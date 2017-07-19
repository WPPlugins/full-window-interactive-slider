(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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
jQuery(document).ready(function($){
    var custom_uploader;
    var n = 1;
    var this_element;
    $(document).on('click', '.upload_image_button', function(e) {
	this_element = $(this);
        e.preventDefault();
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $(this_element).siblings('.upload_image').val(attachment.url);
            /*AÑADIDO NOTYPE PARA CARGA DINAMICA DE LA IMAGEN*/
	      if($(this_element).hasClass('main_image_upload')){
		    $('.fwms_work_area').html('<img src="'+attachment.url+'" width="100%" class="canvas">').click(function(z){
		        // Do something
		       	fwms_get_coords(z);
		    });
		}else{
		    $(this_element).siblings('.pin_element').attr('src', attachment.url);
		    var index = $(this_element).parents('#message').data('index');
		    jQuery('.dummy[data-pin="'+index+'"] img').attr('src', attachment.url);
		    
		}
            /*FIN DE AÑADIDO*/
        });
        
        //Open the uploader dialog
        custom_uploader.open();
    });
	jQuery('.canvas').click(function(z){
		fwms_get_coords(z);
	});
	function fwms_add_field(l, t, et, el) {
		if(jQuery('.fwms_slots').children().length > 0){
			n = jQuery('.fwms_slots').children().last().data('index');
			n++;
		}
		var new_slot = '<div id="message" class="updated notice is-dismissible below-h2" data-index="'+n+'">';
			new_slot += '<p><input type="hidden" name="coord['+n+'][l]" value="'+ parseFloat(l)+'">';
			new_slot += '<input type="hidden" name="coord['+n+'][t]" value="'+ parseFloat(t)+'">';
			new_slot += info.text.texttitle + '<input type="text" name="coord['+n+'][title]">';
			new_slot += info.text.textcontent + '<input type="text" name="coord['+n+'][content]">';
			new_slot += '<label for="upload_image"><input class="upload_image" type="hidden" size="36" name="coord['+n+'][pin]" value=""  /><input id="upload_pin_button_'+n+'" class="button upload_image_button pin_image_upload" type="button" value="'+info.text.textchangepin+'" /><img class="pin_element" width="50" src="'+info.url+'images/pin.png"></label>';
			new_slot += '</p><span class="screen-reader-text">'+info.text.textdiscard+'</span><button class="notice-dismiss" type="button"><span class="screen-reader-text">'+info.text.textdiscard+'</span></button></div>';
		jQuery('.fwms_slots').append(new_slot);		
		var pin = '<div class="dummy" style="left:'+ el + '%; top:'+ et +'%;" data-pin="'+n+'">';
        pin += '<img width="50" src="'+info.url+'images/pin.png">';
        pin += '</div>';
		jQuery('.fwms_work_area').append(pin);
		n++;
	}
	function fwms_get_coords(z){
					var offset = $('.canvas').offset();
					// Then refer to 
					var x = z.pageX - offset.left-25;
					var y = z.pageY - offset.top-50;
					var xx = z.pageX - offset.left;
					var yy = z.pageY - offset.top;
					var w = $('.canvas').width();
					var h = $('.canvas').height();
					var l = (xx*100/w);
					var t = (yy*100/h);
					var el = (x*100/w);
					var et = (y*100/h);
					fwms_add_field(l,t, et, el);
	}
	jQuery(document).on('click', '.fwms_slots .notice-dismiss', function(){
	  var index = jQuery(this).parent('.notice').data('index');
	  jQuery('.dummy[data-pin="'+index+'"]').remove();

	  jQuery(this).parent('.notice').remove();

	});
});
})( jQuery );
