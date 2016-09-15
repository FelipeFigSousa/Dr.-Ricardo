<?php
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if(!class_exists('g5plusFramework_Shortcode_Countdown')){
    class g5plusFramework_Shortcode_Countdown {
        function __construct() {
            add_action( 'init', array($this, 'register_post_types' ), 6 );
            add_shortcode('megatron_countdown_shortcode', array($this, 'megatron_countdown_shortcode' ));
            add_filter( 'rwmb_meta_boxes', array($this,'megatron_register_meta_boxes' ));
        }

        function register_post_types() {
            if ( post_type_exists('countdown') ) {
                return;
            }
            register_post_type('countdown',
                array(
                    'label' => esc_html__('Countdown','g5plus-megatron'),
                    'description' => esc_html__( 'Countdown Description', 'g5plus-megatron' ),
                    'labels' => array(
                        'name'					=>'Countdown',
                        'singular_name' 		=> 'Countdown',
                        'menu_name'    			=> esc_html__( 'Countdown', 'g5plus-megatron' ),
                        'parent_item_colon'  	=> esc_html__( 'Parent Item:', 'g5plus-megatron' ),
                        'all_items'          	=> esc_html__( 'All Countdown', 'g5plus-megatron' ),
                        'view_item'          	=> esc_html__( 'View Item', 'g5plus-megatron' ),
                        'add_new_item'       	=> esc_html__( 'Add New Countdown', 'g5plus-megatron' ),
                        'add_new'            	=> esc_html__( 'Add New', 'g5plus-megatron' ),
                        'edit_item'          	=> esc_html__( 'Edit Item', 'g5plus-megatron' ),
                        'update_item'        	=> esc_html__( 'Update Item', 'g5plus-megatron' ),
                        'search_items'       	=> esc_html__( 'Search Item', 'g5plus-megatron' ),
                        'not_found'          	=> esc_html__( 'Not found', 'g5plus-megatron' ),
                        'not_found_in_trash' 	=> esc_html__( 'Not found in Trash', 'g5plus-megatron' ),
                    ),
                    'supports'    => array( 'title', 'editor', 'comments', 'thumbnail'),
                    'public'      => true,
                    'menu_icon' => 'dashicons-clock',
                    'has_archive' => true
                )
            );
        }

        function megatron_countdown_shortcode($atts){
            $layout_style = $el_class= '';
            extract( shortcode_atts( array(
                'layout_style'     => 'square',
                'el_class' => ''
            ), $atts ) );

            $plugin_path =  untrailingslashit( plugin_dir_path( __FILE__ ) );
            $template_path = $plugin_path . '/templates/comming-soon-'.$layout_style .'.php';
            ob_start();
            include($template_path);
            $ret = ob_get_contents();
            ob_end_clean();
            return $ret;
        }

        function megatron_register_meta_boxes($meta_boxes){
            $meta_boxes[] = array(
                'title'  => esc_html__( 'Countdown Option', 'g5plus-megatron' ),
                'id'     => 'megatron-meta-box-countdown-opening',
                'pages'  => array( 'countdown' ),
                'fields' => array(
                    array(
                        'name' => esc_html__( 'Opening hours', 'g5plus-megatron' ),
                        'id'   => 'countdown-opening',
                        'type' => 'datetime',
                    ),
                     array(
                         'name' => esc_html__( 'Type', 'g5plus-megatron' ),
                         'id'   => 'countdown-type',
                         'type' => 'select',
                         'options'  => array(
                             'comming-soon' => esc_html__('Coming Soon','g5plus-megatron'),
                             'under-construction' => esc_html__('Under Construction','g5plus-megatron')
                         )
                     ),
                    array(
                        'name' => esc_html__( 'Url redirect (after countdown completed)', 'g5plus-megatron' ),
                        'id'   => 'countdown-url',
                        'type' => 'textarea',
                    )
                )
            );
            return $meta_boxes;
        }
    }
    new g5plusFramework_Shortcode_Countdown();
}