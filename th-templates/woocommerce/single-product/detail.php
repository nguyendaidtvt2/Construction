<?php
remove_action( 'woocommerce_before_single_product_summary','woocommerce_show_product_images',20 );
remove_action( 'woocommerce_product_thumbnails','woocommerce_show_product_thumbnails',20 );
th_set_post_view();
$thumb_class = 'col-md-5 col-sm-12 col-xs-12';
$info_class = 'col-md-7 col-sm-12 col-xs-12';
$zoom_style = th_get_option('product_image_zoom');
global $product;
$thumb_id = array(get_post_thumbnail_id());
$attachment_ids = $product->get_gallery_image_ids();
$attachment_ids = array_merge($thumb_id,$attachment_ids);
$gallerys = ''; $i = 1;
foreach ( $attachment_ids as $attachment_id ) {
    $image_link = wp_get_attachment_url( $attachment_id );
    if($i == 1) $gallerys .= $image_link;
    else $gallerys .= ','.$image_link;
    $i++;
}
?>
<div class="product-detail">
    <div class="row">
        <div class="<?php echo esc_attr($thumb_class)?>">
            <div class="detail-gallery">
                <div class="wrap-detail-gallery images <?php echo esc_attr($zoom_style)?>">
                    <div class="mid woocommerce-product-gallery__image image-lightbox" data-number="0" data-gallery="<?php echo esc_attr($gallerys)?>">
                        <?php 
                        $srcfull  = wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'full' );
                        $html = get_the_post_thumbnail(get_the_ID(),'woocommerce_single',array('class'=> 'wp-post-image','data-src' => $srcfull));
                        echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( get_the_ID() ) );
                        ?>
                    </div>
                    <?php                    
                    if ( $attachment_ids && has_post_thumbnail() && count($attachment_ids) > 1) {
                    ?>
                    <div class="gallery-control">
                        <a href="#" class="prev"><i class="la la-angle-left"></i></a>
                        <div class="carousel" data-visible="5">
                            <ul class="list-none">
                                <?php
                                $i = 1;
                                foreach ( $attachment_ids as $attachment_id ) {
                                    if($i == 1) $active = 'active';
                                    else $active = '';
                                    $attributes      = array(
                                        'data-src'      => wp_get_attachment_image_url( $attachment_id, 'woocommerce_single' ),
                                        'data-srcset'   => wp_get_attachment_image_srcset( $attachment_id, 'woocommerce_single' ),
                                        'data-srcfull'  => wp_get_attachment_image_url( $attachment_id, 'full' ),
                                        );
                                    $html = wp_get_attachment_image($attachment_id,'woocommerce_thumbnail',false,$attributes );
                                    echo   '<li data-number="'.esc_attr($i).'">
                                                <a title="'.esc_attr( get_the_title( $attachment_id ) ).'" class="'.esc_attr($active).'" href="#">
                                                    '.apply_filters( 'woocommerce_single_product_image_thumbnail_html',$html,$attachment_id).'
                                                </a>
                                            </li>';
                                    $i++;
                                }
                                ?>
                            </ul>
                        </div>
                        <a href="#" class="next"><i class="la la-angle-right"></i></a>
                    </div>
                    <?php
                        do_action( 'woocommerce_product_thumbnails' );
                    }
                    ?>
                </div>
                <?php th_get_template( 'share','',false,true );?>
            </div>
        </div>
        <div class="<?php echo esc_attr($info_class)?>">
            <div class="summary entry-summary detail-info">
                <h2 class="product-title titlelv1"><?php the_title()?></h2>
                <?php
                    do_action( 'woocommerce_single_product_summary' );
                ?>
            </div>
        </div>
    </div>
</div>