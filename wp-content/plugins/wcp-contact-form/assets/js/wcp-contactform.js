(function() {
    
    tinymce.create('tinymce.plugins.wcpContactForm', {
        init : function(ed, url) {
            ed.addButton('wcp_contactform', {
               title : 'Add New WCP Contact Form',
               image : url+'/ico.png',
               onclick : function() {
                    ed.selection.setContent('[wcp_contactform id="' + uniqueid() + '"]');
               }
            }); 
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
               longname : "FontAwesome Constructor",
               author : 'Webcodin',
               authorurl : 'http://wpdemo.webcodin.com/',
               version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('wcp_contactform', tinymce.plugins.wcpContactForm);
    
    

    function uniqueid(){
        // always start with a letter (for DOM friendlyness)
        var idstr=String.fromCharCode(Math.floor((Math.random()*25)+65));
        do {                
            // between numbers and characters (48 is 0 and 90 is Z (42-48 = 90)
            var ascicode=Math.floor((Math.random()*42)+48);
            if (ascicode<58 || ascicode>64){
                // exclude all chars between : (58) and @ (64)
                idstr+=String.fromCharCode(ascicode);    
            }                
        } while (idstr.length<9);

        return 'wcpform_' + (idstr.toLowerCase());
    }


})();