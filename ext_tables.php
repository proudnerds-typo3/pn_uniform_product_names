<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pnuniformproductnames_domain_model_uniformeproductnamen', 'EXT:pn_uniform_product_names/Resources/Private/Language/locallang_csh_tx_pnuniformproductnames_domain_model_uniformeproductnamen.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pnuniformproductnames_domain_model_uniformeproductnamen');
    }
);
