<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 5/28/2015
 * Time: 5:44 PM
 */
if (!class_exists('g5plusFramework_Shortcodes')) {
    class g5plusFramework_Shortcodes
    {

        private static $instance;

        public static function init()
        {
            if (!isset(self::$instance)) {
                self::$instance = new g5plusFramework_Shortcodes;
                add_action('init', array(self::$instance, 'includes'), 0);
                add_action('init', array(self::$instance, 'register_vc_map'), 10);
            }
            return self::$instance;
        }

        public function includes()
        {
            if(!class_exists('Vc_Manager')){
                return;
            }
            $g5plus_options = &megatron_get_options_config();
            $cpt_disable = isset($g5plus_options['cpt-disable']) ? $g5plus_options['cpt-disable'] : array();
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/expandable/expandable.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/slider-container/slider-container.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/vertical-progress-bar/vertical-progress-bar.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/heading/heading.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/button/button.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/icon-box/icon-box.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/list/list.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/partner-carousel/partner-carousel.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/post/post.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/process/process.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/call-action/call-action.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/counter/counter.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/testimonial/testimonial.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/banner/banner.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/cover-box/cover-box.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/social-icon/social-icon.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/google-map/google-map.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/image-slider/image-slider.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/video/video.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/video-bg/video-bg.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/feature/feature.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/mailchimp/mailchimp.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/view-demo/view-demo.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/image-box/image-box.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/menu-scroll/menu-scroll.php');

            if (!isset($cpt_disable)  || (array_key_exists('pricingtable', $cpt_disable) && ($cpt_disable['pricingtable'] == '0' || $cpt_disable['pricingtable'] == ''))) {
                include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/pricingtable/pricingtable.php');
            }
            if (!isset($cpt_disable)  || (array_key_exists('servicetable', $cpt_disable) && ($cpt_disable['servicetable'] == '0' || $cpt_disable['servicetable'] == ''))) {
                include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/servicetable/servicetable.php');
            }
            if (!isset($cpt_disable) || (array_key_exists('ourteam', $cpt_disable) && ($cpt_disable['ourteam'] == '0' || $cpt_disable['ourteam'] == ''))) {
                include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/ourteam/ourteam.php');
            }
            if (!isset($cpt_disable) || (array_key_exists('portfolio', $cpt_disable) && ($cpt_disable['portfolio'] == '0' || $cpt_disable['portfolio'] == ''))) {
                include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/portfolio/portfolio.php');
            }

            if (!isset($cpt_disable) || (array_key_exists('countdown', $cpt_disable) && ($cpt_disable['countdown'] == '0' || $cpt_disable['countdown'] == ''))) {
                include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/countdown/countdown.php');
            }

            if (class_exists('WooCommerce')) {
                include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/product/product.php');
                include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/product/product-categories.php');
                include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/product/product-sidebar.php');
            }

            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/blog/blog.php');
        }

        public static function g5plus_get_css_animation($css_animation)
        {
            $output = '';
            if ($css_animation != '') {
                wp_enqueue_script('waypoints');
                $output = ' wpb_animate_when_almost_visible g5plus-css-animation ' . $css_animation;
            }
            return $output;
        }

        public static function g5plus_get_style_animation($duration, $delay)
        {
            $styles = array();
            if ($duration != '0' && !empty($duration)) {
                $duration = (float)trim($duration, "\n\ts");
                $styles[] = "-webkit-animation-duration: {$duration}s";
                $styles[] = "-moz-animation-duration: {$duration}s";
                $styles[] = "-ms-animation-duration: {$duration}s";
                $styles[] = "-o-animation-duration: {$duration}s";
                $styles[] = "animation-duration: {$duration}s";
            }
            if ($delay != '0' && !empty($delay)) {
                $delay = (float)trim($delay, "\n\ts");
                $styles[] = "opacity: 0";
                $styles[] = "-webkit-animation-delay: {$delay}s";
                $styles[] = "-moz-animation-delay: {$delay}s";
                $styles[] = "-ms-animation-delay: {$delay}s";
                $styles[] = "-o-animation-delay: {$delay}s";
                $styles[] = "animation-delay: {$delay}s";
            }
            if (count($styles) > 1) {
                return 'style="' . implode(';', $styles) . '"';
            }
            return implode(';', $styles);
        }

        public static function  substr($str, $txt_len, $end_txt = '...')
        {
            if (empty($str)) return '';
            if (strlen($str) <= $txt_len) return $str;

            $i = $txt_len;
            while ($str[$i] != ' ') {
                $i--;
                if ($i == -1) break;
            }
            while ($str[$i] == ' ') {
                $i--;
                if ($i == -1) break;
            }

            return substr($str, 0, $i + 1) . $end_txt;
        }

        public function register_vc_map()
        {
	        $megatron_icons = &megatron_get_theme_icon();
	        $megatron_font_awesome = &megatron_get_font_awesome();
	        $g5plus_options = &megatron_get_options_config();
            $cpt_disable = isset($g5plus_options['cpt-disable']) ? $g5plus_options['cpt-disable'] : array();

            if (function_exists('vc_map')) {
                $add_css_animation = array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('CSS Animation', 'g5plus-megatron'),
                    'param_name' => 'css_animation',
                    'value' => array(esc_html__('No', 'g5plus-megatron') => '', esc_html__('Fade In', 'g5plus-megatron') => 'wpb_fadeIn', esc_html__('Fade Top to Bottom', 'g5plus-megatron') => 'wpb_fadeInDown', esc_html__('Fade Bottom to Top', 'g5plus-megatron') => 'wpb_fadeInUp', esc_html__('Fade Left to Right', 'g5plus-megatron') => 'wpb_fadeInLeft', esc_html__('Fade Right to Left', 'g5plus-megatron') => 'wpb_fadeInRight', esc_html__('Bounce In', 'g5plus-megatron') => 'wpb_bounceIn', esc_html__('Bounce Top to Bottom', 'g5plus-megatron') => 'wpb_bounceInDown', esc_html__('Bounce Bottom to Top', 'g5plus-megatron') => 'wpb_bounceInUp', esc_html__('Bounce Left to Right', 'g5plus-megatron') => 'wpb_bounceInLeft', esc_html__('Bounce Right to Left', 'g5plus-megatron') => 'wpb_bounceInRight', esc_html__('Zoom In', 'g5plus-megatron') => 'wpb_zoomIn', esc_html__('Flip Vertical', 'g5plus-megatron') => 'wpb_flipInX', esc_html__('Flip Horizontal', 'g5plus-megatron') => 'wpb_flipInY', esc_html__('Bounce', 'g5plus-megatron') => 'wpb_bounce', esc_html__('Flash', 'g5plus-megatron') => 'wpb_flash', esc_html__('Shake', 'g5plus-megatron') => 'wpb_shake', esc_html__('Pulse', 'g5plus-megatron') => 'wpb_pulse', esc_html__('Swing', 'g5plus-megatron') => 'wpb_swing', esc_html__('Rubber band', 'g5plus-megatron') => 'wpb_rubberBand', esc_html__('Wobble', 'g5plus-megatron') => 'wpb_wobble', esc_html__('Tada', 'g5plus-megatron') => 'wpb_tada'),
                    'description' => esc_html__('Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'g5plus-megatron'),
                    'group' => esc_html__('Animation Settings', 'g5plus-megatron')
                );

                $add_duration_animation = array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Animation Duration', 'g5plus-megatron'),
                    'param_name' => 'duration',
                    'value' => '',
                    'description' => esc_html__('Duration in seconds. You can use decimal points in the value. Use this field to specify the amount of time the animation plays. <em>The default value depends on the animation, leave blank to use the default.</em>', 'g5plus-megatron'),
                    'dependency' => Array('element' => 'css_animation', 'value' => array('wpb_fadeIn', 'wpb_fadeInDown', 'wpb_fadeInUp', 'wpb_fadeInLeft', 'wpb_fadeInRight', 'wpb_bounceIn', 'wpb_bounceInDown', 'wpb_bounceInUp', 'wpb_bounceInLeft', 'wpb_bounceInRight', 'wpb_zoomIn', 'wpb_flipInX', 'wpb_flipInY', 'wpb_bounce', 'wpb_flash', 'wpb_shake', 'wpb_pulse', 'wpb_swing', 'wpb_rubberBand', 'wpb_wobble', 'wpb_tada')),
                    'group' => esc_html__('Animation Settings', 'g5plus-megatron')
                );

                $add_delay_animation = array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Animation Delay', 'g5plus-megatron'),
                    'param_name' => 'delay',
                    'value' => '',
                    'description' => esc_html__('Delay in seconds. You can use decimal points in the value. Use this field to delay the animation for a few seconds, this is helpful if you want to chain different effects one after another above the fold.', 'g5plus-megatron'),
                    'dependency' => Array('element' => 'css_animation', 'value' => array('wpb_fadeIn', 'wpb_fadeInDown', 'wpb_fadeInUp', 'wpb_fadeInLeft', 'wpb_fadeInRight', 'wpb_bounceIn', 'wpb_bounceInDown', 'wpb_bounceInUp', 'wpb_bounceInLeft', 'wpb_bounceInRight', 'wpb_zoomIn', 'wpb_flipInX', 'wpb_flipInY', 'wpb_bounce', 'wpb_flash', 'wpb_shake', 'wpb_pulse', 'wpb_swing', 'wpb_rubberBand', 'wpb_wobble', 'wpb_tada')),
                    'group' => esc_html__('Animation Settings', 'g5plus-megatron')
                );

                $add_el_class = array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Extra class name', 'g5plus-megatron'),
                    'param_name' => 'el_class',
                    'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'g5plus-megatron'),
                );
                $target_arr = array(
                    esc_html__('Same window', 'g5plus-megatron') => '_self',
                    esc_html__('New window', 'g5plus-megatron') => '_blank'
                );
                $icon_type = array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Icon library', 'g5plus-megatron'),
                    'value' => array(
                        esc_html__('[None]', 'g5plus-megatron') => '',
                        esc_html__('Megatron Icon', 'g5plus-megatron') => 'megatron',
                        esc_html__('Font Awesome', 'g5plus-megatron') => 'fontawesome',
                        esc_html__('Open Iconic', 'g5plus-megatron') => 'openiconic',
                        esc_html__('Typicons', 'g5plus-megatron') => 'typicons',
                        esc_html__('Entypo', 'g5plus-megatron') => 'entypo',
                        esc_html__('Linecons', 'g5plus-megatron') => 'linecons',
                        esc_html__('Image', 'g5plus-megatron') => 'image',
                    ),
                    'param_name' => 'icon_type',
                    'description' => esc_html__('Select icon library.', 'g5plus-megatron'),
                );
                $icon_font = array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Icon library', 'g5plus-megatron'),
                    'value' => array(
                        esc_html__('[None]', 'g5plus-megatron') => '',
                        esc_html__('Megatron Icon', 'g5plus-megatron') => 'megatron',
                        esc_html__('Font Awesome', 'g5plus-megatron') => 'fontawesome',
                        esc_html__('Open Iconic', 'g5plus-megatron') => 'openiconic',
                        esc_html__('Typicons', 'g5plus-megatron') => 'typicons',
                        esc_html__('Entypo', 'g5plus-megatron') => 'entypo',
                        esc_html__('Linecons', 'g5plus-megatron') => 'linecons',
                    ),
                    'param_name' => 'icon_type',
                    'description' => esc_html__('Select icon library.', 'g5plus-megatron'),
                );
                $icon_fontawesome = array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'g5plus-megatron'),
                    'param_name' => 'icon_fontawesome',
                    'value' => 'fa fa-adjust', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false,
                        // default true, display an "EMPTY" icon?
                        'iconsPerPage' => 4000,
                        'source' => $megatron_font_awesome,
                        // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'fontawesome',
                    ),
                    'description' => esc_html__('Select icon from library.', 'g5plus-megatron'),
                );
                $icon_megatron = array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'g5plus-megatron'),
                    'param_name' => 'icon_megatron',
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'iconsPerPage' => 4000,
                        'type' => 'megatron',
                        'source' => $megatron_icons,
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'megatron',
                    ),
                    'description' => esc_html__('Select icon from library.', 'g5plus-megatron'),
                );
                $icon_openiconic = array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'g5plus-megatron'),
                    'param_name' => 'icon_openiconic',
                    'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'openiconic',
                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'openiconic',
                    ),
                    'description' => esc_html__('Select icon from library.', 'g5plus-megatron'),
                );
                $icon_typicons = array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'g5plus-megatron'),
                    'param_name' => 'icon_typicons',
                    'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'typicons',
                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'typicons',
                    ),
                    'description' => esc_html__('Select icon from library.', 'g5plus-megatron'),
                );
                $icon_entypo = array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'g5plus-megatron'),
                    'param_name' => 'icon_entypo',
                    'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'entypo',
                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'entypo',
                    ),
                );
                $icon_linecons = array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'g5plus-megatron'),
                    'param_name' => 'icon_linecons',
                    'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'linecons',
                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'linecons',
                    ),
                    'description' => esc_html__('Select icon from library.', 'g5plus-megatron'),
                );
                $icon_image = array(
                    'type' => 'attach_image',
                    'heading' => esc_html__('Upload Image Icon:', 'g5plus-megatron'),
                    'param_name' => 'icon_image',
                    'value' => '',
                    'description' => esc_html__('Upload the custom image icon.', 'g5plus-megatron'),
                    'dependency' => Array('element' => 'icon_type', 'value' => array('image')),
                );
                vc_map(array(
                    'name' => esc_html__('Slider Container', 'g5plus-megatron'),
                    'base' => 'megatron_slider_container',
                    'class' => '',
                    'icon' => 'fa fa-ellipsis-h',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_parent' => array('except' => 'megatron_slider_container'),
                    'content_element' => true,
                    'show_settings_on_create' => true,
                    'params' => array(
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Loop', 'g5plus-megatron'),
                            'param_name' => 'loop',
                            'description' => esc_html__('Inifnity loop.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Center', 'g5plus-megatron'),
                            'param_name' => 'center',
                            'description' => esc_html__('Center item. Works well with even an odd number of items.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Navigation', 'g5plus-megatron'),
                            'param_name' => 'nav',
                            'description' => esc_html__('Show navigation.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Pagination', 'g5plus-megatron'),
                            'param_name' => 'dots',
                            'description' => esc_html__('Show pagination.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Autoplay', 'g5plus-megatron'),
                            'param_name' => 'autoplay',
                            'description' => esc_html__('Autoplay.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Pause on hover', 'g5plus-megatron'),
                            'param_name' => 'autoplayhoverpause',
                            'description' => esc_html__('Pause on mouse hover.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Autoplay Timeout', 'g5plus-megatron'),
                            'param_name' => 'autoplaytimeout',
                            'description' => esc_html__('Autoplay interval timeout.', 'g5plus-megatron'),
                            'value' => '',
                            'std' => 5000
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items', 'g5plus-megatron'),
                            'param_name' => 'items',
                            'description' => esc_html__('This variable allows you to set the maximum amount of items displayed at a time with the widest browser width', 'g5plus-megatron'),
                            'value' => '',
                            'std' => 4
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Desktop', 'g5plus-megatron'),
                            'param_name' => 'itemsdesktop',
                            'description' => esc_html__('Browser Width >= 1200', 'g5plus-megatron'),
                            'value' => '',
                            'std' => '4'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Desktop Small', 'g5plus-megatron'),
                            'param_name' => 'itemsdesktopsmall',
                            'description' => esc_html__('Browser Width >= 980', 'g5plus-megatron'),
                            'value' => '',
                            'std' => '3'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Tablet', 'g5plus-megatron'),
                            'param_name' => 'itemstablet',
                            'description' => esc_html__('Browser Width >= 768', 'g5plus-megatron'),
                            'value' => '',
                            'std' => '2'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Tablet Small', 'g5plus-megatron'),
                            'param_name' => 'itemstabletsmall',
                            'description' => esc_html__('Browser Width >= 600', 'g5plus-megatron'),
                            'value' => '',
                            'std' => '2'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Mobile', 'g5plus-megatron'),
                            'param_name' => 'itemsmobile',
                            'description' => esc_html__('Browser Width < 600', 'g5plus-megatron'),
                            'value' => '',
                            'std' => '1'
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    ),
                    'js_view' => 'VcColumnView'
                ));
                vc_map(array(
                    'name' => esc_html__('Expandable', 'g5plus-megatron'),
                    'base' => 'megatron_expandable',
                    'class' => '',
                    'icon' => 'fa fa-expand',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_parent' => array('except' => 'megatron_expandable'),
                    'content_element' => true,
                    'show_settings_on_create' => true,
                    'params' => array(
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Collapse section?', 'g5plus-megatron'),
                            'param_name' => 'collapse',
                            'description' => esc_html__('Collapse or Expand section.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'std' => 'yes',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('More Label', 'g5plus-megatron'),
                            'param_name' => 'more_button_label',
                            'value' => '',
                            'std'=>'VIEW MORE',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Less Label', 'g5plus-megatron'),
                            'param_name' => 'less_button_label',
                            'value' => '',
                            'std'=>'VIEW LESS',
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Position', 'g5plus-megatron'),
                            'param_name' => 'button_position',
                            'value' => array(
                                esc_html__('Left', 'g5plus-megatron') => 'left',
                                esc_html__('Right', 'g5plus-megatron') => 'right',
                                esc_html__('Center', 'g5plus-megatron') => 'center',
                            ),
                            'std'=>'center',
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__('Background color', 'g5plus-megatron'),
                            'param_name' => 'button_bgcolor',
                            'value' => '',
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__('Color', 'g5plus-megatron'),
                            'param_name' => 'button_color',
                            'value' => '',
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__('Hover color', 'g5plus-megatron'),
                            'param_name' => 'button_hovercolor',
                            'value' => '',
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    ),
                    'js_view' => 'VcColumnView'
                ));
                vc_map( array(
                    'name' => esc_html__('Vertical Progress Bar', 'g5plus-megatron'),
                    'base' => 'megatron_vertical_progress_bar',
                    'icon' => 'icon-wpb-graph',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'description' => esc_html__( 'Animated vertical progress bar', 'g5plus-megatron' ),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Widget title', 'g5plus-megatron' ),
                            'param_name' => 'title',
                            'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'g5plus-megatron' )
                        ),
                        array(
                            'type' => 'param_group',
                            'heading' => esc_html__( 'Values', 'g5plus-megatron' ),
                            'param_name' => 'values',
                            'description' => esc_html__( 'Enter values for graph - value, title and color.', 'g5plus-megatron' ),
                            'value' => urlencode( json_encode( array(
                                array(
                                    'label' => esc_html__( 'Development', 'g5plus-megatron' ),
                                    'value' => '90',
                                ),
                                array(
                                    'label' => esc_html__( 'Design', 'g5plus-megatron' ),
                                    'value' => '80',
                                ),
                                array(
                                    'label' => esc_html__( 'Marketing', 'g5plus-megatron' ),
                                    'value' => '70',
                                ),
                            ) ) ),
                            'params' => array(
                                array(
                                    'type' => 'textfield',
                                    'heading' => esc_html__( 'Label', 'g5plus-megatron' ),
                                    'param_name' => 'label',
                                    'description' => esc_html__( 'Enter text used as title of bar.', 'g5plus-megatron' ),
                                    'admin_label' => true,
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => esc_html__( 'Value', 'g5plus-megatron' ),
                                    'param_name' => 'value',
                                    'description' => esc_html__( 'Enter value of bar.', 'g5plus-megatron' ),
                                    'admin_label' => true,
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => esc_html__( 'Color', 'g5plus-megatron' ),
                                    'param_name' => 'color',
                                    'value' => array(
                                            esc_html__( 'Default', 'g5plus-megatron' ) => ''
                                        ) + array(
                                            esc_html__('Primary color', 'g5plus-megatron') => 'primary-color',
                                            esc_html__('Secondary color', 'g5plus-megatron') => 'secondary-color',
                                            esc_html__( 'Classic Grey', 'g5plus-megatron' ) => 'bar_grey',
                                            esc_html__( 'Classic Blue', 'g5plus-megatron' ) => 'bar_blue',
                                            esc_html__( 'Classic Turquoise', 'g5plus-megatron' ) => 'bar_turquoise',
                                            esc_html__( 'Classic Green', 'g5plus-megatron' ) => 'bar_green',
                                            esc_html__( 'Classic Orange', 'g5plus-megatron' ) => 'bar_orange',
                                            esc_html__( 'Classic Red', 'g5plus-megatron' ) => 'bar_red',
                                            esc_html__( 'Classic Black', 'g5plus-megatron' ) => 'bar_black',
                                        ) + getVcShared( 'colors-dashed' ) + array(
                                            esc_html__( 'Custom Color', 'g5plus-megatron' ) => 'custom'
                                        ),
                                    'description' => esc_html__( 'Select single bar background color.', 'g5plus-megatron' ),
                                    'admin_label' => true,
                                    'param_holder_class' => 'vc_colored-dropdown'
                                ),
                                array(
                                    'type' => 'colorpicker',
                                    'heading' => esc_html__( 'Custom color', 'g5plus-megatron' ),
                                    'param_name' => 'customcolor',
                                    'description' => esc_html__( 'Select custom single bar value background color.', 'g5plus-megatron' ),
                                    'dependency' => array(
                                        'element' => 'color',
                                        'value' => array( 'custom' )
                                    ),
                                ),
                                array(
                                    'type' => 'colorpicker',
                                    'heading' => esc_html__( 'Custom bar color', 'g5plus-megatron' ),
                                    'param_name' => 'custombarcolor',
                                    'description' => esc_html__( 'Select custom single bar background color.', 'g5plus-megatron' ),
                                    'dependency' => array(
                                        'element' => 'color',
                                        'value' => array( 'custom' )
                                    ),
                                ),
                                array(
                                    'type' => 'colorpicker',
                                    'heading' => esc_html__( 'Custom label text color', 'g5plus-megatron' ),
                                    'param_name' => 'customtxtcolor',
                                    'description' => esc_html__( 'Select custom single bar label text color.', 'g5plus-megatron' ),
                                    'dependency' => array(
                                        'element' => 'color',
                                        'value' => array( 'custom' )
                                    ),
                                ),
                                array(
                                    'type' => 'colorpicker',
                                    'heading' => esc_html__( 'Custom value text color', 'g5plus-megatron' ),
                                    'param_name' => 'customvaluetxtcolor',
                                    'description' => esc_html__( 'Select custom single bar value text color.', 'g5plus-megatron' ),
                                    'dependency' => array(
                                        'element' => 'color',
                                        'value' => array( 'custom' )
                                    ),
                                ),
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Units', 'g5plus-megatron' ),
                            'param_name' => 'units',
                            'std'=> '%',
                            'description' => esc_html__( 'Enter measurement units (Example: %, px, points, etc. Note: graph value and units will be appended to graph title).', 'g5plus-megatron' )
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__( 'Color', 'g5plus-megatron' ),
                            'param_name' => 'bgcolor',
                            'value' => array(
                                    esc_html__('Primary color', 'g5plus-megatron') => 'primary-color',
                                    esc_html__('Secondary color', 'g5plus-megatron') => 'secondary-color',
                                    esc_html__( 'Classic Grey', 'g5plus-megatron' ) => 'bar_grey',
                                    esc_html__( 'Classic Blue', 'g5plus-megatron' ) => 'bar_blue',
                                    esc_html__( 'Classic Turquoise', 'g5plus-megatron' ) => 'bar_turquoise',
                                    esc_html__( 'Classic Green', 'g5plus-megatron' ) => 'bar_green',
                                    esc_html__( 'Classic Orange', 'g5plus-megatron' ) => 'bar_orange',
                                    esc_html__( 'Classic Red', 'g5plus-megatron' ) => 'bar_red',
                                    esc_html__( 'Classic Black', 'g5plus-megatron' ) => 'bar_black',
                                ) + getVcShared( 'colors-dashed' ) + array(
                                    esc_html__( 'Custom Color', 'g5plus-megatron' ) => 'custom'
                                ),
                            'std'=>'primary-color',
                            'description' => esc_html__( 'Select bar background color.', 'g5plus-megatron' ),
                            'admin_label' => true,
                            'param_holder_class' => 'vc_colored-dropdown',
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__( 'Bar value custom background color', 'g5plus-megatron' ),
                            'param_name' => 'custombgcolor',
                            'description' => esc_html__( 'Select custom background color for bars value.', 'g5plus-megatron' ),
                            'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'custom' ) )
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__( 'Bar custom background color', 'g5plus-megatron' ),
                            'param_name' => 'custombgbarcolor',
                            'description' => esc_html__( 'Select custom background color for bars.', 'g5plus-megatron' ),
                            'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'custom' ) )
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__( 'Bar custom label text color', 'g5plus-megatron' ),
                            'param_name' => 'customtxtcolor',
                            'description' => esc_html__( 'Select custom label text color for bars.', 'g5plus-megatron' ),
                            'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'custom' ) )
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__( 'Bar custom value text color', 'g5plus-megatron' ),
                            'param_name' => 'customvaluetxtcolor',
                            'description' => esc_html__( 'Select custom value text color for bars.', 'g5plus-megatron' ),
                            'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'custom' ) )
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__( 'Options', 'g5plus-megatron' ),
                            'param_name' => 'options',
                            'value' => array(
                                esc_html__( 'Add stripes', 'g5plus-megatron' ) => 'striped',
                                esc_html__( 'Add animation (Note: visible only with striped bar).', 'g5plus-megatron' ) => 'animated'
                            )
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Extra class name', 'g5plus-megatron' ),
                            'param_name' => 'el_class',
                            'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'g5plus-megatron' )
                        ),
                        array(
                            'type' => 'css_editor',
                            'heading' => esc_html__( 'CSS box', 'g5plus-megatron' ),
                            'param_name' => 'css',
                            'group' => esc_html__( 'Design Options', 'g5plus-megatron' )
                        ),
                    )
                ) );
                vc_map(array(
                    'name' => esc_html__('Cover Box', 'g5plus-megatron'),
                    'base' => 'megatron_cover_box_ctn',
                    'class' => '',
                    'icon' => 'fa fa-newspaper-o',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_parent' => array('only' => 'megatron_cover_box_sc'),
                    'content_element' => true,
                    'show_settings_on_create' => true,
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Item Active Index', 'g5plus-megatron'),
                            'param_name' => 'active_index',
                            'std' => '1',
                            'admin_label' => true,
                            'description' => esc_html__('Enter number index of item need active.', 'g5plus-megatron')
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    ),
                    'js_view' => 'VcColumnView'
                ));
                vc_map(array(
                    'name' => esc_html__('Cover Box Item', 'g5plus-megatron'),
                    'base' => 'megatron_cover_box_sc',
                    'class' => '',
                    'icon' => 'fa fa-file-text-o',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_child' => array('only' => 'megatron_cover_box_ctn', 'megatron_slider_container'),
                    'params' => array(
                        array(
                            'type' => 'attach_image',
                            'heading' => esc_html__('Image:', 'g5plus-megatron'),
                            'param_name' => 'image',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Title', 'g5plus-megatron'),
                            'param_name' => 'title',
                            'admin_label' => true,
                            'description' => esc_html__('Enter Title.', 'g5plus-megatron')
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => esc_html__('Link (url)', 'g5plus-megatron'),
                            'param_name' => 'link',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => esc_html__('Description', 'g5plus-megatron'),
                            'param_name' => 'content',
                            'value' => ''
                        )
                    )
                ));

                vc_map(array(
                    'name' => esc_html__('Counter', 'g5plus-megatron'),
                    'base' => 'megatron_counter',
                    'class' => '',
                    'icon' => 'fa fa-tachometer',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        $icon_type,
                        $icon_megatron,
                        $icon_fontawesome,
                        $icon_openiconic,
                        $icon_typicons,
                        $icon_entypo,
                        $icon_linecons,
                        $icon_image,
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Value', 'g5plus-megatron'),
                            'param_name' => 'value',
                            'value' => '',
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__('Color', 'g5plus-megatron'),
                            'param_name' => 'value_color',
                            'description' => esc_html__('Select custom color for your element.', 'g5plus-megatron'),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Title', 'g5plus-megatron'),
                            'param_name' => 'title',
                            'value' => '',
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__('Color', 'g5plus-megatron'),
                            'param_name' => 'title_color',
                            'description' => esc_html__('Select custom color for your element.', 'g5plus-megatron'),
                        ),
                        $add_el_class
                    )
                ));

                if (!isset($cpt_disable) || (array_key_exists('portfolio', $cpt_disable) && ($cpt_disable['portfolio'] == '0' || $cpt_disable['portfolio'] == ''))) {
                    $portfolio_categories = get_terms(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY, array('hide_empty' => 0, 'orderby' => 'ASC'));
                    $portfolio_cat = array();
                    if (is_array($portfolio_categories)) {
                        foreach ($portfolio_categories as $cat) {
                            $portfolio_cat[$cat->name] = $cat->slug;
                        }
                    }

                    $args = array(
                        'posts_per_page' => -1,
                        'post_type' => G5PLUS_PORTFOLIO_POST_TYPE,
                        'post_status' => 'publish');
                    $list_portfolio = array();
                    $post_array = get_posts($args);
                    foreach ($post_array as $post) : setup_postdata($post);
                        $list_portfolio[$post->post_title] = $post->ID;
                    endforeach;
                    wp_reset_postdata();

                    vc_map(array(
                        'name' => esc_html__('Portfolio', 'g5plus-megatron'),
                        'base' => 'g5plusframework_portfolio',
                        'class' => '',
                        'icon' => 'fa fa-th-large',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Layout style', 'g5plus-megatron'),
                                'param_name' => 'layout_type',
                                'admin_label' => true,
                                'value' => array(
                                    esc_html__('Grid', 'g5plus-megatron') => 'grid',
                                    esc_html__('Title & category', 'g5plus-megatron') => 'title',
                                    esc_html__('One page', 'g5plus-megatron') => 'one-page',
                                    esc_html__('Masonry extend', 'g5plus-megatron') => 'masonry',
                                    esc_html__('Masonry 4 columns', 'g5plus-megatron') => 'masonry-style-05',
                                    esc_html__('Masonry 3 columns', 'g5plus-megatron') => 'masonry-style-02',
                                    esc_html__('Masonry 2 columns left', 'g5plus-megatron') => 'masonry-style-03',
                                    esc_html__('Masonry 2 columns right', 'g5plus-megatron') => 'masonry-style-04',
                                    esc_html__('Masonry Classic', 'g5plus-megatron') => 'masonry-classic',
                                    esc_html__('Masonry home portfolio', 'g5plus-megatron') => 'masonry-home-portfolio',
                                    esc_html__('Left menu', 'g5plus-megatron') => 'left-menu',
                                    esc_html__('Short description', 'g5plus-megatron') => 'short-desc'
                                )
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Source', 'g5plus-megatron'),
                                'param_name' => 'data_source',
                                'admin_label' => true,
                                'value' => array(
                                    esc_html__('From Category', 'g5plus-megatron') => '',
                                    esc_html__('From Portfolio IDs', 'g5plus-megatron') => 'list_id')
                            ),

                            array(
                                'type' => 'multi-select',
                                'heading' => esc_html__('Portfolio Category', 'g5plus-megatron'),
                                'param_name' => 'category',
                                'admin_label' => true,
                                'options' => $portfolio_cat,
                                'dependency' => Array('element' => 'data_source', 'value' => array(''))
                            ),
                            array(
                                'type' => 'multi-select',
                                'heading' => esc_html__('Select Portfolio', 'g5plus-megatron'),
                                'param_name' => 'portfolio_ids',
                                'options' => $list_portfolio,
                                'dependency' => Array('element' => 'data_source', 'value' => array('list_id'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Show Category', 'g5plus-megatron'),
                                'param_name' => 'show_category',
                                'admin_label' => true,
                                'value' => array(
                                    esc_html__('None', 'g5plus-megatron') => '',
                                    esc_html__('Show in left', 'g5plus-megatron') => 'left',
                                    esc_html__('Show in center', 'g5plus-megatron') => 'center',
                                    esc_html__('Show in right', 'g5plus-megatron') => 'right')

                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Category action', 'g5plus-megatron'),
                                'param_name' => 'tab_category_action',
                                'admin_label' => true,
                                'value' => array(
                                    esc_html__('Isotope Filter', 'g5plus-megatron') => 'filter',
                                    esc_html__('Ajax filter', 'g5plus-megatron') => 'ajax',
                                ),
                                'dependency' => Array('element' => 'show_category', 'value' => array('left', 'center', 'right'))
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Css category class', 'g5plus-megatron'),
                                'param_name' => 'css_category',
                                'value' => '',
                                'dependency' => Array('element' => 'show_category', 'value' => array('left', 'center', 'right'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Number of column', 'g5plus-megatron'),
                                'param_name' => 'column',
                                'value' => array('2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6'),
                                'dependency' => Array('element' => 'layout_type', 'value' => array('grid', 'title'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Number of column masonry', 'g5plus-megatron'),
                                'param_name' => 'column_masonry',
                                'value' => array('3' => '3', '4' => '4', '5' => '5'),
                                'dependency' => Array('element' => 'layout_type', 'value' => array('masonry'))
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Number of item (or number of item per page if choose show paging)', 'g5plus-megatron'),
                                'param_name' => 'item',
                                'value' => '',
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Order Post Date By', 'g5plus-megatron'),
                                'param_name' => 'order',
                                'value' => array(esc_html__('Descending', 'g5plus-megatron') => 'DESC', esc_html__('Ascending', 'g5plus-megatron') => 'ASC')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Show Paging', 'g5plus-megatron'),
                                'param_name' => 'show_pagging',
                                'value' => array('None' => '', esc_html__('Load more', 'g5plus-megatron') => '1', esc_html__('Slider', 'g5plus-megatron') => '2'),
                                'dependency' => Array('element' => 'layout_type', 'value' => array('grid', 'title','short-desc'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Show Paging Masonry', 'g5plus-megatron'),
                                'param_name' => 'show_pagging_masonry',
                                'value' => array('None' => '', esc_html__('Load more', 'g5plus-megatron') => '1'),
                                'dependency' => Array('element' => 'layout_type', 'value' => array('masonry', 'left-menu' ,'one-page','masonry-classic','masonry-style-02','masonry-style-03','masonry-style-04','masonry-style-05'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Padding', 'g5plus-megatron'),
                                'param_name' => 'padding',
                                'value' => array(esc_html__('No padding', 'g5plus-megatron') => 'no-padding', '10 px' => 'col-padding-10', '15 px' => 'col-padding-15', '20 px' => 'col-padding-20', '40 px' => 'col-padding-40'),
                                'dependency' => Array('element' => 'layout_type', 'value' => array('grid', 'title', 'masonry', 'one-page', 'masonry-style-02', 'masonry-classic','masonry-style-03','masonry-style-04','masonry-style-05'))
                            ),

                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Image size', 'g5plus-megatron'),
                                'param_name' => 'image_size',
                                'value' => array('585x585' => '585x585', '590x393' => '590x393', '570x438' =>'570x438', '370x284' => '370x284', '370x620' => '370x620'),
                                'dependency' => Array('element' => 'layout_type', 'value' => array('grid', 'title'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Responsive', 'g5plus-megatron'),
                                'param_name' => 'responsive',
                                'admin_label' => true,
                                'value' => array(esc_html__('Default', 'g5plus-megatron') => '',
                                    esc_html__('Customize', 'g5plus-megatron') => 'customize'
                                )
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Table mode (width 768px)', 'g5plus-megatron'),
                                'param_name' => 'table_item',
                                'admin_label' => true,
                                'value' => array(esc_html__('1 item', 'g5plus-megatron') => 'table-one',
                                    esc_html__('2 item', 'g5plus-megatron') => 'table-two'
                                ),
                                'dependency' => Array('element' => 'responsive', 'value' => array('customize') )
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Small table mode (width 600px)', 'g5plus-megatron'),
                                'param_name' => 'small_table_item',
                                'admin_label' => true,
                                'value' => array(esc_html__('1 item', 'g5plus-megatron') => 'small-table-one',
                                    esc_html__('2 item', 'g5plus-megatron') => 'small-table-two'
                                ),
                                'dependency' => Array('element' => 'responsive', 'value' => array('customize') )
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Overlay Style', 'g5plus-megatron'),
                                'param_name' => 'overlay_style',
                                'admin_label' => true,
                                'value' => array(
                                    esc_html__('Title', 'g5plus-megatron') => 'title',
                                    esc_html__('Title & Category', 'g5plus-megatron') => 'title-category',
                                    esc_html__('Title & Category & Link button', 'g5plus-megatron') => 'title-category-link',
                                    esc_html__('Title & Excerpt & Link button', 'g5plus-megatron') => 'title-excerpt-link',
                                    esc_html__('Title & Excerpt', 'g5plus-megatron') => 'title-excerpt',
                                    esc_html__('Icon Gallery', 'g5plus-megatron') => 'icon',
                                    esc_html__('Icon Gallery & Detail', 'g5plus-megatron') => 'icon-view'

                                ),

                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Overlay Effect', 'g5plus-megatron'),
                                'param_name' => 'overlay_effect',
                                'admin_label' => true,
                                'value' => array(esc_html__('Hover dir', 'g5plus-megatron') => 'hover-dir',
                                    esc_html__('Float top', 'g5plus-megatron') => 'float-top',
                                    esc_html__('Lily', 'g5plus-megatron') => 'lily',
                                    esc_html__('Sadie', 'g5plus-megatron') => 'sadie',
                                    esc_html__('Layla', 'g5plus-megatron') => 'layla',
                                    esc_html__('Oscar', 'g5plus-megatron') => 'oscar',
                                    esc_html__('Marley', 'g5plus-megatron') => 'marley',
                                    esc_html__('Sarah', 'g5plus-megatron') => 'sarah',
                                    esc_html__('Chico', 'g5plus-megatron') => 'chico',
                                    esc_html__('Jazz', 'g5plus-megatron') => 'jazz',
                                    esc_html__('Ming', 'g5plus-megatron') => 'ming'
                                ),
                                'dependency' => Array('element' => 'overlay_style', 'value' => array('left-menu','title', 'title-category', 'title-category-link', 'title-excerpt-link', 'left-title-excerpt-link', 'title-excerpt'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Overlay Background', 'g5plus-megatron'),
                                'param_name' => 'overlay_bg',
                                'admin_label' => true,
                                'value' => array(
                                    esc_html__('Gradient primary & secondary color', 'g5plus-megatron') => 'bg-overlay-ps',
                                    esc_html__('Light', 'g5plus-megatron') => 'bg-light',
                                    esc_html__('Dark', 'g5plus-megatron') => 'bg-dark',

                                ),

                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation

                        )
                    ));
                }

                if (!isset($cpt_disable) || (array_key_exists('ourteam', $cpt_disable) && ($cpt_disable['ourteam'] == '0' || $cpt_disable['ourteam'] == ''))) {
                    $ourteam_cat = array();
                    $ourteam_categories = get_terms('ourteam_category', array('hide_empty' => 0, 'orderby' => 'ASC'));
                    if (is_array($ourteam_categories)) {
                        foreach ($ourteam_categories as $cat) {
                            $ourteam_cat[$cat->name] = $cat->slug;
                        }
                    }
                    vc_map(array(
                        'name' => esc_html__('Our Team', 'g5plus-megatron'),
                        'base' => 'megatron_ourteam',
                        'class' => '',
                        'icon' => 'fa fa-users',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Layout Style', 'g5plus-megatron'),
                                'param_name' => 'layout_style',
                                'admin_label' => true,
                                'value' => array(esc_html__('Image top, Text bottom', 'g5plus-megatron') => 'style1', esc_html__('Image left, Text right', 'g5plus-megatron') => 'style2', esc_html__('Simple', 'g5plus-megatron') => 'style3'),
                                'description' => esc_html__('Select Layout Style.', 'g5plus-megatron')
                            ),
                            array(
                                'type' => 'multi-select',
                                'heading' => esc_html__('Category', 'g5plus-megatron'),
                                'param_name' => 'category',
                                'options' => $ourteam_cat
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Item Amount', 'g5plus-megatron'),
                                'param_name' => 'item_amount',
                                'value' => '8'
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Column', 'g5plus-megatron'),
                                'param_name' => 'column',
                                'value' => '4'
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Slider Style', 'g5plus-megatron'),
                                'param_name' => 'is_slider',
                                'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Show pagination control', 'g5plus-megatron'),
                                'param_name' => 'dots',
                                'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                                'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Show navigation control', 'g5plus-megatron'),
                                'param_name' => 'nav',
                                'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                                'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Autoplay Timeout', 'g5plus-megatron'),
                                'param_name' => 'autoplaytimeout',
                                'description' => esc_html__('Autoplay interval timeout.', 'g5plus-megatron'),
                                'value' => '',
                                'dependency' => Array('element' => 'is_slider', 'value' => 'yes'),
                                'std' => 5000
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    ));
                }
                if (!isset($cpt_disable)  || (array_key_exists('pricingtable', $cpt_disable) && ($cpt_disable['pricingtable'] == '0' || $cpt_disable['pricingtable'] == ''))) {
                    $args = array(
                        'posts_per_page' => -1,
                        'post_type' => 'pricingtable',
                        'orderby' => 'date',
                        'order' => 'ASC',
                        'post_status' => 'publish'
                    );
                    $pt_posts = get_posts($args);
                    $post_name = '';
                    foreach ($pt_posts as $post) : setup_postdata($post);
                        $post_name[$post->post_title] = $post->post_name;
                    endforeach;

                    vc_map(array(
                        'name' => esc_html__('Pricing Table', 'g5plus-megatron'),
                        'base' => 'megatron_pricingtable',
                        'class' => '',
                        'icon' => 'fa fa-money',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Layout Style', 'g5plus-megatron'),
                                'param_name' => 'layout_style',
                                'admin_label' => true,
                                'value' => array(esc_html__('Classic', 'g5plus-megatron') => 'style1', esc_html__('Rounded', 'g5plus-megatron') => 'style2', esc_html__('Modern', 'g5plus-megatron') => 'style3', esc_html__('Classic with space', 'g5plus-megatron') => 'style4'),
                                'description' => esc_html__('Select Layout Style.', 'g5plus-megatron')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Pricing Table', 'g5plus-megatron'),
                                'param_name' => 'post_name',
                                'admin_label' => true,
                                'value' => $post_name,
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Column', 'g5plus-megatron'),
                                'param_name' => 'column',
                                'value' => array('1' => 1, '2' => 2, '3' => 3, '4' => 4),
                                'std' => '4',
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Slider Style', 'g5plus-megatron'),
                                'param_name' => 'is_slider',
                                'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Show pagination control', 'g5plus-megatron'),
                                'param_name' => 'dots',
                                'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                                'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Show navigation control', 'g5plus-megatron'),
                                'param_name' => 'nav',
                                'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                                'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    ));
                }
                if (!isset($cpt_disable)  || (array_key_exists('servicetable', $cpt_disable) && ($cpt_disable['servicetable'] == '0' || $cpt_disable['servicetable'] == ''))) {
                    $args = array(
                        'posts_per_page' => -1,
                        'post_type' => 'servicetable',
                        'orderby' => 'date',
                        'order' => 'ASC',
                        'post_status' => 'publish'
                    );
                    $pt_posts = get_posts($args);
                    $post_name = '';
                    foreach ($pt_posts as $post) : setup_postdata($post);
                        $post_name[$post->post_title] = $post->post_name;
                    endforeach;

                    vc_map(array(
                        'name' => esc_html__('Service Table', 'g5plus-megatron'),
                        'base' => 'megatron_servicetable',
                        'class' => '',
                        'icon' => 'fa fa-money',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Service Table', 'g5plus-megatron'),
                                'param_name' => 'post_name',
                                'admin_label' => true,
                                'value' => $post_name,
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Column', 'g5plus-megatron'),
                                'param_name' => 'column',
                                'value' => array('1' => 1, '2' => 2, '3' => 3, '4' => 4),
                                'std' => '4',
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Slider Style', 'g5plus-megatron'),
                                'param_name' => 'is_slider',
                                'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Show pagination control', 'g5plus-megatron'),
                                'param_name' => 'dots',
                                'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                                'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Show navigation control', 'g5plus-megatron'),
                                'param_name' => 'nav',
                                'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                                'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    ));
                }

                if (!isset($cpt_disable) || (array_key_exists('countdown', $cpt_disable) && ($cpt_disable['countdown'] == '0' || $cpt_disable['countdown'] == ''))) {
                    vc_map(array(
                        'name' => esc_html__('Countdown', 'g5plus-megatron'),
                        'base' => 'megatron_countdown_shortcode',
                        'class' => '',
                        'icon' => 'fa fa-clock-o',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Layout Style', 'g5plus-megatron'),
                                'param_name' => 'layout_style',
                                'admin_label' => true,
                                'value' => array(
                                    esc_html__('Square & background', 'g5plus-megatron') => 'square',
                                    esc_html__('Round', 'g5plus-megatron') => 'round'),
                                'description' => esc_html__('Select Layout Style.', 'g5plus-megatron')
                            ),
                            $add_el_class
                        )
                    ));
                }


                vc_map(array(
                    'name' => esc_html__('Button', 'g5plus-megatron'),
                    'base' => 'megatron_button',
                    'class' => '',
                    'icon' => 'fa fa-bold',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'vc_link',
                            'heading' => esc_html__('Link (url)', 'g5plus-megatron'),
                            'param_name' => 'link',
                            'value' => '',
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Layout Style', 'g5plus-megatron'),
                            'param_name' => 'layout_style',
                            'admin_label' => true,
                            'value' => array(
                                esc_html__('Border 1px', 'g5plus-megatron') => 'm-button-bordered',
                                esc_html__('Border 2px', 'g5plus-megatron') => 'm-button-bordered-2',
                                esc_html__('Background','g5plus-megatron')=>'m-button-bg',
                                esc_html__('Background 3D', 'g5plus-megatron') => 'm-button-3d',),
                            'description' => esc_html__('Select Layout Style.', 'g5plus-megatron')
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Size', 'g5plus-megatron'),
                            'param_name' => 'size',
                            'admin_label' => true,
                            'value' => array(
                                esc_html__('Extra Small', 'g5plus-megatron') => 'm-button-xs',
                                esc_html__('Small', 'g5plus-megatron') => 'm-button-sm',
                                esc_html__('Medium', 'g5plus-megatron') => 'm-button-md',
                                esc_html__('Large', 'g5plus-megatron') => 'm-button-lg',
                                esc_html__('Extra Large', 'g5plus-megatron') => 'm-button-xlg'),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Color', 'g5plus-megatron'),
                            'param_name' => 'button_color',
                            'value' => array(
                                esc_html__('Primary', 'g5plus-megatron') => 'm-button-primary',
                                esc_html__('Secondary', 'g5plus-megatron') => 'm-button-secondary',
                                esc_html__('Gray', 'g5plus-megatron') => 'm-button-gray',
                                esc_html__('Black', 'g5plus-megatron') => 'm-button-black',
                                esc_html__('Light','g5plus-megatron') => 'm-button-light'
                            ),
                            'description' => esc_html__('Select color for your element', 'g5plus-megatron'),
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Add icon?', 'g5plus-megatron'),
                            'param_name' => 'add_icon',
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Icon library', 'g5plus-megatron'),
                            'value' => array(
                                esc_html__('[None]', 'g5plus-megatron') => '',
                                esc_html__('Megatron Icon', 'g5plus-megatron') => 'megatron',
                                esc_html__('Font Awesome', 'g5plus-megatron') => 'fontawesome',
                                esc_html__('Open Iconic', 'g5plus-megatron') => 'openiconic',
                                esc_html__('Typicons', 'g5plus-megatron') => 'typicons',
                                esc_html__('Entypo', 'g5plus-megatron') => 'entypo',
                                esc_html__('Linecons', 'g5plus-megatron') => 'linecons',
                                esc_html__('Image', 'g5plus-megatron') => 'image',
                            ),
                            'param_name' => 'icon_type',
                            'description' => esc_html__('Select icon library.', 'g5plus-megatron'),
                            'dependency' => Array('element' => 'add_icon', 'value' => 'yes'),
                        ),
                        $icon_megatron,
                        $icon_fontawesome,
                        $icon_openiconic,
                        $icon_typicons,
                        $icon_entypo,
                        $icon_linecons,
                        $icon_image,
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Icon Alignment', 'g5plus-megatron'),
                            'description' => esc_html__('Select icon alignment.', 'g5plus-megatron'),
                            'param_name' => 'i_align',
                            'value' => array(
                                esc_html__('Left', 'g5plus-megatron') => 'i-left',
                                esc_html__('Right', 'g5plus-megatron') => 'i-right',
                            ),
                            'dependency' => Array('element' => 'add_icon', 'value' => 'yes'),
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));

                vc_map(array(
                    'name' => esc_html__('Call To Action', 'g5plus-megatron'),
                    'base' => 'megatron_call_action',
                    'class' => '',
                    'icon' => 'fa fa-play',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Layout Style', 'g5plus-megatron'),
                            'param_name' => 'layout_style',
                            'admin_label' => true,
                            'value' => array(
                                esc_html__('Only Text', 'g5plus-megatron') => 'style1',
                                esc_html__('Text with Icon', 'g5plus-megatron') => 'style2'),
                            'description' => esc_html__('Select Layout Style.', 'g5plus-megatron')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Title', 'g5plus-megatron'),
                            'param_name' => 'title',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => esc_html__('Description', 'g5plus-megatron'),
                            'param_name' => 'description',
                            'value' => '',
                            'dependency' => array('element'=>'layout_style','value'=>'style2')
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => esc_html__('Link (url)', 'g5plus-megatron'),
                            'param_name' => 'link',
                            'value' => '',
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Icon library', 'g5plus-megatron'),
                            'value' => array(
                                esc_html__('[None]', 'g5plus-megatron') => '',
                                esc_html__('Megatron Icon', 'g5plus-megatron') => 'megatron',
                                esc_html__('Font Awesome', 'g5plus-megatron') => 'fontawesome',
                                esc_html__('Open Iconic', 'g5plus-megatron') => 'openiconic',
                                esc_html__('Typicons', 'g5plus-megatron') => 'typicons',
                                esc_html__('Entypo', 'g5plus-megatron') => 'entypo',
                                esc_html__('Linecons', 'g5plus-megatron') => 'linecons',
                                esc_html__('Image', 'g5plus-megatron') => 'image',
                            ),
                            'param_name' => 'icon_type',
                            'description' => esc_html__('Select icon library.', 'g5plus-megatron'),
                            'dependency' => array('element'=>'layout_style','value'=>'style2')
                        ),
                        $icon_megatron,
                        $icon_fontawesome,
                        $icon_openiconic,
                        $icon_typicons,
                        $icon_entypo,
                        $icon_linecons,
                        $icon_image,
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Background Color', 'g5plus-megatron'),
                            'param_name' => 'color',
                            'admin_label' => true,
                            'value' => array(
                                esc_html__('Primary', 'g5plus-megatron') => 'p-color-bg',
                                esc_html__('Secondary', 'g5plus-megatron') => 's-color-bg',
                                esc_html__('Transparent', 'g5plus-megatron') => 'call-action-transparent'),
                            'description' => esc_html__('Select color for your element.', 'g5plus-megatron')
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Height','g5plus-megatron'),
                            'param_name' => 'height',
                            'value' => array(
                                esc_html__('Tall','g5plus-megatron') => '',
                                esc_html__('Short','g5plus-megatron') => 'short',
                            ),
                            'description' => esc_html__('Select height for your element.','g5plus-megatron')
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                $category = array();
                $categories = get_categories();
                if (is_array($categories)) {
                    foreach ($categories as $cat) {
                        $category[$cat->name] = $cat->slug;
                    }
                }

                vc_map(
                    array(
                        'name' =>  esc_html__('Blog', 'g5plus-megatron'),
                        'base' => 'megatron_blog',
                        'icon' => 'fa fa-file-text',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(

                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Blog Style', 'g5plus-megatron'),
                                'param_name' => 'type',
                                'value' => array(
                                    esc_html__('Larger Image', 'g5plus-megatron') => 'large-image',
                                    esc_html__('Medium Image', 'g5plus-megatron') => 'medium-image',
                                    esc_html__('Timeline', 'g5plus-megatron') => 'timeline',
                                    esc_html__('Masonry', 'g5plus-megatron') => 'masonry'
                                ),
                                'std' => 'large-image',
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),

                            array(
                                "type" => "dropdown",
                                "heading" => esc_html__("Columns", 'g5plus-megatron'),
                                "param_name" => "columns",
                                "value" => array(
                                    esc_html__('2 columns', 'g5plus-megatron') => 2,
                                    esc_html__('3 columns', 'g5plus-megatron') => 3,
                                    esc_html__('4 columns', 'g5plus-megatron') => 4,
                                ),
                                "description" => esc_html__("How much columns grid", 'g5plus-megatron'),
                                'dependency' => array(
                                    'element' => 'type',
                                    'value' => array('masonry')
                                ),
                                'std' => 2,
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),


                            array(
                                'type' => 'multi-select',
                                'heading' => esc_html__('Narrow Category', 'g5plus-megatron'),
                                'param_name' => 'category',
                                'options' => $category
                            ),

                            array(
                                "type" => "textfield",
                                "heading" => esc_html__("Total items", 'g5plus-megatron'),
                                "param_name" => "max_items",
                                "value" => -1,
                                "description" => esc_html__('Set max limit for items or enter -1 to display all.', 'g5plus-megatron')
                            ),

                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Navigation Type', 'g5plus-megatron'),
                                'param_name' => 'paging_style',
                                'value' => array(
                                    esc_html__('Show all', 'g5plus-megatron') => 'all',
                                    esc_html__('Default', 'g5plus-megatron') => 'default',
                                    esc_html__('Load More', 'g5plus-megatron') => 'load-more',
                                    esc_html__('Infinity Scroll', 'g5plus-megatron') => 'infinity-scroll',
                                ),
                                'std' => 'all',
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                                'dependency' => array(
                                    'element' => 'max_items',
                                    'value' => array('-1')
                                ),
                            ),


                            array(
                                "type" => "textfield",
                                "heading" => esc_html__("Posts per page", 'g5plus-megatron'),
                                "param_name" => "posts_per_page",
                                "value" => get_option('posts_per_page'),
                                "description" => esc_html__('Number of items to show per page', 'g5plus-megatron'),
                                'dependency' => array(
                                    'element' => 'paging_style',
                                    'value' => array('default', 'load-more', 'infinity-scroll'),
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),


                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Has Sidebar', 'g5plus-megatron'),
                                'param_name' => 'has_sidebar',
                                'std' => '',
                                'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes')
                            ),


                            // Data settings
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Order by', 'g5plus-megatron'),
                                'param_name' => 'orderby',
                                'value' => array(
                                    esc_html__('Date', 'g5plus-megatron') => 'date',
                                    esc_html__('Order by post ID', 'g5plus-megatron') => 'ID',
                                    esc_html__('Author', 'g5plus-megatron') => 'author',
                                    esc_html__('Title', 'g5plus-megatron') => 'title',
                                    esc_html__('Last modified date', 'g5plus-megatron') => 'modified',
                                    esc_html__('Post/page parent ID', 'g5plus-megatron') => 'parent',
                                    esc_html__('Number of comments', 'g5plus-megatron') => 'comment_count',
                                    esc_html__('Menu order/Page Order', 'g5plus-megatron') => 'menu_order',
                                    esc_html__('Meta value', 'g5plus-megatron') => 'meta_value',
                                    esc_html__('Meta value number', 'g5plus-megatron') => 'meta_value_num',
                                    esc_html__('Random order', 'g5plus-megatron') => 'rand',
                                ),
                                'description' => esc_html__('Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'g5plus-megatron'),
                                'group' => esc_html__('Data Settings', 'g5plus-megatron'),
                                'param_holder_class' => 'vc_grid-data-type-not-ids',
                            ),

                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Sorting', 'g5plus-megatron'),
                                'param_name' => 'order',
                                'group' => esc_html__('Data Settings', 'g5plus-megatron'),
                                'value' => array(
                                    esc_html__('Descending', 'g5plus-megatron') => 'DESC',
                                    esc_html__('Ascending', 'g5plus-megatron') => 'ASC',
                                ),
                                'param_holder_class' => 'vc_grid-data-type-not-ids',
                                'description' => esc_html__('Select sorting order.', 'g5plus-megatron'),
                            ),

                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Meta key', 'g5plus-megatron'),
                                'param_name' => 'meta_key',
                                'description' => esc_html__('Input meta key for grid ordering.', 'g5plus-megatron'),
                                'group' => esc_html__('Data Settings', 'g5plus-megatron'),
                                'param_holder_class' => 'vc_grid-data-type-not-ids',
                                'dependency' => array(
                                    'element' => 'orderby',
                                    'value' => array('meta_value', 'meta_value_num'),
                                ),
                            ),

                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );
                vc_map(array(
                    'name' => esc_html__('Posts', 'g5plus-megatron'),
                    'base' => 'megatron_post',
                    'icon' => 'fa fa-file-text-o',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'description' => esc_html__('Posts', 'g5plus-megatron'),
                    'params' => array(
                        array(
                            'type' => 'multi-select',
                            'heading' => esc_html__('Category', 'g5plus-megatron'),
                            'param_name' => 'category',
                            'options' => $category
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Display', 'g5plus-megatron'),
                            'param_name' => 'display',
                            'admin_label' => true,
                            'value' => array(esc_html__('Random', '') => 'random', esc_html__('Popular', 'g5plus-megatron') => 'popular', esc_html__('Recent', 'g5plus-megatron') => 'recent', esc_html__('Oldest', 'g5plus-megatron') => 'oldest'),
                            'std' => 'recent',
                            'description' => esc_html__('Select Orderby.', 'g5plus-megatron')
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Layout Style', 'g5plus-megatron'),
                            'param_name' => 'layout_style',
                            'admin_label' => true,
                            'value' => array(
                                esc_html__('Default', 'g5plus-megatron') => 'style1',
                                esc_html__('Large and Small', 'g5plus-megatron') => 'style2'),
                            'description' => esc_html__('Select Layout Style.', 'g5plus-megatron')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Item Amount', 'g5plus-megatron'),
                            'param_name' => 'item_amount',
                            'value' => '6',
                            'dependency' => Array('element' => 'layout_style', 'value' => 'style1')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Column', 'g5plus-megatron'),
                            'param_name' => 'column',
                            'value' => '3',
                            'dependency' => Array('element' => 'layout_style', 'value' => 'style1')
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Slider Style', 'g5plus-megatron'),
                            'param_name' => 'is_slider',
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'dependency' => Array('element' => 'layout_style', 'value' => 'style1')
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Show pagination control', 'g5plus-megatron'),
                            'param_name' => 'dots',
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Show navigation control', 'g5plus-megatron'),
                            'param_name' => 'nav',
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Autoplay Timeout', 'g5plus-megatron'),
                            'param_name' => 'autoplaytimeout',
                            'description' => esc_html__('Autoplay interval timeout.', 'g5plus-megatron'),
                            'value' => '',
                            'dependency' => Array('element' => 'is_slider', 'value' => 'yes'),
                            'std' => 5000
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(array(
                    'name' => esc_html__('Partner Carousel', 'g5plus-megatron'),
                    'base' => 'megatron_partner_carousel',
                    'icon' => 'fa fa-user-plus',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'description' => esc_html__('Animated carousel with images', 'g5plus-megatron'),
                    'params' => array(
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Layout Style', 'g5plus-megatron'),
                            'param_name' => 'layout_style',
                            'admin_label' => true,
                            'value' => array(
                                esc_html__('Default', 'g5plus-megatron') => 'style1',
                                esc_html__('Background', 'g5plus-megatron') => 'style2',
                                esc_html__('Border', 'g5plus-megatron') => 'style3'),
                            'description' => esc_html__('Select Layout Style.', 'g5plus-megatron')
                        ),
                        array(
                            'type' => 'attach_images',
                            'heading' => esc_html__('Images', 'g5plus-megatron'),
                            'param_name' => 'images',
                            'value' => '',
                            'description' => esc_html__('Select images from media library.', 'g5plus-megatron')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Image size', 'g5plus-megatron'),
                            'param_name' => 'img_size',
                            'description' => esc_html__('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'g5plus-megatron'),
                            'std' => 'full'
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Image Opacity', 'g5plus-megatron'),
                            'param_name' => 'opacity',
                            'value' => array(
                                esc_html__('[none]', 'g5plus-megatron') => '',
                                esc_html__('10%', 'g5plus-megatron') => '10',
                                esc_html__('20%', 'g5plus-megatron') => '20',
                                esc_html__('30%', 'g5plus-megatron') => '30',
                                esc_html__('40%', 'g5plus-megatron') => '40',
                                esc_html__('50%', 'g5plus-megatron') => '50',
                                esc_html__('60%', 'g5plus-megatron') => '60',
                                esc_html__('70%', 'g5plus-megatron') => '70',
                                esc_html__('80%', 'g5plus-megatron') => '80',
                                esc_html__('90%', 'g5plus-megatron') => '90',
                                esc_html__('100%', 'g5plus-megatron') => '100'
                            ),
                            'std' => '80'
                        ),
                        array(
                            'type' => 'exploded_textarea',
                            'heading' => esc_html__('Custom links', 'g5plus-megatron'),
                            'param_name' => 'custom_links',
                            'description' => esc_html__('Enter links for each slide here. Divide links with linebreaks (Enter) . ', 'g5plus-megatron'),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Custom link target', 'g5plus-megatron'),
                            'param_name' => 'custom_links_target',
                            'description' => esc_html__('Select where to open  custom links.', 'g5plus-megatron'),
                            'value' => $target_arr
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Loop', 'g5plus-megatron'),
                            'param_name' => 'loop',
                            'description' => esc_html__('Inifnity loop.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Center', 'g5plus-megatron'),
                            'param_name' => 'center',
                            'description' => esc_html__('Center item. Works well with even an odd number of items.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Navigation', 'g5plus-megatron'),
                            'param_name' => 'nav',
                            'description' => esc_html__('Show navigation.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Pagination', 'g5plus-megatron'),
                            'param_name' => 'dots',
                            'description' => esc_html__('Show pagination.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Autoplay', 'g5plus-megatron'),
                            'param_name' => 'autoplay',
                            'description' => esc_html__('Autoplay.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Pause on hover', 'g5plus-megatron'),
                            'param_name' => 'autoplayhoverpause',
                            'description' => esc_html__('Pause on mouse hover.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Autoplay Timeout', 'g5plus-megatron'),
                            'param_name' => 'autoplaytimeout',
                            'description' => esc_html__('Autoplay interval timeout.', 'g5plus-megatron'),
                            'value' => '',
                            'std' => 5000
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items', 'g5plus-megatron'),
                            'param_name' => 'items',
                            'description' => esc_html__('This variable allows you to set the maximum amount of items displayed at a time with the widest browser width', 'g5plus-megatron'),
                            'value' => '',
                            'std' => 6
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Desktop', 'g5plus-megatron'),
                            'param_name' => 'itemsdesktop',
                            'description' => esc_html__('Browser Width >= 1200', 'g5plus-megatron'),
                            'value' => '',
                            'std' => '6'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Desktop Small', 'g5plus-megatron'),
                            'param_name' => 'itemsdesktopsmall',
                            'description' => esc_html__('Browser Width >= 980', 'g5plus-megatron'),
                            'value' => '',
                            'std' => '5'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Tablet', 'g5plus-megatron'),
                            'param_name' => 'itemstablet',
                            'description' => esc_html__('Browser Width >= 768', 'g5plus-megatron'),
                            'value' => '',
                            'std' => '3'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Tablet Small', 'g5plus-megatron'),
                            'param_name' => 'itemstabletsmall',
                            'description' => esc_html__('Browser Width >= 600', 'g5plus-megatron'),
                            'value' => '',
                            'std' => '2'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Mobile', 'g5plus-megatron'),
                            'param_name' => 'itemsmobile',
                            'description' => esc_html__('Browser Width < 600', 'g5plus-megatron'),
                            'value' => '',
                            'std' => '1'
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(array(
                    'name' => esc_html__('Headings', 'g5plus-megatron'),
                    'base' => 'megatron_heading',
                    'class' => '',
                    'icon' => 'fa fa-header',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Title', 'g5plus-megatron'),
                            'param_name' => 'title',
                            'value' => '',
                            'admin_label' => true
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Title Size', 'g5plus-megatron'),
                            'param_name' => 'size',
                            'value' => array(
                                esc_html__('Extra Small','g5plus-megatron') => 'size-xs',
                                esc_html__('Small', 'g5plus-megatron') => 'size-sm',
                                esc_html__('Medium', 'g5plus-megatron') => 'size-md',
                                esc_html__('Large', 'g5plus-megatron') => 'size-lg',
                                esc_html__('Extra Large', 'g5plus-megatron') => 'size-xlg'),
                            'description' => esc_html__('Select Size for your element.', 'g5plus-megatron'),
                            'admin_label' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Sub Title', 'g5plus-megatron'),
                            'param_name' => 'sub_title',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => esc_html__('Description', 'g5plus-megatron'),
                            'param_name' => 'description',
                            'value' => '',
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Line below','g5plus-megatron'),
                            'param_name' => 'line_style',
                            'value' => array(
                                esc_html__('None ','g5plus-megatron')=>'',
                                esc_html__('Double color ','g5plus-megatron')=>'line-double',
                                esc_html__('Single color','g5plus-megatron')=>'line-single',),
                            'description' => esc_html__('Select line below style for your element.', 'g5plus-megatron'),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Text Align', 'g5plus-megatron'),
                            'param_name' => 'text_align',
                            'value' => array(
                                esc_html__('Center', 'g5plus-megatron') => 'text-center',
                                esc_html__('Left', 'g5plus-megatron') => 'text-left',
                                esc_html__('Right', 'g5plus-megatron') => 'text-right'),
                            'description' => esc_html__('Select text align.', 'g5plus-megatron')
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Color Scheme', 'g5plus-megatron'),
                            'param_name' => 'color_scheme',
                            'value' => array(
                                esc_html__('Dark', 'g5plus-megatron') => 'color-dark',
                                esc_html__('Light', 'g5plus-megatron') => 'color-light'),
                            'description' => esc_html__('Select Color Scheme.', 'g5plus-megatron')
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(
                    array(
                        'name' => esc_html__('Icon Box', 'g5plus-megatron'),
                        'base' => 'megatron_icon_box',
                        'icon' => 'fa fa-diamond',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'description' => 'Adds icon box with font icons',
                        'params' => array(
                            $icon_type,
                            $icon_megatron,
                            $icon_fontawesome,
                            $icon_openiconic,
                            $icon_typicons,
                            $icon_entypo,
                            $icon_linecons,
                            $icon_image,
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Icon Background Shape', 'g5plus-megatron'),
                                'param_name' => 'layout_style',
                                'admin_label' => true,
                                'value' => array(
                                    esc_html__('None', 'g5plus-megatron') => 'default',
                                    esc_html__('Circle', 'g5plus-megatron') => 'icon-box-circle',
                                    esc_html__('Transparent, Light','g5plus-megatron')=>'icon-box-light'),
                                'description' => esc_html__('Select Layout Style.', 'g5plus-megatron')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Icon Alignment', 'g5plus-megatron'),
                                'param_name' => 'i_align',
                                'value' => array(
                                    esc_html__('Top-Center', 'g5plus-megatron') => 'text-center',
                                    esc_html__('Top Inline-Title', 'g5plus-megatron') => 'top-inline',
                                    esc_html__('Left', 'g5plus-megatron') => 'left',
                                    esc_html__('Left Inline-Title ','g5plus-megatron') => 'left-inline'),
                                'description' => esc_html__('Select To Place Icon.','g5plus-megatron'),
                                'dependency'=> array('element'=>'layout_style','value'=>array('default','icon-box-circle'))
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Title', 'g5plus-megatron'),
                                'param_name' => 'title',
                                'value' => '',
                                'description' => esc_html__('Provide the title for this element.', 'g5plus-megatron'),
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Sub Title', 'g5plus-megatron'),
                                'param_name' => 'sub_title',
                                'value' => '',
                                'description' => esc_html__('Provide the sub title for this element.', 'g5plus-megatron'),
                            ),
                            array(
                                'type' => 'textarea',
                                'heading' => esc_html__('Description', 'g5plus-megatron'),
                                'param_name' => 'description',
                                'value' => '',
                                'description' => esc_html__('Provide the description for this element.', 'g5plus-megatron'),
                                'dependency'=> array('element'=>'layout_style','value'=>array('default','icon-box-circle'))
                            ),
                            array(
                                'type' => 'vc_link',
                                'heading' => esc_html__('Link (url)', 'g5plus-megatron'),
                                'param_name' => 'link',
                                'value' => '',
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Color Scheme', 'g5plus-megatron'),
                                'param_name' => 'color_scheme',
                                'value' => array(
                                    esc_html__('Dark', 'g5plus-megatron') => 'color-dark',
                                    esc_html__('Light', 'g5plus-megatron') => 'color-light'),
                                'description' => esc_html__('Select Color Scheme.', 'g5plus-megatron'),
                                'dependency'=> array('element'=>'layout_style','value'=>array('default','icon-box-circle'))
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    )
                );
                vc_map(
                    array(
                        'name' => esc_html__('Social Icon','g5plus-megatron'),
                        'base' => 'megatron_social_icon',
                        'icon' => 'fa fa-share-square-o',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Layout Style','g5plus-megatron'),
                                'param_name' => 'layout_style',
                                'admin_label' => true,
                                'value' => array(
                                    esc_html__('Border and Text','g5plus-megatron')=>'style1',
                                    esc_html__('Border and Icon','g5plus-megatron')=>'style2',
                                    esc_html__('Background and Icon','g5plus-megatron')=>'style3',
                                ),
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Size','g5plus-megatron'),
                                'param_name' => 'size',
                                'admin_label' => true,
                                'value' => array(
                                    esc_html__('Small','g5plus-megatron')=>'size-sm',
                                    esc_html__('Medium','g5plus-megatron')=>'size-md',
                                    esc_html__('Large','g5plus-megatron')=>'size-lg',
                                ),
                            ),
                            array(
                                'type' => 'param_group',
                                'heading' => esc_html__('Values','g5plus-megatron'),
                                'param_name' => 'values',
                                'description'=>esc_html__('Enter values for title social-icon, icon, color. ','g5plus-megatron'),
                                'value' => urlencode(json_encode(array(
                                    array(
                                        'name' => esc_html__('Facebook','g5plus-megatron'),
                                        'link' => 'https://www.facebook.com/',
                                    ),
                                    array(
                                        'name' => esc_html__('Twitter','g5plus-megatron'),
                                        'link' => 'https://www.twitter.com/',
                                    ),
                                    array(
                                        'name' => esc_html__('Google Plus','g5plus-megatron'),
                                        'link' => 'https://www.google.com/',
                                    ),
                                ))),
                                'params' => array(
                                    array(
                                        'type' => 'textfield',
                                        'heading' => esc_html__('Name','g5plus-megatron'),
                                        'param_name' => 'name',
                                        'value' => '',
                                        'admin_label' => true,
                                        'description' => esc_html__('Enter Name','g5plus-megatron')
                                    ),
                                    array(
                                        'type' => 'textfield',
                                        'heading' => esc_html__('Link','g5plus-megatron'),
                                        'param_name' => 'link',
                                        'value' => '',
                                        'std' => '#',
                                        'description' => esc_html__('Enter Link','g5plus-megatron')
                                    ),
                                    array(
                                        'type' => 'colorpicker',
                                        'heading' => esc_html__('Color','g5plus-megatron'),
                                        'param_name' => 'color',
                                        'value' => '',
                                        'description' => esc_html__('Select color for your element','g5plus-megatron')
                                    ),
                                    $icon_type,
                                    $icon_megatron,
                                    $icon_fontawesome,
                                    $icon_openiconic,
                                    $icon_typicons,
                                    $icon_entypo,
                                    $icon_linecons,
                                    $icon_image,
                                ),
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    )
                );

                vc_map(
                    array(
                        'name' => esc_html__('List','g5plus-megatron'),
                        'base' => 'megatron_list',
                        'icon' => 'fa fa-list-ul',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Layout Style','g5plus-megatron'),
                                'param_name' => 'layout_style',
                                'admin_label' => true,
                                'value' => array(
                                    esc_html__('Bulleted Circle','g5plus-megatron')=>'style1',
                                    esc_html__('Bulleted Square','g5plus-megatron')=>'style2',
                                    esc_html__('Numbered','g5plus-megatron')=>'style3',
                                    esc_html__('Numbered Leading Zero','g5plus-megatron')=>'style4',
                                    esc_html__('Numbered Leading Zero Background Circle','g5plus-megatron')=>'style5',
                                    esc_html__('Icon','g5plus-megatron')=>'style6',
                                ),
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Color','g5plus-megatron'),
                                'param_name' => 'color',
                                'value' => array(
                                    esc_html__('Primary Color','g5plus-megatron')=>'p-color-bg',
                                    esc_html__('Secondary Color','g5plus-megatron')=>'s-color-bg',
                                    esc_html__('Gray','g5plus-megatron')=>'list-color-gray',
                                ),
                                'description' => esc_html__('Select color for your element','g5plus-megatron')
                            ),
                            array(
                                'type' => 'param_group',
                                'heading' => esc_html__('Values','g5plus-megatron'),
                                'param_name' => 'values_general',
                                'description'=>esc_html__('Enter values for title list. ','g5plus-megatron'),
                                'dependency' => array('element'=>'layout_style','value'=>array(
                                    'style1',
                                    'style2',
                                    'style3',
                                    'style4',
                                    'style5',
                                )),
                                'value' => urlencode(json_encode(array(
                                    array(
                                        'title' => esc_html__('List title line one','g5plus-megatron'),
                                    ),
                                    array(
                                        'title' => esc_html__('List title line two','g5plus-megatron'),
                                    ),
                                    array(
                                        'title' => esc_html__('List title line three','g5plus-megatron'),
                                    ),
                                ))),
                                'params' => array(
                                    array(
                                        'type' => 'textfield',
                                        'heading' => esc_html__('Title','g5plus-megatron'),
                                        'param_name' => 'title',
                                        'value' => '',
                                        'admin_label' => true,
                                        'description' => esc_html__('Enter Title.','g5plus-megatron')),
                                ),
                            ),
                            array(
                                'type' => 'param_group',
                                'heading' => esc_html__('Values','g5plus-megatron'),
                                'param_name' => 'values_separate',
                                'description'=>esc_html__('Enter values for title. ','g5plus-megatron'),
                                'dependency' => array('element'=>'layout_style','value'=>'style6'),
                                'value' => urlencode(json_encode(array(
                                    array(
                                        'title' => esc_html__('List title line one','g5plus-megatron'),
                                    ),
                                    array(
                                        'title' => esc_html__('List title line two','g5plus-megatron'),
                                    ),
                                    array(
                                        'title' => esc_html__('List title line three','g5plus-megatron'),
                                    ),
                                ))),
                                'params' => array(
                                    array(
                                        'type' => 'textfield',
                                        'heading' => esc_html__('Title','g5plus-megatron'),
                                        'param_name' => 'title',
                                        'value' => '',
                                        'admin_label' => true,
                                        'description' => esc_html__('Enter Title','g5plus-megatron')
                                    ),
                                    $icon_type,
                                    $icon_megatron,
                                    $icon_fontawesome,
                                    $icon_openiconic,
                                    $icon_typicons,
                                    $icon_entypo,
                                    $icon_linecons,
                                    $icon_image,
                                ),
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    )
                );

                vc_map(
                    array(
                        'name' => esc_html__('Banner', 'g5plus-megatron'),
                        'base' => 'megatron_banner',
                        'icon' => 'fa fa-file-image-o',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'description' => esc_html__('Interactive banner', 'g5plus-megatron'),
                        'params' => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Layout Style', 'g5plus-megatron'),
                                'param_name' => 'layout_style',
                                'admin_label' => true,
                                'value' => array(
                                   esc_html__('Detail Light','g5plus-megatron')=>'style1',
                                   esc_html__('Simple Dark','g5plus-megatron')=>'style2',
                                   esc_html__('Background Icon','g5plus-megatron')=>'style3',
                                   esc_html__('Sale Off','g5plus-megatron')=>'style4'
                                ),
                                'description' => esc_html__('Select Layout Style.', 'g5plus-megatron')
                            ),
                            array(
                                'type' => 'attach_image',
                                'heading' => esc_html__('Image Banner:', 'g5plus-megatron'),
                                'param_name' => 'image',
                                'value' => '',
                                'dependency' => array(
                                    'element'=>'layout_style',
                                    'value'=>array('style1','style2','style4'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Icon Color', 'g5plus-megatron'),
                                'param_name' => 'icon_color',
                                'value' => array(
                                    esc_html__('Light', 'g5plus-megatron') => 'icon-light',
                                    esc_html__('Dark', 'g5plus-megatron') => 'icon-dark',
                                ),
                                'description' => esc_html__('Select color for your element', 'g5plus-megatron'),
                                'dependency' => array('element'=>'layout_style','value'=>'style3')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Background Color', 'g5plus-megatron'),
                                'param_name' => 'bg_color',
                                'value' => array(
                                    esc_html__('Light', 'g5plus-megatron') => 'banner-bg-light',
                                    esc_html__('Gray', 'g5plus-megatron') => 'banner-bg-gray',
                                    esc_html__('Primary', 'g5plus-megatron') => 'p-color-bg',
                                    esc_html__('Secondary', 'g5plus-megatron') => 's-color-bg',
                                    esc_html__('Dark', 'g5plus-megatron') => 'banner-bg-dark',
                                ),
                                'description' => esc_html__('Select color for your element', 'g5plus-megatron'),
                                'dependency' => array('element'=>'layout_style','value'=>'style3')
                            ),
                            array(
                                'type' => 'vc_link',
                                'heading' => esc_html__('Link (url)', 'g5plus-megatron'),
                                'param_name' => 'link',
                                'value' => '',
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Add Button?', 'g5plus-megatron'),
                                'param_name' => 'add_button',
                                'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'add-button'),
                                'dependency' => array('element'=>'layout_style','value'=>array('style1','style3')),
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Icon library', 'g5plus-megatron'),
                                'value' => array(
                                    esc_html__('[None]', 'g5plus-megatron') => '',
                                    esc_html__('Megatron Icon', 'g5plus-megatron') => 'megatron',
                                    esc_html__('Font Awesome', 'g5plus-megatron') => 'fontawesome',
                                    esc_html__('Open Iconic', 'g5plus-megatron') => 'openiconic',
                                    esc_html__('Typicons', 'g5plus-megatron') => 'typicons',
                                    esc_html__('Entypo', 'g5plus-megatron') => 'entypo',
                                    esc_html__('Linecons', 'g5plus-megatron') => 'linecons',
                                    esc_html__('Image', 'g5plus-megatron') => 'image',
                                ),
                                'param_name' => 'icon_type',
                                'description' => esc_html__('Select icon library.', 'g5plus-megatron'),
                                'dependency' => array('element'=>'layout_style','value'=>array('style3','style2'))
                            ),
                            $icon_megatron,
                            $icon_fontawesome,
                            $icon_openiconic,
                            $icon_typicons,
                            $icon_entypo,
                            $icon_linecons,
                            $icon_image,
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Title', 'g5plus-megatron'),
                                'param_name' => 'title',
                                'value' => '',
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Sale Off', 'g5plus-megatron'),
                                'param_name' => 'sale_off',
                                'value' => '',
                                'dependency' => array('element'=>'layout_style','value'=>'style4')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Sub Title', 'g5plus-megatron'),
                                'param_name' => 'sub_title',
                                'value' => '',
                            ),
                            array(
                                'type' => 'textarea',
                                'heading' => esc_html__('Description', 'g5plus-megatron'),
                                'param_name' => 'description',
                                'value' => '',
                                'dependency' => array('element'=>'layout_style','value'=>array('style1','style3'))
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Banner Height', 'g5plus-megatron'),
                                'param_name' => 'height',
                                'value' => '',
                            ),

                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    )
                );
                $product_cat = array();
                if (class_exists('WooCommerce')) {
                    $args = array(
                        'number' => '',
                    );
                    $product_categories = get_terms('product_cat', $args);
                    if (is_array($product_categories)) {
                        foreach ($product_categories as $cat) {
                            $product_cat[$cat->name] = $cat->slug;
                        }
                    }


                    vc_map(
                        array(
                            'name' => esc_html__('Product', 'g5plus-megatron'),
                            'base' => 'megatron_product',
                            'icon' => 'fa fa-shopping-cart',
                            'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                            'params' => array(
                                array(
                                    "type" => "textfield",
                                    "heading" => esc_html__("Title", 'g5plus-megatron'),
                                    "param_name" => "title",
                                    "admin_label" => true,
                                    "value" => ''
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => esc_html__('Feature', 'g5plus-megatron'),
                                    'param_name' => 'feature',
                                    "admin_label" => true,
                                    'value' => array(
                                        esc_html__('All', 'g5plus-megatron') => 'all',
                                        esc_html__('Sale Off', 'g5plus-megatron') => 'sale',
                                        esc_html__('New In', 'g5plus-megatron') => 'new-in',
                                        esc_html__('Featured', 'g5plus-megatron') => 'featured',
                                        esc_html__('Top rated', 'g5plus-megatron') => 'top-rated',
                                        esc_html__('Recent review', 'g5plus-megatron') => 'recent-review',
                                        esc_html__('Best Selling', 'g5plus-megatron') => 'best-selling'
                                    )
                                ),
                                array(
                                    'type' => 'multi-select',
                                    'heading' => esc_html__('Narrow Category', 'g5plus-megatron'),
                                    'param_name' => 'category',
                                    'options' => $product_cat,
                                    "admin_label" => true,
                                ),
                                array(
                                    "type" => "textfield",
                                    "heading" => esc_html__("Total Items", 'g5plus-megatron'),
                                    "param_name" => "per_page",
                                    "admin_label" => true,
                                    "value" => '8',
                                    "description" => esc_html__('How much total items to show', 'g5plus-megatron'),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                                ),

                                array(
                                    'type' => 'dropdown',
                                    "heading" => esc_html__("Columns", 'g5plus-megatron'),
                                    "param_name" => "columns",
                                    "admin_label" => true,
                                    'value' => array(
                                        '2' => 2,
                                        '3' => 3,
                                        '4' => 4,
                                    ),
                                    'std' => 4,
                                    "description" => esc_html__("How much columns grid", 'g5plus-megatron'),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                                ),

                                array(
                                    'type' => 'checkbox',
                                    'heading' => esc_html__('Show Rating', 'g5plus-megatron'),
                                    'param_name' => 'rating',
                                    'std' => 1,
                                    'value' => array(
                                        esc_html__('Yes, please', 'g5plus-megatron') => 1
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                                ),
                                array(
                                    'type' => 'checkbox',
                                    'heading' => esc_html__('Display Slider', 'g5plus-megatron'),
                                    'param_name' => 'slider',
                                    'std' => '',
                                    'value' => array(
                                        esc_html__('Yes, please', 'g5plus-megatron') => 'slider'
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                                ),

                                array(
                                    'type' => 'checkbox',
                                    'heading' =>  esc_html__('Navigation', 'g5plus-megatron'),
                                    'param_name' => 'nav',
                                    'description' => esc_html__('Show navigation.', 'g5plus-megatron'),
                                    'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                                    'dependency' => array(
                                        'element' => 'slider',
                                        'value' => array('slider')
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                                ),
                                array(
                                    'type' => 'checkbox',
                                    'heading' => esc_html__('Pagination', 'g5plus-megatron'),
                                    'param_name' => 'dots',
                                    'description' => esc_html__('Show pagination.', 'g5plus-megatron'),
                                    'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                                    'dependency' => array(
                                        'element' => 'slider',
                                        'value' => array('slider')
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                                ),


                                array(
                                    'type' => 'checkbox',
                                    'heading' => esc_html__('AutoPlay', 'g5plus-megatron'),
                                    'param_name' => 'auto_play',
                                    'std' => 0,
                                    'value' => array(
                                        esc_html__('Yes, please', 'g5plus-megatron') => 1
                                    ),
                                    'dependency' => array(
                                        'element' => 'slider',
                                        'value' => array('slider')
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                                ),

                                array(
                                    "type" => "textfield",
                                    "heading" => esc_html__("AutoPlay Speed", 'g5plus-megatron'),
                                    "param_name" => "auto_play_speed",
                                    "value" => 5000,
                                    "description" => esc_html__('How much speed autoPlay (ms)', 'g5plus-megatron'),
                                    'dependency' => array(
                                        'element' => 'slider',
                                        'value' => array('slider')
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                                ),

                                array(
                                    'type' => 'dropdown',
                                    'heading' => esc_html__('Order by', 'g5plus-megatron'),
                                    'param_name' => 'orderby',
                                    'value' => array(
                                        esc_html__('Date', 'g5plus-megatron') => 'date',
                                        esc_html__('Price', 'g5plus-megatron') => 'price',
                                        esc_html__('Random', 'g5plus-megatron') => 'rand',
                                        esc_html__('Sales', 'g5plus-megatron') => 'sales'
                                    ),
                                    'description' => esc_html__('Select how to sort retrieved products.', 'g5plus-megatron'),
                                    'dependency' => array(
                                        'element' => 'feature',
                                        'value' => array('all', 'sale', 'featured')
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => esc_html__('Order way', 'g5plus-megatron'),
                                    'param_name' => 'order',
                                    'value' => array(
                                        esc_html__('Descending', 'g5plus-megatron') => 'DESC',
                                        esc_html__('Ascending', 'g5plus-megatron') => 'ASC'
                                    ),
                                    'description' => esc_html__('Designates the ascending or descending order.', 'g5plus-megatron'),
                                    'dependency' => array(
                                        'element' => 'feature',
                                        'value' => array('all', 'sale', 'featured')
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                                ),
                                $add_el_class,
                                $add_css_animation,
                                $add_duration_animation,
                                $add_delay_animation
                            )
                        )
                    );

                    vc_map(array(
                        'name' => esc_html__('Product Categories', 'g5plus-megatron'),
                        'base' => 'megatron_product_categories',
                        'class' => '',
                        'icon' => 'fa fa-cart-plus',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__("Title", 'g5plus-megatron'),
                                "param_name" => "title",
                                "admin_label" => true,
                                "value" => ''
                            ),
                            array(
                                'type' => 'multi-select',
                                'heading' => esc_html__('Narrow Category', 'g5plus-megatron'),
                                'param_name' => 'category',
                                'options' => $product_cat
                            ),
                            array(
                                'type' => 'dropdown',
                                "heading" => esc_html__("Columns", 'g5plus-megatron'),
                                "param_name" => "columns",
                                "admin_label" => true,
                                'value' => array(
                                    '2' => 2,
                                    '3' => 3,
                                    '4' => 4,
                                ),
                                'std' => 4,
                                "description" => esc_html__("How much columns grid", 'g5plus-megatron'),
                            ),

                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Hide empty', 'g5plus-megatron'),
                                'param_name' => 'hide_empty',
                                'std' => 0,
                                'value' => array(
                                    esc_html__('Yes, please', 'g5plus-megatron') => 1
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column'
                            ),

                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Display Slider', 'g5plus-megatron'),
                                'param_name' => 'slider',
                                'std' => '',
                                'value' => array(
                                    esc_html__('Yes, please', 'g5plus-megatron') => 'slider'
                                ),
                                "admin_label" => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column'
                            ),

                            array(
                                'type' => 'checkbox',
                                'heading' =>  esc_html__('Navigation', 'g5plus-megatron'),
                                'param_name' => 'nav',
                                'description' => esc_html__('Show navigation.', 'g5plus-megatron'),
                                'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                                'dependency' => array(
                                    'element' => 'slider',
                                    'value' => array('slider')
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column'
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Pagination', 'g5plus-megatron'),
                                'param_name' => 'dots',
                                'description' => esc_html__('Show pagination.', 'g5plus-megatron'),
                                'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                                'dependency' => array(
                                    'element' => 'slider',
                                    'value' => array('slider')
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column'
                            ),

                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('AutoPlay', 'g5plus-megatron'),
                                'param_name' => 'auto_play',
                                'std' => 0,
                                'value' => array(
                                    esc_html__('Yes, please', 'g5plus-megatron') => 1
                                ),
                                'dependency' => array(
                                    'element' => 'slider',
                                    'value' => array('slider')
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__("AutoPlay Speed", 'g5plus-megatron'),
                                "param_name" => "auto_play_speed",
                                "value" => 5000,
                                "description" => esc_html__('How much speed autoPlay (ms)', 'g5plus-megatron'),
                                'dependency' => array(
                                    'element' => 'slider',
                                    'value' => array('slider')
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),

                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Order by', 'g5plus-megatron'),
                                'param_name' => 'orderby',
                                'value' => array(
                                    esc_html__('Name', 'g5plus-megatron') => 'name',
                                    esc_html__('Order', 'g5plus-megatron') => 'order'
                                ),
                                'description' => esc_html__('Select how to sort retrieved products.', 'g5plus-megatron'),
                                'edit_field_class' => 'vc_col-sm-6 vc_column'
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Order way', 'g5plus-megatron'),
                                'param_name' => 'order',
                                'value' => array(
                                    esc_html__('Descending', 'g5plus-megatron') => 'DESC',
                                    esc_html__('Ascending', 'g5plus-megatron') => 'ASC'
                                ),
                                'description' => esc_html__('Designates the ascending or descending orde.', 'g5plus-megatron'),
                                'edit_field_class' => 'vc_col-sm-6 vc_column'
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    ));



                    vc_map(
                        array(
                            'name' => esc_html__('Product Sidebar', 'g5plus-megatron'),
                            'base' => 'megatron_product_sidebar',
                            'icon' => 'fa fa-shopping-cart',
                            'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                            'params' => array(
                                array(
                                    "type" => "textfield",
                                    "heading" => esc_html__("Title", 'g5plus-megatron'),
                                    "param_name" => "title",
                                    "admin_label" => true,
                                    "value" => ''
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => esc_html__('Feature', 'g5plus-megatron'),
                                    'param_name' => 'feature',
                                    "admin_label" => true,
                                    'value' => array(
                                        esc_html__('All', 'g5plus-megatron') => 'all',
                                        esc_html__('Sale Off', 'g5plus-megatron') => 'sale',
                                        esc_html__('New In', 'g5plus-megatron') => 'new-in',
                                        esc_html__('Featured', 'g5plus-megatron') => 'featured',
                                        esc_html__('Top rated', 'g5plus-megatron') => 'top-rated',
                                        esc_html__('Recent review', 'g5plus-megatron') => 'recent-review',
                                        esc_html__('Best Selling', 'g5plus-megatron') => 'best-selling'
                                    )
                                ),
                                array(
                                    'type' => 'multi-select',
                                    'heading' => esc_html__('Narrow Category', 'g5plus-megatron'),
                                    'param_name' => 'category',
                                    'options' => $product_cat,
                                    "admin_label" => true,
                                ),
                                array(
                                    "type" => "textfield",
                                    "heading" => esc_html__("Total Items", 'g5plus-megatron'),
                                    "param_name" => "total_item",
                                    "admin_label" => true,
                                    "value" => 8,
                                    "description" => esc_html__('How much total items to show', 'g5plus-megatron')
                                ),


                                array(
                                    'type' => 'checkbox',
                                    'heading' => esc_html__('Display Slider', 'g5plus-megatron'),
                                    'param_name' => 'slider',
                                    'std' => '',
                                    'value' => array(
                                        esc_html__('Yes, please', 'g5plus-megatron') => 'slider'
                                    )
                                ),


                                array(
                                    "type" => "textfield",
                                    "heading" => esc_html__("Per Page", 'g5plus-megatron'),
                                    "param_name" => "per_page",
                                    "value" => 4,
                                    "description" => esc_html__('How much items per page to show', 'g5plus-megatron'),
                                    'dependency' => array(
                                        'element' => 'slider',
                                        'value' => array('slider')
                                    ),
                                ),

                                array(
                                    'type' => 'checkbox',
                                    'heading' => esc_html__('AutoPlay', 'g5plus-megatron'),
                                    'param_name' => 'auto_play',
                                    'std' => 0,
                                    'value' => array(
                                        esc_html__('Yes, please', 'g5plus-megatron') => 1
                                    ),
                                    'dependency' => array(
                                        'element' => 'slider',
                                        'value' => array('slider')
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                                ),


                                array(
                                    "type" => "textfield",
                                    "heading" => esc_html__("AutoPlay Speed", 'g5plus-megatron'),
                                    "param_name" => "auto_play_speed",
                                    "value" => 5000,
                                    "description" => esc_html__('How much speed autoPlay (ms)', 'g5plus-megatron'),
                                    'dependency' => array(
                                        'element' => 'auto_play',
                                        'value' => array('1')
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                                ),


                                array(
                                    'type' => 'dropdown',
                                    'heading' => esc_html__('Order by', 'g5plus-megatron'),
                                    'param_name' => 'orderby',
                                    'value' => array(
                                        esc_html__('Date', 'g5plus-megatron') => 'date',
                                        esc_html__('Price', 'g5plus-megatron') => 'price',
                                        esc_html__('Random', 'g5plus-megatron') => 'rand',
                                        esc_html__('Sales', 'g5plus-megatron') => 'sales'

                                    ),
                                    'description' => esc_html__('Select how to sort retrieved products.', 'g5plus-megatron'),
                                    'dependency' => array(
                                        'element' => 'feature',
                                        'value' => array('all', 'sale', 'featured')
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => esc_html__('Order way', 'g5plus-megatron'),
                                    'param_name' => 'order',
                                    'value' => array(
                                        esc_html__('Descending', 'g5plus-megatron') => 'DESC',
                                        esc_html__('Ascending', 'g5plus-megatron') => 'ASC'
                                    ),
                                    'description' => esc_html__('Designates the ascending or descending order.', 'g5plus-megatron'),
                                    'dependency' => array(
                                        'element' => 'feature',
                                        'value' => array('all', 'sale', 'featured')
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column'
                                ),
                                $add_el_class,
                                $add_css_animation,
                                $add_duration_animation,
                                $add_delay_animation
                            )
                        )
                    );
                }

                vc_map(
                    array(
                        'name' => esc_html__('Megatron Google Map', 'g5plus-megatron'),
                        'base' => 'megatron_google_map',
                        'icon' => 'fa fa-map-marker',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Location X', 'g5plus-megatron'),
                                'param_name' => 'location_x',
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6',
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Location Y', 'g5plus-megatron'),
                                'param_name' => 'location_y',
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6',
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Map height', 'g5plus-megatron'),
                                'param_name' => 'map_height',
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6',
                                'std' => '500px',
                                'description' => esc_html__('Set map height (px or %).', 'g5plus-megatron')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Map style', 'g5plus-megatron'),
                                'param_name' => 'map_style',
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6',
                                'std' => 'gray_scale',
                                'value' => array(
                                    esc_html__('None', 'g5plus-megatron') => 'none',
                                    esc_html__('Gray Scale', 'g5plus-megatron') => 'gray_scale',
                                    esc_html__('Icy Blue', 'g5plus-megatron') => 'icy_blue',
                                    esc_html__('Mono Green', 'g5plus-megatron') => 'mono_green',
                                )
                            ),
                            array(
                                'type' => 'number',
                                'heading' => esc_html__('Map zoom', 'g5plus-megatron'),
                                'param_name' => 'map_zoom',
                                'admin_label' => true,
                                'std' => '11',
                                'min' => '1',
                                'max' => '16',
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Layout Style', 'g5plus-megatron'),
                                'param_name' => 'layout_style',
                                'admin_label' => true,
                                'value' => array(esc_html__('Show Marker Icon', 'g5plus-megatron') => 'marker', esc_html__('Show Info Windows', 'g5plus-megatron') => 'infowindow'),
                                'description' => esc_html__('Select Layout Style.', 'g5plus-megatron'),
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Marker title', 'g5plus-megatron'),
                                'param_name' => 'marker_title',
                                'dependency' => array(
                                    'element' => 'layout_style',
                                    'value' => 'marker',
                                ),
                            ),
                            array(
                                'type' => 'attach_image',
                                'heading' => esc_html__( 'Marker Icon', 'g5plus-megatron' ),
                                'param_name' => 'marker_icon',
                                'value' => '',
                                'description' => esc_html__( 'Select an image from media library.', 'g5plus-megatron' ),
                                'dependency' => array(
                                    'element' => 'layout_style',
                                    'value' => 'marker',
                                ),
                            ),
                            array(
                                'type' => 'textarea_raw_html',
                                'heading' => esc_html__( 'Info Windows HTML', 'g5plus-megatron' ),
                                'param_name' => 'info_html',
                                'description' => esc_html__( 'Enter your HTML content.', 'g5plus-megatron' ),
                                'dependency' => array(
                                    'element' => 'layout_style',
                                    'value' => 'infowindow',
                                ),
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Max Width', 'g5plus-megatron'),
                                'param_name' => 'info_max_width',
                                'std'=>210,
                                'dependency' => array(
                                    'element' => 'layout_style',
                                    'value' => 'infowindow',
                                ),
                            ),
                            array(
                                'type' => 'colorpicker',
                                'heading' => esc_html__('Background color', 'g5plus-megatron'),
                                'param_name' => 'info_bg',
                                'value' => '',
                                'dependency' => array(
                                    'element' => 'layout_style',
                                    'value' => 'infowindow',
                                ),
                            ),
                            array(
                                'type' => 'colorpicker',
                                'heading' => esc_html__('Color', 'g5plus-megatron'),
                                'param_name' => 'info_color',
                                'value' => '',
                                'dependency' => array(
                                    'element' => 'layout_style',
                                    'value' => 'infowindow',
                                ),
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    )
                );
                vc_map( array(
                    'name' => esc_html__( 'Process', 'g5plus-megatron' ),
                    'base' => 'megatron_process',
                    'icon' => 'fa fa-sort-numeric-asc',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Layout Style', 'g5plus-megatron'),
                            'param_name' => 'layout_style',
                            'admin_label' => true,
                            'value' => array(esc_html__('Large icon', 'g5plus-megatron') => 'style1', esc_html__('Small icon', 'g5plus-megatron') => 'style2', esc_html__('Show step number', 'g5plus-megatron') => 'style3'),
                            'description' => esc_html__('Select Layout Style.', 'g5plus-megatron')
                        ),
                        array(
                            'type' => 'param_group',
                            'heading' => esc_html__( 'Steps', 'g5plus-megatron' ),
                            'param_name' => 'values',
                            'value' => urlencode( json_encode( array(
                                array(
                                    'label' => esc_html__( 'Title', 'g5plus-megatron' ),
                                    'value' => 'Step 1',
                                ),
                            ) ) ),
                            'params' => array(
                                $icon_type,
                                $icon_megatron,
                                $icon_fontawesome,
                                $icon_openiconic,
                                $icon_typicons,
                                $icon_entypo,
                                $icon_linecons,
                                $icon_image,
                                array(
                                    'type' => 'vc_link',
                                    'heading' => esc_html__('Link (url)', 'g5plus-megatron'),
                                    'param_name' => 'link',
                                    'value' => '',
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => esc_html__( 'Title', 'g5plus-megatron' ),
                                    'param_name' => 'title',
                                    'admin_label' => true,
                                ),
                                array(
                                    'type' => 'textarea',
                                    'heading' => esc_html__( 'Description', 'g5plus-megatron' ),
                                    'param_name' => 'description',
                                    'admin_label' => false,
                                ),
                            ),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Background Scheme', 'g5plus-megatron'),
                            'param_name' => 'bg_scheme',
                            'value' => array(
                                esc_html__('Gray - Dark', 'g5plus-megatron') => 'gray-dark',
                                esc_html__('Primary color - Dark', 'g5plus-megatron') => 'primary-dark',
                                esc_html__('Light - Gray', 'g5plus-megatron') => 'light-gray'),
                            'std' => 'gray-dark',
                            'description' => esc_html__('Select Background Scheme.', 'g5plus-megatron'),
                            'dependency' => array('element' => 'layout_style', 'value' => array('style3')),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Height (px)', 'g5plus-megatron'),
                            'param_name' => 'height',
                            'value' => '',
                            'std' => 316,
                            'dependency' => array('element' => 'layout_style', 'value' => array('style3')),
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ) );
                vc_map( array(
                    'name' => esc_html__( 'Menu Scroll', 'g5plus-megatron' ),
                    'base' => 'megatron_menu_scroll',
                    'icon' => 'fa fa-list',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_parent' => array('except' => 'megatron_menu_scroll'),
                    'content_element' => true,
                    'show_settings_on_create' => true,
                    'params' => array(
                        array(
                            'type' => 'param_group',
                            'heading' => esc_html__( 'Menu Items', 'g5plus-megatron' ),
                            'param_name' => 'values',
                            'value' => urlencode( json_encode( array(
                                array(
                                    'label' => esc_html__( 'Title', 'g5plus-megatron' ),
                                    'value' => '',
                                ),
                            ) ) ),
                            'params' => array(
                                array(
                                    'type' => 'textfield',
                                    'heading' => esc_html__('Content ID', 'g5plus-megatron'),
                                    'param_name' => 'id',
                                    'value' => '',
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => esc_html__( 'Title', 'g5plus-megatron' ),
                                    'param_name' => 'title',
                                    'admin_label' => true,
                                ),
                            ),
                        ),
                        $add_el_class,
                    ),
                    'js_view' => 'VcColumnView'
                ) );
                vc_map( array(
                    'name' => esc_html__( 'Testimonials', 'g5plus-megatron' ),
                    'base' => 'megatron_testimonial',
                    'icon' => 'fa fa-quote-left',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'param_group',
                            'heading' => esc_html__( 'Testimonials', 'g5plus-megatron' ),
                            'param_name' => 'values',
                            'value' => urlencode( json_encode( array(
                                array(
                                    'label' => esc_html__( 'Author', 'g5plus-megatron' ),
                                    'value' => '',
                                ),
                            ) ) ),
                            'params' => array(
                                array(
                                    'type' => 'attach_image',
                                    'heading' => esc_html__('Avatar:', 'g5plus-megatron'),
                                    'param_name' => 'avatar',
                                    'value' => '',
                                    'description' => esc_html__('Choose the author picture.', 'g5plus-megatron'),
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => esc_html__('Author Info', 'g5plus-megatron'),
                                    'param_name' => 'author',
                                    'admin_label' => true,
                                    'description' => esc_html__('Enter Author information.', 'g5plus-megatron')
                                ),
                                array(
                                    'type' => 'textarea',
                                    'heading' => esc_html__('Quote from author', 'g5plus-megatron'),
                                    'param_name' => 'quote',
                                    'value' => ''
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => esc_html__('Rating', 'g5plus-megatron'),
                                    'param_name' => 'rate',
                                    'value' => array(
                                        'None' => 0,
                                        '1' => 1,
                                        '2' => 2,
                                        '3' => 3,
                                        '4' => 4,
                                        '5' => 5,
                                        '6' => 6,
                                        '7' => 7,
                                        '8' => 8,
                                        '9' => 9,
                                        '10' => 10,
                                    ),
                                ),
                            ),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Layout Style', 'g5plus-megatron'),
                            'param_name' => 'layout_style',
                            'admin_label' => true,
                            'value' => array(esc_html__('Default', 'g5plus-megatron') => 'style1', esc_html__('Text italic, Image top', 'g5plus-megatron') => 'style2', esc_html__('Image bottom, Icon top', 'g5plus-megatron') => 'style3', esc_html__('Icon bottom', 'g5plus-megatron') => 'style4', esc_html__('Image top, rate top', 'g5plus-megatron') => 'style5'),
                            'description' => esc_html__('Select Layout Style.', 'g5plus-megatron')
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Color Scheme', 'g5plus-megatron'),
                            'param_name' => 'color_scheme',
                            'value' => array(
                                esc_html__('Dark', 'g5plus-megatron') => 'color-dark',
                                esc_html__('Light', 'g5plus-megatron') => 'color-light'),
                            'std' => 'dark',
                            'description' => esc_html__('Select Color Scheme.', 'g5plus-megatron')
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Navigation', 'g5plus-megatron'),
                            'param_name' => 'nav',
                            'description' => esc_html__('Show navigation.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Pagination', 'g5plus-megatron'),
                            'param_name' => 'dots',
                            'description' => esc_html__('Show pagination.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Pause on hover', 'g5plus-megatron'),
                            'param_name' => 'autoplayhoverpause',
                            'description' => esc_html__('Pause on mouse hover.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Autoplay Timeout', 'g5plus-megatron'),
                            'param_name' => 'autoplaytimeout',
                            'description' => esc_html__('Autoplay interval timeout.', 'g5plus-megatron'),
                            'value' => '',
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                            'std' => 5000
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ) );
                vc_map( array(
                    'name' => esc_html__( 'Image Slider', 'g5plus-megatron' ),
                    'base' => 'megatron_imageslider',
                    'icon' => 'fa fa-picture-o',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Layout Style', 'g5plus-megatron'),
                            'param_name' => 'layout_style',
                            'admin_label' => true,
                            'value' => array(esc_html__('Pagination control in slider', 'g5plus-megatron') => 'style1', esc_html__('Pagination control under slider', 'g5plus-megatron') => 'style2'),
                            'description' => esc_html__('Select Layout Style.', 'g5plus-megatron')
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__( 'Image source', 'g5plus-megatron' ),
                            'param_name' => 'source',
                            'value' => array(
                                esc_html__( 'Media library', 'g5plus-megatron' ) => 'media_library',
                                esc_html__( 'External links', 'g5plus-megatron' ) => 'external_link',
                            ),
                            'std' => 'media_library',
                            'description' => esc_html__( 'Select image source.', 'g5plus-megatron' ),
                        ),
                        array(
                            'type' => 'attach_images',
                            'heading' => esc_html__( 'Images', 'g5plus-megatron' ),
                            'param_name' => 'images',
                            'value' => '',
                            'description' => esc_html__( 'Select images from media library.', 'g5plus-megatron' ),
                            'dependency' => array(
                                'element' => 'source',
                                'value' => 'media_library',
                            ),
                        ),
                        array(
                            'type' => 'exploded_textarea',
                            'heading' => esc_html__( 'External links', 'g5plus-megatron' ),
                            'param_name' => 'custom_srcs',
                            'description' => esc_html__( 'Enter external link for each gallery image (Note: divide links with linebreaks (Enter)).', 'g5plus-megatron' ),
                            'dependency' => array(
                                'element' => 'source',
                                'value' => 'external_link',
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Image size', 'g5plus-megatron' ),
                            'param_name' => 'img_size',
                            'value' => 'thumbnail',
                            'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'g5plus-megatron' ),
                            'dependency' => array(
                                'element' => 'source',
                                'value' => 'media_library',
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Image size', 'g5plus-megatron' ),
                            'param_name' => 'external_img_size',
                            'value' => '',
                            'description' => esc_html__( 'Enter image size in pixels. Example: 200x100 (Width x Height).', 'g5plus-megatron' ),
                            'dependency' => array(
                                'element' => 'source',
                                'value' => 'external_link',
                            ),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__( 'On click action', 'g5plus-megatron' ),
                            'param_name' => 'onclick',
                            'value' => array(
                                esc_html__( 'None', 'g5plus-megatron' ) => '',
                                esc_html__( 'Link to large image', 'g5plus-megatron' ) => 'img_link_large',
                                esc_html__( 'Open prettyPhoto', 'g5plus-megatron' ) => 'link_image',
                                esc_html__( 'Open custom link', 'g5plus-megatron' ) => 'custom_link',
                            ),
                            'description' => esc_html__( 'Select action for click action.', 'g5plus-megatron' ),
                            'std' => 'link_image',
                        ),
                        array(
                            'type' => 'exploded_textarea',
                            'heading' => esc_html__( 'Custom links', 'g5plus-megatron' ),
                            'param_name' => 'custom_links',
                            'description' => esc_html__( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', 'g5plus-megatron' ),
                            'dependency' => array(
                                'element' => 'onclick',
                                'value' => array( 'custom_link' ),
                            ),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__( 'Custom link target', 'g5plus-megatron' ),
                            'param_name' => 'custom_links_target',
                            'description' => esc_html__( 'Select where to open  custom links.', 'g5plus-megatron' ),
                            'dependency' => array(
                                'element' => 'onclick',
                                'value' => array( 'custom_link', 'img_link_large' ),
                            ),
                            'value' => $target_arr,
                        ),

                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Navigation', 'g5plus-megatron'),
                            'param_name' => 'nav',
                            'description' => esc_html__('Show navigation.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Pagination', 'g5plus-megatron'),
                            'param_name' => 'dots',
                            'description' => esc_html__('Show pagination.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Autoplay', 'g5plus-megatron'),
                            'param_name' => 'autoplay',
                            'description' => esc_html__('Autoplay.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Pause on hover', 'g5plus-megatron'),
                            'param_name' => 'autoplayhoverpause',
                            'description' => esc_html__('Pause on mouse hover.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Autoplay Timeout', 'g5plus-megatron'),
                            'param_name' => 'autoplaytimeout',
                            'description' => esc_html__('Autoplay interval timeout.', 'g5plus-megatron'),
                            'value' => '',
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                            'std' => 5000
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ) );
                vc_map( array(
                    'name' => esc_html__( 'Video', 'g5plus-megatron' ),
                    'base' => 'megatron_video',
                    'icon' => 'fa fa-play-circle',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'attach_image',
                            'heading' => esc_html__( 'Image', 'g5plus-megatron' ),
                            'param_name' => 'image',
                            'value' => '',
                            'description' => esc_html__( 'Select an image from media library.', 'g5plus-megatron' ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Link', 'g5plus-megatron' ),
                            'param_name' => 'link',
                            'value' => '',
                            'description' => esc_html__( 'Enter link video', 'g5plus-megatron' ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Button Text', 'g5plus-megatron' ),
                            'param_name' => 'text',
                            'value' => '',
                            'description' => esc_html__( 'Enter button text', 'g5plus-megatron' ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Height', 'g5plus-megatron' ),
                            'param_name' => 'height',
                            'value' => '',
                            'description' => esc_html__( 'Enter element height', 'g5plus-megatron' ),
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Show shadow', 'g5plus-megatron'),
                            'param_name' => 'shadow',
                            'description' => esc_html__('Show background shadow.', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'std' => 'yes',
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ) );
                vc_map( array(
                    'name' => esc_html__( 'Video Background', 'g5plus-megatron' ),
                    'base' => 'megatron_video_bg',
                    'icon' => 'fa fa-play-circle-o',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_parent' => array('except' => 'megatron_video_bg'),
                    'content_element' => true,
                    'show_settings_on_create' => true,
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Mp4 link', 'g5plus-megatron' ),
                            'param_name' => 'mp4_link',
                            'value' => '',
                            'description' => esc_html__( 'Enter Mp4 link video', 'g5plus-megatron' ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Ogg link', 'g5plus-megatron' ),
                            'param_name' => 'ogg_link',
                            'value' => '',
                            'description' => esc_html__( 'Enter Ogg link video', 'g5plus-megatron' ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Webm link', 'g5plus-megatron' ),
                            'param_name' => 'webm_link',
                            'value' => '',
                            'description' => esc_html__( 'Enter Webm link video', 'g5plus-megatron' ),
                        ),
                        array(
                            'type' => 'attach_image',
                            'heading' => esc_html__( 'Image poster', 'g5plus-megatron' ),
                            'param_name' => 'image',
                            'value' => '',
                            'description' => esc_html__( 'Select an image from media library.', 'g5plus-megatron' ),
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Muted', 'g5plus-megatron'),
                            'param_name' => 'muted',
                            'description' => esc_html__('Set muted video?', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'std'=>'yes'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Loop', 'g5plus-megatron'),
                            'param_name' => 'loop',
                            'description' => esc_html__('Set loop video?', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                            'std'=>'yes'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Show Particles', 'g5plus-megatron'),
                            'param_name' => 'particles',
                            'description' => esc_html__('Show Particles?', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    ),
                    'js_view' => 'VcColumnView'
                ) );
                vc_map(array(
                    'name' => esc_html__('Feature Box', 'g5plus-megatron'),
                    'base' => 'megatron_feature',
                    'class' => '',
                    'icon' => 'fa fa-th-list',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'attach_image',
                            'heading' => esc_html__('Image:', 'g5plus-megatron'),
                            'param_name' => 'image',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Video Url', 'g5plus-megatron'),
                            'param_name' => 'video_url',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Sub Title', 'g5plus-megatron'),
                            'param_name' => 'sub_title',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Title', 'g5plus-megatron'),
                            'param_name' => 'title',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => esc_html__('Description', 'g5plus-megatron'),
                            'param_name' => 'description',
                            'value' => '',
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => esc_html__('Link (url)', 'g5plus-megatron'),
                            'param_name' => 'link',
                            'value' => '',
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(array(
                    'name' => esc_html__('Mailchimp', 'g5plus-megatron'),
                    'base' => 'megatron_mailchimp',
                    'class' => '',
                    'icon' => 'fa fa-envelope',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Color Scheme', 'g5plus-megatron'),
                            'param_name' => 'color_scheme',
                            'value' => array(
                                esc_html__('Dark', 'g5plus-megatron') => 'color-dark',
                                esc_html__('Light', 'g5plus-megatron') => 'color-light'),
                            'std' => 'color-dark',
                            'description' => esc_html__('Select Color Scheme.', 'g5plus-megatron')
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Button Background', 'g5plus-megatron'),
                            'param_name' => 'button_bg',
                            'value' => array(
                                esc_html__('Primary Color', 'g5plus-megatron') => 'button_bg_p',
                                esc_html__('Secondary Color', 'g5plus-megatron') => 'button_bg_s'),
                            'std' => 'button_bg_s',
                            'description' => esc_html__('Select button background color.', 'g5plus-megatron')
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(array(
                    'name' => esc_html__('View Demo', 'g5plus-megatron'),
                    'base' => 'megatron_view_demo',
                    'class' => '',
                    'icon' => 'fa fa-eye',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'attach_image',
                            'heading' => esc_html__('Image:', 'g5plus-megatron'),
                            'param_name' => 'image',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Text', 'g5plus-megatron'),
                            'param_name' => 'text',
                            'value' => '',
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => esc_html__('Link (url)', 'g5plus-megatron'),
                            'param_name' => 'link',
                            'value' => '',
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Is New', 'g5plus-megatron'),
                            'param_name' => 'is_new',
                            'description' => esc_html__('Is New Demo?', 'g5plus-megatron'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-megatron') => 'yes'),
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(
                    array(
                        'name' => esc_html__('Image Box', 'g5plus-megatron'),
                        'base' => 'megatron_image_box',
                        'icon' => 'fa fa-picture-o',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'description' => 'Adds image with content',
                        'params' => array(
                            array(
                                'type' => 'attach_image',
                                'heading' => esc_html__('Choose Image:', 'g5plus-megatron'),
                                'param_name' => 'image',
                                'value' => '',
                                'description' => esc_html__('Upload the custom image.', 'g5plus-megatron'),
                            ),
                            array(
                                'type' => 'vc_link',
                                'heading' => esc_html__('Link (url)', 'g5plus-megatron'),
                                'param_name' => 'link',
                                'value' => '',
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Title', 'g5plus-megatron'),
                                'param_name' => 'title',
                                'value' => '',
                                'description' => esc_html__('Provide the title for this image box.', 'g5plus-megatron'),
                            ),
                            array(
                                'type' => 'textarea',
                                'heading' => esc_html__('Description', 'g5plus-megatron'),
                                'param_name' => 'description',
                                'value' => '',
                                'description' => esc_html__('Provide the description for this image box.', 'g5plus-megatron'),
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    )
                );
            }
        }

    }

    if (!function_exists('init_g5plus_framework_shortcodes')) {
        function init_g5plus_framework_shortcodes()
        {
            return g5plusFramework_Shortcodes::init();
        }

        init_g5plus_framework_shortcodes();
    }
}