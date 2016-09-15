<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if(!class_exists('g5plusFramework_Shortcode_Heading')){
    class g5plusFramework_Shortcode_Heading{
        function __construct(){
            add_shortcode('megatron_heading', array($this, 'heading_shortcode'));
        }
        function heading_shortcode($atts){
	        /**
	         * Shortcode attributes
             *
             * @var $line_style
             * @var $size
             * @var $text_align
	         * @var $color_scheme
	         * @var $title
             * @var $sub_title
             * @var $description
             * @var $style_line
	         * @var $el_class
	         * @var $css_animation
	         * @var $duration
	         * @var $delay
	         */
            $line_style = $style_line = $size = $text_align = $color_scheme = $title = $sub_title=$description= $el_class = $css_animation = $duration = $delay = '';
	        $atts = vc_map_get_attributes( 'megatron_heading', $atts );
	        extract( $atts );
	        $g5plus_animation = esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            $heading_class = array('heading', $color_scheme, $size, $text_align , $g5plus_animation);
            ob_start();?>
            <div class="<?php echo join(' ', $heading_class) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                <?php if($line_style != ''):?>
                <div class="<?php echo esc_attr($line_style) ?>">
                <?php endif;?>
                    <?php if(!empty($title)):?>
                    <h2>
                        <?php echo wp_kses_post($title)?>
                    </h2>
                    <?php endif;
                    if(!empty($sub_title)):?>
                    <span>
                        <?php echo wp_kses_post($sub_title)?>
                    </span>
                    <?php endif;
                if($line_style != ''):?>
                </div>
                <?php endif;
                if(!empty($description)):?>
                <p>
                    <?php echo wp_kses_post($description)?>
                </p>
                <?php endif;?>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_Shortcode_Heading();
}