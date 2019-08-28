  /**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-04-25 13:16:48
 * @@Modify Date: 2018-05-09 11:55:55
 * @@Function:
 */
jQuery(document).ready(function($) {
    
    !(function ($) {"use strict"; $.fn.meanmenu = function (options) {var defaults = {meanMenuTarget: $(this), meanMenuContainer: 'body', meanMenuClose: "X", meanMenuCloseSize: "18px", meanMenuOpen: "<span /><span /><span />", meanRevealPosition: "right", meanRevealPositionDistance: "0", meanRevealColour: "", meanRevealHoverColour: "", meanScreenWidth: "480", meanNavPush: "", meanShowChildren: true, meanExpandableChildren: true, meanExpand: "+", meanContract: "-", meanRemoveAttrs: false, onePage: false, removeElements: "", meanMenuExpandTop: true, expandActive: true, meanMenuResponsive: true, }; var options = $.extend(defaults, options); var currentWidth = window.innerWidth || document.documentElement.clientWidth; return this.each(function () {var meanMenu = options.meanMenuTarget; var meanContainer = options.meanMenuContainer; var meanReveal = options.meanReveal; var meanMenuClose = options.meanMenuClose; var meanMenuCloseSize = options.meanMenuCloseSize; var meanMenuOpen = options.meanMenuOpen; var meanRevealPosition = options.meanRevealPosition; var meanRevealPositionDistance = options.meanRevealPositionDistance; var meanRevealColour = options.meanRevealColour; var meanRevealHoverColour = options.meanRevealHoverColour; var meanScreenWidth = options.meanScreenWidth; var meanNavPush = options.meanNavPush; var meanRevealClass = ".meanmenu-reveal"; var meanShowChildren = options.meanShowChildren; var meanExpandableChildren = options.meanExpandableChildren; var meanExpand = options.meanExpand; var meanContract = options.meanContract; var meanRemoveAttrs = options.meanRemoveAttrs; var onePage = options.onePage; var removeElements = options.removeElements; var meanMenuExpandTop = options.meanMenuExpandTop; var meanMenuResponsive = options.meanMenuResponsive; var expandActive = options.expandActive; if ((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i)) || (navigator.userAgent.match(/Android/i)) || (navigator.userAgent.match(/Blackberry/i)) || (navigator.userAgent.match(/Windows Phone/i))) {var isMobile = true; } if ((navigator.userAgent.match(/MSIE 8/i)) || (navigator.userAgent.match(/MSIE 7/i))) {$('html').css("overflow-y", "scroll"); } meanCentered(); var meanStyles = "background:" + meanRevealColour + ";color:" + meanRevealColour + ";" + meanRevealPos; var $navreveal = ""; var menuOn = false; var meanMenuExist = false; if (meanRevealPosition == "right") {meanRevealPos = "right:" + meanRevealPositionDistance + ";left:auto;"; } if (meanRevealPosition == "left") {var meanRevealPos = "left:" + meanRevealPositionDistance + ";right:auto;"; } if (meanMenuResponsive) {if (!isMobile) {$(window).resize(function () {currentWidth = window.innerWidth || document.documentElement.clientWidth; if (currentWidth > meanScreenWidth) {meanOriginal(); } else {showMeanMenu(); meanCentered(); } }); } window.onorientationchange = function () {meanCentered(); currentWidth = window.innerWidth || document.documentElement.clientWidth; if (currentWidth >= meanScreenWidth) {meanOriginal(); } if (currentWidth <= meanScreenWidth) {showMeanMenu(); } } } if (currentWidth <= meanScreenWidth || !meanMenuResponsive) {if (meanMenuExist == false) {showMeanMenu(); } else {meanOriginal(); } }function meanCentered() {if (meanRevealPosition == "center") {var newWidth = window.innerWidth || document.documentElement.clientWidth; var meanCenter = ((newWidth / 2) - 22) + "px"; meanRevealPos = "left:" + meanCenter + ";right:auto;"; if (!isMobile) {$('.meanmenu-reveal').css("left", meanCenter); } else {$('.meanmenu-reveal').animate({left: meanCenter }); } } }function meanInner() {if (!meanMenuExpandTop) {if ($($navreveal).is(".meanmenu-reveal.meanclose")) {$navreveal.html(meanMenuClose); } else {$navreveal.html(meanMenuOpen); } } }function meanOriginal() {$(meanContainer).removeClass("mean-container").find('.mean-bar,.mean-push').hide(); $(meanMenu).show(); menuOn = false; $(removeElements).removeClass('mean-remove'); }function showMeanMenu() {$(removeElements).addClass('mean-remove'); var meanMenuContainer = $(meanContainer); meanMenuContainer.addClass("mean-container"); if (meanMenuExist) {meanMenuContainer.find('.mean-bar,.mean-push').show().find('.mean-nav ul:first').show(); return; } if (meanMenuExpandTop) meanMenuContainer.append('<div class="mean-bar"><nav class="mean-nav"></nav></div>'); else meanMenuContainer.append('<div class="mean-bar"><a href="#nav" class="meanmenu-reveal" style="' + meanStyles + '">Show Navigation</a><nav class="mean-nav"></nav></div>'); var meanMenuObj = $(meanMenu); meanMenuContainer.find('.mean-nav').html(meanMenuObj.html()); meanMenuObj.remove(); var catplus = meanMenuContainer.find('.nav-accordion >.level0:hidden').not('.all-cat'); if(catplus.length) meanMenuContainer.find('.all-cat').show().click(function(event) {$(this).children().toggle(); catplus.slideToggle('slow');}); else meanMenuContainer.find('.all-cat').hide(); if (meanRemoveAttrs) {meanMenuContainer.find('nav.mean-nav ul, nav.mean-nav ul *').each(function () {$(this).removeAttr("class"); $(this).removeAttr("id"); }); } $(meanMenu).before('<div class="mean-push" />'); meanMenuContainer.find('.mean-push').css("margin-top", meanNavPush); $(meanMenu).hide(); meanMenuContainer.find(".meanmenu-reveal").show(); $(meanRevealClass).html(meanMenuOpen); $navreveal = $(meanRevealClass); if (meanMenuExpandTop) {meanMenuContainer.find('.mean-nav ul ul').hide(); } else {meanMenuContainer.find('.mean-nav ul').hide(); } if (meanShowChildren) {if (meanExpandableChildren) {meanMenuContainer.find('.mean-nav ul ul').each(function () {if ($(this).children().length) {$(this, 'li:first').parent().append('<a class="mean-expand" href="#" style="font-size: ' + meanMenuCloseSize + '">' + meanExpand + '</a>'); } }); if (expandActive) {var listActive = meanMenuContainer.find('.mean-nav li.active'); listActive.find('>ul').show(); listActive.find('> .mean-expand').addClass('mean-clicked').html(meanContract); } meanMenuContainer.find('.mean-expand').on("click", function (e) {e.preventDefault(); $(this).parent().siblings().children('a.mean-expand').text(meanExpand); $(this).parent().siblings().children('a.mean-expand').removeClass('mean-clicked'); $(this).parent().siblings().children('ul').slideUp(300, function () {}); if ($(this).hasClass("mean-clicked")) {$(this).text(meanExpand); $(this).prev('ul').slideUp(300, function () {}); } else {$(this).text(meanContract); $(this).prev('ul').slideDown(300, function () {}); } $(this).toggleClass("mean-clicked"); }); } else {meanMenuContainer.find('.mean-nav ul ul').show(); } } else {meanMenuContainer.find('.mean-nav ul ul').hide(); } meanMenuContainer.find('.mean-nav ul li').last().addClass('mean-last'); $navreveal.removeClass("meanclose"); $($navreveal).click(function (e) {e.preventDefault(); if (menuOn == false) {$navreveal.css("text-align", "center"); $navreveal.css("text-indent", "0"); $navreveal.css("font-size", meanMenuCloseSize); meanMenuContainer.find('.mean-nav ul:first').slideDown(); menuOn = true; } else {meanMenuContainer.find('.mean-nav ul:first').slideUp(); menuOn = false; } $navreveal.toggleClass("meanclose"); meanInner(); $(removeElements).addClass('mean-remove'); }); if (onePage) {meanMenuContainer.find('.mean-nav ul > li > a:first-child').on("click", function () {meanMenuContainer.find('.mean-nav ul:first').slideUp(); menuOn = false; $($navreveal).toggleClass("meanclose").html(meanMenuOpen); }); } meanMenuExist = true; } }); }; })(jQuery);

    (function ($) {
        "use strict";
        $.fn.magicmenu = function (options) {
            var defaults = {
                breakpoint : 991,
                horizontal : '.magicmenu',
                vertical   : '.vmagicmenu',
                sticky     : '.header-sticker',
            };

            var settings   = $.extend(defaults, options);
            var breakpoint = settings.breakpoint;
            var hSelector  = settings.horizontal;
            var vSelector  = settings.vertical;
            var sticky     = settings.sticky;

            var methods = {
                init : function() {
                    return this.each(function() {
                        // Topmenu
                        var topmenu = $(hSelector);
                        var navDesktop = topmenu.find('.nav-desktop');
                        if(navDesktop.hasClass('sticker')) methods.sticky(topmenu);
                        var fullWidth = navDesktop.data('fullwidth');
                        var leveltop = topmenu.find('li.level0.hasChild, li.level0.home').not('.dropdown');
                        methods.horizontal(leveltop, fullWidth, true);

                        // Vertical Menu
                        var vmenu   = $(vSelector);
                        methods.toggleVertical(vmenu);
                        var vLeveltop = vmenu.find('li.level0.hasChild, li.level0.home').not('.dropdown');
                        methods.vertical(vLeveltop, fullWidth, true);
                        // Responsive
                        $(window).resize(function(){
                            if ( breakpoint <= $(window).width()){
                                $('.nav-mobile').hide();
                                navDesktop.show();
                                methods.horizontal(leveltop, fullWidth, false);
                                methods.vertical(vLeveltop, fullWidth, false);
                            } else {
                                $('.nav-mobile').show();
                                navDesktop.hide();
                            }
                        })
                    });
                },

                sticky: function(topmenu){
                    var menuHeight  = topmenu.height()/2;
                    var postionTop  = topmenu.offset().top + menuHeight;
                    var fixedMenu   = $(sticky);
                    var parrentMenu = fixedMenu.parent();
                    var body        = $('body');
                    var heightItem  =  0;
                    var heightAIO   = 0
                    var vmagicmenu = topmenu.parent().find('.vmagicmenu');
                    var menuAIO = vmagicmenu.find('.nav-desktop');
                    if(body.hasClass('home') && menuAIO.length){
                        heightItem  = menuAIO.height();
                        vmagicmenu.hover(
                            function() { heightAIO = menuAIO.height() ; menuAIO.addClass('over').css({"overflow": "", "height": 'auto', "display": ''}); }, 
                            function() { menuAIO.removeClass('over').css({"overflow": "hidden", "height": heightAIO}); }
                        );
                    }
                    $('<div class="fixed-height-sticky"></div>').insertBefore(fixedMenu).height(fixedMenu.height()).hide();
                    $(window).scroll(function () {
                        var postion = $(this).scrollTop();
                        if (postion > postionTop ){
                            fixedMenu.addClass('header-container-fixed').parent('.fixed-height-sticky').show();
                            if(heightItem && !menuAIO.hasClass('over')){
                                heightAIO = heightItem - (postion - postionTop) - menuHeight;
                                if(heightAIO > 0 )menuAIO.css({"height": heightAIO, "overflow": "hidden", "display": ''});
                                else{
                                    menuAIO.css({"height": 'auto', "display": 'none', "overflow": "" });
                                }
                            } else {
                                menuAIO.css({"height": 'auto', "display": '', "overflow": "" });
                            }
                        } else {
                            fixedMenu.removeClass('header-container-fixed').parent('.fixed-height-sticky').hide();
                            menuAIO.css({"height": 'auto'});
                        }
                    });
                },

                initMenu: function($navtop, fullWidth){
                    $navtop.each(function(index, val) {
                        var $item     = $(this);
                        if(fullWidth) $item.find('.level-top-mega').addClass('parent-full-width').wrap( '<div class="full-width"></div>' );
                        var options   = $item.data('options');
                        var $catMega = $item.find('.cat-mega');
                        var $children = $catMega.find('.children');
                        var columns   = $children.length;
                        var wchil     = $children.outerWidth();
                        if(options){
                            var col     = parseInt(options.cat_col);
                            if(!isNaN(col)) columns = col;
                            var cat         = parseFloat(options.cat_proportion);
                            var left        = parseFloat(options.left_proportion);
                            var right       = parseFloat(options.right_proportion);
                            if(isNaN(left)) left = 0; if(isNaN(right)) right = 0;
                            var proportion  = cat + left + right;
                            var wCat        = Math.ceil(100*cat/proportion);
                            var wLeft       = Math.floor(100*left/proportion);
                            var wRight      = Math.floor(100*right/proportion);
                            // Init Responsive
                            $catMega.width(wCat + '%');
                            $item.find('.mega-block-left').width(wLeft + '%');
                            $item.find('.mega-block-right').width(wRight + '%');
                            $children.each(function(idx) { if(idx % columns ==0 && idx != 0) $(this).css("clear", "both"); });
                            $item.attr({'data-wcat': wCat, 'data-wleft': wLeft,'data-wright': wRight });
                        } 

                    });
                },

                horizontal: function ($navtop, fullWidth, init) {
                    if(init) methods.initMenu($navtop, fullWidth);
                    var menuBox = $('.container');
                    var maxW      = fullWidth ? $('body').width() : menuBox.width();
                    var wMenuBox  = menuBox.width();
                    $navtop.hover(function(){
                        var $item       = $(this);
                        var options     = $item.data('options');
                        var $children   = $item.find('.cat-mega .children');
                        var columns     = $children.length;
                        var wChild      = $children.outerWidth(true);
                        var wMega       = wChild*columns;
                        if(options){
                            var col     = parseInt(options.cat_col);
                            if(!isNaN(col)) wMega = wChild*col;
                            var wCat    = $item.data('wcat');
                            var wLeft   = Math.ceil($item.data('wleft')*wMega/wCat);
                            var wRight  = Math.ceil($item.data('wright')*wMega/wCat);
                            if( wLeft || wRight ) wMega = wMega + wLeft + wRight;
                        }
                        if(wMega > maxW) wMega = Math.floor(maxW / wChild)*wChild;
                        $item.find('.content-mega-horizontal').width(wMega);
                        var topMega     = $item.find('.level-top-mega');
                        if(topMega.length){
                            var offsetMenuBox        = menuBox.offset();
                            var offsetMega           = $item.offset();
                            var xLeft                = wMenuBox - topMega.outerWidth(true);
                            var xLeft2               = offsetMega.left - offsetMenuBox.left;
                            if(xLeft > xLeft2) xLeft = xLeft2;
                            if(xLeft < 0)      xLeft = xLeft/2;
                            topMega.css('left',xLeft);                          
                        }
                    })
                },

                vertical: function ($navtop, fullWidth, init)  {
                    if(init) methods.initMenu($navtop, fullWidth);
                    var menuBox = $('.container');
                    var maxW    = menuBox.width();
                    $navtop.hover(function(){
                        var $item       = $(this);
                        var options     = $item.data('options');
                        var $children   = $item.find('.cat-mega .children');
                        var columns     = $children.length;
                        var wChild      = $children.outerWidth(true);
                        var topMega     = $item.find('.level-top-mega');
                        var wMega           = wChild*columns;
                        if(options){
                            var col     = parseInt(options.cat_col);
                            if(!isNaN(col)) wMega = wChild*col;
                            var wCat    = $item.data('wcat');
                            var wLeft   = Math.ceil($item.data('wleft')*wMega/wCat);
                            var wRight  = Math.ceil($item.data('wright')*wMega/wCat);
                            if( wLeft || wRight ) wMega = wMega + wLeft + wRight;
                        }
                        var wVmenu          = $navtop.closest(vSelector).outerWidth(true);
                        var wMageMax        = maxW- wVmenu - (topMega.outerWidth(true) - topMega.width());
                        if(wMega > wMageMax) wMega = Math.floor(wMageMax / wChild)*wChild;
                        var postionMega     = $item.position();
                        topMega.css('top', postionMega.top);
                        $item.find('.content-mega-horizontal').width(wMega);
                    })
                },

                toggleVertical: function ($vmenu) {
                    var catplus = $vmenu.find('li.level0:hidden').not('.all-cat');
                    var nav_hidden = $vmenu.find('.nav-desktop').is(":hidden"); 
                    $vmenu.find('.v-title').click(function() {
                        // $vmenu.find('.nav-desktop').parent().toggle();
                        $vmenu.find('.nav-desktop').slideToggle(400);
                        catplus = $vmenu.find('li.level0:hidden').not('.all-cat');
                    });

                    if(nav_hidden){
                        $vmenu.find('.v-title').hover(function() {
                            catplus = $vmenu.find('li.level0:hidden').not('.all-cat');
                            if(catplus.length) $vmenu.find('.all-cat').show();
                            else $vmenu.find('.all-cat').hide();
                        });
                    }

                    var catmore = $vmenu.find('.nav-desktop > .level0');
                    if(catplus.length) $vmenu.find('.all-cat').show().click(function(event) {$(this).children().toggle(); catplus.slideToggle('slow');});
                    // if(catplus.length) $vmenu.find('.all-cat').show().click(function(event) {$(this).children().toggle(); catmore.slideToggle('slow');});
                    else $vmenu.find('.all-cat').hide();
                }
            };

            if(methods[options]) { // $("#element").pluginName('methodName', 'arg1', 'arg2');
                return methods[options].apply(this, Array.prototype.slice.call(arguments, 1));
            } else if (typeof options === 'object' || !options) { // $("#element").pluginName({ option: 1, option:2 });
                return methods.init.apply(this);
            } else {
                $.error('Method "' + method + '" does not exist in timer plugin!');
            }
        }

    })(jQuery);

    $('.openNav').click(function(){
        $('body').addClass('nav-opencanvas');
        $("#mobileSidenav").addClass('opencanvas');
        // $("#container-main").addClass('opencanvas');
    })
    $('.nav-mobile-overlay-fixed').click(function(event){
        $('.sidenav .closebtn').trigger('click');
    })
    $('.sidenav .closebtn').click(function(){
        $('body').removeClass('nav-opencanvas');
        $("#mobileSidenav").removeClass('opencanvas');
        // $("#container-main").removeClass('opencanvas');
    }) 

    // For accordion
    $('.meanmenu-accordion').meanmenu({
        meanMenuContainer: ".accordion-container",
        // meanScreenWidth: "2000",
        removeElements:true,
        // meanMenuExpandTop: false,
        meanMenuResponsive: false,
    });
    // End For accordion

    // For Mobile
    $('.navigation-mobile').meanmenu({
        meanMenuContainer: "#mobileSidenav",
        meanMenuExpandTop: true,
        meanScreenWidth: "991",
        meanMenuResponsive: true,
        expandActive: false,
        removeElements:true,
    });

    // End for Mobile
    $(document).magicmenu();
});
