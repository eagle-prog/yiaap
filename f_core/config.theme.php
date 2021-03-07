<?php
defined ('_ISVALID') or die ('Unauthorized Access!');

$cfg['theme_name']	= 'default';
$cfg['theme_name']	= isset($_SESSION['theme_name']) ? $_SESSION['theme_name'] : $cfg['theme_name'];
$cfg['theme_name_be']	= isset($_SESSION['theme_name_be']) ? $_SESSION['theme_name_be'] : $cfg['theme_name'];

$smarty->assign('theme_name', $cfg['theme_name']);
$smarty->assign('theme_name_be', $cfg['theme_name_be']);
