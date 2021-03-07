<?php
class ChatController extends NesoteController
{
	function settime($time)
	{
		return mktime( gmdate("H", $time), gmdate("i", $time), gmdate("s", $time), gmdate("m", $time), gmdate("d", $time), gmdate("Y", $time));
	}
	function livesearchAction()
	{

		$validateUser=$this->validateUser();

		if($validateUser!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}



	  $divid=$this->getParam(1);
	$chatuserid=$this->getParam(2);
	        $q=$_GET["q"];

		$db=new NesoteDALController();


			
		$user_id=$this->getid();



		$str=$chatuserid.",";

		$db->select("nesote_chat_session_users");
		$db->fields("user_id");
		$db->where("chat_id=?",$divid);
		$rs1=$db->query();
		while($row=$db->fetchRow($rs1))
		{
			$str.=$row[0].",";
		}
		$str=substr($str,0,-1);
			

//		$db->select(array("c"=>"nesote_chat_contact"));
//		$db->fields("u.firstname,u.lastname,u.username");
//		$db->join(array("u"=>"nesote_users"),"c.receiver=u.id");
//		$db->where("(u.firstname like '$q%' or u.lastname like '$q%'or u.username like '$q%') and c.sender=? and c.status=? and u.status=? and u.id NOT IN($str) ",array($user_id,1,1));
//		$db->order("u.firstname asc");
//		$db->group("u.firstname");
//		$res=$db->query();//echo $db->getQuery();
		
		$db->select(array("c"=>"nesote_chat_contact","u"=>"nesote_inoutscripts_users"));
		$db->fields("u.name,u.username");

		$db->where("(u.name like '$q%' or  u.username like '$q%') and c.sender=? and c.status=? and u.status=? and c.receiver=u.id and u.id NOT IN($str) ",array($user_id,1,1));
		$db->order("u.name asc");
		$db->group("u.name");
		$res=$db->query(); 
		//echo $db->getQuery();exit(0);	


		$hint="";
		$i=0;
		while($row =$res->fetchRow())
		{
			$mail="";
			$value=" ";



			$value.=$row[0];//echo $value;
			$value.="&lt;".$row[1].$this->getextension()."&gt;";//echo $value;

			$value1=$value;


			$valuelength=strlen($value1);
			if($valuelength>28)
			$value1=substr($value1,0,28)."...";

			$div=$divid."_".$i;
			//$hint.="<div style=\"z-index:1;\"><table  cellpadding=\"0\" cellspacing=\"0\" width=\"350px\" sytle=\"position:absolute;overflow:visible;left: 0; top: 0; background-color: #eeeeee;\" ><tr><td  nowrap=\"nowrap\"><div  id=\"livesearch_ch_a_$div\"  onclick=\"javascript:setvaluefortb_ch('$value||$divid')\" style='color:#666666;width:350px;' >$value<input type='hidden' id=\"livesearch_ch_h_$div\" value=\"$value \"><input type='hidden' id=\"livesearch_ch_m_$div\" value=\"$value\"></div></td></tr></table></div>";


			//$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"350px\" sytle=\"background-color: #eeeeee;\" ><tr><td  nowrap=\"nowrap\"><div  id=\"livesearch_ch_a_$div\"  onclick=\"javascript:setvaluefortb_ch('$value||$divid')\" style='color:#666666;width:350px;' >$value<input type='hidden' id=\"livesearch_ch_h_$div\" value=\"$value \"><input type='hidden' id=\"livesearch_ch_m_$div\" value=\"$value\"></div></td></tr></table></div>";

			$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"190px\"  style=\"background-color: #eeeeee;font-size:12px;font-family:Verdana, Arial, Helvetica, sans-serif;\"><tr><td  nowrap=\"nowrap\" style=\"\"><div  id=\"livesearch_ch_a_$div\"  onclick=\"javascript:setvaluefortb_ch('$value||$divid')\" style='color:#666666;width:180px;overflow:hidden;' >$value1<input type='hidden' id=\"livesearch_ch_h_$div\" value=\"$value\"><input type='hidden' id=\"livesearch_ch_m_$div\" value=\"$value\"></div></td></tr></table>";

			$i++;
		}


		if ($hint == "")
		{
			//$response="<span style='color:#999999'>".$this->getmessage(414)." '$q'</span>";

			$response="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"190px\" style=\"background-color: #eeeeee;font-size:12px;font-family:Verdana, Arial, Helvetica, sans-serif;\"><tr><td  nowrap=\"nowrap\"><span style='color:#999999'>".$this->getmessage(414)." '$q'</span></td></tr></table>";
		}
		else
		{
			$response=$hint;
		}
		$response.="<input type=\"hidden\" id=\"count_ch\" value=\"$i\">";
		//output the response
		echo "$response";
		exit(0);

	}

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
	
	function getextension()
	{
		$validateUser=$this->validateUser();

		if($validateUser!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}


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
	function ajaxlivesearchAction()
	{
		$validateUser=$this->validateUser();

		if($validateUser!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

	}
	function ajaxlivesearch1Action()
	{
		$validateUser=$this->validateUser();

		if($validateUser!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

	}
	function invitechatAction()
	{

		$validateUser=$this->validateUser();

		if($validateUser!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}


		$value=$this->getParam(1);
		$divid=$this->getParam(2);$str="";


		$value1=explode("@",$value);
		$username=$value1[0];
		$value2=$this->getextension();
		$value3="@".$value1[1];

		$db=new NesoteDALController();



		$db->select("nesote_inoutscripts_users");
		$db->fields("id");
		$db->where("username=?",array($username));
		$rs1=$db->query();
		$row=$db->fetchRow($rs1);
		$userid=$row[0];

		if($userid=="")
		{
			$msg=$this->getmessage(422);
			$msg=str_replace("{user}","$user",$msg);
			$msg1=$this->getmessage(423);
			$time=date("g:i A",time());
			$day=date("l",time());

			$msg1=str_replace("{time}","$time",$msg1);
			$msg1=str_replace("{day}","$day",$msg1);

			$msg="\n$msg\n $msg1\n";

			//$msg=str_replace("{foldername}","$fldrname",$msg);

			$msg=htmlspecialchars_decode($msg);

			//$msg=str_replace("\n","<br>",$msg);

			$time=time();
			$time=$this->settime($time);

			$db->insert("nesote_chat_temporary_messages");
			$db->fields("chat_id,sender,responders,message,time,read_flag");
			$db->values(array($divid,0,$userid,$msg,$time,0));
			$result=$db->query();//echo $db->getQuery();
			echo $msg."+*+".$divid;exit;
		}

		if($value3!=$value2)
		{


			$msg1=$this->getmessage(423);
			$time=date("g:i A",time());
			$day=date("l",time());

			$msg1=str_replace("{time}","$time",$msg1);
			$msg1=str_replace("{day}","$day",$msg1);

			$msg2=$this->getmessage(424);
			$msg="\n$msg2\n $msg1\n";

			$msg=htmlspecialchars_decode($msg);

			//$msg=str_replace("\n","<br>",$msg);


			$time=time();
			$time=$this->settime($time);
			$db->insert("nesote_chat_temporary_messages");
			$db->fields("chat_id,sender,responders,message,time,read_flag");
			$db->values(array($divid,0,$userid,$msg,$time,0));
			$result=$db->query();//echo $db->getQuery();

			echo $msg."+*+".$divid;exit;
		}

		$sender=$this->getId();

		$userexist=$this->usercheck($username);$user=$value;
		$firstname=$this->firstname($userid);
		$invitedusername=$this->firstname($sender);


		$no2=$db->total("nesote_chat_contact","sender=? and receiver=? and status=?",array($sender,$userid,1));
		if($no2>0)
		{

			$db->select("nesote_chat_users");
			$db->fields("chat_status,logout_status,signout");
			$db->where("userid=?", array($userid));
			$result=$db->query();//echo $db->getQuery();
			$rslt1=$db->fetchRow($result);
			if($rslt1[1]==1 || $rslt1[2]==1) //logout
			{
				$msg=$this->getmessage(425);
				$msg=str_replace("{firstname}","$firstname",$msg);
					
				$msg="\n$msg";
				$msg=htmlspecialchars_decode($msg);$title="";
			}
			else if($rslt1[0]==0)
			{
				$msg1=$this->getmessage(418);
				$msg1=str_replace("{firstname}",$firstname,$msg1);
				$msg2=$this->getmessage(425);
				$msg2=str_replace("{firstname}","$user",$msg2);
				$msg3=$this->getmessage(423);
				$time=date("g:i A",time());
				$day=date("l",time());

				$msg3=str_replace("{time}","$time",$msg3);
				$msg3=str_replace("{day}","$day",$msg3);

					
					
				$msg="\n$msg1\n $msg2\n $msg3\n";
				$msg=htmlspecialchars_decode($msg);$title="";
			}
			else
			{

//				$db->select("nesote_chat_session_users");
//				$db->fields("*");
//				$db->where("chat_id=? and user_id=?",array($divid,$userid));
//				$rs1=$db->query();
//				$no1=$db->numRows($rs1);
				$no1=$db->total("nesote_chat_session_users","chat_id=? and user_id=?",array($divid,$userid));
				if($no1>0)
				{
					$msg2=$this->getmessage(426);
					$msg2=str_replace("{user}","$user",$msg2);
					$msg3=$this->getmessage(423);
					$time=date("g:i A",time());
					$day=date("l",time());

					$msg3=str_replace("{time}","$time",$msg3);
					$msg3=str_replace("{day}","$day",$msg3);

					$msg="\n$msg2\n $msg3\n";
					$msg=htmlspecialchars_decode($msg);
				}
				else
				{

					$db->update("nesote_chat_session");
					$db->set("time=?,xml_status=?,group_status=?",array(time(),0,1));
					$db->where("id=?",array($divid));
					$result=$db->query();
					$last=$db->lastInsertid("nesote_chat_session");

					$db1=new NesoteDALController();
					$db1->select("nesote_chat_session_users");
					$db1->fields("user_id");
					$db1->where("chat_id=? and user_id!=?",array($divid,$sender));
					$rs11=$db1->query();//echo $db->getQuery();
					while($row1=$db1->fetchRow($rs11))
					{

						$db->update("nesote_chat_session_users");
						$db->set("active_status=?",array(1));
						$db->where("user_id=?",array($row1[0]));
						$result=$db->query();
					}







					$db->insert("nesote_chat_session_users");
					$db->fields("chat_id,user_id,time,xml_status,typing_status,active_status,present_identified_time,initiators");
					$db->values(array($divid,$userid,time(),0,0,1,time(),$sender));
					$result=$db->query();//echo $db->getQuery();



                    $num=$db->total("nesote_chat_session_users","chat_id=? and active_status=?",array($divid,1));
					



					//$msg="\n$invitedusername have invited $firstname to this chat.\n$user has joined.\n Sent at ".date("g:i A",time())." on ".date("l",time())."\n";
					$msg=htmlentities($msg);$msg1="";$msg0="";

					$name0=$this->getname($sender);
					$msg=$this->getmessage(415);
					$msg=str_replace("{user}","$name0",$msg);

					$msg0.="\n$msg";


					$name4=$this->getname($userid);

					$msg=$this->getmessage(415);
					$msg=str_replace("{user}","$name4",$msg);
					$msg4="\n$msg";

					$mm=$this->getmessage(416);
					$msg100="\n$mm";


					$db->select("nesote_chat_session_users");
					$db->fields("user_id");
					$db->where("chat_id=? and active_status=? and user_id!=?",array($divid,1,$userid));
					$rs1=$db->query();//echo $db->getQuery();
					while($row1=$db->fetchRow($rs1))
					{

						$name3=$this->getname($row1[0]);
						$msg03=$this->getmessage(415);
						$msg03=str_replace("{user}","$name3",$msg03);
						$msg3.="$msg03\n";

					}
					$msg3=$msg100.$msg3;

					//$msg3=str_replace("\n","<br>",$msg3);

					$time=time();
					$time=$this->settime($time);
					$db->insert("nesote_chat_temporary_messages");
					$db->fields("chat_id,sender,responders,message,time,read_flag");
					$db->values(array($divid,0,$userid,$msg3,$time,0)); //for invited user from the sender side
					$result=$db->query();

					//$msg4=str_replace("\n","<br>",$msg4);


					$db->select("nesote_chat_session_users");
					$db->fields("user_id");
					$db->where("chat_id=? and active_status=? and user_id!=? and user_id!=?",array($divid,1,$sender,$userid));
					$rs1=$db->query();//echo $db->getQuery();

					$time=time();
					$time=$this->settime($time);
					while($row1=$db->fetchRow($rs1))
					{

						$db4=new NesoteDALController();
						$db4->insert("nesote_chat_temporary_messages");
						$db4->fields("chat_id,sender,responders,message,time,read_flag");
						$db4->values(array($divid,0,$row1[0],$msg4,$time,0));
						$result4=$db4->query();
					}

					$msg11="";
					
					$db->select("nesote_chat_session_users");
					$db->fields("user_id");
					$db->where("chat_id=? and active_status=? and user_id!=?",array($divid,1,$sender));
					$rs1=$db->query();//echo $db->getQuery();
					while($row11=$db->fetchRow($rs1))
					{
						$name11=$this->getname($row11[0]);
						$msg011=$this->getmessage(415);
						$msg011=str_replace("{user}","$name11",$msg011);
						$msg11.="$msg011\n";
					}
					if($num<4)
					{
						$msg1=$this->getmessage(416);
						$msg2=$this->getmessage(427);
						$msg2=str_replace("{firstname}","$firstname",$msg2);
						$msg3=$this->getmessage(423);
						$time=date("g:i A",time());
						$day=date("l",time());

						$msg3=str_replace("{time}","$time",$msg3);
						$msg3=str_replace("{day}","$day",$msg3);
							
						$msg="\n$msg2\n$msg1\n$msg11 $msg3\n";
					}
					else if($num>=4)
					{

						$msg2=$this->getmessage(427);
						$msg2=str_replace("{firstname}","$firstname",$msg2);
						$msg3=$this->getmessage(423);
						$time=date("g:i A",time());
						$day=date("l",time());

						$msg3=str_replace("{time}","$time",$msg3);
						$msg3=str_replace("{day}","$day",$msg3);
						$msg="$msg2 $msg4 $msg3\n";
					}
					//$msg=str_replace("\n","<br>",$msg);

					$time=time();
					$time=$this->settime($time);
					$db->insert("nesote_chat_temporary_messages");
					$db->fields("chat_id,sender,responders,message,time,read_flag");
					$db->values(array($divid,0,$sender,$msg,$time,1));// for sender(invited)
					$result=$db->query();


					$db->select("nesote_chat_session_users");
					$db->fields("user_id");
					$db->where("chat_id=? and active_status=? and user_id!=?", array($divid,1,$sender));
					$result=$db->query();$title1=$this->firstname($sender).",";$i=1;
					while($row=$db->fetchRow($result))
					{
						$title1.=$this->firstname($row[0]).",";$i++;
					}

					$title=substr($title1,0,-1);
					$title="(".$i.") ".$title;

					$length=strlen($title);
					if($length>12)
					$title=substr($title,0,12)."...";
					$img="iconsCornner chat-gp";
					$title="<img src=\"images/filler.gif\" border=\"0\" class=\"$img\">$title";

					$msg=str_replace("\n","<br>",$msg);
					echo $msg."+*+".$divid."+*+".$title;exit;


				}
			}
			$sender=$this->getId();

			//$msg=str_replace("\n","<br>",$msg);

			$time=time();
			$time=$this->settime($time);

			$db->insert("nesote_chat_temporary_messages");
			$db->fields("chat_id,sender,responders,message,time,read_flag");
			$db->values(array($divid,0,$sender,$msg,$time,0));
			//$result=$db->query();//echo $db->getQuery();
			//$msg=str_replace("\n","<br>",$msg);
			echo $msg."+*+".$divid."+*+".$title;exit;
		}
		else
		{
			$msg2=$this->getmessage(422);
			$msg2=str_replace("{user}","$user",$msg2);
			$msg1=$this->getmessage(423);
			$time=date("g:i A",time());
			$day=date("l",time());

			$msg1=str_replace("{time}","$time",$msg1);
			$msg1=str_replace("{day}","$day",$msg1);

			$msg="\n$msg2\n $msg1\n";
			//$msg=str_replace("\n","<br>",$msg);
			$msg=htmlspecialchars_decode($msg);$title="";


			$time=time();
			$time=$this->settime($time);
			$db->insert("nesote_chat_temporary_messages");
			$db->fields("chat_id,sender,responders,message,time,read_flag");
			$db->values(array($divid,0,$userid,$msg,$time,0));
			$result=$db->query();//echo $db->getQuery();

			echo $msg."+*+".$divid."+*+".$title;exit;
		}

	}



	function insertmessageAction()
	{
		$validateUser=$this->validateUser();

		if($validateUser!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

		$message=strip_tags($_POST['message']);//echo $message;exit;
		$chat_id=$_POST['divid'];

		$userid=$_POST['userid'];
		$sender=$userid;
		//$sender=$this->getId();

		$str="";

		$db=new NesoteDALController();



		if($message!="")
		{
			//$message=str_replace("\n","<br>",$message);

			$db->select("nesote_chat_users");
			$db->fields("chat_status,logout_status,signout");
			$db->where("userid=?",array($userid));
			$rs1=$db->query();//echo $db0->getQuery();
			$res=$db->fetchRow($rs1);


			$db->select("nesote_chat_session");
			$db->fields("group_status");
			$db->where("id=?",array($chat_id));
			$rs1=$db->query();//echo $db0->getQuery();
			$group_status=$db->fetchRow($rs1);
			if($group_status[0]==1)//group chat
			{
				$time=time();
				$time=$this->settime($time);

				if($res[0]==5 || $res[1]==1 || $res[2]==1)
				{

					$msg2=$this->getmessage(482);
					
					$msg2="<br><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif;  font-size: 12px;  color: #B40404;  text-align: left;\">$msg2</span>";
					$msg2=htmlspecialchars_decode($msg2);
					echo $msg2."+*+".$chat_id."+*+".$group_status[0];exit;
				}

				$db->insert("nesote_chat_temporary_messages");
				$db->fields("chat_id,sender,responders,message,time,read_flag");
				$db->values(array($chat_id,$sender,$sender,$message,$time,1));
				$db->query();//echo $db->getQuery();exit;


				$db1=new NesoteDALController();
				$db1->select("nesote_chat_session_users");
				$db1->fields("user_id");
				$db1->where("chat_id=? and active_status=? and user_id!=?",array($chat_id,1,$sender));
				$rs1=$db1->query();
				while($row1=$db1->fetchRow($rs1))
				{

					$receiver=$row1[0];
					$db->insert("nesote_chat_temporary_messages");
					$db->fields("chat_id,sender,responders,message,time,read_flag");
					$db->values(array($chat_id,$sender,$row1[0],$message,$time,0));
					$db->query();//echo $db->getQuery();


				}

				//echo "";exit;
				//echo $str."+*+".$chat_id."+*+".$group_status[0];exit;


			}
			else //single chat
			{


				$db->select("nesote_chat_session_users");
				$db->fields("user_id");
				$db->where("chat_id=? and user_id!=?",array($chat_id,$sender));
				$rs1=$db->query();//echo $db->getQuery();
				$row1=$db->fetchRow($rs1);

				$receiver=$row1[0];//echo $chat_id."111+*+".$chat_id."+*+".$group_status[0];exit;
				if($res[0]==5 || $res[1]==1 || $res[2]==1)
				{
					$msg2=$this->getmessage(481);
					$firstname=$this->firstname($receiver);
					$msg2=str_replace("{firstname}","$firstname",$msg2);
					$msg2="<br><span style=\"font-family:Verdana, Arial, Helvetica, sans-serif;  font-size: 12px;  color: #B40404;  text-align: left;\">$msg2</span>";
					$msg2=htmlspecialchars_decode($msg2);
					echo $msg2."+*+".$chat_id."+*+".$group_status[0];exit;
				}
				$time=time();
				$time=$this->settime($time);


				$db->insert("nesote_chat_temporary_messages");
				$db->fields("chat_id,sender,responders,message,time,read_flag");
				$db->values(array($chat_id,$sender,$row1[0],$message,$time,0));
				$result=$db->query();
				$last=$db->lastInsertid("nesote_chat_temporary_messages");

				$db->update("nesote_chat_session_users");
				$db->set("typing_status=?,present_identified_time=?",array(0,time()));
				$db->where("chat_id=? and user_id=?",array($chat_id,$sender));
				$db->query();

				$earlyid=$sender;

				//echo $str."+*+".$chat_id."+*+".$group_status[0];exit;
			}

			$db->update("nesote_chat_session_users");
			$db->set("typing_status=?",5);
			$db->where("chat_id=? and user_id=?",array($chat_id,$sender));
			$db->query();//echo $db10->getQuery();exit;
				
			echo "";exit;
		}

	}

	function getusername($id)
	{
		$validateUser=$this->validateUser();

		if($validateUser!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

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
	function insertsessionAction()
	{

		$validateUser=$this->validateUser();

		if($validateUser!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

		$userid=$this->getParam(1);//echo $userid;exit;
		$chatcnt=$this->getParam(3);//echo $prevmsg;
		$sender=$this->getId();$msg="";//echo $sender;


		$db=new NesoteDALController();
		$uid=$this->getId();

		$db->select("nesote_chat_users");
		$db->fields("chat_status,logout_status,signout");
		$db->where("userid=?",$uid);
		$rest=$db->query();
		$rrr=$db->fetchRow($rest);
		if($rrr[0]==5 || $rrr[1]==1 || $rrr[2]==1)
		{
			echo "signout";exit;}

			$db00=new NesoteDALController();
			$db00->select("nesote_chat_session");
			$db00->fields("id");
			$db00->where("group_status=?",0);
			$rs1=$db00->query();//echo $db->getQuery();exit;
			$no=$db00->numRows($rs1);
			$insertflag=0;//echo $no;
			if($no!=0)
			{
				while($row1=$db00->fetchRow($rs1))
				{

					$tot1=$db->total("nesote_chat_session_users","chat_id=? and user_id=?",array($row1[0],$sender));//echo $db->getQuery()."/";
					$tot2=$db->total("nesote_chat_session_users","chat_id=? and user_id=?",array($row1[0],$userid));//echo $db->getQuery()."/";


					if(($tot1>0) && ($tot2>0))
					{
						$chat_id=$row1[0];


						$db->update("nesote_chat_session_users");
						$db->set("active_status=?,present_identified_time=?",array(1,time()));
						$db->where("chat_id=? and user_id=?",array($chat_id,$sender));
						$db->query();//echo $db02->getQuery();


						$db->select("nesote_chat_session_users");
						$db->fields("active_status");
						$db->where("chat_id=? and user_id=?",array($chat_id,$userid));
						$rs10=$db->query();
						$rr=$db->fetchRow($rs10);//echo $rr[0];


						$db->update("nesote_chat_session_users");
						$db->set("active_status=?",array($rr[0]));
						$db->where("chat_id=? and user_id=?",array($chat_id,$userid));
						$db->query();//echo $db01->getQuery();

						$insertflag=1;
						break;
					}
				}
				if($insertflag==0)
				{

					$db->insert("nesote_chat_session");
					$db->fields("time,xml_status,group_status");
					$db->values(array(time(),0,0));
					$db->query();//echo $db03->getQuery();
					$last=$db->lastInsertid("nesote_chat_session");
					$chat_id=$last;
					$time=time();

					$db->insert("nesote_chat_session_users");
					$db->fields("chat_id,user_id,time,xml_status,typing_status,active_status,present_identified_time,initiators");
					$db->values(array($last,$sender,$time,0,0,1,$time,$sender));
					$db->query();//echo $db04->getQuery();

					$db->insert("nesote_chat_session_users");
					$db->fields("chat_id,user_id,time,xml_status,typing_status,active_status,present_identified_time,initiators");
					$db->values(array($last,$userid,$time,0,0,0,$time,$sender));
					$db->query();//echo $db05->getQuery();


				}

				/*******************/
					
//				$db->select(array("u"=>"nesote_users","c"=>"nesote_chat_users"));
//				$db->fields("c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.id,u.username,u.password,u.firstname,u.lastname,u.sex,u.dateofbirth,u.country,u.remember_question,u.remember_answer,u.createdtime,u.lastlogin,u.status,u.memorysize,u.server_password,u.time_zone,u.alternate_email,u.smtp_username,c.signout");
//				$db->where("u.id=? and u.id=c.userid",$userid);
				
//				$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users","s"=>"nesote_email_usersettings"));
//				$db->fields("c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.id,u.username,u.password,u.name,s.sex,s.dateofbirth,s.country,s.remember_question,s.remember_answer,u.joindate,s.lastlogin,u.status,s.memorysize,s.server_password,s.time_zone,s.alternate_email,s.smtp_username,c.signout");
//				$db->where("u.id=? and u.id=c.userid and u.id=s.userid",$userid);
				
				
				$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users"));
				$db->fields("c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.id,u.name,c.signout");
				$db->where("u.id=? and u.id=c.userid ",$userid);
				
				$result=$db->query();
				$result1=$db->fetchRow($result);$msg="";

				$firstname=$result1[10];

				if($result1[4]==1 || $result1[11]==1 || $result1[5]==5) // logout // signout // offline
				{
					$msg=$this->getmessage(418);
					$msg=str_replace("{firstname}",$firstname,$msg);

					$msg="\n$msg";
					$msg=htmlspecialchars_decode($msg);

				}
				else if($result1[5]==2) //busy
				{
					$msg=$this->getmessage(419);
					$msg=str_replace("{firstname}","$firstname",$msg);
					$msg="\n$msg";
					$msg=htmlspecialchars_decode($msg);

				}
				else if($result1[5]==4) //invisible
				{
					$msg=$this->getmessage(418);
					$msg=str_replace("{firstname}",$firstname,$msg);

					$msg="\n$msg";
					$msg=htmlspecialchars_decode($msg);
				}
				$msg=str_replace("\n","<br>",$msg);

				//$name=$result1[12]." ".$result1[13];
                 $name=$result1[10];
				$img="";
				if($result1[4]==1 || $result1[11]==1 || $result1[5]==5)
				$img="iconsCornner chat-o";
				else if($result1[8]==1)
				$img="iconsCornner chat-i";
				else if($result1[5]==1)
				$img="iconsCornner chat-a";
				elseif($result1[5]==2)
				$img="iconsCornner chat-b";
				elseif($result1[5]==3)
				$img="iconsCornner chat-i";
				elseif($result1[5]==4)
				$img="iconsCornner chat-o";

				$length=strlen($name);
				if($length>12)
				$name=substr($name,0,12)."...";


				$st="<img src=\"images/filler.gif\" class=\"$img\" border=\"0\" align=\"absmiddle\">$name";

				/********************/


				$group_status=0;

				$db->select("nesote_chat_session_users");
				$db->fields("chat_id");
				$db->where("active_status=? and user_id=?",array(1,$sender));
				$db->order("present_identified_time desc");
				$db->limit(0,$chatcnt);
				$rs11=$db->query();
				$nn=$db->numRows($rs11);$usrids="";
				while($row11=$db->fetchRow($rs11))
				{
					$ids.=$row11[0].",";
				}
			

				$db->select("nesote_chat_session_users");
				$db->fields("user_id");
				$db->where("active_status=? and user_id!=?",array(1,$sender));
				$db->order("present_identified_time desc");
				$db->limit(0,$chatcnt);
				$rs11=$db->query();
				while($row11=$db->fetchRow($rs11))
				{
					$usrids.=$row11[0].",";
				}
				$ids=substr($ids,0,-1);$usrids=substr($usrids,0,-1);


				echo $chat_id."+*+".$group_status."+*+".$userid."+*+".$st."+*+".$ids."+*+".$msg."+*+".$usrids;exit;
			}
			else
			{

				$db->insert("nesote_chat_session");
				$db->fields("time,xml_status,group_status");
				$db->values(array(time(),0,0));
				$db->query();//echo $db1->getQuery();
				$last=$db->lastInsertid("nesote_chat_session");
				$chat_id=$last;//echo $chat_id;
				$time=time();

				$db->insert("nesote_chat_session_users");
				$db->fields("chat_id,user_id,time,xml_status,typing_status,active_status,present_identified_time,initiators");
				$db->values(array($last,$sender,$time,0,0,1,$time,$sender));
				$db->query(); //echo $db2->getQuery();

				$db->insert("nesote_chat_session_users");
				$db->fields("chat_id,user_id,time,xml_status,typing_status,active_status,present_identified_time,initiators");
				$db->values(array($last,$userid,$time,0,0,0,$time,$sender));
				$db->query(); //echo $db3->getQuery();//exit;



				/********************/


//				$db->select(array("u"=>"nesote_users","c"=>"nesote_chat_users"));
//				$db->fields("c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.id,u.username,u.password,u.firstname,u.lastname,u.sex,u.dateofbirth,u.country,u.remember_question,u.remember_answer,u.createdtime,u.lastlogin,u.status,u.memorysize,u.server_password,u.time_zone,u.alternate_email,u.smtp_username,c.signout");
//				$db->where("u.id=? and u.id=c.userid",$userid);
				
//				$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users","s"=>"nesote_email_usersettings"));
//				$db->fields("c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.id,u.username,u.password,u.name,s.sex,s.dateofbirth,s.country,s.remember_question,s.remember_answer,u.joindate,s.lastlogin,u.status,s.memorysize,s.server_password,s.time_zone,s.alternate_email,s.smtp_username,c.signout");
//				$db->where("u.id=? and u.id=c.userid and u.id=s.userid",$userid);
				
				$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users"));
				$db->fields("c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.id,u.name,c.signout");
				$db->where("u.id=? and u.id=c.userid ",$userid);
				
				
				$result=$db->query();
				$result1=$db->fetchRow($result);$msg="";$firstname=$result1[10];

				if($result1[4]==1 || $result1[11]==1 || $result1[5]==5) // logout // signout // offline
				{
					$msg=$this->getmessage(418);
					$msg=str_replace("{firstname}",$firstname,$msg);

					$msg="\n$msg";
					$msg=htmlspecialchars_decode($msg);

				}
				else if($result1[5]==2) //busy
				{
					$msg=$this->getmessage(419);
					$msg=str_replace("{firstname}","$firstname",$msg);
					$msg="\n$msg";
					$msg=htmlspecialchars_decode($msg);

				}
				else if($result1[5]==4) //invisible
				{
					$msg=$this->getmessage(418);
					$msg=str_replace("{firstname}",$firstname,$msg);

					$msg="\n$msg";
					$msg=htmlspecialchars_decode($msg);
				}
				$msg=str_replace("\n","<br>",$msg);
				//$name=$result1[12]." ".$result1[13];
                  $name=$result1[10];
				$img="";
				if($result1[4]==1 || $result1[11]==1 || $result1[5]==5)
				$img="iconsCornner chat-o";
				else if($result1[8]==1)
				$img="iconsCornner chat-i";
				else if($result1[5]==1)
				$img="iconsCornner chat-a";
				elseif($result1[5]==2)
				$img="iconsCornner chat-b";
				elseif($result1[5]==3)
				$img="iconsCornner chat-i";
				elseif($result1[5]==4)
				$img="iconsCornner chat-o";

				$length=strlen($name);
				if($length>12)
				$name=substr($name,0,12)."...";


				$st="<img src=\"images/filler.gif\" class=\"$img\" border=\"0\" align=\"absmiddle\">$name";

				/********************/

				$group_status=0;

				$db->select("nesote_chat_session_users");
				$db->fields("chat_id");
				$db->where("active_status=? and user_id=?",array(1,$sender));
				$db->order("present_identified_time desc");
				$db->limit(0,$chatcnt);
				$rs11=$db->query();
				$nn=$db->numRows($rs11);$usrids="";
				while($row11=$db->fetchRow($rs11))
				{
					$ids.=$row11[0].",";
				}

				$db->select("nesote_chat_session_users");
				$db->fields("user_id");
				$db->where("active_status=? and user_id!=?",array(1,$sender));
				$db->order("present_identified_time desc");
				$db->limit(0,$chatcnt);
				$rs11=$db->query();
				$nn=$db->numRows($rs11);$usrids="";
				while($row11=$db->fetchRow($rs11))
				{
					$usrids.=$row11[0].",";
				}

				$ids=substr($ids,0,-1);$usrids=substr($usrids,0,-1);

				echo $chat_id."+*+".$group_status."+*+".$userid."+*+".$st."+*+".$ids."+*+".$msg."+*+".$usrids;exit;
			}

	}
	function lookupmessageAction()
	{
		$validateUser=$this->validateUser();

		if($validateUser!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

		$chat_id=$_POST['divid'];
		$prevmsg=$_POST['prevmsg'];
		$userid=$_POST['userid'];
		$db=new NesoteDALController();
		$sender=$this->getId();
		if($prevmsg!="")//ie existed chat box
		{

			$db->select("nesote_chat_temporary_messages");
			$db->fields("message,responders,time,sender");
			$db->where("((sender=?) or (responders=?) or (sender=? and responders=?)) and chat_id=? and read_flag=?",array($sender,$sender,0,$sender,$chat_id,0));
			$db->order("id asc");
			$rs1=$db->query();$str="";$i=0;$m=0;

			while($row=$db->fetchRow($rs1))
			{

				$message=htmlentities($row[0],ENT_NOQUOTES, 'UTF-8');
				$message=str_replace("e0d71f32e332df0bf09e2f879dd14d77","&nbsp;",$message);
				if($row[3]==0)
				{
					$user="";
					$str1=$message;//$str1=htmlentities($str1);//$str1=htmlspecialchars_decode($str1);
				}
				else
				{
					if($row[3]==$sender)
					{
						$i++;$me=$this->getmessage(284);
						$user="<div class='newsmi'><div id=\"mediv\"><img height='32px' width='32px' src=".$this->getuserimage($sender)."></div><div id='newdiv'><b>".$me.": </b>";
						
						//$user="<b>$me:  </b>";
					}
					else
					{
						//$user="<b>".$this->gettitlename($row[3]).":  </b>";
						$user="<div class='newsmir'><div id=\"otherdiv\"><img height='32px' width='32px' src=".$this->getuserimage($row[3])."></div><div id='newdiv_other'><b>".$this->gettitlename($row[3]).": </b>";
						

					}

					$str1="\n".$user.$message."</div></div>";




				}
				$str.=$str1;$m++;
			}

			$str=str_replace("\n","<br>",$str);

				

			/*Smiley*/

			$getsmileyvalue=$this->getsmileyvalue();
			if($getsmileyvalue==1)
			{
				$str=str_ireplace(":)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-1\">",$str);
				$str=str_ireplace(":(","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-2\">",$str);
				$str=str_ireplace(":d","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-3\">",$str);
				$str=str_ireplace(":P","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-4\">",$str);
				$str=str_ireplace("(*)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-5\">",$str);
				$str=str_ireplace("(-)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-6\">",$str);
				$str=str_ireplace(":|","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-7\">",$str);
				$str=str_ireplace("(;","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-8\">",$str);
				$str=str_ireplace(":-*","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-9\">",$str);
				$str=str_ireplace(":-v","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-10\">",$str);
				$str=str_ireplace(":*)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-11\">",$str);
				$str=str_ireplace("B-)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-12\">",$str);
				$str=str_ireplace("x-(","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-13\">",$str);
				$str=str_ireplace(":*B","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-14\">",$str);
				$str=str_ireplace("*:A","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-15\">",$str);
				$str=str_ireplace(":-$","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-16\">",$str);
				//$str=str_ireplace(":-^","<img src=\"smile/17.gif\" border=\"0\">",$str);
				//$str=str_ireplace(":-!","<img src=\"smile/18.gif\" border=\"0\">",$str);
				//$str=str_ireplace(":-D","<img src=\"smile/19.gif\" border=\"0\">",$str);
				//$str=str_ireplace(":X","<img src=\"smile/20.gif\" border=\"0\">",$str);
				//$str=str_ireplace(":=)","<img src=\"smile/21.gif\" border=\"0\">",$str);
				//$str=str_ireplace("?=)","<img src=\"smile/22.gif\" border=\"0\">",$str);
				//$str=str_ireplace(":-o","<img src=\"smile/23.gif\" border=\"0\">",$str);
				//$str=str_ireplace(":-Z","<img src=\"smile/24.gif\" border=\"0\">",$str);
			}
			echo $str."+*+".$chat_id."+*+".$userid;exit;
		}

		else//new chatbox
		{

			$db->select("nesote_chat_temporary_messages");
			$db->fields("message,responders,time,sender");
			$db->where("((sender=?) or (responders=?) or (sender=? and responders=?)) and chat_id=?",array($sender,$sender,0,$sender,$chat_id));
			$db->order("id asc");
			$rs1=$db->query();$str="";$i=0;$m=0;

			while($row=$db->fetchRow($rs1))
			{
				$message=htmlentities($row[0],ENT_NOQUOTES, 'UTF-8');
				$message=str_replace("e0d71f32e332df0bf09e2f879dd14d77","&nbsp;",$message);
				if($row[3]==0)
				{
					$user="";
					$str1=$message;//$str1=htmlentities($str1);//$str1=htmlspecialchars_decode($str1);
				}
				else
				{
					if($row[3]==$sender)
					{
						$i++;$me=$this->getmessage(284);
						$user="<div class='newsmi'><div id=\"mediv\"><img height='32px' width='32px' src=".$this->getuserimage($sender)."></div><div id='newdiv'><b>$me:  </b>";
						
						//$user="<b>$me:  </b>";
					}
					else
					{
						$user="<div class='newsmir'><div id=\"otherdiv\"><img height='32px' width='32px' src=".$this->getuserimage($row[3])."></div><div id='newdiv_other'><b>".$this->gettitlename($row[3]).":  </b>";
						
						//$user="<b>".$this->gettitlename($row[3]).":  </b>";


					}
					$str1="\n".$user.$message."</div></div>";
						
				//	$str1="\n".$user.$message;


				}
				$str.=$str1;$m++;
			}

			$str=str_replace("\n","<br>",$str);//echo $str;
			/*Smiley*/
			$getsmileyvalue=$this->getsmileyvalue();
			if($getsmileyvalue==1)
			{
				$str=str_ireplace(":)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-1\">",$str);
				$str=str_ireplace(":(","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-2\">",$str);
				$str=str_ireplace(":d","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-3\">",$str);
				$str=str_ireplace(":P","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-4\">",$str);
				$str=str_ireplace("(*)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-5\">",$str);
				$str=str_ireplace("(-)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-6\">",$str);
				$str=str_ireplace(":|","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-7\">",$str);
				$str=str_ireplace("(;","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-8\">",$str);
				$str=str_ireplace(":-*","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-9\">",$str);
				$str=str_ireplace(":-v","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-10\">",$str);
				$str=str_ireplace(":*)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-11\">",$str);
				$str=str_ireplace("B-)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-12\">",$str);
				$str=str_ireplace("x-(","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-13\">",$str);
				$str=str_ireplace(":*B","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-14\">",$str);
				$str=str_ireplace("*:A","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-15\">",$str);
				$str=str_ireplace(":-$","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-16\">",$str);
				//$str=str_ireplace(":-^","<img src=\"smile/17.gif\" border=\"0\">",$str);
				//$str=str_ireplace(":-!","<img src=\"smile/18.gif\" border=\"0\">",$str);
				//$str=str_ireplace(":-D","<img src=\"smile/19.gif\" border=\"0\">",$str);
				//$str=str_ireplace(":X","<img src=\"smile/20.gif\" border=\"0\">",$str);
				//$str=str_ireplace(":=)","<img src=\"smile/21.gif\" border=\"0\">",$str);
				//$str=str_ireplace("?=)","<img src=\"smile/22.gif\" border=\"0\">",$str);
				//$str=str_ireplace(":-o","<img src=\"smile/23.gif\" border=\"0\">",$str);
				//$str=str_ireplace(":-Z","<img src=\"smile/24.gif\" border=\"0\">",$str);
			}
			echo $str."+*+".$chat_id."+*+".$userid;exit;
		}
	}
	function chatAction()
	{

		$username=$_COOKIE['e_username'];
		$cheat=$this->usercheck($username);
		if($cheat==0)
		{

			header("Location:".$this->url("index/index"));
			exit;
		}
		else

		{

			$this->setValue("loginuserid",$this->getId());

			$uid=$this->getId();
			$userimagepic=$this->getuserimage($uid);
			$this->setValue("userimagepic",$userimagepic);
			$db=new NesoteDALController();

//			$db->select(array("u"=>"nesote_users","c"=>"nesote_chat_users"));
//			$db->fields("c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.id,u.username,u.password,u.firstname,u.lastname,u.sex,u.dateofbirth,u.country,u.remember_question,u.remember_answer,u.createdtime,u.lastlogin,u.status,u.memorysize,u.server_password,u.time_zone,u.alternate_email,u.smtp_username,c.signout");
//			$db->where("u.id=? and u.id=c.userid",$uid);
//			$result=$db->query();
			
//			$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users","s"=>"nesote_email_usersettings"));
//			$db->fields("c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.id,u.username,u.password,u.name,s.sex,s.dateofbirth,s.country,s.remember_question,s.remember_answer,u.joindate,s.lastlogin,u.status,s.memorysize,s.server_password,s.time_zone,s.alternate_email,s.smtp_username,c.signout");
//			$db->where("u.id=? and u.id=c.userid and u.id=s.userid",$userid);
//          $result=$db->query();
            
            $db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users"));
			$db->fields("c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.id,u.name,c.signout");
			$db->where("u.id=? and u.id=c.userid ",$uid);
            $result=$db->query();//echo $db->getQuery();
                
			$result1=$db->fetchRow($result);

			$this->setValue("id",$result1[9]);
			$this->setValue("fname",ucfirst ($result1[10]));
			$this->setValue("lname"," ");
			$this->setValue("image",$result1[2]);
			$this->setValue("status",$result1[3]);
			$this->setValue("logout_status",$result1[4]);
			$this->setValue("signout",$result1[11]);
			$img="";$chval="";

			if($result1[11]==1 || $result1[4]==1 || $result1[5]==5)
			{$img="iconsCornner chat-o";$chval=4;}
			else if($result1[8]==1)
			{$img="iconsCornner chat-i";$chval=3;}
			else if($result1[5]==1)
			{$img="iconsCornner chat-a";$chval=1; }
			else if($result1[5]==2)
			{$img="iconsCornner chat-b";$chval=2;}
			else if($result1[5]==3)
			{$img="iconsCornner chat-i";$chval=3;}
			else if($result1[5]==4)
			{$img="iconsCornner chat-o";$chval=4;}


			$this->setValue("chatstatus",$img);
			$this->setValue("chval",$chval);


			$userid=$this->getId();


			$db->select("nesote_chat_users");
			$db->fields("chatwindowsize");
			$db->where("userid=?",array($userid));
			$res=$db->query();
			$row=$db->fetchRow($res);
			$default=$row[0];
			if($default==0)
			{

				$db->select("nesote_chat_settings");
				$db->fields("value");
				$db->where("name=?",deafault_chatwindow_size);
				$res=$db->query();
				$row=$db->fetchRow($res);
				$default=$row[0];
				if($default==0)
				$default=3;
			}

			$db->select("nesote_chatwindow_settings");
			$db->fields("id,name,width,height");
			$db->where("id=$default");
			$getdetials=$db->query();


			$getdetials1=$db->fetchRow($getdetials);
			$this->setValue("width",$getdetials1[2]);
			$this->setValue("height",$getdetials1[3]);



			$db->select("nesote_chatwindow_settings");
			$db->fields("*");
			$getdeals=$db->query();
			$this->setLoopValue("divdetials",$getdeals->getResult());

		}
	}
	function userstatuscheck()
	{

		$uid=$this->getId();
		$db=new NesoteDALController();

//		$db->select(array("u"=>"nesote_users","c"=>"nesote_chat_users"));
//		$db->fields("u.id,u.username,u.password,u.firstname,u.lastname,u.sex,u.dateofbirth,u.country,u.remember_question,u.remember_answer,u.createdtime,u.lastlogin,u.status,u.memorysize,u.server_password,u.time_zone,u.alternate_email,u.smtp_username,c.chat_status,c.logout_status,c.idle,c.signout");
//		$db->where("u.id=? and u.id=c.userid",$uid);
//		$result=$db->query();
		
		$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users"));
		$db->fields("u.id,u.name,c.chat_status,c.logout_status,c.idle,c.signout");
		$db->where("u.id=? and u.id=c.userid",$uid);
		$result=$db->query();
		

		
		$result1=$db->fetchRow($result);
		
		if($result1[5]==1 || $result1[3]==1 || $result1[2]==5)
		{$img="status-offline.png";}
		else if($result1[3]==1)
		{$img="status-offline.png";}
		else if($result1[4]==1)
		{$img="status-away.png";}
		else if($result1[2]==1)
		{$img="status_available.png"; }
		else if($result1[2]==2)
		{$img="status-busy.png";}
		else if($result1[2]==3)
		{$img="status-away.png";}
		else if($result1[2]==4)
		{$img="status-offline.png";}

		$uid=$this->getId();

		$db->select("nesote_chat_users");
		$db->fields("chat_status");
		$db->where("userid=?",$uid);
		$rest=$db->query();
		$rrr=$db->fetchRow($rest);

		if($rrr[0]==5)
		{$img="status-offline.png";}

		//$title=$result1[3]." ".$result1[4];
		$title=$result1[1];
		$length=strlen($title);
		if($length>12)
		$title=substr($title,0,12)."...";

		$chatimg="images/{$img}";
		return $chatimg."+*+".$title;
			



	}


	function newparserAction()
	{
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); 
		header("Content-type: text/xml");

		$username=$_COOKIE['e_username'];
		$cheat=$this->usercheck($username);
		if($cheat==0)
		{

			header("Location:".$this->url("index/index"));
			exit;
		}
		else
		{

			$time=time();
			$invitate="";$updationvalue=$this->getParam(1);
			$uid=$this->getParam(3);
           $db=new NesoteDALController();
			while(time()-$time<30)
			{
				
				$updation=$this->servertimeupdation($uid,$db);

				$off=$this->getmessage(418);$busy=$this->getmessage(419);


				//				$db->select("nesote_chat_users");
				//				$db->fields("chat_status,signout,logout_status");
				//				$db->where("userid=?",array($userid));
				//				$rs11=$db->query();
				//				$row11=$db->fetchRow($rs11);

				//				if($row11[0]!=5 && $row11[1]!=1 && $row11[2]!=1)  // activate
				//				{
				$db1=new NesoteDALController();

				$xml="";$version=1.0;$status="";$title="";
				$parsestring=$this->parsingnew($uid);
					$parsestring=base64_encode($parsestring);
				$updation=$this->servertimeupdation($uid,$db);
					
				$ajaxupdation=$this->ajaxupdation($updationvalue,$uid,$db1);

				$xml="<memberlist>";


				$db->select(array("u"=>"nesote_inoutscripts_users","c1"=>"nesote_chat_contact"));
				$db->fields("c1.id,u.username");
				$db->where("c1.sender=u.id and c1.receiver=? and c1.status=?",array($uid,0));
				$chatinvitation=$db->query();//echo $db->getQuery();
				$no=$db->numRows($chatinvitation);

				$no1=$no+1;


				while($chatinvitation1=$db->fetchRow($chatinvitation))

				{
					// 	print_r($chatinvitation1);
					if(($no!=0) && ($no<$no1))
					{

						$xml.="<member>";
						$xml.="<id>$chatinvitation1[0]</id>";
						$xml.="<uname>$chatinvitation1[1]</uname>";
						$xml.="<fname></fname>";
						$xml.="<logoutstatus></logoutstatus>";
						$xml.="<idle></idle>";
						$xml.="<chatstatus></chatstatus>";
						$xml.="<image></image>";
						$xml.="<custommessage></custommessage>";
						$xml.="<type>invite</type>";
						$xml.="<loopvariable></loopvariable>";
						$xml.="<contactstatus></contactstatus>";
						$xml.="<userimage></userimage>";
						$xml.="<fullname></fullname>";
						$xml.="<pstring></pstring>";
						$xml.="<signout></signout>";
						$xml.="<stmsg></stmsg>";
						$xml.="</member>";
					}
				}



//
//				$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users"));
//				$db->fields("u.id,u.username,u.password,u.firstname,u.lastname,u.sex,u.dateofbirth,u.country,u.remember_question,u.remember_answer,u.createdtime,u.lastlogin,u.status,u.memorysize,u.server_password,u.time_zone,u.alternate_email,u.smtp_username,c.chat_status,c.logout_status,c.idle,c.custom_message,c.image,c.signout");
//				$db->where("u.id=? and u.id=c.userid",$uid);
//				$result=$db->query();

				
				$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users"));
				$db->fields("u.id,u.name,c.chat_status,c.logout_status,c.idle,c.custom_message,c.image,c.signout");
				$db->where("u.id=? and u.id=c.userid",$uid);
				$result=$db->query();
$userid="";$title="";$img="";$status="";$p="";$chatimg="";$stmsg="";
				$result1=$db->fetchRow($result);
				if($result1[7]==1 || $result1[3]==1 || $result1[2]==5)
				{$chatimg="iconsCornner chat-o";}
				else if($result1[4]==1)
				{$chatimg="iconsCornner chat-i";}
				else if($result1[2]==1)
				{$chatimg="iconsCornner chat-a"; }
				else if($result1[2]==2)
				{$chatimg="iconsCornner chat-b";}
				else if($result1[2]==3)
				{$chatimg="iconsCornner chat-i";}
				else if($result1[2]==4)
				{$chatimg="iconsCornner chat-o";}

				$db->select("nesote_chat_users");
				$db->fields("chat_status,signout,logout_status");
				$db->where("userid=?",$uid);
				$rest=$db->query();
				$rrr=$db->fetchRow($rest);

				if($rrr[0]==5 || $rrr[1]==1 || $rrr[2]==1)
				{$chatimg="iconsCornner chat-o";}

				//$title=$result1[3]." ".$result1[4];
				
				$title=$result1[1];
				$title1=$title;
				$length=strlen($title);
				if($length>12)
				$title=substr($title,0,11)."...";

				if($result1[6]!="")
				$userimg="userdata/$result1[0]/$result1[6]";
				else
				$userimg="images/nophoto.gif";
//echo $chatimg;exit;
				//$chatimg="{$img}";
				
//$chatimg="<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"iconsCornner chat-a\">";

				$xml.="<member>";
				$xml.="<id>$uid</id>";
				$xml.="<uname>$username</uname>";
				$xml.="<fname>$title</fname>";
				$xml.="<logoutstatus>$result1[3]</logoutstatus>";
				$xml.="<idle>$result1[4]</idle>";
				$xml.="<chatstatus>$result1[2]</chatstatus>";
				$xml.="<image>$chatimg</image>";
				$xml.="<custommessage>$result1[5]</custommessage>";
				$xml.="<type>self</type>";
				$xml.="<loopvariable></loopvariable>";
				$xml.="<contactstatus></contactstatus>";
				$xml.="<userimage>$userimg</userimage>";
				$xml.="<fullname>$title1</fullname>";
				$xml.="<pstring></pstring>";
				$xml.="<signout>$result1[7]</signout>";
				$xml.="<stmsg></stmsg>";
				$xml.="</member>";




				//echo $parsestring=$this->parsingnew($uid);exit;

				$xml.="<member>";
				$xml.="<id></id>";
				$xml.="<uname></uname>";
				$xml.="<fname></fname>";
				$xml.="<logoutstatus></logoutstatus>";
				$xml.="<idle></idle>";
				$xml.="<chatstatus></chatstatus>";
				$xml.="<image></image>";
				$xml.="<custommessage></custommessage>";
				$xml.="<type>pstr</type>";
				$xml.="<loopvariable></loopvariable>";
				$xml.="<contactstatus></contactstatus>";
				$xml.="<userimage></userimage>";
				$xml.="<fullname></fullname>";
				$xml.="<pstring>$parsestring</pstring>";
				$xml.="<signout></signout>";
				$xml.="<stmsg></stmsg>";
				$xml.="</member>";




				$x="";

				$username=$_COOKIE['e_username'];//echo $username;

				/***********Available start**********/

				$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users","c1"=>"nesote_chat_contact"));
				$db->fields("u.id,c1.id,c1.sender,c1.receiver,c1.nickname,c1.status,c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.name,c.signout");
				$db->where("c1.receiver=u.id and u.id=c.userid and c1.sender=? and c.chat_status=? and  c1.status=? and c.logout_status=? and c.idle=?",array($uid,1,1,0,0));
				$db->order("u.name asc");
				$result=$db->query();
				$userid="";$title="";$img="";$status="";$p="";$chatimg="";$stmsg="";
				while($result1=$db->fetchRow($result))
				{


					$id=$result1[0];

					if($result1[5]==0)
					{

						$userid=$result1[0];
					}
					else
					{
						if($result1[16]==1 || $result1[10]==1 || $result1[11]==5)
						{$img="iconsCornner chat-o";$stmsg=str_replace("{firstname}",$result1[15],$off);}
						else if($result1[14]==1)
						{$img="iconsCornner chat-i";}
						else if($result1[11]==1)
						{$img="iconsCornner chat-a"; }
						else if($result1[11]==2)
						{$img="iconsCornner chat-b";$stmsg=str_replace("{firstname}",$result1[15],$busy);}
						else if($result1[11]==3)
						{$img="iconsCornner chat-i";}
						else if($result1[11]==4)
						{$img="iconsCornner chat-o";$stmsg=str_replace("{firstname}",$result1[15],$off);}



						$db1->select("nesote_chat_users");
						$db1->fields("logout_status,signout,logout_status");
						$db1->where("userid=?",$uid);
						$rest3=$db1->query();
						$rrr=$db1->fetchRow($rest3);

						if($rrr[0]==1 || $rrr[1]==1 || $rrr[2]==1)
						{$img="iconsCornner chat-o";}

						if($result1[8]!="")
						$chatimg="userdata/$result1[0]/$result1[8]";
						else
						$chatimg="images/nophoto.gif";



						$userid=$result1[7];

						//$title=$result1[15]." ".$result1[16];
						
						$title=$result1[15];
						$title1=$title;
						$length=strlen($title);
						if($length>12)
						$title=substr($title,0,11)."...";


						$status=$result1[9];
						//$status=substr($status,0,15);
						//$status=$this->makelink($status);
						$status=htmlentities($status,0,"UTF-8");
						//$status=$this->makelink($status);

						$status=nl2br($status);

					}
					$p++;


					$db1->select("nesote_chat_users");
					$db1->fields("lastupdatedtime");
					$db1->where("userid=?",$id);
					$result10=$db1->query();
					$row10=$db1->fetchRow($result10);
					$time1=time()-$row10[0];

					if($time1>90)	//Logout status
					{

						$db1->update("nesote_chat_session_users");
						$db1->set("active_status=?,typing_status=?",array(0,0));
						$db1->where("user_id=?",$id);
						$db1->query();//echo $db2->getQuery();


						$db1->update("nesote_chat_users");
						$db1->set("logout_status=?",1);
						$db1->where("userid=? and userid!=?",array($id,$uid));
						$db1->query();//echo $db3->getQuery();
					}
					else
					{

						$db1->update("nesote_chat_users");
						$db1->set("logout_status=?",0);
						$db1->where("userid=? and userid!=? and signout!=?",array($id,$uid,1));
						$db1->query();//echo $db3->getQuery();
					}

					$xml.="<member>";
					$xml.="<id>$userid</id>";
					$xml.="<uname>$result1[4]</uname>";
					$xml.="<fname>$title</fname>";
					$xml.="<logoutstatus>$result1[10]</logoutstatus>";
					$xml.="<idle>$result1[14]</idle>";
					$xml.="<chatstatus>$result1[11]</chatstatus>";
					$xml.="<image>$img</image>";
					$xml.="<custommessage>$status</custommessage>";
					$xml.="<type>list</type>";
					$xml.="<loopvariable>$p</loopvariable>";
					$xml.="<contactstatus>$result1[5]</contactstatus>";
					$xml.="<userimage>$chatimg</userimage>";
					$xml.="<fullname>$title1</fullname>";
					$xml.="<pstring></pstring>";
					$xml.="<signout>$result1[16]</signout>";
					$xml.="<stmsg>$stmsg</stmsg>";
					$xml.="</member>";

				}

				/***********Busy start**********/

				$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users","c1"=>"nesote_chat_contact"));
				$db->fields("u.id,c1.id,c1.sender,c1.receiver,c1.nickname,c1.status,c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.name,c.signout");
				//$db->where("c1.receiver=u.id and u.id=c.userid and c1.sender=?",array($uid));
				$db->where("c1.receiver=u.id and u.id=c.userid and c1.sender=? and c.chat_status=? and  c1.status=? and c.logout_status=? and c.idle=?",array($uid,2,1,0,0));
				$db->order("u.name asc");
				$result=$db->query();

				$userid="";$title="";$img="";$status="";$p="";$chatimg="";$stmsg="";
				while($result1=$db->fetchRow($result))
				{

					$id=$result1[0];

					if($result1[5]==0)
					{
						$userid=$result1[0];


					}
					else
					{
						if($result1[16]==1 || $result1[10]==1 || $result1[11]==5)
						{$img="iconsCornner chat-o";$stmsg=str_replace("{firstname}",$result1[15],$off);}
						else if($result1[14]==1)
						{$img="iconsCornner chat-i";}
						else if($result1[11]==1)
						{$img="iconsCornner chat-a";}
						else if($result1[11]==2)
						{$img="iconsCornner chat-b";$stmsg=str_replace("{firstname}",$result1[15],$busy);}
						else if($result1[11]==3)
						{$img="iconsCornner chat-i";}
						else if($result1[11]==4)
						{$img="iconsCornner chat-o";$stmsg=str_replace("{firstname}",$result1[15],$off);}

						$db1->select("nesote_chat_users");
						$db1->fields("logout_status,signout,logout_status");
						$db1->where("userid=?",$uid);
						$rest3=$db1->query();
						$rrr=$db1->fetchRow($rest3);

						if($rrr[0]==1 || $rrr[1]==1 || $rrr[2]==1)
						{$img="iconsCornner chat-o";}

						if($result1[8]!="")
						$chatimg="userdata/$result1[0]/$result1[8]";
						else
						$chatimg="images/nophoto.gif";

						$userid=$result1[7];

						//$title=$result1[15]." ".$result1[16];
						
						$title=$result1[15];
						$title1=$title;
						$length=strlen($title);
						if($length>12)
						$title=substr($title,0,11)."...";

						$status=$result1[9];
						//$status=substr($status,0,15);
						$status=htmlentities($status,0,"UTF-8");
						$status=nl2br($status);

					}
					$p++;



					$db1->select("nesote_chat_users");
					$db1->fields("lastupdatedtime");
					$db1->where("userid=?",$id);
					$result10=$db1->query();
					$row10=$db1->fetchRow($result10);
					$time1=time()-$row10[0];

					if($time1>90)	//Logout status
					{

						$db1->update("nesote_chat_session_users");
						$db1->set("active_status=?,typing_status=?",array(0,0));
						$db1->where("user_id=?",$id);
						$db1->query();//echo $db2->getQuery();


						$db1->update("nesote_chat_users");
						$db1->set("logout_status=?",1);
						$db1->where("userid=? and userid!=?",array($id,$uid));
						$db1->query();//echo $db->getQuery();
					}
					else
					{

						$db1->update("nesote_chat_users");
						$db1->set("logout_status=?",0);
						$db1->where("userid=? and userid!=? and signout!=?",array($id,$uid,1));
						$db1->query();//echo $db->getQuery();
					}


					$xml.="<member>";
					$xml.="<id>$userid</id>";
					$xml.="<uname>$result1[4]</uname>";
					$xml.="<fname>$title</fname>";
					$xml.="<logoutstatus>$result1[10]</logoutstatus>";
					$xml.="<idle>$result1[14]</idle>";
					$xml.="<chatstatus>$result1[11]</chatstatus>";
					$xml.="<image>$img</image>";
					$xml.="<custommessage>$status</custommessage>";
					$xml.="<type>list</type>";
					$xml.="<loopvariable>$p</loopvariable>";
					$xml.="<contactstatus>$result1[5]</contactstatus>";
					$xml.="<userimage>$chatimg</userimage>";
					$xml.="<fullname>$title1</fullname>";
					$xml.="<pstring></pstring>";
					$xml.="<signout>$result1[16]</signout>";
					$xml.="<stmsg>$stmsg</stmsg>";
					$xml.="</member>";
				}

				/***********Idle start**********/


				$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users","c1"=>"nesote_chat_contact"));
				$db->fields("u.id,c1.id,c1.sender,c1.receiver,c1.nickname,c1.status,c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.name,c.signout");
				//$db->where("c1.receiver=u.id and u.id=c.userid and c1.sender=?",array($uid));
				$db->where("c1.receiver=u.id and u.id=c.userid and c1.sender=? and  c1.status=? and c.logout_status=? and c.idle=?",array($uid,1,0,1));
				$db->order("u.name asc");
				$result=$db->query();
				$userid="";$title="";$img="";$status="";$p="";$chatimg="";$stmsg="";
				while($result1=$db->fetchRow($result))
				{

					$id=$result1[0];

					if($result1[5]==0)
					{

						$userid=$result1[0];


					}
					else
					{
						if($result1[16]==1 || $result1[10]==1 || $result1[11]==5)
						{$img="iconsCornner chat-o";$stmsg=str_replace("{firstname}",$result1[15],$off);}
						else if($result1[14]==1)
						{$img="iconsCornner chat-i";}
						else if($result1[11]==1)
						{$img="iconsCornner chat-a";}
						else if($result1[11]==2)
						{$img="iconsCornner chat-b";$stmsg=str_replace("{firstname}",$result1[15],$busy);}
						else if($result1[11]==3)
						{$img="iconsCornner chat-i";}
						else if($result1[11]==4)
						{$img="iconsCornner chat-o";$stmsg=str_replace("{firstname}",$result1[15],$off);}



						$db1->select("nesote_chat_users");
						$db1->fields("logout_status,signout,logout_status");
						$db1->where("userid=?",$uid);
						$rest3=$db1->query();
						$rrr=$db1->fetchRow($rest3);

						if($rrr[0]==1 || $rrr[1]==1 || $rrr[2]==1)
						{$img="iconsCornner chat-o";}

						if($result1[8]!="")
						$chatimg="userdata/$result1[0]/$result1[8]";
						else
						$chatimg="images/nophoto.gif";

						$userid=$result1[7];

						//$title=$result1[15]." ".$result1[16];
						
						$title=$result1[15];
						$title1=$title;
						$length=strlen($title);
						if($length>12)
						$title=substr($title,0,11)."...";

						$status=$result1[9];
						//$status=substr($status,0,15);
						$status=htmlentities($status,0,"UTF-8");
						$status=nl2br($status);

					}
					$p++;



					$db1->select("nesote_chat_users");
					$db1->fields("lastupdatedtime");
					$db1->where("userid=?",$id);
					$result10=$db1->query();
					$row10=$db1->fetchRow($result10);
					$time1=time()-$row10[0];

					if($time1>90)	//Logout status
					{

						$db1->update("nesote_chat_session_users");
						$db1->set("active_status=?,typing_status=?",array(0,0));
						$db1->where("user_id=?",$id);
						$db1->query();//echo $db2->getQuery();


						$db1->update("nesote_chat_users");
						$db1->set("logout_status=?",1);
						$db1->where("userid=? and userid!=?",array($id,$uid));
						$db1->query();//echo $db->getQuery();
					}
					else
					{

						$db1->update("nesote_chat_users");
						$db1->set("logout_status=?",0);
						$db1->where("userid=? and userid!=? and signout!=?",array($id,$uid,1));
						$db1->query();//echo $db->getQuery();
					}


					$xml.="<member>";
					$xml.="<id>$userid</id>";
					$xml.="<uname>$result1[4]</uname>";
					$xml.="<fname>$title</fname>";
					$xml.="<logoutstatus>$result1[10]</logoutstatus>";
					$xml.="<idle>$result1[14]</idle>";
					$xml.="<chatstatus>$result1[11]</chatstatus>";
					$xml.="<image>$img</image>";
					$xml.="<custommessage>$status</custommessage>";
					$xml.="<type>list</type>";
					$xml.="<loopvariable>$p</loopvariable>";
					$xml.="<contactstatus>$result1[5]</contactstatus>";
					$xml.="<userimage>$chatimg</userimage>";
					$xml.="<fullname>$title1</fullname>";
					$xml.="<pstring></pstring>";
					$xml.="<signout>$result1[16]</signout>";
					$xml.="<stmsg>$stmsg</stmsg>";
					$xml.="</member>";

				}

				/***********BOth offline and logout start**********/

				$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users","c1"=>"nesote_chat_contact"));
				$db->fields("u.id,c1.id,c1.sender,c1.receiver,c1.nickname,c1.status,c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.name,c.signout");
				//$db->where("c1.receiver=u.id and u.id=c.userid and c1.sender=?",array($uid));
				$db->where("c1.receiver=u.id and u.id=c.userid and c1.sender=? and (c.chat_status=? or c.chat_status=? or c.logout_status=?) and c1.status=?",array($uid,4,5,1,1));
				$db->order("u.name asc");
				$result=$db->query();
				$userid="";$title="";$img="";$status="";$p="";$chatimg="";$stmsg="";
				while($result1=$db->fetchRow($result))
				{

					$id=$result1[0];

					if($result1[5]==0)
					{

						$userid=$result1[0];


					}
					else
					{
						if($result1[16]==1 || $result1[10]==1 || $result1[11]==5)
						{$img="iconsCornner chat-o";$stmsg=str_replace("{firstname}",$result1[15],$off);}
						else if($result1[14]==1)
						{$img="iconsCornner chat-i";}
						else if($result1[11]==1)
						{$img="iconsCornner chat-a"; }
						else if($result1[11]==2)
						{$img="iconsCornner chat-b";$stmsg=str_replace("{firstname}",$result1[15],$busy);}
						else if($result1[11]==3)
						{$img="iconsCornner chat-i";}
						else if($result1[11]==4)
						{$img="iconsCornner chat-o";$stmsg=str_replace("{firstname}",$result1[15],$off);}



						$db1->select("nesote_chat_users");
						$db1->fields("logout_status,signout,logout_status");
						$db1->where("userid=?",$uid);
						$rest3=$db1->query();
						$rrr=$db1->fetchRow($rest3);

						if($rrr[0]==1 || $rrr[1]==1 || $rrr[2]==1)
						{$img="iconsCornner chat-o";}

						if($result1[8]!="")
						$chatimg="userdata/$result1[0]/$result1[8]";
						else
						$chatimg="images/nophoto.gif";

						$userid=$result1[7];

						//$title=$result1[15]." ".$result1[16];
						
						$title=$result1[15];
						$title1=$title;
						$length=strlen($title);
						if($length>12)
						$title=substr($title,0,11)."...";

						$status=$result1[9];
						//$status=substr($status,0,15);
						$status=htmlentities($status,0,"UTF-8");
						$status=nl2br($status);

					}
					$p++;



					$db1->select("nesote_chat_users");
					$db1->fields("lastupdatedtime");
					$db1->where("userid=?",$id);
					$result10=$db1->query();
					$row10=$db1->fetchRow($result10);
					$time1=time()-$row10[0];

					if($time1>90)	//Logout status
					{

						$db1->update("nesote_chat_session_users");
						$db1->set("active_status=?,typing_status=?",array(0,0));
						$db1->where("user_id=?",$id);
						$db1->query();//echo $db2->getQuery();


						$db1->update("nesote_chat_users");
						$db1->set("logout_status=?",1);
						$db1->where("userid=? and userid!=?",array($id,$uid));
						$db1->query();
						//echo $db3->getQuery();
					}
					else
					{

						$db1->update("nesote_chat_users");
						$db1->set("logout_status=?",0);
						$db1->where("userid=? and userid!=? and signout!=?",array($id,$uid,1));
						$db1->query();//
						//echo $db3->getQuery();
					}

					$xml.="<member>";
					$xml.="<id>$userid</id>";
					$xml.="<uname>$result1[4]</uname>";
					$xml.="<fname>$title</fname>";
					$xml.="<logoutstatus>$result1[10]</logoutstatus>";
					$xml.="<idle>$result1[14]</idle>";
					$xml.="<chatstatus>$result1[11]</chatstatus>";
					$xml.="<image>$img</image>";
					$xml.="<custommessage>$status</custommessage>";
					$xml.="<type>list</type>";
					$xml.="<loopvariable>$p</loopvariable>";
					$xml.="<contactstatus>$result1[5]</contactstatus>";
					$xml.="<userimage>$chatimg</userimage>";
					$xml.="<fullname>$title1</fullname>";
					$xml.="<pstring></pstring>";
					$xml.="<signout>$result1[16]</signout>";
					$xml.="<stmsg>$stmsg</stmsg>";
					$xml.="</member>";

				}

				/**************Invited start************/

				$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users","c1"=>"nesote_chat_contact"));
				$db->fields("u.id,c1.id,c1.sender,c1.receiver,c1.nickname,c1.status,c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.name,c.signout");
				//$db->where("c1.receiver=u.id and u.id=c.userid and c1.sender=?",array($uid));
				$db->where("c1.receiver=u.id and u.id=c.userid and c1.sender=? and c1.status=?",array($uid,0));
				$db->order("u.name asc");
				$result=$db->query();
				$userid="";$title="";$img="";$status="";$p="";$chatimg="";$stmsg="";
				while($result1=$db->fetchRow($result))
				{
						
					$id=$result1[0];

					if($result1[5]==0)
					{

						$userid=$result1[0];$title=$result1[15];$title1=$title;$length=strlen($title);
                        if($length>12)$title=substr($title,0,11)."...";
                        if($result1[8]!="")
						$chatimg="userdata/$result1[0]/$result1[8]";
						else
						$chatimg="images/nophoto.gif";


					}
					else
					{
						if($result1[16]==1 || $result1[10]==1 || $result1[11]==5)
						{$img="iconsCornner chat-o";$stmsg=str_replace("{firstname}",$result1[15],$off);}
						else if($result1[14]==1)
						{$img="iconsCornner chat-i";}
						else if($result1[11]==1)
						{$img="iconsCornner chat-a"; }
						else if($result1[11]==2)
						{$img="iconsCornner chat-b";$stmsg=str_replace("{firstname}",$result1[15],$off);}
						else if($result1[11]==3)
						{$img="iconsCornner chat-i";}
						else if($result1[11]==4)
						{$img="iconsCornner chat-o";$stmsg=str_replace("{firstname}",$result1[15],$off);}



						$db1->select("nesote_chat_users");
						$db1->fields("logout_status,signout,logout_status");
						$db1->where("userid=?",$uid);
						$rest3=$db1->query();
						$rrr=$db1->fetchRow($rest3);

						if($rrr[0]==1 || $rrr[1]==1 || $rrr[2]==1)
						{$img="iconsCornner chat-o";}

						if($result1[8]!="")
						$chatimg="userdata/$result1[0]/$result1[8]";
						else
						$chatimg="images/nophoto.gif";

						$userid=$result1[7];

						//$title=$result1[15]." ".$result1[16];
						
						$title=$result1[15];
						$title1=$title;
						$length=strlen($title);
						if($length>12)
						$title=substr($title,0,11)."...";

						$status=$result1[9];
						//$status=substr($status,0,15);
						$status=htmlentities($status,0,"UTF-8");
						$status=nl2br($status);

					}
					$p++;



					$db1->select("nesote_chat_users");
					$db1->fields("lastupdatedtime");
					$db1->where("userid=?",$id);
					$result10=$db1->query();
					$row10=$db1->fetchRow($result10);
					$time1=time()-$row10[0];

					if($time1>90)	//Logout status
					{

						$db1->update("nesote_chat_session_users");
						$db1->set("active_status=?,typing_status=?",array(0,0));
						$db1->where("user_id=?",$id);
						$db1->query();//echo $db2->getQuery();


						$db1->update("nesote_chat_users");
						$db1->set("logout_status=?",1);
						$db1->where("userid=? and userid!=?",array($id,$uid));
						$db1->query();//echo $db->getQuery();
					}
					else
					{

						$db1->update("nesote_chat_users");
						$db1->set("logout_status=?",0);
						$db1->where("userid=? and userid!=? and signout!=?",array($id,$uid,1));
						$db1->query();//echo $db->getQuery();
					}


					$xml.="<member>";
					$xml.="<id>$userid</id>";
					$xml.="<uname>$result1[4]</uname>";
					$xml.="<fname>$title</fname>";
					$xml.="<logoutstatus>$result1[10]</logoutstatus>";
					$xml.="<idle>$result1[14]</idle>";
					$xml.="<chatstatus>$result1[11]</chatstatus>";
					$xml.="<image>$img</image>";
					$xml.="<custommessage>$status</custommessage>";
					$xml.="<type>list</type>";
					$xml.="<loopvariable>$p</loopvariable>";
					$xml.="<contactstatus>$result1[5]</contactstatus>";
					$xml.="<userimage>$chatimg</userimage>";
					$xml.="<fullname>$title1</fullname>";
					$xml.="<pstring></pstring>";
					$xml.="<signout>$result1[16]</signout>";
					$xml.="<stmsg>$stmsg</stmsg>";
					$xml.="</member>";
				}

				$xml.="</memberlist>";
				echo $xml;
				exit;
				//				}
				//				else
				//				{
				//					usleep(2000000);
				//				}

				}
				echo "";exit;
			}
		}


		function invicheckAction()
		{
			$username=$_COOKIE['e_username'];
			$cheat=$this->usercheck($username);
			if($cheat==0)
			{

				header("Location:".$this->url("index/index"));
				exit;
			}
			else

			{
				$invitate="";$updationvalue=$this->getParam(1);

				$db=new NesoteDALController();

				$db->select("nesote_inoutscripts_users");
				$db->fields("id");
				$db->where("username=?",$username);
				$result=$db->query();
				$result1=$db->fetchRow($result);


				$db->select(array("u"=>"nesote_inoutscripts_users","c1"=>"nesote_chat_contact"));
				$db->fields("c1.id,u.username");
				$db->where("c1.sender=u.id and c1.receiver=? and c1.status=?",array($result1[0],0));
				$chatinvitation=$db->query();
				$no=$db->numRows($chatinvitation);
				//echo $db->getQuery();
				$no1=$no+1;
				//echo $no;

				while($chatinvitation1=$db->fetchRow($chatinvitation))

				{
					// 	print_r($chatinvitation1);
					if(($no!=0) && ($no<$no1))
					{
						$quote=$this->getmessage(374);$y=$this->getmessage(375);$n=$this->getmessage(376);
						$invitate.="
						<span style=\"font-size: 3mm\"><strong>$chatinvitation1[1]</strong> $quote </span>
						<table>
						<tr>
						<td><a><input type=\"button\" value=\"$y\"
						onclick=\"adding('1','$chatinvitation1[0]')\"></a></td>
						<td><a><input type=\"button\" value=\"$n\"
						onclick=\"adding('2','$chatinvitation1[0]')\"></a></td>
						</tr>
						</table>";


					}
				}

				$gettitle=$this->userstatuscheck();
				//$userstatuscheck=$gettitle;
				$updation=$this->servertimeupdation();
				$ajaxupdation=$this->ajaxupdation($updationvalue);
				echo $invitate."(?+?)".$gettitle;

				exit;

			}
		}


		function contactaddingAction()
		{
			$username=$_COOKIE['e_username'];

			$cheat=$this->usercheck($username);
			if($cheat==0)
			{

				header("Location:".$this->url("index/index"));
				exit;
			}
			else

			{


				$button=$this->getParam(1);
				$invitationid=$this->getParam(2);
				//		echo $invitationid;
				//		exit;

				$db=new NesoteDALController();
				if($button==1)
				{

					$db->update("nesote_chat_contact");
					$db->set("status=?",1);
					$db->where("id=?",$invitationid);
					$db->query();
					$db->select("nesote_chat_contact");
					$db->fields("*");
					$db->where("id=?",$invitationid);
					$get=$db->query();
					$get1=$db->fetchRow($get);
					//			print_r($get1);
					//			exit;
					$receiver=$get1[1];
					$senderid=$get1[2];

					$db->select("nesote_inoutscripts_users");
					$db->fields("username");
					$db->where("id=?",$receiver);
					$heat=$db->query();
					$heat1=$db->fetchRow($heat);
					$user=$heat1[0];

					
					$db->select("nesote_chat_contact");
					$db->fields("*");
					$db->where("sender=? and receiver=?",array($senderid,$receiver));
					$res=$db->query();
					$no=$db->numRows($res);
					if($no==0)
					{

						$db->insert("nesote_chat_contact");
						$db->fields("id,sender,receiver,nickname,status");
						$db->values(array('',$senderid,$receiver,$user,1));
						$res=$db->query();
					}
					exit;


				}
				else if($button==2)
				{


					$db->delete("nesote_chat_contact");
					$db->fields("*");
					$db->where("id=?",$invitationid);
					$db->query();



				}
			}
		}





		function listingAction()
		{
		if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); 
			$username=$_COOKIE['e_username'];

			$cheat=$this->usercheck($username);
			if($cheat==0)
			{

				header("Location:".$this->url("index/index"));
				exit;
			}
			else

			{
				$uid=$this->getId();

				$select=new NesoteDALController();
				$select->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users"));
				$select->fields("u.name,c.image,c.custom_message,c.logout_status,c.chat_status,c.idle,c.signout");
				$select->where("u.id=? and  u.id=c.userid",$uid);
				$meet=$select->query();
				$meet1=$select->fetchRow($meet);

				//$name=$meet1[0]." ".$meet1[1];
				$name=$meet1[0];
				$userfullname=$name;

				if($meet1[6]==1 ||$meet1[3]==1 || $meet1[4]==5)
				{$img="status-offline.png";}
				else if($meet1[5]==1)
				{$img="status-away.png";}
				else if($meet1[4]==1)
				{$img="status_available.png"; }
				else if($meet1[4]==2)
				{$img="status-busy.png";}
				else if($meet1[4]==3)
				{$img="status-away.png";}
				else if($meet1[4]==4)
				{$img="status-offline.png";}

				$cusmessage=$meet1[2];




				if($meet1[1]!="")
				$userimg="userdata/$uid/$meet1[1]";
				else
				$userimg="images/nophoto.gif";


				$this->setValue("self_userid",$uid);

				$this->setValue("self_img",$img);

				$this->setValue("self_title",$name);

				$this->setValue("self_cusmessage",$cusmessage);

				$this->setValue("self_uname",$username);

				$this->setValue("self_userimage",$userimg);

				$this->setValue("self_userfullname",$userfullname);




			}

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
		function statusupdateAction()
		{
			$username=$_COOKIE['e_username'];

			$cheat=$this->usercheck($username);
			if($cheat==0)
			{

				header("Location:".$this->url("index/index"));
				exit;
			}
			else

			{
				$db=new NesoteDALController();
				$h="";
				$newstatus=$this->getParam(1);
				$newstatus=trim($this->getParam(1));//echo $newstatus;exit;
				$flag=$this->getParam(2);
				$uid=$this->getId();
				$clickstatus=$this->getParam(3);//echo $clickstatus;exit;
				if($flag==1)
				{//if flag=1 then newstaus is the logoutstatus
					$chatstaus="";$sign="";

					if($newstatus==0)
					{
						//$sign=$this->getmessage(364);$chatstaus=1;


						$db->update("nesote_chat_users");
						if($clickstatus==7 || $clickstatus==8)
						$db->set("signout=?",array(1,1));
						else
						$db->set("custom_message=?,signout=?",array($h,1));
						$db->where("userid=?",$uid);
						$db->query();

					}
					else
					{
						//$sign=$this->getmessage(368);$chatstaus=0;


						$db->update("nesote_chat_users");
						if($clickstatus==7 || $clickstatus==8)
						$db->set("signout=?",array(0,0));
						else
						$db->set("custom_message=?,signout=?",array($h,0));
						$db->where("userid=?",$uid);
						$db->query();
					}

					if($clickstatus==0)
					{
						$db1=new NesoteDALController();
						$db->select(array("u"=>"nesote_chat_session","c"=>"nesote_chat_session_users"));
						$db->fields("distinct u.id");
						$db->where("u.id=c.chat_id and c.user_id=?",$uid);
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
								$fullname=$this->getname($uid);
								$msg=$this->getmessage(428);
								$msg=str_replace("{fullname}","$fullname",$msg);

								$message="\n $msg";
								//$message=str_replace("\n","<br>",$message);


								$db1->select("nesote_chat_session_users");
								$db1->fields("user_id");
								$db1->where("chat_id=? and active_status=? and user_id!=?",array($chat_id,1,$uid));
								$rs1=$db1->query();
								$time=time();
								$time=$this->settime($time);
								while($row1=$db1->fetchRow($rs1))
								{
									$db->insert("nesote_chat_temporary_messages");
									$db->fields("chat_id,sender,responders,message,time,read_flag");
									$db->values(array($chat_id,0,$row1[0],$message,$time,0));
									$result=$db->query();

								}

							}
						}
						
//						$db->update("nesote_chat_session_users");
//						$db->set("active_status=? and typing_status=?",array(0,0));
//						$db->where("user_id=?",array($uid));
						//$db->query();//echo $db->getQuery();exit;
					}

					echo "";exit;
				}





				$db->update("nesote_chat_users");
				if($clickstatus==7 || $clickstatus==8)
				$db->set("chat_status=?,signout=?",array($newstatus,0));
				else
				$db->set("chat_status=?,custom_message=?,signout=?",array($newstatus,$h,0));
				$db->where("userid=?",$uid);
				$db->query();//echo $db->getQuery();exit;


				echo "";exit;
			}


		}
		function customstatusAction()
		{


			$username=$_COOKIE['e_username'];

			$cheat=$this->usercheck($username);
			if($cheat==0)
			{

				header("Location:".$this->url("index/index"));
				exit;
			}
			else

			{
				$username=$_COOKIE['e_username'];

				$db= new NesoteDALController();


				$db->select("nesote_inoutscripts_users");
				$db->fields("id");
				$db->where("username=?",$username);
				$result=$db->query();
				$result1=$db->fetchRow($result);
				// print_r($result1);
				$customstatus=$_POST['b'];


				$db->update("nesote_chat_users");
				$db->set("custom_message=?",$customstatus);
				$db->where("userid=?",$result1[0]);
				$db->query();
				//echo $db->getQuery();exit;
				//		exit;
				$customstatus=substr($customstatus,0,15);
				$customstatus=htmlentities($customstatus,0,"UTF-8");
				//$customstatus=nl2br($customstatus);

				if($customstatus=="")
				{
					$meat.=$this->getmessage(373);

				}
				else
				{
					$meat.="$customstatus";

				}

				echo $meat."$*&*$".$customstatus;
				exit;
			}
		}
		function inviteAction()
		{
			$validateUser=$this->validateUser();

			if($validateUser!=TRUE)
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}

			$uid=$this->getId();

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

			$userinfo=$this->getParam(1);$invite=$this->getParam(2);//echo $invite;EXIT;
			$this->setValue("invite",$invite);


			$username=$_COOKIE['e_username'];

			$select->select("nesote_inoutscripts_users");
			$select->fields("id");
			$select->where("username=?",$username);
			$result=$select->query();
			$result1=$select->fetchRow($result);
			$this->setValue("id",$result1[0]);

			$memorymsg=$this->getmessage(351);
			$year=date("Y",time());
			$msg1=str_replace('{year}',$year,$memorymsg);
			$this->setValue("footer",$msg1);

		}
		function invitationsAction()
		{

			$username=$_COOKIE['e_username'];

			$cheat=$this->usercheck($username);
			if($cheat==0)
			{

				header("Location:".$this->url("index/index"));
				exit;
			}
			else

			{


				$username=$_COOKIE['e_username'];
				$emailids=$_POST['mailids'];
				//echo $emailids;
				//exit;

				$db=new NesoteDALController();

				$emailid=explode(",",$emailids);
				//print_r($emailid);
				for($i=0;$i<count($emailid);$i++)
				{
					$id[$i]=$emailid[$i];
					if($this->isValid($id[$i])==false)
					{
						echo $emailids;
						exit;

					}
					else
					{
						$upto=strpos($id[$i],"@");

						$user=substr($id[$i],0,$upto);


						$db->select("nesote_inoutscripts_users");
						$db->fields("id");
						$db->where("username=?",$user);
						$result=$db->query();
						$num=$db->numRows($result);
						if($num==0)
						{
							echo "invalid";
							exit;
						}
						$value1=explode("@",$id[$i]);
						$value2=$this->getextension();
						$value3="@".$value1[1];
						if($value2!=$value3)
						{
							echo "domain";
							exit;
						}

						$result1=$db->fetchRow($result);
						$receiver=$result1[0];

						if($username!=$value1[0])
						{


							$db->select("nesote_inoutscripts_users");
							$db->fields("id");
							$db->where("username=?",$username);
							$sender=$db->query();
							$sender1=$db->fetchRow($sender);
							$senderid=$sender1[0];


								
							$db->select("nesote_chat_contact");
							$db->fields("*");
							$db->where("sender=? and receiver=?",array($senderid,$receiver));
							$res=$db->query();
							$num=$db->numRows($res);
							if($num==0)
							{

								$db->insert("nesote_chat_contact");
								$db->fields("id,sender,receiver,nickname,status");
								$db->values(array('',$senderid,$receiver,$user,0));
								$res=$db->query();
							}
						}

					}
				}
				exit;
			}


		}
		function usercheck($username)
		{

			$db=new NesoteDALController();
			$db->select("nesote_inoutscripts_users");
			$db->fields("*");
			$db->where("username=?", array($username));
			$result=$db->query();
			$rno=$db->numRows($result);

			return $rno;

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
		function parsingnew($userid)
		{
			$username=$_COOKIE['e_username'];
			$cheat=$this->usercheck($username);
			if($cheat==0)
			{

				header("Location:".$this->url("index/index"));
				exit;
			}
			else

			{
				$db00=new NesoteDALController();
				$db00->select(array("n"=>"nesote_chat_session","n1"=>"nesote_chat_session_users"));
				$db00->fields("n.id,n1.active_status,n.group_status,n1.xml_status");
				$db00->where("n1.user_id=? and n.id=n1.chat_id ",$userid);
				$c1=$db00->query();

				$test=$db00->numRows($c1);

				if($test!=0)
				{
					$db1=new NesoteDALController();$db4=new NesoteDALController();$str="";$cnt=0;
					while($c2=$db00->fetchRow($c1))
					{


						if($c2[2]==0)
						{
							//******************************************"single chat";
							if($c2[1]==0)

							{

								//echo "inactive";exit;
								$db1->select("nesote_chat_session_users");
								$db1->fields("user_id,active_status,xml_status");
								$db1->where("chat_id=? and user_id!=?",array($c2[0],$userid));
								$j1=$db1->query();

								$j2=$db1->fetchRow($j1);
								$xactive=$j2[1];
								$xmlsta=$j2[2];

								if($xactive==0)
								{
									//echo "all are inactive";exit;
									$tablenumber=$this->tableid($username);
									$rexusername=$this->getusername($j2[0]);
									$rxtablenumber=$this->tableid($rexusername);
									$xml="";$version=1.0;

									$xml="<?xml version='".$version."' encoding='UTF-8'?>";


									$uid=$userid;

									$db1->select("nesote_chat_users");
									$db1->fields("chathistory");
									$db1->where("userid=?",$uid);
									$j10=$db1->query();
									$j20=$db1->fetchRow($j10);

									$db1->select("nesote_chat_users");
									$db1->fields("chathistory,logout_status,signout");
									$db1->where("userid=?",$j2[0]);
									$j10=$db1->query();
									$rxj=$db1->fetchRow($j10);

									if($rxj[1]==1 || $rxj[2]==1)
									$rxchstatus=1;
									else
									$rxchstatus=0;

									$sendr=0;$rexr=0;

									$db1->select("nesote_chat_temporary_messages");
									$db1->fields("*");
									$db1->where("chat_id=?",$c2[0]);
									$db1->order("id asc");
									$result=$db1->query();
									$msgcount=$db1->numRows($result);

									if($msgcount!=0)
									{
										$ll=0;$p="";
										//echo $j20[0]."/".$c2[3]."**".$rxj[0]."/".$xmlsta."/".$rxchstatus;exit;
										//echo $c2[3]."//".$rxj[0];exit;
										//echo $rxchstatus;exit;
										if($j20[0]==0 && $rxj[0]==0)
										{
											$rexr=1;$sendr=1;
										}
										else if(($j20[0]==1 && $c2[3]==0)||($rxj[0]==1 && $xmlsta==0 && $rxchstatus==1))
										{
											while($result1=$db1->fetchRow($result))
											{

												$receivers[$ll]=$result1[3];
												//$result1[5]=$this->gettimeforchat($result1[5]);

												$xml.="<item>";
												$xml.="<id>$c2[0]";
												$xml.="</id>";
												$xml.="<time>$result1[5]";
												$xml.="</time>";
												$xml.="<sender>$result1[2]";
												$xml.="</sender>";
												$xml.="<message>$result1[4]";
												$xml.="</message>";
												$xml.="</item>";

												$ll++;
											}
												

											$newarray=array_unique($receivers);

											$renumbers=count($receivers);

											for($mm=0;$mm<$renumbers;$mm++)
											{

												$reverslist=$newarray[$mm];

												if($reverslist!="")
												{

													$receverfools.=','.$reverslist;

												}
											}


											$t=time();
											$time1=$this->settime($t);
											if($j20[0]==1 && $c2[3]==0)
											{

												$db4->insert("nesote_chat_message_$tablenumber");
												$db4->fields("id,userid,chat_id,receivers,message,time,read_flag");
												$db4->values(array('',$userid,$c2[0],$receverfools,$xml,$time1,0));
												$db4->query();
												$last=$db4->lastInsertid("nesote_chat_message_$tablenumber");
												$p=$this->getparsedetail($last,$userid,$username,1);


												$db4->update("nesote_chat_session_users");
												$db4->set("xml_status=?",1);
												$db4->where("user_id=? and chat_id=?",array($userid,$c2[0]));
												$db4->query();$sendr=1;

											}
											if($rxj[0]==1 && $xmlsta==0 && $rxchstatus==1)
											{
												$db4->insert("nesote_chat_message_$rxtablenumber");
												$db4->fields("id,userid,chat_id,receivers,message,time,read_flag");
												$db4->values(array('',$j2[0],$c2[0],$receverfools,$xml,$time1,0));
												$db4->query();

												$last=$db4->lastInsertid("nesote_chat_message_$rxtablenumber");
												$p1=$this->getparsedetail($last,$j2[0],$rexusername,0);
												$xxx=explode("{nesote_t}",$p1);

												//$xxx[16]=str_replace("e0d71f32e332df0bf09e2f879dd14d77"," ",$xxx[16]);
												//$xxx[16]="<br><strong>These messages were sent while you were offline.</strong><br><br>".$xxx[16];
												
												$xxx[8]=str_replace("e0d71f32e332df0bf09e2f879dd14d77"," ",$xxx[8]);
												$xxx[8]="<br><strong>".$this->getmessage(487)."</strong><br><br>".strip_tags($xxx[8], "<img>")."<link rel='stylesheet' href='smileystyle.css' type='text/css' media='screen' />";
												
												
												//print_r($xxx);exit;
												$db4->select("nesote_email_inbox_$rxtablenumber");
												$db4->fields("id");
												$db4->order("id desc");
												$db4->limit(0,1);
												$result=$db4->query();
												$row=$db4->fetchRow($result);
												$last_sentid=$row[0];
												$var=time().$id.$last_sentid;
												$msg_id=md5($var).$this->getextension();
												$message_id="<".$msg_id.">";

												$db4->insert("nesote_email_inbox_$rxtablenumber");
												$db4->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id");
												$db4->values(array($j2[0],$xxx[13],$xxx[14],'','',$xxx[3],$xxx[8],$xxx[17],1,0,0,0,$message_id));
												$result2=$db4->query();
												$crnt_id=$db4->lastInsertid("nesote_email_inbox_$rxtablenumber");

												$references="<references><item><mailid>$crnt_id</mailid><folderid>1</folderid></item></references>";
												$md5references=md5($references);

												$db4->update("nesote_email_inbox_$rxtablenumber");
												$db4->set("mail_references=?,md5_references=?",array($references,$md5references));
												$db4->where("id=?",array($crnt_id));
												$db4->query();//echo $db4->getQuery();exit;

												$db4->update("nesote_chat_session_users");
												$db4->set("xml_status=?",1);
												$db4->where("user_id=? and chat_id=?",array($j2[0],$c2[0]));
												$db4->query();$rexr=1;
											}
										}
										else if($c2[3]==1 && $rxchstatus==1 && $rxj[0]==0)
										{
											$rexr=1;$sendr=1;
										}
									}

									if(($sendr==1 && $rexr==1)||($c2[3]==1 && $xmlsta==1) || $msgcount==0)
									{

										$db4->select("nesote_chat_session_users");
										$db4->fields("xml_status");
										$db4->where("chat_id=? and user_id=?",array($c2[0],$userid));
										$j5=$db4->query();//echo $db->getQuery();exit;

										$j6=$db4->fetchRow($j5);

										if($j6[0]==1 || $msgcount==0)
										{
											$db4->delete("nesote_chat_session_users");
											$db4->fields("*");
											$db4->where("chat_id=?",$c2[0]);
											$db4->query();

											$db4->delete("nesote_chat_temporary_messages");
											$db4->fields("*");
											$db4->where("chat_id=?",$c2[0]);
											$db4->query();

											$db4->delete("nesote_chat_session");
											$db4->fields("*");
											$db4->where("id=?",$c2[0]);
											$db4->query();
										}

									}
									if($p!="")
									{
										$str.=$p."{n_sep}";
										$cnt++;
									}
										

								}
								//							else {
								//								return ;
								//
								//							}

							}

							//						else
							//						{
							//
							//							return ;
							//							//exit;
							//
							//						}
						}
						else
						{

							//					******************************************	echo "group";
							if($c2[1]==0)

							{ //************************************ "user inactive";

								$tablenumber=$this->tableid($username);

								$xml="";$version=1.0;$k="";$k1="";

								$db4->select("nesote_chat_users");
								$db4->fields("chathistory,logout_status,signout");
								$db4->where("userid=?",$userid);
								$j40=$db4->query();
								$j41=$db4->fetchRow($j40);

								if($j41[0]==1)
								{
									$xml="<?xml version='".$version."' encoding='UTF-8'?>";


									$db4->select("nesote_chat_temporary_messages");
									$db4->fields("*");
									$db4->where("chat_id=? and (responders=? or (sender=? and responders=?))",array($c2[0],$userid,0,$userid));
									$db4->order("id asc");
									$result=$db4->query();

									$ll=0;
									while($result1=$db4->fetchRow($result))
									{
										if($result1[2]!=0)
										{
											$receivers[$ll]=$result1[2];
										}

										$xml.="<item>";
										$xml.="<id>$c2[0]";
										$xml.="</id>";
										$xml.="<time>$result1[5]";
										$xml.="</time>";
										$xml.="<sender>$result1[2]";
										$xml.="</sender>";
										$xml.="<message>$result1[4]";
										$xml.="</message>";
										$xml.="</item>";
										$ll++;


									}

									$newarray=array_unique($receivers);


									$renumbers=count($receivers);

									for($mm=0;$mm<$renumbers;$mm++)
									{
										$reverslist=$newarray[$mm];

										if($reverslist!="")
										{

											$receverfools.=','.$reverslist;

										}
									}
									$time=time();
									$time=$this->settime($time);
									$db1->insert("nesote_chat_message_$tablenumber");
									$db1->fields("id,userid,chat_id,receivers,message,time,read_flag");
									$db1->values(array('',$userid,$c2[0],$receverfools,$xml,$time,0));
									$db1->query();

									$last1=$db1->lastInsertid("nesote_chat_message_$tablenumber");
									$k=$this->getparsedetail($last1,$userid,$username,1);


									$db1->update("nesote_chat_session_users");
									$db1->set("xml_status=?",1);
									$db1->where("user_id=? and chat_id=?",array($userid,$c2[0]));
									$e1=$db1->query();
								}

								$db1->delete("nesote_chat_session_users");
								$db1->fields("*");
								$db1->where("user_id=? and chat_id=?",array($userid,$c2[0]));
								$db1->query();


								$db1->delete("nesote_chat_temporary_messages");
								$db1->fields("*");
								$db1->where("chat_id=? and responders=?",array($c2[0],$userid));
								$db1->query();

								$db1->select("nesote_chat_session_users");
								$db1->fields("*");
								$db1->where("chat_id=?",$c2[0]);
								$result=$db1->query();
								$no=$db1->numRows($result);
								if($no==0)
								{
									$db1->delete("nesote_chat_session");
									$db1->fields("*");
									$db1->where("id=?",$c2[0]);
									$db1->query();
								}


								if($k!="")
								{
									$str.=$k."{n_sep}";
									$cnt++;
								}
							}
						}
					}


					// no chat
					if($str!="")
					{
						$str=substr($str,0,-7);
						return $str."&&".$cnt;
					}
					else
					return ;
				}
				return ;

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
//		
		function tableid($username)
		{

			$user_name=$username;
			//					echo $user_name;
			//								exit;
			include("config.php");
			$number=$cluster_factor;
			//			echo $number;
			//			exit;
			$user_name=trim($user_name);

			$mdsuser_name=md5($user_name);


			$mdsuser_name=str_replace("a","",$mdsuser_name);
			$mdsuser_name=str_replace("b","",$mdsuser_name);
			$mdsuser_name=str_replace("c","",$mdsuser_name);
			$mdsuser_name=str_replace("d","",$mdsuser_name);
			$mdsuser_name=str_replace("e","",$mdsuser_name);
			$mdsuser_name=str_replace("f","",$mdsuser_name);
			//			echo $mdsuser_name;
			//			exit;


			$digits=substr($mdsuser_name,-6);
			//echo $digits."<br>";

			//			echo $digits;
			//			exit;

			$modlusnumber=$digits % $number;
			$modlusnumber=$modlusnumber+1;
			$numbers[$modlusnumber]++;


			return $modlusnumber;



		}
		function getshortdate($date)
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

				$lang_code=$settings->getValue("default_language");
				//$defaultlang_id=$lang_code;
				
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


		function getdetailsAction()
		{
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); 
		

			$validateUser=$this->validateUser();

			if($validateUser!=TRUE)
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}
			require("script.inc.php");
			include($config_path."database.default.config.php");
			$time=time();
			while(time()-$time<30)
			{
				set_time_limit(0);
				$db=new NesoteDALController();
				$db4=new NesoteDALController();

				$userid=$_POST['userid'];//echo $userid;

				$db->select("nesote_chat_users");
				$db->fields("chat_status,signout,logout_status");
				$db->where("userid=?",array($userid));
				$rs11=$db->query();
				$row11=$db->fetchRow($rs11);

				if($row11[0]!=5 && $row11[1]!=1 && $row11[2]!=1)  // offline
				{


					$ids=$_POST['arr'];$var="";$chatcnt=$_POST['chatcnt'];
					if($ids!="")
					{
						$chatids=substr($ids,0,-1);

						$var=" and u.id NOT IN($chatids)";
					}

					$open_ids=$chatids;$status="";$typestatus="";$st="";
						
					$close="";

					$db4->select(array("u"=>"nesote_chat_session","c"=>"nesote_chat_session_users"));
					$db4->fields("u.id");
					$db4->where("u.id=c.chat_id and c.user_id=? and c.active_status=? $var",array($userid,0));
					$meet0=$db4->query();
					$closed_ids="";
					while($meet10=$db4->fetchRow($meet0))
					{
						$closed_ids.=$meet10[0].",";
					}
					$closed_ids=substr($closed_ids,0,-1);$all_ids_1="";
					if($chatids!="")
					{
						$all_ids_1=$chatids.",";
					}

					$all_ids_1.=$closed_ids;
					$all_ids=explode(",",$all_ids_1);$str="";$j=0;$str2="";$h=0;



					$cnt=count($all_ids);
					if($all_ids[0]=="")
					{
						$cnt=0;
					}

					if($cnt==0)
					{

						$db4->select(array("u"=>"nesote_chat_session","c"=>"nesote_chat_session_users"));
						$db4->fields("u.id");
						$db4->where("u.id=c.chat_id and c.user_id=? and u.group_status=?",array($userid,1));
						$meet4=$db4->query();//echo $db3->getQuery();exit;
						$meet5=$db4->fetchRow($meet4);//echo hello;
						$all_ids[0]=$meet5[0];

						$close.=$all_ids[0].",";

					}
					for($i=0;$i<count($all_ids);$i++)
					{

						$dlt_ids="";
						$db4->select(array("u"=>"nesote_chat_session","c"=>"nesote_chat_session_users"));
						$db4->fields("u.id,c.active_status,u.group_status");
						$db4->where("u.id=c.chat_id and c.user_id=? and chat_id=?",array($userid,$all_ids[$i]));
						$meet=$db4->query();
						$meet1=$db4->fetchRow($meet);
						if($meet1[1]==0 && $meet1[2]==0) //closed    ...single chat closed
						{
							$db4->select("nesote_chat_temporary_messages");
							$db4->fields("id");
							$db4->where("(responders=? or (sender=? and responders=?)) and chat_id=? and read_flag=?",array($userid,0,$userid,$all_ids[$i],0));
							$db4->order("id asc");
							$rs1=$db4->query();
							$num=$db4->numRows($rs1);
							if($num>0)
							{

								$db4->select(array("u"=>"nesote_chat_temporary_messages","c"=>"nesote_chat_session_users"));
								$db4->fields("distinct u.chat_id");
								$db4->where("u.chat_id=c.chat_id and c.user_id=? and c.active_status=? and (responders=? or (sender=? and responders=?))",array($userid,0,$userid,0,$userid));
								$meet4=$db4->query();
								$meet4s=$db4->fetchRow($meet4);
								$num4=$db4->numRows($meet4);
								if($num4>0)
								$close.=$meet4s[0].",";
								$db->select("nesote_chat_temporary_messages");
								$db->fields("sender,message,id");
								$db->where("(responders=? or sender=? or (sender=? and responders=?)) and chat_id=? ",array($userid,$userid,0,$userid,$all_ids[$i]));
								//$db->where("chat_id=? and responders=?",array($all_ids[$i],$userid));
								$db->order("id asc");
								$rs2=$db->query();
								$no=$db->numRows($rs2);
							}
						}

						else if($meet1[1]==1 && $meet1[2]==1)// group chat opened
						{

							$db->select("nesote_chat_temporary_messages");
							$db->fields("sender,message,id");
							$db->where("chat_id=? and read_flag=? and (responders=? or (sender=? and responders=?))",array($all_ids[$i],0,$userid,0,$userid));
							$db->order("id asc");
							$rs2=$db->query();
							$num=$db->numRows($rs2);
						}
						else if($meet1[1]==1 && $meet1[2]==0)// single chat opened
						{
							$db->select("nesote_chat_temporary_messages");
							$db->fields("sender,message,id");
							$db->where("chat_id=? and read_flag=? and (responders=? or (sender=? and responders=?))",array($all_ids[$i],0,$userid,0,$userid));
							$db->order("id asc");
							$rs2=$db->query();//echo $db->getQuery();
							$num=$db->numRows($rs2);//echo $num."***";
						}

						if($num>0)
						{
							$uid=$this->getuserid($all_ids[$i]);
							$title=$this->lookupname($all_ids[$i],$uid);
							$db4->select("nesote_chat_session");
							$db4->fields("group_status");
							$db4->where("id=?",array($all_ids[$i]));
							$rs1=$db4->query();
							$groupstatus=$db4->fetchRow($rs1);
							$gpstatus=$groupstatus[0];
							$retvalue.=$all_ids[$i]."(&!~&)".$uid."(&!~&)".$title."(&!~&)".$gpstatus."(&!~&)";
							$str.=$retvalue;
							$m=0;
							$k1=0;
							$earlyid=$userid;
							while($row=$db->fetchRow($rs2))
							{
								$message=htmlentities($row[1],ENT_NOQUOTES, 'UTF-8');

								$message=str_replace("e0d71f32e332df0bf09e2f879dd14d77","&nbsp;",$message);
								$str1="";
								if($row[0]==0)
								{
									$user="";
									$str1=$message;//$str1=htmlentities($str1);//$str1=htmlspecialchars_decode($str1);

									$str.=$str1;
								}
								else
								{
									if($row[0]==$userid)
									{
										$j++;$me=$this->getmessage(284);
										$user="<div class='newsmi'><div id=\"mediv\"><img height='32px' width='32px' src=".$this->getuserimage($userid)."></div><div id='newdiv'><b>$me:  </b>";
									}
									else
									{
										$user="<div class='newsmir'><div id=\"otherdiv\"><img height='32px' width='32px' src=".$this->getuserimage($row[0])."></div><div id='newdiv_other'><b>".$this->gettitlename($row[0]).":  </b>";


									}
										$str1="\n".$user.$message."</div></div>";
										$str.=$str1;
								}
								$dlt_ids.=$row[2].",";
								$m++;
								$lastuser=$row[0];
							}
							$str.="(&!~&)".$lastuser;
							$str=str_replace("\n","<br>",$str);
							/*Smiley*/
							$getsmileyvalue=$this->getsmileyvalue();
							if($getsmileyvalue==1)
							{
								$str=str_ireplace(":)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-1\">",$str);
				$str=str_ireplace(":(","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-2\">",$str);
				$str=str_ireplace(":d","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-3\">",$str);
				$str=str_ireplace(":P","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-4\">",$str);
				$str=str_ireplace("(*)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-5\">",$str);
				$str=str_ireplace("(-)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-6\">",$str);
				$str=str_ireplace(":|","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-7\">",$str);
				$str=str_ireplace("(;","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-8\">",$str);
				$str=str_ireplace(":-*","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-9\">",$str);
				$str=str_ireplace(":-v","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-10\">",$str);
				$str=str_ireplace(":*)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-11\">",$str);
				$str=str_ireplace("B-)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-12\">",$str);
				$str=str_ireplace("x-(","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-13\">",$str);
				$str=str_ireplace(":*B","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-14\">",$str);
				$str=str_ireplace("*:A","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-15\">",$str);
				$str=str_ireplace(":-$","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-16\">",$str);
								
							}
							if($str!="")
							$str2.=$str."@{~}@";
							$dlt_ids=substr($dlt_ids,0,-1);

							mysqli_query($conn,"UPDATE  `".$db_tableprefix."nesote_chat_session_users`  SET active_status='1',typing_status='0' WHERE chat_id IN (".$all_ids[$i].") and user_id=".$userid);//echo $query;
							mysqli_query($conn,"UPDATE  `".$db_tableprefix."nesote_chat_temporary_messages`  SET read_flag='1' WHERE id IN (".$dlt_ids.") and read_flag='0' and chat_id=".$all_ids[$i]);//echo $query;
						}

					}
					$nn1=0;
					$db4->select("nesote_chat_session_users");
					$db4->fields("chat_id");
					$db4->where("active_status=? and user_id=?",array(1,$userid));
					$db4->order("present_identified_time desc");
					$db4->limit(0,$chatcnt);
					$rs11=$db4->query();
					$nn1=$db4->numRows($rs11);
					while($row11=$db4->fetchRow($rs11))
					{
						$ids1.=$row11[0].",";
					}

					if($nn1>=$chatcnt)
					{
						$ids1=substr($ids1,0,-1);
						if($nn1>0)
						{
							$db4->update("nesote_chat_session_users");
							$db4->set("active_status=? and typing_status=?",array(0,0));
							$db4->where("chat_id NOT IN(".$ids1.") and user_id=?",array($userid));
							$db4->query();//echo $db->getQuery();
						}
					}
					else
					{
						$ids1="";$usrids=0;
					}
					if($usrids!=0)
					{
						$db4->select("nesote_chat_session_users");
						$db4->fields("user_id");
						$db4->where("active_status=? and user_id!=?",array(1,$userid));
						$db4->order("present_identified_time desc");
						$db4->limit(0,$chatcnt);
						$rs11=$db4->query();$usrids="";
						while($row11=$db4->fetchRow($rs11))
						{
							$usrids.=$row11[0].",";
						}
					}
					else
					$usrids="";
					$close=substr($close,0,-1);$st="";
					if($open_ids!="")
					{
						$all_open_ids=explode(",",$open_ids);
						for($i1=0;$i1<count($all_open_ids);$i1++)
						{
							$db4->select("nesote_chat_session");
							$db4->fields("group_status");
							$db4->where("id=?",array($all_open_ids[$i1]));
							$rs1=$db4->query();
							$group_status=$db4->fetchRow($rs1);

							if($group_status[0]==1)//group chat
							{
								$db->select("nesote_chat_session_users");
								$db->fields("user_id,typing_status");
								$db->where("chat_id=? and user_id!=?",array($all_open_ids[$i1],$userid));
								$rs1=$db->query();$k=0;
								while($rw1=$db->fetchRow($rs1))
								{
									$db4->select("nesote_chat_users");
									$db4->fields("chat_status,signout,logout_status");
									$db4->where("userid=?",array($rw1[0]));
									$rs11=$db4->query();
									$row11=$db4->fetchRow($rs11);

									if($row11[0]==5 || $row11[1]==1 || $row11[2]==1)  // offline
									{
										$st=="";
									}
									else
									{
										if($rw1[1]==1)
										{
											$fname=$this->firstname($rw1[0]);
											$type=$this->getmessage(420);
											$type=str_replace("{fname}","$fname",$type);
											if($k==0)
											$st="$type...";
											else
											$st="$type...";
											$k++;
										}
										else if($rw1[1]==2)
										{
											$fname=$this->firstname($rw1[0]);

											$enter=$this->getmessage(421);
											$enter=str_replace("{fname}","$fname",$enter);

											if($k==0)
											$st="$enter...";
											else
											$st="$enter...";
											$k++;

											mysqli_query($conn,"UPDATE  `".$db_tableprefix."nesote_chat_session_users` SET typing_status='3' WHERE chat_id IN (".$all_open_ids[$i1].") and user_id=".$userid);//echo $query;
										}
										else if($rw1[1]>2)
										{
											mysqli_query($conn,"UPDATE  `".$db_tableprefix."nesote_chat_session_users` SET typing_status='0' WHERE chat_id IN (".$all_open_ids[$i1].") and user_id=".$userid);//echo $query;
											$st.="CLEAR";
										}
									}
										

								}
								$st1=str_replace("\n","<br>",$st);
								if($st1!="")
								$typestatus.=$all_open_ids[$i1]."$*&*$".$st1."$*&*$";
							}
							else //single chat
							{

								$db4->select("nesote_chat_session_users");
								$db4->fields("user_id,typing_status");
								$db4->where("chat_id=? and user_id!=?",array($all_open_ids[$i1],$userid));
								$rs107=$db4->query();
								$rw107=$db4->fetchRow($rs107);

								$db4->select("nesote_chat_users");
								$db4->fields("chat_status,signout,logout_status");
								$db4->where("userid=?",array($rw107[0]));
								$rs11=$db4->query();
								$row11=$db4->fetchRow($rs11);

								if($row11[0]==5 || $row11[1]==1 || $row11[2]==1)  // offline
								{
									$st=="";
								}
								else
								{
									$fname=$this->firstname($rw107[0]);
									$type=$this->getmessage(420);
									$type=str_replace("{fname}","$fname",$type);
									$enter=$this->getmessage(421);
									$enter=str_replace("{fname}","$fname",$enter);
									if($rw107[1]==1)
									$st.="$type...";
									else if($rw107[1]==2)
									{
										mysqli_query($conn,"UPDATE  `".$db_tableprefix."nesote_chat_session_users` SET typing_status='3' WHERE chat_id IN (".$all_open_ids[$i1].") and user_id=".$userid);//echo $query;
										$st.="$enter...";
									}
									else if($rw107[1]>2)
									{
										mysqli_query($conn,"UPDATE  `".$db_tableprefix."nesote_chat_session_users` SET typing_status='0' WHERE chat_id IN (".$all_open_ids[$i1].") and user_id=".$userid);
										$st.="CLEAR";
									}
								}

								if($st!="")
								$typestatus.=$all_open_ids[$i1]."$*&*$".$st."$*&*$";
							}
						}
					}

					if($typestatus=="$*&*$$*&*$")
					$typestatus="";
					$status="";
					$str4=$str2."(*&q#)".$close."(*&q#)".$status."(*&q#)".$typestatus."(*&q#)".$ids1."(*&q#)".$usrids;

				}
				else
				{
					//echo "";exit;
					$str4="";
					usleep(2000000);
				}//echo $str2;echo $typestatus;exit;
				if($str2!="" || $typestatus!="")
				{
					echo $str4;exit;
				}
				else
				{
					//echo "pattiche";
					usleep(2000000);
				}

			}
			echo "(*&q#)(*&q#)(*&q#)(*&q#)";exit;

		}



		function lookupname($chat_id,$userid)
		{
			$validateUser=$this->validateUser();

			if($validateUser!=TRUE)
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}


			$sender=$this->getId();

			$db=new NesoteDALController();

//			$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users"));
//			$db->fields("c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.id,u.username,u.password,u.firstname,u.lastname,u.sex,u.dateofbirth,u.country,u.remember_question,u.remember_answer,u.createdtime,u.lastlogin,u.status,u.memorysize,u.server_password,u.time_zone,u.alternate_email,u.smtp_username,c.signout");
//			$db->where("u.id=? and u.id=c.userid",$userid);
//			$result=$db->query();
//			$result1=$db->fetchRow($result);
			
			
			$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users"));
			$db->fields("c.logout_status,c.chat_status,c.idle,u.name,c.signout");
			$db->where("u.id=? and u.id=c.userid",$userid);
			$result=$db->query();
			$result1=$db->fetchRow($result);

			$img="";
			if($result1[4]==1 || $result1[0]==1 || $result1[1]==5)
			$img="iconsCornner chat-o";
			else if($result1[2]==1)
			$img="iconsCornner chat-i";
			else if($result1[1]==1)
			$img="iconsCornner chat-a";
			elseif($result1[1]==2)
			$img="iconsCornner chat-b";
			elseif($result1[1]==3)
			$img="iconsCornner chat-i";
			elseif($result1[1]==4)
			$img="iconsCornner chat-o";


			$db->select("nesote_chat_session");
			$db->fields("group_status");
			$db->where("id=?",array($chat_id));
			$result=$db->query();
			$row10=$db->fetchRow($result);

			if($row10[0]==1)
			{



				$db->select("nesote_chat_session_users");
				$db->fields("user_id");
				$db->where("chat_id=? and active_status=? and user_id!=?", array($chat_id,1,$sender));
				$result=$db->query();$title1=$this->firstname($sender).",";$i=1;
				$num=$db->numRows($result);
				if($num>0)
				{
					$img="images/groupchat.png";

					while($row=$db->fetchRow($result))
					{

						$title1.=$this->firstname($row[0]).",";$i++;
					}

					$title=substr($title1,0,-1);
					$title="(".$i.") ".$title;

					$length=strlen($title);
					if($length>12)
					$title=substr($title,0,12)."...";
					//$img="images/groupchat.png";
					$title="<img src=\"images/filler.gif\" class=\"iconsCornner chat-gp\"  border=\"0\" align=\"absmiddle\">$title";
					$st=$title;
					return $st;
				}
				else
				{
					$title=$this->getmessage(485);
					//$img="images/groupchat2.png";
					$title="<img src=\"images/filler.gif\" class=\"iconsCornner chat-gp2\" border=\"0\" align=\"absmiddle\"> $title";
					$st=$title;
					return $st;
				}

			}
			//$name=$result1[12]." ".$result1[13];
			$name=$result1[3];
			$length=strlen($name);
			if($length>12)
			$name=substr($name,0,12)."...";
			$st="<img src=\"images/filler.gif\" class=\"$img\" border=\"0\" align=\"absmiddle\">$name";


			return  $st;
		}

		function chatrefreshAction()
		{
			$validateUser=$this->validateUser();

			if($validateUser!=TRUE)
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}


			$userid=$this->getId();

			$db=new NesoteDALController();
			$db1=new NesoteDALController();


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
					//$message=str_replace("\n","<br>",$message);


					$db1->select("nesote_chat_session_users");
					$db1->fields("user_id");
					$db1->where("chat_id=? and active_status=? and user_id!=?",array($chat_id,1,$userid));
					$rs1=$db1->query();
					$time=time();
					$time=$this->settime($time);
					while($row1=$db1->fetchRow($rs1))
					{
						$db->insert("nesote_chat_temporary_messages");
						$db->fields("chat_id,sender,responders,message,time,read_flag");
						$db->values(array($chat_id,0,$row1[0],$message,$time,0));
						$db->query();

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

					$db->update("nesote_chat_session_users");
					$db->set("active_status=?,typing_status=?",array(0,0));
					$db->where("user_id=? and id=?",array($userid,$row10[0]));
					$db->query();


				}
				//echo $db1->getQuery();
			}

			die;
		}

		function chatwindowclosedAction()
		{
			$validateUser=$this->validateUser();

			if($validateUser!=TRUE)
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}


			$userid=$this->getId();
            $db1=new NesoteDALController();
			$db=new NesoteDALController();
			
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
					//$message=str_replace("\n","<br>",$message);


					$db1->select("nesote_chat_session_users");
					$db1->fields("user_id");
					$db1->where("chat_id=? and active_status=? and user_id!=?",array($chat_id,1,$userid));
					$rs1=$db1->query();
					$time=time();
					$time=$this->settime($time);
					while($row1=$db1->fetchRow($rs1))
					{


						$db->insert("nesote_chat_temporary_messages");
						$db->fields("chat_id,sender,responders,message,time,read_flag");
						$db->values(array($chat_id,0,$row1[0],$message,$time,0));
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

			die;
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

		function typingstatusAction()
		{
			$validateUser=$this->validateUser();

			if($validateUser!=TRUE)
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}


			$status=$this->getParam(1);
			$chat_id=$this->getParam(2);
			//$str=$this->getParam(3);


			//if($str!="")
			//{
			$sender=$this->getId();
				
			$db10=new NesoteDALController();
			$db10->select("nesote_chat_users");
			$db10->fields("chat_status,signout,logout_status");
			$db10->where("userid=?",array($sender));
			$rs11=$db10->query();
			$row11=$db10->fetchRow($rs11);

			if($row11[0]==5 || $row11[1]==1 || $row11[2]==1)  // offline
			{
				echo "";exit;
			}

			$db10->update("nesote_chat_session_users");
			$db10->set("typing_status=?",$status);
			if($status==2)
			$db10->where("chat_id=? and user_id=? and typing_status!=5",array($chat_id,$sender));
			else
			$db10->where("chat_id=? and user_id=?",array($chat_id,$sender));
			$db10->query();//echo $db10->getQuery();exit;
			//}
			//else
			//{
			//			$db10=new NesoteDALController();
				//			$db10->update("nesote_chat_session_users");
				//			$db10->set("typing_status=?",0);
				//			$db10->where("chat_id=? and user_id=?",array($chat_id,$sender));
				//			$db10->query();//echo $db10->getQuery();exit;
			//		}
			echo "";exit;



}

function searchoutcomeAction()
{

	$validateUser=$this->validateUser();

	if($validateUser!=TRUE)
	{
		header("Location:".$this->url("index/index"));
		exit(0);
	}


	$receiver=$this->getParam(1);
	$typedvalue=$this->getParam(2);
	$sender=$this->getId();

	$db=new NesoteDALController();

	if(!is_numeric($receiver))
	{//echo $typedvalue;
		$s1=explode("<",$typedvalue);//echo $s1[0];
		if($s1[1]!="")
		$s2=explode(">",$s1[1]);//echo $s2[0];
		else
		$s2=explode(">",$s1[0]);

		$typedvalue=$s2[0];
		if($this->isValid($typedvalue)==false)
		{
			$s=2;
			echo $s."||".$typedvalue;exit;

		}
		else
		{
			$upto=strpos($typedvalue,"@");

			$user=substr($typedvalue,0,$upto);



			$db->select("nesote_inoutscripts_users");
			$db->fields("id");
			$db->where("username=?",$user);
			$result=$db->query();
			$row=$db->fetchRow($result);
			$num=$db->numRows($result);
			if($num==0)
			{
				$s=2;
				echo $s."||".$typedvalue;exit;
			}

			$value1=explode("@",$typedvalue);
			$value2=$this->getextension();
			$value3="@".$value1[1];
			if($value2!=$value3)
			{
				$s=2;
				echo $s."||".$typedvalue;exit;
			}
			$id=$row[0];


//		
			$num=$db->total("nesote_chat_contact","sender=? and receiver=? and status=?",array($sender,$id,1));
			if($num==0)
			{
				$s=2;
				echo $s."||".$typedvalue;exit;

			}
			else
			{
				$s=1;
				echo $s."||".$id;exit;
			}
		}

	}


	$num=$db->total("nesote_chat_contact","sender=? and receiver=? and status=?",array($sender,$receiver,1));
	if($num==0)
	{
		$s=2;
		echo $s."||".$typedvalue;exit;

	}
	else
	{
		$s=1;
		echo $s."||".$receiver;exit;
	}

}

function servertimeupdation($uid,$db)
{

	$db->update("nesote_chat_users");
	$db->set("lastupdatedtime=?",time());
	$db->where("userid=?",$uid);
	$rs1=$db->query();//echo $db->getQuery();

	return;
}

function setchatwindowsizeAction()
{
	$validateUser=$this->validateUser();

	if($validateUser!=TRUE)
	{
		header("Location:".$this->url("index/index"));
		exit(0);
	}

	$chatwindowsize=$this->getParam(1);
	$userid=$this->getId();
	$db=new NesoteDALController();
	$db->update("nesote_chat_users");
	$db->set("chatwindowsize=?",$chatwindowsize);
	$db->where("userid=?",$userid);
	$rs1=$db->query();//echo $db->getQuery();

	echo "";exit;
}

function getsmileyvalue()
{
   //Turn of Smiley's if admin overrride the smiley
	$db1=new NesoteDALController();
	$db1->select("nesote_chat_settings");
	$db1->fields("value");
	$db1->where("name='chat_smiley'");
	$dbres=$db1->query();
	$dbresult=$db1->fetchRow($dbres);
        $smile_status=$dbresult[0];
        if($smile_status==0)
        {
             return 0;
        } 
        //End

	$userid=$this->getId();
	$select=new NesoteDALController();
	$select->select("nesote_chat_users");
	$select->fields("smileys");
	$select->where("userid=?",array($userid));
	$result=$select->query();
	$rs=$select->fetchRow($result);
	return $rs[0];
}

function ajaxupdation($flag,$uid,$db1)
{

	
    $db1=new NesoteDALController();
	if($flag==1)
	{
		
$available=$db1->total("nesote_chat_users","chat_status=? and userid=?",array(1,$uid));
       if($available==1)
       {
			$db1->update("nesote_chat_users");
			$db1->set("idle=?",1);
			$db1->where("userid=?",$uid);
			$rs2=$db1->query();//echo $db1->getQuery();
		}
	}
	else if($flag==0)
	{
		

		$db1->update("nesote_chat_users");
		$db1->set("idle=?",0);
		$db1->where("userid=?",$uid);
		$rs2=$db1->query();//echo $db->getQuery();
	}
	return ;
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

function sendmailAction()
{
	$valid=$this->validateUser();

	if($valid!=TRUE)
	{
		header("Location:".$this->url("index/index"));
		exit(0);
	}
	else
	{
		$uid=$this->getId();
		$to=$_POST['to'];
		$cc=$_POST['cc'];
		$bcc=$_POST['bcc'];
		$subject=$_POST['subject'];
		$content=$_POST['content'];
		$magic=get_magic_quotes_gpc();
		if($magic==1)
		{
			$content=stripcslashes($content);
		}
		//	echo $content=html_entity_decode($content,ENT_QUOTES,"UTF-8");

		$draftid=$_POST['draftid'];
		$mailid=$_POST['mailid'];
        
		$this->smtp($to,$cc,$bcc,$subject,$content,$uid,"","",$draftid,2,0);


	}
}

function savemailAction()
{
	$valid=$this->validateUser();

	if($valid!=TRUE)
	{
		header("Location:".$this->url("index/index"));
		exit(0);
	}
	else
	{
		$username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);
		
		$to=$_POST['to'];
		$cc=$_POST['cc'];
		$bcc=$_POST['bcc'];
		$subject=$_POST['subject'];
		$content=$_POST['content'];
		$draftid=$_POST['draftid'];
		$time=mktime();
		$reference="<references><item><mailid>".$draftid."</mailid><folderid>2</folderid></item></references>";

		$db1=new NesoteDALController();
		$db1->select("nesote_email_draft_$tablenumber");
		$db1->fields("just_insert");
		$db1->where("id=?",array($draftid));
		$rs1=$db1->query();//echo $db1->getQuery();
		$row=$db1->fetchRow($rs1);


		$db1->update("nesote_email_draft_$tablenumber");
		$db1->set("to_list=?,cc=?,bcc=?,subject=?,body=?,time=?,just_insert=?,mail_references=?",array($to,$cc,$bcc,$subject,$content,$time,0,$reference));
		$db1->where("id=?",array($draftid));
		$rs=$db1->query();//echo $db1->getQuery();
		echo $row[0];exit;
	}//$str=str_ireplace(":-^","<img src=\"smile/17.gif\" border=\"0\">",$str);
								
}

function discardmailAction()
{
	$validateUser=$this->validateUser();

	if($validateUser!=TRUE)
	{
		header("Location:".$this->url("index/index"));
		exit(0);
	}
    $username=$_COOKIE['e_username'];
	$tablenumber=$this->tableid($username);
	$draftid=$_POST['draftid'];
	$db=new NesoteDALController();
	$db->delete("nesote_email_draft_$tablenumber");
	$db->where("id=?",array($draftid));
	$rs=$db->query();
	echo $draftid;exit;
}
function smtp($to,$cc,$bcc,$subject,$html,$id,$mail_references,$in_reply_to,$draftid,$folders,$mails)
{
	$validateUser=$this->validateUser();

	if($validateUser!=TRUE)
	{
		header("Location:".$this->url("index/index"));
		exit(0);
	}
	$db=new NesoteDALController();
	$db1=new NesoteDALController();

	$this->loadLibrary('Settings');
	$settings=new Settings('nesote_email_settings');
	$settings->loadValues();
	
	
	$username=$_COOKIE['e_username'];
	$tablenumber=$this->tableid($username);
	//print_r($_POST);exit;
	$uid=$this->getId();
	$folder=-1;
	$maild=-1;
	 
	if($in_reply_to!="")
	{
		//echo $in_reply_to."jgfjyu";exit;


		$db->select("nesote_email_inbox_$tablenumber");
		$db->fields("*");
		$db->where("message_id=? and userid=?", array($in_reply_to,$uid));
		$result=$db->query();
		$row1=$db->fetchRow($result);
		$no=$db->numRows($result);
		if($no!=0)
		{
			$folder=1;
			$maild=$row1[0];

		}
		$db->select("nesote_email_sent_$tablenumber");
		$db->fields("*");
		$db->where("message_id=? and userid=?", array($in_reply_to,$uid));
		$result=$db->query();
		$row1=$db->fetchRow($result);
		$no=$db->numRows($result);
		if($no!=0)
		{
			$folder=3;
			$maild=$row1[0];

		}
		$db->select("nesote_email_spam_$tablenumber");
		$db->fields("*");
		$db->where("message_id=? and userid=?", array($in_reply_to,$uid));
		$result=$db->query();
		$row1=$db->fetchRow($result);
		$no=$db->numRows($result);
		if($no!=0)
		{
			$folder=4;
			$maild=$row1[0];

		}
		$db->select("nesote_email_trash_$tablenumber");
		$db->fields("*");
		$db->where("message_id=? and userid=?", array($in_reply_to,$uid));
		$result=$db->query();
		$row1=$db->fetchRow($result);
		$no=$db->numRows($result);
		if($no!=0)
		{
			$folder=5;
			$maild=$row1[0];

		}
		$db->select("nesote_email_customfolder_mapping_$tablenumber");
		$db->fields("*");
		$db->where("message_id=?", array($in_reply_to));
		$result=$db->query();
		$row1=$db->fetchRow($result);
		$no=$db->numRows($result);
		if($no!=0)
		{
			$folder=$row1[1];
			$maild=$row1[0];

		}
	}
	//echo $mails;
	$uname=$this->getusername($id);


	$mailextn_name=$this->getextension();
	$at=substr($mailextn_name,0,1);
	if($at=="@")
	{
		$from=$uname.$mailextn_name;
		$mail_extension=$mailextn_name;
	}
	else
	{
		$from=$uname."@".$mailextn_name;
		$mail_extension="@".$mailextn_name;
	}


	$host_name=$settings->getValue("SMTP_host");

    $port_number=$settings->getValue("SMTP_port");

	$catch_all=$settings->getValue("catchall_mail");
 $extsmtp=$settings->getValue("user_smtp");
       


	if($catch_all==1)
	{

		$SMTP_username=$settings->getValue("SMTP_username");


		$SMTP_password=$settings->getValue("SMTP_password");
	}
	else
	{
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
			$db->select("nesote_email_usersettings");
			$db->fields("server_password,smtp_username");
			$db->where("userid=?", array($id));
			$result=$db->query();
			$row=$db->fetchRow($result);
			$password=$row[0];
			$SMTP_password=base64_decode($password);
			$SMTP_username=$row[1];
}
	}

	$db->select("nesote_email_sent_$tablenumber");
	$db->fields("id");
	$db->order("id desc");
	$db->limit(0,1);
	$result=$db->query();
	$row=$db->fetchRow($result);
	$last_sentid=$row[0];
	$var=time().$id.$last_sentid;
	$msg_id=md5($var).$mail_extension;
	$message_id="<".$msg_id.">";


	require_once('class/class.phpmailer.php');
	require_once('class/class.smtp.php');
	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

	//$mail->IsSMTP(); // telling the class to use SMTP
if($extsmtp==1)
{
$mail->IsSMTP();
}

	try {
		$mail->Host       = $host_name; // SMTP server
		$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
		$mail->SMTPAuth   = false;                  // enable SMTP authentication
		$mail->Port       = $port_number;                    // set the SMTP port for the GMAIL server
		$mail->Username   = $SMTP_username; // SMTP account username
		$mail->Password   = $SMTP_password;
		$mail->MessageID  = $message_id;
		// SMTP account password

		$mail->AddReplyTo($from);//('saneesh@valiyapalli.com', 'Saneesh Baby');
		$mail->SetFrom($from);
		if($in_reply_to!="")
		$mail->AddCustomHeader("In-Reply-To:$in_reply_to");
		$to_address="";
		$cc_address="";
		$bcc_address="";//echo $to."+++++++++++";
		if($to!='')
		{
			//$to=" ".$to;
			$to=explode(",",$to);

			foreach ($to as $address)
			{
				if(trim($address)!='')
				{
					$address=" ".$address;
					//"Saneesh Baby" <saneesh.baby@nesote.com>
					$address=str_replace("\\","",$address);

					preg_match("/(.+?)<(.+?)>/i",$address,$mailid);
					if(count($mailid[2])==0)
					preg_match("/(.+?)&lt;(.+?)&gt;/i",$address,$mailid);
					if($mailid[2]=="")
					{
						//echo "aaaaaaaaaa";exit;
						$mailid[2]=$address;
						$mailid[1]="";
					}
					$mailid[1]=str_replace("\"","",$mailid[1]);
					//echo$mailid[2]."++++++".$mailid[1]."++++++";
					$mail->AddAddress($mailid[2],$mailid[1]);
					$to_address.=$mailid[1]."< ".$mailid[2].">,";
					$this->addcontact($mailid[2],$mailid[1]);
				}
			}
		}$to_address=trim($to_address);//echo $to_address;exit;




		if($cc!='')
		{
			$cc=explode(",",$cc);

			foreach ($cc as $address1)
			{
				if(trim($address1)!='')
				{
					$address1=str_replace("\\","",$address1);

					preg_match("/(.+?)<(.+?)>/i",$address1,$mailid);
					if(count($mailid[2])==0)
					preg_match("/(.+?)&lt;(.+?)&gt;/i",$address1,$mailid);

					if($mailid[2]=="")
					{

						$mailid[2]=$address1;
						$mailid[1]="";
					}
					$mailid[1]=str_replace("\"","",$mailid[1]);
					$mail->AddCC($mailid[2],$mailid[1]);
					$cc_address.=$mailid[1]."< ".$mailid[2].">,";
					$this->addcontact($mailid[2],$mailid[1]);


				}
			}
		}
		if($bcc!='')
		{
			$bcc=explode(",",$bcc);
			foreach ($bcc as $address2)
			{
				if(trim($address2)!='')
				{
					$address2=str_replace("\\","",$address2);

					preg_match("/(.+?)<(.+?)>/i",$address2,$mailid);
					if(count($mailid[2])==0)
					preg_match("/(.+?)&lt;(.+?)&gt;/i",$address2,$mailid);
					if($mailid[2]=="")
					{

						$mailid[2]=$address2;
						$mailid[1]="";
					}
					$mailid[1]=str_replace("\"","",$mailid[1]);
					$mail->AddBCC($mailid[2],$mailid[1]);
					$bcc_address.=$mailid[1]."< ".$mailid[2].">,";
					$this->addcontact($mailid[2],$mailid[1]);


				}
			}
		}

		$tme=time();
		$mail->SetFrom($from);//('saneesh@valiyapalli.com', 'Saneesh Baby');
		$subjekt = "=?UTF-8?B?".base64_encode(strval($subject))."?=";
		$mail->Subject = $subjekt;
		$mail->SMTPSecure="ssl";
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically



		$db->insert("nesote_email_sent_$tablenumber");
		$db->fields("userid,from_list,to_list,cc,bcc,subject,status,readflag,starflag,memorysize,message_id,time");
		$db->values(array($uid,$from,$to_address,$cc_address,$bcc_address,$subject,1,1,0,0,$message_id,$tme));
		$res=$db->query();//echo $db->getQuery();
		$lastid=$db->lastInsertid("nesote_email_sent_$tablenumber");

		$mail->IsHTML(true);
       

		$p=0;
		//setcookie("draftid","1","0","/");
		$db2=new NesoteDALController();
		$db2->select("nesote_email_attachments_$tablenumber");
		$db2->fields("*");
		$db2->where("mailid=? and folderid=? and attachment=? and userid=?", array($draftid,2,1,$uid));
		$result2=$db2->query();
		while($rw=$db2->fetchRow($result2))
		{
			$file_name[$p]=$rw[2];
			$flnam=explode(".",$file_name[$p]);
			$extention=$flnam[1];
			$ac=0;
			$img_formats=$this->getimageformats();
			$img_format=explode(",",$img_formats);
			for($a=0;$a<count($img_format);$a++)
			{
				if($extention==$img_format[$a])
				{
					$type="image/".$extention;
					$ac=1;
					break;
				}
			}
			if($ac==0)
			{
				$type="other/".$extention;
			}

			if ($file_name[$p]!= "." && $file_name[$p]!= "..")
			{

				$db->select("nesote_email_attachments_$tablenumber");
				$db->fields("attachment");
				$db->where("mailid=? and folderid=? and name=? and userid=?", array($draftid,2,$file_name[$p],$uid));
				$result3=$db->query();
				$rw1=$db->fetchRow($result3);
				$mail->AddAttachment("attachments/2/$tablenumber/$draftid/$file_name[$p]",$file_name[$p],"base64",$type);
			}

			$p++;

		}


		$p=0;
		$db21=new NesoteDALController();
		$db21->select("nesote_email_attachments_$tablenumber");
		$db21->fields("*");
		$db21->where("mailid=? and folderid=? and attachment=? and userid=?", array($mails,$folders,0,$uid));
		$result21=$db21->query();

		$size=1;
		$new_html=$html;
		while($rw21=$db21->fetchRow($result21))
		{

			$file_names[$p]=$rw21[2];//echo $file_names[$p];



			if ($file_names[$p]!= "." && $file_names[$p]!= "..")
			{
				if(strpos($new_html,"attachments/".$folders."/".$tablenumber."/".$mails."/".$file_names[$p])!="FALSE")
				{


					$url=$_SERVER['HTTP_HOST'].$_SERVER["SCRIPT_NAME"];
					if(strpos($url,"/index.php")!="")
					{
						$url=str_replace("/index.php","",$url);

					}
					$url1="http://".$url."/attachments/".$folders."/".$tablenumber."/".$mails."/".$file_names[$p];


					$cid=$p."_".$msg_id;
					$mail->AddEmbeddedImage("attachments/".$folders."/".$tablenumber."/".$mails."/".$file_names[$p], $cid, $file_names[$p], "base64", "image/jpeg");


					$new_html=str_replace($url1,"cid:".$cid,$new_html);//echo $new_html;
					if((is_dir("attachments/3/".$tablenumber."/".$lastid))!=TRUE)
					{
						
						
						if((is_dir("attachments/3/".$tablenumber))!=TRUE)
						{
						  if((is_dir("attachments/3"))!=TRUE)
						   {
							mkdir("attachments/3",0777);
						   }
							mkdir("attachments/3/".$tablenumber,0777);
						}
						mkdir("attachments/3/".$tablenumber."/".$lastid,0777);

					}
					copy("attachments/".$folders."/".$tablenumber."/".$mails."/".$file_names[$p],"attachments/3/".$tablenumber."/".$lastid."/".$file_names[$p]);
					$filesize=filesize("attachments/".$folders."/".$tablenumber."/".$mails."/".$file_names[$p]);
					$filesize=ceil($filesize/1024);
					$size=$size+$filesize;
					$extention=explode(".",$rw[2]);
					$len=count($extention);
					$extention=$extention[($len-1)];
					$extention=trim($extention);
					$img_formats=$this->getimageformats();
					$img_format=explode(",",$img_formats);

					$type="image/".$extention;

					$db1->insert("nesote_email_attachments_$tablenumber");
					$db1->fields("mailid,userid,name,folderid,attachment,type");
					$db1->values(array($lastid,$uid,$file_names[$p],3,0,$type));
					$res=$db1->query();

					$new_html=str_replace($url1,"http://".$url."/attachments/3/".$tablenumber."/".$lastid."/".$file_names[$p],$new_html);
					$mail->Body=$new_html;

				}


			}
			$p++;

		}//echo $p;exit;
		if($p==0)
		$mail->Body=$html;
		//}

		$mail_references=$this->modified_reference($mail_references,$lastid);

		
		$message_id=$mail->MessageID;
       

		 $time=$this->getusertime();

		//echo "Message Sent OK</p>\n";
		$db2=new NesoteDALController();
		$db2->select("nesote_email_attachments_$tablenumber");
		$db2->fields("*");
		$db2->where("mailid=? and folderid=? and attachment=? and userid=?", array($draftid,2,1,$uid));
		$result2=$db2->query();//echo $db2->getQuery();
		$num=$db2->numRows($result2);
        
		while($rw=$db2->fetchRow($result2))
		{

			if((is_dir("attachments/3/".$tablenumber."/".$lastid))!=TRUE)
			{
				if((is_dir("attachments/3/".$tablenumber))!=TRUE)
				{
					if((is_dir("attachments/3"))!=TRUE)
				    {
				 	mkdir("attachments/3",0777);
				    }
				   				
					
					mkdir("attachments/3/".$tablenumber,0777);
				}
				mkdir("attachments/3/".$tablenumber."/".$lastid,0777);
				
			}
			//echo $entry;
			$filesize=filesize("attachments/2/".$tablenumber."/".$draftid."/".$rw[2]);
			$filesize=ceil($filesize/1024);
			$size=$size+$filesize;
			$extention=explode(".",$rw[2]);
			$len=count($extention);
			$extention=$extention[($len-1)];
			$extention=trim($extention);
			$acc=0;
			$img_formats=$this->getimageformats();
			$img_format=explode(",",$img_formats);
			for($a=0;$a<count($img_format);$a++)
			{
				if($extention==$img_format[$a])
				{
					$type="image/".$extention;
					$acc=1;
					break;
				}
			}
			if($acc==0)
			{
				$type="other/".$extention;
			}

			if($extention=="exe")
			{
				$filename=str_replace("exe","qqq",$rw[2]);
			}
			else
			{
				$filename=$rw[2];
			}

			copy("attachments/2/".$tablenumber."/".$draftid."/".$filename,"attachments/3/".$tablenumber."/".$lastid."/".$filename);
			unlink("attachments/2/".$tablenumber."/".$draftid."/".$filename);


			$db1->insert("nesote_email_attachments_$tablenumber");
			$db1->fields("mailid,userid,name,folderid,attachment,type");
			$db1->values(array($lastid,$uid,$filename,3,$rw[5],$type));
			$res=$db1->query();//echo $db1->getQuery();

				
			$db1->delete("nesote_email_attachments_$tablenumber");
			$db1->where("id=? ",array($rw[0]));
			$db1->query();
		}
		if($num!=0)
		{
			rmdir("attachments/2/".$tablenumber."/".$draftid);

			//rmdir($mydir);



			$db1->delete("nesote_email_attachments_$tablenumber");
			$db1->where("mailid=? and folderid=? and userid=?",array($draftid,2,$uid));
			$res=$db1->query();
		}

		//echo $html."+++++++".$num;
        $md5_mail_references=md5($mail_references);
        
		$db1->update("nesote_email_sent_$tablenumber");
		$db1->set("mail_references=?,md5_references=?,body=?,time=?,memorysize=?",array($mail_references,$md5_mail_references,$html,$time,$size));
		$db1->where("id=?",$lastid);
		$res1=$db1->query();//echo $db1->getQuery();exit;


		$db1->delete("nesote_email_draft_$tablenumber");
		$db1->where("id=?",$draftid);
		$res=$db1->query();
		$mail->Send();
$this->saveLogs("Sent Mail",$username." has sent a mail");

	} catch (phpmailerException $e) {
		echo $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
		echo $e->getMessage(); //Boring error messages from anything else!
	}
	exit;
	return;


}
function modified_reference($mail_references,$lastid)
{
	//echo $mail_references;exit;
	if($mail_references=="")
	{
		$mail_references="<references><item><mailid>$lastid</mailid><folderid>3</folderid></item></references>";
	}
	else
	{
		preg_match_all('/<item>(.+?)<\/item>/i',$mail_references,$reply);
		//print_r($reply);
		$no=count($reply[1]);
		for($i=0;$i<$no;$i++)
		{
			preg_match('/<mailid>(.+?)<\/mailid>/i',$reply[1][$i],$mailid);
			preg_match('/<folderid>(.+?)<\/folderid>/i',$reply[1][$i],$folderid);//echo $mailid[1]."p".$folderid[1]."n";

			if($folderid[1]==2)
			{

				$replace="<item><mailid>$mailid[1]</mailid><folderid>2</folderid></item>";
				$mail_references=str_replace($replace,"",$mail_references);

			}
		}
		$references="<item><mailid>$lastid</mailid><folderid>3</folderid></item></references>";

		$mail_references=str_replace("</references>",$references,$mail_references);
	}

	return $mail_references;
}
function addcontact($mailid,$name)
{
	$validateUser=$this->validateUser();

	if($validateUser!=TRUE)
	{
		header("Location:".$this->url("index/index"));
		exit(0);
	}
	$db=new NesoteDALController();

	$userid=$this->getId();


	$no=$db->total("nesote_email_contacts","mailid=? and addedby=?",array($mailid,$userid));
	if($no==0)
	{

		if($name!="")
		{
			$db->insert("nesote_email_contacts");
			$db->fields("mailid,addedby,contactgroup,firstname");
			$db->values(array($mailid,$userid,0,$name));
			$db->query();
		}
		else
		{
			$db->insert("nesote_email_contacts");
			$db->fields("mailid,addedby,contactgroup");
			$db->values(array($mailid,$userid,0));
			$db->query();
		}
		return;
	}
	else
	return;
}

function deletechatemailAction()
{
	$valid=$this->validateUser();

	if($valid!=TRUE)
	{
		header("Location:".$this->url("index/index"));
		exit(0);
	}
	else
	{
		$username=$_COOKIE['e_username'];

		$modulsnumber=$this->tableid($username);

		$mailid=$_POST['mailid'];
		$userid=$this->getId();

		$db=new NesoteDALController();
		$db->delete("nesote_chat_message_$modulsnumber");
		$db->where("id IN($mailid) and userid=?",$userid);
		$rs1=$db->query();//echo $db->getQuery();

		echo "";exit;
	}
}

function getchatdetailAction()
{
	$valid=$this->validateUser();

	if($valid!=TRUE)
	{
		header("Location:".$this->url("index/index"));
		exit(0);
	}
	else
	{
		$designid=$this->getParam(1);//echo $designid;exit;

		$id=$this->getId();
		$me=$this->getmessage(284);

		$user_name=$_COOKIE['e_username'];
		$user_name=trim($user_name);

		$modlusnumber=$this->tableid($user_name);

		$userid=$this->getId();

		$db=new NesoteDALController();

		$db->select("nesote_chat_message_$modlusnumber");
		$db->fields("*");
		$db->where("userid=? and id=?",array($userid,$designid));
		$db->order("time desc");
		$gethistory=$db->query();
		$tot=$db->numRows($gethistory);$i=0;$j=0;
		while($gethistory1=$db->fetchRow($gethistory))

		{

			$receivers=$gethistory1[3];

			$receivers=explode(",",$receivers);

			$numberingthereciver=count($receivers);$name="";$name1="";$name2="";$name3="";
				
			for($nn=1;$nn<$numberingthereciver;$nn++)
			{
				$rece[$nn]=$receivers[$nn];
				$db->select("nesote_inoutscripts_users");
				$db->fields("username,name");
				$db->where("id=? and username!=?",array($rece[$nn],$user_name));
				$temp=$db->query();
				$temp1=$db->fetchRow($temp);

				$rev[$nn]=$temp1[0];

				$extn=$this->getextension();
				if($rev[$nn]!="")
				{
					$p1=$rev[$nn].",";
					//$p2=$temp1[1]." ".$temp1[2].",";
					$p2=$temp1[1];
					$p=$rev[$nn].$extn.",";
				}
				else
				{
					$p="";$p1="";$p2="";
				}
				$name.=$p2;
				$name1.=$p1;
				$name2.=$p2;
				$name3.=$p;



			}

			$xml=$gethistory1[4];

			$str = $xml;
			$chars = preg_split('/<item>/', $str,-1, PREG_SPLIT_OFFSET_CAPTURE);
			$count=count($chars);
			$lines=$count-1;
			$chars[$i][0]=str_replace("\n","<br>",$chars[$i][0]);
			$subject=$chars[1][0];


			$pattern = '/<id>(.+?)<\/id><time>(.+?)<\/time><sender>(.+?)<\/sender><message>(.+?)<\/message>/i';
			preg_match($pattern,$subject,$matches);
				


			$db->select("nesote_inoutscripts_users");
			$db->fields("username");
			$db->where("id=?",$matches[3]);
			$jet=$db->query();
			$jet1=$db->fetchRow($jet);

			$sendername=$jet1[0];


			if($sendername==$user_name)
			{
				$firstsender=$this->getmessage(284);

			}
			else
			{


				$firstsender=$sendername;

				if($name=="")
				$name.=$this->getfullname($sendername);

				if($name1=="")
				$name1.=$this->getfullname($sendername);
				if($name2=="")
				$name2.=$this->getfullname($sendername);
				if($name3=="")
				$name3.=$sendername.$this->getextension();


			}

			//$chattime=$matches[2];
			$chattime=$gethistory1[5];

			$reverse = strrev($name);
			if($reverse[0]==",")
			$name=substr($name,0,-1);

			$chat_messages[$j][0]=$matches[1];
			$chat_messages[$j][1]=$chattime;
			$chat_messages[$j][2]=$sendername;
			$chat_messages[$j][3]=$matches[4];
			$chat_messages[$j][4]=$firstsender;
			$chat_messages[$j][5]=$name;
			$chat_messages[$j][6]=$gethistory1[0];
			$chat_messages[$j][7]=$lines;
			$chat_messages[$j][8]=$gethistory1[6];

			$reverse1 = strrev($name1);
			if($reverse1[0]==",")
			$name1=substr($name1,0,-1);

			$reverse2 = strrev($name2);
			if($reverse2[0]==",")
			$name2=substr($name2,0,-1);

			$reverse3 = strrev($name3);
			if($reverse3[0]==",")
			$name3=substr($name3,0,-1);



			$tableid=$gethistory1[0];
			$chatid=$matches[1];
			$from=$name;

			if(strpos($from,",")!="")
			{
				$cnt1=explode(",",$from);
				$cnt=count($cnt1);
			}
			else if($from!="")
			$cnt=1;
			if($cnt>1)
			{
				$from=$me;
				$fromopen=$this->getName($userid);
				$to=$name1;
				$todtls=$name3;
				$fromopendtls=$this->getusername($userid).$this->getextension();
				$toreply=$todtls;

			}
			else
			{
				if($firstsender==$me)
				{
					$fromopen=$name2;
					$fromopendtls=$name3;
				}
				else
				{
					$fromopen=$this->getfullname($firstsender);
					$fromopendtls=$firstsender.$this->getextension();
				}

				$to=$me;
				$todtls=$_COOKIE['e_username'].$this->getextension();
				$toreply=$fromopendtls;

			}


			if($name3!=$me || $name3!=="")
			{
				$fromall=$name3.",".$user_name.$this->getextension();

			}
			else
			{
				$fromall=$user_name.$this->getextension();

			}

			$subj=$this->getmessage(384)." ".$name2."  (".$lines." lines)";
			$subj1=$this->getmessage(382)." ".$name2;
			$subj2=$this->getmessage(382)." ".$name2.",".$this->gettitlename($userid);

			$time=$this->gettime($chattime,$user_name);
			$readflag=$gethistory1[6];
			$responders=$firstsender." - ".$chat_messages[$j][3];

			//$msg=$chat_messages[$j][3];

			$msg=$this->getchatmsg($tableid,$modlusnumber,$user_name);
			$msg1=strip_tags($msg);




			$contacts.=trim($tableid)."{nesote_t}";//0
			$contacts.=trim($chatid)."{nesote_t}";//1

			$contacts.=trim($from)."{nesote_t}";//2
			$contacts.=trim($subj)."{nesote_t}";//3
			$contacts.=trim($time)."{nesote_t}";//4
			$contacts.=trim($readflag)."{nesote_t}";//5
			$contacts.=trim($responders)."{nesote_t}";//6
			$contacts.=trim($to)."{nesote_t}";//7
			$contacts.=trim($msg)."{nesote_t}";//8
			$contacts.=trim($fromopen)."{nesote_t}";//9
			$contacts.=trim($subj1)."{nesote_t}";//10
			$contacts.=trim($fromall)."{nesote_t}";//11
			$contacts.=trim($subj2)."{nesote_t}";//12
			$contacts.=trim($fromopendtls)."{nesote_t}";//13
			$contacts.=trim($todtls)."{nesote_t}";//14
			$contacts.=trim($toreply)."{nesote_t}";//15
			$contacts.=trim($msg1)."{nesote_t}";//16
			$i++;$j++;

		}



		$contacts=substr($contacts,0,-10);
		print_r($contacts);
		exit;




		echo $contacts;exit;
	}
}

function getchatmsg($tableid,$modlusnumber,$user_name)
{
	$username=$_COOKIE['e_username'];

	$indexid=$tableid;
	if($indexid=="")
	{

		return;
	}

	$chat_messages="";$str1="";$me=$this->getmessage(284);



	$db=new NesoteDALController();


	$db->select("nesote_chat_message_$modlusnumber");
	$db->fields("*");
	$db->where("id=?",$indexid);
	$db->order("time desc");
	$gethistory=$db->query();
	$gethistory1=$db->fetchRow($gethistory);



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

		$rev[$nn]=$temp1[0];

		$name[$i].=$rev[$nn]." " .","." ";


	}
	$long=strlen($name[$i]);
	$long1=$long-2;

	$name[$i]=substr($name[$i],0,$long1);


	$this->setValue("towhom",$name[$i]);
	$xml=$gethistory1[4];
	$same=0;


	$str = $xml;
	$chars = preg_split('/<item>/', $str,-1, PREG_SPLIT_OFFSET_CAPTURE);
	$count=count($chars);
	//<tr><td ><strong>These messages were sent while you were offline.</strong></td></tr>
	$str1="<table border=0 style=\"table-layout:width:90% fixed;word-wrap: break-word;\" class=\"chatContent\" >";
	$flag=0;
	for($i=0;$i<$count;$i++)
	{

		$chars[$i][0]=str_replace("\n","<br>",$chars[$i][0]);
		$subject=$chars[$i][0];

		$pattern = '/<id>(.+?)<\/id><time>(.+?)<\/time><sender>(.+?)<\/sender><message>(.+?)<\/message>/i';

		preg_match($pattern,$subject,$matches);

		$db->select("nesote_inoutscripts_users");
		$db->fields("username");
		$db->where("id=?",$matches[3]);
		$jet=$db->query();

		$jet1=$db->fetchRow($jet);

		$sendername[$i]=$jet1[0];$sendername1[$i]=$this->gettitlename($matches[3]);
		if($matches[3]==0)
		$sendername[$i]="";

		if($sendername[$i]==$username)
		{
			//$sendername[$i]=$me;$sendername1[$i]=$me;
		}
		//1
		$sendersname[$i]=$sendername[$i];$sendersname1[$i]=$sendername1[$i];

		$getsmileyvalue=$this->getsmileyvalue();
		$msg=$matches[4];
$msg=str_replace("e0d71f32e332df0bf09e2f879dd14d77"," ",$msg);
		if($getsmileyvalue==1)
		{
			$msg=str_ireplace(":)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-1\">",$msg);
				$msg=str_ireplace(":(","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-2\">",$msg);
				$msg=str_ireplace(":d","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-3\">",$msg);
				$msg=str_ireplace(":P","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-4\">",$msg);
				$msg=str_ireplace("(*)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-5\">",$msg);
				$msg=str_ireplace("(-)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-6\">",$msg);
				$msg=str_ireplace(":|","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-7\">",$msg);
				$msg=str_ireplace("(;","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-8\">",$msg);
				$msg=str_ireplace(":-*","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-9\">",$msg);
				$msg=str_ireplace(":-v","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-10\">",$msg);
				$msg=str_ireplace(":*)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-11\">",$msg);
				$msg=str_ireplace("B-)","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-12\">",$msg);
				$msg=str_ireplace("x-(","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-13\">",$msg);
				$msg=str_ireplace(":*B","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-14\">",$msg);
				$msg=str_ireplace("*:A","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-15\">",$msg);
				$msg=str_ireplace(":-$","<img src=\"images/filler.gif\" border=\"0\" align=\"absmiddle\" class=\"smileyCornner smiley-16\">",$msg);
			//$msg=str_ireplace(":-^","<img src=\"smile/17.gif\" border=\"0\">",$msg);
			//$msg=str_ireplace(":-!","<img src=\"smile/18.gif\" border=\"0\">",$msg);
			//$msg=str_ireplace(":-D","<img src=\"smile/19.gif\" border=\"0\">",$msg);
			//$msg=str_ireplace(":X","<img src=\"smile/20.gif\" border=\"0\">",$msg);
			//$msg=str_ireplace(":=)","<img src=\"smile/21.gif\" border=\"0\">",$msg);
			//$msg=str_ireplace("?=)","<img src=\"smile/22.gif\" border=\"0\">",$msg);
			//$msg=str_ireplace(":-o","<img src=\"smile/23.gif\" border=\"0\">",$msg);
			//$msg=str_ireplace(":-Z","<img src=\"smile/24.gif\" border=\"0\">",$msg);
		}

		$message[$i]=$msg;
		if($flag==1)
		{

			if($sendername[$i]==$username)
			{
				$firstsender=$me;
				$this->setValue("firstsender",$firstsender);


			}
			else
			{


				$firstsender=$sendername[$i];
				$this->setValue("firstsender",$firstsender);

			}

		}

		if($flag>0)
		{

			if($matches[2]!="" || $matches[2]!=0)
			{
					
				$time[$i]=$this->gettimetype1($matches[2],$user_name);
				//$time[$i]=date("h:i A",$matches[2]);
			}
			else
			$time[$i]="";


			if($flag==1)
			{
				$hour=$this->gettimetype2($matches[2],$user_name);
				//	$hour=date("F Y h:i:s A",$matches[2]);
				$this->setValue("hour",$hour);
				$chattime=$matches[2];

				$this->setValue("chattime",$chattime);

			}



			if($time[$i-1]==$time[$i])
			{
				$messagetime[$i]="";


				if($sendername[$i-1]==$sendername[$i])
				{
					$same=1;
					$sendersname[$i]="";$sendersname1[$i]="";

					$message[$i-1].=$message[$i];

				}
				else
				{
					//2
					$sendersname[$i]=$sendername[$i];$sendersname1[$i]=$sendername1[$i];

				}

			}
			else
			{
				$messagetime[$i]=$time[$i];

			}

			$sender=$sendersname[$i];$sender=$sendersname1[$i];
			if($sender!="")
			$sender=$sender."<b>: </b>";

			$str1.="<tr>";
			if($messagetime[$i]!="")
			$str1.="<td style=\"float:left;text-align: left;padding:5px 0px 0px 10px;word-break: break-word;\"><span class=\"chattitleTime\">$messagetime[$i]</span></td>";
			else
			$str1.="<td style=\"float:left;text-align: left;padding:5px 0px 0px 61px;word-break: break-word;\"> </td>";
			$str1.="<td style=\"float:left;text-align: left;padding:5px 0px 0px 10px;word-break: break-word;\"><strong>$sender</strong>";
			if($same==0)
			$str1.="<b> </b>";
			if($sendersname1[$i]!="")
			$str1.="$message[$i] </td></tr>";
			else
			$str1.="$message[$i] </td></tr>";
		}

		$flag++;

	}
	$str1.="</table>";
	//$chat_messages=html_entity_decode($chat_messages);
	$str1=html_entity_decode($str1);
	return $str1;
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

function gettitlename($id)
{
	if($id==0)
	return "";
	$db=new NesoteDALController();
	$db->select("nesote_inoutscripts_users");
	$db->fields("name");
	$db->where("id=?",array($id));
	$rs1=$db->query();
	$row=$db->fetchRow($rs1);
	return $row[0];
}
function gettimecurnt($date)
	{
	
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$position=$settings->getValue("time_zone_postion");

		$username=$_COOKIE['e_username'];


		$hour=$settings->getValue("time_zone_hour");
		$min=$settings->getValue("time_zone_mint");


		$diff=((3600*$hour)+(60*$min));

		if($position=="Behind")
		$diff=-$diff;
		else
		$diff=$diff;
		
		$tsa=time()-$date+$diff;
		$dates=$date+$diff;
		$year1= date("Y",$dates);
		$year2= date("Y",time());
		$userid=$this->getId();
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
		$sign=substr($timezone,0,1);
			
		$timezone1=substr($timezone,1);

		$timezone1=explode(":",$timezone1);
		$newtimezone=($timezone1[0]*60*60)+($timezone1[1]*60);

		if($sign=="+")
		$newtimezone=$newtimezone;
		if($sign=="-")
		$newtimezone=-$newtimezone;
		$ts=$date+$newtimezone;
		
		$date=$ts;
 
		$month_id = date("n",$date);
		if(isset ($_COOKIE['lang_mail']))
		{
			$lang_code=$_COOKIE['lang_mail'];
		}
		else
		{

			$lang_code=$settings->getValue("default_language");
		}
		$lang_id=$this->getlang_id($lang_code);

		$day=date(" j ",$date);

		$db=new NesoteDALController();
		$db->select("nesote_email_months_messages");
		$db->fields("message");
		$db->where("month_id=? and lang_id=?",array($month_id,$lang_id));
		$result=$db->query();
		$data=$db->fetchRow($result);
		if($data[0]=="")
		{
			$db=new NesoteDALController();
			$db->select("nesote_email_months_messages");
			$db->fields("message");
			$db->where("month_id=? and lang_id=?",array($month_id,1));
			$result=$db->query();
			$data=$db->fetchRow($result);
		}
		
		if($tsa>86400)
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

function gettime($date,$username)
{
	//return date("h:i A ",$date);
	$db= new NesoteDALController();
	//		$db->select("nesote_email_settings");
	//		$db->fields("value");
	//		$db->where("name=?",time_zone_postion);
	//		$result=$db->query();
	//		$row=$db->fetchRow($result);
	//		$position=$row[0];
	//		$username=$_COOKIE['e_username'];
	//
	//
	//		$db->select("nesote_email_settings");
	//		$db->fields("value");
	//		$db->where("name=?",time_zone_hour);
	//		$result1=$db->query();
	//		$row1=$db->fetchRow($result1);
	//		$hour=$row1[0];
	//
	//
	//		$db->select("nesote_email_settings");
	//		$db->fields("value");
	//		$db->where("name=?",time_zone_mint);
	//		$result2=$db->query();
	//		$row2=$db->fetchRow($result2);
	//		$min=$row2[0];
	//
	//		$diff=((3600*$hour)+(60*$min));
	//
	//		if($position=="Behind")
	//		$diff=-$diff;
	//		else
	//		$diff=$diff;

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

function gettimeforchat($tme)
{
  $this->loadLibrary('Settings');
  $settings=new Settings('nesote_email_settings');
  $settings->loadValues();
		
	$position=$settings->getValue("time_zone_postion");
	$hour=$settings->getValue("time_zone_hour");
	$min=$settings->getValue("time_zone_mint");

	$diff=((3600*$hour)+(60*$min));

	if($position=="Behind")
	$diff=$diff;
	else
	$diff=-$diff;
	$tme=$tme+$diff;
	return $tme;
}

function gettimetype1($date,$username)
{
	
	

	$ts=$date;

	//$tsa=time()-$date+$diff;

	$tsa=time()-$date;
		$userid=$this->getId();
	$db= new NesoteDALController();
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
		$val = date(" h:i A  ",$date);
	}
	elseif($ts<$v2)
	{
		$val =date(" h:i A ",$date);
	}
	else
	{
		$val =date("h:i A ",$date);
	}
	return $val;
}
function gettimetype2($date,$username)
{
	

	$ts=$date;

	//$tsa=time()-$date+$diff;
	$tsa=time()-$date;
	$userid=$this->getId();	
	$db= new NesoteDALController();
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
		$val =date(" F Y h:i:s A",$date);
	}
	elseif($ts<$v2)
	{
		$val =date("F Y h:i:s A",$date);
	}
	else
	{
		$val =date("F Y h:i:s A",$date);
	}
	return $val;
}

function getparsedetail($designid,$userid,$username,$flag)
{
	$valid=$this->validateUser();

	if($valid!=TRUE)
	{
		header("Location:".$this->url("index/index"));
		exit(0);
	}
	else
	{
		//$designid=$this->getParam(1);//echo $designid;exit;

		$id=$userid;


		$user_name=trim($username);

		$modlusnumber=$this->tableid($user_name);

		$me=$this->getmessage(284);

		$db=new NesoteDALController();

		$db->select("nesote_chat_message_$modlusnumber");
		$db->fields("*");
		$db->where("userid=? and id=?",array($userid,$designid));
		$db->order("time desc");
		$gethistory=$db->query();
		$tot=$db->numRows($gethistory);$i=0;$j=0;
		while($gethistory1=$db->fetchRow($gethistory))

		{

			$receivers=$gethistory1[3];

			$receivers=explode(",",$receivers);

			$numberingthereciver=count($receivers);$name="";$name1="";$name2="";$name3="";
				
			for($nn=1;$nn<$numberingthereciver;$nn++)
			{
				$rece[$nn]=$receivers[$nn];
				$db->select("nesote_inoutscripts_users");
				$db->fields("username,name");
				$db->where("id=? and username!=?",array($rece[$nn],$user_name));
				$temp=$db->query();
				$temp1=$db->fetchRow($temp);

				$rev[$nn]=$temp1[0];

				$extn=$this->getextension();
				if($rev[$nn]!="")
				{
					$p1=$rev[$nn].",";
					//$p2=$temp1[1]." ".$temp1[2].",";
					$p2=$temp1[1];
					$p=$rev[$nn].$extn.",";
				}
				else
				{
					$p="";$p1="";$p2="";
				}
				$name.=$p2;
				$name1.=$p1;
				$name2.=$p2;
				$name3.=$p;



			}

			$xml=$gethistory1[4];

			$str = $xml;
			$chars = preg_split('/<item>/', $str,-1, PREG_SPLIT_OFFSET_CAPTURE);
			$count=count($chars);
			$lines=$count-1;
			$chars[$i][0]=str_replace("\n","<br>",$chars[$i][0]);
			$subject=$chars[1][0];


			$pattern = '/<id>(.+?)<\/id><time>(.+?)<\/time><sender>(.+?)<\/sender><message>(.+?)<\/message>/i';
			preg_match($pattern,$subject,$matches);
				


			$db->select("nesote_inoutscripts_users");
			$db->fields("username");
			$db->where("id=?",$matches[3]);
			$jet=$db->query();
			$jet1=$db->fetchRow($jet);

			$sendername=$jet1[0];


			if($sendername==$user_name)
			{
				$firstsender=$this->getmessage(284);

			}
			else
			{


				$firstsender=$sendername;

				if($name=="")
				$name.=$this->getfullname($sendername);

				if($name1=="")
				$name1.=$this->getfullname($sendername);
				if($name2=="")
				$name2.=$this->getfullname($sendername);
				if($name3=="")
				$name3.=$sendername.$this->getextension();


			}

			//$chattime=$matches[2];
			$chattime=$gethistory1[5];

			$reverse = strrev($name);
			if($reverse[0]==",")
			$name=substr($name,0,-1);

			$chat_messages[$j][0]=$matches[1];
			$chat_messages[$j][1]=$chattime;
			$chat_messages[$j][2]=$sendername;
			$chat_messages[$j][3]=$matches[4];
			$chat_messages[$j][4]=$firstsender;
			$chat_messages[$j][5]=$name;
			$chat_messages[$j][6]=$gethistory1[0];
			$chat_messages[$j][7]=$lines;
			$chat_messages[$j][8]=$gethistory1[6];

			$reverse1 = strrev($name1);
			if($reverse1[0]==",")
			$name1=substr($name1,0,-1);

			$reverse2 = strrev($name2);
			if($reverse2[0]==",")
			$name2=substr($name2,0,-1);

			$reverse3 = strrev($name3);
			if($reverse3[0]==",")
			$name3=substr($name3,0,-1);



			$tableid=$gethistory1[0];
			$chatid=$matches[1];
			$from=$name;

			if(strpos($from,",")!="")
			{
				$cnt1=explode(",",$from);
				$cnt=count($cnt1);
			}
			else if($from!="")
			$cnt=1;
			if($cnt>1)
			{
				$from=$me;
				$fromopen=$this->getName($userid);
				$to=$name1;
				$todtls=$name3;
				$fromopendtls=$this->getusername($userid).$this->getextension();
				$toreply=$todtls;

			}
			else
			{
				if($firstsender==$me)
				{
					$fromopen=$name2;
					$fromopendtls=$name3;
				}
				else
				{
					$fromopen=$this->getfullname($firstsender);
					$fromopendtls=$firstsender.$this->getextension();
				}

				$to=$me;
				$todtls=$username.$this->getextension();
				$toreply=$fromopendtls;

			}


			if($name3!=$me || $name3!=="")
			{
				$fromall=$name3.",".$user_name.$this->getextension();

			}
			else
			{
				$fromall=$user_name.$this->getextension();

			}

			$subj=$this->getmessage(384)." ".$name2."  (".$lines." lines)";
			$subj1=$this->getmessage(382)." ".$name2;
			$subj2=$this->getmessage(382)." ".$name2.",".$this->gettitlename($userid);

			$time=$this->gettimecurnt($chattime);
			$readflag=$gethistory1[6];
			$responders=$firstsender." - ".$chat_messages[$j][3];

			//$msg=$chat_messages[$j][3];

			$msg=$this->getchatmsg($tableid,$modlusnumber,$username);
			$msg1=strip_tags($msg);




			$contacts.=trim($tableid)."{nesote_t}";//0
			$contacts.=trim($chatid)."{nesote_t}";//1

			$contacts.=trim($from)."{nesote_t}";//2
			$contacts.=trim($subj)."{nesote_t}";//3
			$contacts.=trim($time)."{nesote_t}";//4
			$contacts.=trim($readflag)."{nesote_t}";//5
			$contacts.=trim($responders)."{nesote_t}";//6
			$contacts.=trim($to)."{nesote_t}";//7
			$contacts.=trim($msg)."{nesote_t}";//8
			$contacts.=trim($fromopen)."{nesote_t}";//9
			$contacts.=trim($subj1)."{nesote_t}";//10
			$contacts.=trim($fromall)."{nesote_t}";//11
			$contacts.=trim($subj2)."{nesote_t}";//12
			$contacts.=trim($fromopendtls)."{nesote_t}";//13
			$contacts.=trim($todtls)."{nesote_t}";//14
			$contacts.=trim($toreply)."{nesote_t}";//15
			$contacts.=trim($msg1)."{nesote_t}";//16
			if($flag==0)
			$contacts.=trim($chattime)."{nesote_t}";//17

			$i++;$j++;

		}

		$contacts=substr($contacts,0,-10);

		return $contacts;
	}
}

function  makelink($text)
{
	$new_str="";
	//echo $text;
	$y=0;
	while($text!="")
	{
		$count=strpos($text,"<a");
		if($count==0)
		$count=strpos($text,"&lt;a");
		if($count==false)
		$count=strpos($text,"&amp;lt;a");

		if($count!=0)
		{
			$result_string=substr($text,0,$count);
			$new_str.=$this->parse($result_string);
			$count2=strpos($text,"</a>");
			$add=4;
			if($count2=="")
			{
				$count2=strpos($text,"&lt;/a&gt;");
				$add=10;
			}
			if($count2=="")
			{
				$count2=strpos($text,"&amp;lt;/a&amp;gt;");
				$add=18;
			}
			if($count2!="")
			$length=($count2-$count)+$add;
			$result_string2=substr($text,$count,$length);
			$new_str.=$result_string2;
			$text=substr($text,$count2+$add);
		}
		else
		{//echo $count.";;;;";
				
			$new_str.=$this->parse($text);
			$text="";
			//return $new_str;
		}
		$y++;
	}
	return $new_str;
}
function parse($text)
{
	$pattern_url = '/(http|https|ftp)+(s)?:(\/\/)((\w|\.)+)(\/)?(\S+)?/i';
	preg_match_all($pattern_url, $text, $matches);

	for ($i=0; $i < count($matches[0]); $i++)
	{

		if (substr($matches[0][$i],0,4) == 'www.' )
		{

			$text = str_replace($matches[0][$i], '<a href="http://'.$matches[0][$i].'">'.$matches[0][$i].'</a>', $text);
		}
		if (substr($matches[0][$i],0,7) == 'http://' )
		{
				
			$text = str_replace("<".$matches[0][$i], '<a href="'.$matches[0][$i].'">'.$matches[0][$i].'</a>', $text);
		}
		if (substr($matches[0][$i],0,8) == 'https://' )
		{
				
			$text = str_replace("<".$matches[0][$i], '<a href="'.$matches[0][$i].'">'.$matches[0][$i].'</a>', $text);

		}

	}

	return $text;

}
// from mailcontrollererrrr
function closeandlookupAction()
{
	$chat_id=$this->getParam(1);
	$userid=$this->getParam(2);
	$flag=$this->getParam(3);
	$chatcnt=$this->getParam(5);

	$sender=$this->getId();
	$db1=new NesoteDALController();
	$db=new NesoteDALController();

	if($flag==0)
	{


		$db1->select("nesote_chat_session");
		$db1->fields("group_status");
		$db1->where("id=?", $chat_id);
		$result1=$db1->query();
		$row1=$db1->fetchRow($result1);

		if($row1[0]==1)//group chat
		{
			$fullname=$this->gettitlename($sender);
			$message="\n $fullname has left";


			$db1->select("nesote_chat_session_users");
			$db1->fields("user_id");
			$db1->where("chat_id=? and active_status=? and user_id!=?",array($chat_id,1,$sender));
			$rs1=$db1->query();
			$time=time();
			$time=$this->settime($time);
			while($row1=$db1->fetchRow($rs1))
			{

				$db->insert("nesote_chat_temporary_messages");
				$db->fields("chat_id,sender,responders,message,time,read_flag");
				$db->values(array($chat_id,0,$row1[0],$message,$time,0));
				$db->query();

			}

		}

		$db->update("nesote_chat_session_users");
		$db->set("active_status=? and typing_status=?",array(0,0));
		$db->where("chat_id=? and user_id=?",array($chat_id,$sender));
		$db->query();//echo $db->getQuery();exit;


	}
	$db1->select("nesote_chat_session_users");
	$db1->fields("chat_id");
	$db1->where("active_status=? and user_id=?",array(1,$sender));
	$db1->order("present_identified_time desc");
	$db1->limit(0,$chatcnt);
	$rs11=$db1->query();
	$nn=$db1->numRows($rs11);
	while($row11=$db1->fetchRow($rs11))
	{
		$ids.=$row11[0].",";
	}
	$ids=substr($ids,0,-1);

	if($nn>0 && $ids!="")
	{

		$db->update("nesote_chat_session_users");
		$db->set("active_status=? and typing_status=?",array(0,0));
		$db->where("chat_id NOT IN(".$ids.") and user_id=?",array($sender));
		$db->query();
	}


//	$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users"));
//	$db->fields("c.id,c.userid,c.image,c.custom_message,c.logout_status,c.chat_status,c.login_time,c.chatframesize,c.idle,u.id,u.username,u.password,u.firstname,u.lastname,u.sex,u.dateofbirth,u.country,u.remember_question,u.remember_answer,u.createdtime,u.lastlogin,u.status,u.memorysize,u.server_password,u.time_zone,u.alternate_email,u.smtp_username,c.signout");
//	$db->where("u.id=? and u.id=c.userid",$userid);
//	$result=$db->query();
//	$result1=$db->fetchRow($result);
	
	$db->select(array("u"=>"nesote_inoutscripts_users","c"=>"nesote_chat_users"));
	$db->fields("c.logout_status,c.chat_status,c.idle,u.name,c.signout");
	$db->where("u.id=? and u.id=c.userid",$userid);
	$result=$db->query();
	$result1=$db->fetchRow($result);

	//$name=$result1[12]." ".$result1[13];
     $name=$result1[3];
	$img="";
	if($result1[4]==1 || $result1[0]==1 || $result1[1]==5)
	$img="iconsCornner chat-o";
	else if($result1[2]==1)
	$img="iconsCornner chat-i";
	else if($result1[1]==1)
	$img="iconsCornner chat-a";
	elseif($result1[1]==2)
	$img="iconsCornner chat-b";
	elseif($result1[1]==3)
	$img="iconsCornner chat-i";
	elseif($result1[1]==4)
	$img="iconsCornner chat-o";


	$db->select("nesote_chat_session");
	$db->fields("group_status");
	$db->where("id=?",array($chat_id));
	$result=$db->query();
	$row10=$db->fetchRow($result);

	if($row10[0]==1)
	{



		$db->select("nesote_chat_session_users");
		$db->fields("user_id");
		$db->where("chat_id=? and active_status=? and user_id!=?", array($chat_id,1,$sender));
		$result=$db->query();$title1=$this->firstname($sender).",";$i=1;
		$num=$db->numRows($result);
		if($num>1)
		{
			//$img="images/groupchat.png";
				
			while($row=$db->fetchRow($result))
			{

				$title1.=$this->firstname($row[0]).",";$i++;
			}

			$title=substr($title1,0,-1);
			$title="(".$i.") ".$title;

			$length=strlen($title);
			if($length>12)
			$title=substr($title,0,12)."...";
			//$img="images/groupchat.png";
			$title="<img src=\"images/filler.gif\" class=\"iconsCornner chat-gp\" border=\"0\" align=\"absmiddle\">$title";
			$st=$title;
			echo $st."+*+".$chat_id;exit(0);
		}


	}

	$length=strlen($name);
	if($length>12)
	$name=substr($name,0,12)."...";


	$st="<img src=\"images/filler.gif\" class=\"$img\" border=\"0\" align=\"absmiddle\">$name";


	echo $st."+*+".$chat_id."+*+".$ids;exit(0);
}
function listsearchAction()
	{
		$validateUser=$this->validateUser();

		if($validateUser!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
        $this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$globaladdress_book=$settings->getValue("globaladdress_book");

		//$xmlDoc = new DOMDocument();
		//$xmlDoc->load("ajax/links.xml");

		//$x=$xmlDoc->getElementsByTagName('link');

		//get the q parameter from URL
		$q=$_GET["q"];
       // echo $q;
		//$q=strtoupper($q);

		//$admin_id=$this->getid();
		$user_id=$this->getId();
		$db=new NesoteDALController();
		
		
//		$db->select(array("c"=>"nesote_chat_contact"));
//		$db->fields("u.firstname,u.lastname,u.username,u.id");
//		$db->join(array("u"=>"nesote_users"),"c.receiver=u.id");
//		$db->where("(u.firstname like '$q%' or u.lastname like '$q%'or u.username like '$q%') and c.sender=? and u.status=? ",array($user_id,1));
//		$db->order("u.firstname asc");
//		$db->group("u.firstname");
//		$res=$db->query();//echo $db->getQuery();

	
		
//		$db->select(array("c"=>"nesote_chat_contact","u"=>"nesote_inoutscripts_users"));
//		$db->fields("u.name,u.username,u.id");		
//		$db->where("(u.name like '$q%' or  u.username like '$q%') and c.sender=? and u.status=? and c.receiver=u.id ",array($user_id,1));
//		$db->order("u.name asc");
//		$db->group("u.name");
//		$res=$db->query();//echo $db->getQuery();

		//	SELECT u.name,u.username,u.id FROM  nesote_inoutscripts_users u WHERE (u.name like '$q%' or u.username like '$q%')  and u.status='1'  GROUP BY u.name ORDER BY u.name asc

		if($globaladdress_book==1)
		{
		$db->select("nesote_inoutscripts_users");
		$db->fields("name,username,id");
		$db->where("(name like '$q%' or username like '$q%') and status=? and id!=?",array(1,$user_id));
		$db->order("name asc");
	//	$db->group("name");
		$res=$db->query();//echo $db->getQuery();
		}
		else
		{
//		$db->select(array("a"=>"nesote_inoutscripts_users","b"=>"nesote_email_contacts"));
//		$db->fields("a.name,a.username,a.id");
//		$db->where("(b.firstname like '$q%' or b.lastname like '$q%' or b.mailid like '$q%') and a.status=? and b.addedby=?  and a.id!=?",array(1,$user_id,$user_id));
//		$db->order("a.name asc");
//	//	$db->group("name");
//		$res=$db->query();echo $db->getQuery();
		
		$db->select(array("c"=>"nesote_chat_contact","u"=>"nesote_inoutscripts_users"));
		$db->fields("u.name,u.username,u.id");		
		$db->where("(u.name like '$q%' or  u.username like '$q%') and c.sender=? and u.status=? and c.receiver=u.id ",array($user_id,1));
		$db->order("u.name asc");
		$db->group("u.name");
		$res=$db->query();
		}
		
		
		$hint="";
		$i=0;
		while($row =$res->fetchRow())
		{
			$row[1]="&lt;".$row[1].$this->getextension()."&gt;";

			
			$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #eeeeee\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearch_invite_a_$i\"  onclick=\"javascript:setvaluefortb1_invite('$row[2]:$row[0]&nbsp;$row[1]')\" style='color:#666666;' >&nbsp;".$row[0]."&nbsp;".$row[1]."<input type='hidden' id=\"livesearch_invite_h_$i\" value=\"$row[2] \"><input type='hidden' id=\"livesearch_invite_m_$i\" value=\"$row[0]&nbsp;$row[1] \"></div></td></tr></table>";
			$i++;
		}

		// Set output to "no suggestion" if no hint were found
		// or to the correct values
		if ($hint == "")
		{
			$response="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #eeeeee\"><tr><td  nowrap=\"nowrap\"><span style='color:#999999'>".$this->getmessage(414)." '$q'</span></td></tr></table>";
		}
		else
		{
			$response=$hint;
		}
		$response.="<input type=\"hidden\" id=\"count_invite\" value=\"$i\">";
		//output the response
		echo "$response";
		exit(0);
	}
	function printmailChatAction()
	{
	
		$user_name=$_COOKIE['e_username'];
		$user_name=trim($user_name);
		$mailId=$this->getParam(1);
		$id=$this->getId();
	    $modlusnumber=$this->tableid($user_name);
        $msg=$this->getchatmsg($mailId,$modlusnumber,$user_name);
				
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$img=$settings->getValue("user_page_logo");
		$servicename=$settings->getValue("engine_name");
        $this->setValue("servicename",$servicename);
		$imgpath="admin/logo/$img";	
		$this->setValue("imgpath",$imgpath);
			
		$name=$this->getName($id)." <$user_name".$this->getextension().">";
		$this->setValue("name",$name);
		$to="";$cc="";$bcc="";


		$db=new NesoteDALController();
		$db->select("nesote_chat_message_$modlusnumber");
		$db->fields("*");
		$db->where("userid=? and id=?",array($id,$mailId));
		$db->order("time desc");
		$gethistory=$db->query();
		$tot=$db->numRows($gethistory);$i=0;$j=0;$me=$this->getmessage(284);
		while($gethistory1=$db->fetchRow($gethistory))
		{

			$receivers=$gethistory1[3];

			$receivers=explode(",",$receivers);

			$numberingthereciver=count($receivers);$name="";$name1="";$name2="";$name3="";
				
			for($nn=1;$nn<$numberingthereciver;$nn++)
			{
				$rece[$nn]=$receivers[$nn];
				$db->select("nesote_inoutscripts_users");
				$db->fields("username,name");
				$db->where("id=? and username!=?",array($rece[$nn],$user_name));
				$temp=$db->query();
				$temp1=$db->fetchRow($temp);

				$rev[$nn]=$temp1[0];

				$extn=$this->getextension();
				if($rev[$nn]!="")
				{
					$p1=$rev[$nn].",";
					//$p2=$temp1[1]." ".$temp1[2].",";
					$p2=$temp1[1];
					$p=$rev[$nn].$extn.",";
				}
				else
				{
					$p="";$p1="";$p2="";
				}
				$name.=$p2;
				$name1.=$p1;
				$name2.=$p2;
				$name3.=$p;



			}

			$xml=$gethistory1[4];

			$str = $xml;
			$chars = preg_split('/<item>/', $str,-1, PREG_SPLIT_OFFSET_CAPTURE);
			$count=count($chars);
			$lines=$count-1;
			$chars[$i][0]=str_replace("\n","<br>",$chars[$i][0]);
			$subject=$chars[1][0];


			$pattern = '/<id>(.+?)<\/id><time>(.+?)<\/time><sender>(.+?)<\/sender><message>(.+?)<\/message>/i';
			preg_match($pattern,$subject,$matches);
				


			$db->select("nesote_inoutscripts_users");
			$db->fields("username");
			$db->where("id=?",$matches[3]);
			$jet=$db->query();
			$jet1=$db->fetchRow($jet);

			$sendername=$jet1[0];


			if($sendername==$user_name)
			{
				$firstsender=$this->getmessage(284);

			}
			else
			{


				$firstsender=$sendername;

				if($name=="")
				$name.=$this->getfullname($sendername).",";

				if($name1=="")
				$name1.=$this->getfullname($sendername).",";
				if($name2=="")
				$name2.=$this->getfullname($sendername).",";
				if($name3=="")
				$name3.=$sendername.$this->getextension().",";


			}

			//$chattime=$matches[2];
			$chattime=$gethistory1[5];

			$reverse = strrev($name);
			if($reverse[0]==",")
			$name=substr($name,0,-1);

			$chat_messages[$j][0]=$matches[1];
			$chat_messages[$j][1]=$chattime;
			$chat_messages[$j][2]=$sendername;
			$chat_messages[$j][3]=$matches[4];
			$chat_messages[$j][4]=$firstsender;
			$chat_messages[$j][5]=$name;
			$chat_messages[$j][6]=$gethistory1[0];
			$chat_messages[$j][7]=$lines;
			$chat_messages[$j][8]=$gethistory1[6];

			$reverse1 = strrev($name1);
			if($reverse1[0]==",")
			$name1=substr($name1,0,-1);

			$reverse2 = strrev($name2);
			if($reverse2[0]==",")
			$name2=substr($name2,0,-1);

			$reverse3 = strrev($name3);
			if($reverse3[0]==",")
			$name3=substr($name3,0,-1);



			$tableid=$gethistory1[0];
			$chatid=$matches[1];
			$from=$name;

			if(strpos($from,",")!="")
			{
				$cnt1=explode(",",$from);
				$cnt=count($cnt1);
			}
			else if($from!="")
			$cnt=1;
			if($cnt>1)
			{
				$from=$me;
				$fromopen=$this->getName($userid);
				$to=$name1;
				$todtls=$name3;
				$fromopendtls=$this->getusername($userid).$this->getextension();
				$toreply=$todtls;

			}
			else
			{
				if($firstsender==$me)
				{
					$fromopen=$name2;
					$fromopendtls=$name3;
				}
				else
				{
					$fromopen=$this->getfullname($firstsender);
					$fromopendtls=$firstsender.$this->getextension();
				}

				$to=$me;
				$todtls=$_COOKIE['e_username'].$this->getextension();
				$toreply=$fromopendtls;

			}


			if($name3!=$me || $name3!=="")
			{
				$fromall=$name3.",".$user_name.$this->getextension();

			}
			else
			{
				$fromall=$user_name.$this->getextension();

			}

			$subj=$this->getmessage(384)." ".$name2."  (".$lines." lines)";
			$subj1=$this->getmessage(382)." ".$name2;
			$subj2=$this->getmessage(382)." ".$name2.",".$this->gettitlename($userid);

			$time=$this->gettime($chattime,$user_name);
			$tt=$this->gettimeforchat($chattime);
			$readflag=$gethistory1[6];
			$responders=$firstsender." - ".$chat_messages[$j][3];
			$i++;$j++;

		}
		

$time1=date("D, M d, Y h:i:s A",$tt);
//$time1=$time;
$row[1]=$from;$row[2]=$this->getmessage(31).": ".$todtls;$row[3]="";$row[5]=$subj;$row[6]=$msg;
$from =$row[1];
$to = $row[2];
$cc = $row[3];
$subj = $row[5];
$body = $row[6];
if($subj!="")
$subjtitle=$servicename." - ".$subj;
else
$subjtitle=$servicename;
$this->setValue("subjtitle",$subjtitle);$this->setValue("subj",$subj);
$this->setValue("from",$from);$this->setValue("time1",$time1);
$this->setValue("to",$to);$this->setValue("cc",$cc);
$this->setValue("body",$body);


	}

function getusertime()
	{
		
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
			
			//echo $ts."++++++";
			$userid=$this->getId();
			$db3= new NesoteDALController();
			$db3->select("nesote_email_usersettings");
			$db3->fields("time_zone");
			$db3->where("userid=?",array($userid));
			$res3=$db3->query();
			$row3=$db3->fetchRow($res3);
			//return $row3[0];
			$db3->select("nesote_email_time_zone");
			$db3->fields("value");
			$db3->where("id=?",array($row3[0]));
			$res3=$db3->query();
			$row3=$db3->fetchRow($res3);
			$timezone=$row3[0];
			//echo $timezone."__________";
			$sign=trim($timezone[0]);
			$timezone1=substr($timezone,1);

			$timezone1=explode(":",$timezone1);
			$newtimezone=($timezone1[0]*60*60)+($timezone1[1]*60);

			if($sign=="+")
			$newtimezone=$newtimezone;
			if($sign=="-")
			$newtimezone=-$newtimezone;
//	$ts=time()+$newtimezone;

			$time=$ts+$newtimezone;
		//	$time=$ts;
			return $time;
		
	}
function saveLogs($operation,$comment)
	{
		$userid=$this->getId();
		$insert=new NesoteDALController();
		$insert->insert("nesote_email_client_logs");
		$insert->fields("uid,operation,comment,time");
		$insert->values(array($userid,$operation,$comment,time()));
		$insert->query();
	}

};
?>
