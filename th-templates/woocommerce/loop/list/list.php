<?php
if(!isset($animation)) $animation = th_get_option('shop_thumb_animation');
if(empty($size_list)) $size_list = array(350,350);
$col_class = 'col-md-12 col-sm-12 col-xs-12';
global $post;
?>
<div class="col-md-12">
    <div class="item-product item-product-list item-list-default">
        <div class="row">
        	<?php do_action( 'woocommerce_before_shop_loop_item' );?>
            <?php if($item_thumbnail == 'yes' && has_post_thumbnail()):?>
                <div class="col-md-4 list-thumb-wrap">
					<div class="product-thumb">
						<!-- th_woocommerce_thumbnail_loop have $size and $animation -->
						<?php th_woocommerce_thumbnail_loop($size_list,$animation);?>
						<div class="thumb-extra-link"> <!-- "",style2,style3 -->
							<?php if($item_quickview == 'yes') th_product_quickview()?>
						</div>
						<?php if($item_label == 'yes') th_product_label()?>
					<?php do_action( 'woocommerce_before_shop_loop_item_title' );?>
					</div>
                </div>
            <?php endif;?>
            <div class="col-md-8 list-info-wrap">
                <div class="product-info">
					<?php if($item_title == 'yes'):?>
						<h3 class="title14 product-title">
							<a title="<?php echo esc_attr(the_title_attribute(array('echo'=>false)))?>" href="<?php the_permalink()?>"><?php the_title()?></a>
						</h3>
					<?php endif?>
					<?php do_action( 'woocommerce_shop_loop_item_title' );?>
					<?php do_action( 'woocommerce_after_shop_loop_item_title' );?>
					<?php if($item_price == 'yes') th_get_price_html()?>
					<?php if($item_rate == 'yes') th_get_rating_html(true,false)?>
					<div class="desc"><?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?></div>
					<?php if($item_button == 'yes'):?>
						<div class="product-extra-link icon">
							<?php 
							$icon_after = $icon = '';
							if(isset($button_icon['value'])){
								$icon = '<i class="'.$button_icon['value'].'"></i>';
								if($button_icon_pos == 'after-text'){
									$icon_after = $icon;
									$icon = '';
								}
							}
							th_addtocart_link([
								'icon'		=>$icon,
								'text'		=>$button_text,
								'icon_after'=>$icon_after,
								'el_class'	=>'button',
							]);
							echo th_compare_url();
							echo th_wishlist_url();
							?>
						</div>
					<?php endif?>
				</div>	
            </div>
            <?php do_action( 'woocommerce_after_shop_loop_item' );?>
        </div>
    </div>
</div>