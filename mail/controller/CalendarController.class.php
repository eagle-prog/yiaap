<?php
class CalendarController extends NesoteController
{
	
	function getloggedheader()
		{
			$io_username=$_COOKIE["e_username"];
			$io_password=$_COOKIE["e_password"];
			$lang_code=$_COOKIE["lang_mail"];
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
				$url=$portal_installation_url."/index.php?page=index/loggedcommonheader/".$lang_code."/".$servicekey."/".$result[0];

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
	
		
		//Function to get the user image of a user
		function getuserimage($userid)
		{
				
			$select=new NesoteDALController();
			$select->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users"));
			$select->fields("c.image");
			$select->where("u.id=? and  u.id=c.userid",$userid);
			$meet=$select->query();
			$meet1=$select->fetchRow($meet);
			$num=$select->numRows($meet);
			if($num==0)
			{
				return("images/nophoto.gif");
			}
			else 
			{
				if(empty($meet1[0]))
					return("images/nophoto.gif");
				else
			  return ("userdata/".$userid."/".$meet1[0]);
			}
		}
		
		
		
		
	function calendarAction()
	{


	
		if(!$this->validateUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		
		
		$username=$_COOKIE['e_username'];$userid=$this->getId();
		
		$userimagepic=$this->getuserimage($userid);
		$this->setValue("userimagepic",$userimagepic);
		
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$portal_status=$settings->getValue("portal_status");
        $this->setValue("portal_status",$portal_status);
		
		$modulsnumber=$this->tableid($username);
		$st1=mktime(date("H",time()),date("i",time()),date("s",time()),date("m",time()),date("d",time()),date("Y",time()));
		$en1=mktime(23,59,59,date("m",time()),date("d",time()),date("Y",time()));
		

		$memorymsg=$this->getmessage(351);
		$year=date("Y",time());
		$msg1=str_replace('{year}',$year,$memorymsg);
		$this->setValue("footer",$msg1);
		
         
		$db=new NesoteDALController();
		$db->select("nesote_email_events_$modulsnumber");
		$db->fields("start,title");
		$db->where("start>=$st1 and start<$en1 and userid=$userid");
		$db->order("start asc");
		$result=$db->query();
		$this->setLoopValue("cal",$result->getResult());
		$no=$db->numRows($result);
		$this->setValue("no",$no);
		
		$today_date=date("d");
		$today_month=date("F");
		$today_year=date("Y");
		
		$this->setValue("today_date",$today_date);
		$this->setValue("today_month",$today_month);
		$this->setValue("today_year",$today_year);
		$this->loadLibrary('Settings');
			$settings=new Settings('nesote_email_settings');
			$settings->loadValues();
			
			$img=$settings->getValue("user_page_logo");
			$imgpath="admin/logo/$img";
			$this->setValue("imgpath",$imgpath);
			$servicename=$settings->getValue("engine_name");
			$this->setValue("servicename",$servicename);
			$username=$_COOKIE['e_username'];
			$username=$username.$this->getextension();
			$this->setValue("username",$username);
			
		$setm=$this->getParam(1);$setd=$this->getParam(2);$sety=$this->getParam(3);$setflag=0;
		if(isset($setm) && isset($setd) && isset($sety))
		{
			$setflag=1;
		}
		$this->setValue("setflag",$setflag);
		$this->setValue("setd",$setd);
		$this->setValue("setm",$setm);
		$this->setValue("sety",$sety);
		$username=$_COOKIE['e_username'];$remainder_flag=0;$overflag=0;

		$modulsnumber=$this->tableid($username);

		$db=new NesoteDALController();
		$db->select("nesote_email_calendar_settings");
		$db->fields("value");
		$db->where("name=?",'email_remainder');
		$result=$db->query();
		$data4=$db->fetchRow($result);
		$email_remainder=$data4[0];
		
		
		$db->select("nesote_email_calendar_settings");
		$db->fields("value");
		$db->where("name=?",'view_event');
		$result=$db->query();
		$data4=$db->fetchRow($result);
		$view_event=$data4[0];
		
		$db->select("nesote_email_usersettings");
		$db->fields("email_remainder,view_event");
		$db->where("userid=?", array($userid));
		$result=$db->query();
		$row=$db->fetchRow($result);
		
		if($email_remainder==1)
		{
		if($row[0]==1)
		$remainder_flag=1;
		}
		
		
		if($view_event==1)
		{
		if($row[1]==1)	
		$overflag=1;
		}
		
		
		$this->setValue("remainder_flag",$remainder_flag);
		$this->setValue("overflag",$overflag);
		
		
		$db->select("nesote_email_time_zone");
		$db->fields("id,name,value");
		$result=$db->query();
		$this->setLoopValue("timezone",$result->getResult());

		$timezone="";
		$this->setValue("tzone",$timezone);

	}
	function geteventsAction()
	{
		if(!$this->validateUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

		$username=$_COOKIE['e_username'];$userid=$this->getId();

		$modulsnumber=$this->tableid($username);

		$db=new NesoteDALController();
		$db->select("nesote_email_events_$modulsnumber");
		$db->fields("*");$db->where("userid=?",$userid);
		$result=$db->query();
		$json.= '"message":[ ';
		$x='[';
		while($message_array =$db->fetchRow($result)) {
			$p1=date("d",$message_array[2]);
			$p2=date("d",$message_array[3]);
			$st1=date("h:ia",$message_array[2]);$st2=date("h:ia",$message_array[3]);
			$start1=date("h:i",$message_array[2]);$end1=date("h:i",$message_array[3]);
			if($p1!=$p2)
			{
			$date=date("D, F d, h:ia",$message_array[2]).date(" - D, F d, h:ia",$message_array[3]);
			}
			else
			{
			$date=date("D, F d,",$message_array[2]).date("h:ia",$message_array[2]).date(" - h:ia",$message_array[3]);
			}
			
		    $remtime=$message_array[2]-$message_array[9];
		    $remmod=$message_array[11];
		   
		    if($remmod==1)
		    {
		   	$remtime=$remtime/(60*60);
		    }
		    else if($remmod==2)
		    {
		    $remtime=$remtime/(60*60*60);
		    }
		    else if($remmod==3)
		    {
		     $remtime=$remtime/(60*60*60*24);
		    }
		    else if($remmod==4)
		    {
		     $remtime=$remtime/(60*60*60*24*7);
		    }
		    $color=$message_array[12];
		    $time_zone=$this->gettimezone();
			$x.='{"id":"'.$message_array[0].'","title":"'.$message_array[5].'","desc":"'.$message_array[7].'","zone":"'.$message_array[6].'","remflag":"'.$message_array[8].'","remtime":"'.$remtime.'","remmod":"'.$remmod.'","dispdate":"'.$date.'","st1":"'.$st1.'","st2":"'.$st2.'","start1":"'.$start1.'","end1":"'.$end1.'","start":"'.date("Y-m-d H:i:s",$message_array[2]).'+'.$time_zone.'","backgroundColor":"'.$color.'","borderColor":"'.$color.'","end":"'.date("Y-m-d H:i:s",$message_array[3]).'+'.$time_zone.'","allDay":false},';

		}
		$x=substr($x,0,-1);
		$x .= ']';
		echo $x;exit;
	}
	function updateeventsAction()
	{
		if(!$this->validateUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		$username=$_COOKIE['e_username'];$userid=$this->getId();
		$modulsnumber=$this->tableid($username);

	 $title=$_POST['title'];
	 //$start=$_POST['start']-(5*60*60+30*60);
	 //date("d M Y","1318568504");
	 
	 
		if($title==$this->getmessage(611))
		$title=$this->getmessage(618);
		$desc=$_POST['desc'];
		if($desc==$this->getmessage(609))
		$desc="";
		
		$start=$_POST['start'];
		$start=explode(":",$start);
		$starttime=mktime($start[3],$start[4],$start[5],$start[1],$start[2],$start[0]);
		$end=$_POST['end'];
		$end=explode(":",$end);
		$endtime=mktime($end[3],$end[4],$end[5],$end[1],$end[2],$end[0]);
	
		$remflag=$_POST['remflag'];
		$remtime=$_POST['remtime'];
		$remmod=$_POST['remmod'];
		$tzoneflag=$_POST['tzoneflag'];
		$tzone=$_POST['tzone'];
		$bgselected=$_POST['bgselected'];
		if($bgselected=="")
		$bgselected="#4986e7";
		$remainder_time="";
		if($remflag==1)
		{
			
			if($remmod==1)
			{$remtime=$remtime*60*60;$remainder_time=$starttime-$remtime;	$remtime1=($starttime-$remainder_time)/(60*60);}
			else if($remmod==2)
			{$remtime=$remtime*60*60*60;$remainder_time=$starttime-$remtime;	$remtime1=($starttime-$remainder_time)/(60*60*60);}
			else if($remmod==3)
			{$remtime=$remtime*60*60*60*24;$remainder_time=$starttime-$remtime;	$remtime1=($starttime-$remainder_time)/(60*60*60*24);}
			else if($remmod==4)
			{$remtime=$remtime*60*60*60*24*7;$remainder_time=$starttime-$remtime;	$remtime1=($starttime-$remainder_time)/(60*60*60*24*7);}
		    
		}
		
		if($tzoneflag==1)
		$time_zone=$tzone;
		else
		{
			$time_zone=$this->gettimezone();
		}
		
	
	    $id=$_POST['id'];
	 	$db=new NesoteDALController();
	 	$db->update("nesote_email_events_$modulsnumber");
	 	$db->set("start=?,end=?,title=?,timezone=?,description=?,remainder=?,remainder_time=?,emailsend=?,remainder_mode=?,bg_color=?",array($starttime,$endtime,$title,$time_zone,$desc,$remflag,$remainder_time,0,$remmod,$bgselected));
		$db->where("id=? and userid=?",array($id,$userid));
		$db->query();//echo $db->getQuery();exit;
		
			$p1=date("d",$starttime);
			$p2=date("d",$endtime);
			if($p1!=$p2)
			{
			$date=date("D, F d, h:ia",$starttime).date(" - D, F d, h:ia",$endtime);
			}
			else
			{
			$date=date("D, F d,",$starttime).date("h:ia",$starttime).date(" - h:ia",$endtime);
			}
			
			
		
		$st1=mktime(date("H",time()),date("i",time()),date("s",time()),date("m",time()),date("d",time()),date("Y",time()));
		$en1=mktime(23,59,59,date("m",time()),date("d",time()),date("Y",time()));
		
		$db->select("nesote_email_events_$modulsnumber");
		$db->fields("start,title");
		$db->where("start>=$st1 and end<$en1 and userid=$userid");
		$db->order("start asc");
		$result=$db->query();
		$num=$db->numRows($result);$str="";
		
	if($num==0)
$str.="<div class=\"noevents-ad\">".$this->getmessage(654)."</div>";
else
{
	while($row=$db->fetchRow($result))
		{
	    $str.="<div class=\"d-t\">".date("h:i A",$row[0])."</div><div class=\"dis\">$row[1]</div>";
		}
}
		
		echo "$time_zone:::$remflag:::$remtime1:::$remmod:::$date:::$bgselected:::$str";exit;
	 
	}
	
	function updateAction()// for dragging
	{
		if(!$this->validateUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		$username=$_COOKIE['e_username'];$userid=$this->getId();
		$modulsnumber=$this->tableid($username);
		
		$start=$_POST['start'];
		/*$start=explode(":",$start);
		$starttime=mktime($start[3],$start[4],$start[5],$start[1],$start[2],$start[0]);*/
		$end=$_POST['end'];
		/*$end=explode(":",$end);
		$endtime=mktime($end[3],$end[4],$end[5],$end[1],$end[2],$end[0]);*/
	 $id=$_POST['id'];
	
	 	$db=new NesoteDALController();
	 	$db->update("nesote_email_events_$modulsnumber");
	 	$db->set("start=?,end=?",array($start,$end));
		$db->where("id=? and userid=?",array($id,$userid));
		$db->query();//echo $db->getQuery();exit;
		
			$p1=date("d",$start);
			$p2=date("d",$end);
			if($p1!=$p2)
			{
			$date=date("D, F d, h:ia",$start).date(" - D, F d, h:ia",$end);
			}
			else
			{
			$date=date("D, F d,",$start).date("h:ia",$start).date(" - h:ia",$end);
			}
		
	$st1=mktime(date("H",time()),date("i",time()),date("s",time()),date("m",time()),date("d",time()),date("Y",time()));
	$en1=mktime(23,59,59,date("m",time()),date("d",time()),date("Y",time()));
		
		$db->select("nesote_email_events_$modulsnumber");
		$db->fields("start,title");
		$db->where("start>=$st1 and end<$en1 and userid=$userid");
		$db->order("start asc");
		$result=$db->query();
		$num=$db->numRows($result);$str="";
		
	if($num==0)
$str.="<div class=\"noevents-ad\">".$this->getmessage(654)."</div>";
else
{
	while($row=$db->fetchRow($result))
		{
	    $str.="<div class=\"d-t\">".date("h:i A",$row[0])."</div><div class=\"dis\">$row[1]</div>";
		}
	}
		
		echo $date.":::".$str;exit;
	 
	}
	
	function addeventsAction()
	{
		if(!$this->validateUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		$username=$_COOKIE['e_username'];
		$uid=$this->getId();
		$modulsnumber=$this->tableid($username);
		$title=$_POST['title'];
		if($title==$this->getmessage(611))
		$title=$this->getmessage(618);
		$desc=$_POST['desc'];
		if($desc==$this->getmessage(609))
		$desc="";
		$start=$_POST['start'];
		$start=explode(":",$start);
		$starttime=mktime($start[3],$start[4],$start[5],$start[1],$start[2],$start[0]);
		$end=$_POST['end'];
		$end=explode(":",$end);
		$endtime=mktime($end[3],$end[4],$end[5],$end[1],$end[2],$end[0]);
		
		
		
		$remflag=$_POST['remflag'];
		$remtime=$_POST['remtime'];
		$remmod=$_POST['remmod'];
		$tzoneflag=$_POST['tzoneflag'];
		$tzone=$_POST['tzone'];
		$bgselected=$_POST['bgselected'];
		if($bgselected=="")
		$bgselected="#4986e7";
		$remainder_time="";
		if($remflag==1)
		{
			if($remmod==1)
			{$remtime=$remtime*60*60;$remainder_time=$starttime-$remtime;	$remtime1=($starttime-$remainder_time)/(60*60);}
			else if($remmod==2)
			{$remtime=$remtime*60*60*60;$remainder_time=$starttime-$remtime;	$remtime1=($starttime-$remainder_time)/(60*60*60);}
			else if($remmod==3)
			{$remtime=$remtime*60*60*60*24;$remainder_time=$starttime-$remtime;	$remtime1=($starttime-$remainder_time)/(60*60*60*24);}
			else if($remmod==4)
			{$remtime=$remtime*60*60*60*24*7;$remainder_time=$starttime-$remtime;	$remtime1=($starttime-$remainder_time)/(60*60*60*24*7);}
		    
		}
		
		if($tzoneflag==1)
		$time_zone=$tzone;
		else
		{
			$time_zone=$this->gettimezone();
		}
		
		
		
		
		$db=new NesoteDALController();
		$db->insert("nesote_email_events_$modulsnumber");
		$db->fields("userid,start,end,title,timezone,description,remainder,remainder_time,emailsend,remainder_mode,bg_color");
		$db->values(array($uid,$starttime,$endtime,$title,$time_zone,$desc,$remflag,$remainder_time,0,$remmod,$bgselected));
		$db->query();
		
		$evtid=$db->lastInsertid("nesote_email_events_$modulsnumber");
		
			$p1=date("d",$starttime);
			$p2=date("d",$endtime);
			if($p1!=$p2)
			{
			$date=date("D,F d, h:ia",$starttime).date(" - D,F d, h:ia",$endtime);
			}
			else
			{
			$date=date("D,F d,",$starttime).date("h:ia",$starttime).date(" - h:ia",$endtime);
			}
	
		
		$st1=mktime(date("H",time()),date("i",time()),date("s",time()),date("m",time()),date("d",time()),date("Y",time()));
		$en1=mktime(23,59,59,date("m",time()),date("d",time()),date("Y",time()));
		
		$db->select("nesote_email_events_$modulsnumber");
		$db->fields("start,title");
		$db->where("start>=$st1 and end<$en1 and userid=$uid");
		$db->order("start asc");
		$result=$db->query();
		$num=$db->numRows($result);$str="";
		
	if($num==0)
$str.="<div class=\"noevents-ad\">".$this->getmessage(654)."</div>";
else
{
	while($row=$db->fetchRow($result))
		{
	    $str.="<div class=\"d-t\">".date("h:i A",$row[0])."</div><div class=\"dis\">$row[1]</div>";
		}
}
			
	 echo "$time_zone:::$remflag:::$remtime1:::$remmod:::$evtid:::$date:::$bgselected:::$str";exit;

	}
	
	function deleteAction()
	{
		if(!$this->validateUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		$username=$_COOKIE['e_username'];
		$uid=$this->getId();
		$modulsnumber=$this->tableid($username);
		$id=$_POST['id'];
		$db=new NesoteDALController();
		$db->delete("nesote_email_events_$modulsnumber");
		$db->where("id=? and userid=?",array($id,$uid));
		$db->query();
		
	$st1=mktime(date("H",time()),date("i",time()),date("s",time()),date("m",time()),date("d",time()),date("Y",time()));
	$en1=mktime(23,59,59,date("m",time()),date("d",time()),date("Y",time()));
		
		$db->select("nesote_email_events_$modulsnumber");
		$db->fields("start,title");
		$db->where("start>=$st1 and end<$en1 and userid=$uid");
		$db->order("start asc");
		$result=$db->query();
		$num=$db->numRows($result);$str="";
		
	if($num==0)
$str.="<div class=\"noevents-ad\">".$this->getmessage(654)."</div>";
else
{
	while($row=$db->fetchRow($result))
		{
	    $str.="<div class=\"d-t\">".date("h:i A",$row[0])."</div><div class=\"dis\">$row[1]</div>";
		}
	}
	
	echo $str;exit;
}
	
function getindexval($val)
{
$s=explode(":",$val);
if($s[0]<10)
$s[0]="0".$s[0];

if($s[0]==00 && $s[1]==00)
return 1;
else if($s[0]==00 && $s[1]==30)
return 2;
else if($s[0]==01 && $s[1]==00)
return 3;
else if($s[0]==01 && $s[1]==30)
return 4;
else if($s[0]==02 && $s[1]==00)
return 5;
else if($s[0]==02 && $s[1]==30)
return 6;
else if($s[0]==03 && $s[1]==00)
return 7;
else if($s[0]==03 && $s[1]==30)
return 8;
else if($s[0]==05 && $s[1]==00)
return 11;
else if($s[0]==05 && $s[1]==30)
return 12;
else if($s[0]==06 && $s[1]==00)
return 13;
else if($s[0]==06 && $s[1]==30)
return 14;
else if($s[0]==07 && $s[1]==00)
return 15;

else if($s[0]==07 && $s[1]==30)
return 16;
else if($s[0]=='08' && $s[1]==00)
return 17;
else if($s[0]=='08' && $s[1]==30)
return 18;
else if($s[0]=='09' && $s[1]==00)
return 19;
else if($s[0]=='09' && $s[1]==30)
return 20;


else if($s[0]==10 && $s[1]==00)
return 21;
else if($s[0]==10 && $s[1]==30)
return 22;
else if($s[0]==11 && $s[1]==00)
return 23;
else if($s[0]==11 && $s[1]==30)
return 24;
else if($s[0]==12 && $s[1]==00)
return 25;
else if($s[0]==12 && $s[1]==30)
return 26;
else if($s[0]==13 && $s[1]==00)
return 27;
else if($s[0]==13 && $s[1]==30)
return 28;
else if($s[0]==14 && $s[1]==00)
return 29;
else if($s[0]==14 && $s[1]==30)
return 30;



else if($s[0]==15 && $s[1]==00)
return 31;
else if($s[0]==15 && $s[1]==30)
return 32;
else if($s[0]==16 && $s[1]==00)
return 33;
else if($s[0]==16 && $s[1]==30)
return 34;
else if($s[0]==17 && $s[1]==00)
return 35;
else if($s[0]==17 && $s[1]==30)
return 36;
else if($s[0]==18 && $s[1]==00)
return 37;
else if($s[0]==18 && $s[1]==30)
return 38;
else if($s[0]==19 && $s[1]==00)
return 39;
else if($s[0]==19 && $s[1]==30)
return 40;
else if($s[0]==20 && $s[1]==00)
return 41;
else if($s[0]==20 && $s[1]==30)
return 42;
else if($s[0]==21 && $s[1]==00)
return 43;
else if($s[0]==21 && $s[1]==30)
return 44;
else if($s[0]==22 && $s[1]==00)
return 45;
else if($s[0]==22 && $s[1]==30)
return 46;
else if($s[0]==23 && $s[1]==00)
return 47;
else if($s[0]==23 && $s[1]==30)
return 48;
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
	function gettimezone()
	{
		$username=$_COOKIE['e_username'];
		$password=$_COOKIE['e_password'];
		$db=new NesoteDALController();
		$userid=$this->getId();
		$db->select("nesote_email_usersettings");
		$db->fields("time_zone");
		$db->where("userid=? ", array($userid));
		$result=$db->query();
		$rs=$db->fetchRow($result);

		return $rs[0];

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
	function saveLogs($operation,$comment)
	{
		$userid=$this->getId();

		$insert=new NesoteDALController();
		$insert->insert("nesote_email_client_logs");
		$insert->fields("uid,operation,comment,time");
		$insert->values(array($userid,$operation,$comment,time()));
		$res=$insert->query();
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

	function getmailid($id)
	{//echo hai;
		$userid=$this->getId();

		$db=new NesoteDALController();
		$db->select("nesote_email_contacts");
		$db->fields("mailid");
		$db->where("id=? ",array($id));
		$result=$db->query();
		$rs=$db->fetchRow($result);
		$mailid=$rs[0];return  $mailid;

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
	
	function remainderAction()
	{
			$db=new NesoteDALController();$ctime=time();
			
			$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name=?",'engine_name');
			$result=$db->query();
			$data4=$db->fetchRow($result);
			$engine_name=strtoupper($data4[0]);
			$db1=new NesoteDALController();
		for($i=1;$i<=100;$i++)
		{
			$db->select("nesote_email_events_$i");
			$db->fields("*");
			$db->where("emailsend=? and remainder_time<=?",array(0,$ctime));
			$result=$db->query();
			while($rs=$db->fetchRow($result))
			{
				
				$p1=date("d",$rs[2]);
				$p2=date("d",$rs[3]);
				if($p1!=$p2)
					{
						$date=date("D,M d, h:ia",$rs[2]).date(" - D,M d, h:ia",$rs[3]);
					}
					else
					{
						$date=date("D,M d,",$rs[2]).date("h:ia",$rs[2]).date(" - h:ia",$rs[3]);
					}
			
					$subj=$this->getmessage(612).":- ". $rs[5]." @ ".$date;
					$to=$this->getusername($rs[1]).$this->getextension();
					$title=$rs[5];
					$username=$this->getusername($rs[1]);
					$umame=$this->getusername($rs[1]).$this->getextension()."'s ".$this->getmessage(3);
					$setd=date("d",$rs[2]);$setm=date("m",$rs[2])-1;$sety=date("Y",$rs[2]);
					//$link=$this->url("calendar/calendar/$setm/$setd/$sety");
					//$link=urlencode($link);
					
$url = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$http_host=$_SERVER['HTTP_HOST'];$http_host=str_replace("www.","",$http_host);
$var=$url .'://'.$http_host.$_SERVER['REQUEST_URI'];
$var=substr($var,0,strrpos($var,"/"));
$var=substr($var,0,strrpos($var,"="));
$link=$var."=calendar/calendar/$setm/$setd/$sety";
		
					$body="<table style=\"margin: 0 auto;border: 3px solid #666666;\" cellspacing=\"0\" cellpadding=\"0\" align=\"left\">
<tbody>
<tr>
<td style=\"padding:0; background-color: #FFFFFF;padding: 0;\">
<table cellspacing=\"0\" cellpadding=\"0\">
<tbody>
<tr>
<td style=\"background-color: #666666;color: white;font-family: Arial;font-size: 14px;font-weight: bold;padding: 0 0 0 10px;height: 20px;\" colspan=\"3\">$engine_name ".$this->getmessage(3)."  - ".$this->getmessage(624)."</td>
</tr>
<tr>
<td style=\"height: 5px;\" colspan=\"3\"></td>
</tr>
<tr>
<td style=\"font-family: Arial;font-size: 12px;padding: 0 10px;vertical-align: top;width: 18%;height: 20px;\">".$this->getmessage(54)."</td>
<td style=\"font-family: Arial;font-size: 12px;padding: 0;vertical-align: top;height: 20px;\">:</td>
<td style=\"font-family: Arial;font-size: 12px;padding: 0 10px;vertical-align: top;width: 80%;height: 20px;\">
<div><a href=\"$link\" target=\"_blank\" style=\"color: #000000;text-decoration: underline;\">".$umame."</a></div>
</td>
</tr>
<tr>
<td style=\"font-family: Arial;font-size: 12px;padding: 0 10px;vertical-align: top;width: 18%;height: 20px;\">".$this->getmessage(44)."</td>
<td style=\"font-family: Arial;font-size: 12px;padding: 0;vertical-align: top;height: 20px;\">:</td>
<td style=\"font-family: Arial;font-size: 12px;padding: 0 10px;vertical-align: top;width: 80%;height: 20px;\">$title</td>
</tr>
<tr>
<td style=\"font-family: Arial;font-size: 12px;padding: 0 10px;vertical-align: top;width: 18%;height: 20px;\">".$this->getmessage(281)."</td>
<td style=\"font-family: Arial;font-size: 12px;padding: 0;vertical-align: top;height: 20px;\">:</td>
<td style=\"font-family: Arial;font-size: 12px;padding: 0 10px;vertical-align: top;width: 80%;height: 20px;\">$date</td>
</tr>
";
if($rs[7]!="")
{
$body.="<tr>
<td style=\"font-family: Arial;font-size: 12px;padding: 0 10px;vertical-align: top;width: 18%;height: 20px;\">".$this->getmessage(609)."</td>
<td style=\"font-family: Arial;font-size: 12px;padding: 0;vertical-align: top;height: 20px;\">:</td>
<td style=\"font-family: Arial;font-size: 12px;padding: 0 10px;vertical-align: top;width: 80%;height: 20px;\">$rs[7]</td>
</tr>";
}
$body.="<tr>
<td style=\"height: 10px;\" colspan=\"3\"></td>
</tr>
<tr>
<td style=\"font-family: Arial;font-size: 12px;padding: 0 10px;vertical-align: top;width: 18%;height: 20px;\"></td>
<td style=\"font-family: Arial;font-size: 12px;padding: 0;vertical-align: top;height: 20px;\"></td>
<td style=\"font-family: Arial;font-size: 12px;padding: 0 10px;vertical-align: top;width: 80%;height: 20px;\">
<a href=\"$link\" target=\"_blank\" style=\"color: #000000;text-decoration: underline;\">".$this->getmessage(625)."</a>
</td>
</tr>
<tr>
<td style=\"height: 10px;\" colspan=\"3\"></td>
</tr
</tbody>
</table>
</td>
</tr>
</tbody>
</table><br>";

			$magic=get_magic_quotes_gpc();
			if($magic==1)
			{
				$body=stripcslashes($body);
			}

					$this->sendmail($to,$subj,$body,$rs[1],$username);
			
	 	$db1->update("nesote_email_events_$i");
	 	$db1->set("emailsend=?",array(1));
		$db1->where("id=?",array($rs[0]));
		$db1->query();
			}
		}
		
		echo "successfully..";exit;
	}
	
	function sendmail($to,$subject,$html,$id,$umame)
	{
		$db=new NesoteDALController();
		if($to!="")
		{
			$this->loadLibrary('Settings');
			$settings=new Settings('nesote_email_settings');
			$settings->loadValues();
			$admin_email=$settings->getValue("adminemail");
		
			$tablenumber=$this->tableid($umame);
			$time=$this->gettimeval($id);
			$db->insert("nesote_email_inbox_$tablenumber");
			$db->fields("userid,from_list,to_list,subject,body,time,status");
			$db->values(array($id,$admin_email,$to,$subject,$html,$time,1));
			$result=$db->query();//echo $db->getQuery();
			$last=$db->lastInsertid("nesote_email_inbox_$tablenumber");
			
			$var=time().$id.$last;
			$ext=$this->getextension();
			$message_id="<".md5($var).$ext.">";

			$mail_references="";

			$mail_references="<references><item><mailid>$last</mailid><folderid>1</folderid></item></references>";
                    $md5_reference=md5($mail_references);
			
			$db->update("nesote_email_inbox_$tablenumber");
			$db->set("mail_references=?,message_id=?,md5_references=?",array($mail_references,$message_id,$md5_reference));
			$db->where("id=?",$last);
			$res1=$db->query();
		}
		
	}
	
function gettimeval($userid)
	{

		
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		
		$db= new NesoteDALController();
		
		$position=$settings->getValue("time_zone_postion");

	
		$hour=$settings->getValue("time_zone_hour");


		$min=$settings->getValue("time_zone_mint");

		$diff=((3600*$hour)+(60*$min));

		if($position=="Behind")
		$diff=-$diff;
		else
		$diff=$diff;

		$ts=time()-$diff;
		//return $ts;

$db3= new NesoteDALController();
			$db3->select("nesote_email_usersettings");
			$db3->fields("time_zone");
			$db3->where("userid=?",array($userid));
			$res3=$db3->query();
			$row3=$db3->fetchRow($res3);
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
			return $time;

	}

};
?>
