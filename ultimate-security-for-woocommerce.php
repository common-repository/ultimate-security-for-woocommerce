<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.programmelab.com/
 * @since             1.0.0
 * @package           Ultimate_Security_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Ultimate Security For WooCommerce
 * Plugin URI:        https://www.programmelab.com
 * Description:       Plugin starter boilerplate for WordPress
 * Version:           1.0.1
 * Author:            Programmelab
 * Author URI:        https://www.programmelab.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ultimate-security-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
	die;
}
if (! function_exists('usfw_fs')) {
	// Create a helper function for easy SDK access.
	function usfw_fs()
	{
		global $usfw_fs;

		if (! isset($usfw_fs)) {
			// Include Freemius SDK.
			// require_once dirname(__FILE__) . '/freemius/start.php';
			require_once dirname(__FILE__) . '/vendor/freemius/wordpress-sdk/start.php';

			$usfw_fs = fs_dynamic_init(array(
				'id'                  => '16836',
				'slug'                => 'ultimate-security-for-woocommerce',
				'type'                => 'plugin',
				'public_key'          => 'pk_d7c28b813c6028aada91552ad8757',
				'is_premium'          => false,
				'has_addons'          => false,
				'has_paid_plans'      => false,
				'menu'                => array(
					'slug'           => 'ultimate-security-for-woocommerce',
					'first-path'	 => 'admin.php?page=ultimate-security-for-woocommerce',
					'account'        => false,
					'contact'        => false,
					'support'        => false,
				),
				'is_live'        => true,
				'author'              => 'Programmelab',
				'author_url'          => 'https://www.programmelab.com/',
			));
		}

		return $usfw_fs;
	}

	// Init Freemius.
	usfw_fs();
	// Signal that SDK was initiated.
	do_action('usfw_fs_loaded');
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('ULTIMATE_SECURITY_FOR_WOOCOMMERCE_VERSION', '1.0.1');
define('ULTIMATE_SECURITY_FOR_WOOCOMMERCE_NAME', __('Ultimate Security For Woocommerce', 'ultimate-security-for-woocommerce'));

define('ULTIMATE_SECURITY_FOR_WOOCOMMERCE_PATH', plugin_dir_path(__FILE__));
define('ULTIMATE_SECURITY_FOR_WOOCOMMERCE_URL', plugin_dir_url(__FILE__));


function ultimate_security_for_woocommerce_get_default_options()
{
	$ultimate_security_for_woocommerce_default_options = [
		'integration' => [
			'security-for-woocommerce' => [
				'firewall' => 1,
				'your-website-ip-address' => '', // ultimate_security_for_woocommerce_get_visitor_ip(),
				'your-current-location' => '', // ultimate_security_for_woocommerce_get_visitor_country_via_api(),
				'blocked-countries-list' => '',
				'blacklisted-ips' => '',
				'allow-only-traffic-from-this-country' => '',
				'whitelisted-ips' => '',
				'debug-log' => 1,
			],
			'customize' => [
				'header-background-image' => [
					'url' => '',
					'id' => 0
				]
			]
		]
	];
	$ultimate_security_for_woocommerce_default_options = apply_filters('ultimate_security_for_woocommerce_default_options_modify', $ultimate_security_for_woocommerce_default_options);

	return $ultimate_security_for_woocommerce_default_options;
}
function ultimate_security_for_woocommerce_get_tabs()
{
	$ultimate_security_for_woocommerce_tabs = [
		'integration' => [
			'slug' => 'integration',
			'name' => esc_html__('Restrictions', 'ultimate-security-for-woocommerce'),
			'description' => esc_html__('Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'ultimate-security-for-woocommerce'),
			'url' => 'ultimate-security-for-woocommerce',
			'sub' => [
				'security-for-woocommerce' => [
					'slug' => 'security-for-woocommerce',
					'name' => esc_html__('Settings', 'ultimate-security-for-woocommerce'),
					'description' => esc_html__('Below you will find all the settings you need to restrict specific countires and IP addressses that you wish to restrict for your WooCommerce site. The restrictons will be applied to your WooCommerce pages.', 'ultimate-security-for-woocommerce'),
					'url' => 'ultimate-security-for-woocommerce'
				],
				'customize' => [
					'slug' => 'customize',
					'name' => esc_html__('Customize', 'ultimate-security-for-woocommerce'),
					'description' => esc_html__('Below you will find all the settings you need to customize restriction pages including the images that the visitor will see if they are restricted from accessing the website. The customization will be applied to your WooCommerce pages.', 'ultimate-security-for-woocommerce'),
					'url' => 'ultimate-security-for-woocommerce-integration-customize'
				],
			],
		],

	];
	// Apply filter to allow modification of $variable by other plugins
	$ultimate_security_for_woocommerce_tabs = apply_filters('ultimate_security_for_woocommerce_tabs_modify', $ultimate_security_for_woocommerce_tabs);

	return $ultimate_security_for_woocommerce_tabs;
}
function ultimate_security_for_woocommerce_is_plugin_page()
{
	if (function_exists('get_current_screen')) {
		$current_screen = get_current_screen();
		$tabs = ultimate_security_for_woocommerce_get_tabs();
		$pages = [];
		foreach ($tabs as $tab) {
			$pages[] = 'admin_page_' . $tab['url'];
			if (isset($tab['sub']) && sizeof($tab['sub'])) {
				foreach ($tab['sub'] as $subtab) {
					$pages[] = 'admin_page_' . $subtab['url'];
				}
			}
		}
		if (
			$current_screen->id == 'toplevel_page_ultimate-security-for-woocommerce'
			|| in_array($current_screen->id, $pages)
		) {
			return true;
		}
	}
	return false;
}

define('ULTIMATE_SECURITY_FOR_WOOCOMMERCE_COUNTRIES', array(
	"AF" => "Afghanistan",
	"AX" => "Åland Islands",
	"AL" => "Albania",
	"DZ" => "Algeria",
	"AS" => "American Samoa",
	"AD" => "Andorra",
	"AO" => "Angola",
	"AI" => "Anguilla",
	"AQ" => "Antarctica",
	"AG" => "Antigua and Barbuda",
	"AR" => "Argentina",
	"AM" => "Armenia",
	"AW" => "Aruba",
	"AU" => "Australia",
	"AT" => "Austria",
	"AZ" => "Azerbaijan",
	"BS" => "Bahamas",
	"BH" => "Bahrain",
	"BD" => "Bangladesh",
	"BB" => "Barbados",
	"BY" => "Belarus",
	"BE" => "Belgium",
	"BZ" => "Belize",
	"BJ" => "Benin",
	"BM" => "Bermuda",
	"BT" => "Bhutan",
	"BO" => "Bolivia",
	"BA" => "Bosnia and Herzegovina",
	"BW" => "Botswana",
	"BV" => "Bouvet Island",
	"BR" => "Brazil",
	"IO" => "British Indian Ocean Territory",
	"BN" => "Brunei",
	"BG" => "Bulgaria",
	"BF" => "Burkina Faso",
	"BI" => "Burundi",
	"KH" => "Cambodia",
	"CM" => "Cameroon",
	"CA" => "Canada",
	"CV" => "Cabo Verde",
	"KY" => "Cayman Islands",
	"CF" => "Central African Republic",
	"TD" => "Chad",
	"CL" => "Chile",
	"CN" => "China",
	"CX" => "Christmas Island",
	"CC" => "Cocos (Keeling) Islands",
	"CO" => "Colombia",
	"KM" => "Comoros",
	"CG" => "Congo Republic",
	"CD" => "DR Congo",
	"CK" => "Cook Islands",
	"CR" => "Costa Rica",
	"CI" => "Ivory Coast",
	"HR" => "Croatia",
	"CU" => "Cuba",
	"CY" => "Cyprus",
	"CZ" => "Czechia",
	"DK" => "Denmark",
	"DJ" => "Djibouti",
	"DM" => "Dominica",
	"DO" => "Dominican Republic",
	"EC" => "Ecuador",
	"EG" => "Egypt",
	"SV" => "El Salvador",
	"GQ" => "Equatorial Guinea",
	"ER" => "Eritrea",
	"EE" => "Estonia",
	"ET" => "Ethiopia",
	"FK" => "Falkland Islands",
	"FO" => "Faroe Islands",
	"FJ" => "Fiji",
	"FI" => "Finland",
	"FR" => "France",
	"GF" => "French Guiana",
	"PF" => "French Polynesia",
	"TF" => "French Southern Territories",
	"GA" => "Gabon",
	"GM" => "Gambia",
	"GE" => "Georgia",
	"DE" => "Germany",
	"GH" => "Ghana",
	"GI" => "Gibraltar",
	"GR" => "Greece",
	"GL" => "Greenland",
	"GD" => "Grenada",
	"GP" => "Guadeloupe",
	"GU" => "Guam",
	"GT" => "Guatemala",
	"GG" => "Guernsey",
	"GN" => "Guinea",
	"GW" => "Guinea-Bissau",
	"GY" => "Guyana",
	"HT" => "Haiti",
	"HM" => "Heard and McDonald Islands",
	"VA" => "Vatican City",
	"HN" => "Honduras",
	"HK" => "Hong Kong",
	"HU" => "Hungary",
	"IS" => "Iceland",
	"IN" => "India",
	"ID" => "Indonesia",
	"IR" => "Iran",
	"IQ" => "Iraq",
	"IE" => "Ireland",
	"IM" => "Isle of Man",
	"IL" => "Israel",
	"IT" => "Italy",
	"JM" => "Jamaica",
	"JP" => "Japan",
	"JE" => "Jersey",
	"JO" => "Jordan",
	"KZ" => "Kazakhstan",
	"KE" => "Kenya",
	"KI" => "Kiribati",
	"KP" => "North Korea",
	"KR" => "South Korea",
	"KW" => "Kuwait",
	"KG" => "Kyrgyzstan",
	"LA" => "Laos",
	"LV" => "Latvia",
	"LB" => "Lebanon",
	"LS" => "Lesotho",
	"LR" => "Liberia",
	"LY" => "Libya",
	"LI" => "Liechtenstein",
	"LT" => "Lithuania",
	"LU" => "Luxembourg",
	"MO" => "Macao",
	"MK" => "North Macedonia",
	"MG" => "Madagascar",
	"MW" => "Malawi",
	"MY" => "Malaysia",
	"MV" => "Maldives",
	"ML" => "Mali",
	"MT" => "Malta",
	"MH" => "Marshall Islands",
	"MQ" => "Martinique",
	"MR" => "Mauritania",
	"MU" => "Mauritius",
	"YT" => "Mayotte",
	"MX" => "Mexico",
	"FM" => "Federated States of Micronesia",
	"MD" => "Moldova",
	"MC" => "Monaco",
	"MN" => "Mongolia",
	"MS" => "Montserrat",
	"MA" => "Morocco",
	"MZ" => "Mozambique",
	"MM" => "Myanmar",
	"NA" => "Namibia",
	"NR" => "Nauru",
	"NP" => "Nepal",
	"NL" => "The Netherlands",
	"AN" => "Netherlands Antilles",
	"NC" => "New Caledonia",
	"NZ" => "New Zealand",
	"NI" => "Nicaragua",
	"NE" => "Niger",
	"NG" => "Nigeria",
	"NU" => "Niue",
	"NF" => "Norfolk Island",
	"MP" => "Northern Mariana Islands",
	"NO" => "Norway",
	"OM" => "Oman",
	"PK" => "Pakistan",
	"PW" => "Palau",
	"PS" => "Palestine",
	"PA" => "Panama",
	"PG" => "Papua New Guinea",
	"PY" => "Paraguay",
	"PE" => "Peru",
	"PH" => "Philippines",
	"PN" => "Pitcairn Islands",
	"PL" => "Poland",
	"PT" => "Portugal",
	"PR" => "Puerto Rico",
	"QA" => "Qatar",
	"RE" => "Réunion",
	"RO" => "Romania",
	"RU" => "Russia",
	"RW" => "Rwanda",
	"SH" => "Saint Helena",
	"KN" => "St Kitts and Nevis",
	"LC" => "Saint Lucia",
	"PM" => "Saint Pierre and Miquelon",
	"VC" => "St Vincent and Grenadines",
	"WS" => "Samoa",
	"SM" => "San Marino",
	"ST" => "São Tomé and Príncipe",
	"SA" => "Saudi Arabia",
	"SN" => "Senegal",
	"CS" => "Serbia and Montenegro",
	"SC" => "Seychelles",
	"SL" => "Sierra Leone",
	"SG" => "Singapore",
	"SK" => "Slovakia",
	"SI" => "Slovenia",
	"SB" => "Solomon Islands",
	"SO" => "Somalia",
	"ZA" => "South Africa",
	"GS" => "South Georgia and the South Sandwich Islands",
	"ES" => "Spain",
	"LK" => "Sri Lanka",
	"SD" => "Sudan",
	"SR" => "Suriname",
	"SJ" => "Svalbard and Jan Mayen",
	"SZ" => "Eswatini",
	"SE" => "Sweden",
	"CH" => "Switzerland",
	"SY" => "Syria",
	"TW" => "Taiwan",
	"TJ" => "Tajikistan",
	"TZ" => "Tanzania",
	"TH" => "Thailand",
	"TL" => "Timor-Leste",
	"TG" => "Togo",
	"TK" => "Tokelau",
	"TO" => "Tonga",
	"TT" => "Trinidad and Tobago",
	"TN" => "Tunisia",
	"TR" => "Türkiye",
	"TM" => "Turkmenistan",
	"TC" => "Turks and Caicos Islands",
	"TV" => "Tuvalu",
	"UG" => "Uganda",
	"UA" => "Ukraine",
	"AE" => "United Arab Emirates",
	"GB" => "United Kingdom",
	"US" => "United States",
	"UM" => "United States Minor Outlying Islands",
	"UY" => "Uruguay",
	"UZ" => "Uzbekistan",
	"VU" => "Vanuatu",
	"VE" => "Venezuela",
	"VN" => "Vietnam",
	"VG" => "British Virgin Islands",
	"VI" => "U.S. Virgin Islands",
	"WF" => "Wallis and Futuna",
	"EH" => "Western Sahara",
	"YE" => "Yemen",
	"ZM" => "Zambia",
	"ZW" => "Zimbabwe"
));
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ultimate-security-for-woocommerce-activator.php
 */
function ultimate_security_for_woocommerce_activate()
{
	require_once ULTIMATE_SECURITY_FOR_WOOCOMMERCE_PATH . 'includes/class-ultimate-security-for-woocommerce-activator.php';
	Ultimate_Security_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ultimate-security-for-woocommerce-deactivator.php
 */
function ultimate_security_for_woocommerce_deactivate()
{
	require_once ULTIMATE_SECURITY_FOR_WOOCOMMERCE_PATH . 'includes/class-ultimate-security-for-woocommerce-deactivator.php';
	Ultimate_Security_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'ultimate_security_for_woocommerce_activate');
register_deactivation_hook(__FILE__, 'ultimate_security_for_woocommerce_deactivate');

// require ULTIMATE_SECURITY_FOR_WOOCOMMERCE_PATH . '/vendor/autoload.php';
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require ULTIMATE_SECURITY_FOR_WOOCOMMERCE_PATH . 'includes/class-ultimate-security-for-woocommerce.php';

if (file_exists(ULTIMATE_SECURITY_FOR_WOOCOMMERCE_PATH . '/vendor/autoload.php')) {
	require_once ULTIMATE_SECURITY_FOR_WOOCOMMERCE_PATH . '/vendor/autoload.php';
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function ultimate_security_for_woocommerce_run()
{

	$plugin = new Ultimate_Security_For_Woocommerce();
	$plugin->run();
}
ultimate_security_for_woocommerce_run();

function ultimate_security_for_woocommerce_get_option()
{
	$ultimate_security_for_woocommerce_options_database = get_option('ultimate_security_for_woocommerce_options', []);
	$ultimate_security_for_woocommerce_options = array_replace_recursive(ultimate_security_for_woocommerce_get_default_options(), $ultimate_security_for_woocommerce_options_database);
	return $ultimate_security_for_woocommerce_options;
}

// var_dump(ultimate_security_for_woocommerce_get_visitor_ip());
function ultimate_security_for_woocommerce_get_visitor_ip()
{
	$ip_address = '';
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip_address = sanitize_text_field(wp_unslash($_SERVER['HTTP_CLIENT_IP']));
	} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip_address = sanitize_text_field(wp_unslash($_SERVER['HTTP_X_FORWARDED_FOR']));
	} else {
		$ip_address = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '';
	}
	if ($ip_address == '127.0.0.1') {
		$response = wp_remote_get('http://www.geoplugin.net/php.gp?ip=');
		if (is_array($response) && ! is_wp_error($response) && isset($response['body'])) {
			$data = unserialize($response['body']);
			$ip_address = isset($data['geoplugin_request']) ? $data['geoplugin_request'] : esc_html('127.0.0.1');
		}
	}
	return $ip_address;
}

// var_dump(ultimate_security_for_woocommerce_get_visitor_country_via_api());
function ultimate_security_for_woocommerce_get_visitor_country_via_api($ip_address = '')
{
	// Get the visitor's IP address.
	$ip_address = $ip_address ? $ip_address : ultimate_security_for_woocommerce_get_visitor_ip();
	$response = wp_remote_get('http://www.geoplugin.net/php.gp?ip=' . esc_html($ip_address));

	if (is_array($response) && ! is_wp_error($response) && $response['body']) {
		$data = unserialize($response['body']);
		return isset($data['geoplugin_countryName']) ? $data['geoplugin_countryName'] : esc_html__('Unknown', 'ultimate-security-for-woocommerce');
	}
}
function ultimate_security_has_woocommerce_pages_accessibility($ip_address = '', $country_code = '')
{

	// Get the visitor's IP address.
	$ip_address = $ip_address ? $ip_address : ultimate_security_for_woocommerce_get_visitor_ip();
	$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();

	if (
		(isset($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['blacklisted-ips']) && $ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['blacklisted-ips'])
		|| (isset($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['blocked-countries-list']) && $ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['blocked-countries-list'])
		|| (isset($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['allow-only-traffic-from-this-country']) && $ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['allow-only-traffic-from-this-country'])
		|| (isset($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['whitelisted-ips']) && $ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['whitelisted-ips'])
	) {
		if (isset($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['blacklisted-ips']) && $ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['blacklisted-ips']) {
			$block_ips_array = array_column(json_decode($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['blacklisted-ips']), 'value');
			if (in_array($ip_address, $block_ips_array)) {
				return false;
			} elseif (isset($ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["blocked-countries-list"]) && $ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["blocked-countries-list"]) {
				return ultimate_security_for_woocommerce_check_block_country_list($ip_address, $country_code);
			} elseif (isset($ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["allow-only-traffic-from-this-country"]) && $ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["allow-only-traffic-from-this-country"]) {
				return ultimate_security_for_woocommerce_check_white_country_list($ip_address, $country_code);
			} elseif (isset($ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["whitelisted-ips"]) && $ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["whitelisted-ips"]) {
				return ultimate_security_for_woocommerce_check_white_ip_list($ip_address, $country_code);
			}
			return true;
		} elseif (isset($ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["blocked-countries-list"]) && $ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["blocked-countries-list"]) {
			return ultimate_security_for_woocommerce_check_block_country_list($ip_address, $country_code);
		} elseif (isset($ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["allow-only-traffic-from-this-country"]) && $ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["allow-only-traffic-from-this-country"]) {
			return ultimate_security_for_woocommerce_check_white_country_list($ip_address, $country_code);
		} elseif (isset($ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["whitelisted-ips"]) && $ultimate_security_for_woocommerce_options["integration"]["security-for-woocommerce"]["whitelisted-ips"]) {
			return ultimate_security_for_woocommerce_check_white_ip_list($ip_address, $country_code);
		}
		return true;
	} else {
		return true;
	}
}
function ultimate_security_for_woocommerce_check_block_country_list($ip_address = '', $country_code = '')
{
	// Get the visitor's IP address.
	$ip_address = $ip_address ? $ip_address : ultimate_security_for_woocommerce_get_visitor_ip();
	$country = $country_code ? $country_code : ultimate_security_for_woocommerce_get_visitor_country_via_api($ip_address);

	$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();

	$countries = array_column(json_decode($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['blocked-countries-list']), 'value');

	if (in_array($country, $countries)) {
		if (isset($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['whitelisted-ips']) && $ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['whitelisted-ips']) {
			return ultimate_security_for_woocommerce_check_white_ip_list($ip_address, $country_code);
		}
		return false;
	}
	return true;
}
function ultimate_security_for_woocommerce_check_white_country_list($ip_address = '', $country_code = '')
{
	// Get the visitor's IP address.
	$ip_address = $ip_address ? $ip_address : ultimate_security_for_woocommerce_get_visitor_ip();
	$country = $country_code ? $country_code : ultimate_security_for_woocommerce_get_visitor_country_via_api($ip_address);
	$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();

	$countries = array_column(json_decode($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['allow-only-traffic-from-this-country']), 'value');
	if (in_array($country, $countries)) {
		if (isset($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['blacklisted-ips']) && $ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['blacklisted-ips']) {
			$block_ips_array = array_column(json_decode($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['blacklisted-ips']), 'value');
			if (in_array($ip_address, $block_ips_array)) {
				return false;
			}
		}
		return true;
	}
	return false;
}
function ultimate_security_for_woocommerce_check_white_ip_list($ip_address = '', $country_code = '')
{
	// Get the visitor's IP address.
	$ip_address = $ip_address ? $ip_address : ultimate_security_for_woocommerce_get_visitor_ip();

	$ultimate_security_for_woocommerce_options = ultimate_security_for_woocommerce_get_option();

	$ips = array_column(json_decode($ultimate_security_for_woocommerce_options['integration']['security-for-woocommerce']['whitelisted-ips']), 'value');
	if (in_array($ip_address, $ips)) {
		return true;
	}
	return false;
}

define('ULTIMATE_SECURITY_FOR_WOOCOMMERCE_IP_LIST', [
	'103.102.221.255' => 'Afghanistan',
	'194.110.191.255' => 'Åland Islands',
	'103.167.235.255' => 'Albania',
	'102.218.191.255' => 'Algeria',
	'103.117.171.255' => 'American Samoa',
	'109.111.127.255' => 'Andorra',
	'102.130.223.255' => 'Angola',
	'104.193.199.255' => 'Anguilla',
	'103.152.127.255' => 'Antarctica',
	'104.255.179.255' => 'Antigua and Barbuda',
	'102.217.237.255' => 'Argentina',
	'109.105.159.255' => 'Armenia',
	'138.255.252.255' => 'Aruba',
	'101.167.175.255' => 'Australia',
	'103.203.183.255' => 'Austria',
	'103.119.111.255' => 'Azerbaijan',
	'129.224.200.255' => 'Bahamas',
	'109.161.255.255' => 'Bahrain',
	'103.100.235.255' => 'Bangladesh',
	'104.153.135.255' => 'Barbados',
	'109.126.191.255' => 'Belarus',
	'103.109.244.255' => 'Belgium',
	'131.161.151.255' => 'Belize',
	'102.214.143.255' => 'Benin',
	'104.218.175.255' => 'Bermuda',
	'103.119.126.255' => 'Bhutan',
	'132.251.255.255' => 'Bolivia',
	'104.239.103.255' => 'Bosnia and Herzegovina',
	'102.134.175.255' => 'Botswana',
	'185.193.124.255' => 'Bouvet Island',
	'103.245.222.255' => 'Brazil',
	'202.44.115.255' => 'British Indian Ocean Territory',
	'103.139.109.255' => 'Brunei',
	'87.120.0.1' => 'Bulgaria',
	'196.28.250.1' => 'Burkina Faso',
	'102.134.111.255' => 'Burundi',
	'103.101.152.255' => 'Cambodia',
	'102.135.189.255' => 'Cameroon',
	'102.129.158.255' => 'Canada',
	'102.209.163.255' => 'Cabo Verde',
	'157.167.118.255' => 'Cayman Islands',
	'196.216.160.255' => 'Central African Republic',
	'102.164.246.255' => 'Chad',
	'104.132.186.255' => 'Chile',
	'101.101.100.255' => 'China',
	'140.248.60.53' => 'Christmas Island',
	'136.23.11.197' => 'Cocos (Keeling) Islands',
	'102.217.238.255' => 'Colombia',
	'102.223.123.255' => 'Comoros',
	'164.160.19.255' => 'Congo Republic',
	'102.213.199.255' => 'DR Congo',
	'116.199.201.255' => 'Cook Islands',
	'102.38.232.255' => 'Costa Rica',
	'102.130.231.255' => 'Ivory Coast',
	'103.225.131.255' => 'Croatia',
	'152.207.255.255' => 'Cuba',
	'109.105.255.255' => 'Cyprus',
	'103.119.108.255' => 'Czechia',
	'103.177.115.255' => 'Denmark',
	'102.214.90.255' => 'Djibouti',
	'104.153.251.255' => 'Dominica',
	'109.110.191.255' => 'Dominican Republic',
	'102.177.175.255' => 'Ecuador',
	'102.128.183.255' => 'Egypt',
	'131.100.143.255' => 'El Salvador',
	'102.164.255.255' => 'Equatorial Guinea',
	'196.200.111.255' => 'Eritrea',
	'103.220.223.255' => 'Estonia',
	'102.208.139.255' => 'Ethiopia',
	'185.244.15.255' => 'Falkland Islands',
	'185.171.175.255' => 'Faroe Islands',
	'103.101.243.255' => 'Fiji',
	'104.132.215.255' => 'Finland',
	'1.179.127.255' => 'France',
	'213.188.163.255' => 'French Guiana',
	'103.129.123.255' => 'French Polynesia',
	'202.22.248.1' => 'French Southern Territories',
	'102.129.35.255' => 'Gabon',
	'102.211.15.255' => 'Gambia',
	'109.172.255.255' => 'Georgia',
	'102.128.165.255' => 'Germany',
	'102.134.131.255' => 'Ghana',
	'104.255.135.255' => 'Gibraltar',
	'103.187.242.255' => 'Greece',
	'157.167.127.255' => 'Greenland',
	'162.245.155.255' => 'Grenada',
	'107.191.223.255' => 'Guadeloupe',
	'103.115.193.255' => 'Guam',
	'138.94.147.255' => 'Guatemala',
	'185.104.203.255' => 'Guernsey',
	'102.176.175.255' => 'Guinea',
	'102.219.175.255' => 'Guinea-Bissau',
	'179.51.205.255' => 'Guyana',
	'148.102.255.255' => 'Haiti',
	'140.248.59.95' => 'Heard and McDonald Islands',
	'212.77.7.255' => 'Vatican City',
	'131.108.235.255' => 'Honduras',
	'101.167.179.255' => 'Hong Kong',
	'109.105.31.255' => 'Hungary',
	'147.28.31.255' => 'Iceland',
	'101.223.255.255' => 'India',
	'101.128.127.255' => 'Indonesia',
	'103.130.144.255' => 'Iran',
	'109.107.155.255' => 'Iraq',
	'103.214.195.255' => 'Ireland',
	'103.214.249.255' => 'Isle of Man',
	'102.128.166.255' => 'Israel',
	'104.132.136.255' => 'Italy',
	'104.152.239.255' => 'Jamaica',
	'101.102.255.255' => 'Japan',
	'165.250.255.255' => 'Jersey',
	'109.107.255.255' => 'Jordan',
	'103.116.199.255' => 'Kazakhstan',
	'102.130.102.255' => 'Kenya',
	'202.58.251.255' => 'Kiribati',
	'175.45.179.255' => 'North Korea',
	'101.101.255.255' => 'South Korea',
	'102.217.239.255' => 'Kuwait',
	'103.195.144.255' => 'Kyrgyzstan',
	'103.109.119.255' => 'Laos',
	'102.38.247.255' => 'Latvia',
	'109.110.127.255' => 'Lebanon',
	'129.232.127.255' => 'Lesotho',
	'102.214.139.255' => 'Liberia',
	'102.164.103.255' => 'Libya',
	'134.238.124.255' => 'Liechtenstein',
	'103.252.111.255' => 'Lithuania',
	'104.244.79.255' => 'Luxembourg',
	'103.115.143.255' => 'Macao',
	'109.121.162.255' => 'North Macedonia',
	'102.211.103.255' => 'Madagascar',
	'102.130.101.255' => 'Malawi',
	'102.211.234.255' => 'Malaysia',
	'103.110.111.255' => 'Maldives',
	'102.130.235.255' => 'Mali',
	'104.243.247.255' => 'Malta',
	'103.202.151.255' => 'Marshall Islands',
	'104.249.191.255' => 'Martinique',
	'102.214.131.255' => 'Mauritania',
	'102.119.255.255' => 'Mauritius',
	'102.135.227.255' => 'Mayotte',
	'104.133.208.255' => 'Mexico',
	'103.166.209.255' => 'Federated States of Micronesia',
	'103.197.151.255' => 'Moldova',
	'134.238.115.255' => 'Monaco',
	'103.126.107.255' => 'Mongolia',
	'209.59.97.255' => 'Montserrat',
	'95.210.47.255' => 'Morocco',
	'98.97.151.255' => 'Mozambique',
	'103.103.173.255' => 'Myanmar',
	'102.209.199.255' => 'Namibia',
	'203.190.216.255' => 'Nauru',
	'103.101.237.255' => 'Nepal',
	'98.71.255.255' => 'The Netherlands',
	'201.216.95.255' => 'Netherlands Antilles',
	'103.105.191.255' => 'New Caledonia',
	'101.100.159.255' => 'New Zealand',
	'138.185.107.255' => 'Nicaragua',
	'102.213.247.255' => 'Niger',
	'102.128.255.255' => 'Nigeria',
	'172.225.244.159' => 'Niue',
	'203.142.221.255' => 'Norfolk Island',
	'103.57.235.255' => 'Northern Mariana Islands',
	'104.132.142.255' => 'Norway',
	'103.194.113.255' => 'Oman',
	'172.69.224.255' => 'Pakistan',
	'103.251.133.255' => 'Palau',
	'213.6.255.255' => 'Palestine',
	'103.173.151.255' => 'Panama',
	'103.100.171.255' => 'Papua New Guinea',
	'131.100.187.255' => 'Paraguay',
	'104.133.255.255' => 'Peru',
	'103.100.101.255' => 'Philippines',
	'206.83.126.255' => 'Pitcairn Islands',
	'103.240.183.255' => 'Poland',
	'103.192.205.255' => 'Portugal',
	'104.218.243.255' => 'Puerto Rico',
	'103.152.175.255' => 'Qatar',
	'102.135.225.255' => 'Réunion',
	'103.112.171.255' => 'Romania',
	'104.109.128.255' => 'Russia',
	'197.243.50.242' => 'Rwanda',
	'194.6.0.69' => 'Saint Helena',
	'104.218.179.255' => 'St Kitts and Nevis',
	'104.218.219.255' => 'Saint Lucia',
	'142.202.131.255' => 'Saint Pierre and Miquelon',
	'104.255.235.255' => 'St Vincent and Grenadines',
	'103.143.149.255' => 'Samoa',
	'109.235.111.255' => 'San Marino',
	'197.159.191.255' => 'São Tomé and Príncipe',
	'212.107.116.238' => 'Saudi Arabia',
	'102.164.191.255' => 'Senegal',
	'192.0.2.152' => 'Serbia and Montenegro',
	'102.141.239.255' => 'Seychelles',
	'102.143.127.255' => 'Sierra Leone',
	'101.100.255.255' => 'Singapore',
	'104.250.187.255' => 'Slovakia',
	'103.225.128.255' => 'Slovenia',
	'103.140.179.255' => 'Solomon Islands',
	'102.128.135.255' => 'Somalia',
	'102.128.163.255' => 'South Africa',
	'185.115.0.1' => 'South Georgia and the South Sandwich Islands',
	'102.177.191.255' => 'Spain',
	'103.138.180.255' => 'Sri Lanka',
	'102.127.255.255' => 'Sudan',
	'138.186.208.255' => 'Suriname',
	'62.16.230.0' => 'Svalbard and Jan Mayen',
	'102.212.228.255' => 'Eswatini',
	'102.177.147.255' => 'Sweden',
	'103.187.243.255' => 'Switzerland',
	'109.238.159.255' => 'Syria',
	'101.139.255.255' => 'Taiwan',
	'109.196.105.255' => 'Tajikistan',
	'102.208.247.255' => 'Tanzania',
	'101.109.255.255' => 'Thailand',
	'103.143.165.255' => 'Timor-Leste',
	'102.164.239.255' => 'Togo',
	'27.96.31.255' => 'Tokelau',
	'103.124.187.255' => 'Tonga',
	'131.100.163.255' => 'Trinidad and Tobago',
	'102.111.255.255' => 'Tunisia',
	'101.44.223.255' => 'Türkiye',
	'185.246.75.255' => 'Turkmenistan',
	'192.203.37.255' => 'Turks and Caicos Islands',
	'202.2.127.255' => 'Tuvalu',
	'102.134.151.255' => 'Uganda',
	'102.217.107.255' => 'Ukraine',
	'103.152.183.255' => 'United Arab Emirates',
	'101.167.187.255' => 'United Kingdom',
	'100.255.255.255' => 'United States',
	'24.155.28.255' => 'United States Minor Outlying Islands',
	'152.156.255.255' => 'Uruguay',
	'109.207.255.255' => 'Uzbekistan',
	'103.101.192.255' => 'Vanuatu',
	'131.221.115.255' => 'Venezuela',
	'102.129.133.255' => 'Vietnam',
	'109.69.59.255' => 'British Virgin Islands',
	'104.192.191.255' => 'U.S. Virgin Islands',
	'103.235.111.255' => 'Wallis and Futuna',
	'41.214.0.1' => 'Western Sahara',
	'109.200.191.255' => 'Yemen',
	'102.130.100.255' => 'Zambia',
	'102.165.115.255' => 'Zimbabwe',
]);
