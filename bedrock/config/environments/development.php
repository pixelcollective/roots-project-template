<?php

\TinyPixel\Config\Bootloader::getInstance()::defineSet([
    'SAVEQUERIES'        => true,
    'WP_DEBUG'           => true,
    'SCRIPT_DEBUG'       => true,
    'WP_DEBUG_DISPLAY'   => true,
    'DISALLOW_FILE_MODS' => false,
]);

ini_set('display_errors', 1);
