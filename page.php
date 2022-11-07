<?php
/**
 * The template for displaying all single posts.
 *
 * @package 7up-framework
 */

get_header();
?>
<?php do_action('th_before_main_content')?>
<div id="main-content" class="main-page-default">
    <div class="container">
        <div class="row">
            <?php th_output_sidebar('left')?>
            <div class="<?php echo esc_attr(th_get_main_class()); ?>">
                <?php
                while ( have_posts() ) : the_post();

                    /*
                    * Include the post format-specific template for the content. If you want to
                    * use this in a child theme, then include a file called called content-___.php
                    * (where ___ is the post format) and that will be used instead.
                    */
                    ?>
                    	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="entry-content clearfix">
                                <?php   
                                if(get_post_meta(get_the_ID(),'show_title_page',true) != '0'):?>
                                            <div class="title-page clearfix">
                                                <h1 class="titlelv1 entry-title"><?php the_title()?></h1>
                                            </div>
                                <?php   endif;?>
                                <div class="detail-content-wrap inner-content clearfix">
    								<?php the_content(); ?>
                                </div>
								<?php
									wp_link_pages( array(
										'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'construction' ),
										'after'  => '</div>',
									) );
                                    th_get_template( 'share','',false,true );
								?>

							</div><!-- .entry-content -->
						</article><!-- #post-## -->
                    <?php

                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number()) :
                        comments_template();
                    endif;

                    // End the loop.
                endwhile; ?>
                
            </div> 
            <?php th_output_sidebar('right')?>
        </div>
    </div>
</div>
<?php do_action('th_after_main_content')?>
<?php
get_footer();