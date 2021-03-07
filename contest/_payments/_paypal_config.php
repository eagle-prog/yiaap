<?php
	define('PAYPAL_ID',(isset($settings['paypal_email']) && $settings['paypal_email'] != '' ? $settings['paypal_email'] : ''));
 	define('PAYPAL_SANDBOX', FALSE);
 	define('PAYPAL_RETURN_URL', $settings['site_url'].'_payments/paypal_success.php'); 
 	define('PAYPAL_CANCEL_URL', $settings['site_url'].'_payments/paypal_cancel.php'); 
 	define('PAYPAL_CURRENCY', (isset($settings['paypal_currency']) && $settings['paypal_currency'] != '' ? $settings['paypal_currency'] : 'USD')); 
	define('PAYPAL_URL', (PAYPAL_SANDBOX == true)?"https://www.sandbox.paypal.com/cgi-bin/webscr":"https://www.paypal.com/cgi-bin/webscr");
?>