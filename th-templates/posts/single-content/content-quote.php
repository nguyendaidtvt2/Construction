<?php
$data = $st_link_post= $s_class = '';
global $post;
if (has_post_thumbnail()) {
    $data .= '<div class="single-post-thumb banner-advs">
                '.get_the_post_thumbnail(get_the_ID(),'full').'                
            </div>';
}
?>
<div class="content-single-blog <?php echo (is_sticky()) ? 'sticky':''?>">
    <?php if(!empty($data)) echo apply_filters('th_output_content',$data);?>
    <?php if($check_meta == '1') th_display_metabox();?>
    <div class="content-post-default">
        <h2 class="titlelv1 title-post-single font-bold">
            <?php the_title()?>
            <?php echo (is_sticky()) ? '<i class="la la-star"></i>':''?>
        </h2>
        <div class="detail-content-wrap clearfix"><?php the_content(); ?></div>
    </div>
</div>