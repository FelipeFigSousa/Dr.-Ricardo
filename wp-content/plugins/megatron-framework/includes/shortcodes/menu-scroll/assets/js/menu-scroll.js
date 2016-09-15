(function($) {
    "use strict";
    $(document).ready(function () {
	    $('#nav-scroll nav').perfectScrollbar({
		    wheelSpeed: 0.5,
		    suppressScrollX: true
	    });
	    $('body').scrollspy({
		    target: '#nav-scroll',
		    offset: 60
	    });
	    $('#nav-scroll a[href*=#]:not([href=#])').click(function() {
		    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			    var target = $(this.hash);
			    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			    if (target.length) {
				    $('html,body').animate({
					    scrollTop: target.offset().top - 50
				    }, 1000);
				    return false;
			    }
		    }
	    });
	    $(window).scroll(function(){
		    var window_top = $(window).scrollTop(); // the "12" should equal the margin-top value for nav.stick
		    var div_top = $('#nav-scroll').offset().top;
		    if (window_top > div_top) {
			    $('#nav-scroll nav').addClass('stick');
		    } else {
			    $('#nav-scroll nav').removeClass('stick');
		    }
		    if ($("#nav-scroll nav li:last-child").hasClass("active")) {
			    $('#nav-scroll nav').removeClass('stick');
		    }
	    });
    });
})(jQuery);