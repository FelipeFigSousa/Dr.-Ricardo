<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 11/7/15
 * Time: 5:25 PM
 */

$class_item = array();
$class_item[] ='portfolio-item';
$class_item[] = $cat_filter;
$class_item[] = $overlay_align;
$class_item[] = $overlay_style;

$post_id = get_the_ID();
$categories = get_the_terms($post_id, G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY);
$client = get_post_meta($post_id, 'portfolio-client', true );
$client_site = get_post_meta($post_id, 'portfolio-client-site', true );
$location = get_post_meta($post_id, 'portfolio-location', true );
$tags = get_the_terms( $post_id, 'post_tag');

$class_item[] = $overlay_effect;

$g5plus_options = &megatron_get_options_config();
$disable_link = false;
if(isset($g5plus_options['portfolio_disable_link_detail']) && $g5plus_options['portfolio_disable_link_detail']=='1' )
{
    $disable_link = true;
}

?>

<div class="<?php echo implode(' ', $class_item) ?>">
        <?php
        $post_thumbnail_id = get_post_thumbnail_id(  get_the_ID() );
        $arrImages = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );

        $thumbnail_url = $url_origin = '';
        $width = 1170;
        $height = 780;
        if(count($arrImages)>0){
            $resize = matthewruddy_image_resize($arrImages[0],1170,780);
            if($resize!=null && is_array($resize) )
                $thumbnail_url = $resize['url'];
            $url_origin = $arrImages[0];
        }
        ?>

    <?php

    $overlay_template = plugin_dir_path( __FILE__ ).'/overlay/'.$overlay_style.'.php';
    if(file_exists($overlay_template)){
        include($overlay_template);
    }
    ?>

    <div class="container" >
        <div class="content">
            <div class="row portfolio-content-wrap">
                <div class="col-md-9">
                    <div class="portfolio-info">
                        <?php if (!$disable_link){?>
                            <a class="link p-color-hover" href="<?php echo get_permalink(get_the_ID()) ?>" title="<?php echo get_the_title() ?>">
                                <h2 class="portfolio-title bold-color line-height-1 p-font"><?php the_title() ?></h2>
                            </a>
                        <?php } else {?>
                            <h2 class="portfolio-title bold-color line-height-1 p-font"><?php the_title() ?></h2>
                        <?php } ?>
                        <?php echo get_the_excerpt() ?>
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
                                    <h6 class="p-font line-height-1"><?php echo wp_kses_post($meta['portfolio_custom_fields'][$i]['custom-field-title']) ?> </h6>
                                    <div class="portfolio-term line-height-1"><?php echo wp_kses_post($meta['portfolio_custom_fields'][$i]['custom-field-description']) ?></div>
                                </div>
                            <?php }
                        }
                        ?>
                        <?php if(isset($client_site) && $client_site!=''){ ?>
                            <div class="portfolio-info-box client-site">
                                <h6 class="p-font line-height-1"><?php echo esc_html__('Client Site','g5plus-megatron') ?> </h6>
                                <div class="portfolio-term line-height-1"><a href="<?php echo esc_url($client_site) ?>"><?php echo esc_html($client_site) ?></a></div>
                            </div>
                        <?php } ?>
                        <?php if(isset($client) && $client!=''){ ?>
                            <div class="portfolio-info-box">
                                <h6 class="p-font line-height-1"><?php echo esc_html__('Client','g5plus-megatron') ?> </h6>
                                <div class="portfolio-term line-height-1"><?php echo esc_html($client) ?></div>
                            </div>
                        <?php } ?>
                        <?php if(isset($cat) && $cat!=''){ ?>
                            <div class="portfolio-info-box">
                                <h6 class="p-font line-height-1"><?php echo esc_html__('Categories','g5plus-megatron') ?> </h6>
                                <div class="portfolio-term line-height-1 category"><?php echo wp_kses_post($cat) ?></div>
                            </div>
                        <?php } ?>
                        <?php if(isset($tags) && is_array($tags)){ ?>
                            <div class="portfolio-info-box">
                                <h6 class="p-font line-height-1"><?php echo esc_html__('Tag','g5plus-megatron') ?> </h6>
                                <div class="portfolio-term line-height-1">
                                    <?php foreach($tags as $tag){ ?>
                                        <span class="tag"><?php echo wp_kses_post($tag->name) ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php

    $gallery_template = plugin_dir_path(__FILE__) . '/gallery.php';
    if(file_exists($gallery_template)){
        include($gallery_template);
    }
    ?>
</div>
