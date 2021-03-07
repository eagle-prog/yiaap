<?php
class chatuserController extends NesoteController
{
	function chatAction()
	{
		$userid=$this->getParam(1);
		$flag=$this->getParam(2);

		if($flag==2)
		{
			header("Location:".$this->url("chatuser/chatdetails/$userid"));
			exit;


		}

		$this->setValue("userid",$userid);
		$db=new NesoteDALController();
		$db->select("nesote_inoutscripts_users");
		$db->fields("username");
		$db->where("id=?",$userid);
		$tight=$db->query();
		$tight1=$db->fetchRow($tight);
		$user_name=$tight1[0];

		$modlusnumber=$this->tableid($user_name);
		$numofchats=$db->total("nesote_chat_message_$modlusnumber","userid=?",$userid);
		$this->setValue("number",$numofchats);

	}
	function chatdetailsAction()
	{
		$userid=$this->getParam(1);
		$this->setValue("uid",$userid);
		$db=new NesoteDALController();
		$db->select("nesote_inoutscripts_users");
		$db->fields("username");
		$db->where("id=?",$userid);
		$tight=$db->query();
		$tight1=$db->fetchRow($tight);
		$user_name=$tight1[0];
        
		$modlusnumber=$this->tableid($user_name);
			
		$db->select("nesote_chat_message_$modlusnumber");
		$db->fields("*");
		$db->where("userid=?",$userid);
		$db->order("time desc");
		$gethistory=$db->query();
		$tot=$db->numRows($gethistory);

		$perpagesize=50;
		$currentpage=1;

		if(isset($_POST['pagenumber'])&&trim($_POST['pagenumber'])!="")
		$currentpage=$_POST['pagenumber'];
		$paging= new Paging();
		$out=$paging->page($tot,$perpagesize,"page",1,1,1,"","","",$_POST);
		$this->setValue("pagingtop",$out);

		$this->setValue("number",$tot);

		$i=0;
		$msg="";
		$array_count=$db->numRows($gethistory);
		$this->setValue("msg",$msg);
		$this->setValue("array_count",$array_count);
		while($gethistory1=$db->fetchRow($gethistory))

		{
			$receivers=$gethistory1[3];

			$receivers=explode(",",$receivers);
			$numberingthereciver=count($receivers);

			for($nn=1;$nn<$numberingthereciver;$nn++)
			{


				$rece[$nn]=$receivers[$nn];

				$db->select("nesote_inoutscripts_users");
				$db->fields("username");
				$db->where("id=?",$rece[$nn]);
				$temp=$db->query();
				$temp1=$db->fetchRow($temp);


				$space="&nbsp";



				$rev[$nn]=$temp1[0];
				// echo $rev[$nn];

				$name[$i].=$rev[$nn]." " .","." ";

					

				//  echo $name[$i];
			}

			$long=strlen($name[$i]);
			$long1=$long-2;

			$name[$i]=substr($name[$i],0,$long1);
			// echo $name[$i];
			//$this->setValue("towhom",$name);
			$xml=$gethistory1[4];

			//	print_r($xml);

			$str = $xml;
			$chars = preg_split('/<item>/', $str,-1, PREG_SPLIT_OFFSET_CAPTURE);
			$count=count($chars);
			$lines=$count-1;
			$subject=$chars[1][0];
			$pattern = '/<id>(.+?)<\/id><time>(.+?)<\/time><sender>(.+?)<\/sender><message>(.+?)<\/message>/i';
			preg_match($pattern,$subject,$matches);
			$db->select("nesote_inoutscripts_users");
			$db->fields("username");
			$db->where("id=?",$matches[3]);
			$jet=$db->query();
			//echo $db->getQuery();
			$jet1=$db->fetchRow($jet);
			$sendername=$jet1[0];

			if($sendername==$user_name)
			{
				$firstsender="$user_name";
				
			}
			else
			{


				$firstsender=$sendername;
				
			}
			$time=date("j/M/Y,g:i a",$matches[2]);
			$chattime=$time;
			//	echo $chattime;
			//$this->setValue("chattime",$chattime);
			$chat_messages[$i][0]=$matches[1];
			$chat_messages[$i][1]=$chattime;
			$chat_messages[$i][2]=$sendername;
			$chat_messages[$i][3]=$matches[4];
			$chat_messages[$i][4]=$firstsender;
			$chat_messages[$i][5]=$name[$i];
			$chat_messages[$i][6]=$gethistory1[0];
			$chat_messages[$i][7]=$lines;
			$chat_messages[$i][8]=$gethistory1[5];
			$i++;
		}
		//print_r($chat_messages);
		$this->setLoopValue("allhistory",$chat_messages);




	}
	function deletechatAction()
	{

		if($this->validuser())
		{


			$userid=$this->getParam(1);
			$chatxmlid=$this->getParam(2);
			$db=new NesoteDALController();
			$db->select("nesote_inoutscripts_users");
			$db->fields("username");
			$db->where("id=?",$userid);
			$tight=$db->query();
			$tight1=$db->fetchRow($tight);
			$user_name=$tight1[0];
            $modlusnumber=$this->tableid($user_name);
			$db->delete("nesote_chat_message_$modlusnumber");

			$db->where("id=?",$chatxmlid);
			$result=$db->query();
			header("Location:".$this->url("chatuser/chat/$userid/2"));
			exit(0);
		}
	}
	function validuser()
	{
		$username=$_COOKIE['a_username'];
		$password=$_COOKIE['a_password'];

		$db=new NesoteDALController();

		$no=$db->total("nesote_email_admin","username=? and password=? and status=?",array($username,$password,1));
		if($no!=0)
		return true;
		else
		return false;

	}
	function settingsAction()
	{


	}
	function chatwindowsettingsAction()
	{
		$db=new NesoteDALController();
		$db->select("nesote_chatwindow_settings");
		$db->fields("*");
		$fet=$db->query();
		$this->setLoopValue("window",$fet->getResult());

		$db->select("nesote_chat_settings");
		$db->fields("value");
		$beat=$db->query();
		$beat1=$db->fetchRow($beat);
		$this->setValue("flag",$beat1[0]);

	}
	function editwindowACtion()
	{


		$id=$this->getParam(1);
		$this->setValue("id",$id);

		$db=new NesoteDALController();
		$db->select("nesote_chatwindow_settings");
		$db->fields("*");
		$db->where("id=?",$id);
		$fet=$db->query();
		$this->setLoopValue("editwindow",$fet->getResult());
	}

	function updatewindowAction()
	{
require("script.inc.php");

		//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')
		{

			header("Location:".$this->url("message/error/1023"));
			exit(0);
		}
		$id=$this->getParam(1);
		$name=$_POST['name'];
		$width=$_POST['width'];
		$height=$_POST['height'];


		$db=new NesoteDALController();
		$db->update("nesote_chatwindow_settings");
		$db->set("name=?,width=?,height=?",array($name,$width,$height));
		$db->where("id=?",$id);
		$heat=$db->query();

		header("Location:".$this->url("message/success/1300/8"));//1 for path creation in message/success controller
		exit(0);


	}
	function makedefaultAction()
	{
require("script.inc.php");
	//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')
		{

			header("Location:".$this->url("message/error/1023"));
			exit(0);
		}

		$id=$this->getParam(1);

		$db=new NesoteDALController();
		$db->update("nesote_chat_settings");
		$db->set("value=?",$id);

		$heat=$db->query();

		header("Location:".$this->url("message/success/1300/8"));//1 for path creation in message/success controller
		exit(0);


	}

	function chatsettingsAction()
	{

		$this->loadLibrary('Settings');
		$chatsettings=new Settings('nesote_chat_settings');
		$chatsettings->loadValues();

		$sound=$chatsettings->getValue("default_chat_sound");
		$this->setValue("sound",$sound);

		$chat_history=$chatsettings->getValue("chat_history");
		$this->setValue("chat_history",$chat_history);


		$picture_format=$chatsettings->getValue("picture_format");
		$this->setValue("picture_format",$picture_format);


		$chat_smiley=$chatsettings->getValue("chat_smiley");
		$this->setValue("smileys",$chat_smiley);


		$chat_enable=$chatsettings->getValue("chat_enable");
		$this->setValue("chat_enable",$chat_enable);



		if($_POST)
		{
require("script.inc.php");

			//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')
			{

				header("Location:".$this->url("message/error/1023"));
				exit(0);
			}

			$chat_enable=$_POST['chat_enable'];//echo $defaultview;
			$chathistory=$_POST['chathistory'];//echo $defaultview;
			$sounds=$_POST['sounds'];
			$alertsound=$_FILES['alertsound']['name'];//echo $alertsound;exit;


			$attachments_path="logo/chat_sound";

			$filename=$_FILES['alertsound']['name'];
			$temp=$_FILES['alertsound']['tmp_name'];

			$pictureformats=$_POST['pictureformats'];
			$smileys=$_POST['smileys'];

			$validformats="mp3";$flag=1;

			if($filename!="")
			{
					

				if(!is_dir("$attachments_path"))

				{
					mkdir("$attachments_path",0777);

				}

				$p_name_length=-(strlen($filename)-1);

				$check_string=substr($filename, strrpos($filename,'.')+1);

				$substrng=strtolower($check_string);

				$filename= substr_replace($filename, $substrng,strrpos($filename,'.')+1);

				$fileext=explode(",",$validformats);

				$check_string=substr($filename, strrpos($filename,'.')+1);

				$flag=0;

				for($i=0;$i<count($fileext);$i++)

				{

					if(trim($fileext[$i])==$check_string)

					{
						//echo "$attachments_path/chat_sound/".$filename;
						if (move_uploaded_file($temp, "$attachments_path/".$filename))
						{
							$flag=1;

							break;
						}
						//$temp=copy($temp,"$attachments_path/".$filename);//echo $temp;exit;
						else
						{
							header("Location:".$this->url("message/error/1135"));
							exit(0);
						}


					}

				}
			}
			if($flag==0)
			{

				header("Location:".$this->url("message/error/1131"));
				exit(0);
			}
			else if($flag==1)
			{
					
				$db=new NesoteDALController();
				$db->update("nesote_chat_settings");
				$db->set("value=?",array($chat_enable));
				$db->where("name=?",chat_enable);
				$db->query();//echo $db->getQuery();

				
				$db->update("nesote_chat_settings");
				$db->set("value=?",array($chathistory));
				$db->where("name=?",chat_history);
				$db->query();//echo $db->getQuery();

			
				$db->update("nesote_chat_settings");
				$db->set("value=?",array($sounds));
				$db->where("name=?",default_chat_sound);
				$db->query();//echo $db->getQuery();

				if($alertsound!="")
				{
//					$db=new NesoteDALController();
//					$db->select("nesote_chat_settings");
//					$db->fields("value");
//					$db->where("name=?",chat_sound_file);
//					$result=$db->query();
//					$row=$db->fetchRow($result);
					$chat_sound_file=$chatsettings->getValue("chat_sound_file");


					$db->update("nesote_chat_settings");
					$db->set("value=?",array($alertsound));
					$db->where("name=?",chat_sound_file);
					$db->query();//echo $db->getQuery();echo $alertsound;exit;

					unlink("logo/chat_sound/".$chat_sound_file);
				}



				$db=new NesoteDALController();
				$db->update("nesote_chat_settings");
				$db->set("value=?",array($pictureformats));
				$db->where("name=?",picture_format);
				$db->query();//echo $db->getQuery();

				$db=new NesoteDALController();
				$db->update("nesote_chat_settings");
				$db->set("value=?",array($smileys));
				$db->where("name=?",chat_smiley);
				$db->query();//echo $db->getQuery();

				header("Location:".$this->url("message/success/1099/8"));//1 for path creation in message/success controller
				exit(0);
			}

		}


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
		$numbers[$modlusnumber]++;//echo $modlusnumber;exit;
		return $modlusnumber;
    } 

};
?>
