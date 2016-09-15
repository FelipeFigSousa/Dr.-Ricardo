/**
 * Created by phuongth on 3/20/15.
 */
"use strict";
var PortfolioAjaxAction = {
    htmlTag:{
        load_more :'.load-more',
        portfolio_container: '#portfolio-'
    },
    vars:{
        ajax_url: '',
        tab_category_action: 'filter'
    },

    processFilter:function(elm, isLoadmore){
        var $this = jQuery(elm);
        if(jQuery(elm).hasClass('ladda-button')){
            var l = Ladda.create(elm);
            l.start();
        }else{
            PortfolioAjaxAction.startLoading($this);
        }
        var $filterType = $this.attr('data-load-type');
        var $overlay_style = $this.attr('data-overlay-style');
        var $section_id = $this.attr('data-section-id');
        var $data_source = $this.attr('data-source');
        var $data_portfolioIds = $this.attr('data-portfolio-ids');
        var $data_show_paging = $this.attr('data-show-paging');
        var $data_show_paging_masonry = $this.attr('data-show-paging-masonry');
        var $current_page =  $this.attr('data-current-page');
        var $category  = $this.attr('data-category');
        var $offset = 0;
        var $post_per_page = $this.attr('data-post-per-page');
        var $column = $this.attr('data-column');
        var $padding = '';
        var $order =  $this.attr('data-order');
        var $layout_type = $this.attr('data-layout-type');
        var $bg_overlay = $this.attr('data-bg-overlay');
        var $bg_effect_overlay = $this.attr('data-effect-overlay');
        var $data_responsive = $this.attr('data-responsive');
        var $data_table_item = $this.attr('data-table-item');
        var $data_small_table_item = $this.attr('data-small-table-item');
        var $data_isotope_col_width = $this.attr('data-isotope-col-width');
        var $image_size = $this.attr('data-image-size');
        var $data_to_top = $this.attr('data-to-top');

        if($filterType=='ajax'){
            if(jQuery(elm).is('a')){
                jQuery('a.active', jQuery(elm).parent().parent()).removeClass('active');
                jQuery('li.active', jQuery(elm).parent().parent()).removeClass('active');
                jQuery($this).parent().addClass('active');
                jQuery($this).addClass('active');
            }
        }
        /*else{
            if(jQuery(elm).is('option')){
                $category = elm.attr('data-category');
            }else{
                $category = jQuery('a.active', jQuery(elm).parent().parent()).attr('data-category');
            }
        }*/

        jQuery.ajax({
            url: PortfolioAjaxAction.vars.ajax_url,
            data: ({action : 'g5plusframework_portfolio_load_by_category', postsPerPage: $post_per_page, current_page: $current_page,
                layoutType: $layout_type,category : $category,
                columns: $column, colPadding: $padding, offset: 0, order: $order,
                data_source  : $data_source, portfolioIds: $data_portfolioIds, data_show_paging: $data_show_paging,
                overlay_style: $overlay_style, data_section_id: $section_id, bg_overlay: $bg_overlay,
                bg_effect_overlay: $bg_effect_overlay, data_responsive: $data_responsive, data_table_item : $data_table_item,
                data_small_table_item : $data_small_table_item, data_show_paging_masonry : $data_show_paging_masonry,
                imageSize: $image_size
            }),
            success: function(data) {
                if(jQuery(elm).hasClass('ladda-button')){
                    l.stop();
                }else{
                    PortfolioAjaxAction.stopLoading($this);
                }
                if($filterType=='ajax')
                    PortfolioAjaxAction.registerFilterByCategory($section_id);

                if($data_show_paging=='1'){
                    jQuery('#load-more-' + $section_id).empty();
                    jQuery('#paging-' + $section_id).empty();
                    if(jQuery('.paging',data).length>0){
                        var $loadButton = jQuery('.paging a.load-more',data);
                        $loadButton.attr('data-section-id',$section_id);

                        jQuery('#load-more-' + $section_id).append($loadButton);
                        PortfolioAjaxAction.registerLoadmore();
                    }
                    if(jQuery('.portfolio-navigation-wrap',data).length>0){
                        var $navigatorWrap = jQuery('.portfolio-navigation-wrap',data);
                        var $navigatorButton = jQuery('a',$navigatorWrap);
                        $navigatorButton.attr('data-section-id',$section_id);
                        jQuery('#paging-' + $section_id).append($navigatorWrap);
                        PortfolioAjaxAction.registerPaging();
                    }
                }
                var $container = jQuery('#portfolio-container-' + $section_id);

                var $item = jQuery('.portfolio-item',data);


                if(isLoadmore == null || !isLoadmore){
                    if(!$container.hasClass('owl-carousel')){
                        if(typeof $data_isotope_col_width != 'undefined' && $data_isotope_col_width!=''){
                            $container.isotope({
                                percentPosition: true,
                                masonry: {
                                    columnWidth: $data_isotope_col_width
                                }
                            });
                        }else{
                            $container.isotope();
                        }

                        jQuery('.portfolio-item',$container).each(function(){
                            $container.isotope( 'remove', jQuery(this) );
                        });
                    }else{
                        $container.empty();
                    }

                    $container.fadeOut();
                    $item.css('transition','all 0.3s');
                    $item.css('-webkit-transition','all 0.3s');
                    $item.css('-moz-transition','all 0.3s');
                    $item.css('-ms-transition','all 0.3s');
                    $item.css('-o-transition','all 0.3s');
                    $item.css('opacity',0);
                }else{
                    $item.fadeOut();
                }

                if(!$container.hasClass('owl-carousel')){
                    $container.append( $item ).isotope( 'appended', $item);
                    var $containerIsotope = jQuery('div[data-section-id="' + $section_id + '"]');
                    $containerIsotope.imagesLoaded( function() {
                        if($bg_effect_overlay=='hover-dir'){
                            jQuery('.portfolio-item > div.thumb-wrap').hoverdir('destroy');
                            jQuery('.portfolio-item > div.thumb-wrap').hoverdir('rebuild');
                        }
                        $container.isotope({ filter: '*' });
                    });
                }else{
                    $container.append( $item );
                }

                PortfolioAjaxAction.registerPrettyPhoto();

                var owl = jQuery($container).data('owlCarousel');
                if(owl!=null && $item.length > 0 ){
                    owl.destroy();
                    jQuery($container).owlCarousel({
                        items : $column,
                        pagination: false,
                        margin: 30,
                        navigation: true,
                        navigationText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>']
                    });
                }
                jQuery('.portfolio-item.hover-dir > div.thumb-wrap').hoverdir();
                if($filterType=='ajax'){
                    $container.fadeIn(10,function(){
                        $item.css('opacity',1);
                    });
                }else{
                    $item.fadeIn();
                    $container.fadeIn();
                }
                if(typeof $data_to_top !='undefined' && $data_to_top=='1'){
                    var $top = jQuery('#portfolio-' + $section_id);
                    jQuery('html, body').animate({
                        scrollTop: $top.offset().top
                    }, 1000);
                }
                PortfolioAjaxAction.registerLoadmore($section_id);
                PortfolioAjaxAction.registerPaging($section_id);
            },
            error:function(){
                if($filterType=='ajax')
                    PortfolioAjaxAction.registerFilterByCategory($section_id);
            }
        });
    },

    registerLoadmore:function(sectionId){
        jQuery('a','#load-more-' + sectionId).off();
        jQuery('a','#load-more-' + sectionId).click(function(){
            PortfolioAjaxAction.processFilter(this, true);
        });
    },

    registerPaging: function(sectionId){
        jQuery('.portfolio-navigation-wrap .nav-next a,.portfolio-navigation-wrap .nav-previous a','#paging-' + sectionId).off();
        jQuery('.portfolio-navigation-wrap .nav-next a,.portfolio-navigation-wrap .nav-previous a','#paging-' + sectionId).click(function(){
            PortfolioAjaxAction.processFilter(this, false);
        });
    },

    registerPrettyPhoto:function(){
        jQuery("a[data-rel^='prettyPhoto']").prettyPhoto(
            {
                hook: 'data-rel',
                theme: 'light_rounded',
                slideshow: 5000,
                deeplinking: false,
                social_tools: false
            });
    },

    registerFilterByCategory:function(sectionId){
        var $container = jQuery('#portfolio-' + sectionId);
        jQuery('.portfolio-tabs li',$container).each(function(){
            jQuery('a',jQuery(this)).off();
            jQuery('a',jQuery(this)).click(function(){
                PortfolioAjaxAction.processFilter(this, false);
            });
        });
        jQuery('select.mobile-category',$container).off();
        jQuery('select.mobile-category',$container).change(function(){
            var $item = jQuery( "option:selected", this );
            PortfolioAjaxAction.processFilter($item, false);
        });
    },

    registerFilterIsotopeMobile: function(){
        jQuery('select.mobile-category').change(function(){
            var $item = jQuery( "option:selected", this );
            var $filter  = $item.attr('data-filter');
            var $section_id = $item.attr('data-section-id');
            var $container = jQuery('#portfolio-container-' + $section_id);
            $container.isotope({ filter: $filter});
        });
    },

    wrapperContentResize:function(){
        jQuery('#wrapper-content').bind('resize', function(){
            var $container = jQuery('.portfolio-wrapper');
            var owl = jQuery('.portfolio-wrapper').data('owlCarousel');
            if(owl==null ){
                 $container.isotope({
                 itemSelector: '.portfolio-item'
                 }).isotope('layout');

            }
        });
    },

    startLoading: function(elm){
        var $loading = jQuery('<div class="loading-wrap"><span class="l-1 p-color-bg"></span><span class="l-2 p-color-bg"></span>' +
                                '<span class="l-3 p-color-bg"></span><span class="l-4 p-color-bg"></span>' +
                                '<span class="l-5 p-color-bg"></span><span class="l-6 p-color-bg"></span></div>');
        jQuery(elm).before($loading);
        jQuery(elm).hide();
    },
    stopLoading: function(elm){
        var $loading = jQuery(elm).prev();
        if(typeof $loading !='undefined' && $loading.hasClass('loading-wrap')){
            $loading.remove();
        }
        jQuery(elm).show();
    },

    init:function(ajax_url, tab_category_action, dataSectionId){
        PortfolioAjaxAction.vars.ajax_url = ajax_url;
        PortfolioAjaxAction.vars.tab_category_action = tab_category_action;
        PortfolioAjaxAction.registerLoadmore(dataSectionId);
        PortfolioAjaxAction.registerPaging(dataSectionId);
        PortfolioAjaxAction.registerPrettyPhoto();
        if(tab_category_action=='ajax'){
            PortfolioAjaxAction.registerFilterByCategory(dataSectionId);
        }else{
            PortfolioAjaxAction.registerFilterIsotopeMobile();
        }
        PortfolioAjaxAction.wrapperContentResize();
    }
}