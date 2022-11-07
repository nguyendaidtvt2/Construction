<?php
if(!isset($animation)) $animation = th_get_option('shop_thumb_animation');
if(empty($size)) $size = array(380,380);
?>	
<?php if(isset($column) && $view == 'grid'):?><?php echo '<div '.$item_wrap.'>';?><?php endif;?>
	<?php echo '<div '.$item_inner.'>';?>
		<div class="item-product item-product-default">
			<?php do_action( 'woocommerce_before_shop_loop_item' );?>
			<?php if($item_thumbnail == 'yes' && has_post_thumbnail()):?>
				<div class="product-thumb">
					<!-- th_woocommerce_thumbnail_loop have $size and $animation -->
					<?php th_woocommerce_thumbnail_loop($size,$animation);?>
						<?php if($item_quickview == 'yes') th_product_quickview()?>
					<?php if($item_label == 'yes') th_product_label()?>
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
				<?php if($item_rate == 'yes') th_get_rating_html(true,false)?>
				<?php if($item_button == 'yes'):?>
					<div class="product-extra-link addcart-link-wrap">
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
						?>
					</div>
				<?php endif?>
			</div>
			<?php do_action( 'woocommerce_after_shop_loop_item' );?>		
		</div>		
	</div>
<?php if(isset($column) && $view == 'grid'):?></div><?php endif;?>