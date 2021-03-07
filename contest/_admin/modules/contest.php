
	<div class="padding_20">

		<?php if(isset($contest_error_msg) && $contest_error_msg) { ?><div class="error_box"><?=$contest_error_msg;?></div><?php } ?>

		<div class="settings_results">

			<form action="index.php?page=contest<?=(isset($cid) && is_numeric($cid) ? '&cid='.$cid : '');?>" method="post">

			<?php if(isset($cid) && is_numeric($cid)) { ?>
			<input type="hidden" name="extra_id" value="<?=$cid;?>" />
			<?php } ?>

			<div class="setting">
				<div class="setting_left">Active contest</div>
				<div class="setting_right">
					<select name="contest_active">
						<option value="1" <?=(isset($site_contest['active']) && $site_contest['active'] == '1' ? 'selected':'');?>>Yes</option>
						<option value="0" <?=(isset($site_contest['active']) && $site_contest['active'] == '0' ? 'selected':'');?>>No</option>
					</select>
				</div>
			</div>

			<div class="setting">
				<div class="setting_left">Title</div>
				<div class="setting_right">
					<input type="text" placeholder="My contest ..." value="<?=(isset($site_contest['title']) ? $site_contest['title'] : '');?>" name="contest_title" />
				</div>
			</div>

			<div class="setting">
				<div class="setting_left">Description</div>
				<div class="setting_right">
					<input type="text" placeholder="My contest is ..." value="<?=(isset($site_contest['description']) ? $site_contest['description'] : '');?>" name="contest_description" />
				</div>
			</div>

			<div class="setting">
				<div class="setting_left">Finish date</div>
				<div class="setting_right">
					<input type="datetime-local" value="<?=(isset($site_contest['end']) ? $site_contest['end'] : '');?>" name="contest_end" />
				</div>
			</div>

			<div class="setting">
				<div class="setting_left">Disable countdown</div>
				<div class="setting_right">
					<select name="disable_countdown">
						<option value="0" <?=(isset($site_contest['disable_countdown']) && $site_contest['disable_countdown'] == '0' ? 'selected':'');?>>No</option>
						<option value="1" <?=(isset($site_contest['disable_countdown']) && $site_contest['disable_countdown'] == '1' ? 'selected':'');?>>Yes</option>
					</select>
				</div>
			</div>

			<div class="slash"></div>

			<div class="setting">
				<div class="setting_left">Prizes</div>
				<div class="setting_right">
					<div class="prizes">
						<?php
						if(isset($site_contest['id']) && is_numeric($site_contest['id'])) {
							$sql_prizes = mysqli_query($db,"SELECT * FROM `contest_prizes` WHERE `contest_id` = '".$site_contest['id']."' ORDER BY `id` ASC");
							while($fetch_prizes = mysqli_fetch_array($sql_prizes)) {
								echo '
								<div style="margin-bottom:15px;">
									<input type="text" maxlength="100" name="prize_name[]" value="'.$fetch_prizes['prize'].'" placeholder="Prize name" /><br>
									<input type="text" maxlength="1000" name="prize_description[]" value="'.$fetch_prizes['description'].'" placeholder="Prize description (optional)" />
								</div>';
							}
						}
						?>
					</div>
					<div style="background:#fff;color:#222;cursor:pointer;padding:12px;border-radius:4px;display:inline-block;clear:both;" class="more_prizes">
						+ Prizes
					</div>
				</div>
			</div>

			<div class="setting">
				<div class="setting_left">Rules</div>
				<div class="setting_right">
					<div class="rules">
						<?php
						if(isset($site_contest['id']) && is_numeric($site_contest['id'])) {
							$sql_rules = mysqli_query($db,"SELECT * FROM `contest_rules` WHERE `contest_id` = '".$site_contest['id']."' ORDER BY `id` ASC");
							while($fetch_rules = mysqli_fetch_array($sql_rules)) {
								echo '
								<div style="margin-bottom:15px;">
									<input type="text" maxlength="250" name="rule_name[]" value="'.$fetch_rules['rule'].'" placeholder="Rule ..." /><br>
								</div>';
							}
						}
						?>
					</div>
					<div style="background:#fff;color:#222;cursor:pointer;padding:12px;border-radius:4px;display:inline-block;clear:both;" class="more_rules">
						+ Rules
					</div>
				</div>
			</div>

			<div class="setting">
				<div class="setting_left">&nbsp;</div>
				<div class="setting_right">
					<input type="submit" name="submit" value="Save changes" class="st_svb" />
				</div>
			</div>

			</form>

		</div>

	</div>