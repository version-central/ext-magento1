<?php

class K10r_Versioncentral_Model_Observer {
    const URL_VERSIONCENTRAL = 'https://data.versioncentral.com';

    public function verify() {
        $client = $this->_getClient();
        $client->setMethod(Zend_Http_Client::HEAD);

        $success = false;
        try{
            $response = $client->request();
            if ($response->isSuccessful()) {
                $success = true;
            }
        } catch (Exception $e) {
        }

        return $success;
    }

    public function scheduleUpdate() {
        if(!Mage::helper("k10r_versioncentral")->getActive()) {
            return;
        }

        $created = new DateTime();
        $scheduled = new DateTime();
        $hours = rand(0, 23);
        $scheduled->add(new DateInterval("PT" . $hours . "H"));

        try {
            $schedule = Mage::getModel("cron/schedule");
            $schedule->setJobCode("k10r_versioncentral_update")
                ->setCreatedAt($created->format("Y-m-d H:i:s"))
                ->setScheduledAt($scheduled->format("Y-m-d H:i:s"))
                ->setStatus(Mage_Cron_Model_Schedule::STATUS_PENDING)
                ->save();
        } catch (Exception $e) {
            throw new K10r_Versioncentral_Exception("VersionCentral: Unable to schedule update cronjob.");
        }
    }

    public function update() {
        if(!Mage::helper("k10r_versioncentral")->getActive()) {
            return;
        }

        if(!$this->verify()) {
            Mage::log("Connection to VersionCentral unsuccessful");
            Mage::getSingleton("adminhtml/session")->addError(Mage::helper("k10r_versioncentral")->__("Connection unsuccessful"));
            return false;
        }

        $client = $this->_getClient();
        $client->setMethod(Zend_Http_Client::PUT);
        $client->setRawData(Zend_Json::encode($this->_getData()), "application/json");

        try{
            $response = $client->request();
            if ($response->isSuccessful()) {
                Mage::log("VersionCentral update successful");
            } else {
                $body = Zend_Json::decode($response->getBody());
                foreach($body["errors"] as $error) {
                    Mage::getSingleton("adminhtml/session")->addError(Mage::helper("k10r_versioncentral/error")->getErrorMessage($error["code"]));
                }
                throw new K10r_Versioncentral_Exception($body["errors"]);
            }
        } catch (Exception $e) {
            Mage::log("VersionCentral update request failed");
            Mage::logException($e);
        }
    }

    public function afterSaveConfig(Varien_Event_Observer $observer) {
        if($observer->getEvent()->getSection() === "k10r_versioncentral") {
            $this->update();
        }
    }

    protected function _getClient() {
        $client = new Zend_Http_Client(self::URL_VERSIONCENTRAL);
        $client->setHeaders("Accept", "application/vnd.version-central-v1+json");
        $client->setHeaders("Authorization", sprintf("Basic %s", base64_encode(Mage::helper("k10r_versioncentral")->getAuthorization())));

        return $client;
    }

    protected function _getData() {
        $data = [
            "application" => [
                "identifier" => "magento1",
                "version" => Mage::getVersion(),
            ],
            "meta" => [
                "name" => Mage::helper("k10r_versioncentral")->getName(),
                "url" => Mage::getBaseUrl(),
            ],
            "packages" => $this->_getModules(),
        ];

        return $data;
    }

    protected function _getModules() {
        $modules = [];

        $config = Mage::getConfig();
        /** @var Mage_Core_Model_Config_Element $item */
        foreach($config->getNode("modules")->children() as $item){
            if($item->codePool->__toString() !== "core" && $item->is("active")) {
                $modules[] = [
                    "identifier" => $item->getName(),
                    "version" => $item->version->__toString(),
                    "active" => $item->is("active"),
                ];
            }
        }

        return $modules;
    }
}
