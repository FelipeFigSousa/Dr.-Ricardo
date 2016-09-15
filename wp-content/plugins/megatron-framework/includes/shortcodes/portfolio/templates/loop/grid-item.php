<div class="<?php echo implode(' ', $class_item) ?> <?php echo esc_attr($cat_filter) ?>">

    <?php
    $post_thumbnail_id = get_post_thumbnail_id(  get_the_ID() );
    $arrImages = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
    $width = 585;
    $height = 585;
    if(isset($image_size) && $image_size=='590x393')
    {
        $width = 590;
        $height = 393;
    }
    if(isset($image_size) &&  $image_size=='570x438')
    {
        $width = 570;
        $height = 438;
    }
    if(isset($image_size) &&  $image_size=='370x620')
    {
        $width = 370;
        $height = 620;
    }
    if(isset($image_size) &&  $image_size=='370x284')
    {
        $width = 370;
        $height = 284;
    }
    $thumbnail_url = '';
    if(count($arrImages)>0){
        $resize = matthewruddy_image_resize($arrImages[0],$width,$height);
        if($resize!=null && is_array($resize) )
            $thumbnail_url = $resize['url'];
    }

    $url_origin = $arrImages[0];
    if($overlay_style=='left-title-excerpt-link')
        $overlay_style = 'title-excerpt-link';

    $overlay_template = plugin_dir_path( __FILE__ ).'/overlay/'.$overlay_style.'.php';
    if(file_exists($overlay_template)){
        include($overlay_template);
    }
    ?>

    <?php
        $gallery_template = plugin_dir_path(__FILE__) . '/gallery.php';
        if(file_exists($gallery_template)){
            include($gallery_template);
        }
    ?>

</div>
