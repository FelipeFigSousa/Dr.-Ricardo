<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_ShortCode_Testimonial')) {
    class g5plusFramework_ShortCode_Testimonial
    {
        function __construct()
        {
            add_shortcode('megatron_testimonial', array($this, 'testimonial_shortcode'));
        }

        function testimonial_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $layout_style
             * @var $color_scheme
             * @var $nav
             * @var $dots
             * @var $autoplayhoverpause
             * @var $autoplaytimeout
             * @var $values
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $layout_style=$color_scheme=$nav=$dots=$autoplayhoverpause=$autoplaytimeout=$values=$el_class=$css_animation=$duration=$delay='';
            $atts = vc_map_get_attributes( 'megatron_testimonial', $atts );
            extract( $atts );
            $dots = ($dots == 'yes') ? 'true' : 'false';
            $nav = ($nav == 'yes') ? 'true' : 'false';
            $autoplayhoverpause = ($autoplayhoverpause == 'yes') ? 'true' : 'false';
            $data_carousel = '"autoplay": true,"loop":true,"center":false,"animateOut":"fadeOut","autoplayHoverPause":'.$autoplayhoverpause.',"autoplayTimeout":'.$autoplaytimeout.', "items":1,"responsive":{},"dots":' . $dots . ', "nav":' . $nav;
	        $g5plus_options = &megatron_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('megatron_testimonial_css', plugins_url('megatron-framework/includes/shortcodes/testimonial/assets/css/testimonial' . $min_suffix_css . '.css'), array(), false);
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            ob_start();?>
            <div class="testimonial <?php echo esc_attr($layout_style.' '.$color_scheme.$g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
                <div data-plugin-options='{<?php echo esc_attr($data_carousel) ?>}' class="owl-g5plus-shortcode owl-carousel">
                <?php
                $values = (array) vc_param_group_parse_atts( $values );
                foreach ( $values as $data ) {
                    $avatar = isset( $data['avatar'] ) ? $data['avatar'] : '';
                    $quote = isset( $data['quote'] ) ? $data['quote'] : '';
                    $author = isset( $data['author'] ) ? $data['author'] : '';
                    $rate = isset( $data['rate'] ) ? $data['rate'] : 0;
                    $r=intval($rate)/2;
                    ?>
                    <div class="testimonial-item">
                        <?php if($avatar!='' && $layout_style!='style3'):
                            $img = wp_get_attachment_image_src( $avatar, 'full' ); ?>
                            <img alt="<?php echo esc_attr($author)?>" src="<?php echo esc_url($img[0])?>"/>
                        <?php endif;?>
                        <?php if($rate!=0 && $layout_style=='style5'):?>
                            <div class="testimonial-ratings">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if($i<=$r):?>
                                        <i class="fa fa-star"></i>
                                    <?php elseif($i==$r+0.5):?>
                                        <i class="fa fa-star-half-o"></i>
                                    <?php else:?>
                                        <i class="fa fa-star-o"></i>
                                    <?php endif;
                                }
                                ?>
                            </div>
                        <?php endif;?>
                        <p><?php echo esc_html($quote)?></p>
                        <?php if($avatar!='' && $layout_style=='style3'):
                            $img = wp_get_attachment_image_src( $avatar, 'full' ); ?>
                            <img alt="<?php echo esc_attr($author)?>" src="<?php echo esc_url($img[0])?>"/>
                        <?php endif;?>
                        <h6><?php echo esc_html($author)?></h6>
                        <?php if($rate!=0 && $layout_style!='style5'):?>
                        <div class="testimonial-ratings">
                            <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if($i<=$r):?>
                                        <i class="fa fa-star"></i>
                                    <?php elseif($i==$r+0.5):?>
                                        <i class="fa fa-star-half-o"></i>
                                    <?php else:?>
                                        <i class="fa fa-star-o"></i>
                                    <?php endif;
                                }
                            ?>
                        </div>
                        <?php endif;?>
                    </div>
                    <?php
                }
                ?>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_ShortCode_Testimonial();
}