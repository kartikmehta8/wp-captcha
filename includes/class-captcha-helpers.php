<?php
/**
 * Contains helper functions for the CAPTCHA plugin.
 */

/**
 * Class Captcha_Helpers.
 * 
 * Contains helper functions for the CAPTCHA plugin.
 */
class Captcha_Helpers {

    /**
     * Generate a random CAPTCHA string.
     *
     * @return string
     */
    public static function generate_captcha_string() {
        // Get the length of the CAPTCHA string.
        $length = get_option('captcha_length', 6);

        // Get the characters to use in the CAPTCHA string.
        $characters = self::get_characters();

        // Generate the CAPTCHA string.
        $captcha = '';
        for ($i = 0; $i < $length; $i++) {
            $captcha .= $characters[ wp_rand(0, strlen($characters) - 1) ];
        }

        return $captcha;
    }

    /**
     * Get the characters to use in the CAPTCHA string.
     *
     * @return string
     */
    public static function get_characters() {

        // Get the characters to use in the CAPTCHA string.
        $characters = '';
        $options = get_option('captcha_characters', array( 'letters', 'numbers' ));

        // Add the selected characters to the list.
        if (in_array('letters', $options)) {
            $characters .= 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        if (in_array('numbers', $options)) {
            $characters .= '0123456789';
        }
        if (in_array('special', $options)) {
            $characters .= '!@#$%^&*()';
        }

        return $characters;
    }
}
