<?php
class TodolistController extends NesoteController
{
	function settime($time)
	{
		return mktime( gmdate("H", $time), gmdate("i", $time), gmdate("s", $time), gmdate("m", $time), gmdate("d", $time), gmdate("Y", $time));
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



	function getId()
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
	function firstname($id)
	{

		$db=new NesoteDALController();
		$db->select("nesote_inoutscripts_users");
		$db->fields("name");
		$db->where("id=?", array($id));
		$result=$db->query();
		$rs=$db->fetchRow($result);

		return $rs[0];

	}
	
	
	function getusername($id)
	{
		
		$db=new NesoteDALController();
		$db->select("nesote_inoutscripts_users");
		$db->fields("username");
		$db->where("id=?",array($id));
		$rs1=$db->query();
		$row=$db->fetchRow($rs1);
		return $row[0];
	}

	function getname($id)
	{

		$db=new NesoteDALController();
		$db->select("nesote_inoutscripts_users");
		$db->fields("name");
		$db->where("id=?",array($id));
		$rs1=$db->query();
		$row=$db->fetchRow($rs1);
		return $row[0];
	}
	

	
		function shorten($text)
		{
			$text=substr($text,0,15);
			$text=htmlentities($text,0,"UTF-8");
			$text=nl2br($text);

			return $text;
		}

		function shottitle($fn,$ln)
		{
			$title=$fn." ".$ln;
			$length=strlen($title);
			if($length>12)
			$title=substr($title,0,11)."...";return $title;
		}
		
		function todolistAction()
		{
			
			
			$validateUser=$this->validateUser();

			if($validateUser!=TRUE)
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}

				
			   $var="";$date=time();$day=date('d',$date);$month=date('m',$date);$year=date('Y',$date);
			
				$st=mktime(0,0,0,$month,$day,$year);
				$en=$st+(60*60*24);
				$var=" and time>$st and time<$en";
			
			$uid=$this->getId();
			$this->setValue("uid",$uid);

			$select=new NesoteDALController();
			$select->select("nesote_email_usersettings");
			$select->fields("theme_id");
			$select->where("userid=?",$uid);
			$result=$select->query();//echo $select->getQuery();
			$res=$select->fetchRow($result);
			$style_id=$res[0];
			if($style_id=="")
			{

				$select->select("nesote_email_settings");
				$select->fields("value");
				$select->where("name='themes'");
				$result=$select->query();//echo $select->getQuery();
				$res=$select->fetchRow($result);
				$style_id=$res[0];


			}

			$select->select("nesote_email_themes");
			$select->fields("name,style");
			$select->where("id=?",$style_id);
			$result=$select->query();
			$theme=$select->fetchRow($result);

			$this->setValue("style",$theme[1]);

			//$userinfo=$this->getParam(1);$invite=$this->getParam(2);//echo $invite;EXIT;
			//$this->setValue("invite",$invite);


			$username=$_COOKIE['e_username'];

			$select->select("nesote_email_todo_list");
			$select->fields("*");
			$select->order("id desc");
			$select->limit(0,1);
			$result=$select->query();
			$result1=$select->fetchRow($result);
			$this->setValue("newtodoid",$result1[0]+1);
		
			
			$select->select("nesote_email_todo_list");
			$select->fields("*");
			$select->where("userid=?",array($uid));
			$select->order("time asc");
			$result11=$select->query();//echo $select->getQuery();
			$no=$select->numRows($result11);
			$this->setValue("total_a",$no);
			
			$select->select("nesote_email_todo_list");
			$select->fields("*");
			$select->where("userid=? and status=?",array($uid,0));
			$select->order("time asc");
			$result11=$select->query();//echo $select->getQuery();
			$no=$select->numRows($result11);
			$this->setValue("total_c",$no);
			
			$select->select("nesote_email_todo_list");
			$select->fields("*");
			$select->where("userid=? and status=?",array($uid,1));
			$select->order("time asc");
			$result11=$select->query();//echo $select->getQuery();
			$no=$select->numRows($result11);
			$this->setValue("total_p",$no);
			
			$select->select("nesote_email_todo_list");
			$select->fields("*");
			$select->where("userid=? $var",array($uid));
			$select->order("time asc");
			$result11=$select->query();//echo $select->getQuery();
			$no=$select->numRows($result11);
			$this->setValue("total_t",$no);
			
			$this->setLoopValue("list",$result11->getResult());

			$memorymsg=$this->getmessage(351);
			$year=date("Y",time());
			$msg1=str_replace('{year}',$year,$memorymsg);
			$this->setValue("footer",$msg1);

		}
		
		function addlistAction()
		{
			$validateUser=$this->validateUser();

			if($validateUser!=TRUE)
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}
			
			$uid=$this->getId();
			$list=$_POST['value'];
			$passhideval=$_POST['passhideval'];
			$db=new NesoteDALController();$time=time();$notes="";
			if($passhideval=="")
			{
			$db->insert("nesote_email_todo_list");
			$db->fields("userid,list,status,time");
			$db->values(array($uid,$list,1,$time));
			$res=$db->query();
			$lastid=$db->lastInsertid("nesote_email_todo_list");
			
			echo $lastid."{nesote_c}".$uid."{nesote_c}".$list."{nesote_c}".$time."{nesote_c}".$notes;exit;
			}
			else
			{
				$db->update("nesote_email_todo_list");
				$db->set("list=?",$list);
				$db->where("userid=? and id=?",array($uid,$passhideval));
				$res=$db->query();
				$lastid=$passhideval;echo $lastid;exit;
			}
			
			
			
		}
	function insertlistdetailsAction()
	{
		$validateUser=$this->validateUser();

			if($validateUser!=TRUE)
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}
			
			$uid=$this->getId();$time=time();
			$list=$_POST['value'];
			$passhideval=$_POST['passhideval'];
			$todo_checkbox=$_POST['todo_checkbox'];
			$notes=$_POST['notes'];
			if($notes==$this->getmessage(628))
			$notes="";
			$cid=$_POST['cid'];
			$from=$_POST['from'];
			$db=new NesoteDALController();
			if($from!="")
			{
			$frm=explode("/",$from);
			//if($frm[0]==date("m") && $frm[1]==date("m") && $frm[2]==date("Y") )
			$fromdate=mktime(date("G"),date("i"),date("s"),$frm[1],$frm[0],$frm[2]);
			}
			else
			{
				
				$fromdate="";
			}
		
			
			if($passhideval=="" && $cid==0)
			{
				$db->insert("nesote_email_todo_list");
				$db->fields("userid,list,status,time,notes");
				$db->values(array($uid,$list,$todo_checkbox,$fromdate,$notes));
				$res=$db->query();
				$lastid=$db->lastInsertid("nesote_email_todo_list");
				echo $lastid."{nesote_c}".$uid."{nesote_c}".$list."{nesote_c}".$todo_checkbox."{nesote_c}".$fromdate."{nesote_c}".$notes;exit;
			}
			else
			{
				$db->select("nesote_email_todo_list");
				$db->fields("time");
				$db->where("userid=? and id=?",array($uid,$passhideval));
				$result11=$db->query();
				$res1=$db->fetchRow($result11);
				
				
				if((date("d",$res1[0])==date("d",$fromdate)) && (date("m",$res1[0])==date("m",$fromdate)) && (date("Y",$res1[0])==date("Y",$fromdate)))
				{$f=0;$fromdate=$res1[0];}
				else
				$f=1;
				
				
				$db->update("nesote_email_todo_list");
				if($f==0)
				$db->set("list=?,status=?,notes=?",array($list,$todo_checkbox,$notes));
				else if($f==1)
				$db->set("list=?,status=?,time=?,notes=?",array($list,$todo_checkbox,$fromdate,$notes));
				$db->where("userid=? and id=?",array($uid,$passhideval));
				$res=$db->query();
				$lastid=$passhideval;
				
				echo $lastid."{nesote_c}".$uid."{nesote_c}".$list."{nesote_c}".$todo_checkbox."{nesote_c}".$fromdate."{nesote_c}".$notes."{nesote_c}".$f;exit;
				//echo $lastid."{nesote_c}".$uid."{nesote_c}".$list."{nesote_c}".$todo_checkbox."{nesote_c}".$fromdate."{nesote_c}".$notes;exit;
				
			}
			
			
	}	
function getlistAction()
{
	
	$validateUser=$this->validateUser();

			if($validateUser!=TRUE)
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}
			
			$uid=$this->getId();$list="";
			$page=$this->getParam(1);$todoarray=$this->getParam(3);
			
			$var="";
			if($page==0)
			{
			$date=time();$day=date('d',$date);$month=date('m',$date);$year=date('Y',$date);
			$st=mktime(0,0,0,$month,$day,$year);
			$en=$st+(60*60*24);
			$var=" and time>$st and time<$en";
			}
			
			if($todoarray=="today")
			$var=" and time>$st and time<$en";
			else if($todoarray=="todocomplete")
			$var=" and status=0";
			else if($todoarray=="todopending")
			$var=" and status=1";
			else if($todoarray=="todoall")
			$var="";
			
			$select=new NesoteDALController();
			$select->select("nesote_email_todo_list");
			$select->fields("*");
			$select->where("userid=? $var",array($uid));
			$select->order("time asc");
			$result11=$select->query();
			$no=$select->numRows($result11);
				
			//if($no!=0)	
			//{
				while($row1=$select->fetchRow($result11))
				{
					$list.=trim($row1[0])."{nesote_c}";//id
					$list.=trim($row1[1])."{nesote_c}";//userid
					$list.=trim($row1[2])."{nesote_c}";//list
					$list.=trim($row1[3])."{nesote_c}";//status
					$list.=trim($row1[4])."{nesote_c}";//time
					$list.=trim($row1[5])."{nesote_c}";//notes
				}
			
				
			$list=substr($list,0,-10);
			$list=$no.":::".$list;
			print_r($list);
			exit;
}
		
		function updateliststatusAction()
		{
			$validateUser=$this->validateUser();

			if($validateUser!=TRUE)
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}
			
			$uid=$this->getId();
			$status=$_POST['value'];
			$id=$_POST['id'];
			$db=new NesoteDALController();
			$db->update("nesote_email_todo_list");
			$db->set("status=?",$status);
			$db->where("userid=? and id=?",array($uid,$id));
			$res=$db->query();//echo $db->getQuery();
			
			echo "";exit;
		}
		
		function actionsAction()
		{
			$validateUser=$this->validateUser();

			if($validateUser!=TRUE)
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}
			
			$uid=$this->getId();
			$id=$_POST['id'];
			$db1=new NesoteDALController();
			if($id==1)// for delete
			{
				$db1->delete("nesote_email_todo_list");
				$db1->where("userid=?",array($uid));
				$db1->query();echo "";exit;
			}
			else if($id==2) // clear pending list
			{
				$db1->delete("nesote_email_todo_list");
				$db1->where("userid=? and status=1",array($uid));
				$db1->query();
				
				echo "";exit;
			}
			else if($id==3) // clear completed list
			{
				
				$db1->delete("nesote_email_todo_list");
				$db1->where("userid=? and status=0",array($uid));
				$db1->query();
				
				echo "";exit;
			}
			else if($id==4) // clear today list
			{
				$date=time();$day=date('d',$date);$month=date('m',$date);$year=date('Y',$date);
				$st=mktime(0,0,0,$month,$day,$year);
				$en=$st+(60*60*24);
				$var=" and time>$st and time<$en";
			
			
				$db1->delete("nesote_email_todo_list");
				$db1->where("userid=? $var",array($uid));
				$db1->query();echo "";exit;
			}
		}

		function isValid($email)
		{
			$result = TRUE;
			if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email))
			{
				$result = FALSE;
			}
			return $result;
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

		
		function getshortdate($date)
		{
			$db= new NesoteDALController();
			$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name=?",time_zone_postion);
			$result=$db->query();
			$row=$db->fetchRow($result);
			$position=$row[0];


			$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name=?",time_zone_hour);
			$result1=$db->query();
			$row1=$db->fetchRow($result1);
			$hour=$row1[0];


			$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name=?",time_zone_mint);
			$result2=$db->query();
			$row2=$db->fetchRow($result2);
			$min=$row2[0];

			$diff=((3600*$hour)+(60*$min));

			if($position=="Behind")
			$diff=-$diff;
			else
			$diff=$diff;

			$ts=time()-$date-$diff;

            $userid=$this->getId();
			$db->select("nesote_email_usersettings");
			$db->fields("time_zone");
			$db->where("userid=?",array($userid));
			$res3=$db->query();
			$row3=$db->fetchRow($res3);

			$db->select("nesote_email_time_zone");
			$db->fields("value");
			$db->where("id=?",array($row3[0]));
			$res3=$db->query();
			$row3=$db->fetchRow($res3);
			$timezone=$row3[0];

			$sign=trim($timezone[0]);
			$timezone1=substr($timezone,1);

			$timezone1=explode(":",$timezone1);
			$newtimezone=($timezone1[0]*60*60)+($timezone1[1]*60);

			if($sign=="+")
			$newtimezone=$newtimezone;
			if($sign=="-")
			$newtimezone=-$newtimezone;
			$ts=$newtimezone+$ts;


			$month_id = date("n",$date);
			if(isset ($_COOKIE['lang_mail']))
			{
				$lang_code=$_COOKIE['lang_mail'];
			}
			else
			{

				$db->select("nesote_email_settings");
				$db->fields("value");
				$db->where("name=?",'default_language');
				$result=$db->query();
				$data4=$db->fetchRow($result);
				$lang_code=$data4[0];
				//$defaultlang_id=$data4[0];
			}
            $lang_id=$this->getlang_id($lang_code);
			$day=date(" j ",$date);


			$db->select("nesote_email_months_messages");
			$db->fields("message");
			$db->where("month_id=? and lang_id=?",array($month_id,$lang_id));
			$result=$db->query();
			$data=$db->fetchRow($result);

			if($ts>2419200)
			{

				$val = $data[0].date(" j,Y ",$date);
			}
			elseif($ts>86400)
			{
				$val =$data[0]. $day;
				//$val=$data[0].$day." (".round($ts/86400,0).' '. $this->getmessage(55).')';
			}
			else
			{
				$val = ' '.$data[0].date("j",$date) ;
				if($ts>3600)
				$val = ' '.round($ts/3600,0).' '.$this->getmessage(56).'';
				else if($ts>60)
				$val = ' '.round($ts/60,0).' '.$this->getmessage(57).'';
				else
				$val = ' '.$ts.' '.$this->getmessage(58).'';
			}
			return $val;

		}


		
		function getuserid($chat_id)
		{
			$sender=$this->getId();
			$db=new NesoteDALController();
			$db->select("nesote_chat_session_users");
			$db->fields("user_id");
			$db->where("chat_id=? and user_id!=?", array($chat_id,$sender));
			$result=$db->query();
			$rs=$db->fetchRow($result);

			return $rs[0];

		}

		
	function validateUser()
	{
		    $db=new NesoteDALController();
		    $this->loadLibrary('Settings');
			$settings=new Settings('nesote_email_settings');
			$settings->loadValues();
			$portal_status=$settings->getValue("portal_status");
		if($portal_status==0)
		{		
			$username=$_COOKIE['e_username'];
			$password=$_COOKIE['e_password'];
			
			$db->select("nesote_inoutscripts_users");
			$db->fields("*");
			$db->where("username=? and password=? and status=?", array($username,$password,1));
			$result=$db->query();
			$no=$db->numRows($result);
			if($no!=1)
			{
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		else
		{
			$username=$_COOKIE['e_username'];
			$password=$_COOKIE['e_password'];
           
			$db->select("nesote_inoutscripts_users");
			$db->fields("*");
			$db->where("username=? and password=? and status=?", array($username,$password,1));
			$result=$db->query();//echo $db->getQuery();
			$results=$db->fetchRow($result);
			
			 $no=$db->numRows($result);
			if($no>0)
			{ 
	            $userid=$results[0];
					
				$db->select("nesote_email_usersettings");
				$db->fields("time_zone,server_password,smtp_username");
				$db->where("userid=?",$userid);
				$res=$db->query();
				$result=$db->fetchRow($res);
				if($result[0]!="" && $result[1]!="" )
				return TRUE;
				else
				{
				header("Location:".$this->url("user/portal_registration"));
				exit(0);
				}
			}
			else
			{
				$this->loadLibrary('Settings');
				$settings=new Settings('nesote_email_settings');
				$settings->loadValues();
				$portal_status=$settings->getValue("portal_status");
				$portal_installation_url=$settings->getValue("portal_installation_url");
				
		        $servicekey_rev=strrev($portal_installation_url); 
				$servicekey=substr($servicekey_rev,0,strpos($servicekey_rev,"/"));
				$servicekey1=$servicekey;
				$servicekey=str_replace($servicekey1,"",$servicekey_rev);
				$servicekey=strrev($servicekey)."index.php?page=index/login";
				header("Location:".$servicekey);
				     exit(0);
			}
		}
	}
		
function getfullname($username)
{
	$db=new NesoteDALController();
	$db->select("nesote_inoutscripts_users");
	$db->fields("name");
	$db->where("username=?",array($username));
	$rs1=$db->query();
	$row=$db->fetchRow($rs1);
	return $row[0];
}

function gettime($date,$username)
{
	//return date("h:i A ",$date);
	$db= new NesoteDALController();
	

	$ts=$date;
	$tsa=$date;
	//$tsa=time()-$date+$diff;
	$year1= date("Y",$date);
	$year2= date("Y",time());
     $userid=$this->getId();
	$db->select("nesote_email_usersettings");
	$db->fields("time_zone");
	$db->where("userid=?",array($userid));
	$res3=$db->query();
	$row3=$db->fetchRow($res3);
		
	$db->select("nesote_email_time_zone");
	$db->fields("value");
	$db->where("id=?",array($row3[0]));
	$res3=$db->query();
	$row3=$db->fetchRow($res3);
	$timezone=$row3[0];
		
	$sign=trim($timezone[0]);
	$timezone1=substr($timezone,1);
		
	$timezone1=explode(":",$timezone1);
	$newtimezone=($timezone1[0]*60*60)+($timezone1[1]*60);
		
	if($sign=="+")
	$newtimezone=$newtimezone;
	if($sign=="-")
	$newtimezone=-$newtimezone;
	$ts=$ts+$newtimezone;
	$tsa=$tsa+$newtimezone;

	$date=$ts;

	$month_id = date("n",$date);
	if(isset ($_COOKIE['lang_mail']))
	{
		$lang_code=$_COOKIE['lang_mail'];
	}
	else
	{

		$db->select("nesote_email_settings");
		$db->fields("value");
		$db->where("name=?",'default_language');
		$result=$db->query();
		$data4=$db->fetchRow($result);
		$lang_code=$data4[0];
		//$defaultlang_id=$data4[0];
	}
    $lang_id=$this->getlang_id($lang_code);
	$day=date(" j ",$date);


	$db->select("nesote_email_months_messages");
	$db->fields("message");
	$db->where("month_id=? and lang_id=?",array($month_id,$lang_id));
	$result=$db->query();
	$data=$db->fetchRow($result);
	if($data[0]=="")
	{

		$db->select("nesote_email_months_messages");
		$db->fields("message");
		$db->where("month_id=? and lang_id=?",array($month_id,1));
		$result=$db->query();
		$data=$db->fetchRow($result);
	}
	$v1=time()-$diff+$newtimezone;
	$v2=mktime(0, 0, 0, date("m",$v1), date("d",$v1), date("Y",$v1));
	if($tsa>2419200)
	{
		if($year1==$year2)
		$val = $data[0].date(" j ",$date);
		else
		$val = date(" d/m/y ",$date);
	}
	elseif($ts<$v2)
	{
		if($year1==$year2)
		$val = $data[0].date(" j ",$date);
		else
		$val = date(" d/m/y ",$date);
	}
	else
	{
		$val =date("h:i A ",$date);
	}

	return $val;
}


};
?>
