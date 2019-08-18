<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://thenorthernrhino.in/author/admin/
 * @since             1.0.0
 * @package           Phpshark_Membership
 *
 * @wordpress-plugin
 * Plugin Name:       PHPShark-Membership
 * Plugin URI:        https://thenorthernrhino.in/author/admin/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Ankit Kumar
 * Author URI:        https://thenorthernrhino.in/author/admin/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       phpshark-membership
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die; 
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PHPSHARK_MEMBERSHIP_VERSION', '1.0.0' );
defined("DS") || define('DS', DIRECTORY_SEPARATOR);
defined("PHPS_PLUGBASE") || define('PHPS_PLUGBASE', plugin_dir_path(__FILE__ ));
defined("PHPS_TEMPLATES") || define('PHPS_TEMPLATES', 'templates'.DS);
defined("PHPS_INCLUDES") || define('PHPS_INCLUDES', 'includes'.DS);
defined("PHPS_PARTIALS") || define('PHPS_PARTIALS', 'partials'.DS);
defined("PHPS_COMPONENTS") || define('PHPS_COMPONENTS', PHPS_PARTIALS.'components'.DS);
defined("PHPS_PARTS") || define('PHPS_PARTS', 'parts'.DS);
defined("PHPS_THEME") || define('PHPS_THEME', 'theme'.DS);
defined("PHPS_ADMIN") || define('PHPS_ADMIN', 'admin'.DS);
defined("PHPS_APP") || define('PHPS_APP', 'app'.DS);

/** 
 * The code that runs during plugin activation.
 * This action is documented in includes/class-phpshark-membership-activator.php
 */
function activate_phpshark_membership() {
	require_once PHPS_PLUGBASE .  PHPS_INCLUDES . 'class-phpshark-membership-activator.php';
	Phpshark_Membership_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-phpshark-membership-deactivator.php
 */
function deactivate_phpshark_membership() {
	require_once PHPS_PLUGBASE . PHPS_INCLUDES . 'class-phpshark-membership-deactivator.php';
	Phpshark_Membership_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_phpshark_membership' );
register_deactivation_hook( __FILE__, 'deactivate_phpshark_membership' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require PHPS_PLUGBASE .  PHPS_INCLUDES . 'class-phpshark-membership.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_phpshark_membership() {

	$plugin = new Phpshark_Membership();
	$plugin->run();

}
run_phpshark_membership();
