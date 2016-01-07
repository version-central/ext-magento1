<?php

class K10r_Versioncentral_Model_Observer {
    const URL_VERSIONCENTRAL = 'http://data.versioncentral.vm';

    public function verify() {
        $client = $this->_getClient();
        $client->setMethod(Varien_Http_Client::HEAD);

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

    public function update() {
        if(!Mage::helper("k10r_versioncentral")->getEnabled()) {
            return;
        }

        if(!$this->verify()) {
            Mage::log("Connection to Versioncentral unsuccessful");
            return false;
        }

        $client = $this->_getClient();
        $client->setMethod(Varien_Http_Client::PUT);
        $client->setRawData(Zend_Json::encode($this->_getData()), "application/json");
        Zend_Debug::dump($this->_getData()); die();

        try{
            $response = $client->request();
            if ($response->isSuccessful()) {
            }
        } catch (Exception $e) {
        }
    }

    protected function _getClient() {
        $client = new Varien_Http_Client(self::URL_VERSIONCENTRAL);
        $client->setHeaders("Accept", "application/vnd.version-central-v1+json");
        $client->setHeaders("Authorization", sprintf("Basic %s", base64_encode(Mage::helper("k10r_versioncentral")->getAuthorization())));

        return $client;
    }

    protected function _getData() {
        $data = [
            "application" => [
                "identifier" => "magento",
                "version" => Mage::getVersion(),
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
            $modules[] = [
                "identifier" => $item->getName(),
                "version" => $item->version->__toString(),
                "active" => $item->is("active"),
            ];
        }

        return $modules;
    }
}
