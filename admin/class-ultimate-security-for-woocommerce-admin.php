<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.programmelab.com/
 * @since      1.0.0
 *
 * @package    Ultimate_Security_For_Woocommerce
 * @subpackage Ultimate_Security_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ultimate_Security_For_Woocommerce
 * @subpackage Ultimate_Security_For_Woocommerce/admin
 * @author     Programmelab <rizvi@programmelab.com>
 */
class Ultimate_Security_For_Woocommerce_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ultimate_Security_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ultimate_Security_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'assets/css/style.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . 'roboto', 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap', array(), $this->version, 'all');
		if (ultimate_security_for_woocommerce_is_plugin_page()) {
			wp_enqueue_style($this->plugin_name . '-hint', ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'assets/plugins/cool-hint-css/src/hint.css', array(), $this->version, 'all');
			wp_enqueue_style($this->plugin_name . '-tagify', ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'assets/plugins/tagify/tagify.css', array(), $this->version, 'all');

			wp_enqueue_style($this->plugin_name . '-bootstrap', ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'assets/css/bootstrap.min.css', array(), $this->version, 'all');
			wp_enqueue_style($this->plugin_name . '-admin', ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'admin/css/admin-style.css', array(), $this->version, 'all');
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ultimate_Security_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ultimate_Security_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'assets/js/script.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name . '-ajax', ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'assets/js/ajax.js', array('jquery'), $this->version, false);
		if (ultimate_security_for_woocommerce_is_plugin_page()) {
			wp_enqueue_media();
			wp_enqueue_script($this->plugin_name . '-tagify', ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'assets/plugins/tagify/tagify.js', array('jquery'), $this->version, false);
			wp_enqueue_script($this->plugin_name . '-admin-script', ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'admin/js/admin-script.js', array('jquery'), $this->version, false);
		}


		$ajax_params = array(
			'admin_url' => admin_url(),
			'ajax_url' => admin_url('admin-ajax.php'),
			'security' => esc_attr(wp_create_nonce('ultimate_security_for_woocommerce_security_nonce')),
			'install_plugin_wpnonce' => esc_attr(wp_create_nonce('updates')),
		);
		wp_localize_script($this->plugin_name . '-ajax', 'ultimate_security_for_woocommerce_ajax_obj', $ajax_params);
	}

	/**
	 * Adding Woocommerce dependency to our plugin.
	 *
	 * @since    1.0.0
	 */
	public function ultimate_security_for_woocommerce_woo_check()
	{

		if (current_user_can('activate_plugins')) {
			if (!is_plugin_active('woocommerce/woocommerce.php') && !file_exists(WP_PLUGIN_DIR . '/woocommerce/woocommerce.php')) {
?>
				<div id="message" class="error">
					<p>
						<?php printf(
							esc_html__(
								'%1$s requires %2$s WooCommerce %3$s to be activated.',
								'ultimate-security-for-woocommerce'
							),
							esc_html(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_NAME),
							'<strong><a href="https://wordpress.org/plugins/woocommerce/" target="_blank">',
							'</a></strong>'
						); ?>
					</p>
					<p><a id="ultimate_security_for_woocommerce_wooinstall" class="install-now button" data-plugin-slug="woocommerce"><?php esc_html_e('Install Now', 'ultimate-security-for-woocommerce'); ?></a></p>
				</div>
			<?php
			} elseif (!is_plugin_active('woocommerce/woocommerce.php') && file_exists(WP_PLUGIN_DIR . '/woocommerce/woocommerce.php')) {
			?>

				<div id="message" class="error">
					<p>
						<?php printf(
							esc_html__(
								'%1$s requires %2$s WooCommerce %3$s to be activated.',
								'ultimate-security-for-woocommerce'
							),
							esc_html(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_NAME),
							'<strong><a href="https://wordpress.org/plugins/woocommerce/" target="_blank">',
							'</a></strong>'
						); ?>
					</p>
					<p><a href="<?php echo esc_url(get_admin_url()); ?>plugins.php?_wpnonce=<?php echo esc_attr(wp_create_nonce('activate-plugin_woocommerce/woocommerce.php')); ?>&action=activate&plugin=woocommerce/woocommerce.php" class="button activate-now button-primary"><?php esc_html_e('Activate', 'ultimate-security-for-woocommerce'); ?></a></p>
				</div>
			<?php
			} elseif (version_compare(get_option('woocommerce_db_version'), '2.5', '<')) {
			?>

				<div id="message" class="error">
					<p>
						<?php printf(
							esc_html__(
								'%1$s %2$s is inactive.%3$s This plugin requires WooCommerce 2.5 or newer. Please %4$supdate WooCommerce to version 2.5 or newer%5$s',
								'ultimate-security-for-woocommerce'
							),
							'<strong>',
							esc_html(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_NAME),
							'</strong>',
							'<a href="' . esc_url(admin_url('plugins.php')) . '">',
							'&nbsp;&raquo;</a>'
						); ?>
					</p>
				</div>

			<?php
			}
		}
	}

	/**
	 * Adding menu to admin menu.
	 *
	 * @since    1.0.0
	 */
	public function ultimate_security_for_woocommerce_admin_menu()
	{
		add_menu_page(
			esc_html(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_NAME),
			esc_html__('Ultimate Security', 'ultimate-security-for-woocommerce'),
			'manage_options',
			$this->plugin_name,
			array($this, 'ultimate_security_for_woocommerce_dashboard_page_html'),
			plugin_dir_url(__DIR__) . 'admin/images/menu-icon.svg',
			57
		);
		add_submenu_page(
			$this->plugin_name,
			esc_html__('Sub', 'ultimate-security-for-woocommerce'),
			esc_html__('Sub', 'ultimate-security-for-woocommerce'),
			'manage_options',
			$this->plugin_name . '-sub',
			array($this, 'ultimate_security_for_woocommerce_dashboard_page_html')
		);
		$tabs = ultimate_security_for_woocommerce_get_tabs();
		if (sizeof($tabs)) {
			foreach ($tabs as $key => $tab) {
				if (isset($tab['sub']) && $tab['sub']) {
					foreach ($tab['sub'] as $k => $subtab) {
						add_submenu_page(
							$this->plugin_name . '-sub',
							// 'admin.php?page=wc-settings',
							esc_html($subtab['name']),
							esc_html($subtab['name']),
							'manage_options',
							$subtab['url'],
							array($this, 'ultimate_security_for_woocommerce_dashboard_page_html')
						);
					}
				} else {
					add_submenu_page(
						$this->plugin_name . '-sub',
						// 'admin.php?page=wc-settings',
						esc_html($tab['name']),
						esc_html($tab['name']),
						'manage_options',
						$tab['url'],
						array($this, 'ultimate_security_for_woocommerce_dashboard_page_html')
					);
				}
			}
		}
		remove_submenu_page($this->plugin_name, $this->plugin_name . '-sub');
	}
	public function ultimate_security_for_woocommerce_parent_file_callback($parent_file)
	{
		global $plugin_page, $submenu_file;
		if (
			'ultimate-security-for-woocommerce-integration-customize' == $plugin_page
		) {

			$plugin_page = $this->plugin_name;
			$submenu_file = $this->plugin_name;
		}
		return $parent_file;
	}
	/**
	 * Loading plugin Welcome page.
	 *
	 * @since    1.0.0
	 */
	public function ultimate_security_for_woocommerce_dashboard_page_html()
	{
		if (!current_user_can('manage_options')) {
			return;
		}
		include_once('partials/' . $this->plugin_name . '-admin-display.php');
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function ultimate_security_for_woocommerce_add_action_links($links)
	{

		/**
		 * Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		 * The "plugins.php" must match with the previously added add_submenu_page first option.
		 * For custom post type you have to change 'plugins.php?page=' to 'edit.php?post_type=your_custom_post_type&page='
		 * 
		 */
		$settings_link = array(
			'<a href="' . admin_url('admin.php?page=' . $this->plugin_name) . '">' . esc_html__('Settings', 'ultimate-security-for-woocommerce') . '</a>',
		);
		return array_merge($settings_link, $links);
	}

	/**
	 * Add body classes to the settings pages.
	 *
	 * @since    1.0.0
	 */
	public function ultimate_security_for_woocommerce_admin_body_class($classes)
	{
		if (ultimate_security_for_woocommerce_is_plugin_page()) {
			$classes .= ' ' . $this->plugin_name . '-settings-template ';
		}
		return $classes;
	}

	/**
	 * Redirect to the welcome pages.
	 *
	 * @since    1.0.0
	 */
	public function ultimate_security_for_woocommerce_do_activation_redirect()
	{
		if (get_option('ultimate_security_for_woocommerce_do_activation_redirect')) {
			delete_option('ultimate_security_for_woocommerce_do_activation_redirect');
			wp_safe_redirect(admin_url('admin.php?page=' . $this->plugin_name));
		}
	}

	/**
	 * Removing all notieces from settings page.
	 *
	 * @since    1.0.0
	 */
	public function ultimate_security_for_woocommerce_hide_admin_notices()
	{
		$current_screen = get_current_screen();
		if (ultimate_security_for_woocommerce_is_plugin_page()) {
			remove_all_actions('user_admin_notices');
			remove_all_actions('admin_notices');
		}
	}
	/**
	 * Save settings page data.
	 *
	 * @since    1.0.0
	 */
	public function ultimate_security_for_woocommerce_save_plugin_options()
	{
		// Verify the nonce before proceeding.
		if (isset($_POST['ultimate_security_for_woocommerce_field']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['ultimate_security_for_woocommerce_field'])), 'ultimate_security_for_woocommerce_action')) {
			wp_die(esc_html__('Nonce verification failed. Please try again.', 'ultimate-security-for-woocommerce'));
			return;
		}
		$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();

		if (isset($_POST['integration'])) {
			if (isset($_POST["integration"]["security-for-woocommerce"])) {
				if (isset($_POST["integration"]["security-for-woocommerce"]["firewall"])) {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["firewall"] = sanitize_text_field(wp_unslash($_POST["integration"]["security-for-woocommerce"]["firewall"]));
				} else {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["firewall"] = 0;
				}

				if (isset($_POST["integration"]["security-for-woocommerce"]["your-website-ip-address"])) {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["your-website-ip-address"] = sanitize_text_field(wp_unslash($_POST["integration"]["security-for-woocommerce"]["your-website-ip-address"]));
				} else {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["your-website-ip-address"] = '';
				}

				if (isset($_POST["integration"]["security-for-woocommerce"]["your-current-location"])) {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["your-current-location"] = sanitize_text_field(wp_unslash($_POST["integration"]["security-for-woocommerce"]["your-current-location"]));
				} else {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["your-current-location"] = '';
				}

				if (isset($_POST["integration"]["security-for-woocommerce"]["blocked-countries-list"])) {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["blocked-countries-list"] = sanitize_text_field(wp_unslash($_POST["integration"]["security-for-woocommerce"]["blocked-countries-list"]));
				} else {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["blocked-countries-list"] = '';
				}
				if (isset($_POST["integration"]["security-for-woocommerce"]["blacklisted-ips"])) {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["blacklisted-ips"] = sanitize_text_field(wp_unslash($_POST["integration"]["security-for-woocommerce"]["blacklisted-ips"]));
				} else {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["blacklisted-ips"] = '';
				}
				if (isset($_POST["integration"]["security-for-woocommerce"]["allow-only-traffic-from-this-country"])) {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["allow-only-traffic-from-this-country"] = sanitize_text_field(wp_unslash($_POST["integration"]["security-for-woocommerce"]["allow-only-traffic-from-this-country"]));
				} else {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["allow-only-traffic-from-this-country"] = '';
				}
				if (isset($_POST["integration"]["security-for-woocommerce"]["whitelisted-ips"])) {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["whitelisted-ips"] = sanitize_text_field(wp_unslash($_POST["integration"]["security-for-woocommerce"]["whitelisted-ips"]));
				} else {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["whitelisted-ips"] = '';
				}
				if (isset($_POST["integration"]["security-for-woocommerce"]["debug-log"])) {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["debug-log"] = sanitize_text_field(wp_unslash($_POST["integration"]["security-for-woocommerce"]["debug-log"]));
				} else {
					$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["debug-log"] = 0;
				}
			}
			if (isset($_POST["integration"]["customize"])) {
				// echo 'Customioze';
				if (isset($_POST["integration"]["customize"]["header-background-image"])) {
					if (isset($_POST["integration"]["customize"]["header-background-image"]['url'])) {
						// echo 'header-background-image';
						$ultimate_security_for_woocommerce_options["integration"]["customize"]["header-background-image"]['url'] = sanitize_url(wp_unslash($_POST["integration"]["customize"]["header-background-image"]['url']));
					} else {
						$ultimate_security_for_woocommerce_options["integration"]["customize"]["header-background-image"]['url'] = '';
					}
					if (isset($_POST["integration"]["customize"]["header-background-image"]['id'])) {
						// echo 'header-background-image';
						$ultimate_security_for_woocommerce_options["integration"]["customize"]["header-background-image"]['id'] = sanitize_text_field(wp_unslash($_POST["integration"]["customize"]["header-background-image"]['id']));
					} else {
						$ultimate_security_for_woocommerce_options["integration"]["customize"]["header-background-image"]['id'] = '';
					}
				}
			}
		}

		update_option('ultimate_security_for_woocommerce_options', $ultimate_security_for_woocommerce_options);
		// isset($_POST["submit"]) ? setcookie('ultimate-security-for-woocommerce-settings-updated', sanitize_text_field(wp_unslash($_POST["submit"])), time() + (86400 * 30), "/") : '';
	}

	public function ultimate_security_for_woocommerce_shop_ip_reset()
	{
		if (isset($_POST['security']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['security'])), 'ultimate_security_for_woocommerce_security_nonce')) {
			$ultimate_security_for_woocommerce_get_visitor_ip = ultimate_security_for_woocommerce_get_visitor_ip();
			$ultimate_security_for_woocommerce_get_visitor_country_via_api = ultimate_security_for_woocommerce_get_visitor_country_via_api();

			$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();

			$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["your-website-ip-address"] = esc_html($ultimate_security_for_woocommerce_get_visitor_ip);

			$ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["your-current-location"] = esc_html($ultimate_security_for_woocommerce_get_visitor_country_via_api);

			update_option('ultimate_security_for_woocommerce_options', $ultimate_security_for_woocommerce_options);

			wp_send_json_success(array('ultimate_security_for_woocommerce_get_visitor_ip' => esc_html($ultimate_security_for_woocommerce_get_visitor_ip), 'ultimate_security_for_woocommerce_get_visitor_country_via_api' => esc_html($ultimate_security_for_woocommerce_get_visitor_country_via_api)));
		} else {
			wp_send_json_error(array('error_message' => esc_html__('Nonce verification failed. Please try again.', 'ultimate-security-for-woocommerce')));
		}

		wp_die();
	}
	/**
	 * Reset settings page data.
	 *
	 * @since    1.0.0
	 */
	public function ultimate_security_for_woocommerce_reset_settings()
	{
		if (isset($_POST['security']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['security'])), 'ultimate_security_for_woocommerce_security_nonce')) {
			$name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';

			$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();

			$ultimate_security_for_woocommerce_default_options = ultimate_security_for_woocommerce_get_default_options();
			$nameArr = explode(".", $name);

			if (isset($nameArr[0]) && isset($nameArr[1]) && isset($ultimate_security_for_woocommerce_default_options[$nameArr[0]][$nameArr[1]])) {
				$ultimate_security_for_woocommerce_options[$nameArr[0]][$nameArr[1]] = $ultimate_security_for_woocommerce_default_options[$nameArr[0]][$nameArr[1]];
			} else if (isset($nameArr[0]) && isset($ultimate_security_for_woocommerce_default_options[$nameArr[0]])) {
				$ultimate_security_for_woocommerce_options[$nameArr[0]] = $ultimate_security_for_woocommerce_default_options[$nameArr[0]];
			}

			update_option('ultimate_security_for_woocommerce_options', $ultimate_security_for_woocommerce_options);
			wp_send_json_success();
		} else {
			wp_send_json_error(array('error_message' => esc_html__('Nonce verification failed. Please try again.', 'ultimate-security-for-woocommerce')));
		}
		wp_die();
	}
	public function ultimate_security_for_woocommerce_admin_bar_menu(WP_Admin_Bar $wp_admin_bar)
	{
		$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();
		if (!current_user_can('manage_options')) {
			return;
		}
		if (
			isset($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['firewall'])
			&& $ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['firewall']
			&& isset($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['debug-log'])
			&& $ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['debug-log']
		) {
			//add top level menu item
			$wp_admin_bar->add_menu(array(
				'id'    => 'ultimate-security-for-woocommerce-switch-to-country',
				'title' => '<span class="ab-icon"></span><span class="ab-text">' . __('USFW', 'ultimate-security-for-woocommerce') . '</span>',
				'icon' => 'dashicons-before dashicons-admin-post'
				// 'href'  => admin_url('options-general.php?page=perfmatters')
			));
			$wp_admin_bar->add_menu(array(
				'parent' => 'ultimate-security-for-woocommerce-switch-to-country',
				'id' => 'ultimate-security-for-woocommerce-form-in-admin-bar',
				'title' => '<form class="search-user"><div class="input-wrap"><input class="search-country-input" type="text" placeholder="' . __('Start typing to search.', 'ultimate-security-for-woocommerce') . '" data-redirect="' . home_url() . '"/><div class="search-result"></div></div></form>'
			));
			$wp_admin_bar->add_menu(array(
				'parent' => 'ultimate-security-for-woocommerce-switch-to-country',
				'id' => 'ultimate-security-for-woocommerce-recent-countries-title',
				'title' => '<span class="title-part">Recent Countries</span>'
			));
			$ultimate_security_for_woocommerce_recent_search = get_option('ultimate_security_for_woocommerce_recent_search') ? array_reverse(get_option('ultimate_security_for_woocommerce_recent_search')) : [];
			if (sizeof($ultimate_security_for_woocommerce_recent_search)) {
				$n = 0;
				foreach ($ultimate_security_for_woocommerce_recent_search as $code) {
					$wp_admin_bar->add_menu(
						array(
							'parent' => 'ultimate-security-for-woocommerce-recent-countries-title',
							'title' => '<span class="ultimate-security-for-woocommerce-change-country" data-redirect="' . home_url() . '" data-code="' . esc_html($code) . '" data-name="' . esc_html(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_COUNTRIES[$code]) . '"><span class="">' . esc_html(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_COUNTRIES[$code]) . '</span></span>',
							'id' => 'switch-country-' . $code,
							'href' => '#',
							'meta' => [
								'class' => 'switch-country-li switch-country-li-' . $code,
							]
						)
					);
					$n++;
					if ($n >= 4) break;
				}
			}
		}
	}
	public function ultimate_security_for_woocommerce_country_reset_admin_notice()
	{
		$currentScreen = get_current_screen();
		$ultimate_security_for_woocommerce_show_notice = isset($_COOKIE['ultimate_security_for_woocommerce_show_notice']) ? sanitize_text_field(wp_unslash($_COOKIE['ultimate_security_for_woocommerce_show_notice'])) : '';
		if ($ultimate_security_for_woocommerce_show_notice && $currentScreen->id == 'dashboard') {
			?>
			<div id="ultimate-security-for-woocommerce-switch-notice" class="ultimate-security-for-woocommerce-switch-notice notice notice-success">
				<div class="wrapper">
					<div class="part-img"><img src="<?php echo esc_url(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'admin/images/notice.svg') ?>" alt="" width="103" height="95"></div>
					<div class="part-text">
						<h4>
							<?php echo sprintf(
								esc_html__('You have switched back to "%1$s". Want toswitch to a differant country again?', 'ultimate-security-for-woocommerce'),
								esc_html(ultimate_security_for_woocommerce_get_visitor_country_via_api())
							) ?>
						</h4>
						<p><?php echo esc_html__('It seems like you have switched back to the admin role. If you wish to back to any specific country view, just search from the top bar, type the name and click on it to switch again.', 'ultimate-security-for-woocommerce') ?></p>
						<div class="button-group">
							<a id="ultimate-security-for-woocommerce-open-switching-dropdown" href="#" class="button button-primary"><span class="text-part">Switch</span></a>
							<a href="admin.php?page=ultimate-security-for-woocommerce" class="button button-secondary"><span class="text-part">Settings</span></a>
						</div><!--.button-group-->
					</div><!--.part-text-->
				</div>
				<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'ultimate-security-for-woocommerce') ?></span></button>
			</div>
		<?php
		}
		// }
	}
	// add_action('admin_notices', 'ultimate_security_for_woocommerce_country_reset_admin_notice');
	public function ultimate_security_for_woocommerce_country_search()
	{
		if (isset($_POST['security']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['security'])), 'ultimate_security_for_woocommerce_security_nonce')) {
			$search_key = isset($_POST['userQuery']) ? sanitize_text_field(wp_unslash($_POST['userQuery'])) : '';
			$redirect = isset($_POST['redirect']) ? sanitize_text_field(wp_unslash($_POST['redirect'])) : '';
			$html = '';
			$matches  = preg_grep('/' . $search_key . '/i', ULTIMATE_SECURITY_FOR_WOOCOMMERCE_COUNTRIES);
			if (sizeof($matches)) {
				$html .= '<ul>';
				foreach ($matches as $code => $name) {
					$html .= '<li><a class="ultimate-security-for-woocommerce-change-country" href="#" data-code="' . $code . '" data-name="' . $name . '" data-redirect="' . $redirect . '"><span class="">' . $name . '</span></a></li>';
				}
				$html .= '</ul>';
			}

			wp_send_json_success(array('html' => $html));
		} else {
			wp_send_json_error(array('error_message' => esc_html__('Nonce verification failed. Please try again.', 'ultimate-security-for-woocommerce')));
		}

		wp_die();
	}
	public function ultimate_security_for_woocommerce_country_set()
	{
		if (isset($_POST['security']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['security'])), 'ultimate_security_for_woocommerce_security_nonce')) {
			$code = isset($_POST['code']) ? sanitize_text_field(wp_unslash($_POST['code'])) : '';
			$name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';

			$cookie_name = "ultimate_security_for_woocommerce_debug_country";
			setcookie($cookie_name, $name, time() + (86400 * 30), "/");

			$ultimate_security_for_woocommerce_recent_search = get_option('ultimate_security_for_woocommerce_recent_search', []);

			if (in_array($code, $ultimate_security_for_woocommerce_recent_search)) {
				array_splice($ultimate_security_for_woocommerce_recent_search, array_search($code, $ultimate_security_for_woocommerce_recent_search), 1);
			}
			$ultimate_security_for_woocommerce_recent_search[] = $code;
			update_option('ultimate_security_for_woocommerce_recent_search', $ultimate_security_for_woocommerce_recent_search);

			wp_send_json_success(array('code' => $code, 'name' => $name));
		} else {
			wp_send_json_error(array('error_message' => esc_html__('Nonce verification failed. Please try again.', 'ultimate-security-for-woocommerce')));
		}
	}
	public function ultimate_security_for_woocommerce_setting_restrictions_settings_unit_1()
	{
		$current_screen = get_current_screen();
		$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();
		// var_dump($current_screen->id);
		if ($current_screen->id == 'toplevel_page_ultimate-security-for-woocommerce') {
		?>
			<div class="setting-unit switch-setting-unit border-bottom-0">
				<div class="row">
					<div class="col-lg-5">
						<div class="title-wrap">
							<div class="title"><?php echo esc_html__('Firewall On/Off', 'ultimate-security-for-woocommerce') ?></div>
							<div class="description">
								<p><?php echo esc_html__('Enable or disable the restrictions that you applied below to your site.', 'ultimate-security-for-woocommerce') ?></p>
							</div>
						</div>
					</div>
					<div class="col-lg-7">
						<div class="row justify-content-between">
							<div class="col-auto">
								<label class="position-relative">
									<span class="hint-tooltip hint--bottom" aria-label="<?php echo esc_html__('Enable/disable restrictions.', 'ultimate-security-for-woocommerce') ?>"><i class="dashicons dashicons-editor-help"></i></span>
									<span><?php echo esc_html__('Apply restrictions', 'ultimate-security-for-woocommerce') ?></span>
								</label>
								<p><?php echo esc_html__('Set the conditions below.', 'ultimate-security-for-woocommerce') ?></p>
							</div>
							<div class="col-auto">
								<div class="position-relative switcher">
									<label for="integration-security-for-woocommerce-firewall">
										<input type="checkbox" name="integration[security-for-woocommerce][firewall]" id="integration-security-for-woocommerce-firewall" value="1" <?php checked($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['firewall'], 1, 1) ?>>
										<em data-on="on" data-off="off"></em>
										<span></span>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		<?php
		}
	}
	public function ultimate_security_for_woocommerce_setting_restrictions_settings_unit_2()
	{
		$current_screen = get_current_screen();
		$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();
		// var_dump($current_screen->id);
		if ($current_screen->id == 'toplevel_page_ultimate-security-for-woocommerce') {
		?>
			<div class="setting-unit border-bottom-0">
				<div class="row">
					<div class="col-lg-5">
						<div class="title-wrap">
							<div class="title"><?php echo esc_html__('Your website IP address', 'ultimate-security-for-woocommerce') ?>:</div>
							<div class="description">
								<p><?php echo esc_html__('See which IP you are currently browsing from.', 'ultimate-security-for-woocommerce') ?></p>
							</div>
						</div>
					</div>
					<div class="col-lg-7">
						<label class="position-relative" for="integration-security-for-woocommerce-your-website-ip-address">
							<span class="hint-tooltip hint--bottom" aria-label="<?php echo esc_html__('This is your current IP.', 'ultimate-security-for-woocommerce') ?>"><i class="dashicons dashicons-editor-help"></i></span>
							<div class="form-control-plaintext"><?php echo esc_html(@$ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['your-website-ip-address']) ?></div>
							<input type="hidden" value="<?php echo esc_html(@$ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['your-website-ip-address']) ?>" name="integration[security-for-woocommerce][your-website-ip-address]" class="integration-security-for-woocommerce-your-website-ip-address">
							<img class="reset-shop-ip" src="<?php echo esc_url(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'admin/images/reset-ip.svg') ?>" alt="">
						</label>
						<div class="help-text">
							<strong>Note :</strong> You need to fetch for the first time.
						</div>
					</div>
				</div>

			</div>

		<?php
		}
	}
	public function ultimate_security_for_woocommerce_setting_restrictions_settings_unit_3()
	{
		$current_screen = get_current_screen();
		$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();
		// var_dump($current_screen->id);
		if ($current_screen->id == 'toplevel_page_ultimate-security-for-woocommerce') {
		?>
			<div class="setting-unit border-bottom-0">
				<div class="row">
					<div class="col-lg-5">
						<div class="title-wrap">
							<div class="title"><?php echo esc_html__('Your current location/country', 'ultimate-security-for-woocommerce') ?>:</div>
							<div class="description">
								<p><?php echo esc_html__('See which country you are currently browsing from.', 'ultimate-security-for-woocommerce') ?></p>
							</div>
						</div>
					</div>
					<div class="col-lg-7">
						<label class="position-relative" for="integration-security-for-woocommerce-your-current-location">
							<span class="hint-tooltip hint--bottom" aria-label="<?php echo esc_html__('This is you current location.', 'ultimate-security-for-woocommerce') ?>"><i class="dashicons dashicons-editor-help"></i></span>
							<div class="form-control-plaintext"><?php echo esc_html(@$ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['your-current-location']) ?></div>
							<input type="hidden" value="<?php echo esc_html(@$ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['your-current-location']) ?>" name="integration[security-for-woocommerce][your-current-location]" class="integration-security-for-woocommerce-your-current-location">
							<img class="reset-shop-ip" src="<?php echo esc_url(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'admin/images/reset-ip.svg') ?>" alt="">
						</label>
						<div class="help-text">
							<strong>Note :</strong> You need to fetch for the first time.
						</div>
					</div>
				</div>

			</div>

		<?php
		}
	}
	public function ultimate_security_for_woocommerce_setting_restrictions_settings_unit_4()
	{
		$current_screen = get_current_screen();
		$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();
		// var_dump($current_screen->id);
		if ($current_screen->id == 'toplevel_page_ultimate-security-for-woocommerce') {
		?>
			<div class="setting-unit border-bottom-0">
				<div class="row">
					<div class="col-lg-5">
						<div class="title-wrap">
							<div class="title"><?php echo esc_html__('Blocked countries list', 'ultimate-security-for-woocommerce') ?>:</div>
							<div class="description">
								<p><?php echo esc_html__('Set the list of countries you would like to block for your WooCommerce pages.', 'ultimate-security-for-woocommerce') ?></p>
							</div>
						</div>
					</div>
					<div class="col-lg-7">
						<label class="position-relative" for="integration-security-for-woocommerce-blocked-countries-list">
							<span class="hint-tooltip hint--bottom" aria-label="<?php echo esc_html__('List of blocked countries.', 'ultimate-security-for-woocommerce') ?>"><i class="dashicons dashicons-editor-help"></i></span>
							<input id="integration-security-for-woocommerce-blocked-countries-list" class="blocked-country-tagify" name="integration[security-for-woocommerce][blocked-countries-list]" value="<?php echo esc_html(@$ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['blocked-countries-list']) ?>">
						</label>
						<div class="action-button-group">
							<a href="#" class="add-all-to-blocked-countries" data-target="#integration-security-for-woocommerce-blocked-countries-list"><?php echo esc_html__('Select All', 'ultimate-security-for-woocommerce') ?></a>
							<a href="#" class="remove-all-from-blocked-countries" data-target="#integration-security-for-woocommerce-blocked-countries-list"><?php echo esc_html__('Remove All', 'ultimate-security-for-woocommerce') ?></a>
						</div>

					</div>
				</div>

			</div>

		<?php
		}
	}
	public function ultimate_security_for_woocommerce_setting_restrictions_settings_unit_5()
	{
		$current_screen = get_current_screen();
		$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();
		// var_dump($current_screen->id);
		if ($current_screen->id == 'toplevel_page_ultimate-security-for-woocommerce') {
		?>
			<div class="setting-unit border-bottom-0">
				<div class="row">
					<div class="col-lg-5">
						<div class="title-wrap">
							<div class="title"><?php echo esc_html__('Blacklisted IPs', 'ultimate-security-for-woocommerce') ?>:</div>
							<div class="description">
								<p><?php echo esc_html__('Set the list of IPs you would like to block for your WooCommerce pages.', 'ultimate-security-for-woocommerce') ?></p>
							</div>
						</div>
					</div>
					<div class="col-lg-7">
						<label class="position-relative">
							<span class="hint-tooltip hint--bottom" aria-label="<?php echo esc_html__('List of black listed IPs.', 'ultimate-security-for-woocommerce') ?>"><i class="dashicons dashicons-editor-help"></i></span>
							<input id="integration-security-for-woocommerce-blacklisted-ips" class="base-tagify" name="integration[security-for-woocommerce][blacklisted-ips]" value="<?php echo esc_html(@$ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['blacklisted-ips']) ?>">
						</label>
					</div>
				</div>

			</div>

		<?php
		}
	}
	public function ultimate_security_for_woocommerce_setting_restrictions_settings_unit_6()
	{
		$current_screen = get_current_screen();
		$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();
		// var_dump($current_screen->id);
		if ($current_screen->id == 'toplevel_page_ultimate-security-for-woocommerce') {
		?>
			<div class="setting-unit border-bottom-0">
				<div class="row">
					<div class="col-lg-5">
						<div class="title-wrap">
							<div class="title"><?php echo esc_html__('Allow only traffic from this country', 'ultimate-security-for-woocommerce') ?>:</div>
							<div class="description">
								<p><?php echo esc_html__('Set the list of countries of countries you would like to allow for your WooCommerce pages.', 'ultimate-security-for-woocommerce') ?></p>
							</div>
						</div>
					</div>
					<div class="col-lg-7">
						<label class="position-relative" for="integration-security-for-woocommerce-allow-only-traffic-from-this-country">
							<span class="hint-tooltip hint--bottom" aria-label="<?php echo esc_html__('List of allowed countries.', 'ultimate-security-for-woocommerce') ?>"><i class="dashicons dashicons-editor-help"></i></span>
							<input id="integration-security-for-woocommerce-allow-only-traffic-from-this-country" class="alowed-country-tagify" name="integration[security-for-woocommerce][allow-only-traffic-from-this-country]" value="<?php echo esc_html(@$ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['allow-only-traffic-from-this-country']) ?>">
						</label>
						<div class="action-button-group">
							<a href="#" class="add-all-to-alowed-countries" data-target="#integration-security-for-woocommerce-blocked-countries-list"><?php echo esc_html__('Select All', 'ultimate-security-for-woocommerce') ?></a>
							<a href="#" class="remove-all-from-alowed-countries" data-target="#integration-security-for-woocommerce-blocked-countries-list"><?php echo esc_html__('Remove All', 'ultimate-security-for-woocommerce') ?></a>
						</div>
					</div>
				</div>
			</div>

		<?php
		}
	}
	public function ultimate_security_for_woocommerce_setting_restrictions_settings_unit_7()
	{
		$current_screen = get_current_screen();
		$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();
		// var_dump($current_screen->id);
		if ($current_screen->id == 'toplevel_page_ultimate-security-for-woocommerce') {
		?>
			<div class="setting-unit border-bottom-0">
				<div class="row">
					<div class="col-lg-5">
						<div class="title-wrap">
							<div class="title"><?php echo esc_html__('Whitelisted IPs', 'ultimate-security-for-woocommerce') ?>:</div>
							<div class="description">
								<p><?php echo esc_html__('Set the list of IPs you would like to allow for your WooCommerce pages.', 'ultimate-security-for-woocommerce') ?></p>
							</div>
						</div>
					</div>
					<div class="col-lg-7">
						<label class="position-relative" for="integration-security-for-woocommerce-whitelisted-ips">
							<span class="hint-tooltip hint--bottom" aria-label="<?php echo esc_html__('List of whitelisted IPs.', 'ultimate-security-for-woocommerce') ?>"><i class="dashicons dashicons-editor-help"></i></span>
							<input id="integration-security-for-woocommerce-whitelisted-ips" class="base-tagify" name="integration[security-for-woocommerce][whitelisted-ips]" value="<?php echo esc_html(@$ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['whitelisted-ips']) ?>">
						</label>
					</div>
				</div>
			</div>
		<?php
		}
	}
	public function ultimate_security_for_woocommerce_setting_restrictions_settings_unit_8()
	{
		$current_screen = get_current_screen();
		$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();
		// var_dump($current_screen->id);
		if ($current_screen->id == 'toplevel_page_ultimate-security-for-woocommerce') {
		?>
			<div class="setting-unit switch-setting-unit border-bottom-0">
				<div class="row">
					<div class="col-lg-5">
						<div class="title-wrap">
							<div class="title"><?php echo esc_html__('Debug Log On/Off', 'ultimate-security-for-woocommerce') ?>:</div>
							<div class="description">
								<p><?php echo esc_html__('Debug mode adds a top bar for easy switching for both frontend and backend.', 'ultimate-security-for-woocommerce') ?></p>
							</div>
						</div>
					</div>
					<div class="col-lg-7">
						<div class="row justify-content-between">
							<div class="col-auto">
								<label class="position-relative">
									<span class="hint-tooltip hint--bottom" aria-label="<?php echo esc_html__('Show/hide top debug bar.', 'ultimate-security-for-woocommerce') ?>"><i class="dashicons dashicons-editor-help"></i></span>
									<span><?php echo esc_html__('Debug bar', 'ultimate-security-for-woocommerce') ?></span>
								</label>
								<p><?php echo esc_html__('Enable/disable debug bar.', 'ultimate-security-for-woocommerce') ?></p>
							</div>
							<div class="col-auto">
								<div class="position-relative switcher">
									<label for="integration-security-for-woocommerce-debug-log">
										<input type="checkbox" id="integration-security-for-woocommerce-debug-log" name="integration[security-for-woocommerce][debug-log]" value="1" <?php checked($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['debug-log'], 1, 1) ?>>
										<em data-on="on" data-off="off"></em>
										<span></span>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
	}
	public function ultimate_security_for_woocommerce_setting_restrictions_customize_unit_1()
	{
		$current_screen = get_current_screen();
		$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();
		// var_dump($current_screen->id);
		if ($current_screen->id == 'admin_page_ultimate-security-for-woocommerce-integration-customize') {
		?>
			<div class="setting-unit media-uploader-setting-unit border-bottom-0">
				<div class="row">
					<div class="col-lg-5">
						<div class="title-wrap">
							<div class="title"><?php echo esc_html__('Header background image', 'ultimate-security-for-woocommerce') ?>:</div>
						</div>
					</div>
					<div class="col-lg-7">
						<?php
						$url = ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'admin/images/upload-image.svg';
						$cls = '';
						if (isset($ultimate_security_for_woocommerce_options['integration']['customize']['header-background-image']['url']) && $ultimate_security_for_woocommerce_options['integration']['customize']['header-background-image']['url']) {
							$url = $ultimate_security_for_woocommerce_options['integration']['customize']['header-background-image']['url'];
							$cls = 'with-close-button';
						}
						?>
						<div class="media-uploader ultimate-security-for-woocommerce-image-uploader <?php echo esc_html($cls) ?>">
							<div class="wrapper">
								<div class="image-wrapper">
									<img class="img-fluid" src="<?php echo esc_url($url) ?>" alt="" data-image="<?php echo esc_url(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'admin/images/upload-image.svg') ?>">
									<span class="remove_image"></span>
								</div>
								<?php printf(
									esc_html__(
										'%1$sSize: Optional %2$s File Support: jpg, .jpeg, . gif, or .png.%3$s',
										'ultimate-security-for-woocommerce'
									),
									'<p>',
									'<br/>',
									'</p>'
								); ?>
								<div class="button-group">
									<button class="button button-solid upload_image" type="button"><?php echo esc_html__('Upload', 'ultimate-security-for-woocommerce') ?></button>
									<button class="button button-outline remove_image" type="button"><?php echo esc_html__('Remove', 'ultimate-security-for-woocommerce') ?></button>
								</div>
								<p><?php echo esc_html__('File link', 'ultimate-security-for-woocommerce') ?>:</p>
							</div>

							<label class="position-relative">
								<span class="hint-tooltip hint--bottom" aria-label="<?php echo esc_html__('This is your image link.', 'ultimate-security-for-woocommerce') ?>"><i class="dashicons dashicons-editor-help"></i></span>
								<input type="text" class="form-control img_url" placeholder="" name="integration[customize][header-background-image][url]" value="<?php echo esc_html(@$ultimate_security_for_woocommerce_options['integration']['customize']['header-background-image']['url']) ?>" readonly />
								<input class="img_id" type="hidden" name="integration[customize][header-background-image][id]" value="<?php echo esc_html(@$ultimate_security_for_woocommerce_options['integration']['customize']['header-background-image']['id']) ?>">
							</label>
							<p><?php echo esc_html__('Select the background image for the header', 'ultimate-security-for-woocommerce') ?></p>
						</div>
					</div>
				</div>
			</div>

<?php
		}
	}
}
