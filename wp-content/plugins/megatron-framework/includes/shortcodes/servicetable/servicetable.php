<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
// Include post types
global $servicetable_metabox;
$servicetable_metabox = new WPAlchemy_MetaBox(array
(
    'id' => 'megatron_servicetable_settings',
    'title' => esc_html__('Service Table Settings', 'g5plus-megatron'),
    'template' => plugin_dir_path( __FILE__ ) . 'custom-field.php',
    'types' => array('servicetable'),
    'autosave' => TRUE,
    'priority' => 'high',
    'context' => 'normal',
    'hide_editor' => TRUE
));
add_filter( 'wp_insert_post_data' , 'service_table_filter_post_data' , '99', 2 );
function service_table_filter_post_data( $data , $postarr ) {
    if ( 'servicetable' != $data['post_type'] ) {
        return $data;
    }
    if(!empty($postarr['megatron_servicetable_settings']))
    {
        for	($i = 0; $i < count($postarr['megatron_servicetable_settings']['features']) ; $i++) {
            if (!empty($_POST['megatron_servicetable_settings']['features'][$i]['planfeatures'])) {
                $_POST['megatron_servicetable_settings']['features'][$i]['planfeatures'] = str_replace("\r\n","\n", $_POST['megatron_servicetable_settings']['features'][$i]['planfeatures']);
                $_POST['megatron_servicetable_settings']['features'][$i]['planfeatures'] = str_replace("\n","||", $_POST['megatron_servicetable_settings']['features'][$i]['planfeatures']);
            }
        }
    }
    return $data;
}
if(!class_exists('g5plusFramework_Shortcode_Servicetable')){
    class g5plusFramework_Shortcode_Servicetable{
        function __construct(){
            add_action('init', array($this, 'register_post_types'), 5);
            add_shortcode('megatron_servicetable', array($this, 'servicetable_shortcode'));
            if (is_admin()) {
                add_action('admin_menu', array($this, 'addMenuChangeSlug'));
            }
        }
        function register_post_types()
        {
            $post_type = 'servicetable';

            if ( post_type_exists($post_type) ) {
                return;
            }

            $post_type_slug = get_option('g5plus-megatron-' . $post_type . '-config');
            if (!isset($post_type_slug) || !is_array($post_type_slug)) {
                $slug = 'servicetable';
                $name = $singular_name = 'Service Table';
            } else {
                $slug = $post_type_slug['slug'];
                $name = $post_type_slug['name'];
                $singular_name = $post_type_slug['singular_name'];
            }

            register_post_type($post_type,
                array(
                    'label' => esc_html__('Service Table','g5plus-megatron'),
                    'description' => esc_html__( 'Service Table Description', 'g5plus-megatron' ),
                    'labels' => array(
                        'name'					=> $name,
                        'singular_name' 		=> $singular_name,
                        'menu_name'    			=> $name,
                        'parent_item_colon'  	=> esc_html__( 'Parent Item:', 'g5plus-megatron' ),
                        'all_items'          	=> sprintf(esc_html__('All %s', 'g5plus-megatron' ), $name),
                        'view_item'          	=> esc_html__( 'View Item', 'g5plus-megatron' ),
	                    'add_new_item'       	=> sprintf(esc_html__( 'Add New %s', 'g5plus-megatron' ), $name),
                        'add_new'            	=> esc_html__( 'Add New', 'g5plus-megatron' ),
                        'edit_item'          	=> esc_html__( 'Edit Item', 'g5plus-megatron' ),
                        'update_item'        	=> esc_html__( 'Update Item', 'g5plus-megatron' ),
                        'search_items'       	=> esc_html__( 'Search Item', 'g5plus-megatron' ),
                        'not_found'          	=> esc_html__( 'Not found', 'g5plus-megatron' ),
                        'not_found_in_trash' 	=> esc_html__( 'Not found in Trash', 'g5plus-megatron' ),
                    ),
                    'supports'    => array( 'title','revisions'),
                    'public'      => true,
                    'show_ui'     => true,
                    '_builtin'    => false,
                    'has_archive' => true,
                    'rewrite'     => array('slug' => $slug, 'with_front' => true),
                )
            );
            flush_rewrite_rules();
        }
        function addMenuChangeSlug()
        {
            add_submenu_page('edit.php?post_type=servicetable', 'Setting', 'Settings', 'edit_posts', wp_basename(__FILE__), array($this, 'initPageSettings'));
        }

        function initPageSettings()
        {
            $template_path = ABSPATH . 'wp-content/plugins/megatron-framework/includes/shortcodes/posttype-settings/settings.php';
            if (file_exists($template_path))
                include_once $template_path;
        }

        function service_table_features_to_html ($plan_features)
        {
            // the string to be returned
            $html = '';

            // explode string into a useable array
            $features = explode("||", $plan_features);

            //how many features does this column have?
            $this_columns_number_of_features = count($features);

            for ($i=0; $i<$this_columns_number_of_features; $i++) {
                $html .= '<li><span>' . str_replace(array("\n", "\r"), '', wp_kses_post($features[$i])) . '</span></li>';
            }

            return $html;
        }
        function servicetable_shortcode($atts){
	        /**
	         * Shortcode attributes
	         * @var $layout_style
	         * @var $column
	         * @var $is_slider
             * @var $nav
             * @var $dots
	         * @var $post_name
	         * @var $el_class
	         * @var $css_animation
	         * @var $duration
	         * @var $delay
	         */
            $layout_style=$column=$is_slider=$nav=$dots=$post_name=$el_class=$css_animation=$duration=$delay='';
	        $atts = vc_map_get_attributes( 'megatron_servicetable', $atts );
	        extract( $atts );
	        $g5plus_options = &megatron_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('megatron_servicetable_css', plugins_url('megatron-framework/includes/shortcodes/servicetable/assets/css/servicetable' . $min_suffix_css . '.css'), array(), false);
	        $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            global $servicetable_metabox;
            global $meta;
            $pt_post = get_posts( array(
                'posts_per_page'   	=> 1,
                'name'      => $post_name,
                'post_type'      => 'servicetable',
                'post_status'      	=> 'publish'
            ) );
            if(count($pt_post)<1)
            {
                return "";
            }
            $pt_post=$pt_post[0];
            $meta = get_post_meta($pt_post->ID, $servicetable_metabox->get_the_id(), TRUE);
            ob_start();
            $class_col='col-md-'.(12/esc_attr($column)).' col-sm-6 sm-margin-bottom-30 ';?>
            <div class="servicetable <?php echo esc_attr($layout_style) ?><?php echo esc_attr($g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                    <?php if($is_slider=='yes'):
                        $class_col='';
                        $dots = ($dots == 'yes') ? 'true' : 'false';
                        $nav = ($nav == 'yes') ? 'true' : 'false';
                        $data_carousel = '"autoplay": true,"loop":true,"center":false,"margin":30,"autoplayHoverPause":true, "items":' . $column . ',"dots":' . $dots . ', "nav":' . $nav;
                        $data_carousel .= ',"responsive": {"0":{"items": 1},"600":{"items": 1},"768":{"items": 2},"980":{"items": 3},"1200":{"items": ' . $column . '}}';
                    ?>
                        <div class="owl-g5plus-shortcode owl-carousel" data-plugin-options='{<?php echo esc_attr($data_carousel) ?>}'>
                    <?php else:?>
                        <div class="row">
                    <?php endif;
                    foreach ($meta['features'] as $col)
                    {
                        $planname = isset($col['planname'])?$col['planname']:'';
                        $planicon = isset($col['planicon'])?$col['planicon']:'';
                        $plantext = isset($col['plantext'])?$col['plantext']:'';
                        $plansubtext = isset($col['plansubtext'])?$col['plansubtext']:'';
                        $planfeatures = isset($col['planfeatures'])?$col['planfeatures']:'';
                        $buttonurl = isset($col['buttonurl'])?$col['buttonurl']:'';
                        $buttontext = isset($col['buttontext'])?$col['buttontext']:'';
                        if(isset($col['feature'])) {
                            if ($col['feature'] == "featured") {
                                $feature = " pt-active";
                            } else {
                                $feature = '';
                            }
                        } else {
                            $feature = '';
                        }
                        ?>
                        <div class="<?php echo esc_attr($class_col) ?>pt-item <?php echo esc_attr($feature) ?>">
                            <div class="pt-content">
                                <div><span><?php echo esc_html($planname) ?></span></div>
                                <i class="<?php echo esc_attr($planicon) ?>"></i>
                                <h6><?php echo wp_kses_post($plantext) ?></h6>
                                <p><?php echo wp_kses_post($plansubtext) ?></p>
                                <ul><?php echo sprintf('%s', $this->service_table_features_to_html($planfeatures)) ?></ul>
                                <a class="m-button m-button-primary m-button-xs m-button-3d" href="<?php echo esc_url($buttonurl) ?>" title="<?php echo esc_attr($buttontext) ?>"><?php echo esc_html($buttontext) ?></a>
                            </div>
                        </div>
                    <?php
                    }?>
                </div>
            </div>
            <?php $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_Shortcode_Servicetable();
}