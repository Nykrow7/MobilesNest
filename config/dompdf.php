<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | Set some default values. It is possible to add all defines that can be set
    | in dompdf_config.inc.php. You can also override the entire config file.
    |
    */
    'show_warnings' => false,   // Throw an Exception on warnings from dompdf

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    | Array of options for Dompdf.
    |
    */
    'options' => [
        'font_dir' => storage_path('fonts/'), // Directory where font files are stored
        'font_cache' => storage_path('fonts/'), // Directory where font cache is stored
        'temp_dir' => sys_get_temp_dir(), // Directory for temporary files
        'chroot' => realpath(base_path()), // Directory for the main document
        'allowed_protocols' => [
            'file://' => ['rules' => []],
            'http://' => ['rules' => []],
            'https://' => ['rules' => []],
        ],
        'log_output_file' => null, // Log output file
        'enable_font_subsetting' => false, // Enable font subsetting
        'pdf_backend' => 'CPDF', // PDF backend to use
        'default_media_type' => 'screen', // Default media type
        'default_paper_size' => 'a4', // Default paper size
        'default_paper_orientation' => 'portrait', // Default paper orientation
        'default_font' => 'serif', // Default font
        'dpi' => 96, // DPI setting
        'enable_php' => false, // Enable PHP in HTML
        'enable_javascript' => true, // Enable JavaScript
        'enable_remote' => true, // Enable remote file access
        'font_height_ratio' => 1.1, // Font height ratio
        'enable_html5_parser' => true, // Enable HTML5 parser
    ],
];
