<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://www.programmelab.com/
 * @since      1.0.0
 *
 * @package    Ultimate_Security_For_Woocommerce
 * @subpackage Ultimate_Security_For_Woocommerce/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Ultimate_Security_For_Woocommerce
 * @subpackage Ultimate_Security_For_Woocommerce/includes
 * @author     Programmelab <rizvi@programmelab.com>
 */
class Ultimate_Security_For_Woocommerce_Deactivator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate()
	{
		delete_option('ultimate_security_for_woocommerce_options');
		
    	// Not like register_uninstall_hook(), you do NOT have to use a static function.
    	usfw_fs()->add_action('after_uninstall', 'usfw_fs_uninstall_cleanup');
	}
}
