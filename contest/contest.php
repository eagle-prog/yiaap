
	<?php
	$is_allow_join = 0;
	$see_active = 0;
	if($site_contest['active'] == '1') {
		if(isset($_SESSION['_logged_id'])) {
			$is_allow_join = paid_contest_entry($site_contest['id']);
		}
		$see_active = 1;
	}
	if(isset($_SESSION['_logged_id']) && $_SESSION['_logged_id'] == $site_contest['creator'] && $_SESSION['_logged_id'] != '0') {
		$see_active = 1;
	}

	$is_my_contest = 0;
	if(isset($_SESSION['_logged_id']) && $_SESSION['_logged_id'] == $site_contest['creator'] && $_SESSION['_logged_id'] != '0') {
		$is_my_contest = 1;
	}
	?>

	<?php if($see_active == '0') { ?>

	<div class="contest_header">

		<div class="contest_header_sub">

			<div class="contest_header_box">
				<div class="contest_header_icon"><i class="fas fa-crown"></i></div>
				<div class="c cs3"><?=_LANG_NO_CONTEST_ACTIVE;?></div>
			</div>

		</div>

	</div>

	<?php } else { ?>

	<?php
	if($is_my_contest == '1' && $site_contest['paid'] == '0') {
		echo '<div class="unpaid_contest">'._LANG_NOPAID_CONTEST.' <span class="buy_contest_click" data-id="'.$site_contest['id'].'">'._LANG_PAYNOW_CONTEST.'</span></div>';
	}
	?>

	<div class="contest_header">

		<div class="contest_header_sub">

			<div class="contest_header_box">
				<div class="contest_header_icon"><i class="fas fa-crown"></i></div>

				<div class="c cs2"><?=$site_contest['title'];?></div>
				<div class="c cs3"><?=$site_contest['description'];?></div>
			</div>

			<?php if($is_my_contest == '1') { ?>
			<div class="editcm">
				<a href="<?=$settings['site_url'];?>/index.php?create_contest=1&cid=<?=$site_contest['id'];?>">
					<div class="editcm_click"><?=_LANG_EDIT_CONTEST;?>&nbsp;&nbsp;<i class="fa fa-pencil-alt"></i></div>		
				</a>
			</div>
			<?php } ?>
			
			<?php if($site_contest['disable_countdown'] == '0') { ?>

			<div class="contest_header_timer">
				<div class="contest_timer_box ct_1">-</div>
				<div class="contest_timer_box ct_2">-</div>
				<div class="contest_timer_box ct_3">-</div>
				<div class="contest_timer_box ct_4">-</div>
			</div>

			<div class="contest_header_tile">
				<div class="contest_timer_tile"><?=_LANG_DAYS;?></div>
				<div class="contest_timer_tile"><?=_LANG_HOURS;?></div>
				<div class="contest_timer_tile"><?=_LANG_MINUTES;?></div>
				<div class="contest_timer_tile"><?=_LANG_SECONDS;?></div>
			</div>

			<?php } ?>

		</div>

	</div>

	<?php if(($multi_contest == '2' || (isset($settings['contest_entry_fee']) && $settings['contest_entry_fee'])) && is_logged() && $site_contest['active'] == '1') { ?>

	<div class="pop_my_photos">
		<div class="pop_join_contest_box">
			<div class="load_my_photos"></div>	
			<div class="join_contest_buttons">
				<div class="click_join_contest"><?=_LANG_SUBMIT;?></div>
				<div class="cancel_contest_join"><?=_LANG_CANCEL;?></div>
			</div>
		</div>
	</div>

	<div class="multi_contest_box">

	<div class="contest_ranking">

		<div class="contest_rankings_box">

			<div class="c cs3 lr565 mphotos_title all_black"><?=_LANG_MY_PHOTOS;?></div>

			<div class="contest_ranking_list dragscroll">

			<?php
			$place = 1;
			if(mysqli_num_rows($sql_r05) == '0') {
				echo '<div class="multi_contest_box_msg all_black">'._LANG_CONTEST_JOIN_NO_PHOTOS.'</div>';
			}
			while($fetch_r = mysqli_fetch_array($sql_r05)) {

				if($fetch_r['type'] == '0') {
					$thumb_picture = $settings['site_url'].'_uploads/_photos/'.$fetch_r['photo'].'_400.jpg';
				}

				if($fetch_r['type'] == '1') {
					if($fetch_r['cover']) {
						$thumb_picture = $settings['site_url'].'_uploads/_content_cover/'.$fetch_r['cover'].'_400.jpg';
					} else {
						$thumb_picture = $settings['site_url'].'_img/no_thumb_music.jpg';
					}
				}

				if($fetch_r['type'] == '2' || $fetch_r['type'] == '4') {
					if($fetch_r['cover']) {
						$thumb_picture = $settings['site_url'].'_uploads/_content_cover/'.$fetch_r['cover'].'_400.jpg';
					} else {
						$thumb_picture = $settings['site_url'].'_img/no_thumb_video.jpg';
					}
				}
			
				echo '
				<div class="contest_thumb">
					<a href="photo-'.$fetch_r['id'].'">
						<div class="thumb_option_place remove_contest_photo" data-id="'.$fetch_r['id'].'">&nbsp;&#10005;&nbsp;</div>
						<img src="'.$thumb_picture.'" />
					</a>
				</div>';
	
				$place++;

			}
			?>

			</div>
		</div>
		
		<?php if($is_allow_join == '0') { ?>

			<div class="contest_header_timer payjoin_box">
				<div class="payjoin_white"><?=_LANG_PRICE_TO_JOIN;?> <b><?=$settings['contest_entry_fee'];?> <?=$settings['paypal_currency'];?></b></div>
				<div class="paynow_joincontest" data-id="<?=$site_contest['id'];?>"><?=_LANG_PAYNOW_CONTEST;?></div>
			</div>

		<?php } else { ?>
			<div class="open_my_photos margin_top_10"><?=_LANG_SUBMIT_PHOTO;?></div>
		<?php } ?>

	</div>

	</div>

	<?php } ?>

	<?php if(mysqli_num_rows($sql_prizes) || mysqli_num_rows($sql_rules)) { ?>
	<div class="extra_bcontest">

		<div class="click_ctab click_ctab_h" data-id="ranking"><?=_LANG_RANKING;?>&nbsp;&nbsp;<i class="fas fa-chevron-down"></i></div>
		<?php if(mysqli_num_rows($sql_prizes)) { ?><div class="click_ctab click_ctab_m" data-id="prizes"><?=_LANG_PRIZES;?>&nbsp;&nbsp;<i class="fas fa-chevron-down"></i></div><?php } ?>
		<?php if(mysqli_num_rows($sql_rules)) { ?><div class="click_ctab click_ctab_m" data-id="rules"><?=_LANG_RULES;?>&nbsp;&nbsp;<i class="fas fa-chevron-down"></i></div><?php } ?>

	</div>
	<?php } ?>

	<?php if(mysqli_num_rows($sql_prizes)) { ?>
	
	<div class="contest_page_tab hide" data-id="prizes">

		<div class="contest_ranking">

			<div class="contest_ranking_box contest_rkbox">

				<?php
				while($fetch_prize = mysqli_fetch_array($sql_prizes)) {

					echo '
					<div class="prize_list_item">
						<div class="prize_list_item_name">'.$fetch_prize['prize'].'</div>
						<div class="prize_list_item_description">'.$fetch_prize['description'].'</div>
					</div>';
		
				}
				?>

			</div>

		</div>

	</div>

	<?php } ?>

	<?php if(mysqli_num_rows($sql_rules)) { ?>
	
	<div class="contest_page_tab hide" data-id="rules">

		<div class="contest_ranking">

			<div class="contest_ranking_box contest_rkbox">

				<?php
				while($fetch_rule = mysqli_fetch_array($sql_rules)) {

					echo '
					<div class="rules_list_item">
						<div class="rules_list_item_name">'.$fetch_rule['rule'].'</div>
					</div>';
		
				}
				?>

			</div>

		</div>

	</div>

	<?php } ?>

	<div class="contest_page_tab show" data-id="ranking">

		<?php if(mysqli_num_rows($sql_prizes)== '0' && mysqli_num_rows($sql_rules) == '0') { ?>
		<div class="contest_ranking_box">

			<div class="contest_ranking_icon"><i class="fas fa-chart-line"></i></div>
			<div class="c cs3 lr565 all_black"><?=_LANG_CONTEST_RANKING;?></div>

		</div>
		<?php } ?>

		<div class="contest_ranking">

			<div class="contest_rankings_box">
				<div class="contest_ranking_list dragscroll">

				<?php
				if(!isset($settings['min_votes'])) {
					$settings['min_votes'] = 0;
				}
				if(mysqli_num_rows($sql_r04) == '0') {
					echo '<div class="contest_no_photos show">'._LANG_CONTEST_NO_PHOTOS.'</div>';
				}
				while($fetch_r = mysqli_fetch_array($sql_r04)) {

					if($fetch_r['type'] == '0') {
						$thumb_picture = $settings['site_url'].'_uploads/_photos/'.$fetch_r['photo'].'_400.jpg';
					}

					if($fetch_r['type'] == '1') {
						if($fetch_r['cover']) {
							$thumb_picture = $settings['site_url'].'_uploads/_content_cover/'.$fetch_r['cover'].'_400.jpg';
						} else {
							$thumb_picture = $settings['site_url'].'_img/no_thumb_music.jpg';
						}
					}

					if($fetch_r['type'] == '2' || $fetch_r['type'] == '4') {
						if($fetch_r['cover']) {
							$thumb_picture = $settings['site_url'].'_uploads/_content_cover/'.$fetch_r['cover'].'_400.jpg';
						} else {
							$thumb_picture = $settings['site_url'].'_img/no_thumb_video.jpg';
						}
					}

					$place = $fetch_r['rank'];
					$crown = '';
					if($place == '1') {
						$crown = '<div class="thumb_ranking_crown"><i class="fas fa-crown"></i></div>';
					}

					echo '
					<div class="contest_thumb">
						<a href="photo-'.$fetch_r['id'].'">
							<div class="thumb_ranking_place">'.$place.'</div>
							'.$crown.'
							<img src="'.$thumb_picture.'" />
						</a>
					</div>';

				}
				?>

				</div>
			</div>
		</div>

	</div>

	<?php } ?>