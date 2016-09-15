<?php

do_action('g5plus_before_page');

$data_section_id = uniqid();
?>
<div class="portfolio-full detail-01" id="content">
    <div class="fullwidth">
        <div class="container">
            <div class="navigator">
                <?php
                do_action('g5plus_after_single_portfolio_content'); ?>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="portfolio-title-wrap">
                        <h2 class="portfolio-title p-font"><?php the_title() ?></h2>
                    </div>
                    <div class="post-slideshow" id="post_slideshow_<?php echo esc_attr($data_section_id) ?>">
                        <?php if(count($meta_values) > 0){
                            $index = 0;
                            foreach($meta_values as $image){
                                $urls = wp_get_attachment_image_src($image,'full');
                                $img = '';
                                if(count($urls)>0){
                                    $resize = matthewruddy_image_resize($urls[0],970,747);
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
            </div>
        </div>
        <div class="paging-wrap">
            <div class="container">
                <div class="row">
                    <div class="slideshow-paging" data-current-index="0" data-total-items="<?php echo esc_attr(count($meta_values)) ?>" id="slideshow_paging_<?php echo esc_attr($data_section_id) ?>">
                        <?php if(count($meta_values) > 0){
                            $index = 0;
                            foreach($meta_values as $image){
                                $urls = wp_get_attachment_image_src($image,'full');
                                $img = '';
                                if(count($urls)>0){
                                    $resize = matthewruddy_image_resize($urls[0],170,129);
                                    if($resize!=null && is_array($resize) )
                                        $img = $resize['url'];
                                }
                                ?>
                                <div class="item">
                                    <a href="javascript:;" class="nav-slideshow" data-section-id="<?php echo esc_attr($data_section_id) ?>" data-index="<?php echo esc_attr($index++) ?>" >
                                        <img alt="portfolio" src="<?php echo esc_url($img) ?>" />
                                    </a>
                                </div>
                            <?php }
                        }else { if(count($imgThumbs)>0) {?>
                            <div class="item">
                                <img alt="portfolio" src="<?php echo esc_url($imgThumbs[0])?>" />
                            </div>
                        <?php }
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="container">
            <div class="row portfolio-content-wrap">
                <div class="col-md-12">
                    <div class="portfolio-info">
                        <h5 class="clear-top title p-font line-height-1"><?php echo esc_html__('About Project','g5plus-megatron') ?></h5>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="portfolio-info">
                        <?php the_content() ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="portfolio-info spec">
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
                                <div class="portfolio-term line-height-1"><a class="s-color " href="<?php echo esc_url($client_site) ?>"><?php echo esc_html($client_site) ?></a></div>
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
                                            <span class="tag">
                                                <?php echo wp_kses_post($tag->name) ?>
                                            </span>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="navigator bottom">
                <?php
                do_action('g5plus_after_single_portfolio_content'); ?>
            </div>
        </div>

    </div>

</div>

<script type="text/javascript">
    (function($) {
        "use strict";
        $(window).load(function(){
            var $portfolio_owl = $(".post-slideshow",'#content');
            $portfolio_owl.on('initialized.owl.carousel', function(event) {
                $portfolio_owl.css('opacity','1');
            });
            $portfolio_owl.owlCarousel({
                items: 1,
                nav : true,
                slideSpeed: 600,
                navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                pagination: false
            });
            $portfolio_owl.on('translated.owl.carousel', function(event) {
                var index = event.item.index;
                moveNavSlide(index);
            });


            var $slide_owl = $(".slideshow-paging",'#content');
            $slide_owl.on('initialized.owl.carousel', function(event) {
                $(".slideshow-paging",'#content').css('opacity','1');

                $('a.nav-slideshow', '#content .slideshow-paging').click(function(){
                    var index = $(this).attr('data-index');
                    var currentIndex = $(".slideshow-paging",'#content').attr('data-current-index');
                    var totalItems = $(".slideshow-paging",'#content').attr('data-total-items');
                    index = parseInt(index);
                    movePostSlide(index);
                    if(index <= currentIndex){
                        $slide_owl.trigger('prev.owl.carousel');
                    }
                })
            });
            $slide_owl.owlCarousel({
                items: 6,
                margin: 30,
                responsive:{
                    0:{
                        items:2,
                        margin: 15

                    },
                    600:{
                        items:3,
                        margin: 15
                    },
                    768:{
                        items:4,
                        margin: 15
                    },
                    1000:{
                        items:6,
                        margin: 15
                    }
                },
                nav : false,
                dots: false
            });

            $portfolio_owl.on('resized.owl.carousel',function(event){

            })

            function moveNavSlide(index){
                $slide_owl.trigger('to.owl.carousel',[index]);
                $slide_owl.attr('data-current-index', index);

            }
            function movePostSlide(index){
                if(index!='undefined'){
                    $portfolio_owl.trigger('to.owl.carousel',[index]);
                    $slide_owl.attr('data-current-index', index);
                }
            }
        })
    })(jQuery);
</script>

