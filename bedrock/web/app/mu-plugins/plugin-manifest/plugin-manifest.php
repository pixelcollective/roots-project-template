<?php
/**
 * Plugin name: Plugin Manifest
 * Plugin description: Load plugins for particular environments
 */

if (file_exists($file = __DIR__ . '/manifest.yml')) {
    \PrimeTime\WordPress\PluginManifest\Activation::set($manifestFile, getenv('WP_ENV'));
}
