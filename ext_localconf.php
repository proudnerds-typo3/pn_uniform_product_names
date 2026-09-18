<?php

use Proudnerds\PnUniformProductNames\Controller\UniformeproductnamenController;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin(
    'PnUniformProductNames',
    'PnForPages',
    [
        UniformeproductnamenController::class => 'show',
    ],
    [
        UniformeproductnamenController::class => 'show',
    ]
);

$productNamesImportLogFilePath = Environment::getVarPath() . '/log/productNames-import.log';

$GLOBALS['TYPO3_CONF_VARS']['LOG']['Proudnerds']['PnUniformProductNames']['Command']['ImportCommand'] = [
    'writerConfiguration' => [
        LogLevel::INFO => [
            'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => [
                'logFile' => $productNamesImportLogFilePath,
            ],
        ],
        LogLevel::NOTICE => [
            'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => [
                'logFile' => $productNamesImportLogFilePath,
            ],
        ],
        LogLevel::WARNING => [
            'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => [
                'logFile' => $productNamesImportLogFilePath,
            ],
        ],
        LogLevel::ERROR => [
            'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => [
                'logFile' => $productNamesImportLogFilePath,
            ],
        ],
        LogLevel::CRITICAL => [
            'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => [
                'logFile' => $productNamesImportLogFilePath,
            ],
        ],
        LogLevel::ALERT => [
            'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => [
                'logFile' => $productNamesImportLogFilePath,
            ],
        ],
    ],
];
