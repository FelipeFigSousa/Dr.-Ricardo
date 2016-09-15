/**
 * Created by trungpq on 15/09/2015.
 */
(function ($) {
    "use strict";
    var G5PlusMailchimp = {
        init: function() {
            if ($('.mailchimp').length) {
                $('.mailchimp').each(function () {
                    var w=$(this).width();
                    var s_w= $('input[type="submit"]',this).width();
                    var e_w=w-s_w-15;
                    $('input[type="email"]',this).attr('style','width:'+ e_w+'px');
                })
            }
        }
    };
    $(document).ready(G5PlusMailchimp.init);
    $(window).resize(G5PlusMailchimp.init);
})(jQuery);