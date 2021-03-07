<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Razorpay\Api\Api;
session_start();

	require_once('_functions.php');
	
	$settings = get_settings();

	if(!isset($settings['min_votes'])) {
		$settings['min_votes'] = 0;
	}

	$return = array('error'=>1,'error_text'=>_LANG_ERROR_DEFAULT);

	if(!isset($_POST['reason'])) {
		echo json_encode($return);
		die();
	} else {
		$reason = mysqli_real_escape_string($db,$_POST['reason']);
	}

	if($reason == 'submit_youtube' && isset($_SESSION['_logged_id']) && isset($_POST['youtube_url']) && $_POST['youtube_url'] != '') {

		$youtube_url = $_POST['youtube_url'];
		if(get_youtube_id($youtube_url)) {

			$settings = get_settings();
			if($settings['photo_approval'] == '1') {
				$approved = 0;
			} else {
				$approved = 1;
			}

			$sql_ci = mysqli_query($db,"SELECT * FROM `contest` WHERE `active` = '1' AND `end` > NOW() LIMIT 2");
			if(mysqli_num_rows($sql_ci) == '1') {
				$fetch_ci = mysqli_fetch_array($sql_ci);
				$contest_id = $fetch_ci['id'];
			} else {
				$contest_id = 0;
			}

			if(isset($_POST['content_category_id']) && is_numeric($_POST['content_category_id']) && $_POST['content_category_id'] != '0') {
				$get_user_category = mysqli_real_escape_string($db,$_POST['content_category_id']);
			} else {
				$get_user_category = get_logged_user_category();
			}

			$uni_id = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVXYZ"), 0, 20);
			$ytid = get_youtube_id($youtube_url);
			$youtube_img = 'https://img.youtube.com/vi/'.$ytid.'/maxresdefault.jpg';
			copy($youtube_img,'../_uploads/_content_cover/'.$uni_id.'.jpg');

			mysqli_query($db,"INSERT INTO `content` (`contest`,`type`,`iduser`,`photo`,`approved`,`category`,`cover`) VALUES ('".$contest_id."','4','".$_SESSION['_logged_id']."','".$ytid."','".$approved."','".$get_user_category."','".$uni_id."')") or die(mysqli_error($db));
			$db_id = mysqli_insert_id($db);
			if($db_id) {

				compress_image('../_uploads/_content_cover/'.$uni_id.'.jpg', 70);
				crop_image('../_uploads/_content_cover/'.$uni_id.'.jpg', '../_uploads/_content_cover/'.$uni_id.'_400.jpg', 400, 400);

				$return['error'] = 0;
				$oks = 1;
				if($approved == '1') {
					$return['cid'] = $db_id;
				}

				
			}

		} else {
			$return['error_text'] = _LANG_INVALID_VIDEO;
		}

		echo json_encode($return);
		die();

	}

	if($reason == 'paynow_joincontest' && isset($_POST['item_id']) && is_numeric($_POST['item_id']) && isset($_SESSION['_logged_id']) && is_numeric($_SESSION['_logged_id'])) {
		
		$item_id = mysqli_real_escape_string($db,$_POST['item_id']);
		$settings = get_settings();
		
		if(isset($settings['payment_gateway']) && $settings['payment_gateway'] == 'razorpay') {

			require_once('../_payments/Razorpay.php');

			$return['ptype'] = 'razorpay';

			$api = new Api($settings['razorpay_api'], $settings['razorpay_secret']);

			$order = $api->order->create(array('amount' => $settings['contest_entry_fee'], 'currency' => $settings['paypal_currency']));
			$orderId = $order['id'];

			$sql_user = mysqli_query($db,"SELECT * FROM `users` WHERE `id` = '".$_SESSION['_logged_id']."' LIMIT 1");
			$fetch_user = mysqli_fetch_array($sql_user);

			$return['user_name'] = $fetch_user['name'];
			$return['user_email'] = $fetch_user['email'];

			$return['order_id'] = $orderId;
			$return['currency'] = $settings['paypal_currency'];
			$return['price'] = $settings['contest_entry_fee'];
			$return['item_name'] = _LANG_PAY_JOIN_CONTEST;

			$return['return_url'] = $settings['site_url'].'_payments/paypal_success.php';

			$unid = md5($_SESSION['_logged_id'].$item_id.time());
			mysqli_query($db,"INSERT INTO `payments` (`txn_id`,`item_number`,`payment_gross`,`currency_code`,`payment_status`,`userid`) VALUES ('".$unid."','".$item_id."','".$return['price']."','".$return['currency']."','Open','".$_SESSION['_logged_id']."')");

			$return['unid'] = $unid;
			$return['error'] = 0;

		} else {

			require_once('../_payments/_paypal_config.php');

			$return['ptype'] = 'paypal';
			$return['paypal_url'] = PAYPAL_URL;
			$return['paypal_id'] = PAYPAL_ID;
			$return['item_name'] = _LANG_PAY_JOIN_CONTEST;
			$return['item_id'] = $item_id;
			$return['price'] = $settings['contest_entry_fee'];
			$return['currency'] = PAYPAL_CURRENCY;
			$return['return_url'] = PAYPAL_RETURN_URL;
			$return['cancel_url'] = PAYPAL_CANCEL_URL;

			$unid = md5($_SESSION['_logged_id'].$item_id.time());
			mysqli_query($db,"INSERT INTO `payments` (`txn_id`,`item_number`,`payment_gross`,`currency_code`,`payment_status`,`userid`) VALUES ('".$unid."','".$item_id."','".$return['price']."','".$return['currency']."','Open','".$_SESSION['_logged_id']."')");

			$return['unid'] = $unid;
			$return['error'] = 0;

		}

	}

	if($reason == 'paynow_contest' && isset($_POST['item_id']) && is_numeric($_POST['item_id']) && isset($_SESSION['_logged_id']) && is_numeric($_SESSION['_logged_id'])) {

		$item_id = mysqli_real_escape_string($db,$_POST['item_id']);
		$settings = get_settings();
		
		if(isset($settings['payment_gateway']) && $settings['payment_gateway'] == 'razorpay') {

			require_once('../_payments/Razorpay.php');

			$return['ptype'] = 'razorpay';

			$api = new Api($settings['razorpay_api'], $settings['razorpay_secret']);

			$order = $api->order->create(array('amount' => $settings['user_contest_price'], 'currency' => $settings['paypal_currency']));
			$orderId = $order['id'];

			$sql_user = mysqli_query($db,"SELECT * FROM `users` WHERE `id` = '".$_SESSION['_logged_id']."' LIMIT 1");
			$fetch_user = mysqli_fetch_array($sql_user);

			$return['user_name'] = $fetch_user['name'];
			$return['user_email'] = $fetch_user['email'];

			$return['order_id'] = $orderId;
			$return['currency'] = $settings['paypal_currency'];
			$return['price'] = $settings['user_contest_price'];
			$return['item_name'] = _LANG_PAY_THE_CONTEST;

			$return['return_url'] = $settings['site_url'].'_payments/paypal_success.php';

			$unid = md5($_SESSION['_logged_id'].$item_id.time());
			mysqli_query($db,"INSERT INTO `payments` (`txn_id`,`item_number`,`payment_gross`,`currency_code`,`payment_status`,`userid`) VALUES ('".$unid."','".$item_id."','".$return['price']."','".$return['currency']."','Open','".$_SESSION['_logged_id']."')");

			$return['unid'] = $unid;
			$return['error'] = 0;

		} else {

			require_once('../_payments/_paypal_config.php');

			$return['ptype'] = 'paypal';

			$return['paypal_url'] = PAYPAL_URL;
			$return['paypal_id'] = PAYPAL_ID;
			$return['item_name'] = _LANG_PAY_THE_CONTEST;
			$return['item_id'] = $item_id;
			$return['price'] = $settings['user_contest_price'];
			$return['currency'] = PAYPAL_CURRENCY;
			$return['return_url'] = PAYPAL_RETURN_URL;
			$return['cancel_url'] = PAYPAL_CANCEL_URL;

			$unid = md5($_SESSION['_logged_id'].$item_id.time());
			mysqli_query($db,"INSERT INTO `payments` (`txn_id`,`item_number`,`payment_gross`,`currency_code`,`payment_status`,`userid`) VALUES ('".$unid."','".$item_id."','".$return['price']."','".$return['currency']."','Open','".$_SESSION['_logged_id']."')");

			$return['unid'] = $unid;
			$return['error'] = 0;

		}

	}

	if($reason == 'paynow' && isset($_POST['item_id']) && is_numeric($_POST['item_id']) && isset($_SESSION['_logged_id']) && is_numeric($_SESSION['_logged_id'])) {

		$item_id = mysqli_real_escape_string($db,$_POST['item_id']);
		$settings = get_settings();

		$sql = mysqli_query($db,"SELECT * FROM `payments_items` WHERE `id` = '".$item_id."' LIMIT 1");
		if(mysqli_num_rows($sql)) {
			
			$current_purchase = mysqli_fetch_array($sql);

			if(isset($settings['payment_gateway']) && $settings['payment_gateway'] == 'razorpay') {

				require_once('../_payments/Razorpay.php');

				$return['ptype'] = 'razorpay';

				$api = new Api($settings['razorpay_api'], $settings['razorpay_secret']);

				$order = $api->order->create(array('amount' => $current_purchase['price'], 'currency' => $settings['paypal_currency']));
				$orderId = $order['id'];

				$sql_user = mysqli_query($db,"SELECT * FROM `users` WHERE `id` = '".$_SESSION['_logged_id']."' LIMIT 1");
				$fetch_user = mysqli_fetch_array($sql_user);

				$return['user_name'] = $fetch_user['name'];
				$return['user_email'] = $fetch_user['email'];

				$return['order_id'] = $orderId;
				$return['currency'] = $settings['paypal_currency'];
				$return['price'] = $current_purchase['price'];
				$return['item_name'] = $current_purchase['item_name'];

				$return['return_url'] = $settings['site_url'].'_payments/paypal_success.php';

				$unid = md5($_SESSION['_logged_id'].$item_id.time());
				mysqli_query($db,"INSERT INTO `payments` (`txn_id`,`item_number`,`payment_gross`,`currency_code`,`payment_status`,`userid`) VALUES ('".$unid."','".$item_id."','".$current_purchase['price']."','".$return['currency']."','Open','".$_SESSION['_logged_id']."')");

				$return['unid'] = $unid;
				$return['error'] = 0;

			} else {

				require_once('../_payments/_paypal_config.php');

				$return['paypal_url'] = PAYPAL_URL;
				$return['paypal_id'] = PAYPAL_ID;
				$return['item_name'] = $current_purchase['item_name'];
				$return['item_id'] = $current_purchase['id'];
				$return['price'] = $current_purchase['price'];
				$return['currency'] = PAYPAL_CURRENCY;
				$return['return_url'] = PAYPAL_RETURN_URL;
				$return['cancel_url'] = PAYPAL_CANCEL_URL;

				$unid = md5($_SESSION['_logged_id'].$item_id.time());
				mysqli_query($db,"INSERT INTO `payments` (`txn_id`,`item_number`,`payment_gross`,`currency_code`,`payment_status`,`userid`) VALUES ('".$unid."','".$item_id."','".$current_purchase['price']."','".$return['currency']."','Open','".$_SESSION['_logged_id']."')");

				$return['unid'] = $unid;
				$return['error'] = 0;

			}

		}

	}

	if($reason == 'forgot' && isset($_POST['email']) && $_POST['email']) {

		$settings = get_settings();
		$email = mysqli_real_escape_string($db,$_POST['email']);

		$sql = mysqli_query($db,"SELECT * FROM `users` WHERE `email` = '".$email."' LIMIT 1");
		if(mysqli_num_rows($sql)) {

			$fetch = mysqli_fetch_array($sql);

			$return['error'] = 0;
			$email_key = md5($fetch['password'].$fetch['registered']);

			require 'PHPMailer/src/Exception.php';
			require 'PHPMailer/src/PHPMailer.php';
			require 'PHPMailer/src/SMTP.php';

			$mail = new PHPMailer(true);
			$mail->CharSet = 'UTF-8';

			try {

				$domain_name = parse_url($settings['site_url']);

				if(isset($settings['smtp_host']) && $settings['smtp_host'] != '') {

  					$mail->setFrom($settings['smtp_user'], $settings['site_logo']);
    					$mail->addAddress($fetch['email'], $fetch['name']);
    					$mail->Subject = 'Forgot password - '.$settings['site_logo'];
					
					$mail->Host = $settings['smtp_host'];
					$mail->SMTPAuth = true;
					$mail->Username = $settings['smtp_user'];
					$mail->Password = $settings['smtp_pass'];

					if(isset($settings['smtp_ssl']) && $settings['smtp_ssl'] == '1') {
						$mail->SMTPSecure = 'ssl';
					}

					$mail->Port = $settings['smtp_port'];

    					$mail->Body = 'Hello '.$fetch['name'].',<br><br>To change your current password go to: <a href="'.$settings['site_url'].'index.php?forgot='.$email_key.'">'.$settings['site_url'].'index.php?forgot='.$email_key.'</a>';
    					$mail->IsHTML(true);
					$mail->send();
	
				} else {

					if(isset($settings['site_email']) && $settings['site_email'] != '') {
  						$mail->setFrom($settings['site_email'], $settings['site_logo']);
					} else {
						$mail->setFrom('contact@'.$domain_name['host'], $settings['site_logo']);
					}

    					$mail->addAddress($fetch['email'], $fetch['name']);
    					$mail->isHTML(true);
    					$mail->Subject = 'Forgot password - '.$settings['site_logo'];
    					$mail->Body    = 'Hello '.$fetch['name'].',<br><br>To change your current password go to: <a href="'.$settings['site_url'].'index.php?forgot='.$email_key.'">'.$settings['site_url'].'index.php?forgot='.$email_key.'</a>';
    					$mail->send();

				}

			} catch (Exception $e) { }

		}

	}

	if($reason == 'next_random') {

		$extra_sql = '';
		if(isset($settings['vote_own']) && $settings['vote_own'] == '0' && is_logged()) {
			$extra_sql = " `iduser` != '".$_SESSION['_logged_id']."' AND ";
		}

		if(is_logged()) {
			$sql_s = mysqli_query($db,"SELECT `id` FROM `content` WHERE $extra_sql `id` NOT IN (select photo_id FROM `ratings` WHERE iduser = '".$_SESSION['_logged_id']."') ORDER BY rand() LIMIT 1");
		} else {
			$sql_s = mysqli_query($db,"SELECT `id` FROM `content` WHERE `id` NOT IN (select photo_id FROM `ratings` WHERE ip = '".my_ip()."') ORDER BY rand() LIMIT 1");
		}

		if(mysqli_num_rows($sql_s)) {
			$fetch_s = mysqli_fetch_array($sql_s);
			$return['error'] = 0;
			$return['random'] = $fetch_s['id'];
		}

	}
	
	if($reason == 'update_description' && isset($_POST['photo_id']) && is_numeric($_POST['photo_id']) && is_logged()) {

		$photo_id = mysqli_real_escape_string($db,$_POST['photo_id']);
		$sql_update_desc = mysqli_query($db,"SELECT * FROM `content` WHERE `id` = '".$photo_id."' AND `iduser` = '".$_SESSION['_logged_id']."' LIMIT 1");
		if(mysqli_num_rows($sql_update_desc)) {

			$description = mysqli_real_escape_string($db,$_POST['description']);

			if(isset($settings['description_links']) && $settings['description_links'] == '1') {
				$description = strip_tags($description,'<a>');
			} else {
				$description = strip_tags($description);
			}

			mysqli_query($db,"UPDATE `content` SET `description` = '".$description."' WHERE `id` = '".$photo_id."' AND `iduser` = '".$_SESSION['_logged_id']."' LIMIT 1");	

		}

	}

	if($reason == 'remove_contest_photo' && is_logged() && isset($_POST['photo_id']) && is_numeric($_POST['photo_id'])) {

		$photo_id = mysqli_real_escape_string($db,$_POST['photo_id']);

		$sql = mysqli_query($db,"SELECT * FROM `content` WHERE `iduser` = '".$_SESSION['_logged_id']."' AND `id` = '".$photo_id."' LIMIT 1");
		if(mysqli_num_rows($sql)) {
			mysqli_query($db,"UPDATE `content` SET `contest` = '0', `nr_ratings` = '0', `rating` = '0' WHERE `iduser` = '".$_SESSION['_logged_id']."' AND `id` = '".$photo_id."' LIMIT 1");
		}

	}

	if($reason == 'join_contest' && is_logged() && isset($_POST['contest_id']) && is_numeric($_POST['contest_id']) && isset($_POST['photos'])) {

		$photos = json_decode($_POST['photos'],true);
		$contest_id = mysqli_real_escape_string($db,$_POST['contest_id']);

		if(isset($photos) && count($photos)) {
			
			foreach($photos as $photo) {
				$photo = mysqli_real_escape_string($db,$photo);
				if(is_numeric($photo)) {
					$sql_s = mysqli_query($db,"SELECT * FROM `content` WHERE `iduser` = '".$_SESSION['_logged_id']."' AND `contest` = '0' AND `id` = '".$photo."' LIMIT 1");
					if(mysqli_num_rows($sql_s)) {
						mysqli_query($db,"UPDATE `content` SET `contest` = '".$contest_id."', `nr_ratings` = '0', `rating` = '0' WHERE `iduser` = '".$_SESSION['_logged_id']."' AND `id` = '".$photo."' LIMIT 1");
					}
				}
			}

		}

	}

	if($reason == 'get_description' && isset($_POST['photo_id']) && is_numeric($_POST['photo_id']) && is_logged()) {

		$photo_id = mysqli_real_escape_string($db,$_POST['photo_id']);
		$sql_desc = mysqli_query($db,"SELECT `description`,`type`,`cover` FROM `content` WHERE `id` = '".$photo_id."' LIMIT 1");
		$fetch_desc = mysqli_fetch_array($sql_desc);
		$return['description'] = $fetch_desc['description'];
		$return['type'] = $fetch_desc['type'];
		$return['cover'] = $fetch_desc['cover'];
		$return['error'] = 0;

	}

	if($reason == 'add_comment' && is_logged() && isset($_POST['comment']) && isset($_POST['photo_id']) && is_numeric($_POST['photo_id'])) {

		$photo_id = mysqli_real_escape_string($db,$_POST['photo_id']);
		$comment = mysqli_real_escape_string($db,strip_tags($_POST['comment']));
		$comment = trim($comment);	

		if(isset($settings['comments_review']) && $settings['comments_review'] == '1') {
			$approved = 0;
		} else {
			$approved = 1;
		}	
		
		if(strlen($comment) > 1 && $photo_id) {
			mysqli_query($db,"INSERT INTO `comments` (`photo_id`,`user_id`,`comment`,`approved`) VALUES ('".$photo_id."','".$_SESSION['_logged_id']."','".$comment."','".$approved."')");
			$return['error'] = 0;
			$return['comment'] = $comment;
		}

	}

	if($reason == 'load_my_photos' && is_logged()) {

		$return['my_photos'] = array();

		$sql = mysqli_query($db,"SELECT * FROM `content` WHERE `iduser` = '".$_SESSION['_logged_id']."' AND `contest` = '0' AND `approved` = '1' ORDER BY `id` DESC LIMIT 50");
		while($fetch = mysqli_fetch_array($sql)) {

			$return['my_photos'][] = array(
				'id'=>$fetch['id'],
				'photo'=>$fetch['photo'],
				'type'=>$fetch['type'],
				'cover'=>$fetch['cover'],
			);

		}

	}

	if($reason == 'comments' && isset($_POST['photo_id']) && is_numeric($_POST['photo_id'])) {

		$return['comments'] = array();

		$photo_id = mysqli_real_escape_string($db,$_POST['photo_id']);
		$sql_comments = mysqli_query($db,"SELECT a.`id`, a.`user_id`, a.`comment`, a.`date`, b.`user`, b.`name`, b.`profile_picture` FROM `comments` a INNER JOIN `users` b ON a.`user_id` = b.`id` WHERE a.`approved` = '1' AND a.`photo_id` = '".$photo_id."' ORDER BY a.`id` DESC LIMIT 100") or die(mysqli_error($db));
		while($fetch_comment = mysqli_fetch_array($sql_comments)) {

			$return['comments'][] = array(
				'id'=>$fetch_comment['id'],
				'name'=>$fetch_comment['name'],
				'picture'=>$fetch_comment['profile_picture'],
				'date'=>date_to_text($fetch_comment['date']),
				'comment'=>$fetch_comment['comment'],
				'user'=>$fetch_comment['user'],
			);

		}
	}

	if($reason == 'search') {

		$return['list'] = array();
	
		if(isset($_POST['term']) && strlen(trim($_POST['term']))) {

			$term = mysqli_real_escape_string($db,$_POST['term']);
			$sql = mysqli_query($db,"SELECT * FROM `users` WHERE `name` LIKE '%".$term."%' OR `user` LIKE '%".$term."%' LIMIT 5");
			while($fetch = mysqli_fetch_array($sql)) {

				$return['list'][] = array(
					'user'=>$fetch['user'],
					'name'=>$fetch['name'],
					'picture'=>$fetch['profile_picture'],
				);

			}

		}

	}

	if($reason == 'rankings') {

		$order = 'rating';
		if(isset($_POST['order']) && is_numeric($_POST['order'])) {
			if($_POST['order'] == 1) { $order = 'rating DESC, nr_ratings'; }
			if($_POST['order'] == 2) { $order = 'nr_ratings'; }
			if($_POST['order'] == 3) { $order = 'views'; }
		}

		$contest = $contest_y = '';
		if(isset($_POST['contest']) && $_POST['contest'] != '' && is_numeric($_POST['contest'])) {
			$contest_id = mysqli_real_escape_string($db,$_POST['contest']);
			$contest_s = " AND temp.`contest` = '".$contest_id."' ";
			$contest = " AND `contest` = '".$contest_id."' ";
		}

		$category = $category_s = '';
		if(isset($_POST['category']) && is_numeric($_POST['category']) && $_POST['category'] != '-1') {
			$category = " WHERE `category` = '".mysqli_real_escape_string($db,$_POST['category'])."' $contest AND `nr_ratings` >= '".$settings['min_votes']."' ";
			$category_s = " WHERE temp.`category_y` = '".mysqli_real_escape_string($db,$_POST['category'])."' $contest_y ";
		} else {
			$category = " WHERE `nr_ratings` >= '".$settings['min_votes']."' $contest ";
		}

		$return['list'] = array();

		mysqli_query($db,"SET @rank := 0");
		
		$page_nr = (isset($_POST['page_nr']) && is_numeric($_POST['page_nr']) ? mysqli_real_escape_string($db,$_POST['page_nr']) : 0);

		$limit = 25;
		$offset = $page_nr * $limit;

		$sql_rank = mysqli_query($db,"SELECT b.name,b.user,b.id as id2,`rank`,temp.`id` as id3,`iduser`,`category` as 'category_s',`rating`,temp.`nr_ratings`,temp.`views`,`photo`,`type`,`cover` FROM (SELECT (@rank := @rank + 1) AS 'rank', `id`, `iduser`,`rating`,`category` as 'category_y',`nr_ratings`,`views`,`photo`,`type`,`cover` FROM `content` $category ORDER BY $order DESC) temp JOIN `users` b ON temp.iduser = b.id $category_s ORDER BY `rank` ASC LIMIT $offset,$limit") or die(mysqli_error($db));
		
		$tot = 0;
		while($fetch = mysqli_fetch_array($sql_rank)) {

			if(!isset($settings['content_ratemode']) || (isset($settings['content_ratemode']) && $settings['content_ratemode'] == '0')) {

				if($fetch['rating'] == '0') { $fetch['rating'] = '0.00'; }

				$rating_score = $fetch['rating'];

				if(strlen($rating_score) == '1') {
					$rating_score = $rating_score.'.00';
				}

				if(strlen($rating_score) == '3') {
					$rating_score = $rating_score.'0';
				}

			}

			if(isset($settings['content_ratemode']) && $settings['content_ratemode'] == '1') {
	
				$rating_score = $fetch['rating'];

			}

			$return['list'][] = array(
				'id'=>$fetch['id3'],
				'rank'=>$fetch['rank'],
				'photo'=>$fetch['photo'],
				'user'=>$fetch['user'],
				'name'=>$fetch['name'],
				'rating'=>$fetch['rating'],
				'rating_score'=>$rating_score,
				'nr_ratings'=>$fetch['nr_ratings'],	
				'views'=>$fetch['views'],
				'type'=>$fetch['type'],
				'cover'=>$fetch['cover'],
			);

			$tot++;

		}

		if($tot) {
			$return['error'] = 0;
		}		

	}

	if($reason == 'photos' && isset($_POST['type']) && ($_POST['type'] == 'home' || $_POST['type'] == 'profile')) {

		$return['error'] = 0;
		$return['files'] = array();
	
		$type = mysqli_real_escape_string($db,$_POST['type']);
		$page_nr = (isset($_POST['page_nr']) && is_numeric($_POST['page_nr']) ? mysqli_real_escape_string($db,$_POST['page_nr']) : 0);

		$limit = $settings['photos_per_page'];
		$offset = $page_nr * $limit;

		if($type == 'home') {
			if(isset($_POST['category']) && is_numeric($_POST['category']) && $_POST['category'] != '-1') {
				$category = mysqli_real_escape_string($db,$_POST['category']);
				$sql = mysqli_query($db,"SELECT * FROM `content` WHERE `approved` = '1' AND `category` = '".$category."' ORDER BY `id` DESC LIMIT $offset,$limit");
			} else {
				$sql = mysqli_query($db,"SELECT * FROM `content` WHERE `approved` = '1' ORDER BY `id` DESC LIMIT $offset,$limit");
			}
		}

		if($type == 'profile') {
			$profile_id = mysqli_real_escape_string($db,$_POST['id2']);
			$sql = mysqli_query($db,"SELECT * FROM `content` WHERE `approved` = '1' AND `iduser` = '".$profile_id."' ORDER BY `id` DESC LIMIT $offset,$limit");
		}

		while($fetch = mysqli_fetch_array($sql)) {
	
			if(!isset($settings['content_ratemode']) || (isset($settings['content_ratemode']) && $settings['content_ratemode'] == '0')) {
				if($fetch['rating'] == '0') { $fetch['rating'] = '0.00'; }
				$rate1 = round_rate($fetch['rating']);
				$rate2 = check_rating($fetch['rating']);
			}

			if(isset($settings['content_ratemode']) && $settings['content_ratemode'] == '1') {
				$rate1 = $rate2 = $fetch['rating'];
			}

			$return['files'][] = array(
				'ratings'=>$fetch['nr_ratings'],
				'rate'=>$rate1,
				'rate_real'=>$rate2,
				'photo'=>$fetch['photo'],
				'id'=>$fetch['id'],
				'iduser'=>$fetch['iduser'],
				'type'=>$fetch['type'],
				'cover'=>$fetch['cover'],
			);
		}

	}

	if($reason == 'remove_profile_picture' && is_logged()) {

		$sql_s = mysqli_query($db,"SELECT `profile_picture` FROM `users` WHERE `id` = '".$_SESSION['_logged_id']."' LIMIT 1");
		if(mysqli_num_rows($sql_s)) {
			$fetch_s = mysqli_fetch_array($sql_s);
			if(file_exists('../_uploads/_profile_pictures/'.$fetch_s['profile_picture'].'.jpg')) {
				unlink('../_uploads/_profile_pictures/'.$fetch_s['profile_picture'].'.jpg');
			}
			mysqli_query($db,"UPDATE `users` SET `profile_picture` = '' WHERE `id` = '".$_SESSION['_logged_id']."' LIMIT 1");
		}

	}

	if($reason == 'remove_photo') {

		if(isset($_SESSION['_logged_id']) && isset($_POST['id']) && is_numeric($_POST['id'])) {

			$photo_id = mysqli_real_escape_string($db,$_POST['id']);
			$sql_s = mysqli_query($db,"SELECT `photo` FROM `content` WHERE `id` = '".$photo_id."' AND `iduser` = '".$_SESSION['_logged_id']."' LIMIT 1");
			if(mysqli_num_rows($sql_s)) {
				$fetch_s = mysqli_fetch_array($sql_s);
				if(file_exists('../_uploads/_photos/'.$fetch_s['photo'].'.jpg')) {
					unlink('../_uploads/_photos/'.$fetch_s['photo'].'.jpg');
				}
				if(file_exists('../_uploads/_photos/'.$fetch_s['photo'].'_400.jpg')) {
					unlink('../_uploads/_photos/'.$fetch_s['photo'].'_400.jpg');
				}
				mysqli_query($db,"DELETE FROM `content` WHERE `id` = '".$photo_id."' AND `iduser` = '".$_SESSION['_logged_id']."' LIMIT 1");		
			}

		}

	}

	if($reason == 'login') {

		if(isset($_POST['username']) && $_POST['username'] && isset($_POST['password']) && $_POST['password']) {

			$username = strtolower(trim(mysqli_real_escape_string($db,$_POST['username'])));
			$password = mysqli_real_escape_string($db,$_POST['password']);

			if($username && $password && strlen($password) > 5) {
				$check = mysqli_query($db,"SELECT * FROM `users` WHERE `user` = '".$username."' AND `password` = '".hash('sha512',$password)."' LIMIT 1");
				if(mysqli_num_rows($check)) {

					$get = mysqli_fetch_array($check);

					$eok = 1;
					if(isset($settings['confirm_mail']) && $settings['confirm_mail'] == '1') {
						if($get['confirmed'] == '0') {
							$eok = 0;
						}
					}

					if($eok == '1') {
						$_SESSION['_logged'] = 1;
						$_SESSION['_logged_id'] = $get['id'];
						$_SESSION['_logged_user'] = $get['user'];
						$_SESSION['_logged_name'] = $get['name'];
						$_SESSION['_role'] = $get['role'];
				// 		setcookie('_contest',md5($get['registered'].$get['id']),time()+(86400*24*365),'/');

						$return['error'] = 0;	
					} else {
						$return['error'] = 2;
						$return['error_text'] = _LANG_LOGIN_NOT_CONFIRMED;
					}	
		
				} else {
				
					$return['error'] = 2;
					$return['error_text'] = _LANG_LOGIN_ERROR;
		
				}
			} else {
				$return['error'] = 2;
				$return['error_text'] = _LANG_LOGIN_ERROR;
			}

		}

	}

	if($reason == 'register') {

		if(isset($_POST['role']) && $_POST['role'] && isset($_POST['email']) && $_POST['email'] && isset($_POST['name']) && $_POST['name'] && isset($_POST['password']) && $_POST['password'] && isset($_POST['repeat_password']) && $_POST['repeat_password']) {

			$return['error'] = 0;

            $role = trim(mysqli_real_escape_string($db,$_POST['role']));
			$email = trim(mysqli_real_escape_string($db,$_POST['email']));
			$name = trim(mysqli_real_escape_string($db,$_POST['name']));
			$password = mysqli_real_escape_string($db,$_POST['password']);
			$repeat_password = mysqli_real_escape_string($db,$_POST['repeat_password']);
			$category = mysqli_real_escape_string($db,$_POST['category']);

			$name = strip_tags($name);
			$email = strip_tags($email);
	
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$return['error'] = 2;
				$return['error_text'] = _LANG_REGISTER_ERROR_EMAIL;
			}

			if($return['error'] == '0' && strlen($password) < 6) {
				$return['error'] = 3;
				$return['error_text'] = _LANG_REGISTER_ERROR_PASSWORD;
			}

			if($return['error'] == '0' && ($password != $repeat_password)) {
				$return['error'] = 4;
				$return['error_text'] = _LANG_REGISTER_ERROR_REPEAT_PASSWORD;
			}

			if($return['error'] == '0') {
				$check_email = mysqli_query($db,"SELECT * FROM `users` WHERE `email` = '".$email."' LIMIT 1");
				if(mysqli_num_rows($check_email)) {
					$return['error'] = 5;
					$return['error_text'] = _LANG_REGISTER_ERROR_EMAIL_EXISTS;
				}
			}
	
			if($settings['category_required'] == '1' && $return['error'] == '0') {
				if(!is_numeric($category)) {
					$return['error'] = 6;
					$return['error_text'] = _LANG_REGISTER_ERROR_CATEGORY;
				}
			}

			if($return['error'] == '0') {
				$user = user_generator($name);
				if(isset($settings['confirm_mail']) && $settings['confirm_mail'] == '1') {
					$confirmed = 0;
				} else {
					$confirmed = 1;
				}

				mysqli_query($db,"INSERT INTO `users` (`confirmed`,`email`,`name`,`password`,`user`,`category`, `role`) VALUES ('1','".$email."','".$name."','".hash('sha512',$password)."','".$user."','".$category."','".$role."')") or die(mysqli_error($db));

				$my_id = mysqli_insert_id($db);

				if($confirmed == '0') {

					require 'PHPMailer/src/Exception.php';
					require 'PHPMailer/src/PHPMailer.php';
					require 'PHPMailer/src/SMTP.php';

					$mail = new PHPMailer(true);
					$mail->CharSet = 'UTF-8';

					try {

						if(isset($settings['smtp_host']) && $settings['smtp_host'] != '') {

  							$mail->setFrom($settings['smtp_user'], $settings['site_logo']);
    							$mail->addAddress($email, $name);
					
							$mail->Host = $settings['smtp_host'];
							$mail->SMTPAuth = true;
							$mail->Username = $settings['smtp_user'];
							$mail->Password = $settings['smtp_pass'];

							if(isset($settings['smtp_ssl']) && $settings['smtp_ssl'] == '1') {
								$mail->SMTPSecure = 'ssl';
							}

							$mail->Port = $settings['smtp_port'];

    							$mail->Subject = 'Confirm e-mail - '.$settings['site_logo'];
    							$mail->Body    = 'Hello '.$name.',<br><br>To confirm your e-mail address please go to: <a href="'.$settings['site_url'].'index.php?confirm_email='.md5($my_id).'">'.$settings['site_url'].'index.php?confirm_email='.md5($my_id).'</a>';

    							$mail->IsHTML(true);
							$mail->send();
	
						} else {

							$domain_name = parse_url($settings['site_url']);
  							$mail->setFrom('contact@'.$domain_name['host'], $settings['site_logo']);
    							$mail->addAddress($email, $name);
    							$mail->isHTML(true);
    							$mail->Subject = 'Confirm e-mail - '.$settings['site_logo'];
    							$mail->Body    = 'Hello '.$name.',<br><br>To confirm your e-mail address please go to: <a href="'.$settings['site_url'].'index.php?confirm_email='.md5($my_id).'">'.$settings['site_url'].'index.php?confirm_email='.md5($my_id).'</a>';
    							$mail->send();

						}

					} catch (Exception $e) { }

				}

				$check = mysqli_query($db,"SELECT * FROM `users` WHERE `id` = '".$my_id."' LIMIT 1");
				if(mysqli_num_rows($check)) {

					$get = mysqli_fetch_array($check);
					if($confirmed == '1') {
						$_SESSION['_logged'] = 1;
						$_SESSION['_logged_id'] = $get['id'];
						$_SESSION['_logged_user'] = $get['user'];
						$_SESSION['_logged_name'] = $get['name'];
						setcookie('_contest',md5($get['registered'].$get['id']),time()+(86400*24*365),'/');
					} else {
						$return['error_text'] = _LANG_CHECK_EMAIL;
					}

					$return['error'] = 0;	

				}	
			}

		}

	}

	if($reason == 'fb_login') {

		if(isset($_POST['fb_userid']) && $_POST['fb_userid']) {

			$fb_userid = mysqli_real_escape_string($db,$_POST['fb_userid']);

			$return['error'] = 0;

			if($fb_userid) {

				$check = mysqli_query($db,"SELECT * FROM `users` WHERE `fb_id` = '".$fb_userid."' LIMIT 1");
				if(mysqli_num_rows($check)) {

					$get = mysqli_fetch_array($check);
					$_SESSION['_logged'] = 1;
					$_SESSION['_logged_id'] = $get['id'];
					$_SESSION['_logged_user'] = $get['user'];
					$_SESSION['_logged_name'] = $get['name'];
					
					setcookie('_contest',md5($get['registered'].$get['id']),time()+(86400*24*365),'/');

					$return['error'] = 0;		
		
				} else {
				
					if(isset($_POST['email']) && strstr($_POST['email'],'@') && isset($_POST['name']) && $_POST['name'] != '') {

						$email = trim(mysqli_real_escape_string($db,$_POST['email']));
						$name = trim(mysqli_real_escape_string($db,$_POST['name']));

						$name = strip_tags($name);
						$email = strip_tags($email);
	
						if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
							$return['error'] = 2;
						}

						if($return['error'] == '0') {
							$check_email = mysqli_query($db,"SELECT * FROM `users` WHERE `email` = '".$email."' LIMIT 1");
							if(mysqli_num_rows($check_email)) {

								$fetch_mail = mysqli_fetch_array($check_email);
								mysqli_query($db,"UPDATE `users` SET `fb_id` = '".$fb_userid."' WHERE `id` = '".$fetch_mail['id']."' LIMIT 1");

								$_SESSION['_logged'] = 1;
								$_SESSION['_logged_id'] = $fetch_mail['id'];
								$_SESSION['_logged_user'] = $fetch_mail['user'];
								$_SESSION['_logged_name'] = $fetch_mail['name'];

								setcookie('_contest',md5($fetch_mail['registered'].$fetch_mail['id']),time()+(86400*24*365),'/');

								$return['error'] = 0;	

							} else {

								$user = user_generator($name);
								mysqli_query($db,"INSERT INTO `users` (`email`,`name`,`user`,`fb_id`) VALUES ('".$email."','".$name."','".$user."','".$fb_userid."')") or die(mysqli_error($db));
								$db_id = mysqli_insert_id($db);
								if($db_id) {

									$_SESSION['_logged'] = 1;
									$_SESSION['_logged_id'] = $db_id;
									$_SESSION['_logged_user'] = $user;
									$_SESSION['_logged_name'] = $name;

									$sql_cr = mysqli_query($db,"SELECT * FROM `users` WHERE `id` = '".$db_id."' LIMIT 1");
									$fetch_mail = mysqli_fetch_array($sql_cr);

									setcookie('_contest',md5($fetch_mail['registered'].$fetch_mail['id']),time()+(86400*24*365),'/');

									$return['error'] = 0;	

								}

							}

						}

					}
		
				}

			}

		}

	}

	if($reason == 'rotate' && isset($_POST['image_id']) && is_numeric($_POST['image_id']) && is_logged()) {

		$image_id = mysqli_real_escape_string($db,$_POST['image_id']);
		$sql = mysqli_query($db,"SELECT * FROM `content` WHERE `id` = '".$image_id."' AND `iduser` = '".$_SESSION['_logged_id']."' LIMIT 1");
		if(mysqli_num_rows($sql)) {

			$fetch = mysqli_fetch_array($sql);
			$new_photo_id = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVXYZ"), 0, 20);
			rotate_image('../_uploads/_photos/'.$fetch['photo'].'.jpg', '../_uploads/_photos/'.$new_photo_id.'.jpg');
			crop_image('../_uploads/_photos/'.$new_photo_id.'.jpg', '../_uploads/_photos/'.$new_photo_id.'_400.jpg', 400, 400);

			mysqli_query($db,"UPDATE `content` SET `photo` = '".$new_photo_id."' WHERE `id` = '".$image_id."' AND `iduser` = '".$_SESSION['_logged_id']."' LIMIT 1");
			$return['error'] = 0;
			$return['file'] = $new_photo_id;

		}

	}

	if($reason == 'update_slogan' && is_logged()) {

		if(isset($_POST['slogan']) && $_POST['slogan'] != '') {
			$slogan = mysqli_real_escape_string($db,$_POST['slogan']);
		} else {
			$slogan = '';
		}

		$slogan = trim($slogan);
		$slogan = strip_tags($slogan);

		if($slogan != _LANG_PROFILE_ADD_SLOGAN) {
			mysqli_query($db,"UPDATE `users` SET `slogan` = '".$slogan."' WHERE `id` = '".$_SESSION['_logged_id']."' LIMIT 1");
		}

	}

	if($reason == 'rate' && isset($_POST['rate']) && ($_POST['rate'] > 0 && $_POST['rate'] < 6) && isset($_POST['photo_id']) && is_numeric($_POST['photo_id'])) {

		$rate = mysqli_real_escape_string($db,$_POST['rate']);
		$photo_id = mysqli_real_escape_string($db,$_POST['photo_id']);
		
		if(is_logged()) {
			mysqli_query($db,"INSERT IGNORE INTO `ratings` (`iduser`,`rate`,`photo_id`,`ip`) VALUES ('".$_SESSION['_logged_id']."','".$rate."','".$photo_id."','".my_ip()."')");
		} else {
			mysqli_query($db,"INSERT IGNORE INTO `ratings` (`iduser`,`rate`,`photo_id`,`ip`) VALUES ('0','".$rate."','".$photo_id."','".my_ip()."')");
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

			mysqli_query($db,"UPDATE `content` SET `nr_ratings` = '".$total_ratings."', `rating` = '".$new_rating."' WHERE `id` = '".$photo_id."' LIMIT 1");

			$sql_s = mysqli_query($db,"SELECT `contest` FROM `content` WHERE `id` = '".$photo_id."' LIMIT 1");
			$fetch_photo = mysqli_fetch_array($sql_s);

			mysqli_query($db,"SET @rank := 0");
			if($fetch_photo['contest']) {
				$sql_rank = mysqli_query($db,"SELECT `rank`,`id`,`contest` FROM (SELECT (@rank := @rank + 1) AS 'rank', `id`, `contest` FROM `content` WHERE `contest` = '".$fetch_photo['contest']."' ORDER BY `rating` DESC) temp WHERE `id` = '".$photo_id."'") or die(mysqli_error($db));
			} else {
				$sql_rank = mysqli_query($db,"SELECT `rank`,`id` FROM (SELECT (@rank := @rank + 1) AS 'rank', `id` FROM `content` ORDER BY `rating` DESC) temp WHERE `id` = '".$photo_id."'") or die(mysqli_error($db));
			}
			$fetch_rank = mysqli_fetch_array($sql_rank);

			$return['error'] = 0;
			$return['new_rank'] = $fetch_rank['rank'];
			$return['new_rating'] = $new_rating;
			$return['nr_ratings'] = $total_ratings;
			$return['real_rate'] = round_rate($new_rating);

			if($settings['min_votes'] > $total_ratings) {
				$return['new_rank'] = '';
			}

		}

	}

	if($reason == 'logout') {
		session_destroy();
		setcookie('_contest','',time()-10,'/');
		die();
	}

	echo json_encode($return);
?>