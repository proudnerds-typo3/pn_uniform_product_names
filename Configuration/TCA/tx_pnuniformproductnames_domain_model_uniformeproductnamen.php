<?php

$languagePath = 'LLL:EXT:pn_uniform_product_names/Resources/Private/Language/';

return [
    'ctrl' => [
        'title' => $languagePath . 'locallang_db.xlf:tx_pnuniformproductnames_domain_model_uniformeproductnamen',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'sortby' => 'sorting',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'typeicon_classes' => [
            'default' => 'tx_pnuniformproductnames_domain_model_uniformeproductnamen',
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, uri, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    [
                        'label' => 'None',
                        'value' => 0,
                    ],
                    [
                        'label' => 'Active',
                        'value' => 1,
                    ],
                ],
                'foreign_table' => 'tx_pnuniformproductnames_domain_model_uniformeproductnamen',
                'foreign_table_where' => 'AND {#tx_pnuniformproductnames_domain_model_uniformeproductnamen}.{#pid}=###CURRENT_PID### AND {#tx_pnuniformproductnames_domain_model_uniformeproductnamen}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'searchable' => false,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ],
        ],

        'title' => [
            'exclude' => true,
            'label' => $languagePath . 'locallang_db.xlf:tx_pnuniformproductnames_domain_model_uniformeproductnamen.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'uri' => [
            'exclude' => true,
            'label' => $languagePath . 'locallang_db.xlf:tx_pnuniformproductnames_domain_model_uniformeproductnamen.uri',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
    ],
];
