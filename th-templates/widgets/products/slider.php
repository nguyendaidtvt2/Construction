<?php
namespace Elementor;
extract($settings);
$attr = array(
    'item_wrap'         => $item_wrap,
    'item_inner'        => $item_inner,
    'button_icon_pos'   => $button_icon_pos,
    'button_icon'       => $button_icon,
    'button_text'       => $button_text,
    'size'              => $size,
    'view'              => $view,
    'column'            => $column,
    'item_style'        => $item_style,
    'item_thumbnail'    => $item_thumbnail,
    'item_quickview'    => $item_quickview,
    'item_label'        => $item_label,
    'item_title'        => $item_title,
    'item_rate'         => $item_rate,
    'item_price'        => $item_price,
    'item_button'       => $item_button,
    'animation'         => $thumbnail_hover_animation,
    );
?>
<div class="th-slider-wrap">
    <?php echo '<div '.$wdata->get_render_attribute_string( 'elth-wrapper' ).'>';?>
        <?php
        if($filter_show == 'yes'){
            $data_filter = array(
                'args'          => $args,
                'attr'          => $attr,
                'filter_style'  => $filter_style,
                'filter_column' => $filter_column,
                'filter_cats'   => $filter_cats,
                'filter_price'  => $filter_price,
                'filter_attr'   => $filter_attr,
                'filter_pos'    => '',
            );
            th_get_template_woocommerce('loop/filter-product','',$data_filter,true);
        }
        ?>
        <?php echo '<div '.$wdata->get_render_attribute_string( 'elth-inner' ).'>';?>
            <?php 
            if($product_query->have_posts()) {
                while($product_query->have_posts()) {
                    $product_query->the_post();
                    $attr['count'] = $count;
                    // if($slider_column > 1 && $count % $slider_column == 1) echo '<div class="item-wrap-column swiper-slide item-wrap-'.$slider_column.'">';
                    th_get_template_woocommerce('loop/grid/grid',$item_style,$attr,true);
                    // if($slider_column > 1 && $count % $slider_column == 0) echo '</div>';
                    $count++;
                }
            }
            ?>
        </div>
    </div>
    <?php if ( $slider_navigation == 'yes' ):?>
        <div class="swiper-button-nav swiper-button-next"><?php Icons_Manager::render_icon( $slider_icon_next, [ 'aria-hidden' => 'true' ] );?></div>
        <div class="swiper-button-nav swiper-button-prev"><?php Icons_Manager::render_icon( $slider_icon_prev, [ 'aria-hidden' => 'true' ] );?></div>
    <?php endif?>
    <?php if ( $slider_pagination == 'yes' ):?>
        <div class="swiper-pagination"></div>
    <?php endif?>
</div>