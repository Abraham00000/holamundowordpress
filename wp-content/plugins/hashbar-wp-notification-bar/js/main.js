(function ($) {
    "use strict";

$( document ).ready(function() {

/*-- Notification --*/
var $body = $('body');
var $window = $(window);

/*-- Notification --*/
var $notificationSection = $('.ht-notification-section');
    
/*-- Notification Height --*/
var $notiTopHeight = $('.ht-notification-section.ht-n-top').height();
var $notiBottomHeight = $('.ht-notification-section.ht-n-bottom').height();
    
/*-- Open & Close Button --*/
var $openToggle = $('.ht-n-open-toggle');
var $closeToggle = $('.ht-n-close-toggle');

    
/*-- Body Padding For Default Open Notification --*/
if($notificationSection.hasClass('ht-n-top ht-n-open')) {
    
    $body.css('padding-top', $notiTopHeight);
    $body.addClass( 'htnotification-mobile' );
    
}
if( $notificationSection.hasClass('ht-n-bottom ht-n-open') ) {
    
    $body.css('padding-bottom', $notiBottomHeight);
    $body.addClass( 'htnotification-mobile' );
    
}
    
/*-- Body Padding For Default Closed Notification --*/
if( $notificationSection.hasClass('ht-n-top ht-n-close')) {
    
   $body.css('padding-top', '0px');
    
}
if( $notificationSection.hasClass('ht-n-bottom ht-n-close')) {
    
    $body.css('padding-bottom', '0px');
    
}
    
/*-- Closed Notification Open Icon Active Class --*/
if( $notificationSection.hasClass('ht-n-close') ) {
    
   $('.ht-n-close').find('.ht-n-open-toggle').addClass('ht-n-active');
    
}
 
    
/*-- Closed Notification --*/
if( $notificationSection.hasClass('ht-n-top ht-n-close') ) {
    
   $('.ht-n-top.ht-n-close').find('.ht-notification-wrap').slideUp();
    
}
if( $notificationSection.hasClass('ht-n-bottom ht-n-close') ) {
    
   $('.ht-n-bottom.ht-n-close').find('.ht-notification-wrap').slideUp();
    
}


/*-- left and right notification  --*/
var nLeftSection = $('.ht-n-left');
var nLeftSectionWidth = nLeftSection.width();
var nRightSection = $('.ht-n-right');
var nRightSectionWidth = nRightSection.width();

if( nLeftSection.hasClass('ht-n-close') ) {
    
   nLeftSection.css({
    'left': -1 * nLeftSectionWidth + 'px',
   });
    
}
if( nRightSection.hasClass('ht-n-close') ) {
    
   nRightSection.css({
    'right': -1 * nRightSectionWidth + 'px',
   });
    
}


/*-- Notification Close Function --*/
$closeToggle.on('click', function(e){
    e.preventDefault();
    
    var nSection = $(this).parents('.ht-notification-buttons').parents('.ht-notification-wrap').parents('.ht-notification-section');
    var nSectionWidth = nSection.width();
    
    /* Open Toggle */
    nSection.find('.ht-n-open-toggle').addClass('ht-n-active');

    /* Top, Bottom, Left & Right Animation */
    if( nSection.hasClass('ht-n-top') ){
        
        nSection.removeClass('ht-n-open').addClass('ht-n-close');
        nSection.find('.ht-notification-wrap').slideToggle();
        $body.css('padding-top', '0px');
        
    }else if( nSection.hasClass('ht-n-bottom') ){
        
        nSection.removeClass('ht-n-open').addClass('ht-n-close');
        nSection.find('.ht-notification-wrap').slideToggle();
        $body.css('padding-bottom', '0px');
        
    }else if( nSection.hasClass('ht-n-left') ){
        
        nSection.removeClass('ht-n-open').addClass('ht-n-close');
        nSection.css({
            'left' : -1 * nSectionWidth + 'px',
        });
        
    }else if( nSection.hasClass('ht-n-right') ){
        
        nSection.removeClass('ht-n-open').addClass('ht-n-close');
        nSection.css({
            'right' : -1 * nSectionWidth + 'px',
        });
        
    }
    
});

/*-- Notification Open Function --*/
$openToggle.on('click', function(e){
    e.preventDefault();
    
    var nSection = $(this).parents('.ht-notification-section');
    
    /* Open Toggle */
    nSection.find('.ht-n-open-toggle').removeClass('ht-n-active');

    /* Top, Bottom, Left & Right Animation */
    if( nSection.hasClass('ht-n-top') ){
        
        nSection.removeClass('ht-n-close').addClass('ht-n-open');
        nSection.find('.ht-notification-wrap').slideToggle();
        $body.css('padding-top', $notiTopHeight);
        
    }else if( nSection.hasClass('ht-n-bottom') ){
        
        nSection.removeClass('ht-n-close').addClass('ht-n-open');
        nSection.find('.ht-notification-wrap').slideToggle();
        $body.css('padding-bottom', $notiBottomHeight);
        
    }else if( nSection.hasClass('ht-n-left') ){
        
        nSection.removeClass('ht-n-close').addClass('ht-n-open');
        nSection.css('left', '0px');
        nSection.find('.ht-notification-wrap').show();
        
    }else if( nSection.hasClass('ht-n-right') ){
        
        nSection.removeClass('ht-n-close').addClass('ht-n-open');
        nSection.css('right', '0px');
        nSection.find('.ht-notification-wrap').show();
        
    }
    
});

$window.on('scroll', function() {
    var $scroll = $window.scrollTop();
    
    if ( $scroll > 400 && $notificationSection.hasClass('ht-n-close ht-n-scroll ht-n-top') ) {
        
        var topSection = $('.ht-n-top.ht-n-scroll');
        /* Open Toggle */
        topSection.find('.ht-n-open-toggle').removeClass('ht-n-active');
        topSection.removeClass('ht-n-close ht-n-scroll').addClass('ht-n-open');
        topSection.find('.ht-notification-wrap').slideDown();
        topSection.parents('body').css('padding-top', $notiTopHeight);
        
    }
    
    if ( $scroll > 800 && $notificationSection.hasClass('ht-n-close ht-n-scroll ht-n-bottom') ) {
        
        var bottomSection = $('.ht-n-bottom.ht-n-scroll');
        /* Open Toggle */
        bottomSection.find('.ht-n-open-toggle').removeClass('ht-n-active');
        bottomSection.removeClass('ht-n-close ht-n-scroll').addClass('ht-n-open');
        bottomSection.find('.ht-notification-wrap').slideDown();
        bottomSection.parents('body').css('padding-bottom', $notiBottomHeight);
        
    }
    
    if ( $scroll > 1200 && $notificationSection.hasClass('ht-n-close ht-n-scroll ht-n-left') ) {
        
        var leftSection = $('.ht-n-left.ht-n-scroll');
        /* Open Toggle */
        leftSection.find('.ht-n-open-toggle').removeClass('ht-n-active');
        leftSection.removeClass('ht-n-close ht-n-scroll').addClass('ht-n-open');
        leftSection.css('left', '0px');
        leftSection.find('.ht-notification-wrap').show();
      
    }
    
    if ( $scroll > 1600 && $notificationSection.hasClass('ht-n-close ht-n-scroll ht-n-right') ) {
        
        var rightSection = $('.ht-n-right.ht-n-scroll');
        /* Open Toggle */
        rightSection.find('.ht-n-open-toggle').removeClass('ht-n-active');
        rightSection.removeClass('ht-n-close ht-n-scroll').addClass('ht-n-open');
        rightSection.css('right', '0px');
        rightSection.find('.ht-notification-wrap').show();
        
    }
    
});

});


})(jQuery);