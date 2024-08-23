<?php
/**
 * Contains settings for the CAPTCHA plugin.
 */

/**
 * Class Captcha_Settings.
 * 
 * Contains settings for the CAPTCHA plugin.
 */
class Captcha_Settings {

    /**
     * Initialize settings.
     */
    public static function init() {
        add_action('admin_menu', array( __CLASS__, 'add_admin_menu' ));
        add_action('admin_init', array( __CLASS__, 'register_settings' ));
    }

    /**
     * Add settings page to admin menu.
     */
    public static function add_admin_menu() {
        add_options_page(
            __('CAPTCHA Settings', 'captcha'),
            __('CAPTCHA Settings', 'captcha'),
            'manage_options',
            'captcha',
            array( __CLASS__, 'settings_page' )
        );
    }

    /**
     * Register settings.
     */
    public static function register_settings() {

        // Register settings group.
        register_setting('captcha_settings_group', 'captcha_enabled');
        register_setting('captcha_settings_group', 'captcha_length', array(
            'type' => 'integer',
            'sanitize_callback' => array( __CLASS__, 'validate_length' ),
            'default' => 6,
        ));
        register_setting('captcha_settings_group', 'captcha_characters', array(
            'type' => 'array',
            'sanitize_callback' => array( __CLASS__, 'validate_characters' ),
            'default' => array( 'letters', 'numbers' )
        ));
    }

    /**
     * Validate the CAPTCHA length.
     *
     * @param int $input Length input.
     * @return int Validated length.
     */
    public static function validate_length($input) {
        // Convert input to integer.
        $input = intval($input);

        // Validate the length.
        if ($input < 4 || $input > 10) {
            add_settings_error(
                'captcha_length',
                'captcha_length_error',
                __('CAPTCHA length must be between 4 and 10.', 'captcha'),
                'error'
            );

            // Return the default value.
            return get_option('captcha_length', 6);
        }

        return $input;
    }

    /**
     * Validate the selected characters.
     *
     * @param array $input Selected characters.
     * @return array Validated characters.
     */
    public static function validate_characters($input) {

        $output = array();

        // Validate the characters.
        if (! is_array($input) || empty($input)) {
            add_settings_error(
                'captcha_characters',
                'captcha_characters_error',
                __('You must select at least one character type.', 'captcha'),
                'error'
            );

            // Return the default value.
            return get_option('captcha_characters', array( 'letters', 'numbers' ));
        }

        // Sanitize the characters.
        foreach ($input as $value) {
            $output[] = sanitize_text_field($value);
        }

        return $output;
    }

    /**
     * Display the settings page.
     */
    public static function settings_page() {
        // Get the characters to use in the CAPTCHA string.
        $characters = get_option('captcha_characters', array( 'letters', 'numbers' ));

        // Load the settings template.
        require_once plugin_dir_path(__FILE__) . '../templates/template-settings.php';
    }
}
