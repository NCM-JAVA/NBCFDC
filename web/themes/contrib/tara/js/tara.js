/* Load jQuery.
------------------------------------------------*/
jQuery(document).ready(function ($) {
  // Mobile menu.
  $('.mobile-menu').click(function () {
    $(this).next('.primary-menu-wrapper').toggleClass('active-menu');
  });
  $('.close-mobile-menu').click(function () {
    $(this).closest('.primary-menu-wrapper').toggleClass('active-menu');
  });

  // Full page search.
  $('.search-icon').click(function () {
    $('.search-box').css('display', 'flex');
    return false;
  });
  $('.search-box-close').click(function () {
    $('.search-box').css('display', 'none');
    return false;
  });
$('.social-media-link-icon--twitter span').addClass('fa-x-twitter').removeClass('fa-twitter');
  // Scroll To Top.
  $(window).scroll(function () {
    if ($(this).scrollTop() > 80) {
      $('.scrolltop').css('display', 'flex');
    } else {
      $('.scrolltop').fadeOut('slow');
    }
  });
  $('.scrolltop').click(function () {
    $('html, body').scrollTop(0);
  });

// End document ready.
});

/* Function if device width is more than 767px.
------------------------------------------------*/
jQuery(window).on('load', function ($) {
  // Add empty space for fixed footer.
  if (jQuery(window).width() > 767) {
    var footerheight = jQuery('#footer').outerHeight(true) + 4;
    jQuery('#last-section').css('height', footerheight);
  }
   $('.file--mime-application-pdf a').attr('target', '_blank');  
   $(".file--mime-application-pdf  a ").text('View');
// end window on load
});
jQuery(document).ready(function(jQuery) {
const forbiddenChars = ['@', '!', '#', '$', '%', '^', '&', '*', '(', ')', '.','<','>','`','~','-','_','=','+','?','/','|',';','"','{','}',':',',','[',']','\\',"'"]

						jQuery("textarea").keydown(function(event) {
						  if (forbiddenChars.includes(event.key)) {
							console.log('Key prevented')
							event.preventDefault();
							return false;
						  }
						});
						jQuery("input[type=text]").keydown(function(event) {
						  if (forbiddenChars.includes(event.key)) {
							console.log('Key prevented')
							event.preventDefault();
							return false;
						  }
						});
            
						jQuery('#edit-name').keydown(function (e) {
										var key = e.keyCode;
											if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105)) {
												e.preventDefault();
											}
									});
						jQuery('#edit-contact-no-').keypress(function (e) {
						  var key = e.charCode || e.keyCode || 0;
					  
						  // only numbers
						  if (key < 48 || key > 58) {
							return false;
						  }
						});

						jQuery('#edit-mobile').keypress(function (e) {
						  var key = e.charCode || e.keyCode || 0;
					  
						  // only numbers
						  if (key < 48 || key > 58) {
							return false;
						  }
						});
          

					});
  jQuery(function(){
        jQuery('.view-display-id-block_3.home-news-ticker').easyTicker({
            direction: 'up',
            easing: 'swing',
            visible: 1,
            mousePause: 1,
            height:'150',
            controls: {
                toggle: '.btnToggle-news-announce', 
                playText: 'Play',
                stopText: 'Stop'
            }
        });
    });
	
