<?php
namespace Elementor;
$type_active_temp = $type_active;
$column_temp = $column;
extract($settings);
$type_active = $type_active_temp;
$column = $column_temp;
$view = 'grid';
$attr = array(
	'grid_style'		=> 'layout',
    'item_wrap'         => $item_wrap,
    'item_inner'		=> $item_inner,
    'type_active'		=> $type_active,
    'button_icon_pos'	=> $button_icon_pos,
    'button_icon'		=> $button_icon,
    'button_text'		=> $button_text,
	'size'				=> $size,
	'size_list'			=> $size_list,
	'excerpt'			=> $excerpt,
	'column'			=> $column,
    'item_style'		=> $item_style,
    'item_list_style'	=> $item_list_style,
    'view'				=> $view,
    'item_thumbnail' 	=> $item_thumbnail,
    'item_title' 		=> $item_title,
    'item_excerpt' 		=> $item_excerpt,
    'item_button' 		=> $item_button,
    'item_meta' 		=> $item_meta,
    'item_meta_select' 	=> $item_meta_select,
    'thumbnail_hover_animation' 	=> $thumbnail_hover_animation,
	);
$slug = $item_style;
?>
<?php echo '<div '.$wdata->get_render_attribute_string( 'elth-wrapper' ).'>';?>
	<?php echo '<div '.$wdata->get_render_attribute_string( 'elth-inner' ).'>';?>
    	<?php 
        $count_item = 1;
    	if($post_query->have_posts()) {
            while($post_query->have_posts()) {
                $post_query->the_post();
                if($count_item % 3 == 2) $attr['size'] = [770,370];
                else $attr['size'] = [370,370];
    			th_get_template_post($view.'/'.$view,$slug,$attr,true); 
                $count_item++;
    		}
    	}
    	?>
	</div>
	<?php
	if($pagination == 'load-more' && $max_page > 1){
        $data_load = array(
            "args"        => $args,
            "attr"        => $attr,
            );
        $data_loadjs = json_encode($data_load);
        echo    '<div class="btn-loadmore">
                    <a href="#" class="blog-loadmore loadmore elth-bt-default elth-bt-medium" 
                        data-load="'.esc_attr($data_loadjs).'" data-paged="1" 
                        data-maxpage="'.esc_attr($max_page).'">
                        '.esc_html__("Load more","construction").'
                    </a>
                </div>';
    }
    if($pagination == 'pagination') th_paging_nav($post_query,'',true);
	?>
</div>