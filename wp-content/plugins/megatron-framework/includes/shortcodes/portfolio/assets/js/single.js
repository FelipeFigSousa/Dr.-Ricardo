"use strict";
var PortfolioSingle = {

    init: function(){
        jQuery("a[rel^='prettyPhoto']").prettyPhoto(
            {
                theme: 'light_rounded',
                slideshow: 5000,
                deeplinking: false,
                social_tools: false
            });

        var $gallery = jQuery('.gallery-wrap','.detail-02');
        var $scrollInfo = jQuery('.scroll-info-wrap','.detail-02');
        if(typeof $gallery != 'undefined' && typeof $scrollInfo !='undefined' ){
            var $galleryHeight = jQuery($gallery).outerHeight();
            var $scrollInfoHeight = jQuery($scrollInfo).outerHeight();
            if(typeof  jQuery($scrollInfo).position() !='undefined'){
                var $scrollInfoTop = jQuery($scrollInfo).position().top;
                var $maxScroll = $galleryHeight - $scrollInfoHeight;
                jQuery(window).scroll(function(){
                    PortfolioSingle.scrollInfo($scrollInfo, $maxScroll, $scrollInfoTop);
                });
                jQuery(window).resize(function(){
                    PortfolioSingle.scrollInfo($scrollInfo, $maxScroll, $scrollInfoTop);
                })
            }

        }

        jQuery('.portfolio-item.hover-dir > div.entry-thumbnail, .portfolio-item.hover-dir > div.thumb-wrap').hoverdir();
    },

    transformY: function($elm, $to){
        $elm.css('transform','translateY(' + $to + 'px)');
        $elm.css('-webkit-transform','translateY(' + $to + 'px)');
        $elm.css('transform','translateY(' + $to + 'px)');
    },
    scrollInfo:function($scrollInfo, $maxScroll, $scrollInfoTop){
        var $windowTop = jQuery(window).scrollTop();
        var $windowWidth = jQuery(window).width();
        var $to = $windowTop - $scrollInfoTop;
        if($windowWidth>992 && $maxScroll > 0 && $to > 0){
            if($to <= $maxScroll){
                PortfolioSingle.transformY($scrollInfo, $to);
            }else{
                PortfolioSingle.transformY($scrollInfo, $maxScroll);
            }
        }else{
            PortfolioSingle.transformY($scrollInfo, 0);
        }
    }

}
