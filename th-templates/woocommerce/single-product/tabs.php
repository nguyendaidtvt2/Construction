<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$tabs = apply_filters( 'woocommerce_product_tabs', array() );
$tab_style = th_get_value_by_id('product_tab_detail');
if ( ! empty( $tabs ) ) : ?>

	<div class="detail-tabs <?php echo esc_attr($tab_style)?>">
		<div class="detail-tab-title">
			<ul class="list-tag-detail list-none font-bold nav nav-tabs" role="tablist">
				<?php 
				$i = 1;
				foreach ( $tabs as $key => $tab ) :
					if($i == 1) $active = 'active';
					else $active = '';
					$i++;
				?>
					<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>">
						<a class="<?php echo esc_attr($active)?>" href="#tab-<?php echo esc_attr( $key ); ?>" data-target="#tab-<?php echo esc_attr( $key ); ?>" data-toggle="tab" aria-expanded="false">
							<?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="detail-tab-content">
			<div class="tab-content">
				<?php 
				$i = 1;
				foreach ( $tabs as $key => $tab ) : 
					if($i == 1) $active = 'active';
					else $active = '';
					$i++;
				?>
					<div id="tab-<?php echo esc_attr( $key ); ?>" class="tab-pane <?php echo esc_attr($active)?>">
						<div class="detail-tab-desc">
							<?php if ( isset( $tab['callback'] ) ) { call_user_func( $tab['callback'], $key, $tab ); } ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

<?php endif; ?>
