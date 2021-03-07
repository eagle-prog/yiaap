<?php
session_start();

	require_once('../_core/_functions.php');
	
	$return = array('error'=>1,'error_text'=>_LANG_ERROR_DEFAULT);

	if(!isset($_POST['reason'])) {
		echo json_encode($return);
		die();
	} else {
		$reason = mysqli_real_escape_string($db,$_POST['reason']);
	}

	if($reason == 'remove_fad' && isset($_POST['id']) && is_numeric($_POST['id'])) {

		$fad_id = mysqli_real_escape_string($db,$_POST['id']);
		mysqli_query($db,"DELETE FROM `ads` WHERE `id` = '".$fad_id."' LIMIT 1");

	}

	if($reason == 'remove_fitem' && isset($_POST['id']) && is_numeric($_POST['id'])) {
		
		$fitem_id = mysqli_real_escape_string($db,$_POST['id']);
		mysqli_query($db,"DELETE FROM `payments_items` WHERE `id` = '".$fitem_id."' LIMIT 1");

	}

	if($reason == 'rallr') {

		mysqli_query($db,"DELETE FROM `ratings`");
		mysqli_query($db,"UPDATE `content` SET `nr_ratings` = '0', `views` = '0', `rating` = '0'");
		die();

	}

	if($reason == 'get_fad') {

		if(isset($_POST['id']) && is_numeric($_POST['id'])) {

			$sql = mysqli_query($db,"SELECT * FROM `ads` WHERE `id` = '".mysqli_real_escape_string($db,$_POST['id'])."' LIMIT 1");
			if(mysqli_num_rows($sql)) {
				$fetch = mysqli_fetch_array($sql);
				$return['ad_title'] = $fetch['ad_title'];
				$return['ad_code'] = $fetch['ad_code'];
				$return['ad_position'] = $fetch['ad_position'];
				$return['ad_privacy'] = $fetch['ad_privacy'];
			}

		}

	}

	if($reason == 'get_fitem') {

		if(isset($_POST['id']) && is_numeric($_POST['id'])) {

			$sql = mysqli_query($db,"SELECT * FROM `payments_items` WHERE `id` = '".mysqli_real_escape_string($db,$_POST['id'])."' LIMIT 1");
			if(mysqli_num_rows($sql)) {
				$fetch = mysqli_fetch_array($sql);
				$return['item_name'] = $fetch['item_name'];
				$return['votes'] = $fetch['votes'];
				$return['views'] = $fetch['views'];
				$return['price'] = $fetch['price'];
			}

		}

	}

	if($reason == 'delete_logo') {

		mysqli_query($db,"DELETE FROM `settings` WHERE `set_key` = 'site_logo_image' LIMIT 1");

	}

	if($reason == 'update_fitem') {

		if(isset($_POST['fitem_id']) && is_numeric($_POST['fitem_id'])) {
			$fitem_id = mysqli_real_escape_string($db,$_POST['fitem_id']);
		}

		$item_name = mysqli_real_escape_string($db,$_POST['item_name']);
		$item_votes = mysqli_real_escape_string($db,$_POST['item_votes']);
		$item_views = mysqli_real_escape_string($db,$_POST['item_views']);
		$item_price = mysqli_real_escape_string($db,$_POST['item_price']);

		if($item_name && $item_price) {

			if(isset($fitem_id) && is_numeric($fitem_id)) {
				mysqli_query($db,"UPDATE `payments_items` SET `item_name` = '".$item_name."', `votes` = '".$item_votes."', `views` = '".$item_views."', `price` = '".$item_price."' WHERE `id` = '".$fitem_id."' LIMIT 1");
			} else {
				mysqli_query($db,"INSERT INTO `payments_items` (`item_name`,`votes`,`views`,`price`) VALUES ('".$item_name."','".$item_votes."','".$item_views."','".$item_price."')");
			}

			$return['error'] = 0;

		}

	}

	if($reason == 'update_fad') {

		if(isset($_POST['fad_id']) && is_numeric($_POST['fad_id'])) {
			$fad_id = mysqli_real_escape_string($db,$_POST['fad_id']);
		}

		$ad_title = mysqli_real_escape_string($db,$_POST['ad_title']);
		$ad_code = mysqli_real_escape_string($db,$_POST['ad_code']);

		$ad_position = mysqli_real_escape_string($db,$_POST['ad_position']);
		$ad_privacy = mysqli_real_escape_string($db,$_POST['ad_privacy']);

		if($ad_position != '0' && $ad_code != '') {
			if(isset($fad_id) && is_numeric($fad_id)) {
				mysqli_query($db,"UPDATE `ads` SET `ad_title` = '".$ad_title."', `ad_code` = '".$ad_code."', `ad_privacy` = '".$ad_privacy."', `ad_position` = '".$ad_position."' WHERE `id` = '".$fad_id."' LIMIT 1");
			} else {
				mysqli_query($db,"INSERT INTO `ads` (`ad_title`,`ad_code`,`ad_privacy`,`ad_position`) VALUES ('".$ad_title."','".$ad_code."','".$ad_privacy."','".$ad_position."')") or die(mysqli_error($db));
			}
			$return['error'] = 0;
		}

	}

	if($reason == 'remove_contest' && isset($_POST['id']) && is_numeric($_POST['id'])) {

		$id = mysqli_real_escape_string($db,$_POST['id']);
		$sql = mysqli_query($db,"SELECT * FROM `contest` WHERE `id` = '".$id."' LIMIT 1");
		if(mysqli_num_rows($sql)) {

			mysqli_query($db,"DELETE FROM `contest` WHERE `id` = '".$id."' LIMIT 1");
			$return['error'] = 0;

		}

	}

	if($reason == 'remove_page' && isset($_POST['id']) && is_numeric($_POST['id'])) {

		$id = mysqli_real_escape_string($db,$_POST['id']);
		$sql = mysqli_query($db,"SELECT * FROM `pages` WHERE `id` = '".$id."' LIMIT 1");
		if(mysqli_num_rows($sql)) {

			mysqli_query($db,"DELETE FROM `pages` WHERE `id` = '".$id."' LIMIT 1");
			$return['error'] = 0;

		}

	}

	if($reason == 'contests') {
	
		$return['contests'] = array();

		$sql_contests = mysqli_query($db,"SELECT * FROM `contest` ORDER BY `active` DESC, `id` DESC");
		while($fetch_contest = mysqli_fetch_array($sql_contests)) {
			
			$sql_joined = mysqli_query($db,"SELECT count(*) as 'total' FROM `content` WHERE `contest` = '".$fetch_contest['id']."'");
			$fetch_joined = mysqli_fetch_array($sql_joined);
			
			$countDownDate = strtotime($fetch_contest['end']);
			$now = time();

			if(time() > $countDownDate) {
				$days = $hours = $minutes = $seconds = 0;
			} else {
    
  				$distance = $countDownDate - time();
    
  				$days = floor($distance / (60 * 60 * 24));
  				$hours = floor(($distance % (60 * 60 * 24)) / (60 * 60));
  				$minutes = floor(($distance % (60 * 60)) / (60));
  				$seconds = floor(($distance % (60)));

			}

			$countdown = '<span class="bold">'.$days.'</span> days, <span class="bold">'.$hours.'</span> hours, <span class="bold">'.$minutes.'</span> minutes';

			$return['contests'][] = array(
				'id'=>$fetch_contest['id'],
				'active'=>$fetch_contest['active'],
				'title'=>$fetch_contest['title'],
				'end'=>$fetch_contest['end'],
				'description'=>$fetch_contest['description'],
				'joined'=>$fetch_joined['total'],
				'countdown'=>$countdown
			);

		}
		
	}

	if($reason == 'update_user' && isset($_POST['user_id'])) {

		$user_id = mysqli_real_escape_string($db,$_POST['user_id']);
		$sql = mysqli_query($db,"SELECT * FROM `users` WHERE `id` = '".$user_id."' LIMIT 1");
		if(mysqli_num_rows($sql)) {
			$email = mysqli_real_escape_string($db,$_POST['email']);
			$name = mysqli_real_escape_string($db,$_POST['name']);
			$user = mysqli_real_escape_string($db,$_POST['user']);
			$sql2 = mysqli_query($db,"SELECT * FROM `users` WHERE `email` = '".$email."' AND `id` != '".$user_id."' LIMIT 1");
			if(!mysqli_num_rows($sql2)) {
				$sql3 = mysqli_query($db,"SELECT * FROM `users` WHERE `user` = '".$user."' AND `id` != '".$user_id."' LIMIT 1");
				if(!mysqli_num_rows($sql3)) {
					mysqli_query($db,"UPDATE `users` SET `email` = '".$email."', `name` = '".$name."', `user` = '".$user."' WHERE `id` = '".$user_id."' LIMIT 1");
					$return['error'] = 0;
				} else {
					$return['error'] = 2;
				}
			} else {
				$return['error'] = 3;
			}
		}

	}

	if($reason == 'get_edit_user' && isset($_POST['id'])) {

		$id = mysqli_real_escape_string($db,$_POST['id']);
		$sql = mysqli_query($db,"SELECT * FROM `users` WHERE `id` = '".$id."' LIMIT 1");
		if(mysqli_num_rows($sql)) {
			$fetch = mysqli_fetch_array($sql);
			$return['email'] = $fetch['email'];	
			$return['name'] = $fetch['name'];
			$return['user'] = $fetch['user'];
			$return['error'] = 0;
		}

	}

	if($reason == 'pages') {
	
		$return['pages'] = array();

		$sql_pages = mysqli_query($db,"SELECT * FROM `pages` ORDER BY `id` DESC");
		while($fetch_page = mysqli_fetch_array($sql_pages)) {
			
			if($fetch_page['title'] == '') {
				$fetch_page['title'] = 'Untitled';
			}

			$return['pages'][] = array(
				'id'=>$fetch_page['id'],
				'footer'=>$fetch_page['footer'],
				'title'=>$fetch_page['title'],
			);

		}
		
	}

	if($reason == 'users') {
	
		$return['users'] = array();

		$page_nr = (isset($_POST['page_nr']) ? $_POST['page_nr'] : 0);
		$offset = $page_nr * 50;

		$sql_users = mysqli_query($db,"SELECT * FROM `users` ORDER BY `id` DESC LIMIT $offset,50");
		while($fetch_user = mysqli_fetch_array($sql_users)) {
			
			if($fetch_user['profile_picture']) {
				$fetch_user['profile_picture'] = '../_uploads/_profile_pictures/'.$fetch_user['profile_picture'].'.jpg';
			} else {
				$fetch_user['profile_picture'] = '../_img/no_profile_picture.jpg';
			}

			$return['users'][] = array(
				'id'=>$fetch_user['id'],
				'name'=>$fetch_user['name'],
				'user'=>$fetch_user['user'],
				'email'=>$fetch_user['email'],
				'picture'=>$fetch_user['profile_picture'],
				'regdate'=>date('d-m-Y H:i', strtotime($fetch_user['registered'])),
			);

		}
		
	}

	if($reason == 'payments') {
	
		$return['payments'] = array();

		$page_nr = (isset($_POST['page_nr']) ? $_POST['page_nr'] : 0);
		$offset = $page_nr * 50;

		$sql_payments = mysqli_query($db,"SELECT a.*, b.* FROM `payments` a INNER JOIN `users` b ON a.`userid` = b.`id` ORDER BY a.`payment_id` DESC LIMIT $offset,50");
		while($fetch_payment = mysqli_fetch_array($sql_payments)) {

			$sql_item = mysqli_query($db,"SELECT * FROM `payments_items` WHERE `id`= '".$fetch_payment['item_number']."' LIMIT 1");
			if(mysqli_num_rows($sql_item)) {
				$fetch_item = mysqli_fetch_array($sql_item);
				$product = $fetch_item['item_name'];
			} else {
				$product = '-';
			}

			$return['payments'][] = array(
				'id'=>$fetch_payment['payment_id'],
				'name'=>$fetch_payment['name'],
				'email'=>$fetch_payment['email'],
				'txn_id'=>$fetch_payment['txn_id'],
				'price'=>$fetch_payment['currency_code'].' '.$fetch_payment['payment_gross'],
				'date'=>date('d-m-Y H:i', strtotime($fetch_payment['date'])),
				'status'=>$fetch_payment['payment_status'],
				'product'=>$product,
			);

		}
		
	}

	if($reason == 'photos') {

		$return['photos'] = array();

		$type = (isset($_POST['type']) && $_POST['type'] == '1' ? 0 : 1);

		$page_nr = (isset($_POST['page_nr']) ? $_POST['page_nr'] : 0);
		$offset = $page_nr * 50;

		$sql_photos = mysqli_query($db,"SELECT * FROM `content` WHERE `type` = '0' AND `approved` = '".$type."' ORDER BY `id` DESC LIMIT $offset,50");
		while($fetch_photo = mysqli_fetch_array($sql_photos)) {

			$return['photos'][] = array(
				'id'=>$fetch_photo['id'],
				'photo'=>$fetch_photo['photo'],
				'approved'=>$fetch_photo['approved'],
			);

		}

	}

	if($reason == 'videos' || $reason == 'music') {

		$return['content'] = array();

		$type = (isset($_POST['type']) && $_POST['type'] == '1' ? 0 : 1);

		$page_nr = (isset($_POST['page_nr']) ? $_POST['page_nr'] : 0);
		$offset = $page_nr * 50;

		$ne_type = ($reason == 'videos' ? '2' : '1');
		$sql_content = mysqli_query($db,"SELECT * FROM `content` WHERE `type` = '".$ne_type."' AND `approved` = '".$type."' ORDER BY `id` DESC LIMIT $offset,50");
		while($fetch_content = mysqli_fetch_array($sql_content)) {

			$return['content'][] = array(
				'id'=>$fetch_content['id'],
				'content'=>$fetch_content['photo'],
				'approved'=>$fetch_content['approved'],
				'cover'=>$fetch_content['cover'],
				'type'=>$fetch_content['type'],
			);

		}

	}

	if($reason == 'ratings') {

		$return['ratings'] = array();

		$page_nr = (isset($_POST['page_nr']) ? $_POST['page_nr'] : 0);
		$offset = $page_nr * 50;

		$sql_ratings = mysqli_query($db,"SELECT a.`id`,b.`type`,b.`cover`,a.`iduser`,a.`ip`,a.`photo_id`,a.`rate`,a.`date`,b.`photo`,c.`user` FROM `ratings` a LEFT JOIN `users` c ON a.`iduser` = c.`id` INNER JOIN `content` b ON a.`photo_id` = b.`id` ORDER BY a.`id` DESC LIMIT $offset,50");
		while($fetch_rating = mysqli_fetch_array($sql_ratings)) {

			if(!$fetch_rating['user']) {
				$fetch_rating['user'] = 'Guest';
			}

			$return['ratings'][] = array(
				'id'=>$fetch_rating['id'],
				'photo'=>$fetch_rating['photo'],
				'rate'=>$fetch_rating['rate'],
				'ip'=>$fetch_rating['ip'],
				'date'=>date('d-m-Y H:i', strtotime($fetch_rating['date'])),
				'user'=>$fetch_rating['user'],
				'photo_id'=>$fetch_rating['photo_id'],
				'type'=>$fetch_rating['type'],
				'cover'=>$fetch_rating['cover'],
			);

		}

	}

	if($reason == 'comments') {

		$return['comments'] = array();

		$type = (isset($_POST['type']) && $_POST['type'] == '1' ? 0 : 1);

		$page_nr = (isset($_POST['page_nr']) ? $_POST['page_nr'] : 0);
		$offset = $page_nr * 50;

		$sql_comments = mysqli_query($db,"SELECT a.`id`,b.`type`,b.`cover`,a.`approved`,a.`user_id`,a.`photo_id`,a.`comment`,a.`date`,b.`photo`,c.`user`,c.`name` FROM `comments` a INNER JOIN `users` c ON a.`user_id` = c.`id` INNER JOIN `content` b ON a.`photo_id` = b.`id` WHERE a.`approved` = '".$type."' ORDER BY a.`id` DESC LIMIT $offset,50");
		while($fetch_comment = mysqli_fetch_array($sql_comments)) {

			$return['comments'][] = array(
				'id'=>$fetch_comment['id'],
				'photo'=>$fetch_comment['photo'],
				'comment'=>$fetch_comment['comment'],
				'date'=>date('d-m-Y H:i', strtotime($fetch_comment['date'])),
				'user'=>$fetch_comment['user'],
				'photo_id'=>$fetch_comment['photo_id'],
				'type'=>$fetch_comment['type'],
				'cover'=>$fetch_comment['cover'],
				'name'=>$fetch_comment['name'],
				'approved'=>$fetch_comment['approved'],
			);

		}

	}

	if($reason == 'categories') {

		$return['categories'] = array();

		$sql_categories = mysqli_query($db,"SELECT * FROM `categories` ORDER BY `name` ASC");
		while($fetch_category = mysqli_fetch_array($sql_categories)) {

			$sql_count = mysqli_query($db,"SELECT count(*) as 'total' FROM `content` WHERE `category` = '".$fetch_category['id']."'");
			$fetch_count = mysqli_fetch_array($sql_count);

			$return['categories'][] = array(
				'id'=>$fetch_category['id'],
				'name'=>$fetch_category['name'],
				'count'=>$fetch_count['total'],
			);

		}

	}

	if($reason == 'add_ncat') {

		if(isset($_POST['ncat']) && $_POST['ncat'] != '') {
			$ncat = mysqli_real_escape_string($db,$_POST['ncat']);
		}

		if(isset($_POST['id']) && is_numeric($_POST['id'])) {
			$id = mysqli_real_escape_string($db,$_POST['id']);
		}

		if(isset($ncat) && $ncat) {

			if(isset($id) && is_numeric($id) && $id != '0') {
				mysqli_query($db,"UPDATE `categories` SET `name` = '".$ncat."' WHERE `id` = '".$id."' LIMIT 1");
			} else {
				mysqli_query($db,"INSERT IGNORE INTO `categories` (`name`) VALUES ('".$ncat."')");
			}

		}

	}
		
	if($reason == 'remove_category' && isset($_POST['id']) && is_numeric($_POST['id'])) {

		$id = mysqli_real_escape_string($db,$_POST['id']);
		if(is_numeric($id)) {
			mysqli_query($db,"DELETE FROM `categories` WHERE `id` = '".$id."' LIMIT 1");
		}

	}

	if($reason == 'remove_comment' && isset($_POST['id']) && is_numeric($_POST['id'])) {

		$id = mysqli_real_escape_string($db,$_POST['id']);
		if(is_numeric($id)) {
			mysqli_query($db,"DELETE FROM `comments` WHERE `id` = '".$id."' LIMIT 1");
		}

	}

	if($reason == 'remove_rating' && isset($_POST['id']) && is_numeric($_POST['id'])) {

		$id = mysqli_real_escape_string($db,$_POST['id']);
		if(is_numeric($id)) {
			$sql_rating = mysqli_query($db,"SELECT * FROM `ratings` WHERE `id` = '".$id."' LIMIT 1");
			$fetch_rating = mysqli_fetch_array($sql_rating);
			$photo_id = $fetch_rating['photo_id'];
			mysqli_query($db,"DELETE FROM `ratings` WHERE `id` = '".$id."' LIMIT 1");
			$sql_count = mysqli_query($db,"SELECT SUM(rate) as 'rating', count(*) as 'total_ratings' FROM `ratings` WHERE `photo_id` = '".$photo_id."'");
			if(mysqli_num_rows($sql_count)) {
				$fetch_count = mysqli_fetch_array($sql_count);
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
				mysqli_query($db,"UPDATE `content` SET `nr_ratings` = '".$total_ratings."', `rating` = '".$new_rating."' WHERE `id` = '".$photo_id."' LIMIT 1");
			}
		}

	}

	if($reason == 'remove_photo' && isset($_POST['id']) && is_numeric($_POST['id'])) {

		$id = mysqli_real_escape_string($db,$_POST['id']);
		if(is_numeric($id)) {
			$sql_s = mysqli_query($db,"SELECT `photo` FROM `content` WHERE `id` = '".id."' LIMIT 1");
			if(mysqli_num_rows($sql_s)) {
				$fetch_s = mysqli_fetch_array($sql_s);
				if(file_exists('../_uploads/_photos/'.$fetch_s['photo'].'.jpg')) {
					unlink('../_uploads/_photos/'.$fetch_s['photo'].'.jpg');
				}
				if(file_exists('../_uploads/_photos/'.$fetch_s['photo'].'_400.jpg')) {
					unlink('../_uploads/_photos/'.$fetch_s['photo'].'_400.jpg');
				}
			}
			mysqli_query($db,"DELETE FROM `content` WHERE `id` = '".$id."' LIMIT 1");
			mysqli_query($db,"DELETE FROM `ratings` WHERE `photo_id` = '".$id."'");
		}

	}

	if($reason == 'approve_photo' && isset($_POST['id']) && is_numeric($_POST['id'])) {

		$id = mysqli_real_escape_string($db,$_POST['id']);
		if(is_numeric($id)) {
			mysqli_query($db,"UPDATE `content` SET `approved` = '1' WHERE `id` = '".$id."' LIMIT 1");
		}

	}

	if($reason == 'approve_comment' && isset($_POST['id']) && is_numeric($_POST['id'])) {

		$id = mysqli_real_escape_string($db,$_POST['id']);
		if(is_numeric($id)) {
			mysqli_query($db,"UPDATE `comments` SET `approved` = '1' WHERE `id` = '".$id."' LIMIT 1");
		}

	}

	if($reason == 'remove_user' && isset($_POST['id']) && is_numeric($_POST['id'])) {

		$id = mysqli_real_escape_string($db,$_POST['id']);
		if(is_numeric($id)) {
			mysqli_query($db,"DELETE FROM `users` WHERE `id` = '".$id."' LIMIT 1");
			mysqli_query($db,"DELETE FROM `content` WHERE `iduser` = '".$id."'");
		}

	}

	echo json_encode($return);
?>