/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

    var tooltipsy = require(['/wp-content/themes/looptheme/bower_components/tooltipsy/tooltipsy.min.js']);

    // Use this variable to set up the common and page specific functions. If you
    // rename this variable, you will also need to rename the namespace below.
    var Sage = {
        // All pages
        'common' : {
            init : function() {
                // JavaScript to be fired on all pages
            },
            finalize : function() {
                // JavaScript to be fired on all pages, after page specific JS is fired
                if($('body').hasClass('home')) {
                    $contentCol = $('html body>.container .content .main');
                    $contentCol.css({
                        'max-width': '100%'
                    });
                    $contentCol = $('html body>.container .content .sidebar');
                    $contentCol.css({
                        'max-width': '0%'
                    });
                }

                $companyTypo = $('a.brand');
                $companyTypo.after('<h4 class="slogan">WEBSERVER-ADMINISTRATION</h4>');

                $pageLink = $('.content.row a');
                $pageLink.each(function() {
                    if($(this).find('*').length===0) {
                        $(this).attr('title', '[Klick] Hypertext-Link öffnen');
                    }
                    if($(this).find('img').length>0) {
                        $(this).attr('title', '[Klick] Bild vergrößern');
                    }
                });
                $('input,select,textarea').attr('title', 'Eingabefeld bitte ausfüllen');
                $('button,input[type="submit"]').attr('title', '[Klick] interaktive Funktion ausführen');

                var navMainMenu = $('nav #menu-mainmenu a');
                var navItems = [
                    'TECHJOURNAL: <br />Ein Blogsystem mit Themen rund um die Webentwicklung',
                    'PRODUCTION: <br />Scripts, Themes und anderes befindet sich hier zum download',
                    'ÜBER MICH: <br />Eine Zusammenfassung über den Webmaster von Awebgo',
                    'KONTAKT: <br />Kontaktiere den Webmaster <br />über einen E-Mail-Klienten',
                    'IMPRESSUM: <br />Pflichtangaben zur Awebgo-Website'
                ];
                var navCount = 0;
                navMainMenu.each(function() {
                    $(this).attr('title', navItems[navCount]);
                    navCount++;
                });

                var $tooltipItem = $('.hastip,.container img,nav #menu-mainmenu a,.content.row a,#wp-calendar th,.tagcloud a,button,input,select,textarea');
                if($tooltipItem.prop('title').length!==0) {
                    $tooltipItem.tooltipsy({
                        alignTo: 'cursor',
                        offset: [10,-10],
                        css: {
                            'position': 'fixed',
                            'top': '30px',
                            'right': '30px',
                            'font-weight': 'bold',
                            'padding': '0.25em 0.4em',
                            'max-width': '280px',
                            'color': '#fff',
                            'background-color': '#203040',
                            'border': '3px solid #102030',
                            '-moz-box-shadow': '0 0 10px rgba(0,0,0,0.75)',
                            '-webkit-box-shadow': '0 0 10px rgba(0,0,0,0.75)',
                            'box-shadow': '0 0 10px rgba(0,0,0,0.75)',
                            'text-shadow': 'none',
                            '-webkit-border-radius': '7px',
                            'border-radius': '7px',
                            'overflow': 'hidden'
                        }
                    });
                }

            }
        },
        // Home page
        'home' : {
            init : function() {
                // JavaScript to be fired on the home page
            },

            finalize : function() {
                // JavaScript to be fired on the home page, after the init JS
            }
        },
        // About us page, note the change from about-us to about_us.
        'about_us' : {
            init : function() {
                // JavaScript to be fired on the about us page
            }
        }
    };

    // The routing fires all common scripts, followed by the page specific scripts.
    // Add additional events for more control over timing e.g. a finalize event
    var UTIL = {
        fire : function(func, funcname, args) {
            var fire;
            var namespace = Sage;
            funcname = (funcname === undefined) ? 'init' : funcname;
            fire = func !== '';
            fire = fire && namespace[func];
            fire = fire && typeof namespace[func][funcname] === 'function';

            if (fire) {
                namespace[func][funcname](args);
            }
        },
        loadEvents : function() {
            // Fire common init JS
            UTIL.fire('common');

            // Fire page-specific init JS, and then finalize JS
            $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
                UTIL.fire(classnm);
                UTIL.fire(classnm, 'finalize');
            });

            // Fire common finalize JS
            UTIL.fire('common', 'finalize');
        }
    };

    // Load Events
    $(document).ready(UTIL.loadEvents);

})(jQuery);
// Fully reference jQuery after this point.
