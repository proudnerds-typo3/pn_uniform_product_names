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
    'version' => '11.5.1',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.8-11.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
