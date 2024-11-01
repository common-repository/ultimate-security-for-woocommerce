<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.programmelab.com/
 * @since      1.0.0
 *
 * @package    Ultimate_Security_For_Woocommerce
 * @subpackage Ultimate_Security_For_Woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ultimate_Security_For_Woocommerce
 * @subpackage Ultimate_Security_For_Woocommerce/includes
 * @author     Programmelab <rizvi@programmelab.com>
 */
class Ultimate_Security_For_Woocommerce_Activator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		update_option('ultimate_security_for_woocommerce_recent_search', []);
		$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();
		update_option('ultimate_security_for_woocommerce_options', $ultimate_security_for_woocommerce_options);
		add_option('ultimate_security_for_woocommerce_do_activation_redirect', true);
	}
}
