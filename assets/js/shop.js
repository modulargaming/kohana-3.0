$(document).ready(function(){
	
	$('.items .item a').tooltip({
		bodyHandler: function() {
			return $(this).parent().find( 'div' ).html();
		},
		showURL: false,
		track: true
	});
	
	$('.items .item a').click(function() {
		
		var div = $(this).parent().find( 'div' );
		var title = div.find('h3').html();
		var amount = div.find('.amount').html();
		var price = div.find('.price').html();
		var description = div.find('.description').html();
		
		var html = '<p class="desc">'
		html += description;
		html += '</p>';
		
		html += '<ul>';
		html += '<li>Price: <span class="price">0</span></li>';
		html += '<li>Amount: <input type="text" name="amount" value="0" /></li>';
		html += '</ul>';
		
		html += '<div class="amount"></div>';
		
		$( '<div/>', {
			title: title,
			html: html
		}).dialog({
			modal: true,
			resizable: false,
			buttons: {
				Buy: function() {
					// Tell the server we wants to buy the item.
					$.post("test.php", { item: "John", time: "2pm" },
					function(data){
							
					});

					
					$(this).dialog('close');
				},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
		
		var slider = $('div.amount').slider({
			min: 0,
			max: amount,
			slide: function(event, ui) {
				$(this).parent().find('input[name="amount"]').val(ui.value);
				$(this).parent().find('span.price').text(ui.value * price);
			}
		});
		
		return false;
	});

	
});