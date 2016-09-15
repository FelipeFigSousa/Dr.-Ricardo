<?php
$post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
$arrImages = wp_get_attachment_image_src($post_thumbnail_id, 'full');
$width = 395;
$height = 395;

$matrix = array(
    array(1,1,2,1),
    array(1,1,1),

);

$index_row = floor(($index-1) / $column)%2;
$index_col = ($index-1) % $column;
if($matrix[$index_row][$index_col]==2){
    $width = 395;
    $height = 790;
}

?>

<div class="<?php echo implode(' ', $class_item) ?> <?php echo esc_attr($cat_filter) ?>">
    <?php
    $thumbnail_url = '';
    if (count($arrImages) > 0) {
        $resize = matthewruddy_image_resize($arrImages[0], $width, $height);
        if ($resize != null && is_array($resize))
            $thumbnail_url = $resize['url'];
    }

    $url_origin = $arrImages[0];
    if ($overlay_style == 'left-title-excerpt-link')
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
