<?php
$orderby = 'rand';
$order = 'desc';
$limit = 6;
$cross_sells = array_filter( array_map( 'wc_get_product', WC()->cart->get_cross_sells() ), 'wc_products_array_filter_visible' );
// Handle orderby and limit results.
$orderby     = apply_filters( 'woocommerce_cross_sells_orderby', $orderby );
$order       = apply_filters( 'woocommerce_cross_sells_order', $order );
$cross_sells = wc_products_array_orderby( $cross_sells, $orderby, $order );
$limit       = apply_filters( 'woocommerce_cross_sells_total', $limit );
$cross_sells = $limit > 0 ? array_slice( $cross_sells, 0, $limit ) : $cross_sells;
extract(th_show_single_product_data());
if ( $cross_sells ) : ?>

    <div class="cross-sells related-product">
        <h2 class="title18 font-bold text-uppercase single-title"><?php esc_html_e( 'You may be interested in&hellip;', 'construction' ) ?></h2>
        <div class="product-slider cross-sell-slider">
            <?php echo '<div class="wrap-item group-navi smart-slider owl-carousel owl-theme" data-item="" data-speed="" data-itemres="0:1,480:2,768:3,990:4" data-navigation="true">';?>

                <?php woocommerce_product_loop_start(); ?>

                <?php foreach ( $cross_sells as $cross_sell ) : ?>

                    <?php
                    $post_object = get_post( $cross_sell->get_id() );

                    setup_postdata( $GLOBALS['post'] =& $post_object );

                    th_get_template_woocommerce('loop/grid/grid',$item_style,array('size'=>$size),true);?>

                <?php endforeach; ?>

                <?php woocommerce_product_loop_end(); ?>

            </div>
        </div>
    </div>

<?php endif;

wp_reset_postdata();
