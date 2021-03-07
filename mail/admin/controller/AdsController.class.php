<?php
class AdsController extends NesoteController
{
	function adscodeAction()
	{
		if(!$this->validUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

		$this->loadLibrary("settings");
		$set=new settings("nesote_email_settings");
		$set->loadValues();
			
		$rightads_code=$set->getValue("rightads_code");
		$topads_code=$set->getValue("topads_code");
			
		$this->setValue("rightads_code",$rightads_code);
		$this->setValue("topads_code",$topads_code);
	}

	function adscodeprocessAction()
	{
require("script.inc.php");

		//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')

		{

			header("Location:".$this->url("message/error/1023"));
			exit(0);
		}

		if(!$this->validUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}


		$rightads_code=$_POST['rightads_code'];
		$topads_code=$_POST['topads_code'];

		$db= new NesoteDALController();
		$db->update("nesote_email_settings");
		$db->set("value=?",array($rightads_code));
		$db->where("name='rightads_code'");
		$db->query();
		$db->set("value=?",array($topads_code));
		$db->where("name='topads_code'");
		$db->query();
		//echo $db->getQuery();
		header("Location:".$this->url("message/success/1060/17"));
		exit(0);
	}


	function analyticscodeAction()
	{
		if(!$this->validUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}


		$this->loadLibrary("settings");
		$set=new settings("nesote_email_settings");
		$set->loadValues();
		$analystics_code=$set->getValue("analystics_code");
		$this->setValue("analystics_code",$analystics_code);
	}

	function analyticscodeprocessAction()
	{
require("script.inc.php");

		//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')
		{

			header("Location:".$this->url("message/error/1023"));
			exit(0);
		}

		if(!$this->validUser())
		{
			header("Location:".$this->url("index/index"));
			exit(0);
		}

		$analystics_code=trim($_POST['analystics_code']);

		$db=new NesoteDALController();
		$db->update("nesote_email_settings");
		$db->set("value=?",array($analystics_code));
		$db->where("name='analystics_code'");
		$db->query();

		header("Location:".$this->url("message/success/1020/3"));
		exit(0);
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
	function sponsoredlinksAction()
	{
		$server=$_SERVER['HTTP_HOST'];
		$db= new NesoteDALController();
		$this->loadLibrary('Settings');
		$settings=new Settings('nesote_email_settings');
		$settings->loadValues();
		$installurl=$settings->getValue("adserver_installurl");
		$authcode=$settings->getValue("adserver_authenticationcode");
		$topadcount=$settings->getValue("adserver_topadcount");
		$rightadcount=$settings->getValue("adserver_rightadcount");
		$publicadstatus=$settings->getValue("publicadstatus");
		if($server=="www.inout-search-ultimate.com" || $server=="inout-search-ultimate.com" || $server=="www.inout-search.com" || $server=="inout-search.com")
		{
			$this->setValue("installurl","YOUR INOUT ADSERVER INSTALL URL");
			$this->setValue("authcode","YOUR INOUT ADSERVER AUTHENTICATION CODE");
			$this->setValue("topadcount",$topadcount);
			$this->setValue("rightadcount",$rightadcount);
			$this->setValue("publicadstatus",$publicadstatus);
		}
		else
		{
			$this->setValue("installurl",$installurl);
			$this->setValue("authcode",$authcode);
			$this->setValue("topadcount",$topadcount);
			$this->setValue("rightadcount",$rightadcount);
			$this->setValue("publicadstatus",$publicadstatus);
		}
	}
	function sponsoredprocessAction()
	{
require("script.inc.php");
		//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')
		{

			header("Location:".$this->url("message/error/1023"));
			exit(0);
		}

		
			
		$installurl = trim($_POST['installurl']);
		$authcode = trim($_POST['authcode']);
		$topadcount = trim($_POST['topadcount']);
		$rightadcount = trim($_POST['rightadcount']);
		$publicadstatus=trim($_POST['publicadstatus']);
		//echo $publicadstatus;
		if($publicadstatus=="on")
		{
			$publicadstatus=1;
		}
		else
		{
			$publicadstatus=0;
		}
		//echo $installurl." ".$authcode." ".$displayurl." "; exit;
		if($installurl=="" || $authcode=="" || $topadcount=="" || $rightadcount=="")
		{
			header("Location:".$this->url("message/error/1017"));
			exit(0);
		}
		else
		{
			$db= new NesoteDALController();
			$db->update("nesote_email_settings");
			$db->set("value=?",$installurl);
			$db->where("name=?","adserver_installurl");
			$db->query();
			$db->update("nesote_email_settings");
			$db->set("value=?",$authcode);
			$db->where("name=?","adserver_authenticationcode");
			$db->query();
			$db->update("nesote_email_settings");
			$db->set("value=?",$topadcount);
			$db->where("name=?","adserver_topadcount");
			$db->query();
			$db->update("nesote_email_settings");
			$db->set("value=?",$rightadcount);
			$db->where("name=?","adserver_rightadcount");
			$db->query();
			$db->update("nesote_email_settings");
			$db->set("value=?",$publicadstatus);
			$db->where("name=?","publicadstatus");
			$db->query();
			header("Location:".$this->url("message/success/1018/8"));
			exit(0);
		}
			
	}

}
?>
