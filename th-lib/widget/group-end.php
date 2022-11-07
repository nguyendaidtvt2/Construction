<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 24/12/15
 * Time: 10:20 AM
 */
if(!class_exists('th_Group_End'))
{
    class Th_Group_End extends WP_Widget {


        protected $default=array();

        static function _init()
        {
            add_action( 'widgets_init', array(__CLASS__,'_add_widget') );
        }

        static function _add_widget()
        {
            if(function_exists('th_reg_widget')) th_reg_widget( 'th_Group_End' );
        }

        function __construct() {
            // Instantiate the parent object
            parent::__construct( false, esc_html__('Group end','construction'),
                array( 'description' => esc_html__( 'End a Group', 'construction' ), ));

            $this->default=array();
        }



        function widget( $args, $instance ) {
            // Widget output
            echo '</div>';
        }

        function update( $new_instance, $old_instance ) {}

        function form( $instance ) {}
    }

    th_Group_End::_init();

}
