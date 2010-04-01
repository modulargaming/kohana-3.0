$(document).ready(function(){
	$(".register").validate({
		
		rules: {
			username: {
				required: true,
				minlength: 3,
				maxlength: 20
			},
			
			email: {
				required: true,
				email: true
			},
			email_confirm: {
				required: true,
				equalTo: "input[name$='email']"
			},
			
			password: {
				required: true,
				minlength: 6,
				maxlength: 20
			},
			password_confirm: {
				required: true,
				equalTo: "input[name$='password']"
			},
			
			captcha: {
				required: true
			}
		},
		
		messages: {
			username: {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 3 characters",
				maxlength: "Your username must consist of less then 20 characters"
			},
			email: {
				required: "Please enter an email",
			}
		}

	});
});
