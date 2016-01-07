<?php

class K10r_Versioncentral_Adminhtml_VersioncentralController extends Mage_Adminhtml_Controller_Action {
    public function checkAction() {
        $result = Mage::getModel("k10r_versioncentral/observer")->verify();
        Mage::app()->getResponse()->setBody($result ? 1 : 0);
    }
}
