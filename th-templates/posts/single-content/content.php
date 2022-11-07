
<?php
$data = '';
global $post;
if(empty($size)) $size = [1170,500];
$th_image_blog = get_post_meta(get_the_ID(), 'format_image', true);
if($check_thumb == '1'){
    if(isset($th_image_blog['id']) && !empty($th_image_blog['id'])){
        $data .='<div class="single-post-thumb banner-advs custom-thumb">
                    '.wp_get_attachment_image($th_image_blog['id'],'full').'
                </div>';
    }
    else{
        if (has_post_thumbnail()) {
            $data .= '<div class="single-post-thumb banner-advs default-thumb">
                        '.get_the_post_thumbnail(get_the_ID(),$size).'                
                    </div>';
        }
    }
}
?>
<div class="content-single-blog <?php echo (is_sticky()) ? 'sticky':''?>">
    <?php if($check_meta == '1') th_display_metabox();?>
    <h2 class="titlelv1 title-post-single font-bold">
        <?php the_title()?>
        <?php echo (is_sticky()) ? '<i class="la la-star"></i>':''?>
    </h2>
    <?php if(!empty($data)) echo apply_filters('th_output_content',$data);?>
    <div class="content-post-default">
        <div class="detail-content-wrap clearfix"><?php the_content(); ?></div>
    </div>
</div>
