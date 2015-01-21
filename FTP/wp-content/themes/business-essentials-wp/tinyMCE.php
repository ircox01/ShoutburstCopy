<?php

add_action('admin_head', 'add_custom_buttons');
function add_custom_buttons() { 
wp_print_scripts( 'quicktags'); ?>
		
<script type='text/javascript'>
	
		
		edButtons[edButtons.length] = new edButton('tws_quote',
		
			'Quote',
			'[quote] ',
			' [/quote] ',
			''
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_hr',
		
			'HR',
			'[hr] ',
			''
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_intro',
		
			'Intro Text',
			'[intro] ',
			'[/intro]'
		
		);
				
		edButtons[edButtons.length] = new edButton('tws_pullquoteleft',
		
			'Quote Left',
			'[pullquoteleft] ',
			'[/pullquoteleft]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_pullquoteright',
		
			'Quote Right',
			'[pullquoteright] ',
			'[/pullquoteright]'
		
		);
			
		
		edButtons[edButtons.length] = new edButton('tws_alert_green',
		
			'Alert Green',
			'[alert_green] ',
			'[/alert_green]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_alert_red',
		
			'Alert Red',
			'[alert_red] ',
			'[/alert_red]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_alert_blue',
		
			'Alert Blue',
			'[alert_blue] ',
			'[/alert_blue]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_alert_yellow',
		
			'Alert Yellow',
			'[alert_yellow] ',
			'[/alert_yellow]'
		
		);
		
		
		edButtons[edButtons.length] = new edButton('tws_one_half_first',
		
			'1/2 First',
			'[one_half_first] ',
			'[/one_half_first]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_one_half',
		
			'1/2',
			'[one_half] ',
			'[/one_half]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_one_third_first',
		
			'1/3 First',
			'[one_third_first] ',
			'[/one_third_first]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_one_third',
		
			'1/3',
			'[one_third] ',
			'[/one_third]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_one_fourth_first',
		
			'1/4 First',
			'[one_fourth_first] ',
			'[/one_fourth_first]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_one_fourth',
		
			'1/4',
			'[one_fourth] ',
			'[/one_fourth]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_one_fifth_first',
		
			'1/5 First',
			'[one_fifth_first] ',
			'[/one_fifth_first]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_one_fifth',
		
			'1/5',
			'[one_fifth] ',
			'[/one_fifth]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_one_sixth_first',
		
			'1/6 First',
			'[one_sixth_first] ',
			'[/one_sixth_first]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_one_sixth',
		
			'1/6',
			'[one_sixth] ',
			'[/one_sixth]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_two_third_first',
		
			'2/3 First',
			'[two_third_first] ',
			'[/two_third_first]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_two_third',
		
			'2/3',
			'[two_third] ',
			'[/two_third]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_three_fourth_first',
		
			'3/4 First',
			'[three_fourth_first] ',
			'[/three_fourth_first]'
		
		);
				
		edButtons[edButtons.length] = new edButton('tws_three_fourth',
		
			'3/4',
			'[three_fourth] ',
			'[/three_fourth]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_two_fifth_first',
		
			'2/5 First',
			'[two_fifth_first] ',
			'[/two_fifth_first]'
		
		);
				
		edButtons[edButtons.length] = new edButton('tws_two_fifth',
		
			'2/5',
			'[two_fifth] ',
			'[/two_fifth]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_three_fifth_first',
		
			'3/5 First',
			'[three_fifth_first] ',
			'[/three_fifth_first]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_three_fifth',
		
			'3/5',
			'[three_fifth] ',
			'[/three_fifth]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_four_fifth_first',
		
			'4/5 First',
			'[four_fifth_first] ',
			'[/four_fifth_first]'
		
		);
			
		edButtons[edButtons.length] = new edButton('tws_four_fifth',
		
			'4/5',
			'[four_fifth] ',
			'[/four_fifth]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_button_red',
		
			'Red Button',
			'[button_red] ',
			'[/button_red]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_button_green',
		
			'Green Button',
			'[button_green] ',
			'[/button_green]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_button_blue',
		
			'Blue Button',
			'[button_blue] ',
			'[/button_blue]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_button_red_image',
		
			'Red Image Button',
			'[button_red_image] ',
			'[/button_red_image]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_button_green_image',
		
			'Green Image Button',
			'[button_green_image] ',
			'[/button_green_image]'
		
		);
		
		edButtons[edButtons.length] = new edButton('tws_button_blue_image',
		
			'Blue Image Button',
			'[button_blue_image] ',
			'[/button_blue_image]'
		
		);

	</script>
<?php }	

?>