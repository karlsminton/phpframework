<?php
/**
 * This configuration will be read and overlaid on top of the
 * default configuration. Command line arguments will be applied
 * after this file is read.
 */
return [
    "target_php_version" => '7.1',
    'directory_list' => [
        'modules',
    ],
    "exclude_analysis_directory_list" => [
        'vendor/'
    ],
    'plugins' => [],
];