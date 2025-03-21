<?php

defined('TYPO3') || die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'pages',
    [
        'uniform_product_names_export' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.uniform_product_names_export',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'Standaard', 'value' => ''],
                    ['label' => 'Ja', 'value' => '1'],
                    ['label' => 'Nee', 'value' => '0'],
                ],
            ],
        ],
        'uniform_product_names_audience' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.uniform_product_names_audience',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'Particulier', 'value' => 'particulier'],
                    ['label' => 'Ondernemer', 'value' => 'ondernemer'],
                    ['label' => 'Particulier en ondernemer', 'value' => 'beide'],
                ],
            ],
        ],
        'uniform_product_names_online_aanvragen' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.uniform_product_names_online_aanvragen',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'Nee', 'value' => 'nee'],
                    ['label' => 'Ja', 'value' => 'ja'],
                    ['label' => 'DigiD', 'value' => 'digid'],
                ],
            ],
        ],
        'uniform_product_names_aanvraag_url' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.uniform_product_names_aanvraag_url',
            'config' => [
                'type' => 'input',
            ],
        ],
        'uniform_product_names_abstract' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.uniform_product_names_abstract',
            'config' => [
                'type' => 'text',
                'cols' => 50,
                'rows' => 6,
            ],
        ],
        'uniform_product_names_uniforme_productnaam' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.uniform_product_names_uniforme_productnaam',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_pnuniformproductnames_domain_model_uniformeproductnamen',
                'foreign_table_where' => 'ORDER BY tx_pnuniformproductnames_domain_model_uniformeproductnamen.title',
                'default' => 0,
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'listModule' => [
                        'disabled' => true,
                    ],
                ],
            ],
        ],
        'uniform_product_names_gerelateerd_product' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.uniform_product_names_gerelateerd_product',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_pnuniformproductnames_domain_model_uniformeproductnamen',
                'foreign_table_where' => 'ORDER BY tx_pnuniformproductnames_domain_model_uniformeproductnamen.title',
                'default' => 0,
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'listModule' => [
                        'disabled' => true,
                    ],
                ],
            ],
        ],
        'uniform_product_names_language' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.uniform_product_names_language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.nl', 'value' => 'nl'],
                    ['label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.en', 'value' => 'en'],
                    ['label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.de', 'value' => 'de'],
                    ['label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.fr', 'value' => 'fr'],
                    ['label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.es', 'value' => 'es'],
                    ['label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.tr', 'value' => 'tr'],
                    ['label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.it', 'value' => 'it'],
                    ['label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.pl', 'value' => 'pl'],
                    ['label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.ro', 'value' => 'ro'],
                ],
            ],
        ],
        'uniform_product_names_product_html' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.uniform_product_names_product_html',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
            ],
        ],
    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    ',--div--;LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_uniformeproductnamen, uniform_product_names_export, uniform_product_names_abstract, uniform_product_names_audience, uniform_product_names_online_aanvragen, uniform_product_names_aanvraag_url, uniform_product_names_uniforme_productnaam, uniform_product_names_gerelateerd_product, uniform_product_names_product_html, uniform_product_names_language'
);
