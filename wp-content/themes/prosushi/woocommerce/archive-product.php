<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) && !is_front_page() ) : ?>
		<a href="/" class="menuxx">вернуться назад</a>
			<div class="entry-header-category">
			
				<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
			</div>

		<?php endif; ?>


		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

        
        
  <?php     
 if( is_front_page() ) { ?>
 
 
 



 
<aside class="sidebarright">
<div class="sidebar-content">
	

<a href="#sets" class="suschi"><img src="/wp-content/themes/prosushi/img/set.png" class="iconmenu" /><span><?php _e('[:de]MENÜ[:en]Sets[:ru]Сеты (наборы)[:]'); ?></span></a>
<a href="#complex"><img src="/wp-content/themes/prosushi/img/slognie.png" class="iconmenu" /><span><?php _e('[:de]URAMAKI[:en]Complicated maki[:ru]Сложные роллы[:]'); ?></span></a>
<a href="#tempura"><img src="/wp-content/themes/prosushi/img/tempura.png" class="iconmenu" /><span><?php _e('[:de]Tempura[:en]Tempura maki[:ru]Темпура[:]'); ?></span></a>
<a href="#baked"><img src="/wp-content/themes/prosushi/img/zapech.png" class="iconmenu" /><span><span><?php _e('[:de]Überbackene Rolls[:en]Baked maki[:ru]Запеченные роллы[:]'); ?></span></a>
<a href="#pasta"><img src="/wp-content/themes/prosushi/img/lapsha.png" class="iconmenu" /><span><?php _e('[:de]WOK[:en]WOK[:ru]WOK[:]'); ?></span></a>
<a href="#poke"><img src="/wp-content/themes/prosushi/img/bowl.png" class="iconmenu" /><span><?php _e('[:de]Bowls[:en]Poke[:ru]Поке-боулы[:]'); ?></span></a>
<!--<a href="#pitases"><img src="/wp-content/themes/prosushi/img/pitas.png" class="iconmenu" /><span><?php _e('[:de]Питасы[:en]Питас[:ru]Питасы[:]'); ?></span></a>-->
<a href="#deserts"><img src="/wp-content/themes/prosushi/img/desert.png" class="iconmenu" /><span><span><?php _e('[:de]NACHSPEISEN[:en]Desserts[:ru]Десерты[:]'); ?></span></a>
<a href="#salats" ><img src="/wp-content/themes/prosushi/img/sup_salat.png" class="iconmenu" /><span><?php _e('[:de]VORSPEISEN[:en]Hot dishes and salads[:ru]Горячее и салаты[:]'); ?></span></a>
<a href="#nigiri"><img src="/wp-content/themes/prosushi/img/nigiri.png" class="iconmenu" /><span><?php _e('[:de]Sushi Nigiri[:en]Nigiri sushi[:ru]Суши Нигири[:]'); ?></span></a>
<a href="#gunkan" ><img src="/wp-content/themes/prosushi/img/gunkan.png" class="iconmenu" /><span><?php _e('[:de]Sushi Gunkan[:en]Gunkan sushi[:ru]Суши Гункан[:]'); ?></span></a>
<a href="#classic"><img src="/wp-content/themes/prosushi/img/klassich.png" class="iconmenu" /><span><?php _e('[:de]MAKI ROLLS[:en]Classic maki[:ru]Классические роллы[:]'); ?></span></a>
<a href="#napitki"><img src="/wp-content/themes/prosushi/img/napitki.png" class="iconmenu" /><span><?php _e('[:de]Getränke[:en]Beverages[:ru]Напитки[:]'); ?></span></a>
<a href="#sauces"><img src="/wp-content/themes/prosushi/img/sauces.png" class="iconmenu" /><span><?php _e('[:de]Saucen[:en]Sauces[:ru]Соусы[:]'); ?></span></a>
    
	
</div>
</aside>

 <?php 
}?>


        
        
			<?php woocommerce_product_loop_start(); ?>
			
			

        
        
			<div class="categories" style="display:none;">
				<?php woocommerce_product_subcategories(); ?>
			</div>				

			<div class="card-wrap">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>
			</div>				

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		// do_action( 'woocommerce_sidebar' );
	?>
		<?php if ( is_front_page() ) : ?>
		
		<?php endif; ?>
	<?php
	/**
	 * woocommerce_archive_description hook.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
		do_action( 'woocommerce_archive_description' );
	?>
<?php get_footer( 'shop' ); ?>
