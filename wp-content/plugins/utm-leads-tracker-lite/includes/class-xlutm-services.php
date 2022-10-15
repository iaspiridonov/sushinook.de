<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class XLUTM_Services {

	public function __construct() {
		global $wpdb;
		$wpdb->xlutm     = $wpdb->prefix . 'xlutm';
		$wpdb->xlutmmeta = $wpdb->prefix . 'xlutmmeta';
	}

	public function insert_info( $type, $refid = 0, $timestamp ) {
		global $wpdb;
		$wpdb->insert( "{$wpdb->prefix}xlutm", array(
			'type'  => $type,
			'refid' => $refid,
			//          'date'  => date_i18n( 'Y-m-d H:i:s', $timestamp ),
			'date'  => date( 'Y-m-d H:i:s', $timestamp ),
			'ip'    => $_SERVER['REMOTE_ADDR'],
		), array( '%s', '%d', '%s', '%s' ) );

		return $wpdb->insert_id;
		exit;
	}

	public function update_info( $id, $key, $value, $format = '%d' ) {
		global $wpdb;
		if ( empty( $id ) || empty( $key ) || empty( $value ) ) {
			return false;
		}
		$wpdb->update( "{$wpdb->prefix}xlutm", array( $key => $value ), array( 'ID' => $id ), array( $format ), array( '%d' ) );

		return $wpdb->insert_id;
	}

	public function get_info_by( $type, $col = 'id', $value = '', $get = '*', $order_by = 'date' ) {
		global $wpdb;
		if ( empty( $value ) ) {
			return false;
		}
		$result       = $wpdb->get_results( $wpdb->prepare( "SELECT {$get} FROM {$wpdb->prefix}xlutm WHERE `{$col}` = %s AND `type` = %s ORDER BY `{$order_by}` DESC", $value, $type ), ARRAY_A );
		$final_result = array();
		if ( is_array( $result ) && count( $result ) > 0 ) {
			foreach ( $result as $key1 => $value1 ) {
				$final_result[] = $value1;
			}

			return $final_result;
		}

		return false;
	}

	public function xlutm_get_data( $table_name, $get, $where_condition = '', $order_by_column = '', $order_by = '' ) {
		global $wpdb;
		$sql = "SELECT $get FROM $table_name";
		if ( '' !== $where_condition ) {
			$parameters   = $where_condition[1];
			$sql          .= " WHERE $where_condition[0] ";
			$sql_prepared = $wpdb->prepare( $sql, $parameters );
			$sql          = $sql_prepared;
		}
		if ( '' !== $order_by_column ) {
			$sql .= " ORDER BY $order_by_column";
		}
		if ( '' !== $order_by ) {
			$sql .= " $order_by";
		}

		$result       = $wpdb->get_results( $sql, ARRAY_A );
		$final_result = array();
		if ( is_array( $result ) && count( $result ) > 0 ) {
			foreach ( $result as $key1 => $value1 ) {
				$final_result[] = $value1;
			}

			return $final_result;
		}

		return false;
	}

	public function exclude_underscore_meta_fields( $array = array() ) {
		if ( count( $array ) > 0 ) {
			foreach ( $array as $key => $value ) {
				if ( '_' == $key[0] ) {
					unset( $array[ $key ] );
				}
			}
			if ( count( $array ) > 0 ) {
				return $array;
			}
		}

		return false;
	}

	public function xlutm_get_defined_source_name() {
		$return_array   = array();
		$defined_source = XLUTM_Common::setting_props();
		if ( is_array( $defined_source ) && count( $defined_source ) > 0 ) {
			foreach ( $defined_source as $group => $group_data ) {
				if ( isset( $group_data['keys'] ) && is_array( $group_data['keys'] ) && count( $group_data['keys'] ) > 0 ) {
					foreach ( $group_data['keys'] as $key => $name ) {
						$return_array[ $key ] = $name;
					}
				}
			}
		}

		return $return_array;
	}

	public function xlutm_get_view( $metadata, $payment_id ) {
		do_action( 'xlutm_stats_view_before', $payment_id );
		$param_source_names = $this->xlutm_get_defined_source_name();
		$xlutm_html         = '';
		$time               = '';
		foreach ( $metadata as $key => $val ) {
			$key_label = strtolower( $key );
			if ( isset( $param_source_names[ $key ] ) && ! empty( $param_source_names[ $key ] ) ) {
				$key_label = $param_source_names[ $key ];
			}
			if ( 'utm_timestamp' == $key ) {
				continue;
			}
			ob_start();
			echo "<tr><td>{$key_label}</td><td>{$val[0]}</td></tr>";
			$xlutm_html .= ob_get_clean();
		}
		?>
        <table class="xlutm_table_view">
			<?php echo $xlutm_html; ?>
        </table>
		<?php
		do_action( 'xlutm_stats_view_after', $payment_id );
	}

	public function get_metabox_title() {
		return __( 'XL UTM Stats', 'xlutm' );
	}

	public function insert_utm_details( $service_type, $order_id ) {
		$public_class_object          = XLUTM_Public::get_instance();
		$cookie_name_first_occurrence = XLUTM_Public::get_cookie_prefix() . '_' . XLUTM_Public::get_cookie_first_occurrence();
		$defined_source               = XLUTM_Public::get_params_source();
		if ( is_array( $defined_source ) && count( $defined_source ) > 0 ) {
			foreach ( $defined_source as $group => $group_data ) {
				$cookie_name = XLUTM_Public::get_cookie_prefix() . '_' . sanitize_title( $group );
				$cookie_val  = XLUTM_Public::xlutm_read_query_param( $cookie_name );
				update_post_meta( $order_id, 'before_order_cookie_' . $cookie_name, $cookie_val );
				if ( isset( $cookie_val['utm_campaign'] ) || isset( $cookie_val['HTTP_REFERER'] ) ) {
					$public_class_object->xlutm_modify_old_cookie();
					if ( $public_class_object->is_cookie_structure_modified ) {
						$cookie_val = $public_class_object->new_cookie_structure[ $cookie_name ];
					}
				}
				if ( is_array( $cookie_val ) && count( $cookie_val ) > 0 ) {
					foreach ( $cookie_val as $key1 => $value1 ) {
						$new_id = $this->insert_info( $service_type, $order_id, $key1 );
						$this->insert_utm_meta( $new_id, $value1 );
					}
				}
				update_post_meta( $order_id, 'after_order_cookie_' . $cookie_name, $cookie_val );
			}
		}

		$cookie_val = XLUTM_Public::xlutm_read_query_param( $cookie_name_first_occurrence );
		if ( is_array( $cookie_val ) && count( $cookie_val ) > 0 && is_numeric( $cookie_val['timestamp'] ) ) {
			// Do nothing, first occurrence cookie is saved correctly
		} else {
			$public_class_object->xlutm_first_occurrence();
			$cookie_val = (array) json_decode( $public_class_object->first_occurrence_cookie_value );
		}

		if ( '' != $cookie_val && is_numeric( $cookie_val['timestamp'] ) ) {
			update_post_meta( $order_id, 'first_occurrence_timestamp_start', $cookie_val['timestamp'] );
			update_post_meta( $order_id, 'first_occurrence_timestamp_end', time() );
		}
	}

	public function insert_utm_meta( $xlutm_id, $cookie_val ) {
		if ( is_array( $cookie_val ) && count( $cookie_val ) > 0 ) {
			foreach ( $cookie_val as $key1 => $value1 ) {
				update_metadata( 'xlutm', $xlutm_id, $key1, $value1 );
			}
		}
	}

	public function xlutm_get_lead_conversion_time( $post_id ) {
		$first_occurrence_timestamp_start = get_post_meta( $post_id, 'first_occurrence_timestamp_start', true );
		$first_occurrence_timestamp_end   = get_post_meta( $post_id, 'first_occurrence_timestamp_end', true );
		if ( '' != $first_occurrence_timestamp_start && '' != $first_occurrence_timestamp_end ) {
			$datetime1    = new DateTime( date( 'Y-m-d H:i:s', $first_occurrence_timestamp_start ) );//start time
			$datetime2    = new DateTime( date( 'Y-m-d H:i:s', $first_occurrence_timestamp_end ) );//end time
			$interval     = $datetime1->diff( $datetime2 );
			$years        = $interval->format( '%Y' );
			$months       = $interval->format( '%m' );
			$days         = $interval->format( '%d' );
			$hours        = $interval->format( '%h' );
			$minutes      = $interval->format( '%i' );
			$seconds      = $interval->format( '%s' );
			$time_to_show = '';
			if ( $years > 0 && $years < 2 ) {
				$time_to_show .= $years . ' yr ';
			}
			if ( $years > 2 ) {
				$time_to_show .= $years . ' yrs ';
			}
			if ( $months > 0 && $months < 2 ) {
				$time_to_show .= $months . ' month ';
			}
			if ( $months > 2 ) {
				$time_to_show .= $months . ' months ';
			}
			if ( $days > 0 && $days < 2 ) {
				$time_to_show .= $days . ' day ';
			}
			if ( $days > 2 ) {
				$time_to_show .= $days . ' days ';
			}
			if ( $hours > 0 && $hours < 2 ) {
				$time_to_show .= $hours . ' hr ';
			}
			if ( $hours > 2 ) {
				$time_to_show .= $hours . ' hrs ';
			}
			if ( $minutes > 0 && $minutes < 2 ) {
				$time_to_show .= $minutes . ' min ';
			}
			if ( $minutes > 2 ) {
				$time_to_show .= $minutes . ' mins ';
			}
			if ( $seconds > 0 && $seconds < 2 ) {
				$time_to_show .= $seconds . ' sec ';
			}
			if ( $seconds > 2 ) {
				$time_to_show .= $seconds . ' secs ';
			}

			return $time_to_show;
		}

		return false;
	}

	public function xlutm_show_start_time( $post_id, $date_object ) {
		$first_occurrence_timestamp_start = get_post_meta( $post_id, 'first_occurrence_timestamp_start', true );
		if ( '' != $first_occurrence_timestamp_start ) {
			$date_format = get_option( 'date_format' );
			$time_format = get_option( 'time_format' );
			$date_object->setTimestamp( $first_occurrence_timestamp_start );

			return $date_object->format( $date_format . ' ' . $time_format );
		} else {
			return '';
		}
	}

	public function xlutm_show_timeline( $timeline_array, $date ) {
		if ( is_array( $timeline_array ) && count( $timeline_array ) > 0 ) {
			$time_format = get_option( 'time_format' );
			$date        = new DateTime();
			$count       = 1;
			?>
            <ul class="xlutm-timeline">
				<?php
				foreach ( $timeline_array as $date_val => $time_arr ) {
					echo '<li class="xlutm-center"><div class="tldate">' . $date_val . '</div></li>';
					if ( is_array( $time_arr ) && count( $time_arr ) > 0 ) {
						foreach ( $time_arr as $time_val => $time_instances ) {
							$date->setTimestamp( strtotime( $date_val . $time_val ) );
							if ( is_array( $time_instances ) && count( $time_instances ) > 0 ) {
								$unique_instances = array_unique( $time_instances );
								foreach ( $unique_instances as $service_html ) {
									$timeline_class = ( $count % 2 == 0 ) ? 'timeline-inverted' : 'timeline-inverted-right';
									?>
                                    <li class="<?php echo $timeline_class; ?>">
                                        <div class="tl-circ"></div>
                                        <div class="timeline-panel">
                                            <div class="tl-heading">
                                                <h4><?php echo $date->format( $time_format ); ?></h4>
                                            </div>
                                            <div class="tl-body">
												<?php echo $service_html; ?>
                                            </div>
                                        </div>
                                    </li>
									<?php
									$count ++;
								}
							}
						}
					}
				}
				?>
            </ul>
			<?php
		}
	}

}
