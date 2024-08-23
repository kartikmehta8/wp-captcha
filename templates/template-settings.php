<?php
/**
 * Template for the CAPTCHA settings page.
 */

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php esc_html_e('CAPTCHA Settings', 'captcha'); ?></h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('captcha_settings_group');
        do_settings_sections('captcha_settings_group');
        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Enable CAPTCHA', 'captcha'); ?></th>
                <td>
                    <input type="checkbox" name="captcha_enabled" value="1" <?php checked(1, get_option('captcha_enabled', true)); ?> />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e('CAPTCHA Length', 'captcha'); ?></th>
                <td>
                    <input type="number" name="captcha_length" value="<?php echo esc_attr(get_option('captcha_length', 6)); ?>" min="4" max="10" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Characters to Include', 'captcha'); ?></th>
                <td>
                    <input type="checkbox" name="captcha_characters[]" value="letters" <?php checked(in_array('letters', $characters)); ?> /> <?php esc_html_e('Letters', 'captcha'); ?><br />
                    <input type="checkbox" name="captcha_characters[]" value="numbers" <?php checked(in_array('numbers', $characters)); ?> /> <?php esc_html_e('Numbers', 'captcha'); ?><br />
                    <input type="checkbox" name="captcha_characters[]" value="special" <?php checked(in_array('special', $characters)); ?> /> <?php esc_html_e('Special Characters', 'captcha'); ?><br />
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
</div>
