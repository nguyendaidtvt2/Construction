<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!class_exists('Th_HeaderController'))
{
    class Th_HeaderController{

        static function _init()
        {
            if(function_exists('stp_reg_post_type'))
            {
                add_action('init',array(__CLASS__,'_add_post_type'));
            }
        }

        static function _add_post_type()
        {
            $labels = array(
                'name'               => esc_html__('Header Page','construction'),
                'singular_name'      => esc_html__('Header Page','construction'),
                'menu_name'          => esc_html__('Header Page','construction'),
                'name_admin_bar'     => esc_html__('Header Page','construction'),
                'add_new'            => esc_html__('Add New','construction'),
                'add_new_item'       => esc_html__( 'Add New Header','construction' ),
                'new_item'           => esc_html__( 'New Header', 'construction' ),
                'edit_item'          => esc_html__( 'Edit Header', 'construction' ),
                'view_item'          => esc_html__( 'View Header', 'construction' ),
                'all_items'          => esc_html__( 'All Header', 'construction' ),
                'search_items'       => esc_html__( 'Search Header', 'construction' ),
                'parent_item_colon'  => esc_html__( 'Parent Header:', 'construction' ),
                'not_found'          => esc_html__( 'No Header found.', 'construction' ),
                'not_found_in_trash' => esc_html__( 'No Header found in Trash.', 'construction' )
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'th_header' ),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,
                'menu_icon'          => get_template_directory_uri() . "/assets/admin/image/header-icon.png",
                'supports'           => array( 'title', 'editor', 'revisions' )
            );

            stp_reg_post_type('th_header',$args);
        }
    }

    Th_HeaderController::_init();

}