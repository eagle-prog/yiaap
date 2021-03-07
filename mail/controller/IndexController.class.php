<?php
class IndexController extends NesoteController
{
	function indexAction()
	{
include("config/database.default.config.php");
//demo reset start
include("resetdemo/database.reset.config.php");
   include("resetdemo/reset.config.inc.php");
//   $now=1499421594;//1499420454;//time();//echo $now;
$now=time();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//echo $db_last_reset;exit;
$check_time=$db_last_reset+($db_reset_duration*3600);
$check_time_before=$check_time-(15*60);
$check_time_after=$db_last_reset+(15*60);

 // echo "1@$$@This demo and data in it have just been reset!";exit;

//echo $check_time_before.">=".$now." &&". $now."<=".$check_time;
if($check_time_before<=$now && $now<$check_time)
{
   // $rem=($check_time-$now)%60;
    $rem = round(($check_time-$now)/60);
$this->setValue("beforedemo",1);
$this->setValue("remtime",$rem);
     //echo "1@$$@This demo and the data in it will reset within ".$rem." minutes";exit;
}
if($now>=$db_last_reset && $check_time_after>=$now)//if($now>=$db_last_reset && $check_time_after>=$now)
{
$this->setValue("afterdemo",1);

     //echo "1@$$@This demo and data in it have just been reset!";exit;
}
/*echo "0@$$@";exit;
  echo "<br>NOW : ".date("F j, Y, g:i a",$now); 
  echo "<br>LAST RESET TYM : ".date("F j, Y, g:i a",$db_last_reset); //$db_last_reset
  echo "<br>CHECK TYM : ".date("F j, Y, g:i a",$check_time); //$check_time;
  echo "<br>CHECK TYM BEFORE 20 min: ".date("F j, Y, g:i a",$check_time_before); //$check_time;
  echo "<br>CHECK TYM AFTER 10 min: ".date("F j, Y, g:i a",$check_time_after); 
exit;*/
//$check_time;
//demo reset end
require("script.inc.php");
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$portal_status=$settings->getValue("portal_status");

		 $db=new NesoteDALController();

		if($portal_status==1)
		{
			header("Location:".$this->url("mail/mailbox"));
				exit(0);
			
		}
		else
		{
		    $mobile_status=$this->mobile_device_detect();
			$path=$_SERVER['SCRIPT_NAME'];
			$path=substr($path,0,strrpos($path,"/"));
			if($mobile_status==true)
			{
			header("location:".$path."/mobile/");
			exit(0);
			}
	
	        $db=new NesoteDALController();
	
			$style_id=$settings->getValue("themes");
						
			$db->select("nesote_email_themes");
			$db->fields("name,style");
			$db->where("id=?",$style_id);
			$result=$db->query();
			$theme=$db->fetchRow($result);
	
			$this->setValue("style",$theme[1]);
			
			//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.beta.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="inoutwebmaildemo.com") )


			if($restricted_mode=='true')
			{
	
				$users=$this->avilableusers();
				$curntuser=array_rand($users);
				$demouserid=$users[$curntuser];
				$demouser=$this->getuname($demouserid);
				
				
				if($demouser=="")
	            {
	                $users= array("demomailer1", "demomailer2");
	
	                $demouser="demomailer";
	                $curntuser=array_rand($users);
	
	                $curntuser=$curntuser+1;
	
	                $demouser=$demouser.$curntuser;
	            }
	
	
				$this->setValue("user","$demouser");
				$this->setValue("pass","KQ2UOb7kkZ@D");
			}
			else
			{
				$this->setValue("user","");
				$this->setValue("pass","");
			}
			
			$memorymsg=$this->getmessage(351);
			$year=date("Y",time());
			$msg1=str_replace('{year}',$year,$memorymsg);
			$this->setValue("footer",$msg1);
	
			$signupvalue=0;
			$msg="";
			$msg=$this->getParam(1);
$msg1=$msg;
			if($msg=="errlog") 
			$msg=$this->getmessage(200);
			if($msg=="logout")
			$msg=$this->getmessage(780);
			$this->setValue("msg",$msg);
                        $this->setValue("msg_type",$msg1);
	
			$servicename=$settings->getValue("engine_name");
			$this->setValue("servicename",$servicename);
	
			$account_type=$settings->getValue("catchall_mail");
	
			$lang_cookie=$_COOKIE['lang_mail'];
	
	
			$langid=$settings->getValue("default_language");
			if($langid=="")
			$langid='eng';
			$this->setValue("defaultlang",$langid);
	
		
			$db->select("nesote_email_settings");
			$db->fields("*");
			$res=$db->query();
			//echo $db->getQuery();
			while($row=$res->fetchRow())
			{
				//echo $row[2];
				$this->setValue("$row[1]","$row[2]");
			}
			
	
			$img=$settings->getValue("public_page_logo");
			$imgpath="admin/logo/".$img;
			$this->setValue("imgpath",$imgpath);
			
			$db->select("nesote_email_languages");
			$db->fields("lang_code,language");
			$db->where("status=?",array(1));
			$db->order("id asc");
			$result=$db->query();
			$this->setLoopValue("lang",$result->getResult());
	
			if($account_type==1)// catchall
			{
	
	
				$public_registration=$settings->getValue("public_registration");
				if($public_registration==1)
				{
					$signupvalue=1;// display signup link
				}
				else
				$signupvalue=0;
			}
	
			else //individual
			{
			//echo "aanna";exit;
	            $automatic_account_creation=$settings->getValue("automatic_account_creation");
				if($automatic_account_creation==1)// for automatic account creation
				{
					$signupvalue=0;
	
					$public_registration=$settings->getValue("public_registration");
					if($public_registration==1)
					{
						$signupvalue=1;// display signup link
					}
					else
					$signupvalue=0;
				}
				else //manually account creation
				$signupvalue=0;
			}
			$this->setValue("signupvalue",$signupvalue);
			$username=$_COOKIE['e_username'];
			$password=$_COOKIE['e_password'];
	
			$no=$db->total("nesote_inoutscripts_users","username=? and password=? and status=?",array($username,$password,1));
			if($_COOKIE["e_username"])
			{
				if($no!=0)
				{
				
					header("Location:".$this->url("mail/mailbox"));
					exit(0);
				}
				
			}
		}


	}
	function logincheckAction()
	{

                require("script.inc.php");
$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
	    
		$username=$_POST['username'];$username=strtolower($username);
		if(strpos($username,"@")!="")
		{
			$uname=explode("@",$username);
			$extn=$this->getextension();
			$udomain="@".$uname[1];
			if($extn!=$udomain)
			{
				$msg="errlog";
				header("Location:".$this->url("index/index/$msg"));
				exit(0);
			}
			else
			$username=$uname[0];
		}
		$pasword=$_POST['password'];
$salt_password=$settings->getValue("salt_password");
$pasword=$salt_password.$pasword;//$salt_password from script.inc.php
//echo $pasword;exit;
		$password=md5($pasword);

		$db=new NesoteDALController();
		$db->select("nesote_inoutscripts_users");
		$db->fields("*");
		$db->where("username=? and password=? and status=?",array($username,$password,1));
		$result=$db->query();$rr1=$db->fetchRow($result);
		$no=$db->numRows($result);
		//$no=$db->total("nesote_inoutscripts_users","username=? and password=? and status=?",array($username,$password,1));
		if($no!=0)
		{
			
		        $db->select("nesote_email_usersettings");
				$db->fields("time_zone,server_password,smtp_username,lang_id");
				$db->where("userid=?",$rr1[0]);
				$res=$db->query();
				$result=$db->fetchRow($res);
				if($result[0]=="" || $result[1]=="" )
				{
				header("Location:".$this->url("index/index/errlog"));
				exit(0);
				}
				if($result[3]=="")
				$result[3]=="eng";
				
				$this->loadLibrary('Settings');
		        $settings=new Settings('nesote_email_settings');
		        $settings->loadValues();
				$default_language=$settings->getValue("default_language");
				if($default_language===0 || $default_language=="")
				$default_language='eng';
				if (is_numeric($default_language))
				$default_language='eng';
		
				if (is_numeric($result[3]))
				$result[3]=$default_language;
				
			setcookie("lang_mail","$result[3]","0","/");
			setcookie("e_username","$username","0","/");
			setcookie("e_password","$password","0","/");
			
			setcookie("folderid","1","0","/");
			setcookie("page","1","0","/");
			setcookie("preload","0","0","/");
			setcookie("page_display","1","0","/");
			setcookie("crnt_mailid","0","0","/");
			setcookie("image_display","","0","/");
			setcookie("start","1","0","/");
			setcookie("folder","inbox","0","/");

			$uid=$this->getId($username);
			
			$db->update("nesote_email_usersettings");
			$db->set("lastlogin=?",array(1));
			$db->where("userid=?", array($uid));
			$db->query();	
			
			$db->update("nesote_chat_users");
			$db->set("logout_status=?,lastupdatedtime=?",array(0,time()));
			$db->where("userid=?", array($uid));
			$db->query();//echo $db->getQuery();//exit;
			
		                               require("script.inc.php");
                                       include($config_path."database.default.config.php");
                                      
                                       //include("../config/database.default.config.php");
                                       error_reporting(1);
                                      // $link =mysql_connect($db_server,$db_username,$db_password);
                                       //mysql_query("set names utf8 collate utf8_unicode_ci");
                                       $link=$conn;
                                      mysqli_select_db($conn,$db_name);
                                      $time=time();
                                      $m=date("m",$time);
                                      
                                      $y=date("Y",$time);
                                       
			  mysqli_query($conn,"CREATE TABLE IF NOT EXISTS `".$db_tableprefix."nesote_email_ip_".$m.$y."` ( `id` int(11) NOT NULL auto_increment,
			   `userid` int(11) NOT NULL,
			 `ip` varchar(256) NOT NULL,
			 `time` int(11) NOT NULL,
			 `country` varchar(256) NOT NULL,
			 PRIMARY KEY  (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
			");
			  
			 include("geo/geoip.inc");
			 $gi = geoip_open("geo/GeoIP.dat",GEOIP_STANDARD);
			 $public_ip=$this->GetUserIP(); //$public_ip="195.117.168.1";
			 $record = geoip_country_code_by_addr($gi, $public_ip);
			 
			 
			 $db->insert("nesote_email_ip_".$m.$y." ");
			 $db->fields("id,userid,ip,time,country");
			 $db->values(array(0,$uid,$public_ip,$time,$record));
			 $db->query();
			  
//echo "aaa";exit;
			header("Location:".$this->url("mail/mailbox"));
			exit(0);
		}
		else
		{
			$msg="errlog";
			header("Location:".$this->url("index/index/$msg"));
			exit(0);
		}


	}
		function GetUserIP()
	 {
		
		   if (isset($_SERVER)) {
		       if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $ip = $this->CheckIP($_SERVER['HTTP_X_FORWARDED_FOR']))
		       return $ip;
		       if (isset($_SERVER['HTTP_CLIENT_IP']) && $ip = $this->CheckIP($_SERVER['HTTP_CLIENT_IP']))
		       return $ip;
		       return $_SERVER['REMOTE_ADDR'];
		   }
		   if ($ip = $this->CheckIP(getenv('HTTP_X_FORWARDED_FOR')))
		   return $ip;
		   if ($ip = $this->CheckIP(getenv('HTTP_CLIENT_IP')))
		   return $ip;
		   return getenv('REMOTE_ADDR');
     }


	function CheckIP($ip)
	 {
	   if (empty($ip) ||
	   ($ip >= '10.0.0.0' && $ip <= '10.255.255.255') ||
	   ($ip >= '172.16.0.0' && $ip <= '172.31.255.255') ||
	   ($ip >= '192.168.0.0' && $ip <= '192.168.255.255') ||
	   ($ip >= '169.254.0.0' && $ip <= '169.254.255.255'))
	   return false;
	   return $ip;
	}
	
	function getextension()
	{
		$db=new NesoteDALController();
		$db->select("nesote_email_settings");
		$db->fields("value");
		$db->where("name='emailextension'");
		$result=$db->query();
		$row=$db->fetchRow($result);
		if(stristr(trim($row[0]),"@")!="")
		return $row[0];
		else
		return htmlentities("@".$row[0]);
	}
	function getUID()
	{
		$username=$_COOKIE['e_username'];
		$password=$_COOKIE['e_password'];
		$db=new NesoteDALController();
		$db->select("nesote_inoutscripts_users");
		$db->fields("*");
		$db->where("username=? and password=?", array($username,$password));
		$result=$db->query();
		$rs=$db->fetchRow($result);

		return $rs[0];

	}

	function logoutAction()
	{
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		
		$uid=$this->getUID();$userid=$this->getUID();
		$newtime=time()-90;
		$db1=new NesoteDALController();
		$db=new NesoteDALController();
		
		$db->update("nesote_email_usersettings");
		$db->set("lastlogin=?",array(0));
		$db->where("userid=?", array($uid));
		$db->query();	
		
		$db->update("nesote_chat_users");
		$db->set("logout_status=?,lastupdatedtime=?",array(1,$newtime));
		$db->where("userid=?", array($uid));
		$db->query();
	

		$db->select(array("u"=>"nesote_chat_session","c"=>"nesote_chat_session_users"));
		$db->fields("distinct u.id");
		$db->where("u.id=c.chat_id and c.user_id=?",$userid);
		$result=$db->query();//echo $db->getQuery();

		while($row=$db->fetchRow($result))
		{
			$chat_id=$row[0];
			
			$db1->select("nesote_chat_session");
			$db1->fields("group_status");
			$db1->where("id=?", $chat_id);
			$result1=$db1->query();
			$row1=$db1->fetchRow($result1);

			if($row1[0]==1)//group chat
			{
				$fullname=$this->getname($userid);
				$msg=$this->getmessage(428);
				$msg=str_replace("{fullname}","$fullname",$msg);

				$message="\n $msg";
				$db1->select("nesote_chat_session_users");
				$db1->fields("user_id");
				$db1->where("chat_id=? and active_status=? and user_id!=?",array($chat_id,1,$userid));
				$rs1=$db1->query();
				while($row1=$db1->fetchRow($rs1))
				{

					
					$db->insert("nesote_chat_temporary_messages");
					$db->fields("chat_id,sender,responders,message,time,read_flag");
					$db->values(array($chat_id,0,$row1[0],$message,time(),0));
					$result=$db->query();

				}

			}
		}

	
		$db->select("nesote_chat_session_users");
		$db->fields("id,active_status");
		$db->where("user_id=?",$userid);
		$res0=$db->query();
		$num=$db->numRows($res0);


		if($num>0)
		{
			while($row10=$db->fetchRow($res0))
			{
				
				$db1->update("nesote_chat_session_users");
				$db1->set("active_status=?,typing_status=?",array(0,0));
				$db1->where("user_id=? and id=?",array($userid,$row10[0]));
				$db1->query();


			}
			//echo $db1->getQuery();
		}

		

		$mails_per_page=$settings->getValue("mails_per_page");
		if(($mails_per_page=="")|| ($mails_per_page==0))
		$mails_per_page=25;


		$default_language=$settings->getValue("default_language");
		if($default_language===0 || $default_language=="")
		$default_language='eng';


		$themes=$settings->getValue("themes");
		if($themes==0)
		$themes=1;

		$display=$settings->getValue("display");
		if($display==0)
		$display=1;

		$username="demouser1";$password=md5("demo");

	
		$db->select("nesote_inoutscripts_users");
		$db->fields("*");
		$db->where("username=? and password=?",array($username,$password));
		$result=$db->query();
		$rs=$db->fetchRow($result);

		$userid=$rs[0];

		//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.beta.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="inoutwebmaildemo.com") )
		//{
if($restricted_mode=='true')
			{
			
			$db->update("nesote_email_usersettings");
			$db->set("lang_id=?,theme_id=?,display=?,mails_per_page=?,signatureflag=?,signature=?",array($default_language,$themes,$display,$mails_per_page,0,""));
			$db->where("userid=?",array($userid));
			$result=$db->query();

			setcookie("lang_mail",$default_language,"0","/");
		}
        setcookie("lang_mail",$default_language,"0","/");
		setcookie("e_username","","0","/");
		setcookie("e_password","","0","/");
		setcookie("image_display","","0","/");
		setcookie("preload","0","0","/");
		setcookie("folderid","0","0","/");
		setcookie("page_display","1","0","/");
		header("Location:".$this->url("index/index/logout"));
		exit(0);
	}

	function getname($id)
	{


		$db=new NesoteDALController();
		$db->select("nesote_inoutscripts_users");
		$db->fields("name");
		$db->where("id=?",array($id));
		$rs1=$db->query();
		$row=$db->fetchRow($rs1);
		//return $row[0]." ".$row[1];
		return $row[0];
	}
	function getuname($id)
	{

		$db=new NesoteDALController();
		$db->select("nesote_inoutscripts_users");
		$db->fields("username");
		$db->where("id=?",array($id));
		$rs1=$db->query();
		$row=$db->fetchRow($rs1);
		return $row[0];
	}
	
	function getlang_id($lang_code)
    {
	
	    $db=new NesoteDALController();
		$db->select("nesote_email_languages");
		$db->fields("id");
		$db->where("lang_code=?",$lang_code);
		$result=$db->query();
		$data=$db->fetchRow($result);
		$lang_id=$data[0];
		if($lang_id=="")
		$lang_id=1;
		
		return $lang_id;
    }	
	
	function getmessage($msg_id)
	{

		$db=new NesoteDALController();

		$db->select("nesote_email_settings");
		$db->fields("value");
		$db->where("name=?",'default_language');
		$result=$db->query();
		$data4=$db->fetchRow($result);
		$defaultlang_code=$data4[0];
		if($defaultlang_code=="")
		$defaultlang_code='eng';
		

		
		if(isset ($_COOKIE['lang_mail']))
		{
			$lang_code=$_COOKIE['lang_mail'];
			$lang_id=$this->getlang_id($lang_code);

		}
		else
		{

			$lang_id=$this->getlang_id($defaultlang_code);
			setcookie("lang_mail",$lang_code,0,"/");

		}

		if($lang_id!="")
		{
           

			$tot=$db->total("nesote_email_messages","msg_id=? and lang_id=?",array($msg_id,$lang_id));
			//echo $db->getQuery();
			if($tot!=0)
			{

				$db->select("nesote_email_messages");
				$db->fields("wordscript");
				$db->where("msg_id=? and lang_id=?", array($msg_id,$lang_id));
				$result=$db->query();
				$row=$db->fetchRow($result);
				return html_entity_decode($row[0]);
			}
			else
			{
				$tot=$db->total("nesote_email_messages","msg_id=? and lang_id=?",array($msg_id,$lang_id));
				if($tot!=0)
				{

					$db->select("nesote_email_messages");
					$db->fields("wordscript");
					$db->where("msg_id=? and lang_id=?", array($msg_id,$lang_id));
					$result=$db->query();
					$row=$db->fetchRow($result);
					return html_entity_decode($row[0]);
				}

				else
				{
					$db->select("nesote_email_messages");
					$db->fields("wordscript");
					$db->where("msg_id=? and lang_id=?", array($msg_id,1));
					$result=$db->query();
					$row=$db->fetchRow($result);
					return html_entity_decode($row[0]);
				}
			}

		}
		else
		{

			$db->select("nesote_email_messages");
			$db->fields("wordscript");
			$db->where("msg_id=? and lang_id=?", array($msg_id,$lang_id));
			$result=$db->query();
			$row=$db->fetchRow($result);
			return html_entity_decode($row[0]);
		}

	}

	function forgotpasswordAction()
	{
		

		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		
		$select=new NesoteDALController();

		$style_id=$settings->getValue("themes");	


$captcha_sitekey=$settings->getValue("captcha_sitekey");
$this->setValue("captcha_sitekey",$captcha_sitekey);

		$select->select("nesote_email_themes");
		$select->fields("name,style");
		$select->where("id=?",$style_id);
		$result=$select->query();
		$theme=$select->fetchRow($result);

		$this->setValue("style",$theme[1]);
			
		$footermsg=$this->getmessage(351);
		$year=date("Y",time());
		$footer=str_replace('{year}',$year,$footermsg);
		$this->setValue("footer",$footer);

		$extension=$this->getextension();
		$this->setValue("extension",$extension);
		$msg="";
		$msg=$this->getParam(1);

		if(isset($msg))
		{
			if($msg=="u")
			$msg=$this->getmessage(270);
			else if($msg=="e")
			$msg=$this->getmessage(320);
			else if($msg=="iu")
			$msg=$this->getmessage(271);
			else if($msg=="ia")
			$msg=$this->getmessage(340);
		    else if($msg=="icv")
			$msg=$this->getmessage(784);

			$this->setValue("msg",$msg);
		}
		else
		$this->setValue("msg",$msg);

		$img=$settings->getValue("public_page_logo");
		$imgpath="admin/logo/".$img;
		$this->setValue("imgpath",$imgpath);


	}
	function forgotpasswordprocessAction()
	{//echo(mktime(0,0,0,04,28,1986));
		//echo md5(sibin);
		//echo "aa";exit;
require("script.inc.php");
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		
		$settings->loadValues();
		
	//	$salt_password=$settings->getValue("salt_password");
		
		$db=new NesoteDALController();

		$style_id=$settings->getValue("themes");
			
		$db->select("nesote_email_themes");
		$db->fields("name,style");
		$db->where("id=?",$style_id);
		$result=$db->query();
		$theme=$db->fetchRow($result);

		$this->setValue("style",$theme[1]);
		$footermsg=$this->getmessage(351);
		$year=date("Y",time());
		$footer=str_replace('{year}',$year,$footermsg);
		$this->setValue("footer",$footer);

		$msg="";
		$msg=$this->getParam(2);
		$y=array();

		for($i=$year,$j=0;$i>=1900;$i--,$j++)
		{
			$y[$j][0]=$i;
		}

		$this->setLoopValue("YY",$y);
		
		$d=array();

		for($i=1,$j=0;$i<=31;$i++,$j++)
		{
			if($i<10)
			$i="0".$i;
			$d[$j][0]=$i;
		}

		$this->setLoopValue("DD",$d);

		$lang_id=$_COOKIE['lang_mail'];
		if(isset($lang_id))
		$lang=$lang_id;
		else
		{

			$default_lang=$settings->getValue("default_language");
			if($default_lang!="")
			$lang=$default_lang;
			else
			$lang="eng";
		}
		
		 $lang=$this->getlang_id($lang);
		 
		$img=$settings->getValue("public_page_logo");
		$imgpath="admin/logo/".$img;
		$this->setValue("imgpath",$imgpath);

		
		$db->select("nesote_email_months_messages");
		$db->fields("month_id,message");
		$db->where("lang_id=?",array($lang));
		$result1=$db->query();
		$this->setLoopValue("month",$result1->getResult());

		if(isset($msg))
		{
			if($msg=="ans")
			$msg=$this->getmessage(277);
			else if($msg=="q")
			$msg=$this->getmessage(125);
			else if($msg=="i")
			$msg=$this->getmessage(149);
			else if($msg=="img")
			$msg=$this->getmessage(148);
			else if($msg=="e")
			$msg=$this->getmessage(158);
			else if($msg=="em")
			$msg=$this->getmessage(159);
			else if($msg=="d")
			$msg=$this->getmessage(128);
			else if($msg=="m")
			$msg=$this->getmessage(129);
			else if($msg=="y")
			$msg=$this->getmessage(130);
			else if($msg=="iu")//user either ans/alt email or dob wrong or both
			$msg=$this->getmessage(280);
			else if($msg=="ia")
			$msg=$this->getmessage(340);
		    else if($msg=="icv")
			$msg=$this->getmessage(784);

			$this->setValue("msg",$msg);

			$this->setValue("question",$qusetion);
			$userid=$this->getParam(1);//echo $username;
			$username=$this->getusername($userid);//echo $username;
		}
		else
		$username=$_POST['username'];
		$flag=1;$err="";


////////////////anna//////////////////

$captcha_sitekey=$settings->getValue("captcha_sitekey");
$this->setValue("captcha_sitekey",$captcha_sitekey);
			//////////////////anna///////////////////


		$userid="";$qusetion="";$answer="";

		if($username=="")
		{
			$flag=0;
			$err="u";
			header("Location:".$this->url("index/forgotpassword/$err"));
			exit(0);
			//$msg=$this->getmessage(270);

		}

		else
		{
			//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.beta.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="inoutwebmaildemo.com") )
			//{

if($restricted_mode=='true')
			{
				if(($username=="demouser1")||($username=="demouser2"))
				{

					$msg="ia";
					header("Location:".$this->url("index/forgotpassword/$msg"));
					exit(0);
				}
			}

			$uname=$username.$this->getextension();
			if($this->isEmail($uname)==false)
			{
				$flag=0;
				$err="e";
				header("Location:".$this->url("index/forgotpassword/$err"));
				exit(0);
			}
			else
			{
				
				$db->select("nesote_inoutscripts_users");
				$db->fields("*");
				$db->where("username=? and status=?",array($username,1));
				$result=$db->query();//echo $db->getQuery();
				$row=$db->fetchRow($result);
				$num=$db->numRows($result);
				//echo $num;exit;
				if($num==0)
				{
					$flag=0;
					$err="iu";
					header("Location:".$this->url("index/forgotpassword/$err"));
					exit(0);
				}
				else if($num==1)
				{
				$userid=$row[0];
				$db->select("nesote_email_usersettings");
			    $db->fields("remember_answer,alternate_email");
			    $db->where("userid=?",array($userid));
			    $result=$db->query();
			    $row=$db->fetchRow($result);
			    $answer=$row[0];$alteremail=$row[1];
					

				}
			}

		}

		$this->setValue("msg",$msg);
		$this->setValue("uid",$userid);
		$this->setValue("uname",$username);
		//$this->setValue("question",$qusetion);
		$this->setValue("answer",$answer);
		$this->setValue("alteremail",$alteremail);

	}

	function getId($username)
	{

		$db=new NesoteDALController();
		$db->select("nesote_inoutscripts_users");
		$db->fields("id");
		$db->where("username=?", array($username));
		$result=$db->query();
		$rs=$db->fetchRow($result);

		return $rs[0];

	}

	 function avilableusers()
    {
        $str=array();

        $db=new NesoteDALController();
        $db->select("nesote_inoutscripts_users");
        $db->fields("id");
        $db->where("id<=2 and id>=1  and status=?", array(1));
        $result=$db->query();
        while($rs=$db->fetchRow($result))
        {
            $st.=$rs[0].",";
        }

        $st.=substr($st,0,-1);

        
        $db->select("nesote_chat_users");
        $db->fields("distinct userid");
		if($st!="")
        $db->where("logout_status=? and userid IN($st)", array(1));
		else
        $db->where("logout_status=?", array(1));
		$result=$db->query();$i=0;
        while($rs=$db->fetchRow($result))
        {
            $str[$i]=$rs[0];$i++;
        }
        return $str;

    }
	
	function setlanguageAction()
       {
               $lang=$this->getParam(1); $url="";

               if($lang!="")
               {
                       //echo $lang;
                       //setcookie("lang_id",$lang,"0","/");
                       $url=$this->url("index/index");
                       echo $url."{".$lang;die;
               }
               else
               {

                       $url=$this->url("index/index");
                       echo $url;die;
               }
       }
function forgotyourpasswordAction()
	{
		require("script.inc.php");
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$db=new NesoteDALController();	
		
		$style_id=$settings->getValue("themes");
				
		$db->select("nesote_email_themes");
		$db->fields("name,style");
		$db->where("id=?",$style_id);
		$result=$db->query();
		$theme=$db->fetchRow($result);

		$this->setValue("style",$theme[1]);
		$footermsg=$this->getmessage(351);
		$year=date("Y",time());
		$footer=str_replace('{year}',$year,$footermsg);
		$this->setValue("footer",$footer);

		$flag=1;
		$username=$_POST['uname'];



		$userid=$this->getId($username);

		//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.beta.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="inoutwebmaildemo.com") )
		//{
if($restricted_mode=='true')
			{
			if(($username=="demouser1")||($username=="demouser2"))
			{
				$msg="ia";
				header("Location:".$this->url("index/forgotpasswordprocess/$userid/$msg"));
				exit(0);
			}
		}

		$uid=$_POST['uid'];
		$whichspan=$_POST['whichspan'];
		$this->setValue("msg",$msg);
		if($whichspan=='qstnanswerid')//for question answer
		{

			$question=trim($_POST['question']);$myqst="";
			$answer=$_POST['answer'];
			$day=$_POST['day'];
			$month=$_POST['month'];
			$year=$_POST['year'];


			$image=$_POST['image'];





			if($question=="")
			{
				$flag=0;
				$err="q";
				header("Location:".$this->url("index/forgotpasswordprocess/$userid/$err"));
				exit(0);//277
			}
			else if($question==1)
			{
				$myqst=trim($_POST['myqst']);
				if($myqst=="")
				{
					$flag=0;
					$err="q";
					header("Location:".$this->url("index/forgotpasswordprocess/$userid/$err"));
					exit(0);//277
				}
				else if($answer=="")
				{
					$flag=0;
					$err="ans";
					header("Location:".$this->url("index/forgotpasswordprocess/$userid/$err"));
					exit(0);//277
				}
			}
			if($answer=="")
			{
				$flag=0;
				$err="ans";
				header("Location:".$this->url("index/forgotpasswordprocess/$userid/$err"));
				exit(0);//277
			}
			else if($day=="")
			{
				$flag=0;
				$err="d";
				header("Location:".$this->url("index/forgotpasswordprocess/$userid/$err"));
				exit(0);//128
			}
			else if($month=="")
			{
				$flag=0;
				$err="m";
				header("Location:".$this->url("index/forgotpasswordprocess/$userid/$err"));
				exit(0);//129

			}
			else if($year=="")
			{
				$flag=0;
				$err="y";
				header("Location:".$this->url("index/forgotpasswordprocess/$userid/$err"));
				exit(0);//130
			}


			/*else if($image=="")
			{
				$flag=0;
				$err="i";
				header("Location:".$this->url("index/forgotpasswordprocess/$userid/$err"));
				exit(0);//149
			}*/
			else
			{
					

////////////////anna//////////////////

$captcha_sitekey=$settings->getValue("captcha_sitekey");
$this->setValue("captcha_sitekey",$captcha_sitekey);

$secret=$settings->getValue("captche_secretkey");
		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);

	    $responseData = json_decode($verifyResponse);//print_r($responseData);exit;

	    if($responseData->success)
	    {

$flag=1;
}
else
{
	$flag=0;
	$err="icv";
			header("Location:".$this->url("index/forgotpasswordprocess/$userid/$err"));
			exit(0);
}
			//////////////////anna///////////////////

				$image="";//trim($_POST['image']);

				$enc_image="";//md5($image);
				$random="";//$_COOKIE['random'];

				if($random!=$enc_image)
				{
					$flag=0;
					$err="img";
					header("Location:".$this->url("index/forgotpasswordprocess/$userid/$err"));
					exit(0);//148
				}

				else
				{
					$dob=mktime(0,0,0,$month,$day,$year);//echo $month."/".$day."/".$year."/".$dob."/".$answer;exit;

					// update password
					$oldpassword="";
					if($question==1)
					$question=trim($_POST['myqst']);
					
					$db->select(array("a"=>"nesote_inoutscripts_users","b"=>"nesote_email_usersettings"));
					$db->fields("a.password,b.remember_answer,b.remember_question");
					$db->where("a.username=? and a.status=? and a.id=? and b.dateofbirth=? and a.id=b.userid",array($username,1,$uid,$dob));
					$result8=$db->query();//echo $db->getQuery();
					$row8=$db->fetchRow($result8);
					$num=$db->numRows($result8);

					if($num==0)
					{
						$flag=0;
						$err="iu";
						header("Location:".$this->url("index/forgotpasswordprocess/$userid/$err"));
						exit(0);
					}
					else
					{

						$table_qstn=trim($row8[2]);
						$user_qstn=trim($question);

						$table_answer=trim($row8[1]);
						$user_answer=trim($answer);

						$table_qstn=strtolower($table_qstn);$user_qstn=strtolower($user_qstn);
						$user_qstn=trim($user_qstn);$table_qstn=trim($table_qstn);
						$user_qstn=str_replace(" ",'',$user_qstn);$table_qstn=str_replace(" ",'',$table_qstn);

						$table_answer=strtolower($table_answer);$user_answer=strtolower($user_answer);
						$user_answer=trim($user_answer);$table_answer=trim($table_answer);
						$user_answer=str_replace(" ",'',$user_answer);$table_answer=str_replace(" ",'',$table_answer);


						if(strcmp($table_qstn,$user_qstn)!=0)
						{
							$flag=0;
							$err="iu";
							header("Location:".$this->url("index/forgotpasswordprocess/$userid/$err"));
							exit(0);
						}
						else if(strcmp($table_answer,$user_answer)!=0)
						{
							$flag=0;
							$err="iu";
							header("Location:".$this->url("index/forgotpasswordprocess/$userid/$err"));
							exit(0);
						}
						else
						$oldpassword=$row8[0];
					}
					if($oldpassword!="")
					{
						$str="";
						$chr1= array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
						$numbers= array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
						$CHR2=array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H','J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q','R', 'S', 'T', 'U','V', 'W','X','Y','Z');
						$spl=array("!","@","#","$","%","^","&","*");

						$c1=array_rand($CHR2);
						$c2=array_rand($CHR2);
						while (trim($c1)==trim($c2))
						{
							$c1=array_rand($CHR2);
							$c2=array_rand($CHR2);
						}

						$c3=array_rand($chr1);
						$c4=array_rand($chr1);
						while (trim($c3)==trim($c4))
						{
							$c3=array_rand($chr1);
							$c4=array_rand($chr1);

						}

						$s1=array_rand($spl);
						$s2=array_rand($spl);
						while (trim($s1)==trim($s2))
						{
							$s1=array_rand($spl);
							$s2=array_rand($spl);

						}

						$no1=array_rand($numbers);
						$no2=array_rand($numbers);
						while (trim($no1)==trim($no2))
						{
							$no1=array_rand($numbers);
							$no2=array_rand($numbers);

						}

						$str=$chr1[$c3].$spl[$s1].$CHR2[$c1].$numbers[$no1].$CHR2[$c2].$spl[$s2].$numbers[$no2].$chr1[$c4];


						//echo $str;exit;
						$newpassword=$str;
						$salt_password=$settings->getValue("salt_password");
						$newpassword=$salt_password.$newpassword;
						$new_serverpassword=base64_encode($newpassword);
						//$newpassword=substr($oldpassword,0,9);//echo $newpassword;

						$encnewpassword=md5($newpassword);//echo $encnewpassword;exit;
						
						

					
                        $account_type=$settings->getValue("catchall_mail");
						if($account_type==1)// catch all
						{
							
							$db->update("nesote_email_usersettings");
							$db->set("server_password=?",$new_serverpassword);
							$db->where("userid=?",$uid);
							$result=$db->query();
							
							$db->update("nesote_inoutscripts_users");
							$db->set("password=?",array($encnewpassword));
							$db->where("username=? and password=? and id=?",array($username,$oldpassword,$uid));
							$result=$db->query();
							
							

							//$userid=$this->getId();
							$username=$this->getusername($uid);
							$this->saveLogs("Settings Updation","$username has updated his/her settings",$uid);


							header("Location:".$this->url("index/passworddetails/$uid"));
							exit(0);

						}
						else if($account_type==0)  // individual
						{
							
//							
							$automatic_account_creation=$settings->getValue("automatic_account_creation");

							if($automatic_account_creation==1)// for automatic account creation
							{

								// api calling
								$username=$this->getusername($uid);
//								
								$controlpanel=$settings->getValue("controlpanel");

								if($controlpanel==1)// cpanel
								{
									$this->capnelaction(1,$username,$newpassword);// 1 for change password
								}
								else if($controlpanel==2)//plesk
								{
									$this->pleskaction(1,$username,$newpassword);// 1 for change password
								}

								
								$db->update("nesote_email_usersettings");
								$db->set("server_password=?",$new_serverpassword);
								$db->where("userid=?",$uid);
								$result=$db->query();
							
								$db->update("nesote_inoutscripts_users");
								$db->set("password=?",array($encnewpassword));
								$db->where("username=? and password=? and id=?",array($username,$oldpassword,$uid));
								$result=$db->query();

								//$userid=$this->getId();
								$username=$this->getusername($uid);
								$this->saveLogs("Settings Updation","$username has updated his/her settings",$uid);


								header("Location:".$this->url("index/passworddetails/$uid"));
								exit(0);

							}


						}

					}
				}
			}
		}
		else if($whichspan=='altemailid')//for alternative email
		{


			
			$alternatemail=$_POST['alternatemail'];
			$day1=$_POST['day'];
			$month1=$_POST['month'];
			$year1=$_POST['year'];
			$image=$_POST['image'];




			if($alternatemail=="")
			{
				$flag=0;
				$err="e";
				header("Location:".$this->url("index/forgotpasswordprocess/$username/$err"));
				exit(0);//158
			}
			else if($this->isEmail($alternatemail)==false)
			{
				$flag=0;
				$err="em";
				header("Location:".$this->url("index/forgotpasswordprocess/$username/$err"));
				exit(0);//159

			}
			else if($day1=="")
			{
				$flag=0;
				$err="d";
				header("Location:".$this->url("index/forgotpasswordprocess/$username/$err"));
				exit(0);//128

			}
			else if($month1=="")
			{
				$flag=0;
				$err="m";
				header("Location:".$this->url("index/forgotpasswordprocess/$username/$err"));
				exit(0);//129

			}
			else if($year1=="")
			{
				$flag=0;
				$err="y";
				header("Location:".$this->url("index/forgotpasswordprocess/$username/$err"));
				exit(0);//130

			}

		/*	else if($image=="")
			{
				$flag=0;
				$err="i";
				header("Location:".$this->url("index/forgotpasswordprocess/$username/$err"));
				exit(0);//149
			}*/
			else
			{

				
////////////////anna//////////////////

$captcha_sitekey=$settings->getValue("captcha_sitekey");
$this->setValue("captcha_sitekey",$captcha_sitekey);

$secret=$settings->getValue("captche_secretkey");
		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);

	    $responseData = json_decode($verifyResponse);//print_r($responseData);exit;

	    if($responseData->success)
	    {

$flag=1;
}
else
{
	$flag=0;
	$err="icv";
			header("Location:".$this->url("index/forgotpasswordprocess/$userid/$err"));
			exit(0);
}
			//////////////////anna///////////////////




				$image="";//trim($_POST['image']);

				$enc_image="";//md5($image);
				$random="";//$_COOKIE['random'];

				if($random!=$enc_image)
				{
					$flag=0;
					$err="img";
					header("Location:".$this->url("index/forgotpasswordprocess/$username/$err"));
					exit(0);
				}
				else
				{

					$dob1=mktime(0,0,0,$month1,$day1,$year1);
					//upadte password
					
					$db->select(array("a"=>"nesote_inoutscripts_users","b"=>"nesote_email_usersettings"));
					$db->fields("a.password,a.joindate");
					//if($whichmail==1)
				   $db->where("a.username=? and a.status=? and a.id=? and b.dateofbirth=? and b.alternate_email=? and a.id=b.userid",array($username,1,$uid,$dob1,$alternatemail));
					//else
					//$db->where("a.username=? and a.status=? and a.id=? and b.dateofbirth=?  and a.id=b.userid",array($username,1,$uid,$dob1));
					$result1=$db->query();
//echo $db->getQuery();exit;
					$no1=$db->numRows($result1);
					$row=$db->fetchRow($result1);
					if($no1==0)
					{
						$flag=0;
						$err="iu";
						header("Location:".$this->url("index/forgotpasswordprocess/$uid/$err"));
						exit(0);
					}
					else
					{
						$oldpassword1=$row[0];
						$creattime=$row[1];
					}
					if($oldpassword1!="")
					{


						$str="";
						$chr1= array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
						$numbers= array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
						$CHR2=array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H','J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q','R', 'S', 'T', 'U','V', 'W','X','Y','Z');
						$spl=array("!","@","#","$","%","^","&","*");

						$c1=array_rand($CHR2);
						$c2=array_rand($CHR2);
						while (trim($c1)==trim($c2))
						{
							$c1=array_rand($CHR2);
							$c2=array_rand($CHR2);
						}

						$c3=array_rand($chr1);
						$c4=array_rand($chr1);
						while (trim($c3)==trim($c4))
						{
							$c3=array_rand($chr1);
							$c4=array_rand($chr1);

						}

						$s1=array_rand($spl);
						$s2=array_rand($spl);
						while (trim($s1)==trim($s2))
						{
							$s1=array_rand($spl);
							$s2=array_rand($spl);

						}

						$no1=array_rand($numbers);
						$no2=array_rand($numbers);
						while (trim($no1)==trim($no2))
						{
							$no1=array_rand($numbers);
							$no2=array_rand($numbers);

						}

						$str=$chr1[$c3].$spl[$s1].$CHR2[$c1].$numbers[$no1].$CHR2[$c2].$spl[$s2].$numbers[$no2].$chr1[$c4];


						//echo $str;exit;
						$newpassword1=$str;
						$salt_password=$settings->getValue("salt_password");
						$newpassword1=$salt_password.$newpassword1;
						$new_serverpassword1=base64_encode($newpassword1);
						$encnewpassword1=md5($newpassword1);

						

						$account_type=$settings->getValue("catchall_mail");

						if($account_type==1)// catch all
						{


							$forgotpassword_msg=$settings->getValue("forgotpassword_msg");
							$forgotpassword_msg=htmlspecialchars($forgotpassword_msg);
							$forgotpassword_msg=html_entity_decode($forgotpassword_msg);

							$subject=$this->getmessage(286);
							$message=$this->getmessage(287);
							$click=$this->getmessage(288);
							$value2=trim($uid.$creattime);
							$value3=md5($value2);

							$engine_name=$settings->getValue("engine_name");

							$from=$settings->getValue("adminemail");


							$link="<a href=\"";
							$link.=$this->url("index/updatepassword/$value3");
							$link.="\" target=\"_blank\" >$click</a>";


							$mail=str_replace('{Subject}',$subject.'|'.$engine_name,$forgotpassword_msg);
							$mail=str_replace('{msg}',$message,$mail);
							$mail=str_replace('{link}',$link,$mail);
                                                        $mail=str_replace('{website}',"http://".$_SERVER['HTTP_HOST'],$mail);
                                                        $mail=str_replace('{admin}',$from,$email);
                                                        $mail=str_replace('{service}',$engine_name,$email);

							$mail=nl2br($mail);

							$headers = "From:". $from. "\r\n";
							$headers .= "MIME-Version: 1.0\r\n";

							$headers .= "Content-type: text/html; charset=UTF-8\r\n";

							//---------------------------for high priority-----------------------
							$headers .= "X-Priority: 1 (Highest)\n";
							$headers .= "X-MSMail-Priority: High\n";
							$headers .= "Importance: High\n";
							//---------------------------------------------------------------------
							$headers .= 'Reply-To:'.$from;
							$p=$this->smtp_mail($alternatemail,$subject,$mail,$headers,$uid,$username,$from);
							if($p==1)
							header("Location:".$this->url("index/passwordprocesscontinue"));
							else
							header("Location:".$this->url("index/forgotpassword"));
							exit(0);


						}
						else if($account_type==0)  // individual
						{
//echo "aaavvv";exit;

                            $automatic_account_creation=$settings->getValue("automatic_account_creation");
							
							if($automatic_account_creation==1)// for automatic account creation
							{

								// api calling



								$forgotpassword_msg=$settings->getValue("forgotpassword_msg");
								$forgotpassword_msg=htmlspecialchars($forgotpassword_msg);
								$forgotpassword_msg=html_entity_decode($forgotpassword_msg);
							$engine_name=$settings->getValue("engine_name");

								$subject=$this->getmessage(286);
								$message=$this->getmessage(287);
								$click=$this->getmessage(288);
								$value2=trim($uid.$creattime);
								$value3=md5($value2);

								$from=$settings->getValue("adminemail");


								$link="<a href=\"";
								$link.=$this->url("index/updatepassword/$value3");
								$link.="\" target=\"_blank\" >$click</a>";
//echo $link;exit;


							$mail=str_replace('{Subject}',$subject.'|'.$engine_name,$forgotpassword_msg);
								$mail=str_replace('{msg}',$message,$mail);
								$mail=str_replace('{link}',$link,$mail);
  $mail=str_replace('{website}',"http://".$_SERVER['HTTP_HOST'],$mail);
                                                        $mail=str_replace('{admin}',$from,$mail);
                                                        $mail=str_replace('{service}',$engine_name,$mail);

								$mail=nl2br($mail);

								$headers = "From:". $from. "\r\n";
								$headers .= "MIME-Version: 1.0\r\n";

								$headers .= "Content-type: text/html; charset=UTF-8\r\n";

								//---------------------------for high priority-----------------------
								$headers .= "X-Priority: 1 (Highest)\n";
								$headers .= "X-MSMail-Priority: High\n";
								$headers .= "Importance: High\n";
								//---------------------------------------------------------------------
								$headers .= 'Reply-To:'.$from;

								//$p=mail($alternatemail,$subject,$mail,$headers);
                                                                $p=$this->smtp_mail($alternatemail,$subject,$mail,$headers,$uid,$username,$from);
								if($p==1)
								header("Location:".$this->url("index/passwordprocesscontinue"));
								else
								header("Location:".$this->url("index/forgotpassword"));
								exit(0);

							}


						}

					}


				}//upadtion complete

			}
		}
	}
function smtp_mail($alternatemail,$subject,$mailcontent,$headers,$id,$username,$from)
{
//return "aaaa";exit;
$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$db=new NesoteDALController();
$extention=$settings->getValue("emailextension");
		if(substr($extention,0,1)!="@")
		{
			$fullid=$username."@".$extention;
		}
		else
		{
			$fullid=$username.$extention;
		}
$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name=?", array("user_smtp"));
			$result=$db->query();
			$row=$db->fetchRow($result);
			$extsmtp=$row[0];

			require_once('class/class.phpmailer.php');
	                require_once('class/class.smtp.php');
			$mail = new PHPMailer(true); 
			//$mail->IsSMTP(); 
if($extsmtp==1)
{
$mail->IsSMTP();
}
if($extsmtp==1)
{

$db->select("nesote_email_smtp_settings");
			$db->fields("*");
			//$db->where("userid=?", array($id));
			$result=$db->query();
			$row=$db->fetchRow($result);
			$SMTP_host=$row[1];
			$SMTP_password=$row[4];
			$SMTP_username=$row[3];
                        $SMTP_port=$row[2];
//return $SMTP_host;return "<br>";return $SMTP_port;return "<br>";return $SMTP_username;return "<br>";return $SMTP_password;return "<br>";
}
else
{

				$SMTP_host=$settings->getValue("SMTP_host");


				$SMTP_port=$settings->getValue("SMTP_port");
				

				$SMTP_username=$fullid;

				$db->select("nesote_email_usersettings");
				$db->fields("server_password");
				$db->where("userid=? ",array($id));
				$result=$db->query();
				$row=$db->fetchRow($result);
				$SMTP_password=base64_decode($row[0]);
}

				$mail->Host       = $SMTP_host; // SMTP server
				$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->Port       = $SMTP_port;                    // set the SMTP port for the GMAIL server
				$mail->Username   = $SMTP_username; // SMTP account username
				$mail->Password   = $SMTP_password;
				// SMTP account password
//return $mail;exit;
				//$mail->AddReplyTo($alternatemail);


				$mail->AddAddress($alternatemail);

				$mail->SetFrom($from);//('saneesh@valiyapalli.com', 'Saneesh Baby');
				$mail->Subject = $subject;
				//$mail->SMTPSecure="ssl";
				//$mail->AltBody = $alternate_message; // optional - MsgHTML will create an alternate automatically
				$mail->MsgHTML($mailcontent);
				$rt=$mail->Send();
				//echo "Message Sent OK</p>\n";exit;
			
			return $rt;
}

	function updatepasswordAction()
	{
require("script.inc.php");
		
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$db=new NesoteDALController();

		$style_id=$settings->getValue("themes");
			
		
		$db->select("nesote_email_themes");
		$db->fields("name,style");
		$db->where("id=?",$style_id);
		$result=$db->query();
		$theme=$db->fetchRow($result);

		$this->setValue("style",$theme[1]);
		$footermsg=$this->getmessage(351);
		$year=date("Y",time());
		$footer=str_replace('{year}',$year,$footermsg);
		$this->setValue("footer",$footer);


		$img=$settings->getValue("public_page_logo");
		$imgpath="admin/logo/".$img;
		$this->setValue("imgpath",$imgpath);


		$pwd=$this->getParam(1);//echo $pwd; exit;
		$this->setValue("pwd",$pwd);
		if($_POST)
		{
			$button=$_POST['submit1'];
			$value=$_POST['pwd'];//echo $value;

			if($button)
			{
				//echo $button;echo hai;
				//md5(id+createdtime);
				$id="";$flag=0;
				
				$db->select("nesote_inoutscripts_users");
				$db->fields("id,joindate");
				$result=$db->query();
				$num=$db->numRows($result);
				if($num!=0)
				{
					while($row=$db->fetchRow($result))
					{
						$c=$row[0].$row[1];
						$checkvalue=md5($c);
						if(trim($checkvalue)==trim($value))
						{
							$flag=1;
							$id=$row[0];break;
						}
					}
				}
				//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.beta.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="inoutwebmaildemo.com") )
				//{
if($restricted_mode=='true')
			{
					if($id<=2)
					{
						$msg="ia";
						header("Location:".$this->url("index/forgotpassword/$msg"));
						exit(0);
					}
				}
				if(($id!="") && ($flag==1))
				{
					
					$db->select("nesote_inoutscripts_users");
					$db->fields("password,username");
					$db->where("id=?",array($id));
					$result1=$db->query();//echo $db->getQuery();
					$no1=$db->numRows($result1);
					$row=$db->fetchRow($result1);
					if($no1!=0)
					$oldpassword1=$row[0];

					if($oldpassword1!="")
					{

						$str="";
						$chr1= array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
						$numbers= array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
						$CHR2=array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H','J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q','R', 'S', 'T', 'U','V', 'W','X','Y','Z');
						$spl=array("!","@","#","$","%","^","&","*");

						$c1=array_rand($CHR2);
						$c2=array_rand($CHR2);
						while (trim($c1)==trim($c2))
						{
							$c1=array_rand($CHR2);
							$c2=array_rand($CHR2);
						}

						$c3=array_rand($chr1);
						$c4=array_rand($chr1);
						while (trim($c3)==trim($c4))
						{
							$c3=array_rand($chr1);
							$c4=array_rand($chr1);

						}

						$s1=array_rand($spl);
						$s2=array_rand($spl);
						while (trim($s1)==trim($s2))
						{
							$s1=array_rand($spl);
							$s2=array_rand($spl);

						}

						$no1=array_rand($numbers);
						$no2=array_rand($numbers);
						while (trim($no1)==trim($no2))
						{
							$no1=array_rand($numbers);
							$no2=array_rand($numbers);

						}

						$str=$chr1[$c3].$spl[$s1].$CHR2[$c1].$numbers[$no1].$CHR2[$c2].$spl[$s2].$numbers[$no2].$chr1[$c4];


						//echo $str;exit;
						$newpassword1=$str;
						$salt_password=$settings->getValue("salt_password");
							$newpassword1=$salt_password.$newpassword1;
						$new_serverpassword1=base64_encode($newpassword1);



						$encnewpassword1=md5($newpassword1);
						$username=$this->getusername($id);

						

						$controlpanel=$settings->getValue("controlpanel");

						if($controlpanel==1)// cpanel
						{
							$this->capnelaction(1,$username,$newpassword1);// 1 for change password
						}
						else if($controlpanel==2)//plesk
						{
							$this->pleskaction(1,$username,$newpassword1);// 1 for change password
						}

						$db->update("nesote_email_usersettings");
						$db->set("server_password=?",array($new_serverpassword1));
						$db->where("userid=?",array($id));
						$result2=$db->query();
						
						$db->update("nesote_inoutscripts_users");
						$db->set("password=?",array($encnewpassword1));
						$db->where("id=? and password=?",array($id,$oldpassword1));
						$result2=$db->query();//echo $update->getQuery();
						

						$this->saveLogs("Settings Updation","$username has updated his/her password",$id);

						header("Location:".$this->url("index/passworddetails/$id"));
						exit(0);

					}

				}
				else
				{
					header("Location:".$this->url("index/passworddetails/err"));
					exit(0);
				}

			}
		}

	}

	function passworddetailsAction()
	{
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		
		$db=new NesoteDALController();
		$style_id=$settings->getValue("themes");
				
		$db->select("nesote_email_themes");
		$db->fields("name,style");
		$db->where("id=?",$style_id);
		$result=$db->query();
		$theme=$db->fetchRow($result);

		$this->setValue("style",$theme[1]);
		$footermsg=$this->getmessage(351);
		$year=date("Y",time());
		$footer=str_replace('{year}',$year,$footermsg);
		$this->setValue("footer",$footer);

		$img=$settings->getValue("public_page_logo");
		$imgpath="admin/logo/".$img;
		$this->setValue("imgpath",$imgpath);

		$id=$this->getParam(1);//echo $id;
		$msg="";
		if(isset($id))
		{
			if($id=="err")
			{
				$msg=$this->getmessage(285);//echo $msg;
			}
			else
			{
				
				$db->select("nesote_email_usersettings");
				$db->fields("server_password");
				$db->where("userid=?",array($id));
				$result=$db->query();//echo $db->getQuery();
				$row=$db->fetchRow($result);

				$new_serverpassword=base64_decode($row[0]);
				$salt_password=$settings->getValue("salt_password");
				$new_serverpassword=str_replace($salt_password, '',$new_serverpassword);
				$this->setValue("password",$new_serverpassword);
			}
		}
		if($msg!="")
		$this->setValue("msg",$msg);//echo $msg;

	}

	function passwordprocesscontinueAction()
	{
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		
		$select=new NesoteDALController();

		$style_id=$settings->getValue("themes");	
		
		$select->select("nesote_email_themes");
		$select->fields("name,style");
		$select->where("id=?",$style_id);
		$result=$select->query();
		$theme=$select->fetchRow($result);

		$this->setValue("style",$theme[1]);
		$footermsg=$this->getmessage(351);
		$year=date("Y",time());
		$footer=str_replace('{year}',$year,$footermsg);
		$this->setValue("footer",$footer);

		$img=$settings->getValue("public_page_logo");
		$imgpath="admin/logo/".$img;
		$this->setValue("imgpath",$imgpath);
	}

	function capnelaction($execte,$username,$value)
	{

//return $execte;exit;
		include_once 'class/xmlapi.php';
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();

		$ip=$settings->getValue("domain_ip");

		$root_pass=$settings->getValue("domain_password");

		$email_domain=$settings->getValue("domain_name");

		$domain_username=$settings->getValue("domain_username");

		$cpanel_port_number=$settings->getValue("cpanel_port_number");
		//return "aaaa";exit;
		
		$account = "cptest";
		$email_user = $username;
		$email_password = $value;
		//return $email_password;exit;
		$email_query = '10';
		$xmlapi = new xmlapi($ip);
		/* IF the port no is 2083 then uncomment the below sentence*/
		
		$xmlapi->password_auth($domain_username,$root_pass);
		$xmlapi->set_port(2083);
		$xmlapi->set_output('json');
		$email_quota=0;

		$xmlapi->set_debug(1);
		if($execte==1) //for password change
		{
			$xmlapi->api1_query($account, "Email", "passwdpop", array($email_user, $value, $email_quota, $email_domain) );
			//print_r($xmlapi);exit;
		}

		return;

	}

	function pleskaction($execte,$username,$value)
	{

		include_once 'class/mail_plesk.php';
           
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();

		$host=$settings->getValue("domain_name");

		$login=$settings->getValue("domain_username");

		$password=$settings->getValue("domain_password");

		$plesk_packetversion=$settings->getValue("plesk_packetversion");

		$plesk_domainid=$settings->getValue("plesk_domainid");

		if($execte==1)// for change password
		{

			$change="<?xml version='1.0' encoding='UTF-8' ?>
			<packet version=$plesk_packetversion>
			<mail>
			<update>
			<set>
			<filter><domain_id>$plesk_domainid</domain_id>
			<mailname>
			<name>$username</name>
			<mailbox>
			<enabled>true</enabled>
			</mailbox>
			<password>$value</password>
			<password_type>plain</password_type>

			</mailname>
			</filter>
			</set>
			</update>
			</mail>
			</packet>
						";
			$action=$change;
		}


		$curl = curlInit($host, $login, $password);
		try {

			// echo GET_PROTOS;
			$response = sendRequest($curl, $action);//echo $response;
			$responseXml = parseResponse($response);
			checkResponse($responseXml);
		} catch (ApiRequestException $e) {
			echo $e;
			die();
		}
		// Explore the result
		foreach ($responseXml->xpath('/packet/domain/get/result') as $resultNode) {
			echo "Domain id: " . (string)$resultNode->id . " ";
			echo (string)$resultNode->data->gen_info->name . " (" .
			(string)$resultNode->data->gen_info->dns_ip_address . ")\n";
		}

		return;

	}
function isEmail($email)
	{
		$result =false;
		if(preg_match ('/[^a-z0-9,._]/i', $email))
		{
			return true;
		}

		return $result;
	}

	function getusername($id)
	{

		$db=new NesoteDALController();
		$db->select("nesote_inoutscripts_users");
		$db->fields("username");
		$db->where("id=?",array($id));
		$result=$db->query();
		$row=$db->fetchRow($result);
		return $row[0];
	}

	function saveLogs($operation,$comment,$userid)
	{
		//$userid=$this->getId();

		$insert=new NesoteDALController();
		$insert->insert("nesote_email_client_logs");
		$insert->fields("uid,operation,comment,time");
		$insert->values(array($userid,$operation,$comment,time()));
		$insert->query();
	}  
function mobile_device_detect($iphone=true,$android=true,$opera=true,$blackberry=true,$palm=true,$windows=true,$mobileredirect=false,$desktopredirect=false){

        $mobile_browser   = false;
        $user_agent       = $_SERVER['HTTP_USER_AGENT']; 
        $accept           = $_SERVER['HTTP_ACCEPT'];

        switch(true){ 

            case (preg_match('ipod',$user_agent)||preg_match('iphone',$user_agent)||preg_match('iPhone',$user_agent)); 
            $mobile_browser = $iphone; 
            if(substr($iphone,0,4)=='http'){ 
                $mobileredirect = $iphone;
            }
            break;
            case (preg_match('android',$user_agent));
            $mobile_browser = $android; 
            if(substr($android,0,4)=='http'){ 
                $mobileredirect = $android; 
            } 
            break; 
            case (preg_match('opera mini',$user_agent));
            $mobile_browser = $opera; 
            if(substr($opera,0,4)=='http'){
                $mobileredirect = $opera;
            }
            break; 
            case (preg_match('blackberry',$user_agent));
            $mobile_browser = $blackberry;
            if(substr($blackberry,0,4)=='http'){
                $mobileredirect = $blackberry;
            }
            break; 
            case (preg_match('/(palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine)/i',$user_agent));
            $mobile_browser = $palm;
            if(substr($palm,0,4)=='http'){ 
                $mobileredirect = $palm;
            }
            break; 
            case (preg_match('/(windows ce; ppc;|windows ce; smartphone;|windows ce; iemobile)/i',$user_agent));
            $mobile_browser = $windows; 
            if(substr($windows,0,4)=='http'){
                $mobileredirect = $windows;
            }
            break;

            case (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|pda|psp|treo)/i',$user_agent));
            $mobile_browser = true; 
            break; 
            case ((strpos($accept,'text/vnd.wap.wml')>0)||(strpos($accept,'application/vnd.wap.xhtml+xml')>0)); 
            $mobile_browser = true;
            break; 
            case (isset($_SERVER['HTTP_X_WAP_PROFILE'])||isset($_SERVER['HTTP_PROFILE']));
            $mobile_browser = true;
            break;
            case (in_array(strtolower(substr($user_agent,0,4)),array('1207'=>'1207','3gso'=>'3gso','4thp'=>'4thp','501i'=>'501i','502i'=>'502i','503i'=>'503i','504i'=>'504i','505i'=>'505i','506i'=>'506i','6310'=>'6310','6590'=>'6590','770s'=>'770s','802s'=>'802s','a wa'=>'a wa','acer'=>'acer','acs-'=>'acs-','airn'=>'airn','alav'=>'alav','asus'=>'asus','attw'=>'attw','au-m'=>'au-m','aur '=>'aur ','aus '=>'aus ','abac'=>'abac','acoo'=>'acoo','aiko'=>'aiko','alco'=>'alco','alca'=>'alca','amoi'=>'amoi','anex'=>'anex','anny'=>'anny','anyw'=>'anyw','aptu'=>'aptu','arch'=>'arch','argo'=>'argo','bell'=>'bell','bird'=>'bird','bw-n'=>'bw-n','bw-u'=>'bw-u','beck'=>'beck','benq'=>'benq','bilb'=>'bilb','blac'=>'blac','c55/'=>'c55/','cdm-'=>'cdm-','chtm'=>'chtm','capi'=>'capi','comp'=>'comp','cond'=>'cond','craw'=>'craw','dall'=>'dall','dbte'=>'dbte','dc-s'=>'dc-s','dica'=>'dica','ds-d'=>'ds-d','ds12'=>'ds12','dait'=>'dait','devi'=>'devi','dmob'=>'dmob','doco'=>'doco','dopo'=>'dopo','el49'=>'el49','erk0'=>'erk0','esl8'=>'esl8','ez40'=>'ez40','ez60'=>'ez60','ez70'=>'ez70','ezos'=>'ezos','ezze'=>'ezze','elai'=>'elai','emul'=>'emul','eric'=>'eric','ezwa'=>'ezwa','fake'=>'fake','fly-'=>'fly-','fly_'=>'fly_','g-mo'=>'g-mo','g1 u'=>'g1 u','g560'=>'g560','gf-5'=>'gf-5','grun'=>'grun','gene'=>'gene','go.w'=>'go.w','good'=>'good','grad'=>'grad','hcit'=>'hcit','hd-m'=>'hd-m','hd-p'=>'hd-p','hd-t'=>'hd-t','hei-'=>'hei-','hp i'=>'hp i','hpip'=>'hpip','hs-c'=>'hs-c','htc '=>'htc ','htc-'=>'htc-','htca'=>'htca','htcg'=>'htcg','htcp'=>'htcp','htcs'=>'htcs','htct'=>'htct','htc_'=>'htc_','haie'=>'haie','hita'=>'hita','huaw'=>'huaw','hutc'=>'hutc','i-20'=>'i-20','i-go'=>'i-go','i-ma'=>'i-ma','i230'=>'i230','iac'=>'iac','iac-'=>'iac-','iac/'=>'iac/','ig01'=>'ig01','im1k'=>'im1k','inno'=>'inno','iris'=>'iris','jata'=>'jata','java'=>'java','kddi'=>'kddi','kgt'=>'kgt','kgt/'=>'kgt/','kpt '=>'kpt ','kwc-'=>'kwc-','klon'=>'klon','lexi'=>'lexi','lg g'=>'lg g','lg-a'=>'lg-a','lg-b'=>'lg-b','lg-c'=>'lg-c','lg-d'=>'lg-d','lg-f'=>'lg-f','lg-g'=>'lg-g','lg-k'=>'lg-k','lg-l'=>'lg-l','lg-m'=>'lg-m','lg-o'=>'lg-o','lg-p'=>'lg-p','lg-s'=>'lg-s','lg-t'=>'lg-t','lg-u'=>'lg-u','lg-w'=>'lg-w','lg/k'=>'lg/k','lg/l'=>'lg/l','lg/u'=>'lg/u','lg50'=>'lg50','lg54'=>'lg54','lge-'=>'lge-','lge/'=>'lge/','lynx'=>'lynx','leno'=>'leno','m1-w'=>'m1-w','m3ga'=>'m3ga','m50/'=>'m50/','maui'=>'maui','mc01'=>'mc01','mc21'=>'mc21','mcca'=>'mcca','medi'=>'medi','meri'=>'meri','mio8'=>'mio8','mioa'=>'mioa','mo01'=>'mo01','mo02'=>'mo02','mode'=>'mode','modo'=>'modo','mot '=>'mot ','mot-'=>'mot-','mt50'=>'mt50','mtp1'=>'mtp1','mtv '=>'mtv ','mate'=>'mate','maxo'=>'maxo','merc'=>'merc','mits'=>'mits','mobi'=>'mobi','motv'=>'motv','mozz'=>'mozz','n100'=>'n100','n101'=>'n101','n102'=>'n102','n202'=>'n202','n203'=>'n203','n300'=>'n300','n302'=>'n302','n500'=>'n500','n502'=>'n502','n505'=>'n505','n700'=>'n700','n701'=>'n701','n710'=>'n710','nec-'=>'nec-','nem-'=>'nem-','newg'=>'newg','neon'=>'neon','netf'=>'netf','noki'=>'noki','nzph'=>'nzph','o2 x'=>'o2 x','o2-x'=>'o2-x','opwv'=>'opwv','owg1'=>'owg1','opti'=>'opti','oran'=>'oran','p800'=>'p800','pand'=>'pand','pg-1'=>'pg-1','pg-2'=>'pg-2','pg-3'=>'pg-3','pg-6'=>'pg-6','pg-8'=>'pg-8','pg-c'=>'pg-c','pg13'=>'pg13','phil'=>'phil','pn-2'=>'pn-2','pt-g'=>'pt-g','palm'=>'palm','pana'=>'pana','pire'=>'pire','pock'=>'pock','pose'=>'pose','psio'=>'psio','qa-a'=>'qa-a','qc-2'=>'qc-2','qc-3'=>'qc-3','qc-5'=>'qc-5','qc-7'=>'qc-7','qc07'=>'qc07','qc12'=>'qc12','qc21'=>'qc21','qc32'=>'qc32','qc60'=>'qc60','qci-'=>'qci-','qwap'=>'qwap','qtek'=>'qtek','r380'=>'r380','r600'=>'r600','raks'=>'raks','rim9'=>'rim9','rove'=>'rove','s55/'=>'s55/','sage'=>'sage','sams'=>'sams','sc01'=>'sc01','sch-'=>'sch-','scp-'=>'scp-','sdk/'=>'sdk/','se47'=>'se47','sec-'=>'sec-','sec0'=>'sec0','sec1'=>'sec1','semc'=>'semc','sgh-'=>'sgh-','shar'=>'shar','sie-'=>'sie-','sk-0'=>'sk-0','sl45'=>'sl45','slid'=>'slid','smb3'=>'smb3','smt5'=>'smt5','sp01'=>'sp01','sph-'=>'sph-','spv '=>'spv ','spv-'=>'spv-','sy01'=>'sy01','samm'=>'samm','sany'=>'sany','sava'=>'sava','scoo'=>'scoo','send'=>'send','siem'=>'siem','smar'=>'smar','smit'=>'smit','soft'=>'soft','sony'=>'sony','t-mo'=>'t-mo','t218'=>'t218','t250'=>'t250','t600'=>'t600','t610'=>'t610','t618'=>'t618','tcl-'=>'tcl-','tdg-'=>'tdg-','telm'=>'telm','tim-'=>'tim-','ts70'=>'ts70','tsm-'=>'tsm-','tsm3'=>'tsm3','tsm5'=>'tsm5','tx-9'=>'tx-9','tagt'=>'tagt','talk'=>'talk','teli'=>'teli','topl'=>'topl','tosh'=>'tosh','up.b'=>'up.b','upg1'=>'upg1','utst'=>'utst','v400'=>'v400','v750'=>'v750','veri'=>'veri','vk-v'=>'vk-v','vk40'=>'vk40','vk50'=>'vk50','vk52'=>'vk52','vk53'=>'vk53','vm40'=>'vm40','vx98'=>'vx98','virg'=>'virg','vite'=>'vite','voda'=>'voda','vulc'=>'vulc','w3c '=>'w3c ','w3c-'=>'w3c-','wapj'=>'wapj','wapp'=>'wapp','wapu'=>'wapu','wapm'=>'wapm','wig '=>'wig ','wapi'=>'wapi','wapr'=>'wapr','wapv'=>'wapv','wapy'=>'wapy','wapa'=>'wapa','waps'=>'waps','wapt'=>'wapt','winc'=>'winc','winw'=>'winw','wonu'=>'wonu','x700'=>'x700','xda2'=>'xda2','xdag'=>'xdag','yas-'=>'yas-','your'=>'your','zte-'=>'zte-','zeto'=>'zeto','acs-'=>'acs-','alav'=>'alav','alca'=>'alca','amoi'=>'amoi','aste'=>'aste','audi'=>'audi','avan'=>'avan','benq'=>'benq','bird'=>'bird','blac'=>'blac','blaz'=>'blaz','brew'=>'brew','brvw'=>'brvw','bumb'=>'bumb','ccwa'=>'ccwa','cell'=>'cell','cldc'=>'cldc','cmd-'=>'cmd-','dang'=>'dang','doco'=>'doco','eml2'=>'eml2','eric'=>'eric','fetc'=>'fetc','hipt'=>'hipt','http'=>'http','ibro'=>'ibro','idea'=>'idea','ikom'=>'ikom','inno'=>'inno','ipaq'=>'ipaq','jbro'=>'jbro','jemu'=>'jemu','java'=>'java','jigs'=>'jigs','kddi'=>'kddi','keji'=>'keji','kyoc'=>'kyoc','kyok'=>'kyok','leno'=>'leno','lg-c'=>'lg-c','lg-d'=>'lg-d','lg-g'=>'lg-g','lge-'=>'lge-','libw'=>'libw','m-cr'=>'m-cr','maui'=>'maui','maxo'=>'maxo','midp'=>'midp','mits'=>'mits','mmef'=>'mmef','mobi'=>'mobi','mot-'=>'mot-','moto'=>'moto','mwbp'=>'mwbp','mywa'=>'mywa','nec-'=>'nec-','newt'=>'newt','nok6'=>'nok6','noki'=>'noki','o2im'=>'o2im','opwv'=>'opwv','palm'=>'palm','pana'=>'pana','pant'=>'pant','pdxg'=>'pdxg','phil'=>'phil','play'=>'play','pluc'=>'pluc','port'=>'port','prox'=>'prox','qtek'=>'qtek','qwap'=>'qwap','rozo'=>'rozo','sage'=>'sage','sama'=>'sama','sams'=>'sams','sany'=>'sany','sch-'=>'sch-','sec-'=>'sec-','send'=>'send','seri'=>'seri','sgh-'=>'sgh-','shar'=>'shar','sie-'=>'sie-','siem'=>'siem','smal'=>'smal','smar'=>'smar','sony'=>'sony','sph-'=>'sph-','symb'=>'symb','t-mo'=>'t-mo','teli'=>'teli','tim-'=>'tim-','tosh'=>'tosh','treo'=>'treo','tsm-'=>'tsm-','upg1'=>'upg1','upsi'=>'upsi','vk-v'=>'vk-v','voda'=>'voda','vx52'=>'vx52','vx53'=>'vx53','vx60'=>'vx60','vx61'=>'vx61','vx70'=>'vx70','vx80'=>'vx80','vx81'=>'vx81','vx83'=>'vx83','vx85'=>'vx85','wap-'=>'wap-','wapa'=>'wapa','wapi'=>'wapi','wapp'=>'wapp','wapr'=>'wapr','webc'=>'webc','whit'=>'whit','winw'=>'winw','wmlb'=>'wmlb','xda-'=>'xda-',))); // check against a list of trimmed user agents to see if we find a match
            $mobile_browser = true; 
            break;

        }
        header('Cache-Control: no-transform');
        header('Vary: User-Agent, Accept');
        return $mobile_browser; 
    }  

    function infoAction()
    {
     phpinfo();
     exit;
    }
};
?>

