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
										sprintf('
											<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
											esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
											__( 'Remove this item', 'woocommerce' ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() )
										), 
										$cart_item_key );								
								?> 							                      
	                        </div>
							
							<div class="cartM-item-main">

			                    <div class="cartM-item-main-l">
		                            <p class="gds-number">

		                                <i class="fa fa-minus"></i>
		                                <span class="gds-number-this">  
		                                <!-- Кол-во одного наименования -->                              	
											<?php 
			        							echo apply_filters( 'woocommerce_widget_cart_item_quantity', sprintf( $cart_item['quantity'], $product_price )); 
		        							?>
		                                </span>
		                                <i class="fa fa-plus"></i>
		                            </p>
		                            						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
							}							
						?>


						

		                            <p class="gds-sum">
		                                <span class="gds-sum-this">
		                                <!-- Сумма одного наименования -->
		                                <?php
											echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
										?>
		                                </span>
		                            </p>                            
		                        </div>

								<div class="cartM-item-main-r">
								<!-- Картинка позиции -->
								<?php if ( ! $_product->is_visible() ) : ?>
									<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail )  . '&nbsp;'; ?>
								<?php else : ?>							
										<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . '&nbsp;'; ?>							
								<?php endif; ?>
								</div>

							<?php echo WC()->cart->get_item_data( $cart_item ); ?>
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