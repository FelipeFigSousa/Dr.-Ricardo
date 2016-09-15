<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Banner')) {
    class g5plusFramework_Shortcode_Banner
    {
        function __construct()
        {
            add_shortcode('megatron_banner', array($this, 'banner_shortcode'));
        }
        function banner_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $layout_style
             * @var $icon_type
             * @var $icon_image
             * @var $add_icon
             * @var $add_button
             * @var $image
             * @var $bg_color
             * @var $icon_color
             * @var $link
             * @var $title
             * @var $sale_off
             * @var $sub_title
             * @var $description
             * @var $height
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $icon_type=$icon_image=$el_class=$css_animation=$duration=$delay=$layout_style=$a_title=$sale_off=$sub_title=$description=$height=$add_icon=$add_button=$icon_color=$bg_color=$image=$link=$style=$iconClass='';
            $atts = vc_map_get_attributes( 'megatron_banner', $atts );
            extract( $atts );
            if($icon_type!='' && $icon_type!='image')
            {
                vc_icon_element_fonts_enqueue( $icon_type );
                $iconClass = isset( ${"icon_" . $icon_type} ) ? esc_attr( ${"icon_" . $icon_type} ) : '';
            }
	        $g5plus_options = &megatron_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('megatron_banner_css', plugins_url('megatron-framework/includes/shortcodes/banner/assets/css/banner' . $min_suffix_css . '.css'), array(), false);
            $g5plus_animation = esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            //parse link
            $link = ( $link == '||' ) ? '' : $link;
            $link = vc_build_link( $link );

            $a_href='#';
            $a_title = $title;
            $a_target = '_self';

            if ( strlen( $link['url'] ) > 0 ) {
                $a_href = $link['url'];
                $a_title = $link['title'];
                $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
            }

            if (!empty($image)) {
                $bg_images_attr = wp_get_attachment_image_src($image, "full");
                if (isset($bg_images_attr)) {
                    if (!empty($height)) {
                        $style = ' style="height:' . $height . 'px; background-image: url(' . $bg_images_attr[0] . ');"';

                    }else {
                        $style = ' style="background-image: url(' . $bg_images_attr[0] . ');"';
                    }
                }
            }
            else{
                if($layout_style == 'style3'){
                    $style = 'style="height:'.$height.'px;"';
                }
            }

            $banner_button_class = array('m-button', 'm-button-bg', 'm-button-xs');
            if($layout_style == 'style3' && $bg_color == 'banner-bg-primary'){
                $banner_button_class[]='m-button-secondary';
            }
            else{
                $banner_button_class[]='m-button-primary';
            }

	        $banner_class = array('banner', $layout_style, $g5plus_animation);

            ob_start();?>
            <div class="<?php echo join(' ', $banner_class) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                <div class="overflow-hidden">
                    <div class="banner-bg-img <?php if(!empty($icon_color)) echo esc_attr($icon_color)?> <?php if(!empty($bg_color) && $layout_style=='style3') echo esc_attr($bg_color)?>" <?php echo wp_kses_post($style)?>>
                        <?php if ($layout_style == 'style3'):?>
                            <?php if ( $icon_type != '' ) :
                                if ( $icon_type == 'image' ) :
                                    $img = wp_get_attachment_image_src( $icon_image, 'full' );?>
                                    <img src="<?php echo esc_url($img[0])?>"/>
                                <?php else :?>
                                    <i class="<?php echo esc_attr($iconClass) ?>"></i>
                                <?php endif;
                            endif;
                        endif;?>
                    </div>
                </div>
                <div class="overlay-banner <?php if(!empty($bg_color) && $layout_style=='style3') echo esc_attr($bg_color)?>">
                    <a class= "link-banner" title="<?php echo esc_attr($a_title ); ?>" target="<?php echo esc_attr($a_target); ?>" href="<?php echo  esc_url($a_href) ?>">
                        <div class="content-middle">
                            <div class="content-middle-inner">
                                <div class="content-banner">
                                    <?php if ($layout_style == 'style2'):?>
                                        <?php if ( $icon_type != '' ) :
                                            if ( $icon_type == 'image' ) :
                                                $img = wp_get_attachment_image_src( $icon_image, 'full' );?>
                                                <img src="<?php echo esc_url($img[0])?>"/>
                                            <?php else :?>
                                                <i class="<?php echo esc_attr($iconClass) ?>"></i>
                                            <?php endif;
                                        endif;?>
                                    <?php endif;
                                    if(($layout_style == 'style1' || $layout_style == 'style3' ) && !empty($sub_title)):?>
                                        <span class="sub-title"><?php echo esc_html($sub_title)?></span>
                                    <?php endif;
                                    if(!empty ($title)):?>
                                        <h4><?php echo esc_html($title)?></h4>
                                    <?php endif;
                                    if($layout_style == 'style4' && !empty($sale_off)):?>
                                        <h2><?php echo esc_html($sale_off)?></h2>
                                    <?php endif;
                                    if(($layout_style != 'style1' && $layout_style != 'style3') && !empty($sub_title)):?>
                                        <span class="sub-title"><?php echo esc_html($sub_title)?></span>
                                    <?php endif;
                                    if(!empty($description)):?>
                                        <p><?php echo wp_kses_post($description)?></p>
                                    <?php endif;
                                    if($add_button == 'add-button'):?>
                                        <span class="<?php echo join(' ', $banner_button_class) ?>">
                                    <?php if(!empty($a_title)):?><?php echo esc_html($a_title)?><?php endif;?>
                                        </span>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_Shortcode_Banner();
}