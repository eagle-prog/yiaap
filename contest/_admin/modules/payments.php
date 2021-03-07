
	<div class="padding_20 boxn12">

		<div>Payments</div>

		<div class="clear_space"></div>

		<div class="settings">
			<a href="index.php?page=payments">
				<div class="settings_menu <?=(!isset($_GET['extrap']) ? 'photos_menu_selected':'');?>">Transactions</div>
			</a>
			<a href="index.php?page=payments&extrap=items">
				<div class="settings_menu <?=(isset($_GET['extrap']) && $_GET['extrap'] == 'items' ? 'photos_menu_selected':'');?>">Items</div>
			</a>
			<a href="index.php?page=payments&extrap=settings">
				<div class="settings_menu <?=(isset($_GET['extrap']) && $_GET['extrap'] == 'settings' ? 'photos_menu_selected':'');?>">Settings</div>
			</a>
		</div>

		<div class="clear_space"></div>
		<div class="slash"></div>
	</div>

	<div class="padding_20">

		<?php if(isset($_GET['extrap']) && $_GET['extrap'] == 'settings') { ?>

		<?php if(isset($success_msg) && $success_msg) { ?>
		<div class="success_box_new show">
			<div class="scb_icon"><i class="fas fa-check"></i></div>
			<div class="scb_text"><?=$success_msg;?></div>
		</div>
		<?php } ?>

		<div class="settings_results">

			<form action="index.php?page=payments&extrap=settings" method="post">

			<div class="setting">
				<div class="setting_left">Gateway</div>
				<div class="setting_right">
					<select name="payment_gateway" id="payment_gateway">
						<option value="paypal" <?=(!isset($site_settings['payment_gateway']) || (isset($site_settings['payment_gateway']) && $site_settings['payment_gateway'] == 'paypal') ? 'selected' : '');?>>PayPal</option>
						<option value="razorpay" <?=(isset($site_settings['payment_gateway']) && $site_settings['payment_gateway'] == 'razorpay' ? 'selected' :'');?>>RazorPay</option>
					</select>
				</div>
			</div>

			<div class="p_only_paypal" <?=(!isset($site_settings['payment_gateway']) || (isset($site_settings['payment_gateway']) && $site_settings['payment_gateway'] == 'paypal') ? 'style="display:block;"':'style="display:none;"');?>>

				<div class="setting">
					<div class="setting_left">PayPal e-mail<br><span class="setting_explain">(all payments will get right into your paypal account)</span></div>
					<div class="setting_right">
						<input type="text" placeholder="my@email.com" value="<?=(isset($site_settings['paypal_email']) && $site_settings['paypal_email'] != '' ? $site_settings['paypal_email'] : '');?>" name="paypal_email" />
					</div>
				</div>

			</div>

			<div class="p_only_razorpay" <?=(isset($site_settings['payment_gateway']) && $site_settings['payment_gateway'] == 'razorpay' ? 'style="display:block;"':'style="display:none;"');?>>

				<div class="setting">
					<div class="setting_left">API Key</div>
					<div class="setting_right">
						<input type="text" placeholder="" value="<?=(isset($site_settings['razorpay_api']) && $site_settings['razorpay_api'] != '' ? $site_settings['razorpay_api'] : '');?>" name="razorpay_api" />
					</div>
				</div>

				<div class="setting">
					<div class="setting_left">API Secret</div>
					<div class="setting_right">
						<input type="text" placeholder="" value="<?=(isset($site_settings['razorpay_secret']) && $site_settings['razorpay_secret'] != '' ? $site_settings['razorpay_secret'] : '');?>" name="razorpay_secret" />
					</div>
				</div>
			</div>

			<div class="setting">
				<div class="setting_left">Currency</div>
				<div class="setting_right">
					<select name="paypal_currency">
						<option value="ARS" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'ARS' ? 'selected' : '');?>>Argentinian Peso (ARS)</option>
						<option value="AUD" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'AUD' ? 'selected' : '');?>>Australian Dollar (AUD)</option>
						<option value="BRL" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'BRL' ? 'selected' : '');?>>Brazilian Real (BRL)</option>
						<option value="CAD" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'CAD' ? 'selected' : '');?>>Canadian Dollar (CAD)</option>
						<option value="CHF" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'CHF' ? 'selected' : '');?>>Swiss Franc (CHF)</option>
						<option value="CZK" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'CZK' ? 'selected' : '');?>>Czech Koruna (CZK)</option>
						<option value="DKK" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'DKK' ? 'selected' : '');?>>Danish Krone (DKK)</option>
						<option value="EUR" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'EUR' ? 'selected' : '');?>>Euro (EUR)</option>
						<option value="GBP" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'GBP' ? 'selected' : '');?>>British Pound (GBP)</option>
						<option value="HKD" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'HKD' ? 'selected' : '');?>>Hong Kong Dollar (HKD)</option>
						<option value="HUF" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'HUF' ? 'selected' : '');?>>Hungarian Forint (HUF)</option>
						<option value="INR" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'INR' ? 'selected' : '');?>>Indian Rupee (INR)</option>
						<option value="ILS" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'ILS' ? 'selected' : '');?>>Israeli New Shekel (ILS)</option>
						<option value="JPY" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'JPY' ? 'selected' : '');?>>Japanese Yen (JPY)</option>
						<option value="MXN" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'MXN' ? 'selected' : '');?>>Mexican Peso (MXN)</option>
						<option value="MYR" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'MYR' ? 'selected' : '');?>>Malaysian Ringgit (MYR)</option>
						<option value="NOK" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'NOK' ? 'selected' : '');?>>Norwegian Krone (NOK)</option>
						<option value="NZD" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'NZD' ? 'selected' : '');?>>New Zealand Dollar (NZD)</option>
						<option value="PHP" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'PHP' ? 'selected' : '');?>>Philippine Peso (PHP)</option>
						<option value="PLN" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'PLN' ? 'selected' : '');?>>Polish Zloty (PLN)</option>
						<option value="RUB" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'RUB' ? 'selected' : '');?>>Russian Ruble (RUB)</option>
						<option value="SEK" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'SEK' ? 'selected' : '');?>>Swedish Krona (SEK)</option>
						<option value="SGD" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'SGD' ? 'selected' : '');?>>Singapore Dollar (SGD)</option>
						<option value="THB" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'THB' ? 'selected' : '');?>>Thai Baht (THB)</option>
						<option value="TWD" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'TWD' ? 'selected' : '');?>>Taiwan New Dollar (TWD)</option>
						<option value="USD" <?=(isset($site_settings['paypal_currency']) && $site_settings['paypal_currency'] == 'USD' ? 'selected' : '');?>>United States Dollar (USD)</option>
					</select>
				</div>
			</div>

			<div class="slash"></div>

			<div class="setting">
				<div class="setting_left">&nbsp;</div>
				<div class="setting_right">
					<input type="submit" name="submit" value="Save changes" class="st_svb" />
				</div>
			</div>

			</form>

		</div>


		<?php } ?>

		<?php if(isset($_GET['extrap']) && $_GET['extrap'] == 'items') { ?>

		<div class="rallr_si inld">+&nbsp;&nbsp;New item</div>
		<div class="clear_space"></div>

		<div class="pop_ncat" data-id="0">

			<div class="pop_ncat_box pop_ncat_boxitem">

				<div class="pop_ncat_head">New item</div>

				<div class="sat">
					<div class="sat_left">Item name</div>
					<div class="sat_right">
						<input type="text" placeholder="My item name ..." maxlength="100" id="item_name" name="item_name" />
					</div>
				</div>

				<div class="sat">
					<div class="sat_left">Number of votes</div>
					<div class="sat_right">
						<input type="number" min="1" max="1000" placeholder="100" id="item_votes" name="item_votes" />
					</div>
				</div>

				<div class="sat">
					<div class="sat_left">Number of views</div>
					<div class="sat_right">
						<input type="number" min="1" max="100000" placeholder="1000" maxlength="100" id="item_views" name="item_views" />
					</div>
				</div>

				<div class="sat">
					<div class="sat_left">Price</div>
					<div class="sat_right">
						<input type="number" placeholder="10" maxlength="100" id="item_price" name="item_price" />
					</div>
				</div>

				<div class="pop_ncat_op margin_top12">
					<div class="pop_ncat_op_cancel">Cancel</div>
					<div class="pop_ncat_op_submit_si"><i class="fas fa-check"></i>&nbsp;&nbsp;Save</div>
				</div>
			
			</div>
		
		</div>

		<div class="users_dash_cap">
			<div class="users_dash_col paymenti_dash_col_1">Item name</div>
			<div class="users_dash_col paymenti_dash_col_2">Votes</div>
			<div class="users_dash_col paymenti_dash_col_3">Views</div>
			<div class="users_dash_col paymenti_dash_col_4">Price</div>
			<div class="users_dash_col paymenti_dash_col_5">Options</div>
		</div>

		<?php
		$sql_items = mysqli_query($db,"SELECT * FROM `payments_items` ORDER BY `id`");
		if(mysqli_num_rows($sql_items) == '0') {
			echo '
			<div class="no_results show">
				<div class="no_results_icon"><i class="fas fa-exclamation-triangle"></i></div>
				<div class="no_results_text">No results</div>
			</div>';
		} else {

			echo '<div class="items_results" data-page="0" data-stop="0">';

			while($fetch_items = mysqli_fetch_array($sql_items)) {

				echo '
				<div class="users_dash items fitem_'.$fetch_items['id'].'">
					<div class="users_dash_col paymenti_dash_col_1">'.$fetch_items['item_name'].'</div>
					<div class="users_dash_col paymenti_dash_col_2">'.$fetch_items['votes'].'</div>
					<div class="users_dash_col paymenti_dash_col_3">'.$fetch_items['views'].'</div>
					<div class="users_dash_col paymenti_dash_col_4">$'.$fetch_items['price'].'</div>
					<div class="users_dash_col center paymenti_dash_col_5">
						<div class="relative">
							<div class="open_pop_menu" data-id="'.$fetch_items['id'].'"><i class="fas fa-chevron-down"></i></div>
							<div class="pop_menu" data-id="'.$fetch_items['id'].'">
								<div class="pop_menu_item edit_fitem overflow" data-id="'.$fetch_items['id'].'">
									<div class="pop_menu_item_icon"><i class="fas fa-pencil-alt"></i></div>
									<div class="pop_menu_item_text">Edit item</div>
								</div>
								<div class="pop_menu_item border_bottom0 remove_fitem overflow" data-id="'.$fetch_items['id'].'">
									<div class="pop_menu_item_icon red">&#10005;&nbsp;</div>
									<div class="pop_menu_item_text">Remove item</div>
								</div>
							</div>
						</div>
					</div>
				</div>';

			}

			echo '</div>';
		}
		?>

		<?php } ?>

		<?php if(!isset($_GET['extrap'])) { ?>

		<div class="users_dash_cap">
			<div class="users_dash_col center payment_dash_col_1">Order ID</div>
			<div class="users_dash_col payment_dash_col_2">User information</div>
			<div class="users_dash_col payment_dash_col_3">Payment date</div>
			<div class="users_dash_col payment_dash_col_4">Product</div>
			<div class="users_dash_col payment_dash_col_5">Price</div>
			<div class="users_dash_col payment_dash_col_6">Status</div>
		</div>

		<div class="no_results">
			<div class="no_results_icon"><i class="fas fa-exclamation-triangle"></i></div>
			<div class="no_results_text">No results</div>
		</div>

		<div class="payments_results" data-page="0" data-stop="0"></div>

		<div class="cloading"><i class="fas fa-spinner fa-spin"></i></div>

		<?php } ?>

	</div>