<?php

//echo $config_path;

class AccountController extends NesoteController
{
	function helpAction()
	{
		$id=$this->getParam(1);
		$this->setValue("helpid",$id);
		//echo $id;
		$year=date("Y",time());
		$this->setValue("year",$year);
	}

	
	
		
	
	function apisettingsAction()
	{
require("script.inc.php");
		$valid=$this->validuser();
	
		if($valid!=false)
		{				
			$google_clientid=$_POST['gclientid'];
			$google_secret=$_POST['gsecret'];		
			$cb=new NesoteDALController();
			if($_POST['Update'])
			{				
				//if(($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')
				{
	
				header("Location:".$this->url("message/error/1023"));
				exit(0);
				}
			
				$this->updateapi("gclientid",$google_clientid);
				$this->updateapi("gsecret",$google_secret);
				header("Location:".$this->url("message/success/1650/18"));
				exit(0);
			}
			$google_redirect=$this->getpath()."google_connected.php";
			$this->setValue("gredirect",$google_redirect);
			$this->setValue("gclientid",$this->selectapivalue("gclientid"));
			$this->setValue("gsecret",$this->selectapivalue("gsecret"));
		}
		else
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}
	}
	
	
	
	function selectapivalue($name)
	{
	
	
		$db=new NesoteDALController();
		$db->select("nesote_email_settings");
		$db->fields("*");
		$db->where("name=?",array($name));
		$result=$db->query();
		$row=$db->fetchRow($result);
		return $row[2];
	
	
	
	
	}
	
	
	
	
	function updateapi($name,$value)
	{
		$up=new NesoteDALController();
		$up->update("nesote_email_settings");
		$up->set("value=?",array($value));
		$up->where("name=?",$name);
		$res=$up->query();
		return $res;
	}
	
	
	
	
	
	function getpath()
	{
	
	
		$servername=$_SERVER['SERVER_NAME'];
		$path=$servername.$_SERVER['SCRIPT_NAME'];
		$pos=strpos($path,"admin");
		$subpath=substr($path,0,$pos);
		$subpath=$subpath."class/social_library/";
		return $subpath;
	
	
	
	
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
	
	
	
	
	
	
	
	
	
	
};
?>
