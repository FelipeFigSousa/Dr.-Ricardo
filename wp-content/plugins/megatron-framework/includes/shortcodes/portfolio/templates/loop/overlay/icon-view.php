<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 3/20/15
 * Time: 11:01 AM
 */

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