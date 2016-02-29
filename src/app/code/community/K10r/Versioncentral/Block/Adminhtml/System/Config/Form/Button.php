<?php

class K10r_Versioncentral_Block_Adminhtml_System_Config_Form_Button extends Mage_Adminhtml_Block_System_Config_Form_Field {
    protected function _construct() {
        parent::_construct();
        $this->setTemplate("k10r_versioncentral/check.phtml");
    }

    /**
     * Return element html
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
        return $this->_toHtml();
    }

    /**
     * Return ajax url for button
     *
     * @return string
     */
    public function getAjaxCheckUrl() {
        return Mage::helper("adminhtml")->getUrl("adminhtml/versioncentral/check");
    }

    /**
     * Generate button html
     *
     * @return string
     */
    public function getButtonHtml() {
        $button = $this->getLayout()->createBlock("adminhtml/widget_button")
            ->setData(array(
                "id"        => "k10r_versioncentral_button",
                "label"     => $this->helper("k10r_versioncentral")->__("Check"),
                "onclick"   => "javascript:k10r_versioncentral_test(); return false;"
            ));

        return $button->toHtml();
    }
}
