<?php
$check_author   = th_get_option('post_single_author','1');
$des 			= get_the_author_meta('description');
if(!empty($des) && $check_author == '1'):
    $user_info = get_userdata(get_the_author_meta( 'ID' ));
?>
<div class="single-info-author table-custom">
	<div class="author-thumb">
		<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>">
            <?php echo get_avatar(get_the_author_meta('email'),'300'); ?>
        </a>
	</div>
	<div class="author-info">
		<h3 class="titlelv3 font-bold">
			<a class="black" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo get_the_author(); ?></a>
		</h3>
		<p class="desc"><?php echo get_the_author_meta('description'); ?></p>
		<div class="author-social">
			<?php
                global $post;
                $sl=array(
                    'googleplus'    =>  "la la-google-plus",
                    'facebook'      =>  "la la-facebook",
                    'twitter'       =>  "la la-twitter",
                    'linkedin'      =>  "la la-linkedin",
                    'pinterest'     =>  "la la-pinterest",
                    'github'        =>  'la la-github',
                    'tumblr'        =>  'la la-tumblr',
                    'youtube'       =>  'la la-youtube',
                    'instagram'     =>  'la la-instagram',
                    'vimeo'         =>  'la la-vimeo'
                );
                if(isset($post->post_author)){
                    foreach($sl as $type=>$class){
                        $url  = get_user_option( $type, $post->post_author );
                        if($url==true){?>
                            <a href="<?php echo esc_url($url);?>" class="silver"><i class="<?php echo esc_attr($class);?>"></i></a>
                        <?php }
                    }
                }
            ?>
		</div>
	</div>
</div>
<?php endif;?>