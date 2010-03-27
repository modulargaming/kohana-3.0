
$(function() {
	
	
	$('li.login a').click(function() {
		
		$( '#login-dialog' ).dialog({
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
		
		return false; // Disable the link.
	});
	
});


$(document).ready(function(){
	


	
});