<?php
/**
 * The main plugin class.
 */

/**
 * Class Captcha.
 * 
 * Main plugin class.
 */
class Captcha {

    /**
     * Initialize the plugin.
     */
    public static function init() {
        add_action('login_form', array( __CLASS__, 'add_captcha_field' ));
        add_filter('authenticate', array( __CLASS__, 'validate_captcha' ), 30, 3);
        add_action('login_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ));

        // Initialize settings page.
        if (is_admin()) {
            Captcha_Settings::init();
        }
    }

    /**
     * Add the CAPTCHA field to the login form.
     */
    public static function add_captcha_field() {
        // Check if CAPTCHA is enabled.
        if (! get_option('captcha_enabled', true)) {
            return;
        }

        // Generate a new CAPTCHA string.
        session_start();
        $captcha = Captcha_Helpers::generate_captcha_string();
        $_SESSION['captcha'] = $captcha;

        // Output the CAPTCHA field.
        require_once plugin_dir_path(__FILE__) . '../templates/template-captcha.php';
    }

    /**
     * Enqueue the CSS file.
     */
    public static function enqueue_assets() {
        // Enqueue the CAPTCHA styles.
        wp_enqueue_style('captcha-styles', plugin_dir_url(__FILE__) . '../assets/css/captcha-styles.css', array(), filemtime(
            plugin_dir_path(__FILE__) . '../assets/css/captcha-styles.css'
        ), 'all');
    }

    /**
     * Validate the CAPTCHA input.
     *
     * @param WP_User|WP_Error $user
     * @param string $username
     * @param string $password
     * @return WP_User|WP_Error
     */
    public static function validate_captcha($user, $username, $password) {
        // Check if CAPTCHA is enabled.
        if (isset($_POST['captcha'])) {
            session_start();

            // Validate the CAPTCHA input.
            $captcha_input = sanitize_text_field(wp_unslash($_POST['captcha']));

            // Check if the CAPTCHA answer is correct.
            $captcha_correct = isset($_SESSION['captcha']) ? $_SESSION['captcha'] : '';

            if (empty($captcha_input) || $captcha_input !== $captcha_correct) {
                return new WP_Error('captcha_error', __('<strong>ERROR</strong>: CAPTCHA answer is incorrect.', 'captcha'));
            }
        }

        return $user;
    }

    /**
     * Plugin activation callback.
     */
    public static function activate() {
        // Set default options.
        add_option('captcha_enabled', true);
        add_option('captcha_length', 6);
        add_option('captcha_characters', array( 'letters', 'numbers' ));
    }

    /**
     * Plugin deactivation callback.
     */
    public static function deactivate() {
        // Clean up options.
        delete_option('captcha_enabled');
        delete_option('captcha_length');
        delete_option('captcha_characters');
    }
}
