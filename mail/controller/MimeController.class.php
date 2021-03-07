<?php

class MimeController extends NesoteController
{
	function getmailAction()
	{ 
//echo "aaaa";exit;
	    //echo $d=$this->srtautoreply('yes');exit;
		
		$username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);
		
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$userid=$this->getId();
		require_once 'class/mimeDecode.php';

		require_once 'class/POP3.php';
		$pop3 = new Net_POP3();

		$db=new NesoteDALController();

		$strServerName=$settings->getValue("pop3_servername");
		$strServerName=$settings->getValue("domain_ip");
		$pop3->connect($strServerName);


		$catchall=$settings->getValue("catchall_mail");

		if($catchall==1)
		{

			$useremail=$settings->getValue("pop3_serveremail");


			$userpassword=$settings->getValue("pop3_serverpassword");
			
		}

		else
		{
			$username=$_COOKIE['e_username'];

			$extention=$settings->getValue("emailextension");
			$first=substr($extention,0,1);
			if($first!="@")
			{
				$extention="@".$extention;
			}
			$useremail=$username.$extention;
			$db->select("nesote_email_usersettings");
			$db->fields("server_password");
			$db->where("userid=?",array($userid));
			$res1=$db->query();
			$row=$db->fetchRow($res1);
			$userpassword=base64_decode($row[0]);
		}
   //echo  $useremail."+".$userpassword;exit;
     $cron=$this->getParam(2);
$pop3->login($useremail,$userpassword);
		$t123=time();set_time_limit(0);
		while(time()-$t123<=30)
		{
		   
		$listing = $pop3->getListing();
//print_r($listing);exit;

		$i=0;

		$totalmail=count($listing);
		if($totalmail!=0 || $cron==1)
		
		break;
		else
		usleep(2000000);
		}
     $totalmail=count($listing);
     if($totalmail==0)
     {      
    echo  $returnString.="0/0/0/0"; exit;
     }
     $userid=$this->getId();
     $inbox=0;$spam=0;$trash=0;
     $db->select("nesote_email_customfolder");
     $db->fields("id");
     $db->where("userid=?",$userid);
     $resu=$db->query();$x=0;
     while($resul=$db->fetchRow($resu))
     {
     	$custom[$x][0]=$resul[0];$custom[$x][1]=0;
     	$x++;
     }
     
     
		$resultString="";
		if($catchall==0)
		{
			foreach($listing as $msg)
			{ 

				$i++;
				if($i<=$totalmail)
				$mail=$msg['msg_id'];

					
				$headers = $pop3->getParsedHeaders($msg['msg_id']);
              
				$To=$headers[To];
				
                            //Coded Additional for Encoded Word Decoding

                              $To=$this->getDecodedSubject($To);
                               $To=str_replace("\"","",$To);
				$To=str_replace("'","",$To);
                                preg_match('/<(.+?)>/i',$To,$toid);
				if($toid[1]=="")
				preg_match('/&lt;(.+?)&gt;/i',$To,$toid);
				if($toid[1]=="")
				preg_match('/&amp;&lt;(.+?)&amp;&gt;/i',$To,$toid);
				if($toid[1]=="")
				$toid[1]=$To;
                                  
                                  $To=$toid[1];
                                 //Ends

                                       
				$Cc=$headers[Cc];
				$Cc=str_replace("\"","",$Cc);
				$Cc=str_replace("'","",$Cc);

				$Bcc=$headers[Bcc];
				$Bcc=str_replace("\"","",$Bcc);
				$Bcc=str_replace("'","",$Bcc);



				$subjekt=$headers[Subject];
				$Subject=$this->getDecodedSubject($subjekt);



				$Subject=str_replace("<","< ",$Subject);
				$From=$this->getDecodedSubject($headers[From]);
				$From=str_replace("\"","",$From);
				$From=str_replace("'","",$From);

				$headertime=$headers[Date];

					

				$gmt=$headertime;
				$gmtt=explode(":",$gmt);

				$gmtt= trim(substr($gmtt[2],2));

				$add=$gmtt[0];
				$h1=$gmtt[1];
				$h2=$gmtt[2];
				$m1=$gmtt[3];
				$m2=$gmtt[4];

				$H=$h1.$h2;
				$M=$m1.$m2;
				$diff=($H*60*60)+($M*60);
				if($add=="+")
				$diff=-$diff;
				if($add=="-")
				$diff=$diff;



				$htime=$headertime;
				$htimearray=explode(",",$htime);

				$Tday=trim($htimearray[0]); 
				if($htimearray[1]=="")
                 $htimear=trim($htimearray[0]);
                 else
				$htimear=trim($htimearray[1]);
				$hTimearry=explode(" ",$htimear);

				$hTimeArry=explode(":",$hTimearry[3]);

				$hour=$hTimeArry[0];
				$minute=$hTimeArry[1];
				$second=$hTimeArry[2];
				$day=$hTimearry[0];
				$month=$hTimearry[1];
				$year=$hTimearry[2];

				if(strtolower($month)=="jan")
				$month=1;
				if(strtolower($month)=="feb")
				$month=2;
				if(strtolower($month)=="mar")
				$month=3;
				if(strtolower($month)=="apr")
				$month=4;
				if(strtolower($month)=="may")
				$month=5;
				if(strtolower($month)=="jun")
				$month=6;
				if(strtolower($month)=="jul")
				$month=7;
				if(strtolower($month)=="aug")
				$month=8;
				if(strtolower($month)=="sep")
				$month=9;
				if(strtolower($month)=="oct")
				$month=10;
				if(strtolower($month)=="nov")
				$month=11;
				if(strtolower($month)=="dec")
				$month=12;
					
					
				$time=mktime($hour,$minute,$second,$month,$day,$year);

				$time=$time+$diff;



				$userid=$this->getId();
				$db->select("nesote_email_usersettings");
				$db->fields("autoreply_flag");
				$db->where("userid=? ",array($userid));
				$result=$db->query();
				$row=$db->fetchRow($result);
				$autoreply_flag= $row[0];
				
				if($autoreply_flag==1)
					$this->autoreply($headers,$Subject);

				$Received=$headers[Received];




				preg_match('/<(.+?)>/i',$From,$fromid);
				if($fromid[1]=="")
				preg_match('/&lt;(.+?)&gt;/i',$From,$fromid);
				if($fromid[1]=="")
				preg_match('/&amp;&lt;(.+?)&amp;&gt;/i',$From,$fromid);
				if($fromid[1]=="")
				$fromid[1]=$From;
				$userid=$this->getId();

				$input=$pop3->getMsg($mail);
				//echo $input;exit;
				$xml=$this->getxml($input);

				$html=$this->getHtmltags($xml);
				//echo $html;exit;//testcustteam
                                 //echo $html;exit;//testcustteam
			//echo "bb";exit;
                            

                              $folderid=$this->getfolderid($xml,$Subject,$fromid[1],$Received[0],$userid);
					
				$message_id=$this->getmessageid($xml);
				$reply_to=	$this->getconversation($xml);
				$reply_to=html_entity_decode($reply_to);


					
					
				$db->select("nesote_email_usersettings");
				$db->fields("forward_flag");
				$db->where("userid=? ",array($userid));
				$result=$db->query();
				$row=$db->fetchRow($result);
				$forward_flag= $row[0];


				
				if($folderid==1)
				{//echo "inboxxx";

					$db->select("nesote_email_sent_$tablenumber");
					$db->fields("mail_references");
					$db->where("userid=? and message_id=? ",array($userid,$reply_to));
					$res1=$db->query();
					$row=$db->fetchRow($res1);
					if($row[0]!="")
					{
						$a=$this->getReferences($row[0],$Subject);
						if($a==1)
						{
							$mail_references=$row[0];

						}
						else
						{

							$db->select("nesote_email_inbox_$tablenumber");
							$db->fields("mail_references");
							$db->where("userid=? and message_id=?",array($userid,$reply_to));
							$res1=$db->query();
							$row11=$db->fetchRow($res1);
							if($row11[0]!="")
							$a=$this->getReferences($row11[0],$Subject);
							if($a==1)
							{
								$mail_references=$row11[0];

							}

						}
					}
					else
					{
						$db->select("nesote_email_inbox_$tablenumber");
						$db->fields("mail_references");
						$db->where("userid=? and message_id=?",array($userid,$reply_to));
						$res1=$db->query();
						$row11=$db->fetchRow($res1);
						if($row11[0]!="")
						$a=$this->getReferences($row11[0],$Subject);
						if($a==1)
						{
							$mail_references=$row11[0];

						}
						else
						{
							$mail_references="";
						}
					}

					
					$db->insert("nesote_email_inbox_$tablenumber");
					$db->fields("userid,from_list,to_list,cc,subject,body,time");
					$db->values(array($userid,$From,$To,$Cc,$Subject,$html,$time));
					$res=$db->query();//echo $db->getQuery();
                     $inbox=$inbox+1; 

				


					$id=$db->lastInsertid("nesote_email_inbox_$tablenumber");
					$refrnce1="inbox:";
					$refrnce2=":";
					if($mail_references=="")
					{
						$mail_references="<references><item><mailid>$id</mailid><folderid>1</folderid></item></references>";
					}
					else
					{
						preg_match_all('/<folderid>(.+?)<\/folderid>/i',$mail_references,$folderArray);
						preg_match_all('/<mailid>(.+?)<\/mailid>/i',$mail_references,$mailidArray);

						for($j=(count($folderArray)-1);$j>=0;$j--)
						{
							if($folderArray[1][count($folderArray[1])-1]==3)
							{
								$refrnce2="sent:".$mailidArray[1][count($folderArra[1])-1];
							}
							else
							{
								$refrnce1="inbox:".$mailidArray[1][count($folderArray[1])-1];
							}

						}
							

						$references="<item><mailid>$id</mailid><folderid>1</folderid></item></references>";
						$mail_references=str_replace("</references>",$references,$mail_references);
					}
$md5_references=md5($mail_references);
					
					$db->update("nesote_email_inbox_$tablenumber");
					$db->set("mail_references=?,md5_references=?,message_id=?",array($mail_references,$md5_references,$message_id));
					$db->where("id=?",array($id));
					$rs=$db->query();
					$this->update_conversation($mail_references);
					$username=$this->getusername($userid);
					$this->saveLogs("Recieved mail",$username." had recieved a mail");
				}
				elseif($folderid==4)
				{
					$db->select("nesote_email_sent_$tablenumber");
					$db->fields("mail_references");
					$db->where("userid=? and message_id=? ",array($userid,$reply_to));
					$res1=$db->query();//echo $db->getQuery();
					$row=$db->fetchRow($res1);
					if($row[0]!="")
					{
						$a=$this->getReferences($row[0],$Subject);
						if($a==1)
						{
							$mail_references=$row[0];

						}
						else
						{

							$db->select("nesote_email_spam_$tablenumber");
							$db->fields("mail_references");
							$db->where("userid=? and message_id=?",array($userid,$reply_to));
							$res1=$db->query();//echo $db->getQuery();
							$row11=$db->fetchRow($res1);
							if($row11[0]!="")
							$a=$this->getReferences($row11[0],$Subject);
							if($a==1)
							{
								$mail_references=$row11[0];

							}

						}
					}
					else
					{
						$db->select("nesote_email_spam_$tablenumber");
						$db->fields("mail_references");
						$db->where("userid=? and message_id=?",array($userid,$reply_to));
						$res1=$db->query();//echo $db->getQuery();
						$row11=$db->fetchRow($res1);
						if($row11[0]!="")
						$a=$this->getReferences($row11[0],$Subject);
						if($a==1)
						{
							$mail_references=$row11[0];

						}
						else
						{
							$mail_references="";
						}
					}

					$db->insert("nesote_email_spam_$tablenumber");
					$db->fields("userid,from_list,to_list,cc,subject,body,time,backreference");
					$db->values(array($userid,$From,$To,$Cc,$Subject,$html,$time,1));
					$res=$db->query();
					$spam=$spam+1;


					$id=$db->lastInsertid("nesote_email_spam_$tablenumber");
					$refrnce1="spam:";
					$refrnce2=":";
					if($mail_references=="")
					{
						$mail_references="<references><item><mailid>$id</mailid><folderid>4</folderid></item></references>";
					}
					else
					{
						preg_match_all('/<folderid>(.+?)<\/folderid>/i',$mail_references,$folderArray);
						preg_match_all('/<mailid>(.+?)<\/mailid>/i',$mail_references,$mailidArray);
						for($j=(count($folderArray)-1);$j>=0;$j--)
						{
							if($folderArray[$j][0]==3)
							{
								$refrnce2="sent:".$mailidArray[$j][0];
							}
							else
							{
								$refrnce1="spam:".$mailidArray[$j][0];
							}
						}
						$references="<item><mailid>$id</mailid><folderid>4</folderid></item></references>";
						$mail_references=str_replace("</references>",$references,$mail_references);
					}
$md5_references=md5($mail_references); 
					
					$db->update("nesote_email_spam_$tablenumber");
					$db->set("mail_references=?,md5_references=?,message_id=?",array($mail_references,$md5_references,$message_id));
					$db->where("id=?",array($id));
					$rs=$db->query();
					$this->update_conversation($mail_references);
					$username=$this->getusername($userid);
					$this->saveLogs("Recieved mail",$username." had recieved a mail");
				}

				elseif($folderid==5)
				{
					$db->select("nesote_email_sent_$tablenumber");
					$db->fields("mail_references");
					$db->where("userid=? and message_id=? ",array($userid,$reply_to));
					$res1=$db->query();//echo $db->getQuery();
					$row=$db->fetchRow($res1);
					if($row[0]!="")
					{
						$a=$this->getReferences($row[0],$Subject);
						if($a==1)
						{
							$mail_references=$row[0];

						}
						else
						{

							$db->select("nesote_email_trash_$tablenumber");
							$db->fields("mail_references");
							$db->where("userid=? and message_id=?",array($userid,$reply_to));
							$res1=$db->query();//echo $db->getQuery();
							$row11=$db->fetchRow($res1);
							if($row11[0]!="")
							$a=$this->getReferences($row11[0],$Subject);
							if($a==1)
							{
								$mail_references=$row11[0];

							}

						}
					}
					else
					{
						$db->select("nesote_email_trash_$tablenumber");
						$db->fields("mail_references");
						$db->where("userid=? and message_id=?",array($userid,$reply_to));
						$res1=$db->query();//echo $db->getQuery();
						$row11=$db->fetchRow($res1);
						if($row11[0]!="")
						$a=$this->getReferences($row11[0],$Subject);
						if($a==1)
						{
							$mail_references=$row11[0];

						}
						else
						{
							$mail_references="";
						}
					}

					$db->insert("nesote_email_trash_$tablenumber");
					$db->fields("userid,from_list,to_list,cc,subject,body,time,backreference");
					$db->values(array($userid,$From,$To,$Cc,$Subject,$html,$time,1));
					$res=$db->query();
                    $trash=$trash+1;

					$id=$db->lastInsertid("nesote_email_trash_$tablenumber");
					$refrnce1="trash:";
					$refrnce2=":";
					if($mail_references=="")
					{
						$mail_references="<references><item><mailid>$id</mailid><folderid>5</folderid></item></references>";
					}
					else
					{
						for($j=(count($folderArray)-1);$j>=0;$j--)
						{
							if($folderArray[$j][0]==5)
							{
								$refrnce2="trash:".$mailidArray[$j][0];
							}

						}
						$references="<item><mailid>$id</mailid><folderid>5</folderid></item></references>";
						$mail_references=str_replace("</references>",$references,$mail_references);
					}
$md5_references=md5($mail_references);
					
					$db->update("nesote_email_trash_$tablenumber");
					$db->set("mail_references=?,md5_references=?,message_id=?",array($mail_references,$md5_references,$message_id));
					$db->where("id=?",array($id));
					$rs=$db->query();
					$this->update_conversation($mail_references);
					$username=$this->getusername($userid);
					$this->saveLogs("Recieved mail",$username." had recieved a mail");
				}

				elseif($folderid>=10)
				{
					$db->select("nesote_email_sent_$tablenumber");
					$db->fields("mail_references");
					$db->where("userid=? and message_id=? ",array($userid,$reply_to));
					$res1=$db->query();//echo $db->getQuery();
					$row=$db->fetchRow($res1);
					if($row[0]!="")
					{
						$a=$this->getReferences($row[0],$Subject);
						if($a==1)
						{
							$mail_references=$row[0];

						}
						else
						{

							$db->select("nesote_email_customfolder_mapping_$tablenumber");
							$db->fields("mail_references");
							$db->where("folderid=? and message_id=?",array($folderid,$reply_to));
							$res1=$db->query();//echo $db->getQuery();
							$row11=$db->fetchRow($res1);
							if($row11[0]!="")
							$a=$this->getReferences($row11[0],$Subject);
							if($a==1)
							{
								$mail_references=$row11[0];

							}

						}
					}
					else
					{
						$db->select("nesote_email_customfolder_mapping_$tablenumber");
						$db->fields("mail_references");
						$db->where("folderid=? and message_id=?",array($folderid,$reply_to));
						$res1=$db->query();//echo $db->getQuery();
						$row11=$db->fetchRow($res1);
						if($row11[0]!="")
						$a=$this->getReferences($row11[0],$Subject);
						if($a==1)
						{
							$mail_references=$row11[0];

						}
						else
						{
							$mail_references="";
						}
					}

					$db->select("nesote_email_customfolder");
					$db->fields("id");
					$db->where("userid=?",array($userid));
					$res1=$db->query();
					$db->insert("nesote_email_customfolder_mapping_$tablenumber");
					$db->fields("folderid,from_list,to_list,cc,subject,body,time");
					$db->values(array($folderid,$From,$To,$Cc,$Subject,$html,$time));
					$res=$db->query();
					//$custom.$folderid=1;
					for($q=0;$q<count($custom);$q++)
					{
						if($folderid==$custom[$q][0])
						$custom[$q][1]=$custom[$q][1]+1;
					}

				$id=$db->lastInsertid("nesote_email_customfolder_mapping_$tablenumber");
					$refrnce1="custom".$folderid.":";
					$refrnce2=":";
					if($mail_references=="")
					{
						$mail_references="<references><item><mailid>$id</mailid><folderid>$folderid</folderid></item></references>";
					}
					else
					{
						preg_match_all('/<folderid>(.+?)<\/folderid>/i',$mail_references,$folderArray);
						preg_match_all('/<mailid>(.+?)<\/mailid>/i',$mail_references,$mailidArray);
						for($j=(count($folderArray)-1);$j>=0;$j--)
						{
							if($folderArray[$j][0]==3)
							{
								$refrnce2="sent:".$mailidArray[$j][0];
							}
							else
							{
								$refrnce1="custom".$folderid.":".$mailidArray[$j][0];
							}
						}
						$references="<item><mailid>$id</mailid><folderid>$folderid</folderid></item></references>";
						$mail_references=str_replace("</references>",$references,$mail_references);
					}
$md5_references=md5($mail_references);
					
					$db->update("nesote_email_customfolder_mapping_$tablenumber");
					$db->set("mail_references=?,md5_references=?,message_id=?",array($mail_references,$md5_references,$message_id));
					$db->where("id=?",array($id));
					$rs=$db->query();
					$this->update_conversation($mail_references);
					$username=$this->getusername($userid);
					$this->saveLogs("Recieved mail",$username." had recieved a mail");
				}


				$refrnce1=str_replace("<mailid>","",$refrnce1);
				$refrnce1=str_replace("</mailid>","",$refrnce1);
				$refrnce2=str_replace("<mailid>","",$refrnce2);
				$refrnce2=str_replace("</mailid>","",$refrnce2);
				$htmlcontent=$this->insrt($xml,$id,$folderid);
				$attach=$this->getattachcount($mail_references);
				$starr=$this->getstar($mail_references);
				$timez=$this->gettime($time);
				$contnt=$this->substringMail($html);
				$Subject=$this->substringMail($Subject);
				$foldername=$this->getfoldername($folderid);
				preg_match_all('/<folderid>(.+?)<\/folderid>/i',$mail_references,$folderArray_last);
				$no_cnvr=count($folderArray[1])+1;
				//$resultString.=$refrnce1."{nesote:_ref}".$refrnce2."{nesote:_boundary}".$id."{nesote_;,}".$From."{nesote_;,}".$To."{nesote_;,}".$Cc."{nesote_;,}{nesote_;,}".$Subject."{nesote_;,}".$contnt."{nesote_;,}0{nesote_;,}".$starr."{nesote_;,}".$timez."{nesote_;,}".$attach."{nesote_;,}".$time."{nesote_;,}".$foldername."{nesote_;,}".$no_cnvr."{nesote_separetor}";
               


				$pop3->deleteMsg($mail);
			}

			$pop3->disconnect();
            $cus_string="";
               for($q=0;$q<count($custom);$q++)
                      {
                            if($custom[$q][1]>0)
                                {
                                      $cus_string.=$custom[$q][0]."@@".$custom[$q][1];
                                       $cus_string.="{**}";
                                   }
                       }
              $cus_string=substr($cus_string,0,-4);
                       
  $returnString.=$inbox."/".$spam."/".$trash."/".$cus_string;
			//$resultString=substr($resultString,0,-18);
			echo $returnString;exit(0);
		}
		else
		{
			
			foreach($listing as $msg)
			{
				
				$i++;
				if($i<=$totalmail)
				$mail=$msg['msg_id'];
				$username=$_COOKIE['e_username'];
				$db->select("nesote_email_settings");
				$db->fields("value");
				$db->where("name=?",array("emailextension"));
				$res1=$db->query();
				$row=$db->fetchRow($res1);
				$extentionz=trim($row[0]);
				if($extentionz[0]=="@")
				{
					$full_id=$username.$extentionz;
					$extentionz=substr($extentionz,1);
				}
				else
				{
					$full_id=$username."@".$extentionz;
				}
				
				$headers = $pop3->getParsedHeaders($msg['msg_id']);
				

				$To=$headers[To];
				$To=str_replace("\"","",$To);
				$To=str_replace("'","",$To);

				$To=htmlentities($To,0,"UTF-8");
				$To=trim($To);
				$len=strlen($To);
				if($To[($len-1)]==",")
				$To=substr($To,0,-1);
				$to_list=explode(",",$To);
				$ids="";
				for($b=0;$b<count($to_list);$b++)
				{
					$idz=="";
					preg_match('/<(.+?)>/i',$to_list[$b],$idz);
					if(count($idz[1])==0)
					{
						preg_match('/&lt;(.+?)&gt;/i',$to_list[$b],$idz);
					}
					if(count($idz[1])!=0)
					{
						$extn=explode("@",$idz[1]);
					}
					else
					{
						$extn=explode("@",$to_list[$b]);
					}
					
					if($extentionz==$extn[1])
					{
						$db->select("nesote_inoutscripts_users");
						$db->fields("id");
						$db->where("username=? ",array(trim($extn[0])));
						$res1=$db->query();//echo $db->getQuery();
						$row=$db->fetchRow($res1);
						$ids.=$row[0].",";
						
					}
				}
				$Cc=$headers[Cc];
				$Cc=str_replace("\"","",$Cc);
				$Cc=str_replace("'","",$Cc);
				$Cc=htmlentities($Cc,ENT_QUOTES,"UTF-8");
					
				$Cc=trim($Cc);
				$len=strlen($Cc);
				if($Cc[($len-1)]==",")
				$Cc=substr($Cc,0,-1);
				$cc_list=explode(",",$Cc);
				for($b=0;$b<count($cc_list);$b++)
				{
					$idz=="";
					preg_match('/<(.+?)>/i',$cc_list[$b],$idz);
					if(count($idz[1])==0)
					{
						preg_match('/&lt;(.+?)&gt;/i',$cc_list[$b],$idz);
					}
					if(count($idz[1])!=0)
					{
						$extn=explode("@",$idz[1]);
					}
					else
					{
						$extn=explode("@",$cc_list[$b]);
					}
					if($extentionz==$extn[1])
					{
						$db->select("nesote_inoutscripts_users");
						$db->fields("id");
						$db->where("username=? ",array(trim($extn[0])));
						$res1=$db->query();
						$row=$db->fetchRow($res1);
						$ids.=$row[0].",";
						
					}
				}
					
				$Bcc=$headers[Bcc];
				$Bcc=str_replace("\"","",$Bcc);
				$Bcc=str_replace("'","",$Bcc);
				$Bcc=htmlentities($Bcc,0,"UTF-8");
					
				$Bcc=trim($Bcc);
				$len=strlen($Bcc);
				if($Bcc[($len-1)]==",")
				$Bcc=substr($Bcc,0,-1);
				$bcc_list=explode(",",$Bcc);
				for($b=0;$b<count($bcc_list);$b++)
				{
					$idz=="";
					preg_match('/<(.+?)>/i',$bcc_list[$b],$idz);
					if(count($idz[1])==0)
					{
						preg_match('/&lt;(.+?)&gt;/i',$bcc_list[$b],$idz);
					}
					if(count($idz[1])!=0)
					{
						$extn=explode("@",$idz[1]);
					}
					else
					{
						$extn=explode("@",$bcc_list[$b]);
					}
					if($extentionz==$extn[1])
					{
						$db->select("nesote_inoutscripts_users");
						$db->fields("id");
						$db->where("username=? ",array(trim($extn[0])));
						$res1=$db->query();
						$row=$db->fetchRow($res1);
						$ids.=$row[0].",";
						
					}
				}
				while(1==1)
				{
					$lngth=strlen($ids);
					if($ids[($lngth-1)]==",")
					{
						$ids=substr($ids,0,-1);
					}
					else
					break;
				}
				
				$userids=explode(",",$ids);
				for($c=0;$c<count($userids);$c++)
				{
					$db->select("nesote_inoutscripts_users");
					$db->fields("username");
					$db->where("id=? ",array($userids[$c]));
					$res1=$db->query();
					$row=$db->fetchRow($res1);
					$username=$row[0];
					$subjekt=$headers[Subject];
					$Subject=$this->getDecodedSubject($subjekt);
					$From=$headers[From];
					$From=str_replace("\"","",$From);
					$From=str_replace("'","",$From);
					$From=htmlentities($From,ENT_QUOTES,"UTF-8");
					$headertime=$headers[Date];
					$gmt=$headertime;
					$gmtt=explode(":",$gmt);
					$gmtt= trim(substr($gmtt[2],2));

					$add=$gmtt[0];
					$h1=$gmtt[1];
					$h2=$gmtt[2];
					$m1=$gmtt[3];
					$m2=$gmtt[4];
					$H=$h1.$h2;
					$M=$m1.$m2;
					$diff=($H*60*60)+($M*60);
					if($add=="+")
					$diff=-$diff;
					if($add=="-")
					$diff=$diff;

					$timearray1=date_parse($headertime);
					$hour=$timearray1['hour'];
					$minute=$timearray1['minute'];
					$second=$timearray1['second'];
					$day=$timearray1['day'];
					$month=$timearray1['month'];
					$year=$timearray1['year'];
					$time=mktime($hour,$minute,$second,$month,$day,$year);

					$time=$time+$diff;
					
					$userid=$this->getId();
					$db->select("nesote_email_usersettings");
					$db->fields("autoreply_flag");
					$db->where("userid=? ",array($userids[$c]));
					$result=$db->query();//echo $db->getQuery();
					$row=$db->fetchRow($result);
					$autoreply_flag= $row[0];

					if($autoreply_flag==1)
					$this->autoreply($headers,$Subject);
					$Received=$headers[Received];


					

					preg_match('/<(.+?)>/i',$From,$fromid);
					if($fromid[1]=="")
					preg_match('/&lt;(.+?)&gt;/i',$From,$fromid);
					if($fromid[1]=="")
					preg_match('/&amp;&lt;(.+?)&amp;&gt;/i',$From,$fromid);
					$userid=$userids[$c];
					
					$input=$pop3->getMsg($mail);
					$xml=$this->getxml($input);
					$html=$this->getHtmltags($xml);
					$html=iconv_mime_decode("$html", 0, "utf-8");
					$folderid=$this->getfolderid($xml,$Subject,$fromid[1],$Received[0],$userid);
					
					$message_id=$this->getmessageid($xml);
					$reply_to=	$this->getconversation($xml);
					$reply_to=html_entity_decode($reply_to);
					
					
					if($folderid==1)
					{


						$db->select("nesote_email_sent_$tablenumber");
						$db->fields("mail_references");
						$db->where("userid=? and message_id=? ",array($userid,$reply_to));
						$res1=$db->query();//echo $db->getQuery();
						$row=$db->fetchRow($res1);
						if($row[0]!="")
						{
							$a=$this->getReferences($row[0],$Subject);
							if($a==1)
							{
								$mail_references=$row[0];

							}
							else
							{
									
								$db->select("nesote_email_inbox_$tablenumber");
								$db->fields("mail_references");
								$db->where("userid=? and message_id=?",array($userid,$reply_to));
								$res1=$db->query();//echo $db->getQuery();
								$row11=$db->fetchRow($res1);
								if($row11[0]!="")
								$a=$this->getReferences($row11[0],$Subject);
								if($a==1)
								{
									$mail_references=$row11[0];

								}
									
							}
						}
						else
						{
							$db->select("nesote_email_inbox_$tablenumber");
							$db->fields("mail_references");
							$db->where("userid=? and message_id=?",array($userid,$reply_to));
							$res1=$db->query();//echo $db->getQuery();
							$row11=$db->fetchRow($res1);
							if($row11[0]!="")
							$a=$this->getReferences($row11[0],$Subject);
							if($a==1)
							{
								$mail_references=$row11[0];

							}
							else
							{
								$mail_references="";
							}
						}

						
						$db->insert("nesote_email_inbox_$tablenumber");
						$db->fields("userid,from_list,to_list,cc,subject,body,time");
						$db->values(array($userid,$From,$To,$Cc,$Subject,$html,$time));
						$res=$db->query();//echo $db->getQuery();
							$inbox=$inbox+1;

						$id=$db->lastInsertid("nesote_email_inbox_$tablenumber");
						$refrnce1="inbox:";
						$refrnce2=":";
						if($mail_references=="")
						{
							$mail_references="<references><item><mailid>$id</mailid><folderid>1</folderid></item></references>";
						}
						else
						{
							preg_match_all('/<folderid>(.+?)<\/folderid>/i',$mail_references,$folderArray);
							preg_match_all('/<mailid>(.+?)<\/mailid>/i',$mail_references,$mailidArray);
							//print_r($mailidArray);echo count($folderArray[1])-1;
							for($j=(count($folderArray)-1);$j>=0;$j--)
							{
								if($folderArray[1][count($folderArray[1])-1]==3)
								{
									$refrnce2="sent:".$mailidArray[1][count($folderArra[1])-1];
								}
								else
								{
								 $refrnce1="inbox:".$mailidArray[1][count($folderArray[1])-1];
								}
									
							}


							$references="<item><mailid>$id</mailid><folderid>1</folderid></item></references>";
							$mail_references=str_replace("</references>",$references,$mail_references);
						}
$md5_references=md5($mail_references);

						
						$db->update("nesote_email_inbox_$tablenumber");
						$db->set("mail_references=?,md5_references=?,message_id=?",array($mail_references,$md5_references,$message_id));
						$db->where("id=?",array($id));
						$rs=$db->query();
						$this->update_conversation($mail_references);
						$username=$this->getusername($userid);
						$this->saveLogs("Recieved mail",$username." had recieved a mail");
					}
					elseif($folderid==4)
					{
						$db->select("nesote_email_sent_$tablenumber");
						$db->fields("mail_references");
						$db->where("userid=? and message_id=? ",array($userid,$reply_to));
						$res1=$db->query();//echo $db->getQuery();
						$row=$db->fetchRow($res1);
						if($row[0]!="")
						{
							$a=$this->getReferences($row[0],$Subject);
							if($a==1)
							{
								$mail_references=$row[0];

							}
							else
							{
									
								$db->select("nesote_email_spam_$tablenumber");
								$db->fields("mail_references");
								$db->where("userid=? and message_id=?",array($userid,$reply_to));
								$res1=$db->query();//echo $db->getQuery();
								$row11=$db->fetchRow($res1);
								if($row11[0]!="")
								$a=$this->getReferences($row11[0],$Subject);
								if($a==1)
								{
									$mail_references=$row11[0];

								}
									
							}
						}
						else
						{
							$db->select("nesote_email_spam_$tablenumber");
							$db->fields("mail_references");
							$db->where("userid=? and message_id=?",array($userid,$reply_to));
							$res1=$db->query();//echo $db->getQuery();
							$row11=$db->fetchRow($res1);
							if($row11[0]!="")
							$a=$this->getReferences($row11[0],$Subject);
							if($a==1)
							{
								$mail_references=$row11[0];

							}
							else
							{
								$mail_references="";
							}
						}

						$db->insert("nesote_email_spam_$tablenumber");
						$db->fields("userid,from_list,to_list,cc,subject,body,time");
						$db->values(array($userid,$From,$To,$Cc,$Subject,$html,$time));
						$res=$db->query();//echo $db->getQuery();
							$spam=$spam+1;

						$id=$db->lastInsertid("nesote_email_spam_$tablenumber");
						$refrnce1="spam:";
						$refrnce2=":";
						if($mail_references=="")
						{
							$mail_references="<references><item><mailid>$id</mailid><folderid>4</folderid></item></references>";
						}
						else
						{
							preg_match_all('/<folderid>(.+?)<\/folderid>/i',$mail_references,$folderArray);
							preg_match_all('/<mailid>(.+?)<\/mailid>/i',$mail_references,$mailidArray);
							for($j=(count($folderArray)-1);$j>=0;$j--)
							{
								if($folderArray[$j][0]==3)
								{
									$refrnce2="sent:".$mailidArray[$j][0];
								}
								else
								{
									$refrnce1="spam:".$mailidArray[$j][0];
								}
							}
							$references="<item><mailid>$id</mailid><folderid>4</folderid></item></references>";
							$mail_references=str_replace("</references>",$references,$mail_references);
						}
						$md5_references=md5($mail_references);
						$db=new NesoteDALController();
						$db->update("nesote_email_spam_$tablenumber");
							$db->set("mail_references=?,md5_references=?,message_id=?",array($mail_references,$md5_references,$message_id));
					
						$db->where("id=?",array($id));
						$rs=$db->query();
						$this->update_conversation($mail_references);
						$username=$this->getusername($userid);
						$this->saveLogs("Recieved mail",$username." had recieved a mail");
					}

					elseif($folderid==5)
					{
						$db->select("nesote_email_sent_$tablenumber");
						$db->fields("mail_references");
						$db->where("userid=? and message_id=? ",array($userid,$reply_to));
						$res1=$db->query();//echo $db->getQuery();
						$row=$db->fetchRow($res1);
						if($row[0]!="")
						{
							$a=$this->getReferences($row[0],$Subject);
							if($a==1)
							{
								$mail_references=$row[0];

							}
							else
							{
									
								$db->select("nesote_email_trash_$tablenumber");
								$db->fields("mail_references");
								$db->where("userid=? and message_id=?",array($userid,$reply_to));
								$res1=$db->query();//echo $db->getQuery();
								$row11=$db->fetchRow($res1);
								if($row11[0]!="")
								$a=$this->getReferences($row11[0],$Subject);
								if($a==1)
								{
									$mail_references=$row11[0];

								}
									
							}
						}
						else
						{
							$db->select("nesote_email_trash_$tablenumber");
							$db->fields("mail_references");
							$db->where("userid=? and message_id=?",array($userid,$reply_to));
							$res1=$db->query();//echo $db->getQuery();
							$row11=$db->fetchRow($res1);
							if($row11[0]!="")
							$a=$this->getReferences($row11[0],$Subject);
							if($a==1)
							{
								$mail_references=$row11[0];

							}
							else
							{
								$mail_references="";
							}
						}

						$db->insert("nesote_email_trash_$tablenumber");
						$db->fields("userid,from_list,to_list,cc,subject,body,time");
						$db->values(array($userid,$From,$To,$Cc,$Subject,$html,$time));
						$res=$db->query();//echo $db->getQuery();
							$trash=$trash+1;

						$id=$db->lastInsertid("nesote_email_trash_$tablenumber");
						$refrnce1="trash:";
						$refrnce2=":";
						if($mail_references=="")
						{
							$mail_references="<references><item><mailid>$id</mailid><folderid>5</folderid></item></references>";
						}
						else
						{
							for($j=(count($folderArray)-1);$j>=0;$j--)
							{
								if($folderArray[$j][0]==5)
								{
									$refrnce2="trash:".$mailidArray[$j][0];
								}

							}
							$references="<item><mailid>$id</mailid><folderid>5</folderid></item></references>";
							$mail_references=str_replace("</references>",$references,$mail_references);
						}
					$md5_references=md5($mail_references); 
						
						$db->update("nesote_email_trash_$tablenumber");
						$db->set("mail_references=?,md5_references=?,message_id=?",array($mail_references,$md5_references,$message_id));
						$db->where("id=?",array($id));
						$rs=$db->query();
						$this->update_conversation($mail_references);
						$username=$this->getusername($userid);
						$this->saveLogs("Recieved mail",$username." had recieved a mail");
					}

					elseif($folderid>=10)
					{
						$db->select("nesote_email_sent_$tablenumber");
						$db->fields("mail_references");
						$db->where("userid=? and message_id=? ",array($userid,$reply_to));
						$res1=$db->query();//echo $db->getQuery();
						$row=$db->fetchRow($res1);
						if($row[0]!="")
						{
							$a=$this->getReferences($row[0],$Subject);
							if($a==1)
							{
								$mail_references=$row[0];

							}
							else
							{
									
								$db->select("nesote_email_customfolder_mapping_$tablenumber");
								$db->fields("mail_references");
								$db->where("folderid=? and message_id=?",array($folderid,$reply_to));
								$res1=$db->query();//echo $db->getQuery();
								$row11=$db->fetchRow($res1);
								if($row11[0]!="")
								$a=$this->getReferences($row11[0],$Subject);
								if($a==1)
								{
									$mail_references=$row11[0];

								}
									
							}
						}
						else
						{
							$db->select("nesote_email_customfolder_mapping_$tablenumber");
							$db->fields("mail_references");
							$db->where("folderid=? and message_id=?",array($folderid,$reply_to));
							$res1=$db->query();//echo $db->getQuery();
							$row11=$db->fetchRow($res1);
							if($row11[0]!="")
							$a=$this->getReferences($row11[0],$Subject);
							if($a==1)
							{
								$mail_references=$row11[0];

							}
							else
							{
								$mail_references="";
							}
						}

						$db->select("nesote_email_customfolder");
						$db->fields("id");
						$db->where("userid=?",array($userid));
						$res1=$db->query();
						$db->insert("nesote_email_customfolder_mapping_$tablenumber");
						$db->fields("folderid,from_list,to_list,cc,subject,body,time");
						$db->values(array($folderid,$From,$To,$Cc,$Subject,$html,$time));
						$res=$db->query();//echo $db->getQuery();
						for($q=0;$q<count($custom);$q++)
						{
							if($folderid==$custom[$q][0])
							$custom[$q][1]=$custom[$q][1]+1;
						}

						$id=$db->lastInsertid("nesote_email_customfolder_mapping_$tablenumber");
						$refrnce1="custom".$folderid.":";
						$refrnce2=":";
						if($mail_references=="")
						{
							$mail_references="<references><item><mailid>$id</mailid><folderid>$folderid</folderid></item></references>";
						}
						else
						{
							preg_match_all('/<folderid>(.+?)<\/folderid>/i',$mail_references,$folderArray);
							preg_match_all('/<mailid>(.+?)<\/mailid>/i',$mail_references,$mailidArray);
							for($j=(count($folderArray)-1);$j>=0;$j--)
							{
								if($folderArray[$j][0]==3)
								{
									$refrnce2="sent:".$mailidArray[$j][0];
								}
								else
								{
									$refrnce1="custom".$folderid.":".$mailidArray[$j][0];
								}
							}
							$references="<item><mailid>$id</mailid><folderid>$folderid</folderid></item></references>";
							$mail_references=str_replace("</references>",$references,$mail_references);
						}
$md5_references=md5($mail_references);
						
						$db->update("nesote_email_customfolder_mapping_$tablenumber");
						$db->set("mail_references=?,md5_references=?,message_id=?",array($mail_references,$md5_references,$message_id));
						$db->where("id=?",array($id));
						$rs=$db->query();
						$this->update_conversation($mail_references);
						$username=$this->getusername($userid);
						$this->saveLogs("Recieved mail",$username." had recieved a mail");
					}
					$refrnce1=str_replace("<mailid>","",$refrnce1);
					$refrnce1=str_replace("</mailid>","",$refrnce1);
					$refrnce2=str_replace("<mailid>","",$refrnce2);
					$refrnce2=str_replace("</mailid>","",$refrnce2);
					$htmlcontent=$this->insrt($xml,$id,$folderid);
					$attach=$this->getattachcount($mail_references);
					$starr=$this->getstar($mail_references);
					$timez=$this->gettime($time);
					$Subject=$this->substringMail($Subject);
					$contnt=$this->substringMail($html);
					$foldername=$this->getfoldername($folderid);
					preg_match_all('/<folderid>(.+?)<\/folderid>/i',$mail_references,$folderArray_last);
					$no_cnvr=count($folderArray[1])+1;
					//$resultString.=$refrnce1."{nesote:_ref}".$refrnce2."{nesote:_boundary}".$id."{nesote_;,}".$From."{nesote_;,}".$To."{nesote_;,}".$Cc."{nesote_;,}{nesote_;,}".$Subject."{nesote_;,}".$contnt."{nesote_;,}0{nesote_;,}".$starr."{nesote_;,}".$timez."{nesote_;,}".$attach."{nesote_;,}".$time."{nesote_;,}".$foldername."{nesote_;,}".$no_cnvr."{nesote_separetor}";
           
					//preg_match_all('/src=3D"cid:(.+?)">/i',$html,$result1);
					//$replace=$this->getsource($result1,$xml);
					$pop3->deleteMsg($mail);
				}//exit;



				$db->select("nesote_email_usersettings");
				$db->fields("forward_flag");
				$db->where("userid=? ",array($userid));
				$result=$db->query();
				$row=$db->fetchRow($result);
				$forward_flag= $row[0];//echo $html;exit;
				if($forward_flag==1)
				$this->autoforwarding($folderid,$id);
				//$this->autoforwarding($htmlcontent,$headers);

			}

			$pop3->disconnect();
            $cus_string="";
               for($q=0;$q<count($custom);$q++)
                      {
                            if($custom[$q][1]>0)
                                {
                                      $cus_string.=$custom[$q][0]."@@".$custom[$q][1];
                                       $cus_string.="{**}";
                                   }
                       }
              $cus_string=substr($cus_string,0,-4);
                       
  $returnString.=$inbox."/".$spam."/".$trash."/".$cus_string;
			//$resultString=substr($resultString,0,-18);
			echo $returnString;exit(0);
		}


	}

	function getconversation($headers)
	{

		$singlelinebody=str_replace("\n","{nesote_n}",$headers);//echo $singlelinebody;
		$singlelinebody=str_replace("\r\n","{nesote_rn}",$singlelinebody);
		$singlelinebody=str_replace("\r","{nesote_r}",$singlelinebody);
		$singlelinebody=str_replace("\t","{nesote_t}",$singlelinebody);
		$singlelinebody=str_replace("&nbsp;","",$singlelinebody);

		preg_match('/In-Reply-To<\/headername>{nesote_r}{nesote_n}{nesote_t}{nesote_t}<headervalue>(.+?)<\/headervalue>/i',$singlelinebody,$reply);
		if($reply[1]!="")
		{
			$reply[1]=str_replace("&lt;","",$reply[1]);
			$reply[1]=str_replace("&gt;","",$reply[1]);
			$replyto="&lt;$reply[1]&gt;";
		}
		else
		$replyto="";
		return $replyto;
	}

	function getmessageid($headers)
	{

		$singlelinebody=str_replace("\n","{nesote_n}",$headers);//echo $singlelinebody;
		$singlelinebody=str_replace("\r\n","{nesote_rn}",$singlelinebody);
		$singlelinebody=str_replace("\r","{nesote_r}",$singlelinebody);
		$singlelinebody=str_replace("\t","{nesote_t}",$singlelinebody);
		$singlelinebody=str_replace("&nbsp;","",$singlelinebody);

		preg_match('/Message-Id<\/headername>{nesote_r}{nesote_n}{nesote_t}{nesote_t}<headervalue>&lt;(.+?)&gt;<\/headervalue>/i',$singlelinebody,$reply);
		$reply[1]=str_replace("&lt;","",$reply[1]);
		$reply[1]=str_replace("&gt;","",$reply[1]);

		$replyto="<".$reply[1].">";
		return $replyto;
	}

	function getfolderid($xml,$Subject,$fromid,$server,$userid)
	{
          
		$start_pos2=strpos($xml,"<mimepart>");

		$end_pos2=strpos($xml,"</mimepart>");
		$end_pos2=$end_pos2+strlen("</mimepart>");
		$length2=($end_pos2-$start_pos2);


		$result_string2=substr($xml,$start_pos2,$length2);

		$start_pos3=strpos($result_string2,"<body>")+strlen("<body>");
		$end_pos3=strpos($result_string2,"</body>");
		$length3=$end_pos3-$start_pos3;
		$result_string3=substr($result_string2,$start_pos3,$length3);
		$body=str_replace("<![CDATA[","",$result_string3);
		$body=str_replace("]]>","",$body);
             $body=strip_tags($this->getHtmltags($xml));

		$length=strlen($body);

		$i=0;
		$db=new NesoteDALController();
		$db->select("nesote_email_spam_settings");
		$db->fields("*");
		$res=$db->query();

		while($row=$db->fetchRow($res))
		{
			$from_string="";$subject_string="";$body_string="";

			if($row[4]!=0)
			{
				if($row[4]==1)
				$from_string="^".$row[1]."$";
				else if($row[4]==2)
				$from_string="^".$row[1];
				else if($row[4]==3)
				$from_string=$row[1]."$";
				else if($row[4]==4)
				$from_string=$row[1];
			}

			if($row[5]!=0)
			{
				if($row[5]==1)
				$subject_string="^".$row[2]."$";
				else if($row[5]==2)
				$subject_string="^".$row[2];
				else if($row[5]==3)
				$subject_string=$row[2]."$";
				else if($row[5]==4)
				$subject_string=$row[2];//echo $subject_string;
			}

			if($row[6]!=0)
			{
				if($row[6]==1)
				$body_string="^".$row[3]."$";
				else if($row[6]==2)
				$body_string="^".$row[3];
				else if($row[6]==3)
				$body_string=$row[3]."$";
				else if($row[6]==4)
				$body_string=$row[3];//echo $body_string."--";
			}
			//echo $subject_string."/";
			$folder=$this->getfolder($from_string,$subject_string,$body_string,$fromid,$Subject,$body);
			if($folder!=1)
			return   $folder;
            
		}

		
		$db->select("nesote_email_spamserver_settings");
		$db->fields("name");
		$reslt1=$db->query();//echo $db->getQuery();
		$num1=$db->numRows($reslt1);
		if($num1!=0)
		{//echo "nesote_email_spamserver_settings";
			while($serverresult1=$db->fetchRow($reslt1))
			{
				$fid1=$this->checkserver($serverresult1[0],$server);
				if($fid1==4)
				break;
			}

		}

		if($fid1==4)
		return $fid1;


		//return   $folder;

		$db->select("nesote_email_emailfilters");
		$db->fields("*");
		$db->where("userid=?",array($userid));
		$res1=$db->query();//echo $db1->getQuery();

		while($row1=$db->fetchRow($res1))
		{

			$from_string1="";$subject_string1="";$body_string1="";

			if($row1[4]!=0)
			{
				if($row1[4]==1)
				$from_string1="^".$row1[1]."$";
				else if($row1[4]==2)
				$from_string1="^".$row1[1];
				else if($row1[4]==3)
				$from_string1=$row1[1]."$";
				else if($row1[4]==4)
				$from_string1=$row1[1];
			}

			if($row1[5]!=0)
			{
				if($row1[5]==1)
				$subject_string1="^".$row1[2]."$";
				else if($row1[5]==2)
				$subject_string1="^".$row1[2];
				else if($row1[5]==3)
				$subject_string1=$row1[2]."$";
				else if($row1[5]==4)
				$subject_string1=$row1[2];
			}

			if($row1[6]!=0)
			{
				if($row1[6]==1)
				$body_string1="^".$row1[3]."$";
				else if($row1[6]==2)
				$body_string1="^".$row1[3];
				else if($row1[6]==3)
				$body_string1=$row1[3]."$";
				else if($row1[6]==4)
				$body_string1=$row1[3];
			}

			$whichfolder=$this->getwhichfolder($from_string1,$subject_string1,$body_string1,$fromid,$Subject,$body,$row1[7]);//echo $whichfolder;

			if($whichfolder!=1)
			return $whichfolder;
		}

		$db->select("nesote_email_blacklist_server");
		$db->fields("server");
		$db->where("clientid=?",array($userid));
		$reslt2=$db->query();
		$num2=$db->numRows($reslt2);
		if($num2!=0)
		{
			while($serverresult2=$db->fetchRow($reslt2))
			{
				$fid2=$this->checkserver($serverresult2[0],$server);
				if($fid2==4)
				break;
			}

		}

		if($fid2==4)
		return $fid2;

		
		$db->select("nesote_email_whitelist_server");
		$db->fields("server");
		$db->where("clientid=?",array($userid));
		$reslt3=$db->query();//echo $db->getQuery();exit;
		$num3=$db->numRows($reslt3);
		if($num3!=0)
		{
			while($whserverresult3=$db->fetchRow($reslt3))
			{
				$fid3=$this->checkserver($whserverresult3[0],$server);
				if($fid3==1)
				break;
			}
		}
		
		$db->select("nesote_email_blacklist_mail");
		$db->fields("*");
		$db->where("mailid=? and clientid=?",array($fromid,$userid));
		$res=$db->query();//echo $db->getQuery();exit;
		$num3=$db->numRows($res);

		if($num3!=0)
		return 4;
			
			
		
		$db->select("nesote_email_whitelist_mail");
		$db->fields("*");
		$db->where("mailid=? and clientid=?",array($fromid,$userid));
		$res=$db->query();//echo $db->getQuery();exit;
		$num4=$db->numRows($res);

		if($num4!=0)
		return 1;
		
		$db->select("nesote_email_contacts");
		$db->fields("*");
		$db->where("addedby=? and mailid=?",array($userid,$fromid));
		$reslt2=$db->query();//echo "..lo".$db->getQuery();exit;
		$num0=$db->numRows($reslt2);
		if($num0!=0)
		return 1;
		

		
		$db->select("nesote_email_blacklist_mail");
		$db->fields("*");
		$db->where("mailid=?",array($fromid));
		$res=$db->query();
		$num5=($db->numRows($res))*4;
		
		$db->select("nesote_email_whitelist_mail");
		$db->fields("*");
		$db->where("mailid=?",array($fromid));
		$res=$db->query();//echo $db->getQuery();exit;
		$num6=$db->numRows($res);
		//echo $num5."/".$num6;
		if($num5>$num6)
		return 4;
		else
		return 1;
			
	}

	function getfolder($from_string,$subject_string,$body_string,$from,$subject,$body)
	{



		if($from_string!="")
		{
			$from_string=trim($from_string);$from=trim($from);
			preg_match("/$from_string/i",$from,$res);
			$res=count($res);
		}
		else
		$res=1;

		if($res==0)
		return 1;
		else
		{
			if($subject_string!="")
			{
				//echo $subject_string."/".$subject;
				$subject_string=trim($subject_string);$subject=trim($subject);
				preg_match("/$subject_string/i",$subject,$res1);//print_r($res1);
				$res1=count($res1);
			}
			else
			$res1=1;

			if($res1==0)
			return 1;
			else
			{
				if($body_string!="")
				{

					//preg_match("/body$/i","fmg,mfg,mf,gmf,g.m,.fgm,.fgm.,gm.,dfm.,dfgm.,dgfm.g,.mgdf,body",$res2);
					//echo $body_string."/".$body;
					$body_string=trim($body_string);$body=trim($body);
					preg_match("/$body_string/i",$body,$res2);
					//print_r($res2);

					$res2=count($res2);
				}
				else
				$res2=1;

				if($res2==0)
				return 1;

				else
				return 4;

			}
		}
	}
	function getwhichfolder($from_string,$subject_string,$body_string,$from,$subject,$body,$folder)
	{
		if($from_string!="")
		{
			$from_string=trim($from_string);$from=trim($from);
			preg_match("/$from_string/i",$from,$res);
			$res=count($res);
		}
		else
		$res=1;
		if($res==0)
		return 1;
		else
		{
			if($subject_string!="")
			{
				$subject_string=trim($subject_string);$subject=trim($subject);
				preg_match("/$subject_string/i",$subject,$res1);
				$res1=count($res1);
			}
			else
			$res1=1;

			if($res1==0)
			return 1;
			else
			{

				if($body_string!="")
				{
					//echo $body_string."/".$body;
					$body_string=trim($body_string);$body=trim($body);
					preg_match("/$body_string/i",$body,$res2);//print_r($res2);
					$res2=count($res2);
				}
				else
				$res2=1;
				if($res2==0)
				return 1;

				else
				return $folder;

			}
		}
	}

	function checkserver($table_server,$rec_server)// to check black listy or whitelist server
	{
		$table_server=trim($table_server);
		$rec_server=trim($rec_server);

		preg_match("/$table_server/i",$rec_server,$res2);
		$res2=count($res2);

		if($res2==0)
		return 1;
		else
		return 4;
	}

	function update_conversation($mail_references)
	{
		$username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);
		
		preg_match_all('/<item>(.+?)<\/item>/i',$mail_references,$reply);
		//print_r($reply);
		$no=count($reply[1]);
		$md5_references=md5($mail_references);
		for($i=0;$i<$no;$i++)
		{
			preg_match('/<mailid>(.+?)<\/mailid>/i',$reply[1][$i],$mailid);
			preg_match('/<folderid>(.+?)<\/folderid>/i',$reply[1][$i],$folderid);//echo $mailid[1]."p".$folderid[1]."n";
			$db=new NesoteDALController();
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
			$db->set("mail_references=?,md5_references=?",array($mail_references,$md5_references));
			$db->where("id=?",array($mailid[1]));
			$rs=$db->query();

		}
	}



	function insrt($xml,$id,$folderid)
	{

		$username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);
		$userid=$this->getId();
		$db=new NesoteDALController();
		$html=$this->getHtmltags($xml);

		$singlelinebody=str_replace("\n","{nesote_n}",$xml);
		$singlelinebody=str_replace("\r\n","{nesote_rn}",$singlelinebody);
		$singlelinebody=str_replace("\r","{nesote_r}",$singlelinebody);
		$singlelinebody=str_replace("\t","{nesote_t}",$singlelinebody);
		$singlelinebody=str_replace("&nbsp;","",$singlelinebody);


		$singlelinebodi=$singlelinebody;
		if((strpos($singlelinebody,"text/html")=="FALSE")||(strpos($singlelinebody,"text/html")<1))
		{
			preg_match('/<headername>Content-Transfer-Encoding<\/headername>{nesote_r}{nesote_n}{nesote_t}{nesote_t}{nesote_t}<headervalue>(.+?)<\/headervalue>/i',$singlelinebody,$encode);
			if(count($encode[1])==0)
			preg_match('/<headername>Content-Transfer-Encoding<\/headername>{nesote_r}{nesote_n}{nesote_t}{nesote_t}<headervalue>(.+?)<\/headervalue>/i',$singlelinebody,$encode);
			$file_size=0;

		}
		else
		{

			$start=strpos($singlelinebody,"text/html");
			$sub_part=substr($singlelinebody,$start,750);

			preg_match('/text\/html(.+?)<headername>Content-Transfer-Encoding<\/headername>(.+?)<headervalue>(.+?)<\/headervalue>/i',$sub_part,$encode);

			$count1=strpos($singlelinebody,"</mimepart>");
			$end=strlen("</mimepart>");
			$end_pos_final=($count1+$end);

			$singlelinebody=substr_replace($singlelinebody,"{nesote_bodyclose}",$count1,$end);
			$count10=strpos($singlelinebody,"</mimepart>");
			$end_pos_final10=($count10+$end);
			$start_pos=$end_pos_final10;


			$end_pos=strpos($singlelinebody,"</email>");
			$length=$end_pos-$start_pos;
			$result_string=substr($singlelinebody,$start_pos,$length);

			$results=strpos($result_string,"</mimepart>{nesote_r}{nesote_n}{nesote_t}</mimepart>");
			if($results>0)
			{
				$results1=substr($result_string,0,$results);
				$nw_results=$results+strlen("</mimepart>{nesote_r}{nesote_n}{nesote_t}</mimepart>");
				$results2=substr($result_string,$nw_results);

				$result_string1=$results1."</mimepart>".$results2;
			}
			else
			$result_string1=$result_string;
			$resultsz=strpos($result_string1,"</mimepart>{nesote_r}{nesote_n}{nesote_t}{nesote_t}</mimepart>");
			if($resultsz>0)
			{
				$resultsz1=substr($result_string1,0,$resultsz);
				$nw_resultsz=$resultsz+strlen("</mimepart>{nesote_r}{nesote_n}{nesote_t}{nesote_t}</mimepart>");
				$resultsz2=substr($result_string1,$nw_resultsz);

				$result_string1=$resultsz1."</mimepart>".$resultsz2;
			}

			$result_string1=substr($result_string1,strpos($result_string1,"<mimepart>"));


			$countz=substr_count($result_string1,"<mimepart>");

			$file_size=0;

			for($i=0;$i<$countz;$i++)
			{

				$start_pos2=strpos($result_string1,"<mimepart>");

				$end_pos2=strpos($result_string1,"</mimepart>");
				$end_pos2=$end_pos2+strlen("</mimepart>");
				$length2=($end_pos2-$start_pos2);


				$result_string2=substr($result_string1,$start_pos2,$length2);

				$start_pos3=strpos($result_string2,"<body>")+strlen("<body>");
				$end_pos3=strpos($result_string2,"</body>");
				$length3=$end_pos3-$start_pos3;
				$result_string3=substr($result_string2,$start_pos3,$length3);
				$content[$i]=str_replace("<![CDATA[","",$result_string3);
				$content[$i]=str_replace("]]>","",$content[$i]);
				$content[$i]=str_replace("{nesote_n}","\n",$content[$i]);
				$content[$i]=str_replace("{nesote_rn}","\r\n",$content[$i]);
				$content[$i]=str_replace("{nesote_r}","\r",$content[$i]);
				$content[$i]=str_replace("{nesote_t}","\t",$content[$i]);
				$decode[$i]=base64_decode($content[$i]);
				$details[$i]=str_replace("{nesote_n}","",$result_string2);
				$details[$i]=str_replace("{nesote_rn}","",$details[$i]);
				$details[$i]=str_replace("{nesote_r}","",$details[$i]);
				$details[$i]=str_replace("{nesote_t}","",$details[$i]);
				preg_match_all('/<headervalue>(.+?)<\/headervalue>/i',$details[$i],$res2[$i]);
				$type[$i]=$res2[$i][1][0];
				preg_match('/<\/headervalue><parameter><paramname>name<\/paramname><paramvalue>(.+?)<\/paramvalue>/i',$details[$i],$name[$i]);
				if($name[$i][0]=="")
				preg_match('/<\/headervalue><parameter><paramname>filename<\/paramname><paramvalue>(.+?)<\/paramvalue>/i',$details[$i],$name[$i]);
					
				$filename[$i]=$name[$i][1];
				if($filename[$i]=="")
                  {
                    preg_match('/<\/headervalue><parameter><paramname>filename<\/paramname><paramvalue>(.+?)<\/paramvalue>/i',$details[$i],$name[$i]);
                    $filename[$i]=$name[$i][1];
                   }

				preg_match('/<headername>Content-Transfer-Encoding<\/headername><headervalue>(.+?)<\/headervalue>/i',$details[$i],$coding[$i]);
				$coding_type[$i]=$coding[$i][1];
				preg_match_all('/<headername>Content-Disposition<\/headername><headervalue>(.+?)<\/headervalue>/i',$details[$i],$mode[$i]);

				$modez[$i]=$mode[$i][1][0];
				if($modez[$i]=="")
				$modez[$i]=$mode[$i][1];
				$file_mode[$i]=$modez[$i];

				preg_match_all('/<headername>Content-Id<\/headername><headervalue>&lt;(.+?)&gt;<\/headervalue>/i',$details[$i],$res3[$i]);

				$temp[$i]=$res3[$i][1][0];
				$q[$i]=substr($filename[$i],strrpos($filename[$i],'.')+1);


				
				$db->select("nesote_email_settings");
				$db->fields("value");
				$db->where("name=?",array("restricted_attachment_types"));
				$result1=$db->query();
				$row1=$db->fetchRow($result1);


				$extention=$row1[0];
				$extention=str_replace(".","",$extention);

				$extentions=explode(",",$extention);
				$no=count($extentions);
				$match=0;

				$namez[$i]=$i."_".time()."-".$filename[$i];
				if($file_mode[$i]=="attachment")
				{
					for($r=0;$r<$no;$r++)
					{

						if((trim($extentions[$r])==trim($q[$i]))||("exe"==trim($q[$i])))

						{


							$match=1;
							break;
						}
					}

					if($match==0)
					{

						$imageformats=$this->getimageformats();
						$format=explode(",",$imageformats);
						$imagematch=0;
						for($a=0;$a<count($format);$a++)
						{
							if(trim($q[$i])==$format[$a])
							{
								$imagematch=1;
								$extn=$format[$a];
								break;
							}

						}
						if($imagematch==1)
						{
							$typez="image/".$extn;
						}
						else
						{
							$extnsn=trim($q[$i]);
							if($extnsn=="qqq")
							$extnsn="exe";
							$typez="other/".$extnsn;
						}

						if($filename[$i]=="")
						{

							$type1[$i]=explode("/",$type[$i]);

							$t=time().$i;

							$filename[$i]=md5($t).".".$type1[$i][1];
							$namez[$i]=time()."-".$filename[$i];
						}
						$url="http://".$_SERVER['HTTP_HOST'].$_SERVER["SCRIPT_NAME"];
						if(strpos($url,"/index.php")!="")
						{
							$url=str_replace("/index.php","",$url);

						}
						$urls="attachments";
						$urlz=$url."/attachments";
						if((is_dir($urls."/".$folderid."/".$tablenumber."/".$id))!=TRUE)
						{
							if((is_dir($urls."/".$folderid))!=TRUE)
							{

								mkdir($urls."/".$folderid,0777);
							}
						    if((is_dir($urls."/".$folderid."/".$tablenumber))!=TRUE)
							{

								mkdir($urls."/".$folderid."/".$tablenumber,0777);
							}

							mkdir("attachments/".$folderid."/".$tablenumber."/".$id,0777);
						}
						$namez[$i]=html_entity_decode($namez[$i]);
						$fp=fopen("$urls/$folderid/$tablenumber/$id/$namez[$i]","w");
						fwrite($fp,$decode[$i]);
						fclose($fp);
						$file_size=$file_size+ceil((filesize("$urls/$folderid/$tablenumber/$id/$namez[$i]"))/1024);



						
						$db->insert("nesote_email_attachments_$tablenumber");
						$db->fields("mailid,userid,folderid,type,name,attachment");
						$db->values(array($id,$userid,$folderid,$type[$i],$namez[$i],1));
						$res=$db->query();

					}

				}
				else
				{
					if($filename[$i]=="")
					{

						$type1[$i]=explode("/",$type[$i]);



						$t=time().$i;

						$filename[$i]=md5($t).".".$type1[$i][1];
						$namez[$i]=time()."-".$filename[$i];
					}
					$url="http://".$_SERVER['HTTP_HOST'].$_SERVER["SCRIPT_NAME"];
					if(strpos($url,"/index.php")!="")
					{
						$url=str_replace("/index.php","",$url);

					}
					$urls="attachments";
					$urlz=$url."/attachments";
					if((is_dir($urls."/".$folderid."/".$tablenumber."/".$id))!=TRUE)
					{
						if((is_dir($urls."/".$folderid))!=TRUE)
						{

							mkdir($urls."/".$folderid,0777);
						}
					   if((is_dir($urls."/".$folderid."/".$tablenumber))!=TRUE)
						{

							mkdir($urls."/".$folderid."/".$tablenumber,0777);
						}

						mkdir("attachments/".$folderid."/".$tablenumber."/".$id,0777);
					}
					$namez[$i]=html_entity_decode($namez[$i]);
					$fp=fopen("$urls/$folderid/$tablenumber/$id/$namez[$i]","w");
					fwrite($fp,$decode[$i]);
					fclose($fp);
					$file_size=$file_size+ceil((filesize("$urls/$folderid/$tablenumber/$id/$namez[$i]"))/1024);



					
					$db->insert("nesote_email_attachments_$tablenumber");
					$db->fields("mailid,userid,folderid,type,name,attachment");
					$db->values(array($id,$userid,$folderid,$type[$i],$namez[$i],0));
					$res=$db->query();




				}
				$html=str_replace("cid:".$temp[$i],$urlz."/".$folderid."/".$tablenumber."/".$id."/".$namez[$i],$html);
				preg_match('/img(.+?)src(.+?)'.$namez[$i].'/i',$html,$names[$i]);


				$result_string1=str_replace($result_string2,"",$result_string1);

			}
		}

		
		if($folderid==1)
		{
			$db->update("nesote_email_inbox_$tablenumber");
			$db->set("body=? ,memorysize=?",array($html,$file_size));
			$db->where("id=?",$id);
			$res=$db->query();
		}
		else if($folderid==4)
		{
			$db->update("nesote_email_spam_$tablenumber");
			$db->set("body=? ,memorysize=?",array($html,$file_size));
			$db->where("id=?",$id);
			$res=$db->query();
		}
		else if($folderid>=10)
		{
			$db->update("nesote_email_customfolder_mapping_$tablenumber");
			$db->set("body=? ,memorysize=?",array($html,$file_size));
			$db->where("id=?",$id);
			$res=$db->query();
		}

		return $html;
	}

	function autoreply($headers,$reply)
	{

		$id=$this->getId();
		$db= new NesoteDALController();
		
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
			


		$catchall=$settings->getValue("catchall_mail");

		$username=$_COOKIE['e_username'];

		$extention=$settings->getValue("emailextension");
		if(substr($extention,0,1)!="@")
		{
			$fullid=$username."@".$extention;
		}
		else
		{
			$fullid=$username.$extention;
		}

		$db->select("nesote_email_usersettings");
		$db->fields("autoreply_flag");
		$db->where("userid=? ",array($id));
		$result=$db->query();
		$row=$db->fetchRow($result);
		$flag= $row[0];
		if($flag==1)
		{

			$reply_sub_predecessor=$settings->getValue("reply_sub_predecessor");
			$reply_sub_predecessor=" ".$reply_sub_predecessor.": ";


			$db->select("nesote_email_usersettings");
			$db->fields("autoreply_msg,autoreply_subject,autoreply_send_flag");
			$db->where("userid=? ",array($id));
			$result=$db->query();
			$row=$db->fetchRow($result);
			$msg= $row[0];
			$subject=$row[1];
			$subject=$subject.$reply_sub_predecessor.$reply;
			$From=$headers[From];

			//$Received=$headers[Received];

			preg_match('/<(.+?)>/i',$From,$fromid);
			if($fromid[1]=="")
			preg_match('/&lt;(.+?)&gt;/i',$From,$fromid);
			if($fromid[1]=="")
			preg_match('/&amp;&lt;(.+?)&amp;&gt;/i',$From,$fromid);
			if($fromid[1]=="")
			$fromid[1]=$From;
			$to=$fromid[1];
			//$to='suraaj.k@inoutscripts.com';
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

			if($catchall==1)
			{

				$SMTP_host=$settings->getValue("SMTP_host");


				$SMTP_port=$settings->getValue("SMTP_port");


				$SMTP_username=$settings->getValue("SMTP_username");


				$SMTP_password=$settings->getValue("SMTP_password");
		
				$alternate_message=$settings->getValue("alternate_message");
				
				
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
			$SMTP_host=$row[1];
			$SMTP_password=$row[4];
			$SMTP_username=$row[3];
                        $SMTP_port=$row[2];
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

				$alternate_message=$settings->getValue("alternate_message");
			}

			//echo $SMTP_password;exit;
			try {
				$mail->Host       = $SMTP_host; // SMTP server
				$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->Port       = $SMTP_port;                    // set the SMTP port for the GMAIL server
				$mail->Username   = $SMTP_username; // SMTP account username
				$mail->Password   = $SMTP_password;
				// SMTP account password

				$mail->AddReplyTo($fullid);


				$mail->AddAddress($to);

				$mail->SetFrom($fullid);//('saneesh@valiyapalli.com', 'Saneesh Baby');
				$mail->Subject = $subject;
				//$mail->SMTPSecure="ssl";
				$mail->AltBody = $alternate_message; // optional - MsgHTML will create an alternate automatically
				$mail->MsgHTML($msg);
				$mail->Send();
				//echo "Message Sent OK</p>\n";exit;
			}
			catch (phpmailerException $e)
			{
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
			}
			catch (Exception $e)
			{
				echo $e->getMessage(); //Boring error messages from anything else!
			}
			return;
		}

	}
	function srtautoreply($reply)
	{

		$id=$this->getId();
		$db= new NesoteDALController();
		
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
			


		$catchall=$settings->getValue("catchall_mail");

		$username=$_COOKIE['e_username'];

		$extention=$settings->getValue("emailextension");
		if(substr($extention,0,1)!="@")
		{
			$fullid=$username."@".$extention;
		}
		else
		{
			$fullid=$username.$extention;
		}

		$db->select("nesote_email_usersettings");
		$db->fields("autoreply_flag");
		$db->where("userid=? ",array($id));
		$result=$db->query();
		$row=$db->fetchRow($result);
		$flag= $row[0];
		if($flag==1)
		{

			$reply_sub_predecessor=$settings->getValue("reply_sub_predecessor");
			$reply_sub_predecessor=" ".$reply_sub_predecessor.": ";


			$db->select("nesote_email_usersettings");
			$db->fields("autoreply_msg,autoreply_subject,autoreply_send_flag");
			$db->where("userid=? ",array($id));
			$result=$db->query();
			$row=$db->fetchRow($result);
			$msg= $row[0];
			$subject=$row[1];
			$subject=$subject.$reply_sub_predecessor.$reply;
			//$From=$headers[From];
			$to='suraaj.k@inoutscripts.com';

			//$Received=$headers[Received];

			/*preg_match('/<(.+?)>/i',$From,$fromid);
			if($fromid[1]=="")
			preg_match('/&lt;(.+?)&gt;/i',$From,$fromid);
			if($fromid[1]=="")
			preg_match('/&amp;&lt;(.+?)&amp;&gt;/i',$From,$fromid);
			if($fromid[1]=="")
			$fromid[1]=$From;*/

			require_once('class/class.phpmailer.php');
	                require_once('class/class.smtp.php');
			$mail = new PHPMailer(true); 
			//$mail->IsSMTP(); 

			if($catchall==1)
			{

				$SMTP_host=$settings->getValue("SMTP_host");


				$SMTP_port=$settings->getValue("SMTP_port");


				$SMTP_username=$settings->getValue("SMTP_username");


				$SMTP_password=$settings->getValue("SMTP_password");
		
				$alternate_message=$settings->getValue("alternate_message");
				
				
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

				$alternate_message=$settings->getValue("alternate_message");
			}

			//echo $SMTP_password;exit;
			try {
				$mail->Host       = $SMTP_host; // SMTP server
				$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->Port       = $SMTP_port;                    // set the SMTP port for the GMAIL server
				$mail->Username   = $SMTP_username; // SMTP account username
				$mail->Password   = $SMTP_password;
				// SMTP account password

				$mail->AddReplyTo($fullid);


				$mail->AddAddress($to);

				$mail->SetFrom($fullid);//('saneesh@valiyapalli.com', 'Saneesh Baby');
				$mail->Subject = $subject;
				//$mail->SMTPSecure="ssl";
				$mail->AltBody = $alternate_message; // optional - MsgHTML will create an alternate automatically
				$mail->MsgHTML($msg);
				$mail->Send();
				//echo "Message Sent OK</p>\n";exit;
			}
			catch (phpmailerException $e)
			{
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
			}
			catch (Exception $e)
			{
				echo $e->getMessage(); //Boring error messages from anything else!
			}
			return;
		}

	}

	function autoforwarding($folder,$mailid)
	{

		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		
		$username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);
		
		$db= new NesoteDALController();
		if($folder==1)
		$db->select("nesote_email_inbox_$tablenumber");
		else if($folder==4)
		$db->select("nesote_email_spam_$tablenumber");
		else if($folder==5)
		$db->select("nesote_email_trash_$tablenumber");
		else if($folder>=10)
		$db->select("nesote_email_customfolder_mapping_$tablenumber");
		$db->fields("*");
		$db->where("id=? ",array($mailid));
		$result1=$db->query();
		$row1=$db->fetchRow($result1);
		$Subject=$row1[6];
		$html=$row1[7];
		$from=$row1[2];
		$id=$this->getId();
		$db= new NesoteDALController();
		$db->select("nesote_email_usersettings");
		$db->fields("forward_mail");
		$db->where("userid=?",array($id));
		$result=$db->query();//echo $db->getQuery();
		$row=$db->fetchRow($result);
		$to= $row[0];
$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name=?", array("user_smtp"));
			$result=$db->query();
			$row=$db->fetchRow($result);
			$extsmtp=$row[0];
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
}
else
{

		$SMTP_host=$settings->getValue("SMTP_host");


		$SMTP_port=$settings->getValue("SMTP_port");


		$SMTP_username=$settings->getValue("SMTP_username");


		$SMTP_password=$settings->getValue("SMTP_password");
}


		$alternate_message=$settings->getValue("alternate_message");
		$username=$_COOKIE['e_username'];

		$extention=$settings->getValue("emailextension");

		if(substr($extention,0,1)!="@")
		{
			$fullid=$username."@".$extention;
		}
		else
		{
			$fullid=$username.$extention;
		}

		require_once('class/class.phpmailer.php');
		include("class/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

		//$mail->IsSMTP();
if($extsmtp==1)
{
$mail->IsSMTP();
}
		try {

			$mail->Host       = $SMTP_host; // SMTP server
			$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			$mail->Port       = $SMTP_port;                    // set the SMTP port for the GMAIL server
			$mail->Username   = $SMTP_username; // SMTP account username
			$mail->Password   = $SMTP_password;
			
			$mail->AddReplyTo($fullid);//from
			if($to!='')
			{
				$to=explode(",",$to);

				foreach ($to as $address)
				{
					if($address!='')
					{
						
						$address=str_replace("\\","",$address);

						preg_match("/(.+?)<(.+?)>/i",$address,$mailid3);
						if($mailid3[2]=="")
						{

							$mailid3[2]=$address;
							$mailid3[1]="";
						}
						$mailid3[1]=str_replace("\"","",$mailid3[1]);

						$mail->AddAddress($mailid3[2],$mailid3[1]);
						$to_address.=$mailid3[1]."<".$mailid3[2].">,";
						
					}
				}
			}
			
			$mail->SetFrom($fullid);
			$mail->Subject = $Subject;
			$mail->SMTPSecure="ssl";
			$mail->AltBody = $alternate_message; // optional - MsgHTML will create an alternate automatically

			$p=0;
			
			$db->select("nesote_email_attachments_$tablenumber");
			$db->fields("*");
			$db->where("mailid=? and folderid=? and userid=?", array($mailid,$folder,$id));
			$result2=$db->query();
			while($rw=$db->fetchRow($result2))
			{
				$file_name[$p]=$rw[2];
				$p++;
				
			}
			$mydir = "attachments/$folder/$tablenumber/$mailid";
			$d = dir($mydir);

			if($d)
			{

				while($entry = $d->read())
				{
					
					if ($entry!= "." && $entry!= "..")
					{
						
						$db->select("nesote_email_attachments_$tablenumber");
						$db->fields("attachment");
						$db->where("mailid=? and folderid=? and name=? and userid=?", array($mailid,$folder,$entry,$id));
						$result3=$db->query();
						$rw1=$db->fetchRow($result3);
						if(($rw1[0]==1)||(strpos($html,"attachment/".$folder."/".$tablenumber."/".$maild."/".$entry)!=""))
						{
							$mail->AddAttachment("attachments/$folder/$tablenumber/$mailid/$entry");
							
						}
					}
				}
				$d->close();
			}

			
			$mail->MsgHTML($html);
			

			$mail->Send();
			
		}
		catch (phpmailerException $e)
		{
			echo $e->errorMessage(); //Pretty error messages from PHPMailer
		}
		catch (Exception $e)
		{
			echo $e->getMessage(); //Boring error messages from anything else!
		}
		return;


	}


	function getattachment($folderid,$mailid,$filenam)
	{
        $username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);
		$userid=$this->getId();
		$db= new NesoteDALController();
		$db->select("nesote_email_attachments_$tablenumber");
		$db->fields("name");
		$db->where("folderid=? and mailid=? and name=? and userid=? ",array($folderid,$mailid,$filenam,$userid));
		$result=$db->query();
		$row=$db->fetchRow($result);
		$filename=$row[0];
		$size=getimagesize("attachments/$folderid/$tablenumber/$mailid/$filenam");
		$new_width=100;
		$new_height=$size[1]/$size[0]*100;
		$check_string=substr($filename, strrpos($filename,'.')+1);$check_string=strtolower($check_string);
		if(($check_string=="zip")||($check_string=="rar"))
		{

			return "<br><br>".$this->getmessage(35)."-
			<b>&nbsp;&nbsp;<table><tr><td height='.$new_height.';width='.$new_width'.>img src=attachments/'.$folderid.'/'.$tablenumber.'/'.$mailid.'/'.$filenam.'</td></tr><tr><td>".$filename."</td></tr></table></b>&nbsp;&nbsp;&nbsp;<a href=\"".$this->url("mime/downloadattachment/$folderid/$tablenumber/$mailid/$filename")."\" border='0'>".$this->getmessage(101)."</a> <br><br>   ";
		}
		elseif(($check_string=="jpg")||($check_string=="gif")||($check_string=="png")||($check_string=="jpeg"))
		{

			return"<br><br>".$this->getmessage(35)."-

			<b>&nbsp;&nbsp;<table border=1><tr><td ><img src='attachments/$folderid/$tablenumber/$mailid/$filenam' style='height:$new_height;width:$new_width;'></td></tr></table></b>".$filename."&nbsp;&nbsp;&nbsp;<a href=\"".$this->url("mime/downloadattachment/$folderid/$tablenumber/$mailid/$filename")."\" border='0'>".$this->getmessage(101)."</a>&nbsp;&nbsp;<a rel=\"lightbox\" href=\"".$this->url("mime/showimage/$folderid/$tablenumber/$mailid/$filename")."\">".$this->getmessage(102)."</a> <br>  <br> ";

		}
		else return " ";
	}
	function downloadattachmentAction()
	{
		$folderid=$this->getParam(1);
		$mailid=$this->getParam(2);
		$filename=$this->getParam(3);
        $username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);    


		$path="attachments/$folderid/$tablenumber/$mailid/$filename";


		$attachments_path="desktop/download/$filename";//"userdata/attachments";


		$pathToServerFile=$path;
		
		header('Content-disposition: attachment; filename='.$filename);
		readfile($pathToServerFile);
	}
	function showimageAction()
	{

		$folderid=$this->getParam(1);
		$mailid=$this->getParam(2);
		$filename=$this->getParam(3);
        $username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);
        $userid=$this->getId();
		$path="attachments/$folderid/$tablenumber/$mailid/$filename";

		$db= new NesoteDALController();
		$db->select("nesote_email_attachments_$tablenumber");
		$db->fields("type");
		$db->where("folderid=? and mailid=? and name=? and userid=?",array($folderid,$mailid,$filename,$userid));
		$result=$db->query();
		$row=$db->fetchRow($result);

		


		$pathToServerFile=$path;//"$attachments_path/support_attachments/{$postid}/".$row[0];



		header('Content-Type:'. $row[0].'; filename='.$filename);//str_replace(" ","_",$row[0]));
		readfile($pathToServerFile);

		exit(0);

	}


	function getxml($input)
	{
		$params['include_bodies'] = true;
		$params['decode_bodies']  = true;
		$params['decode_headers'] = true;


		$decoder = new Mail_mimeDecode($input);
		$structure = $decoder->decode($params);
		$body=$decoder->_quotedPrintableDecode($input);

		//This example calls the decode function statically (ie no object, straight function call) and then passes the structure to the getXML() function.



		$params['include_bodies'] = true;
		$params['decode_bodies']  = false;
		$params['decode_headers'] = true;
		$params['input']          = $input;
		$params['crlf']           = "\r\n";

		$structure = Mail_mimeDecode::decode($params);
		$xml = Mail_mimeDecode::getXML($structure);
		return $xml;
	}

	function getHtmltags1($xml)
	{
	 $xml=str_replace("\r\n","{nesote_nlrn}",$xml);
	 $xml=str_replace("\n","{nesote_nln}",$xml);
	 $xml=str_replace("\r","{nesote_nlr}",$xml);
	 $result=str_replace("&Acirc;","",$result);
	
	 $strt=strpos($xml,"<headervalue>text/html</headervalue>");
	if($strt==FALSE)
	 $strt=strpos($xml,"<headervalue>text/plain</headervalue>");
	 $new_xml=substr($xml,$strt);
    preg_match('/text\/html(.+?)<headername>Content-Transfer-Encoding<\/headername>(.+?)<headervalue>(.+?)<\/headervalue>/i',$new_xml,$encode);
    $curntencode=$encode[3];
     if($curntencode=="")
    {
 	preg_match('/text\/plain(.+?)<headername>Content-Transfer-Encoding<\/headername>(.+?)<headervalue>(.+?)<\/headervalue>/i',$new_xml,$encode);
    $curntencode=$encode[3];
    }

	 preg_match('/<paramname>charset<\/paramname>(.+?)<paramvalue>(.+?)<\/paramvalue>/i',$new_xml,$cset1);
	 $chset=$cset1[2]; 
	 $len=strlen("<headervalue>text/html</headervalue>");
	 $middle=strpos($new_xml,"<body>");
	 $length=strlen("<body>");
	 $start=$middle+$length;
	 $end=strpos($new_xml,"</body>");
	 $end=$end-$start;
	 $xml1=substr($new_xml,$start,$end);
	
	$new_xml1=$new_xml;$result2="";
	$pp=substr_count($new_xml, '<![CDATA[');
		for($i=0;$i<$pp;$i++)
		{$res=0;
			 $len1=strlen("<headervalue>text/plain</headervalue>");
			 if($len1=="")
			  $len1=strlen("<headervalue>text/html</headervalue>");
			  else
			 $res=1;
			 
			 
			 $middle1=strpos($new_xml1,"<body>");
			 $length1=strlen("<body>");
			 $start1=$middle1+$length1;
			 $end1=strpos($new_xml1,"</body>");
			 $end1=$end1-$start1;
		     $xml11=substr($new_xml1,$start1,$end1);
			 
			  $xml1=str_replace("{nesote_nlrn}","\r\n",$xml11); 
		 	  $xml1=str_replace("{nesote_nln}","\n",$xml1);
		      $xml1=str_replace("{nesote_nlr}","\r",$xml1);

	          $result1=str_replace("<![CDATA[","",$xml1);
	         $result1=str_replace("]]>","",$result1);
	         $result1=str_replace("=A0","",$result1);
			  $result2.=$result1;
	 
		 preg_match('/<headername>Return-Path<\/headername>(.+?)<headername>Return-Path<\/headername>/i',$new_xml,$arr);
		 
		 $new_xml1=str_replace($arr[1],"",$new_xml1); $new_xml1=str_replace($xml11,"",$new_xml1);
		}

	 $xml1=str_replace("{nesote_nlrn}","\r\n",$xml1); 
	 $xml1=str_replace("{nesote_nln}","\n",$xml1);
	 $xml1=str_replace("{nesote_nlr}","\r",$xml1);

	 $result1=str_replace("<![CDATA[","",$xml1);
	 $result1=str_replace("]]>","",$result1);
	
	$result1=$result2;
	 if($curntencode=="base64")
	 {
	 
	  $pr1=$result1;$chset1=strtoupper($chset);
        if(strlen($result1)!=0 && $chset1!="ISO-8859-1")
	    $result1=base64_decode($result1);

        if($result1=="")
        $result1=quoted_printable_decode($pr1);
	 	
	 	if($chset1!="UTF-8"  && $chset1!="ISO-8859-1")
	 	$result1=iconv($chset, 'UTF-8', $result1);
	 	
	 	
	 	/*$chset1=strtoupper($chset);
        if(strlen($result1)!=0 && $chset1!="ISO-8859-1")
	 	$result1=base64_decode($result1);
	 	
	 	if($chset1!="UTF-8"  && $chset1!="ISO-8859-1")
	 	$result1=iconv($chset, 'UTF-8', $result1);*/
	 }
	 else
	 {
	 	

	 	$result1=preg_replace("/%([0-9A-Fa-f]{2})/e", "chr(hexdec('\\1'))", $result1);

	 	$chset1=strtoupper($chset);
	 	if($curntencode!="8bit")
	 	$result1=quoted_printable_decode($result1);
	 	else 
	 	 return $result1;
		 if($chset!="" && $chset1!="UTF-8" && $chset1!="ISO-8859-1")
	 	{
	 		$result1=iconv($chset, 'UTF-8', $result1);

	 	}
	 	

	 }
	 return $result1;
	}
function origetHtmltags($xml)
	{
	    
	    //return $xml;exit;
	 $xml=str_replace("\r\n","{nesote_nlrn}",$xml);
	 $xml=str_replace("\n","{nesote_nln}",$xml);
	 $xml=str_replace("\r","{nesote_nlr}",$xml);
	 $result=str_replace("&Acirc;","",$result);
	$qpval=0;
	 $strt=strpos($xml,"<headervalue>text/html</headervalue>");
	if($strt==FALSE)
	 {$strt=strpos($xml,"<headervalue>text/plain</headervalue>");$qpval=1;}
	 //return $qpval;exit;
	$new_xml=substr($xml,$strt);
    preg_match('/text\/html(.+?)<headername>Content-Transfer-Encoding<\/headername>(.+?)<headervalue>(.+?)<\/headervalue>/i',$new_xml,$encode);
    $curntencode=$encode[3];
    
     if($curntencode=="")
    {
 	preg_match('/text\/plain(.+?)<headername>Content-Transfer-Encoding<\/headername>(.+?)<headervalue>(.+?)<\/headervalue>/i',$new_xml,$encode);
    $curntencode=$encode[3];
    }

	 preg_match('/<paramname>charset<\/paramname>(.+?)<paramvalue>(.+?)<\/paramvalue>/i',$new_xml,$cset1);
	$chset=$cset1[2]; 
	 $len=strlen("<headervalue>text/html</headervalue>");
	 $middle=strpos($new_xml,"<body>");
	 $length=strlen("<body>");
	 $start=$middle+$length;
	 $end=strpos($new_xml,"</body>");
	 $end=$end-$start;
	 $xml1=substr($new_xml,$start,$end);
	
	$new_xml1=$new_xml;$result2="";
	$pp=substr_count($new_xml, '<![CDATA[');
		for($i=0;$i<$pp;$i++)
		{$res=0;$res1=0;

$len1=strpos($new_xml1,"<headervalue>text/plain</headervalue>");
if($len1 !== false)
$res=1;

$len2=strpos($new_xml1,"<headervalue>text/html</headervalue>");
if($len2 !== false)
$res1=2;
			 
			 $middle1=strpos($new_xml1,"<body>");
			 $length1=strlen("<body>");
			 $start1=$middle1+$length1;
			 $end1=strpos($new_xml1,"</body>");
			 $end1=$end1-$start1;
		     $xml11=substr($new_xml1,$start1,$end1);
			 //return $xml11;
			  $xml1=str_replace("{nesote_nlrn}","\r\n",$xml11); 
		 	  $xml1=str_replace("{nesote_nln}","\n",$xml1);
		      $xml1=str_replace("{nesote_nlr}","\r",$xml1);

	          $result1=str_replace("<![CDATA[","",$xml1);
	         $result1=str_replace("]]>","",$result1);
	         $result1=str_replace("=A0","",$result1);
if($res==1)
{
//return "a";
$result1=str_replace("\n","<br>",$result1);
$pattern = "/((((f|ht){1}(tp|tps):\/\/)|(www\.))(([a-z][-a-z0-9]+\.)?[a-z][-a-z0-9]+\.[a-z]+(\.[a-z]{2,2})?)\/?[a-z0-9.,_\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1})/is";
  $result1 = preg_replace($pattern, "<a href='$1' target='_blank'>$1</a>", $result1);
  // fix URLs without protocols
  $result1 = preg_replace("/href='www/", "href='http://www", $result1);
 $result1 = preg_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})', 
    '<a href="mailto:\\1">\\1</a>', $result1);
}
else if($res1==2)
{
//return "b";
$result1 = preg_replace ("/<a([^>]+)>/is","<a$1 target=\"_blank\">",$result1); 
}
			  $result2.=$result1;
	 
		 preg_match('/<headername>Return-Path<\/headername>(.+?)<headername>Return-Path<\/headername>/i',$new_xml,$arr);
		
		 $new_xml1=str_replace($arr[1],"",$new_xml1); 
                 $new_xml1=str_replace($xml11,"",$new_xml1);
		}

	 $xml1=str_replace("{nesote_nlrn}","\r\n",$xml1); 
	 $xml1=str_replace("{nesote_nln}","\n",$xml1);
	 $xml1=str_replace("{nesote_nlr}","\r",$xml1);

	 $result1=str_replace("<![CDATA[","",$xml1);
	 $result1=str_replace("]]>","",$result1);

	$result1=$result2;	

	 if($curntencode=="base64")
	 {
	 
	  $pr1=$result1;$chset1=strtoupper($chset);
        if(strlen($result1)!=0 && $chset1!="ISO-8859-1")
	    $result1=base64_decode($result1);
//return $result1;
        if($result1=="")
        $result1=quoted_printable_decode($pr1);
	 	
	 	if($chset1!="UTF-8"  && $chset1!="ISO-8859-1")
	 	$result1=iconv($chset, 'UTF-8', $result1);
	 	
	 	//return $result1;
	 	/*$chset1=strtoupper($chset);
        if(strlen($result1)!=0 && $chset1!="ISO-8859-1")
	 	$result1=base64_decode($result1);
	 	
	 	if($chset1!="UTF-8"  && $chset1!="ISO-8859-1")
	 	$result1=iconv($chset, 'UTF-8', $result1);*/
	 }
	 else
	 {
	 	
	 //	$result1=preg_replace("/%([0-9A-Fa-f]{2})/e", "chr(hexdec('\\1'))", $result1);
	$result1 = preg_replace("/\\\\u([0-9a-fA-F]{4})/", "&#x\\1;", $result1);
	 	$chset1=strtoupper($chset);
	 	//return $curntencode;exit;
	 //	return $result1."----".$chset1;exit;
	 	if($curntencode!="8bit")
                  {
                  if($qpval==1 && $curntencode!="")
                  
	 	  $result1=quoted_printable_decode($result1);
                  else if($qpval==0)
                  $result1=quoted_printable_decode($result1);
                  
                  }
	 	else 
	 	 return $result1;
		 if($chset!="" && $chset1!="UTF-8" && $chset1!="ISO-8859-1")
	 	{
	 	    
	 		$result1=iconv($chset, 'UTF-8', $result1);
	 	

	 	}
	 	

	 }
	 return $result1;
	}
function getHtmltags($xml)
	{
	    
	    //return $xml;exit;
	 $xml=str_replace("\r\n","{nesote_nlrn}",$xml);
	 $xml=str_replace("\n","{nesote_nln}",$xml);
	 $xml=str_replace("\r","{nesote_nlr}",$xml);
	 $result=str_replace("&Acirc;","",$result);
	$qpval=0;
	 $strt=strpos($xml,"<headervalue>text/html</headervalue>");
	if($strt==FALSE)
	 {$strt=strpos($xml,"<headervalue>text/plain</headervalue>");$qpval=1;}
	 //return $qpval;exit;
	$new_xml=substr($xml,$strt);
    preg_match('/text\/html(.+?)<headername>Content-Transfer-Encoding<\/headername>(.+?)<headervalue>(.+?)<\/headervalue>/i',$new_xml,$encode);
    $curntencode=$encode[3];
    
     if($curntencode=="")
    {
 	preg_match('/text\/plain(.+?)<headername>Content-Transfer-Encoding<\/headername>(.+?)<headervalue>(.+?)<\/headervalue>/i',$new_xml,$encode);
    $curntencode=$encode[3];
    }

	 preg_match('/<paramname>charset<\/paramname>(.+?)<paramvalue>(.+?)<\/paramvalue>/i',$new_xml,$cset1);
	$chset=$cset1[2]; 
	 $len=strlen("<headervalue>text/html</headervalue>");
	 $middle=strpos($new_xml,"<body>");
	 $length=strlen("<body>");
	 $start=$middle+$length;
	 $end=strpos($new_xml,"</body>");
	 $end=$end-$start;
	 $xml1=substr($new_xml,$start,$end);
	
	$new_xml1=$new_xml;$result2="";
	$pp=substr_count($new_xml, '<![CDATA[');
		for($i=0;$i<$pp;$i++)
		{$res=0;$res1=0;

$len1=strpos($new_xml1,"<headervalue>text/plain</headervalue>");
if($len1 !== false)
$res=1;

$len2=strpos($new_xml1,"<headervalue>text/html</headervalue>");
if($len2 !== false)
$res1=2;
			 
			 $middle1=strpos($new_xml1,"<body>");
			 $length1=strlen("<body>");
			 $start1=$middle1+$length1;
			 $end1=strpos($new_xml1,"</body>");
			 $end1=$end1-$start1;
		     $xml11=substr($new_xml1,$start1,$end1);
			 //return $xml11;
			  $xml1=str_replace("{nesote_nlrn}","\r\n",$xml11); 
		 	  $xml1=str_replace("{nesote_nln}","\n",$xml1);
		      $xml1=str_replace("{nesote_nlr}","\r",$xml1);

	          $result1=str_replace("<![CDATA[","",$xml1);
	         $result1=str_replace("]]>","",$result1);
	         $result1=str_replace("=A0","",$result1);
if($res==1)
{
//return "a";
$result1=str_replace("\n","<br>",$result1);
$pattern = "/((((f|ht){1}(tp|tps):\/\/)|(www\.))(([a-z][-a-z0-9]+\.)?[a-z][-a-z0-9]+\.[a-z]+(\.[a-z]{2,2})?)\/?[a-z0-9.,_\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1})/is";
  $result1 = preg_replace($pattern, "<a href='$1' target='_blank'>$1</a>", $result1);
  // fix URLs without protocols
  $result1 = preg_replace("/href='www/", "href='http://www", $result1);
 $result1 = preg_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})', 
    '<a href="mailto:\\1">\\1</a>', $result1);
}
else if($res1==2)
{
//return "b";
$result1 = preg_replace ("/<a([^>]+)>/is","<a$1 target=\"_blank\">",$result1); 
}
			  $result2.=$result1;
	 
		 preg_match('/<headername>Return-Path<\/headername>(.+?)<headername>Return-Path<\/headername>/i',$new_xml,$arr);
		
		 $new_xml1=str_replace($arr[1],"",$new_xml1); 
                 $new_xml1=str_replace($xml11,"",$new_xml1);
		}

	 $xml1=str_replace("{nesote_nlrn}","\r\n",$xml1); 
	 $xml1=str_replace("{nesote_nln}","\n",$xml1);
	 $xml1=str_replace("{nesote_nlr}","\r",$xml1);

	 $result1=str_replace("<![CDATA[","",$xml1);
	 $result1=str_replace("]]>","",$result1);

	$result1=$result2;	

	
	 
	 	
	 //	$result1=preg_replace("/%([0-9A-Fa-f]{2})/e", "chr(hexdec('\\1'))", $result1);
	$result1 = preg_replace("/\\\\u([0-9a-fA-F]{4})/", "&#x\\1;", $result1);
	 	$chset1=strtoupper($chset);
	 	//return $curntencode;exit;
	 //	return $result1."----".$chset1;exit;
	 	if($curntencode!="8bit")
                  {
                  if($qpval==1 && $curntencode!="")
                  
	 	  $result1=quoted_printable_decode($result1);
                  else if($qpval==0)
                  $result1=quoted_printable_decode($result1);
                  
                  }
	 	else 
	 	 return $result1;
		 if($chset!="" && $chset1!="UTF-8" && $chset1!="ISO-8859-1")
	 	{
	 	    
	 		$result1=iconv($chset, 'UTF-8', $result1);
	 	

	 	}
	 	

	 
	 return $result1;
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

	function getReferences($reference,$subject)
	{
		$username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);
		
		$x=0;
		$subj=trim($subject);
		$subj=strtolower($subj);
		while(1==1)
		{
			$subj=trim($subj);
			if(substr($subj,0,3)=="re:")
			{
				$subj=substr($subj,3);
				continue;
			}
			if(substr($subj,0,3)=="fw:")
			{
				$subj=substr($subj,3);
				continue;
			}
			else if(substr($subj,0,4)=="fwd:")
			{
				$subj=substr($subj,4);
				continue;
			}
			else
			{
				break;
			}
		}
		preg_match_all('/<item>(.+?)<\/item>/i',$reference,$reply);
		//print_r($reply);
		$no=count($reply[1]);
		for($i=0;$i<$no;$i++)
		{
			preg_match('/<mailid>(.+?)<\/mailid>/i',$reply[1][$i],$mail[$i]);
			preg_match('/<folderid>(.+?)<\/folderid>/i',$reply[1][$i],$folder[$i]);
			$db=new NesoteDALController();
			if($folder[$i][1]==1)
			$db->select("nesote_email_inbox_$tablenumber");
			else if($folder[$i][1]==2)
			$db->select("nesote_email_draft_$tablenumber");
			else if($folder[$i][1]==3)
			$db->select("nesote_email_sent_$tablenumber");
			else if($folder[$i][1]==4)
			$db->select("nesote_email_spam_$tablenumber");
			else if($folder[$i][1]==5)
			$db->select("nesote_email_trash_$tablenumber");
			else if($folder[$i][1]>=10)
			$db->select("nesote_email_customfolder_mapping_$tablenumber");
			$db->fields("subject");
			$db->where("id=?",$mail[$i][1]);
			$res=$db->query();
			$row=$db->fetchRow($res);
			$sub=$row[0];
			$sub=strtolower($sub);
			while(1==1)
			{
				$sub=trim($sub);
				if(substr($sub,0,3)=="re:")
				{
					$sub=substr($sub,3);
					continue;
				}
				else if(substr($sub,0,3)=="fw:")
				{
					$sub=substr($sub,3);
					continue;
				}
				else if(substr($sub,0,4)=="fwd:")
				{
					$sub=substr($sub,4);
					continue;
				}
				else
				{
					break;
				}
			}
			if($sub==$subj)
			{
				$x=1;
				break;
			}
		}
		return $x;
	}
	

	function getDecodedFrom($from)
	{
		preg_match('/=\?(.+?)\?/i',$from,$chars);
		$charset=$chars;
		if(count($charset)!=0)
		{
			preg_match_all('/=\?(.+?)\?=/i',$from,$charsets1);//return count($charsets1[1]);
			$fr="";$fr1="";
			for($i=0;$i<count($charsets1[1]);$i++)
			{
				preg_match('/(.+?)\?/i',$charsets1[1][$i],$charset2);
				$chset=$charset2[1];$chset1=trim(strtoupper($chset));
				if(trim($charset2[1])=="Big5" || $charset2[1]=="GB2312")
				{
					//$sub=iconv_mime_decode("$subject", 0, "UTF-8");//echo"hh". $sub;

					mb_internal_encoding('UTF-8');
					$fr1=mb_decode_mimeheader($from);
				}
				else
				{
					preg_match('/\?(.+?)\?/i',$charsets1[1][$i],$charset1);
					$encode_type=$charset1[1];
					$len=strpos($charsets1[1][$i],$encode_type);
					$charsets1[1][$i]=substr($charsets1[1][$i],($len+2));
					if($encode_type=="B")
					$fr.=base64_decode($charsets1[1][$i]);
					if($encode_type=="utf-8")
					$fr.=utf8_decode($charsets1[1][$i]);
					if($encode_type=="Q")
					$fr.=quoted_printable_decode($charsets1[1][$i]);

					if($chset1!="UTF-8")
					$fr1=iconv($chset,'UTF-8',$fr);
					else
					{
						mb_internal_encoding('UTF-8');
						$fr1=mb_decode_mimeheader($fr);
					}
				}
			}
			//return $sub;
		}
		else
		{
			$fr1=$from;
		}
		return $fr1;
	}
	function getDecodedSubject($subject)
	{
		$subject=trim($subject);
		preg_match('/=\?(.+?)\?/i',$subject,$chars);
		$charset=$chars;

		//mb_internal_encoding('UTF-8');
		//echo mb_decode_mimeheader($subject);exit;


		if(count($charset)!=0)
		{
			preg_match_all('/=\?(.+?)\?=/i',$subject,$charsets1);
			$sub="";$sub1="";
			for($i=0;$i<count($charsets1[1]);$i++)
			{
				preg_match('/(.+?)\?/i',$charsets1[1][$i],$charset2);
				$chset=$charset2[1];$chset1=trim(strtoupper($chset));
				if(trim($charset2[1])=="Big5" || trim($charset2[1])=="GB2312")
				{
					mb_internal_encoding('UTF-8');
					$sub1=mb_decode_mimeheader($subject);
				}
				else
				{
					preg_match('/\?(.+?)\?/i',$charsets1[1][$i],$charset1);
					$encode_type=$charset1[1];
					$len=strpos($charsets1[1][$i],$encode_type);
					$charsets1[1][$i]=substr($charsets1[1][$i],($len+2));

					if($encode_type=="B")
					$sub.=base64_decode($charsets1[1][$i]);
					if($encode_type=="utf-8")
					$sub.=utf8_decode($charsets1[1][$i]);
					if($encode_type=="Q")
					$sub.=quoted_printable_decode($charsets1[1][$i]);
					
					if($chset1!="UTF-8")
					$sub1=iconv($chset,'UTF-8',$sub);
					else
					{
						mb_internal_encoding('UTF-8');
						$sub1=mb_decode_mimeheader($subject);
					}


				}
			}

			
			return $sub1;
		}
		else
		{
			$sub1=$subject;
		}//exit;
		return $sub1;
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

	function saveLogs($operation,$comment)
	{
		$userid=$this->getId();
		$insert=new NesoteDALController();
		$insert->insert("nesote_email_client_logs");
		$insert->fields("uid,operation,comment,time");
		$insert->values(array($userid,$operation,$comment,time()));
		$insert->query();
		return;
	}
	function getimageformats()
	{

		return "jpeg,jpg,png,gif,bmp,psd,thm,tif,yuv,3dm,pln";
	}

	function getattachcount($references)
	{
		$username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);
		$userid=$this->getId();
		preg_match_all('/<folderid>(.+?)<\/folderid>/i',$references,$folderArray);
		preg_match_all('/<mailid>(.+?)<\/mailid>/i',$references,$mailidArray);
		$no=count($folderArray[1]);
		$w=0;
		$db= new NesoteDALController();
		for($i=0;$i<$no;$i++)
		{
			
			$db->select("nesote_email_attachments_$tablenumber");
			$db->fields("id");
			$db->where("mailid=? and folderid=? and attachment=? and userid=?",array($mailidArray[1][$i],$folderArray[1][$i],1,$userid));
			$result=$db->query();
			$no=$db->numRows($result);
			$w=$w+$no;
		}
		if($w==0)
		return "";
		else
		return "<img src=\"images/attachment.png\" border=\"0\">";
	}

	function getstar($references)
	{
		$username=$_COOKIE['e_username'];
		$tablenumber=$this->tableid($username);
		
		preg_match_all('/<folderid>(.+?)<\/folderid>/i',$references,$folderArray);
		preg_match_all('/<mailid>(.+?)<\/mailid>/i',$references,$mailidArray);
		$no=count($folderArray[1]);
		$w=0;
		for($i=0;$i<$no;$i++)
		{
			if($folderArray[1][$i]==5)
			return 0;
			else
			{
				$db=new NesoteDALController();
				if($folderArray[1][$i]==1)
				$db->select("nesote_email_inbox_$tablenumber");
				else if($folderArray[1][$i]==2)
				$db->select("nesote_email_draft_$tablenumber");
				else if($folderArray[1][$i]==3)
				$db->select("nesote_email_sent_$tablenumber");
				else if($folderArray[1][$i]==4)
				$db->select("nesote_email_spam_$tablenumber");
				else if($folderArray[1][$i]>=10)
				$db->select("nesote_email_customfolder_mapping_$tablenumber");
				$db->fields("starflag");
				$db->where("id=?",array($mailidArray[1][$i]));
				$rs=$db->query();
				$rows=$db->fetchRow($rs);
				if($rows[0]==1)
				{
					$w=1;
					break;
				}

			}

		}
		return $w;

	}

	function gettime($date)
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

		$ts=$date;

		$tsa=time()-$date+$diff;
		$year1= date("Y",$date);
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

			$lang_code=$settings->getValue("default_language");
			$defaultlang_code=$settings->getValue("default_language");
			
		}
         $lang_id=$this->getlang_id($lang_code);
		$day=date(" j ",$date);

		
		$db3->select("nesote_email_months_messages");
		$db3->fields("message");
		$db3->where("month_id=? and lang_id=?",array($month_id,$lang_id));
		$result=$db3->query();
		$data=$db3->fetchRow($result);
		if($data[0]=="")
		{
			
			$db3->select("nesote_email_months_messages");
			$db3->fields("message");
			$db3->where("month_id=? and lang_id=?",array($month_id,1));
			$result=$db3->query();
			$data=$db3->fetchRow($result);
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
	function substringMail($content)
	{
		$count=250;
		
		$content=strip_tags($content);

		return substr($content,0,$count);
	}

	function getfoldername($folderid)
	{

		if($folderid==1)
		{
			return 'inbox';
		}
		else if($folderid==2)
		{
			return 'draft';
		}
		else if($folderid==3)
		{
			return 'sent';
		}
		else if($folderid==4)
		{
			return 'spam';
		}
		else if($folderid==5)
		{
			return 'trash';
		}
		else if($folderid==6)
		{
			return 'starred';
		}
		else
		{
			$db=new NesoteDALController();
			$db->select("nesote_email_customfolder");
			$db->fields("name");
			$db->where("id=?",$folderid);
			$rs1=$db->query();
			$row=$db->fetchRow($rs1);
			return $row[0];
		}

	}
	function iconv_mime_decode_mail($str, $mode=0, $charset="UTF-8")
	{
		$data = imap_mime_header_decode($str);
		if (count($data) > 0) {
			// because iconv doesn't like the 'default' for charset
			$charset = ($data[0]->charset == 'default') ? 'ASCII' : $data[0]->charset;
			return(iconv($charset, $charset, $data[0]->text));
		}
		return("");
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
};
?>
