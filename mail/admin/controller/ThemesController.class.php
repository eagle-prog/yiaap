<?php
class ThemesController extends NesoteController
{


    function newAction()
    {
        if(!$this->validUser())
        {
            header("Location:".$this->url("index/index"));
            exit(0);
        }

            }

    function storeinfoAction()
    {
        if(!$this->validUser())
        {
            header("Location:".$this->url("index/index"));
            exit(0);
        }
        

        $name=$_POST['theme'];
        $content=$_POST['style'];

        if(($name=="")||($content==""))
        {
            header("Location:".$this->url("message/error/1013"));
            exit(0);
        }
        $db= new NesoteDALController();
        $tot=$db->total("nesote_email_themes","name=?",array($name));
        if($tot!=0)
        {
            header("Location:".$this->url("message/error/1055"));
            exit(0);
        }

		/*$mdl=$this->modelInstance("nesote_email_themes");
		$mdl->setName($name);
		$mdl->setStyle($content);
		$mdl->setStatus(1);
		$mdl->save();*/


	$db=new NesoteDALController();
					$db->insert("nesote_email_themes");
					$db->fields("name,style,status");
					$db->values(array($name,$content,1));
					$result=$db->query();
					$last=$db->lastInsertid('nesote_email_themes');


        header("Location:".$this->url("themes/manage/1"));
        exit(0);
    }

    function manageAction()
    {

        if(!$this->validUser())
        {
            header("Location:".$this->url("index/index"));
            exit(0);
        }
        
        $msg=$this->getParam(1);$msg1="";
        if($msg==1)
        $this->setValue("msg","New theme has been added successfully.");
        if($msg==2)
        $this->setValue("msg","Theme details has been updated successfully.");
        if($msg==3)
        $this->setValue("msg","Theme has been deleted successfully.");
        if($msg==4)
        $this->setValue("msg","Theme has been disabled successfully.");
        if($msg==5)
        $this->setValue("msg","Theme has been enabled successfully.");

        $db= new NesoteDALController();
        $db->select("nesote_email_themes");
        $db->fields("*");
        $db->order("name");
        $result=$db->query();//echo $db->getQuery();
        $num=$db->numRows($result);
        if($num==0)
        $msg1="No Themes";
        $this->setValue("msg1",$msg1);
        $this->setLoopValue("themes",$result->getResult());
    }

    function editAction()
    {
require("script.inc.php");
        if(!$this->validUser())
        {
            header("Location:".$this->url("index/index"));
            exit(0);
        }


        $id=$this->getParam(1);
        $this->setValue("id",$id);
        $server=$_SERVER['HTTP_HOST'];
        //if(($server=="www.inoutwebportal.com") || ($server=="inoutwebportal.com")|| ($server=="www.54.186.224.75") || ($server=="inoutwebmaildemo.com")
if($restricted_mode=='true')
        {
            //if($id<3)
            //{
                header("Location:".$this->url("message/error/1023"));
                exit(0);
            //}
        }

        $db= new NesoteDALController();
        $db->select("nesote_email_themes");
        $db->fields("*");
        $db->where("id=?",$id);
        $result=$db->query();
        $row=$db->fetchRow($result);
        $this->setValue("name",$row[1]);
        $this->setValue("style",$row[2]);
    }

    function storeeditinfoAction()
    {
require("script.inc.php");
        if(!$this->validUser())
        {
            header("Location:".$this->url("index/index"));
            exit(0);
        }

        

        $id=$this->getParam(1);

        $server=$_SERVER['HTTP_HOST'];
        //if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')
        {
            //if($id<3)
            //{
                header("Location:".$this->url("message/error/1023"));
                exit(0);
            //}
        }

        $theme=$_POST['theme'];
        $style=$_POST['style'];

        if(($theme=="")||($style==""))
        {
            header("Location:".$this->url("message/error/1013"));
            exit(0);
        }
        $db= new NesoteDALController();
        $tot=$db->total("nesote_email_themes","name=? and id!=?",array($theme,$id));
        if($tot!=0)
        {
            header("Location:".$this->url("message/error/1055"));
            exit(0);
        }



		$db=new NesoteDALController();
		$db->update("nesote_email_themes");
		$db->set("name=?,style=?",array($theme,$style));
		$db->where("id='$id'");
		$db->query();

//echo $db->getQuery();exit;
	/*	$mdl=$this->modelInstance("nesote_email_themes");
		$mdl->load();
		$mdl->setName($theme);
		$mdl->setStyle();
		$mdl->update();*/
		header("Location:".$this->url("themes/manage/2"));
		exit(0);
	}

    function deleteAction()
    {
require("script.inc.php");
        if(!$this->validUser())
        {
            header("Location:".$this->url("index/index"));
            exit(0);
        }

        
        $id=$this->getParam(1);

        $server=$_SERVER['HTTP_HOST'];
       // if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')
        {
            //if($id<3)
            //{
                header("Location:".$this->url("message/error/1023"));
                exit(0);
            //}
        }

        $this->loadLibrary('Settings');
        $settings=new Settings('nesote_email_settings');
        $settings->loadValues();
        $themes=$settings->getValue("themes");

        if($themes==$id)
        {
            header("Location:".$this->url("message/error/1057"));
            exit(0);
        }
        else
        {
            $db= new NesoteDALController();
            $db->delete("nesote_email_themes");
            $db->where("id=?",$id);
            $db->query();
            header("Location:".$this->url("themes/manage/3"));
            exit(0);

        }

    }


    function enableAction()
    {
require("script.inc.php");
        if(!$this->validUser())
        {
            header("Location:".$this->url("index/index"));
            exit(0);
        }

        
        $id=$this->getParam(1);

        $server=$_SERVER['HTTP_HOST'];
        //if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')
        {
            //if($id<3)
            //{
                header("Location:".$this->url("message/error/1023"));
                exit(0);
            //}
        }

		/*$mdl=$this->modelInstance("nesote_email_themes");
		$mdl->load("$id");
		$mdl->setStatus("1");
		$mdl->update();*/

	$db=new NesoteDALController();
		$db->update("nesote_email_themes");
		$db->set("status=?",array('1'));
		$db->where("id='$id'");
		$db->query();



		header("Location:".$this->url("themes/manage/5"));
		exit(0);
	}

    function disableAction()
    {
require("script.inc.php");
        if(!$this->validUser())
        {
            header("Location:".$this->url("index/index"));
            exit(0);
        }

        
        $id=$this->getParam(1);

        $server=$_SERVER['HTTP_HOST'];
       // if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')
        {
            //if($id<3)
            //{
                header("Location:".$this->url("message/error/1023"));
                exit(0);
            //}
        }

        $this->loadLibrary('Settings');
        $settings=new Settings('nesote_email_settings');
        $settings->loadValues();
        $themes=$settings->getValue("themes");

        if($themes==$id)
        {
            header("Location:".$this->url("message/error/1056"));
            exit(0);
        }

		/*$mdl=$this->modelInstance("nesote_email_themes");
		$mdl->load("$id");
		$mdl->setStatus("0");
		$mdl->update();
*/
	$db=new NesoteDALController();
		$db->update("nesote_email_themes");
		$db->set("status=?",array('0'));
		$db->where("id='$id'");
		$db->query();


		header("Location:".$this->url("themes/manage/4"));
		exit(0);

    }

    function settingsAction()
    {
        if(!$this->validUser())
        {
            header("Location:".$this->url("index/index"));
            exit(0);
        }

        

        $db= new NesoteDALController();
        $db->select("nesote_email_themes");
        $db->fields("id,name");
        $db->where("status=?",1);
        $result=$db->query();
        $this->setLoopValue("themes",$result->getResult());

		$this->loadLibrary("settings");
		$set=new settings("nesote_email_settings");
		$set->loadValues();
		$override_themes=$set->getValue("override_themes");
		$themes=$set->getValue("themes");
		$this->setValue("themes",$themes);
		$this->setValue("override_themes",$override_themes);

		$db->select("nesote_email_themes");
		$db->fields("id,name");
		$db->where("id=?",$themes);
		$result=$db->query();
                $rowss=$db->fetchRow($result);
		$this->setValue("crnttheme",$rowss[1]);



	}

    function settingsprocessAction()
    {
require("script.inc.php");
        if(!$this->validUser())
        {
            header("Location:".$this->url("index/index"));
            exit(0);
        }
        $db= new NesoteDALController();
        
        $themes=$_POST['themes'];
        $override_themes=$_POST['override_themes'];
            //if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="inout-webmail-ultimate.demo.inoutscripts.net") || ($_SERVER['HTTP_HOST']=="54.186.224.75") )
if($restricted_mode=='true')
            {
                header("Location:".$this->url("message/error/1023"));
                exit(0);
            }
        if($override_themes=="on")
        $override_themes=1;
        else
        $override_themes=0;
        $db->update("nesote_email_settings");
        $db->set("value=?",array($themes));
        $db->where("name='themes'");
        $db->query();
        $db->set("value=?",array($override_themes));
        $db->where("name='override_themes'");
        $db->query();
        //echo $db->getQuery();
        header("Location:".$this->url("message/success/1020/3"));
        exit(0);
    }

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
        $leftads_code=$set->getValue("leftads_code");
        $rightads_code=$set->getValue("rightads_code");
        $this->setValue("leftads_code",$leftads_code);
        $this->setValue("rightads_code",$rightads_code);

    }

    function adscodeprocessAction()
    {
        if(!$this->validUser())
        {
            header("Location:".$this->url("index/index"));
            exit(0);
        }
        
        $leftads_code=$_POST['leftads_code'];
        $rightads_code=$_POST['rightads_code'];

        $db= new NesoteDALController();
        $db->update("nesote_email_settings");
        $db->set("value=?",array($leftads_code));
        $db->where("name='leftads_code'");
        $db->query();
        $db->set("value=?",array($rightads_code));
        $db->where("name='rightads_code'");
        $db->query();
        //echo $db->getQuery();
        header("Location:".$this->url("message/success/1060/3"));
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

    
}
?>

