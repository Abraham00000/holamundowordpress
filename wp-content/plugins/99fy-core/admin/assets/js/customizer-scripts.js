(function($){
  "use strict";

    $(window).load(function() {
        
        /*
        * Header Layout Conditional Field
        * On Change Value and default value
        */
        // Default Value
        if( nnfy.header_layout == 'one' ){
            $('#customize-control-nnfy_logo_position').show();
        }else{
           $('#customize-control-nnfy_logo_position').hide(); 
        }

        // Top Bar
        if( nnfy.header_layout == 'four' ){
            $('#customize-control-nnfy_topbar_left,#customize-control-nnfy_topbar_status').hide();
        }else{
            $('#customize-control-nnfy_topbar_left,#customize-control-nnfy_topbar_status').show();
        }

        // After On Change Value
        $('#_customize-input-nnfy_header_layout').on('change', function() {
            // Logo Position Conditionaly
            if( this.value == 'one' ){
                $('#customize-control-nnfy_logo_position').show();
            }else{
                $('#customize-control-nnfy_logo_position').hide();
            }
            // Top Bar Enable / Disable
            if( this.value == 'four' ){
                $('#customize-control-nnfy_topbar_left,#customize-control-nnfy_topbar_status').hide();
            }else{
                $('#customize-control-nnfy_topbar_left,#customize-control-nnfy_topbar_status').show();
            }
        });

        /*
        * Footer Layout Conditional Field
        * On Change Value and default value
        */
        // Default Value save
        if( nnfy.footer_layout == 'one' ){
            $('#customize-control-nnfy_footer_aboutinfo').show();
        }else{
            $('#customize-control-nnfy_footer_aboutinfo').hide();
        }

        // Address and Contact info field
        if( nnfy.footer_layout == 'two' ){
            $('#customize-control-nnfy_footer_contact_info,#customize-control-nnfy_footer_address').show();
        }else{
            $('#customize-control-nnfy_footer_contact_info,#customize-control-nnfy_footer_address').hide();
        }

        //Logo field
        if( nnfy.footer_layout == 'three' ){
            $('#customize-control-nnfy_footer_logo').hide();
            $('#customize-control-nnfy_footer_payment_icon').show();
            $('#customize-control-nnfy_footer_menu').show();
        }else{
            if(  nnfy.footer_layout == 'four' ){
                $('#customize-control-nnfy_footer_logo').hide();
            }else{
                $('#customize-control-nnfy_footer_logo').show();
            }
            $('#customize-control-nnfy_footer_payment_icon').hide();
            if( nnfy.footer_layout == 'five' ){
                $('#customize-control-nnfy_footer_menu').show();
                $('#customize-control-nnfy_footer_payment_icon').show();
            }else{
                $('#customize-control-nnfy_footer_menu').hide();
                $('#customize-control-nnfy_footer_payment_icon').hide();
            }
        }

        /*
        * Footer Layout Conditional Field
        * After On Change
        */
        $('#_customize-input-nnfy_footer_layout').on('change', function() {
            
            // About Info Field
            if( this.value == 'one' ){
                $('#customize-control-nnfy_footer_aboutinfo').show();
            }else{
                $('#customize-control-nnfy_footer_aboutinfo').hide();
            }
            
            // Address and Contact info field
            if( this.value == 'two' ){
                $('#customize-control-nnfy_footer_contact_info,#customize-control-nnfy_footer_address').show();
            }else{
                $('#customize-control-nnfy_footer_contact_info,#customize-control-nnfy_footer_address').hide();
            }

            // Footer Logo field
            if( this.value == 'three' ){
                $('#customize-control-nnfy_footer_logo').hide();
                $('#customize-control-nnfy_footer_payment_icon').show();
                $('#customize-control-nnfy_footer_menu').show();
            }else{
                if( this.value == 'four' ){
                    $('#customize-control-nnfy_footer_logo').hide();
                }else{
                    $('#customize-control-nnfy_footer_logo').show();
                }
                if( this.value == 'five' ){
                    $('#customize-control-nnfy_footer_menu').show();
                    $('#customize-control-nnfy_footer_payment_icon').show();
                }else{
                    $('#customize-control-nnfy_footer_menu').hide();
                    $('#customize-control-nnfy_footer_payment_icon').hide();
                }
            }

        });

        /*
        * Page breadcrumb content cutom postion
        */
        // Page title Position
        if( nnfy.custom_pos == 'yes' ){
            $('#customize-control-nnfy_page_title_x_position,#customize-control-nnfy_page_title_y_position').show();
        }else{
            $('#customize-control-nnfy_page_title_x_position,#customize-control-nnfy_page_title_y_position').hide();
        }

        $('#_customize-input-nnfy_page_title_custom_postion').on('change', function() {
            if( this.value == 'yes' ){
                $('#customize-control-nnfy_page_title_x_position,#customize-control-nnfy_page_title_y_position').show();
            }else{
                $('#customize-control-nnfy_page_title_x_position,#customize-control-nnfy_page_title_y_position').hide();
            }
        });

        // Pro Element Dialog Notice
        $( "ul.control-section li select[id^='_customize-input-nnfy_nnfy_'],ul.control-section li input[id^='_customize-input-nnfy_nnfy_'],ul.control-section li[id^='customize-control-nnfy_nnfy_'] .tgl-light,ul.control-section li[id^='customize-control-nnfy_nnfy_'] .range-slider__range" ).attr('disabled', true);

        var porupnotice = '<div id="nnfy-pro-dialog" style="display: none;"><div class="nnfydialog-content"><span class="nnfy-dialogclose"><i class="dashicons dashicons-no-alt"></i></span><span><i class="dashicons dashicons-warning"></i></span><p>Purchase our <a href="https://bit.ly/2SbjVPh" target="_blank" rel="nofollow">premium version</a> to unlock these pro feature!</p></div></div>';
        $("form#customize-controls").append( porupnotice );

        $( "ul.control-section li[id^='customize-control-nnfy_nnfy_']" ).on('click', function() {
            $( "#nnfy-pro-dialog" ).show();
        });

        // Close Notice
        $(".nnfy-dialogclose").on('click',function(){
            $( "#nnfy-pro-dialog" ).hide();
        });

        //check pro plugin install or not

        if( nnfy.check_pro_plugin === '' ){

            $('#_customize-input-nnfy_footer_copyright_brand').prop('disabled', true);
        }

        //hide custom image heigt width field on window load

        if( nnfy.image_size_type === 'custom' ){

            $('#customize-control-nnfy_blog_image_height').show();
            $('#customize-control-nnfy_blog_image_width').show();

        }else{

            $('#customize-control-nnfy_blog_image_height').hide();
            $('#customize-control-nnfy_blog_image_width').hide();
            
        }

        //on select custom image size effect
        $('#_customize-input-nnfy_blog_img_size').on('change', function() {

            var img_val = $(this).val();

            if(img_val === 'custom'){

                $('#customize-control-nnfy_blog_image_height').slideDown();
                $('#customize-control-nnfy_blog_image_width').slideDown();

            }else{

                $('#customize-control-nnfy_blog_image_height').slideUp();
                $('#customize-control-nnfy_blog_image_width').slideUp();

            }

        });



    });
  
})(jQuery);