<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_ShortCode_Image_Slider')) {
    class g5plusFramework_ShortCode_Image_Slider
    {
        function __construct()
        {
            add_shortcode('megatron_imageslider', array($this, 'image_slider_shortcode'));
        }

        function image_slider_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $layout_style
             * @var $source
             * @var $images
             * @var $custom_srcs
             * @var $img_size
             * @var $external_img_size
             * @var $onclick
             * @var $custom_links
             * @var $custom_links_target
             * @var $nav
             * @var $dots
             * @var $autoplay
             * @var $autoplayhoverpause
             * @var $autoplaytimeout
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $layout_style=$source=$images=$custom_srcs=$img_size=$external_img_size=$onclick=$custom_links=$custom_links_target=$nav=$dots=$autoplay=$autoplayhoverpause=$autoplaytimeout=$el_class=$css_animation=$duration=$delay='';
            $atts = vc_map_get_attributes( 'megatron_imageslider', $atts );
            extract( $atts );
            $dots = ($dots == 'yes') ? 'true' : 'false';
            $nav = ($nav == 'yes') ? 'true' : 'false';
            $autoplay = ($autoplay == 'yes') ? 'true' : 'false';
            $autoplayhoverpause = ($autoplayhoverpause == 'yes') ? 'true' : 'false';
            $data_carousel = '"autoplay": '.$autoplay.',"loop":true,"center":false,"autoplayHoverPause":'.$autoplayhoverpause.',"autoplayTimeout":'.$autoplaytimeout.', "items":1,"responsive":{},"dots":' . $dots . ', "nav":' . $nav;
	        $g5plus_options = &megatron_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('megatron_image_slider_css', plugins_url('megatron-framework/includes/shortcodes/image-slider/assets/css/image-slider' . $min_suffix_css . '.css'), array(), false);
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);

            $default_src = vc_asset_url( 'vc/no_image.png' );
            $gal_images = '';
            $large_img_src='';
            $thumbnail='';
            if ( 'link_image' === $onclick ) {
                wp_enqueue_script( 'prettyphoto' );
                wp_enqueue_style( 'prettyphoto' );
            }

            if ( '' === $images ) {
                $images = '-1,-2,-3';
            }

            $pretty_rel_random = ' rel="prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']"';

            if ( 'custom_link' === $onclick ) {
                $custom_links = explode( ',', $custom_links );
            }

            switch ( $source ) {
                case 'media_library':
                    $images = explode( ',', $images );
                    break;

                case 'external_link':
                    $images = explode( ',', $custom_srcs );
                    break;
            }
            foreach ( $images as $i => $image ) {
                switch ( $source ) {
                    case 'media_library':
                        if ( $image > 0 ) {
                            $img = wpb_getImageBySize( array( 'attach_id' => $image, 'thumb_size' => $img_size ) );
                            $thumbnail = $img['thumbnail'];
                            $large_img_src = $img['p_img_large'][0];
                        } else {
                            $large_img_src = $default_src;
                            $thumbnail = '<img src="' . $default_src . '" />';
                        }
                        break;

                    case 'external_link':
                        $image = esc_attr( $image );
                        $dimensions = vcExtractDimensions( $external_img_size );
                        $hwstring = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';
                        $thumbnail = '<img ' . $hwstring . ' src="' . $image . '" />';
                        $large_img_src = $image;
                        break;
                }

                $link_start = $link_end = '';

                switch ( $onclick ) {
                    case 'img_link_large':
                        $link_start = '<a href="' . $large_img_src . '" target="' . $custom_links_target . '">';
                        $link_end = '</a>';
                        break;

                    case 'link_image':
                        $link_start = '<a class="prettyphoto" href="' . $large_img_src . '"' . $pretty_rel_random . '>';
                        $link_end = '</a>';
                        break;

                    case 'custom_link':
                        if ( ! empty( $custom_links[ $i ] ) ) {
                            $link_start = '<a href="' . $custom_links[ $i ] . '"' . ( ! empty( $custom_links_target ) ? ' target="' . $custom_links_target . '"' : '' ) . '>';
                            $link_end = '</a>';
                        }
                        break;
                }

                $gal_images .= $link_start . $thumbnail . $link_end;
            }
            ob_start();?>
            <div data-plugin-options='{<?php echo esc_attr($data_carousel) ?>}' class="image-slider owl-carousel <?php echo esc_attr($layout_style.' '.$g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
                <?php echo wp_kses_post($gal_images); ?>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_ShortCode_Image_Slider();
}