<?php
class MailController extends NesoteController
{

	function attachcount($folder,$mail)
	{

		$username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);
		$db=new NesoteDALController();
		$db->select("nesote_email_attachments_$tablenumber");
		$db->fields("id");
		$db->where("folderid=? and mailid=? and attachment=?",array($folder,$mail,1));
		$res=$db->query();
		$number=$db->numRows($res);
		return $number;

	}

	function short_subject($sub)
	{
		$sub=strip_tags($sub);
		$brief=substr($sub,0,20);
		return $brief;
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
	function tableid($username)
    {
		$user_name=$username;
		include("../config.php");
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
	function getstar_shortmail($mailid,$folderid)
	{
		$username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);
			
		$db=new NesoteDALController();
		if($folderid==1)
		$db->select("nesote_email_inbox_$tablenumber");
		else if($folderid==2)
		$db->select("nesote_email_draft_$tablenumber");
		else if($folderid==3)
		$db->select("nesote_email_sent_$tablenumber");
		else if($folderid==4)
		$db->select("nesote_email_spam_$tablenumber");
		else if($folderid==5)
		$db->select("nesote_email_trash_$tablenumber");
		else if($folderid>=10)
		$db->select("nesote_email_customfolder_mapping_$tablenumber");
		$db->fields("mail_references");
		$db->where("id=?",array($mailid));
		$rs=$db->query();
		$row=$db->fetchRow($rs);
		$references=$row[0];
		preg_match_all('/<item>(.+?)<\/item>/i',$references,$reply);

		$no=count($reply[1]);
		$w=0;
		for($i=0;$i<$no;$i++)
		{
			preg_match('/<mailid>(.+?)<\/mailid>/i',$reply[1][$i],$mail[$i]);
			preg_match('/<folderid>(.+?)<\/folderid>/i',$reply[1][$i],$folder[$i]);

			if($folder[$i][1]==1)
			$db->select("nesote_email_inbox_$tablenumber");
			else if($folder[$i][1]==2)
			$db->select("nesote_email_draft_$tablenumber");
			else if($folder[$i][1]==3)
			$db->select("nesote_email_sent_$tablenumber");
			else if($folder[$i][1]==4)
			$db->select("nesote_email_spam_$tablenumber");
			else if($folder[$i][1]>=10)
			$db->select("nesote_email_customfolder_mapping_$tablenumber");
			$db->fields("starflag");
			$db->where("id=?",array($mail[$i][1]));
			$rs=$db->query();
			$rows=$db->fetchRow($rs);
			if($rows[0]==1)
			{
				$w=1;
				break;
			}
		}


		if($w==0)
		return "<a href=\"javascript:markstar($mailid,$folderid)\"><img src=\"../images/filler.gif\" alt=\" \" border=\"0\" align=\"absmiddle\" class=\"iconsCornner str-g\"/></a>";
		else
		return "<a href=\"javascript:unmarkstar($mailid,$folderid)\"><img src=\"../images/filler.gif\" alt=\" \" border=\"0\" align=\"absmiddle\" class=\"iconsCornner str-y\"/></a>";
	}
	function validateUser()
	{
		$username=$_COOKIE['e_username'];
		$password=$_COOKIE['e_password'];
		$db=new NesoteDALController();
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


	function mailboxAction()
	{

		$valid=$this->validateUser();

		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

			$username=$_COOKIE['e_username'];
			$uname=$username;
			$this->setValue("uname",$uname);
			
		$tablenumber=$this->tableid($username);
		$db=new NesoteDALController();
		$db->select("nesote_email_settings");
		$db->fields("value");
		$db->where("name='public_page_logo'");
		$result1=$db->query();
		$row1=$db->fetchRow($result1);
		$img=$row1[0];
		$imgpath="../admin/logo/".$img;

//$this->setValue("imgpath","images/banner.png");
		$this->setValue("imgpath",$imgpath);
		
		

		$id=$this->getId();
		$this->setValue("uid",$id);

		
			
		$db->select("nesote_email_settings");
		$db->fields("value");
		$db->where("name='engine_name'");
		$result=$db->query();
		$row=$db->fetchRow($result);
		$servicename=$row[0];
		$this->setValue("servicename",$servicename);


		$db->select("nesote_email_customfolder");
		$db->fields("id,name");
		$db->where("userid=?",array($id));
		$res1=$db->query();
		$i=0;
		while($rw=$db->fetchRow($res1))
		{
			$db1=new NesoteDALController();
			$db1->select("nesote_email_customfolder_mapping_$tablenumber");
			$db1->fields("distinct mail_references");
			$db1->where("folderid=?",array($rw[0]));
			$db1->order("time desc");
			$result1=$db1->query();
			$count=$db1->numRows($result1);


			$db1->select("nesote_email_customfolder_mapping_$tablenumber");
			$db1->fields("distinct mail_references");
			$db1->where("folderid=? and readflag=?",array($rw[0],0));
			$db1->order("time desc");
			$result1=$db1->query();
			$count1=$db1->numRows($result1);

			$customFolder[$i][0]=$rw[0];
			$customFolder[$i][1]=$rw[1];
			$customFolder[$i][2]=$count;
			$customFolder[$i][3]=$count11;
			$countCookie="custom".$rw[0];
			setcookie($countCookie,$count,"0","/");
			$i++;
		}
		$this->setValue("mpcount",$i);
		$this->setLoopValue("customfolders",$customFolder);

	
		$perpagesize=20;
			
		$all=0;
		$flag=0;
		$folder=$this->getParam(1);
		if(!isset($folder))
		$folder=1;

	setcookie("folderdetailid",$folder,0,"/");
		setcookie("folderid",$folder,0,"/");
		$this->setValue("fid",$folder);
		$this->setValue("perpagesize",$perpagesize);


		$page=$this->getParam(2);
		if(isset($page))
	{$pq=$page;	$this->setValue("page",$page);}
		else
		{$pq=1;$this->setValue("page",1);}
			
			


		$msg=$this->getParam(3);$more=0;$action="";

		if($msg===0)
		{
			$msg="";$more=0;
		}
		else if($msg==-1)
		{
			$msg="";$more=1;
		}
		else if($msg=="r" || $msg=="d" || $msg=="m")
		{
			$action=$msg;$msg="";
		}
		$this->setValue("action",$action);
		$this->setValue("more",$more);
		if(isset($msg))
		{
			$p=base64_decode($msg);
			$msg1=explode("@@",$p);
			if($msg1[1]!="")
			{
				$msg=$this->getmessage($msg1[0]);
				$msg=str_replace("{number}",$msg1[1],$msg);
			}
			else
			$msg=$this->getmessage($msg1[0]);

			$this->setValue("msg",$msg);
		}
		else
		$this->setValue("msg","");
    $submit=$_POST['submit']; $search="";
    if(isset($submit))
	 {
	$search=$_POST['search'];
	 }
		
		if($search!="")
		{
			$flag=1;

			$folder=$_POST['folder'];
			$this->setValue("searchflag",1);
			$this->setValue("allsearch",1);
			$this->setValue("search",$search);
			$this->setValue("searchresult",$folder);
		}
		else
		{
			$this->setValue("searchflag",0);

		}
		$heading=$this->getheading($folder,$search);
		
		$this->setValue("heading",$heading);
		$i=0;
		if($folder==1)
		{
			$db->select("nesote_email_inbox_$tablenumber");
			$db->fields("*");
			if($flag==1)
			{
				$db->where("userid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",$id);
			}
			else
			{
				$db->where("userid=?",$id);
			}
			$db->order("time desc");
			$db->limit(0,1);
			$res=$db->query();
			$row=$db->fetchRow($res);
			$url=$this->url('mail/detailmail/'.$folder.'/'.$row[0]);
			
			$db->select("nesote_email_inbox_$tablenumber");
			$db->fields("*");
			if($flag==1)
			{
				$db->where("userid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",$id);
			}
			else
			{
				$db->where("userid=?",$id);
			}
			$db->order("time desc");

			$res=$db->query();
			$max=$db->numRows($res);
			$page=$this->getParam(2);



			$db->select("nesote_email_inbox_$tablenumber");
			$db->fields("*");
			if($flag==1)
			{
				$db->where("userid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",$id);
			}
			else
			{
				$db->where("userid=?",$id);
			}
			$db->order("time desc");
			$startpage=($pq-1)*$perpagesize;
			$db->limit($startpage,$perpagesize);

			$res=$db->query();

			while($row=$db->fetchRow($res))
			{
				$db->select("nesote_email_attachments_$tablenumber");
				$db->fields("*");
				$db->where("mailid=? and folderid=? and attachment=?",array($row[0],1,1));
				$rs=$db->query();
				$rw1=$db->numRows($rs);
				if($rw1>0)
				{
					$flag1=1;
				}
				else
				{
					$flag1=0;
				}

				$mail_1[$i][0]=$row[0];
				$mail_1[$i][1]=$row[1];
				$mail_1[$i][2]=$row[2];
				$mail_1[$i][3]=$row[3];
				$mail_1[$i][4]=$row[4];
				$mail_1[$i][5]=$row[5];
				$mail_1[$i][6]=$this->short_subject($row[6]);
				preg_match('/<img(.+?)src=(.+?)>/i',$row[7],$cset1);
				if($cset1[2]!="")
				$row[7]=str_replace("attachments/","../attachments/",$cset1[2]);
				$mail_1[$i][7]=$row[7];
				
				$mail_1[$i][8]=$row[8];
				$mail_1[$i][9]=$row[9];
				$mail_1[$i][10]=$row[10];
				$mail_1[$i][11]=$row[11];
				$mail_1[$i][12]=$row[12];
				$mail_1[$i][13]=1;
				$mail_1[$i][14]=$row[13];
				$mail_1[$i][15]=$row[14];
				$mail_1[$i][16]=$flag1;
				$mail_1[$i][17]=$row[15];
				$i++;
			}
			$mail[0]=$mail_1[0];
			for($r=1,$w=1;$r<count($mail_1);$r++)
			{

				$flag0=0;
				for($a=0;$a<count($mail);$a++)
				{
					if($mail_1[$r][15]==$mail[$a][15])
					{
						$flag0=1;
						if($mail_1[$r][16]==1)
						$mail[$a][16]=1;
						if($mail[$a][10]==1)
						$mail_1[$r][10]=1;
					}
				}
				if($flag0==0)
				{

					$mail[$w]=$mail_1[$r];
					$w++;
				}
			}

			if(!isset($page))
			{
				$page=1;
			}
			/*$p=$page;
			$index=($p-1)*$perpagesize;
			for($r=0;$r<$perpagesize;$r++,$index++)
			{
				if($index>=$max)
				break;
				$mail_new[$r]=$mail[$index];
			}*/


			$this->setValue("firstid",$mail[0][0]);
			$this->setLoopValue("mail",$mail);



			$nmbr=count($mail);
			if($mail[0][0]=="")
			$nmbr=0;


			if($page>$w)
			{
				$page=1;
				$startpage=0;

			}
			$startpage=($page-1)*$perpagesize;

			if($startpage<0)//for firsttime
			{

				$page=1;
				$startpage=0;
			}


			$this->setValue("array_count",$nmbr);
			$this->setValue("number",$nmbr);



			$previouspage=$page-1;$s1=0;$s2=0;
			$pagelink="<div class=\"pagingtbl\">";
			if($page!=1)
			{
				$s1=1;	
				$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$previouspage")."\" class=\"commonBtn1\">".$this->getmessage(432)."</a>";
			}
			$nextpage=$page+1;
			if($page*$perpagesize<($max))//if($page*10<=($total+10))
			{
					$s2=1;
				$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$nextpage")."\" class=\"commonBtn1\">".$this->getmessage(433)."</a>";
			}
			$pagelink.="</div>";$s=$s1+$s2;
			$this->setValue("show",$s);
			$this->setValue("pagelink",$pagelink);



		}
		elseif($folder==2)
		{

			$db->select("nesote_email_draft_$tablenumber");
			$db->fields("*");
			if($flag==1)
			{
				$db->where("userid=? and just_insert=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",array($id,0));
			}
			else
			{
				$db->where("userid=? and just_insert=?",array($id,0));
			}
			$db->order("time desc");
			$db->limit(0, 1);
			$res=$db->query();
			$row=$db->fetchRow($res);
			$db->select("nesote_email_draft_$tablenumber");
			$db->fields("*");
			if($flag==1)
			{
				$db->where("userid=? and just_insert=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",array($id,0));
			}
			else
			{
				$db->where("userid=? and just_insert=?",array($id,0));
			}
			$db->order("time desc");
			$res=$db->query();
            $no=$db->numRows($res);$nod=$no;

			

			$db->select("nesote_email_draft_$tablenumber");
			$db->fields("*");
			if($flag==1)
			{
				$db->where("userid=? and just_insert=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",array($id,0));
			}
			else
			{
				$db->where("userid=? and just_insert=?",array($id,0));
			}
			$db->order("time desc");
			$page=$this->getParam(2);
			$startpage=($pq-1)*$perpagesize;
			$db->limit($startpage,$perpagesize);
			$res=$db->query();

			while($row=$db->fetchRow($res))
			{
				$db->select("nesote_email_attachments_$tablenumber");
				$db->fields("*");
				$db->where("mailid=? and folderid=? and attachment=?",array($row[0],2,1));
				$rs=$db->query();
				$rw1=$db->numRows($rs);
				if($rw1>0)
				{
					$flag1=1;
				}
				else
				{
					$flag1=0;
				}
				$mail_1[$i][0]=$row[0];
				$mail_1[$i][1]=$row[1];
				$mail_1[$i][2]=$row[2];
				$mail_1[$i][3]=$row[3];
				$mail_1[$i][4]=$row[4];
				$mail_1[$i][5]=$row[5];
				$mail_1[$i][6]=$row[6];
				$mail_1[$i][6]=$this->short_subject($row[6]);
				preg_match('/<img(.+?)src=(.+?)>/i',$row[7],$cset1);
						if($cset1[2]!="")
				$row[7]=str_replace("attachments/","../attachments/",$cset1[2]);
				$mail_1[$i][7]=$row[7];
				$mail_1[$i][8]=$row[8];
				$mail_1[$i][9]=$row[9];
				$mail_1[$i][10]=$row[10];
				$mail_1[$i][11]=$row[11];
				$mail_1[$i][12]=$row[12];
				$mail_1[$i][13]=2;
				$mail_1[$i][14]=$row[13];
				$mail_1[$i][15]=$row[14];
				$mail_1[$i][16]=$flag1;
				//$mail_1[$i][17]=$row[15];
				$i++;
			}
			$mail[0]=$mail_1[0];
			for($r=1,$w=1;$r<count($mail_1);$r++)
			{

				$flag0=0;
				for($a=0;$a<count($mail);$a++)
				{
					if($mail_1[$r][15]==$mail[$a][15])
					{
						$flag0=1;
						if($mail_1[$r][16]==1)
						$mail[$a][16]=1;
						if($mail[$a][10]==1)
						$mail_1[$r][10]=1;
					}
				}
				if($flag0==0)
				{

					$mail[$w]=$mail_1[$r];
					$w++;
				}
			}

			if(!isset($page))
			{
				$page=1;
			}
			/*$p=$page;
			$index=($p-1)*$perpagesize;
			for($r=0;$r<$perpagesize;$r++,$index++)
			{
				if($index>=$w)
				break;
				$mail_new[$r]=$mail[$index];
			}*/


			if($page>$w)
			{
				$page=1;
				$startpage=0;

			}
			$startpage=($page-1)*$perpagesize;

			if($startpage<0)//for firsttime
			{

				$page=1;
				$startpage=0;
			}


			$this->setValue("firstid",$mail[0][0]);
			$this->setLoopValue("mail",$mail);
			$nmbr=count($mail);
			if($mail[0][0]=="")
			$nmbr=0;
			$this->setValue("array_count",$nmbr);
			$this->setValue("number",$nmbr);

			$previouspage=$page-1;$s1=0;$s2=0;
			$pagelink="<div class=\"pagingtbl\">";
			if($page!=1)
			{
				$s1=1;	
				$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$previouspage")."\" class=\"commonBtn1\">".$this->getmessage(432)."</a>";
			}
			

			$nextpage=$page+1;
			if($page*$perpagesize<($nod))
			{
				$s2=1;	
				$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$nextpage")."\" class=\"commonBtn1\">".$this->getmessage(433)."</a>";
			}
			$pagelink.="</div>";
			$s=$s1+$s2;
            $this->setValue("show",$s);
			$this->setValue("pagelink",$pagelink);
			
		}
		elseif($folder==3)
		{

			$db->select("nesote_email_sent_$tablenumber");

			$db->fields("*");
			if($flag==1)
			{
				$db->where("userid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",$id);
			}
			else
			{
				$db->where("userid=?",$id);
			}
			$db->order("time desc");
			$db->limit(0,1);
			$res=$db->query();
			$row=$db->fetchRow($res);
			$db->select("nesote_email_sent_$tablenumber");
			$db->fields("*");
			if($flag==1)
			{
				$db->where("userid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",$id);
			}
			else
			{
				$db->where("userid=?",$id);
			}
			$db->order("time desc");

			$res=$db->query();
		   $no=$db->numRows($res);$nos=$no;
			$db->select("nesote_email_sent_$tablenumber");
			$db->fields("*");
			if($flag==1)
			{
				$db->where("userid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",$id);
			}
			else
			{
				$db->where("userid=?",$id);
			}
			$db->order("time desc");
			$page=$this->getParam(2);
			$startpage=($pq-1)*$perpagesize;
			$db->limit($startpage,$perpagesize);
			$res=$db->query();
			while($row=$db->fetchRow($res))
			{
				$db->select("nesote_email_attachments_$tablenumber");
				$db->fields("*");
				$db->where("mailid=? and folderid=? and attachment=?",array($row[0],3,1));
				$rs=$db->query();
				$rw1=$db->numRows($rs);
				if($rw1>0)
				{
					$flag1=1;
				}
				else
				{
					$flag1=0;
				}
				$mail_1[$i][0]=$row[0];
				$mail_1[$i][1]=$row[1];
				$mail_1[$i][2]=$row[2];
				$mail_1[$i][3]=$row[3];
				$mail_1[$i][4]=$row[4];
				$mail_1[$i][5]=$row[5];
				$mail_1[$i][6]=$row[6];
				$mail_1[$i][6]=$this->short_subject($row[6]);
				preg_match('/<img(.+?)src=(.+?)>/i',$row[7],$cset1);
						if($cset1[2]!="")
				$row[7]=str_replace("attachments/","../attachments/",$cset1[2]);
				$mail_1[$i][7]=$row[7];
				$mail_1[$i][8]=$row[8];
				$mail_1[$i][9]=$row[9];
				$mail_1[$i][10]=$row[10];
				$mail_1[$i][11]=$row[11];
				$mail_1[$i][12]=$row[12];
				$mail_1[$i][13]=3;
				$mail_1[$i][14]=$row[13];
				$mail_1[$i][15]=$row[14];
				$mail_1[$i][16]=$flag1;
				$mail_1[$i][17]=$row[15];
				$i++;
			}
			$mail[0]=$mail_1[0];
			for($r=1,$w=1;$r<count($mail_1);$r++)
			{

				$flag0=0;
				for($a=0;$a<count($mail);$a++)
				{
					if($mail_1[$r][15]==$mail[$a][15])
					{
						$flag0=1;
						if($mail_1[$r][16]==1)
						$mail[$a][16]=1;
						if($mail[$a][10]==1)
						$mail_1[$r][10]=1;
					}
				}
				if($flag0==0)
				{

					$mail[$w]=$mail_1[$r];
					$w++;
				}
			}

			if(!isset($page))
			{
				$page=1;
			}
			/*$p=$page;
			$index=($p-1)*$perpagesize;
			for($r=0;$r<$perpagesize;$r++,$index++)
			{
				if($index>=$w)
				break;
				$mail_new[$r]=$mail[$index];
			}*/


			if($page>$w)
			{
				$page=1;
				$startpage=0;

			}
			$startpage=($page-1)*$perpagesize;

			if($startpage<0)//for firsttime
			{

				$page=1;
				$startpage=0;
				//$db->limit($startpage,$perpagesize);
			}


			$this->setLoopValue("mail",$mail);
			$this->setValue("firstid",$mail[0][0]);
			$nmbr=count($mail);
			if($mail[0][0]=="")
			$nmbr=0;
			$this->setValue("array_count",$nmbr);
			$this->setValue("number",$nmbr);

			$previouspage=$page-1;$s1=0;$s2=0;
			$pagelink="<div class=\"pagingtbl\">";
			if($page!=1)
			{
					$s1=1;
				$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$previouspage")."\" class=\"commonBtn1\">".$this->getmessage(432)."</a>";
			}
			//else
			//$pagelink.="<td align=\"left\">&nbsp;</td>";

			$nextpage=$page+1;
			if($page*$perpagesize<($nos))//if($page*10<=($total+10))
			{
				$s2=1;	
				$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$nextpage")."\" class=\"commonBtn1\">".$this->getmessage(433)."</a>";
			}
			//else
			//$pagelink.="<td align=\"right\" style=\"padding-right: 2px;\">&nbsp;</td>";
			$pagelink.="</div>";$s=$s1+$s2;
            $this->setValue("show",$s);
			$this->setValue("pagelink",$pagelink);
		}
		elseif($folder==4)
		{

			$db->select("nesote_email_spam_$tablenumber");

			$db->fields("*");
			if($flag==1)
			{
				$db->where("userid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",$id);
			}
			else
			{
				$db->where("userid=?",$id);
			}
			$db->order("time desc");
			$db->limit(0,1);
			$res=$db->query();
			$row=$db->fetchRow($res);
			$db->select("nesote_email_spam_$tablenumber");
			$db->fields("*");
			if($flag==1)
			{
				$db->where("userid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",$id);
			}
			else
			{
				$db->where("userid=?",$id);
			}
			$db->order("time desc");
			$res=$db->query();
			$no=$db->numRows($res);$nosp=$no;
			$db->select("nesote_email_spam_$tablenumber");
			$db->fields("*");
			if($flag==1)
			{
				$db->where("userid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",$id);
			}
			else
			{
				$db->where("userid=?",$id);
			}
			$db->order("time desc");
			$page=$this->getParam(2);
			$startpage=($pq-1)*$perpagesize;
			$db->limit($startpage,$perpagesize);
			$res=$db->query();
			while($row=$db->fetchRow($res))
			{
				$db->select("nesote_email_attachments_$tablenumber");
				$db->fields("*");
				$db->where("mailid=? and folderid=? and attachment=?",array($row[0],4,1));
				$rs=$db->query();
				$rw1=$db->numRows($rs);
				if($rw1>0)
				{
					$flag1=1;
				}
				else
				{
					$flag1=0;
				}
				$mail_1[$i][0]=$row[0];
				$mail_1[$i][1]=$row[1];
				$mail_1[$i][2]=$row[2];
				$mail_1[$i][3]=$row[3];
				$mail_1[$i][4]=$row[4];
				$mail_1[$i][5]=$row[5];
				$mail_1[$i][6]=$row[6];
				$mail_1[$i][6]=$this->short_subject($row[6]);
				preg_match('/<img(.+?)src=(.+?)>/i',$row[7],$cset1);
						if($cset1[2]!="")
				$row[7]=str_replace("attachments/","../attachments/",$cset1[2]);
				$mail_1[$i][7]=$row[7];
				$mail_1[$i][8]=$row[8];
				$mail_1[$i][9]=$row[9];
				$mail_1[$i][10]=$row[10];
				$mail_1[$i][11]=$row[11];
				$mail_1[$i][12]=$row[12];
				$mail_1[$i][13]=4;
				$mail_1[$i][14]=$row[13];
				$mail_1[$i][15]=$row[14];
				$mail_1[$i][16]=$flag1;
				$mail_1[$i][17]=$row[15];
				$i++;
			}
			$mail[0]=$mail_1[0];
			for($r=1,$w=1;$r<count($mail_1);$r++)
			{

				$flag0=0;
				for($a=0;$a<count($mail);$a++)
				{
					if($mail_1[$r][15]==$mail[$a][15])
					{
						$flag0=1;
						if($mail_1[$r][16]==1)
						$mail[$a][16]=1;
						if($mail[$a][10]==1)
						$mail_1[$r][10]=1;
					}
				}
				if($flag0==0)
				{

					$mail[$w]=$mail_1[$r];
					$w++;
				}
			}
			if(!isset($page))
			{
				$page=1;
			}
			/*$p=$page;
			$index=($p-1)*$perpagesize;
			for($r=0;$r<$perpagesize;$r++,$index++)
			{
				if($index>=$w)
				break;
				$mail_new[$r]=$mail[$index];
			}*/


			if($page>$w)
			{
				$page=1;
				$startpage=0;

			}
			$startpage=($page-1)*$perpagesize;

			if($startpage<0)//for firsttime
			{

				$page=1;
				$startpage=0;
				//$db->limit($startpage,$perpagesize);
			}
			$this->setLoopValue("mail",$mail);
			$this->setValue("firstid",$mail[0][0]);
			$nmbr=count($mail);
			if($mail[0][0]=="")
			$nmbr=0;
			$this->setValue("array_count",$nmbr);
			$this->setValue("number",$nmbr);

			$previouspage=$page-1;$s1=0;$s2=0;
			$pagelink="<div class=\"pagingtbl\" >";
			if($page!=1)
			{
					$s1=1;
				$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$previouspage")."\" class=\"commonBtn1\">".$this->getmessage(432)."</a>";
			}
			//else
			//$pagelink.="<td align=\"left\">&nbsp;</td>";

			$nextpage=$page+1;
			if($page*$perpagesize<($nosp))//if($page*10<=($total+10))
			{
					$s2=1;
				$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$nextpage")."\" class=\"commonBtn1\">".$this->getmessage(433)."</a>";
			}
			//else
			//$pagelink.="<td align=\"right\" style=\"padding-right: 2px;\">&nbsp;</td>";
			$pagelink.="</div>";$s=$s1+$s2;
$this->setValue("show",$s);	
			$this->setValue("pagelink",$pagelink);
		}
		elseif($folder==5)
		{

			$db->select("nesote_email_trash_$tablenumber");


			$db->fields("*");

			$db->where("userid=?",$id);

			$db->order("time desc");
			$db->limit(0,1);
			$res=$db->query();
			$row=$db->fetchRow($res);
			$db->select("nesote_email_trash_$tablenumber");
			$db->fields("*");

			$db->where("userid=?",$id);

			$db->order("time desc");
			$res=$db->query();
			$no=$db->numRows($res);$not=$no;
			
			$db->select("nesote_email_trash_$tablenumber");
			$db->fields("*");

			$db->where("userid=?",$id);

			$db->order("time desc");
			$page=$this->getParam(2);
			$startpage=($pq-1)*$perpagesize;
			$db->limit($startpage,$perpagesize);
			$res=$db->query();
			while($row=$db->fetchRow($res))
			{
				$db->select("nesote_email_attachments_$tablenumber");
				$db->fields("*");
				$db->where("mailid=? and folderid=? and attachment=?",array($row[0],5,1));
				$rs=$db->query();
				$rw1=$db->numRows($rs);
				if($rw1>0)
				{
					$flag1=1;
				}
				else
				{
					$flag1=0;
				}
				$mail_1[$i][0]=$row[0];
				$mail_1[$i][1]=$row[1];
				$mail_1[$i][2]=$row[2];
				$mail_1[$i][3]=$row[3];
				$mail_1[$i][4]=$row[4];
				$mail_1[$i][5]=$row[5];
				$mail_1[$i][6]=$row[6];
				$mail_1[$i][6]=$this->short_subject($row[6]);
				preg_match('/<img(.+?)src=(.+?)>/i',$row[7],$cset1);
						if($cset1[2]!="")
				$row[7]=str_replace("attachments/","../attachments/",$cset1[2]);
				$mail_1[$i][7]=$row[7];
				$mail_1[$i][8]=$row[8];
				$mail_1[$i][9]=$row[9];
				$mail_1[$i][10]=$row[10];
				$mail_1[$i][11]=$row[11];
				$mail_1[$i][12]=$row[12];
				$mail_1[$i][13]=5;
				$mail_1[$i][14]=$row[13];
				$mail_1[$i][15]=$row[14];
				$mail_1[$i][16]=$flag1;
				$mail_1[$i][17]=$row[15];
				$i++;
			}
			$mail[0]=$mail_1[0];
			for($r=1,$w=1;$r<count($mail_1);$r++)
			{

				$flag0=0;
				for($a=0;$a<count($mail);$a++)
				{
					if($mail_1[$r][15]==$mail[$a][15])
					{
						$flag0=1;
						if($mail_1[$r][16]==1)
						$mail[$a][16]=1;
					}
				}
				if($flag0==0)
				{

					$mail[$w]=$mail_1[$r];
					$w++;
				}
			}

			if(!isset($page))
			{
				$page=1;
			}
			/*$p=$page;
			$index=($p-1)*$perpagesize;
			for($r=0;$r<$perpagesize;$r++,$index++)
			{
				if($index>=$w)
				break;
				$mail_new[$r]=$mail[$index];
			}*/


			if($page>$w)
			{
			$page=1;
			$startpage=0;

			}
			$startpage=($page-1)*$perpagesize;

			if($startpage<0)//for firsttime
			{

				$page=1;
				$startpage=0;
				//$db->limit($startpage,$perpagesize);
			}
			$this->setLoopValue("mail",$mail);
			$this->setValue("firstid",$mail[0][0]);
			$nmbr=count($mail);
			if($mail[0][0]=="")
			$nmbr=0;
			$this->setValue("array_count",$nmbr);
			$this->setValue("number",$nmbr);

			$previouspage=$page-1;$s1=0;$s2=0;
			$pagelink="<div class=\"pagingtbl\">";
			if($page!=1)
			{$s1=1;
					
				$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$previouspage")."\" class=\"commonBtn1\">".$this->getmessage(432)."</a>";
			}
			//else
			//$pagelink.="<td align=\"left\">&nbsp;</td>";

			$nextpage=$page+1;
			if($page*$perpagesize<($not))//if($page*10<=($total+10))
			{
				$s2=1;	
				$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$nextpage")."\" class=\"commonBtn1\">".$this->getmessage(433)."</a>";
			}
			//else
			//$pagelink.="<td align=\"right\" style=\"padding-right: 2px;\">&nbsp;</td>";
			$pagelink.="</div>";$s=$s1+$s2;
$this->setValue("show",$s);	
			$this->setValue("pagelink",$pagelink);
		}

		elseif($folder==0)
		{
			$i=0;$s=0;$t=0;$d=0;$c=0;
			$all=1;

			$mail=array();
			//starred mail
			$db1=new NesoteDALController();
			$db1->select("nesote_email_inbox_$tablenumber");
			$db1->fields("*");
			$db1->where("userid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%')",array($id));
			$db1->order("time asc");
			$res1=$db1->query();
			$no1=$db1->numRows($res1);

			if($no1!=0)
			{
				//echo $db1->getQuery();
				while($row=$db1->fetchRow($res1))
				{
					$db->select("nesote_email_attachments_$tablenumber");
					$db->fields("*");
					$db->where("mailid=? and folderid=? and attachment=?",array($row[0],1,1));
					$rs=$db->query();
					$rw1=$db->numRows($rs);
					if($rw1>0)
					{
						$flag1=1;
					}
					else
					{
						$flag1=0;
					}
					$mail_1[$i][0]=$row[0];
					$mail_1[$i][1]=$row[1];
					$mail_1[$i][2]=$row[2];
					$mail_1[$i][3]=$row[3];
					$mail_1[$i][4]=$row[4];
					$mail_1[$i][5]=$row[5];
					$mail_1[$i][6]=$row[6];
				    $mail_1[$i][6]=$this->short_subject($row[6]);
					preg_match('/<img(.+?)src=(.+?)>/i',$row[7],$cset1);
						if($cset1[2]!="")
					$row[7]=str_replace("attachments/","../attachments/",$cset1[2]);
					$mail_1[$i][7]=$row[7];
					$mail_1[$i][8]=$row[8];
					$mail_1[$i][9]=$row[9];
					$mail_1[$i][10]=$row[10];
					$mail_1[$i][11]=$row[11];
					$mail_1[$i][12]=$row[12];
					$mail_1[$i][13]=1;
					$mail_1[$i][14]=$row[13];
					$mail_1[$i][15]=$row[14];
					$mail_1[$i][16]=$flag1;
					$mail_1[$i][17]=$row[15];
					$i++;
				}

				$mail1[0]=$mail_1[0];

				for($r=1,$count1=1;$r<count($mail_1);$r++)
				{

					$flag0=0;
					for($a=0;$a<count($mail1);$a++)
					{
						if($mail_1[$r][15]==$mail1[$a][15])
						{
							$flag0=1;
							if($mail_1[$r][16]==1)
							$mail1[$a][16]=1;
						}
					}
					if($flag0==0)
					{

						$mail1[$count1]=$mail_1[$r];
						$count1++;
					}
				}
			}
			$db1->select("nesote_email_spam_$tablenumber");
			$db1->fields("*");
			$db1->where("userid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%')",array($id));
			$db1->order("time asc");
			$res1=$db1->query();
			$no2=$db1->numRows($res1);
			if($no2!=0)
			{
				while($row=$db1->fetchRow($res1))
				{
					$db->select("nesote_email_attachments_$tablenumber");
					$db->fields("*");
					$db->where("mailid=? and folderid=? and attachment=?",array($row[0],4,1));
					$rs=$db->query();
					$rw1=$db->numRows($rs);
					if($rw1>0)
					{
						$flag1=1;
					}
					else
					{
						$flag1=0;
					}
					$mail_2[$s][0]=$row[0];
					$mail_2[$s][1]=$row[1];
					$mail_2[$s][2]=$row[2];
					$mail_2[$s][3]=$row[3];
					$mail_2[$s][4]=$row[4];
					$mail_2[$s][5]=$row[5];
					$mail_2[$s][6]=$row[6];
				    $mail_2[$i][6]=$this->short_subject($row[6]);
					preg_match('/<img(.+?)src=(.+?)>/i',$row[7],$cset1);
						if($cset1[2]!="")
					$row[7]=str_replace("attachments/","../attachments/",$cset1[2]);
					$mail_2[$s][7]=$row[7];
					$mail_2[$s][8]=$row[8];
					$mail_2[$s][9]=$row[9];
					$mail_2[$s][10]=$row[10];
					$mail_2[$s][11]=$row[11];
					$mail_2[$s][12]=$row[12];
					$mail_2[$s][13]=4;
					$mail_2[$s][14]=$row[13];
					$mail_2[$s][15]=$row[14];
					$mail_2[$s][16]=$flag1;
					$mail_2[$s][17]=$row[15];
					$s++;
				}
				$mail2[0]=$mail_2[0];
				for($r=1,$count2=1;$r<count($mail_2);$r++)
				{

					$flag0=0;
					for($a=0;$a<count($mail2);$a++)
					{
						if($mail_2[$r][15]==$mail2[$a][15])
						{
							$flag0=1;
							if($mail_2[$r][16]==1)
							$mail2[$a][16]=1;

						}
					}
					if($flag0==0)
					{

						$mail2[$count2]=$mail_2[$r];
						$count2++;
					}
				}
			}

			$db1->select("nesote_email_draft_$tablenumber");
			$db1->fields("*");
			$db1->where("userid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%')",array($id));
			$db1->order("time asc");
			$res1=$db1->query();
			//echo $db1->getQuery();
			$no3=$db1->numRows($res1);
			if($no3!=0)
			{
				while($row=$db1->fetchRow($res1))
				{
					$db->select("nesote_email_attachments_$tablenumber");
					$db->fields("*");
					$db->where("mailid=? and folderid=? and attachment=?",array($row[0],2,1));
					$rs=$db->query();
					$rw1=$db->numRows($rs);
					if($rw1>0)
					{
						$flag1=1;
					}
					else
					{
						$flag1=0;
					}
					$mail_3[$d][0]=$row[0];
					$mail_3[$d][1]=$row[1];
					$mail_3[$d][2]=$row[2];
					$mail_3[$d][3]=$row[3];
					$mail_3[$d][4]=$row[4];
					$mail_3[$d][5]=$row[5];
					$mail_3[$d][6]=$row[6];
				    $mail_3[$i][6]=$this->short_subject($row[6]);
					preg_match('/<img(.+?)src=(.+?)>/i',$row[7],$cset1);
						if($cset1[2]!="")
					$row[7]=str_replace("attachments/","../attachments/",$cset1[2]);
					$mail_3[$d][7]=$row[7];
					$mail_3[$d][8]=$row[8];
					$mail_3[$d][9]=$row[9];
					$mail_3[$d][10]=$row[10];
					$mail_3[$d][11]=$row[11];
					$mail_3[$d][12]=$row[12];
					$mail_3[$d][13]=2;
					$mail_3[$d][14]=$row[13];
					$mail_3[$d][15]=$row[14];
					$mail_3[$d][16]=$flag1;
					//$mail_3[$d][17]=$row[15];
					$d++;
				}
				$mail3[0]=$mail_3[0];
				for($r=1,$count3=1;$r<count($mail_3);$r++)
				{

					$flag0=0;
					for($a=0;$a<count($mail3);$a++)
					{
						if($mail_3[$r][15]==$mail3[$a][15])
						{
							$flag0=1;
							if($mail_3[$r][16]==1)
							$mail3[$a][16]=1;
						}
					}
					if($flag0==0)
					{

						$mail3[$count3]=$mail_3[$r];
						$count3++;
					}
				}
			}
			$db1->select("nesote_email_sent_$tablenumber");
			$db1->fields("*");
			$db1->where("userid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%')",array($id));
			$db1->order("time asc");
			$res1=$db1->query();
			$no4=$db1->numRows($res1);
			if($no4!=0)
			{
				while($row=$db1->fetchRow($res1))
				{
					$db->select("nesote_email_attachments_$tablenumber");
					$db->fields("*");
					$db->where("mailid=? and folderid=? and attachment=?",array($row[0],3,1));
					$rs=$db->query();
					$rw1=$db->numRows($rs);
					if($rw1>0)
					{
						$flag1=1;
					}
					else
					{
						$flag1=0;
					}
					$mail_4[$t][0]=$row[0];
					$mail_4[$t][1]=$row[1];
					$mail_4[$t][2]=$row[2];
					$mail_4[$t][3]=$row[3];
					$mail_4[$t][4]=$row[4];
					$mail_4[$t][5]=$row[5];
					$mail_4[$t][6]=$row[6];
				    $mail_4[$i][6]=$this->short_subject($row[6]);
					preg_match('/<img(.+?)src=(.+?)>/i',$row[7],$cset1);
						if($cset1[2]!="")
					$row[7]=str_replace("attachments/","../attachments/",$cset1[2]);
					$mail_4[$t][7]=$row[7];
					$mail_4[$t][8]=$row[8];
					$mail_4[$t][9]=$row[9];
					$mail_4[$t][10]=$row[10];
					$mail_4[$t][11]=$row[11];
					$mail_4[$t][12]=$row[12];
					$mail_4[$t][13]=3;
					$mail_4[$t][14]=$row[13];
					$mail_4[$t][15]=$row[14];
					$mail_4[$t][16]=$flag1;
					$mail_4[$t][17]=$row[15];
					$t++;
				}
				$mail4[0]=$mail_4[0];
				for($r=1,$count4=1;$r<count($mail_4);$r++)
				{

					$flag0=0;
					for($a=0;$a<count($mail4);$a++)
					{
						if($mail_4[$r][15]==$mail4[$a][15])
						{
							$flag0=1;
							if($mail_4[$r][16]==1)
							$mail4[$a][16]=1;
						}
					}
					if($flag0==0)
					{

						$mail4[$count4]=$mail_4[$r];
						$count4++;
					}
				}
			}
			$db->select("nesote_email_customfolder");
			$db->fields("id");
			$db->where("userid=?",array($id));

			$res2=$db->query();
			while($row1=$db->fetchRow($res2))
			{

				$ids.=$row1[0].",";
			}
			$ids=substr($ids,0,-1);
			$number=$db->numRows($res2);
			if($number!=0)
			{
				$db1->select("nesote_email_customfolder_mapping_$tablenumber");
				$db1->fields("*");
				$db1->where("folderid in($ids) and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%')");
				$db1->order("time asc");

				$res1=$db1->query();
				//echo $db1->getQuery();exit;
				$no5=$no5+$db1->numRows($res1);
				if($no5!=0)
				{
					while($row=$db1->fetchRow($res1))
					{
						$db->select("nesote_email_attachments_$tablenumber");
						$db->fields("*");
						$db->where("mailid=? and folderid=? and attachment=?",array($row[0],$row[1],1));
						$rs=$db->query();
						$rw1=$db->numRows($rs);
						if($rw1>0)
						{
							$flag1=1;
						}
						else
						{
							$flag1=0;
						}
						$mail_5[$c][0]=$row[0];
						$mail_5[$c][1]=$row[1];
						$mail_5[$c][2]=$row[2];
						$mail_5[$c][3]=$row[3];
						$mail_5[$c][4]=$row[4];
						$mail_5[$c][5]=$row[5];
						$mail_5[$c][6]=$row[6];
				        $mail_5[$i][6]=$this->short_subject($row[6]);
						preg_match('/<img(.+?)src=(.+?)>/i',$row[7],$cset1);
						if($cset1[2]!="")
						$row[7]=str_replace("attachments/","../attachments/",$cset1[2]);
						$mail_5[$c][7]=$row[7];
						$mail_5[$c][8]=$row[8];
						$mail_5[$c][9]=$row[9];
						$mail_5[$c][10]=$row[10];
						$mail_5[$c][11]=$row[11];
						$mail_5[$c][12]=$row[12];
						$mail_5[$c][13]=$row[1];
						$mail_5[$c][14]=$row[13];
						$mail_5[$c][15]=$row[14];
						$mail_5[$c][16]=$flag1;
						$mail_5[$c][17]=$row[15];

						$c++;

					}
					$mail5[0]=$mail_5[0];
					for($r=1,$count5=1;$r<count($mail_5);$r++)
					{

						$flag0=0;
						for($a=0;$a<count($mail5);$a++)
						{
							if($mail_5[$r][15]==$mail5[$a][15])
							{
								$flag0=1;
								if($mail_5[$r][16]==1)
								$mail5[$a][16]=1;
							}
						}
						if($flag0==0)
						{

							$mail5[$count5]=$mail_5[$r];
							$count5++;
						}
					}
				}
			}


			if($i>0)
			$i--;
			if($s>0)
			$s--;
			if($t>0)
			$t--;
			if($d>0)
			$d--;
			if($c>0)
			$c--;
			$total=$no1+$no2+$no3+$no4+$no5;
			//$total--;//
			//echo $c;exit;
			for($k=$i,$l=$s,$m=$t,$n=$d,$p=0,$o=$c;$total>0;$total--,$p++)
			{
				//echo $no3."/$n";
				//echo $mail1[$k][8]."/";	echo $mail5[$o][8]."<br>";
				$loop=0;
				$num=0;
				$inbox_top=$mail1[$k][8];
				$spam_top=$mail2[$l][8];
				$sent_top=$mail4[$m][8];
				$draft_top=$mail3[$n][8];
				$cf_top=$mail5[$o][8];//echo $cf_top;

				$max=max($inbox_top,$spam_top,$sent_top,$draft_top,$cf_top);
				//echo $inbox_top."==<br>".$spam_top."==<br>".$sent_top."==<br>".$draft_top."==<br>".$cf_top."///<br>";
				//echo $max;//echo $max."=".$draft_top;
				if($max==$inbox_top && $loop==0)
				{
					//$top=$inbox_top;
					//echo "i";
					$count=count($mail);
					for($g=0;$g<$count;$g++)
					{
						if($mail[$g][15]==$mail1[$k][15])
						{
							$num=1;
							break;
						}
						else
						$num=0;
					}
					if($num==0)
					{
						$mail[$p]=$mail1[$k];
						$k--;
						$loop=1;
					}
					//continue;
				}
				if($max==$spam_top && $loop==0)
				{
					//echo "s";
					//$top=$inbox_top;
					$count=count($mail);
					for($g=0;$g<$count;$g++)
					{
						if($mail[$g][15]==$mail2[$l][15])
						{
							$num=1;
							break;
						}
						else
						$num=0;
					}
					if($num==0)
					{
						$mail[$p]=$mail2[$l];
						$l--;
						$loop=1;
					}
					//continue;
				}
				if($max==$sent_top && $loop==0)
				{
					//echo "t";
					//$top=$inbox_top;
					$count=count($mail);
					for($g=0;$g<$count;$g++)
					{
						if($mail[$g][15]==$mail4[$m][15])
						{
							$num=1;
							break;
						}
						else
						$num=0;
					}
					if($num==0)
					{
						$mail[$p]=$mail4[$m];
						$m--;
						$loop=1;
					}
					//continue;
				}
				if($max==$draft_top && $loop==0)
				{
					//echo "d";
					//$top=$inbox_top;
					//	echo "k";
					$count=count($mail);
					for($g=0;$g<$count;$g++)
					{
						if($mail[$g][15]==$mail3[$n][15])
						{
							$num=1;
							break;
						}
						else
						$num=0;
					}
					if($num==0)
					{
						$mail[$p]=$mail3[$n];
						$n--;
						$loop=1;
					}
					//continue;
				}
				if($max==$cf_top && $loop==0)
				{
					//echo "c";
					//	$top=$inbox_top;
					$count=count($mail);
					for($g=0;$g<$count;$g++)
					{
						if($mail[$g][15]==$mail5[$o][15])
						{
							$num=1;
							break;
						}
						else
						$num=0;
					}
					if($num==0)
					{
						$mail[$p]=$mail5[$o];
						$o--;
						$loop=1;
					}

				}

			}




			$total=$count1+$count2+$count3+$count4+$count5;


			for($k=$count1-1,$l=$count2-1,$m=$count4-1,$n=$count3-1,$p=0,$o=$count5-1;$total>0;$total--)
			{

				$loop=0;
				$num=0;
				$inbox_top=$mail1[$k][8];
				$spam_top=$mail2[$l][8];
				$sent_top=$mail4[$m][8];
				$draft_top=$mail3[$n][8];
				$cf_top=$mail5[$o][8];

				$max=max($inbox_top,$spam_top,$sent_top,$draft_top,$cf_top);


				if($max==$inbox_top && $loop==0)
				{



					$count=count($mail);
					for($g=0;$g<$count;$g++)
					{
						if($mail[$g][15]==$mail1[$k][15])
						{
							$num=1;
							break;
						}
						else
						$num=0;
					}
					if($num==0)
					{

						$mail[$p]=$mail1[$k];
						$k--;
						$p++;
						$loop=1;
					}

				}
				if($max==$spam_top && $loop==0)
				{



					$count=count($mail);
					for($g=0;$g<$count;$g++)
					{
						if($mail[$g][15]==$mail2[$l][15])
						{
							$num=1;
							break;
						}
						else
						$num=0;
					}
					if($num==0)
					{

						$mail[$p]=$mail2[$l];
						$l--;
						$p++;
						$loop=1;
					}

				}
				if($max==$sent_top && $loop==0)
				{


					$count=count($mail);
					for($g=0;$g<$count;$g++)
					{
						if($mail[$g][15]==$mail4[$m][15])
						{
							$num=1;
							break;
						}
						else
						$num=0;
					}
					if($num==0)
					{

						$mail[$p]=$mail4[$m];

						$p++;
						$loop=1;
					}

					$m--;
				}
				if($max==$draft_top && $loop==0)
				{


					$count=count($mail);
					for($g=0;$g<$count;$g++)
					{
						if($mail[$g][15]==$mail3[$n][15])
						{
							$num=1;
							break;
						}
						else
						$num=0;
					}
					if($num==0)
					{

						$mail[$p]=$mail3[$n];
						$n--;
						$p++;
						$loop=1;
					}

				}
				if($max==$cf_top && $loop==0)
				{


					$count=count($mail);
					for($g=0;$g<$count;$g++)
					{
						if($mail[$g][15]==$mail5[$o][15])
						{
							$num=1;
							break;
						}
						else
						$num=0;
					}
					if($num==0)
					{

						$mail[$p]=$mail5[$o];
						$o--;
						$p++;
						$loop=1;
					}

				}

			}

			$no=count($mail);

			$page=$this->getParam(2);
			if(!isset($page))
			{
				$page=1;
			}
			$p=$page;
			$index=($p-1)*$perpagesize;
			for($r=0;$r<$perpagesize;$r++,$index++)
			{
				if($index>=$no)
				break;
				$mail_new[$r]=$mail[$index];
			}


			if($page>$no)
			{
				$page=1;
				$startpage=0;

			}
			$startpage=($page-1)*$perpagesize;

			if($startpage<0)//for firsttime
			{

				$page=1;
				$startpage=0;
				
			}
			$this->setLoopValue("mail",$mail_new);
			$this->setValue("firstid",$mail[0][0]);
			$nmbr=count($mail_new);
			if($mail[0][0]=="")
			$nmbr=0;
			$this->setValue("number",$nmbr);
			$this->setValue("array_count",$nmbr);

			$previouspage=$page-1;$s1=0;$s2=0;
			$pagelink="<div class=\"pagingtbl\">";
			if($page!=1)
			{
					$s1=1;
				$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$previouspage")."\" class=\"commonBtn1\">".$this->getmessage(432)."</a>";
			}
			

			$nextpage=$page+1;
			if($page*$perpagesize<($no))
			{
					$s2=1;
				$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$nextpage")."\" class=\"commonBtn1\">".$this->getmessage(433)."</a>";
			}
			
			$pagelink.="</div>";$s=$s1+$s2;
$this->setValue("show",$s);	
			$this->setValue("pagelink",$pagelink);




		}
		elseif($folder==6)
		{
//echo "aaa";exit;
			$i=0;$s=0;$t=0;$d=0;$c=0;
			$all=1;

			$mail=array();
			//starred mail
			$db1=new NesoteDALController();
			$db1->select("nesote_email_inbox_$tablenumber");
			$db1->fields("*");
			if($flag==1)
			{
				$db1->where("userid=? and starflag=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",array($id,1));
			}
			else
			{
				$db1->where("userid=? and starflag=?",array($id,1));
			}

			$db1->order("time asc");
			$res1=$db1->query();
			 $no1=$db1->numRows($res1);
			//echo $db1->getQuery();
			while($row=$db1->fetchRow($res1))
			{
				$db->select("nesote_email_attachments_$tablenumber");
				$db->fields("*");
				$db->where("mailid=? and folderid=? and attachment=?",array($row[0],1,1));
				$rs=$db->query();
				$rw1=$db->numRows($rs);
				if($rw1>0)
				{
					$flag1=1;
				}
				else
				{
					$flag1=0;
				}
				$mail_1[$i][0]=$row[0];
				$mail_1[$i][1]=$row[1];
				$mail_1[$i][2]=$row[2];
				$mail_1[$i][3]=$row[3];
				$mail_1[$i][4]=$row[4];
				$mail_1[$i][5]=$row[5];
				$mail_1[$i][6]=$row[6];
				$mail_1[$i][6]=$this->short_subject($row[6]);
				preg_match('/<img(.+?)src=(.+?)>/i',$row[7],$cset1);
						if($cset1[2]!="")
				$row[7]=str_replace("attachments/","../attachments/",$cset1[2]);
				$mail_1[$i][7]=$row[7];
				$mail_1[$i][8]=$row[8];
				$mail_1[$i][9]=$row[9];
				$mail_1[$i][10]=$row[10];
				$mail_1[$i][11]=$row[11];
				$mail_1[$i][12]=$row[12];
				$mail_1[$i][13]=1;
				$mail_1[$i][14]=$row[13];
				$mail_1[$i][15]=$row[14];
				$mail_1[$i][16]=$flag1;
				$mail_1[$i][17]=$row[15];
				$i++;
			}
			$mail1[0]=$mail_1[0];
			for($r=1,$w=1;$r<count($mail_1);$r++)
			{

				$flag0=0;
				for($a=0;$a<count($mail1);$a++)
				{
					if($mail_1[$r][15]==$mail1[$a][15])
					{
						$flag0=1;

					}
				}
				if($flag0==0)
				{

					$mail1[$w]=$mail_1[$r];
					$w++;
				}
			}
			$db1->select("nesote_email_draft_$tablenumber");
			$db1->fields("*");
			if($flag==1)
			{
				$db1->where("userid=? and starflag=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",array($id,1));
			}
			else
			{
				$db1->where("userid=? and starflag=?",array($id,1));
			}

			$db1->order("time asc");
			$res1=$db1->query();
			//echo $db1->getQuery();
			 $no3=$db1->numRows($res1);
			while($row=$db1->fetchRow($res1))
			{
				$db->select("nesote_email_attachments_$tablenumber");
				$db->fields("*");
				$db->where("mailid=? and folderid=? and attachment=?",array($row[0],2,1));
				$rs=$db->query();
				$rw1=$db->numRows($rs);
				if($rw1>0)
				{
					$flag1=1;
				}
				else
				{
					$flag1=0;
				}
				$mail_3[$d][0]=$row[0];
				$mail_3[$d][1]=$row[1];
				$mail_3[$d][2]=$row[2];
				$mail_3[$d][3]=$row[3];
				$mail_3[$d][4]=$row[4];
				$mail_3[$d][5]=$row[5];
				$mail_3[$d][6]=$row[6];
			    $mail_3[$i][6]=$this->short_subject($row[6]);
				preg_match('/<img(.+?)src=(.+?)>/i',$row[7],$cset1);
						if($cset1[2]!="")
				$row[7]=str_replace("attachments/","../attachments/",$cset1[2]);
				$mail_3[$d][7]=$row[7];
				$mail_3[$d][8]=$row[8];
				$mail_3[$d][9]=$row[9];
				$mail_3[$d][10]=$row[10];
				$mail_3[$d][11]=$row[11];
				$mail_3[$d][12]=$row[12];
				$mail_3[$d][13]=2;
				$mail_3[$d][14]=$row[13];
				$mail_3[$d][15]=$row[14];
				$mail_3[$d][16]=$flag1;
				//$mail_3[$d][17]=$row[15];
				$d++;
			}
			$mail3[0]=$mail_3[0];
			for($r=1,$w=1;$r<count($mail_3);$r++)
			{

				$flag0=0;
				for($a=0;$a<count($mail3);$a++)
				{
					if($mail_3[$r][15]==$mail3[$a][15])
					{
						$flag0=1;

					}
				}
				if($flag0==0)
				{

					$mail3[$w]=$mail_3[$r];
					$w++;
				}
			}
			$db1->select("nesote_email_sent_$tablenumber");
			$db1->fields("*");
			if($flag==1)
			{
				$db1->where("userid=? and starflag=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",array($id,1));
			}
			else
			{
				$db1->where("userid=? and starflag=?",array($id,1));
			}

			$db1->order("time asc");
			$res1=$db1->query();
			 $no4=$db1->numRows($res1);
			while($row=$db1->fetchRow($res1))
			{
				$db->select("nesote_email_attachments_$tablenumber");
				$db->fields("*");
				$db->where("mailid=? and folderid=? and attachment=?",array($row[0],3,1));
				$rs=$db->query();
				$rw1=$db->numRows($rs);
				if($rw1>0)
				{
					$flag1=1;
				}
				else
				{
					$flag1=0;
				}
				$mail_4[$t][0]=$row[0];
				$mail_4[$t][1]=$row[1];
				$mail_4[$t][2]=$row[2];
				$mail_4[$t][3]=$row[3];
				$mail_4[$t][4]=$row[4];
				$mail_4[$t][5]=$row[5];
				$mail_4[$t][6]=$row[6];
			    $mail_4[$i][6]=$this->short_subject($row[6]);
				preg_match('/<img(.+?)src=(.+?)>/i',$row[7],$cset1);
						if($cset1[2]!="")
				$row[7]=str_replace("attachments/","../attachments/",$cset1[2]);
				$mail_4[$t][7]=$row[7];
				$mail_4[$t][8]=$row[8];
				$mail_4[$t][9]=$row[9];
				$mail_4[$t][10]=$row[10];
				$mail_4[$t][11]=$row[11];
				$mail_4[$t][12]=$row[12];
				$mail_4[$t][13]=3;
				$mail_4[$t][14]=$row[13];
				$mail_4[$t][15]=$row[14];
				$mail_4[$t][16]=$flag1;
				$mail_4[$t][17]=$row[15];
				$t++;
			}
			$mail4[0]=$mail_4[0];
			for($r=1,$w=1;$r<count($mail_4);$r++)
			{

				$flag0=0;
				for($a=0;$a<count($mail4);$a++)
				{
					if($mail_4[$r][15]==$mail4[$a][15])
					{
						$flag0=1;
					}
				}
				if($flag0==0)
				{

					$mail4[$w]=$mail_4[$r];
					$w++;
				}
			}
			$db->select("nesote_email_customfolder");
			$db->fields("id");
			$db->where("userid=?",array($id));

			$res2=$db->query();
			while($row1=$db->fetchRow($res2))
			{

				$ids.=$row1[0].",";
			}
			$ids=substr($ids,0,-1);
			$number=$db->numRows($res2);
			if($number!=0)
			{
				$db1->select("nesote_email_customfolder_mapping_$tablenumber");
				$db1->fields("*");
				if($flag==1)
				{
					$db1->where("folderid in($ids)  and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') and starflag=? ",array(1));
				}
				else
				{
					$db1->where("folderid in($ids) and starflag=?",array(1));
				}


				$db1->order("time asc");

				$res1=$db1->query();
				//echo $db1->getQuery();exit;
				 $no5=$no5+$db1->numRows($res1);
				while($row=$db1->fetchRow($res1))
				{
					$db->select("nesote_email_attachments_$tablenumber");
					$db->fields("*");
					$db->where("mailid=? and folderid=? and attachment=?",array($row[0],$row[1],1));
					$rs=$db->query();
					$rw1=$db->numRows($rs);
					if($rw1>0)
					{
						$flag1=1;
					}
					else
					{
						$flag1=0;
					}
					$mail_5[$c][0]=$row[0];
					$mail_5[$c][1]=$row[1];
					$mail_5[$c][2]=$row[2];
					$mail_5[$c][3]=$row[3];
					$mail_5[$c][4]=$row[4];
					$mail_5[$c][5]=$row[5];
					$mail_5[$c][6]=$row[6];
				    $mail_5[$i][6]=$this->short_subject($row[6]);
					preg_match('/<img(.+?)src=(.+?)>/i',$row[7],$cset1);
						if($cset1[2]!="")
					$row[7]=str_replace("attachments/","../attachments/",$cset1[2]);
					$mail_5[$c][7]=$row[7];
					$mail_5[$c][8]=$row[8];
					$mail_5[$c][9]=$row[9];
					$mail_5[$c][10]=$row[10];
					$mail_5[$c][11]=$row[11];
					$mail_5[$c][12]=$row[12];
					$mail_5[$c][13]=$row[1];
					$mail_5[$c][14]=$row[13];
					$mail_5[$c][15]=$row[14];
					$mail_5[$c][16]=$flag1;
					$mail_5[$c][17]=$row[15];
					$c++;
				}
				$mail5[0]=$mail_5[0];
				for($r=1,$w=1;$r<count($mail_5);$r++)
				{

					$flag0=0;
					for($a=0;$a<count($mail5);$a++)
					{
						if($mail_5[$r][15]==$mail5[$a][15])
						{
							$flag0=1;
						}
					}
					if($flag0==0)
					{

						$mail5[$w]=$mail_5[$r];
						$w++;
					}
				}
			}



			if($i>0)
			$i--;
			if($s>0)
			$s--;
			if($t>0)
			$t--;
			if($d>0)
			$d--;
			if($c>0)
			$c--;
		    $total=$no1+$no2+$no3+$no4+$no5;

			for($k=$i,$l=$s,$m=$t,$n=$d,$p=0,$o=$c;$total>0;$total--,$p++)
			{
					
				$loop=0;
				$num=0;
				$inbox_top=$mail1[$k][8]."//";
				$spam_top=$mail2[$l][8];
				$sent_top=$mail4[$m][8];
				$draft_top=$mail3[$n][8];
				$cf_top=$mail5[$o][8];

				$max=max($inbox_top,$spam_top,$sent_top,$draft_top,$cf_top);
				if($max==$inbox_top && $loop==0)
				{

					$count=count($mail);
					for($g=0;$g<$count;$g++)
					{
						if($mail[$g][15]==$mail1[$k][15])
						{
							$num=1;
							break;
						}
						else
						$num=0;
					}
					if($num==0)
					{
						$mail[$p]=$mail1[$k];
						$k--;
						$loop=1;
					}

				}
				if($max==$spam_top && $loop==0)
				{

					$count=count($mail);
					for($g=0;$g<$count;$g++)
					{
						if($mail[$g][15]==$mail2[$l][15])
						{
							$num=1;
							break;
						}
						else
						$num=0;
					}
					if($num==0)
					{
						$mail[$p]=$mail2[$l];
						$l--;
						$loop=1;
					}

				}
				if($max==$sent_top && $loop==0)
				{

					$count=count($mail);
					for($g=0;$g<$count;$g++)
					{
						if($mail[$g][15]==$mail4[$m][15])
						{
							$num=1;
							break;
						}
						else
						$num=0;
					}
					if($num==0)
					{
						$mail[$p]=$mail4[$m];
						$m--;
						$loop=1;
					}

				}
				if($max==$draft_top && $loop==0)
				{

					$count=count($mail);
					for($g=0;$g<$count;$g++)
					{
						if($mail[$g][15]==$mail3[$n][15])
						{
							$num=1;
							break;
						}
						else
						$num=0;
					}
					if($num==0)
					{
						$mail[$p]=$mail3[$n];
						$n--;
						$loop=1;
					}

				}
				if($max==$cf_top && $loop==0)
				{

					$count=count($mail);
					for($g=0;$g<$count;$g++)
					{
						if($mail[$g][15]==$mail5[$o][15])
						{
							$num=1;
							break;
						}
						else
						$num=0;
					}
					if($num==0)
					{
						$mail[$p]=$mail5[$o];
						$o--;
						$loop=1;
					}

				}
					
			}
		 $no=count($mail);
		 $page=$this->getParam(2);
			if(!isset($page))
			{
				$page=1;
			}
			 $p=$page;
			 $index=($p-1)*$perpagesize;
			for($r=0;$r<$perpagesize;$r++,$index++)
			{
				if($index>=$no)
				break;
				$mail_new[$r]=$mail[$index];
			}

			if($page>$no)
			{
				$page=1;
				$startpage=0;

			}
			$startpage=($page-1)*$perpagesize;

			if($startpage<0)//for firsttime
			{

				$page=1;
				$startpage=0;
				
			}
			
			$this->setLoopValue("mail",$mail_new);
			$this->setValue("firstid",$mail[0][0]);
			$nmbr=count($mail_new);
			//if($mail[0][0]=="")
			//$nmbr=0;
			$this->setValue("number",$nmbr);
			$this->setValue("array_count",$nmbr);
			
			
			$previouspage=$page-1;$s1=0;$s2=0;
			$pagelink="<div class=\"pagingtbl\">";
			if($page!=1)
			{
					$s1=1;
				$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$previouspage")."\" class=\"commonBtn1\">".$this->getmessage(432)."</a>";
			}
			

			$nextpage=$page+1;
			if($page*$perpagesize<($w))//if($page*10<=($total+10))
			{
					$s2=1;
				$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$nextpage")."\" class=\"commonBtn1\">".$this->getmessage(433)."</a>";
			}
			
			$pagelink.="</div>";$s=$s1+$s2;
$this->setValue("show",$s);	
			$this->setValue("pagelink",$pagelink);



		}

		else
		{
			$id=$this->getId();

			$db->select("nesote_email_customfolder");
			$db->fields("id");
			$db->where("userid=? and id=?",array($id,$folder));
			$res1=$db->query();
			$rw=$db->fetchRow($res1);
			$number=$db->numRows($res1);
			if($number!=0)
			{
				$db->select("nesote_email_customfolder_mapping_$tablenumber");
				$db->fields("*");
				if($flag==1)
				{
					$db->where("folderid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",array($folder));
				}
				else
				{
					$db->where("folderid=?",array($folder));
				}

				$db->order("time desc");
				$db->limit(0,1);
				$res=$db->query();
				
				$row=$db->fetchRow($res);
				$db->select("nesote_email_customfolder_mapping_$tablenumber");
				$db->fields("*");
				if($flag==1)
				{
					$db->where("folderid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",array($folder));
				}
				else
				{
					$db->where("folderid=?",array($folder));
				}
				$db->order("time desc");
				
					
				$res=$db->query();
				$nocust=$db->numRows($res);
				
				$db->select("nesote_email_customfolder_mapping_$tablenumber");
				$db->fields("*");
				if($flag==1)
				{
					$db->where("folderid=? and (subject like '%$search%' or body like '%$search%' or from_list like '%$search%') ",array($folder));
				}
				else
				{
					$db->where("folderid=?",array($folder));
				}
				$db->order("time desc");
				$startpage=($pq-1)*$perpagesize;
			    $db->limit($startpage,$perpagesize);
				$res=$db->query();
				while($row=$db->fetchRow($res))
				{
					$db->select("nesote_email_attachments_$tablenumber");
					$db->fields("*");
					$db->where("mailid=? and folderid=? and attachment=?",array($row[0],$row[1],1));
					$rs=$db->query();
					$rw1=$db->numRows($rs);
					if($rw1>0)
					{
						$flag1=1;
					}
					else
					{
						$flag1=0;
					}
					$mail_5[$i][0]=$row[0];
					$mail_5[$i][1]=$row[1];
					$mail_5[$i][2]=$row[2];
					$mail_5[$i][3]=$row[3];
					$mail_5[$i][4]=$row[4];
					$mail_5[$i][5]=$row[5];
					$mail_5[$i][6]=$row[6];
				    $mail_5[$i][6]=$this->short_subject($row[6]);
					preg_match('/<img(.+?)src=(.+?)>/i',$row[7],$cset1);
						if($cset1[2]!="")
					$row[7]=str_replace("attachments/","../attachments/",$cset1[2]);
					$mail_5[$i][7]=$row[7];
					$mail_5[$i][8]=$row[8];
					$mail_5[$i][9]=$row[9];
					$mail_5[$i][10]=$row[10];
					$mail_5[$i][11]=$row[11];
					$mail_5[$i][12]=$row[12];
					$mail_5[$i][13]=$row[1];
					$mail_5[$i][14]=$row[13];
					$mail_5[$i][15]=$row[14];
					$mail_5[$i][16]=$flag1;
					$mail_5[$i][17]=$row[15];
					$i++;
				}
				$mail[0]=$mail_5[0];
				for($r=1,$w=1;$r<count($mail_5);$r++)
				{

					$flag0=0;
					for($a=0;$a<count($mail);$a++)
					{
						if($mail_5[$r][15]==$mail[$a][15])
						{
							$flag0=1;
							if($mail_5[$r][16]==1)
							$mail[$a][16]=1;
							if($mail[$a][10]==1)
							$mail_5[$r][10]=1;
						}
					}
					if($flag0==0)
					{

						$mail[$w]=$mail_5[$r];
						$w++;
					}
				}
				if(!isset($page))
				{
					$page=1;
				}
				/*$p=$page;
				$index=($p-1)*$perpagesize;
				for($r=0;$r<$perpagesize;$r++,$index++)
				{
					if($index>=$w)
					break;
					$mail_new[$r]=$mail[$index];
				}*/
					

				if($page>$w)
				{
					$page=1;
					$startpage=0;

				}
				$startpage=($page-1)*$perpagesize;

				if($startpage<0)//for firsttime
				{

					$page=1;
					$startpage=0;
					//$db->limit($startpage,$perpagesize);
				}
				$this->setLoopValue("mail",$mail);
				$this->setValue("firstid",$mail[0][0]);
				$nmbr=count($mail);
				if($mail[0][0]=="")
				$nmbr=0;
				$this->setValue("number",$nmbr);
				$this->setValue("array_count",$nmbr);

				$previouspage=$page-1;$s1=0;$s2=0;
				$pagelink="<div class=\"pagingtbl\">";
				if($page!=1)
				{
$s1=1;
					$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$previouspage")."\" class=\"commonBtn1\">".$this->getmessage(432)."</a>";
				}
				

				$nextpage=$page+1;
				if($page*$perpagesize<($nocust))
				{
$s2=1;
					$pagelink.="<a href=\"".$this->url("mail/mailbox/$folder/$nextpage")."\" class=\"commonBtn1\">".$this->getmessage(433)."</a>";
				}
				
				$pagelink.="</div>";$s=$s1+$s2;
$this->setValue("show",$s);	
				$this->setValue("pagelink",$pagelink);
			}
		}
		$this->setValue("allsearch",$all);
		$folderid=$_COOKIE['folderid'];
		$this->setValue("folderid",$folderid);





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
	function gettolist($mailid,$folder)
	{//return $folder;
		
		$username=$_COOKIE['e_username'];
	    $tablenumber=$this->tableid($username);
		$ids="";
		$db1=new NesoteDALController();
		$db=new NesoteDALController();
		if($folder==3)
		{


			$db1->select("nesote_email_sent_$tablenumber");
			$db1->fields("mail_references");
			$db1->where("id=?",array($mailid));
			$rs1=$db1->query();//return $db1->getQuery();
			$row1=$db1->fetchRow($rs1);
			preg_match_all('/<item>(.+?)<\/item>/i',$row1[0],$reply);

			$no=count($reply[1]);//return $no;
			if($no>1)
			$num="(".$no.")";
			else
			$num="";

			$db->select("nesote_email_sent_$tablenumber");
			$db->fields("to_list,cc,bcc");
			$db->where("id=?",array($mailid));
			$rs=$db->query();//return $db->getQuery();
			//$row=$db->fetchRow($rs);
			//				$db->select("nesote_email_sent");
			//				$db->fields("to_list,cc,bcc");
			//				$db->where("id=?",array($mailid));
			//				$rs=$db->query();
			$row=$db->fetchRow($rs);//return htmlspecialchars($row[0])."++++/".htmlspecialchars($row[1])."+++++++/".htmlspecialchars($row[2])."++++/";
			$to=htmlspecialchars(trim($row[0]));
			$len=strlen($to);
			if($to[($len-1)]==",")
			$to=substr($to,0,-1);
			$to_list=explode(",",$to);
			if(($row[0]!="")||($row[1]!="")||($row[2]!=""))
			$ids=$this->getmessage(31).": ";
			if($to!="")
			{
				for($i=0;$i<count($to_list);$i++)
				{
					//echo count($to_list)."to";
					$to_list[$i]=trim($to_list[$i]);
					if(substr($to_list[$i],0,6)=="&nbsp;")
					$to_list[$i]=str_replace("&nbsp;","",$to_list[$i]);
					preg_match('/(.+?)<(.+?)>/i',$to_list[$i],$name);
					if(count($name[1])==0)
					preg_match('/(.+?)&lt;(.+?)&gt;/i',$to_list[$i],$name);
					if(count($name[1])==1)
					$less_position=strpos($to_list[$i],"<");
					if(($less_position=="FALSE")||($less_position<1))
					$less_position=strpos($to_list[$i],"&lt;");
					//return $less_position;
					//if((count($name[1])==1)&&((strpos($to_list[$i],"<")!=0)||(strpos($to_list[$i],"&lt;")!=0)))
					if(($less_position!="FALSE")&&($less_position>0))
					$ids.=$name[1].",";
					else
					$ids.=$to_list[$i].",";
				}
			}
			$cc= htmlspecialchars(trim($row[1]));
			$len=strlen($cc);
			if($cc[($len-1)]==",")
			$cc=substr($cc,0,-1);
			$cc_list=explode(",",$cc);
			if($cc!="")
			{
				for($i=0;$i<count($cc_list);$i++)
				{
					//echo count($cc_list)."cc";
					$cc_list[$i]=trim($cc_list[$i]);
					if(substr($cc_list[$i],0,6)=="&nbsp;")
					$cc_list[$i]=str_replace("&nbsp;","",$cc_list[$i]);
					preg_match('/(.+?)<(.+?)>/i',$cc_list[$i],$name);
					if(count($name[1])==0)
					preg_match('/(.+?)&lt;(.+?)&gt;/i',$cc_list[$i],$name);
					if(count($name[1])==1)
					$less_position=strpos($cc_list[$i],"<");
					if(($less_position=="FALSE")||($less_position<1))
					$less_position=strpos($cc_list[$i],"&lt;");
					//return $less_position;
					//if((count($name[1])==1)&&((strpos($cc_list[$i],"<")!=0)||(strpos($cc_list[$i],"&lt;")!=0)))
					if(($less_position!="FALSE")&&($less_position>0))
					$ids.=$name[1].",";
					else
					$ids.=$cc_list[$i].",";
				}
			}

			$bcc= htmlspecialchars(trim($row[2]));
			$len=strlen($bcc);
			if($bcc[($len-1)]==",")
			$bcc=substr($bcc,0,-1);
			$bcc_list=explode(",",$bcc);
			if($bcc!="")
			{
				for($i=0;$i<count($bcc_list);$i++)
				{
					//echo count($bcc_list)."bcc";
					$bcc_list[$i]=trim($bcc_list[$i]);
					if(substr($bcc_list[$i],0,6)=="&nbsp;")
					$bcc_list[$i]=str_replace("&nbsp;","",$bcc_list[$i]);
					preg_match('/(.+?)<(.+?)>/i',$bcc_list[$i],$name);
					if(count($name[1])==0)
					preg_match('/(.+?)&lt;(.+?)&gt;/i',$bcc_list[$i],$name);
					if(count($name[1])==1)
					$less_position=strpos($bcc_list[$i],"<");
					if(($less_position=="FALSE")||($less_position<1))
					$less_position=strpos($bcc_list[$i],"&lt;");
					//return $less_position;
					//if((count($name[1])==1)&&((strpos($bcc_list[$i],"<")!=0)||(strpos($bcc_list[$i],"&lt;")!=0)))
					if(($less_position!="FALSE")&&($less_position>0))
					$ids.=$name[1].",";
					else
					$ids.=$bcc_list[$i].",";
				}
			}


			$ids=substr($ids,0,-1);
			if(strlen($ids)>20)
			return substr($ids,0,20)."...".$num;
			else
			return $ids.$num;
		}
		else if($folder==2)
		{

			$db->select("nesote_email_draft_$tablenumber");
			$db->fields("to_list,cc,bcc");
			$db->where("id=?",array($mailid));
			$rs=$db->query();
			$row=$db->fetchRow($rs);//return htmlspecialchars($row[0])."++++/".htmlspecialchars($row[1])."+++++++/".htmlspecialchars($row[2])."++++/";
			$to=htmlspecialchars(trim($row[0]));
			$len=strlen($to);
			if($to[($len-1)]==",")
			$to=substr($to,0,-1);
			$to_list=explode(",",$to);
			if(($row[0]!="")||($row[1]!="")||($row[2]!=""))
			$ids=$this->getmessage(31).": ";
			if($to!="")
			{
				for($i=0;$i<count($to_list);$i++)
				{
					//echo count($to_list)."to";
					$to_list[$i]=trim($to_list[$i]);
					if(substr($to_list[$i],0,6)=="&nbsp;")
					$to_list[$i]=str_replace("&nbsp;","",$to_list[$i]);
					preg_match('/(.+?)<(.+?)>/i',$to_list[$i],$name);
					if(count($name[1])==0)
					preg_match('/(.+?)&lt;(.+?)&gt;/i',$to_list[$i],$name);
					if(count($name[1])==1)
					$less_position=strpos($to_list[$i],"<");
					if(($less_position=="FALSE")||($less_position<1))
					$less_position=strpos($to_list[$i],"&lt;");
					//return $less_position;
					//if((count($name[1])==1)&&((strpos($to_list[$i],"<")!=0)||(strpos($to_list[$i],"&lt;")!=0)))
					if(($less_position!="FALSE")&&($less_position>0))
					$ids.=$name[1].",";
					else
					$ids.=$to_list[$i].",";
				}
			}
			$cc= htmlspecialchars(trim($row[1]));
			$len=strlen($cc);
			if($cc[($len-1)]==",")
			$cc=substr($cc,0,-1);
			$cc_list=explode(",",$cc);
			if($cc!="")
			{
				for($i=0;$i<count($cc_list);$i++)
				{
					//echo count($cc_list)."cc";
					$cc_list[$i]=trim($cc_list[$i]);
					if(substr($cc_list[$i],0,6)=="&nbsp;")
					$cc_list[$i]=str_replace("&nbsp;","",$cc_list[$i]);
					preg_match('/(.+?)<(.+?)>/i',$cc_list[$i],$name);
					if(count($name[1])==0)
					preg_match('/(.+?)&lt;(.+?)&gt;/i',$cc_list[$i],$name);
					if(count($name[1])==1)
					$less_position=strpos($cc_list[$i],"<");
					if(($less_position=="FALSE")||($less_position<1))
					$less_position=strpos($cc_list[$i],"&lt;");
					//return $less_position;
					//if((count($name[1])==1)&&((strpos($cc_list[$i],"<")!=0)||(strpos($cc_list[$i],"&lt;")!=0)))
					if(($less_position!="FALSE")&&($less_position>0))
					$ids.=$name[1].",";
					else
					$ids.=$cc_list[$i].",";
				}
			}

			$bcc= htmlspecialchars(trim($row[2]));
			$len=strlen($bcc);
			if($bcc[($len-1)]==",")
			$bcc=substr($bcc,0,-1);
			$bcc_list=explode(",",$bcc);
			if($bcc!="")
			{
				for($i=0;$i<count($bcc_list);$i++)
				{
					//echo count($bcc_list)."bcc";
					$bcc_list[$i]=trim($bcc_list[$i]);
					if(substr($bcc_list[$i],0,6)=="&nbsp;")
					$bcc_list[$i]=str_replace("&nbsp;","",$bcc_list[$i]);
					preg_match('/(.+?)<(.+?)>/i',$bcc_list[$i],$name);
					if(count($name[1])==0)
					preg_match('/(.+?)&lt;(.+?)&gt;/i',$bcc_list[$i],$name);
					if(count($name[1])==1)
					$less_position=strpos($bcc_list[$i],"<");
					if(($less_position=="FALSE")||($less_position<1))
					$less_position=strpos($bcc_list[$i],"&lt;");
					//return $less_position;
					//if((count($name[1])==1)&&((strpos($bcc_list[$i],"<")!=0)||(strpos($bcc_list[$i],"&lt;")!=0)))
					if(($less_position!="FALSE")&&($less_position>0))
					$ids.=$name[1].",";
					else
					$ids.=$bcc_list[$i].",";
				}
			}
			$ids=substr($ids,0,-1);
			if(strlen($ids)>20)
			return substr($ids,0,20)."...".$num;
			else
			return $ids.$num;
		}
	}
function gettolistnew($mailid,$folderid)
	{
	if($folderid==6)
	return "";
	    $username=$_COOKIE['e_username'];
	 $tablenumber=$this->tableid($username);
		$db=new NesoteDALController();
		if($folderid==1)
		$db->select("nesote_email_inbox_$tablenumber");
		else if($folderid==2)
		$db->select("nesote_email_draft_$tablenumber");
		else if($folderid==3)
		$db->select("nesote_email_sent_$tablenumber");
		else if($folderid==4)
		$db->select("nesote_email_spam_$tablenumber");
		else if($folderid==5)
		$db->select("nesote_email_trash_$tablenumber");
		else if($folderid>=10)
		$db->select("nesote_email_customfolder_mapping_$tablenumber");
		$db->fields("mail_references");
		$db->where("id=?",array($mailid));
		$rs=$db->query();
		$row=$db->fetchRow($rs);
		$references=$row[0];

		preg_match_all('/<item>(.+?)<\/item>/i',$references,$reply);
		
		$no=count($reply[1]);
		if($no>1)
		$str="(".$no.")";
		else
		$str="";
			
			return $str;
	}

	function getfromlist($mailid,$folderid,$x)
	{
	$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
		$uid=$this->getId();
		$db=new NesoteDALController();
		if($folderid==1)
		$db->select("nesote_email_inbox_$tablenumber");
		else if($folderid==4)
		$db->select("nesote_email_spam_$tablenumber");
		else if($folderid==5)
		$db->select("nesote_email_trash_$tablenumber");
		else if($folderid>=10)
		$db->select("nesote_email_customfolder_mapping_$tablenumber");
		$db->fields("mail_references");
		$db->where("id=?",array($mailid));
		$rs=$db->query();
		$row=$db->fetchRow($rs);
		$references=$row[0];


		$from= array();


		preg_match_all('/<item>(.+?)<\/item>/i',$references,$reply);
		//print_r($reply);
		$no=count($reply[1]);//return $no."?/////////////";
		$fromlist="";
		$w=0;
		for($i=0;$i<$no;$i++)
		{
			preg_match('/<mailid>(.+?)<\/mailid>/i',$reply[1][$i],$mail[$i]);//return $reply[1][$i]."+++++";
			preg_match('/<folderid>(.+?)<\/folderid>/i',$reply[1][$i],$folder[$i]);//return $folder[$i]."//".$mail[$i]."+++";
			$db=new NesoteDALController();
			if($folder[$i][1]==5)
			{
				$db->select("nesote_email_trash_$tablenumber");
				$db->fields("backreference");
				$db->where("id=?",array($mail[$i][1]));
				$rs1=$db->query();//return $db->getQuery()."++++++++++";
				$row1=$db->fetchRow($rs1);//return $row1[0];
				$folder_back=$row1[0];
				$db->select("nesote_email_trash_$tablenumber");
				if(($folder_back==2)||($folder_back==3))
				{
					$db->fields("to_list");
				}
				else
				$db->fields(" distinct from_list");
				$db->where("id=?",array($mail[$i][1]));
				$rs=$db->query();
			}//return $folder[$i][1]."*******";
			else if($folder[$i][1]==4)
			{
				$db->select("nesote_email_spam_$tablenumber");
				$db->fields("backreference");
				$db->where("id=?",array($mail[$i][1]));
				$rs1=$db->query();//return $db->getQuery()."++++++++++";
				$row1=$db->fetchRow($rs1);//return $row1[0];
				$folder_back=$row1[0];
				$db->select("nesote_email_spam_$tablenumber");
				if(($folder_back==2)||($folder_back==3))
				{
					$db->fields("to_list");
				}
				else
				$db->fields(" distinct from_list");
				$db->where("id=?",array($mail[$i][1]));
				$rs=$db->query();
			}
			else if(($folder[$i][1]!=2)&&($folder[$i][1]!=3))
			{
				if($folder[$i][1]==1)
				$db->select("nesote_email_inbox_$tablenumber");
				else if($folder[$i][1]>=10)
				$db->select("nesote_email_customfolder_mapping_$tablenumber");
				$db->fields(" distinct from_list");
				$db->where("id=?",array($mail[$i][1]));
				$rs=$db->query();//return $db->getQuery()."++++++++++";
			}
			else
			{   if($folder[$i][1]==2)
			$db->select("nesote_email_draft_$tablenumber");
			else if($folder[$i][1]==3)
			$db->select("nesote_email_sent_$tablenumber");
			$db->fields("to_list");
			$db->where("id=?",array($mail[$i][1]));
			$rs=$db->query();//echo $db->getQuery();
			}

			$row=$db->fetchRow($rs);
			
			$flag0=0;
			$len=strpos(trim($row[0]),"<");//echo $len."++++++==";
			if($len<1)
			{
				$len=strpos(trim($row[0]),"&lt");//echo $len."====";
			}
			if($len<1)
			{
				$len=strpos(trim($row[0]),"&amp;lt");//
			}//return $len."*******";
			if($len>0)
			{
				//return "xxxxxxx";
				$froms=substr($row[0],0,($len-1));
			}
			else
			{ //return "aaaaaa";
				preg_match('/<(.+?)>/i',$row[0],$fromz);
				if(count($fromz)==0)
				{
					preg_match('/&lt;(.+?)&gt;/i',$row[0],$fromz);
				}
				if(count($fromz)==0)
				{
					preg_match('/&amp;lt;(.+?)&amp;gt;/i',$row[0],$fromz);
				}
				if(count($fromz)!=0)
				$frm=$fromz[1];
				else
				$frm=$row[0]; //return $frm."++++++++";
				$db1=new NesoteDALController();
				$db1->select("nesote_email_contacts");
				$db1->fields("firstname");
				$db1->where("mailid=? and addedby=?",array($frm,$uid));
				$res=$db1->query();//echo $db1->getQuery();
				$nums=$db1->numRows($res);
				$rw1=$db1->fetchRow($res);
				if(($nums!=0)&&($rw1[0]!=""))
				{
					$froms=$rw1[0];//return $froms."+++++++".$nums;
				}
				else
				{
					$db2=new NesoteDALController();
					$db2->select("nesote_email_settings");
					$db2->fields("value");
					$db2->where("name=?",array("globaladdress_book"));
					$res2=$db2->query();
					$rw2=$db2->fetchRow($res2);//echo $rw2[0]."+++";
					$a=explode("@",$frm);//echo $a[1]."***";
					$db3=new NesoteDALController();
					$db3->select("nesote_email_settings");
					$db3->fields("value");
					$db3->where("name=?",array("emailextension"));
					$res3=$db3->query();
					$rw3=$db3->fetchRow($res3);//echo $rw3[0]."@@@";
					if(($a[1]==$rw3[0])&&($rw2[0]==1))
					{
						$db4=new NesoteDALController();
						$db4->select("nesote_inoutscripts_users");
						$db4->fields("name");
						$db4->where("username=?",array($a[0]));
						$res4=$db4->query();
						$rw4=$db4->fetchRow($res4);
						$froms=$rw4[0];//return "++++global".$froms;
					}
					else
					{
						$froms=$frm;
						//return "++++normal".$froms;
					}
				}
			}

			//return $froms;
			for($j=0;$j<count($from);$j++)
			{

				if($froms==$from[$j])
				{

					$flag0=1;
					continue;

				}
			}
			if($flag0==0)
			{
				//if()

				if(trim($folder[$i][1])==3)
				{

					$fromlist.=$this->getmessage(284).",";
				}
				else
				$fromlist.=$froms.",";
			}
			$from[$w]=$froms;
			$w++;
		}

		$fromlist=substr($fromlist,0,-1);
		if(strlen($fromlist)>30)
		{
			$fromlist=substr($fromlist,0,30);
			$fromlist=$fromlist."....";
		}
		if($no>1)
		{
			$fromlist=$fromlist."(".$no.")";
		}


		return $fromlist;
	}
	function briefmessage($body,$length)
	{
		$body=strip_tags($body);
		while(1)
		{
			$a=substr(trim($body),0,6);
			if($a=="&nbsp;")
			{
				$body=substr(trim($body),6);

			}
			else
			break;
		}
		if(strlen($body)>$length)
		$brief=substr($body,0,$length)."...";
		else
		$brief=$body;
		$brief=htmlentities(substr($brief,0,$length),0,"UTF-8");
		return $brief;
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
		$res3=$db3->query();
		$rw3=$db3->fetchRow($res3);

		$db->select("nesote_email_time_zone");
		$db->fields("value");
		$db->where("id=?",array($rw3[0]));
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
			$lang_id=$_COOKIE['lang_mail'];
		}
		else
		{
			$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name=?",'default_language');
			$result=$db->query();
			$data4=$db->fetchRow($result);
			$lang_id=$data4[0];
			$defaultlang_id=$data4[0];
		}

		$day=date(" j ",$date);
        $language_id=$this->getlang_id($lang_id);
		$db->select("nesote_email_months_messages");
		$db->fields("message");
		$db->where("month_id=? and lang_id=?",array($month_id,$language_id));
		$result=$db->query();
		$data=$db->fetchRow($result);

		if($ts>2419200)
		{
			$data[0]=date("M",$date);
			$val = $data[0].date(" j,Y ",$date);
		}
		elseif($ts>86400)
		{
			$data[0]=date("M",$date);
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

	function getheading($folder,$search)
	{

		if($search!="")
		{

			$heading=$this->getmessage(163);
			$heading=str_replace("{search}",$search,$heading);
			if($folder==1)
			{
				$f=$this->getmessage(19);
				$heading=str_replace("{folder}",$f,$heading);
			}
			else if($folder==2)
			{
				$f=$this->getmessage(20);
				$heading=str_replace("{folder}",$f,$heading);
			}
			else if($folder==3)
			{
				$f=$this->getmessage(21);
				$heading=str_replace("{folder}",$f,$heading);
			}
			else if($folder==4)
			{
				$f=$this->getmessage(12);
				$heading=str_replace("{folder}",$f,$heading);
			}
			else if($folder==5)
			{
				$f=$this->getmessage(22);
				$heading=str_replace("{folder}",$f,$heading);
			}
			else if($folder==6)
			{
				$f=$this->getmessage(205);
				$heading=str_replace("{folder}",$f,$heading);
			}
			else if($folder==0)
			{
				$f=$this->getmessage(164);
				$heading=str_replace("{folder}",$f,$heading);
			}
			else if($folder>=10)
			{
				$db=new NesoteDALController();
				$db->select("nesote_email_customfolder");
				$db->fields("name");
				$db->where("id=?",$folder);
				$rs=$db->query();
				$row=$db->fetchRow($rs);

				$f=$row[0];
				$heading=str_replace("{folder}",$f,$heading);

			}
		}
		else if($folder>=10)
		{
			$db=new NesoteDALController();
			$db->select("nesote_email_customfolder");
			$db->fields("name");
			$db->where("id=?",$folder);
			$rs=$db->query();
			$row=$db->fetchRow($rs);
			$heading=$row[0];
		}
		else if($folder==1)
		{
			$heading=$this->getmessage(19);
		}
		else if($folder==2)
		{
			$heading=$this->getmessage(20);
		}
		else if($folder==3)
		{
			$heading=$this->getmessage(21);
		}
		else if($folder==4)
		{
			$heading=$this->getmessage(12);
		}
		else if($folder==5)
		{
			$heading=$this->getmessage(22);
		}
		else if($folder==6)
		{
			$heading=$this->getmessage(205);
		}
		else if($folder==7)
		{
			$heading=$this->getmessage(360);
		}
		else
		{
			$heading="";
		}
		return $heading;
	}

	function detailmailAction()
	{
require("script.inc.php");
if($restricted_mode=='true')
{
$this->setValue("demo","demo");
}

		$valid=$this->validateUser();
		$copy=array();$copy1=array();
		$userid=$this->getId();
		$subject="";
		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		else
		{
			
			$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
		    
		    $db=new NesoteDALController();
			$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name='public_page_logo'");
			$result1=$db->query();
			$row1=$db->fetchRow($result1);
			$img=$row1[0];
			$imgpath="../admin/logo/".$img;
			$this->setValue("imgpath",$imgpath);

			$db->select("nesote_email_usersettings");
			$db->fields("signature");
			$db->where("userid=?",$userid);
			$res=$db->query();
			$row=$db->fetchRow($res);
			$this->setValue("sign",$row[0]);

				
			$db->select("nesote_email_usersettings");
			$db->fields("display");
			$db->where("userid=?",$userid);
			$rs1=$db->query();
			$row1=$db->fetchRow($rs1);
			$this->setValue("display",$row1[0]);
			$external_content_display=0;

				
			$select=new NesoteDALController();
			$db1=new NesoteDALController();
			$folder=$this->getParam(1);//echo $folder;exit;
			$this->setValue("fid",$folder);
			$folderid=$_COOKIE['folderid'];
			if($folderid>=10)
			{

				$db->select("nesote_email_customfolder");
				$db->fields("name");
				$db->where("id=? and userid=?",array($folderid,$userid));
				$rs1=$db->query();
				$row1=$db->fetchRow($rs1);
				$foldername=$row1[0];
			}
			$this->setValue("folderid",$folderid);
			$this->setValue("folderd",$folderid);
			$mailid=$this->getParam(2);
			$this->setValue("mailid",$mailid);
			$msgid=$this->getParam(3);

			$more=0;$pge="";

			if($msgid===0)
			{
				$msgid="";$more=0;
			}
			else if($msgid==-1)
			{
				$msgid="";$more=1;
			}
			else
			{
				if(stristr(trim($msgid),"p")!="")
				{
					$pge=str_replace("p","",$msgid);
					$msgid="";
				}
			}
		//	echo $pge;exit;
			$this->setValue("more",$more);
			$this->setValue("pge",$pge);


			$number=$this->getParam(4);$rdinfo=0;
			if($number=="read")
			{
				$rdinfo=1;
				$number="";
			}
			$from=$this->getParam(5);
			$to=$this->getParam(6);
			$db->select("nesote_email_attachments_$tablenumber");
			$db->fields("*");
			$db->where("mailid=? and folderid=? and attachment=?",array($mailid,$folder,1));
			$res=$db->query();
			$num=$db->numRows($res);

			$this->setLoopValue("attach",$res->getResult());


			if(isset($msgid))
			{
				$p=base64_decode($msgid);
				$msg=$this->getmessage($p);

				$this->setValue("msg",$msg);
			}
			else
			$this->setValue("msg","");

			if($mailid!=0)
			{
				if($folder==1)
				{


					$db->select("nesote_email_inbox_$tablenumber");
					$db->fields("*");
					$db->where("id=?",$mailid);
					$res=$db->query();
					$rw=$db->fetchRow($res);
					$references=$rw[14];
					$copy=$rw[3];
					$copy1=$rw[4];
					preg_match_all('/<item>(.+?)<\/item>/i',$references,$reply);
					//print_r($reply);
					$nom=count($reply[1]);



					for($i=0;$i<$nom;$i++)
					{
						preg_match('/<mailid>(.+?)<\/mailid>/i',$reply[1][$i],$mailid1);
						preg_match('/<folderid>(.+?)<\/folderid>/i',$reply[1][$i],$folderid1);
						if($folderid1[1]==1)

						$db->select("nesote_email_inbox_$tablenumber");
						else if($folderid1[1]==3)

						$db->select("nesote_email_sent_$tablenumber");


						$db->fields("*");
						$db->where("id=?",$mailid1[1]);
						$res=$db->query();
						$rw=$db->fetchRow($res);

						$mail[$i][0]=$rw[0];
						$mail[$i][1]=$rw[1];
						$mail[$i][2]=$rw[2];
						$mail[$i][3]=$rw[3];
						$mail[$i][4]=$rw[4];
						$mail[$i][6]=$rw[6];
						preg_match('/<img(.+?)src=(.+?)>/i',$rw[7],$cset1);
					//	if($cset1[2]!="")
					//	$rw[7]=str_replace("attachments/","../attachments/",$cset1[2]);
						$mail[$i][7]=$rw[7];
						$mail[$i][8]=$rw[8];
						$mail[$i][9]=$rw[9];
						$mail[$i][10]=$rw[10];
						$mail[$i][11]=$rw[11];
						$mail[$i][12]=$rw[12];
						$mail[$i][13]=$folderid1[1];
						$mail[$i][15]=$rw[13];
						$mail[$i][16]=$rw[14];
						$mail[$i][17]=$this->attachcount($folderid1[1],$rw[0]);
						$mail[$i][18]=$rw[15];
						$mail[$i][19]=0;

						if($rdinfo==0)
						{
							if($folderid1[1]==1)
							$db->update("nesote_email_inbox_$tablenumber");
							else if($folderid1[1]==3)
							$db->update("nesote_email_sent_$tablenumber");
							$db->set("readflag=?",1);
							$db->where("id=?",$mailid1[1]);
							$res=$db->query();
						}
						$maild=$mail[$i][2];
						if(strpos($maild,">")!="")
						{
							preg_match('/<(.+?)>/i',$maild,$new_mailid);
							$id=$new_mailid[1];
						}
						else
						{

							if(strpos($mailid,">")!="")
							{
								preg_match('/<(.+?)>/i',$mailid,$new_mailid);
								$id=$new_mailid[1];
							}
							else if(strpos($mailid,"&lt;")!="")
							{
								preg_match('/&lt;(.+?)&gt;/i',$mailid,$new_mailid);
								$id=$new_mailid[1];
							}
							else if(strpos($mailid,"&amp;lt;")!="")
							{
								preg_match('/&amp;lt;(.+?)&amp;gt;/i',$mailid,$new_mailid);
								$id=$new_mailid[1];
							}
							else
							$id=$maild;
						}


						$subj=$mail[$i][6];
						$sub=explode(":",$subj);
						$number1=count($sub);
						$subject=$sub[$number1-1];


						$this->setLoopValue("mail",$mail);

						$this->setValue("subject",$subj);
						$total=count($mail);
						$this->setValue("total",$total);
						if($rdinfo==0)
						{
							$db1->update("nesote_email_inbox_$tablenumber");
							$db1->set("readflag=?",1);
							$db1->where("id=?",$mailid);
							$res1=$db1->query();
						}

					}

				}
				else if($folder==2)
				{


					$db->select("nesote_email_draft_$tablenumber");
					$db->fields("*");
					$db->where("id=?",$mailid);
					//$this->setValue("flag",0);
					$res=$db->query();
					//$this->setLoopValue("mail",$res->getResult());
					$rw=$db->fetchRow($res);
					$references=$rw[14];
					$copy=$rw[3];
					$copy1=$rw[4];
					preg_match_all('/<item>(.+?)<\/item>/i',$references,$reply);
					//print_r($reply);
					$nom=count($reply[1]);



					for($i=0;$i<$nom;$i++)
					{
						preg_match('/<mailid>(.+?)<\/mailid>/i',$reply[1][$i],$mailid1);
						preg_match('/<folderid>(.+?)<\/folderid>/i',$reply[1][$i],$folderid1);
						if($folderid1[1]==1)

						$db->select("nesote_email_inbox_$tablenumber");
						else if($folderid1[1]==3)

						$db->select("nesote_email_sent_$tablenumber");


						$db->fields("*");
						$db->where("id=?",$mailid1[1]);
						$res=$db->query();
						$rw=$db->fetchRow($res);

						$mail[$i][0]=$rw[0];
						$mail[$i][1]=$rw[1];
						$mail[$i][2]=$rw[2];
						$mail[$i][3]=$rw[3];
						$mail[$i][4]=$rw[4];
						$mail[$i][6]=$rw[6];
						preg_match('/<img(.+?)src=(.+?)>/i',$rw[7],$cset1);
					//	if($cset1[2]!="")
					//	$rw[7]=str_replace("attachments/","../attachments/",$cset1[2]);
						$mail[$i][7]=$rw[7];
						$mail[$i][8]=$rw[8];
						$mail[$i][9]=$rw[9];
						$mail[$i][10]=$rw[10];
						$mail[$i][11]=$rw[11];
						$mail[$i][12]=$rw[12];
						$mail[$i][13]=$folderid1[1];
						$mail[$i][15]=$rw[13];
						$mail[$i][16]=$rw[14];
						$mail[$i][17]=$this->attachcount($folderid1[1],$rw[0]);
						$mail[$i][18]=$rw[15];
						$mail[$i][19]=0;

						if($rdinfo==0)
						{
							if($folderid1[1]==1)
							$db->update("nesote_email_inbox_$tablenumber");
							else if($folderid1[1]==3)
							$db->update("nesote_email_sent_$tablenumber");
							$db->set("readflag=?",1);
							$db->where("id=?",$mailid1[1]);
							$res=$db->query();
						}
						$maild=$mail[$i][2];
						if(strpos($maild,">")!="")
						{
							preg_match('/<(.+?)>/i',$maild,$new_mailid);
							$id=$new_mailid[1];
						}
						else
						{

							if(strpos($mailid,">")!="")
							{
								preg_match('/<(.+?)>/i',$mailid,$new_mailid);
								$id=$new_mailid[1];
							}
							else if(strpos($mailid,"&lt;")!="")
							{
								preg_match('/&lt;(.+?)&gt;/i',$mailid,$new_mailid);
								$id=$new_mailid[1];
							}
							else if(strpos($mailid,"&amp;lt;")!="")
							{
								preg_match('/&amp;lt;(.+?)&amp;gt;/i',$mailid,$new_mailid);
								$id=$new_mailid[1];
							}
							else
							$id=$maild;
						}


						$subj=$mail[$i][6];
						$sub=explode(":",$subj);
						$number1=count($sub);
						$subject=$sub[$number1-1];


						$this->setLoopValue("mail",$mail);

						$this->setValue("subject",$subj);
						$total=count($mail);
						$this->setValue("total",$total);
						if($rdinfo==0)
						{
							$db1->update("nesote_email_inbox_$tablenumber");
							$db1->set("readflag=?",1);
							$db1->where("id=?",$mailid);
							$res1=$db1->query();
						}

					}



				}
				elseif($folder==3)
				{
				    //echo $tablenumber;exit;
					$db->select("nesote_email_sent_$tablenumber");
					$db->fields("*");
					$db->where("id=?",$mailid);
					$res=$db->query();
					$rw=$db->fetchRow($res);
					$references=$rw[14];
					$copy=$rw[3];
					$copy1=$rw[4];
					preg_match_all('/<item>(.+?)<\/item>/i',$references,$reply);

					$nom=count($reply[1]);

					for($i=0;$i<$nom;$i++)
					{
						preg_match('/<mailid>(.+?)<\/mailid>/i',$reply[1][$i],$mailid1);
						preg_match('/<folderid>(.+?)<\/folderid>/i',$reply[1][$i],$folderid1);
						if($folderid1[1]==1)

						$db->select("nesote_email_inbox_$tablenumber");
						else if($folderid1[1]==3)
						$db->select("nesote_email_sent_$tablenumber");
						else if($folderid1[1]>=10)
						$db->select("nesote_email_customfolder_mapping_$tablenumber");
						$db->fields("*");
						$db->where("id=?",$mailid1[1]);
						$res=$db->query();
						$rw=$db->fetchRow($res);

						$mail[$i][0]=$rw[0];
						$mail[$i][1]=$rw[1];
						$mail[$i][2]=$rw[2];
						$mail[$i][3]=$rw[3];
						$mail[$i][4]=$rw[4];
						$mail[$i][6]=$rw[6];
						preg_match('/<img(.+?)src=(.+?)>/i',$rw[7],$cset1);
					//	if($cset1[2]!="")
					//	$rw[7]=str_replace("attachments/","../attachments/",$cset1[2]);
						$mail[$i][7]=$rw[7];
						$mail[$i][8]=$rw[8];
						$mail[$i][9]=$rw[9];
						$mail[$i][10]=$rw[10];
						$mail[$i][11]=$rw[11];
						$mail[$i][12]=$rw[12];
						$mail[$i][13]=$folderid1[1];
						$mail[$i][15]=$rw[13];
						$mail[$i][16]=$rw[14];
						$mail[$i][17]=$this->attachcount($folderid1[1],$rw[0]);
						$mail[$i][18]=$rw[15];
						$mail[$i][19]=0;
						if($rdinfo==0)
						{
							if($folderid1[1]==1)

							$db->update("nesote_email_inbox_$tablenumber");
							else if($folderid1[1]==3)
							$db->update("nesote_email_sent_$tablenumber");
							else if($folderid1[1]>=10)
							$db->update("nesote_email_customfolder_mapping_$tablenumber");
							$db->set("readflag=?",1);
							$db->where("id=?",$mailid1[1]);
							$res=$db->query();
						}
					}


					$subject=$mail[0][6];
						

					$this->setLoopValue("mail",$mail);

					$this->setValue("subject",$subject);
					$total=count($mail);
					$this->setValue("total",$total);
				}
				elseif($folder==4)
				{


					$db->select("nesote_email_spam_$tablenumber");
					$db->fields("*");
					$db->where("id=?",$mailid);
					$res=$db->query();
					$rw=$db->fetchRow($res);
					$references=$rw[14];
					$copy=$rw[3];
					$copy1=$rw[4];
					preg_match_all('/<item>(.+?)<\/item>/i',$references,$reply);

					$nom=count($reply[1]);



					for($i=0;$i<$nom;$i++)
					{
						preg_match('/<mailid>(.+?)<\/mailid>/i',$reply[1][$i],$mailid1);
						preg_match('/<folderid>(.+?)<\/folderid>/i',$reply[1][$i],$folderid1);
						if($folderid1[1]==1)

						$db->select("nesote_email_inbox_$tablenumber");
						else if($folderid1[1]==3)

						$db->select("nesote_email_sent_$tablenumber");
						else if($folderid1[1]==4)

						$db->select("nesote_email_spam_$tablenumber");
						else if($folderid1[1]==5)

						$db->select("nesote_email_trash_$tablenumber");
						else if($folderid1[1]>=10)

						$db->select("nesote_email_customfolder_mapping_$tablenumber");

						$db->fields("*");
						$db->where("id=?",$mailid1[1]);
						$res=$db->query();
						$rw=$db->fetchRow($res);

						$mail[$i][0]=$rw[0];
						$mail[$i][1]=$rw[1];
						$mail[$i][2]=$rw[2];
						$mail[$i][3]=$rw[3];
						$mail[$i][4]=$rw[4];
						$mail[$i][6]=$rw[6];
						preg_match('/<img(.+?)src=(.+?)>/i',$rw[7],$cset1);
					//	if($cset1[2]!="")
					//	$rw[7]=str_replace("attachments/","../attachments/",$cset1[2]);
						$mail[$i][7]=$rw[7];
						$mail[$i][8]=$rw[8];
						$mail[$i][9]=$rw[9];
						$mail[$i][10]=$rw[10];
						$mail[$i][11]=$rw[11];
						$mail[$i][12]=$rw[12];
						$mail[$i][13]=$folderid1[1];
						$mail[$i][15]=$rw[13];
						$mail[$i][16]=$rw[14];
						$mail[$i][17]=$this->attachcount($folderid1[1],$rw[0]);
						$mail[$i][18]=$rw[15];
						$mail[$i][19]=0;
						if($rdinfo==0)
						{
							$db->update("nesote_email_spam_$tablenumber");
							$db->set("readflag=?",1);
							$db->where("id=?",$mailid1[1]);
							$res=$db->query();
						}

						$maild=$mail[$i][2];
						if(strpos($maild,">")!="")
						{
							preg_match('/<(.+?)>/i',$maild,$new_mailid);
							$id=$new_mailid[1];
						}
						else
						{

							if(strpos($mailid,">")!="")
							{
								preg_match('/<(.+?)>/i',$mailid,$new_mailid);
								$id=$new_mailid[1];
							}
							else if(strpos($mailid,"&lt;")!="")
							{
								preg_match('/&lt;(.+?)&gt;/i',$mailid,$new_mailid);
								$id=$new_mailid[1];
							}
							else if(strpos($mailid,"&amp;lt;")!="")
							{
								preg_match('/&amp;lt;(.+?)&amp;gt;/i',$mailid,$new_mailid);
								$id=$new_mailid[1];
							}
							else
							$id=$maild;
						}
						if(strpos($maild,">")!="")
						{
							preg_match('/<(.+?)>/i',$maild,$new_mailid);
							$id=$new_mailid[1];
						}
						else
						$id=$maild;


						$subject=$mail[$i][6];
						$this->setValue("subject",$subject);
						$total=count($mail);
						$this->setValue("total",$total);
						$this->setLoopValue("mail",$mail);
						if($rdinfo==0)
						{
							$db1->update("nesote_email_spam_$tablenumber");
							$db1->set("readflag=?",array(1));
							$db1->where("id=?",$mailid);
							$res1=$db1->query();
						}


					}
				}
				elseif($folder==5)
				{
					$db->select("nesote_email_trash_$tablenumber");
					$db->fields("*");
					$db->where("id=?",$mailid);
					$res=$db->query();
					$rw=$db->fetchRow($res);

					$references=$rw[14];
					$copy=$rw[3];
					$copy1=$rw[4];
					preg_match_all('/<item>(.+?)<\/item>/i',$references,$reply);

					$nom=count($reply[1]);


					for($i=0;$i<$nom;$i++)
					{
						preg_match('/<mailid>(.+?)<\/mailid>/i',$reply[1][$i],$mailid1);
						preg_match('/<folderid>(.+?)<\/folderid>/i',$reply[1][$i],$folderid1);




						$db->select("nesote_email_trash_$tablenumber");

						$db->fields("*");
						$db->where("id=?",$mailid1[1]);
						$res=$db->query();
						$rw=$db->fetchRow($res);

						$mail[$i][0]=$rw[0];
						$mail[$i][1]=$rw[1];
						$mail[$i][2]=$rw[2];
						$mail[$i][3]=$rw[3];
						$mail[$i][4]=$rw[4];
						$mail[$i][6]=$rw[6];
						preg_match('/<img(.+?)src=(.+?)>/i',$rw[7],$cset1);
					//	if($cset1[2]!="")
					//	$rw[7]=str_replace("attachments/","../attachments/",$cset1[2]);
						$mail[$i][7]=$rw[7];
						$mail[$i][8]=$rw[8];
						$mail[$i][9]=$rw[9];
						$mail[$i][10]=$rw[10];
						$mail[$i][11]=$rw[11];
						$mail[$i][12]=$rw[12];
						$mail[$i][13]=$folderid1[1];
						$mail[$i][15]=$rw[13];
						$mail[$i][16]=$rw[14];
						$mail[$i][17]=$this->attachcount($folderid1[1],$rw[0]);
						$mail[$i][18]=$rw[15];
						$mail[$i][19]=0;
						if($rdinfo==0)
						{
							$db->update("nesote_email_trash_$tablenumber");
							$db->set("readflag=?",1);
							$db->where("id=?",$mailid1[1]);
							$res=$db->query();
						}
					}


					$subject=$mail[0][6];
					$this->setValue("subject",$subject);
					$total=count($mail);

					$this->setValue("total",$total);

					$this->setLoopValue("mail",$mail);
					if($rdinfo==0)
					{
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("readflag=?",array(1));
						$db1->where("id=?",$mailid);
						$res1=$db1->query();
					}
				}
				else
				{
					$db->select("nesote_email_customfolder_mapping_$tablenumber");
					$db->fields("*");
					$db->where("id=?",$mailid);
					$res=$db->query();
					$rw=$db->fetchRow($res);
					$references=$rw[14];
					$copy=$rw[3];
					$copy1=$rw[4];
					preg_match_all('/<item>(.+?)<\/item>/i',$references,$reply);

					$nom=count($reply[1]);



					for($i=0;$i<$nom;$i++)
					{
						preg_match('/<mailid>(.+?)<\/mailid>/i',$reply[1][$i],$mailid1);
						preg_match('/<folderid>(.+?)<\/folderid>/i',$reply[1][$i],$folderid1);
						if($folderid1[1]==1)

						$db->select("nesote_email_inbox_$tablenumber");
						else if($folderid1[1]==3)

						$db->select("nesote_email_sent_$tablenumber");
						else if($folderid1[1]==4)

						$db->select("nesote_email_spam_$tablenumber");
						else if($folderid1[1]==5)

						$db->select("nesote_email_trash_$tablenumber");
						else if($folderid1[1]>=10)

						$db->select("nesote_email_customfolder_mapping_$tablenumber");

						$db->fields("*");
						$db->where("id=?",$mailid1[1]);
						$res=$db->query();
						$rw=$db->fetchRow($res);

						$mail[$i][0]=$rw[0];
						$mail[$i][1]=$rw[1];
						$mail[$i][2]=$rw[2];
						$mail[$i][3]=$rw[3];
						$mail[$i][4]=$rw[4];
						$mail[$i][6]=$rw[6];
						preg_match('/<img(.+?)src=(.+?)>/i',$rw[7],$cset1);
				//		if($cset1[2]!="")
				//		$rw[7]=str_replace("attachments/","../attachments/",$cset1[2]);
						$mail[$i][7]=$rw[7];
						$mail[$i][8]=$rw[8];
						$mail[$i][9]=$rw[9];
						$mail[$i][10]=$rw[10];
						$mail[$i][11]=$rw[11];
						$mail[$i][12]=$rw[12];
						$mail[$i][13]=$folderid1[1];
						$mail[$i][15]=$rw[13];
						$mail[$i][16]=$rw[14];
						$mail[$i][17]=$this->attachcount($folderid1[1],$rw[0]);
						$mail[$i][18]=$rw[15];
						$mail[$i][19]=0;

						if($rdinfo==0)
						{
							if($folderid1[1]==3)
							$db->update("nesote_email_sent_$tablenumber");
							else if($folderid1[1]>=10)
							$db->update("nesote_email_customfolder_mapping_$tablenumber");
							$db->set("readflag=?",1);
							$db->where("id=?",$mailid1[1]);
							$res=$db->query();
						}
						$maild=$mail[$i][2];
						if(strpos($maild,">")!="")
						{
							preg_match('/<(.+?)>/i',$maild,$new_mailid);
							$id=$new_mailid[1];
						}
						else
						{

							if(strpos($mailid,">")!="")
							{
								preg_match('/<(.+?)>/i',$mailid,$new_mailid);
								$id=$new_mailid[1];
							}
							else if(strpos($mailid,"&lt;")!="")
							{
								preg_match('/&lt;(.+?)&gt;/i',$mailid,$new_mailid);
								$id=$new_mailid[1];
							}
							else if(strpos($mailid,"&amp;lt;")!="")
							{
								preg_match('/&amp;lt;(.+?)&amp;gt;/i',$mailid,$new_mailid);
								$id=$new_mailid[1];
							}
							else
							$id=$maild;
						}
						if(strpos($maild,">")!="")
						{
							preg_match('/<(.+?)>/i',$maild,$new_mailid);
							$id=$new_mailid[1];
						}
						else
						$id=$maild;
						$subject=$mail[$i][6];
						$this->setValue("subject",$subject);
						$total=count($mail);
						$this->setValue("total",$total);
						$this->setLoopValue("mail",$mail);
						if($rdinfo==0)
						{
							$db1->update("nesote_email_customfolder_mapping_$tablenumber");
							$db1->set("readflag=?",array(1));
							$db1->where("id=?",$mailid);
							$res1=$db1->query();
						}

					}
				}
			}
			$username=$_COOKIE['e_username'];

			$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name=?",array('emailextension'));
			$res=$db->query();
			$rs=$db->fetchRow($res);
			$extention=$rs[0];

			if(substr($extention,0,1)!="@")
			{
				$fullid=$username."@".$extention;
			}
			else
			{
				$fullid=$username.$extention;
			}
			$arry=array();
			$arry=$copy.",".$copy1;
			$array=explode(",",$arry);
			$arraycount=count($array);

			for($i=0;$i<$arraycount;$i++)
			{
				if($array[$i]==$fullid)
				{
					$array[$i]="";
				}
			}
			$length=count($array);
			foreach($array as $key => $value)
			{
				if($value == "" || $value == " " || is_null($value))
				{
					unset($array[$key]);
				}
			}
			for($j=0,$k=0;$j<$length;$j++,$k++)

			{
				if($array[$j]!="")
				{
					$testing[$k][0]=$array[$j];

				}
				else
				$k--;



			}
			$this->setLoopValue("cc",$testing);

		}
	}

	function getstar($mailid,$folder)
	{

			$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
		//$uid=$this->getUserId();
		$db=new NesoteDALController();
		if($folder==1)
		$db->select("nesote_email_inbox_$tablenumber");
		else if($folder==2)
		$db->select("nesote_email_draft_$tablenumber");
		else if($folder==3)
		$db->select("nesote_email_sent_$tablenumber");
		else if($folder==4)
		$db->select("nesote_email_spam_$tablenumber");
		else if($folder>=10)
		$db->select("nesote_email_customfolder_mapping_$tablenumber");
		$db->fields("starflag");
		$db->where("id=?",$mailid);
		$res=$db->query();
		$row=$db->fetchRow($res);
		if($row[0]==0)
		return "<a href=\"javascript:markstar($mailid,$folder)\"><img src=\"../images/greystar_sml.png\" border=\"0\" align=\"absmiddle\" /></a>";
		else
		return "<a href=\"javascript:unmarkstar($mailid,$folder)\"><img src=\"../images/fullstar_sml.png\" border=\"0\" align=\"absmiddle\" /></a>";
	}
	function getdetaildate($date)
	{
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

		$ts=time()-$date-$diff;
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
			$lang_id=$_COOKIE['lang_mail'];
		}
		else
		{
			$select=new NesoteDALController();
			$select->select("nesote_email_settings");
			$select->fields("value");
			$select->where("name=?",'default_language');
			$result=$select->query();
			$data4=$select->fetchRow($result);
			$lang_id=$data4[0];
			$defaultlang_id=$data4[0];
		}
           
		$day=date(" j ",$date);
        $language_id=$this->getlang_id($lang_id);
		$db=new NesoteDALController();
		$db->select("nesote_email_months_messages");
		$db->fields("message");
		$db->where("month_id=? and lang_id=?",array($month_id,$language_id));
		$result=$db->query();
		$data=$db->fetchRow($result);

		if($ts>2419200)
		{

			$val = $data[0].date(" j,Y ",$date);
		}
		elseif($ts>86400)
		{
			$val =$data[0]. $day;
			$val=$data[0].$day." (".round($ts/86400,0).' '. $this->getmessage(55).')';
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
	function briefids($id1,$id2,$id3,$length)
	{//echo $id1."++++".$id2."++++";

		$leng=strlen($id1);
		if($id1[($leng-1)]==",")
		$id1=substr($id1,0,-1);
		$body=$id1.",".$id2;
		$lengt=strlen($body);
		if($body[($lengt-1)]==",")
		$body=substr($body,0,-1);
		if($id3!=0)
		{
			$body.=",".$id3;
		}
		while($body[0]==",")
		{
			$body=substr($body,1);

		}
		$len=strlen($body);
		while($body[$len-1]==",")
		{
			$body=substr($body,0,-1);
			$len--;
		}
		while($body[0]==",")
		{
			$body=substr($body,1);

		}

		$body=htmlspecialchars($body);
		//$body=htmlspecialchars($body,ENT_QUOTES,"UTF-8");
		$ids=explode(",",$body);//return $body."***********";
		$idz="";

		for($a=0;$a<count($ids);$a++)
		{//echo $ids[$a]."&&&&&&";
			//				while(1)
			//				{
			//				if(substr(trim($ids[$a]),0,6)=="&nbsp;")
			//				{
			//					$ids[$a]=substr(trim($ids[$a]),6);
			//				}
			//				else
			//				{
			//					break;
			//				}
			//				}
			//echo $ids[$a]."++++";
			$ids[$a]=str_replace("&amp;","&",$ids[$a]);//echo $ids[$a]."++++";
			$ids[$a]=str_replace("&nbsp;","a",$ids[$a]);//echo $ids[$a]."++++";

			//$ids[$a]=html_entity_decode($ids[$a]);
			//echo $ids[$a]."//////////";
			$aa=strpos(trim($ids[$a]),"<");//echo $aa."---";
			if(($aa=="FALSE")||($aa==""))
			$aa=strpos(trim($ids[$a]),"&lt;");//echo $aa."---";
			//if(($aa=="FALSE")||($aa==""))
			//$aa=strpos(trim($ids[$a]),"&amp;lt;");
			//echo $aa."---";
			if((($aa!="FALSE")||($aa>1))&&($aa!=""))
			{
				//echo $ids[$a]."+++".$aa;
				$idz.=substr(trim($ids[$a]),0,$aa).",";
				//echo $idz."@@@@@@@@@@@";
			}
			else
			{
				//preg_match('/<(.+?)>/i',$ids[$a],$name);
				//$idz.=$name[1].",";echo $idz."*************";
				$idz.=trim($ids[$a]).",";
				//echo $idz."*************";
			}
	}
	//echo $idz."+++++++";
	$idz=substr($idz,0,-1);
	//$body=strip_tags($body);
	$brief=substr($idz,0,$length);
	return $this->getmessage(31)." :".$brief;
}
function arrange_ids($to,$cc,$bcc,$time,$sub,$from)
{
	$from=htmlspecialchars($from);
	$from=str_replace("&amp;","&",$from);
	$from=str_replace("&nbsp;"," ",$from);

	$to=htmlspecialchars($to);
	$to=str_replace("&amp;","&",$to);
	$to=str_replace("&nbsp;"," ",$to);
	//$cc=htmlentities($cc);
	$len=strlen($to);
	if($to[($len-1)]==",")
	$to=substr($to,0,-1);
	$ids=explode(",",$to);
	$no=count($ids);
	$string.="<div class=\"row\">";
	$string.="<div class=\"blackTxt\">".$this->getmessage(54).": </div>";
	$string.="<div class=\"row floatL\">";
	$string.="<div>".$from."</div>";

	$string.="</div>";
	$string.="</div><div class=\"clear\"></div>";

	$string.="<div class=\"row\">";
	$string.="<div class=\"blackTxt\">".$this->getmessage(31).": </div>";
	$string.="<div class=\"row floatL\">";

	if($to!="")
	{
		for($a=0;$a<$no;$a++)
		{
			while(1)
			{
				if(substr(trim($ids[$a]),0,6)=="&nbsp;")
				{
					$ids[$a]=substr(trim($ids[$a]),6);
				}
				else
				{
					break;
				}
			}

			$idz=$ids[$a];

			$string.="<div>".$idz."</div>";
		}
	}
	else
	$string.="<div>".$idz."</div>";

	$string.="</div>";
	$string.="</div><div class=\"clear\"></div>";

	$cc=htmlspecialchars($cc);
	$cc=str_replace("&amp;","&",$cc);
	$cc=str_replace("&nbsp;"," ",$cc);
	$length=strlen($cc);
	if($cc[($length-1)]==",")
	$cc=substr($cc,0,-1);
	$cclist=explode(",",$cc);
	$num=count($cclist);
	if($cc=="")
	$num=0;
	else
	{
		$string.="<div class=\"row\">";
		$string.="<div class=\"blackTxt \">".$this->getmessage(32).": </div>";
		$string.="<div class=\"row floatL\">";
	}
	if($cc!="")
	{
		for($a=0;$a<$num;$a++)
		{
			$idz=$cclist[$a];

			$string.="<div>".$idz."</div>";
		}
		$string.="</div>";
		$string.="</div><div class=\"clear\"></div>";
	}

	if($bcc!=0)
	{
		$bcc=htmlspecialchars($bcc);
		$bcc=str_replace("&amp;","&",$bcc);
		$bcc=str_replace("&nbsp;"," ",$bcc);
		$lngth=strlen($bcc);
		if($bcc[($lngth-1)]==",")
		$bcc=substr($bcc,0,-1);
		$bcclist=explode(",",$bcc);
		$numb=count($bcclist);
		if($bcc=="")
		$numb=0;
		else
		{
			$string.="<div class=\"row\">";
			$string.="<div class=\"blackTxt \">".$this->getmessage(33).":</div>";
			$string.="<div class=\"row floatL\">";
		}
		for($a=0;$a<$numb;$a++)
		{
			$idz=$bcclist[$a];

			$string.="<div>".$idz."</div>";

		}
		$string.="</div>";
		$string.="</div><div class=\"clear\"></div>";
	}

	$times=$this->timez($time);
	$string.="<div class=\"row\">";
	$string.="<div class=\"blackTxt \">".$this->getmessage(281).": </div>";

	$string.="<div class=\"row floatL\">";
	$string.=$times."";
	$string.="</div>";
	$string.="</div><div class=\"clear\"></div>";
	if($sub!="")
	{
		$string.="<div class=\"row\">";
		$string.="<span class=\"blackTxt \">".$this->getmessage(34).": </span>";

		$string.="<div class=\"row floatL\">";
		$string.=$sub."</div>";
		$string.="</div><div class=\"clear\"></div>";
	}
	return $string;
}

function getattachmentdetailsAction()
{
	$valid=$this->validateUser();

	if($valid!=TRUE)
	{
		header("Location:".$this->url("index/index"));
		exit(0);
	}

	
	$username=$_COOKIE['e_username'];
	$tablenumber=$this->tableid($username);
	$mailid=$this->getParam(2);
	$this->setValue("mailid",$mailid);
	$folderid=$this->getParam(1);
	$this->setValue("fid",$folderid);
	 $moreval=$this->getParam(3);
	$more=0;$ms="";

	if($moreval===0)
	{
		$more=0;
	}
	else if($moreval==-1)
	{
		$more=1;
	}
	else
	{
	 $ms=base64_decode($moreval);
	 $ms=$this->getmessage($ms);
	}
	$this->setValue("more",$more);
	$this->setValue("ms",$ms);

	$id=$this->getId();

	$response="";
	$db= new NesoteDALController();
	$db->select("nesote_email_attachments_$tablenumber");
	$db->fields("name,type");
	$db->where("folderid=? and mailid=? and attachment=?",array($folderid,$mailid,1));
	$result=$db->query();
	$num=$db->numRows($result);
	$this->setValue("num",$num);

	while($row=$db->fetchRow($result))
	{

		$filename=$row[0];$ftype=base64_encode($row[1]);

		$size=filesize("../attachments/$folderid/$tablenumber/$mailid/$filename");

		$check_string=substr($filename, strrpos($filename,'.')+1);
		$check_string=strtolower($check_string);
		$check_string=trim($check_string);
		$number=0;
		$selectz=new NesoteDALController();
		$selectz->select("nesote_email_settings");
		$selectz->fields("value");
		$selectz->where("name=?",'restricted_attachment_types');
		$resulta=$selectz->query();
		$dataz=$selectz->fetchRow($resulta);
		if($dataz[0]!="")
		{
			$r_img_formats=$dataz[0];
			$r_img_formats=str_replace(".","",$r_img_formats);
			$r_img_formats=strtolower($r_img_formats);
			$r_img_formats=trim($r_img_formats);
			$r_img_format=explode(",",$r_img_formats);

			for($b=0;$b<count($r_img_format);$b++)
			{
			    $ptr=strtolower($r_img_format[$b]);$ptr1=strtolower($check_string);
				if(($r_img_format[$b]==$check_string)||($ptr==$ptr1))
				{
					$number=1;
					break;
				}
			}
		}


		if($number==0)
		{
			$img_formats=$this->getimageformats();
			$img_format=explode(",",$img_formats);

			$no=0;
			for($a=0;$a<count($img_format);$a++)
			{
			$ptr=strtolower($img_format[$a]);$ptr1=strtolower($check_string);
				if(($check_string==$img_format[$a])||($ptr==$ptr1))
				{
					$dimention=getimagesize("../attachments/$folderid/$tablenumber/$mailid/$filename");
					if($dimention[1]>100)
					{
						$new_height=100;
						$new_width=$dimention[0]/$dimention[1]*100;
					}
					else
					{
						$new_height=$dimention[1];
						$new_width=$dimention[0];
					}
					$var=strpos($filename,"-");
					if($var>0)
					$namez=substr($filename,($var+1));
					else
					$namez=$filename;

					$new_height=$new_height."px";
					$new_width=$new_width."px";
					$url1=$this->url("mail/downloadattachment/$folderid/$mailid/$filename/$ftype");
					$url2=$this->url("mail/showimage/$folderid/$mailid/$filename");

					$response.="<div class=\"row\" style=\"padding-left:2px;\"><span  class=\"attachedImage\"><img src=\"../attachments/$folderid/$tablenumber/$mailid/$filename\" height=\"$new_height\" width=\"$new_width\" ></span></div><div class=\"row\"><span class=\"attachments\">$namez&nbsp;<a href=\"$url1\" >".$this->getmessage(101)."</a></span></div><br>";
					$no=1;

				}
			}

			if($no==0)
			{

				if($check_string=="qqq")
				{
					$filename=str_replace("qqq","exe",$filename);

				}
				$var=strpos($filename,"-");
				if($var>0)
				$namez=substr($filename,($var+1));
				else
				$namez=$filename;
				$response.="<b>&nbsp;&nbsp;<img src='../images/files.png'></b><span class=\"attachments\">$namez&nbsp;<a href=\"".$this->url("mail/downloadattachment/$folderid/$mailid/$filename/$ftype")."\" border='0'>".$this->getmessage(101)."</a></span><br><br>";


			}


		}

	}

	$response.="<span class=\"attachments\"><a href=\"".$this->url("mail/detailmail/$folderid/$mailid")."\" border='0'>Back to message</a></span>";
	$this->setValue("response",$response);

	//return  $response;
}
function getattachment($mailid,$folderid)
{

$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);

	$response="";
	$db= new NesoteDALController();
	$db->select("nesote_email_attachments_$tablenumber");
	$db->fields("name");
	$db->where("folderid=? and mailid=? and attachment=?",array($folderid,$mailid,1));
	$result=$db->query();//return $db->getQuery();
	$num=$db->numRows($result);
	if($num>0)
	{
		$url1=$this->url("mail/getattachmentdetails/$folderid/$mailid");
		$response="<div class=\"row\" style=\"padding-left:2px;\"><img  src=\"../images/filler.gif\" alt=\"\" border=\"0\" align=\"absmiddle\" class=\"iconsCornner attach-a\"><span class=\"attachments\" >&nbsp;&nbsp;$num&nbsp;<a href=\"$url1\" >".$this->getmessage(35)."</a></span></div>";
		return $response;
	}
	else
	return "";


}
function getimageformats()
{

	return "jpeg,jpg,png,gif,bmp,psd,thm,tif,yuv,3dm,pln";
}
function downloadattachmentAction()
{
	$username=$_COOKIE['e_username'];
				$tablenumber=$this->tableid($username);
				$folderid=$this->getParam(1);
				$mailid=$this->getParam(2);
				$filename=$this->getParam(3);
				$ftype=$this->getParam(4);$ftype=base64_decode($ftype);
				
				$ftype1=explode("/",$ftype);
				$ftype1[1]=strtolower($ftype1[1]);
				if($ftype1[1]=='txt' || $ftype1[1]=='csv')
                    $newftype='text/plain';
			   else if($ftype1[1]=='odt')
                     $newftype='application/vnd.oasis.opendocument.text';
               else if($ftype1[1]=='doc')
                     $newftype='application/msword';
               else if($ftype1[1]=='docx')
                     $newftype='application/vnd.openxmlformats-officedocument.wordprocessingml.document';
               else if($ftype1[1]=='jpg' || $ftype1[1]=='jpeg')
                    $newftype='image/jpeg';
			   else if($ftype1[1]=='png')
                     $newftype='image/png';
			   else if($ftype1[1]=='gif')
                     $newftype='image/gif';
				else if($ftype1[1]=='pdf')
                    $newftype='application/pdf';
				else if($ftype1[1]=='zip')
                    $newftype='application/zip';
				else if($ftype1[1]=='mp3' || $ftype1[1]=='amr' || $ftype1[1]=='wma' || $ftype1[1]=='wav' || $ftype1[1]=='3ga' || $ftype1[1]=='mid' || $ftype1[1]=='midi')
                    $newftype="audio/$ftype1[1]";
				else if($ftype1[1]=='mp4' || $ftype1[1]=='3gp' || $ftype1[1]=='mpeg' || $ftype1[1]=='mpg' || $ftype1[1]=='mpeg-4' || $ftype1[1]=='wmv' || $ftype1[1]=='avi')
                    $newftype="video/$ftype1[1]";
				else
					$newftype="application/$ftype1[1]";


				//$filename=str_replace(" ","+_+",$filename);
				$flnam=explode(".",$filename);
				$extn=$flnam[1];
				$path="../attachments/$folderid/$tablenumber/$mailid/$filename";		
		$filenam=$filename;
		$filenam=str_replace("qqq ","exe",$filenam);
		$var=strpos($filenam,"-");
		if($var!="FALSE")
		{
			$namez=substr($filenam,($var+1));

		}
		else
		$namez=$filenam;
		$attachments_path="desktop/download/$namez";

		$pathToServerFile=$path;
		
//header('Content-Type: application/force-download');
//header('Content-Disposition: attachment; filename='.$namez);

header("Content-Type: application/force-download"); 
header('Content-type: '.$newftype);
header('Content-Description: File Download');
header('Content-Disposition: attachment; filename=' . $namez);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-length: ' . filesize($pathToServerFile));
ob_clean();
flush();

		//header('Content-type: application/'.$extn);
		//header('Content-disposition: attachment; filename='.$namez);
		readfile($pathToServerFile);
		exit;
}
function showimageAction()
{

$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
	$folderid=$this->getParam(1);
	$mailid=$this->getParam(2);
	$filename=$this->getParam(3);


	$path="../attachments/$folderid/$tablenumber/$mailid/$filename";
	$pathToServerFile=$path;
	$db= new NesoteDALController();
	$db->select("nesote_email_attachments_$tablenumber");
	$db->fields("type");
	$db->where("folderid=? and mailid=? and name=?",array($folderid,$mailid,$filename));
	$result=$db->query();
	$row=$db->fetchRow($result);

	$var=strpos($filename,"-");
	if($var!="FALSE")
	$namez=substr($filename,($var+1));
	else
	$namez=$filename;

	$attachments_path="desktop/download/$namez";

	header('Content-Type:'. $row[0].'; filename='.$namez);
	readfile($pathToServerFile);

	exit(0);

}
function timez1($time)
{
	$month_id = date("n",$time);
	if(isset ($_COOKIE['lang_mail']))
	{
		$lang_id=$_COOKIE['lang_mail'];
	}
	else
	{
		$select=new NesoteDALController();
		$select->select("nesote_email_settings");
		$select->fields("value");
		$select->where("name=?",'default_language');
		$result=$select->query();
		$data4=$select->fetchRow($result);
		$lang_id=$data4[0];
		$defaultlang_id=$data4[0];
	}

	$day=date(" j ",$time);
    $language_id=$this->getlang_id($lang_id);
	$db=new NesoteDALController();
	$db->select("nesote_email_months_messages");
	$db->fields("message");
	$db->where("month_id=? and lang_id=?",array($month_id,$language_id));
	$result=$db->query();
	$data=$db->fetchRow($result);



	$val = $data[0].date(" j,Y h:i:s A",$time);
	return $val;
}
function timez($time)
{ 
    $date=$time;
	$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		//return date("h:i A ",$date);

		$position=$settings->getValue("time_zone_postion");

		$username=$_COOKIE['e_username'];


		$hour=$settings->getValue("time_zone_hour");



		$min=$settings->getValue("time_zone_mint");


		$diff=((3600*$hour)+(60*$min));

		if($position=="Behind")
		$diff=-$diff;
		else
		$diff=$diff;

		$ts=$date;

	
			
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

		$sign=trim($timezone[0]);
		$timezone1=substr($timezone,1);

		$timezone1=explode(":",$timezone1);
		$newtimezone=($timezone1[0]*60*60)+($timezone1[1]*60);

		if($sign=="+")
		$newtimezone=$newtimezone;
		if($sign=="-")
		$newtimezone=-$newtimezone;
		$ts=$date+$newtimezone;
		//$tsa=$tsa+$newtimezone;

		$date=$ts;

		$month_id = date("n",$date);
		if(isset ($_COOKIE['lang_mail']))
		{
			$lang_code=$_COOKIE['lang_mail'];
		}
		else
		{
			$select=new NesoteDALController();
			$select->select("nesote_email_settings");
			$select->fields("value");
			$select->where("name=?",'default_language');
			$result=$select->query();
			$data4=$select->fetchRow($result);
			$lang_code=$data4[0];
			//$defaultlang_id=$data4[0];
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
		$v1=time()-$diff+$newtimezone;
		$v2=mktime(0, 0, 0, date("m",$v1), date("d",$v1), date("Y",$v1));
		
		
		$val=date("D M d Y h:i:s A",$date);
		return $val;
}
function substringMail($content)
	{//echo html_entity_decode($content);
		// Include the class definition file.
       //require_once("class/html2text/class.html2text.inc");
		//$h2t =& new html2text($content);
		//$text = $h2t->get_text();echo $text;
		//$count=100;
		$content = str_replace('<p>&nbsp</p>','',$content);
		
		require_once '../class/html2text/Html2Text.php';
		$html = new \Html2Text\Html2Text($content);
		return $text=$html->getText();
       
       //$content=str_replace("<br>","&nbsp;",$text);
		//$content=trim(strip_tags($content));
		//$content = preg_replace('/\s\s+/', ' ', $content);
		//$content=str_replace("&nbsp;","",$content);

		//return $substring_mail=substr($text,0,$count);
		//	return $content;

// 		/return utf8_encode(substr($content,0,$count));
	}

function replylinkAction()
{
	
	$valid=$this->validateUser();

	if($valid!=TRUE)
	{
		header("Location:".$this->url("index/index"));
		exit(0);
	}

	 $db=new NesoteDALController();
			$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name='public_page_logo'");
			$result1=$db->query();
			$row1=$db->fetchRow($result1);
			$img=$row1[0];
			$imgpath="../admin/logo/".$img;
			$this->setValue("imgpath",$imgpath);
			
	$userid=$this->getId();

$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
		
	$db->select("nesote_email_usersettings");
	$db->fields("signature,display");
	$db->where("userid=?",$userid);
	$res=$db->query();
	$row=$db->fetchRow($res);
	$this->setValue("sign",$row[0]);
	$this->setValue("display",$row[1]);

	$db=new NesoteDALController();
	$select=new NesoteDALController();
	$db1=new NesoteDALController();
	$folder=$this->getParam(1);//echo $folder;exit;
	$mailid=$this->getParam(2);
	$this->setValue("mailid",$mailid);
	$msgid=$this->getParam(3);
	$number=$this->getParam(4);
	if($folder=="newmail")
	{
		$this->setValue("newmail",1);$folder="";$mailid=0;
		$fldr=$this->getParam(2);$this->setValue("fldr",$fldr);
		$pge=$this->getParam(3);$this->setValue("pge",$pge);
		$action=$this->getParam(4);$msgid=$action;
		$this->setValue("act",$action);
		$crntfold=$this->getParam(5);$number=$crntfold;
		$this->setValue("crntfold",$crntfold);
		$crntid=$this->getParam(6);
		$this->setValue("crntid",$crntid);
		$ms=$this->getParam(7);
		$ms=base64_decode($ms);$ms=$this->getmessage($ms);
		$this->setValue("ms",$ms);
		$this->setValue("to","");
	}
	else if($folder=="tomail")
	{
		$this->setValue("newmail",1);$folder="";$mailid=0;
		$fldr=$this->getParam(2);$this->setValue("fldr",$fldr);
		$pge=$this->getParam(3);$this->setValue("pge",$pge);
		$action=$this->getParam(4);$msgid=$action;
		$this->setValue("act",$action);
		$to=$this->getParam(5);
		$to=$this->getcnamenew($to); $number1=$to;
		//$to.="+";
		//$to=base64_decode($to);


		$this->setValue("to",$to);

		$this->setValue("crntfold",$number1);

		$contactid=$this->getParam(6);$this->setValue("contactid",$contactid);

		$this->setValue("crntid",$contactid);
		$this->setValue("ms","");
		$number=$this->getParam(7);
	}
	else
	{
		$this->setValue("newmail",0);

		$crntfold=$this->getParam(4);
		$this->setValue("crntfold",$crntfold);
		$crntid=$this->getParam(5);
		$this->setValue("crntid",$crntid);
		$ms=$this->getParam(6);
		$ms=base64_decode($ms);$ms=$this->getmessage($ms);
		$this->setValue("ms",$ms);
	}


	$this->setValue("fid",$folder);
	$folderid=$_COOKIE['folderid'];
	if($folderid>=10)
	{
		$name=new NesoteDALController();
		$name->select("nesote_email_customfolder");
		$name->fields("name");
		$name->where("id=? and userid=?",array($folderid,$userid));
		$rs1=$name->query();
		$row1=$name->fetchRow($rs1);
		$foldername=$row1[0];
	}
	$this->setValue("folderid",$folderid);
	$this->setValue("folderd",$folderid);


	if($msgid=="r" || $msgid=="ra" || $msgid=="f" || $msgid=="c" || $msgid=="t")
	//if($msgid=="ra" || $msgid=="f" || $msgid=="c" || $msgid=="t")
	{
		$this->setValue("action",$msgid);
		$msgid="";
	}
	else
	$this->setValue("action","");

	$more=0;

	if($number==-2)
	{
		$number="";$more=0;
	}
	else if($number==-1)
	{
		$msgid="";$more=1;
	}
	$this->setValue("more",$more);
	//$from=$this->getParam(5);
	//$to=$this->getParam(6);
	$db->select("nesote_email_attachments_$tablenumber");
	$db->fields("*");
	$db->where("mailid=? and folderid=? and attachment=?",array($mailid,$folder,1));
	$res=$db->query();
	$num=$db->numRows($res);
	$this->setLoopValue("attach",$res->getResult());
	if(isset($msgid))
	{
		
			$msg=$this->getmessage($msgid);
			if($msgid=="221")
			{
				$msg=str_replace('{foldername}',$foldername,$msg);
			}
		}
		else
		{
			$msg="";
		}
		$this->setValue("msg",$msg);
		if($mailid!=0)
		{
			if($folder==1)
			{


				$db->select("nesote_email_inbox_$tablenumber");
				$db->fields("*");
				$db->where("id=?",$mailid);
				$res=$db->query();
				$rw=$db->fetchRow($res);
				$copy=$rw[3];
				$copy1=$rw[4];
				$i=0;
				$mail[$i][0]=$rw[0];
				$mail[$i][1]=$rw[1];
				$mail[$i][2]=$rw[2];
				$mail[$i][3]=$rw[3];
				$mail[$i][4]=$rw[4];
				$mail[$i][6]=$rw[6];
				preg_match('/<img(.+?)src=(.+?)>/i',$rw[7],$cset1);
						if($cset1[2]!="")
				$rw[7]=str_replace("attachments/","../attachments/",$cset1[2]);
				$mail[$i][7]=$rw[7];
				$mail[$i][8]=$rw[8];
				$mail[$i][9]=$rw[9];
				$mail[$i][10]=$rw[10];
				$mail[$i][11]=$rw[11];
				$mail[$i][12]=$rw[12];
				$mail[$i][13]=$folder[1];
				$mail[$i][15]=$rw[13];
				$mail[$i][16]=$rw[14];
				$mail[$i][17]=$this->attachcount($folder[1],$rw[0]);
				$mail[$i][18]=$rw[15];
				$mail[$i][19]=0;

				$body=htmlentities($rw[7]);
				$subj=$mail[$i][6];
				$sub=explode(":",$subj);
				$number1=count($sub);
				$subject=$sub[$number1-1];
				$mail[$i][14]=html_entity_decode($body);
                                $mail[$i][14]=$this->substringMail($mail[$i][14]);
				$this->setValue("flag",$external_content_display);

				$this->setLoopValue("mail",$mail);

				$this->setValue("subject",$subj);
                                $this->setValue("bodyreply",$mail[$i][14]);
				$total=count($mail);
				$this->setValue("total",$total);
$from=htmlspecialchars($mail[$i][2]);
	$from=str_replace("&amp;","&",$from);
	$from=str_replace("&nbsp;"," ",$from);
$from=str_replace("&lt;","<",$from);
			$from=str_replace("&gt;",">",$from);
$this->setValue("frommail",$from);
$times=$this->timez($mail[$i][8]);
$this->setValue("fromtime",$times);

			}
			else if($folder==2)
			{
//echo "aaa";exit;

				$db->select("nesote_email_draft_$tablenumber");
				$db->fields("*");
				$db->where("id=?",$mailid);
				//$this->setValue("flag",0);
				$res=$db->query();
				//echo $db->getQuery();exit;
				//$this->setLoopValue("mail",$res->getResult());


								$rw=$db->fetchRow($res);
								$copy=$rw[3];
								$copy1=$rw[4];
								$i=0;
								$mail[$i][0]=$rw[0];
								$mail[$i][1]=$rw[1];
								$mail[$i][2]=$rw[2];
								$mail[$i][3]=$rw[3];
								$mail[$i][4]=$rw[4];
								$mail[$i][6]=$rw[6];
								preg_match('/<img(.+?)src=(.+?)>/i',$rw[7],$cset1);
										if($cset1[2]!="")
								$rw[7]=str_replace("attachments/","../attachments/",$cset1[2]);
								$mail[$i][7]=$rw[7];
								$mail[$i][8]=$rw[8];
								$mail[$i][9]=$rw[9];
								$mail[$i][10]=$rw[10];
								$mail[$i][11]=$rw[11];
								$mail[$i][12]=$rw[12];
								$mail[$i][13]=$folder[1];
								$mail[$i][15]=$rw[13];
								$mail[$i][16]=$rw[14];
								$mail[$i][17]=$this->attachcount($folder[1],$rw[0]);
								$mail[$i][18]=$rw[15];
								$mail[$i][19]=0;

								$body=htmlentities($rw[7]);
								$subj=$mail[$i][6];
								$sub=explode(":",$subj);
								$number1=count($sub);
								$subject=$sub[$number1-1];
								$mail[$i][14]=html_entity_decode($body);
				                                $mail[$i][14]=$this->substringMail($mail[$i][14]);
								$this->setValue("flag",$external_content_display);

								$this->setLoopValue("mail",$mail);

								$this->setValue("subject",$subj);
				                                $this->setValue("bodyreply",$mail[$i][14]);
								$total=count($mail);
								$this->setValue("total",$total);
				$from=htmlspecialchars($mail[$i][2]);
					$from=str_replace("&amp;","&",$from);
					$from=str_replace("&nbsp;"," ",$from);
				$from=str_replace("&lt;","<",$from);
							$from=str_replace("&gt;",">",$from);
				$this->setValue("frommail",$from);
				$times=$this->timez($mail[$i][8]);
				$this->setValue("fromtime",$times);


			}
			elseif($folder==3)
			{
				$db->select("nesote_email_sent_$tablenumber");
				$db->fields("*");
				$db->where("id=?",$mailid);
				$res=$db->query();
				$rw=$db->fetchRow($res);
				$copy=$rw[3];
				$copy1=$rw[4];


				$i=0;

				$mail[$i][0]=$rw[0];
				$mail[$i][1]=$rw[1];
				$mail[$i][2]=$rw[2];
				$mail[$i][3]=$rw[3];
				$mail[$i][4]=$rw[4];
				$mail[$i][6]=$rw[6];
				preg_match('/<img(.+?)src=(.+?)>/i',$rw[7],$cset1);
						if($cset1[2]!="")
				$rw[7]=str_replace("attachments/","../attachments/",$cset1[2]);
				$mail[$i][7]=$rw[7];
				$mail[$i][8]=$rw[8];
				$mail[$i][9]=$rw[9];
				$mail[$i][10]=$rw[10];
				$mail[$i][11]=$rw[11];
				$mail[$i][12]=$rw[12];
				$mail[$i][13]=$folder[1];
				$mail[$i][15]=$rw[13];
				$mail[$i][16]=$rw[14];
				$mail[$i][17]=$this->attachcount($folder[1],$rw[0]);
				$mail[$i][18]=$rw[15];
				$mail[$i][19]=0;
				$subject=$mail[0][6];
                                $body=htmlentities($rw[7]);
				$mail[0][14]=html_entity_decode($body);
                                $mail[0][14]=$this->substringMail($mail[0][14]);
                               //$mail[0][14]=htmlspecialchars_decode($body);
                               //$mail[0][14]=strip_tags(htmlspecialchars_decode($body));

				$this->setLoopValue("mail",$mail);

				$this->setValue("subject",$subject);
                                $this->setValue("bodyreply",$mail[0][14]);
				$total=count($mail);
				$this->setValue("total",$total);
$from=htmlspecialchars($mail[$i][2]);
	$from=str_replace("&amp;","&",$from);
	$from=str_replace("&nbsp;"," ",$from);
$from=str_replace("&lt;","<",$from);
			$from=str_replace("&gt;",">",$from);
$this->setValue("frommail",$from);
$times=$this->timez($mail[$i][8]);
$this->setValue("fromtime",$times);
			}
			elseif($folder==4)
			{


				$db->select("nesote_email_spam_$tablenumber");
				$db->fields("*");
				$db->where("id=?",$mailid);
				$res=$db->query();
				$rw=$db->fetchRow($res);
				$copy=$rw[3];
				$copy1=$rw[4];$i=0;
				$mail[$i][0]=$rw[0];
				$mail[$i][1]=$rw[1];
				$mail[$i][2]=$rw[2];
				$mail[$i][3]=$rw[3];
				$mail[$i][4]=$rw[4];
				$mail[$i][6]=$rw[6];
				preg_match('/<img(.+?)src=(.+?)>/i',$rw[7],$cset1);
						if($cset1[2]!="")
				$rw[7]=str_replace("attachments/","../attachments/",$cset1[2]);
				$mail[$i][7]=$rw[7];
				$mail[$i][8]=$rw[8];
				$mail[$i][9]=$rw[9];
				$mail[$i][10]=$rw[10];
				$mail[$i][11]=$rw[11];
				$mail[$i][12]=$rw[12];
				$mail[$i][13]=$folder[1];
				$mail[$i][15]=$rw[13];
				$mail[$i][16]=$rw[14];
				$mail[$i][17]=$this->attachcount($folder[1],$rw[0]);
				$mail[$i][18]=$rw[15];
				$mail[$i][19]=0;

                     

				$body=htmlentities($rw[7]);//echo $body;



				$subject=$mail[$i][6];
				//$mail[$i][14]=htmlspecialchars_decode($body);
                                $mail[0][14]=html_entity_decode($body);
                                $mail[0][14]=$this->substringMail($mail[0][14]);
				$this->setValue("subject",$subject);
                                $this->setValue("bodyreply",$mail[0][14]);
				$total=count($mail);
				$this->setValue("total",$total);
				$this->setValue("no",$noz);
				$this->setLoopValue("mail",$mail);
$from=htmlspecialchars($mail[$i][2]);
	$from=str_replace("&amp;","&",$from);
	$from=str_replace("&nbsp;"," ",$from);
$from=str_replace("&lt;","<",$from);
			$from=str_replace("&gt;",">",$from);
$this->setValue("frommail",$from);
$times=$this->timez($mail[$i][8]);
$this->setValue("fromtime",$times);

			}
			elseif($folder==5)
			{
				$db->select("nesote_email_trash_$tablenumber");
				$db->fields("*");
				$db->where("id=?",$mailid);
				$res=$db->query();
				$rw=$db->fetchRow($res);
				$copy=$rw[3];
				$copy1=$rw[4];
				$i=0;
				$mail[$i][0]=$rw[0];
				$mail[$i][1]=$rw[1];
				$mail[$i][2]=$rw[2];
				$mail[$i][3]=$rw[3];
				$mail[$i][4]=$rw[4];
				$mail[$i][6]=$rw[6];
				preg_match('/<img(.+?)src=(.+?)>/i',$rw[7],$cset1);
						if($cset1[2]!="")
				$rw[7]=str_replace("attachments/","../attachments/",$cset1[2]);
				$mail[$i][7]=$rw[7];
				$mail[$i][8]=$rw[8];
				$mail[$i][9]=$rw[9];
				$mail[$i][10]=$rw[10];
				$mail[$i][11]=$rw[11];
				$mail[$i][12]=$rw[12];
				$mail[$i][13]=$folder[1];
				$mail[$i][15]=$rw[13];
				$mail[$i][16]=$rw[14];
				$mail[$i][17]=$this->attachcount($folder[1],$rw[0]);
				$mail[$i][18]=$rw[15];
				$mail[$i][19]=0;

				$subject=$mail[0][6];
                                $body=htmlentities($rw[7]);
				$mail[0][14]=html_entity_decode($body);
                                $mail[0][14]=$this->substringMail($mail[0][14]);
				$this->setValue("subject",$subject);
                                $this->setValue("bodyreply",$mail[0][14]);
				$total=count($mail);

				$this->setValue("total",$total);
$from=htmlspecialchars($mail[$i][2]);
	$from=str_replace("&amp;","&",$from);
	$from=str_replace("&nbsp;"," ",$from);
$from=str_replace("&lt;","<",$from);
			$from=str_replace("&gt;",">",$from);
$this->setValue("frommail",$from);
$times=$this->timez($mail[$i][8]);
$this->setValue("fromtime",$times);
			}
			else
			{
				$db->select("nesote_email_customfolder_mapping_$tablenumber");
				$db->fields("*");
				$db->where("id=?",$mailid);
				$res=$db->query();
				$rw=$db->fetchRow($res);
				$copy=$rw[3];
				$copy1=$rw[4];

				$i=0;
				$mail[$i][0]=$rw[0];
				$mail[$i][1]=$rw[1];
				$mail[$i][2]=$rw[2];
				$mail[$i][3]=$rw[3];
				$mail[$i][4]=$rw[4];
				$mail[$i][6]=$rw[6];
				$mail[$i][7]=$rw[7];
				preg_match('/<img(.+?)src=(.+?)>/i',$rw[7],$cset1);
						if($cset1[2]!="")
				$rw[7]=str_replace("attachments/","../attachments/",$cset1[2]);
				$mail[$i][8]=$rw[8];
				$mail[$i][9]=$rw[9];
				$mail[$i][10]=$rw[10];
				$mail[$i][11]=$rw[11];
				$mail[$i][12]=$rw[12];
				$mail[$i][13]=$folder[1];
				$mail[$i][15]=$rw[13];
				$mail[$i][16]=$rw[14];
				$mail[$i][17]=$this->attachcount($folder[1],$rw[0]);
				$mail[$i][18]=$rw[15];
				$mail[$i][19]=0;
				$maild=$mail[$i][2];

				$body=htmlentities($rw[7]);

				$subject=$mail[$i][6];
				//$mail[$i][14]=htmlspecialchars_decode($body);
                                $mail[0][14]=html_entity_decode($body);
                                $mail[0][14]=$this->substringMail($mail[0][14]);
				$this->setValue("subject",$subject);
                                $this->setValue("bodyreply",$mail[0][14]);
				$total=count($mail);
				$this->setValue("total",$total);
$from=htmlspecialchars($mail[$i][2]);
	$from=str_replace("&amp;","&",$from);
	$from=str_replace("&nbsp;"," ",$from);
$from=str_replace("&lt;","<",$from);
			$from=str_replace("&gt;",">",$from);
$this->setValue("frommail",$from);
$times=$this->timez($mail[$i][8]);
$this->setValue("fromtime",$times);
				$this->setLoopValue("mail",$mail);
			}
		}
		$username=$_COOKIE['e_username'];
		$this->setValue("folderid",$folder);
		$db->select("nesote_email_settings");
		$db->fields("value");
		$db->where("name=?",array('emailextension'));
		$res=$db->query();
		$rs=$db->fetchRow($res);
		$extention=$rs[0];

		if(substr($extention,0,1)!="@")
		{
			$fullid=$username."@".$extention;
		}
		else
		{
			$fullid=$username.$extention;
		}
		$arry=array();
		$arry=$copy.",".$copy1;
		$array=explode(",",$arry);
		$arraycount=count($array);

		for($i=0;$i<$arraycount;$i++)
		{
			if($array[$i]==$fullid)
			{
				$array[$i]="";
			}
		}
		$length=count($array);
		foreach($array as $key => $value)
		{
			if($value == "" || $value == " " || is_null($value))
			{
				unset($array[$key]);
			}
		}
		for($j=0,$k=0;$j<$length;$j++,$k++)

		{
			if($array[$j]!="")
			{
				$testing[$k][0]=$array[$j];

			}
			else
			$k--;



		}


	}

	function pre($x)
	{

		$db=new NesoteDALController();
		if($x=="r" || $x=="ra")
		//if($x=="ra")
		{
			$c="reply_sub_predecessor";

		}
		else if($x=="f")
		{
			$c="forward_sub_predecessor";
		}
		$db->select("nesote_email_settings");
		$db->fields("value");
		$db->where("name=?",array($c));
		$res=$db->query();
		$row1=$db->fetchRow($res);
		echo $row1[0];


	}

	function tolist($to_list)
	{
		if($to_list=="")
		return "";
		$address="";
		$uid=$this->getId();
		$username=$_COOKIE['e_username'];
		$db=new NesoteDALController();
		$db->select("nesote_email_settings");
		$db->fields("value");
		$db->where("name=?",array(emailextension));
		$res=$db->query();
		$rs=$db->fetchRow($res);
		$extention=$rs[0];

		if(substr($extention,0,1)!="@")
		{
			$fullid=$username."@".$extention;
		}
		else
		{
			$fullid=$username.$extention;
		}

		$to_list=trim($to_list);

		$length=strlen($to_list);
		$a=$to_list[$length-1];
		if($a==",")
		$to_list=substr($to_list,0,-1);
		$to_list=trim($to_list);

		$addresses=explode(",",$to_list);
		for($i=0;$i<count($addresses);$i++)
		{
			$addresses[$i]=trim($addresses[$i]);
			$len[$i]=strlen($addresses[$i]);
			preg_match('/<(.+?)>/i',$addresses[$i],$adrs);
			if(count($adrs[1])==0)
			preg_match('/&lt;(.+?)&gt;/i',$addresses[$i],$adrs);
			if(($adrs[1]!=$fullid)&&($addresses[$i]!=$fullid))
			{
				$address.=$addresses[$i].",";
			}
		}
		if(trim($address)==",")
		$address="";
		return $address;


	}
	function to($from,$to1)
	{
		//return $from."+++++++".$to;
		$tolist=explode(",",$to1);//print_r($tolist);echo "----";
		$to2=$tolist[0];//echo $to."+++++++".$from."++";
		$uid=$this->getId();
		$username=$_COOKIE['e_username'];
		$db=new NesoteDALController();
		$db->select("nesote_email_settings");
		$db->fields("value");
		$db->where("name=?",array(emailextension));
		$res=$db->query();
		$rs=$db->fetchRow($res);
		$extention=$rs[0];
		if(substr($extention,0,1)!="@")
		{
			$fullid=$username."@".$extention;
		}
		else
		{
			$fullid=$username.$extention;
		}
		$length=strpos($from,"<");//echo $length."frm";
		if($length>1)
		{
			preg_match('/<(.+?)>/i',$from,$fromarray);
			$from1=$fromarray[1];
		}
		else
		{
			$from1=$from;
		}
		$length1=strpos($to2,"<");//echo $length1."to";
		if($length1>1)
		{
			preg_match('/<(.+?)>/i',$to2,$toarray);
			$to=$toarray[1];
		}
		else
		{
			$to=$to2;
		}
		//echo $to."++++".$from1."+++";

		if($from1==$fullid)
		$to=$to;

		else
		$to=$from;



		return $to=($to);
	}

	function replymailAction()
	{
/*
require("script.inc.php");
if($restricted_mode=='true')
		{

			header("Location:".$this->url("message/error/1023"));
			exit(0);
		}
*/
			$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
		$folderid=$this->getParam(2);
		$mailid=$this->getParam(1);
		$action=$this->getParam(3);
		$crntfold=$this->getParam(4);
		$crntid=$this->getParam(5);

$drftid ='draftid_'.$mailid.'_0';
		$send=$_POST['send'];
		$draft=$_POST['draft'];
		$discard=$_POST['discard'];
		$draftid=$_POST[$drftid];
//echo $draftid;exit;

		if(isset($send))
		$type=1;
		else
		if(isset($draft))
		$type=2;
		else
		if(isset($discard))
		$type=3;

require("script.inc.php");
if($restricted_mode=='true')
		{

			$p=base64_encode(340);
				header("Location:".$this->url("mail/replylink/$folderid/$mailid/$action/$crntfold/$crntid/$p"));
			exit(0);
		}
//echo $folderid;exit;
		$to=$_POST['to'];
		$to=str_replace("\"","",$to);
		$cc=$_POST['cc'];
		$cc=str_replace("\"","",$cc);
		$bcc=$_POST['bcc'];
		$bcc=str_replace("\"","",$bcc);

		if($to=="" && $cc=="" && $bcc=="")
		{
			$p=base64_encode(330);
			//header("Location:".$this->url("mail/replylink/$mailid/$folderid/$action/$crntfold/$crntid/$p"));
                        header("Location:".$this->url("mail/replylink/$folderid/$mailid/$action/$crntfold/$crntid/$p"));
			exit(0);
		}

		$db=new NesoteDALController();
	
		if($folderid==1)
		$db->select("nesote_email_inbox_$tablenumber");
		else if($folderid==3)
		$db->select("nesote_email_sent_$tablenumber");
		else if($folderid==2)
		$db->select("nesote_email_draft_$tablenumber");
		else if($folderid==4)
		$db->select("nesote_email_spam_$tablenumber");
		else if($folderid>=10)
		$db->select("nesote_email_customfolder_mapping_$tablenumber");
		$db->fields("mail_references,message_id,body");
		$db->where("id=?", array($mailid));
		$result=$db->query();
		$row=$db->fetchRow($result);
		$mail_reference=$row[0];
		$replyto=$row[1];
		
		$html=$_POST["newbody"];
		preg_match('/<img(.+?)src=(.+?)>/i',$html,$cset1);
						if($cset1[2]!="")
		$html=str_replace("../attachments/","attachments/",$cset1[2]);
			
			
		$html=htmlspecialchars($html);
		$subject=htmlspecialchars($_POST["sub"]);
		
		
		/*if(isset($_POST["previousbody"]))
		{
			$html.="<br>".$row[2];
		}*/
		


		
		
		$username=$_COOKIE['e_username'];
		$password=$_COOKIE['e_password'];

		$from=$username;
		$id=$this->getId();

		$db->select("nesote_email_usersettings");
		$db->fields("signature,signatureflag");
		$db->where("userid=?",$id);
		$res=$db->query();
		$row=$db->fetchRow($res);
		if($row[0]!="" && $row[1]==1)
		$html.="<br>".$row[0];
$html=str_replace("\n","<br>",$html);

		$magic=get_magic_quotes_gpc();
		if($magic==1)
		{
			$html=stripslashes($html);
			$to=stripslashes($to);
			$cc=stripslashes($cc);
			$bcc=stripslashes($bcc);
		}
		$html=htmlspecialchars_decode($html);
		$time=time();

		if($type==1)
		{
				
		$ss=$this->smtp($to,$cc,$bcc,$subject,$html,$id,$mail_reference,$replyto,$draftid,$folderid,$mailid);
			if(stristr(trim($ss),"Invalid address")!="")
			{
				echo $ss;exit;
			}
			if($folderid==2)
			{
			$db->delete("nesote_email_draft_$tablenumber");
						$db->where("id=?",array($mailid));
						$db->query();
			}
			$this->saveLogs("Sent Mail",$username." has sent a mail");
			$p=base64_encode(173);
			header("Location:".$this->url("mail/detailmail/$folderid/$mailid/$p"));
			exit(0);

		}
		else if($type==2)
		{


			$fullid=$username.$this->getextension();

			$to=str_replace("&Acirc;","",$to);
			$to=str_replace("&lt;","<",$to);
			$to=str_replace("&gt;",">",$to);

			$cc=str_replace("&Acirc;","",$cc);
			$cc=str_replace("&lt;","<",$cc);
			$cc=str_replace("&gt;",">",$cc);

			$bcc=str_replace("&Acirc;","",$bcc);
			$bcc=str_replace("&lt;","<",$bcc);
			$bcc=str_replace("&gt;",">",$bcc);

			$time=$this->getusertime();



			/*$db->insert("nesote_email_draft_$tablenumber");
			$db->fields("userid,from_list,to_list,cc,bcc,subject,body,time,just_insert");
			$db->values(array($id,$fullid,$to,$cc,$bcc,$subject,$html,$time,0));
			$db->query();
			//$last_id=$db->lastInsert();
			$last_id=$db->lastInsertid("nesote_email_draft_$tablenumber");*/

				$db->update("nesote_email_draft_$tablenumber");
			$db->set("to_list=?,cc=?,bcc=?,subject=?,body=?,time=?,just_insert=?,userid=?,from_list=?",array($to,$cc,$bcc,$subject,$html,$time,0,$id,$fullid));
			$db->where("id=?",array($draftid));
			$rs=$db->query();$last_id=$draftid;


			$var=time().$username.$last_id;
			$message_id="<".md5($var).$extention.">";
			$references="<references><item><mailid>$last_id</mailid><folderid>2</folderid></item></references>";
			$db->update("nesote_email_draft_$tablenumber");
			$db->set("message_id=?,mail_references=?",array($message_id,$references));
			$db->where("id=?",$last_id);
			$res=$db->query();

			$this->saveLogs("Saved to Draft",$username." has saved a mail to draft");
			$p=base64_encode(449);
			header("Location:".$this->url("mail/detailmail/2/$last_id/$p"));
			exit(0);
		}
		else if($type==3)
		{
			header("Location:".$this->url("mail/detailmail/$folderid/$mailid"));
			exit(0);
		}
	}

	function mailactionAction()
	{
		$spam=$_POST['spam'];
		$delete=$_POST['delete'];

		if(isset($spam))
		$type=1;
		else
		if(isset($delete))
		$type=2;

		$folderid=$this->getParam(1);
		$page=$this->getParam(2);
		$perpagesize=$this->getParam(3);
		$mailpage=$this->getParam(4);
		$idstring="";

		for($i=0;$i<$perpagesize;$i++)
		{

			if($_POST['cb'.$i]!="")
			{
				$idstring.=$_POST['cb'.$i].",";
			}
		}

		$len=strlen($idstring);
		if($idstring[$len-1]==",")
		$ids=substr($idstring,0,-1);
		else
		$ids=$idstring;
		$idz=explode(",",$ids);
		$number=count($idz);
		if($idz=="" || $len==0)
		{
			$p=base64_encode(304);
			header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
			exit(0);
		}


		if($type==1) //Report spam
		{
			$str=$this->makespam($folderid,$idstring,$page,$mailpage);
			echo $str;exit;
		}
		else if($type==2)  //delete
		{
			$str=$this->delete($folderid,$idstring,$page,$mailpage);
			echo $str;exit;
		}




	}

	function delete($folderid,$idstring,$page,$mailpage)
	{
	    //return $folderid;exit;

		$valid=$this->validateUser();
		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		else
		{
			$userid=$this->getId();
			$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
			$len=strlen($idstring);
			if($idstring[$len-1]==",")
			$ids=substr($idstring,0,-1);
			else
			$ids=$idstring;
			$idz=explode(",",$ids);
			$number=count($idz);
			$db=new NesoteDALController();
			$db1=new NesoteDALController();
			$db2=new NesoteDALController();
			if($folderid==1)
			{

				$db->select("nesote_email_inbox_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				$groups="";
				while($row=$db->fetchRow($ros))
				{

					$groups=$this->getgroups($row[0]);
					$d="";
					$mailids="";

					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);

						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==1)
						$db->select("nesote_email_inbox_$tablenumber");

						else if($folder[$a]==3)
						$db->select("nesote_email_sent_$tablenumber");

						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						while($rw=$db->fetchRow($rs))
						{
							$d.=$a.",";

							$db1->insert("nesote_email_trash_$tablenumber");
							$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
							$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$folder[$a]));
							$db1->query();
							//$maild=$db1->lastInsert();
							$maild=$db1->lastInsertid("nesote_email_trash_$tablenumber");
							$body=$rw[7];
							$body=str_replace("attachments/".$folder[$a]."/".$tablenumber."/".$mailid[$a],"attachments/5/".$tablenumber."/".$maild,$body);
							$db1->update("nesote_email_trash_$tablenumber");
							$db1->set("body=?",array($body));
							$db1->where("id=?",$maild);
							$rs1=$db1->query();
							$mailids.=$maild.",";
							$this->saveLogs("Deleted Mail",$username." has deleted a mail to trash");

							$db2->select("nesote_email_attachments_$tablenumber");
							$db2->fields("*");
							$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
							$rs2=$db2->query();
							while($row2=$db2->fetchRow($rs2))
							{

								$db->update("nesote_email_attachments_$tablenumber");
								$db->set("mailid=?,folderid=?",array($maild,5));
								$db->where("id=?",$row2[0]);
								$res=$db->query();
								if((is_dir("../attachments/5/".$maild))!=TRUE)
								{
									mkdir("../attachments/5/".$maild,0777);

								}
								copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/5/".$tablenumber."/".$maild."/".$row2[2]);
								unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
								rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
							}



							$e=explode(",",$d);
							if($e[0]==$a)
							{

								$references=$this->new_reference($row[0],$folder[$a],5,$mailid[$a],$maild);
							}
							else
							{

								$references=$this->new_reference($references,$folder[$a],5,$mailid[$a],$maild);
							}

						}

						if($folder[$a]==1)
						$db->delete("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
					}
					$ides=explode(",",$mailids);
					$num=count($ides);
					for($b=0;$b<$num;$b++)
					{

						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("mail_references=?",$references);
						$db1->where("id=?",array($ides[$b]));
						$db1->query();
					}
				}
				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_inbox_$tablenumber");
				$db->fields("id");
				$db->where("userid=? and id<?",array($userid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{

					if($number==1)
					{
						$p=base64_encode(174);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}

				}
				else
				{

					$db->select("nesote_email_inbox_$tablenumber");
					$db->fields("id");
					$db->where("userid=? and id>?",array($userid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(174);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
			}
			else if($folderid==2)
			{

				$db->select("nesote_email_draft_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				//echo $db->getQuery();exit;
				$groups="";
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);
					$d="";
					$mailids="";
					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);

						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==2)
						$db->select("nesote_email_draft_$tablenumber");
						else if($folder[$a]==1)
						$db->select("nesote_email_inbox_$tablenumber");

						else if($folder[$a]==3)
						$db->select("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->select("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->select("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->select("nesote_email_customfolder_mapping_$tablenumber");
						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						$rw=$db->fetchRow($rs);
						$d.=$a.",";
						$db1->insert("nesote_email_trash_$tablenumber");
						$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
						$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$folder[$a]));
						$db1->query();
						//$maild=$db1->lastInsert();
						$maild=$db1->lastInsertid("nesote_email_trash_$tablenumber");
						$body=$rw[7];
						$body=str_replace("attachments/".$folder[$a]."/".$tablenumber."/".$mailid[$a],"attachments/5/".$tablenumber."/".$maild,$body);
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("body=?",array($body));
						$db1->where("id=?",$maild);
						$rs1=$db1->query();
						$mailids.=$maild.",";
						$this->saveLogs("Deleted Mail",$username." has deleted a mail to trash");

						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->update("nesote_email_attachments_$tablenumber");
							$db->set("mailid=?,folderid=?",array($maild,5));
							$db->where("id=?",$row2[0]);
							$res=$db->query();
							if((is_dir("../attachments/5/".$tablenumber."/".$maild))!=TRUE)
							{
								mkdir("../attachments/5/".$tablenumber."/".$maild,0777);

							}
							copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/5/".$tablenumber."/".$maild."/".$row2[2]);
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}



						$e=explode(",",$d);
						if($e[0]==$a)
						$references=$this->new_reference($row[0],$folder[$a],5,$mailid[$a],$maild);
						$references=$this->new_reference($references,$folder[$a],5,$mailid[$a],$maild);
						if($folder[$a]==2)
						$db->delete("nesote_email_draft_$tablenumber");
						else if($folder[$a]==1)
						$db->delete("nesote_email_inbox_$tablenumber");
						//
						else if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->delete("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->delete("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->delete("nesote_email_customfolder_mapping_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
					}
					$ides=explode(",",$mailids);
					$num=count($ides);
					for($b=0;$b<$num;$b++)
					{
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("mail_references=?",$references);
						$db1->where("id=?",array($ides[$b]));
						$db1->query();
					}
				}
				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_draft_$tablenumber");
				$db->fields("id");
				$db->where("userid=? and just_insert=? and id<?",array($userid,0,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{
					if($number==1)
					{
						$p=base64_encode(174);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
				else
				{

					$db->select("nesote_email_draft_$tablenumber");
					$db->fields("id");
					$db->where("userid=? and just_insert=? and id>?",array($userid,0,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(174);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
			}
			else if($folderid==3)
			{
			    //$folder=array();
			    //return $tablenumber;exit;
				$db->select("nesote_email_sent_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				//return $db->getQuery();exit;
				$groups="";
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);
					$d="";
					$mailids="";
					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);
						//					echo $ides;exit;
						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==3)
						$db->select("nesote_email_sent_$tablenumber");
						else if($folder[$a]==1)
						$db->select("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->select("nesote_email_draft_$tablenumber");

						else if($folder[$a]==4)
						$db->select("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->select("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->select("nesote_email_customfolder_mapping_$tablenumber");
						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						$rw=$db->fetchRow($rs);
						$d.=$a.",";
						$db1->insert("nesote_email_trash_$tablenumber");
						$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
						$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$folder[$a]));
						$db1->query();
						//$maild=$db1->lastInsert();
						$maild=$db1->lastInsertid("nesote_email_trash_$tablenumber");
						$body=$rw[7];
						$body=str_replace("attachments/".$folder[$a]."/".$tablenumber."/".$mailid[$a],"attachments/5/".$tablenumber."/".$maild,$body);
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("body=?",array($body));
						$db1->where("id=?",$maild);
						$rs1=$db1->query();
						$mailids.=$maild.",";
						$this->saveLogs("Deleted Mail",$username." has deleted a mail to trash");

						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->update("nesote_email_attachments_$tablenumber");
							$db->set("mailid=?,folderid=?",array($maild,5));
							$db->where("id=?",$row2[0]);
							$res=$db->query();
							if((is_dir("../attachments/5/".$tablenumber."/".$maild))!=TRUE)
							{
								if((is_dir("../attachments/5/".$tablenumber))!=TRUE)
							    {	
							    	
							    if((is_dir("../attachments/5/"))!=TRUE)
							    mkdir("../attachments/5/",0777);
				    
							    mkdir("../attachments/5/".$tablenumber,0777);
							    }
								mkdir("../attachments/5/".$tablenumber."/".$maild,0777);

							}
							copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/5/".$tablenumber."/".$maild."/".$row2[2]);
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}



						$e=explode(",",$d);
						//print_r($mailid);exit;
						if($e[0]==$a)
						$references=$this->new_reference($row[0],$folder[$a],5,$mailid[$a],$maild);
						$references=$this->new_reference($references,$folder[$a],5,$mailid[$a],$maild);
						if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						else if($folder[$a]==1)
						$db->delete("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->delete("nesote_email_draft_$tablenumber");

						else if($folder[$a]==4)
						$db->delete("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->delete("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->delete("nesote_email_customfolder_mapping_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
						//return $db->getQuery();exit;
					}
					$ides=explode(",",$mailids);
					$num=count($ides);
					for($b=0;$b<$num;$b++)
					{
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("mail_references=?",$references);
						$db1->where("id=?",array($ides[$b]));
						$db1->query();
					}
				}
				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_sent_$tablenumber");
				$db->fields("id");
				$db->where("userid=? and id<?",array($userid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{
					if($number==1)
					{
						$p=base64_encode(174);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
				else
				{

					$db->select("nesote_email_sent_$tablenumber");
					$db->fields("id");
					$db->where("userid=? and id>?",array($userid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(174);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
			}

			else if($folderid==4)
			{
				$db->select("nesote_email_spam_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				$groups="";
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);
					$d="";
					$mailids="";
					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);
						//					echo $ides;exit;
						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==4)
						$db->select("nesote_email_spam_$tablenumber");
						//
						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						$rw=$db->fetchRow($rs);
						$d.=$a.",";
						$db1->insert("nesote_email_trash_$tablenumber");
						$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
						$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$rw[15]));
						$db1->query();
						//$maild=$db1->lastInsert();
						$maild=$db1->lastInsertid("nesote_email_trash_$tablenumber");
						$body=$rw[7];
						$body=str_replace("attachments/".$folder[$a]."/".$mailid[$a],"attachments/5/".$maild,$body);
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("body=?",array($body));
						$db1->where("id=?",$maild);
						$rs1=$db1->query();
						$mailids.=$maild.",";
						$this->saveLogs("Deleted Mail",$username." has deleted a mail to trash");

						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->update("nesote_email_attachments_$tablenumber");
							$db->set("mailid=?,folderid=?",array($maild,5));
							$db->where("id=?",$row[0]);
							$res=$db->query();
							if((is_dir("../attachments/5/".$tablenumber."/".$maild))!=TRUE)
							{
								if((is_dir("../attachments/5/".$tablenumber))!=TRUE)
							    {
							    	if((is_dir("../attachments/5/"))!=TRUE)
							        {
							         mkdir("../attachments/5/",0777);
							        }
							        mkdir("../attachments/5/".$tablenumber,0777);
							    	
							    }
							
								
								mkdir("../attachments/5/".$tablenumber."/".$maild,0777);

							}
							copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/5/".$tablenumber."/".$maild."/".$row2[2]);
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}




						$e=explode(",",$d);
						if($e[0]==$a)
						$references=$this->new_reference($row[0],$folder[$a],5,$mailid[$a],$maild);
						$references=$this->new_reference($references,$folder[$a],5,$mailid[$a],$maild);
						if($folder[$a]==4)
						$db->delete("nesote_email_spam_$tablenumber");
						//
						$db->where("id=?",array($mailid[$a]));
						$db->query();
					}
					$ides=explode(",",$mailids);
					$num=count($ides);
					for($b=0;$b<$num;$b++)
					{
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("mail_references=?",$references);
						$db1->where("id=?",array($ides[$b]));
						$db1->query();
					}
				}
				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_spam_$tablenumber");
				$db->fields("id");
				$db->where("userid=? and id<?",array($userid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{
					if($number==1)
					{
						$p=base64_encode(174);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
				else
				{

					$db->select("nesote_email_spam_$tablenumber");
					$db->fields("id");
					$db->where("userid=? and id>?",array($userid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(174);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
			}

			else if($folderid==5)
			{
				$db->select("nesote_email_trash_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				//return $db->getQuery();exit;
				$groups="";
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);

					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);
						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==5)
						$db->select("nesote_email_trash_$tablenumber");

						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						//return $db->getQuery();exit;
						$rw=$db->fetchRow($rs);
						$d.=$a.",";
						$this->saveLogs("Deleted Mail",$username." has deleted a mail permenantly");

						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->delete("nesote_email_attachments_$tablenumber");
							$db->where("id=?",$row2[0]);
							$res=$db->query();
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}
						if($folder[$a]==5)
						$db->delete("nesote_email_trash_$tablenumber");
						else if($folder[$a]==2)
						$db->delete("nesote_email_draft_$tablenumber");
						else if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->delete("nesote_email_spam_$tablenumber");
						else if($folder[$a]==1)
						$db->delete("nesote_email_inbox_$tablenumber");
						else if($folder[$a]>=10)
						$db->delete("nesote_email_customfolder_mapping_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
						//return $db->getQuery();exit;
					}
				}
				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_trash_$tablenumber");
				$db->fields("id");
				$db->where("userid=? and id<?",array($userid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{
					if($number==1)
					{
						$p=base64_encode(182);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("181@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}


				}
				else
				{

					$db->select("nesote_email_trash_$tablenumber");
					$db->fields("id");
					$db->where("userid=? and id>?",array($userid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(182);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("181@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
			}


			else if($folderid>=10)
			{
			   
				$db->select("nesote_email_customfolder_mapping_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				$groups="";
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);
					$d="";
					$mailids="";
					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);

						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]>=10)
						$db->select("nesote_email_customfolder_mapping_$tablenumber");

						else if($folder[$a]==3)
						$db->select("nesote_email_sent_$tablenumber");
						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						$rw=$db->fetchRow($rs);
						$d.=$a.",";

						$db1->insert("nesote_email_trash_$tablenumber");
						$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
						$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$folder[$a]));
						$db1->query();
						//$maild=$db1->lastInsert();
						$maild=$db1->lastInsertid("nesote_email_trash_$tablenumber");
						$body=$rw[7];
						$body=str_replace("attachments/".$folder[$a]."/".$mailid[$a],"attachments/5/".$maild,$body);
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("body=?",array($body));
						$db1->where("id=?",$maild);
						$rs1=$db1->query();
						$mailids.=$maild.",";
						$this->saveLogs("Deleted Mail",$username." has deleted a mail to trash");

						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->update("nesote_email_attachments_$tablenumber");
							$db->set("mailid=?,folderid=?",array($maild,5));
							$db->where("id=?",$row2[0]);
							$res=$db->query();
							if((is_dir("../attachments/5/".$tablenumber."/".$maild))!=TRUE)
							{
								if((is_dir("../attachments/5/".$tablenumber))!=TRUE)
							    {
							    	if((is_dir("../attachments/5/"))!=TRUE)
							        {
							        mkdir("../attachments/5/",0777);
							        }
							        mkdir("../attachments/5/".$tablenumber,0777);
							    }
								
								mkdir("../attachments/5/".$tablenumber."/".$maild,0777);

							}
							copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/5/".$tablenumber."/".$maild."/".$row2[2]);
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}




						$e=explode(",",$d);
						if($e[0]==$a)
						$references=$this->new_reference($row[0],$folder[$a],5,$mailid[$a],$maild);
						$references=$this->new_reference($references,$folder[$a],5,$mailid[$a],$maild);
						if($folder[$a]>=10)
						$db->delete("nesote_email_customfolder_mapping_$tablenumber");
						else if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
					}
					$ides=explode(",",$mailids);
					$num=count($ides);
					for($b=0;$b<$num;$b++)
					{
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("mail_references=?",$references);
						$db1->where("id=?",array($ides[$b]));
						$db1->query();
					}
				}
				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_customfolder_mapping_$tablenumber");
				$db->fields("id");
				$db->where("folderid=? and id<?",array($folderid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{
					if($number==1)
					{
						$p=base64_encode(174);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
				else
				{

					$db->select("nesote_email_customfolder_mapping_$tablenumber");
					$db->fields("id");
					$db->where("folderid=? and id>?",array($folderid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(174);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}

			}
		}
	}

////////////////////anna///////////////////

function makespam1Action()  //$mailpage 1 for shortmail 2 for detailmail
	{
require("script.inc.php");
if($restricted_mode=='true')
		{
echo "demo";exit(0);
}

$folderid=$_POST['id1'];
$idstring=$_POST['id2'];
$page=$_POST['page'];
$mailpage='';



		$valid=$this->validateUser();
		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		else
		{

			$userid=$this->getId();
			$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
			$len=strlen($idstring);
			if($idstring[$len-1]==",")
			$ids=substr($idstring,0,-1);
			else
			$ids=$idstring;
			$idz=explode(",",$ids);
			$number=count($idz);
			if($folderid==1)
			{

				$db=new NesoteDALController();
				$db->select("nesote_email_inbox_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();//echo $db->getQuery();exit;
				$groups="";
				$c=0;
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);
					$d="";
					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);
						//					echo $ides;exit;
						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==1)
						$db->select("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->select("nesote_email_draft_$tablenumber");
						else if($folder[$a]==3)
						$db->select("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->select("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->select("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->select("nesote_email_customfolder_mapping_$tablenumber");
						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						$rw=$db->fetchRow($rs);
						$d.=$a.",";
						$db1=new NesoteDALController();
						$db1->insert("nesote_email_spam_$tablenumber");
						$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
						$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$folder[$a]));
						$db1->query();
						//$maild=$db1->lastInsert();
						$maild=$db1->lastInsertid("nesote_email_spam_$tablenumber");
						$body=$rw[7];
						$body=str_replace("attachments/".$folder[$a]."/".$tablenumber."/".$mailid[$a],"attachments/4/".$tablenumber."/".$maild,$body);
						$db1->update("nesote_email_spam_$tablenumber");
						$db1->set("body=?",array($body));
						$db1->where("id=?",$maild);
						$rs1=$db1->query();
						$mailids.=$maild.",";
						$this->saveLogs("Marked as Spam",$username." has marked a mail as spam");
						$this->removewhitelist($rw[2],$rw[1]);
						$this->setblacklist($rw[2],$rw[1]);


						$db2=new NesoteDALController();
						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->update("nesote_email_attachments_$tablenumber");
							$db->set("mailid=?,folderid=?",array($maild,4));
							$db->where("id=?",$row2[0]);
							$res=$db->query();
							if((is_dir("../attachments/4/".$tablenumber."/".$maild))!=TRUE)
							{
								
								if((is_dir("../attachments/4/".$tablenumber))!=TRUE)
							    {
							    	if((is_dir("../attachments/4/"))!=TRUE)
							        {
							        mkdir("../attachments/4/",0777);		
							        }
							        mkdir("../attachments/4/".$tablenumber,0777);
							    }
								mkdir("../attachments/4/".$tablenumber."/".$maild,0777);

							}
							copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/4/".$tablenumber."/".$maild."/".$row2[2]);
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}


						$e=explode(",",$d);

						if($e[0]==$a)
						$references=$this->new_reference($row[0],$folder[$a],4,$mailid[$a],$maild);
						else
						$references=$this->new_reference($references,$folder[$a],4,$mailid[$a],$maild);
						$c++;
						if($folder[$a]==1)
						$db->delete("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->delete("nesote_email_draft_$tablenumber");
						else if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->delete("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->delete("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->delete("nesote_email_customfolder_mapping_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
					}
				}
				$ides=explode(",",$mailids);
				$num=count($ides);

				for($b=0;$b<$num;$b++)
				{
					$db1->update("nesote_email_spam_$tablenumber");
					$db1->set("mail_references=?",$references);
					$db1->where("id=?",array($ides[$b]));
					$db1->query();
				}

				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_inbox_$tablenumber");
				$db->fields("id");
				$db->where("userid=? and id<?",array($userid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{
					if($number==1)
					{
						$p=base64_encode(191);
						echo "1";
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("192@@$number");
						echo "2";
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
				else
				{

					$db->select("nesote_email_inbox_$tablenumber");
					$db->fields("id");
					$db->where("userid=? and id>?",array($userid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);

					if($number==1)
					{
						$p=base64_encode(191);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("192@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}

				//return $url.",".$folderid.",".$row1[0];
				//exit;





			}
			else if($folderid==5)
			{
				$db=new NesoteDALController();
				$db->select("nesote_email_trash_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				$groups="";
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);
					$d="";
					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);
						//					echo $ides;exit;
						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==1)
						$db->select("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->select("nesote_email_draft_$tablenumber");
						else if($folder[$a]==3)
						$db->select("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->select("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->select("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->select("nesote_email_customfolder_mapping_$tablenumber");
						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						$rw=$db->fetchRow($rs);
						$d.=$a.",";
						$db1=new NesoteDALController();
						$db1->insert("nesote_email_spam_$tablenumber");
						$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
						$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$rw[15]));
						$db1->query();
					//	$maild=$db1->lastInsert();
						$maild=$db1->lastInsertid("nesote_email_spam_$tablenumber");
						$body=$rw[7];
						$body=str_replace("attachments/".$folder[$a]."/".$tablenumber."/".$mailid[$a],"attachments/4/".$tablenumber."/".$maild,$body);
						$db1->update("nesote_email_spam_$tablenumber");
						$db1->set("body=?",array($body));
						$db1->where("id=?",$maild);
						$rs1=$db1->query();
						$mailids.=$maild.",";
						$this->saveLogs("Marked as Spam",$username." has marked a mail as spam");
						$this->removewhitelist($rw[2],$rw[1]);
						$this->setblacklist($rw[2],$rw[1]);


						$db2=new NesoteDALController();
						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->update("nesote_email_attachments_$tablenumber");
							$db->set("mailid=?,folderid=?",array($maild,4));
							$db->where("id=?",$row2[0]);
							$res=$db->query();
							
						   if((is_dir("../attachments/4/".$tablenumber."/".$maild))!=TRUE)
							{
								
								if((is_dir("../attachments/4/".$tablenumber))!=TRUE)
							    {
							    	if((is_dir("../attachments/4/"))!=TRUE)
							        {
							        mkdir("../attachments/4/",0777);		
							        }
							        mkdir("../attachments/4/".$tablenumber,0777);
							    }
								mkdir("../attachments/4/".$tablenumber."/".$maild,0777);

							}
							copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/4/".$tablenumber."/".$maild."/".$row2[2]);
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}



						$e=explode(",",$d);
						if($e[0]==$a)

						$references=$this->new_reference($row[0],$folder[$a],4,$mailid[$a],$maild);
						else

						$references=$this->new_reference($references,$folder[$a],4,$mailid[$a],$maild);
						if($folder[$a]==1)
						$db->delete("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->delete("nesote_email_draft_$tablenumber");
						else if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->delete("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->delete("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->delete("nesote_email_customfolder_mapping_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
					}
				}
				$ides=explode(",",$mailids);
				$num=count($ides);
				for($b=0;$b<$num;$b++)
				{
					$db1->update("nesote_email_spam_$tablenumber");
					$db1->set("mail_references=?",$references);
					$db1->where("id=?",array($ides[$b]));
					$db1->query();
				}

				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_trash_$tablenumber");
				$db->fields("id");
				$db->where("userid=? and id<?",array($userid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{

					if($number==1)
					{
						$p=base64_encode(191);
						echo "3";
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("192@@$number");
						echo "4";
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}



				}
				else
				{

					$db->select("nesote_email_trash_$tablenumber");
					$db->fields("id");
					$db->where("userid=? and id>?",array($userid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(191);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("192@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}

				//return $url.",".$folderid.",".$row1[0];
				//exit;

			}
			elseif($folderid>=10)
			{
				$db=new NesoteDALController();
				$db->select("nesote_email_customfolder_mapping_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				$groups="";
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);
					$d="";
					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);
						//					echo $ides;exit;
						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==1)
						$db->select("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->select("nesote_email_draft_$tablenumber");
						else if($folder[$a]==3)
						$db->select("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->select("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->select("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->select("nesote_email_customfolder_mapping_$tablenumber");
						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						$rw=$db->fetchRow($rs);
						$d.=$a.",";
						$db1=new NesoteDALController();
						$db1->insert("nesote_email_spam_$tablenumber");
						$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
						$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$folder[$a]));
						$db1->query();
						//$maild=$db1->lastInsert();
						$maild=$db1->lastInsertid("nesote_email_spam_$tablenumber");
						$body=$rw[7];
						$body=str_replace("attachments/".$folder[$a]."/".$tablenumber."/".$mailid[$a],"attachments/4/".$tablenumber."/".$maild,$body);
						$db1->update("nesote_email_spam_$tablenumber");
						$db1->set("body=?",array($body));
						$db1->where("id=?",$maild);
						$rs1=$db1->query();
						$mailids.=$maild.",";
						$this->saveLogs("Marked as Spam",$username." has marked a mail as spam");
						$this->removewhitelist($rw[2],$rw[1]);
						$this->setblacklist($rw[2],$rw[1]);



						$db2=new NesoteDALController();
						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->update("nesote_email_attachments_$tablenumber");
							$db->set("mailid=?,folderid=?",array($maild,4));
							$db->where("id=?",$row2[0]);
							$res=$db->query();
						    if((is_dir("../attachments/4/".$tablenumber."/".$maild))!=TRUE)
							{
								
								if((is_dir("../attachments/4/".$tablenumber))!=TRUE)
							    {
							    	if((is_dir("../attachments/4/"))!=TRUE)
							        {
							        mkdir("../attachments/4/",0777);		
							        }
							        mkdir("../attachments/4/".$tablenumber,0777);
							    }
								mkdir("../attachments/4/".$tablenumber."/".$maild,0777);

							}
							copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/4/".$tablenumber."/".$maild."/".$row2[2]);
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}



						$e=explode(",",$d);
						if($e[0]==$a)
						$references=$this->new_reference($row[0],$folder[$a],4,$mailid[$a],$maild);
						else
						$references=$this->new_reference($references,$folder[$a],4,$mailid[$a],$maild);
						if($folder[$a]==1)
						$db->delete("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->delete("nesote_email_draft_$tablenumber");
						else if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->delete("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->delete("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->delete("nesote_email_customfolder_mapping_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
					}
					$ides=explode(",",$mailids);
					$num=count($ides);
					for($b=0;$b<$num;$b++)
					{
						$db1->update("nesote_email_spam_$tablenumber");
						$db1->set("mail_references=?",$references);
						$db1->where("id=?",array($ides[$b]));
						$db1->query();
					}
				}
				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_customfolder_mapping_$tablenumber");
				$db->fields("id");
				$db->where("folderid=? and id<?",array($folderid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{
					if($number==1)
					{
						$p=base64_encode(191);
						echo "5";
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("192@@$number");
						echo "6";
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
				else
				{

					$db->select("nesote_email_customfolder_mapping_$tablenumber");
					$db->fields("id");
					$db->where("folderid=? and id>?",array($folderid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(191);
						echo "7";
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("192@@$number");
						echo "8";
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}

				//return $url.",".$folderid.",".$row1[0];
				//exit;




			}

		}
	}




function delete1Action()
	{
require("script.inc.php");
if($restricted_mode=='true')
		{
echo "demo";exit(0);
}
exit;
	    //return $folderid;exit;

$folderid=$_POST['id1'];
$idstring=$_POST['id2'];
$page=$_POST['page'];
$mailpage='';

		$valid=$this->validateUser();
		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		else
		{
			$userid=$this->getId();
			$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
			$len=strlen($idstring);
			if($idstring[$len-1]==",")
			$ids=substr($idstring,0,-1);
			else
			$ids=$idstring;
			$idz=explode(",",$ids);
			$number=count($idz);
			$db=new NesoteDALController();
			$db1=new NesoteDALController();
			$db2=new NesoteDALController();
			if($folderid==1)
			{

				$db->select("nesote_email_inbox_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				$groups="";
				while($row=$db->fetchRow($ros))
				{

					$groups=$this->getgroups($row[0]);
					$d="";
					$mailids="";

					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);

						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==1)
						$db->select("nesote_email_inbox_$tablenumber");

						else if($folder[$a]==3)
						$db->select("nesote_email_sent_$tablenumber");

						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						while($rw=$db->fetchRow($rs))
						{
							$d.=$a.",";

							$db1->insert("nesote_email_trash_$tablenumber");
							$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
							$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$folder[$a]));
							$db1->query();
							//$maild=$db1->lastInsert();
							$maild=$db1->lastInsertid("nesote_email_trash_$tablenumber");
							$body=$rw[7];
							$body=str_replace("attachments/".$folder[$a]."/".$tablenumber."/".$mailid[$a],"attachments/5/".$tablenumber."/".$maild,$body);
							$db1->update("nesote_email_trash_$tablenumber");
							$db1->set("body=?",array($body));
							$db1->where("id=?",$maild);
							$rs1=$db1->query();
							$mailids.=$maild.",";
							$this->saveLogs("Deleted Mail",$username." has deleted a mail to trash");

							$db2->select("nesote_email_attachments_$tablenumber");
							$db2->fields("*");
							$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
							$rs2=$db2->query();
							while($row2=$db2->fetchRow($rs2))
							{

								$db->update("nesote_email_attachments_$tablenumber");
								$db->set("mailid=?,folderid=?",array($maild,5));
								$db->where("id=?",$row2[0]);
								$res=$db->query();
								if((is_dir("../attachments/5/".$maild))!=TRUE)
								{
									mkdir("../attachments/5/".$maild,0777);

								}
								copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/5/".$tablenumber."/".$maild."/".$row2[2]);
								unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
								rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
							}



							$e=explode(",",$d);
							if($e[0]==$a)
							{

								$references=$this->new_reference($row[0],$folder[$a],5,$mailid[$a],$maild);
							}
							else
							{

								$references=$this->new_reference($references,$folder[$a],5,$mailid[$a],$maild);
							}

						}

						if($folder[$a]==1)
						$db->delete("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
					}
					$ides=explode(",",$mailids);
					$num=count($ides);
					for($b=0;$b<$num;$b++)
					{

						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("mail_references=?",$references);
						$db1->where("id=?",array($ides[$b]));
						$db1->query();
					}
				}
				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_inbox_$tablenumber");
				$db->fields("id");
				$db->where("userid=? and id<?",array($userid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{

					if($number==1)
					{
						$p=base64_encode(174);
						echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");
						echo $p;
					//	header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}

				}
				else
				{

					$db->select("nesote_email_inbox_$tablenumber");
					$db->fields("id");
					$db->where("userid=? and id>?",array($userid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(174);echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
			}
			else if($folderid==2)
			{

				$db->select("nesote_email_draft_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				//echo $db->getQuery();exit;
				$groups="";
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);
					$d="";
					$mailids="";
					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);

						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==2)
						$db->select("nesote_email_draft_$tablenumber");
						else if($folder[$a]==1)
						$db->select("nesote_email_inbox_$tablenumber");

						else if($folder[$a]==3)
						$db->select("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->select("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->select("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->select("nesote_email_customfolder_mapping_$tablenumber");
						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						$rw=$db->fetchRow($rs);
						$d.=$a.",";
						$db1->insert("nesote_email_trash_$tablenumber");
						$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
						$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$folder[$a]));
						$db1->query();
						//$maild=$db1->lastInsert();
						$maild=$db1->lastInsertid("nesote_email_trash_$tablenumber");
						$body=$rw[7];
						$body=str_replace("attachments/".$folder[$a]."/".$tablenumber."/".$mailid[$a],"attachments/5/".$tablenumber."/".$maild,$body);
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("body=?",array($body));
						$db1->where("id=?",$maild);
						$rs1=$db1->query();
						$mailids.=$maild.",";
						$this->saveLogs("Deleted Mail",$username." has deleted a mail to trash");

						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->update("nesote_email_attachments_$tablenumber");
							$db->set("mailid=?,folderid=?",array($maild,5));
							$db->where("id=?",$row2[0]);
							$res=$db->query();
							if((is_dir("../attachments/5/".$tablenumber."/".$maild))!=TRUE)
							{
								mkdir("../attachments/5/".$tablenumber."/".$maild,0777);

							}
							copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/5/".$tablenumber."/".$maild."/".$row2[2]);
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}



						$e=explode(",",$d);
						if($e[0]==$a)
						$references=$this->new_reference($row[0],$folder[$a],5,$mailid[$a],$maild);
						$references=$this->new_reference($references,$folder[$a],5,$mailid[$a],$maild);
						if($folder[$a]==2)
						$db->delete("nesote_email_draft_$tablenumber");
						else if($folder[$a]==1)
						$db->delete("nesote_email_inbox_$tablenumber");
						//
						else if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->delete("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->delete("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->delete("nesote_email_customfolder_mapping_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
					}
					$ides=explode(",",$mailids);
					$num=count($ides);
					for($b=0;$b<$num;$b++)
					{
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("mail_references=?",$references);
						$db1->where("id=?",array($ides[$b]));
						$db1->query();
					}
				}
				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_draft_$tablenumber");
				$db->fields("id");
				$db->where("userid=? and just_insert=? and id<?",array($userid,0,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{
					if($number==1)
					{
						$p=base64_encode(174);echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
				else
				{

					$db->select("nesote_email_draft_$tablenumber");
					$db->fields("id");
					$db->where("userid=? and just_insert=? and id>?",array($userid,0,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(174);echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
			}
			else if($folderid==3)
			{
			    //$folder=array();
			    //return $tablenumber;exit;
				$db->select("nesote_email_sent_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				//return $db->getQuery();exit;
				$groups="";
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);
					$d="";
					$mailids="";
					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);
						//					echo $ides;exit;
						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==3)
						$db->select("nesote_email_sent_$tablenumber");
						else if($folder[$a]==1)
						$db->select("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->select("nesote_email_draft_$tablenumber");

						else if($folder[$a]==4)
						$db->select("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->select("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->select("nesote_email_customfolder_mapping_$tablenumber");
						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						$rw=$db->fetchRow($rs);
						$d.=$a.",";
						$db1->insert("nesote_email_trash_$tablenumber");
						$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
						$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$folder[$a]));
						$db1->query();
						//$maild=$db1->lastInsert();
						$maild=$db1->lastInsertid("nesote_email_trash_$tablenumber");
						$body=$rw[7];
						$body=str_replace("attachments/".$folder[$a]."/".$tablenumber."/".$mailid[$a],"attachments/5/".$tablenumber."/".$maild,$body);
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("body=?",array($body));
						$db1->where("id=?",$maild);
						$rs1=$db1->query();
						$mailids.=$maild.",";
						$this->saveLogs("Deleted Mail",$username." has deleted a mail to trash");

						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->update("nesote_email_attachments_$tablenumber");
							$db->set("mailid=?,folderid=?",array($maild,5));
							$db->where("id=?",$row2[0]);
							$res=$db->query();
							if((is_dir("../attachments/5/".$tablenumber."/".$maild))!=TRUE)
							{
								if((is_dir("../attachments/5/".$tablenumber))!=TRUE)
							    {	
							    	
							    if((is_dir("../attachments/5/"))!=TRUE)
							    mkdir("../attachments/5/",0777);
				    
							    mkdir("../attachments/5/".$tablenumber,0777);
							    }
								mkdir("../attachments/5/".$tablenumber."/".$maild,0777);

							}
							copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/5/".$tablenumber."/".$maild."/".$row2[2]);
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}



						$e=explode(",",$d);
						//print_r($mailid);exit;
						if($e[0]==$a)
						$references=$this->new_reference($row[0],$folder[$a],5,$mailid[$a],$maild);
						$references=$this->new_reference($references,$folder[$a],5,$mailid[$a],$maild);
						if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						else if($folder[$a]==1)
						$db->delete("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->delete("nesote_email_draft_$tablenumber");

						else if($folder[$a]==4)
						$db->delete("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->delete("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->delete("nesote_email_customfolder_mapping_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
						//return $db->getQuery();exit;
					}
					$ides=explode(",",$mailids);
					$num=count($ides);
					for($b=0;$b<$num;$b++)
					{
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("mail_references=?",$references);
						$db1->where("id=?",array($ides[$b]));
						$db1->query();
					}
				}
				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_sent_$tablenumber");
				$db->fields("id");
				$db->where("userid=? and id<?",array($userid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{
					if($number==1)
					{
						$p=base64_encode(174);echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
				else
				{

					$db->select("nesote_email_sent_$tablenumber");
					$db->fields("id");
					$db->where("userid=? and id>?",array($userid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(174);echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
			}

			else if($folderid==4)
			{
				$db->select("nesote_email_spam_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				$groups="";
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);
					$d="";
					$mailids="";
					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);
						//					echo $ides;exit;
						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==4)
						$db->select("nesote_email_spam_$tablenumber");
						//
						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						$rw=$db->fetchRow($rs);
						$d.=$a.",";
						$db1->insert("nesote_email_trash_$tablenumber");
						$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
						$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$rw[15]));
						$db1->query();
						//$maild=$db1->lastInsert();
						$maild=$db1->lastInsertid("nesote_email_trash_$tablenumber");
						$body=$rw[7];
						$body=str_replace("attachments/".$folder[$a]."/".$mailid[$a],"attachments/5/".$maild,$body);
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("body=?",array($body));
						$db1->where("id=?",$maild);
						$rs1=$db1->query();
						$mailids.=$maild.",";
						$this->saveLogs("Deleted Mail",$username." has deleted a mail to trash");

						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->update("nesote_email_attachments_$tablenumber");
							$db->set("mailid=?,folderid=?",array($maild,5));
							$db->where("id=?",$row[0]);
							$res=$db->query();
							if((is_dir("../attachments/5/".$tablenumber."/".$maild))!=TRUE)
							{
								if((is_dir("../attachments/5/".$tablenumber))!=TRUE)
							    {
							    	if((is_dir("../attachments/5/"))!=TRUE)
							        {
							         mkdir("../attachments/5/",0777);
							        }
							        mkdir("../attachments/5/".$tablenumber,0777);
							    	
							    }
							
								
								mkdir("../attachments/5/".$tablenumber."/".$maild,0777);

							}
							copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/5/".$tablenumber."/".$maild."/".$row2[2]);
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}




						$e=explode(",",$d);
						if($e[0]==$a)
						$references=$this->new_reference($row[0],$folder[$a],5,$mailid[$a],$maild);
						$references=$this->new_reference($references,$folder[$a],5,$mailid[$a],$maild);
						if($folder[$a]==4)
						$db->delete("nesote_email_spam_$tablenumber");
						//
						$db->where("id=?",array($mailid[$a]));
						$db->query();
					}
					$ides=explode(",",$mailids);
					$num=count($ides);
					for($b=0;$b<$num;$b++)
					{
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("mail_references=?",$references);
						$db1->where("id=?",array($ides[$b]));
						$db1->query();
					}
				}
				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_spam_$tablenumber");
				$db->fields("id");
				$db->where("userid=? and id<?",array($userid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{
					if($number==1)
					{
						$p=base64_encode(174);echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
				else
				{

					$db->select("nesote_email_spam_$tablenumber");
					$db->fields("id");
					$db->where("userid=? and id>?",array($userid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(174);echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
			}

			else if($folderid==5)
			{
				$db->select("nesote_email_trash_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				//return $db->getQuery();exit;
				$groups="";
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);

					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);
						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==5)
						$db->select("nesote_email_trash_$tablenumber");

						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						//return $db->getQuery();exit;
						$rw=$db->fetchRow($rs);
						$d.=$a.",";
						$this->saveLogs("Deleted Mail",$username." has deleted a mail permenantly");

						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->delete("nesote_email_attachments_$tablenumber");
							$db->where("id=?",$row2[0]);
							$res=$db->query();
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}
						if($folder[$a]==5)
						$db->delete("nesote_email_trash_$tablenumber");
						else if($folder[$a]==2)
						$db->delete("nesote_email_draft_$tablenumber");
						else if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->delete("nesote_email_spam_$tablenumber");
						else if($folder[$a]==1)
						$db->delete("nesote_email_inbox_$tablenumber");
						else if($folder[$a]>=10)
						$db->delete("nesote_email_customfolder_mapping_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
						//return $db->getQuery();exit;
					}
				}
				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_trash_$tablenumber");
				$db->fields("id");
				$db->where("userid=? and id<?",array($userid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{
					if($number==1)
					{
						$p=base64_encode(182);echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("181@@$number");echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}


				}
				else
				{

					$db->select("nesote_email_trash_$tablenumber");
					$db->fields("id");
					$db->where("userid=? and id>?",array($userid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(182);echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("181@@$number");echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
			}


			else if($folderid>=10)
			{
			   
				$db->select("nesote_email_customfolder_mapping_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				$groups="";
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);
					$d="";
					$mailids="";
					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);

						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]>=10)
						$db->select("nesote_email_customfolder_mapping_$tablenumber");

						else if($folder[$a]==3)
						$db->select("nesote_email_sent_$tablenumber");
						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						$rw=$db->fetchRow($rs);
						$d.=$a.",";

						$db1->insert("nesote_email_trash_$tablenumber");
						$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
						$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$folder[$a]));
						$db1->query();
						//$maild=$db1->lastInsert();
						$maild=$db1->lastInsertid("nesote_email_trash_$tablenumber");
						$body=$rw[7];
						$body=str_replace("attachments/".$folder[$a]."/".$mailid[$a],"attachments/5/".$maild,$body);
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("body=?",array($body));
						$db1->where("id=?",$maild);
						$rs1=$db1->query();
						$mailids.=$maild.",";
						$this->saveLogs("Deleted Mail",$username." has deleted a mail to trash");

						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->update("nesote_email_attachments_$tablenumber");
							$db->set("mailid=?,folderid=?",array($maild,5));
							$db->where("id=?",$row2[0]);
							$res=$db->query();
							if((is_dir("../attachments/5/".$tablenumber."/".$maild))!=TRUE)
							{
								if((is_dir("../attachments/5/".$tablenumber))!=TRUE)
							    {
							    	if((is_dir("../attachments/5/"))!=TRUE)
							        {
							        mkdir("../attachments/5/",0777);
							        }
							        mkdir("../attachments/5/".$tablenumber,0777);
							    }
								
								mkdir("../attachments/5/".$tablenumber."/".$maild,0777);

							}
							copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/5/".$tablenumber."/".$maild."/".$row2[2]);
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}




						$e=explode(",",$d);
						if($e[0]==$a)
						$references=$this->new_reference($row[0],$folder[$a],5,$mailid[$a],$maild);
						$references=$this->new_reference($references,$folder[$a],5,$mailid[$a],$maild);
						if($folder[$a]>=10)
						$db->delete("nesote_email_customfolder_mapping_$tablenumber");
						else if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
					}
					$ides=explode(",",$mailids);
					$num=count($ides);
					for($b=0;$b<$num;$b++)
					{
						$db1->update("nesote_email_trash_$tablenumber");
						$db1->set("mail_references=?",$references);
						$db1->where("id=?",array($ides[$b]));
						$db1->query();
					}
				}
				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_customfolder_mapping_$tablenumber");
				$db->fields("id");
				$db->where("folderid=? and id<?",array($folderid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{
					if($number==1)
					{
						$p=base64_encode(174);echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
				else
				{

					$db->select("nesote_email_customfolder_mapping_$tablenumber");
					$db->fields("id");
					$db->where("folderid=? and id>?",array($folderid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(174);echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("177@@$number");echo $p;
						//header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}

			}
		}
	}




	//////////////////////anna///////////////////

	function spamAction()
	{
		$valid=$this->validateUser();
		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		$folderid=$this->getParam(1);$idstring=$this->getParam(2);$page=$this->getParam(3);
		if($idstring=="")
		{
			$p=base64_encode(304);
			header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
			exit(0);
		}
require("script.inc.php");
if($restricted_mode=='true')
		{

			$p=base64_encode(340);
				header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
				exit(0);
		}

		$str=$this->makespam($folderid,$idstring,$page,'');

	}

	function maildeleteAction()
	{
		$valid=$this->validateUser();
		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		$folderid=$this->getParam(1);$idstring=$this->getParam(2);$page=$this->getParam(3);
//echo $page;exit;

		if($idstring=="")
		{
			$p=base64_encode(304);
			header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
			exit(0);
		}
require("script.inc.php");
if($restricted_mode=='true')
		{

			$p=base64_encode(340);
				header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
				exit(0);
		}
	  $str=$this->delete($folderid,$idstring,$page,'');

	}
	function makespam($folderid,$idstring,$page,$mailpage)  //$mailpage 1 for shortmail 2 for detailmail
	{
		$valid=$this->validateUser();
		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		else
		{

			$userid=$this->getId();
			$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
			$len=strlen($idstring);
			if($idstring[$len-1]==",")
			$ids=substr($idstring,0,-1);
			else
			$ids=$idstring;
			$idz=explode(",",$ids);
			$number=count($idz);
			if($folderid==1)
			{

				$db=new NesoteDALController();
				$db->select("nesote_email_inbox_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();//echo $db->getQuery();exit;
				$groups="";
				$c=0;
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);
					$d="";
					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);
						//					echo $ides;exit;
						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==1)
						$db->select("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->select("nesote_email_draft_$tablenumber");
						else if($folder[$a]==3)
						$db->select("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->select("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->select("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->select("nesote_email_customfolder_mapping_$tablenumber");
						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						$rw=$db->fetchRow($rs);
						$d.=$a.",";
						$db1=new NesoteDALController();
						$db1->insert("nesote_email_spam_$tablenumber");
						$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
						$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$folder[$a]));
						$db1->query();
						//$maild=$db1->lastInsert();
						$maild=$db1->lastInsertid("nesote_email_spam_$tablenumber");
						$body=$rw[7];
						$body=str_replace("attachments/".$folder[$a]."/".$tablenumber."/".$mailid[$a],"attachments/4/".$tablenumber."/".$maild,$body);
						$db1->update("nesote_email_spam_$tablenumber");
						$db1->set("body=?",array($body));
						$db1->where("id=?",$maild);
						$rs1=$db1->query();
						$mailids.=$maild.",";
						$this->saveLogs("Marked as Spam",$username." has marked a mail as spam");
						$this->removewhitelist($rw[2],$rw[1]);
						$this->setblacklist($rw[2],$rw[1]);


						$db2=new NesoteDALController();
						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->update("nesote_email_attachments_$tablenumber");
							$db->set("mailid=?,folderid=?",array($maild,4));
							$db->where("id=?",$row2[0]);
							$res=$db->query();
							if((is_dir("../attachments/4/".$tablenumber."/".$maild))!=TRUE)
							{
								
								if((is_dir("../attachments/4/".$tablenumber))!=TRUE)
							    {
							    	if((is_dir("../attachments/4/"))!=TRUE)
							        {
							        mkdir("../attachments/4/",0777);		
							        }
							        mkdir("../attachments/4/".$tablenumber,0777);
							    }
								mkdir("../attachments/4/".$tablenumber."/".$maild,0777);

							}
							copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/4/".$tablenumber."/".$maild."/".$row2[2]);
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}


						$e=explode(",",$d);

						if($e[0]==$a)
						$references=$this->new_reference($row[0],$folder[$a],4,$mailid[$a],$maild);
						else
						$references=$this->new_reference($references,$folder[$a],4,$mailid[$a],$maild);
						$c++;
						if($folder[$a]==1)
						$db->delete("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->delete("nesote_email_draft_$tablenumber");
						else if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->delete("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->delete("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->delete("nesote_email_customfolder_mapping_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
					}
				}
				$ides=explode(",",$mailids);
				$num=count($ides);

				for($b=0;$b<$num;$b++)
				{
					$db1->update("nesote_email_spam_$tablenumber");
					$db1->set("mail_references=?",$references);
					$db1->where("id=?",array($ides[$b]));
					$db1->query();
				}

				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_inbox_$tablenumber");
				$db->fields("id");
				$db->where("userid=? and id<?",array($userid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{
					if($number==1)
					{
						$p=base64_encode(191);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("192@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
				else
				{

					$db->select("nesote_email_inbox_$tablenumber");
					$db->fields("id");
					$db->where("userid=? and id>?",array($userid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);

					if($number==1)
					{
						$p=base64_encode(191);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("192@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}

				//return $url.",".$folderid.",".$row1[0];
				//exit;





			}
			else if($folderid==5)
			{
				$db=new NesoteDALController();
				$db->select("nesote_email_trash_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				$groups="";
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);
					$d="";
					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);
						//					echo $ides;exit;
						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==1)
						$db->select("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->select("nesote_email_draft_$tablenumber");
						else if($folder[$a]==3)
						$db->select("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->select("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->select("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->select("nesote_email_customfolder_mapping_$tablenumber");
						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						$rw=$db->fetchRow($rs);
						$d.=$a.",";
						$db1=new NesoteDALController();
						$db1->insert("nesote_email_spam_$tablenumber");
						$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
						$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$rw[15]));
						$db1->query();
					//	$maild=$db1->lastInsert();
						$maild=$db1->lastInsertid("nesote_email_spam_$tablenumber");
						$body=$rw[7];
						$body=str_replace("attachments/".$folder[$a]."/".$tablenumber."/".$mailid[$a],"attachments/4/".$tablenumber."/".$maild,$body);
						$db1->update("nesote_email_spam_$tablenumber");
						$db1->set("body=?",array($body));
						$db1->where("id=?",$maild);
						$rs1=$db1->query();
						$mailids.=$maild.",";
						$this->saveLogs("Marked as Spam",$username." has marked a mail as spam");
						$this->removewhitelist($rw[2],$rw[1]);
						$this->setblacklist($rw[2],$rw[1]);


						$db2=new NesoteDALController();
						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->update("nesote_email_attachments_$tablenumber");
							$db->set("mailid=?,folderid=?",array($maild,4));
							$db->where("id=?",$row2[0]);
							$res=$db->query();
							
						   if((is_dir("../attachments/4/".$tablenumber."/".$maild))!=TRUE)
							{
								
								if((is_dir("../attachments/4/".$tablenumber))!=TRUE)
							    {
							    	if((is_dir("../attachments/4/"))!=TRUE)
							        {
							        mkdir("../attachments/4/",0777);		
							        }
							        mkdir("../attachments/4/".$tablenumber,0777);
							    }
								mkdir("../attachments/4/".$tablenumber."/".$maild,0777);

							}
							copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/4/".$tablenumber."/".$maild."/".$row2[2]);
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}



						$e=explode(",",$d);
						if($e[0]==$a)

						$references=$this->new_reference($row[0],$folder[$a],4,$mailid[$a],$maild);
						else

						$references=$this->new_reference($references,$folder[$a],4,$mailid[$a],$maild);
						if($folder[$a]==1)
						$db->delete("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->delete("nesote_email_draft_$tablenumber");
						else if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->delete("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->delete("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->delete("nesote_email_customfolder_mapping_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
					}
				}
				$ides=explode(",",$mailids);
				$num=count($ides);
				for($b=0;$b<$num;$b++)
				{
					$db1->update("nesote_email_spam_$tablenumber");
					$db1->set("mail_references=?",$references);
					$db1->where("id=?",array($ides[$b]));
					$db1->query();
				}

				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_trash_$tablenumber");
				$db->fields("id");
				$db->where("userid=? and id<?",array($userid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{

					if($number==1)
					{
						$p=base64_encode(191);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("192@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}



				}
				else
				{

					$db->select("nesote_email_trash_$tablenumber");
					$db->fields("id");
					$db->where("userid=? and id>?",array($userid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(191);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("192@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}

				//return $url.",".$folderid.",".$row1[0];
				//exit;

			}
			elseif($folderid>=10)
			{
				$db=new NesoteDALController();
				$db->select("nesote_email_customfolder_mapping_$tablenumber");
				$db->fields("mail_references");
				$db->where("id in($ids)");
				$ros=$db->query();
				$groups="";
				while($row=$db->fetchRow($ros))
				{
					$groups=$this->getgroups($row[0]);
					$d="";
					$combination=explode(",",$groups);
					for($a=0;$a<count($combination);$a++)
					{
						$combo[$a]=explode(":",$combination[$a]);
						//					echo $ides;exit;
						$folder[$a]=$combo[$a][0];
						$mailid[$a]=$combo[$a][1];
						if($folder[$a]==1)
						$db->select("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->select("nesote_email_draft_$tablenumber");
						else if($folder[$a]==3)
						$db->select("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->select("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->select("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->select("nesote_email_customfolder_mapping_$tablenumber");
						$db->fields("*");
						$db->where("id=?",array($mailid[$a]));
						$rs=$db->query();
						$rw=$db->fetchRow($rs);
						$d.=$a.",";
						$db1=new NesoteDALController();
						$db1->insert("nesote_email_spam_$tablenumber");
						$db1->fields("userid,from_list,to_list,cc,bcc,subject,body,time,status,readflag,starflag,memorysize,message_id,backreference");
						$db1->values(array($userid,$rw[2],$rw[3],$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11],$rw[12],$rw[13],$folder[$a]));
						$db1->query();
						//$maild=$db1->lastInsert();
						$maild=$db1->lastInsertid("nesote_email_spam_$tablenumber");
						$body=$rw[7];
						$body=str_replace("attachments/".$folder[$a]."/".$tablenumber."/".$mailid[$a],"attachments/4/".$tablenumber."/".$maild,$body);
						$db1->update("nesote_email_spam_$tablenumber");
						$db1->set("body=?",array($body));
						$db1->where("id=?",$maild);
						$rs1=$db1->query();
						$mailids.=$maild.",";
						$this->saveLogs("Marked as Spam",$username." has marked a mail as spam");
						$this->removewhitelist($rw[2],$rw[1]);
						$this->setblacklist($rw[2],$rw[1]);



						$db2=new NesoteDALController();
						$db2->select("nesote_email_attachments_$tablenumber");
						$db2->fields("*");
						$db2->where("mailid=?and folderid=?",array($mailid[$a],$folder[$a]));
						$rs2=$db2->query();
						while($row2=$db2->fetchRow($rs2))
						{

							$db->update("nesote_email_attachments_$tablenumber");
							$db->set("mailid=?,folderid=?",array($maild,4));
							$db->where("id=?",$row2[0]);
							$res=$db->query();
						    if((is_dir("../attachments/4/".$tablenumber."/".$maild))!=TRUE)
							{
								
								if((is_dir("../attachments/4/".$tablenumber))!=TRUE)
							    {
							    	if((is_dir("../attachments/4/"))!=TRUE)
							        {
							        mkdir("../attachments/4/",0777);		
							        }
							        mkdir("../attachments/4/".$tablenumber,0777);
							    }
								mkdir("../attachments/4/".$tablenumber."/".$maild,0777);

							}
							copy("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2],"../attachments/4/".$tablenumber."/".$maild."/".$row2[2]);
							unlink("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]."/".$row2[2]);
							rmdir("../attachments/".$folder[$a]."/".$tablenumber."/".$rw[0]);
						}



						$e=explode(",",$d);
						if($e[0]==$a)
						$references=$this->new_reference($row[0],$folder[$a],4,$mailid[$a],$maild);
						else
						$references=$this->new_reference($references,$folder[$a],4,$mailid[$a],$maild);
						if($folder[$a]==1)
						$db->delete("nesote_email_inbox_$tablenumber");
						else if($folder[$a]==2)
						$db->delete("nesote_email_draft_$tablenumber");
						else if($folder[$a]==3)
						$db->delete("nesote_email_sent_$tablenumber");
						else if($folder[$a]==4)
						$db->delete("nesote_email_spam_$tablenumber");
						else if($folder[$a]==5)
						$db->delete("nesote_email_trash_$tablenumber");
						else if($folder[$a]>=10)
						$db->delete("nesote_email_customfolder_mapping_$tablenumber");
						$db->where("id=?",array($mailid[$a]));
						$db->query();
					}
					$ides=explode(",",$mailids);
					$num=count($ides);
					for($b=0;$b<$num;$b++)
					{
						$db1->update("nesote_email_spam_$tablenumber");
						$db1->set("mail_references=?",$references);
						$db1->where("id=?",array($ides[$b]));
						$db1->query();
					}
				}
				$array=explode(",",$ids);
				$least=$array[0];
				$array_count=count($array);

				for($i=0;$i<$array_count;$i++)
				{
					if($least>$array[$i])
					{
						$least=$array[$i];
					}
				}
				$db->select("nesote_email_customfolder_mapping_$tablenumber");
				$db->fields("id");
				$db->where("folderid=? and id<?",array($folderid,$least));
				$db->order("id desc");
				$db->limit(0,1);

				$res=$db->query();
				$row1=$db->fetchRow($res);
				$no=$db->numRows($res);
				if ($no!=0)
				{
					if($number==1)
					{
						$p=base64_encode(191);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("192@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}
				else
				{

					$db->select("nesote_email_customfolder_mapping_$tablenumber");
					$db->fields("id");
					$db->where("folderid=? and id>?",array($folderid,$least));
					$db->limit(0,1);

					$res=$db->query();
					$row1=$db->fetchRow($res);
					if($number==1)
					{
						$p=base64_encode(191);
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);
					}
					else
					{
						$p=base64_encode("192@@$number");
						header("Location:".$this->url("mail/mailbox/$folderid/$page/$p"));
						exit(0);

					}
				}

				//return $url.",".$folderid.",".$row1[0];
				//exit;




			}

		}
	}

	function getgroups($references)
	{
		preg_match_all('/<item>(.+?)<\/item>/i',$references,$reply);
		//print_r($reply);
		$no=count($reply[1]);
		$idstring="";
		for($i=0;$i<$no;$i++)
		{
			preg_match('/<mailid>(.+?)<\/mailid>/i',$reply[1][$i],$mail[$i]);
			preg_match('/<folderid>(.+?)<\/folderid>/i',$reply[1][$i],$folder[$i]);
			$db=new NesoteDALController();
			$idstring.=$folder[$i][1].":".$mail[$i][1].",";
		}
		$idstring=substr($idstring,0,-1);
		return $idstring;
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
	function removeblacklist($mailid,$uid)
	{
		$db=new NesoteDALController();
		$db->select("nesote_email_blacklist_mail");
		$db->fields("id");
		$db->where("mailid=? and clientid=?",array($mailid,$uid));
		$result=$db->query();
		$no=$db->numRows($result);
		$row=$db->fetchRow($result);
		if($no!=0)
		{
			$db->delete("nesote_email_blacklist_mail");
			$db->where("id=?",$row[0]);
			$result=$db->query();
		}
		return ;
	}
	function removewhitelist($mailid,$uid)
	{
		$db=new NesoteDALController();
		$db->select("nesote_email_whitelist_mail");
		$db->fields("id");
		$db->where("mailid=? and clientid=?",array($mailid,$uid));
		$result=$db->query();
		$no=$db->numRows($result);
		$row=$db->fetchRow($result);
		if($no!=0)
		{
			$db->delete("nesote_email_whitelist_mail");
			$db->where("id=?",$row[0]);
			$result=$db->query();
		}
		return ;
	}
	function setblacklist($mailid,$uid)
	{
		$db=new NesoteDALController();
		$db->select("nesote_email_blacklist_mail");
		$db->fields("id");
		$db->where("mailid=? and clientid=?",array($mailid,$uid));
		$result=$db->query();
		$no=$db->numRows($result);
		if($no==0)
		{
			$db->insert("nesote_email_blacklist_mail");
			$db->fields("mailid,clientid");
			$db->values(array($mailid,$uid));
			$res=$db->query();
		}
		return ;
	}
	function new_reference($references,$folder_old,$folder_new,$old_mailid,$mailid)
	{

		preg_match_all('/<item>(.+?)<\/item>/i',$references,$reply);
		$new_1="";
		$no=count($reply[1]);
		for($i=0;$i<$no;$i++)
		{

			preg_match('/<folderid>(.+?)<\/folderid>/i',$reply[1][$i],$folder[$i]);
			preg_match('/<mailid>(.+?)<\/mailid>/i',$reply[1][$i],$mail[$i]);

			if(($folder[$i][1]==$folder_old) && ($mail[$i][1]==$old_mailid))
			{
				$new_1=str_replace("<mailid>".$old_mailid."</mailid><folderid>".$folder_old."</folderid>","<mailid>".$mailid."</mailid><folderid>".$folder_new."</folderid>",$references);
				//$new_1=str_replace("<mailid>".$old_mailid."</mailid>","<mailid>".$mailid."</mailid>",$new);
			}

		}
		//echo $new_1;
		if($new_1=="")
		{
			$new_1=$references;
		}

		return $new_1;
	}
function getunreadcountnew($userid,$folder)
	{

$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
		$db=new NesoteDALController();

		if($folder==1)
		{
			$db->select("nesote_email_inbox_$tablenumber");
			$db->fields("distinct mail_references");
			$db->where("userid=? and readflag=?",array($userid,0));
			$res=$db->query();
			$no=$db->numRows($res);
			if($no!=0)
			{
$str="(".$no.")";
				return $str;
			}
			else
			{
				return "";
			}
		}

		if($folder==2)
		{
			$db->select("nesote_email_draft_$tablenumber");
			$db->fields("distinct mail_references");
			$db->where("userid=? and just_insert=? ",array($userid,0));
			$res=$db->query();
			$no=$db->numRows($res);

			if($no!=0)
			{

$str="(".$no.")";
				return $str;
			}
			else
			{
				return "";
			}
		}
		if($folder==4)
		{
			$db->select("nesote_email_spam_$tablenumber");
			$db->fields("distinct mail_references");
			$db->where("userid=? and readflag=?",array($userid,0));
			$res=$db->query();
			$no=$db->numRows($res);
			if($no!=0)
			{
$str="(".$no.")";
				return $str;
			}
			else
			{
				return "";
			}
		}

		if($folder>=10)
		{
			$db->select("nesote_email_customfolder_mapping_$tablenumber");
			$db->fields("distinct mail_references");
			$db->where("folderid=? and readflag=?",array($folder,0));
			$res1=$db->query();
			$no=$db->numRows($res1);
			if($no!=0)
			{
				$str="(".$no.")";
				return $str;
			}
			else
			{
				return "";
			}
		}

	}
	function getunreadcount($userid,$folder)
	{

$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
		$db=new NesoteDALController();

		if($folder==1)
		{
			$db->select("nesote_email_inbox_$tablenumber");
			$db->fields("distinct mail_references");
			$db->where("userid=? and readflag=?",array($userid,0));
			$res=$db->query();
			$no=$db->numRows($res);
			if($no!=0)
			{
$str="<div class=\"countShow\"><div class=\"in\">".$no."</div></div>";
				return $str;
			}
			else
			{
				return "";
			}
		}

		if($folder==2)
		{
			$db->select("nesote_email_draft_$tablenumber");
			$db->fields("distinct mail_references");
			$db->where("userid=? and just_insert=? ",array($userid,0));
			$res=$db->query();
			$no=$db->numRows($res);

			if($no!=0)
			{

				
$str="<div class=\"countShow\"><div class=\"in\">".$no."</div></div>";
				return $str;
			}
			else
			{
				return "";
			}
		}
		if($folder==4)
		{
			$db->select("nesote_email_spam_$tablenumber");
			$db->fields("distinct mail_references");
			$db->where("userid=? and readflag=?",array($userid,0));
			$res=$db->query();
			$no=$db->numRows($res);
			if($no!=0)
			{
				
$str="<div class=\"countShow\"><div class=\"in\">".$no."</div></div>";
				return $str;
			}
			else
			{
				return "";
			}
		}

		if($folder>=10)
		{
			$db->select("nesote_email_customfolder_mapping_$tablenumber");
			$db->fields("distinct mail_references");
			$db->where("folderid=? and readflag=?",array($folder,0));
			$res1=$db->query();
			$no=$db->numRows($res1);
			if($no!=0)
			{
				
$str="<div class=\"countShow\"><div class=\"in\">".$no."</div></div>";
				return $str;
			}
			else
			{
				return "";
			}
		}

	}
	function mailfooter1Action()
	{
$link = $_SERVER['REQUEST_URI'];
    $link_array = explode('/',$link);
    //print_r($link_array);exit;
//echo $link_array[0];exit;
if($link_array[6]=='detailmail' || $link_array[7]=='newmail' || $link_array[6]=='getattachmentdetails' || $link_array[6]=='replylink' || $link_array[6]=='contacts' || $link_array[6]=='home' || $link_array[3]=='home' || $link_array[3]=='detailmail' || $link_array[4]=='newmail' || $link_array[3]=='getattachmentdetails' || $link_array[3]=='replylink' || $link_array[3]=='contacts')
{
$dmail=0;
$this->setValue("dmail",$dmail);
}
else
{
$dmail=1;
$this->setValue("dmail",$dmail);
}
//echo "nn";exit;

		$valid=$this->validateUser();

		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

			$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
		$db=new NesoteDALController();
		$fid=$this->getParam(1);
		if(!isset($fid))
		$fid=1;
		$this->setValue("fid",$fid);

		$whichpage=$this->getParam(2);
		$this->setValue("whichpage",$whichpage);

		$page=$this->getParam(3);
		if(isset($page))
		$this->setValue("page",$page);
		else
		$this->setValue("page",1);

		$rlink=$this->getParam(4);
		if(isset($rlink))
		$this->setValue("rlink",$rlink);
		else
		$this->setValue("rlink","");

		$crntfold=$this->getParam(5);
		$this->setValue("crntfold",$crntfold);
		$crntid=$this->getParam(6);
		$this->setValue("crntid",$crntid);


		$id=$this->getId();
		$this->setValue("uid",$id);
		$db->select("nesote_email_customfolder");
		$db->fields("id,name");
		$db->where("userid=?",array($id));
		$res1=$db->query();
		$i=0;
		while($rw=$db->fetchRow($res1))
		{
			$db1=new NesoteDALController();
			$db1->select("nesote_email_customfolder_mapping_$tablenumber");
			$db1->fields("distinct mail_references");
			$db1->where("folderid=?",array($rw[0]));
			$db1->order("time desc");
			$result1=$db1->query();
			$count=$db1->numRows($result1);


			$db1->select("nesote_email_customfolder_mapping_$tablenumber");
			$db1->fields("distinct mail_references");
			$db1->where("folderid=? and readflag=?",array($rw[0],0));
			$db1->order("time desc");
			$result1=$db1->query();
			$count1=$db1->numRows($result1);

			$customFolder[$i][0]=$rw[0];
			$customFolder[$i][1]=$rw[1];
			$customFolder[$i][2]=$count;
			$customFolder[$i][3]=$count11;
			$countCookie="custom".$rw[0];
			setcookie($countCookie,$count,"0","/");
			$i++;
		}
		$this->setValue("mpcount",$i);
		$this->setLoopValue("customfolders",$customFolder);

		$memorymsg=$this->getmessage(351);
		$year=date("Y",time());
		$msg1=str_replace('{year}',$year,$memorymsg);
		$this->setValue("footer",$msg1);

		$userid=$this->getuserid($username);
			$db->select("nesote_email_inbox_$tablenumber");
			$db->fields("distinct mail_references");
			$db->where("userid=? and readflag=?",array($userid,0));
			$res=$db->query();
			$noread=$db->numRows($res);
$this->setValue("unreadcount",$noread);


	}
	function mailfooter2Action()
	{
		$valid=$this->validateUser();

		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

			$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
		$db=new NesoteDALController();
		$fid=$this->getParam(1);
		if(!isset($fid))
		$fid=1;
		$this->setValue("fid",$fid);

		$whichpage=$this->getParam(2);
		$this->setValue("whichpage",$whichpage);
		$page=$this->getParam(3);
		if(isset($page))
		$this->setValue("page",$page);
		else
		$this->setValue("page",1);


		$rlink=$this->getParam(4);
		if(isset($rlink))
		$this->setValue("rlink",$rlink);
		else
		$this->setValue("rlink","");


		$crntfold=$this->getParam(5);
		$this->setValue("crntfold",$crntfold);
		$crntid=$this->getParam(6);
		$this->setValue("crntid",$crntid);


		$id=$this->getId();
		$this->setValue("uid",$id);
		$db->select("nesote_email_customfolder");
		$db->fields("id,name");
		$db->where("userid=?",array($id));
		$res1=$db->query();
		$i=0;
		while($rw=$db->fetchRow($res1))
		{
			$db1=new NesoteDALController();
			$db1->select("nesote_email_customfolder_mapping_$tablenumber");
			$db1->fields("distinct mail_references");
			$db1->where("folderid=?",array($rw[0]));
			$db1->order("time desc");
			$result1=$db1->query();
			$count=$db1->numRows($result1);


			$db1->select("nesote_email_customfolder_mapping_$tablenumber");
			$db1->fields("distinct mail_references");
			$db1->where("folderid=? and readflag=?",array($rw[0],0));
			$db1->order("time desc");
			$result1=$db1->query();
			$count1=$db1->numRows($result1);

			$customFolder[$i][0]=$rw[0];
			$customFolder[$i][1]=$rw[1];
			$customFolder[$i][2]=$count;
			$customFolder[$i][3]=$count11;
			$countCookie="custom".$rw[0];
			setcookie($countCookie,$count,"0","/");
			$i++;
		}
		$this->setValue("mpcount",$i);
		$this->setLoopValue("customfolders",$customFolder);

		$memorymsg=$this->getmessage(351);
		$year=date("Y",time());
		$msg1=str_replace('{year}',$year,$memorymsg);
		$this->setValue("footer",$msg1);

	}



	function livesearchAction()
	{

		//if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
		$string=$this->getParam(1);
		$loop=$this->getParam(2);
		$target="_$loop";
		$string=htmlentities($string);
		$magic=get_magic_quotes_gpc();
		if($magic==1)
		{

			$string=stripslashes($string);
		}
		//$x=$string;
		$id=$this->getId();
		//$xmlDoc = new DOMDocument();
		//$xmlDoc->load("ajax/links.xml");

		//$x=$xmlDoc->getElementsByTagName('link');

		//get the q parameter from URL
		$q=$_GET["q"];


		$count=strlen($q);

		$db= new NesoteDALController();
		$db->select("nesote_email_contacts");
		$db->fields("distinct mailid,firstname,lastname");
		$db->where("mailid like '%$q%' and addedby=? ",array($id));
		$res=$db->query();
		$hint="";
		$j=0;
		$result=array();
		while($row=$db->fetchRow($res))
		{



			$result[$j]=$row[0];

			$value=$string." ";

			$mail="";
			if($row[1]!="" || $row[2]!="")
			{

				$value.="&quot;".$row[1]." ".$row[2]."&quot;";
				$mail="&quot;".$row[1]." ".$row[2]."&quot;";
			}

			$value.="&lt;".$row[0]."&gt;";
			//$value.=htmlspecialchars_decode($l);
			//	$setvalue=htmlspecialchars_decode($value);
			$mail.="&lt;".$row[0]."&gt;";
			$loop1=$loop."_".$j;
			$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #eeeeee\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearch_a_$loop1\"  onclick=\"javascript:setvaluefortb('$value','$target','$loop')\" style='color:#666666;' >$mail<input type='hidden' id=\"livesearch_h_$loop1\" value=\"&quot;$row[1]  $row[2]&quot;&lt;$row[0]&gt;\"><input type='hidden' id=\"result_$loop1\" value=\"$value\"></div></td></tr></table>";

			//$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearch_a_$i\"  onclick=\"javascript:setvaluefortb('$string$row[0]')\" style='color:#666666;' >&nbsp;".$row[0]."<input type='hidden' id=\"livesearch_a_$i\" value=\"$row[0]\"></div></td></tr></table>";
			$j++;
		}


		$db->select("nesote_email_contactgroup");
		$db->fields("name,id");
		$db->where("name like '%$q%' and userid=?  ",array($id));
		$res=$db->query();

		$db1= new NesoteDALController();
		while($row =$db->fetchRow($res))
		{
			$result[$j]=$row[0];
			$groupid=$row[1];

			//$x=$string;

			$db1->select("nesote_email_contacts");
			$db1->fields("distinct mailid,firstname,lastname");
			$db1->where(" contactgroup =? and addedby=?  ",array($groupid,$id));
			$res1=$db1->query();
			$t=$db1->getQuery();
			$k=0;
			$loop1=$loop."_".$j;
			//$value1="$string&nbsp;";
			while($row1 =$db1->fetchRow($res1))
			{

				if(substr($x,0,-1)!=",")
				{
					if($k!=0)
					$x.=",";
				}

				if($row1[1]!="" || $row1[2]!="")
				{
					$value1="&quot;".$row1[1]." ".$row1[2]."&quot;";

				}
				else
				$value1="";


				$mail1.="$row[0]";
				$x.=$value1."&lt;".$row1[0]."&gt;";//

				//	$y="&quot;$row1[1]&nbsp;$row1[2]&quot;&lt;$row1[0]&gt".",";
				$k++;
				//$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #eeeeee\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearch_a_$i\"  onclick=\"javascript:setvaluefortb('$string&quot;$row1[1]&nbsp;$row1[2]&quot;&lt;$row1[0]&gt;','$loop')\" style='color:#666666;' >&nbsp;".$row[0]."(group)<input type='hidden' id=\"livesearch_a_$i\" value=\"$row[0]\"></div></td></tr></table>";

			}

			$y=$string." ".$x;

			$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #eeeeee\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearch_a_$loop1\"  onclick=\"javascript:setvaluefortb('$y','$target','$loop')\" style='color:#666666;' > ".$row[0]."(".$this->getmessage(49)."))<input type='hidden' id=\"livesearch_h_$loop1\" value=\"$row[0]\"><input type='hidden' id=\"result_$loop1\" value=\"$x\"></div></td></tr></table>";

			$j++;
		}



		$db->select("nesote_email_settings");
		$db->fields("value");
		$db->where("name='globaladdress_book'");
		$result=$db->query();//echo $select->getQuery();
		$res5=$db->fetchRow($result);
		$addressbook=$res5[0];

		$db->select("nesote_email_settings");
		$db->fields("value");
		$db->where("name='emailextension'");
		$result4=$db->query();
		$row4=$db->fetchRow($result4);
		if(stristr(trim($row4[0]),"@")!="")
		$emailextension=$row4[0];
		else
		$emailextension="@".$row4[0];

		if($addressbook==1)
		{


			$db->select("nesote_inoutscripts_users");
			//$db->fields("username,firstname,lastname");
            $db->fields("username,name");
			$db->where("username like '%$q%' and status=? ",1);
			$res2=$db->query();

			while($row2 =$db->fetchRow($res2))
			{
				$usern=$row2[0].$emailextension;


				$db1->select("nesote_email_contacts");
				$db1->fields("mailid");
				$db1->where(" contactgroup =? and addedby=? and mailid=?   ",array($groupid,$id,$usern));
				$res3=$db1->query();
				$mNo=$db1->numRows($res3);
				if($mNo==0)
				{

					$loop1=$loop."_".$j;

					$value2="$string ";

					if($row2[1]!="")
					{
						$value2.="&quot;".$row2[1]."&quot;";
						$mail2="&quot;".$row2[1]."&quot;";

					}
					$value2.="&lt;".$row2[0].$emailextension."&gt;";
					$mail2.="&lt;".$row2[0].$emailextension."&gt;";

					$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #eeeeee\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearch_a_$loop1\"  onclick=\"javascript:setvaluefortb('$value2','$target','$loop')\" style='color:#666666;' >$mail2<input type='hidden' id=\"livesearch_h_$loop1\" value=\"&quot;$row2[1]&quot;&lt;".$row2[0].$emailextension."&gt;\"><input type='hidden' id=\"result_$loop1\" value=\"$value2\"></div></td></tr></table>";

					//$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearch_a_$i\"  onclick=\"javascript:setvaluefortb('$string$row[0]')\" style='color:#666666;' >&nbsp;".$row[0]."<input type='hidden' id=\"livesearch_a_$i\" value=\"$row[0]\"></div></td></tr></table>";
					$j++;
				}
			}
		}
		if ($hint == "")
		{
			$response="<div id=nomatch_$loop style='color:#999999;background-color: #eeeeee'>No match for '$q'</div>";
		}
		else
		{
			$response=$hint;
		}
		$v=$j."_".$loop;
		$response.="<input type='hidden' id=\"total_$loop\" value=\"$j\">";
		//output the response
		echo $loop."}".$response;
		exit(0);
	}


	function livesearchbccAction()
	{

		//if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
		$string=$this->getParam(1);
		$loop=$this->getParam(2);
		$target="bcc_$loop";
		$string=htmlentities($string);
		$magic=get_magic_quotes_gpc();
		if($magic==1)
		{

			$string=stripslashes($string);
		}
		//$x=$string;
		$id=$this->getId();
		//$xmlDoc = new DOMDocument();
		//$xmlDoc->load("ajax/links.xml");

		//$x=$xmlDoc->getElementsByTagName('link');

		//get the q parameter from URL
		$q=$_GET["q"];


		$count=strlen($q);

		$db= new NesoteDALController();
		$db->select("nesote_email_contacts");
		$db->fields("distinct mailid,firstname,lastname");
		$db->where("mailid like '%$q%' and addedby=? ",array($id));
		$res=$db->query();
		$hint="";
		$j=0;
		$result=array();
		while($row=$db->fetchRow($res))
		{



			$result[$j]=$row[0];
			$mail="";
			$value=$string." ";

			if($row[1]!="" || $row[2]!="")
			{
				$value.="&quot;".$row[1]." ".$row[2]."&quot;";
				$mail="&quot;".$row[1]." ".$row[2]."&quot;";
			}
			$value.="&lt;$row[0]&gt;";
			$mail.="&lt;$row[0]&gt;";
			$loop1=$loop."_".$j;
			$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #eeeeee\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearchbcc_a_$loop1\"  onclick=\"javascript:setvaluefortb2('$value','$target','$loop')\" style='color:#666666;' >$mail<input type='hidden' id=\"livesearchbcc_h_$loop1\" value=\"&quot;$row[1] $row[2]&quot;&lt;$row[0]&gt;\"><input type='hidden' id=\"resultbcc_$loop1\" value=\"$value\"></div></td></tr></table>";

			//$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearch_a_$i\"  onclick=\"javascript:setvaluefortb('$string$row[0]')\" style='color:#666666;' > ".$row[0]."<input type='hidden' id=\"livesearch_a_$i\" value=\"$row[0]\"></div></td></tr></table>";
			$j++;
		}

		$db= new NesoteDALController();
		$db->select("nesote_email_contactgroup");
		$db->fields("name,id");
		$db->where("name like '%$q%' and userid=?  ",array($id));
		$res=$db->query();


		while($row =$db->fetchRow($res))
		{
			$result[$j]=$row[0];
			$groupid=$row[1];

			//$x=$string;
			$db1= new NesoteDALController();
			$db1->select("nesote_email_contacts");
			$db1->fields("distinct mailid,firstname,lastname");
			$db1->where(" contactgroup =? and addedby=?  ",array($groupid,$id));
			$res1=$db1->query();
			$t=$db1->getQuery();
			$k=0;
			$loop1=$loop."_".$j;
			while($row1 =$db1->fetchRow($res1))
			{

				if(substr($x,0,-1)!=",")
				{
					if($k!=0)
					$x.=",";
				}
				//$value1="$string&nbsp;";
				if($row1[1]!="" || $row1[2]!="")
				{
					$value1="&quot;".$row1[1]." ".$row1[2]."&quot;";

				}
				else
				$value1="";


				$mail1.="$row[0]";
				$x.="$value1&lt;$row1[0]&gt;";//

				//	$y="&quot;$row1[1]&nbsp;$row1[2]&quot;&lt;$row1[0]&gt".",";
				$k++;
				//$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #eeeeee\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearch_a_$i\"  onclick=\"javascript:setvaluefortb('$string&quot;$row1[1]&nbsp;$row1[2]&quot;&lt;$row1[0]&gt;','$loop')\" style='color:#666666;' >&nbsp;".$row[0]."(group)<input type='hidden' id=\"livesearch_a_$i\" value=\"$row[0]\"></div></td></tr></table>";

			}
			$y="$string $x";
			$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #eeeeee\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearchbcc_a_$loop1\"  onclick=\"javascript:setvaluefortb2('$y','$target','$loop')\" style='color:#666666;' > ".$row[0]."(".$this->getmessage(49)."))<input type='hidden' id=\"livesearchbcc_h_$loop1\" value=\"$row[0]\"><input type='hidden' id=\"resultbcc_$loop1\" value=\"$x\"></div></td></tr></table>";

			$j++;
		}


		$select=new NesoteDALController();
		$select->select("nesote_email_settings");
		$select->fields("value");
		$select->where("name='globaladdress_book'");
		$result=$select->query();//echo $select->getQuery();
		$res5=$select->fetchRow($result);
		$addressbook=$res5[0];
		$db4=new NesoteDALController();
		$db4->select("nesote_email_settings");
		$db4->fields("value");
		$db4->where("name='emailextension'");
		$result4=$db4->query();
		$row4=$db4->fetchRow($result4);
		if(stristr(trim($row4[0]),"@")!="")
		$emailextension=$row4[0];
		else
		$emailextension="@".$row4[0];
		if($addressbook==1)
		{

			$db2= new NesoteDALController();
			$db2->select("nesote_inoutscripts_users");
			$db2->fields("username,name");
			$db2->where("username like '%$q%' and status=? ",1);
			$res2=$db2->query();
			while($row2 =$db2->fetchRow($res2))
			{
				$usern=$row2[0].$emailextension;

				$db3= new NesoteDALController();
				$db3->select("nesote_email_contacts");
				$db3->fields("mailid");
				$db3->where(" contactgroup =? and addedby=? and mailid=?   ",array($groupid,$id,$usern));
				$res3=$db3->query();
				$mNo=$db3->numRows($res3);
				if($mNo==0)
				{
					$loop1=$loop."_".$j;

					$value2=$string." ";
					if($row2[1]!="" || $row2[2]!="")
					{
						$value2.="&quot;".$row2[1]."&quot;";
						$mail2="&quot;".$row2[1]."&quot;";

					}
					$value2.="&lt;".$row2[0].$emailextension."&gt;";
					$mail2.="&lt;".$row2[0].$emailextension."&gt;";

					$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #eeeeee\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearchbcc_a_$loop1\"  onclick=\"javascript:setvaluefortb2('$value2','$target','$loop')\" style='color:#666666;' >$mail2<input type='hidden' id=\"livesearchbcc_h_$loop1\" value=\"&quot;$row2[1] &quot;&lt;".$row2[0].$emailextension."&gt;\"><input type='hidden' id=\"resultbcc_$loop1\" value=\"$value2\"></div></td></tr></table>";

					//$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearch_a_$i\"  onclick=\"javascript:setvaluefortb('$string$row[0]')\" style='color:#666666;' >&nbsp;".$row[0]."<input type='hidden' id=\"livesearch_a_$i\" value=\"$row[0]\"></div></td></tr></table>";
					$j++;
				}
			}
		}
		if ($hint == "")
		{
			$response="<div id=nomatch style='color:#999999'>".$this->getmessage(414)." '$q'</div>";
		}
		else
		{
			$response=$hint;
		}
		$v=$j."_".$loop;
		$response.="<input type='hidden' id=\"totalbcc_$loop\" value=\"$j\">";
		//output the response
		echo "$loop}$response";
		exit(0);
	}
	function livesearchccAction()
	{
		//if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
		$string=$this->getParam(1);
		$loop=$this->getParam(2);
		$target="cc_$loop";
		$string=htmlentities($string);
		$magic=get_magic_quotes_gpc();
		if($magic==1)
		{

			$string=stripslashes($string);
		}
		//$x=$string;
		$id=$this->getId();
		//$xmlDoc = new DOMDocument();
		//$xmlDoc->load("ajax/links.xml");

		//$x=$xmlDoc->getElementsByTagName('link');

		//get the q parameter from URL
		$q=$_GET["q"];


		$count=strlen($q);

		$db= new NesoteDALController();
		$db->select("nesote_email_contacts");
		$db->fields("distinct mailid,firstname,lastname");
		$db->where("mailid like '%$q%' and addedby=? ",array($id));
		$res=$db->query();
		$hint="";
		$j=0;
		$result=array();
		while($row=$db->fetchRow($res))
		{



			$result[$j]=$row[0];

			$value=$string." ";
			$mail="";
			if($row[1]!="" || $row[2]!="")
			{
				$value.="&quot;".$row[1]." ".$row[2]."&quot;";
				$mail="&quot;".$row[1]." ".$row[2]."&quot;";
			}
			$value.="&lt;$row[0]&gt;";
			$mail.="&lt;$row[0]&gt;";
			$loop1=$loop."_".$j;
			$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #eeeeee\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearchcc_a_$loop1\"  onclick=\"javascript:setvaluefortb1('$value','$target','$loop')\" style='color:#666666;' >$mail<input type='hidden' id=\"livesearchcc_h_$loop1\" value=\"&quot;$row[1] $row[2]&quot;&lt;$row[0]&gt;\"><input type='hidden' id=\"resultcc_$loop1\" value=\"$value\"></div></td></tr></table>";

			//$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearch_a_$i\"  onclick=\"javascript:setvaluefortb('$string$row[0]')\" style='color:#666666;' > ".$row[0]."<input type='hidden' id=\"livesearch_a_$i\" value=\"$row[0]\"></div></td></tr></table>";
			$j++;
		}

		$db= new NesoteDALController();
		$db->select("nesote_email_contactgroup");
		$db->fields("name,id");
		$db->where("name like '%$q%' and userid=?  ",array($id));
		$res=$db->query();


		while($row =$db->fetchRow($res))
		{
			$result[$j]=$row[0];
			$groupid=$row[1];

			//$x=$string;
			$db1= new NesoteDALController();
			$db1->select("nesote_email_contacts");
			$db1->fields("distinct mailid,firstname,lastname");
			$db1->where(" contactgroup =? and addedby=?  ",array($groupid,$id));
			$res1=$db1->query();
			$t=$db1->getQuery();
			$k=0;
			$loop1=$loop."_".$j;
			while($row1 =$db1->fetchRow($res1))
			{

				if(substr($x,0,-1)!=",")
				{
					if($k!=0)
					$x.=",";
				}
				//$value1="$string&nbsp;";
				if($row1[1]!="" || $row1[2]!="")
				{
					$value1="&quot;".$row1[1]." ".$row1[2]."&quot;";

				}
				else
				$value1="";


				$mail1.="$row[0]";
				$x.="$value1&lt;$row1[0]&gt;";//

				//	$y="&quot;$row1[1]&nbsp;$row1[2]&quot;&lt;$row1[0]&gt".",";
				$k++;
				//$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #eeeeee\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearch_a_$i\"  onclick=\"javascript:setvaluefortb('$string&quot;$row1[1]&nbsp;$row1[2]&quot;&lt;$row1[0]&gt;','$loop')\" style='color:#666666;' >&nbsp;".$row[0]."(group)<input type='hidden' id=\"livesearch_a_$i\" value=\"$row[0]\"></div></td></tr></table>";

			}
			$y="$string $x";
			$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #eeeeee\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearchcc_a_$loop1\"  onclick=\"javascript:setvaluefortb1('$y','$target','$loop')\" style='color:#666666;' > ".$row[0]."(".$this->getmessage(49)."))<input type='hidden' id=\"livesearchcc_h_$loop1\" value=\"$row[0]\"><input type='hidden' id=\"resultcc_$loop1\" value=\"$x\"></div></td></tr></table>";

			$j++;
		}


		$select=new NesoteDALController();
		$select->select("nesote_email_settings");
		$select->fields("value");
		$select->where("name='globaladdress_book'");
		$result=$select->query();//echo $select->getQuery();
		$res5=$select->fetchRow($result);
		$addressbook=$res5[0];
		$db4=new NesoteDALController();
		$db4->select("nesote_email_settings");
		$db4->fields("value");
		$db4->where("name='emailextension'");
		$result4=$db4->query();
		$row4=$db4->fetchRow($result4);
		if(stristr(trim($row4[0]),"@")!="")
		$emailextension=$row4[0];
		else
		$emailextension="@".$row4[0];
		if($addressbook==1)
		{

			$db2= new NesoteDALController();
			$db2->select("nesote_inoutscripts_users");
			$db2->fields("username,name");
			$db2->where("username like '%$q%' and status=? ",1);
			$res2=$db2->query();
			while($row2 =$db2->fetchRow($res2))
			{
				$usern=$row2[0].$emailextension;

				$db3= new NesoteDALController();
				$db3->select("nesote_email_contacts");
				$db3->fields("mailid");
				$db3->where(" contactgroup =? and addedby=? and mailid=?   ",array($groupid,$id,$usern));
				$res3=$db3->query();
				$mNo=$db3->numRows($res3);
				if($mNo==0)
				{
					$loop1=$loop."_".$j;

					$value2=$string." ";
					if($row2[1]!="" || $row2[2]!="")
					{
						$value2.="&quot;".$row2[1]."&quot;";
						$mail2="&quot;".$row2[1]."&quot;";

					}
					$value2.="&lt;".$row2[0].$emailextension."&gt;";
					$mail2.="&lt;".$row2[0].$emailextension."&gt;";

					$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #eeeeee\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearchcc_a_$loop1\"  onclick=\"javascript:setvaluefortb1('$value2','$target','$loop')\" style='color:#666666;' >$mail2<input type='hidden' id=\"livesearchcc_h_$loop1\" value=\"&quot;$row2[1] &quot;&lt;".$row2[0].$emailextension."&gt;\"><input type='hidden' id=\"resultcc_$loop1\" value=\"$value2\"></div></td></tr></table>";

					//$hint.="<table  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td  nowrap=\"nowrap\"><div  id=\"livesearch_a_$i\"  onclick=\"javascript:setvaluefortb('$string$row[0]')\" style='color:#666666;' > ".$row[0]."<input type='hidden' id=\"livesearch_a_$i\" value=\"$row[0]\"></div></td></tr></table>";
					$j++;
				}
			}
		}
		if ($hint == "")
		{
			$response="<div id=nomatch style='color:#999999'>".$this->getmessage(414)." '$q'</div>";
		}
		else
		{
			$response=$hint;
		}
		$v=$j."_".$loop;
		$response.="<input type='hidden' id=\"totalcc_$loop\" value=\"$j\">";
		//output the response
		echo "$loop}$response";
		exit(0);
	}

	function newmailAction()
	{

/*if($restricted_mode=='true')
		{

			header("Location:".$this->url("message/error/1023"));
			exit(0);
		}*/
		$valid=$this->validateUser();

		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

		$id=$this->getId();
		$username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);
		

		$send=$_POST['send'];
		$draft=$_POST['draft'];
		$discard=$_POST['discard'];
				$draftid=$_POST['draftid_0_0'];



		if(isset($send))
		$type=1;
		else
		if(isset($draft))
		$type=2;
		else
		if(isset($discard))
		$type=3;

		$fldr=$this->getParam(1);
		$pge=$this->getParam(2);
		$act=$this->getParam(3);
		$crntfold=$this->getParam(4);
		$crntid=$this->getParam(5);
//echo $type;exit;
/*require("script.inc.php");
if($restricted_mode=='true')
		{

			$p=base64_encode(340);
				header("Location:".$this->url("mail/replylink/newmail/$fldr/$pge/$act/$crntfold/$crntid/$p"));
				exit(0);
		}*/
require("script.inc.php");
if($restricted_mode=='true')
		{

			$p=base64_encode(340);
				header("Location:".$this->url("mail/replylink/newmail/$fldr/$pge/$act/$crntfold/$crntid/$p"));
				exit(0);
		}
		$db=new NesoteDALController();

		if($type==1)
		{
				
			$to=$_POST['to'];
			$to=str_replace("\"","",$to);
			$cc=$_POST['cc'];
			$cc=str_replace("\"","",$cc);
			$bcc=$_POST['bcc'];
			$bcc=str_replace("\"","",$bcc);
				
			if($to=="" && $cc=="" && $bcc=="")
			{
				$p=base64_encode(330);
				header("Location:".$this->url("mail/replylink/newmail/$fldr/$pge/$act/$crntfold/$crntid/$p"));
				exit(0);
			}
			$subject=htmlspecialchars($_POST['sub']);
			$body=$_POST['newbody'];
			if($subject=="" && $body=="")
			{
			$p=base64_encode(196);
				header("Location:".$this->url("mail/replylink/newmail/$fldr/$pge/$act/$crntfold/$crntid/$p"));
				exit(0);
			}
			preg_match('/<img(.+?)src=(.+?)>/i',$body,$cset1);
						if($cset1[2]!="")
			$body=str_replace("../attachments/","attachments/",$cset1[2]);
			
			$html=htmlspecialchars($body);
			$time=$this->getusertime();
				
			$db->select("nesote_email_usersettings");
			$db->fields("signature,signatureflag");
			$db->where("userid=?",$id);
			$res=$db->query();
			$row=$db->fetchRow($res);
			if($row[0]!="" && $row[1]==1)
			$html.="<br>".$row[0];
				$html=str_replace("\n","<br>",$html);
				
			$magic=get_magic_quotes_gpc();
			if($magic==1)
			{
				$html=stripslashes($html);
				$to=stripslashes($to);
				$cc=stripslashes($cc);
				$bcc=stripslashes($bcc);
			}
			$html=htmlspecialchars_decode($html);


			 $ss=$this->smtp($to,$cc,$bcc,$subject,$html,$id,"","",$draftid,2,"");
			
			if(stristr(trim($ss),"Invalid address")!="")
			{
				echo $ss;exit;
			}
			$this->saveLogs("Sent Mail",$username." has sent a mail");

			$p=base64_encode(173);
			if($act=="m")
			{
				header("Location:".$this->url("mail/mailbox/$fldr/$pge/$p"));
				exit(0);
			}
		    else if($act=="d")
			{
				header("Location:".$this->url("mail/detailmail/$fldr/$pge/$p"));
				exit(0);
			}
		   else if($act=="r")
			{
				header("Location:".$this->url("mail/replylink/$fldr/$pge/$act/$crntfold/$crntid/$p"));
				exit(0);
			}
		   else if($act=="dw")
			{
				header("Location:".$this->url("mail/getattachmentdetails/$fldr/$pge/$p"));
				exit(0);
			}
			
			}
			else if($type==2)
			{
				$fullid=$username.$this->getextension();
				$to=$_POST['to'];
				$cc=$_POST['cc'];
				$bcc=$_POST['bcc'];
				$subject=$_POST['sub'];
				$magic=get_magic_quotes_gpc();
				if($magic==1)
				{
					$to=stripslashes($to);
					$cc=stripslashes($cc);
					$bcc=stripslashes($bcc);
				}
				//$to=htmlentities($to);
				$to=str_replace("&Acirc;","",$to);
				$to=str_replace("&lt;","<",$to);
				$to=str_replace("&gt;",">",$to);
				//$cc=htmlentities($cc);
				$cc=str_replace("&Acirc;","",$cc);
				$cc=str_replace("&lt;","<",$cc);
				$cc=str_replace("&gt;",">",$cc);
				//$bcc=htmlentities($bcc);
				$bcc=str_replace("&Acirc;","",$bcc);
				$bcc=str_replace("&lt;","<",$bcc);
				$bcc=str_replace("&gt;",">",$bcc);
				$body=$_POST['newbody'];
				
				
			
				preg_match('/<img(.+?)src=(.+?)>/i',$body,$cset1);
						if($cset1[2]!="")
				$body=str_replace("../attachments/","attachments/",$cset1[2]);

				$db->select("nesote_email_usersettings");
				$db->fields("signature,signatureflag");
				$db->where("userid=?",$id);
				$res=$db->query();
				$row=$db->fetchRow($res);
				if($row[0]!="" && $row[1]==1)
				$body.="<br>".$row[0];
$body=str_replace("\n","<br>",$body);

				$time=$this->getusertime();



				/*$db->insert("nesote_email_draft_$tablenumber");
				$db->fields("userid,from_list,to_list,cc,bcc,subject,body,time,just_insert");
				$db->values(array($id,$fullid,$to,$cc,$bcc,$subject,$body,$time,0));
				$db->query();
				$last_id=$db->lastInsertid("nesote_email_draft_$tablenumber");
*/


				$db->update("nesote_email_draft_$tablenumber");
			$db->set("to_list=?,cc=?,bcc=?,subject=?,body=?,time=?,just_insert=?,userid=?,from_list=?",array($to,$cc,$bcc,$subject,$body,$time,0,$id,$fullid));
			$db->where("id=?",array($draftid));
			$rs=$db->query();$last_id=$draftid;

				$var=time().$username.$last_id;
				$message_id="<".md5($var).$extention.">";
				$references="<references><item><mailid>$last_id</mailid><folderid>2</folderid></item></references>";
				$md5_reference=md5($references);
				$db->update("nesote_email_draft_$tablenumber");
				$db->set("message_id=?,mail_references=?,md5_references=?",array($message_id,$references,$md5_reference));
				$db->where("id=?",$last_id);
				$res=$db->query();

				$this->saveLogs("Saved to Draft",$username." has saved a mail to draft");
				$p=base64_encode(449);
				header("Location:".$this->url("mail/detailmail/2/$last_id/$p"));
				exit(0);



			}
			else if($type==3)
			{
				//header("Location:".$this->url("mail/detailmail/$folderid/$mailid"));
				exit(0);
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

		function getusertime()
		{
			//time
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


			$time=$ts+$newtimezone;
			return $time;
		}

		function getstyle($userid)
		{
			$db=new NesoteDALController();
				
			$db->select("nesote_email_usersettings");
			$db->fields("theme_id");
			$db->where("userid=?",$userid);
			$result=$db->query();//echo $db->getQuery();
			$res=$db->fetchRow($result);
			$style_id=$res[0];
			if($style_id=="" || $style_id==0)
			{
				$db->select("nesote_email_settings");
				$db->fields("value");
				$db->where("name='themes'");
				$result=$db->query();//echo $select->getQuery();
				$res=$db->fetchRow($result);
				$style_id=$res[0];


			}
			$db->select("nesote_email_themes");
			$db->fields("name,style");
			$db->where("id=?",$style_id);
			$result=$db->query();
			$theme=$db->fetchRow($result);
			return $theme[1];
				
		}

		function starAction()
		{
require("script.inc.php");
if($restricted_mode=='true')
		{
echo "demo";exit(0);
}
			$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
			$mailid=$_POST['id2'];//$this->getParam(2);
			$folder=$_POST['id1'];//$this->getParam(1);
			$flag=$_POST['id3'];//$this->getParam(3);
			$curntfid=$_POST['fid'];//$this->getParam(4);
			$curntmailid=$_POST['mailid'];//$this->getParam(5);
			$db=new NesoteDALController();
			if($flag)
			{
				if($folder==1)
				$db->update("nesote_email_inbox_$tablenumber");
				else if($folder==2)
				$db->update("nesote_email_draft_$tablenumber");
				else if($folder==3)
				$db->update("nesote_email_sent_$tablenumber");
				else if($folder==4)
				$db->update("nesote_email_spam_$tablenumber");
				else if($folder==5)
				$db->update("nesote_email_trash_$tablenumber");
				else if($folder>=10)
				$db->update("nesote_email_customfolder_mapping_$tablenumber");
				$db->set("starflag=?",0);
				$db->where("id=?",$mailid);
				$res=$db->query();
				$p=base64_encode(189);

			}
			else
			{
				if($folder==1)
				$db->update("nesote_email_inbox_$tablenumber");
				else if($folder==2)
				$db->update("nesote_email_draft_$tablenumber");
				else if($folder==3)
				$db->update("nesote_email_sent_$tablenumber");
				else if($folder==4)
				$db->update("nesote_email_spam_$tablenumber");
				else if($folder==5)
				$db->update("nesote_email_trash_$tablenumber");
				else if($folder>=10)
				$db->update("nesote_email_customfolder_mapping_$tablenumber");
				$db->set("starflag=?",1);
				$db->where("id=?",$mailid);
				$res=$db->query();
				$p=base64_encode(185);

			}


			header("Location:".$this->url("mail/detailmail/$curntfid/$curntmailid/$p"));
			exit(0);


		}
		function getreaddetails($folderid,$mailid)
		{
		    $username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
			$response="";
			$db= new NesoteDALController();
			if($folderid==1)
			$db->select("nesote_email_inbox_$tablenumber");
			else if($folderid==2)
			$db->select("nesote_email_draft_$tablenumber");
			else if($folderid==3)
			$db->select("nesote_email_sent_$tablenumber");
			else if($folderid==4)
			$db->select("nesote_email_spam_$tablenumber");
			else if($folderid==5)
			$db->select("nesote_email_trash_$tablenumber");
			else if($folderid>=10)
			$db->select("nesote_email_customfolder_mapping_$tablenumber");
			$db->fields("readflag");
			$db->where("id=?",array($mailid));
			$result=$db->query();
			$num=$db->numRows($result);
			if($num>0)
			{
				$row=$db->fetchRow($result);
				if($row[0]==0)
				$response="<div id=\"mailread_$mailid\" class=\"replyLink floatL\"><a onclick=\"markasread($folderid,$mailid,$row[0])\">".$this->getmessage(74)."</a></div>";
				else if($row[0]==1)
				$response="<div id=\"mailread_$mailid\" class=\"replyLink floatL\"><a onclick=\"markasunread($folderid,$mailid,$row[0])\">".$this->getmessage(75)."</a></div>";
				
				//$response="<li><a href=\"".$this->url("mail/read/$folderid/$mailid/$row[0]")."\"><span class=\"attachments\">".$this->getmessage(74)."</span></a></li>";
				//$response="<li><a href=\"".$this->url("mail/read/$folderid/$mailid/$row[0]")."\"><span class=\"attachments\">".$this->getmessage(75)."</span></a></li>";

				return $response;
			}
			else
			return "";

		}

		function readAction()
		{
require("script.inc.php");
if($restricted_mode=='true')
		{
echo "demo";exit(0);
}

			$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
			$mailid=$_POST['mailid'];//$this->getParam(2);
			$folder=$_POST['fid'];//$this->getParam(1);
			$flag=$_POST['flg'];//$this->getParam(3);
			$db=new NesoteDALController();
			if($flag)
			{
				if($folder==1)
				$db->update("nesote_email_inbox_$tablenumber");
				else if($folder==2)
				$db->update("nesote_email_draft_$tablenumber");
				else if($folder==3)
				$db->update("nesote_email_sent_$tablenumber");
				else if($folder==4)
				$db->update("nesote_email_spam_$tablenumber");
				else if($folder==5)
				$db->update("nesote_email_trash_$tablenumber");
				else if($folder>=10)
				$db->update("nesote_email_customfolder_mapping_$tablenumber");
				$db->set("readflag=?",0);
				$db->where("id=?",$mailid);
				$res=$db->query();
				$p=base64_encode(187);

			}
			else
			{
				if($folder==1)
				$db->update("nesote_email_inbox_$tablenumber");
				else if($folder==2)
				$db->update("nesote_email_draft_$tablenumber");
				else if($folder==3)
				$db->update("nesote_email_sent_$tablenumber");
				else if($folder==4)
				$db->update("nesote_email_spam_$tablenumber");
				else if($folder==5)
				$db->update("nesote_email_trash_$tablenumber");
				else if($folder>=10)
				$db->update("nesote_email_customfolder_mapping_$tablenumber");
				$db->set("readflag=?",1);
				$db->where("id=?",$mailid);
				$res=$db->query();
				$p=base64_encode(183);

			}


			//header("Location:".$this->url("mail/detailmail/$folder/$mailid/$p/read"));
			exit(0);


		}

		function smtp($to,$cc,$bcc,$subject,$html,$id,$mail_references,$in_reply_to,$draftid,$folders,$mails)
		{
            if($html=="")
            $html=" ";
			$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
			$uid=$this->getId();
			$folder=-1;
			$maild=-1;$db=new NesoteDALController();
			if($in_reply_to!="")
			{

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

			$uname=$this->getusername($id);

			$mailextn_name=$this->getextension();
			$from=$uname.$mailextn_name;
			$mail_extension=$mailextn_name;

			$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name=?", array("SMTP_host"));
			$result=$db->query();
			$row=$db->fetchRow($result);
			$host_name=$row[0];

			$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name=?", array("SMTP_port"));
			$result=$db->query();
			$row=$db->fetchRow($result);
			$port_number=$row[0];


			$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name=?", array("catchall_mail"));
			$result=$db->query();
			$row=$db->fetchRow($result);
			$catch_all=$row[0];

 
                        $db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name=?", array("user_smtp"));
			$result=$db->query();
			$row=$db->fetchRow($result);
			$extsmtp=$row[0];


			if($catch_all==1)
			{
				$db->select("nesote_email_settings");
				$db->fields("value");
				$db->where("name=?", array("SMTP_username"));
				$result=$db->query();
				$row=$db->fetchRow($result);
				$SMTP_username=$row[0];

				$db->select("nesote_email_settings");
				$db->fields("value");
				$db->where("name=?", array("SMTP_password"));
				$result=$db->query();
				$row=$db->fetchRow($result);
				$SMTP_password=$row[0];
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


			require_once('../class/class.phpmailer.php');
			require_once('../class/class.smtp.php');

			$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

			//$mail->IsSMTP(); // telling the class to use SMTP
if($extsmtp==1)
{
$mail->IsSMTP();
}

			try {
				$mail->Host       = $host_name; // SMTP server
				$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->Port       = $port_number;                    // set the SMTP port for the GMAIL server
				$mail->Username   = $SMTP_username; // SMTP account username
				$mail->Password   = $SMTP_password;
				$mail->MessageID  = $message_id;
				// SMTP account password

				$mail->AddReplyTo($from);
				$mail->SetFrom($from);
				if($in_reply_to!="")
				$mail->AddCustomHeader("In-Reply-To:$in_reply_to");
				$to_address="";
				$cc_address="";
				$bcc_address="";
				if($to!='')
				{
						
					$to=explode(",",$to);

					foreach ($to as $address)
					{
						if(trim($address)!='')
						{
							$address=" ".$address;
								
							$address=str_replace("\\","",$address);

							preg_match("/(.+?)<(.+?)>/i",$address,$mailid);
							if(count($mailid[2])==0)
							preg_match("/(.+?)&lt;(.+?)&gt;/i",$address,$mailid);
							if($mailid[2]=="")
							{

								$mailid[2]=$address;
								$mailid[1]="";
							}
							$mailid[1]=str_replace("\"","",$mailid[1]);
								
							$mail->AddAddress($mailid[2],$mailid[1]);
							$to_address.=$mailid[1]."<".$mailid[2].">,";
							$this->addcontact($mailid[2],$mailid[1]);
						}
					}
				}$to_address=trim($to_address);


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
							$cc_address.=$mailid[1]."<".$mailid[2].">,";
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
							$bcc_address.=$mailid[1]."<".$mailid[2].">,";
							$this->addcontact($mailid[2],$mailid[1]);


						}
					}
				}

				$tme=time();
				$mail->SetFrom($from);
				$subjekt = "=?UTF-8?B?".base64_encode(strval($subject))."?=";
				$mail->Subject = $subjekt;
				//$mail->SMTPSecure="ssl";
				$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically


				$db->insert("nesote_email_sent_$tablenumber");
				$db->fields("userid,from_list,to_list,cc,bcc,subject,status,readflag,starflag,memorysize,message_id,time");
				$db->values(array($uid,$from,$to_address,$cc_address,$bcc_address,$subject,1,1,0,0,$message_id,$tme));
				$res=$db->query();
			//	$lastid=$db->lastInsert();
			$lastid=$db->lastInsertid("nesote_email_sent_$tablenumber");

				$mail->IsHTML(true);

				
				
				preg_match('/<img(.+?)src=(.+?)>/i',$html,$cset1);
						if($cset1[2]!="")
                                 {
                                       if(strpos($cset[2],"../attachments/")!=0)
                                       {
				          $html=str_replace("../attachments/","attachments/",$cset1[2]);
                                      }   
                                }


if($folders==4)
			$to_attach_id=4;
			else if($folders==5)
			$to_attach_id=5;
			else
			$to_attach_id=3;

			$p=0;
			//setcookie("draftid","1","0","/");
			$db2=new NesoteDALController();
			$db2->select("nesote_email_attachments_$tablenumber");
			$db2->fields("*");
			$db2->where("mailid=? and folderid=? and attachment=? and userid=?", array($draftid,2,1,$uid));
			$result2=$db2->query();//echo $db2->getQuery();
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
					$db3=new NesoteDALController();
					$db3->select("nesote_email_attachments_$tablenumber");
					$db3->fields("attachment");
					$db3->where("mailid=? and folderid=? and name=? and userid=?", array($draftid,2,$file_name[$p],$uid));
					$result3=$db3->query();
					$rw1=$db3->fetchRow($result3);
							$mail->AddAttachment("../attachments/2/$tablenumber/$draftid/$file_name[$p]",$file_name[$p],"base64",$type);
				}

				$p++;

			}

			//echo $draftid;
			//echo $mails;
			//if($folders!=2)
			//{
			$p=0;
			$db21=new NesoteDALController();
			$db21->select("nesote_email_attachments_$tablenumber");
			$db21->fields("*");
			$db21->where("mailid=? and folderid=? and attachment=? and userid=?", array($mails,$folders,0,$uid));
			$result21=$db21->query();
			//echo $db21->getQuery();
			//echo $folders;
			$size=1;
			$new_html=$html;
			while($rw21=$db21->fetchRow($result21))
			{
				//echo $p;
				$file_names[$p]=$rw21[2];//echo $file_names[$p];



				if ($file_names[$p]!= "." && $file_names[$p]!= "..")
				{
							if(strpos($new_html,"../attachments/".$folders."/".$tablenumber."/".$mails."/".$file_names[$p])!="FALSE")
					{


						$url=$_SERVER['HTTP_HOST'].$_SERVER["SCRIPT_NAME"];
						if(strpos($url,"/index.php")!="")
						{
							$url=str_replace("/index.php","",$url);

						}
								$url1="http://".$url."/attachments/".$folders."/".$tablenumber."/".$mails."/".$file_names[$p];
						//echo $url1;exit;
						//	$mail->AddEmbeddedImage("http://www.overnight.co.za/images_clean/logo.jpg","overnight-logo","http://www.overnight.co.za/images_clean/logo.jpg","base64","image/jpg");


						$cid=$p."_".$msg_id;
								$mail->AddEmbeddedImage("../attachments/".$folders."/".$tablenumber."/".$mails."/".$file_names[$p], $cid, $file_names[$p], "base64", "image/jpeg");


						//	$mail->AddEmbeddedImage($url1,$cid,$file_names[$p]);
						//echo $new_html."++++++++++++++";
						$new_html=str_replace($url1,"cid:".$cid,$new_html);//echo $new_html;


								if((is_dir("../attachments/".$to_attach_id))!=TRUE)
								{
									mkdir("../attachments/".$to_attach_id,0777);
								}
								if((is_dir("../attachments/".$to_attach_id."/".$tablenumber))!=TRUE)
								{
									mkdir("../attachments/".$to_attach_id."/".$tablenumber,0777);
								}
								if((is_dir("../attachments/".$to_attach_id."/".$tablenumber."/".$lastid))!=TRUE)
								{
									mkdir("../attachments/".$to_attach_id."/".$tablenumber."/".$lastid,0777);
								}
									
									
									
									

								//							if((is_dir("attachments/".$to_attach_id."/".$lastid))!=TRUE)
								//							{
								//								if((is_dir("attachments/".$to_attach_id))!=TRUE)
								//								{
								//									mkdir("attachments/".$to_attach_id,0777);
								//								}
								//								mkdir("attachments/".$to_attach_id."/".$lastid,0777);
								//
								//							}
								copy("../attachments/".$folders."/".$tablenumber."/".$mails."/".$file_names[$p],"../attachments/".$to_attach_id."/".$tablenumber."/".$lastid."/".$file_names[$p]);
								$filesize=filesize("../attachments/".$folders."/".$tablenumber."/".$mails."/".$file_names[$p]);
								$filesize=ceil($filesize/1024);
								$size=$size+$filesize;
								$extention=explode(".",$rw[2]);
								$len=count($extention);
								$extention=$extention[($len-1)];
								$extention=trim($extention);
								$img_formats=$this->getimageformats();
								$img_format=explode(",",$img_formats);

								$type="image/".$extention;
								$db1=new NesoteDALController();
								$db1->insert("nesote_email_attachments_$tablenumber");
								$db1->fields("mailid,userid,name,folderid,attachment,type");
								$db1->values(array($lastid,$uid,$file_names[$p],$to_attach_id,0,$type));
								$res=$db1->query();

								$new_html=str_replace($url1,"http://".$url."/attachments/".$to_attach_id."/".$tablenumber."/".$lastid."/".$file_names[$p],$new_html);
								$mail->Body=$new_html;

					}


				}
				$p++;
				//$d->close();
				//setcookie("draftid","1","0","/");
			}//echo $p;exit;
			if($p==0)
                $mail->Body=$html;
				
				$mail->Send();

				$message_id=$mail->MessageID;


				$time=$this->getusertime();

				$mail_references=$this->modified_reference($mail_references,$lastid);
				
				$this->update_conversation($mail_references);


			$db2=new NesoteDALController();
			$db2->select("nesote_email_attachments_$tablenumber");
			$db2->fields("*");
			$db2->where("mailid=? and folderid=? and attachment=? and userid=?", array($draftid,2,1,$uid));
			$result2=$db2->query();//echo $db2->getQuery();
			$num=$db2->numRows($result2);

				while($rw=$db2->fetchRow($result2))
				{
					if((is_dir("../attachments/".$to_attach_id))!=TRUE)
					{
						mkdir("../attachments/".$to_attach_id,0777);
					}
				 if((is_dir("../attachments/".$to_attach_id."/".$tablenumber))!=TRUE)
				 {
				 	mkdir("../attachments/".$to_attach_id."/".$tablenumber,0777);
				 }
				 if((is_dir("../attachments/".$to_attach_id."/".$tablenumber."/".$lastid))!=TRUE)
				 {
				 	mkdir("../attachments/".$to_attach_id."/".$tablenumber."/".$lastid,0777);
				 }

				
					//echo $entry;
					$filesize=filesize("../attachments/2/".$tablenumber."/".$draftid."/".$rw[2]);
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

					copy("../attachments/2/".$tablenumber."/".$draftid."/".$filename,"../attachments/".$to_attach_id."/".$tablenumber."/".$lastid."/".$filename);
					unlink("../attachments/2/".$tablenumber."/".$draftid."/".$filename);
					//echo $filename."+++++++++++".$rw[5];
					$db1=new NesoteDALController();
					$db1->insert("nesote_email_attachments_$tablenumber");
					$db1->fields("mailid,userid,name,folderid,attachment,type");
					$db1->values(array($lastid,$uid,$filename,$to_attach_id,$rw[5],$type));
					$res=$db1->query();//echo $db1->getQuery();
					$db5=new NesoteDALController();
					$db5->delete("nesote_email_attachments_$tablenumber");
					$db5->where("id=? ",array($rw[0]));
					$db5->query();
				}
				if($num!=0)
				{
					rmdir("../attachments/2/".$tablenumber."/".$draftid);

					//rmdir($mydir);


					$db3=new NesoteDALController();
					$db3->delete("nesote_email_attachments_$tablenumber");
					$db3->where("mailid=? and folderid=? and userid=?",array($draftid,2,$uid));
					$res=$db3->query();
			}

			//echo $html."+++++++".$num;exit;


                $md5_mail_references=md5($mail_references);  
				$size=0;

				$db->update("nesote_email_sent_$tablenumber");
				$db->set("mail_references=?,md5_references=?,body=?,time=?,memorysize=?",array($mail_references,$md5_mail_references,$html,$time,$size));
				$db->where("id=?",$lastid);
				$res1=$db->query();
				//return $db->getQuery();exit;

			} catch (phpmailerException $e) {
				
				
				 $p=$e->errorMessage(); return $p;//Pretty error messages from PHPMailer
			} catch (Exception $e) {
				 $p=$e->getMessage(); return $p;//Boring error messages from anything else!
			}

			return;


		}

		function modified_reference($mail_references,$lastid)
		{
				
			if($mail_references=="")
			{
				$mail_references="<references><item><mailid>$lastid</mailid><folderid>3</folderid></item></references>";
			}
			else
			{
				preg_match_all('/<item>(.+?)<\/item>/i',$mail_references,$reply);

				$no=count($reply[1]);
				for($i=0;$i<$no;$i++)
				{
					preg_match('/<mailid>(.+?)<\/mailid>/i',$reply[1][$i],$mailid);
					preg_match('/<folderid>(.+?)<\/folderid>/i',$reply[1][$i],$folderid);

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

		function update_conversation($mail_references)
		{
				
			$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
			preg_match_all('/<item>(.+?)<\/item>/i',$mail_references,$reply);
				
			$no=count($reply[1]);
			for($i=0;$i<$no;$i++)
			{
				preg_match('/<mailid>(.+?)<\/mailid>/i',$reply[1][$i],$mailid);
				preg_match('/<folderid>(.+?)<\/folderid>/i',$reply[1][$i],$folderid);
				$db=new NesoteDALController();
				if($folderid[1]!=2)
				{
					if($folderid[1]==1)
					$db->update("nesote_email_inbox_$tablenumber");
					else if($folderid[1]==3)
					$db->update("nesote_email_sent_$tablenumber");
					else if($folderid[1]==4)
					$db->update("nesote_email_spam_$tablenumber");
					else if($folderid[1]==5)
					$db->update("nesote_email_trash_$tablenumber");
					else if($folderid[1]>=10)
					$db->update("nesote_email_customfolder_mapping_$tablenumber");
					$db->set("mail_references=?",array($mail_references));
					$db->where("id=?",array($mailid[1]));
					$rs=$db->query();
				}
			}
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
function getuserid($username)
		{
			$db=new NesoteDALController();
			$db->select("nesote_inoutscripts_users");
			$db->fields("id");
			$db->where("username=?",array($username));
			$result=$db->query();
			$row=$db->fetchRow($result);
			return $row[0];
		}

		function addcontact($mailid,$name)
		{
			$userid=$this->getId();
			$db=new NesoteDALController();
			$db->select("nesote_email_contacts");
			$db->fields("*");
			$db->where("mailid=? and addedby=?",array($mailid,$userid));
			$result=$db->query();
			$no=$db->numRows($result);
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
		function contactsAction()
		{
				
			$valid=$this->validateUser();

			if($valid!=TRUE)
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}
				


			$userid=$this->getId();
			
				
			$search=$_POST['search'];
			if(isset($search))
			$flag=1;
			else
			$flag=0;
			$search=mysqli_real_escape_string($search);
			
			$db=new NesoteDALController();
			$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name='public_page_logo'");
			$result1=$db->query();
			$row1=$db->fetchRow($result1);
			$img=$row1[0];
			$imgpath="../admin/logo/".$img;
			$this->setValue("imgpath",$imgpath);
		
			
			$db->select("nesote_email_contacts");
			$db->fields("mailid,id");
			if($flag==1)
			$db->where("addedby=? and (mailid like '%$search%' or firstname like '%$search%' or lastname like '%$search%')",array($userid));
			else
			$db->where("addedby=?",array($userid));
			$db->group("mailid");
			$db->order("mailid asc");
			$result=$db->query();
			$no=$db->numRows($result);
			$this->setValue("no",$no);
				
			$this->setLoopValue("contacts",$result->getResult());
				
			$memorymsg=$this->getmessage(351);
			$year=date("Y",time());
			$msg1=str_replace('{year}',$year,$memorymsg);
			$this->setValue("footer",$msg1);
		}

		function getcontactname($id)
		{
			$db=new NesoteDALController();
			$db->select("nesote_email_contacts");
			$db->fields("mailid,firstname,lastname");
			$db->where("id=?",array($id));
			$result=$db->query();
			$row=$db->fetchRow($result);
			if($row[1]!="")
			return $row[1]." &lt;".$row[0]."&gt;";
			else
			return "&lt;".$row[0]."&gt;";
				
		}
		
		function getcnamenew($id)
		{
			$db=new NesoteDALController();
			$db->select("nesote_email_contacts");
			$db->fields("mailid,firstname,lastname");
			$db->where("id=?",array($id));
			$result=$db->query();
			$row=$db->fetchRow($result);
			if($row[1]!="")
			return $row[1]." ". $row[2]."<".$row[0].">";
			else
			return $row[0];
				
		}

		function viewcontactsAction()
		{
			$valid=$this->validateUser();

			if($valid!=TRUE)
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}
			$userid=$this->getId();
			$id=$this->getParam(1);
			$this->setValue("cid",$id);
				
			$db=new NesoteDALController();
			
			$db->select("nesote_email_contacts");
			$db->fields("mailid,firstname,lastname");
			$db->where("id=?",array($id));
			$result=$db->query();
			$row=$db->fetchRow($result);
			if($row[1]!="")
			$cname=trim($row[1])." ".trim($row[2])."<".trim($row[0]).">";
			else
			$cname=trim($row[0]);
				
			$cname1=base64_encode($cname);
			$this->setValue("cname",$cname);$this->setValue("cname1",$cname1);$this->setValue("mailid",$row[0]);
				
			$memorymsg=$this->getmessage(351);
			$year=date("Y",time());
			$msg1=str_replace('{year}',$year,$memorymsg);
			$this->setValue("footer",$msg1);
				
				
		}
		
		function homeAction()
		{
		$valid=$this->validateUser();

		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

     $mobile_status=$this->mobile_device_detect();
	 if($mobile_status==true)
	 $mob=1;
	 else
	 $mob=0;
	 $this->setValue("mob",$mob);
	 
			$username=$_COOKIE['e_username'];
			$password=$_COOKIE['e_password'];
		$db=new NesoteDALController();
		$db->select("nesote_inoutscripts_users");
		$db->fields("*");
		$db->where("username=? and password=?", array($username,$password));
		$result=$db->query();
		$rs=$db->fetchRow($result);
		$fname = $rs[3];
				$this->loadLibrary('Settings');
			$settings=new Settings('nesote_email_settings');
			$settings->loadValues();
			
			$servicename=$settings->getValue("engine_name");
			$this->setValue("servicename",$servicename);
			
			$memorymsg=$this->getmessage(351);
			$year=date("Y",time());
			$msg1=str_replace('{year}',$year,$memorymsg);
			$this->setValue("footer",$msg1);
			$this->setValue("uname",$username);
			$this->setValue("fname",$fname);
			$id=$this->getId();
		    $this->setValue("uid",$id);
		}
		
		function headerAction()
		{
$link = $_SERVER['REQUEST_URI'];
    $link_array = explode('/',$link);
    //print_r($link_array);exit;
//echo $link_array[6];exit;
if($link_array[6]=='detailmail' || $link_array[6]=='newmail')
{
$dmail=0;
$this->setValue("dmail",$dmail);
}
else
{
$dmail=1;
$this->setValue("dmail",$dmail);
}
		$valid=$this->validateUser();

		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
$mobile_status=$this->mobile_device_detect();
	 if($mobile_status==true)
	 $mob=1;
	 else
	 $mob=0;
	 $this->setValue("mob",$mob);
			$username=$_COOKIE['e_username'];
			$password=$_COOKIE['e_password'];
		$db=new NesoteDALController();
		$db->select("nesote_inoutscripts_users");
		$db->fields("*");
		$db->where("username=? and password=?", array($username,$password));
		$result=$db->query();
		$rs=$db->fetchRow($result);
		$fname = $rs[3];
		    $tablenumber=$this->tableid($username);
				$this->loadLibrary('Settings');
			$settings=new Settings('nesote_email_settings');
			$settings->loadValues();
			
			$servicename=$settings->getValue("engine_name");
			$this->setValue("servicename",$servicename);
			
			$memorymsg=$this->getmessage(351);
			$year=date("Y",time());
			$msg1=str_replace('{year}',$year,$memorymsg);
			$this->setValue("footer",$msg1);
			$uname=$username;
			$this->setValue("uname",$uname);
						$this->setValue("fname",$fname);

		
			
		$id=$this->getId();
		$this->setValue("uid",$id);
		$db=new NesoteDALController();	
		$db->select("nesote_email_customfolder");
		$db->fields("id,name");
		$db->where("userid=?",array($id));
		$res1=$db->query();
		$i=0;
		while($rw=$db->fetchRow($res1))
		{
			$db1=new NesoteDALController();
			$db1->select("nesote_email_customfolder_mapping_$tablenumber");
			$db1->fields("distinct mail_references");
			$db1->where("folderid=?",array($rw[0]));
			$db1->order("time desc");
			$result1=$db1->query();
			$count=$db1->numRows($result1);


			$db1->select("nesote_email_customfolder_mapping_$tablenumber");
			$db1->fields("distinct mail_references");
			$db1->where("folderid=? and readflag=?",array($rw[0],0));
			$db1->order("time desc");
			$result1=$db1->query();
			$count1=$db1->numRows($result1);

			$customFolder[$i][0]=$rw[0];
			$customFolder[$i][1]=$rw[1];
			$customFolder[$i][2]=$count;
			$customFolder[$i][3]=$count11;
			$countCookie="custom".$rw[0];
			setcookie($countCookie,$count,"0","/");
			$i++;
		}

		$this->setValue("mpcount",$i);
		$this->setLoopValue("customfolders",$customFolder);
		 $folder=$this->getParam(1);
		 
		 if($folder=="contacts")
		 {
		 $heading=$this->getmessage(2);$folder="";
		 }
		 else if($folder=="new")
		 {
		  $heading=$this->getmessage(10);$folder="";
		 }
		  /*else if($folder='2')
		 {
		  $heading=$this->getmessage(20);
		 }
		 else if($folder='3')
		 {
		  $heading=$this->getmessage(21);
		 }*/
		 else
		 {
		if($folder=="")
		{
		    $url1 = $_SERVER['QUERY_STRING'];

$parts = parse_url($url1);
$fragments = explode('/', $parts['path']);
$fragments = array_filter($fragments);

$folder = $fragments[2];

$folderdetailid=$_COOKIE['folderdetailid'];

if($folderdetailid==6){
$folder = 6;
}

		  if($folder==2)
		  $heading=$this->getmessage(20);
		  else if($folder==3)
		  $heading=$this->getmessage(21);
		  else if($folder==4)
		  $heading=$this->getmessage(12);
		  else if($folder==5)
		  $heading=$this->getmessage(22);
		  else if($folder==6 )
		  $heading=$this->getmessage(206);
		  else
		$folder=1;
		}
		$search="";
		$search=$this->getParam(2);

		if($search!="")
		{
			$folder=$this->getParam(3);
		}
		$this->setValue("fid",$folder);
		$heading=$this->getheading($folder,$search);
			}
		$this->setValue("heading",$heading);
		}
		
		function footerAction()
		{
		$fid=$this->getParam(1);$page=$this->getParam(2);
		$uid=$this->getId();
		$this->setValue("uid",$uid);
		$this->setValue("fid",$fid);
		$this->setValue("page",$page);
		}
		
		function srtmobile_device_detect($iphone=true,$android=true,$opera=true,$blackberry=true,$palm=true,$windows=true,$mobileredirect=false,$desktopredirect=false){

        $mobile_browser   = false;
        $user_agent       = $_SERVER['HTTP_USER_AGENT']; 
        $accept           = $_SERVER['HTTP_ACCEPT'];

        switch(true){ 

            case (eregi('ipod',$user_agent)||eregi('iphone',$user_agent)||eregi('iPhone',$user_agent)); 
            $mobile_browser = $iphone; 
            if(substr($iphone,0,4)=='http'){ 
                $mobileredirect = $iphone;
            }
            break;
            case (eregi('android',$user_agent));
            $mobile_browser = $android; 
            if(substr($android,0,4)=='http'){ 
                $mobileredirect = $android; 
            } 
            break; 
            case (eregi('opera mini',$user_agent));
            $mobile_browser = $opera; 
            if(substr($opera,0,4)=='http'){
                $mobileredirect = $opera;
            }
            break; 
            case (eregi('blackberry',$user_agent));
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

//////////anna////////////

function upload_frameAction()
	{
		//setcookie("draftid","0","0","/");
		//if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

		$userid=$this->getId();

		$draftid=$this->getParam(1);
		$filevar=$this->getParam(2);
		$designId=$this->getParam(3);
		$fl=1;
		if($designId=="0_0")
		$fl=0;
		$this->setValue("fl",$fl);
		$this->setValue("draftid",$draftid);
		$this->setValue("filevar",$filevar);
		$this->setValue("designid",$designId);
	}

	function file_addprocessAction()
	{
		$username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);

		$userid=$this->getId();
		$select=new NesoteDALController();

		$draftid=$_POST['draftid'];
		$designid=$_POST['designid'];
		$this->setValue("designid",$designid);
		$fl=1;
		if($designid=="0_0")
		$fl=0;
		$this->setValue("fl",$fl);
	


		$select->select("nesote_email_draft_$tablenumber");
		$select->fields("memorysize");
		$select->where("id=? and just_insert=?",array($draftid,0));
		$rs=$select->query();
		$row=$select->fetchRow($rs);
		$filesize=$row[0];
		$filevar=$_POST['filevar'];
		$uid=$this->getId();
		$size=$_FILES['filez']['size']/1024;
		
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$restric_types=$settings->getValue("restricted_attachment_types");

		$allowed_attachment_size=$settings->getValue("attachment_size");
		
		$cal_size=$size/1024;
		 if($allowed_attachment_size<$cal_size)
          {
             $this->setValue("filename",-3);
          }
	   else if($cal_size<=0)
	   {
		 $this->setValue("filename",-2);
	   }
	   else
	   {
		$size=ceil($size);
		$filesize=$filesize+$size;
		$time=time();
		$filename=$time."-".$_FILES["filez"]["name"];
		$file=explode(".",$filename);
		$no=count($file);
		$filetype=trim($file[($no-1)]);

		$len=strlen($restric_types);
		if($restric_types[($len-1)]==",")
		$restric_types=substr($restric_types,0,-1);
		$types=explode(",",$restric_types);
		$length=count($types);
		$restricted=0;
		for($a=0;$a<$length;$a++)
		{
			$b=trim($types[$a]);
			if($b[0]==".")
			{
				$b=substr($b,1);
				$b=trim($b);
			}
			if($filetype==$b)
			{
				$restricted=1;
				break;
			}
		}
		//echo $restricted."jgddds";exit;
		if($restricted==0)
		{
			$var=strpos($filename,"-");
			if($var!="FALSE")
			$namez=substr($filename,($var+1));
			else
			$namez=$filename;
			$this->setValue("filename",$namez);
			if($filetype=="exe")
			$filename=str_replace("exe","qqq",$filename);
			$references="<references><item><mailid>$draftid</mailid><folderid>2</folderid></item></references>";

			$select->update("nesote_email_draft_$tablenumber");
			$select->set("userid=?,memorysize=?,mail_references=?",array($uid,$filesize,$references));
			$select->where("id=?",$draftid);
			$res=$select->query();
			$select->insert("nesote_email_attachments_$tablenumber");
			$select->fields("mailid,userid,folderid,name,attachment");
			$select->values(array($draftid,$userid,2,$filename,1));
			$res=$select->query();
			$id=$select->lastInsertid("nesote_email_attachments_$tablenumber");


					setcookie("file_$filevar",0,"0","/");

					if((is_dir("../attachments/2"))!=TRUE)
					{
						mkdir("../attachments/2",0777);
					}
					if((is_dir("../attachments/2/".$tablenumber))!=TRUE)
					{
						mkdir("../attachments/2/".$tablenumber,0777);

					}
					if((is_dir("../attachments/2/".$tablenumber."/".$draftid))!=TRUE)
					{
						mkdir("../attachments/2/".$tablenumber."/".$draftid,0777);
					}
						


					copy($_FILES['filez']['tmp_name'],"../attachments/2/".$tablenumber."/".$draftid."/".$filename);

			$url=$this->url("mail/delete_attachment/$draftid/$id");


			setcookie("file_$filevar",1,"0","/");
			$this->setValue("dratfid",$draftid);
			$this->setValue("filevar",$filevar);

			$this->setValue("url",$url);
			setcookie("file_$filevar",1,"0","/");
		}
		else
		{
			$this->setValue("filename",-1);
		}
		}
	}

function delete_attachmentAction()
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
			$userid=$this->getId();
			$mailid=$this->getParam(1);
			$id=$this->getParam(2);

			$db=new NesoteDALController();
			$db->select("nesote_email_attachments_$tablenumber");
			$db->fields("name");
			$db->where("mailid=? and id=? and folderid=? and userid=?",array($mailid,$id,2,$userid));
			$res=$db->query();
			$row=$db->fetchRow($res);
			$name=$row[0];
			$size=filesize("../attachments/2/$mailid/$name");
			$size=ceil($size/1024);

			$db->select("nesote_email_draft_$tablenumber");
			$db->fields("memorysize");
			$db->where("id=? and just_insert=?",array($mailid,0));
			$res2=$db->query();
			$row2=$db->fetchRow($res2);
			$file_size=$row2[0];
			$filesize=$file_size-$size;


			$db->update("nesote_email_draft_$tablenumber");
			$db->set("memorysize=?",array($filesize));
			$db->where("id=?",$mailid);
			$res=$db->query();

			$db->delete("nesote_email_attachments_$tablenumber");
			$db->where("mailid=? and id=? and userid=?",array($mailid,$id,$userid));
			$re=$db->query();
					unlink("../attachments/2/$tablenumber/$mailid/$name");
			//			echo $mailid;
			exit(0);

		}
	}


	function createdraftAction()
	{
		$username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();


		$time=time();

		$db= new NesoteDALController();

		$position=$settings->getValue("time_zone_postion");

		$username=$_COOKIE['e_username'];


		$hour=$settings->getValue("time_zone_hour");


		$min=$settings->getValue("time_zone_mint");

		$diff=((3600*$hour)+(60*$min));

		if($position=="Behind")
		$diff=$diff;
		else
		$diff=-$diff;
		$time=$time+$diff;
		// echo date("d/m/y H:i:s",$time);
		//$time=$this->getParam(1);
		$id=$this->getId();
		$username=$_COOKIE['e_username'];
		$username=$username.$this->getextension();
		$db= new NesoteDALController();
		$db->insert("nesote_email_draft_$tablenumber");
		$db->fields("time,userid,from_list,just_insert,readflag");
		$db->values(array($time,$id,$username,1,1));
		$result=$db->query();
		$lasTid=$db->lastInsertid("nesote_email_draft_$tablenumber");
		echo $lasTid;exit;
	}
	function upload_forwardAction()
	{
		//if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

		$username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);

		$userid=$this->getId();
		$select=new NesoteDALController();
		$draftid=$this->getParam(1);
		$loop=$this->getParam(2);
		$just_insert=$this->getParam(3);
		$att=array();

		$select->select("nesote_email_attachments_$tablenumber");
		$select->fields("*");
		$select->where("folderid=? and mailid=? and attachment=? and userid=?",array(2,$draftid,1,$userid));
		$rs=$select->query();

		$this->setValue("aa",$just_insert);
		$filevar=$select->numRows($rs);
		$temp=$loop."_".$filevar;
		$i=0;

		while($row=$select->fetchRow($rs))
		{
			$filename=$row[2];
			$name=explode(".",$filename);
			$len=count($name);
			$extn=$name[($len-1)];
			if($extn=="qqq")
			$filename=str_replace("qqq","exe",$filename);
			$var=strpos($filename,"-");
			if(($var!="FALSE")||($var>0))
			$namez=substr($filename,($var+1));
			else
			$namez=$filename;
			$att[$i][0]=$namez;
			$att[$i][2]=$row[0];
					$filesize=filesize("../attachments/2/$tablenumber/$draftid/$row[2]");
			$filesize=ceil($filesize/1024);
			$filesize=ceil($filesize);
			//echo $filesize."mkn";
			$att[$i][1]=$filesize;
			$total_size=$total_size+$filesize;
			$i++;

		}

		$select->update("nesote_email_draft_$tablenumber");
		$select->set("memorysize=?",array($total_size));
		$select->where("id=?",$draftid);
		$res1=$select->query();
		$url=$this->url("mail/delete_attachment/$draftid");//exit;
		$this->setLoopValue("attach",$att);
		$this->setValue("i",$i);
		$this->setValue("draftid",$draftid);
		$this->setValue("temp",$temp);

		$this->setValue("loop",$loop);
	}

	function delete_forwardattachmentAction()
	{
		$username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);
		$userid=$this->getId();
		$string="";
		$mailid=$this->getParam(1);
		$id=$this->getParam(2);

		$db=new NesoteDALController();
		$db->select("nesote_email_attachments_$tablenumber");
		$db->fields("name");
		$db->where("mailid=? and id=? and folderid=? and userid=?" ,array($mailid,$id,2,$userid));
		$re1=$db->query();
		$row1=$db->fetchRow($re1);
		$name=$row1[0];

		$db->select("nesote_email_draft_$tablenumber");
		$db->fields("memorysize");
		$db->where("id=?" ,array($mailid));
		$re3=$db->query();
		$row3=$db->fetchRow($re3);
		$file_size=$row3[0];
				$size=filesize("../attachments/2/$tablenumber/$mailid/$name");
		$size=ceil($size/1024);
		$filesize1=$file_size-$size;

		$db->update("nesote_email_draft_$tablenumber");
		$db->set("memorysize=?",$filesize1);
		$db->where("id=?" ,array($mailid));
		$re4=$db->query();


		$db->delete("nesote_email_attachments_$tablenumber");
		$db->where("mailid=? and id=? and folderid=? and userid=?" ,array($mailid,$id,2,$userid));
		$re=$db->query();
		unlink("../attachments/2/$tablenumber/$mailid/$name");


		$db->select("nesote_email_attachments_$tablenumber");
		$db->fields("*");
		$db->where("folderid=? and mailid=? and userid=?",array(2,$mailid,$userid));
		$rs=$db->query();
		$filevar=$db->numRows($rs);
		$temp=$loop."_".$filevar;
		$i=0;
		while($row=$db->fetchRow($rs))
		{
			
			$pos=strpos($row[2],"-");//echo $pos;
			if(($pos!="FALSE")||($pos>0))
			$filename=substr($row[2],($pos+1));
			else
			$filename=$row[2];
			$filesize=filesize("../attachments/2/$tablenumber/$mailid/$row[2]");
			$filesize=ceil($filesize/1024);

			$string.="<table><tr><td><input type=\"checkbox\" name=\"select_$i\" id=\"select_$i\" checked=\"true\" onclick=\" delete_item($row[0])\"></td><td>$filename($filesize kb)</td></tr></table>";
			$i++;
		}


		echo $string;
		exit;

	}
	function getattachlistAction()
	{
				$username=$_COOKIE['e_username'];
				$tablenumber=$this->tableid($username);
		$folderName=$this->getParam(1);
		$mailId=$this->getParam(2);
		$draftId=$this->getParam(3);
		$folderId=$this->getfolderid($folderName);$userid=$this->getId();
		$string="";
		$db= new NesoteDALController();
		$db->select("nesote_email_attachments_$tablenumber");
		$db->fields("*");
		$db->where("folderid=? and mailid=? and attachment=? and userid=?",array($folderId,$mailId,1,$userid));
		$result=$db->query();
		$no=$db->numRows($result);
		while($row=$db->fetchRow($result))
		{
					//$last_id=$db1->lastInsert();


					if((is_dir("../attachments/2/"))!=TRUE)
					{

						mkdir("../attachments/2/",0777);
					}
					if((is_dir("../attachments/2/".$tablenumber))!=TRUE)
					{
						mkdir("../attachments/2/".$tablenumber,0777);
					}
					if((is_dir("../attachments/2/".$tablenumber."/".$draftId))!=TRUE)
					{
						mkdir("../attachments/2/".$tablenumber."/".$draftId,0777);
					}
					$string.=$row[2]."{nesote_,}";
					copy("../attachments/".$folderId."/".$tablenumber."/".$mailId."/".$row[2],"../attachments/2/".$tablenumber."/".$draftId."/".$row[2]);
			$db2=new NesoteDALController();
					$db2->insert("nesote_email_attachments_$tablenumber");
			$db2->fields("mailid,folderid,name,attachment,userid");
			$db2->values(array($draftId,2,$row[2],$row[5],$userid));
			$res2=$db2->query();
		}
		$string=substr($string,0,-10);
		echo $no."{nesote_:}".$string;exit;


	}

	function getfolderid($foldername)
	{

		if($foldername=='inbox')
		{
			return 1;
		}
		else if($foldername=='draft')
		{
			return 2;
		}
		else if($foldername=='sent')
		{
			return 3;
		}
		else if($foldername=='spam')
		{
			return 4;
		}
		else if($foldername=='trash')
		{
			return 5;
		}
		else if($foldername=='starred')
		{
			return 6;
		}
		else if(strpos($foldername,"ustom")==1)
		{
			$folderid=str_replace("custom","",$foldername);
			return $folderid;
		}
		else if(strpos($foldername,"earch")==1)
		{
			$folderid=str_replace("search","",$foldername);
			return $folderid;
		}
		else
		{
			$db=new NesoteDALController();
			$db->select("nesote_email_customfolder");
			$db->fields("id");
			$db->where("name=?",$foldername);
			$rs1=$db->query();
			$row=$db->fetchRow($rs1);
			return $row[0];
		}


	}


	function innerheaderAction()
		{
$link = $_SERVER['REQUEST_URI'];
    $link_array = explode('/',$link);
    //print_r($link_array);exit;
//echo $link_array[6];exit;
if($link_array[6]=='detailmail' || $link_array[6]=='newmail')
{
$dmail=0;
$this->setValue("dmail",$dmail);
}
else
{
$dmail=1;
$this->setValue("dmail",$dmail);
}
		$valid=$this->validateUser();

		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
$mobile_status=$this->mobile_device_detect();
	 if($mobile_status==true)
	 $mob=1;
	 else
	 $mob=0;
	 $this->setValue("mob",$mob);
			$username=$_COOKIE['e_username'];
			$password=$_COOKIE['e_password'];
		$db=new NesoteDALController();
		$db->select("nesote_inoutscripts_users");
		$db->fields("*");
		$db->where("username=? and password=?", array($username,$password));
		$result=$db->query();
		$rs=$db->fetchRow($result);
		$fname = $rs[3];
		    $tablenumber=$this->tableid($username);
				$this->loadLibrary('Settings');
			$settings=new Settings('nesote_email_settings');
			$settings->loadValues();
			
			$servicename=$settings->getValue("engine_name");
			$this->setValue("servicename",$servicename);
			
			$memorymsg=$this->getmessage(351);
			$year=date("Y",time());
			$msg1=str_replace('{year}',$year,$memorymsg);
			$this->setValue("footer",$msg1);
			$uname=$username;
			$this->setValue("uname",$uname);
						$this->setValue("fname",$fname);

		
			
		$id=$this->getId();
		$this->setValue("uid",$id);
		$db=new NesoteDALController();	
		$db->select("nesote_email_customfolder");
		$db->fields("id,name");
		$db->where("userid=?",array($id));
		$res1=$db->query();
		$i=0;
		while($rw=$db->fetchRow($res1))
		{
			$db1=new NesoteDALController();
			$db1->select("nesote_email_customfolder_mapping_$tablenumber");
			$db1->fields("distinct mail_references");
			$db1->where("folderid=?",array($rw[0]));
			$db1->order("time desc");
			$result1=$db1->query();
			$count=$db1->numRows($result1);


			$db1->select("nesote_email_customfolder_mapping_$tablenumber");
			$db1->fields("distinct mail_references");
			$db1->where("folderid=? and readflag=?",array($rw[0],0));
			$db1->order("time desc");
			$result1=$db1->query();
			$count1=$db1->numRows($result1);

			$customFolder[$i][0]=$rw[0];
			$customFolder[$i][1]=$rw[1];
			$customFolder[$i][2]=$count;
			$customFolder[$i][3]=$count11;
			$countCookie="custom".$rw[0];
			setcookie($countCookie,$count,"0","/");
			$i++;
		}

		$this->setValue("mpcount",$i);
		$this->setLoopValue("customfolders",$customFolder);
		 $folder=$this->getParam(1);
		 
		 if($folder=="contacts")
		 {
		 $heading=$this->getmessage(2);$folder="";
		 }
		 else if($folder=="new")
		 {
		  $heading=$this->getmessage(10);$folder="";
		 }
		  /*else if($folder='2')
		 {
		  $heading=$this->getmessage(20);
		 }
		 else if($folder='3')
		 {
		  $heading=$this->getmessage(21);
		 }*/
		 else
		 {
		if($folder=="")
		{
		    $url1 = $_SERVER['QUERY_STRING'];

$parts = parse_url($url1);
$fragments = explode('/', $parts['path']);
$fragments = array_filter($fragments);

$folder = $fragments[2];

$folderdetailid=$_COOKIE['folderdetailid'];

if($folderdetailid==6){
$folder = 6;
}

		  if($folder==2)
		  $heading=$this->getmessage(20);
		  else if($folder==3)
		  $heading=$this->getmessage(21);
		  else if($folder==4)
		  $heading=$this->getmessage(12);
		  else if($folder==5)
		  $heading=$this->getmessage(22);
		  else if($folder==6 )
		  $heading=$this->getmessage(206);
		  else
		$folder=1;
		}
		$search="";
		$search=$this->getParam(2);

		if($search!="")
		{
			$folder=$this->getParam(3);
		}
		$this->setValue("fid",$folder);
		$heading=$this->getheading($folder,$search);
			}
		$this->setValue("heading",$heading);
		}

function innerfooterAction()
		{
		$fid=$this->getParam(1);$page=$this->getParam(2);
		$uid=$this->getId();
		$this->setValue("uid",$uid);
		$this->setValue("fid",$fid);
		$this->setValue("page",$page);
		}

		function innermailfooter1Action()
	{
$link = $_SERVER['REQUEST_URI'];
    $link_array = explode('/',$link);
    //print_r($link_array);exit;
//echo $link_array[0];exit;
if($link_array[6]=='detailmail' || $link_array[7]=='newmail' || $link_array[6]=='getattachmentdetails' || $link_array[6]=='replylink' || $link_array[6]=='contacts' || $link_array[6]=='home' || $link_array[3]=='detailmail' || $link_array[4]=='newmail' || $link_array[3]=='getattachmentdetails' || $link_array[3]=='replylink' || $link_array[3]=='contacts')
{
$dmail=0;
$this->setValue("dmail",$dmail);
}
else
{
$dmail=1;
$this->setValue("dmail",$dmail);
}
//echo "nn";exit;

		$valid=$this->validateUser();

		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

			$username=$_COOKIE['e_username'];
		    $tablenumber=$this->tableid($username);
		$db=new NesoteDALController();
		$fid=$this->getParam(1);
		if(!isset($fid))
		$fid=1;
		$this->setValue("fid",$fid);

		$whichpage=$this->getParam(2);
		$this->setValue("whichpage",$whichpage);

		$page=$this->getParam(3);
		if(isset($page))
		$this->setValue("page",$page);
		else
		$this->setValue("page",1);

		$rlink=$this->getParam(4);
		if(isset($rlink))
		$this->setValue("rlink",$rlink);
		else
		$this->setValue("rlink","");

		$crntfold=$this->getParam(5);
		$this->setValue("crntfold",$crntfold);
		$crntid=$this->getParam(6);
		$this->setValue("crntid",$crntid);


		$id=$this->getId();
		$this->setValue("uid",$id);
		$db->select("nesote_email_customfolder");
		$db->fields("id,name");
		$db->where("userid=?",array($id));
		$res1=$db->query();
		$i=0;
		while($rw=$db->fetchRow($res1))
		{
			$db1=new NesoteDALController();
			$db1->select("nesote_email_customfolder_mapping_$tablenumber");
			$db1->fields("distinct mail_references");
			$db1->where("folderid=?",array($rw[0]));
			$db1->order("time desc");
			$result1=$db1->query();
			$count=$db1->numRows($result1);


			$db1->select("nesote_email_customfolder_mapping_$tablenumber");
			$db1->fields("distinct mail_references");
			$db1->where("folderid=? and readflag=?",array($rw[0],0));
			$db1->order("time desc");
			$result1=$db1->query();
			$count1=$db1->numRows($result1);

			$customFolder[$i][0]=$rw[0];
			$customFolder[$i][1]=$rw[1];
			$customFolder[$i][2]=$count;
			$customFolder[$i][3]=$count11;
			$countCookie="custom".$rw[0];
			setcookie($countCookie,$count,"0","/");
			$i++;
		}
		$this->setValue("mpcount",$i);
		$this->setLoopValue("customfolders",$customFolder);

		$memorymsg=$this->getmessage(351);
		$year=date("Y",time());
		$msg1=str_replace('{year}',$year,$memorymsg);
		$this->setValue("footer",$msg1);

		$userid=$this->getuserid($username);
			$db->select("nesote_email_inbox_$tablenumber");
			$db->fields("distinct mail_references");
			$db->where("userid=? and readflag=?",array($userid,0));
			$res=$db->query();
			$noread=$db->numRows($res);
$this->setValue("unreadcount",$noread);


	}

function editprofileAction()
	{
		$valid=$this->validateUser();
		if($valid!=TRUE)
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		
		$userid=$this->getId();$folder="";$msg="";
		$lang_code=$_COOKIE['lang_mail'];
		if($lang_code=="")
		{
			$lang_code='eng';
			setcookie("lang_mail",$lang_code,"0","/");
		}
		$lang_id=$this->getlang_id($lang_code);

		$msg2=$this->getParam(1);
		if($msg2 != ""){
		$this->setValue("msg2",$msg2);
	}

		$select=new NesoteDALController();
		$this->setValue("uid",$userid);$db=new NesoteDALController();
		$db->select("nesote_email_months_messages");
		$db->fields("month_id,message");
		$db->where("lang_id=?",array($lang_id));
		$result1=$db->query();
		$this->setLoopValue("month",$result1->getResult());



		$uname=$_COOKIE['e_username'];
		$pwd=$_COOKIE['e_password'];
		
		$select->select(array("a"=>"nesote_inoutscripts_users","b"=>"nesote_email_usersettings"));
		$select->fields("a.name,b.sex,b.dateofbirth,b.country,b.alternate_email");
		$select->where("a.id=? and a.username=? and a.password=? and a.status=? and a.id=b.userid",array($userid,$uname,$pwd,1));
		$result=$select->query();//echo $select->getQuery();
		$this->setLoopValue("profile",$result->getResult());
		$rs=$select->fetchRow($result);
		$num=$select->numRows($result);
		$dob=date("d/n/Y",$rs[2]);
		$dob1=explode("/",$dob);
		$day=$dob1[0];$mnth=$dob1[1];$year=$dob1[2];
		$this->setValue("dd",$day);$this->setValue("mn",$mnth);$this->setValue("yr123",$year);

		$male=$this->getmessage(137);$female=$this->getmessage(138);
		$this->setValue("male",$male);$this->setValue("female",$female);
		$year=date("Y",time());
		for($i=$year,$j=0;$i>=1900;$i--,$j++)
		{
			$yr[$j][0]=$i;
		}
		$this->setLoopValue("yrs",$yr);
			
		for($i1=01,$j1=0;$i1<=31;$i1++,$j1++)
		{
			if($i1<10)
			$i1="0".$i1;
			$days[$j1][0]=$i1;
		}
		$this->setLoopValue("days",$days);
			
		
		$select->select("nesote_email_country");
		$select->fields("name");
		$select->order("name asc");
		$result=$select->query();
		$this->setLoopValue("country",$result->getResult());

		
		if($_POST)
		{



			$userid=$this->getId();$flag=1;$msg="";
$loginemail=$this->getmailid($userid);
			$name=trim($_POST['name']);
		   if($name=="")
			{
				$flag=0;
				if($msg=="")
				$msg=$this->getmessage(669);
			}
			
//			if($fname=="")
//			{
//				$flag=0;
//				if($msg=="")
//				$msg=$this->getmessage(112);
//			}
//			$lname=trim($_POST['lname']);
//			if($lname=="")
//			{
//				$flag=0;
//				if($msg=="")
//				$msg=$this->getmessage(113);
//			}
			$gender=$_POST['gender'];
			if($gender=="")
			{
				$flag=0;
				if($msg=="")
				$msg=$this->getmessage(127);
			}
			$dd=$_POST['day'];//echo $dd;
			if($dd=="")
			{
				$flag=0;
				if($msg=="")
				$msg=$this->getmessage(128);
			}
			$mn=$_POST['month'];//echo $mn;
			if($mn=="")
			{
				$flag=0;
				if($msg=="")
				$msg=$this->getmessage(129);
			}
			$yr=$_POST['year'];//echo $yr;
			if($yr=="")
			{
				$flag=0;
				if($msg=="")
				$msg=$this->getmessage(130);
			}

			$country=$_POST['country'];//echo $country;
			if($country=="")
			{
				$flag=0;
				if($msg=="")
				$msg=$this->getmessage(131);
			}
			$alternamteemail=$_POST['alternatemail'];

			if($alternamteemail!="")
			{
				$rslt=$this->isValid($alternamteemail);
				if($rslt=="true")
				{
					$flag=1;
				}
				else
				{
					$flag=0;
					if($msg=="")
					$msg=$this->getmessage(159);
				}
			}

				if($alternamteemail==$loginemail)
			{
					$flag=0;
					if($msg=="")
					$msg=$this->getmessage(785);
				
			}

			$uname=$_COOKIE['e_username'];
			$pwd=$_COOKIE['e_password'];
			if($flag==1)
			{

				if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
				{

					$msg=$this->getmessage(340);
					header("Location:".$this->url("mail/editprofile/$msg"));
					exit(0);
				}


				if($mn<10)
				$mn=$mm="0".$mn;
				$dob=mktime(0,0,0,$mn,$dd,$yr);//echo "$dob,$mm,$dd,$yr";exit;

				
				$select->update("nesote_inoutscripts_users");
				$select->set("name=?",array($name));
				$select->where("id=? and username=? and password=? and status=?",array($userid,$uname,$pwd,1));
				$select->query();//echo $db->getQuery();exit;
				$select->update("nesote_email_usersettings");
				$select->set("sex=?,dateofbirth=?,country=?,alternate_email=?",array($gender,$dob,$country,$alternamteemail));
				$select->where("userid=?",array($userid));
				$select->query();//echo $select->getQuery();exit;


				$username=$this->getusername($userid);
				$this->saveLogs("Edit Profile","$username has updated his/her profile");

				$msg="success";//$this->getmessage(362);
			}

			header("Location:".$this->url("mail/editprofile/$msg"));
			exit(0);
		}
	}

	function getmailid($id)
	{


		$db=new NesoteDALController();
		$db->select("nesote_email_settings");
		$db->fields("value");
		$db->where("name='emailextension'");
		$result=$db->query();
		$row=$db->fetchRow($result);
		if(stristr(trim($row[0]),"@")!="")
		$emailextension=trim($row[0]);
		else
		$emailextension="@".trim($row[0]);

		
		$db->select("nesote_inoutscripts_users");
		$db->fields("username");
		$db->where("id=?", array($id));
		$result=$db->query();
		$rs=$db->fetchRow($result);

		return $rs[0].$emailextension;

	}

	function isValid($email)
	{
	    $regex = '/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		$result ="true";$msg="";$false="false";
		if(!preg_match($regex,$email))
		//if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,}$/i", $email))
		{
			$msg=$this->getmessage(159);
			$result =$msg."/".$false;
		}
		;
		return $result;
	}

    /////////anna/////////

};
?>
