<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
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
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

		<p class="woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

		<p class="woocommerce-thankyou-order-failed-actions">
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>
        
		
		<p class="woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Спасибо Вам за оказанное доверие и за Ваш выбор нашей доставки! Мы искренне надеемся, что вам все понравится, и вы сделаете заказ еще не один раз! ', 'woocommerce' ), $order ); ?></p>
		
		<p style="color: red;">Заказ сразу поступает в работу, операторы НЕ ПЕРЕЗВАНИВАЮТ. Среднее время доставки 60-90 минут. Среднее время приготовления на вынос 20-30 минут. Время начинает идти с момента заказа на сайте. </p>
		
<p class="">
Время заказа: <?php echo date('H:i:s', strtotime($order->order_date));?></p>
		
		<p><b>В случае, если с момента приема заказа до его доставки прошло 90 минут или более, вы получаете сертификат на сумму 3000 тенге! </b></p>
		
		<p>У нас так же имеются другие акции, с которыми вы можете ознакомиться на странице <a href="/category/promotions/">«АКЦИИ»</a> </p>
		
		<p>
		А еще мы часто проводим различные конкурсы и розыгрыши, чтобы не упустить самого интересного, дружите с нами в социальных сетях!
		</p>
		
		<div class="pagetnks">
		
	    <a href="https://vk.com/prosushikz" class="soc2"><i class="fa fa-vk"></i> </a>
        <a href="https://www.instagram.com/prosushi_kostanay/" class="soc2"><i class="fa fa-instagram"></i></a>
		
        </div>
		
		
		
		<br>
        
		<ul class="woocommerce-thankyou-order-details order_details">
			<li class="order">
				<?php _e( 'Номер заказа:', 'woocommerce' ); ?>
				<strong><?php echo $order->get_order_number(); ?></strong>
			</li>
			<li class="date">
				<?php _e( 'Date:', 'woocommerce' ); ?>
				<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>
			</li>
			<li class="total">
				<?php _e( 'Total:', 'woocommerce' ); ?>
				<strong><?php echo $order->get_formatted_order_total(); ?></strong>
			</li>
			<?php if ( $order->payment_method_title ) : ?>
			<li class="method">
				<?php _e( 'Способ оплаты:', 'woocommerce' ); ?>
				<strong><?php echo $order->payment_method_title; ?></strong>
			</li>
			<?php endif; ?>
		</ul>
		<div class="clear"></div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
	<?php do_action( 'woocommerce_thankyou', $order->id ); ?>

<?php else : ?>

	<p class="woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

<?php endif; ?>
