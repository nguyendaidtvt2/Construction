<?php
/**
 * The template for displaying all single posts.
 *
 * @package 7up-framework
 */
?>
<?php get_header();?>
<?php do_action('th_before_main_content')?>
    <div id="main-content"  class="main-page-default">
        <div class="container">
            <div class="row">
                <?php th_output_sidebar('left')?>
                <div class="<?php echo esc_attr(th_get_main_class()); ?>">
                    <?php
                    th_set_post_view();
                    $size               = th_get_option('post_single_size');
                    $check_thumb        = th_get_option('post_single_thumbnail','1');
                    $check_meta         = th_get_option('post_single_meta','1');

                    $size = th_get_size_crop($size);
                    $data = array(
                        'size'              => $size,
                        'check_thumb'       => $check_thumb,
                        'check_meta'        => $check_meta,
                        );
                    while ( have_posts() ) : the_post();

                        /*
                        * Include the post format-specific template for the content. If you want to
                        * use this in a child theme, then include a file called called content-___.php
                        * (where ___ is the post format) and that will be used instead.
                        */
                        th_get_template_post( 'single-content/content',get_post_format(),$data,true );
                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'construction' ),
                            'after'  => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                        ) );
                        th_get_template( 'share','',false,true );
                        th_get_template_post( 'single-content/navigation','',false,true );
                        th_get_template_post( 'single-content/author','',false,true );
                        th_get_template_post( 'single-content/related','',false,true );
                        if ( comments_open() || get_comments_number() ) { comments_template(); }
                       
                    endwhile; ?>
                </div>
                <?php th_output_sidebar('right')?>
            </div>
        </div>
    </div>
<?php do_action('th_after_main_content')?>
<?php get_footer();?> 