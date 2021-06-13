(function($){
"use strict";

    function slickRowActive(){
        
        $('.htinstagram-carousel').each(function(){
            var $this = $(this);
            var settings = $this.data('settings');
            var arrows = settings['arrows'];
            var arrow_prev_txt = settings['arrow_prev_txt'];
            var arrow_next_txt = settings['arrow_next_txt'];
            var dots = settings['dots'];
            var autoplay = settings['autoplay'];
            var autoplay_speed = parseInt(settings['autoplay_speed']) || 3000;
            var animation_speed = parseInt(settings['animation_speed']) || 300;
            var center_mode = settings['center_mode'];
            var center_padding = parseInt(settings['center_padding']) || 50;
            var center_padding = center_padding.toString();
            var rows = parseInt(settings['rows']) || 1;
            var display_columns = parseInt(settings['display_columns']) || 1;
            var scroll_columns = parseInt(settings['scroll_columns']) || 1;
            var tablet_width = parseInt(settings['tablet_width']) || 800;
            var tablet_display_columns = parseInt(settings['tablet_display_columns']) || 1;
            var tablet_scroll_columns = parseInt( settings['tablet_scroll_columns'] ) || 1;
            var mobile_width = parseInt(settings['mobile_width']) || 480;
            var mobile_display_columns = parseInt(settings['mobile_display_columns']) || 1;
            var mobile_scroll_columns = parseInt(settings['mobile_scroll_columns']) || 1;

            $this.slick({
                arrows: arrows,
                prevArrow: '<button type="button" class="ht-arrow ht-prev">'+arrow_prev_txt+'</button>',
                nextArrow: '<button type="button" class="ht-arrow ht-next">'+arrow_next_txt+'</button>',
                dots: dots,
                infinite: true,
                autoplay: autoplay,
                autoplaySpeed: autoplay_speed,
                speed: animation_speed,
                fade: false,
                slidesToShow: display_columns,
                slidesToScroll: scroll_columns,
                rows: rows,
                centerMode: center_mode,
                centerPadding: center_padding,
                responsive: [
                    {
                        breakpoint: tablet_width,
                        settings: {
                            slidesToShow: tablet_display_columns,
                            slidesToScroll: tablet_scroll_columns
                        }
                    },
                    {
                        breakpoint: mobile_width,
                        settings: {
                            slidesToShow: mobile_display_columns,
                            slidesToScroll: mobile_scroll_columns
                        }
                    }
                ]
            });

        });
    };
    slickRowActive();



})(jQuery);