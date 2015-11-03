(function($) {  
    $(document).ready(function() { 
        $('.scfp-color-picker').wpColorPicker();    
        if (csvVar.active) {
            var csv = '<div class="alignleft actions"><a class="button" title="Export to CSV" href="'+csvVar.href+'">Export to CSV</a></div>'
            $(csv).insertAfter($('.tablenav.top').find('.alignleft.actions:last'));
        }
    });
})(jQuery);


