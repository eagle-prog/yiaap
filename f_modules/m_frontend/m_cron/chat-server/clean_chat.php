<?php
/**************************************************************************************************
| Software Name        : ViewShark
| Software Description : High End Video, Photo, Music, Document & Blog Sharing Script
| Software Author      : (c) ViewShark
| Website              : http://www.viewshark.com
| E-mail               : info@viewshark.com
|**************************************************************************************************
|
|**************************************************************************************************
| This source file is subject to the ViewShark End-User License Agreement, available online at:
| http://www.viewshark.com/support/license/
| By using this software, you acknowledge having read this Agreement and agree to be bound thereby.
|**************************************************************************************************
| Copyright (c) 2013-2019 viewshark.com. All rights reserved.
|**************************************************************************************************/

define('_ISVALID', true);

require 'cfg.php';

$conn   = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if(! $conn ) {
        die('Could not connect: ' . mysqli_error());
}
echo "Connected successfully\n";


$sql    = sprintf("DELETE FROM `db_livenotifications` WHERE `displayed`='1';");

if (mysqli_query($conn, $sql))
        echo "db_livenotifications updated successfully\n";
else
        echo "Error updating table db_livenotifications: " . mysqli_error($conn) . "\n";


$sql    = sprintf("DELETE FROM `db_livechat` WHERE DATE(`chat_time`) < DATE(NOW() - INTERVAL 2 DAY);");

if (mysqli_query($conn, $sql))
        echo "db_livechat records updated successfully\n";
else
        echo "Error updating db_livechat: " . mysqli_error($conn) . "\n";

mysqli_close($conn);
