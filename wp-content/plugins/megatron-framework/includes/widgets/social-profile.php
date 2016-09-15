<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 3/26/15
 * Time: 5:24 PM
 */
class G5plus_Social_Profile extends  G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-social-profile';
        $this->widget_description =  esc_html__( "Social profile widget", 'g5plus-megatron' );
        $this->widget_id          = 'g5plus-social-profile';
        $this->widget_name        = esc_html__( 'G5Plus: Social Profile', 'g5plus-megatron' );
        $this->settings           = array(
            'title' => array(
		        'type' => 'text',
		        'std' => '',
		        'label' => esc_html__('Title','g5plus-megatron')
            ),
	        'layout'  => array(
                'type'    => 'select',
                'std'     => 's-default',
                'label'   => esc_html__( 'Layout', 'g5plus-megatron' ),
                'options' => array(
                    's-default'  => esc_html__( 'Default', 'g5plus-megatron' ),
                    's-rounded'  => esc_html__( 'Rounded', 'g5plus-megatron' ),
	                's-icon-text'  => esc_html__( 'Icon And Text', 'g5plus-megatron' ),
                )
            ),
	        'scheme'  => array(
		        'type'    => 'select',
		        'std'     => 's-primary',
		        'label'   => esc_html__( 'Scheme', 'g5plus-megatron' ),
		        'options' => array(
			        's-scheme-default' => esc_html__( 'Default', 'g5plus-megatron' ),
			        's-primary' => esc_html__( 'Primary', 'g5plus-megatron' ),
			        's-secondary' => esc_html__( 'Secondary', 'g5plus-megatron' ),
			        's-light' => esc_html__( 'Light (#FFF)', 'g5plus-megatron' ),
			        's-dark'  => esc_html__( 'Dark (#000)', 'g5plus-megatron' ),
			        's-gray'  => esc_html__( 'Gray (#777)', 'g5plus-megatron' ),
			        's-light-gray-1'  => esc_html__( 'Light Gray 1 (#CCC)', 'g5plus-megatron' ),
			        's-light-gray-2'  => esc_html__( 'Light Gray 2 (#BBB)', 'g5plus-megatron' ),
			        's-light-gray-3'  => esc_html__( 'Light Gray 3 (#BABABA)', 'g5plus-megatron' ),
			        's-dark-gray-1'  => esc_html__( 'Dark Gray 1 (#444)', 'g5plus-megatron' ),
			        's-dark-gray-2'  => esc_html__( 'Dark Gray 2 (#666)', 'g5plus-megatron' ),
			        's-dark-gray-3'  => esc_html__( 'Dark Gray 3 (#888)', 'g5plus-megatron' ),
		        )
	        ),
	        'size'  => array(
		        'type'    => 'select',
		        'std'     => 's-medium',
		        'label'   => esc_html__( 'Size', 'g5plus-megatron' ),
		        'options' => array(
			        's-md'  => esc_html__( 'Medium', 'g5plus-megatron' ),
			        's-lg'  => esc_html__( 'Large', 'g5plus-megatron' ),
		        )
	        ),

            'icons' => array(
                'type'  => 'multi-select',
                'label'   => esc_html__( 'Select social profiles', 'g5plus-megatron' ),
                'std'   => '',
	            'options' => array(
		            'twitter'  => esc_html__( 'Twitter', 'g5plus-megatron' ),
		            'facebook'  => esc_html__( 'Facebook', 'g5plus-megatron' ),
		            'dribbble'  => esc_html__( 'Dribbble', 'g5plus-megatron' ),
		            'vimeo'  => esc_html__( 'Vimeo', 'g5plus-megatron' ),
		            'tumblr'  => esc_html__( 'Tumblr', 'g5plus-megatron' ),
		            'skype'  => esc_html__( 'Skype', 'g5plus-megatron' ),
		            'linkedin'  => esc_html__( 'LinkedIn', 'g5plus-megatron' ),
		            'googleplus'  => esc_html__( 'Google+', 'g5plus-megatron' ),
		            'flickr'  => esc_html__( 'Flickr', 'g5plus-megatron' ),
		            'youtube'  => esc_html__( 'YouTube', 'g5plus-megatron' ),
		            'pinterest' => esc_html__( 'Pinterest', 'g5plus-megatron' ),
		            'foursquare'  => esc_html__( 'Foursquare', 'g5plus-megatron' ),
		            'instagram' => esc_html__( 'Instagram', 'g5plus-megatron' ),
		            'github'  => esc_html__( 'GitHub', 'g5plus-megatron' ),
		            'xing' => esc_html__( 'Xing', 'g5plus-megatron' ),
		            'behance'  => esc_html__( 'Behance', 'g5plus-megatron' ),
		            'deviantart'  => esc_html__( 'Deviantart', 'g5plus-megatron' ),
		            'soundcloud'  => esc_html__( 'SoundCloud', 'g5plus-megatron' ),
		            'yelp'  => esc_html__( 'Yelp', 'g5plus-megatron' ),
		            'rss'  => esc_html__( 'RSS Feed', 'g5plus-megatron' ),
		            'email'  => esc_html__( 'Email address', 'g5plus-megatron' ),
	            )
            )
        );
        if(function_exists('vc_map')){
            add_shortcode('g5plusframework_widget_social_profile', array($this, 'vc_widget'));
        }
        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
	    $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
        $layout         = ( ! empty( $instance['layout'] ) ) ? $instance['layout'] : 's-default';
	    $scheme        = ( ! empty( $instance['scheme'] ) ) ? $instance['scheme'] : 's-primary';
	    $size        = ( ! empty( $instance['size'] ) ) ? $instance['size'] : 's-md';
	    $icons        = ( ! empty( $instance['icons'] ) ) ? $instance['icons'] : '';

	    $class_wrap = 'social-profile '. $layout . ' ' . $scheme . ' ' .$size;

	    $social_icons = g5plus_get_social_icon($icons,$class_wrap );

	    echo wp_kses_post($args['before_widget']);
		if ($title) {
			echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
		}
	    echo wp_kses_post( $social_icons );
	    echo wp_kses_post($args['after_widget']);
    }

    function vc_widget($atts){
        $attributes = vc_map_get_attributes( 'g5plusframework_widget_social_profile', $atts );
        $args = array();
        $args['widget_id'] = 'g5plus-social-profile';
        $attributes['icons'] = str_replace(',','||',$attributes['icons'] );
        the_widget('G5plus_Social_Profile',$attributes,$args);
    }
}
if (!function_exists('g5plus_register_social_profile')) {
    function g5plus_register_social_profile() {
        register_widget('G5plus_Social_Profile');

        if(function_exists('vc_map')){
            vc_map( array(
                'name' => esc_html__( 'G5Plus Social Profile','g5plus-megatron' ),
                'base' => 'g5plusframework_widget_social_profile',
                'icon' => 'fa fa-share-square-o',
                'category' => esc_html__( 'Megatron Widgets', 'g5plus-megatron' ),
                'class' => 'wpb_vc_wp_widget',
                'weight' => - 50,
                'description' => esc_html__( 'Social icon for your site', 'g5plus-megatron' ),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Title', 'g5plus-megatron' ),
                        'param_name' => 'title'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Layout', 'g5plus-megatron' ),
                        'param_name' => 'layout',
                        'value' => array(
                            esc_html__( 'Default', 'g5plus-megatron' ) => 's-default'  ,
                            esc_html__( 'Rounded', 'g5plus-megatron' ) => 's-rounded'  ,
                            esc_html__( 'Icon And Text', 'g5plus-megatron' ) => 's-icon-text'  ,
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Scheme', 'g5plus-megatron' ),
                        'param_name' => 'scheme',
                        'std' => 's-primary',
                        'value' => array(
                            esc_html__( 'Default', 'g5plus-megatron' ) => 's-scheme-default' ,
                            esc_html__( 'Primary', 'g5plus-megatron' ) => 's-primary' ,
                            esc_html__( 'Secondary', 'g5plus-megatron' ) => 's-secondary' ,
                            esc_html__( 'Light (#FFF)', 'g5plus-megatron' ) => 's-light' ,
                            esc_html__( 'Dark (#000)', 'g5plus-megatron' ) => 's-dark'  ,
                            esc_html__( 'Gray (#777)', 'g5plus-megatron' ) => 's-gray'  ,
                            esc_html__( 'Light Gray 1 (#CCC)', 'g5plus-megatron' ) => 's-light-gray-1'  ,
                            esc_html__( 'Light Gray 2 (#BBB)', 'g5plus-megatron' ) => 's-light-gray-2'  ,
                            esc_html__( 'Light Gray 3 (#BABABA)', 'g5plus-megatron' ) => 's-light-gray-3'  ,
                            esc_html__( 'Dark Gray 1 (#444)', 'g5plus-megatron' ) => 's-dark-gray-1'  ,
                            esc_html__( 'Dark Gray 2 (#666)', 'g5plus-megatron' ) => 's-dark-gray-2' ,
                            esc_html__( 'Dark Gray 3 (#888)', 'g5plus-megatron' ) => 's-dark-gray-3'  ,
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Size', 'g5plus-megatron' ),
                        'param_name' => 'size',
                        'std' => 's-md',
                        'value' => array(
                            esc_html__( 'Medium', 'g5plus-megatron' ) => 's-md'  ,
                            esc_html__( 'Large', 'g5plus-megatron' ) => 's-lg'
                        )
                    ),
                    array(
                        'type' => 'multi-select',
                        'heading' => esc_html__( 'Icons', 'g5plus-megatron' ),
                        'admin_label' => true,
                        'param_name' => 'icons',
                        'options' => array(
                            esc_html__( 'Twitter', 'g5plus-megatron' ) => 'twitter'  ,
                            esc_html__( 'Facebook', 'g5plus-megatron' ) => 'facebook'  ,
                            esc_html__( 'Dribbble', 'g5plus-megatron' ) => 'dribbble'  ,
                            esc_html__( 'Vimeo', 'g5plus-megatron' ) => 'vimeo'  ,
                            esc_html__( 'Tumblr', 'g5plus-megatron' ) => 'tumblr'  ,
                            esc_html__( 'Skype', 'g5plus-megatron' ) => 'skype'  ,
                            esc_html__( 'LinkedIn', 'g5plus-megatron' ) => 'linkedin' ,
                            esc_html__( 'Google+', 'g5plus-megatron' ) => 'googleplus' ,
                            esc_html__( 'Flickr', 'g5plus-megatron' ) => 'flickr'  ,
                            esc_html__( 'YouTube', 'g5plus-megatron' ) => 'youtube'  ,
                            esc_html__( 'Pinterest', 'g5plus-megatron' ) => 'pinterest' ,
                            esc_html__( 'Foursquare', 'g5plus-megatron' ) => 'foursquare'  ,
                            esc_html__( 'Instagram', 'g5plus-megatron' ) => 'instagram' ,
                            esc_html__( 'GitHub', 'g5plus-megatron' ) => 'github'  ,
                            esc_html__( 'Xing', 'g5plus-megatron' ) => 'xing' ,
                            esc_html__( 'Behance', 'g5plus-megatron' ) => 'behance'  ,
                            esc_html__( 'Deviantart', 'g5plus-megatron' ) => 'deviantart'  ,
                            esc_html__( 'SoundCloud', 'g5plus-megatron' ) => 'soundcloud'  ,
                            esc_html__( 'Yelp', 'g5plus-megatron' ) => 'yelp' ,
                            esc_html__( 'RSS Feed', 'g5plus-megatron' ) => 'rss'  ,
                            esc_html__( 'Email address', 'g5plus-megatron' ) => 'email'  ,
                        )
                    ),
                )
            ) );
        }
    }
    add_action('widgets_init', 'g5plus_register_social_profile', 1);
}