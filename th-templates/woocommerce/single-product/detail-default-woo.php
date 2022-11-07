<?php
th_set_post_view();
$thumb_class = 'col-md-5 col-sm-12 col-xs-12';
$info_class = 'col-md-7 col-sm-12 col-xs-12';
?>
<div class="product-detail">
    <div class="row">
        <div class="<?php echo esc_attr($thumb_class)?>">
            <div class="detail-gallery">
                <?php do_action( 'woocommerce_before_single_product_summary' );?>
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