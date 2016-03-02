<?php

class K10r_Versioncentral_Helper_Error extends Mage_Core_Helper_Abstract
{
    public function getErrorMessage($errorCode)
    {
        switch($errorCode) {
            case 'application_type_changed':
                return $this->__('This token is already used by another application. Please use the correct token for your application or create a new application in VersionCentral.');
            default:
                return $this->__('An error occured during a VersionCentral update. Please contact us for further information and support.');
        }
    }
}
