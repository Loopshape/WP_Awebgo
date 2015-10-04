jQuery(document).ready(function() {
   
    jQuery("#wp-admin-bar-google_plus_feed_admin_bar-default li:first-child a").click(function() {
		//alert('etf');
        console.log('Click Clear Cache Function');
     
        jQuery.ajax({
            data: {action: "gpf_clear_cache_ajax" },
            type: 'POST',
            url: gpfAjax.ajaxurl,
            success: function( response ) { 
			//	jQuery('body').hide();
				console.log('Well Done and got this from sever: ' + response);
				// alert and upon clicking refresh the page
				if(!alert('Cache for all Google Feeds cleared!')){window.location.reload();}

				return false;
			}
        }); // end of ajax()
        return false;
    }); // end of document.ready
}); // end of form.submit