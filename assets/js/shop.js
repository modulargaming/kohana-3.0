$(document).ready(function(){
	
	$("a").tooltip({
		bodyHandler: function() {
			return $(this).parent().find( 'div' ).html();
		},
		showURL: false,
		track: true
	});
	
	$('.items .item a').click(function() {
		$('#buy-form').dialog('open');
		return false;
	});
	
	$("#buy-form").dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		buttons: {
			'Buy': function() {
				
				allFields.removeClass('ui-state-error');
				
				
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		},
		close: function() {
			allFields.val('').removeClass('ui-state-error');
		}
	});

	
});