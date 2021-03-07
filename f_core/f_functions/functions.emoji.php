<?php
namespace Emojione;

defined ('_ISVALID') or die ('Unauthorized Access!');

function emsg($text){
	require('f_core/f_classes/class_emoji/autoload.php');

	$client = new Client(new Ruleset());

	return $client->shortnameToImage($text);
}

