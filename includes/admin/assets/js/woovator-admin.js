(function($){
"use strict";

    // Tab Menu
    function woovator_admin_tabs( $tabmenus, $tabpane ){
        $tabmenus.on('click', 'a', function(e){
            e.preventDefault();
            var $this = $(this),
                $target = $this.attr('href');
            $this.addClass('wvactive').parent().siblings().children('a').removeClass('wvactive');
            $( $tabpane + $target ).addClass('wvactive').siblings().removeClass('wvactive');
        });
    }
    woovator_admin_tabs( $(".woovator-admin-tabs"), '.woovator-admin-tab-pane' );

    var contenttypeval = admin_wvlocalize_data.contenttype;
    if( contenttypeval == 'fakes' ){
        $(".notification_fake").show();
        $(".notification_real").hide();
    }else{
        $(".notification_fake").hide();
        $(".notification_real").show();
    }
    // When Change radio button
    $(".notification_content_type .radio").on('change',function(){
        if( $(this).is(":checked") ){
            contenttypeval = $(this).val();
        }
        if( contenttypeval == 'fakes' ){
            $(".notification_fake").show();
            $(".notification_real").hide();
        }else{
            $(".notification_fake").hide();
            $(".notification_real").show();
        }
    });
    
})(jQuery);