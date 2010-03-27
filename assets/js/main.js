
$(function() {
	
	
	$('li.login a').click(function() {
		
		var dialog = $( '#login-dialog' ).dialog({
			modal: true,
			resizable: false,
			width: 320,
			close: function() {
				// Reset the errors
				$(this).find('ul.errors').html('');
			},
			buttons: {
				Login: function() {
					
					var dialog = this;
					var form = $(this).find('input');
					
					$.post( path+'account/login', form.serialize(), function(json){  
						
						// If we returns 1, the login was sucessful, redirect the user to homepage.
						if ( json == '1' ) {
							window.location = path;
						} else {
							
							// Output the errors
							var raw_errors = eval( "(" + json + ")" );
							var errors = [];
							
							for (var i in raw_errors) {
								errors += '<li>'+raw_errors[i]+'</li>';
							}
							
							$(dialog).find('ul.errors').html( errors );
							
						}
						
					});  
				},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
		
		// Submit the dialog form when pressing enter.
		$('#login-dialog').find('input').keypress(function(e) {
			if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
				$(this).parents('div.ui-dialog').find('.ui-dialog-buttonpane').find('button:first').click();
				return false;
			}
		});
		
		return false; // Disable the link.
	});
	
	
	
	
	
	
	// Autocomplete for reciver in pm.
	$('#new_pm input[name=to]').autocomplete({
		source: function(request, response) {
			$.ajax({
				url: path+'pm/reciver/'+request.term,
				dataType: 'json',
				success: function(data) {
					response(data);
				}
			});
		},
		minLength: 2
	});
	
	
	
	
});


$(document).ready(function(){
	


	
});