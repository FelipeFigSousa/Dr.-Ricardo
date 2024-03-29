<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Image_Box')) {
    class g5plusFramework_Shortcode_Image_Box
    {
        function __construct()
        {
            add_shortcode('megatron_image_box', array($this, 'image_box_shortcode'));
        }
        function image_box_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $image
             * @var $link
             * @var $title
             * @var $description
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $atts = vc_map_get_attributes( 'megatron_image_box', $atts );
            extract( $atts );
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
	        $g5plus_options = &megatron_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('megatron_image_box_css', plugins_url('megatron-framework/includes/shortcodes/image-box/assets/css/image-box' . $min_suffix_css . '.css'), array(), false);
            //parse link
            $link = ( $link == '||' ) ? '' : $link;
            $link = vc_build_link( $link );

            $a_href='#';
            $a_target = '_self';
            $a_title = $title;

            if ( strlen( $link['url'] ) > 0 ) {
                $a_href = $link['url'];
                $a_title = $link['title'];
                $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
            }
            $img_id = preg_replace( '/[^\d]/', '', $image );
            $img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => '192x157'  ) );
            ob_start();?>
            <div class="image-box <?php echo esc_attr($g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
                <?php if($img['thumbnail']):?>
                <div class="ibox-image">
                    <?php echo wp_kses_post($img['thumbnail']); ?>
                </div>
                <?php endif;?>
                <div class="ibox-content">
                <?php if($title!=''):?>
                    <a class="p-font" title="<?php echo esc_attr($a_title ); ?>" target="<?php echo trim( esc_attr( $a_target ) ); ?>" href="<?php echo  esc_url($a_href) ?>"><?php echo esc_html($title) ?></a>
                <?php endif;
                if($description!=''):?>
                    <p><?php echo wp_kses_post($description) ?></p>
                <?php endif;?>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_Shortcode_Image_Box();
}