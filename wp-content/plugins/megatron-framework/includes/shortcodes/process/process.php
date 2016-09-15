<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_ShortCode_Process')) {
    class g5plusFramework_ShortCode_Process
    {
        function __construct()
        {
            add_shortcode('megatron_process', array($this, 'process_shortcode'));
        }

        function process_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $layout_style
             * @var $values
             * @var $height
             * @var $bg_scheme
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $iconClass=$layout_style=$values=$height=$bg_scheme=$el_class=$css_animation=$duration=$delay='';
            $atts = vc_map_get_attributes( 'megatron_process', $atts );
            extract( $atts );
	        $g5plus_options = &megatron_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('megatron_process_css', plugins_url('megatron-framework/includes/shortcodes/process/assets/css/process' . $min_suffix_css . '.css'), array(), false);
            $class[] = 'process row '.$layout_style;
            $style='';
            if($layout_style=='style3')
            {
                $style=' style="height:'.$height.'px; line-height: '.$height.'px;"';
                $class[] =$bg_scheme;
            }
            $class[] = esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            ob_start();?>
            <div class="<?php echo esc_attr(join(' ',$class)) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
                <?php
                $values = (array) vc_param_group_parse_atts( $values );
                $column=count($values);
                if($column>0)
                {
                    if($column>4)
                    {
                        $class_col='col-md-3 col-sm-12';
                    }
                    else
                    {
                        $class_col='col-md-'.(12/esc_attr($column)).' col-sm-12';
                    }
                    if($layout_style=='style1' || $layout_style=='style2')
                    {
                        $class_col.=' sm-padding-bottom-30';
                    }
                }
                else
                {
                    $class_col='col-md-12';
                }
                $i=0;
                foreach ( $values as $data ) {
                    $i++;
                    $icon_type = isset( $data['icon_type'] ) ? $data['icon_type'] : '';
                    $icon_image = isset( $data['icon_image'] ) ? $data['icon_image'] : '';
                    $link = isset( $data['link'] ) ? $data['link'] : '';
                    $title = isset( $data['title'] ) ? $data['title'] : '';
                    $description = isset( $data['description'] ) ? $data['description'] : '';
                    $iconClass='';
                    if($icon_type!='' && $icon_type!='image')
                    {
                        vc_icon_element_fonts_enqueue( $icon_type );
                        $iconClass = isset( $data['icon_' . $icon_type]) ? esc_attr( $data['icon_' . $icon_type]) : '';
                    }
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
                    ?>
                    <div<?php echo wp_kses_post($style) ?> class="<?php echo esc_attr($class_col) ?> process-step">
                        <a title="<?php echo esc_attr($a_title ); ?>" target="<?php echo esc_attr( $a_target ); ?>" href="<?php echo  esc_url($a_href) ?>">
                        <?php if($title!=''):?>
                        <h6><?php echo esc_html($title) ?></h6>
                        <?php endif;
                        if ( $icon_type == 'image' ) :
                            $img = wp_get_attachment_image_src( $icon_image, 'full' );?>
                            <div class="process-icon"><img alt="<?php echo esc_attr($title)?>" src="<?php echo esc_url($img[0])?>"/></div>
                        <?php elseif($iconClass!=''):?>
                            <div class="process-icon"><i class="<?php echo esc_attr($iconClass) ?>"></i></div>
                        <?php endif;
                        if($description!=''):?>
                            <p><?php echo esc_html($description) ?></p>
                        <?php endif;?>
                        </a>
                        <?php if($layout_style=='style3'):?>
                            <span class="p-font"><?php echo esc_html($i)?></span>
                        <?php endif;?>
                    </div>
                <?php
                }
                ?>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_ShortCode_Process();
}