<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 3/20/15
 * Time: 11:01 AM
 */
?>
<div class="thumb-wrap">
    <img width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" src="<?php echo esc_url($thumbnail_url) ?>" alt="<?php echo get_the_title() ?>"/>
    <div class="p-bg-rgba-color thumb <?php echo esc_attr($overlay_bg) ?>">
        <div class="hover-outer">
            <div class="hover-inner">
                <a href="<?php echo esc_url($url_origin) ?>" data-rel="prettyPhoto[pp_gal_<?php echo get_the_ID() ?>]"  title="<?php echo get_the_title() ?>">
                    <i class="fa fa-expand  fc-white"></i>
                </a>
            </div>
        </div>
    </div>
</div>
