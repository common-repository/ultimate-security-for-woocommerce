<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.programmelab.com/
 * @since      1.0.0
 *
 * @package    Ultimate_Security_For_Woocommerce
 * @subpackage Ultimate_Security_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ultimate_Security_For_Woocommerce
 * @subpackage Ultimate_Security_For_Woocommerce/public
 * @author     Programmelab <rizvi@programmelab.com>
 */
class Ultimate_Security_For_Woocommerce_Public
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		wp_enqueue_style($this->plugin_name . '-public', ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'public/css/public-style.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		// wp_enqueue_script($this->plugin_name, plugin_dir_url(__DIR__) . 'assets/js/script.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name, ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'assets/js/script.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name . '-ajax', ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL . 'assets/js/ajax.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name . '-public-script', plugin_dir_url(__FILE__) . 'js/public-script.js', array('jquery'), $this->version, false);


		$ajax_params = array(
			'admin_url' => admin_url(),
			'ajax_url' => admin_url('admin-ajax.php'),
			'security' => esc_attr(wp_create_nonce('ultimate_security_for_woocommerce_security_nonce')),
			// 'install_plugin_wpnonce' => esc_attr(wp_create_nonce('updates')),
		);
		wp_localize_script($this->plugin_name . '-ajax', 'ultimate_security_for_woocommerce_ajax_obj', $ajax_params);
	}
	public function ultimate_security_for_woocommerce_shop_page_redirect()
	{
		if (is_woocommerce() || is_checkout() || is_cart()) {
			wp_redirect(home_url('/restricted/'));
			exit();
		}
	}
	// add_action('template_redirect', 'ultimate_security_for_woocommerce_shop_page_redirect');
	public function ultimate_security_for_woocommerce_woocommerce_page_template($template)
	{
		$country_code = isset($_COOKIE['ultimate_security_for_woocommerce_debug_country']) ? sanitize_text_field(wp_unslash($_COOKIE['ultimate_security_for_woocommerce_debug_country'])) : '';
		$ultimate_security_for_woocommerce_get_visitor_ip = ultimate_security_for_woocommerce_get_visitor_ip();
		$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();

		if (isset($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['firewall']) && $ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['firewall']) {
			if (is_woocommerce() || is_checkout() || is_cart() || is_account_page()) {
				if (!ultimate_security_has_woocommerce_pages_accessibility($ultimate_security_for_woocommerce_get_visitor_ip, $country_code)) {
					$template = ULTIMATE_SECURITY_FOR_WOOCOMMERCE_PATH . 'public/partials/' . 'ultimate-security-for-woocommerce-public-display.php';
				}
			}
		}
		return $template;
	}
	// add_filter('template_include', 'woocommerce_page_template', 99);
	public function ultimate_security_for_woocommerce_added_page_content($content)
	{
		if (is_page()) {
			return $content = '';
		}

		return $content;
	}
	// add_filter('the_content', 'ultimate_security_for_woocommerce_added_page_content', 9999);
	public function ultimate_security_for_woocommerce_top_bar()
	{
		$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();

		$get_visitor_country = ultimate_security_for_woocommerce_get_visitor_country_via_api();
		$view_from_country = isset($_COOKIE['ultimate_security_for_woocommerce_debug_country']) ? sanitize_text_field(wp_unslash($_COOKIE['ultimate_security_for_woocommerce_debug_country'])) : $get_visitor_country;

		if (current_user_can('manage_options') && isset($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['firewall']) && $ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['firewall'] && isset($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['debug-log']) && $ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['debug-log']) :
?>
			<section class="ultimate-security-for-woocommerce-top-bar">
				<div class="ultimate-security-for-woocommerce-current-data"><?php echo esc_html__('You\'re Viewing from ', 'ultimate-security-for-woocommerce') ?>"<?php echo esc_html($view_from_country) ?>"</div>
				<div class="ultimate-security-for-woocommerce-switch-to-another">
					<div class="ultimate-security-for-woocommerce-header-text"><?php echo esc_html__('Switch to another country', 'ultimate-security-for-woocommerce') ?></div>
					<div class="ultimate-security-for-woocommerce-hover-content" style="display: none;">
						<div class="ab-item ab-empty-item" role="menuitem">
							<form class="search-country">
								<div class="input-wrap">
									<input type="text" class="search-country-input" placeholder="Start typing to search.">
									<div class="search-result"></div>
								</div>
							</form>
						</div>
						<ul>
							<?php
							$ultimate_security_for_woocommerce_recent_search = get_option('ultimate_security_for_woocommerce_recent_search') ? array_reverse(get_option('ultimate_security_for_woocommerce_recent_search')) : [];

							if (sizeof($ultimate_security_for_woocommerce_recent_search)) {
								$n = 0;
								foreach ($ultimate_security_for_woocommerce_recent_search as $code) {
									$link = '#';
									echo '<li><a class="ultimate-security-for-woocommerce-change-country" href="#" data-code="' . esc_html($code) . '" data-name="' . esc_html(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_COUNTRIES[$code]) . '"><span class="">' . esc_html(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_COUNTRIES[$code]) . '</span></a></li>';
									$n++;
									if ($n >= 4) break;
								}
							}
							?>
						</ul>
					</div>
				</div>
				<div class="ultimate-security-for-woocommerce-switch-to-main">
					<a href="#" data-redirect="<?php echo esc_url(admin_url()) ?>"><?php echo esc_html__('Switch Back to Admin', 'ultimate-security-for-woocommerce') ?></a>
				</div>
			</section>
<?php
		endif;
	}
}
