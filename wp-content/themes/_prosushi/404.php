<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package ProSushi
 */

get_header(); ?>			
			<style type="text/css">
				.error-404 {
					margin-bottom: 20vh;}
			</style>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Извините, такой страницы у нас нет!', 'prosushi' ); ?></h1>
				</header><!-- .page-header -->
			</section><!-- .error-404 -->


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
