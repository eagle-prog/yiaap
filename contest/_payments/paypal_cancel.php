<?php
	include_once '../_core/_config.php';
	include_once '../_core/_functions.php'; 

	$settings = get_settings();
	include_once '_paypal_config.php';

	if(isset($_GET['unid']) && $_GET['unid'] != ''){ 
	
		if(isset($_GET['contest_id']) && is_numeric($_GET['contest_id'])) {
			$contest_id = mysqli_real_escape_string($db,$_GET['contest_id']);
		} else {
			$contest_id = 0;
		}

		if(isset($_GET['photo_id']) && is_numeric($_GET['photo_id'])) {
			$photo_id = mysqli_real_escape_string($db,$_GET['photo_id']);
		} else {
			$photo_id = 0;
		}

		$payment_id = mysqli_real_escape_string($db,$_GET['unid']);
	
		$prevPaymentResult = mysqli_query($db,"SELECT * FROM `payments` WHERE `txn_id` = '".$payment_id."'"); 
		if(mysqli_num_rows($prevPaymentResult)) { 

			$fetch_pp = mysqli_fetch_array($prevPaymentResult);

			$insert = mysqli_query($db,"UPDATE `payments` SET `payment_status` = 'Canceled' WHERE `payment_id` = '".$fetch_pp['payment_id']."' LIMIT 1"); 
			$payment_id = $fetch_pp['payment_id']; 

		} 

		if($photo_id) {
			header('location: '.$settings['site_url'].'index.php?payment=cancel&photo='.$photo_id);
		} else {
			if($contest_id) { 
				header('location: '.$settings['site_url'].'index.php?payment=cancel&contest_id='.$contest_id);
			} else {
				header('location: '.$settings['site_url'].'index.php?payment=cancel');
			}
		}

	} else {

		header('location: '.$settings['site_url']);
	}
?>