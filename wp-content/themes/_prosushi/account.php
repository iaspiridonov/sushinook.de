<?php 

/**
 * Template Name: имя шаблона
 *
 
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main as" role="main">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	
	
	
<!--
	 php $acsessuar = new WP_Query( array( 'post_type' => 'shop_order', 'id' => 22666 ) ); 

	   //var_dump($acsessuar);
	 
	 ?>
-->

	
	

<?php

// get_sidebar();
get_footer();