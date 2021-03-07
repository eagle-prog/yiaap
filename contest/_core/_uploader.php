<?php
session_start();

	require_once('_functions.php');

	$settings = get_settings();
	if($settings['photo_approval'] == '1') {
		$approved = 0;
	} else {
		$approved = 1;
	}

	if(!isset($_SESSION['_logged'])) {
		return json_encode(array('files'=>''));
		die();
	}

	if(isset($_POST['content_category_id']) && is_numeric($_POST['content_category_id']) && $_POST['content_category_id'] != '0') {
		$get_user_category = mysqli_real_escape_string($db,$_POST['content_category_id']);
	} else {
		$get_user_category = get_logged_user_category();
	}

	set_time_limit(600);
	$err = array();
	$files = array();

	$oks = 0;

	$sql_ci = mysqli_query($db,"SELECT * FROM `contest` WHERE `active` = '1' AND `end` > NOW() LIMIT 2");
	if(mysqli_num_rows($sql_ci) == '1') {

		$fetch_ci = mysqli_fetch_array($sql_ci);

		if(paid_contest_entry($fetch_ci['id']) != '0') {
			$contest_id = $fetch_ci['id'];
		} else {
			$contest_id = 0;
		}

	} else {
		$contest_id = 0;
	}

	if(isset($_FILES['_uploader']) && (isset($_FILES['_uploader']['name']) && count($_FILES['_uploader']['name']))) {

		mysqli_query($db,"DELETE FROM `content_temp` WHERE `user_id` = '".$_SESSION['_logged_id']."' OR `data` < '".date('Y-m-d H:i:s', strtotime('-1 hour'))."'");

		for($i=0;$i<=count($_FILES['_uploader']['name'])-1;$i++) {

    			$mime = is_valid_image($_FILES['_uploader']['tmp_name'][$i]);
			if(!$mime) {
				$mime = $_FILES['_uploader']['type'][$i];
			}

			$ext = false;

			$type = 0;

			$photo_id = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVXYZ"), 0, 20);
	
    			$ok = false;
    			switch ($mime) {
       		 		case 'image/jpg': $ext = 'jpg'; $ok = true; break;
				case 'image/jpeg': $ext = 'jpeg'; $ok = true; break;
				case 'image/png': $ext = 'png'; $ok = true; break;
				case 'image/gif': $ext = 'gif'; $ok = true; break;
				case 'audio/mpeg': $ext = 'mp3'; $ok = true; break;
				case 'video/mp4': $ext = 'mp4'; $ok = true; break;
        		}
		
			if($ok) {
				
				if($ext == 'mp3') {
					$type = 1;
					$image_path = '../_uploads/_music/'.$photo_id.'.mp3';
				} elseif($ext == 'mp4') {
					$type = 2;
					$image_path = '../_uploads/_videos/'.$photo_id.'.mp4';
				} else {
					$image_path = '../_uploads/_photos/'.$photo_id.'.jpg';
				}

				if(move_uploaded_file($_FILES['_uploader']['tmp_name'][$i], $image_path)) {

					if($ext == 'jpeg') {
						$exif_data = get_exif_photo($image_path);
						correct_exif_rotation($image_path);
					} else {
						$exif_data = false;
					}

					if($ext != 'mp3' && $ext != 'mp4') {
						compress_image($image_path, 70);
						crop_image($image_path, '../_uploads/_photos/'.$photo_id.'_400.jpg', 400, 400);
					
						if($ext != 'gif' && isset($settings['watermark']) && $settings['watermark'] == '1' && isset($settings['watermark_image']) && file_exists('../'.$settings['watermark_image'])) {
							apply_watermark($image_path, '../'.$settings['watermark_image'], $settings['watermark_position'], $settings['watermark_opacity']);
						}
					}

					if($ext == 'mp4') {

						if(isset($settings['content_ffmpeg']) && $settings['content_ffmpeg'] == '1') {
						
							$var = shell_exec('which ffmpeg');
							if($var === null) {
								// no ffmpeg installed - skip
							} else {
								$image_path_cover = '../_uploads/_content_cover/'.$photo_id.'.jpg';
								exec("ffmpeg -i ../_uploads/_videos/".$photo_id.".mp4 -vf fps=1/60 ".$image_path_cover);

								compress_image($image_path_cover, 70);
								crop_image($image_path_cover, '../_uploads/_content_cover/'.$photo_id.'_400.jpg', 400, 400);
					
								if(isset($settings['watermark']) && $settings['watermark'] == '1' && isset($settings['watermark_image']) && file_exists('../'.$settings['watermark_image'])) {
									apply_watermark($image_path_cover, '../'.$settings['watermark_image'], $settings['watermark_position'], $settings['watermark_opacity']);
								}

								$image_cover = $photo_id;
							}

						}

					}

					mysqli_query($db,"INSERT INTO `content` (`contest`,`type`,`iduser`,`photo`,`approved`,`category`) VALUES ('".$contest_id."','".$type."','".$_SESSION['_logged_id']."','".$photo_id."','".$approved."','".$get_user_category."')");
					$db_id = mysqli_insert_id($db);
					if($db_id) {
	
						mysqli_query($db,"INSERT IGNORE INTO `content_temp` (`user_id`,`cid`) VALUES ('".$_SESSION['_logged_id']."','".$db_id."')");

						if(isset($image_cover)) {
							mysqli_query($db,"UPDATE `content` SET `cover` = '".$image_cover."' WHERE `id` = '".$db_id."' LIMIT 1");
						}

						if($exif_data) {

							if(isset($exif_data['iso']) && $exif_data['iso'] != '') {
								$exif_iso = $exif_data['iso'];
							} else {
								$exif_iso = 0;
							}

							mysqli_query($db,"INSERT INTO `content_exif` (`photo_id`,`make`,`model`,`exposure`,`aperture`,`date`,`iso`) VALUES ('".$db_id."','".$exif_data['make']."','".$exif_data['model']."','".$exif_data['exposure']."','".$exif_data['aperture']."','".$exif_data['date']."','".$exif_iso."')");

						}

						$oks = 1;
						if($approved == '1') {
							$files[] = array(
								'ratings'=>0,
								'rate'=>'0',
								'rate_real'=>'0.00',
								'iduser'=>$_SESSION['_logged_id'],
								'photo'=>$photo_id,
								'id'=>$db_id,
								'type'=>$type,
							);
						}
					}

				}
	
			}

		}
	
	}
	
	$ret = array('ok'=>$oks,'files'=>$files);
	echo json_encode($ret);
?>