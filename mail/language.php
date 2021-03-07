<?php

$service_id=trim($_GET['d']);
$language_code=trim($_GET['lan']);
$flag=0;
//echo $language_code; exit;
$portal_installation_url="portal_installation_url";


include_once 'config/database.default.config.php';

//mysql_connect($db_server,$db_username,$db_password);
mysqli_select_db($conn,$db_name);

$result=mysqli_query($conn,"SELECT * FROM ".$db_tableprefix."nesote_email_languages WHERE lang_code='".$language_code."'");

$tot=mysqli_num_rows($result);
$result=mysqli_fetch_row($result);

$language_code=$result[7];

			$result2=mysqli_query($conn,"SELECT * FROM ".$db_tableprefix."nesote_email_settings WHERE name='".$portal_installation_url."'");
			$tot2=mysqli_num_rows($result2);
			$result2=mysqli_fetch_row($result2);
			$portal_installation_url=$result2[2];
			$portal_installation_url=substr($portal_installation_url,0,strrpos($portal_installation_url,"/"));

	if($tot>0)
	{
		
		$username=$_COOKIE['e_username'];
		$password=$_COOKIE['e_password'];
		$a=mysqli_query($conn,"SELECT * FROM ".$db_tableprefix."nesote_inoutscripts_users WHERE username='".$username."' and password='".$password."' and status=1 ");
		$b=mysqli_fetch_row($a);
		
		 $userid=$b[0];
		
		mysqli_query($conn,"update ".$db_tableprefix."nesote_email_usersettings set lang_id='$language_code' where userid='$userid' ");
		
		if( setcookie("lang_mail",$language_code,0,"/"))
		{

			//sleep(1);

			$flag=1;

			$url="$portal_installation_url/index.php?page=index/scriptslanguage/".$language_code."/".$service_id."/".$flag;

			header("location:".$url);
			
		}//if( setcookie("io_username",$username,0,"/") && setcookie("io_password",$password,0,"/") )
		else
		{
			$flag=0;
			$url="$portal_installation_url/index.php?page=index/scriptslanguage/".$language_code."/".$service_id."/".$flag;
			header("location:".$url);

		}
	   

	}//if($tot>0)
	else
	{
		$flag=0;
		$url="$portal_installation_url/index.php?page=index/scriptslanguage/".$language_code."/".$service_id."/".$flag;
			header("location:".$url);
	}//else


?>

<html>
<head>
	<title>Portal Login</title>
	
</head>
<body>
	<script type="text/javascript">
	
		parent.updateStatus('<?php echo $service_id ?>','<?php echo $flag ?>')
	
	</script>
</body>

</html>
