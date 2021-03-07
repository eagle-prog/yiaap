<?php
class ContactsController extends NesoteController
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
	function getcontactsAction()
	{
	    //echo "aaa";exit;
		if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

		$db=new NesoteDALController();
		$userid=$this->getId();
		$contactName=$this->getParam(1);
		$contactGroup=$this->getParam(2);
		//global addressbok
		if($contactGroup=="global")
		$contactGroup=-1;
		if($contactGroup=="mycontacts")
		$contactGroup=0;

		if($contactGroup==-1)
		{

			$db->select(array("a"=>"nesote_inoutscripts_users","b"=>"nesote_email_usersettings"));
			$db->fields("a.id,a.username,a.name,b.dateofbirth,b.country");
			$db->where("a.status=? and a.id=b.userid",array(1));
			$db->order("a.name asc");
			$resultg=$db->query();//echo $db->getQuery();
			$i=0;
			while($row1=$db->fetchRow($resultg))
			{
				$contacts.=trim($row1[0])."{nesote_c}";
				$contacts.=trim($row1[1]).$this->getextension()."{nesote_c}";;

				$contacts.="-1{nesote_c}";
				$contacts.=trim($row1[2])."{nesote_c}";
				$contacts.="{nesote_c}";
				$contacts.=trim(date("j/m/Y",$row1[3]))."{nesote_c}";
				$contacts.=trim($row1[4])."{nesote_c}";

				$contacts.="{nesote_c}";
				$contacts.="{nesote_c}";
				$contacts.="{nesote_c}";
				$contacts.="{nesote_c}";
				$i++;
			}
		}
		else
		{
			$db->select("nesote_email_contacts");
			$db->fields("*");
			$db->where("addedby=? and contactgroup=?",array($userid,$contactGroup));
			$result=$db->query();//echo $db->getQuery();exit;
			$no=$db->numRows($result);
			$this->setValue("mycontact_total",$no);
			$i=0;

			while($row1=$db->fetchRow($result))
			{
				$contacts.=trim($row1[0])."{nesote_c}";
				$contacts.=trim($row1[1])."{nesote_c}";

				$contacts.=trim($row1[3])."{nesote_c}";
				$contacts.=trim($row1[4])."{nesote_c}";
				$contacts.=trim($row1[5])."{nesote_c}";
				$contacts.=trim(date("j/m/Y",$row1[6]))."{nesote_c}";
				$contacts.=trim($row1[7])."{nesote_c}";
				$contacts.=trim($row1[8])."{nesote_c}";
				$contacts.=trim($row1[9])."{nesote_c}";
				$contacts.=trim($row1[10])."{nesote_c}";
				$contacts.=trim($row1[11])."{nesote_c}";
				$i++;
			}
		}
		$contacts=substr($contacts,0,-10);
		print_r($contacts);
		exit;
	}
	function importAction()
	{
		$userid=$this->getId();
		$YOUR_EMAIL		 = $this->getParam(1);
		$YOUR_PASSWORD 	 = $this->getParam(2);

		require("class/baseclass/baseclass.php");

		$usrdomain="gmail.com";
		require("class/gmail/libgmailer.php");
		$YOUR_EMAIL = $YOUR_EMAIL."@".$usrdomain;
		$obj = new GMailer();
		$contacts = $obj->getAddressbook($YOUR_EMAIL,$YOUR_PASSWORD);


		$str="";
		if(is_array($contacts))
		{
			$totalRecords=0;

			$total = sizeof($contacts['name']);
			$select=new NesoteDALController();
			$db=new NesoteDALController();
			for ($i=0;$i< $total;$i++)
			{
				$db->select("nesote_email_contacts");
				$db->fields("*");
				$db->where("addedby=? and contactgroup=? and mailid=?",array($userid,0,$contacts['email'][$i]));
				$result=$db->query();//echo $db->getQuery();
				$no=$db->numRows($result);
				$totalRecords = $totalRecords+1;
				if($no==0)
				{
					$select->insert("nesote_email_contacts");
					$select->fields("mailid,addedby,contactgroup,firstname");
					$select->values(array($contacts['email'][$i],$userid,0,$contacts['name'][$i] ));
					$select->query();


				}
			}
		}
		$db=new NesoteDALController();
		$db->select("nesote_email_contacts");
		$db->fields("*");
		$db->where("addedby=? and contactgroup=? ",array($userid,0));
		$result=$db->query();
		$no=$db->numRows($result);
		echo "{nesote_c#123}".$no;exit;

	}
	
	/**
	 * This Function extracts contact information from Vcard file
	 */
	function import_vcardAction()
	{	
		
		
		
			$filename=$_FILES['vcard_holder']['tmp_name'];
		
			$extension = pathinfo($_FILES['vcard_holder']['name'],PATHINFO_EXTENSION);
			
			$allowed_extns1=array('vcard','vcf');
		 	
			if(!in_array($extension,$allowed_extns1))
			{
				echo "Invalid File Extension";exit;
			}
			else 
			{	
			
				$userid=$this->getId();
				
			///	include 'class/contacts/Contact/Vcard/Build.php';
				
		// include this class file
		 require_once 'class/contacts/Contact/Vcard/Parse.php';
		// instantiate a parser object
		 $parse = new Contact_Vcard_Parse();
		// parse a vCard file and store the data
		// in $cardinfo
		 $cardinfo = $parse->fromFile($filename);
		 $db=new NesoteDALController();
		 $select=new NesoteDALController();
		 foreach($cardinfo as $card)
		 {
		 	
		 	
		 	
		 $fullname=$card['FN'][0]['value'][0][0];
		 
		 if($fullname=="")
		 {
		 	
		 	$fullname=$card['N'][0]['value'][0][0].$card['N'][0]['value'][1][0];
		 }
		 
		 
		 $email_address=$card['EMAIL'][0]['value'][0][0];

		 
		 
		 $db->select("nesote_email_contacts");
		 $db->fields("*");
		 $db->where("addedby=? and contactgroup=? and mailid=?",array($userid,0,$email_address));
		 $result=$db->query();//echo $db->getQuery();
		 $no=$db->numRows($result);
		 $totalRecords = $totalRecords+1;
		 if($no==0)
		 {
		 	$select->insert("nesote_email_contacts");
		 	$select->fields("mailid,addedby,contactgroup,firstname");
		 	$select->values(array($email_address,$userid,0,$fullname));
		 	$select->query();
		 
		 
		 }
		 
		 
		 
		 
		 
		 
		 
		
		 
		 }
		 
		 header("Location:".$this->url("mail/mailbox#contacts"));
		exit;
			}
	}
	
	
	
	
	///////////////////////////Function Used to export webmail contacts to csv or Vcard
	
	function exportcontactsAction()
	{
		//include 'class/vcardphp-1.1.2/vcard.php';

		include 'class/contacts/Contact/Vcard/Build.php';
	
		$userid=$this->getId();
		$contactids=urldecode($this->getParam(2));
		$type=$this->getParam(1);
                
                //$contactids=$_POST['contactids'];
                //$contactids=urldecode($contactids);
		//$type=$_POST['type1'];
	
		if(empty($contactids))
		{
			header("location".$this->url("mail/mailbox#contacts"));exit(0);
		}
	
		$db=new NesoteDALController();
	
	
		$contacts_array=explode(",",substr($contactids,0,-1));
			
	
	
		if($type==1)
		{///CSV
			echo $contactids;exit;
		}
		else
		{//Vacrd
			$vcard1='';	
				
			for($i=0;$i<count($contacts_array);$i++)
			{
	
	
			$db->select("nesote_email_contacts");
			$db->fields("*");
			$db->where("addedby=? and id=?",array($userid,$contacts_array[$i]));
			$result=$db->query();
			while($row=$db->fetchRow($result))
			{
				
				
			// instantiate a builder object
				// (defaults to version 3.0)
						$vcard = new Contact_Vcard_Build();
							
						// set a formatted name
			$vcard->setFormattedName($row[4]."".$row[5]);
				
			// set the structured name parts
			$vcard->setName($row[5], $row[4],'','','');
				
			// add a work email.  note that we add the value
			// first and the param after -- Contact_Vcard_Build
			// is smart enough to add the param in the correct
			// place.
			//$vcard->addEmail($row[1]);
			//$vcard->addParam('TYPE', 'WORK');
				
			// add a home/preferred email
			$vcard->addEmail($row[1]);
			//$vcard->addParam('TYPE', 'HOME');
			$vcard->addParam('TYPE', 'PREF');
				
			//add Telephone
			if(!empty($row[9]))
			{
			$vcard->addTelephone($row[9]);
			$vcard->addParam('TYPE','HOME');
			$vcard->addParam('TYPE','VOICE');
			}
			// add a work address
				
			if(!empty($row[10]))
			{
			$vcard->addAddress($row[10]);
			$vcard->addParam('TYPE', 'HOME');
			}
			//add birthday
			if(!empty($row[6]))
				{
				$vcard->setBirthday($row[6]);
			}
			//add URL
			if(!empty($row[11]))
			{
			$vcard->setURL($row[11]);
			}
			//add company
			if(!empty($row[8]))
			{
			$vcard->addOrganization($row[8]);
			}
				
			// set the title (checks for colon-escaping)
			if(!empty($row[7]))
			{
			$vcard->setTitle($row[7]);
			}

			// send the vcard
			header('Content-Type: text/plain');
                        //$vcard1='';
			$vcard1.=$vcard->fetch();
			}
		}
//print_r($vcard);exit;							
			$filename='mycontacts.vcf';
			$disposition = 'attachment';
			$charset = 'us-ascii';
			header('Content-Type: application/directory;'.
			'profile="vcard";'.
			'charset='.$charset);
			header('Content-Length:'.strlen($vcard1));
			header("Content-Disposition: $disposition; filename=$filename");
			echo $vcard1;
			exit;
		}
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
	function editfolderAction()
	{
		$flag=1;$msg="";$msg1="";$userid=$this->getId();
		$db=new NesoteDALController();
		$id=$this->getParam(1);
		$name=$this->getParam(2);
		if($name=="")
		{
			$cgid="errmsg";
			$msg1=$this->getmessage(325);
			echo $cgid."/".$cgid."/".$msg1;die;
		}


		$cmpstr=strcmp(strtolower($name),strtolower($this->getmessage(209)));
		if($cmpstr==0)
		{


			$msg1=$this->getmessage(475);
			//$msg1=str_replace('{groupname}',$groupname,$msg);

			$magic=get_magic_quotes_gpc();
			if($magic==1)
			{
				$msg1=stripslashes($msg1);
			}

			$cgid="errmsg";
			echo $cgid."/".$cgid."/".$msg1;die;

		}
		$cmpstr1=strcmp(strtolower($name),strtolower($this->getmessage(456)));
		if($cmpstr1==0)
		{
			$flag=0;


			$msg1=$this->getmessage(475);
			//$msg1=str_replace('{groupname}',$groupname,$msg);

			$magic=get_magic_quotes_gpc();
			if($magic==1)
			{
				$msg1=stripslashes($msg1);
			}
			$cgid="errmsg";
			echo $cgid."/".$cgid."/".$msg1;die;

		}



		$db->select("nesote_email_contactgroup");
		$db->fields("name");
		$db->where("userid=? and id!=?",array($userid,$id));
		$rs1=$db->query();
		while($row1=$db->fetchRow($rs1))
		{
			if(trim($row1[0])==trim(stripslashes($name)))
			{
				$flag=0;break;
			}
		}

		if($flag==0)
		{

			$msg1=$this->getmessage(475);
			//$msg1=str_replace('{groupname}',$name,$msg);


			$db->select("nesote_email_contacts");
			$db->fields("id");
			$db->where("contactgroup=? and addedby=?",array($id,$userid));
			$db->order("mailid asc");
			$db->limit(0,1);
			$result30=$db->query();
			$num30=$db->numRows($result30);
			if($num30!=0)
			{
				$row30=$db->fetchRow($result30);
				$mailid30=$row30[0];
			}
			else
			{

				$db->select("nesote_inoutscripts_users");
				$db->fields("id");
				$db->where("status=?",array(1));
				$db->order("name asc");
				$db->limit(0,1);
				$result20=$db->query();
				$row20=$db->fetchRow($result20);
				$mailid30=$row20[0];
			}

			$magic=get_magic_quotes_gpc();
			if($magic==1)
			{
				$msg1=stripslashes($msg1);
			}

echo "0/"."errmsg"."/".$msg1;die;			

//echo $id."/".$mailid30."/".$msg1;die;
		}

		//$db=new NesoteDALController();
		$db->select("nesote_email_contactgroup");
		$db->fields("name");
		$db->where("id=? and userid=?",array($id,$userid));
		$rs=$db->query();
		$row=$db->fetchRow($rs);
		$groupname=$row[0];
		if(trim($groupname)==trim($name))
		{


			$flag=0;
			$msg=$this->getmessage(214);
			$msg1=str_replace('{groupname}',$name,$msg);

			$magic=get_magic_quotes_gpc();
			if($magic==1)
			{
				$msg1=stripslashes($msg1);
			}

			$db->select("nesote_email_contacts");
			$db->fields("id");
			$db->where("contactgroup=? and addedby=?",array($id,$userid));
			$db->order("mailid asc");
			$db->limit(0,1);
			$result1=$db->query();
			$num1=$db->numRows($result1);
			if($num1!=0)
			{
				$row1=$db->fetchRow($result1);
				$mailid=$row1[0];
			}
			else
			{

				$db->select("nesote_inoutscripts_users");
				$db->fields("id");
				$db->where("status=?",array(1));
				$db->order("name asc");
				$db->limit(0,1);
				$result20=$db->query();
				$row20=$db->fetchRow($result20);
				$mailid=$row20[0];
			}
			$magic=get_magic_quotes_gpc();
			if($magic==1)
			{
				$msg1=stripslashes($msg1);
			}
			echo $id."/".$mailid."/".$msg1;die;
		}

		if($flag==1)
		{
			//$db=new NesoteDALController();
			$db->update("nesote_email_contactgroup");
			$db->set("name=?",array($name));
			$db->where("id=?",array($id));
			$rs=$db->query();

			$userid=$this->getId();
			$username=$this->getusername($userid);
			$groupname1=mysqli_REAL_escape_string($conn,$groupname);
			$this->saveLogs("Edit Contactgroup","$username has edited contactgroup $groupname1");

			//		$url=$this->url("layout/contactsleftpanel/$id");
			//		echo $url;die;

			$msg=$this->getmessage(214);
			$msg1=str_replace('{groupname}',$name,$msg);

			$magic=get_magic_quotes_gpc();
			if($magic==1)
			{
				$msg1=stripslashes($msg1);
			}
		}


		$db->select("nesote_email_contacts");
		$db->fields("id");
		$db->where("contactgroup=? and addedby=?",array($id,$userid));
		$db->order("mailid asc");
		$db->limit(0,1);
		$result1=$db->query();
		$num=$db->numRows($result1);
		if($num!=0)
		{
			$row1=$db->fetchRow($result1);
			$mailid=$row1[0];
		}
		else
		{

			$db->select("nesote_inoutscripts_users");
			$db->fields("id");
			$db->where("status=?",array(1));
			$db->order("name asc");
			$db->limit(0,1);
			$result20=$db->query();
			$row20=$db->fetchRow($result20);
			$mailid=$row20[0];
		}
		echo $id."/".$mailid."/".$msg1;die;
	}
	function addfolderAction()
	{
		if(!$this->validateUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

		$userid=$this->getId();$flag=1;
		$foldername=$this->getParam(1);

		$db=new NesoteDALController();

		$db->select("nesote_email_customfolder");
		$db->fields("name");
		$db->where("userid=?",array($userid));
		$rs=$db->query();
		while($rw=$db->fetchRow($rs))
		{
			if(trim($foldername)==trim($rw[0]))
			{
				$flag=0;break;
			}
		}
		if($flag==0)
		{
			$id=$_COOKIE['currentcontact'];
			$msg1=$this->getmessage(317);
			$s="";
			echo $id."/".$s."/".$msg1;die;
		}

		if($flag==1)
		{

			$db->insert("nesote_email_customfolder");
			$db->fields("name,userid");
			$db->values(array($foldername,$userid));
			$db->query();
			$lastinsertid=$db->lastInsertid("nesote_email_customfolder");//echo $lastinsertid;exit;
			mkdir("attachments/$lastinsertid",0777);
			$userid1=$this->getId();
			$username1=$this->getusername($userid1);
			$this->saveLogs("New mail folder","$username1 has added new mail folder");

			$msg=$this->getmessage(221);
			$msg1=str_replace('{foldername}',$foldername,$msg);

			//echo $insertid;die;
			$s="";
			echo $lastinsertid."/".$s."/".$msg1;die;
		}

	}
	function newgroupAction()
	{
		if(!$this->validateUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

		$userid=$this->getId();$flag=1;$msg="";$msg1="";

		$db=new NesoteDALController();

		$groupname=$this->getParam(1);
		$stringids=$this->getParam(2);//for dropdown groupcreation
		//$cgid=$this->getParam(3);
		$cgid=$_COOKIE['currentcontct'];
		//setcookie("contact",$cgid,0,"/");
		if($groupname=="")
		{
			$cgid="errmsg";
			$msg1=$this->getmessage(325);
			echo "0/".$cgid."/".$msg1;die;
		}
		$cmpstr=strcmp(strtolower($groupname),strtolower($this->getmessage(209)));
		if($cmpstr==0)
		{
			$flag=0;


			$msg1=$this->getmessage(475);
			//$msg1=str_replace('{groupname}',$groupname,$msg);

			$magic=get_magic_quotes_gpc();
			if($magic==1)
			{
				$msg1=stripslashes($msg1);
			}
			$cgid="errmsg";
			echo "0/".$cgid."/".$msg1;die;

		}

		$cmpstr1=strcmp(strtolower($groupname),strtolower($this->getmessage(456)));
		if($cmpstr1==0)
		{
			$flag=0;


			$msg1=$this->getmessage(475);
			//$msg1=str_replace('{groupname}',$groupname,$msg);

			$magic=get_magic_quotes_gpc();
			if($magic==1)
			{
				$msg1=stripslashes($msg1);
			}
			$cgid="errmsg";
			echo "0/".$cgid."/".$msg1;die;

		}


		$db->select("nesote_email_contactgroup");
		$db->fields("name");
		$db->where("userid=?",array($userid));
		$rs9=$db->query();
		while($rw9=$db->fetchRow($rs9))
		{
			if(trim(stripslashes($groupname))==trim($rw9[0]))
			{
				$flag=0;
				break;


			}
		}

		if($flag==0)
		{
			$msg1=$this->getmessage(475);
			//$msg1=str_replace('{groupname}',$groupname,$msg);

			$magic=get_magic_quotes_gpc();
			if($magic==1)
			{
				$msg1=stripslashes($msg1);
			}
			$cgid="errmsg";
			echo "0/".$cgid."/".$msg1;die;
		}

		$id=0;
		if($flag==1)
		{

			if($stringids!="")
			{



				$stringids1=explode(",",$stringids);$count=0;
				$cnt=count($stringids1);

				if($cnt!=0)
				{

					$db->insert("nesote_email_contactgroup");
					$db->fields("name,userid");
					$db->values(array($groupname,$userid));
					$db->query();
					$insertidg=$db->lastInsertid("nesote_email_contactgroup");
					setcookie("contact",$insertidg,0,"/");

					$userid=$this->getId();
					$username=$this->getusername($userid);
					$groupname1=mysqli_REAL_escape_string($conn,$groupname);
					$this->saveLogs("New Contactgroup","$username has added new contactgroup $groupname1 to  his/her contacts  ");
				}
				$c=0;$i=0;
				for($i=0;$i<$cnt;$i++)
				{
					if($stringids1[$i]!="")
					{


						$db->select("nesote_email_contacts");
						$db->fields("*");
						if($cgid!=0)
						$db->where("id=? and contactgroup=? and addedby=?",array($stringids1[$i],$cgid,$userid));
						else
						$db->where("id=? and addedby=?",array($stringids1[$i],$userid));
						$rs=$db->query();//echo $db->getQuery();
						$rw=$db->fetchRow($rs);
						$rr=$db->numRows($rs);

						if($rr==0)
						{

						   $db->select(array("a"=>"nesote_inoutscripts_users","b"=>"nesote_email_usersettings"));
						   $db->fields("a.username,a.name,b.dateofbirth");
						   $db->where("a.id=? and a.status=? and a.id=b.userid",array($stringids1[$i],1));
						   $rs=$db->query();
							$user=$db->fetchRow($rs);
							$num=$db->numRows($rs);
							$mailid=$user[0].$this->getextension();


							$db->insert("nesote_email_contacts");
							$db->fields("mailid,addedby,contactgroup,firstname,date_of_birth");
							$db->values(array($mailid,$userid,$insertidg,$user[1],$user[2]));
							$db->query();
						}
						else
						{

							$db->insert("nesote_email_contacts");
							$db->fields("mailid,addedby,contactgroup,firstname,lastname,date_of_birth,title,company,phone,address,website");
							$db->values(array($rw[1],$userid,$insertidg,$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11]));
							$db->query();//echo $db1->getQuery();
						}
						$lastinsertid=$db->lastInsertid("nesote_email_contacts");
						$count+=mysqli_affected_rows($conn);
					}


				}

				$userid1=$this->getId();
				$username1=$this->getusername($userid1);
				$this->saveLogs("New Contact","$username has added $email to his/her group");

				$groupname=$this->getgroupname($insertidg);
				$msg=$this->getmessage(305);
				$msg1=str_replace('{number}',$count,$msg);
				$msg1=str_replace('{groupname}',$groupname,$msg1);

				$magic=get_magic_quotes_gpc();
				if($magic==1)
				{
					$msg1=stripslashes($msg1);
				}
				$msg1=htmlspecialchars($msg1);
				$cgid=$insertidg;//echo $cgid;exit;

				$db->select("nesote_email_contacts");
				$db->fields("id");
				if($cgid!=0)
				$db->where("contactgroup=? and addedby=?",array($cgid,$userid));
				else
				$db->where("addedby=?",array($userid));
				$db->order("mailid asc");
				$db->limit(0,1);
				$rs2=$db->query();//echo $db2->getQuery();
				$rw2=$db->fetchRow($rs2);


				$url=$cgid."/".$rw2[0]."/".$msg1."/".$count;;
				echo $url;exit(0);
			}


			$db->insert("nesote_email_contactgroup");
			$db->fields("name,userid");
			$db->values(array($groupname,$userid));
			$db->query();
			$insertid=$db->lastInsertid("nesote_email_contactgroup");
			setcookie("contact",$insertid,0,"/");
			//echo $insertid;exit;
			$userid=$this->getId();
			$username=$this->getusername($userid);
			$groupname1=mysqli_REAL_escape_string($conn,$groupname);
			$this->saveLogs("New Contactgroup","$username has added new contactgroup $groupname1 to  his/her contacts");
			//$gid=$db->lastInsert();

			//			header("Location:".$this->url("layout/contactsleftpanel"));
			//
			//			exit(0);

			$msg=$this->getmessage(215);
			$msg1=str_replace('{groupname}',$groupname,$msg);

			$magic=get_magic_quotes_gpc();
			if($magic==1)
			{
				$msg1=stripslashes($msg1);
			}
			$msg1=htmlspecialchars($msg1);


			//echo $insertid;die;
			$id=$insertid;
			$db->select("nesote_inoutscripts_users");
			$db->fields("id");
			$db->where("status=?",array(1));
			$db->order("name asc");
			$db->limit(0,1);
			$result1=$db->query();
			$row1=$db->fetchRow($result1);
			$cgid="global";



			echo $insertid."/".$row1[0]."/".$msg1;die;
		}



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
				if($result[0]!="" && $result[1]!="")
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
	function getgroupname($id)
	{//echo hai;
		$userid=$this->getId();

		$db=new NesoteDALController();
		$db->select("nesote_email_contactgroup");
		$db->fields("name");
		$db->where("id=? and userid=?", array($id,$userid));
		$result=$db->query();
		$rs=$db->fetchRow($result);
		$gpname=$rs[0];return  $gpname;
		//return $gpname;
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
	function newcontactAction()
	{

		$flag=1;

		if(!$this->validateUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

		$userid=$this->getId();




		$select=new NesoteDALController();


		$select->select("nesote_email_contactgroup");
		$select->fields("*");
		$select->order("name asc");
		$select->where("userid=?",array($userid));
		$result=$select->query();//echo $select->getQuery();
		$this->setValue("num",$select->numRows($result));

		$this->setLoopValue("groups",$result->getResult());







		$select->select("nesote_email_contacts");
		$select->fields("id");
		$select->where("addedby=? and contactgroup=?",array($userid,0));
		$select->order("mailid asc");
		$select->limit(0,1);
		$result=$select->query();
		$row1=$select->fetchRow($result);

		$firstname=$_POST['firstname'];

		if($firstname==""||$firstname=="null")
		{
			$msg=$this->getmessage(112);
			//header("Location:".$this->url("contacts/contactsdetail/0/$row1[0]/1/$msg"));
			echo $msg."||0";
			exit(0);
		}

		$lastname=$_POST['lastname'];

		if($lastname==""||$lastname=="null")
		{
			$msg=$this->getmessage(113);
			echo $msg."||0";
			//header("Location:".$this->url("contacts/contactsdetail/0/$row1[0]/1/$msg"));
			exit(0);
		}

		$email=$_POST['email'];
		if($email=="")
		{
			$msg=$this->getmessage(224);
			echo $msg."||0";
			//header("Location:".$this->url("contacts/contactsdetail/0/$row1[0]/1/$msg"));
			exit(0);
		}

		$validemail=$this->isValid($email);
		if($validemail==FALSE)
		{

			$msg=$this->getmessage(225);
			echo $msg."||0";
			//header("Location:".$this->url("contacts/contactsdetail/0/$row1[0]/1/$msg"));
			exit(0);
		}

		$group=$_POST['group'];
		if($group=="")
		$group=0;


		$select->select("nesote_email_contacts");
		$select->fields("mailid,id");
		$select->where("addedby=? and contactgroup=?",array($userid,$group));
		$result=$select->query();
		while($row=$select->fetchRow($result))
		{
			if($email==$row[0])
			{
				$flag=0;
				$id=$row[1];

			}


		}
		setcookie("contact",$group,0,"/");
		if($flag==0)
		{
			$msg=$this->getmessage(228);
			//				header("Location:".$this->url("contacts/contactsdetail/$group/$row[1]/1/$msg"));
			//				exit(0);


			$select->select("nesote_email_contacts");
			$select->fields("id");
			$select->where("addedby=? and contactgroup=?",array($userid,$group));
			$select->order("mailid desc");
			$select->limit(0,1);
			$result=$select->query();
			$row1=$select->fetchRow($result);
			echo $msg."||0";
			//header("Location:".$this->url("contacts/contactsdetail/$group/$row1[0]/1/$msg"));
			exit(0);
		}

		$address=$_POST['address'];
                if($address=="null")
                {
                   $address="";
                }
    
		$dob=$_POST['dob'];
                if($dob=="null")
                {
                     $dob="";
                }else{
                $dob11=explode("/",$dob);
                $checkdob=checkdate($dob11[1], $dob11[0], $dob11[2]);
                if($checkdob!=1){
                	$msg=$this->getmessage(786);
                	echo $msg."||3443";
					exit(0);
                }
            	}

		$dob=explode("/",$dob);
		/*strtolower($dob[0]);
		if($dob[0]=='jan')
		$dob[0]=1;
		else if($dob[0]=='feb')
		$dob[0]=2;
		else if($dob[0]=='mar')
		$dob[0]=3;
		else if($dob[0]=='apr')
		$dob[0]=4;
		else if($dob[0]=='may')
		$dob[0]=5;
		else if($dob[0]=='jun')
		$dob[0]=6;
		else if($dob[0]=='jul')
		$dob[0]=7;
		else if($dob[0]=='aug')
		$dob[0]=8;
		else if($dob[0]=='sep')
		$dob[0]=9;
		else if($dob[0]=='oct')
		$dob[0]=10;
		else if($dob[0]=='nov')
		$dob[0]=11;
		else if($dob[0]=='dec')
		$dob[0]=12;*/

		$dob=mktime(0,0,0,$dob[1],$dob[0],$dob[2]);

		$phone=$_POST['phone'];
                if($phone=="null"){$phone="";}

/*
		if($phone=="")
		{
			$msg=$this->getmessage(314);
			echo $msg."||0";
			//header("Location:".$this->url("contacts/contactsdetail/0/$row1[0]/1/$msg"));
			exit(0);
		}
*/
           if($phone!="")
           {
		if(!is_numeric($phone))
		{
			$msg=$this->getmessage(226);
			echo $msg."||0";
			//header("Location:".$this->url("contacts/contactsdetail/0/$row1[0]/1/$msg"));
			exit(0);
		}
            }

		$title=$_POST['title'];if($title=="null"){$title="";}
		$company=$_POST['company'];if($company=="null"){$company="";}
		$website=trim($_POST['website']);if($website=="null"){$website="";}
 if($website!="")
                 {
                 $website = filter_var($website, FILTER_SANITIZE_URL);

                if(!filter_var($website,FILTER_VALIDATE_URL))
                 {
                         $msg="The website url is in invalid format";
                         echo $msg."||0";exit(0);
                 }   
             }

  
		if($flag==1)
		{

			$select->insert("nesote_email_contacts");
			$select->fields("mailid,addedby,contactgroup,firstname,lastname,date_of_birth,title,company,phone,address,website");
			$select->values(array($email,$userid,$group,$firstname,$lastname,$dob,$title,$company,$phone,$address,$website));
			$select->query();



			//				header("Location:".$this->url("mail/mailframe/1"));
			//				exit(0);
			$insertid=$select->lastInsertid("nesote_email_contacts");
			$username=$this->getusername($userid);
			$this->saveLogs("New Contact","$username has added $email to his/her contacts");


			$select->select("nesote_email_contacts");
			$select->fields("id");
			$select->where("addedby=? and contactgroup=?",array($userid,$group));
			$result=$select->query();
			$rownum=$select->numRows($result);

			//$this->setRedirect("contacts/contacts/$group");
			$msg=$this->getmessage(223);
			echo $msg."||1||".$rownum."||".$insertid;
			//header("Location:".$this->url("contacts/contactsdetail/$group/$insertid/2/$msg"));
			//echo $group."/".$insertid."/2/".$msg;
			exit(0);
		}
		//		header("Location:".$this->url("contacts/contactsdetail"));
		//		exit(0);


	}

	function editcontactAction()
	{
		$flag=1;

		if(!$this->validateUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

		$userid=$this->getId();



		$select=new NesoteDALController();


		$cid=$_POST['cid'];
		$firstname=trim($_POST['firstname']);

		if(($firstname=="")||(is_null($firstname)||$firstname=="null"))
		{
			$msg=$this->getmessage(112);
			//header("Location:".$this->url("contacts/contactsdetail/0/$row1[0]/1/$msg"));
			echo $msg."||0";
			exit(0);
		}

		$lastname=trim($_POST['lastname']);

		if(($lastname=="")||(is_null($lastname)||$lastname=="null"))
		{
			$msg=$this->getmessage(113);
			echo $msg."||0";
			//header("Location:".$this->url("contacts/contactsdetail/0/$row1[0]/1/$msg"));
			exit(0);
		}

		$email=trim($_POST['email']);
		if(($email=="")||(is_null($email)))
		{
			$msg=$this->getmessage(224);
			echo $msg."||0";
			//header("Location:".$this->url("contacts/contactsdetail/0/$row1[0]/1/$msg"));
			exit(0);
		}

		$validemail=$this->isValid($email);
		if($validemail==FALSE)
		{

			$msg=$this->getmessage(225);
			echo $msg."||0";
			//header("Location:".$this->url("contacts/contactsdetail/0/$row1[0]/1/$msg"));
			exit(0);
		}

		$group=$_POST['group'];
		if(($group=="")||($group=="null"))
		$group=0;


		$select->select("nesote_email_contacts");
		$select->fields("mailid");
		$select->where("addedby=? and contactgroup=? and id=?",array($userid,$group,$cid));
		$result=$select->query();
		$row1=$select->fetchRow($result);// if mail id same as the edited id  then msg canot display.ok..edit ss@ss.com to ss@ss.com ok..


		$select->select("nesote_email_contacts");
		$select->fields("mailid");
		$select->where("addedby=? and contactgroup=?",array($userid,$group));
		$result1=$select->query();
		while($row=$select->fetchRow($result1))
		{
			if($email==$row[0] && $email!=$row1[0])
			{
				//echo "here";
				$flag=0;
			}
		}
		setcookie("contact",$group,0,"/");
		if($flag==0)
		{
			$msg=$this->getmessage(228);
			//				header("Location:".$this->url("contacts/contactsdetail/$group/$row[1]/1/$msg"));
			//				exit(0);


			$select->select("nesote_email_contacts");
			$select->fields("id");
			$select->where("addedby=? and contactgroup=?",array($userid,$group));
			$select->order("mailid desc");
			$select->limit(0,1);
			$result=$select->query();
			$row1=$select->fetchRow($result);
			echo $msg."||0";
			//header("Location:".$this->url("contacts/contactsdetail/$group/$row1[0]/1/$msg"));
			exit(0);
		}

		$address=trim($_POST['address']);
                if($address=="null"||$address==NULL)
                {
                     $address="";
                }
                 
		$dob=trim($_POST['dob']);
                if($dob=="null"||$dob==NULL)
                {
                     $dob="";
                }
                else{
                $dob11=explode("/",$dob);
                $checkdob=checkdate($dob11[1], $dob11[0], $dob11[2]);
                if($checkdob!=1){
                	$msg=$this->getmessage(786);
                	echo $msg."||3443";
					exit(0);
                }
            	}

		$dob=explode("/",$dob);
		/*strtolower($dob[0]);
		if($dob[0]=='jan')
		$dob[0]=1;
		else if($dob[0]=='feb')
		$dob[0]=2;
		else if($dob[0]=='mar')
		$dob[0]=3;
		else if($dob[0]=='apr')
		$dob[0]=4;
		else if($dob[0]=='may')
		$dob[0]=5;
		else if($dob[0]=='jun')
		$dob[0]=6;
		else if($dob[0]=='jul')
		$dob[0]=7;
		else if($dob[0]=='aug')
		$dob[0]=8;
		else if($dob[0]=='sep')
		$dob[0]=9;
		else if($dob[0]=='oct')
		$dob[0]=10;
		else if($dob[0]=='nov')
		$dob[0]=11;
		else if($dob[0]=='dec')
		$dob[0]=12;*/

		$dob=mktime(0,0,0,$dob[1],$dob[0],$dob[2]);

		$phone=trim($_POST['phone']);
                if(empty($phone)||$phone=="null")
                {
                     $phone="";
                }

/*
		if($phone=="")
		{
			$msg=$this->getmessage(314);
			echo $msg."||0";
			//header("Location:".$this->url("contacts/contactsdetail/0/$row1[0]/1/$msg"));
			exit(0);
		}
*/			
          if($phone!=="")
          {
		if(!is_numeric($phone))
		{
			$msg=$this->getmessage(226);
			echo $msg."||0";
			//header("Location:".$this->url("contacts/contactsdetail/0/$row1[0]/1/$msg"));
			exit(0);
		}
          }

		$title=trim($_POST['title']);
                if(is_null($title)||$title=="null")
                {
                     $title="";
                }

		$company=trim($_POST['company']);
                if(is_null($company)||$company=="null")
                {
                     $company="";
                }

                $website=trim($_POST['website']);
                if(is_null($website)||$website=="null")
                {
                     $website="";
                }
                if($website!="")
                 {
                 $website = filter_var($website, FILTER_SANITIZE_URL);

                if(!filter_var($website,FILTER_VALIDATE_URL))
                 {
                         $msg="The website url is in invalid format";
                         echo $msg."||0";exit(0);
                 }   
             }
		if($flag==1)
		{


			$select->update("nesote_email_contacts");
			$select->set("mailid=?,addedby=?,contactgroup=?,firstname=?,lastname=?,date_of_birth=?,title=?,company=?,phone=?,address=?,website=?",array($email,$userid,$group,$firstname,$lastname,$dob,$title,$company,$phone,$address,$website));
			$select->where("id=?",array($cid));//echo $select->getQuery();
			$select->query();

			//				header("Location:".$this->url("mail/mailframe/1"));
			//				exit(0);
			$insertid=$select->lastInsertid("nesote_email_contacts");

			$select->select("nesote_email_contacts");
			$select->fields("id");
			$select->where("addedby=? and contactgroup=?",array($userid,$group));
			$result=$select->query();
			$rownum=$select->numRows($result);
			$username=$this->getusername($userid);
			$this->saveLogs("Edit Contact","$username has edited  his/her contacts  ");
			//$this->setRedirect("contacts/contacts/$group");
			$msg=$this->getmessage(227);
			echo $msg."||1||".$rownum."||".$insertid;
			//header("Location:".$this->url("contacts/contactsdetail/$group/$insertid/2/$msg"));
			//echo $group."/".$insertid."/2/".$msg;
			exit(0);
		}
		//		header("Location:".$this->url("contacts/contactsdetail"));
		//		exit(0);


	}
//Some Modifications in isValid Function to validate email.
	function isValid($email)
	{
		$result = TRUE;
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                   $result="FALSE";
                    }
             /*if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email))
		{
			$result = FALSE;
		}*/
		return $result;
	}
	function folderdropdownAction()
	{
		$userid=$this->getId();
		$db4=new NesoteDALController();
		$db4->select("nesote_email_contactgroup");
		$db4->fields("*");
		$db4->where("userid=?",array($userid));
		$db4->order("name asc");
		$result4=$db4->query();
		$string="";
		$string.="<select name=\"edit_group\" id=\"edit_group\"  class=\"SelectContact\"><a value=\"0\">".$this->getmessage(210)."</a>";

		while($row4=$db4->fetchRow($result4))
		{

			$string=$string."<option value=\"$row4[0]\">$row4[1]</option>";
		}
		$string.="</select>";
		echo $string;exit(0);
	}
	function getcontactdropdownAction()
	{

		if(!$this->validateUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}


		$userid=$this->getId();
		$id=$this->getParam(1);$id=substr($id,0,-1);
		$id1=explode(",",$id);
		if(count($id1)==1)
		$id="$id";//echo $id;exit;
		$groupid=$this->getParam(2);$flag=0;$mailid="";
		$execute=$this->getParam(3);//1 for global contacts
		$db6=new NesoteDALController();
		if($id=="")
		{
			if($execute!=1)
			{

				$db6->select("nesote_email_contacts");
				$db6->fields("id");
				$db6->where("contactgroup=? and addedby=?",array($groupid,$userid));
				$db6->order("mailid asc");
				$db6->limit(0,1);
				$result0=$db6->query();
				$row1=$db6->fetchRow($result0);
				$id=$row1[0];
			}
			else
			{

				$db6->select("nesote_inoutscripts_users");
				$db6->fields("id");
				$db6->where("status=? ",array(1));
				$db6->order("username asc");
				$db6->limit(0,1);
				$result0=$db6->query();
				$row1=$db6->fetchRow($result0);
				$id=$row1[0];
			}
		}
		if($id!="")
		{

			if($execute==0)
			{
				$db6->select("nesote_email_contacts");
				$db6->fields("mailid");
			}
			else
			{
				$db6->select("nesote_inoutscripts_users");
				$db6->fields("username");
			}
			$db6->where("id in($id)");
			$result=$db6->query();//echo $db->getQuery();
			$number=$db6->numRows($result);
			while($row=$db6->fetchRow($result))
			{
				if($execute==1)
				{
					$p1=$row[0].$this->getextension();
					$mailid=$mailid."'$p1',";
				}
				else
				$mailid=$mailid."'$row[0]',";
			}
			$mailid=substr($mailid,0,-1);//echo $mailid;

			$mailid1=explode(",",$mailid);
			$cnt=count($mailid1);
			if($cnt==1)
			$mailid="$mailid";
			$db6->select("nesote_inoutscripts_users");
			$db6->fields("username");
			$db6->where("status=?",array(1));
			$result1=$db6->query();
			while($row1=$db6->fetchRow($result1))
			{

				$checkmail="";
				for($i=0;$i<$cnt;$i++)
				{
					$checkmail=str_replace(",","",$mailid1[$i]);
					$mail=$row1[0].$this->getextension();$mail="'$mail'";
					if(trim($mail)==trim($checkmail))
					$flag=1;break;
				}


			}

			$p=0;$q=0;$flag1=1;
			$stringidss=array();


			for($i=0;$i<$cnt;$i++)
			{


				$db6->select("nesote_email_contacts");
				$db6->fields("contactgroup");
				$mailid1[$i]=str_replace("\"","",$mailid1[$i]);
				$mailid1[$i]=str_replace("'","",$mailid1[$i]);

				$db6->where("mailid=? and contactgroup!=? and addedby=?",array($mailid1[$i],0,$userid));
				$result3=$db6->query();//echo $db3->getQuery();
				while($row3=$db6->fetchRow($result3))
				{
					$stringidss[$p]=$row3[0];
					$p++;

				}

			}


			$k=0;
			$k1=0;
			for($i=0;$i<$p;$i++)
			{
				$count=0;
				if($cnt==1)
				{
					$stringids_temp[$k]=$stringidss[$i].",";
					$k++;
					continue;
				}
				for($j=0;$j<$p;$j++)
				{
					if($stringidss[$i]==$stringidss[$j])
					{
						$count++;
					}
				}

				if(($cnt)==$count)//problem
				{
					$stringids_temp[$k]=$stringidss[$i].",";
					$k++;
				}
			}

			$string_final="";
			$m=0;
			for($i=0;$i<$k;$i++)
			{
				$check=0;
				for($j=$i+1;$j<$k;$j++)
				{
					if($stringids_temp[$j]==$stringids_temp[$i])
					{
						$check=1;
					}
				}
				if($check==0)
				{
					$string_final.=$stringids_temp[$i];
				}
			}
			$string_final=substr($string_final,0,-1);
			$r=0;
			$db6->select("nesote_email_contacts");
			$db6->fields("distinct(contactgroup)");
			for($i=0;$i<$cnt;$i++)
			{
				$db6->where("mailid=? and contactgroup!=? and addedby=?",array($mailid1[$i],0,$userid));
				$result6=$db6->query();//echo $db3->getQuery();exit;
				while($row6=$db6->fetchRow($result6))
				{

					$stringidssr[$r]=$row6[0];$r++;

				}
			}
			for($i=0;$i<$r;$i++)
			{
				$check=0;
				for($j=$i+1;$j<$r;$j++)
				{

					if($stringidssr[$j]==$stringidssr[$i])
					{
						$check=1;

					}

				}
				if($check==0)
				{
					$stringidsr.=$stringidssr[$i].",";
				}
			}
			$stringidsr=substr($stringidsr,0,-1);
			if($string_final!="")
			{

				$db6->select("nesote_email_contactgroup");
				$db6->fields("id,name");
				$db6->where("id not in($string_final) and userid=? ",array($userid));
				$db6->order("name asc");
				$result4=$db6->query();//echo $db4->getQuery();
				$num1=$db6->numRows($result4);
			}
			else
			{

				$db6->select("nesote_email_contactgroup");
				$db6->fields("id,name");
				$db6->where("userid=?",array($userid));
				$db6->order("name asc");
				$result4=$db6->query();//echo $db4->getQuery();exit;

				$num1=$db6->numRows($result4);

			}

			if($stringidsr!="")
			{

				$db6->select("nesote_email_contactgroup");
				$db6->fields("id,name");
				$db6->where("id in($stringidsr) and userid=?",array($userid));
				$db6->order("name asc");
				$result5=$db6->query();//echo $db5->getQuery();exit;
				$num2=$db6->numRows($result5);//echo $num2;
				$this->setLoopValue("folders",$result5->getResult());
			}

			$string="<div class=\"in\">";

			$string=$string."<a href=\"javascript:selectAllContact();\" id=\"3\"  style=\"cursor: pointer;\">".$this->getmessage(85)."</a>";
			$string=$string."<a href=\"javascript:unselectAllContact();\" id=\"4\"  style=\"cursor: pointer;\">".$this->getmessage(86)."</a>";

			$string=$string."<a id=\"0\">".$this->getmessage(310)."</a>";
			$string=$string."<a  href=\"javascript:addcustomfolder_contact(1);\" id=\"newgroup\">".$this->getmessage(25)."</a>";
			if($num1!=0)
			{
				if($execute==0)
				{
					while($row4=$db6->fetchRow($result4))
					{
						$s="changfn/".$row4[0]."/1/0";
						$string=$string."<a   href=\"javascript:changefn(1,".$row4[0].");\" id=".$s."   value=".$row4[0].">".$row4[1]."</a>";
					}
				}
				else if($execute==1)
				{
					while($row4=$db6->fetchRow($result4))
					{

						$s="changfn/".$row4[0]."/1/1";
						$string=$string."<a   href=\"javascript:changefn(1,".$row4[0].");\" id=".$s."  value=".$row4[0].">".$row4[1]."</a>";
					}
				}
			}
			if($execute==0)
			{

				$string=$string."<a id=\"0\">".$this->getmessage(311)."</a>";
			}
			else if($execute==1)
			{
				if($num2!=0)
				$string=$string."<a id=\"0\">".$this->getmessage(311)."</a>";
			}
			if($num2!=0)
			{

				if($execute==0)
				{
					while($row5=$db6->fetchRow($result5))
					{
						$p="changfn/".$row5[0]."/0/0";
						$string=$string."<a href=\"javascript:changefn(0,".$row5[0].");\" id=".$p."  value=".$row5[0].">".$row5[1]."</a>";
					}
				}
				else if($execute==1)
				{
					while($row5=$db6->fetchRow($result5))
					{
						$p="changfn/".$row5[0]."/0/1";
						$string=$string."<a href=\"javascript:changefn(0,".$row5[0].");\" id=".$p."   value=".$row5[0].">".$row5[1]."</a>";
					}
				}
			}
			else if($execute==0)
			{
				$q="changfn/0/0";
				$string=$string."<a id=".$q."  value=\"0\">".$this->getmessage(209)."</a>";

			}
			//$string=$string."</select>";
		}
		$string=$string."</div>";
		$mailid=str_replace("'","",$mailid);
		echo $string."///".$mailid;exit;

	}
	function addorremovegroupAction()
	{


		if(!$this->validateUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

		$userid=$this->getId();

		$db=new NesoteDALController();


		$groupid=$this->getParam(1);
		$mailid=$this->getParam(2);
		if($mailid!="")
		$mailid=substr($mailid,0,-1);
		$execute=$this->getParam(3);//1 for add to group,0 for remove from a group
		//$currentgid=$this->getParam(4);
		$currentgid=$_COOKIE['currentcontact'];
		$globalornot=$this->getParam(5);
		$remove_flag=$this->getParam(6);//removing from difrnt folder

		if($execute==0)//remove from group
		{
			$mailid1=explode(",",$mailid);$count=0;
			$cnt=count($mailid1);//echo $cnt."";exit;
			$c=0;$i=0;//echo $cnt;
			for($i=0;$i<$cnt;$i++)
			{
			 if($remove_flag==1)
			 {
					$db->delete("nesote_email_contacts");
					$db->where("contactgroup=? and addedby=? and mailid=? ",array($groupid,$userid,$mailid1[$i]));
					$rslt=$db->query();

			 }

			 $db->select("nesote_email_contacts");
			 $db->fields("*");
			 $db->where("id=? and contactgroup=? and addedby=?",array($mailid1[$i],$groupid,$userid));
			 $rs9=$db->query();
			 $rw9=$db->fetchRow($rs9);

			 if($rw9[0]==$mailid1[$i])
			 {

			 	$db->delete("nesote_email_contacts");
			 	$db->where("id=? and contactgroup=? and addedby=?",array($mailid1[$i],$groupid,$userid));
			 	$rslt=$db->query();//echo $db->getQuery();
			 	$count+=mysqli_affected_rows($conn);
			 }
			 else
			 $count++;


			}
			if($groupid==0)
			$groupname=$this->getmessage(209);
			else
			$groupname=$this->getgroupname($groupid);
			$msg=$this->getmessage(306);
			$msg1=str_replace('{number}',$count,$msg);
			$msg1=str_replace('{groupname}',$groupname,$msg1);


			$db->select("nesote_email_contacts");
			$db->fields("id");
			if($currentgid!=0)
			$db->where("contactgroup=? and addedby=?",array($currentgid,$userid));
			else
			$db->where("addedby=?",array($userid));
			$db->order("mailid asc");
			$db->limit(0,1);
			$rs1=$db->query();
			$rw1=$db->fetchRow($rs1);
			$no=$db->numRows($rs1);
			if($no==0)
			{

				$db->select("nesote_inoutscripts_users");
				$db->fields("*");
				$db->where("status=?",array(1));
				$db->order("name asc");
				$db->limit(0,1);
				$results=$db->query();//echo $db->getQuery();
				$row=$db->fetchRow($results);
				$rw1[0]=$row[0];
				$currentgid="global";
			}

			$userid=$this->getId();
			$username=$this->getusername($userid);
			$this->saveLogs("Delete Contact","$username has deleted  his/her contacts  ");
			//$url=$this->url("contacts/contactsdetail/$currentgid/$rw[0]/2/$msg1");
			$url=$currentgid."/".$rw1[0]."/2/".$msg1."/".$execute."/".$groupname;
			echo $url;die;

		}

		else if($execute==1) //add to group
		{
			$flag=1;
			$mailid1=explode(",",$mailid);$count=0;//print_r($mailid1);exit;
			//echo $mailid1[0];
			$cnt=count($mailid1);//echo $cnt;exit;
			$c=0;$i=0;
			for($i=0;$i<$cnt;$i++)
			{




				if($flag==1)
				{


					if($globalornot==0)
					{
						$mailid2[$i]=$this->getmailid($mailid1[$i]);
						$db->select("nesote_email_contacts");
						$db->fields("*");
						if($currentgid!=0)
						$db->where("mailid=? and contactgroup=? and addedby=?",array($mailid2[$i],$currentgid,$userid));
						else
						$db->where("mailid=? and addedby=?",array($mailid2[$i],$userid));
					}
					else if($globalornot==1)
					{
						//$mailiduser=explode("@",$mailid1[$i]);
						$mailid22[$i]=$this->getusername($mailid1[$i]);
						$mailid2[$i]=$this->getusername($mailid1[$i]).$this->getextension();

						$db->select(array("a"=>"nesote_inoutscripts_users","b"=>"nesote_email_usersettings"));
						$db->fields("a.username,a.name,b.dateofbirth");
						$db->where("a.status=? and a.username=? and a.id=b.userid",array(1,$mailid22[$i]));
					}
					$rs=$db->query();
					$rw=$db->fetchRow($rs);//echo $db->getQuery();exit;


					$db->select("nesote_email_contacts");
					$db->fields("*");
					$db->where("mailid=? and contactgroup=? and addedby=?",array($mailid2[$i],$groupid,$userid));
					$rs10=$db->query();
					$rw10=$db->fetchRow($rs10);

					if($rw10[1]!=$mailid2[$i])
					{

						$db->insert("nesote_email_contacts");
						if($globalornot==0)
						{
							$db->fields("mailid,addedby,contactgroup,firstname,lastname,date_of_birth,title,company,phone,address,website");
							$db->values(array($rw[1],$userid,$groupid,$rw[4],$rw[5],$rw[6],$rw[7],$rw[8],$rw[9],$rw[10],$rw[11]));
						}
						else if($globalornot==1)
						{
							$db->fields("mailid,addedby,contactgroup,firstname,date_of_birth");
							$usermailid=$rw[0].$this->getextension();
							$db->values(array($usermailid,$userid,$groupid,$rw[1],$rw[2]));
						}
						$db->query();//echo $db1->getQuery();exit;
						$lastinsertid=$db->lastInsertid("nesote_email_contacts");

						$count+=mysqli_affected_rows($conn);
					}
					else
					$count++;
				}

			}

			$userid1=$this->getId();
			$username1=$this->getusername($userid1);
			$this->saveLogs("New Contact","$username has added $email to his/her contacts");

			$groupname=$this->getgroupname($groupid);
			$msg=$this->getmessage(305);
			$msg1=str_replace('{number}',$count,$msg);
			$msg1=str_replace('{groupname}',$groupname,$msg1);



			if($execute==1)
			{
				$rw2[0]=$mailid1[0];

				$db->select("nesote_email_contacts");
				$db->fields("id");
				if($currentgid!=0)
				$db->where("contactgroup=? and id=? and addedby=?",array($currentgid,$mailid1[0],$userid));
				else
				$db->where("id=? and addedby=?",array($mailid1[0],$userid));
				$db->order("mailid asc");
				$db->limit(0,1);
				$rs2=$db->query();//echo $db2->getQuery();
				$rw2=$db->fetchRow($rs2);
			}
			else
			{

				$db->select("nesote_email_contacts");
				$db->fields("id");
				if($currentgid!=0)
				$db->where("contactgroup=? and addedby=?",array($currentgid,$userid));
				else
				$db->where("addedby=?",array($userid));
				$db->order("mailid asc");
				$db->limit(0,1);
				$rs2=$db->query();
				$rw2=$db->fetchRow($rs2);
			}
			//			header("Location:".$this->url("contacts/contactsdetail/$groupid/$lastinsertid/2/$msg1"));
			//				exit(0);

			$url=$currentgid."/".$rw2[0]."/2/".$msg1."/".$execute."/".$groupname;
			echo $url;exit(0);


		}

	}
	function deletegroupAction()
	{

		if(!$this->validateUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		$id=$this->getParam(1);$msg="";
		$userid=$this->getId();$cgid=$_COOKIE['contact'];
		$db=new NesoteDALController();
		$select=new NesoteDALController();


		$db->select("nesote_email_contactgroup");
		$db->fields("name");
		$db->where("id=?",array($id));
		$rs=$db->query();
		$row=$db->fetchRow($rs);
		$groupname=$row[0];


		$db->delete("nesote_email_contactgroup");
		$db->where("id=?",array($id));
		$rs=$db->query();


		$db->delete("nesote_email_contacts");
		$db->where("contactgroup=? and addedby=?",array($id,$userid));
		$rs=$db->query();

		//		$db=new NesoteDALController();
		//		$db->update("nesote_email_contacts");
		//		$db->set("contactgroup=?",array(0));
		//		$db->where("id=? and addedby=?",array($id,$userid));
		//		$rs=$db->query();


		$username=$this->getusername($userid);

		$groupname1=mysqli_REAL_escape_string($conn,$groupname);
		$this->saveLogs("Delete Contactgroup","$username has deleted contactgroup $groupname1");

		//		header("Location:".$this->url("layout/contactsleftpanel"));
		//
		//		echo "";exit(0);

		if($id==$cgid)
		{
			setcookie("currentcontact",0,0,"/");
			$cgid=0;
		}

		$db->select("nesote_email_contacts");
		$db->fields("id");
		if($cgid!=0)
		$db->where("addedby=? and contactgroup=?",array($userid,$cgid));
		else
		$db->where("addedby=?",array($userid));
		$db->order("mailid asc");
		$db->limit(0,1);
		$result1=$db->query();
		$row1=$db->fetchRow($result1);
		if($row1[0]=="")
		{

			$select->select("nesote_email_settings");
			$select->fields("value");
			$select->where("name='globaladdress_book'");
			$result=$select->query();//echo $select->getQuery();
			$res=$select->fetchRow($result);
			$addressbook=$res[0];
			if($addressbook==1)
			$row1[0]="global";
			else
			$row1[0]=0;
		}
		$msg=$this->getmessage(219);echo $row1[0]."/".$msg."/".$id;
		die;

		//$msg1=str_replace('{groupname}',$groupname,$msg);

	}

	function deletecontactAction()
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

			$magic=get_magic_quotes_gpc();
			if($magic==1)
			{
				$userid=stripslashes($userid);
			}
			$ids=0;$count=array();
			$groupid=$this->getParam(1);
			$idstring=$this->getParam(2);
			if($groupid==0)
			$grpName=0;
			else
			$grpName=$this->getgroupname($groupid);
			$ids=substr($idstring,0,-1);$count=0;
			$db=new NesoteDALController();

			$db->delete("nesote_email_contacts");
			$db->where("id in($ids)");
			$rs=$db->query();//echo $db->getQuery();
			$count+=mysqli_affected_rows($conn);





			$db->select("nesote_email_contacts");
			$db->fields("id");
			if($groupid!=0)
			$db->where("addedby=? and contactgroup=?",array($userid,$groupid));
			else
			$db->where("addedby=?",array($userid));
			$db->order("mailid asc");
			$db->limit(0,1);
			$rs=$db->query();//echo $db->getQuery();
			$rw=$db->fetchRow($rs);
			$num=$db->numRows($rs);
			if($num==0)
			{

				$db->select("nesote_inoutscripts_users");
				$db->fields("id,username,name");
				$db->where("status=?",array(1));
				$db->order("name asc");
				$db->limit(0,1);
				$result10=$db->query();
				$row10=$db->fetchRow($result10);
				$rw[0]=$row10[0];
				$groupid="global";
			}

			$msg=$this->getmessage(199);
			$msg1=$msg1=str_replace('{number}',$count,$msg);


			$username=$this->getusername($userid);
			$this->saveLogs("Delete Contact","$username has deleted  his/her contacts  ");

			//			$url=$this->url("contacts/contactsdetail/$groupid/$rw[0]/2/$msg1");
			//			echo $url;

			echo $groupid."/".$rw[0]."/2/".$msg1."/".$grpName;
			die;

		}
	}
function getcontactsajaxAction()
	{
	    //echo "aaa";exit;
		if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

		$db=new NesoteDALController();
		$userid=$this->getId();
		$cid=$this->getParam(1);
		

			$db->select(array("a"=>"nesote_email_contacts"));
			$db->fields("*");
			$db->where("a.id=?",array($cid));
			//$db->order("a.name asc");
			$result=$db->query();
//echo $db->getQuery();exit;
			$i=0;
			
			

			while($row1=$db->fetchRow($result))
			{
				$contacts.=trim($row1[0])."{nesote_c}";
				$contacts.=trim($row1[1])."{nesote_c}";

				$contacts.=trim($row1[3])."{nesote_c}";
				$contacts.=trim($row1[4])."{nesote_c}";
				$contacts.=trim($row1[5])."{nesote_c}";
				$contacts.=trim(date("j/m/Y",$row1[6]))."{nesote_c}";
				$contacts.=trim($row1[7])."{nesote_c}";
				$contacts.=trim($row1[8])."{nesote_c}";
				$contacts.=trim($row1[9])."{nesote_c}";
				$contacts.=trim($row1[10])."{nesote_c}";
				$contacts.=trim($row1[11])."{nesote_c}";
				$i++;
			}
		
		$contacts=substr($contacts,0,-10);
		print_r($contacts);
		exit;
	}

};
?>
