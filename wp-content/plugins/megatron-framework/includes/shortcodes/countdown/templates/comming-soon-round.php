<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 6/15/15
 * Time: 2:56 PM
 */

$g5plus_options = &megatron_get_options_config();
$min_suffix = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' : '';
wp_enqueue_style('megatron-portfolio-css', plugins_url() . '/megatron-framework/includes/shortcodes/countdown/assets/css/countdown'.$min_suffix.'.css', array(),false);
wp_enqueue_script('megatron-jquery-countdown',plugins_url() . '/megatron-framework/includes/shortcodes/countdown/assets/jquery.countdown/jquery.countdown.min.js', false, true);
wp_enqueue_script('megatron-jquery-knob',plugins_url() . '/megatron-framework/includes/shortcodes/countdown/assets/jquery.countdown/jquery.knob.min.js', false, true);
$args = array(
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'post_type'        => 'countdown',
    'post_status'      => 'publish');
$posts_array  = new WP_Query( $args );
$opening_hours = $countdown_type= '';
$urlRedirect = '';
while ( $posts_array->have_posts() ) : $posts_array->the_post();
    $type= rwmb_meta('countdown-type');
    if($type=='comming-soon'){
        $countdown_type = $type;
        $urlRedirect = rwmb_meta('countdown-url');
        $opening_hours = rwmb_meta('countdown-opening');
        break;
    }
endwhile;
wp_reset_postdata();
$g5plus_options = &megatron_get_options_config();
$color = $g5plus_options['primary_color'];
$font_family = $g5plus_options['count_down_font'];
if(is_array($font_family))
    $font_family = $font_family["font-family"];
$data_section_id = 'opening-hours-'.uniqid();
?>
<div class="countdown <?php echo esc_attr($el_class) ?>">
    <div class="container">
        <div id="<?php echo esc_attr($data_section_id)?>" class="opening-hours">
            <div class="circle">
                <div class="canvas">
                    <input type="text" data-min="0" data-max="31" data-width="130" data-height="130" data-readOnly="true"
                           data-thickness=".1" value="0" class="months" id="months"
                           data-fgColor="<?php echo esc_attr($color)?>"  data-inputColor="#fff" data-bgColor="rgba(255, 255, 255, 0.4)"
                           data-font="<?php echo esc_attr($font_family) ?>"
                        >
                    <span class="title"><?php esc_html_e('Months','g5plus-megatron') ?></span>
                </div>
                <div class="canvas">
                    <input type="text" data-min="0" data-max="31" data-width="130" data-height="130" data-readOnly="true"
                           data-thickness=".1" value="0" class="days" id="days"
                           data-fgColor="<?php echo esc_attr($color)?>" data-inputColor="#fff" data-bgColor="rgba(255, 255, 255, 0.4)"
                           data-font="<?php echo esc_attr($font_family) ?>"
                        >
                    <span class="title"><?php esc_html_e('Days','g5plus-megatron') ?></span>
                </div>
                <div class="canvas">
                    <input type="text" data-min="0" data-max="23" data-width="130" data-height="130" data-readOnly="true"
                           data-thickness=".1" value="0" class="hours" id="hours"
                           data-fgColor="<?php echo esc_attr($color)?>"  data-inputColor="#fff" data-bgColor="rgba(255, 255, 255, 0.4)"
                           data-font="<?php echo esc_attr($font_family) ?>"
                        >
                    <span class="title"><?php esc_html_e('Hours','g5plus-megatron') ?></span>
                </div>
                <div class="canvas">
                    <input type="text" data-min="0" data-max="59" data-width="130" data-height="130" data-readOnly="true"
                           data-thickness=".1"  value="0" class="minutes" id="minutes"
                           data-fgColor="<?php echo esc_attr($color)?>" data-inputColor="#fff" data-bgColor="rgba(255, 255, 255, 0.4)"
                           data-font="<?php echo esc_attr($font_family) ?>"
                        >
                    <span class="title"><?php esc_html_e('Minutes','g5plus-megatron') ?></span>
                </div>
                <div class="canvas">
                    <input type="text" data-min="0" data-max="59" data-width="130" data-height="130" data-readOnly="true"
                           data-thickness=".1"  value="0" class="second" id="second"
                           data-fgColor="<?php echo esc_attr($color)?>"  data-inputColor="#fff" data-bgColor="rgba(255, 255, 255, 0.4)"
                           data-font="<?php echo esc_attr($font_family) ?>"
                        >
                    <span class="title"><?php esc_html_e('Seconds','g5plus-megatron') ?></span>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>

</div>
<script type="text/javascript">
    (function($) {
        "use strict";
        var elm = $('#<?php echo esc_attr($data_section_id)?>');
        $(document).ready(function(){
            var isInitCountdown = 0;
            $("#<?php echo esc_attr($data_section_id)?>").countdown('<?php echo esc_html($opening_hours); ?>',function(event){
                var months = parseInt(event.strftime('%m'));
                $('#months').attr('data-max',months);
                if(isInitCountdown==0){
                    $('input','#<?php echo esc_attr($data_section_id)?>').knob();
                    isInitCountdown=1;
                }
                setTimeout(function(){
                    $(elm).css('opacity','1');
                },500);

            });

            $("#<?php echo esc_attr($data_section_id)?>").countdown('<?php echo esc_html($opening_hours); ?>').on('update.countdown', function(event) {
                var second = parseInt(event.strftime('%S'));
                var minutes = parseInt(event.strftime('%M'));
                var hours = parseInt(event.strftime('%H'));
                var days = parseInt(event.strftime('%d'));
                var months = parseInt(event.strftime('%m'));
                var weeks = parseInt(event.strftime('%w'));
                if(months>0){
                    var bufferDay = weeks%4 * 7;
                    if(bufferDay>0){
                        days = bufferDay;
                    }
                }
                else{
                    days =  weeks*7 + days;
                }
                if(second<10)
                    second = '0' + second;
                if(minutes<10)
                    minutes = '0' + minutes;
                if(hours<10)
                    hours = '0' + hours;
                if(days<10)
                    days = '0' + days;
                if(months<10)
                    months = '0' + months;

                var elm = $('#<?php echo esc_attr($data_section_id)?>');
                $('#second',elm).val(second).trigger('change');
                $('#minutes',elm).val(minutes).trigger('change');
                $('#hours',elm).val(hours).trigger('change');
                $('#days',elm).val(days).trigger('change');
                $('#months',elm).val(months).trigger('change');

            }).on('finish.countdown', function(event){
                var elm = $('#<?php echo esc_attr($data_section_id)?>');
                $('#seconds',elm).val(0);
                <?php if( $urlRedirect!=''){ ?>
                window.location.href= '<?php echo esc_url($urlRedirect); ?>';
                <?php } ?>
            });


            $('input',elm).css('font-size','54px');
            $('input',elm).css('font-weight','400');
            if(navigator.userAgent.indexOf("Chrome") != -1 ){
                var height, width;
                var height, width;
                var marginTop = '30px';
                height = '60px';
                width = '70px';
                $('input',elm).css('height',height);
                $('input',elm).css('width',width);
                $('input',elm).css('margin-top',marginTop);
            }

            function fullScreen(){
                var $window_height = $(window).height();
                var $window_width = $(window).width();
                var $logoHeight = $('.logo').outerHeight();
                var $countdown = 160;
                var $separator = 0;
                var $wpadminbar = 0;
                var $messageWrap = 0;
                if($('.separator').length>0){
                    $separator = $('.separator').outerHeight();
                }
                if($('#wpadminbar').length>0){
                    $wpadminbar = $('#wpadminbar').outerHeight();
                }
                if($('.message-wrap').length>0){
                    $messageWrap = $('.message-wrap').outerHeight();
                }
                var $padding =  150;
                if($window_width > 992){
                    $padding =  ($window_height - $separator - $wpadminbar - $logoHeight - $countdown - $messageWrap)/2;
                    var $fullScreenHeight = $('.full-screen').outerHeight();
                    if($fullScreenHeight< $window_height){
                        $('.full-screen').css('height',$window_height);
                    }
                }else{
                    $('.full-screen').css('height','auto');
                }
                if($padding>0){
                    $('.count-down').css('padding-top',$padding);
                    $('.count-down').css('padding-bottom',$padding);
                }

            }
            fullScreen();
            $(window).resize(function(){
                fullScreen();
            });

        });
    })(jQuery);
</script>
