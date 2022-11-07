<?php
add_action( 'elementor/widgets/widgets_registered', function( $widgets_manager ) {
    $elements = array(
        'image_box', 
        'section_title',
        'projects_grid',
        'members_slider'
    );

    foreach ( $elements as $element_name ) {
        $template_file = get_template_directory().'/inc/elementor/'.$element_name.'.php';
   
        if ( $template_file && is_readable( $template_file ) ) {

            require_once $template_file;
            $class_name = '\Elementor\Th_' . ucwords($element_name,'_');  
            $widgets_manager->register_widget_type( new $class_name() );
        }
            
    }
} );
