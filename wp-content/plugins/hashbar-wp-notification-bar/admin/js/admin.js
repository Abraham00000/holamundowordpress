(function($) {
    "use strict";

    $( document ).ready(function() {

        $('#_wphash_themes_header_type,#_wphash_notification_transparent_selector, .pro, [name="_wphash_notification_schedule"],#_wphash_notification_schedule_datetime_date,#_wphash_notification_schedule_datetime_time,#_wphash_notification_where_to_show3, #_wphash_notification_where_to_show4').attr("disabled", true);

        // Pro Pop Up Notice
        $( 'span.pro,.cmb-th label span' ).click(function() {
         	$( "#ht_dialog" ).dialog({
         		modal: true,
         		minWidth: 500,
         		buttons: {
                    Ok: function() {
                      $( this ).dialog( "close" );
                    }
                }
         	});
        });
        
    });

})(jQuery);