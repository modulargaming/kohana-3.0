$(function() {
	
	$("a").tooltip({
		bodyHandler: function() {
			return $(this).parent().find( 'div' ).html()
		},
		showURL: false
	});
	
});

$(document).ready(function(){
	
	
});