<?php
	session_start();
	require_once('config.php');
	require_once ('google/Google_Client.php');
	$client = new Google_Client();
	$client->setApplicationName('Google Contacts PHP Sample');
	$client->setScopes('http://www.google.com/m8/feeds/');
	$client->setClientId($google_client_id);
	$client->setClientSecret($google_client_secret);
	$client->setRedirectUri($google_redirect_url);
	if (isset($_GET['code']))
	{
		$client->authenticate();
		$_SESSION['token'] = $client->getAccessToken();
		$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
		header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
	}
	if (isset($_SESSION['token']))
	{
		$client->setAccessToken($_SESSION['token']);
	}
	if (isset($_REQUEST['logout'])) 
	{
		unset($_SESSION['token']);
		$client->revokeToken();
	}
	if ($client->getAccessToken()) 
	{
	
		$req = new Google_HttpRequest('https://www.google.com/m8/feeds/contacts/default/thin?q=email&max-results=1000');
		$val = $client->getIo()->authenticatedRequest($req);
		$response = json_encode(simplexml_load_string($val->getResponseBody()));
		$_SESSION['token'] = $client->getAccessToken();
		$xml = simplexml_load_string($val->getResponseBody());
		$xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
		$user_contacts = array();
		foreach ($xml->entry as $entry) 
		{
			foreach ($entry->xpath('gd:email') as $email) 
			{
				$user_contacts[] = array('title'=>(string)$entry->title, 'email'=>(string)$email->attributes()->address);
			}
		}
		//unset($_SESSION['token']);
		
include("../../config/database.default.config.php");
//mysql_connect($db_server,$db_username,$db_password);
mysqli_select_db($conn,$db_name);

$username=$_COOKIE['e_username'];
$query=mysqli_query($conn,"select id from nesote_inoutscripts_users where username='$username'");
$res=mysqli_fetch_row($conn,$query);
$userid=$res[0];
foreach($user_contacts as $contacts )
		{
			extract($contacts);
			
			
			
			
				
$email=$contacts['email'];
$query=mysqli_query($conn,"select * from nesote_email_contacts where addedby='$userid' and contactgroup='0' and mailid='$email'");
$no=mysqli_num_rows($query);
		
				if($no==0)
				{
					$title=$contacts['title'];

mysqli_query($conn,"insert into nesote_email_contacts(mailid,addedby,contactgroup,firstname) values('$email',$userid,0,'$title')");
				}
			
					
			
			
			
			
		}
		
//$query=mysql_query("select * from nesote_email_contacts where addedby='$userid' and contactgroup='0'");
//$no1=mysql_num_rows($query);
		
		
		
	?>
		<script type="text/javascript">

if (window.opener && !window.opener.closed) {
window.opener.location.reload();
}

		</script> 
<?php	}
	else
	{
		$auth = $client->createAuthUrl();
		
	}
	
	
	
	
	
	if (isset($auth))
	{
		
		print "<div style='border: 1px solid #999999;display:block;margin: 60px auto 0;
    max-width: 500px;
    overflow: hidden;
    padding: 130px 0;
    text-align: center;
    width: 100%;' class='center'>
<div>
<div style='width: 100%; float: left;' class='title'>
<h4 style='font-family:Arial, Helvetica, sans-serif; color:#444444; font-weight: normal; font-variant:normal; font-size:16px; padding:0 30px; line-height:30px;
 margin:0; '>To begin importing, click the connect button</h4>
</div>
<div style='width: 100%; float: left; margin:30px 0 0;' class='buttonf'>
<a style='background-color: rgb(67, 135, 255);
border: 1px solid transparent;
border-radius: 2px; color: rgb(255, 255, 255);
-moz-border-radius: 2px; color: rgb(255, 255, 255);
-o-border-radius: 2px; color: rgb(255, 255, 255);
-webkit-border-radius: 2px; color: rgb(255, 255, 255);
 font-family: Arial,Helvetica,sans-serif; font-size: 14px; font-weight: bold; padding: 10px 23px; text-decoration: none;  white-space: nowrap; display: inline-block;' href='$auth'>Connect</a>
</div>
</div>
</div>
	";
	}
	 else
	  {
	  	
	  	
	  	
	  	print "<div style='border: 1px solid #999999;display:block;margin: 60px auto 0;
	  	max-width: 500px;
	  	overflow: hidden;
	  	padding: 130px 0;
	  	text-align: center;
	  	width: 100%;' class='center'>
	  	<div>
	  	<div style='width: 100%; float: left;' class='title'>
	  	<h4 style='font-family:Arial, Helvetica, sans-serif; color:#444444; font-weight: normal; font-variant:normal; font-size:16px; padding:0 30px; line-height:30px;
	  	margin:0; '>Contacts have been imported.</br>It seems that you already have an active gmail session in your browser.</br>To import contacts from another google account please logout your session by visiting gmail.com</br>OR</br>Visit: <a href='https://www.google.com/accounts/Logout' target='_blank'>https://www.google.com/accounts/Logout</a></br>To continue using the current gmail session. click on continue button  below.</h4>
	  	</div>
	  	<div style='width: 100%; float: left; margin:30px 0 0;' class='buttonf'>
	  	<a style='background-color: rgb(67, 135, 255);
	  	border: 1px solid transparent;
	  	border-radius: 2px; color: rgb(255, 255, 255);
	  	-moz-border-radius: 2px; color: rgb(255, 255, 255);
	  	-o-border-radius: 2px; color: rgb(255, 255, 255);
	  	-webkit-border-radius: 2px; color: rgb(255, 255, 255);
	  	font-family: Arial,Helvetica,sans-serif; font-size: 14px; font-weight: bold; padding: 10px 23px; text-decoration: none; white-space: nowrap; display: inline-block;' href='?logout'>Continue</a>
	  	</div>
	  	</div>
	  	</div>
	  	";
	  	
	  	
	  	
	  	
	//print "<div align='center'><b> Contacts have been imported It seems that you already have an active gmail session in your browser. To import contacts from another google account please logout your session by visiting gmail.com.</br>Visit:<a href='https://www.google.com/accounts/Logout' target='_blank'>https://www.google.com/accounts/Logout</a>To continue using the current gmail session. click on continue button  below.</b><a class=logout href='?logout'><img src='continue.jpg' alt='google connect' ></a></div>";
	}
	
	
	
	
	
	
?>
