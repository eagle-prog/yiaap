
	<link rel="stylesheet" media="all" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
	<link rel="stylesheet" media="all" href="_css/style.css?v=<?=rand(1,99999999);?>" />

	<?php if(isset($settings['site_theme']) && $settings['site_theme']) { ?>
	<link rel="stylesheet" media="all" href="_css/<?=$settings['site_theme'];?>.css?v=<?=rand(1,999999);?>" />
	<?php } ?>

	<?php if(isset($settings['header_type']) && $settings['header_type'] == '1') { ?>
	<style type="text/css">
	.space_fixedh { width:100%;height:55px; }
	.hh5 { background: <?=(isset($settings['header_bgcolor']) ? $settings['header_bgcolor'] : '');?>; }
	<?php if(isset($settings['header_fixed']) && $settings['header_fixed'] == '1') { ?>
	.hh5 { position:fixed; top:0; left:0; width:100%; height:55px !important; z-index:9999999;  }
	<?php } else { ?>
	.hh5 { height:55px !important; }
	<?php } ?>
	.logo { margin-top: 3px !important; font-size: 32px !important; }
	.hh5 .logo a { color: <?=(isset($settings['header_logocolor']) ? $settings['header_logocolor'] : '');?> !important; }
	.hh5 .button, .hh5 .button3s { color: <?=(isset($settings['header_menucolor']) ? $settings['header_menucolor'] : '');?> !important; border-bottom:0 !important; }
	.hh5 .button:hover, .hh5 .button3s:hover { border-bottom:0 !important; }
	.hh5 .header_main { padding-top: 0 !important; }
	.header_search_input { padding: 9px !important; }
	.button2 { margin-top: 7px !important; }
	.headerv2home { height: <?=($from_mobile == '1' ? '100':'180');?>px;width: 100%; margin-top:-2px; background: <?=$settings['header_homebg'];?><?=(isset($settings['header_homeopacity']) && $settings['header_homeopacity'] != '100' && is_numeric($settings['header_homeopacity']) ? $settings['header_homeopacity']:'');?>; }
	.header_main .head_home { margin-top:<?=($from_mobile == '1' ? '0':'29');?>px !important; }
	.header_main .head_home .cs2, .header_main .head_home .cs3 { color: <?=$settings['header_homeht'];?> !important; }
	.hh5 .button2, .hh5 .button2:hover { background: <?=(isset($settings['header_uploadbgcolor']) ? $settings['header_uploadbgcolor'] : '');?> !important; color: <?=(isset($settings['header_uploadtxcolor']) ? $settings['header_uploadtxcolor'] : '');?> !important; }
	.hh5 .header_search_icon, .header_search_input::placeholder, .header_search_input { color: <?=(isset($settings['header_menucolor']) ? $settings['header_menucolor'] : '');?> !important; }
	</style>
	<?php } ?>
