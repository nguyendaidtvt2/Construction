<?php
$data = '';
$blog_single_title_check = th_get_option('post_single_title','1');
if (get_post_meta(get_the_ID(), 'format_media', true)) {
    $media_url = get_post_meta(get_the_ID(), 'format_media', true);
    $data .='<div class="post-video single-post-thumb banner-advs">';
    $data .= th_remove_w3c(wp_oembed_get($media_url));
    $data .='</div>';
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