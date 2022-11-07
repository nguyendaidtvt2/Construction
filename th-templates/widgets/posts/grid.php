<?php
namespace Elementor;
$type_active_temp = $type_active;
$column_temp = $column;
extract($settings);
$type_active = $type_active_temp;
$column = $column_temp;
$attr = array(
	'item_wrap'			=> $item_wrap,
    'item_inner'		=> $item_inner,
    'type_active'		=> $type_active,
    'button_icon_pos'	=> $button_icon_pos,
    'button_icon'		=> $button_icon,
    'button_text'		=> $button_text,
	'size'				=> $size,
	'size_list'			=> $size_list,
	'excerpt'			=> $excerpt,
    'excerpt_list'      => $excerpt_list,
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
if($view == 'grid' && $type_active == 'list'){
	$view = $type_active;
	$slug = $item_list_style;
}
if($show_top_filter == 'yes'){
    echo th_get_template('top-filter','',array(
        'style'         =>$type_active,
        'number'        =>$number,
        'show_number'   =>$show_number,
        'show_type'     =>$show_type,
        'show_title'    =>$show_title,
    ));
}
?>
<?php echo '<div '.$wdata->get_render_attribute_string( 'elth-wrapper' ).'>';?>
	<?php echo '<div '.$wdata->get_render_attribute_string( 'elth-inner' ).'>';?>
    	<?php 
    	if($post_query->have_posts()) {
            while($post_query->have_posts()) {
                $post_query->the_post();
    			th_get_template_post($view.'/'.$view,$slug,$attr,true);
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