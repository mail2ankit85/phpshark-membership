<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://thenorthernrhino.in/author/admin/
 * @since      1.0.0
 *
 * @package    Phpshark_Membership
 * @subpackage Phpshark_Membership/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Phpshark_Membership
 * @subpackage Phpshark_Membership/includes
 * @author     Ankit Kumar <mail2ankit85@gmail.com>
 */
class Phpshark_Membership {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Phpshark_Membership_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PHPSHARK_MEMBERSHIP_VERSION' ) ) {
			$this->version = PHPSHARK_MEMBERSHIP_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'phpshark-membership';

		add_action('init',[$this, 'StartSession'], 1);
		add_action('wp_logout',[$this, 'endSession']);
		add_action('wp_login',[$this, 'endSession']);
		add_action('end_session_action',[$this, 'endSession']);
		add_action('init', [$this,'remove_default_redirect']);
		add_filter('auth_redirect_scheme', [$this,'stop_redirect'], 9999);
		add_action( 'admin_init', [$this,'restrict_admin_with_redirect'], 1 );

		add_action('init',[$this,'redirect_login_page']);
		add_action('wp_logout',[$this,'logout_redirect']);
		add_filter('authenticate', [$this,'verify_user_pass'], 1, 3);
		add_action('wp_login_failed', [$this,'custom_login_failed']);

		add_shortcode('PHPS-login', [$this,'shortcode_login']);
		add_shortcode('PHPS-register', [$this,'shortcode_register']);
		add_shortcode('PHPS-forgot-password', [$this,'shortcode_forgot_password']);
		add_shortcode('PHPS-subscribe', [$this,'shortcode_subscribe']);
	
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->final_run();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Phpshark_Membership_Loader. Orchestrates the hooks of the plugin.
	 * - Phpshark_Membership_i18n. Defines internationalization functionality.
	 * - Phpshark_Membership_Admin. Defines all hooks for the admin area.
	 * - Phpshark_Membership_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once PHPS_PLUGBASE . PHPS_INCLUDES . 'class-phpshark-membership-loader.php';

		/** 
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once PHPS_PLUGBASE . PHPS_INCLUDES . 'class-phpshark-membership-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once PHPS_PLUGBASE . PHPS_ADMIN . 'class-phpshark-membership-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once PHPS_PLUGBASE . PHPS_THEME . 'class-phpshark-membership-theme.php';

		/**
		 * The class is the final public / admin section
		 */
		require_once PHPS_PLUGBASE . PHPS_INCLUDES . 'class-phpshark-membership-admin.php';
		require_once PHPS_PLUGBASE . PHPS_INCLUDES . 'class-phpshark-membership-theme.php';

		$this->loader = new Phpshark_Membership_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Phpshark_Membership_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Phpshark_Membership_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Phpshark_Membership_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Phpshark_Membership_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Phpshark_Membership_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function final_run(){
		$admin_pages = new \app\admin\Pages;
		$public_pages = new \app\theme\Pages;
	}

	public function StartSession() {
		if(!session_id()) {
			session_start();
		}
	}

	public function endSession() {
	  	session_destroy ();
	}

	public function stop_redirect($scheme){
		if ( $user_id = wp_validate_auth_cookie( '',  $scheme) ) {
			return $scheme;
		}
	
		global $wp_query;
		$wp_query->set_404();
		get_template_part( 404 );
		exit();
	}
	
	public function remove_default_redirect(){
		remove_action('template_redirect', 'wp_redirect_admin_locations', 1000);
	}
	
	/**
	 * Restrict access to the administration screens.
	 *
	 * Only administrators will be allowed to access the admin screens,
	 * all other users will be automatically redirected to
	 * 'example.com/path/to/location' instead.
	 *
	 * We do allow access for Ajax requests though, since these may be
	 * initiated from the front end of the site by non-admin users.
	 */
	public function restrict_admin_with_redirect() {
		if ( ! current_user_can( 'manage_options' ) && ( ! wp_doing_ajax() ) ) {
			// Replace this with the URL to redirect to.
			wp_safe_redirect( site_url('member/admin') ); 
			exit;
		}
	}


	/* Main redirection of the default login page */
	public function redirect_login_page() {
		$login_page = site_url('login');
		$page_viewed = basename($_SERVER['REQUEST_URI']);

		if($page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
			wp_redirect($login_page);
			exit;
		}
	}

	/* Where to go if a login failed */
	public function custom_login_failed() {
		$login_page = home_url('login');
		wp_redirect($login_page . '?login=failed');
		exit;
	}

	/* Where to go if any of the fields were empty */
	public function verify_user_pass($user, $username, $password) {
		$login_page = home_url('login');
		if($username == "" || $password == "") {
		wp_redirect($login_page . "?login=empty");
		exit;
		}
	}

	/* What to do on logout */
	public function logout_redirect() {
		$login_page = home_url('login');
		wp_redirect($login_page . "?login=false");
		exit;
	}

	public function shortcode_login(){
		include_once (PHPS_PLUGBASE . PHPS_THEME . PHPS_COMPONENTS . 'shortcode-btn-login.php');
	}

	public function shortcode_register(){
		include_once (PHPS_PLUGBASE . PHPS_THEME . PHPS_COMPONENTS . 'shortcode-btn-register.php');
	}

	public function shortcode_forgot_password(){
		include_once (PHPS_PLUGBASE . PHPS_THEME . PHPS_COMPONENTS . 'shortcode-btn-forgot.php');
	}

	public function shortcode_subscribe(){
		include_once (PHPS_PLUGBASE . PHPS_THEME . PHPS_COMPONENTS . 'shortcode-form-subscribe.php');
	}
}
