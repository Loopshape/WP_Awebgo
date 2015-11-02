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
    "use_strict";

    var _href = window.location.href;

    try {

        // ********************************************************************************

        var scriptdata = function() {

            var _scrollElem = 'body>header';

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
                        var $contentCol,
                            $companyTypo,
                            $pageLink;
                        if ($('body').hasClass('home')) {
                            $contentCol = $('html body>.container .content .main');
                            $contentCol.css({
                                'max-width' : '100%'
                            });
                            $contentCol = $('html body>.container .content .sidebar');
                            $contentCol.css({
                                'max-width' : '0%'
                            });
                        }

                        $companyTypo = $('a.brand');
                        $companyTypo.after('<h4 class="slogan">WEBSERVER-ADMINISTRATION</h4>');

                        $pageLink = $('.content.row a');
                        $pageLink.each(function() {
                            if ($(this).find('*').length === 0) {
                                $(this).attr('title', '[Klick] Hypertext-Link öffnen');
                            }
                            if ($(this).find('img').length > 0) {
                                $(this).attr('title', '[Klick] Bild vergrößern').closest('a').addClass('internal');
                            }
                        });
                        $('input,select,textarea').attr('title', 'Eingabefeld bitte ausfüllen');
                        $('button,input[type="submit"]').attr('title', '[Klick] interaktive Funktion ausführen');

                        var navMainMenu = $('nav #menu-mainmenu a');
                        var navItems = ['STARTSEITE: <br />Hauptseite von Awebgo und Ausgangspunkt zu den jeweiligen Themenbereichen', 'TECHJOURNAL: <br />Ein Blogsystem mit Themen rund um die Webentwicklung', 'PRODUCTION: <br />Scripts, Themes und Weiteres befindet sich hier zum Download', 'KONTAKT: <br />Kontaktiere den Webmaster <br />über einen E-Mail-Klienten', 'ÜBER MICH: <br />Eine Zusammenfassung über den Webmaster von Awebgo', 'IMPRESSUM: <br />Pflichtangaben zur Awebgo-Website'];
                        var navCount = 0;
                        navMainMenu.each(function() {
                            $(this).attr('title', navItems[navCount]);
                            navCount++;
                        });

                        $('#pinterestBox a').each(function() {
                            var _textBuffer = $(this).children('img').prop('alt');
                            $(this).children('img').attr('alt', '').closest('a').attr('title', _textBuffer);
                        });

                        var $tooltipItem = $('.hastip,.container img,nav #menu-mainmenu a,.content.row a,#wp-calendar th,#wp-calendar td a,.tagcloud a,button,input,select,textarea,.widget_views a,#pinterestBox a');
                        if ($tooltipItem.prop('title').length !== 0) {
                            $tooltipItem.tooltipsy({
                                alignTo : 'cursor',
                                offset : [10, -10],
                                css : {
                                    'position' : 'fixed',
                                    'top' : '30px',
                                    'right' : '30px',
                                    'font-weight' : 'bold',
                                    'padding' : '0.35em 0.5em',
                                    'max-width' : '280px',
                                    'color' : '#fff',
                                    'background-color' : '#203040',
                                    'background-image' : 'url("/wp-content/themes/looptheme/assets/images/MetalField.png")',
                                    'background-size' : '50%',
                                    'background-position' : 'top left',
                                    'background-attachment' : 'scroll',
                                    'border' : '3px solid #102030',
                                    '-moz-box-shadow' : '0 0 10px rgba(0,0,0,0.75)',
                                    '-webkit-box-shadow' : '0 0 10px rgba(0,0,0,0.75)',
                                    'box-shadow' : '0 0 10px rgba(0,0,0,0.75)',
                                    'text-shadow' : 'none',
                                    '-webkit-border-radius' : '7px',
                                    'border-radius' : '7px',
                                    'opacity' : '0.9',
                                    'visibility' : 'visible',
                                    'overflow' : 'hidden'
                                }
                            });
                        }

                        // ********************************************************************************

                        $(function($) {

                            // Check if HTML-DOM is initialized and remove flag
                            if ($('html').hasClass('init')) {
                                $('html').removeClass('init');
                                // Check COOKIE for STATIC-DOM activated
                                if (Cookies.set('awebgo_staticdom', {
                                    path : ''
                                }) !== false) {
                                    $('img,div').css({
                                        'filter' : 'none',
                                        '-webkit-transition' : 'all 0ms linear',
                                        '-moz-transition' : 'all 0ms linear',
                                        '-ms-transition' : 'all 0ms linear',
                                        '-o-transition' : 'all 0ms linear',
                                        'transition' : 'all 0ms linear'
                                    });
                                    if ($('body').hasClass('mover')) {
                                        $('body').removeClass('mover');
                                    }
                                    if ($('body').hasClass('static')) {
                                        $('body').removeClass('static');
                                    }
                                    $('body').addClass('freezed');
                                } else {
                                    Cookies.set('awebgo_staticdom', false, {
                                        path : ''
                                    });
                                    $('body').removeClass('freezed');
                                }
                            }

                            // Init CSS3-TRANSITIONS
                            if ($('body').hasClass('home')) {
                                $('body').addClass('mover');
                            }

                            // Define the STATIC-DOM switch
                            $('div.laptopArea img').on('click', function(e) {
                                e.preventDefault();
                                if (Cookies.set('awebgo_staticdom', {
                                    path : ''
                                })) {
                                    Cookies.set('awebgo_staticdom', false, {
                                        path : ''
                                    });
                                    $('body').removeClass('freezed');
                                    $('.laptopArea img').css({
                                        'filter' : 'invert(0%)'
                                    });
                                } else {
                                    Cookies.set('awebgo_staticdom', true, {
                                        path : ''
                                    });
                                    $('body').addClass('freezed');
                                    $('.laptopArea img').css({
                                        'filter' : 'invert(100%)'
                                    });
                                }
                                window.location.href = '/';
                                return false;
                            });

                            // Set BODY to colorful mode
                            $('body').addClass('colorful');

                            // Show the content
                            $('body>*,body>*>*,body>*>*>*,body>*>*>*>*,body>*>*>*>*>*,body>*>*>*>*>*>*,body>*>*>*>*>*>*+*').animate({
                                'opacity' : '+=0.999'
                            }, 1000);

                            // Calculate MEDIAQUERY settings for viewport
                            var _mediaQueryFactor = 10 / ($(window).innerWidth() / 256);

                            if (_mediaQueryFactor !== 0) {

                                $('*').each(function() {

                                    var padValTop = $(this).attr('padding-top') - _mediaQueryFactor;
                                    var padValBot = $(this).attr('padding-bottom') - _mediaQueryFactor;
                                    var padValLeft = $(this).attr('padding-left') - _mediaQueryFactor;
                                    var padValRight = $(this).attr('padding-right') - _mediaQueryFactor;

                                    var marValTop = $(this).attr('margin-top') - _mediaQueryFactor;
                                    var marValBot = $(this).attr('margin-bottom') - _mediaQueryFactor;
                                    var marValLeft = $(this).attr('margin-left') - _mediaQueryFactor;
                                    var marValRight = $(this).attr('margin-right') - _mediaQueryFactor;

                                    if (padValTop !== null || padValBot !== null || padValLeft !== null || padValRight !== null) {
                                        $(this).css('padding-top', padValTop);
                                        $(this).css('padding-bot', padValBot);
                                        $(this).css('padding-left', padValLeft);
                                        $(this).css('padding-right', padValRight);
                                    }

                                    if (marValTop !== null || marValBot !== null || marValLeft !== null || marValRight !== null) {
                                        $(this).css('margin-top', marValTop);
                                        $(this).css('margin-bot', marValBot);
                                        $(this).css('margin-left', marValLeft);
                                        $(this).css('margin-right', marValRight);
                                    }

                                });

                            }

                            // Add FONT-AWESOME via jQuery
                            $('section.widget h3').prepend('<i class="fa fa-square yellow"></i>&nbsp;');
                            $('body div.wrap.container div > * > div.page-header > h1').prepend('<i class="fa fa-edit green"></i>&nbsp;');
                            $('.widget .tagcloud a').prepend('<i class="fa fa-asterisk yellow"></i>&nbsp;');
                            if ($('article').length !== 0) {
                                $('time.updated').prepend('<i class="fa fa-clock-o yellow"></i>&nbsp;');
                            }

                            // ************************************************** //

                            // Smooth viewport scroll by Chris Coyier
                            // https://css-tricks.com/snippets/jquery/smooth-scrolling/
                            $('a[href*=#]:not([href=#])').on('click touchend', function(event) {
                                event.preventDefault();
                                if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
                                    var target = $(this.hash);
                                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                                    if (target.length) {
                                        $('html,body').animate({
                                            scrollTop : target.offset().top
                                        }, 1000, function() {
                                            $('.gotoTop').animate({
                                                'opacity' : '-=0.999'
                                            }, 1000, function() {
                                                $(this).hide();
                                            });
                                        });
                                    }
                                }
                            });

                            // http://stackoverflow.com/questions/15590236/fade-in-element-on-scroll-down-using-css
                            $(window).scroll(function() {
                                /* Check the location of each desired element */
                                $(_scrollElem).each(function(i) {
                                    i = null;
                                    var bottom_of_object = $(this).position().top + $(this).outerHeight();
                                    var bottom_of_window = $(window).scrollTop() + $(window).height();
                                    /* If the object is completely visible in the window, fade it it */
                                    if (bottom_of_window > bottom_of_object) {
                                        $('.gotoTop').show().animate({
                                            'opacity' : '+=0.99'
                                        }, 1000);
                                    }
                                });
                            });

                            // Click handler for internal and external URLs
                            // with Screen-Fading functionality via Greensock.
                            // Coded by Arjuna Noorsanto
                            $('a:not(a[data-rel^="lightbox"])').on('click', function(event) {
                                _href = $(this).prop('href');
                                if ($('li[id^="menu-item"]>a,.tagcloud>a') || $(this).hasClass('gotoSideRight')) {
                                    window.location = _href;
                                }
                                if ($(this).hasClass('external')) {
                                    event.preventDefault();
                                    $('body').addClass('static');
                                    $('.container.wrap').animate({
                                        'opacity' : '-=1'
                                    }, 1000, function() {
                                        window.open(_href, '_blank');
                                    });
                                    return false;
                                } else {
                                    $('body').addClass('static');
                                    $('.container.wrap').animate({
                                        'opacity' : '-=1'
                                    }, 1000, function() {
                                        if ($(this).hasClass('internal') || $(this).hasClass('gotoSideRight')) {
                                            return true;
                                        }
                                        if ($('a:not(a[data-rel^="lightbox"])').length !== 0) {
                                            return false;
                                        }
                                        event.preventDefault();
                                        window.location = _href;
                                    });
                                }
                            });

                            // ISOTOPE item grid handler
                            var contentParagraph = 'p:not(.noline p):not(.impressum .main > p):not(.privacy-policy .main > p):not(.administration-website .main > p):not(.main div + div p:not(.masonry p)):not(form p):not(header p):not(.main blockquote > p):not(#commentform > p):not(.entry-content > p):not(.entry-summary > p)';
                            if ($('.main').length !== 0) {
                                var mainColWidth = $('.main p a[data-rel^="lightbox-"] img').innerWidth() + 28;
                                $(contentParagraph).isotope({
                                    itemSelector : 'a[data-rel^="lightbox-"]',
                                    percentPosition : true,
                                    gutter : 20,
                                    //layoutMode : 'fitRows',
                                    masonry : {
                                        columnWidth : mainColWidth
                                    }
                                });
                            }

                            $('.main > p img').each(function() {
                                $(this).closest('p').css('height', 'auto');
                            });

                            // POST LIST content area resize
                            //$(document).ready(function() {
                            $('article > header').each(function() {
                                if ($(this).find('.thumbnail').length === 0) {
                                    $(this).find('.entry-title').css({
                                        'max-width' : '100%',
                                        'margin-bottom' : -($(this).find('.entry-title a').innerHeight())
                                    }).find('.gotoSideRight').css({
                                        'max-width' : '100%',
                                        'min-height' : '0'
                                    });
                                } else {
                                    $(this).find('.entry-title').css({
                                        'margin-bottom' : -($(this).find('.entry-title a').innerHeight())
                                    }).find('.gotoSideRight').css({
                                        'min-height' : ($(this).find('.thumbnail img').innerHeight() - 10)
                                    });
                                }
                            });
                            //});

                            // Fix Isotope item-sum height for contentareas
                            var contentHeight = $('div.content').innerHeight();
                            var lastElemPosY = $('div.content > *:last-of-type').offset().top;
                            $('div.content').height(lastElemPosY);
                            $('div.content > *').matchHeight({
                                byRow : true,
                                property : 'height',
                                target : null,
                                remove : false
                            });
                            $('section.widget').matchHeight({
                                byRow : true,
                                property : 'height',
                                target : null,
                                remove : false
                            });
                            var headerHeight = $('body > header').innerHeight() * 2;
                            var naviHeight = $('.container > nav').innerHeight() * 2;
                            var footerPosY = $('body > footer').offset().top;
                            var isSpecialPage = $('body.production').length !== 0 ? true : false;
                            if (isSpecialPage === false) {
                                $('body > footer').css({
                                    'margin-top' : ((footerPosY - (headerHeight - naviHeight)) + (lastElemPosY - contentHeight) - 30)
                                });
                            } else {
                                $('body > footer').css({
                                    'margin-top' : (((footerPosY - contentHeight) - headerHeight / 2) + 20)
                                });
                            }

                            // Set BODY width to screen-width for better viewport resizing
                            var $window = $(window).innerWidth();
                            if ($window < 1024) {
                                $window = 1024;
                                $('body').css('min-width', $window).css('max-width', $window).css('overflow', 'scroll');
                            } else {
                                $('body').css('min-width', $window).css('max-width', $window);
                            }

                        });
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
                        i = null;
                        UTIL.fire(classnm);
                        UTIL.fire(classnm, 'finalize');
                    });

                    // Fire common finalize JS
                    UTIL.fire('common', 'finalize');
                }
            };

            // Load Events
            $(document).ready(UTIL.loadEvents);

        };

        scriptdata();

    } catch(err) {
        if (err !== 0) {
            window.open('#gotoTop', '_top');
        }
    }

    $(window).resize(function() {
        //window.open(_href, '_top');
    });

})(jQuery);
// Fully reference jQuery after this point.