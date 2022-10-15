<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class XLUTM_WC extends XLUTM_Services {

	private static $instance = null;
	protected $type = 'wc';

	public function __construct() {
		parent::__construct();
		if ( ! class_exists( 'WooCommerce' ) ) {
			return false;
		}
		if ( is_admin() ) {
			// admin hooks
			$this->admin_hooks();
		} else {
			// public hooks
			$this->public_hooks();
		}
	}

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function admin_hooks() {
		add_action( 'add_meta_boxes', array( $this, 'xlutm_add_meta_boxes' ), 20 );
	}

	public function public_hooks() {
		add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'xlutm_woocommerce_thankyou' ), 20, 2 );
	}

	public function xlutm_woocommerce_thankyou( $order_id, $data ) {
		$this->insert_utm_details( $this->type, $order_id );
	}

	public function xlutm_add_meta_boxes() {
		add_meta_box( 'xlutm-stats', $this->get_metabox_title(), array(
			$this,
			'xlutm_meta_box_view',
		), 'shop_order', 'normal', 'low' );
	}

	public function xlutm_meta_box_view() {
		global $wpdb;
		$order_id        = absint( $_GET['post'] );
		$conversion_time = $this->xlutm_get_lead_conversion_time( $order_id );
		//      $info_id  = $this->get_info_by( $this->type, 'refid', $order_id, 'id,date', 'date' );
		$table_name      = $wpdb->prefix . 'xlutm';
		$get             = ' id,date ';
		$order_by        = 'DESC';
		$order_by_column = 'date';
		$type            = $this->type;
		$where_condition = array(
			0 => 'refid = %d
                    AND type = %s',
			1 => array( $order_id, $type ),
		);
		$info_id         = $this->xlutm_get_data( $table_name, $get, $where_condition, $order_by_column, $order_by );
		if ( is_array( $info_id ) && count( $info_id ) > 0 ) {
			?>
            <div class="xlutm-container">
                <div class="xlutm-inner">
                    <div class="xlutm-width30">
						<?php
						$timeline_array = array();
						$timezone       = XLUTM_Common::wc_timezone_string();
						$date           = new DateTime();
						$date->setTimezone( new DateTimeZone( $timezone ) );
						$first_occurence = $this->xlutm_show_start_time( $order_id, $date );
						if ( '' != $first_occurence ) {
							?>
                            <p class="tldate ptldate xlutm-left">
                                <span class="label"><b>First Occurrence:</b></span>&nbsp;
								<?php echo $first_occurence; ?>
                            </p>
							<?php
						}
						if ( false != $conversion_time ) {
							?>
                            <p class="tldate ptldate xlutm-right">
                                <span class="label"><b>Conversion Time:</b></span>&nbsp;
								<?php echo $conversion_time; ?>
                            </p>
							<?php
						}
						?>
                    </div>
                    <div class="xlutm-left xlutm-width70">
						<?php
						$date_format = get_option( 'date_format' );
						foreach ( $info_id as $key1 => $value1 ) {
							$xlutm_id = $value1['id'];
							$metadata = get_metadata( 'xlutm', $xlutm_id );
							$metadata = $this->exclude_underscore_meta_fields( $metadata );
							if ( is_array( $metadata ) && count( $metadata ) > 0 ) {
								if ( '0000-00-00 00:00:00' != $value1['date'] ) {
									$date->setTimestamp( strtotime( $value1['date'] ) );
									$day_date = $date->format( $date_format );
									ob_start();
									$this->xlutm_get_view( $metadata, $order_id );
									$table_html                                                  = ob_get_clean();
									$timeline_array[ $day_date ][ $date->format( 'g:i:s a' ) ][] = $table_html;
								}
							}
						}
						$this->xlutm_show_timeline( $timeline_array, $date );
						?>
                    </div>
                    <div class="xlutm-clear"></div>
                </div>
            </div>
			<?php
		}
	}

}

return XLUTM_WC::get_instance();
