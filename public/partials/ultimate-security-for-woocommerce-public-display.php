<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.programmelab.com/
 * @since      1.0.0
 *
 * @package    Ultimate_Security_For_Woocommerce
 * @subpackage Ultimate_Security_For_Woocommerce/public/partials
 */
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body class="restricted-layout">
    <div class="wrapper">
        <?php if (isset($ultimate_security_for_woocommerce_options['integration']['customize']['header-background-image']['id']) && $ultimate_security_for_woocommerce_options['integration']['customize']['header-background-image']['id']) :
            echo wp_get_attachment_image($ultimate_security_for_woocommerce_options['integration']['customize']['header-background-image']['id'], 'full');
        ?>
        <?php else : ?>
            <img class="img-fluid" src="<?php echo esc_url(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'public/images/not-permitted.svg') ?>">
        <?php endif ?>
        <h4><?php echo esc_html__('Sorry, your country is not permitted to visit this website.', 'ultimate-security-for-woocommerce') ?></h4>
        <?php printf(
            esc_html__(
                '%1$sContact the site owner for more information.%2$s',
                'ultimate-security-for-woocommerce'
            ),
            '<p>',
            '</p>'
        ); ?>
    </div>
</body>
<?php wp_footer(); ?>

</html>