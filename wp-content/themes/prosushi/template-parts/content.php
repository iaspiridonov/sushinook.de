<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ProSushi
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php prosushi_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content 
    <?php if( is_page( 'account' ) ){ ?>
      myaccount
    <?php } else {?>
      
    <?php }?>">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'prosushi' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'prosushi' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
   
    <?php 
      if( is_page( 'account' ) ){ ?>
      <style>
        #form4{
          margin: 0 auto;
          text-align: center;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
        }
        button.promocode{
          width: 300px;
        }
        .myaccount .fa-sign-in:before, .myaccount .fa-lightbulb-o:before, .myaccount .fa-key:before  {
          content: " ";
        }

      </style>
    <?php } else {?>
      <footer class="entry-footer">
        <?php prosushi_entry_footer(); ?>
      </footer>
    <?php }?>
<!--
	
-->
	
	<!-- .entry-footer -->
</article><!-- #post-## -->
