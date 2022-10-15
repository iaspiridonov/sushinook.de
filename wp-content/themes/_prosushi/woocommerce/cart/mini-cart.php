<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>
	<div class="cartM-body">

		<?php if ( ! WC()->cart->is_empty() ) : ?>

			<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
						$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
						$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						?>

						<div class="cartM-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
			                
			                <div class="cartM-item-name">
	                            <h5>
	                            <?php echo $product_name ?>
	                            </h5>							
								<?php
									echo apply_filters( 'woocommerce_cart_item_remove_link',
										sprintf('<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
											esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
											__( 'Remove this item', 'woocommerce' ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() )
										), 
										$cart_item_key );								
								?> 							                      
	                        </div>
							
							<div class="cartM-item-main">

<div class="<?php woofc_class(); ?>" <?php woofc_attributes();?>>
	
	<?php do_action( 'woofc_before_cart' ); ?>
	
	<?php woo_floating_cart_template('parts/trigger'); ?>
	<?php woo_floating_cart_template('parts/cart'); ?>

	<?php do_action( 'woofc_after_cart' ); ?>

</div>
							</div>
						</div> <!-- .cartM-item -->

						<?php
					}
				}
			?>

		<?php else : ?>

			<p><?php _e( 'No products in the cart.', 'woocommerce' ); ?></p>

		<?php endif; ?>

	</div> <!-- .cartM-body -->
	<!-- end product list -->
				

<div class="cartM-footer">    
    <p class="gds-resum-sum total">
    Итого: <?php echo WC()->cart->get_cart_subtotal(); ?>
    </p>
    <p>
        <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>">
            <i class="fa fa-credit-card"></i>
            <span>оформить</span>
         </a>
    </p>
</div>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>