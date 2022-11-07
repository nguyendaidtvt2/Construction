<?php
$check_navigation   = th_get_option('post_single_navigation','1');
if($check_navigation == '1'):
	$previous_post = get_previous_post(); 
	$next_post = get_next_post();
?>
<div class="post-control">
	<div class="row">
		<div class=" col-md-6 col-sm-6 col-xs-6"> 
			<div class="post-nav-prev-wrap">
				<?php if(!empty( $previous_post )):?> 
				<h3 class="title14"><?php echo esc_html_e('PREV POST','construction')?></h3>
				<a href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>" class="prev-post"><i class="la la-angle-left"></i> <span><?php echo ''.$previous_post->post_title?></span>
				<?php 
					if( has_post_thumbnail( $previous_post->ID ) ): ?>
					<div class="content-nav_mediatooltip cnmd_leftside"><?php echo get_the_post_thumbnail( $prev_post->ID ) ;?></div>
					<?php endif ;?>
					</a>
				<?php endif;?>
			</div>
		</div>
		<div class=" col-md-6 col-sm-6 col-xs-6"> 
			<div class="post-nav-next-wrap">
				<?php if(!empty( $next_post )):?>
				<h3 class="title14 "><?php echo esc_html_e('NEXT POST','construction')?></h3>
				<a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>" class="next-post"> <span><?php echo ''.$next_post->post_title?></span><i class="la la-angle-right"></i>
				<?php 
					if( has_post_thumbnail( $next_post->ID ) ): ?>
					<div class="content-nav_mediatooltip cnmd_rightside"><?php echo get_the_post_thumbnail( $next_post->ID ) ;?></div>
					<?php endif ;?>
					</a>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>
<?php endif;?>