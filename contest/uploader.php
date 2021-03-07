
	<div class="celling_settings margin_top30 uploader17">

		<div class="uploader17_title">
			<h2><?=_LANG_FILES_UPLOADED;?></h2>
		</div>

		<form action="" method="post">

		<?php
		if(isset($content_temp) && count($content_temp)) {

			foreach($content_temp as $temp_c) {

				if($temp_c['type'] == '0') {
					$thumb_picture = $settings['site_url'].'_uploads/_photos/'.$temp_c['photo'].'_400.jpg';
				}

				if($temp_c['type'] == '1') {
					if(strlen($temp_c['cover']) > 5) {
						$thumb_picture = $settings['site_url'].'_uploads/_content_cover/'.$temp_c['cover'].'_400.jpg';
					} else {
						$thumb_picture = $settings['site_url'].'_img/no_thumb_music.jpg';
					}
				}

				if($temp_c['type'] == '2' || $temp_c['type'] == '4') {
					if(strlen($temp_c['cover']) > 5) {
						$thumb_picture = $settings['site_url'].'_uploads/_content_cover/'.$temp_c['cover'].'_400.jpg';
					} else {
						$thumb_picture = $settings['site_url'].'_img/no_thumb_video.jpg';
					}
				}

				echo '
				<div class="uploader17_item">
					<div class="uploader17_item_left">
						<img class="cover_for_'.$temp_c['id'].'" src="'.$thumb_picture.'" />
						<div class="temp_change_photo_cover" data-id="'.$temp_c['id'].'">'._LANG_CONTENT_COVER_CHANGE.'</div>
					</div>
					<div class="uploader17_item_right">
						<textarea name="desc_for_'.$temp_c['id'].'" class="uploader17_textarea" placeholder="'._LANG_POP_EDIT_PHOTO_PLACEHOLDER.'"></textarea>
					</div>
				</div>';

			}

			echo '
			<div class="uploader17_footer">
				<input type="submit" value="'._LANG_POP_SAVE_PHOTO.'" class="uploader17_submit" name="submit_uploader" />
			</div>';

		}
		?>

		</form>

	</div>