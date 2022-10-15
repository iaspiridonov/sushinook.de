<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class XLUTM_EDD extends XLUTM_Services {

	private static $instance = null;
	protected $type = 'edd';

	public function __construct() {
		parent::__construct();
		if ( ! class_exists( 'Easy_Digital_Downloads' ) ) {
			return;
		}
		if ( is_admin() ) {
			// admin hooks
			$this->admin_hooks();
		}
		// public hooks
		$this->public_hooks();
	}

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function admin_hooks() {
		add_action( 'edd_view_order_details_billing_after', array( $this, 'xlutm_edd_view_order_details_billing_after' ) );
	}

	public function public_hooks() {
		add_action( 'edd_payment_saved', array( $this, 'xlutm_edd_on_complete_purchase' ), 20, 1 );
		add_action( 'edd_complete_purchase', array( $this, 'xlutm_edd_on_complete_purchase' ), 20, 1 );
	}

	public function xlutm_edd_on_complete_purchase( $payment_id ) {
		$transient_key    = 'xlutm_verify_' . $payment_id;
		$verify_insertion = get_transient( $transient_key );
		if ( false === $verify_insertion ) {
			$this->insert_utm_details( $this->type, $payment_id );
			set_transient( $transient_key, $payment_id, 3600 );
		}
	}

	public function xlutm_edd_view_order_details_billing_after() {
		global $wpdb;
		$payment_id      = absint( $_GET['id'] );
		$conversion_time = $this->xlutm_get_lead_conversion_time( $payment_id );
		//      $info_id    = $this->get_info_by( $this->type,'refid', $payment_id, 'id,date' );
		$table_name      = $wpdb->prefix . 'xlutm';
		$get             = ' id,date ';
		$order_by        = 'DESC';
		$order_by_column = 'date';
		$type            = $this->type;
		$where_condition = array(
			0 => 'refid = %d
                    AND type = %s',
			1 => array( $payment_id, $type ),
		);
		$info_id         = $this->xlutm_get_data( $table_name, $get, $where_condition, $order_by_column, $order_by );
		if ( is_array( $info_id ) && count( $info_id ) > 0 ) {
			?>
            <div id="edd-order-details" class="postbox edd-order-data">
                <div class="inside">
                    <div class="xlutm-container">
                        <h3 class="hndle">
                            <span><?php echo $this->get_metabox_title(); ?></span>
                        </h3>
                        <div class="xlutm-inner">
                            <div class="xlutm-width30">
								<?php
								$timeline_array = array();
								$timezone       = XLUTM_Common::wc_timezone_string();
								$date           = new DateTime();
								$date->setTimezone( new DateTimeZone( $timezone ) );
								$first_occurence = $this->xlutm_show_start_time( $payment_id, $date );
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
										$date->setTimestamp( strtotime( $value1['date'] ) );
										$day_date = $date->format( $date_format );
										ob_start();
										$this->xlutm_get_view( $metadata, $payment_id );
										$table_html                                                  = ob_get_clean();
										$timeline_array[ $day_date ][ $date->format( 'g:i:s a' ) ][] = $table_html;
									}
								}
								$this->xlutm_show_timeline( $timeline_array, $date );
								?>
                            </div>
                            <div class="xlutm-clear"></div>
                        </div>
                    </div>
                </div>
            </div>
			<?php
		}
	}

}

return XLUTM_EDD::get_instance();
