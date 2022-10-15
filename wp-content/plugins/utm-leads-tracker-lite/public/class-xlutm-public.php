<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class XLUTM_Public {

	protected static $instance = null;
	protected static $params_source;
	protected $params = array();
	protected $is_utm_available = false;
	protected static $cookie_prefix = 'xlutm_params';
	protected $utm_history_count = 5;
	protected static $cookie_first_occurrence = 'first_occurrence';
	public $new_cookie_structure = array();
	public $is_cookie_structure_modified = false;
	public $first_occurrence_cookie_value = null;

	/**
	 * construct
	 */
	public function __construct() {
		$this->hooks();
		self::$params_source = XLUTM_Common::setting_props();
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since  1.0.0
	 * @return object    A single instance of this class.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function hooks() {
		add_action( 'template_redirect', array( $this, 'xlutm_grab_utm_data' ), 11 );
	}

	public function xlutm_grab_utm_data() {
		$this->xlutm_modify_old_cookie();

		if ( is_array( self::$params_source ) && count( self::$params_source ) > 0 ) {
			foreach ( self::$params_source as $group => $group_data ) {
				if ( isset( $group_data['keys'] ) && is_array( $group_data['keys'] ) && count( $group_data['keys'] ) > 0 ) {
					$method   = 'get';
					$restrict = false;
					if ( isset( $group_data['method'] ) && '' != $group_data['method'] ) {
						$method = $group_data['method'];
					}
					if ( isset( $group_data['rule'] ) ) {
						$restrict = $group_data['rule'];
					}
					foreach ( $group_data['keys'] as $key => $name ) {
						if ( $this->xlutm_check_query_param( $key, $method, $group, $restrict ) ) {
							$this->is_utm_available = true;
						}
					}
				}
			}

			if ( $this->is_utm_available && is_array( $this->params ) && count( $this->params ) > 0 ) {
				$current_time = time();
				foreach ( $this->params as $group => $group_data ) {
					$final_cookie_val = array();
					$cookie_name      = self::$cookie_prefix . '_' . sanitize_title( $group );
					$cookie_val_old   = self::xlutm_read_query_param( $cookie_name );
					if ( ( is_array( $cookie_val_old ) && count( $cookie_val_old ) > 0 ) ) {
						// cookie has value
						if ( isset( $cookie_val_old['utm_campaign'] ) || isset( $cookie_val_old['HTTP_REFERER'] ) ) {
							// old scenario
							$final_cookie_val[ ( (int) $current_time - DAY_IN_SECONDS ) ] = $cookie_val_old;
						} else {
							// new scenario
							$final_cookie_val = $cookie_val_old;
						}
						$final_cookie_val[ $current_time ] = $group_data;
					} else {
						// cookie don't have value
						$final_cookie_val[ $current_time ] = $group_data;
					}

					$this->utm_history_count = apply_filters( 'xlutm_modify_cookie_count', $this->utm_history_count );
					if ( 0 == $this->utm_history_count ) {
						$this->utm_history_count = 1;
					}

					krsort( $final_cookie_val );
					if ( count( $final_cookie_val ) > $this->utm_history_count ) {
						array_pop( $final_cookie_val );
					}

					$cookie_val = json_encode( $final_cookie_val );
					$secure     = is_ssl();
					setcookie( $cookie_name, $cookie_val, time() + YEAR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, $secure, true );
				}
			}

			$this->xlutm_first_occurrence();
		}
	}

	public function xlutm_grab_change_cookie_count( $cookie_count ) {
		if ( '' != $cookie_count ) {
			return $cookie_count;
		}

		return $cookie_count;
	}

	/**
	 * Checking if query param exist and has value
	 * If has then assign
	 *
	 * @param  type $param
	 * @param  type $method
	 *
	 * @return boolean
	 */
	public function xlutm_check_query_param( $param, $method = 'get', $group, $rule ) {
		if ( false !== $rule ) {
			if ( isset( $rule['type'] ) && 'referer' == $rule['type'] ) {
				$server_name = $_SERVER['SERVER_NAME'];
				if ( isset( $_SERVER[ $param ] ) && '' != $_SERVER[ $param ] ) {
					if ( strpos( $_SERVER[ $param ], $server_name ) !== false ) {
						return false;
					}
				}
			}
		}
		if ( 'get' == $method ) {
			if ( isset( $_GET[ $param ] ) && '' != $_GET[ $param ] ) {
				$this->xlutm_assign_query_param( $param, $_GET[ $param ], $group );

				return true;
			}
		} elseif ( 'server' == $method ) {
			if ( isset( $_SERVER[ $param ] ) && '' != $_SERVER[ $param ] ) {
				$this->xlutm_assign_query_param( $param, $_SERVER[ $param ], $group );

				return true;
			}
		}

		return false;
	}

	public function xlutm_assign_query_param( $param, $value, $group ) {
		if ( empty( $param ) || empty( $value ) ) {
			return;
		}
		$this->params[ $group ][ $param ] = $value;
	}

	public static function xlutm_read_query_param( $cookie_name, $key = '' ) {
		if ( isset( $_COOKIE[ $cookie_name ] ) ) {
			$cookie_val = json_decode( stripslashes( $_COOKIE[ $cookie_name ] ), true );
			if ( ! empty( $key ) && isset( $cookie_val[ $key ] ) ) {
				return $cookie_val[ $key ];
			}

			return $cookie_val;
		}

		return false;
	}

	public static function get_params_source() {
		return self::$params_source;
	}

	public static function get_cookie_prefix() {
		return self::$cookie_prefix;
	}

	public static function get_cookie_first_occurrence() {
		return self::$cookie_first_occurrence;
	}

	public function xlutm_modify_old_cookie() {
		// for modifying already saved cookie structure to new structure
		if ( is_array( self::$params_source ) && count( self::$params_source ) > 0 ) {
			$current_time = time();
			foreach ( self::$params_source as $group => $group_data ) {
				$final_cookie_val = array();
				$cookie_name      = self::$cookie_prefix . '_' . sanitize_title( $group );
				$cookie_val_old   = self::xlutm_read_query_param( $cookie_name );
				if ( is_array( $cookie_val_old ) && count( $cookie_val_old ) > 0 ) {
					$group_keys  = $group_data['keys'];
					$xlutm_array = array();
					foreach ( $group_keys as $key1 => $value1 ) {
						if ( isset( $cookie_val_old[ $key1 ] ) ) {
							$xlutm_array[ $key1 ] = $cookie_val_old[ $key1 ];
						}
					}
					if ( is_array( $xlutm_array ) && count( $xlutm_array ) > 0 ) {
						$final_cookie_val[ ( (int) $current_time - DAY_IN_SECONDS ) ] = $xlutm_array;
						$cookie_val                                                   = json_encode( $final_cookie_val );
						$secure                                                       = is_ssl();
						setcookie( $cookie_name, $cookie_val, time() + YEAR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, $secure, true );
						$this->new_cookie_structure[ $cookie_name ] = $final_cookie_val;
						$this->is_cookie_structure_modified         = true;
					}
				}
			}
		}
	}

	public function xlutm_first_occurrence() {
		$cookie_name_first_occurrence = self::$cookie_prefix . '_' . self::$cookie_first_occurrence;
		if ( is_array( self::$params_source ) && count( self::$params_source ) > 0 ) {
			$all_timestamps = array();
			$cookie_val_old = self::xlutm_read_query_param( $cookie_name_first_occurrence );

			if ( is_array( $cookie_val_old ) && count( $cookie_val_old ) > 0 ) {
				if ( isset( $cookie_val_old['timestamp'] ) ) {
					if ( ! is_numeric( $cookie_val_old['timestamp'] ) ) {
						$cookie_val_old = array();
					}
				}
			}

			if ( is_array( $cookie_val_old ) && count( $cookie_val_old ) > 0 ) {
				// Do Nothing, first occurrence cookie is already saved

			} else {
				foreach ( self::$params_source as $group => $group_data ) {
					$cookie_name = self::$cookie_prefix . '_' . sanitize_title( $group );
					if ( $this->is_cookie_structure_modified ) {
						$cookie_val_old = $this->new_cookie_structure[ $cookie_name ];
					} else {
						$cookie_val_old = self::xlutm_read_query_param( $cookie_name );
					}
					if ( is_array( $cookie_val_old ) && count( $cookie_val_old ) > 0 ) {
						foreach ( $cookie_val_old as $timestamp => $cookie_val ) {
							$all_timestamps[] = $timestamp;
						}
					}
				}
				if ( is_array( $all_timestamps ) && count( $all_timestamps ) > 0 ) {
					$first_occurrence_timestamp = min( $all_timestamps );
					$cookie_val                 = json_encode( array( 'timestamp' => $first_occurrence_timestamp ) );
					$secure                     = is_ssl();
					setcookie( $cookie_name_first_occurrence, $cookie_val, time() + YEAR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, $secure, true );
					$this->first_occurrence_cookie_value = $cookie_val;
				} else {
					$first_occurrence_timestamp = time();
					$cookie_val                 = json_encode( array( 'timestamp' => $first_occurrence_timestamp ) );
					$secure                     = is_ssl();
					setcookie( $cookie_name_first_occurrence, $cookie_val, time() + YEAR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, $secure, true );
					$this->first_occurrence_cookie_value = $cookie_val;
				}
			}
		}
	}

}

XLUTM_Public::get_instance();
