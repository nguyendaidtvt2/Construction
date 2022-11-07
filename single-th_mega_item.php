<?php
/**
 * The template for displaying all single posts.
 *
 * @package 7up-framework
 */
?>
<?php get_header('none');?>
    <div id="main-content"  class="main-page-mega main-custom">
        <?php
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
        ?>
    </div>
<?php get_footer('none');?>