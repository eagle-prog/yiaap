<?php

$scriptname=$_SERVER['SCRIPT_NAME'];
$scriptname=substr($scriptname,0,strrpos($scriptname,"/"));
$scriptname=str_replace("/cron","",$scriptname);
$hostdir= "http://".$_SERVER['HTTP_HOST'].$scriptname."/";



$url=$hostdir."index.php?page=calendar/remainder";
//$url="http://www.inoutwebmaildemo.com/index.php?page=calendar/remainder";
echo "<br> The url is ".$url;
$fp="";
$sitecontent="";
if($fp=fopen($url,"r"))
{
	while(!feof($fp))
	{
		$sitecontent.=fgetc($fp);
		//echo $row[1];
	}
	fclose($fp);
	echo "<br><br> Email sent successfully.";
}
elseif (function_exists('curl_init'))
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$sitecontent = curl_exec($ch);
	curl_close($ch);
	echo "<br><br> Email sent successfully.";
}

?>
