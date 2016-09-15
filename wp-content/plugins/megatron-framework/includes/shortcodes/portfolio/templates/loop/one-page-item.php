<?php
$col_class = 'col-md-3 col-sm-6 col-xs-12';
$width = 585;
$height = 585;
$hover_align_bottom = '';
$total_item_clone = 1;
if($index==1 || ($index-1)%8==0){
    $col_class = 'col-md-6 col-sm-6 col-xs-12';
    $hover_align_bottom = 'hover-align-bottom';
}
if($index%8==0 && $index > 1){
    $width = 570;
    $height = 270;
    $col_class = 'col-md-6 col-sm-6 col-xs-12 hidden-sm hidden-xs';
    $total_item_clone = 2;
}


$class_item = array();
$class_item[] ='portfolio-item';
$class_item[] = $cat_filter;
$class_item[] = $overlay_align;
$class_item[] = $overlay_style;
$class_item[] = $hover_align_bottom;
$class_item[] = $overlay_effect;
?>
<?php for($i=1;$i<=$total_item_clone;$i++){
        if($i==2){
            $width = 585;
            $height = 585;
            $col_class = 'col-md-3 col-sm-6 col-xs-12 hidden-lg hidden-md';
        }
    $class_item[] = $col_class;
    ?>
    <div class="<?php echo implode(' ', $class_item) ?>">
        <?php
        $post_thumbnail_id = get_post_thumbnail_id(  get_the_ID() );
        $arrImages = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );

        $thumbnail_url = '';
        if(count($arrImages)>0){
            $resize = matthewruddy_image_resize($arrImages[0],$width,$height);
            if($resize!=null && is_array($resize) )
                $thumbnail_url = $resize['url'];
        }

        $url_origin = $arrImages[0];
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
<?php } ?>

