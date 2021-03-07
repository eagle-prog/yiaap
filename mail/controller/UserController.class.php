<?php
class UserController extends NesoteController
{

	function getloggedheader()
	{
		$io_username=$_COOKIE["e_username"];
		$io_password=$_COOKIE["e_password"];
		$lang_code=$_COOKIE["lang_mail"];
		//echo $lang_code; exit;
		$io_password=$_COOKIE["e_password"];
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$portal_status=$settings->getValue("portal_status");
		if($portal_status==1)
		{
			if($io_username!=""||$io_password!="")
			{

				$db= new NesoteDALController();
				$db->select("nesote_inoutscripts_users");
				$db->fields("*");
				$db->where("username=? and password=?",array($io_username,$io_password));
				$res=$db->query();
				$result=$db->fetchRow($res);

				$this->loadLibrary('Settings');
				$settings=new Settings('nesote_email_settings');
				$settings->loadValues();
				$portal_installation_url=$settings->getValue("portal_installation_url");

				$servicekey=strrev($portal_installation_url);
				$servicekey=substr($servicekey,0,strpos($servicekey,"/"));
				$servicekey=strrev($servicekey);
					
				$portal_installation_url=substr($portal_installation_url,0,strrpos($portal_installation_url,"/"));



				//$lang_code="engl";
				$url=$portal_installation_url."/index.php?page=index/loggedcommonheader/".$lang_code."/".$servicekey."/".$result[0];

				//echo $url;
				//exit;

				//sleep(2);

				if (function_exists('curl_init'))
				{

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					$xmldata = curl_exec($ch);
					curl_close($ch);


				}
				elseif($fp=fopen($url,"r"))
				{
					while(!feof($fp))
					{
						$xmldata.=fgetc($fp);
					}
					fclose($fp);

				}
				else
				{

					echo "Error in file open, please enable curl or fopen";
					exit;
				}



				echo $xmldata;
			}//if($io_username!=""||$io_password!="")
			else
			{
				$this->loadLibrary('Settings');
				$settings=new Settings('nesote_email_settings');
				$portal_installation_url=$settings->getValue("portal_installation_url");

				$servicekey=strrev($portal_installation_url);
				$servicekey=substr($servicekey,0,strpos($servicekey,"/"));
				$servicekey=strrev($servicekey);
					
				$portal_installation_url=substr($portal_installation_url,0,strrpos($portal_installation_url,"/"));

				$url=$portal_installation_url."/index.php?page=index/commonheader/".$lang_code."/".$servicekey;

				sleep(2);

				//echo $url;
				//exit;

				if (function_exists('curl_init'))
				{

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					$xmldata = curl_exec($ch);
					curl_close($ch);


				}
				elseif($fp=fopen($url,"r"))
				{
					while(!feof($fp))
					{
						$xmldata.=fgetc($fp);
					}
					fclose($fp);

				}
				else
				{
						

					echo "Error in file open, please enable curl or fopen";
					exit;
				}
				echo $xmldata;
			}//else

		}

	}//function getlogedheader()





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

	
	function validateUser()
	{
		$username=$_COOKIE['e_username'];
		$password=$_COOKIE['e_password'];
		$db=new NesoteDALController();
		$no=$db->total("nesote_inoutscripts_users","username=? and password=?",array($username,$password));
		if($no!=1)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}


	function portal_serverpwdAction()
	{
		$userid=trim($this->getParam(1));
		$password=trim($this->getParam(2));

		$userid=base64_decode($userid);
		$password=base64_decode($password);


		$password=str_replace("_*#@","",$password);
		$userid=str_replace("_*#@","",$userid);

		$server_password=base64_encode($password);

		$db=new NesoteDALController();
		$db->insert("nesote_email_usersettings");
		$db->fields("userid,server_password");
		$db->values(array($userid,$server_password));
		$db->query();//echo $db->getQuery();
		echo "success";exit;

	}
	function portal_registrationAction()
	{

		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$db=new NesoteDALController();
		$portal_status=$settings->getValue("portal_status");
		$this->setValue("portal_status",$portal_status);
		$portal_installation_url=$settings->getValue("portal_installation_url");

		$servicekey=strrev($portal_installation_url);
		$servicekey=substr($servicekey,0,strpos($servicekey,"/"));
		$servicekey=strrev($servicekey);
		$portal_installation_url=substr($portal_installation_url,0,strrpos($portal_installation_url,"/"));

		$path=$portal_installation_url."/index.php?page=member/myaccount";
		$this->setValue("path",$path);
		
		$img=$settings->getValue("public_page_logo");
		$imgpath="admin/logo/".$img;
		$this->setValue("imgpath",$imgpath);

		if($portal_status==1)
		{
			$username=$_COOKIE['e_username'];
			$password=$_COOKIE['e_password'];//md5
			//    $username=trim($_GET['u']);
			// $server_password=trim($_GET['p']);//base64_encode




			$db->select("nesote_inoutscripts_users");
			$db->fields("id");
			$db->where("username=? and password=?",array($username,$password));
			$rs=$db->query();
			$rsult=$db->fetchRow($rs);
			$userid=$rsult[0];

                        $db->select("nesote_email_usersettings");
			$db->fields("server_password");
			$db->where("userid=?",array($userid));
			$res=$db->query();
                        $reslt=$db->fetchRow($res);
                        $server_password=$reslt[0];
			// $encpassword=md5($cpassword);
			$decode_password=base64_decode($server_password);
				
			//         $min_passwordlength=$settings->getValue("min_passwordlength");
			//		 $this->setValue("min_passwordlength",$min_passwordlength);

			$chatsettings=new Settings('nesote_chat_settings');
			$chatsettings->loadValues();
			$footermsg=$this->getmessage(351);
			$year=date("Y",time());
			$footer=str_replace('{year}',$year,$footermsg);
			$this->setValue("footer",$footer);
			$m=$this->getmessage(137);$f=$this->getmessage(138);
			$this->setValue("m",$m);
			$this->setValue("f",$f);


			

			$d=array();

			for($i=1,$j=0;$i<=31;$i++,$j++)
			{
				if($i<10)
				$i="0".$i;
				$d[$j][0]=$i;
			}

			$this->setLoopValue("DD",$d);


			$y=array();

			for($i=$year,$j=0;$i>=1900;$i--,$j++)
			{
				$y[$j][0]=$i;
			}

			$this->setLoopValue("YY",$y);
			/*******/

			$msg="";

			$userpanel="";


		

			$this->setValue("msg",$msg);
			$msg1="";
			$this->setValue("msg1",$msg1);
			$msg2="";
			$msg2=$this->getParam(1);
			$this->setValue("msg2",$msg2);
			$gender="";$day="";$month="";$year="";$country="";$timezone="";
			$flag=1;


			$this->setValue("gr",$gender);
			$this->setValue("day",$day);
			$this->setValue("tt",$month);
			$this->setValue("yr",$year);
			$this->setValue("cntr",$country);
			$this->setValue("tzone",$timezone);
				
			

			$db->select("nesote_email_country");
			$db->fields("name");
			$db->order("name asc");
			$result=$db->query();
			$this->setLoopValue("country",$result->getResult());

			$db->select("nesote_email_time_zone");
			$db->fields("id,name,value");
			$result=$db->query();
			$this->setLoopValue("timezone",$result->getResult());


			$lang_id=$_COOKIE['lang_mail'];
			if(isset($lang_id))
			$lang=$lang_id;
			else
			{

				$default_lang_id=$settings->getValue("default_language");
				if($default_lang_id!="")
				$lang=$default_lang_id;
				else
				$lang='eng';
			}
			$lang=$this->getlang_id($lang);
			$db->select("nesote_email_months_messages");
			$db->fields("month_id,message");
			$db->where("lang_id=?",array($lang));
			$result1=$db->query();
			$this->setLoopValue("kkk",$result1->getResult());

			$img=$settings->getValue("public_page_logo");
			$imgpath="admin/logo/".$img;
			$this->setValue("imgpath",$imgpath);

			


			if($_POST)
			{
				$tot=0;$flag=1;$server_password="";
					
					
				if($flag==1)
				{
					$gender=$_POST['gender'];
					if($gender=="")
					{
						$flag=0;
						$msg2=$this->getmessage(127);
						$this->setValue("msg2",$msg2);
						//header("Location:".$this->url("user/registration/$msg2"));
						//exit(0);

					}
				}
				if($flag==1)
				{
					$day=$_POST['day'];
					if($day=="")
					{
						$flag=0;
						$msg2=$this->getmessage(128);
						$this->setValue("msg2",$msg2);
						//header("Location:".$this->url("user/registration/$msg2"));
						//exit(0);

					}
				}
				if($flag==1)
				{
					$month=$_POST['month'];
					if($month=="")
					{
						$flag=0;
						$msg2=$this->getmessage(129);
						$this->setValue("msg2",$msg2);
						//header("Location:".$this->url("user/registration/$msg2"));
						//exit(0);

					}
				}
				if($flag==1)
				{
					$year=$_POST['year'];
					if($year=="")
					{
						$flag=0;
						$msg2=$this->getmessage(130);
						$this->setValue("msg2",$msg2);
						//header("Location:".$this->url("user/registration/$msg2"));
						//exit(0);

					}
				}
				if($flag==1)
				{
					$dob=mktime(0,0,0,$month,$day,$year);
					$country=$_POST['country'];
					if($country=="")
					{
						$flag=0;
						$msg2=$this->getmessage(131);
						$this->setValue("msg2",$msg2);
						//header("Location:".$this->url("user/registration/$msg2"));
						//exit(0);

					}
				}
				if($flag==1)
				{
					$timezone=$_POST['time_zone'];
					if($timezone=="")
					{
						$flag=0;
						$msg2=$this->getmessage(231);
						$this->setValue("msg2",$msg2);
						//header("Location:".$this->url("user/registration/$msg2"));
						//exit(0);

					}
				}


					
					
				$time=time();


				if($flag==1)
				{
					$image=trim($_POST['image']);

					$enc_image=md5($image);
					$random=$_COOKIE['random'];

					if($random!=$enc_image)
					{
						$flag=0;
						$msgy=$this->getmessage(148);
						$this->setValue("msg2",$msgy);
					}
				}

				$extension=$this->getextension();
				$extension1=substr($extension,0,1);
				if($extension1=="@")
				$extension=substr($extension,1,strlen($extension));

				$smtp_username="";
					
				$controlpanel=$settings->getValue("controlpanel");

				if($controlpanel==1)
				$smtp_username=$username."+".$extension;
				else if($controlpanel==2)
				$smtp_username=$username."@".$extension;

				if($flag==1)
				{
					////email settings///
					 
					$mails_per_page=$settings->getValue("mails_per_page");
					if(($mails_per_page=="")|| ($mails_per_page==0))
					$mails_per_page=20;


					$default_language=$settings->getValue("default_language");
					if($default_language==""  || $default_language===0)
					$default_language='eng';


					$themes=$settings->getValue("themes");
					if($themes==0)
					$themes=1;

					$display=$settings->getValue("display");
					if($display==0)
					$display=1;


					////chat settings///

					$chathistory=$chatsettings->getValue("chat_history");

						
					$sounds=$chatsettings->getValue("default_chat_sound");

					//
					$smileys=$chatsettings->getValue("chat_smiley");

						
					//
					$deafault_chatwindow_size=$chatsettings->getValue("deafault_chatwindow_size");

						
						
					$account_type=$settings->getValue("catchall_mail");
					if($account_type==1)// for catch all
					{
						$public_registration=$settings->getValue("public_registration");
						if($public_registration==1)//public registration
						{
							



							$shortcuts=$settings->getValue("shortcuts");
							if($shortcuts=="")
							$shortcuts=0;
								

							 
							$db->select("nesote_email_calendar_settings");
							$db->fields("value");
							$db->where("name=?",email_remainder);
							$result=$db->query();
							$rs=$db->fetchRow($result);
							$email_remainder=$rs[0];

							$db->select("nesote_email_calendar_settings");
							$db->fields("value");
							$db->where("name=?",view_event);
							$result1=$db->query();
							$rs1=$db->fetchRow($result1);
							$view_event=$rs1[0];


							$db->update("nesote_email_usersettings");
							$db->set("lang_id=?,theme_id=?,display=?,mails_per_page=?,email_remainder=?,view_event=?,shortcuts=?,sex=?,dateofbirth=?,country=?,time_zone=?,smtp_username=?",array($default_language,$themes,$display,$mails_per_page,$email_remainder,$view_event,$shortcuts,$gender,$dob,$country,$timezone,$smtp_username));
							$db->where("userid=?",array($userid));
							$db->query();

							////Chat Start////////////
								
							$db->insert("nesote_chat_users");
							$db->fields("userid,chathistory,sounds,smileys,chat_status,chatwindowsize");
							$db->values(array($userid,$chathistory,$sounds,$smileys,1,$deafault_chatwindow_size));
							$result=$db->query();

							$attachments_path="userdata";

							if(!is_dir("$attachments_path/$userid"))

							{

								mkdir("$attachments_path/$userid",0777);

							}

							/////////Chat End///////////



							//						SETCOOKIE("e_username",$username,0,"/");
							//						SETCOOKIE("e_password",$encpassword,0,"/");
							$this->welcomemessage($userid,$username);//echo $flag;exit;
							$this->saveLogs("New Client","$username has registred as new client",$last);

						}
					}
					else //for individual
					{
							

						$automatic_account_creation=$settings->getValue("automatic_account_creation");

						if($automatic_account_creation==1)// for automatic account creation
						{

							$public_registration=$settings->getValue("public_registration");
							if($public_registration==1)//public registration
							{

								//---api calling------

								$controlpanel=$settings->getValue("controlpanel");
								if($controlpanel==1)
								{
									$this->cpanelaccountcreate($username,$decode_password);
								}
								else if($controlpanel==2)
								{
									$this->pleskaccountcreate($username,$decode_password);
								}

									
								$shortcuts=$settings->getValue("shortcuts");
								if($shortcuts=="")
								$shortcuts=0;
									

								 
								$db->select("nesote_email_calendar_settings");
								$db->fields("value");
								$db->where("name=?",email_remainder);
								$result=$db->query();
								$rs=$db->fetchRow($result);
								$email_remainder=$rs[0];
								 
								$db->select("nesote_email_calendar_settings");
								$db->fields("value");
								$db->where("name=?",view_event);
								$result1=$db->query();
								$rs1=$db->fetchRow($result1);
								$view_event=$rs1[0];
									
									
								//							
									
								$db->update("nesote_email_usersettings");
								$db->set("lang_id=?,theme_id=?,display=?,mails_per_page=?,email_remainder=?,view_event=?,shortcuts=?,sex=?,dateofbirth=?,country=?,remember_answer=?,remember_question=?,time_zone=?,smtp_username=?",array($default_language,$themes,$display,$mails_per_page,$email_remainder,$view_event,$shortcuts,$gender,$dob,$country,$answer,$question,$timezone,$smtp_username));
								$db->where("userid=?",array($userid));
								$db->query();
								 
								////Chat Start////////////
									
									
								$db->insert("nesote_chat_users");
								$db->fields("userid,chathistory,sounds,smileys,chat_status,chatwindowsize");
								$db->values(array($userid,$chathistory,$sounds,$smileys,1,$deafault_chatwindow_size));
								$result=$db->query();
									
								$attachments_path="userdata";

								if(!is_dir("$attachments_path/$userid"))

								{

									mkdir("$attachments_path/$userid",0777);

								}

								/////////Chat End///////////

								//							SETCOOKIE("e_username",$username,0,"/");
								//							SETCOOKIE("e_password",$encpassword,0,"/");
								$this->welcomemessage($userid,$username);
								$this->saveLogs("New Client","$username has registred as new client",$last);

							}
						}

					}

					header("Location:".$this->url("user/registrationsuccess"));
					exit(0);
				}

			}
			//$this->setValue("firstname",$firstname);
			//$this->setValue("lastname",$lastname);
			$this->setValue("gr",$gender);
			$this->setValue("day",$day);
			$this->setValue("tt",$month);
			$this->setValue("yr",$year);
			$this->setValue("cntr",$country);
			$this->setValue("tzone",$timezone);

		}

	}

	function registrationAction()
	{
	   //echo $this->cpanelaccountcreate('srt123456','123456');exit;
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$signupvalue=0;
		   $account_type=$settings->getValue("catchall_mail");
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
		if($signupvalue==0)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		$db=new NesoteDALController();
		$portal_status=$settings->getValue("portal_status");

$captcha_sitekey=$settings->getValue("captcha_sitekey");
$this->setValue("captcha_sitekey",$captcha_sitekey);

		if($portal_status==1)
		{
			$portal_installation_url=$settings->getValue("portal_installation_url");
			$servicekey=strrev($portal_installation_url);
			$servicekey=substr($servicekey,0,strpos($servicekey,"/"));
			$servicekey=strrev($servicekey);
			$portal_installation_url=substr($portal_installation_url,0,strrpos($portal_installation_url,"/"));
				
			$path=$portal_installation_url."/index.php?page=member/myaccount";
			header("Location:".$path);exit;
		}
		else
		{

			$min_passwordlength=$settings->getValue("min_passwordlength");
			$this->setValue("min_passwordlength",$min_passwordlength);

			$chatsettings=new Settings('nesote_chat_settings');
			$chatsettings->loadValues();

			$db=new NesoteDALController();

			
			$footermsg=$this->getmessage(351);
			$year=date("Y",time());
			$footer=str_replace('{year}',$year,$footermsg);
			$this->setValue("footer",$footer);
			$m=$this->getmessage(137);$f=$this->getmessage(138);
			$this->setValue("m",$m);
			$this->setValue("f",$f);


			$this->setValue("f1",$this->getmessage(141));
			$this->setValue("f2",$this->getmessage(142));
			$this->setValue("f3",$this->getmessage(143));
			$this->setValue("f4",$this->getmessage(144));
			$this->setValue("f5",$this->getmessage(145));
			/*******/

			$d=array();

			for($i=1,$j=0;$i<=31;$i++,$j++)
			{
				if($i<10)
				$i="0".$i;
				$d[$j][0]=$i;
			}

			$this->setLoopValue("DD",$d);


			$y=array();

			for($i=$year,$j=0;$i>=1900;$i--,$j++)
			{
				$y[$j][0]=$i;
			}

			$this->setLoopValue("YY",$y);
			/*******/

			$msg="";

			$userpanel="";


			$userpanel=$settings->getValue("controlpanel");
			$this->setValue("controlpanel",$userpanel);

			$min_usernamelength=$settings->getValue("min_usernamelength");
			$this->setValue("min_usernamelength",$min_usernamelength);


			$this->setValue("msg",$msg);
			$msg1="";
			$this->setValue("msg1",$msg1);
			$msg2="";
			$msg2=$this->getParam(1);
			$this->setValue("msg2",$msg2);
			//$firstname="";$lastname="";
			$name="";
			$gender="";$day="";$month="";$year="";$country="";$timezone="";$loginname="";$question1="";$qs="";$answer="";$alternateemail="";
			$flag=1;

			//$this->setValue("firstname",$firstname);
			//$this->setValue("lastname",$lastname);
			$this->setValue("name",$name);
			$this->setValue("gr",$gender);
			$this->setValue("day",$day);
			$this->setValue("tt",$month);
			$this->setValue("yr",$year);
			$this->setValue("cntr",$country);
			$this->setValue("tzone",$timezone);
			$this->setValue("loginname",$loginname);
			$this->setValue("qst",$question1);
			$this->setValue("qs",$qs);
			$this->setValue("answer",$answer);
			$this->setValue("alternateemail",$alternateemail);

				
			$emailextension=$settings->getValue("emailextension");
			if(stristr(trim($emailextension),"@")!="")
			$emailextension=$emailextension;
			else
			$emailextension="@".$emailextension;
			$this->setValue("emailextension",$emailextension);


			$db->select("nesote_email_country");
			$db->fields("name");
			$db->order("name asc");
			$result=$db->query();
			$this->setLoopValue("country",$result->getResult());

			$db->select("nesote_email_time_zone");
			$db->fields("id,name,value");
			$result=$db->query();
			$this->setLoopValue("timezone",$result->getResult());


			$lang_id=$_COOKIE['lang_mail'];
			if(isset($lang_id))
			$lang=$lang_id;
			else
			{

				$default_lang_id=$settings->getValue("default_language");
				if($default_lang_id!="")
				$lang=$default_lang_id;
				else
				$lang='eng';
			}
			$lang_idnew=$this->getlang_id($lang);
			$db->select("nesote_email_months_messages");
			$db->fields("month_id,message");
			$db->where("lang_id=?",array($lang_idnew));
			$result1=$db->query();
			$this->setLoopValue("kkk",$result1->getResult());

			$img=$settings->getValue("public_page_logo");
			$imgpath="admin/logo/".$img;
			$this->setValue("imgpath",$imgpath);

			$msgs=$this->getmessage(109);
			$minlengtherr=str_replace('{min_usernamelength}',$min_usernamelength,$msgs);
			$this->setValue("minlengtherr",$minlengtherr);
			$controlpanel=$settings->getValue("controlpanel");




			if($_POST)
			{
require("script.inc.php");
				$tot=0;$flag=1;$server_password="";



////////////////anna//////////////////

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
						$msg2=$this->getmessage(784);
						$this->setValue("msg2",$msg2);
}
			//////////////////anna///////////////////

				//$firstname=$_POST['firstname'];
				$name=$_POST['name'];
				if($name=="")
				{
					$flag=0;
					$msg2=$this->getmessage(669);
					$this->setValue("msg2",$msg2);
					//header("Location:".$this->url("user/registration/$msg2"));
					//exit(0);

				}
				
				if($flag==1)
				{
					$gender=$_POST['gender'];
					if($gender=="")
					{
						$flag=0;
						$msg2=$this->getmessage(127);
						$this->setValue("msg2",$msg2);
						//header("Location:".$this->url("user/registration/$msg2"));
						//exit(0);

					}
				}
				if($flag==1)
				{
					$day=$_POST['day'];
					if($day=="")
					{
						$flag=0;
						$msg2=$this->getmessage(128);
						$this->setValue("msg2",$msg2);
						//header("Location:".$this->url("user/registration/$msg2"));
						//exit(0);

					}
				}
				if($flag==1)
				{
					$month=$_POST['month'];
					if($month=="")
					{
						$flag=0;
						$msg2=$this->getmessage(129);
						$this->setValue("msg2",$msg2);
						//header("Location:".$this->url("user/registration/$msg2"));
						//exit(0);

					}
				}
				if($flag==1)
				{
					$year=$_POST['year'];
					if($year=="")
					{
						$flag=0;
						$msg2=$this->getmessage(130);
						$this->setValue("msg2",$msg2);
						//header("Location:".$this->url("user/registration/$msg2"));
						//exit(0);

					}
				}
				if($flag==1)
				{
					$dob=mktime(0,0,0,$month,$day,$year);
					$country=$_POST['country'];
					if($country=="")
					{
						$flag=0;
						$msg2=$this->getmessage(131);
						$this->setValue("msg2",$msg2);
						//header("Location:".$this->url("user/registration/$msg2"));
						//exit(0);

					}
				}
				if($flag==1)
				{
					$timezone=$_POST['time_zone'];
					if($timezone=="")
					{
						$flag=0;
						$msg2=$this->getmessage(231);
						$this->setValue("msg2",$msg2);
						//header("Location:".$this->url("user/registration/$msg2"));
						//exit(0);

					}
				}
				if($flag==1)
				{
					$loginname=strtolower($_POST['loginname']);
					if($loginname=="")
					{
						$flag=0;
						$msg2=$this->getmessage(114);
						$this->setValue("msg2",$msg2);
						

					}
				}
				if($flag==1)
				{

			  if (preg_match ('/[^a-z0-9,._]/i', $loginname))
			  {
			  	$msg2=$this->getmessage(327);
			  	$this->setValue("msg2",$msg2);$flag=0;
			  }
				}
					
				if($flag==1)
				{
					$p=substr($loginname,0,1);
					if((is_numeric($loginname))||(is_numeric($p)))
					{
						$msg2=$this->getmessage(327);
						$this->setValue("msg2",$msg2);$flag=0;
					}
				}
				if($flag==1)
				{
					$loginname=strtolower($loginname);

					$count=strlen($loginname);
					if($count<$min_usernamelength)
					{
						$flag=0;
						$msg=$this->getmessage(109);
						$msg=str_replace('{min_usernamelength}',$min_usernamelength,$msg);
						$this->setValue("msg2",$msg);

					}
					else if($count>32)
					{
						$flag=0;
						$msg=$this->getmessage(108);
						$this->setValue("msg2",$msg);
					}
					else
					{
						
						if($flag==1)
						{
						
						$account_type=$settings->getValue("catchall_mail");//0
						$automatic_account_creation=$settings->getValue("automatic_account_creation");//1
						$public_registration=$settings->getValue("public_registration");//1
 
							if( $controlpanel==1 && $account_type==0 && $automatic_account_creation==1 && $public_registration==1)
							{
								$exist_mail=$this->mailaccexist($loginname);
								if($exist_mail!=0)
								{
									
									$msg1=$this->getmessage(229);
									$this->setValue("msg2",$msg1);
									
									$flag=0;
								}
							}
							else if( $controlpanel==2 && $account_type==0 && $automatic_account_creation==1 && $public_registration==1)
							{
								$exist_mail=$this->pleskmailaccexist($loginname);
								if($exist_mail=="ok")
								{
									
									$msg1=$this->getmessage(229);
									$this->setValue("msg2",$msg1);
									
									$flag=0;
								}
							}
						}
						if($flag==1)
						{
							$msg=$this->lognameavailable($loginname);
							if($msg!="")
							{

								$this->setValue("msg2",$msg);
								$flag=0;
							}
							$username=$loginname;
						}
				}
		}
		if($flag==1)
		{

			$tot=$db->total("nesote_inoutscripts_users","username=?",array($loginname));
			if($tot!=0)
			{
				$msg1=$this->getmessage(229);
				$this->setValue("msg2",$msg1);
				//$this->setValue("msg1",$msg1);
				$flag=0;
			}
		}
		if($flag==1)
		{
			$password=$_POST['password'];
			if($password=="")
			{
				$msg1=$this->getmessage(289);
				$this->setValue("msg2",$msg1);
				//$this->setValue("msg1",$msg1);
				$flag=0;
			}
		}
		if($flag==1)
		{
			if($password==$loginname)
			{
				$msg1=$this->getmessage(354);
				$this->setValue("msg2",$msg1);
				//$this->setValue("msg1",$msg1);
				$flag=0;
			}
		}
		if($flag==1)
		{
			$pwdcount=$_POST['pwdcnt'];//echo $pwdcount;

			if($pwdcount<2)
			{
				$msg1=$this->getmessage(290);
				$this->setValue("msg2",$msg1);
				//$this->setValue("msg1",$msg1);
				$flag=0;
			}

		}
		if($flag==1)
		{
			$cpassword=$_POST['cpassword'];

			$count2=strlen($cpassword);
			

				if($password!=$cpassword)
				{
					$msg1=$this->getmessage(132);
					$this->setValue("msg2",$msg1);
					$flag=0;

				}
				else
				{
//salt added
$salt_password=$settings->getValue("salt_password");
$password=$salt_password.$password;
$cpassword=$salt_password.$cpassword;
//salt added
					$encpassword=md5($cpassword);
					$server_password=base64_encode($cpassword);
				}
			}
			if($flag==1)
			{
				$question=$_POST['question'];
				if($question=="")
				{
					$flag=0;
					$msg2=$this->getmessage(125);
					$this->setValue("msg2",$msg2);
					header("Location:".$this->url("user/registration/$msg2"));
					exit(0);

				}
			}
			if($flag==1)
			{
				$question1=$question;
				if($question==1)
				{
					$question=$_POST['myownquestion'];$qs=$_POST['myownquestion'];
					if($question=="")
					{
						$flag=0;
						$msg2=$this->getmessage(125);
						$this->setValue("msg2",$msg2);
						//header("Location:".$this->url("user/registration/$msg2"));
						//exit(0);

					}
					$question1=1;
				}
			}
			if($flag==1)
			{
				$answer=$_POST['answer'];
				if($answer=="")
				{
					$flag=0;
					$msg2=$this->getmessage(126);
					$this->setValue("msg2",$msg2);
					//header("Location:".$this->url("user/registration/$msg2"));
					//exit(0);

				}
			}
			if($answer=="")
			{
				$question="";
			}
			if($flag==1)
			{
				$alternateemail=$_POST['alternatemail'];
				if($alternateemail!="")
				{
					if($this->isValid($alternateemail)=='FALSE')
					{
						$flag=0;
						$msg2=$this->getmessage(159);
						$this->setValue("msg2",$msg2);
					}
				}


$uname=$loginname.$this->getextension();

if($alternateemail==$uname)
				{
					
						$flag=0;
						$msg2=$this->getmessage(785);
						$this->setValue("msg2",$msg2);
					
				}


			}
			$time=time();


			/*if($flag==1)
			{
				$image=trim($_POST['image']);

				$enc_image=md5($image);
				$random=$_COOKIE['random'];

				if($random!=$enc_image)
				{
					$flag=0;
					$msgx=$this->getmessage(148);
					$this->setValue("msg2",$msgx);
				}
			}*/

			$extension=$this->getextension();
			$extension1=substr($extension,0,1);
			if($extension1=="@")
			$extension=substr($extension,1,strlen($extension));

			$smtp_username="";
				
			$controlpanel=$settings->getValue("controlpanel");

			if($controlpanel==1)
			$smtp_username=$username."+".$extension;
			else if($controlpanel==2)
			$smtp_username=$username."@".$extension;

			if($flag==1)
			{
				////email settings///
				 
				$mails_per_page=$settings->getValue("mails_per_page");
				if(($mails_per_page=="")|| ($mails_per_page==0))
				$mails_per_page=20;


				$default_language=$settings->getValue("default_language");
				if($default_language==""  || $default_language===0)
				$default_language='eng';


				$themes=$settings->getValue("themes");
				if($themes==0)
				$themes=1;

				$display=$settings->getValue("display");
				if($display==0)
				$display=1;


				////chat settings///

				$chathistory=$chatsettings->getValue("chat_history");

					
				$sounds=$chatsettings->getValue("default_chat_sound");

				//
				$smileys=$chatsettings->getValue("chat_smiley");

					
				//
				$deafault_chatwindow_size=$chatsettings->getValue("deafault_chatwindow_size");

					
					
				$account_type=$settings->getValue("catchall_mail");
				if($account_type==1)// for catch all
				{
					$public_registration=$settings->getValue("public_registration");
					if($public_registration==1)//public registration
					{
						

						$db->insert("nesote_inoutscripts_users");
						$db->fields("username,password,name,joindate,status");
						$db->values(array($username,$encpassword,$name,$time,1));
						$result=$db->query();
						$last=$db->lastInsertid("nesote_inoutscripts_users");


						$shortcuts=$settings->getValue("shortcuts");
						if($shortcuts=="")
						$shortcuts=0;
							

						 
						$db->select("nesote_email_calendar_settings");
						$db->fields("value");
						$db->where("name=?",email_remainder);
						$result=$db->query();
						$rs=$db->fetchRow($result);
						$email_remainder=$rs[0];
						 
						$db->select("nesote_email_calendar_settings");
						$db->fields("value");
						$db->where("name=?",view_event);
						$result1=$db->query();
						$rs1=$db->fetchRow($result1);
						$view_event=$rs1[0];
							

						$db->insert("nesote_email_usersettings");
						$db->fields("userid,lang_id,theme_id,display,mails_per_page,email_remainder,view_event,shortcuts,sex,dateofbirth,country,remember_answer,remember_question,server_password,time_zone,smtp_username,alternate_email");
						$db->values(array($last,$default_language,$themes,$display,$mails_per_page,$email_remainder,$view_event,$shortcuts,$gender,$dob,$country,$answer,$question,$server_password,$timezone,$smtp_username,$alternateemail));
						$result=$db->query();


						////Chat Start////////////
							
						$db->insert("nesote_chat_users");
						$db->fields("userid,chathistory,sounds,smileys,chat_status,chatwindowsize");
						$db->values(array($last,$chathistory,$sounds,$smileys,1,$deafault_chatwindow_size));
						$result=$db->query();

						$attachments_path="userdata";

						if(!is_dir("$attachments_path/$last"))

						{

							mkdir("$attachments_path/$last",0777);

						}

						/////////Chat End///////////



						//						SETCOOKIE("e_username",$username,0,"/");
						//						SETCOOKIE("e_password",$encpassword,0,"/");
						$this->welcomemessage($last,$username);//echo $flag;exit;
						$this->saveLogs("New Client","$username has registred as new client",$last);

					}
				}
				else //for individual
				{
						

					$automatic_account_creation=$settings->getValue("automatic_account_creation");

					if($automatic_account_creation==1)// for automatic account creation
					{

						$public_registration=$settings->getValue("public_registration");
						if($public_registration==1)//public registration
						{

							//---api calling------

							$controlpanel=$settings->getValue("controlpanel");
							if($controlpanel==1)
							{
								$this->cpanelaccountcreate($username,$password);
							}
							else if($controlpanel==2)
							{
								$this->pleskaccountcreate($username,$password);
							}

							$db->insert("nesote_inoutscripts_users");
							$db->fields("username,password,name,joindate,status");
							$db->values(array($username,$encpassword,$name,$time,1));
							$result=$db->query();
							$last=$db->lastInsertid("nesote_inoutscripts_users");
						
								
							$shortcuts=$settings->getValue("shortcuts");
							if($shortcuts=="")
							$shortcuts=0;
								

							 
							$db->select("nesote_email_calendar_settings");
							$db->fields("value");
							$db->where("name=?",email_remainder);
							$result=$db->query();
							$rs=$db->fetchRow($result);
							$email_remainder=$rs[0];
							 
							$db->select("nesote_email_calendar_settings");
							$db->fields("value");
							$db->where("name=?",view_event);
							$result1=$db->query();
							$rs1=$db->fetchRow($result1);
							$view_event=$rs1[0];
								
								
								
							$db->insert("nesote_email_usersettings");
							$db->fields("userid,lang_id,theme_id,display,mails_per_page,email_remainder,view_event,shortcuts,sex,dateofbirth,country,remember_answer,remember_question,server_password,time_zone,smtp_username,alternate_email");
							$db->values(array($last,$default_language,$themes,$display,$mails_per_page,$email_remainder,$view_event,$shortcuts,$gender,$dob,$country,$answer,$question,$server_password,$timezone,$smtp_username,$alternateemail));
							$result=$db->query();
							////Chat Start////////////
								
								
							$db->insert("nesote_chat_users");
							$db->fields("userid,chathistory,sounds,smileys,chat_status,chatwindowsize");
							$db->values(array($last,$chathistory,$sounds,$smileys,1,$deafault_chatwindow_size));
							$result=$db->query();
								
							$attachments_path="userdata";

							if(!is_dir("$attachments_path/$last"))

							{

								mkdir("$attachments_path/$last",0777);

							}

							/////////Chat End///////////

							//							SETCOOKIE("e_username",$username,0,"/");
							//							SETCOOKIE("e_password",$encpassword,0,"/");
							$this->welcomemessage($last,$username);
							$this->saveLogs("New Client","$username has registred as new client",$last);

						}
					}

				}

				header("Location:".$this->url("user/registrationsuccess"));
				exit(0);
			}

			}
			//$this->setValue("firstname",$firstname);
			//$this->setValue("lastname",$lastname);
			$this->setValue("name",$name);
			$this->setValue("gr",$gender);
			$this->setValue("day",$day);
			$this->setValue("tt",$month);
			$this->setValue("yr",$year);
			$this->setValue("cntr",$country);
			$this->setValue("tzone",$timezone);
			$this->setValue("loginname",$loginname);
			$this->setValue("qst",$question1);
			$this->setValue("qs",$qs);
			$this->setValue("answer",$answer);

			$this->setValue("alternateemail",$alternateemail);
		}

	}

	function LoginnameavailableAction()
	{
//require("script.inc.php");
//if($restricted_mode=='true')
//{
//echo "1";
//exit;
//}
		$tot=0;
		$name=$this->getParam(1);//echo $name;exit;

		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		
		$controlpanel=$settings->getValue("controlpanel");
		
		$db=new NesoteDALController();
		$db->select("nesote_email_reservedemail");
		$db->fields("name");
		$result=$db->query();
		while($row=$db->fetchRow($result))
		{//echo $row[0];
			if(stristr(trim($row[0]),"@")!="")
			{
				$username=explode("@",$row[0]);
				$uname=$username[0];
			}
			else
			$uname=$row[0];
			if($name==$uname)
			$tot+=1;


		}
		if($tot==0)
		{
			$db->select("nesote_inoutscripts_users");
			$db->fields("*");
			$db->where("username=?",array($name));
			$result=$db->query();//echo $db1->getQuery();exit;
			$num1=$db->numRows($result);
			$tot=$num1;
		}
		$names=$name.$this->getextension();
		if($tot==0)
		{
						$account_type=$settings->getValue("catchall_mail");//0
						$automatic_account_creation=$settings->getValue("automatic_account_creation");//1
						$public_registration=$settings->getValue("public_registration");//1
 
					if( $controlpanel==1 && $account_type==0 && $automatic_account_creation==1 && $public_registration==1)
					{
		       
					$exist_mail=$this->mailaccexist($name);
					if($exist_mail!=0)
					{
					  $msg=$this->getmessage(111);

			          $mailid=str_replace('{mailid}',$names,$msg);
			          $mailid=$mailid.",1";
						echo $mailid;exit;
					}
				}
				else if( $controlpanel==2 && $account_type==0 && $automatic_account_creation==1 && $public_registration==1)
					{
		       
					$exist_mail=$this->pleskmailaccexist($name);
					if($exist_mail=="ok")
					{
					  $msg=$this->getmessage(111);

			          $mailid=str_replace('{mailid}',$names,$msg);
			          $mailid=$mailid.",1";
						echo $mailid;exit;
					}
				}
				
			
			
			$msg=$this->getmessage(110);
			$mailid=str_replace('{mailid}',$names,$msg);
			$mailid=$mailid.",".$tot;
		}
		else
		{
			$msg=$this->getmessage(111);

			$mailid=str_replace('{mailid}',$names,$msg);
			$mailid=$mailid.",".$tot;
		}

		echo $mailid;
		die;

	}


	function lognameavailable($name)
	{
		$tot=0;$mailid="";


		$db=new NesoteDALController();
		$db->select("nesote_email_reservedemail");
		$db->fields("name");
		$result=$db->query();
		while($row=$db->fetchRow($result))
		{
			if(stristr(trim($row[0]),"@")!="")
			{
				$username=explode("@",$row[0]);
				$uname=$username[0];
			}
			else
			$uname=$row[0];
			if($name==$uname)
			$tot+=1;

		}

		if($tot==0)
		{
				
			$db->select("nesote_inoutscripts_users");
			$db->fields("*");
			$db->where("username=?",array($name));
			$result=$db->query();//echo $db1->getQuery();exit;
			$num1=$db->numRows($result);
			$tot=$num1;
		}
		if($tot==0)
		{
			//			$msg=$this->getmessage(110);
			//			$mailid=str_replace('{mailid}',$name,$msg);
			$mailid="";
		}
		else
		{
			$msg=$this->getmessage(111);
			$mailid=str_replace('{mailid}',$name,$msg);
		}

		return $mailid;


	}
	function getusertime($id,$username)
	{
		
		/*$username=$_COOKIE['e_username'];
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
			


		$position=$settings->getValue("time_zone_postion");

		$hour=$settings->getValue("time_zone_hour");

		$min=$settings->getValue("time_zone_mint");

		$diff=((3600*$hour)+(60*$min));

		if($position=="Behind")
		$diff=-$diff;
		else
		$diff=$diff;

		$ts=time()-$diff;
		//echo $ts."++++++";
		$db3= new NesoteDALController();
		$db3->select("nesote_email_usersettings");
		$db3->fields("time_zone");
		$db3->where("id=?",array($id));
		$res3=$db3->query();
		$row3=$db3->fetchRow($res3);
		//return $row3[0];
		$db3->select("nesote_email_time_zone");
		$db3->fields("value");
		$db3->where("id=?",array($row3[0]));
		$res3=$db3->query();
		$row3=$db3->fetchRow($res3);
		$timezone=$row3[0];
		
		$sign=trim($timezone[0]);
		$timezone1=substr($timezone,1);

		$timezone1=explode(":",$timezone1);
		$newtimezone=($timezone1[0]*60*60)+($timezone1[1]*60);

		if($sign=="+")
		$newtimezone=$newtimezone;
		if($sign=="-")
		$newtimezone=-$newtimezone;


		$time=$ts+$newtimezone;
		return $time;*/
$username=$_COOKIE['e_username'];
			$db= new NesoteDALController();
			$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name=?",time_zone_postion);
			$result=$db->query();
			$row=$db->fetchRow($result);
			$position=$row[0];

			$db1= new NesoteDALController();
			$db1->select("nesote_email_settings");
			$db1->fields("value");
			$db1->where("name=?",time_zone_hour);
			$result1=$db1->query();
			$row1=$db1->fetchRow($result1);
			$hour=$row1[0];

			$db2= new NesoteDALController();
			$db2->select("nesote_email_settings");
			$db2->fields("value");
			$db2->where("name=?",time_zone_mint);
			$result2=$db2->query();
			$row2=$db2->fetchRow($result2);
			$min=$row2[0];

			$diff=((3600*$hour)+(60*$min));

			if($position=="Behind")
			$diff=-$diff;
			else
			$diff=$diff;

			$ts=time()-$diff;
			return $ts;
	}
	function welcomemessage($id,$username)
	{

		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();


		$welcome_email=$settings->getValue("welcome_email_body");


		$welcome_subject=$settings->getValue("welcome_email_subject");


		$adminemail=$settings->getValue("adminemail");

		$mailid=$username.$this->getextension();

		$time=$this->getusertime($id,$username);
		$tablenumber=$this->tableid($username);

		$db=new NesoteDALController();
		$db->insert("nesote_email_inbox_$tablenumber");
		$db->fields("userid,from_list,to_list,subject,body,time,status");
		$db->values(array($id,$adminemail,$mailid,$welcome_subject,$welcome_email,$time,1));
		$result=$db->query();
		$last=$db->lastInsertid("nesote_email_inbox_$tablenumber");

		$var=time().$id."1";
		$ext=$this->getextension();
		$message_id="<".md5($var).$ext.">";

		$mail_references="";

		$mail_references="<references><item><mailid>$last</mailid><folderid>1</folderid></item></references>";
		$md5_references=md5($mail_references);

		$db->update("nesote_email_inbox_$tablenumber");
		$db->set("mail_references=?,md5_references=?,message_id=?",array($mail_references,$md5_references,$message_id));
		$db->where("id=?",$last);
		$res1=$db->query();

		return;
	}
	function tableid($username)
	{
		$user_name=$username;
		include("config.php");
		$number=$cluster_factor;

		$user_name=trim($user_name);
		$mdsuser_name=md5($user_name);
		$mdsuser_name=str_replace("a","",$mdsuser_name);
		$mdsuser_name=str_replace("b","",$mdsuser_name);
		$mdsuser_name=str_replace("c","",$mdsuser_name);
		$mdsuser_name=str_replace("d","",$mdsuser_name);
		$mdsuser_name=str_replace("e","",$mdsuser_name);
		$mdsuser_name=str_replace("f","",$mdsuser_name);

		$digits=substr($mdsuser_name,-6);

		$modlusnumber=$digits % $number;
		$modlusnumber=$modlusnumber+1;
		$numbers[$modlusnumber]++;
		return $modlusnumber;
	}

	function smtp($id,$subject,$html,$adminemail)
	{

		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
$extsmtp=$settings->getValue("user_smtp");

		$emailextension=$this->getextension();

if($extsmtp==1)
{

$db->select("nesote_email_smtp_settings");
			$db->fields("*");
			//$db->where("userid=?", array($id));
			$result=$db->query();
			$row=$db->fetchRow($result);
			$host_name=$row[1];
			$SMTP_password=$row[4];
			$SMTP_username=$row[3];
                        $port_number=$row[2];
}
else
{
		$host_name=$settings->getValue("SMTP_host");

		$port_number=$settings->getValue("SMTP_port");

		$SMTP_username=$settings->getValue("SMTP_username");

		$SMTP_password=$settings->getValue("SMTP_password");
}

		$engine_name=$settings->getValue("engine_name");

		$db=new NesoteDALController();
		$db->select("nesote_inoutscripts_users");
		$db->fields("username,name");
		$db->where("id=?", array($id));
		$result=$db->query();
		$row=$db->fetchRow($result);
		$to=$row[0];
		$to=$to.$emailextension;
		//$name="$row[1].$row[2]";
		$name=$row[1];
		require_once('class/class.phpmailer.php');
		include("class/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

		//$mail->IsSMTP(); // telling the class to use SMTP
if($extsmtp==1)
{
$mail->IsSMTP();
}

		try {
			$mail->Host       = $host_name; // SMTP server
			$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			$mail->Port       = $port_number;                    // set the SMTP port for the GMAIL server
			$mail->Username   = $SMTP_username; // SMTP account username
			$mail->Password   = $SMTP_password;
			// SMTP account password

			$mail->AddAddress($to,$name);
			$mail->AddReplyTo($adminemail, $engine_name);


			$mail->SetFrom($adminemail,  $engine_name);
			$mail->Subject = $subject;
			$mail->SMTPSecure="ssl";
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
			$mail->MsgHTML($html);


			$mail->Send();

			//$to_address=htmlentities($to_address);
			//echo "Message Sent OK</p>\n";
		} catch (phpmailerException $e) {
			echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
			echo $e->getMessage(); //Boring error messages from anything else!
		}

		return;


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
	function cpanelaccountcreate($username,$password)
	{

//return $password;exit;
		include_once 'class/xmlapi.php';
		

		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();

		$ip=$settings->getValue("domain_ip");

		$root_pass=$settings->getValue("domain_password");

		$email_domain=$settings->getValue("domain_name");

		$domain_username=$settings->getValue("domain_username");
		$portal_status=$settings->getValue("portal_status");
	$cpanel_port_number=$settings->getValue("cpanel_port_number");
	
		$account = "cptest";
		$email_user = $username;
		$email_password =$password;
		$email_query = '10';
		$xmlapi = new xmlapi($ip);
		$xmlapi->password_auth($domain_username,$root_pass);
	//	$xmlapi->set_output('xml');
	$xmlapi->set_port(2083);
	$xmlapi->set_output('json');
		$xmlapi->set_debug(1);
		try
		{
		 $arr=$xmlapi->api2_query($account, "Email", "addpop", array(domain=>$email_domain, email=>$email_user, password=>$email_password, quota=>0) );
		}
		catch (Exception $e) {
	
			if($portal_status==1)
			{
				header("Location:".$this->url("user/portal_registration/$msg2"));
				exit(0);
			}
			else
			{
				header("Location:".$this->url("user/registration/$msg2"));
				exit(0);
			}
		}
		return;
	}

function cpAction()
	{

$username="checkuser";$password="123!@#";
		include_once 'class/xmlapi.php';

		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();

		$ip=$settings->getValue("domain_ip");

		$root_pass=$settings->getValue("domain_password");

		$email_domain=$settings->getValue("domain_name");

		$domain_username=$settings->getValue("domain_username");
		$portal_status=$settings->getValue("portal_status");
		$cpanel_port_number=$settings->getValue("cpanel_port_number");

		$account = "cptest";
		$email_user = $username;
		$email_password = $password;
		$email_query = '10';
		$xmlapi = new xmlapi($ip);
		/* IF the port no is 2083 then uncomment the below sentence*/
		//$xmlapi->set_port(2083);
                $xmlapi->set_port($cpanel_port_number);
		$xmlapi->password_auth($domain_username,$root_pass);
		$xmlapi->set_output('xml');

		$xmlapi->set_debug(1);
		print $arr = $xmlapi->api2_query($account, "Email", "addpop", array(domain=>$email_domain, email=>$email_user, password=>$email_password, quota=>0) );exit;

		
	}

	function pleskaccountcreate($username,$user_password)
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
		$portal_status=$settings->getValue("portal_status");


		$create="<?xml version='1.0' encoding='UTF-8' ?>
		<packet version='$plesk_packetversion'>
		<mail>
		<create>
		<filter>
		<domain_id>$plesk_domainid</domain_id>
		<mailname>
		<name>$username</name>
		<mailbox>
		<enabled>true</enabled>
		</mailbox>
		<password>$user_password</password>
		<password_type>plain</password_type>

		</mailname>

		</filter>
		</create>
		</mail>
		</packet>
";

		$curl = curlInit($host, $login, $password);
		try {

			// echo GET_PROTOS;
			$response = sendRequest($curl, $create);
			$responseXml = parseResponse($response);
			checkResponse($responseXml);
		} catch (ApiRequestException $e) {

			$msg2=$this->getmessage(440);
			$this->setValue("msg2",$msg2);
			if($portal_status==1)
			{
				header("Location:".$this->url("user/portal_registration/$msg2"));
				exit(0);
			}
			else
			{
				header("Location:".$this->url("user/registration/$msg2"));
				exit(0);
			}

			echo $e;

			die();
		}
		// Explore the result
		foreach ($responseXml->xpath('/packet/domain/get/result') as $resultNode) {
			echo "Domain id: " . (string)$resultNode->id . " ";
			echo (string)$resultNode->data->gen_info->name . " (" .
			(string)$resultNode->data->gen_info->dns_ip_address . ")\n";
		}



	}

	function plAction($username,$user_password)
	{
		$username='checkuser';
		$user_password='123!@#';
		include_once 'class/mail_plesk.php';

		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();

		$host=$settings->getValue("domain_name");

		$login=$settings->getValue("domain_username");

		$password=$settings->getValue("domain_password");

		$plesk_packetversion=$settings->getValue("plesk_packetversion");

		$plesk_domainid=$settings->getValue("plesk_domainid");
		$portal_status=$settings->getValue("portal_status");


		$create="<?xml version='1.0' encoding='UTF-8' ?>
		<packet version='$plesk_packetversion'>
		<mail>
		<create>
		<filter>
		<domain_id>$plesk_domainid</domain_id>
		<mailname>
		<name>$username</name>
		<mailbox>
		<enabled>true</enabled>
		</mailbox>
		<password>$user_password</password>
		<password_type>plain</password_type>

		</mailname>

		</filter>
		</create>
		</mail>
		</packet>
";

		$curl = curlInit($host, $login, $password);
		try {

			// echo GET_PROTOS;
			echo $response = sendRequest($curl, $create);
			echo $responseXml = parseResponse($response);
			checkResponse($responseXml);exit;
		} catch (ApiRequestException $e) {

			$msg2=$this->getmessage(440);
			$this->setValue("msg2",$msg2);
			if($portal_status==1)
			{
				header("Location:".$this->url("user/portal_registration/$msg2"));
				exit(0);
			}
			else
			{
				header("Location:".$this->url("user/registration/$msg2"));
				exit(0);
			}

			echo $e;

			die();
		}
		// Explore the result
		foreach ($responseXml->xpath('/packet/domain/get/result') as $resultNode) {
			echo "Domain id: " . (string)$resultNode->id . " ";
			echo (string)$resultNode->data->gen_info->name . " (" .
			(string)$resultNode->data->gen_info->dns_ip_address . ")\n";
		}



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


	function isValid($email)
	{
		$result = 'TRUE';
		$regex = '/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		if(!preg_match($regex,$email))
		{
			$result = 'FALSE';
		}
		return $result;
	}

	function isValidAction()
	{
		$email="sibinck";
		$result = 'TRUE';

		if (preg_match ('/[^a-z0-9,_]/i', $email))
		{
			$result = 'FALSE';
		}
		echo $result;exit;
		if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)$", $email))
		{
			$result = 'FALSE';
		}
		echo $result;
	}

	function registrationsuccessAction()
	{
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$portal_status=$settings->getValue("portal_status");
		$this->setValue("portal_status",$portal_status);
		
		$footermsg=$this->getmessage(351);
		$year=date("Y",time());
		$footer=str_replace('{year}',$year,$footermsg);
		$this->setValue("footer",$footer);

		$img=$settings->getValue("public_page_logo");
		$imgpath="admin/logo/".$img;
		$this->setValue("imgpath",$imgpath);


	}
	function portal_reg_checkAction()//checking username,pwd
	{
		$username=trim($this->getParam(1));//base64 encode
		 

		$username=base64_decode($username);

		$username=str_replace("_*#@","",$username);
		$db=new NesoteDALController();
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$min_usernamelength=$settings->getValue("min_usernamelength");
		$controlpanel=$settings->getValue("controlpanel");
		$uname_flag=1;


		if($uname_flag==1)
		{
			if (preg_match ('/[^a-z0-9,_]/i', $username))
			{
				$uname_flag=0;
			}
		}
		if($uname_flag==1)
		{
			$username=strtolower($username);

			$count=strlen($username);
			if($count<$min_usernamelength)
			{
				$uname_flag=0;
					

			}
			else if($count>32)
			{
				$uname_flag=0;

			}
			else
			{
				
				if($uname_flag==1)
				{
					$msg=$this->lognameavailable($username);
					if($msg!="")
					{

						$uname_flag=0;
						echo "mail_exist";exit;
					}
					//$username=$loginname;
				}
				}
			}
			if($uname_flag==1)
			{

				$tot=$db->total("nesote_inoutscripts_users","username=?",array($username));
				if($tot!=0)
				{
						
					$uname_flag=0;
					echo "mail_exist";exit;
				}
			}
			if($uname_flag==1)
			{
					$account_type=$settings->getValue("catchall_mail");//0
					$automatic_account_creation=$settings->getValue("automatic_account_creation");//1
					$public_registration=$settings->getValue("public_registration");//1
 
					if( $controlpanel==1 && $account_type==0 && $automatic_account_creation==1 && $public_registration==1)
					{
					$exist_mail=$this->mailaccexist($username);
					if($exist_mail!=0)
					{
						$uname_flag=0;
						echo "mail_exist";exit;
					}
				}
				else if( $controlpanel==2 && $account_type==0 && $automatic_account_creation==1 && $public_registration==1)
					{
					$exist_mail=$this->pleskmailaccexist($username);
					if($exist_mail=="ok")
					{
						$uname_flag=0;
						echo "mail_exist";exit;
					}
				}

			}
				
				

				
				
			//echo "hello".$uname_flag;exit;
				
			if($uname_flag==0)
			{
				echo "mail_invalid"; exit;
			}
				
				
			echo "success";exit;

				
		}


		function mailaccexist($username)// username->uu@domain.com format
		{

			$extension=$this->getextension();
			$username=$username.$extension;
			include_once 'class/xmlapi.php';

			$this->loadLibrary('Settings');
			$settings=new Settings('nesote_email_settings');
			$settings->loadValues();

			$ip=$settings->getValue("domain_ip");

			$root_pass=$settings->getValue("domain_password");

			$email_domain=$settings->getValue("domain_name");

			$domain_username=$settings->getValue("domain_username");

              		$cpanel_port_number=$settings->getValue("cpanel_port_number");


			$account = "cptest";


			$email_query = '10';
			$xmlapi = new xmlapi($ip);
			/* IF the port no is 2083 then uncomment the below sentence*/
			//$xmlapi->set_port(2083);
			$xmlapi->set_port($cpanel_port_number);
                        $xmlapi->password_auth($domain_username,$root_pass);
			$xmlapi->set_output('json');

			$xmlapi->set_debug(1);
			$arr = $xmlapi->api2_query($account,"Email", "listpopswithdisk", array(domain=>$email_domain) );

			$json_o=json_decode($arr);
			$e_arr=array();$i=0;
			foreach($json_o->cpanelresult->data as $p)
			{
				if($username==$p->login)
				$i++;
			}
			return $i;
		}
function pleskmailaccexist($username)// username normal
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
		$portal_status=$settings->getValue("portal_status");
		
		$create = '<packet version="1.6.0.0"><mail><get_info><filter><domain_id>'.$plesk_domainid.'</domain_id><name>'.$username.'</name></filter></get_info></mail></packet>';

		$curl = curlInit($host, $login, $password);
		try {

			// echo GET_PROTOS;
			$response = sendRequest($curl, $create);
			preg_match('/<status>(.+?)<\/status>/i',$response,$folderArray);
			return $folderArray[1];
			$responseXml = parseResponse($response);
			checkResponse($responseXml);
		} catch (ApiRequestException $e) {

			$msg2=$this->getmessage(440);
			$this->setValue("msg2",$msg2);
			if($portal_status==1)
			{
				header("Location:".$this->url("user/portal_registration/$msg2"));
				exit(0);
			}
			else
			{
				header("Location:".$this->url("user/registration/$msg2"));
				exit(0);
			}

			echo $e;

			die();
		}
				foreach ($responseXml->xpath('/packet/domain/get/result') as $resultNode) {
			echo "Domain id: " . (string)$resultNode->id . " ";
			echo (string)$resultNode->data->gen_info->name . " (" .
			(string)$resultNode->data->gen_info->dns_ip_address . ")\n";
		}
}

	};
?>
