<?php
defined('TYPO3_MODE') || die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'pages', [
        'uniform_product_names_audience' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.uniform_product_names_audience',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Particulier', 'particulier'],
                    ['Ondernemer', 'ondernemer'],
                    ['Particulier en ondernemer', 'beide']
                ]
            ]
        ],
        'uniform_product_names_online_aanvragen' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.uniform_product_names_online_aanvragen',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Nee', 'nee'],
                    ['Ja', 'ja'],
                    ['DigiD', 'digid']
                ]
            ],
        ],
        'uniform_product_names_aanvraag_url' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.uniform_product_names_aanvraag_url',
            'config' => [
                'type' => 'input'
            ]
        ],
        'uniform_product_names_abstract' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.uniform_product_names_abstract',
            'config' => [
                'type' => 'text',
                'cols' => 50,
                'rows' => 6
            ]
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
                    ['LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.nl', 'nl'],
                    ['LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.en', 'en'],
                    ['LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.de', 'de'],
                    ['LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.fr', 'fr'],
                    ['LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.es', 'es'],
                    ['LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.tr', 'tr'],
                    ['LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.it', 'it'],
                    ['LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.pl', 'pl'],
                    ['LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.taal.ro', 'ro'],
                ]
            ]
        ],
        'uniform_product_names_product_html' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_pages.uniform_product_names_product_html',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
            ]
        ],
    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    ',--div--;LLL:EXT:pn_uniform_product_names/Resources/Private/Language/locallang_db.xlf:tx_pnuniformproductnames_domain_model_uniformeproductnamen, uniform_product_names_abstract, uniform_product_names_audience, uniform_product_names_online_aanvragen, uniform_product_names_aanvraag_url, uniform_product_names_uniforme_productnaam, uniform_product_names_gerelateerd_product, uniform_product_names_product_html, uniform_product_names_language'
);