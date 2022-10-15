<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>


<?php 
// Генерация кода смс
$cod_sms = mt_rand(1000, 9999);

?>

<h3><?php _e('[:de]Essstäbchen, Wasabi und Ingwer sind bei jeder Bestellung kostenlos dabei![:en]Necessary amount of sushi sticks, soybean sauce and ginger is free![:ru]Необходимое количество палочек для суши, соевого соуса и имбиря – бесплатно![:]'); ?></h3>

<!--<style>
.promocode{
background-color: #c33;
    color: #fff;
    padding: 10px 10px;
    display: inline-block;
    border-radius: 4px;
    text-transform: uppercase;
    font-weight: 400;
    font-size: .9em;
    cursor: pointer;
    width: 200px;
    align-self: center;
	border: 0;
}

.promocode:hover{
background-color: #e47272;
}
</style>


<div class="cart__promocode" style="margin-top:40px;margin-bottom:20;">
<form id="promoform">
<input name="certificate" id="certificate"  style='font-size: .9em;padding: .7em;' placeholder="Введите промокод" value="" required/>
<button type="submit" class="promocode">Применить</button>
<h3 id="promorez" style="display:none;font-size: 28px;text-align: center;color: green;border: 1px solid green;padding: 16px;border-radius: 16px;margin-top: 13px;"></h3>
</form>
</div>-->


<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

				<div id="order_review" class="woocommerce-checkout-review-order">
					<table class="shop_table woocommerce-checkout-review-order-table">
	<thead>
		<tr>
			<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-total"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<td class="product-name">
						<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</td>
					<td class="product-total">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot>

		<tr class="cart-subtotal">
			<th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<th><?php echo esc_html( $tax->label ); ?></th>
						<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total">
			<th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>

				</div>

				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

				<input type="hidden" id="cod_sms" value="<?php echo $cod_sms; ?>" name="cod_sms">
				
				<input type="hidden" id="promo1" value="" name="promo1">
				<input type="hidden" class="res_brone_timer" value="" name="time">
					
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
				
				
				<div class="sms_parent"><input type="button" value="<?php _e('[:de]Senden Sie mir den Code[:en]Send me SMS code[:ru]Отправьте мне код[:]'); ?>" id="sms_cod"> <div class="sms-result"></div></div>
				
				<h3 id="ball" style="display:none;font-size: 28px;text-align: center;color: green;border: 1px solid green;padding: 16px;border-radius: 16px;margin-top: 13px;display:none"></h3>
				
				<p class="form-row input-text" id="bonus_field"><label for="bonus"><?php _e('[:kz]Қанша бонус алу керек?[:ru]Сколько списать бонусов?[:]'); ?></label><span class="woocommerce-input-wrapper"><input type="number" class="input-text" name="bonus" id="bonus" placeholder="<?php _e('[:kz]Қанша бонус алу керек?[:ru]Сколько списать бонусов?[:]'); ?>" value="0" step="1" min="0"></span></p>
				

		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
	
<style>
#list-timer {
    text-align: center;
    padding: 10px 0px;
}
#list-timer ul {
    list-style: none;
}

#list-timer li {
	cursor:pointer;
    display: inline-block;
    font-size: 14px;
    padding: 10px;
    margin: 3px;
    border-radius: 3px;
	border: 1px solid #2a2727;
    width: 150px;
    background-color: #f5f5e9;
}

.timer-active { 
background-color: #c33 !important;
    border: 1px solid #cc3333 !important;
    color: #ffffff !important;
}

.timeoffset{
	font-weight: 300 !important;
	border-bottom: 1px dashed #000;
	padding-bottom: 2px;	
	text-transform: none !important;
	cursor:pointer;
}
</style>


<?php 

/*
$ip=$_SERVER['REMOTE_ADDR'];
if ($ip!="91.180.44.29"){
	
	
$offset=strtotime("+8 hours");
$start=strtotime("11:00:00 ".date("d.m.Y"));
$ss=0;
$str1='';
for ($x=0;$x<27;$x++){
	$start0=strtotime("+0 minute",$start);
	$start=strtotime("+30 minute",$start);
	if ($start>$offset){
		$str1.='<li class="timer-no-brone">'.date("H:i",$start0).'-'.date("H:i",$start).'</li>';
		$ss=1;
	}
}
	
if ($ss==1){
?>
<span class="timeoffset">▼ Заказ ко времени</span>
<div id="timeoffsetdiv" style="display:none">
<?php 
$offset1=strtotime("-2 hours",$offset);
//echo "Текущее время: ".date("H:i",$offset1)."<br>";
echo '<ul id="list-timer" class="">'.$str1.'</ul>';
	
?>

</div>

<?php
} 

} // от ip

*/

	
	
if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
?>
<div id="payment" class="woocommerce-checkout-payment">
	<?php if ( WC()->cart->needs_payment() ) : ?>
		<ul class="wc_payment_methods payment_methods methods">
			<?php
			if ( ! empty( $available_gateways ) ) {
				foreach ( $available_gateways as $gateway ) {
					wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
				}
			} else {
				echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</li>'; // @codingStandardsIgnoreLine
			}
			?>
		</ul>
	<?php endif; ?>
	<div class="form-row place-order">
		<noscript>
			<?php
			/* translators: $1 and $2 opening and closing emphasis tags respectively */
			printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ), '<em>', '</em>' );
			?>
			<br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
		</noscript>

		<?php wc_get_template( 'checkout/terms.php' ); ?>

		<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

		<?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>

		<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

		<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
	</div>
</div>
<?php
if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
	
	?>
</form>




<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<script>
    var cod_style_clean = jQuery('#cod_style').val('');
	//alert(jQuery('#cod_style').val(''));

</script>