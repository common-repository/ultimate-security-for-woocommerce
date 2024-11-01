<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) die;

$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();
$current_screen = get_current_screen();



$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://" . (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['REQUEST_URI'])) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST'])) . sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '';

$tabs = ultimate_security_for_woocommerce_get_tabs();

?>

<form method="post" enctype="multipart/form">
    <?php wp_nonce_field('ultimate_security_for_woocommerce_action', 'ultimate_security_for_woocommerce_field'); ?>
    <div class="ultimate-security-for-woocommerce-settings-wrapper">
        <div class="header-part">
            <div class="container-fluid">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <div class="d-flex align-items-center">
                            <img src="<?php echo esc_url(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'admin/images/logo-44x44.svg') ?>" alt="Logo" class="img-fluid plugin-logo" width="40" height="40">
                            <h2 class="plugin-name">
                                <?php echo esc_html(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_NAME) ?>
                                <small><?php echo esc_html('v') . esc_html(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_VERSION) ?></small>
                            </h2>
                        </div>
                    </div>
                    <div class="col-auto">
                        <ul class="list-inline menu-list">
                            <li class="list-inline-item"><a href="#"><?php echo esc_html__('Knowledgebase', 'ultimate-security-for-woocommerce') ?></a></li>
                            <li class="list-inline-item">
                                <a href="#">
                                    <img src="<?php echo esc_url(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'admin/images/question-round.svg') ?>" alt="" width="32" height="32">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-part">
            <div class="top-nav">
                <div class="container-fluid">
                    <ul class="nav" id="main-tab" role="tablist">
                        <?php
                        $activeParentKey = $activeChildKey = '';
                        foreach ($tabs as $key => $tab) :
                            $active = '';
                            if (isset($_REQUEST['page']) && $tab['url'] == $_REQUEST['page']) {
                                $active = 'active';
                                $activeParentKey = $key;
                            }
                            if (isset($tab['sub']) && sizeof($tab['sub'])) {
                                foreach ($tab['sub'] as $subkey => $subtab) {
                                    if (isset($_REQUEST['page']) && $subtab['url'] == $_REQUEST['page']) {
                                        $active = 'active';
                                        $activeParentKey = $key;
                                        $activeChildKey = $subkey;
                                    }
                                }
                            }
                        ?>
                            <li class="nav-item">
                                <a
                                    href="<?php echo isset($tab['url']) ? esc_html('admin.php?page=' . $tab['url']) : '#' ?>"
                                    class="nav-link <?php echo esc_html($key) ?>-link primary-menu-nav-link <?php echo esc_html($active) ?>"><?php echo esc_html($tab['name']) ?></a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
            <div class="content-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="tab-content">
                                <!-- Sub Menu -->
                                <?php
                                // var_dump($_REQUEST['page']);
                                // var_dump($activeParentKey);
                                if (isset($tabs[$activeParentKey]['sub']) && $tabs[$activeParentKey]['sub']) :
                                ?>
                                    <ul class="nav">
                                        <?php foreach ($tabs[$activeParentKey]['sub'] as $key => $subtab) : ?>
                                            <?php $active = (isset($_REQUEST['page']) && $subtab['url'] == $_REQUEST['page']) ? 'active' : '' ?>
                                            <li class="nav-item">
                                                <a
                                                    href="<?php echo isset($subtab['url']) ? esc_html('admin.php?page=' . $subtab['url']) : '#' ?>"
                                                    class="nav-link <?php echo esc_html($key) ?>-link primary-menu-nav-link <?php echo esc_html($active) ?>"><?php echo esc_html($subtab['name']) ?></a>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                <?php endif ?>
                                <!-- Notice -->
                                <?php if (
                                    (isset($_COOKIE['ultimate-security-for-woocommerce-settings-updated']) && sanitize_text_field(wp_unslash($_COOKIE['ultimate-security-for-woocommerce-settings-updated'])) == $current_screen->id)
                                    || (isset($_POST['ultimate_security_for_woocommerce_field']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['ultimate_security_for_woocommerce_field'])), 'ultimate_security_for_woocommerce_action') && isset($_POST['submit']) &&  sanitize_text_field(wp_unslash($_POST['submit'])) == $current_screen->id)
                                ) : ?>
                                    <div class="ultimate-security-for-woocommerce-form-notice">
                                        <span class="icon"></span>
                                        <div class="text-wrapper"><?php echo esc_html__('All changes have been applied correctly, ensuring your preferences are now in effect.', 'ultimate-security-for-woocommerce') ?></div>
                                        <button type="button" class="ultimate-security-for-woocommerce-form-notice-dismiss"><span class="screen-reader-text"><?php esc_html__('Dismiss this notice.', 'ultimate-security-for-woocommerce') ?></span></button>
                                    </div>
                                <?php endif ?>
                                <div class="tab-content">
                                    <!-- Content -->
                                    <div class="section-title">
                                        <h4><?php echo ($activeChildKey) ? $tabs[$activeParentKey]['sub'][$activeChildKey]['name'] : $tabs[$activeParentKey]['name'] ?></h4>
                                        <div class="description">
                                            <?php echo ($activeChildKey) ? $tabs[$activeParentKey]['sub'][$activeChildKey]['description'] : $tabs[$activeParentKey]['description'] ?>
                                        </div>
                                        <!-- <div class="screen-id"><?php echo $current_screen->id; ?></div> -->
                                    </div>
                                    <div class="ultimate-security-for-woocommerce-setting-unit">
                                        <?php do_action('ultimate_security_for_woocommerce_setting_unit') ?>
                                    </div>
                                    <!-- Action Button -->
                                    <div class="section-footer">
                                        <div class="footer-button-group">
                                            <button type="submit" class="button button-save" name="submit" value="<?php echo esc_html($current_screen->id) ?>"><?php echo esc_html__('Save changes', 'ultimate-security-for-woocommerce') ?></button>
                                            <?php
                                            $ultimate_security_for_woocommerce_default_options = ultimate_security_for_woocommerce_get_default_options();
                                            if (($activeParentKey && isset($ultimate_security_for_woocommerce_default_options[$activeParentKey])) || (isset($activeChildKey) && $ultimate_security_for_woocommerce_default_options[$activeParentKey][$activeChildKey])) :
                                            ?>
                                                <button
                                                    type="button"
                                                    class="button ultimate-security-for-woocommerce-button-reset"
                                                    value="reset"
                                                    data-name="<?php echo $activeParentKey ? $activeParentKey : '' ?><?php echo $activeChildKey ? '.' . $activeChildKey : '' ?>"
                                                    data-url="<?php echo esc_url($actual_link) ?>"><?php echo esc_html__('Reset to Default', 'ultimate-security-for-woocommerce') ?></button>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="ultimate-security-for-woocommerce-settings-information sticky-top">
                                <div class="wrapper">
                                    <h4>
                                        <?php printf(
                                            esc_html__(
                                                'What do you think of %1$s (Free)?',
                                                'ultimate-security-for-woocommerce'
                                            ),
                                            esc_html(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_NAME)
                                        ); ?>
                                    </h4>
                                    <img src="<?php echo esc_url(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'admin/images/option-feature-image.svg') ?>" alt="" class="img-fluid">
                                    <p><?php echo esc_html__('If you like the plugin. please leave a review.', 'ultimate-security-for-woocommerce') ?></p>
                                    <div class="button-group"><a href="#" class="button"><?php echo esc_html__('Leave a Review', 'ultimate-security-for-woocommerce') ?></a></div>
                                    <p class="small"><?php echo esc_html__('Or if you have any questions,, please get in touch.', 'ultimate-security-for-woocommerce') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="footer-part">
            <div class="container-fluid">
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-lg-auto text-center text-lg-start">
                        <!-- %1$s -->
                        <?php printf(
                            esc_html__('Enjoyed %1$s? Please leave us a rating. We really appreciate your support!', 'ultimate-security-for-woocommerce'),
                            '<strong>' . esc_html(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_NAME) . '</strong>',

                        ); ?>
                    </div>
                    <div class="coll-12 col-lg-auto text-center text-lg-end">
                        <strong>Version</strong>
                        <?php echo esc_html(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_VERSION) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>