<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the cart list product item thumbnail.
 *
 * This template can be overridden by copying it to yourtheme/woo-floating-cart/parts/cart/list/product/thumbnail.php.
 *
 * Available global vars: $product
 *
 * HOWEVER, on occasion we will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @link       http://xplodedthemes.com
 * @since      1.0.0
 *
 * @package    Woo_Floating_Cart
 * @subpackage Woo_Floating_Cart/public/templates/parts
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 
?>

<a href="<?php echo esc_url(get_permalink( $product->id )); ?>">
	<?php echo  $product->get_image(); ?>
</a>