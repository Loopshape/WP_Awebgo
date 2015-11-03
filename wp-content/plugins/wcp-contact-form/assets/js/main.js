(function($) {  
    $(document).ready(function() { 
        
        function refreshCaptcha (element) {
            
            var container = $(element).closest('.scfp-form-row').find('.scfp-captcha-image');
            var self = element;
            
            var data = {};
            data.action = 'recreateCaptcha';
            data.nonce = ajax_scfp.ajax_nonce;
            data.id = $(element).data('id');
            data.key = $(element).data('key');

            $.ajax({
                url:ajax_scfp.ajax_url,
                type: 'POST' ,
                data: data,
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if (data.img) {
                        $(container).find('img').attr('src', data.img);
                        $(self).closest('.scfp-form-row').find('.scfp-captcha-field .scfp-form-field').val('');                        
                    }
                },
                error: function (request, status, error) {
                }
            });            
        }
        
        
        $('.scfp-captcha-refresh').each(function() {
            $(this).on('click', function( event ) {
                event.preventDefault();
                refreshCaptcha(this);
                return false;
            });

            refreshCaptcha(this);            
        });
        
        setTimeout(function () { $('.scfp-form-notification').fadeOut('slow', function() {$(this).remove();});}, 7000);
        
        $(document).on('click', '.scfp-form-notifications-close', function(event) {
           $(this).closest('.scfp-notifications').fadeOut('slow', function() {$(this).remove();}); 
           return false;
        }); 
        
        if ($('.scfp-notifications').length > 0) {
            $('html, body').stop().animate({scrollTop: $('.scfp-notifications').eq(0).position().top} , 0);    
        }

        $(document).on('submit', '.scfp-form', function(event) {
            if ( $(this).find('.scfp-form-submit').attr("disabled") != 'disabled' ) {
                $(this).find('.scfp-form-submit').attr("disabled", true);    
                $(this).find('.scfp-form-submit').addClass('scfp-form-submit-disabled');    
            } else {
                return false;    
            }
        }); 

    });
    
    $('.scfp-rcwidget-response').val('');
    
})(jQuery);


