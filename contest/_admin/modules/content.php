
	<div class="big_preview">

		<div class="big_preview_box">

			<div class="close_pop">&nbsp;&#10005;&nbsp;</div>
			<div class="big_preview_header">Preview</div>

			<div class="big_preview_embed"></div>
			
		</div>

	</div>

	<div class="padding_20">

		<div class="photos">
			<a href="index.php?page=<?=$_GET['page'];?>">
				<div class="photos_menu <?=(!isset($_GET['approval']) ? 'photos_menu_selected':'');?>"><i class="fas fa-check"></i>&nbsp;&nbsp;Approved (<span id="count_photos_1"><?=$fetch_count_photos['total_photos'];?></span>)</div>
			</a>
			<a href="index.php?page=<?=$_GET['page'];?>&approval=1">
				<div class="photos_menu <?=(isset($_GET['approval']) ? 'photos_menu_selected':'');?>"><i class="fas fa-eye-slash"></i>&nbsp;&nbsp;Pending (<span id="count_photos_2"><?=$fetch_count_notapproved_photos['total_notapproved'];?></span>)</div>
			</a>
		</div>

		<div class="clear_photos_x"></div>
		<div class="no_results">
			<div class="no_results_icon"><i class="fas fa-exclamation-triangle"></i></div>
			<div class="no_results_text">No results</div>
		</div>

		<div class="photos_results photo_results_x" id="photos_results" data-page="0" data-stop="0"></div>

	</div>