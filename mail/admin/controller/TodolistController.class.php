<?php
class TodolistController extends NesoteController
{
	
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

	function todolistAction()
	{
if(!$this->validUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

		$select=new NesoteDALController();
		$select->select("nesote_email_settings");
		$select->fields("value");
		$select->where("name=?",todolist);
		$result=$select->query();
		$rs=$select->fetchRow($result);
		$this->setValue("todolist",$rs[0]);


		if($_POST)
		{
require("script.inc.php");

			//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')
			{

				header("Location:".$this->url("message/error/1023"));
				exit(0);
			}

			$todolist=$_POST['todo'];
			
			$db=new NesoteDALController();
			$db->update("nesote_email_settings");
			$db->set("value=?",array($todolist));
			$db->where("name=?",todolist);
			$db->query();
			 
				header("Location:".$this->url("message/success/1508/15"));//1 for path creation in message/success controller
				exit(0);

		}


	}
function smtpsettingsAction()
	{
if(!$this->validUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

		$select=new NesoteDALController();
		$select->select("nesote_email_settings");
		$select->fields("value");
		$select->where("name=?",user_smtp);
		$result=$select->query();
//echo $select->getQuery();exit;
		$rs=$select->fetchRow($result);
		$this->setValue("todolist",$rs[0]);
//echo $rs[0];exit;


		if($_POST)
		{
require("script.inc.php");

			//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')
			{

				header("Location:".$this->url("message/error/1023"));
				exit(0);
			}

			$todolist=$_POST['todo'];
			
			$db=new NesoteDALController();
			$db->update("nesote_email_settings");
			$db->set("value=?",array($todolist));
			$db->where("name=?",user_smtp);
			$db->query();
			 
				header("Location:".$this->url("message/success/1701/19"));//1 for path creation in message/success controller
				exit(0);

		}


	}

function smtpconfigurationsAction()
	{

if(!$this->validUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
		$select=new NesoteDALController();
		$select->select("nesote_email_smtp_settings");
		$select->fields("*");
		//$select->where("name=?",user_smtp);
		$result=$select->query();
$row=$select->numRows($result);
$rs=$select->fetchRow($result);
if($row>0)
{
$this->setValue("smtphost_name",$rs[1]);
$this->setValue("smtpportno",$rs[2]);
$this->setValue("smtpusername",$rs[3]);
$this->setValue("smtppassword",$rs[4]);
$this->setValue("smtpservice",$rs[5]);
}
else
{
$this->setValue("smtphost_name",'');
$this->setValue("smtpportno",'');
$this->setValue("smtpusername",'');
$this->setValue("smtppassword",'');
$this->setValue("smtpservice",'');
}

		

		



		if($_POST)
		{
require("script.inc.php");

			//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')
			{

				header("Location:".$this->url("message/error/1023"));
				exit(0);
			}

			$host=$_POST['smtphostname'];
                        $port=$_POST['smtpportno'];
                        $username=$_POST['smtpusername'];
                        $password=$_POST['smtppassword'];
                        $service=$_POST['smtpservice'];
if($host!='' && $port!='' && $username!='' && $password!='' && $service!='')
{
$select->select("nesote_email_smtp_settings");
		$select->fields("*");
		//$select->where("name=?",user_smtp);
		$result=$select->query();
$row=$select->numRows($result);
$rs=$select->fetchRow($result);
$db=new NesoteDALController();
if($row>0)
{

			$db->update("nesote_email_smtp_settings");
			$db->set("smtp_host=?,smtp_port=?,smtp_user=?,smtp_pass=?,smtp_secure=?,smtp_auth=?",array($host,$port,$username,$password,$service,$service));
			//$db->where("name=?",user_smtp);
			$db->query();
}
else
{
//echo "aaaa";exit;
$db->insert("nesote_email_smtp_settings");
						$db->fields("smtp_host,smtp_port,smtp_user,smtp_pass,smtp_secure,smtp_auth");
						$db->values(array($host,$port,$username,$password,$service,$service));
						$result=$db->query();
//echo $db->getQuery();exit;
}
}
else
{
header("Location:".$this->url("todolist/smtpconfigurations"));
				exit(0);
}
			
			
			 
				header("Location:".$this->url("message/success/1702/20"));//1 for path creation in message/success controller
				exit(0);

		}


	}




};
?>
