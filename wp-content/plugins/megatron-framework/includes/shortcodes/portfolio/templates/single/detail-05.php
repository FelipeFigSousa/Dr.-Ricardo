<?php

do_action('g5plus_before_page');

$data_section_id = uniqid();

?>
<div class="portfolio-full detail-04" id="content">
    <div class="fullwidth">
        <div class="container">

            <div class="navigator">
                <?php
                do_action('g5plus_after_single_portfolio_content'); ?>
            </div>
            <div class="content">
                <div class="row">
                    <div class="gallery-grid portfolio-wrapper g5-col-md-3 col-padding-15">
                        <?php if(count($meta_values) > 0){
                            $index = 0;
                            foreach($meta_values as $image){
                                $urls = wp_get_attachment_image_src($image,'full');
                                $img = '';
                                $orgin_img = '';
                                if(count($urls)>0){
                                    $orgin_img = $urls[0];
                                    $resize = matthewruddy_image_resize($orgin_img,370,284);
                                    if($resize!=null && is_array($resize) )
                                        $img = $resize['url'];
                                }
                                ?>
                                <div class="portfolio-item hover-dir">
                                    <div class="thumb-wrap">
                                        <img alt="portfolio" src="<?php echo esc_url($img) ?>" />
                                        <div class="p-bg-rgba-color thumb bg-overlay-ps">
                                            <div class="hover-outer">
                                                <div class="hover-inner">
                                                    <a href="<?php echo esc_url($orgin_img) ?>" data-rel="prettyPhoto[pp_gal_<?php echo get_the_ID() ?>]"  title="<?php echo get_the_title() ?>">
                                                        <i class="fa fa-expand  fc-white"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }else { if(count($imgThumbs)>0) {?>
                            <div class="item"><img alt="portfolio" src="<?php echo esc_url($imgThumbs[0])?>" /></div>
                        <?php }
                        }
                        ?>
                    </div>
                </div>

                <div class="row portfolio-content-wrap">
                    <div class="col-md-9">
                        <div class="portfolio-info">
                            <h2 class="portfolio-title bold-color line-height-1 p-font"><?php the_title() ?></h2>
                            <?php the_content() ?>
                        </div>

                        <?php include_once(plugin_dir_path( __FILE__ ).'/social-share.php') ?>
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
            <div class="navigator bottom">
                <?php
                do_action('g5plus_after_single_portfolio_content'); ?>
            </div>

        </div>
    </div>
</div>



