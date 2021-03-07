<?php
class LanguageController extends NesoteController
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


		$language=trim($_POST['language']);
		$script=trim($_POST['script']);
		$char_encoding=trim($_POST['char_encoding']);
		$language_code=trim($_POST['lang_code']);

		if(($language=="") || ($script==""))
		{
			header("Location:".$this->url("message/error/1013"));
			exit(0);
		}
		$db= new NesoteDALController();
		$tot=$db->total("nesote_email_languages","language=? or language_script=? ",array($language,$script));
		if($tot!=0)
		{
			header("Location:".$this->url("message/error/1042"));
			exit(0);
		}

		if($char_encoding=="")
		$char_encoding="UTF-8";
	/*	$mdl=$this->modelInstance("nesote_email_languages");
		$mdl->setLanguage($language);
		$mdl->setLanguage_script($script);
		$mdl->setStatus(0);
		$mdl->setChar_encoding($char_encoding);
		$mdl->setLang_alignment(1);
		$mdl->setLang_code($language_code);
		$mdl->save();
		$lid=$mdl->getId();*/
			$db->insert("nesote_email_languages");
			$db->fields("language,language_script,status,char_encoding,lang_alignment,lang_code");
			$db->values(array($language,$script,0,$char_encoding,1,$language_code));
			$result=$db->query();

		header("Location:".$this->url("language/manage/6"));
		exit(0);
	}


	
		function managemessagesAction()
		{
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}


			$db= new NesoteDALController();
			$db->select("nesote_email_languages");
			$db->fields("id,language");
			$db->order("id asc");
			$result=$db->query();
			$this->setLoopValue("lang",$result->getResult());
		}
		function manageAction()
		{
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}


			$id=$this->getParam(1);$msg1="";
			if($id==1)
			$this->setValue("msg","Language has been deleted successfully");
			if($id==2)
			$this->setValue("msg","Language has been enabled successfully");
			if($id==3)
			$this->setValue("msg","Language has been disabled successfully");
			if($id==4)
			$this->setValue("msg","Messages has been updated successfully");
			if($id==5)
			$this->setValue("msg","Language details has been updated successfully");
			if($id==6)
			$this->setValue("msg","New language has been added successfully");
			if($id==7)
			$this->setValue("msg","New category message has been a successfully entered.");
			if($id==8)
			$this->setValue("msg","New custom field message has been a successfully entered.");
			if($id==9)
			$this->setValue("msg","New month message has been a successfully entered.");

			$db= new NesoteDALController();
			$db->select("nesote_email_languages");
			$db->fields("id,language,language_script,status,char_encoding,lang_code");
			$db->order("id asc");
			$result=$db->query();
			//echo $db->getQuery();exit;
			$num=$db->numRows($result);
			if($num==0)
			$msg1="No Languages";
			$this->setValue("msg1",$msg1);
			$this->setLoopValue("languages",$result->getResult());
		}
		function editAction()
		{
require("script.inc.php");
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index/2"));
				exit(0);
			}


			$lang_id=$this->getParam(1);

			//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="www.inoutwebmaildemo.com") || ($_SERVER['HTTP_HOST']=="inoutwebmaildemo.com") )
if($restricted_mode=='true')
			
			{
				//if($lang_id<4)
				//{
					header("Location:".$this->url("message/error/1023"));
					exit(0);
				//}
			}

			$this->setValue("lang_id",$lang_id);
			$db= new NesoteDALController();
			$db->select("nesote_email_languages");
			$db->fields("id,language,language_script,status,char_encoding,image,lang_code");
			$db->where("id=?",$lang_id);
			$result=$db->query();
			$this->setLoopValue("editdetails",$result->getResult());
		}

		function storeeditinfoAction()
		{
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}


			$lang_id=$this->getParam(1);
			$lang=trim($_POST['language']);
			$lang_script=trim($_POST['script']);
			$char_encod=trim($_POST['char_encoding']);
			$lang_code=trim($_POST['lang_code']);
			

			if(($lang=="") ||($lang_script=="")||($char_encod=="")||($lang_code==""))
			{
				header("Location:".$this->url("message/error/1013"));
				exit(0);
			}
			$db= new NesoteDALController();
			$tot=$db->total("nesote_email_languages","(language=? or language_script=? or lang_code=?) and id!=?",array($lang,$lang_script,$lang_code,$lang_id));
			if($tot!=0)
			{
				header("Location:".$this->url("message/error/1042"));
				exit(0);
			}

			/*$mdl=$this->modelInstance("nesote_email_languages");
			$mdl->load($lang_id);
			$mdl->setLanguage($lang);
			$mdl->setLanguage_script($lang_script);
			$mdl->setChar_encoding($char_encod);
			$mdl->setLang_code($lang_code);
			$mdl->update();*/
			
	$db->update("nesote_email_languages");
	$db->set("language=?,language_script=?,char_encoding=?,lang_code=?",array($lang,$lang_script,$char_encod,$lang_code));
	$db->where("id=?",array($lang_id));
	$result=$db->query();
		

	
			

			header("Location:".$this->url("language/manage/5"));
			exit(0);
		}

		function deleteAction()
		{
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}
			$lang_id=$this->getParam(1);
			if($lang_id==1)
			{
				header("Location:".$this->url("message/error/1045"));
				exit(0);
			}
			$server=$_SERVER['HTTP_HOST'];
			if(($server=="www.inoutwebportal.com") || ($server=="inoutwebportal.com"))
			{
				if($lang_id<4)
				{
					header("Location:".$this->url("message/error/1023"));
					exit(0);
				}
			}
			$db= new NesoteDALController();
			$db->delete("nesote_email_languages");
			$db->where("id=?",$lang_id);
			$db->query();
			$db->delete("nesote_email_messages");
			$db->where("lang_id=?",$lang_id);
			$db->query();
			header("Location:".$this->url("language/manage/1"));
			exit(0);
		}

		function enableAction()
		{
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}


			$lang_id=$this->getParam(1);
			if($lang_id==1)
			{
				header("Location:".$this->url("message/error/1043"));
				exit(0);
			}
		/*	$mdl=$this->modelInstance("nesote_email_languages");
			$mdl->load($lang_id);
			$mdl->setStatus(1);
			$mdl->update();*/
	$db= new NesoteDALController();
	$db->update("nesote_email_languages");
	$db->set("status=?",array(1));
	$db->where("id=?",array($lang_id));
	$result=$db->query();
		
			header("Location:".$this->url("language/manage/2"));
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


			$lang_id=$this->getParam(1);
			if($lang_id==1)
			{
				header("Location:".$this->url("message/error/1044"));
				exit(0);
			}
			$server=$_SERVER['HTTP_HOST'];
			//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="www.inoutwebmaildemo.com") || ($_SERVER['HTTP_HOST']=="inoutwebmaildemo.com") )
			//{
if($restricted_mode=='true')
			{
				//if($lang_id<4)
				//{
					header("Location:".$this->url("message/error/1023"));
					exit(0);
				//}
			}

		/*	$mdl=$this->modelInstance("nesote_email_languages");
			$mdl->load($lang_id);
			$mdl->setStatus(0);
			$mdl->update();*/
				$db= new NesoteDALController();
	$db->update("nesote_email_languages");
	$db->set("status=?",array(0));
	$db->where("id=?",array($lang_id));
	$result=$db->query();
			header("Location:".$this->url("language/manage/3"));
			exit(0);
		}



		function messagesAction()
		{
		    
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}


			if(!isset($_POST['lang']))
			$lang_id=$this->getParam(1);
			else
			$lang_id=$_POST['lang'];

			//			if( $_SERVER['HTTP_HOST']=="www.inoutwebmaildemo.com" || $_SERVER['HTTP_HOST']=="inoutwebmaildemo.com" )
			//			{
			//				if($lang_id<4)
			//				{
			//					header("Location:".$this->url("message/error/1023"));
			//					exit(0);
			//				}
			//			}

			$this->setValue("lang_id",$lang_id);
			$db= new NesoteDALController();
			$tot=$db->total("nesote_email_languages","id=?",array($lang_id));
			if($tot==0)
			{
				header("Location:".$this->url("message/error/1037"));
				exit(0);
			}
			$db->select("nesote_email_messages");
			$db->fields("msg_id,wordscript");
			$db->where("lang_id=?",array(1));
			$result=$db->query();
		//	echo $db->getQuery();exit;
			$this->setLoopValue("messages",$result->getResult());
		}



		function getmessage($mid,$lid)
		{
			$db= new NesoteDALController();
			$db->select("nesote_email_messages");
			$db->fields("msg_id,wordscript");
			$db->where("lang_id=? and msg_id=?",array($lid,$mid));
			$result=$db->query();
			$row=$db->fetchRow($result);
			return $row[1];
		}

		function getcategorymessage($mid,$lid)
		{
			$db= new NesoteDALController();
			$db->select("nesote_inoutarticle_category_message");
			$db->fields("cat_id,message");
			$db->where("lang_id=? and cat_id=?",array($lid,$mid));
			$result=$db->query();
			$row=$db->fetchRow($result);
			return $row[1];
		}

		function getmonthsmessage($mid,$lid)
		{
			$db= new NesoteDALController();
			$db->select("nesote_email_months_messages");
			$db->fields("month_id,message");
			$db->where("lang_id=? and month_id=?",array($lid,$mid));
			$result=$db->query();
			$row=$db->fetchRow($result);
			return $row[1];
		}

		function getparametermessage($mid,$lid)
		{
			$db= new NesoteDALController();
			$db->select("nesote_inoutarticle_parameters_messages");
			$db->fields("cust_id,message");
			$db->where("lang_id=? and cust_id=?",array($lid,$mid));
			$result=$db->query();
			$row=$db->fetchRow($result);
			return $row[1];
		}

		function getparametervalues($mid,$lid)
		{
			$db= new NesoteDALController();
			$db->select("nesote_inoutarticle_parameters_messages");
			$db->fields("value");
			$db->where("lang_id=? and cust_id=?",array($lid,$mid));
			$result=$db->query();
			$row=$db->fetchRow($result);
			return $row[0];
		}


		function storemessageinfoAction()
		{
require("script.inc.php");
		    ob_start();
		    
		    //ini_set('display_errors', 1);
            //ini_set('display_startup_errors', 1);
            //error_reporting(E_ALL);  
            // echo "<pre>";
            // print_r($_POST);
             //echo "</pre>";
            // exit;
            
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}
				
			//if( ($_SERVER['HTTP_HOST']=="www.inoutwebportal.com") || ($_SERVER['HTTP_HOST']=="inoutwebportal.com")||($_SERVER['HTTP_HOST']=="www.inoutwebmaildemo.com") || ($_SERVER['HTTP_HOST']=="inoutwebmaildemo.com") )
			//{
if($restricted_mode=='true')
			{
				//if($lang_id<4)
				//{
					header("Location:".$this->url("message/error/1023"));
					exit(0);
				//}
			}

			$lang_id=$this->getParam(1);
			$db= new NesoteDALController();
			$db->select("nesote_email_messages");
			$db->fields("msg_id");
			$db->where("lang_id=?",array(1));
			$result=$db->query();

            //echo $db->getQuery();exit;
			$quotes=get_magic_quotes_gpc();
			//echo $quotes;
	
			while($row=$result->fetchRow())
			{  
			  
				if($_POST['script'.$row[0]]!="")
				{

                     print_r($_POST['script'.$row[0]]);
 
					$wordscript=$_POST['script'.$row[0]];
					$tot=$db->total("nesote_email_messages","lang_id=? and msg_id=?",array($lang_id,$row[0]));
					$total=$db->total("nesote_email_messages","lang_id=? and msg_id<>? and wordscript=?",array($lang_id,$row[0],$wordscript));
					if($total==0)
					{
					    
						if($tot==0)
						{
						    
							/*$mdl=$this->modelInstance("nesote_email_messages");
							$mdl->setMsg_id($row[0]);
							$mdl->setLang_id($lang_id);*/
							if($quotes==1)
							{
								$messages=stripslashes($wordscript);
								//echo $messages;
								// echo stripslashes($wordscript);
								//$mdl->setWordscript($messages);
							}
							else
							{
							//	$mdl->setWordscript($wordscript);
								$messages=$wordscript;
							}
						//	$mdl->save();
							$db->insert("nesote_email_messages");
                			$db->fields("msg_id,lang_id,wordscript");
                			$db->values(array($row[0],$lang_id,$messages));
                			$result_11=$db->query();
							
						}
						else
						{
						 
							$db->select("nesote_email_messages");
							$db->fields("id");
							$db->where("msg_id=? and lang_id=?",array($row[0],$lang_id));
							$result1=$db->query();
							//echo $db->getQuery();exit;
							$row1=$result1->fetchRow();
						//	$mdl=$this->modelInstance("nesote_email_messages");
						//	$mdl->load($row1[0]);
						
						

							if($quotes==1)
							{
							    //echo "c";exit;
								$messages=stripslashes($wordscript);
								//echo stripslashes($wordscript);
								//echo $messages;
							//	$mdl->setWordscript($messages);
							}
							else
							{
							     //echo "d";exit;
							//	$mdl->setWordscript($wordscript);
								$messages=$wordscript;
								//echo $messages;
							}
						//	$mdl->update();
						
                    	$db->update("nesote_email_messages");
                    	$db->set("wordscript=?",array($messages));
                    	$db->where("id=?",array($row1[0]));
                    	$result_22=$db->query();
                    	
                    	
						}
					}
				}
// var_dump($_POST);exit;
				if($_POST['script'.$row[0]]=="")
				{
					$tot=$db->total("nesote_email_messages","lang_id=? and msg_id=?",array($lang_id,$row[0]));
					if($tot!=0)
					{

						$db->select("nesote_email_messages");
						$db->fields("id");
						$db->where("msg_id=? and lang_id=?",array($row[0],$lang_id));
						$result111=$db->query();
						$row1=$result111->fetchRow();
						$db->delete("nesote_email_messages");
						$db->where("id=?",$row1[0]);
						$db->query();

					}

				}
			}
		//	ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

			header("Location:".$this->url("language/manage/4"));
			exit(0);
		}

		function languagename($langid)
		{
			$db= new NesoteDALController();
			$db->select("nesote_email_languages");
			$db->fields("language");
			$db->where("id=?",array($langid));
			$result=$db->query();
			$row=$db->fetchRow($result);
			return $row[0];
		}
		////////////////////////////////////////


		function new_messagesAction()
		{
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}

			$db= new NesoteDALController();
			$db->select("nesote_email_languages");
			$db->fields("id");
			$db->where("language=?","English");
			$result=$db->query();
			//echo $db->getQuery();
			$row=$db->fetchRow($result);
			$id=$this->setValue("id",$row[0]);
		}

		function store_messagesAction()
		{
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}

			$id=$this->getParam(1);
			$message=trim($_POST['message']);

			$db= new NesoteDALController();
			$db->select("nesote_email_messages");
			$db->fields("msg_id");
			$db->where("lang_id=?",$id);
			$db->order("msg_id desc");
			$db->limit(0,1);
			$result=$db->query();
			//echo $db->getQuery();
			$row=$result->fetchRow();
			$messageid=$row[0] +1;
			//echo $messageid;
			//echo $message;

			$tot=$db->total("nesote_email_messages","lang_id=? and wordscript=?",array($id,$message));
			if($tot!=0)
			{
				header("Location:".$this->url("message/error/1047"));
				exit(0);
			}
			else
			{
			/*	$mdl=$this->modelInstance("nesote_email_messages");
				//$mdl->load($row1[0]);
				$mdl->setMsg_id($messageid);
				$mdl->setLang_id($id);
				$mdl->setWordscript($message);
				$mdl->save();*/
				
				
						$db->insert("nesote_email_messages");
						$db->fields("msg_id,lang_id,wordscript");
						$db->values(array($messageid,$id,$message));
						$result=$db->query();

				header("Location:".$this->url("message/success/1046/5"));
				exit(0);
			}

		}

		function messages_codesAction()
		{
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}


			///////////////////////////////////
			$perpagesize=50;
			$currentpage=1;
			//$db=new NesoteDALController();
			//$tot=$db->total(array("a"=>"inout_ipns","b"=>"inout_users"),"a.userid=b.userid  and $condition", $conditionarray);
			$db=new NesoteDALController();
			$tot=$db->total(array("a"=>"nesote_email_languages","b"=>"nesote_email_messages"),"a.language=? and  a.id=b.lang_id","English");
			if(isset($_POST['pagenumber'])&&trim($_POST['pagenumber'])!="")
			$currentpage=$_POST['pagenumber'];
			$paging= new Paging();
			//echo $paging;
			$out=$paging->page($tot,$perpagesize,"page",1,1,1,"","","",$_POST);
			//echo $tot;
			//echo $out;
			$this->setValue("pagingtop",$out);
			//echo $out;
			//$this->setValue("num",$tot);

			////////////////////////////////////////////

			$db= new NesoteDALController();
			$db->select(array("a"=>"nesote_email_languages","b"=>"nesote_email_messages"));
			$db->fields("b.msg_id,b.wordscript");
			$db->where("a.language=? and  a.id=b.lang_id","English");
			$db->order("b.msg_id");
			$db->limit(($currentpage-1)*$perpagesize, $perpagesize);

			$result=$db->query();
			//echo $db->getQuery();
			$this->setLoopValue("codes",$result->getResult());
		}


		//parameters and categories.........

		function parametersAction()
		{
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}


			if(!isset($_POST['lang']))
			$lang_id=$this->getParam(1);
			else
			$lang_id=$_POST['lang'];
			$this->setValue("lang_id",$lang_id);
			$db= new NesoteDALController();
			$tot=$db->total("nesote_email_languages","id=?",array($lang_id));
			if($tot==0)
			{
				header("Location:".$this->url("message/error/1037"));
				exit(0);
			}

			$db->select("nesote_inoutarticle_custom_fields");
			$db->fields("id,label,type");
			//$db->where("lang_id=?",array(1));
			$result=$db->query();
			//echo $db->getQuery();
			$this->setLoopValue("messages",$result->getResult());

		}

		function storeparameterinfoAction()
		{
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}


			$lang_id=$this->getParam(1);
			$db= new NesoteDALController();
			$db->select("nesote_inoutarticle_custom_fields");
			$db->fields("id");
			//$db->where("lang_id=?",array(1));
			$result=$db->query();

			$quotes=get_magic_quotes_gpc();
			//echo $quotes;
			//print_r($_POST);
			while($row=$result->fetchRow())
			{
				if($_POST['script'.$row[0]]!="")
				{

					$wordscript=$_POST['script'.$row[0]];
					$tot=$db->total("nesote_inoutarticle_parameters_messages","lang_id=? and cust_id=?",array($lang_id,$row[0]));
					//echo $db->getQuery();
					//$total=$db->total("nesote_inoutarticle_parameters_messages","lang_id=? and cust_id<>? and message=?",array($lang_id,$row[0],$wordscript));
					//echo $db->getQuery();
					//echo "total".$total."tot".$tot;

					if($tot==0)
					{

					/*	$mdl=$this->modelInstance("nesote_inoutarticle_parameters_messages");
						$mdl->setCust_id($row[0]);
						$mdl->setLang_id($lang_id);*/
						if($quotes==1)
						{
							$messages=stripslashes($wordscript);
							//echo $messages;
							// echo stripslashes($wordscript);
							$mdl->setMessage($messages);
						}
						else
						{
						//	$mdl->setMessage($wordscript);
							$messages=$wordscript;
						}
						if($_POST['values'.$row[0]]!="")
						{
							$val=$_POST['values'.$row[0]];
							$value=$this->getparameterfiledvalues($val);
						//	if($value!="")
						//	$mdl->setValue($value);
						}

					//	$mdl->save();
						
							$db->insert("nesote_inoutarticle_parameters_messages");
								if($value!=""){
						$db->fields("cust_id,lang_id,message,value");
						$db->values(array($row[0],$lang_id,$message,$value));
								}
								else
								{
								$db->fields("cust_id,lang_id,message");
						$db->values(array($row[0],$lang_id,$message));	    
								}
						$result=$db->query();

					}
					else
					{
						$db->select("nesote_inoutarticle_parameters_messages");
						$db->fields("id");
						$db->where("cust_id=? and lang_id=?",array($row[0],$lang_id));
						$result1=$db->query();
						$row1=$result1->fetchRow();
						//$mdl=$this->modelInstance("nesote_inoutarticle_parameters_messages");
					//	$mdl->load($row1[0]);
						if($quotes==1)
						{
							$messages=stripslashes($wordscript);
							//echo stripslashes($wordscript);
							//echo $messages;
						//	$mdl->setMessage($messages);
						}
						else
						{
						//	$mdl->setMessage($wordscript);
							$messages=$wordscript;
						}

						if($_POST['values'.$row[0]]!="")
						{
							$val=$_POST['values'.$row[0]];
							$value=$this->getparameterfiledvalues($val);
							//if($value!="")
							//echo $value;
							//$mdl->setValue($value);
						}
						//$mdl->update();
						
							$db= new NesoteDALController();
	$db->update("nesote_inoutarticle_parameters_messages");
	if($value!="")
	$db->set("message=?,value=?",array($messages,$value));
	else
	$db->set("message=?",array($messages));
	$db->where("id=?",array($lang_id));
	$result=$db->query();
					}

				}

				if($_POST['script'.$row[0]]=="")
				{
					$tot=$db->total("nesote_inoutarticle_parameters_messages","lang_id=? and cust_id=?",array($lang_id,$row[0]));
					if($tot!=0)
					{

						$db->select("nesote_inoutarticle_parameters_messages");
						$db->fields("id");
						$db->where("cust_id=? and lang_id=?",array($row[0],$lang_id));
						$result1=$db->query();
						$row1=$result1->fetchRow();
						$db->delete("nesote_inoutarticle_parameters_messages");
						$db->where("id=?",$row1[0]);
						$db->query();

					}

				}
			}
			header("Location:".$this->url("language/manage/8"));
			exit(0);
		}


		function getparameterfiledvalues($value)
		{
			$value=explode(",",$value);
			$elements=array();
			for($i=0;$i<count($value);$i++)
			{
				if(!in_array($value[$i],$elements))
				array_push($elements,$value[$i]);

			}
			$value="";
			//print_r($value);
			for($i=0;$i<count($elements);$i++)
			{
				if($i==0)
				$value=$value.$elements[$i];
				else
				$value=$value.",".$elements[$i];

			}
			return $value;
		}

		function categoriesAction()
		{
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index"));
				exit(0);
			}


			if(!isset($_POST['lang']))
			$lang_id=$this->getParam(1);
			else
			$lang_id=$_POST['lang'];
			$this->setValue("lang_id",$lang_id);
			$db= new NesoteDALController();
			$tot=$db->total("nesote_email_languages","id=?",array($lang_id));
			if($tot==0)
			{
				header("Location:".$this->url("message/error/1037"));
				exit(0);
			}
			$db->select("nesote_inoutarticle_categories");
			$db->fields("id,categoryname");
			$result=$db->query();
			//echo $db->getQuery();
			$this->setLoopValue("messages",$result->getResult());
		}

		function storecategoryinfoAction()
		{
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index/2"));
				exit(0);
			}

			$lang_id=$this->getParam(1);
			$db= new NesoteDALController();
			$db->select("nesote_inoutarticle_categories");
			$db->fields("id");
			//$db->where("lang_id=?",array(1));
			$result=$db->query();

			$quotes=get_magic_quotes_gpc();
			//echo $quotes;

			while($row=$result->fetchRow())
			{
				if($_POST['script'.$row[0]]!="")
				{

					$wordscript=$_POST['script'.$row[0]];
					$tot=$db->total("nesote_inoutarticle_category_message","lang_id=? and cat_id=?",array($lang_id,$row[0]));
					$total=$db->total("nesote_inoutarticle_category_message","lang_id=? and cat_id<>? and message=?",array($lang_id,$row[0],$wordscript));
					//echo $db->getQuery();
					if($total==0)
					{
						if($tot==0)
						{
						//	$mdl=$this->modelInstance("nesote_inoutarticle_category_message");
						//	$mdl->setCat_id($row[0]);
						//	$mdl->setLang_id($lang_id);
							if($quotes==1)
							{
								$messages=stripslashes($wordscript);
								//echo $messages;
								// echo stripslashes($wordscript);
							//	$mdl->setMessage($messages);
							}
							else
							{
							//	$mdl->setMessage($wordscript);
								$messages=$wordscript;
							}
						//	$mdl->save();
							
								$db->insert("nesote_inoutarticle_category_message");
							
						$db->fields("cat_id,lang_id,message,value");
						$db->values(array($row[0],$lang_id,$messages,$value));
								
					
						$result=$db->query();
						}
						else
						{
							$db->select("nesote_inoutarticle_category_message");
							$db->fields("id");
							$db->where("cat_id=? and lang_id=?",array($row[0],$lang_id));
							$result1=$db->query();
							$row1=$db->fetchRow($result1);
						//	$mdl=$this->modelInstance("nesote_inoutarticle_category_message");
						//	$mdl->load($row1[0]);
							if($quotes==1)
							{
								$messages=stripslashes($wordscript);
								//echo stripslashes($wordscript);
								//echo $messages;
							//	$mdl->setMessage($messages);
							}
							else
							{
							    $messages=$wordscript;
							//	$mdl->setMessage($wordscript);
							}
						//	$mdl->update();
							
							$db->update("nesote_inoutarticle_category_message");
	$db->set("message=?",array($messages));
	$db->where("id=?",array($row1[0]));
	$result=$db->query();
						}
					}
				}

				if($_POST['script'.$row[0]]=="")
				{
					$tot=$db->total("nesote_inoutarticle_category_message","lang_id=? and cat_id=?",array($lang_id,$row[0]));
					if($tot!=0)
					{

						$db->select("nesote_inoutarticle_category_message");
						$db->fields("id");
						$db->where("cat_id=? and lang_id=?",array($row[0],$lang_id));
						$result1=$db->query();
						$row1=$db->fetchRow($result1);
						$db->delete("nesote_inoutarticle_category_message");
						$db->where("id=?",$row1[0]);
						$db->query();

					}

				}
			}
			header("Location:".$this->url("language/manage/7"));
			exit(0);
		}

		function monthsAction()
		{
			if(!$this->validUser())
			{
				header("Location:".$this->url("index/index/2"));
				exit(0);
			}



			if(!isset($_POST['lang']))
			$lang_id=$this->getParam(1);
			else
			$lang_id=$_POST['lang'];
			$this->setValue("lang_id",$lang_id);

			$server=$_SERVER['HTTP_HOST'];
			//			if(($server=="www.inoutwebmaildemo.com") || ($server=="inoutwebmaildemo.com"))
			//			{
			//				if($lang_id<4)
				//				{
				//					header("Location:".$this->url("message/error/1023"));
				//					exit(0);
				//				}
				//			}

				$db= new NesoteDALController();
				$tot=$db->total("nesote_email_languages","id=?",array($lang_id));
				if($tot==0)
				{
					header("Location:".$this->url("message/error/1037"));
					exit(0);
				}
				$db->select("nesote_email_months_messages");
				$db->fields("*");
				$db->where("lang_id=?",array(1));
				$result=$db->query();
				//echo $db->getQuery();
				$this->setLoopValue("messages",$result->getResult());
			}


			function storemonthinfoAction()
			{
				if(!$this->validUser())
				{
					header("Location:".$this->url("index/index"));
					exit(0);
				}
				if( $_SERVER['HTTP_HOST']=="www.inoutwebportal.com" || $_SERVER['HTTP_HOST']=="inoutwebportal.com" )
				{
					if($lang_id<4)
					{
						header("Location:".$this->url("message/error/1023"));
						exit(0);
					}
				}
				$lang_id=$this->getParam(1);
				$db= new NesoteDALController();
				$db->select("nesote_email_months_messages");
				$db->fields("id");
				$db->where("lang_id=?",array(1));
				$result=$db->query();

				$quotes=get_magic_quotes_gpc();
				//echo $quotes;

				while($row=$result->fetchRow())
				{
					if($_POST['script'.$row[0]]!="")
					{

						$wordscript=$_POST['script'.$row[0]];
						$tot=$db->total("nesote_email_months_messages","lang_id=? and month_id=?",array($lang_id,$row[0]));
						$total=$db->total("nesote_email_months_messages","lang_id=? and month_id<>? and message=?",array($lang_id,$row[0],$wordscript));
						//echo $db->getQuery();
						if($total==0)
						{
							if($tot==0)
							{
							//	$mdl=$this->modelInstance("nesote_email_months_messages");
							//	$mdl->setMonth_id($row[0]);
							//	$mdl->setLang_id($lang_id);
								if($quotes==1)
								{
									$messages=stripslashes($wordscript);
									//echo $messages;
									// echo stripslashes($wordscript);
								//	$mdl->setMessage($messages);
								}
								else
								{
									//$mdl->setMessage($wordscript);
									$messages=$wordscript;
								}
							//	$mdl->save();
								$db->insert("nesote_email_months_messages");
							
						$db->fields("month_id,lang_id,message");
						$db->values(array($row[0],$lang_id,$messages));
							}
							else
							{
								$db->select("nesote_email_months_messages");
								$db->fields("id");
								$db->where("month_id=? and lang_id=?",array($row[0],$lang_id));
								$result1=$db->query();
								$row1=$db->fetchRow($result1);
							//	$mdl=$this->modelInstance("nesote_email_months_messages");
							//	$mdl->load($row1[0]);
								if($quotes==1)
								{
									$messages=stripslashes($wordscript);
									//echo stripslashes($wordscript);
									//echo $messages;
								//	$mdl->setMessage($messages);
								}
								else
								{
								//	$mdl->setMessage($wordscript);
									$messages=$wordscript;
								}
							//	$mdl->update();
								
									$db->update("nesote_email_months_messages");
	$db->set("message=?",array($messages));
	$db->where("id=?",array($row1[0]));
	$result=$db->query();
							}
						}
					}

					if($_POST['script'.$row[0]]=="")
					{
						$tot=$db->total("nesote_email_months_messages","lang_id=? and month_id=?",array($lang_id,$row[0]));
						if($tot!=0)
						{

							$db->select("nesote_email_months_messages");
							$db->fields("id");
							$db->where("month_id=? and lang_id=?",array($row[0],$lang_id));
							$result1=$db->query();
							$row1=$db->fetchRow($result1);
							$db->delete("nesote_inoutarticle_months_messages");
							$db->where("id=?",$row1[0]);
							$db->query();

						}

					}
				}
				header("Location:".$this->url("language/manage/9"));
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
			function getGid()
			{
				$username=$_COOKIE['a_username'];
				$password=$_COOKIE['a_password'];
				$db=new NesoteDALController();
				$db->select("nesote_email_admin");
				$db->fields("id");
				$db->where("username=? and password=?",array($username,$password));
				$res=$db->query();
				$row=$db->fetchRow($res) ;
				return $row[0];
			}


			function gettemplatecode($msgid,$wordscripts)
			{
				$count=	substr_count($wordscripts,"{");
				if($count==0)
				{

					return "{cfn:getmessage(".$msgid.")}";
				}
				else
				{
					return "";
				}

			}


		}
		?>
