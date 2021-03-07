
<div class="celling_settings margin_top30 mh99">

	<div class="create_contest relative">

		<div class="create_c_title"><?=_LANG_CREATE_CONTEST;?></div>
		<?php if(isset($settings['user_contest_price']) && $settings['user_contest_price'] > 0) { ?>
		<div class="create_c_subtitle"><?=_LANG_CREATE_CONTEST_COST;?> <b><?=$settings['user_contest_price'];?> <?=(isset($settings['paypal_currency']) ? $settings['paypal_currency'] : 'USD');?></b></div>
		<?php } ?>

		<?php if(isset($contest_error_msg) && $contest_error_msg) { ?><div class="error_box"><?=$contest_error_msg;?></div><?php } ?>

		<div class="settings_results">

			<form action="index.php?create_contest=1<?=(isset($cid) && is_numeric($cid) ? '&cid='.$cid : '');?>" method="post">

			<?php if(isset($cid) && is_numeric($cid)) { ?>
			<input type="hidden" name="extra_id" value="<?=$cid;?>" />
			<?php } ?>

			<div class="setting setting_cont">
				<div class="setting_left"><?=_LANG_CR_CONTEST_TITLE;?></div>
				<div class="setting_right">
					<input type="text" placeholder="<?=_LANG_CR_CONTEST_TITLE;?>" value="<?=(isset($site_contest['title']) ? $site_contest['title'] : '');?>" name="contest_title" />
				</div>
			</div>

			<div class="setting setting_cont">
				<div class="setting_left"><?=_LANG_CR_CONTEST_DESC;?></div>
				<div class="setting_right">
					<input type="text" placeholder="<?=_LANG_CR_CONTEST_DESC;?>" value="<?=(isset($site_contest['description']) ? $site_contest['description'] : '');?>" name="contest_description" />
				</div>
			</div>

			<div class="setting setting_cont">
				<div class="setting_left"><?=_LANG_CR_CONTEST_FINISH;?></div>
				<div class="setting_right">
					<input type="datetime-local" value="<?=(isset($site_contest['end']) ? $site_contest['end'] : '');?>" name="contest_end" />
				</div>
			</div>

			<div class="slash"></div>

			<div class="setting setting_cont">
				<div class="setting_left"><?=_LANG_PRIZES;?></div>
				<div class="setting_right">
					<div class="prizes">
						<?php
						if(isset($site_contest['id']) && is_numeric($site_contest['id'])) {
							$sql_prizes = mysqli_query($db,"SELECT * FROM `contest_prizes` WHERE `contest_id` = '".$site_contest['id']."' ORDER BY `id` ASC");
							while($fetch_prizes = mysqli_fetch_array($sql_prizes)) {
								echo '
								<div class="mb15">
									<input type="text" maxlength="100" name="prize_name[]" value="'.$fetch_prizes['prize'].'" placeholder="'._LANG_PRIZE_NAME.'" /><br>
									<input type="text" maxlength="1000" name="prize_description[]" value="'.$fetch_prizes['description'].'" placeholder="'._LANG_PRIZE_DESC.'" />
								</div>';
							}
						}
						?>
					</div>
					<div class="more_prizes">
						+ <?=_LANG_PRIZES;?>
					</div>
				</div>
			</div>

			<div class="setting setting_cont">
				<div class="setting_left"><?=_LANG_RULES;?></div>
				<div class="setting_right">
					<div class="rules">
						<?php
						if(isset($site_contest['id']) && is_numeric($site_contest['id'])) {
							$sql_rules = mysqli_query($db,"SELECT * FROM `contest_rules` WHERE `contest_id` = '".$site_contest['id']."' ORDER BY `id` ASC");
							while($fetch_rules = mysqli_fetch_array($sql_rules)) {
								echo '
								<div class="mb15">
									<input type="text" maxlength="250" name="rule_name[]" value="'.$fetch_rules['rule'].'" placeholder="'._LANG_RULE.'" /><br>
								</div>';
							}
						}
						?>
					</div>
					<div class="more_rules">
						+ <?=_LANG_RULES;?>
					</div>
				</div>
			</div>

			<div class="setting setting_cont">
					
			<div class="setting setting_cont">
				<div class="setting_left">&nbsp;</div>
				<div class="setting_right">
					<input type="submit" name="submit" value="<?=_LANG_SAVE_CONTEST;?>" class="st_svb st_svb5" />
				</div>
			</div>

			<?php if(isset($cid)) { ?>
			<div class="setting setting_cont">
				<div class="setting_left">&nbsp;</div>
				<div class="setting_right">
					<input type="submit" name="remove_contest" value="<?=_LANG_DELETE_CONTEST;?>" onclick="return confirm('<?=_LANG_DELETE_SURE;?>');" class="st_svb st_svb6" />
				</div>
			</div>
			<?php } ?>

			</form>

		</div>

	</div>

</div>

