<?php

   
   
   include "../../config/database.default.config.php"; 
   
  
   
   
   
   /**
    * Get the value of the field from database nesote_email_settings 
    * @param
    * string $name,string  $db_server,string $db_username,string $db_password,string $db_name
    * @return
    * $row[0]
    * returns the value in the given field.
    */
   
   
   
   function getvalue($name,$db_server,$db_username,$db_password,$db_name)
   {
   	
   	$conn=$connect=mysqli_connect($db_server,$db_username,$db_password); 
   	$db=mysqli_select_db($conn,$db_name);  
   	$query="SELECT value FROM nesote_email_settings WHERE name='$name'"; 
   	$result=mysqli_query($conn,$query);
   	$row=mysqli_fetch_array($result);
   	return $row[0];
   
   }
   
   
   
   
   
   /**
    * Get the current connected path of php page relative to the current server
    * @param 
    * string $connected
    * @return
    * $replace
    */
   
   
   function getpath($connected)
   {   
 	$servername=$_SERVER['SERVER_NAME'];
 	$path=$servername.$_SERVER['SCRIPT_NAME'];
 	$replace=str_replace("config.php",$connected.".php",$path); 
    return $replace;
   }
   
  
   
   
  
   
   
   
   
  	
	
	
	
	
	
   //Here gclient id is a Filed in database with value of client id from google.
   //Here gsecret is a Filed in database with value of client id from google.
   
	

	$google_client_id = getvalue(gclientid,$db_server,$db_username,$db_password,$db_name);
	$google_client_secret= getvalue(gsecret,$db_server,$db_username,$db_password,$db_name);
	$google_connected_path = 'google_connected.php';
	$google_redirect_url = "http://".getpath(google_connected);
	

		
	
	
	
	
	
	
	?>
