<?php

/**
 * Fired during plugin activation
 *
 * @link       https://thenorthernrhino.in/author/admin/
 * @since      1.0.0
 *
 * @package    Phpshark_Membership
 * @subpackage Phpshark_Membership/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Phpshark_Membership
 * @subpackage Phpshark_Membership/includes
 * @author     Ankit Kumar <mail2ankit85@gmail.com>
 */
class Phpshark_Membership_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::validate_before_activation();
		self::subscription_queries();
	}

	private static function subscription_queries(){

		global $wpdb;

		$sql1 = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}msg_header (
						email VARCHAR(200) NOT NULL,
						confirmed CHAR NULL,
						firstname VARCHAR(20) NULL,
						lastname VARCHAR(20) NULL,
						phone VARCHAR(20) NULL,
						token VARCHAR(255) NULL,
						PRIMARY KEY (email))";

		$wpdb->query($sql1);

		$sql2 = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}msg_item (
					  msg_ID BIGINT(20) NOT NULL AUTO_INCREMENT,
					  subject_text VARCHAR(250) NULL,
					  query_text TEXT NULL,
					  email VARCHAR(200) NULL,
					  response TEXT NULL,
					  reference TEXT NULL,
					  PRIMARY KEY (msg_ID))";

		$wpdb->query($sql2);

		$sql3 = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}subscription (
					email VARCHAR(200) NULL,
					PRIMARY KEY (email))";

		$wpdb->query($sql3);
	}

	private function validate_before_activation(){
		/**
		 * Detect plugin. For use on Front End only.
		 */
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		// //replace this with your dependent plugin
		$category_ext = 'phpshark-plugin/phpshark-plugin.php';
		$category_error = false;

		if(!is_plugin_active($category_ext)){
			$category_error = true;
		} else{
			$category_error = false;
		}  

		if ( !$category_error ) {
			echo '<h3>'.__('This plugin depends upon PHPShark Plugin. Please install and activate the plugin before this or it will throw some serious errors', 'ap').'</h3>';

			//Adding @ before will prevent XDebug output
			@trigger_error(__('This plugin depends upon PHPShark Plugin.', 'ap'), E_USER_ERROR);
			exit;
		}
	}
}
