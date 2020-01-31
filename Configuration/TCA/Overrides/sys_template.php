<?php
defined('TYPO3_MODE') || die();

call_user_func(
    function()
    {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('pn_uniform_product_names', 'Configuration/TypoScript', 'Uniform product names');
    }
);