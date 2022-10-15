<?php

/**
 * Plugin Name: UTM Leads Tracker - XLPlugins
 * Plugin URI: https://xlplugins.com/
 * Description: Discover which marketing campaigns are actually profitable and which are wasting your time & money. Works with multiple services like EDD, WC, GForm etc.
 * Version: 1.2.0
 * Author: XLPlugins
 * Author URI: https://www.xlplugins.com
 * License: GPLv3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: utm-leads-tracker-lite
 *
 * UTM Leads Tracker - XLPlugins is free software.
 * You can redistribute it and/or modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * UTM Leads Tracker - XLPlugins is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with UTM Leads Tracker - XLPlugins. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package UTM Leads Tracker
 * @Category Core
 * @author XLPlugins
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Xlutm_Core' ) ) :

	class Xlutm_Core {

		/**
		 * @var Xlutm_Core
		 */
		public static $_instance = null;

		public function __construct() {

			/**
			 * Load important variables and constants
			 */
			$this->define_plugin_properties();

			/**
			 * Loads activation hooks
			 */
			$this->maybe_load_activation();
			/**
			 * Loads deactivation hooks
			 */
			$this->maybe_load_deactivation();
			/**
			 * Loads all the hooks
			 */
			$this->load_hooks();
		}

		public function define_plugin_properties() {
			/*             * ****** DEFINING CONSTANTS ********* */
			define( 'XLUTM_VERSION', '1.2.0' );
			define( 'XLUTM_TEXTDOMAIN', 'utm-leads-tracker' );
			define( 'XLUTM_NAME', 'UTM Leads Tracker' );
			define( 'XLUTM_PLUGIN_FILE', __FILE__ );
			define( 'XLUTM_PLUGIN_DIR', __DIR__ );
			define( 'XLUTM_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			define( 'XLUTM_SHORT_SLUG', 'xlutm' );
		}

		public function load_hooks() {
			/** Initializing Functionality */
			add_action( 'plugins_loaded', array( $this, 'xlutm_init' ), 0 );

			/** Initialize Localization */
			add_action( 'init', array( $this, 'xlutm_init_localization' ) );

			/** Redirecting Plugin to the settings page after activation */
			add_action( 'activated_plugin', array( $this, 'xlutm_settings_redirect' ) );
		}

		/**
		 * @return null|Xlutm_Core
		 */
		public static function get_instance() {
			if ( null == self::$_instance ) {
				self::$_instance = new self;
			}

			return self::$_instance;
		}

		/**
		 * Checking WooCommerce dependency and then loads further
		 * @return bool false on failure
		 */
		public function xlutm_init() {
			// common code can come here
			require 'includes/class-xlutm-services.php';
			require 'includes/class-xlutm-common.php';

			if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
				// admin
				require 'admin/class-xlutm-admin.php';
			} else {
				// public
			}
			require 'public/class-xlutm-public.php';
		}

		/**
		 * Added redirection on plugin activation
		 *
		 * @param $plugin
		 */
		public function xlutm_settings_redirect( $plugin ) {
			if ( plugin_basename( __FILE__ ) == $plugin ) {
				// redirect to plugin settings page if available
			}
		}

		public function maybe_load_activation() {
			/** Hooking action to the activation */
			register_activation_hook( __FILE__, array( $this, 'xlutm_activation' ) );
		}

		public function maybe_load_deactivation() {
			register_deactivation_hook( __FILE__, array( $this, 'xlutm_deactivation' ) );
		}

		/** Triggering activation initialization */
		public function xlutm_activation() {
			global $wpdb;
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

			$collate = '';
			if ( $wpdb->has_cap( 'collation' ) ) {
				$collate = $wpdb->get_charset_collate();
			}
			$sql = "CREATE TABLE `{$wpdb->prefix}xlutm` (
                `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                `type` varchar(50) NOT NULL,
                `refid` bigint(20) UNSIGNED NOT NULL,
                `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                `ip` varchar(80) NOT NULL,
                PRIMARY KEY (id)) {$collate};";
			dbDelta( $sql );

			$sql = "CREATE TABLE `{$wpdb->prefix}xlutmmeta` (
                `meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
                `xlutm_id` bigint(20) NOT NULL,
                `meta_key` varchar(255) NOT NULL,
                `meta_value` longtext NOT NULL,
                PRIMARY KEY (meta_id)) {$collate};";
			dbDelta( $sql );
		}

		/** Triggering deactivation initialization */
		public function xlutm_deactivation() {

		}

		public function xlutm_init_localization() {
			load_plugin_textdomain( XLUTM_TEXTDOMAIN, false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
		}

	}

endif;


if ( ! function_exists( 'Xlutm_Core' ) ) {

	/**
	 * Global Common function to load all the classes
	 *
	 * @param bool $debug
	 *
	 * @return Xlutm_Core
	 */
	function xlutm_core() {
		return Xlutm_Core::get_instance();
	}
}


$GLOBALS['Xlutm_Core'] = xlutm_core();
