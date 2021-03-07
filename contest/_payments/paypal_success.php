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

		if($contest_id) {
			if(isset($_GET['ptype']) && $_GET['ptype'] == '2') {
				$pay_type = 3;
			} else {
				$pay_type = 1;
			}
		} else {
			$pay_type = 2;
		}

		$payment_id = mysqli_real_escape_string($db,$_GET['unid']);
	
		$prevPaymentResult = mysqli_query($db,"SELECT * FROM `payments` WHERE `txn_id` = '".$payment_id."'"); 
		if(mysqli_num_rows($prevPaymentResult)) { 

			$fetch_pp = mysqli_fetch_array($prevPaymentResult);

			$productResult = mysqli_query($db,"SELECT * FROM `payments_items` WHERE `id` = '".$fetch_pp['item_number']."' LIMIT 1"); 
			$productRow = mysqli_fetch_array($productResult);

			if($pay_type == 1 && $contest_id) {
				mysqli_query($db,"UPDATE `contest` SET `paid` = '1', `active` = '1' WHERE `id` = '".$contest_id."' LIMIT 1");
			}

			if($pay_type == 3 && $contest_id) {
				mysqli_query($db,"INSERT IGNORE INTO `contest_entry` (`contest_id`,`user_id`,`paid`) VALUES ('".$contest_id."','".$fetch_pp['userid']."','1')");
			}

			if($pay_type == 2 && $photo_id) {

				if(isset($settings['content_ratemode']) && $settings['content_ratemode'] == '1') {
					$rate_mode = 1;
				} else {
					$rate_mode = 5;
				}

				if($productRow['votes']) {
					for($i=1;$i<=$productRow['votes'];$i++) {
						mysqli_query($db,"INSERT INTO `ratings` (`iduser`,`rate`,`ip`,`photo_id`) VALUES ('0','".$rate_mode."','127.0.0.1','".$photo_id."')");
					}
				}

				$sql_count = mysqli_query($db,"SELECT SUM(rate) as 'rating', count(*) as 'total_ratings' FROM `ratings` WHERE `photo_id` = '".$photo_id."'");
				if(mysqli_num_rows($sql_count)) {
					$fetch_count = mysqli_fetch_array($sql_count);

					if(isset($settings['content_ratemode']) && $settings['content_ratemode'] == '1') {
						$total_ratings = $new_rating = $fetch_count['total_ratings'];
					}

					if(!isset($settings['content_ratemode']) || (isset($settings['content_ratemode']) && $settings['content_ratemode'] == '0')) {

						if($fetch_count['rating'] && $fetch_count['total_ratings']) {
							$new_rating = $fetch_count['rating'] / $fetch_count['total_ratings'];
							$total_ratings = $fetch_count['total_ratings'];
							if(strlen($new_rating) == 1) { $new_rating = $new_rating.'.00'; }
							if(strlen($new_rating) == 3) { $new_rating = $new_rating.'0'; }
							if(strlen($new_rating) > 4) { $new_rating = substr($new_rating,0,4); }
						} else {
							$new_rating = '0.00';
							$total_ratings = 0;
						}
			
					}

					$sql_photo = mysqli_query($db,"SELECT * FROM `content` WHERE `id` = '".$photo_id."' LIMIT 1");
					$fetch_photo = mysqli_fetch_array($sql_photo);

					$views_plus = $fetch_photo['views'] + $productRow['views'];
					mysqli_query($db,"UPDATE `content` SET `views` = '".$views_plus."', `nr_ratings` = '".$total_ratings."', `rating` = '".$new_rating."' WHERE `id` = '".$photo_id."' LIMIT 1");
				}

			}

			$insert = mysqli_query($db,"UPDATE `payments` SET `payment_status` = 'Paid' WHERE `payment_id` = '".$fetch_pp['payment_id']."' LIMIT 1"); 
			$payment_id = $fetch_pp['payment_id']; 

		} 

		if($photo_id && $pay_type == 2) {
			header('location: '.$settings['site_url'].'index.php?payment='.(isset($payment_id) ? 'success':'failed').'&photo='.$photo_id);
		} else {	
			if($contest_id && ($pay_type == 1 || $pay_type == 3)) {
				header('location: '.$settings['site_url'].'index.php?payment='.(isset($payment_id) ? 'success':'failed').'&contest='.$contest_id);
			} else {
				header('location: '.$settings['site_url'].'index.php?payment='.(isset($payment_id) ? 'success':'failed'));
			}
		}

	} else {

		header('location: '.$settings['site_url']);
	}
?>