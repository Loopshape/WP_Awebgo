(function($) {  
    $(document).ready(function() { 
        $(document).on('click', '#agp-repeater-scfp_form_settings .agp-del-row', function(e) {
           $(this).closest('.agp-row').remove();
           renumber_table('#scfp-sortable');
        });

        $(document).on('click', '#agp-repeater-scfp_form_settings .agp-up-row', function(e) {            
            var el = $(this).closest('.agp-row');
            var prev = $(el).prev('.agp-row');
            $(el).insertBefore(prev);
            renumber_table('#scfp-sortable');
        });            

        $(document).on('click', '#agp-repeater-scfp_form_settings .agp-down-row', function(e) {                        
            var el = $(this).closest('.agp-row');
            var next = $(el).next('.agp-row');
            $(el).insertAfter(next);
            renumber_table('#scfp-sortable');
        });                    
        
        $(document).on('click', '#agp-repeater-scfp_form_settings .agp-add-row', function(e) {
            var content = $(this).closest('.agp-repeater').find('.agp-row.agp-row-template').html();
            var index = 'xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {var r = Math.random()*16|0,v=c=='x'?r:r&0x3|0x8;return v.toString(16);});

            content = '<div class="agp-row scfp-field-row ui-sortable-handle">' + content.replace(/\[0\]/g, '[' + index + ']').replace(/_0_/g, '_' + index + '_') + '</div>';

            $(this).closest('.agp-repeater').find('.scfp-settings-table-list').append(content);
            renumber_table('#scfp-sortable');
        });
        

        //make table rows sortable
        $('#agp-repeater-scfp_form_settings .scfp-settings-table-list').sortable({
            helper: function (e, ui) {
                ui.children().each(function () {
                    $(this).width($(this).width());
                });
                return ui;
            },
            scroll: true,
            placeholder: "ui-sortable-placeholder",
            stop: function(event,ui) {renumber_table('#scfp-sortable');}
        });

        
        function renumber_table(tableID) {     
            $(tableID + " .agp-row:visible").each(function() {
                count = $(this).parent().children(':visible').index($(this)) + 1;
                $(this).find('.priority').html(count);
            });
        }
 
    });
})(jQuery);
