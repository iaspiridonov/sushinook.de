<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class XLUTM_Admin {

	protected static $instance = null;

	public function __construct() {
		$this->hooks();
	}

	/**
	 * Return an instance of this class.
	 * @since     1.0.0
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'xlutm_admin_enqueue_scripts' ), 11 );
	}

	/**
	 * Get Admin path
	 * @return string plugin admin path
	 */
	public function get_admin_url() {
		return plugin_dir_url( XLUTM_PLUGIN_FILE ) . 'admin';
	}

	public function xlutm_admin_enqueue_scripts() {
		wp_enqueue_style( 'xlutm-admin', $this->get_admin_url() . '/assets/css/xlutm-admin.css', false, time() );
	}

}

XLUTM_Admin::get_instance();
