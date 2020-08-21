
$(window).scroll(function(){
           if ($(this).scrollTop() > 100) {
             $('.back-top').fadeIn();
             $('.scrollup').fadeIn();
           } else {
             $('.back-top').fadeOut();
             $('.scrollup').fadeOut();
           }
       });

       $('.scrollup').click(function(){
           $("html, body").animate({ scrollTop: 0 }, 600);
           return false;
       });
