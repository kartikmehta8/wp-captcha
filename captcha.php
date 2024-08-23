<?php
/**
 * Plugin Name: CAPTCHA for WordPress Login
 * Plugin URI: https://mrmehta.in
 * Description: Adds a CAPTCHA to the WordPress login page with customizable settings.
 * Version: 1.0
 * Author: Kartik Mehta
 * Author URI: https://mrmehta.in
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: captcha
 * Requires at least: 6.0
 * Requires PHP: 8.1.29
 */

 // Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

// Autoload the required classes.
spl_autoload_register(function ($class) {
    $prefix   = '';
    $base_dir = __DIR__ . '/includes/';
    $len      = strlen($prefix);
    
    // Check if the class uses the correct prefix.
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    // Get the relative class name.
    $relative_class = substr($class, $len);
    $file           = $base_dir . 'class-' . str_replace('_', '-', strtolower($relative_class)) . '.php';
    
    // If the file exists, require it.
    if (file_exists($file)) {
        require $file;
    }
});

// Activation hook.
register_activation_hook(__FILE__, 'Captcha::activate');

// Deactivation hook.
register_deactivation_hook(__FILE__, 'Captcha::deactivate');

// Initialize the plugin.
add_action('plugins_loaded', array( 'Captcha', 'init' ));
