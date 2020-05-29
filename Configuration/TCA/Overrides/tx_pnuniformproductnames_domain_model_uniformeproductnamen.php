<?php
defined('TYPO3_MODE') or die();

$boot = static function () {
    // Remove TCA settings for version 10 to avoid entries in TCA migration check
    if (\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class)->getMajorVersion() === 10) {
        unset($GLOBALS['TCA']['tx_pnuniformproductnames_domain_model_uniformeproductnamen']['interface']['showRecordFieldList']);
    }
};

$boot();
unset($boot);
