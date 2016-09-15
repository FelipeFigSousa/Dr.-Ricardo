<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_ShortCode_Menu_Scroll')) {
    class g5plusFramework_ShortCode_Menu_Scroll
    {
        function __construct()
        {
            add_shortcode('megatron_menu_scroll', array($this, 'menu_scroll_shortcode'));
        }

        function menu_scroll_shortcode($atts, $content)
        {
            /**
             * Shortcode attributes
             * @var $values
             * @var $el_class
             */
            $values=$el_class='';
            $atts = vc_map_get_attributes( 'megatron_menu_scroll', $atts );
            extract( $atts );
	        $g5plus_options = &megatron_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('megatron_menus_croll_css', plugins_url('megatron-framework/includes/shortcodes/menu-scroll/assets/css/menu-scroll' . $min_suffix_css . '.css'), array(), false);
            $min_suffix_js = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' : '';
            wp_enqueue_script('megatron_menus_croll_js', plugins_url('megatron-framework/includes/shortcodes/menu-scroll/assets/js/menu-scroll' . $min_suffix_js . '.js'), array(), false, true);
            $class = 'menu-scroll '.esc_attr($el_class);
            ob_start();?>
            <div class="<?php echo esc_attr($class) ?>">
                <div class="menu-scroll-left" id="nav-scroll">
                    <nav>
                        <ul class="nav">
                        <?php
                        $values = (array) vc_param_group_parse_atts( $values );
                        foreach ( $values as $data ) {
                            $id = isset( $data['id'] ) ? $data['id'] : '';
                            $title = isset( $data['title'] ) ? $data['title'] : '';
                            ?>
                            <li>
                                <a href="#<?php echo esc_attr($id) ?>">
                                    <span><?php echo esc_html($title) ?></span>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        </ul>
                    </nav>
                </div>
                <div class="menu-scroll-content" id="nav-content">
                    <?php echo do_shortcode($content) ?>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_ShortCode_Menu_Scroll();
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_megatron_menu_scroll extends WPBakeryShortCodesContainer {
    }
}