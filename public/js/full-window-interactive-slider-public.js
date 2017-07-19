(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
 jQuery(".other").each(function(){
        var image = jQuery( this ).data( "bg" );
        jQuery(this).backstretch(image);
//         alert('done');
      });

      jQuery('.fwmbup').click(function(){
        if(jQuery('.active').next('.other').length){
            jQuery('.active').addClass('current');
            jQuery('.active').next('.other').addClass('active');
            jQuery('.current').slideUp();
            jQuery('.current').removeClass('active');
            jQuery('.current').removeClass('current');
            var image = jQuery( ".active" ).data( "bg" );
            jQuery(".active").backstretch(image);
            clearTimeout(doit);
            doit = setTimeout(remap, 50); 
        } 
      });

      jQuery('.fwmbdown').click(function(){
        if(jQuery('.active').prev('.other').length){
            /*debugging the weird effect that happens on loading prev divs (dont ask)*/
            var div_w = jQuery('.active').children('.backstretch').css('width');
            var div_h = jQuery('.active').children('.backstretch').css('height');
            var img_w = jQuery('.active').children('.backstretch').children('img').css('width');
            var img_i = jQuery('.active').children('.backstretch').children('img').css('height');
            var img_l = jQuery('.active').children('.backstretch').children('img').css('left');
            var img_t = jQuery('.active').children('.backstretch').children('img').css('top');            
            jQuery('.active').prev('.other').children('.backstretch').css('width', div_w).css('height', div_h);
            jQuery('.active').prev('.other').children('.backstretch').children('img').css('width', img_w).css('height', img_i).css('left', img_l).css('top', img_t);          
            /**/
            jQuery('.active').addClass('current');
            jQuery('.active').prev('.other').addClass('active');
            jQuery('.current').removeClass('active');
            jQuery('.current').removeClass('current');
            jQuery('.active').slideDown(function(){
                        var image = jQuery( ".active" ).data( "bg" );
//                           jQuery(".active").backstretch(image);
			  clearTimeout(doit);
                          doit = setTimeout(remap, 50);  
                });
        } 
      }); 
//window.onload = remap();
var doit;
window.onresize = function(){
   var image = jQuery( ".active" ).data( "bg" );
   jQuery(".active").backstretch(image);
 clearTimeout(doit);
 doit = setTimeout(remap, 50);
// remap();
};
// jQuery(document).ready(function() {
//       alert("document ready occurred!");
// });
window.onload = function() {  

    //  alert("window load occurred!");
remap();
}

      function remap(){
//alert('remapped');
        jQuery('.dummy').each(function(){
	  //for left
          var ld = jQuery(this).data('left');
          var iw = parseFloat(jQuery(this).closest('.other').find('.backstretch img').css('width'));
          ld = parseFloat(ld)*parseFloat(iw)/100;
          var ww = parseFloat(jQuery(window).width());
          if(iw > ww){
            var dif = (iw - ww) / 2;
            ld = ld - dif;
          }
          ld = ld-25;
          jQuery(this).css('left', ld);
	  //For top
	  var td = jQuery(this).data('top');
          var ih = jQuery(this).closest('.other').find('.backstretch img').css('height');
	  
	  
	  
          var tl = jQuery(this).closest('.other').find('.backstretch img').css('top');
	  
	  
	  td = parseFloat(td)*parseFloat(ih)/100;
	  td = td+parseFloat(tl);
// 	  tl = parseFloat(tl)/2;
// 	  console.log(td + '/' + parseFloat(ih) + '/' + tl);
//           td = parseFloat(td)*(parseFloat(ih)+tl)/100;
//            console.log(td + '/' + tl);
// 	  td = parseFloat(td) + (parseFloat(tl));
	  td = td-50;
          jQuery(this).css('top', td);
          
        });
        
      }

      jQuery('.fwms_pin').mouseenter(function(){
        jQuery(this).next('.fwmb_tooltip').show('0.5');
      });
      jQuery('.dummy').mouseleave(function(){
        jQuery(this).children('.fwmb_tooltip').hide('0.5');
      });
})( jQuery );
