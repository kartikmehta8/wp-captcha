<?php
/**
 * Uninstall script for CAPTCHA for WordPress Login plugin.
 */

 // Exit if accessed directly.
if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Clean up all options related to the plugin.
delete_option('captcha_enabled');
delete_option('captcha_length');
delete_option('captcha_characters');
