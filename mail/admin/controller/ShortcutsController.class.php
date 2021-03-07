<?php
class ShortcutsController extends NesoteController
{

		function shortcutsAction()
		{
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}

			$db= new NesoteDALController();
			$db->select("nesote_email_shortcuts");
			$db->fields("keyvalue,description,id");
			$result=$db->query();
			//echo $db->getQuery();
			$this->setLoopValue("messages",$result->getResult());
			
			
			
			
		}


		function storeinfoAction()
		{
require("script.inc.php");
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}
				
			//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')

			{
				
					header("Location:".$this->url("message/error/1023"));
					exit(0);
			}

			$lang_id=$this->getParam(1);
			$db= new NesoteDALController();$db1= new NesoteDALController();
			$db1->select("nesote_email_shortcuts");
			$db1->fields("id");
			$result=$db1->query();

			$quotes=get_magic_quotes_gpc();
			//echo $quotes;

			while($row=$result->fetchRow())
			{
					$wordscript=$_POST['script'.$row[0]];
					
					$db->update("nesote_email_shortcuts");
					$db->set("description=?",array($wordscript));
					$db->where("id=?",array($row[0]));
					$db->query();//echo $db->getQuery();exit;
			}
			
			header("Location:".$this->url("message/success/1507/13"));
			exit(0);
		}
		
		function shortcutsettingsAction()
		{
			
		
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}
			$db=new NesoteDALController();
			$db->select("nesote_email_settings");
			$db->fields("value");
			$db->where("name='shortcuts'");
			$result=$db->query();
			//echo $db->getQuery();
			$row=$result->fetchRow();
			if($row[0]=="")
			$row[0]=0;
			$this->setValue("shortcuts",$row[0]);
			
		}
		
		function shortcutsettingsprocessAction()
		{
		if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}
			
			$shortcuts=$_POST['shortcut'];
			$db=new NesoteDALController();
			$db->update("nesote_email_settings");
			$db->set("value=?",array($shortcuts));
			$db->where("name='shortcuts'");
			$db->query();//echo $db->getQuery();exit;
			
			header("Location:".$this->url("message/success/1507/13"));
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
};
?>
