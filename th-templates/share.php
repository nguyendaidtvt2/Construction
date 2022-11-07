<?php
$check_share = th_get_option('post_single_share',array());
$check_share_page = th_get_value_by_id('post_single_page_share');
$post_type = get_post_type();
if((isset($check_share[$post_type]) && $check_share[$post_type] == '1') || $check_share_page == '1'):
	$list_default = array(
		array(
			'title'  => esc_html__('Total',"construction"),
		    'social' => 'total',
		    'number' => '1',
			),
		array(
			'title'  => esc_html__('Facebook',"construction"),
		    'social' => 'facebook',
		    'number' => '1',
			),
		array(
			'title'  => esc_html__('Twitter',"construction"),
		    'social' => 'twitter',
		    'number' => '1',
			),
		array(
			'title'  => esc_html__('Google',"construction"),
		    'social' => 'google',
		    'number' => '1',
			),
		array(
			'title'  => esc_html__('Pinterest',"construction"),
		    'social' => 'pinterest',
		    'number' => '1',
			),
		array(
			'title'  => esc_html__('Linkedin',"construction"),
		    'social' => 'linkedin',
		    'number' => '1',
			),
		array(
			'title'  => esc_html__('Tumblr',"construction"),
		    'social' => 'tumblr',
		    'number' => '1',
			),
		array(
			'title'  => esc_html__('Email',"construction"),
		    'social' => 'envelope',
		    'number' => '1',
			),
		);
	$list = th_get_option('post_single_share_list',$list_default);
?>
<div class="single-list-social" data-id="<?php echo esc_attr(get_the_ID())?>">
	<ul class="list-inline-block">
	<?php
		foreach ($list as $value) {
			switch ($value['social']) {
				case 'facebook':
					$number = get_post_meta(get_the_ID(),'total_share_'.$value['social'],true);
					if(empty($number)) $number = 0;
					if($value['number'] == '1') $number_html = '<span class="number">'.esc_html($number).'</span>';
					else $number_html = '';
					echo 	'<li><a target="_blank" data-social="'.esc_attr($value['social']).'" title="'.esc_attr($value['title']).'" href="'.esc_url('http://www.facebook.com/sharer.php?u='.get_the_permalink()).'">
								<span class="share-icon '.esc_attr($value['social']).'-social"><i class="la la-'.esc_attr($value['social']).'" aria-hidden="true"></i>'.$number_html.'</span>
							</a></li>';
					break;

				case 'twitter':
					$number = get_post_meta(get_the_ID(),'total_share_'.$value['social'],true);
					if(empty($number)) $number = 0;
					if($value['number'] == '1') $number_html = '<span class="number">'.esc_html($number).'</span>';
					else $number_html = '';
					echo 	'<li><a target="_blank" data-social="'.esc_attr($value['social']).'" title="'.esc_attr($value['title']).'" href="'.esc_url('http://www.twitter.com/share?url='.get_the_permalink()).'">
								<span class="share-icon '.esc_attr($value['social']).'-social"><i class="la la-'.esc_attr($value['social']).'" aria-hidden="true"></i>'.$number_html.'</span>
							</a></li>';
					break;

				case 'google':
					$number = get_post_meta(get_the_ID(),'total_share_'.$value['social'],true);
					if(empty($number)) $number = 0;
					if($value['number'] == '1') $number_html = '<span class="number">'.esc_html($number).'</span>';
					else $number_html = '';
					echo 	'<li><a target="_blank" data-social="'.esc_attr($value['social']).'" title="'.esc_attr($value['title']).'" href="'.esc_url('https://plus.google.com/share?url='.get_the_permalink()).'">
								<span class="share-icon '.esc_attr($value['social']).'-social"><i class="la la-'.esc_attr($value['social']).'" aria-hidden="true"></i>'.$number_html.'</span>
							</a></li>';
					break;

				case 'pinterest':
					$number = get_post_meta(get_the_ID(),'total_share_'.$value['social'],true);
					if(empty($number)) $number = 0;
					if($value['number'] == '1') $number_html = '<span class="number">'.esc_html($number).'</span>';
					else $number_html = '';
					echo 	'<li><a target="_blank" data-social="'.esc_attr($value['social']).'" title="'.esc_attr($value['title']).'" href="'.esc_url('http://pinterest.com/pin/create/button/?url='.get_the_permalink().'&amp;media='.wp_get_attachment_url(get_post_thumbnail_id())).'">
								<span class="share-icon '.esc_attr($value['social']).'-social"><i class="la la-'.esc_attr($value['social']).'" aria-hidden="true"></i>'.$number_html.'</span>
							</a></li>';
					break;

				case 'envelope':
					$number = get_post_meta(get_the_ID(),'total_share_'.$value['social'],true);
					if(empty($number)) $number = 0;
					if($value['number'] == '1') $number_html = '<span class="number">'.esc_html($number).'</span>';
					else $number_html = '';
					echo 	'<li><a target="_blank" data-social="'.esc_attr($value['social']).'" title="'.esc_attr($value['title']).'" href="mailto:?subject='.esc_attr__("I wanted you to see this site&amp;body=Check out this site","construction").' '.get_the_permalink().'">
								<span class="share-icon '.esc_attr($value['social']).'-social"><i class="la la-'.esc_attr($value['social']).'" aria-hidden="true"></i>'.$number_html.'</span>
							</a></li>';
					break;

				case 'linkedin':
					$number = get_post_meta(get_the_ID(),'total_share_'.$value['social'],true);
					if(empty($number)) $number = 0;
					if($value['number'] == '1') $number_html = '<span class="number">'.esc_html($number).'</span>';
					else $number_html = '';
					echo 	'<li><a target="_blank" data-social="'.esc_attr($value['social']).'" title="'.esc_attr($value['title']).'" href="'.esc_url('https://www.linkedin.com/cws/share?url='.get_the_permalink()).'">
								<span class="share-icon '.esc_attr($value['social']).'-social"><i class="la la-'.esc_attr($value['social']).'" aria-hidden="true"></i>'.$number_html.'</span>
							</a></li>';
					break;

				case 'tumblr':
					$number = get_post_meta(get_the_ID(),'total_share_'.$value['social'],true);
					if(empty($number)) $number = 0;
					if($value['number'] == '1') $number_html = '<span class="number">'.esc_html($number).'</span>';
					else $number_html = '';
					echo 	'<li><a target="_blank" data-social="'.esc_attr($value['social']).'" title="'.esc_attr($value['title']).'" href="'.esc_url('https://www.tumblr.com/widgets/share/tool?canonicalUrl='.get_the_permalink().'&amp;title='.get_the_title()).'">
								<span class="share-icon '.esc_attr($value['social']).'-social"><i class="la la-'.esc_attr($value['social']).'" aria-hidden="true"></i>'.$number_html.'</span>
							</a></li>';
					break;
				
				default:
					$number = get_post_meta(get_the_ID(),'total_share',true);
					if(empty($number)) $number = 0;
					if($value['number'] == '1') $number_html = '<span class="number">'.esc_html($number).'</span>';
					else $number_html = '';
					echo '<li><span class="share-icon total-share"><i class="la la-share-alt" aria-hidden="true"></i>'.$number_html.'</span></li>';
					break;
			}			
		}
	?>
	</ul>
</div>
<?php endif;?>