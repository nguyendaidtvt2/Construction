<?php 
function construction_addons_get_project_ids(){
	$posts = array();
    $post_args = array(
        'post_type'         => 'project',
        'posts_per_page'    => -1,
        'post_status'       => 'publish',
    );
	$get_posts = get_posts($post_args);
	if ( $get_posts ) {
		foreach ( $get_posts as $post ) {
			$posts[ $post->ID ] = $post->post_title; 
		}
		wp_reset_postdata();
	}
    return $posts;

}