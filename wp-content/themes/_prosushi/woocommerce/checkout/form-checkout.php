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

<h3><?php _e('[:kz]Сушиге арналған таяқшалардың қажетті саны, соя тұздығы және зімбір - тегін![:ru]Необходимое количество палочек для суши, соевого соуса и имбиря – бесплатно![:]'); ?></h3>

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

				<?php do_action( 'woocommerce_checkout_billing' ); ?>
				<div class="sms_parent"><input type="button" value="Отправьте мне код" id="sms_cod"> <div class="sms-result"></div></div>
				
				
				<!--<h3 id="ball" style="display:none;font-size: 28px;text-align: center;color: green;border: 1px solid green;padding: 16px;border-radius: 16px;margin-top: 13px;display:none"></h3>-->
				
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>


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
?>
	
	

	<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

	<input type="hidden" id="cod_sms" value="<?php echo $cod_sms; ?>" name="cod_sms">
	
	<input type="hidden" id="promo1" value="" name="promo1">
	<input type="hidden" class="res_brone_timer" value="" name="time">
	
</form>




<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<script>
    var cod_style_clean = jQuery('#cod_style').val('');
	//alert(jQuery('#cod_style').val(''));

</script>