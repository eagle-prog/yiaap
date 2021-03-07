<?php
class CalendarController extends NesoteController
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

	function calendarAction()
	{

		$select=new NesoteDALController();
		$select->select("nesote_email_calendar_settings");
		$select->fields("value");
		$select->where("name=?",calendar);
		$result=$select->query();
		$rs=$select->fetchRow($result);
		$this->setValue("calendar_enable",$rs[0]);
		
		$select->select("nesote_email_calendar_settings");
		$select->fields("value");
		$select->where("name=?",email_remainder);
		$result=$select->query();
		$rs=$select->fetchRow($result);
		$this->setValue("emailremainder",$rs[0]);
			
		$select->select("nesote_email_calendar_settings");
		$select->fields("value");
		$select->where("name=?",view_event);
		$result1=$select->query();
		$rs1=$select->fetchRow($result1);
		$this->setValue("viewevent",$rs1[0]);


		if($_POST)
		{
require("script.inc.php");

			//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )	
if($restricted_mode=='true')		
{

				header("Location:".$this->url("message/error/1023"));
				exit(0);
			}

			$calendar_enable=$_POST['calendar_enable'];
			$emailremainder=$_POST['emailremainder'];
			$viewevent=$_POST['viewevent'];
			
			$db=new NesoteDALController();
			$db->update("nesote_email_calendar_settings");
			$db->set("value=?",array($calendar_enable));
			$db->where("name=?",calendar);
			$db->query();
			
			$db->update("nesote_email_calendar_settings");
			$db->set("value=?",array($emailremainder));
			$db->where("name=?",email_remainder);
			$db->query();//echo $db->getQuery();
			
			$db->update("nesote_email_calendar_settings");
			$db->set("value=?",array($viewevent));
			$db->where("name=?",view_event);
			$db->query();//echo $db->getQuery();
			 
				header("Location:".$this->url("message/success/1600/14"));//1 for path creation in message/success controller
				exit(0);

		}


	}

};
?>
