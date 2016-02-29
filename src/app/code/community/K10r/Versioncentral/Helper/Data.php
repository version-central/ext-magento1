<?php

class K10r_Versioncentral_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_ACTIVE = "k10r_versioncentral/general/active";
    const XML_NAME = "k10r_versioncentral/general/name";
    const XML_API_IDENTIFIER = "k10r_versioncentral/general/api_identifier";
    const XML_API_TOKEN = "k10r_versioncentral/general/api_token";
    const XML_STORE_NAME = "general/store_information/name";

    public function getActive()
    {
        return Mage::getStoreConfig(self::XML_ACTIVE);
    }

    public function getName()
    {
        return Mage::getStoreConfig(self::XML_NAME) ? Mage::getStoreConfig(self::XML_NAME) : Mage::getStoreConfig(self::XML_STORE_NAME);
    }

    public function getApiIdentifier()
    {
        return Mage::getStoreConfig(self::XML_API_IDENTIFIER);
    }

    public function getApiToken()
    {
        return Mage::getStoreConfig(self::XML_API_TOKEN);
    }

    public function getAuthorization()
    {
        return sprintf(
            '%s:%s',
            $this->getApiIdentifier(),
            $this->getApiToken()
        );
    }
}
