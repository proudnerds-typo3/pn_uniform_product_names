<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Proudnerds.PnUniformProductNames',
    'PnForPages',
    [
        'Uniformeproductnamen' => 'show',
    ],
    [
        'Uniformeproductnamen' => 'show',
    ]
);

call_user_func(function () {

    $projectRootPath = TYPO3\CMS\Core\Utility\GeneralUtility::fixWindowsFilePath(getenv('TYPO3_PATH_APP'));
    $productNamesImportLogFilePath = $projectRootPath . '/var/log/productNames-import.log';

    $GLOBALS['TYPO3_CONF_VARS']['LOG']['Proudnerds']['PnUniformProductNames']['Command']['ImportCommand'] = [
        'writerConfiguration' => [
            \TYPO3\CMS\Core\Log\LogLevel::INFO => [
                'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => [
                    'logFile' => $productNamesImportLogFilePath
                ]
            ],
            \TYPO3\CMS\Core\Log\LogLevel::NOTICE => [
                'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => [
                    'logFile' => $productNamesImportLogFilePath
                ]
            ],
            \TYPO3\CMS\Core\Log\LogLevel::WARNING => [
                'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => [
                    'logFile' => $productNamesImportLogFilePath
                ]
            ],
            \TYPO3\CMS\Core\Log\LogLevel::ERROR => [
                'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => [
                    'logFile' => $productNamesImportLogFilePath
                ]
            ],
            \TYPO3\CMS\Core\Log\LogLevel::CRITICAL => [
                'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => [
                    'logFile' => $productNamesImportLogFilePath
                ]
            ],
            \TYPO3\CMS\Core\Log\LogLevel::ALERT => [
                'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => [
                    'logFile' => $productNamesImportLogFilePath
                ]
            ],
        ]
    ];
});

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconPath = 'EXT:pn_uniform_product_names/Resources/Public/Icons/';

$svgIcons = [
    'tx_pnuniformproductnames_domain_model_uniformeproductnamen' => $iconPath . 'tx_pnuniformproductnames_domain_model_uniformeproductnamen.svg'
];

foreach ($svgIcons as $identifier => $path) {
    $iconRegistry->registerIcon(
        $identifier,
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => $path]
    );
}
