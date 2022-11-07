<?php
add_action('wp_ajax_nopriv_valik_lm_folio', 'valik_lm_folio_callback'); 
add_action('wp_ajax_valik_lm_folio', 'valik_lm_folio_callback');

function valik_lm_folio_callback(){

    $output = array();
    $output['status'] = 'fail';
    if ( ! isset( $_POST['_lmnonce'] ) || ! wp_verify_nonce( $_POST['_lmnonce'], 'valik_lm_folio' ) ) {
        // This nonce is not valid.
        $output['content'] = esc_html__('Sorry, your nonce did not verify.','valik' );
        $output['is_remaining'] = 'no';
    } else {
        // The nonce was valid.
        // Do stuff here.
        $default_args = array(
            'post_type' => 'project',
            'paged' => 2,
            'posts_per_page'=> 3,
            'post__in' => array(),
            'post__not_in' => array(),
            'orderby'=> 'date',
            'order'=> 'DESC',
            'cat'=> '',
            'lmore_items'=> 3,

            'post_status'       => 'publish',
        );

        $args = wp_parse_args( $_POST['wp_query'], $default_args );

        $lmore_items = $args['lmore_items'];

        
        unset($args['action']);
        unset($args['lmore_items']);
         if(isset($args['layout']) && isset($args['show_fix_height']) ){
            $layout = $args['layout'];
            $show_fix_height = $args['show_fix_height'];
            unset($args['layout']);
            unset($args['show_fix_height']);
        }else{
            $layout = 'style-1';
            $show_fix_height = 'no';
        }
        // $output['layout'] = $layout;
        // $output['show_fix_height'] = $show_fix_height;
        $args['offset'] = $current_offset = $args['posts_per_page'] + $lmore_items*($_POST['click_num']-1);
        $args['posts_per_page'] = $lmore_items;
        $output['ddd'] = $args;
        $folio_posts = new WP_Query($args);
        ob_start(); 
        if($folio_posts->have_posts()) : 
            $pin = $current_offset + 1;
            while($folio_posts->have_posts()) : $folio_posts->the_post(); ?>
                 <div <?php post_class('cthiso-item gallery-titem gallery-item');?>>
                        <div class="grid-item-holder">

                            <?php if(has_post_thumbnail()): ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php if( $layout == 'style-2' && $show_fix_height == 'yes'){
                                        the_post_thumbnail( 'valik-fix-height' );
                                   }else{
                                     the_post_thumbnail( 'valik-portfolios' );
                                   } ?>
                                </a>
                            <?php endif; ?>
                            <div class="grid-item-holder_title">
                                <?php 
                                $terms = get_the_terms(get_the_ID(), 'project_cat');
                                if ( $terms && ! is_wp_error( $terms ) ){
                                    foreach( $terms as $key => $term){
                                        
                                       $term_link = get_term_link( $term, array( 'project_cat') );
                                        echo sprintf('<h5><a href="%1$s">%2$s</a></h5>',
                                            esc_url($term_link),
                                            esc_html($term->name)
                                        );
                                    }
                                }
                                ?>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            </div>
                        </div>
                    </div>
            <?php   
            endwhile;

        endif;

        $output['status'] = 'success';

        $output['content'] = ob_get_clean();

        //check for remaining items
        if($folio_posts->found_posts && $folio_posts->found_posts > $current_offset + $lmore_items){
            $output['is_remaining'] = 'yes';
        }else{
            $output['is_remaining'] = 'no';
        }

        wp_reset_postdata();
    }
    wp_send_json( $output );
}
