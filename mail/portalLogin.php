<?php

$username=trim($_GET['u']);
$password=trim($_GET['p']);
$service_id=trim($_GET['d']);
//echo $status; exit;
$flag=0;
$portal_installation_url="portal_installation_url";
/*echo $password;
exit;
*/

//echo $username."...".$password;
include_once 'config/database.default.config.php';
//mysql_connect($db_server,$db_username,$db_password);
//mysql_select_db($db_name);

$result=mysqli_query($conn,"SELECT * FROM ".$db_tableprefix."nesote_inoutscripts_users 

WHERE username='".$username."' and password='".$password."' and status=1 ");

$uidresult=mysqli_fetch_row($result);
$userid=$uidresult[0];

$tot=mysqli_num_rows($result);

			$result2=mysqli_query($conn,"SELECT * FROM ".$db_tableprefix."nesote_email_settings WHERE name='".$portal_installation_url."'");
			$tot2=mysqli_num_rows($result2);
			$result2=mysqli_fetch_row($result2);
			$portal_installation_url=$result2[2];
			$portal_installation_url=substr($portal_installation_url,0,strrpos($portal_installation_url,"/"));

	if($tot>0)
	{
		
		$a=mysqli_query($conn,"SELECT lang_id FROM ".$db_tableprefix."nesote_email_usersettings WHERE userid='$userid' ");
		$b=mysqli_fetch_row($a);
		if($b[0]!="")
		{
		setcookie("lang_mail","$b[0]","0","/");		
		}
		else
		{
		$a1=mysqli_query($conn,"SELECT value FROM ".$db_tableprefix."nesote_email_settings WHERE name='default_language' ");	
		$b1=mysqli_fetch_row($a1);
		if($b1[0]!="")
		 setcookie("lang_mail","$b1[0]","0","/");	
		else
		 setcookie("lang_mail","eng","0","/");	  		
		}
		 
		
		if( setcookie("e_username",$username,0,"/") && setcookie("e_password",$password,0,"/") && setcookie("folderid","1","0","/") && 	setcookie("page","1","0","/") && setcookie("preload","0","0","/") && setcookie("page_display","1","0","/") && setcookie("crnt_mailid","0","0","/") &&  setcookie("image_display","","0","/") && setcookie("start","1","0","/") && setcookie("folder","inbox","0","/")  )
		{
			//sleep(1);
			$flag=1;
			$url="$portal_installation_url/index.php?page=index/registrationprocess/".$service_id."/".$username."/".$password."/".$flag;
				
			header("location:".$url);
			
		}//if( setcookie("io_username",$username,0,"/") && setcookie("io_password",$password,0,"/") )
		else
		{
			$flag=0;
			$url="$portal_installation_url/index.php?page=index/registrationprocess/".$service_id."/".$username."/".$password."/".$flag;
			header("location:".$url);

		}
	   

	}//if($tot>0)
	else
	{
		$flag=0;
		$url="$portal_installation_url/index.php?page=index/registrationprocess/".$service_id."/".$username."/".$password."/".$flag;
			header("location:".$url);
	}//else


?>
<!--<html>
<head>
	<title>Portal Login</title>
	
</head>
<body>
	<script type="text/javascript">
	
		parent.updateStatus('<?php /*?><?php echo $service_id ?>','<?php echo $flag ?><?php */?>')
	
	</script>
</body>

</html>-->
