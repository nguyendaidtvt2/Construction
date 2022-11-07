<?php
/**
 * The template for displaying search results pages.
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
                $view           = th_get_option('blog_default_style','list');
                $grid_type      = th_get_option('post_grid_type');
                $item_style     = th_get_option('post_grid_item_style');
                $item_list_style= th_get_option('post_list_item_style');
                $excerpt        = th_get_option('post_grid_excerpt',80);
                $blog_style     = th_get_option('blog_style');
                $column         = th_get_option('post_grid_column',3);
                $size           = th_get_option('post_grid_size');
                $size_list      = th_get_option('post_list_size');
                $number         = get_option('posts_per_page');
                $show_number    = th_get_option('blog_number_filter');
                $show_type     = th_get_option('blog_type_filter');

                if(isset($_GET['number'])) $number = sanitize_text_field($_GET['number']);
                $type_active = $view;
                if(isset($_GET['type']) && $_GET['type']) $type_active = sanitize_text_field($_GET['type']);
                $view = $type_active;
                $item_wrap = 'class="list-col-item list-'.esc_attr($column).'-item"';
                $item_inner = 'class="item-post item-post-default"';
                $button_icon_pos = $button_icon = '';
                $button_text = esc_html__("Read more", "printing");
                $slug = $item_style;
                if($type_active == 'list') $slug = $item_list_style;
                if($view == 'slider') $view = 'grid';
                $item_thumbnail = $item_title = $item_excerpt = $item_button = $item_meta = 'yes';
                $item_meta_select = ['author','date','comments'];
                $thumbnail_hover_animation = 'grow-rotate';
                $size = th_get_size_crop($size);
                $size_list = th_get_size_crop($size_list);
                $attr = array(
                    'item_wrap'         => $item_wrap,
                    'item_inner'        => $item_inner,
                    'type_active'       => $type_active,
                    'button_icon_pos'   => $button_icon_pos,
                    'button_icon'       => $button_icon,
                    'button_text'       => $button_text,
                    'size'              => $size,
                    'size_list'         => $size_list,
                    'excerpt'           => $excerpt,
                    'column'            => $column,
                    'item_style'        => $item_style,
                    'item_list_style'   => $item_list_style,
                    'view'              => $view,
                    'item_thumbnail'    => $item_thumbnail,
                    'item_title'        => $item_title,
                    'item_excerpt'      => $item_excerpt,
                    'item_button'       => $item_button,
                    'item_meta'         => $item_meta,
                    'item_meta_select'  => $item_meta_select,
                    'thumbnail_hover_animation'     => $thumbnail_hover_animation,
                    );


                $max_page = $GLOBALS['wp_query']->max_num_pages;
                $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
                $args = array(
                    'post_type'         => 'post',
                    'posts_per_page'    => $number,
                    'order'             => 'DESC',
                    'paged'             => $paged,
                );

                $curent_query = $GLOBALS['wp_query']->query;
                if(is_array($curent_query)) $args = array_merge($args,$curent_query);
                
                th_get_template('top-filter','',array('style'=>$type_active,'number'=>$number,'show_number'=>$show_number,'show_type'=>$show_type),true);
                if($type_active == 'list' && $view == 'grid') $el_class = 'blog-list-view '.$grid_type;
                else $el_class = 'blog-'.$view.'-view '.$grid_type;
                ?>

                <div class="js-content-wrap elth-posts-wrap <?php echo esc_attr($el_class)?>" data-column="<?php echo esc_attr($column)?>">
                    <?php if(have_posts()):?>
                        <div class="js-content-main list-post-wrap row">
                        
                            <?php while (have_posts()) :the_post();?>

                                <?php th_get_template_post($view.'/'.$view,$slug,$attr,true);?>

                            <?php endwhile;?>

                        </div>
                        
                        <?php 
                        if($blog_style == 'load-more' && $max_page > 1){
                            $data_load = array(
                                "args"        => $args,
                                "attr"        => $attr,
                                );
                            $data_loadjs = json_encode($data_load);
                            echo    '<div class="btn-loadmore">
                                        <a href="#" class="blog-loadmore loadmore elth-bt-default elth-bt-medium" 
                                            data-load="'.esc_attr($data_loadjs).'" data-paged="1" 
                                            data-maxpage="'.esc_attr($max_page).'">
                                            '.esc_html__("Load more","printing").'
                                        </a>
                                    </div>';
                        }
                        else th_paging_nav(); 
                        ?>

                    <?php else : ?>

                        <?php echo th_get_template_post( 'content' , 'search-none' ); ?>

                    <?php endif;?>

                </div>
            </div>
            <?php th_output_sidebar('right')?>
        </div>
    </div>
</div>
<?php do_action('th_after_main_content')?>
<?php get_footer(); ?>
