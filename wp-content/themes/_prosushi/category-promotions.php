<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ProSushi
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class="entry-header">
				<h1 class="entry-title"><?php $cat = get_the_category(); echo $cat[0]->cat_name; ?></h1>
			</div><!-- .entry-header -->

			<?php
			while ( have_posts() ) : the_post();
			?>

			<div class="promotions-item">
				
				<?php echo get_the_post_thumbnail();?>	

				<div class="promotions-item-content">
					<p class="promotions-item-title"><?php the_title($before = '', $after = '', $echo = true);?></p>

					<div class="promotions-item-text"><?php the_content( $more_link_text, $strip_teaser );?></div>
				</div>

			</div>


				
				<?php if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>
			<?php
			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// get_sidebar();
get_footer();
