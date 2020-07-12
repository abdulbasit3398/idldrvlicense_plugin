<?php

class Idldrvlicense {

	protected $loader;
	protected $plugin_name;
	protected $version;

	public function __construct() {
		if ( defined( 'IDLDRVLICENSE_VERSION' ) ) {
			$this->version = IDLDRVLICENSE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'idldrvlicense';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-idldrvlicense-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-idldrvlicense-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-idldrvlicense-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-idldrvlicense-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-table-example.php';

		$this->loader = new Idldrvlicense_Loader();

	}

	private function set_locale() {

		$plugin_i18n = new Idldrvlicense_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function define_admin_hooks() {

		$plugin_admin = new Idldrvlicense_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'idl_license_cities_menu' );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'idl_lisenceforms_register_settings');

	}

	private function define_public_hooks() {

		$plugin_public = new Idldrvlicense_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_shortcode( 'idl_licenseform', $plugin_public, 'loadlicenseform', 1 );
		$this->loader->add_action( 'wp_ajax_savelicense', $plugin_public , 'savelicense' );
		$this->loader->add_action( 'wp_ajax_nopriv_savelicense', $plugin_public , 'savelicense' );
		$this->loader->add_action( 'wp_ajax_paynow', $plugin_public , 'paynow' );
		$this->loader->add_action( 'wp_ajax_nopriv_paynow', $plugin_public , 'paynow' );
		$this->loader->add_action( 'init', $plugin_public, 'molliewebhook');

	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}
