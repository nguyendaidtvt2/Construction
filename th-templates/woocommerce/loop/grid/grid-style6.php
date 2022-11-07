
<?php
if(!isset($animation)) $animation = th_get_option('shop_thumb_animation');
if(empty($size)) $size = array(380,380);
// $size = th_size_random($size);
?>	
<?php if(isset($column) && $view == 'grid') echo '<div '.$item_wrap.'>';?>
	<?php echo '<div '.$item_inner.'>';?>
		<div class="item-product item-product-grid item-product-grid-style6 icon">
			<?php do_action( 'woocommerce_before_shop_loop_item' );?>
			<?php if($item_thumbnail == 'yes' && has_post_thumbnail()):?>
				<div class="product-thumb">
					<!-- th_woocommerce_thumbnail_loop have $size and $animation -->
					<?php th_woocommerce_thumbnail_loop($size,$animation);?>			
					<div class="thumb-extra-link style4"> <!-- "",style2,style3 -->
						<?php if($item_button == 'yes') th_addtocart_link(['style' => 'cart-icon2']);?>
						<?php if($item_quickview == 'yes') th_product_quickview('<i class="la la-search"></i><span>'.esc_html__("Quick view","construction").'</span>')?>
						<?php echo th_compare_url('',false, '<span>'.esc_html__("Compare","construction").'</span>');?>
						<?php echo th_wishlist_url('',false, '<span>'.esc_html__("Wishlist","construction").'</span>');?>
					</div>
					<?php if($item_label == 'yes') th_product_label()?>	
					<?php //if($item_price == 'yes') th_get_price_html()?>	
					<?php do_action( 'woocommerce_before_shop_loop_item_title' );?>
				</div>
			<?php endif?>
			<div class="product-info">
				<?php if($item_title == 'yes'):?>
					<h3 class="title14 product-title">
						<a title="<?php echo esc_attr(the_title_attribute(array('echo'=>false)))?>" href="<?php the_permalink()?>"><?php the_title()?></a>
					</h3>
				<?php endif?>
				<?php do_action( 'woocommerce_shop_loop_item_title' );?>
				<?php do_action( 'woocommerce_after_shop_loop_item_title' );?>				
				<?php if($item_price == 'yes') th_get_price_html()?>
				<?php if($item_rate == 'yes') th_get_rating_html()?>
			</div>
			<?php do_action( 'woocommerce_after_shop_loop_item' );?>
		</div>
	</div>
<?php if(isset($column) && $view == 'grid'):?></div><?php endif;?>