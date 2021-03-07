<?php
	if(isset($settings['redirect_ssl']) && $settings['redirect_ssl'] == '1') {
		if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != 'on') {
    			header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
    			exit;
		}
	}

	if(isset($_COOKIE['_contest']) && strlen($_COOKIE['_contest']) == '32' && !isset($_SESSION['_logged_id'])) {
		$check_cookie = mysqli_real_escape_string($db,$_COOKIE['_contest']);
		$sql_rq = mysqli_query($db,"SELECT * FROM `users` WHERE MD5(CONCAT(registered, id)) = '".$check_cookie."' LIMIT 1");
		if(mysqli_num_rows($sql_rq) == '1') {
				
			$get = mysqli_fetch_array($sql_rq);
			$_SESSION['_logged'] = 1;
			$_SESSION['_logged_id'] = $get['id'];
			$_SESSION['_logged_user'] = $get['user'];
			$_SESSION['_logged_name'] = $get['name'];

			header("Refresh:0");

		}
	}

	if(isset($_GET['my_contests'])) {

		if(!is_logged()) {
			header('location: index.php');
			die();
		}

	}

	if(isset($_GET['uploader'])) {

		$fail = 0;

		if(!isset($_SESSION['_logged_id'])) {
			$fail = 1;
		}

		if($fail == 0) {
			
			if(isset($_POST['submit_uploader'])) {

				foreach($_POST as $ks=>$ps) {
					
					if(strstr($ks,'desc_for_') && $ps) {

						$ks_2 = str_replace('desc_for_','',$ks);
						if(is_numeric($ks_2)) {

							$description = mysqli_real_escape_string($db,$ps);

							if(isset($settings['description_links']) && $settings['description_links'] == '1') {
								$description = strip_tags($description,'<a>');
							} else {
								$description = strip_tags($description);
							}

							mysqli_query($db,"UPDATE `content` SET `description` = '".$description."' WHERE `id` = '".$ks_2."' AND `iduser` = '".$_SESSION['_logged_id']."' LIMIT 1");	

						}

					}

				}

				header('location: '.$site_url.$_SESSION['_logged_user']);

			}

			$sql_uploader = mysqli_query($db,"SELECT * FROM `content_temp` WHERE `user_id` = '".$_SESSION['_logged_id']."' ORDER BY `id` DESC");
			if(mysqli_num_rows($sql_uploader) == '0') {
				$fail = 1;
			} else {
				$content_temp = array();
				while($fetch_uploader = mysqli_fetch_array($sql_uploader)) {

					$sql_cont = mysqli_query($db,"SELECT * FROM `content` WHERE `id` = '".$fetch_uploader['cid']."' LIMIT 1");
					$fetch_cont = mysqli_fetch_array($sql_cont);
	
					$content_temp[] = array(
						'id'=>$fetch_cont['id'],
						'photo'=>$fetch_cont['photo'],
						'type'=>$fetch_cont['type'],
						'cover'=>$fetch_cont['cover']
					);

					mysqli_query($db,"DELETE FROM `content_temp` WHERE `user_id` = '".$_SESSION['_logged_id']."' AND `cid` = '".$fetch_uploader['cid']."' LIMIT 1");

				}
			}
		}

		if($fail == 1) {
			header('location: '.$settings['site_url']);
		}

	}

	if(isset($_GET['create_contest'])) {

		if(!is_logged()) {
			header('location: index.php');
			die();
		}

		if(isset($_GET['cid']) && is_numeric($_GET['cid'])) {
			$cid = mysqli_real_escape_string($db,$_GET['cid']);
			$check_contest = mysqli_query($db,"SELECT * FROM `contest` WHERE `creator` = '".$_SESSION['_logged_id']."' AND `id` = '".$cid."' LIMIT 1");
			if(mysqli_num_rows($check_contest)) {
				$site_contest = mysqli_fetch_array($check_contest);
				$site_contest['end'] = str_replace(' ','T',substr($site_contest['end'],0,16));
			} else {
				header('location: index.php');
			}
		} else {
			$site_contest = array();
		}

		$contest_error_msg = '';

		if(isset($_POST['remove_contest'])) {

			$extra_id = (isset($_GET['cid']) && is_numeric($_GET['cid']) ? $_GET['cid'] : 0);
			$sql_c = mysqli_query($db,"SELECT * FROM `contest` WHERE `id` = '".$extra_id."' AND `creator` = '".$_SESSION['_logged_id']."' LIMIT 1");
			if(mysqli_num_rows($sql_c) == '1') {
				mysqli_query($db,"DELETE FROM `contest` WHERE `id` = '".$extra_id."' AND `creator` = '".$_SESSION['_logged_id']."' LIMIT 1");
				mysqli_query($db,"UPDATE `content` SET `contest` = '0' WHERE `contest` = '".$extra_id."'");
			}

			header('location: /index.php?my_contests=1');

		}

		if(isset($_POST['submit'])) {

			$extra_id = (isset($_POST['extra_id']) && is_numeric($_POST['extra_id']) ? $_POST['extra_id'] : 0);
			
			$title = $description = $end = $disable_countdown = '';
			$end = '0000-00-00T00:00';

			if(isset($_POST['contest_title']) && $_POST['contest_title'] != '') {
				$title = mysqli_real_escape_string($db,$_POST['contest_title']);
			} 
		
			if(isset($_POST['contest_description']) && $_POST['contest_description'] != '') {
				$description = mysqli_real_escape_string($db,$_POST['contest_description']);
			}

			if(isset($_POST['contest_end']) && $_POST['contest_end'] != '') {
				$end = mysqli_real_escape_string($db,$_POST['contest_end']);
			}

			if(!$title) {
				$contest_error_msg = _LANG_CR_TITLE_REQ;
			}

			if(!$contest_error_msg) {

				$active_c = 0;
				$paid = 0;
				if((isset($settings['user_contest_price']) && $settings['user_contest_price'] == '0') || !isset($settings['user_contest_price'])) {
					$active_c = 1;
					$paid = 1;
				}

				if(isset($extra_id) && $extra_id != '0') {
					mysqli_query($db,"UPDATE `contest` SET `title` = '".$title."', `description` = '".$description."', `end` = '".$end."', `disable_countdown` = '0' WHERE `creator` = '".$_SESSION['_logged_id']."' AND `id` = '".$extra_id."' LIMIT 1");
				} else {
					mysqli_query($db,"INSERT INTO `contest` (`paid`,`creator`,`active`,`title`,`description`,`end`,`disable_countdown`) VALUES ('".$paid."','".$_SESSION['_logged_id']."','".$active_c."','".$title."','".$description."','".$end."','0')") or die(mysqli_error($db));
					$extra_id = mysqli_insert_id($db);
				}

				if(isset($extra_id) && is_numeric($extra_id) && $extra_id != '0') {

					mysqli_query($db,"DELETE FROM `contest_prizes` WHERE `contest_id` = '".$extra_id."'");
					if(isset($_POST['prize_name']) && count($_POST['prize_name'])) {
						for($i=0;$i<=count($_POST['prize_name'])-1;$i++) {
							if(isset($_POST['prize_name'][$i]) && trim($_POST['prize_name'][$i]) != '') {
								$prize_name = '';
								$prize_name = trim(strip_tags($_POST['prize_name'][$i]));
								$prize_name = mysqli_real_escape_string($db,$prize_name);
								$prize_description = '';
								if(isset($_POST['prize_description'][$i]) && trim($_POST['prize_description'][$i]) != '') {
									$prize_description = trim(strip_tags($_POST['prize_description'][$i]));
									$prize_description = mysqli_real_escape_string($db,$prize_description);
								}

								if($prize_name) {
									mysqli_query($db,"INSERT INTO `contest_prizes` (`contest_id`,`prize`,`description`) VALUES ('".$extra_id."','".$prize_name."','".$prize_description."')");
								}
							}
						}
					}

					mysqli_query($db,"DELETE FROM `contest_rules` WHERE `contest_id` = '".$extra_id."'");
					if(isset($_POST['rule_name']) && count($_POST['rule_name'])) {
						for($i=0;$i<=count($_POST['rule_name'])-1;$i++) {
							if(isset($_POST['rule_name'][$i]) && trim($_POST['rule_name'][$i]) != '') {
								$rule_name = '';
								$rule_name = trim(strip_tags($_POST['rule_name'][$i]));
								$rule_name = mysqli_real_escape_string($db,$rule_name);

								if($rule_name) {
									mysqli_query($db,"INSERT INTO `contest_rules` (`contest_id`,`rule`) VALUES ('".$extra_id."','".$rule_name."')");
								}
							}
						}
					}

				}

				header('location: index.php?contest='.$extra_id);


			}
			
		}

	}

	$footer_extra_pages = array();

	if(isset($settings['contact_page']) && $settings['contact_page'] == '1') {
		$footer_extra_pages[] = '<a href="'.$settings['site_url'].'index.php?contact=1">'._LANG_CONTACT_PAGE.'</a>';
	}

	$sql_footerlink = mysqli_query($db,"SELECT * FROM `pages` WHERE `footer` = '1' ORDER BY `id` ASC");
	if(mysqli_num_rows($sql_footerlink)) {
		while($fetch_links = mysqli_fetch_array($sql_footerlink)) {

			$footer_extra_pages[] = '<a href="'.$settings['site_url'].'index.php?extra_page='.$fetch_links['id'].'">'.$fetch_links['title'].'</a>';

		}
	}

	$show_popupad = 0;
	if(isset($_SESSION['popup_ad']) && $_SESSION['popup_ad'] == '1') {
		$show_popupad = 1;
		$_SESSION['popup_ad'] = 2;
		$sql_sg = mysqli_query($db,"SELECT * FROM `ads` WHERE `ad_position` = 'popup_ad' ORDER BY rand() LIMIT 1");
		if(mysqli_num_rows($sql_sg)) {
			$fetch_sg = mysqli_fetch_array($sql_sg);
			$popupad_title = $fetch_sg['ad_title'];
		} else {
			$show_popupad = 0;
		}
	}

	if(!isset($_SESSION['popup_ad'])) {
		$_SESSION['popup_ad'] = 1;
	}

	if(isset($settings['random_page']) && $settings['random_page'] == '1' && isset($_GET['random']) && $_GET['random'] == '1') {
		
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
			header('location: '.$settings['site_url'].'photo-'.$fetch_s['id']);
		} else {
			header('location: index.php');
		}

	}

	$preloader_show = 0;
	if(isset($settings['preloader']) && $settings['preloader'] == '1') {
		if(!isset($_SESSION['preloader'])) {
			$preloader_show = 1;
			$_SESSION['preloader'] = 1;
		}
	}

	if(isset($settings['site_url'])) {
		$site_url = $settings['site_url'];
	} else {
		$site_url = '';
	}		

	if(isset($_GET['settings']) && !is_logged()) {
		header('location: index.php');
	}

	if(!isset($settings['min_votes'])) {
		$settings['min_votes'] = 0;
	}

	$metatags = site_metatags((current_page() == 'photo' ? 'post':current_page()));

	$profile_rating = 0;
	if(isset($_GET['profile']) && $_GET['profile'] != '') {

		$profile_id = mysqli_real_escape_string($db,$_GET['profile']);
		$sql_profile = mysqli_query($db,"SELECT * FROM `users` WHERE `user` = '".$profile_id."' LIMIT 1");
		if(!mysqli_num_rows($sql_profile)) {
			header('location: '.$settings['site_url']);
			die();
		}

		$fetch_profile = mysqli_fetch_array($sql_profile);

		$fetch_profile['name'] = str_replace('"','',$fetch_profile['name']);
		$fetch_profile['slogan'] = str_replace('"','',$fetch_profile['slogan']);

		$metatags['title'] = str_replace(array('%name%','%user%','%slogan%'),array($fetch_profile['name'],$fetch_profile['user'],$fetch_profile['slogan']),$metatags['title']);
		$metatags['description'] = str_replace(array('%name%','%user%','%slogan%'),array($fetch_profile['name'],$fetch_profile['user'],$fetch_profile['slogan']),$metatags['description']);
		$metatags['keywords'] = str_replace(array('%name%','%user%','%slogan%'),array($fetch_profile['name'],$fetch_profile['user'],$fetch_profile['slogan']),$metatags['keywords']);

		$profile_id = $fetch_profile['id'];

		$count_sql = mysqli_query($db,"SELECT sum(nr_ratings) as 'total_ratings', sum(rating) as 'rate', sum(views) as 'total_views', count(*) as 'total_photos' FROM `content` WHERE `approved` = '1' AND `iduser` = '".$fetch_profile['id']."' LIMIT 1");
		$fetch_count = mysqli_fetch_array($count_sql);

		$count_not_sql = mysqli_query($db,"SELECT count(*) as 'total_not' FROM `content` WHERE `approved` = '0' AND `iduser` = '".$fetch_profile['id']."' LIMIT 1");
		$fetch_not_count = mysqli_fetch_array($count_not_sql);

		if($fetch_count['total_ratings'] > 0) {
			$profile_rating = $fetch_count['rate']/$fetch_count['total_photos'];
		} else {
			$profile_rating = '0.00';
		}
		if($profile_rating) { 
			$profile_rating = substr($profile_rating,0,4);
		}

	}

	if(isset($_GET['extra_page']) && is_numeric($_GET['extra_page'])) {

		$extra_page = mysqli_real_escape_string($db,$_GET['extra_page']);

		$sql_s = mysqli_query($db,"SELECT * FROM `pages` WHERE `id` = '".$extra_page."' LIMIT 1");
		if(mysqli_num_rows($sql_s)) {
			$fetch_s = mysqli_fetch_array($sql_s);
			$fetch_s['content'] = str_replace("\n","<br>",$fetch_s['content']);
			$extra_page_title = html_entity_decode($fetch_s['title']);
			$extra_page_content = html_entity_decode($fetch_s['content']);
		} else {
			$extra_page_title = '';
			$extra_page_content = '';
		}

	}

	if(isset($_GET['contact'])) {

		if(isset($_POST['submit'])) {

			$error_now = 0;

			if(isset($_POST['contact_name']) && $_POST['contact_name'] != '') {
				$contact_name = trim(strip_tags($_POST['contact_name']));
				$contact_name = mysqli_real_escape_string($db,$contact_name);
				if($contact_name == '') {
					$error_now = 2;
				}
			} else {
				$error_now = 2;
			}

			if(isset($_POST['contact_email']) && $_POST['contact_email'] != '') {
				$contact_email = trim(strip_tags($_POST['contact_email']));
				$contact_email = mysqli_real_escape_string($db,$contact_email);
				if($contact_email == '' || !filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
					$error_now = 3;
				}
			} else {
				$error_now = 3;
			}

			if(isset($_POST['contact_subject']) && $_POST['contact_subject'] != '') {
				$contact_subject = trim(strip_tags($_POST['contact_subject']));
				$contact_subject = mysqli_real_escape_string($db,$contact_subject);
				if($contact_subject == '') {
					$error_now = 4;
				}
			} else {
				$error_now = 4;
			}

			if(isset($_POST['contact_message']) && $_POST['contact_message'] != '') {
				$contact_message = trim(strip_tags($_POST['contact_message']));
				$contact_message = mysqli_real_escape_string($db,$contact_message);
				if($contact_message == '') {
					$error_now = 5;
				}
			} else {
				$error_now = 5;
			}

			if($error_now == '0' && isset($settings['site_email']) && $settings['site_email'] != '') {

				require 'PHPMailer/src/Exception.php';
				require 'PHPMailer/src/PHPMailer.php';
				require 'PHPMailer/src/SMTP.php';

				$mail = new PHPMailer\PHPMailer\PHPMailer();
				$mail->CharSet = 'UTF-8';

				try {

					if(isset($settings['smtp_host']) && $settings['smtp_host'] != '') {

  						$mail->setFrom($contact_email, $contact_name);
    						$mail->addAddress($settings['site_email'], $settings['site_logo']);
    						$mail->Subject = 'Contact '.$settings['site_logo'].': '.$contact_subject;
					
						$mail->Host = $settings['smtp_host'];
						$mail->SMTPAuth = true;
						$mail->Username = $settings['smtp_user'];
						$mail->Password = $settings['smtp_pass'];

						if(isset($settings['smtp_ssl']) && $settings['smtp_ssl'] == '1') {
							$mail->SMTPSecure = 'ssl';
						}

						$mail->Port = $settings['smtp_port'];

						$mail->Body = $contact_message;
    						$mail->IsHTML(true);
						$mail->send();

					} else {

  						$mail->setFrom($contact_email, $contact_name);
    						$mail->addAddress($settings['site_email'], $settings['site_logo']);
    						$mail->isHTML(true);
    						$mail->Subject = 'Contact '.$settings['site_logo'].': '.$contact_subject;
    						$mail->Body = $contact_message; 
    						$mail->send();
		
					}

				} catch (Exception $e) { }

			}

			if(!isset($settings['site_email'])) {
				$error_now = 1;
			}

			if($error_now == '0') {
				$success_msg = _LANG_CONTACT_PAGE_SUCCESS;
			}

			if($error_now == 1) {
				$error_msg = _LANG_CONTACT_PAGE_ERROR_6;
			}

			if($error_now == 2) {
				$error_msg = _LANG_CONTACT_PAGE_ERROR_2;
			}

			if($error_now == 3) {
				$error_msg = _LANG_CONTACT_PAGE_ERROR_3;
			}

			if($error_now == 4) {
				$error_msg = _LANG_CONTACT_PAGE_ERROR_4;
			}

			if($error_now == 5) {
				$error_msg = _LANG_CONTACT_PAGE_ERROR_5;
			}

		}

	}

	if(isset($_GET['photo']) && $_GET['photo'] != '') {

		$sql_photo = mysqli_query($db,"SELECT * FROM `content` WHERE `id` = '".mysqli_real_escape_string($db,$_GET['photo'])."' LIMIT 1");
		if(!mysqli_num_rows($sql_photo)) {
			header('location: index.php');
			die();
		}

		$photoid = mysqli_real_escape_string($db,$_GET['photo']);
		if(!isset($_SESSION['_update_view_'.$photoid])) {
			$_SESSION['_update_view_'.$photoid] = 1;
			mysqli_query($db,"UPDATE `content` SET `views` = `views`+1 WHERE `id` = '".mysqli_real_escape_string($db,$_GET['photo'])."' LIMIT 1");
		}

		$fetch_photo = mysqli_fetch_array($sql_photo);

		$photo_id = $fetch_photo['id'];
		$fetch_photo['rating'] = check_rating($fetch_photo['rating']);

		$sql_user = mysqli_query($db,"SELECT * FROM `users` WHERE `id` = '".$fetch_photo['iduser']."' LIMIT 1");
		$fetch_user = mysqli_fetch_array($sql_user);

		if($fetch_photo['contest'] != '0' || $multi_contest == '1') {

			mysqli_query($db,"SET @rank := 0");
			$sql_rank = mysqli_query($db,"SELECT `rank`,`id`,`contest` FROM (SELECT (@rank := @rank + 1) AS 'rank', `id`, `contest` FROM `content` WHERE `contest` = '".$fetch_photo['contest']."' ORDER BY `rating` DESC, `nr_ratings` DESC) temp WHERE `id` = '".$_GET['photo']."'") or die(mysqli_error($db));
			$fetch_rank = mysqli_fetch_array($sql_rank);

			if($settings['min_votes'] > $fetch_photo['nr_ratings']) {
				$fetch_rank['rank'] = '';
			}

			$site_contest = get_contest($fetch_photo['contest']);

		} else {
			$fetch_rank['rank'] = '';
		}

		$sql_exif = mysqli_query($db,"SELECT * FROM `content_exif` WHERE `photo_id` = '".$photo_id."' LIMIT 1");
		if(mysqli_num_rows($sql_exif)) {
			$photo_exif = mysqli_fetch_array($sql_exif);
		} else {
			$photo_exif = array('make'=>'','model'=>'','exposure'=>'','aperture'=>'','date'=>'','iso'=>'');
		}

		$i_rated = i_rated($photo_id);

		$fetch_user['name'] = str_replace('"','',$fetch_user['name']);

		$metatags['title'] = str_replace(array('%name%','%rank%','%rating%','%votes%'),array($fetch_user['name'],$fetch_rank['rank'],$fetch_photo['rating'],$fetch_photo['nr_ratings']),$metatags['title']);
		$metatags['description'] = str_replace(array('%name%','%rank%','%rating%','%votes%'),array($fetch_user['name'],$fetch_rank['rank'],$fetch_photo['rating'],$fetch_photo['nr_ratings']),$metatags['description']);
		$metatags['keywords'] = str_replace(array('%name%','%rank%','%rating%','%votes%'),array($fetch_user['name'],$fetch_rank['rank'],$fetch_photo['rating'],$fetch_photo['nr_ratings']),$metatags['keywords']);

		if(isset($settings['description_links']) && $settings['description_links'] == '1') {

			if(strstr($fetch_photo['description'],'<a href="') && !strstr($fetch_photo['description'],'target="_blank"')) {
				$fetch_photo['description'] = str_replace('<a href="','<a target="_blank" href="',$fetch_photo['description']);
			}

			if(strstr($fetch_photo['description'],"<a href='") && !strstr($fetch_photo['description'],"target='_blank'")) {
				$fetch_photo['description'] = str_replace("<a href='","<a target='_blank' href='",$fetch_photo['description']);
			}

		}

		$sql_similar_photos = mysqli_query($db,"SELECT * FROM `content` WHERE `id` != '".$photo_id."' AND `iduser` = '".$fetch_user['id']."' ORDER BY rand() LIMIT 9");

	}

	if(isset($_GET['contest']) && is_numeric($_GET['contest'])) {

		if($multi_contest == '2' && is_logged()) {
			$sql_r05 = mysqli_query($db,"SELECT * FROM `content` WHERE `iduser` = '".$_SESSION['_logged_id']."' AND `contest` = '".mysqli_real_escape_string($db,$_GET['contest'])."' ORDER BY `rating` DESC, `nr_ratings` DESC LIMIT 50");
		}

		$sql_prizes = mysqli_query($db,"SELECT * FROM `contest_prizes` WHERE `contest_id` = '".mysqli_real_escape_string($db,$_GET['contest'])."' ORDER BY `id` ASC");
		$sql_rules = mysqli_query($db,"SELECT * FROM `contest_rules` WHERE `contest_id` = '".mysqli_real_escape_string($db,$_GET['contest'])."' ORDER BY `id` ASC");		

		mysqli_query($db,"SET @rank := 0");
		if($multi_contest == '2') {
			$sql_r04 = mysqli_query($db,"SELECT `type`,`cover`, `rank`,`id`,`contest`,`photo` FROM (SELECT (@rank := @rank + 1) AS 'rank', `id`, `type`,`cover`, `photo`,`contest` FROM `content` WHERE `nr_ratings` >= '".$settings['min_votes']."' AND `contest` = '".mysqli_real_escape_string($db,$_GET['contest'])."' ORDER BY `rating` DESC, `nr_ratings` DESC) temp LIMIT 5") or die(mysqli_error($db));
		} else {
			$sql_r04 = mysqli_query($db,"SELECT `type`,`cover`, `rank`,`id`,`contest`,`photo` FROM (SELECT (@rank := @rank + 1) AS 'rank', `id`, `type`,`cover`, `photo`,`contest` FROM `content` WHERE `nr_ratings` >= '".$settings['min_votes']."' ORDER BY `rating` DESC, `nr_ratings` DESC) temp LIMIT 5") or die(mysqli_error($db));
		}

	}

	if(isset($_GET['forgot']) && !is_logged()) {

		$forgot_key = mysqli_query($db,"SELECT `id` FROM `users` WHERE MD5(CONCAT(password,registered)) = '".mysqli_real_escape_string($db,$_GET['forgot'])."' LIMIT 1");
		if(!mysqli_num_rows($forgot_key)) {
			header('location: '.$settings['site_url']);
		} else {
			$new_i = mysqli_fetch_array($forgot_key);
		}

		if(isset($_POST['submit']) && isset($_POST['set_pw_2']) && isset($_POST['set_pw_3']) && isset($new_i['id'])) {

			if(strlen($_POST['set_pw_2']) < 6) {
				$error_msg = _LANG_PASSWORD_AT_LEAST;
			} else {
				if($_POST['set_pw_2'] != $_POST['set_pw_3']) {
					$error_msg = _LANG_PASSWORD_MUST_MATCH;
				} else {
						
					$set_pw_2 = mysqli_real_escape_string($db,$_POST['set_pw_2']);
					mysqli_query($db,"UPDATE `users` SET `password` = '".hash('sha512',$set_pw_2)."' WHERE `id` = '".$new_i['id']."' LIMIT 1");
					$success_msg = _LANG_PASSWORD_CHANGED;

				}
			}

		}

	}

	if(isset($_GET['settings']) && is_logged()) {

		if(isset($_GET['changepw'])) {

			if(isset($_POST['submit']) && isset($_POST['set_pw_2']) && isset($_POST['set_pw_3'])) {

				if(isset($_POST['set_pw_1'])) {
					$set_pw_1 = mysqli_real_escape_string($db,$_POST['set_pw_1']);
				} else {
					$set_pw_1 = '';
				}

				if(strlen($_POST['set_pw_2']) < 6) {
					$error_msg = _LANG_PASSWORD_AT_LEAST;
				} else {
					if($_POST['set_pw_2'] != $_POST['set_pw_3']) {
						$error_msg = _LANG_PASSWORD_MUST_MATCH;
					} else {
						
						if(!isset($_POST['set_pw_1'])) {
							$set_pw_2 = mysqli_real_escape_string($db,$_POST['set_pw_2']);
							mysqli_query($db,"UPDATE `users` SET `password` = '".hash('sha512',$set_pw_2)."' WHERE `id` = '".$_SESSION['_logged_id']."' LIMIT 1");
							$success_msg = _LANG_PASSWORD_CHANGED;
						} else {

							$check_pass = mysqli_query($db,"SELECT count(*) as 'total' FROM `users` WHERE `id` = '".$_SESSION['_logged_id']."' AND `password` = '".hash('sha512',$set_pw_1)."' LIMIT 1");
							$fetch_pass = mysqli_fetch_array($check_pass);
							if($fetch_pass['total'] == '0') {
								$error_msg = _LANG_PASSWORD_INCORRECT;
							} else {
								$set_pw_2 = mysqli_real_escape_string($db,$_POST['set_pw_2']);
								mysqli_query($db,"UPDATE `users` SET `password` = '".hash('sha512',$set_pw_2)."' WHERE `id` = '".$_SESSION['_logged_id']."' LIMIT 1");
								$success_msg = _LANG_PASSWORD_CHANGED;
							}
						}

					}
				}

			}

		}

		if(!isset($_GET['changepw'])) {

			if(isset($_POST['submit']) && isset($_POST['set_name']) && isset($_POST['set_email'])) {
	
				$ok_submit = 0;

				$name = mysqli_real_escape_string($db,$_POST['set_name']);
				$email = mysqli_real_escape_string($db,$_POST['set_email']);
				$category = (isset($_POST['set_category']) && $_POST['set_category'] ? mysqli_real_escape_string($db,$_POST['set_category']) : 0);
				$slogan = trim(isset($_POST['set_slogan']) && $_POST['set_slogan'] ? mysqli_real_escape_string($db,$_POST['set_slogan']) : '');
	
				$name = strip_tags($name);
				$email = strip_tags($email);
				$slogan = strip_tags($slogan);

				$check_mail = mysqli_query($db,"SELECT count(*) as 'total' FROM `users` WHERE `email` = '".$email."' AND `id` != '".$_SESSION['_logged_id']."' LIMIT 1");
				$fetch_mail = mysqli_fetch_array($check_mail);

				if($fetch_mail['total'] == '0') {

					if($settings['category_required'] == '1' && $category == '0') {
						$error_msg = _LANG_REGISTER_ERROR_CATEGORY;
					} else {

						mysqli_query($db,"UPDATE `users` SET `category` = '".$category."', `slogan` = '".$slogan."', `name` = '".$name."', `email` = '".$email."' WHERE `id` = '".$_SESSION['_logged_id']."' LIMIT 1");
						if($category) {
							mysqli_query($db,"UPDATE `content` SET `category` = '".$category."' WHERE `iduser` = '".$_SESSION['_logged_id']."'");
						}

						$_SESSION['_logged_name'] = $name;

						$success_msg = _LANG_CHANGES_SAVED;

					}

				} else {
					$error_msg = _LANG_REGISTER_ERROR_EMAIL_EXISTS;
				}

			}

		}

		$get_user_settings = mysqli_query($db,"SELECT * FROM `users` WHERE `id` = '".$_SESSION['_logged_id']."' LIMIT 1");
		if(!mysqli_num_rows($get_user_settings)) {
			header('location: index.php');
			die();
		} else {

			$user_settings = mysqli_fetch_array($get_user_settings);

		}		

	}
?>