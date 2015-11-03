if (typeof scfp_rcwidget == 'undefined') {
    var scfp_rcwidget = {};
}

var scfpOnLoadCallback = function () {
    for(var prop in scfp_rcwidget) {
        scfp_rcwidget[prop] = grecaptcha.render(prop, scfp_rcwidget[prop]);
    }            
};



