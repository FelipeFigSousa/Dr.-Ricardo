<div class="<?php echo implode(' ', $class_item) ?> <?php echo esc_attr($cat_filter) ?>">

    <?php
    $g5plus_options = &megatron_get_options_config();
    $disable_link = false;
    $detail_link = '';
    if(isset($g5plus_options['portfolio_disable_link_detail']) && $g5plus_options['portfolio_disable_link_detail']=='1' )
    {
        $disable_link = true;
    }else{
        $detail_link = get_post_meta(get_the_ID(), 'portfolio-link', true );
        if(!isset($detail_link) || $detail_link=='')
            $detail_link = get_permalink(get_the_ID());
    }

    $post_thumbnail_id = get_post_thumbnail_id(  get_the_ID() );
    $arrImages = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
    $width = 585;
    $height = 585;
    if($image_size=='590x393')
    {
        $width = 590;
        $height = 393;
    }
    if($image_size=='570x438')
    {
        $width = 570;
        $height = 438;
    }
    $thumbnail_url = '';
    if(count($arrImages)>0){
        if($arrImages[1]==$width && $arrImages[2]==$height){
            $thumbnail_url = $arrImages[0];
        }else{
            $resize = matthewruddy_image_resize($arrImages[0],$width,$height);
            if($resize!=null && is_array($resize) )
                $thumbnail_url = $resize['url'];
        }
    }

    $url_origin = $arrImages[0];
    $cat = '';
    foreach ( $terms as $term ){
        $cat .= $term->name.', ';
    }
    $cat = rtrim($cat,', ');


    ?>

    <div class="thumb-wrap">
        <img width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" src="<?php echo esc_url($thumbnail_url) ?>" alt="<?php echo get_the_title() ?>"/>
        <div class="thumb <?php echo esc_attr($overlay_bg) ?>">
            <div class="hover-outer">
                <div class="hover-inner">
                    <span class="link-button">
                     <a class="view-gallery fc-white p-color-hover prettyPhoto" href="<?php echo esc_url($url_origin) ?>" data-rel="prettyPhoto[pp_gal_<?php echo get_the_ID() ?>]"  title="<?php echo get_the_title() ?>">
                         <i class="fa fa-expand"></i>
                     </a>
                        <?php if (!$disable_link){?>
                            <a class="link fc-white p-color-hover" href="<?php echo esc_url($detail_link) ?>" title="<?php echo get_the_title() ?>">
                                <i class="fa fa-search"></i>
                            </a>
                        <?php }?>
                </span>
                </div>
            </div>
        </div>

    </div>
    <div class="title-inner">
        <?php if ($disable_link){?>
            <div class="title p-font"><?php the_title() ?></div>
        <?php } else{?>
            <a href="<?php echo esc_url($detail_link) ?>" class="line-height-1"><div class="title p-font"><?php the_title() ?></div> </a>
        <?php }?>
        <span class="category s-font"><?php echo wp_kses_post($cat) ?></span>
    </div>

    <?php

    $gallery_template = plugin_dir_path(__FILE__) . '/gallery.php';
    if(file_exists($gallery_template)){
        include($gallery_template);
    }
    ?>
</div>
