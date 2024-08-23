<?php
/**
 * Template for the CAPTCHA field.
 */

 // Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}
?>

<p class="captcha-container">
    <label for="captcha" class="captcha-label"><?php esc_html_e('Verify Captcha', 'captcha'); ?></label>
    <strong class="captcha-value"><?php echo esc_html($captcha); ?></strong>
</p>
<input type="text" name="captcha" id="captcha" class="input captcha-input" value="" size="25" />
