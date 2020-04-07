(function($){
"use strict";

	// key press event
	$(document).ready(function(){

		$('.woovator_widget_psa input').keyup( function(e) {
			var $this = $(this);
		    clearTimeout( $.data( this, 'timer' ) );
		    if ( e.keyCode == 13 ){
		    	doSearch( $this );
		    } else {
		    	doSearch( $this );
		    	$(this).data( 'timer', setTimeout( doSearch, 100 ) );
		    }
		});

		$('.woovator_widget_psa_clear_icon').on('click', function(){
			$(this).siblings('#woovator_psa_results_wrapper').html('');
			$(this).parents('.woovator_widget_psa').removeClass('woovator_widget_psa_clear');
			$(this).siblings('input[type="search"]').val('');
		});

	});

	function doSearch( $this = '' ) {

		if ( $this.length > 0 ) {
		    var searchString = $this.val();
		    if( searchString == '' ){
		    	$this.siblings('#woovator_psa_results_wrapper').html('');
		    	$this.parents('.woovator_widget_psa').removeClass('woovator_widget_psa_clear');
		    }
		    if ( searchString.length < 2 ) return; //wasn't enter, not > 2 char
		    var wrapper_width = $this.parents('.woovator_widget_psa').width(),
		    settings	= $this.parents('.woovator_widget_psa form').data('settings'),
		    limit	=	settings.limit ? parseInt(settings.limit) : 10;

		    $.ajax({
		    	url: woovator_addons.woovatorajaxurl,
		    	data: {
		    		'action': 'woovator_ajax_search',
		    		's': searchString,
		    		'limit': limit,
		    		'nonce': woovator_addons.ajax_nonce
		    	},
		    	beforeSend:function(){
		    		$this.parents('.woovator_widget_psa').addClass('woovator_widget_psa_loading');
		    	},
		    	success:function(response) {
		    		$this.siblings('#woovator_psa_results_wrapper').css({'width': wrapper_width});
		    		$this.siblings('#woovator_psa_results_wrapper').html(response);
		    		$this.parents('.woovator_widget_psa').removeClass('woovator_widget_psa_loading');

		    		// nice scroll
		    		$(".woovator_psa_inner_wrapper").niceScroll({cursorborder:"",cursorcolor:"#666"});
		    	},
		    	error: function(errorThrown){
		    	    console.log(errorThrown);
		    	}
		    }).done(function(response){
		    	$this.parents('.woovator_widget_psa').addClass('woovator_widget_psa_clear');
		    });
		}
		
	}

})(jQuery);