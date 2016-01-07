<?php
 
class K10r_Versioncentral_Helper_Data extends Mage_Core_Helper_Abstract {
    const XML_ENABLED = "k10r_versioncentral/general/enable";
    const XML_API_IDENTIFIER = "k10r_versioncentral/general/api_identifier";
    const XML_API_TOKEN = "k10r_versioncentral/general/api_token";

    public function getEnabled() {
        return Mage::getStoreConfig(self::XML_ENABLED);
    }

    public function getApiIdentifier() {
        return Mage::getStoreConfig(self::XML_API_IDENTIFIER);
    }

    public function getApiToken() {
        return Mage::getStoreConfig(self::XML_API_TOKEN);
    }

    public function getAuthorization() {
        return sprintf(
            '%s:%s',
            $this->getApiIdentifier(),
            $this->getApiToken()
        );
    }
}
