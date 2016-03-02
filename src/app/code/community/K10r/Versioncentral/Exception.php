<?php

class K10r_Versioncentral_Exception extends Mage_Core_Exception
{
    public function __construct($errors) {
        parent::__construct(print_r($errors, true));
    }
}
