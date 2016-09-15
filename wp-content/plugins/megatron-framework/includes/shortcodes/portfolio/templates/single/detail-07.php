<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 7/13/15
 * Time: 11:14 AM
 */
$g5plus_options = &megatron_get_options_config();
do_action('g5plus_before_page');
$data_section_id = uniqid();
$is_only_display_content = false;
if(isset($g5plus_options['portfolio_detail_07_layout']) && $g5plus_options['portfolio_detail_07_layout']=='only_content'){
    $is_only_display_content  =true;
}
?>
<div class="portfolio-full detail-03 full-content" id="content">

        <div class="container">
            <div class="navigator">
                <?php
                do_action('g5plus_after_single_portfolio_content'); ?>
            </div>
        </div>
        <div class="content">
            <?php if(!$is_only_display_content){ ?>
                <div class="container">
                    <div class="row ">
                        <div class="col-md-8">
                            <div class="post-slideshow" id="post_slideshow_<?php echo esc_attr($data_section_id) ?>">
                                <?php if(count($meta_values) > 0){
                                    $index = 0;
                                    foreach($meta_values as $image){
                                        $urls = wp_get_attachment_image_src($image,'full');
                                        $img = '';
                                        if(count($urls)>0){
                                            $resize = matthewruddy_image_resize($urls[0],770,510);
                                            if($resize!=null && is_array($resize) )
                                                $img = $resize['url'];
                                        }

                                        ?>
                                        <div class="item">
                                            <a class="nav-post-slideshow" href="javascript:;" data-section-id="<?php echo esc_attr($data_section_id) ?>" data-index="<?php echo esc_attr($index++) ?>">
                                                <img alt="portfolio" src="<?php echo esc_url($img) ?>" />
                                            </a>
                                        </div>
                                    <?php }
                                }else { if(count($imgThumbs)>0) {?>
                                    <div class="item"><img alt="portfolio" src="<?php echo esc_url($imgThumbs[0])?>" /></div>
                                <?php }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="portfolio-info portfolio-content">
                                <h2 class="portfolio-title p-font"><?php the_title() ?></h2>
                                <?php the_excerpt(); ?>
                            </div>
                            <div class="portfolio-info">
                                <?php
                                $meta = get_post_meta(get_the_ID(), 'portfolio_custom_fields', TRUE);
                                if(isset($meta) && is_array($meta) && count($meta['portfolio_custom_fields'])>0){
                                    for($i=0; $i<count($meta['portfolio_custom_fields']);$i++){
                                        ?>
                                        <div class="portfolio-info-box">
                                            <h6 class="p-font"><?php echo wp_kses_post($meta['portfolio_custom_fields'][$i]['custom-field-title']) ?> </h6>
                                            <div class="portfolio-term line-height-1"><?php echo wp_kses_post($meta['portfolio_custom_fields'][$i]['custom-field-description']) ?></div>
                                        </div>
                                    <?php }
                                }
                                ?>
                                <?php if(isset($client_site) && $client_site!=''){ ?>
                                    <div class="portfolio-info-box client-site">
                                        <h6 class="p-font"><?php echo esc_html__('Client Site','g5plus-megatron') ?> </h6>
                                        <div class="portfolio-term line-height-1"><a class="s-color" href="<?php echo esc_url($client_site) ?>"><?php echo esc_html($client_site) ?></a></div>
                                    </div>
                                <?php } ?>
                                <?php if(isset($client) && $client!=''){ ?>
                                    <div class="portfolio-info-box">
                                        <h6 class="p-font"><?php echo esc_html__('Client','g5plus-megatron') ?> </h6>
                                        <div class="portfolio-term line-height-1"><?php echo esc_html($client) ?></div>
                                    </div>
                                <?php } ?>
                                <?php if(isset($cat) && $cat!=''){ ?>
                                    <div class="portfolio-info-box">
                                        <h6 class="p-font"><?php echo esc_html__('Categories','g5plus-megatron') ?> </h6>
                                        <div class="portfolio-term line-height-1 s-font p-color category"><?php echo wp_kses_post($cat) ?></div>
                                    </div>
                                <?php } ?>
                                <?php if(isset($tags) && is_array($tags)){ ?>
                                    <div class="portfolio-info-box">
                                        <h6 class="p-font"><?php echo esc_html__('Tag','g5plus-megatron') ?> </h6>
                                        <div class="portfolio-term line-height-1">
                                            <?php foreach($tags as $tag){ ?>
                                            <a href="<?php echo esc_url(get_tag_link($tag->term_id )) ?>">
                                                <span class="tag"><?php echo wp_kses_post($tag->name) ?></span>
                                            </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>


                        </div>
                    </div>
                </div>
            <?php } ?>
            <div>
                <?php the_content(); ?>
            </div>
        </div>
        <div class="container">
        <div class="navigator bottom">
            <?php
            do_action('g5plus_after_single_portfolio_content'); ?>
        </div>
            </div>


</div>

<script type="text/javascript">
    (function($) {
        "use strict";
        $(window).load(function(){
            $(".post-slideshow",'#content').owlCarousel({
                items: 1,
                nav : true,
                navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                dots: false
            });
        })
    })(jQuery);
</script>