<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Uniform product names',
    'description' => 'Import and select in page properties the uniform names of products and services of The Dutch government.',
    'category' => 'be',
    'author' => 'Jacco van der Post',
    'author_email' => 'jacco.vanderpost@proudnerds.com',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => 'typo3temp/pn_uniform_product_names',
    'clearCacheOnLoad' => 0,
    'version' => '1.1.2',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
