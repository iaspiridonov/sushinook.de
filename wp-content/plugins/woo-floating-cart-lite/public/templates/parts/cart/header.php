<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the cart header.
 *
 * This template can be overridden by copying it to yourtheme/woo-floating-cart/parts/cart/header.php.
 *
 * HOWEVER, on occasion we will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @link       http://xplodedthemes.com
 * @since      1.0.6.1
 *
 * @package    Woo_Floating_Cart
 * @subpackage Woo_Floating_Cart/public/templates/parts
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 
?>

<div class="woofc-header">


	
	<span class="woofc-title">
	
	    
	<?php echo esc_html__('[:de]Warenkorb[:en]Basket[:ru]Корзина[:]', 'woo-floating-cart'); ?></h2>
	<span class="woofc-undo"><?php echo esc_html__('Item Removed.', 'woo-floating-cart'); ?> <a href="#0"><?php echo esc_html__('Undo', 'woo-floating-cart'); ?></a></span>
	<span class="woofc-cart-error"></span><br>
	
    <a href="/#napitki"><span  class="animation_text"><?php _e('[:de]Vergessen Sie nicht, ein Getränk zu nehmen[:en]Do not forget to buy a drink[:ru]Не забудьте взять напиток[:]'); ?></span></a>
</div>

