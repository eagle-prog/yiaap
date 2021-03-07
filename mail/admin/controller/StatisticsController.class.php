<?php
class StatisticsController extends NesoteController
{

	function accountactivityAction()
	{
		$timeperiod=$this->getParam(1);
		$month1=$this->getParam(2);
		$year1=$this->getParam(3);

		if($month1!="")
		{
			if($month1<10)
			$month1="0".$month1;
		}
//$timeperiod=1;

		//$this->setValue("time",$timeperiod);

		$current_time=time();
		$d=date("d",$current_time);
		$m=date("m",$current_time);
		//if($m<10)
		//$m="0".$m;
		$y=date("Y",$current_time);

		$mktime=mktime(0,0,0,$m,$d,$y);
		if($month1=="")
		$month1=$m;
		if($year1=="")
		$year1=$y;

		//$year="";
                $year=array();
		for($i=2000,$j=0;$i<=$y;$i++,$j++)
		{
			$year[$j][0]=$i;
		}
		$this->setLoopValue("year",$year);
		$this->setValue("year1",$year1);
		$this->setValue("month1",$month1);

		//$lang_id=$_COOKIE['lang_id'];
		$db1=new NesoteDALController();
		$db1->select("nesote_email_months_messages");
		$db1->fields("month_id,message");
		$db1->where("lang_id=?",1);
		$result1=$db1->query();
		$this->setLoopValue("month",$result1->getResult());




		//if($timeperiod=='today')
		$flag=86400;
		//		if($timeperiod=='lastweek')
		//		$flag=604800;
			
		//$time=time()-$flag;
	 $db=new NesoteDALController();

	 $exist=1;
require("script.inc.php");
include($config_path."database.default.config.php");


	 if(($month1=="")&&($year1!=""))
	 {
	 	$sql="SELECT * FROM  ".$db_tableprefix."nesote_email_ip_".$m.$year1." ";
	 	$result=@mysqli_query($conn,$sql);
	 	if (!$result)
	 	{
	 		$exist=0;
	 	}
	 	else
	 	$append=$m.$year1;
	 }
	 else if(($month1!="")&&($year1==""))
	 {
	 	$sql="SELECT * FROM  ".$db_tableprefix."nesote_email_ip_".$month1.$y." ";
	 	$result=@mysqli_query($conn,$sql);
	 	if (!$result)
	 	{
	 		$exist=0;
	 	}
	 	else
	 	$append=$month1.$y;
	 }
	  

	 else if(($month1!="")&&($year1!=""))
	 {

	 	$sql="SELECT * FROM  ".$db_tableprefix."nesote_email_ip_".$month1.$year1." ";
	 	$result=@mysqli_query($conn,$sql);
	 	if (!$result)
	 	{
	 		$exist=0;
	 	}
	 	else
	 	$append=$month1.$year1;


	 }
	 else
	 {
	 	$sql="SELECT * FROM ".$db_tableprefix."nesote_email_ip_".$m.$y." ";
	 	$result=@mysqli_query($conn,$sql);
	 	if(!$result)
	 	{
	 		$exit=0;
	 	}
	 	else
	 	{
	 		$append=$m.$y;
	 		//$month1=$m;
	 		//$year1=$y;
	 		//echo "jkjk".$append;
	 	}
	 }



	 if($exist!=0)
	 {  if($timeperiod=="")
	 $tot=$db->total(array("i"=>"nesote_email_ip_".$append." ","u"=>"nesote_inoutscripts_users","c"=>"nesote_email_country"),"i.userid=u.id and i.country=c.code and i.time>=? order by i.time desc",$mktime);               // $tot=$db->total("nesote_email_ip_".$append." ","time>=?",array($mktime));
	 else
	 $tot=$db->total(array("i"=>"nesote_email_ip_".$append." ","u"=>"nesote_inoutscripts_users","c"=>"nesote_email_country"),"i.userid=u.id and i.country=c.code order by i.time desc");//$tot=$db->total("nesote_email_ip_".$append." ");
	 

//echo $db->getQuery();
         $perpagesize=15;
	 $currentpage=1;
	 if(isset($_POST['pagenumber'])&&trim($_POST['pagenumber'])!="")
	 $currentpage=$_POST['pagenumber'];
	 $paging= new Paging();
	 $out=$paging->page($tot,$perpagesize,"test",1,1,1,"","","",$_POST);
	 $this->setValue("pagingtop",$out);
	 $this->setValue("count",$tot);

	 $db->select(array("i"=>"nesote_email_ip_".$append." ","u"=>"nesote_inoutscripts_users","c"=>"nesote_email_country"));

	  
	 $db->fields("i.id,u.username,i.ip,i.time,c.name");
	 if($timeperiod=="")
	 $db->where("i.userid=u.id and i.country=c.code and i.time>=?",$mktime);
	 else
	 $db->where("i.userid=u.id and i.country=c.code");
	 $db->order("i.time desc");
	 $db->limit(($currentpage-1)*$perpagesize, $perpagesize);
	 $res=$db->query();


	 $this->setLoopValue("ip",$res->getResult());
	 $this->setValue("norslt",1);
	 }
	 else
	 $this->setValue("norslt",0);

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


	function graphAction()
	{

		$show=$this->getParam(1);
		$month=$this->getParam(2);
		//$this->setValue("setmonth",$month);
		if($month<10)
		$month="0".$month;
		$year=$this->getParam(3);
		if($show=="today")
		{//echo "dsw";
			$flag_time=-1;
			$showmessage="today";
			$time=mktime(0,0,0,date("m",time()),date("d",time()),date("y",time()));
			$end_time=mktime(date("H",time()),0,0,date("m",time()),date("d",time()),date("y",time()));
			$beg_time=$time;
			//echo date("H",time());
			//echo date("d M h a",$end_time);

		}

		else if($show=="month")
		{
			if($year=="")
			$year=date("Y",time());

			$flag_time=0;
			$showmessage="Last 30 days";
			$time=mktime(0,0,0,$month,1,$year); //mktime(0,0,0,date("m",time()),1,date("y",time()));
			//$end_time=mktime(0,0,0,date("m",time()),date("d",time())+1,date("y",time()));
			$end_time=mktime(0,0,0,$month,date("t",time()),$year);
			$beg_time=$time;
		}
		else if($show=="year")
		{
			$flag_time=1;
			$showmessage="Last 12 months";
			$time=mktime(0,0,0,1,1,$year);//$end_time-(365*24*60*60); //mktime(0,0,0,1,1,date("y",time()));
			$end_time=mktime(0,0,0,12,31,$year);
			$beg_time=$time;
		}
		else if($show=="all")
		{
			$flag_time=2;
			$showmessage="All Time";
			$time=mktime(0,0,0,1,1,2000);
			$end_time=mktime(0,0,0,1,1,date("y",time())+1);
			$beg_time=$time;
		}


		$returnVal=$this->plotGraphs($show,$flag_time,$beg_time,$end_time,$month,$year);


		$FC=$returnVal[0];
		$FC->renderChart();

	}
function suff($i) {
    $j = $i % 10;
        $k = $i % 100;
        
    if ($j == 1 && $k != 11) {
    	
        return $i."st";
    }
    if ($j == 2 && $k != 12) {
        return $i."nd";
    }
    if ($j == 3 && $k != 13) {
        return $i."rd";
    }
    return $i."th";
}
	function showgraphAction()
	{

// to display in sleetc box start

$d=date("d",time());
		$m=date("m",time());
		$y=date("Y",time());

		for($i=2000,$j=0;$i<=$y;$i++,$j++)
		{
			$years[$j][0]=$i;
		}
		$this->setLoopValue("year",$years);
		$db=new NesoteDALController();	
		$db1=new NesoteDALController();
		$db1->select("nesote_email_months_messages");
		$db1->fields("month_id,message");
		$db1->where("lang_id=?",1);
		$result1=$db1->query();
		$this->setLoopValue("month",$result1->getResult());
$show=$this->getParam(1);$month=$this->getParam(2);$year=$this->getParam(3);
		if($show=="")
		$show="today";
		if($month=="" && $show=="today")
		$month=date("n",time());
		$this->setValue("setmonth",$month);
		if($month<10)
		$month="0".$month;
		if($year=="" && $show=="today")
		$year=date("Y",time());
		$this->setValue("setyear",$year);
		$show=$this->getParam(1);$month=$this->getParam(2);$year=$this->getParam(3);
		if($show=="" && $month=="" && $year=="")
		$show="month";
		$this->setValue("show",$show);
			

		if($show=="today")
		{//echo "dsw";
			$flag_time=-1;
			$showmessage="today";
			$time=mktime(0,0,0,date("m",time()),date("d",time()),date("y",time()));
			$end_time=mktime(date("H",time()),0,0,date("m",time()),date("d",time()),date("y",time()));
			$beg_time=$time;
		}
		else if($show=="month")
		{
			if($year=="")
			$year=date("Y",time());

			$flag_time=0;
			$showmessage="Last 30 days";
			$time=mktime(0,0,0,$month,1,$year);
			$end_time=mktime(0,0,0,$month,date("t",time()),$year);
			$beg_time=$time;
		}
		else if($show=="year")
		{
			$flag_time=1;
			$showmessage="Last 12 months";
			$time=mktime(0,0,0,1,1,$year);
			$end_time=mktime(0,0,0,12,31,$year);
			$beg_time=$time;
		}
		else if($show=="all")
		{
			$flag_time=2;
			$showmessage="All Time";
			$time=mktime(0,0,0,1,1,2000);
			$end_time=mktime(0,0,0,1,1,date("y",time())+1);
			$beg_time=$time;
		}
// to display in select box end

$todayday=date("d",time());
if($month=='')
$currmonth=date("m",time());
else
{
if($month<10)
$currmonth='0'.$month;
else
$currmonth=$month;
}
if($year=='')
$curryear=date("Y",time());
else
$curryear=$year;


//$timestampcurrmonth = mktime(0,0,0,$datenow[1],1,$datenow[2]);
//$timestampcurryear=mktime(0,0,0,1,1,$datenow[2]);








$number = cal_days_in_month(CAL_GREGORIAN, $currmonth, $curryear);
$timestampreceveir="";
$datareceiver1="data: [";
$arraybuilding="labels : [";

//for ipn table 
		//if($m<10)
require("script.inc.php");
include($config_path."database.default.config.php");
                                      
$sql1="SELECT time FROM  ".$db_tableprefix."nesote_email_ip_".$currmonth.$curryear." ";

//echo $sql1;exit;
				$result12=@mysqli_query($conn,$sql1);
				if ($result12)
				{
					
				


for ($i = 1; $i <= $number; $i++) {
	
	
	$ni=$this->suff($i);
	//echo $ni;exit;
	
	$arraybuilding.='"'.$ni.'",';
	$timestampreceveir=strtotime($i."-".$currmonth."-".$curryear);
	$nt=$i+1;
$timestampnext=strtotime($nt."-".$currmonth."-".$curryear);

$db->select("nesote_email_ip_".$currmonth.$curryear);
			
	$db->fields("COUNT(id)");
			
	$db->where("time >=? and time <=?",array($timestampreceveir,$timestampnext));

        //$db->group("userid");
			
	$res=$db->query();
	$row33=$res->fetchRow();
//echo $db->getQuery();exit;
$tot=$row33[0];
$datareceiver1.=$tot.",";
//if($todayday==$i){
//		break;
		
//	}

}//exit;
//echo $datareceiver1;exit;
$arraybuilding.="],";
$datareceiver1.="]";
$this->setValue("daily",$arraybuilding);
$this->setValue("totaldataday",$datareceiver1);

/*$montharybuilder="labels : [";
$datareceiver1mnth="data: [";
for ($m=1; $m<=12; $m++) {
     $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
 $timeStampfirstday=mktime(0,0,0,$m, 1, date('Y'));
$timeStamplastday=mktime(0, 0, 0, $m+1 , 1, date("Y"));
$montharybuilder.='"'.substr($month,0,3).'",';


$db=new NesoteDALController();
$db->select("nesote_email_ip_".$m.$y);
			
	$db->fields("COUNT(id)");
			
	$db->where("time >=? and time <=?",array($timeStampfirstday,$timeStamplastday));

        //$db->group("userid");
			
	$res=$db->query();
	$row33=$res->fetchRow();
//echo $db->getQuery();
$totm=$row33[0];
$datareceiver1mnth.=$totm.",";
if($currmonth==$m){

break;	
	
}

}
$montharybuilder.="],";
$datareceiver1mnth.="]";
$this->setValue("monthly",$montharybuilder);
$this->setValue("totaldatamnth",$datareceiver1mnth);*/
//total amount


	
		}
else
{
$ng="a";
//echo "aaa";exit;
$this->setValue("nograph",$ng);
$this->setValue("daily","");
$this->setValue("totaldataday","");
}
	}
function regshowgraphAction()
	{

// to display in sleetc box start

$d=date("d",time());
		$m=date("m",time());
		$y=date("Y",time());

		for($i=2000,$j=0;$i<=$y;$i++,$j++)
		{
			$years[$j][0]=$i;
		}
		$this->setLoopValue("year",$years);
		$db=new NesoteDALController();	
		$db1=new NesoteDALController();
		$db1->select("nesote_email_months_messages");
		$db1->fields("month_id,message");
		$db1->where("lang_id=?",1);
		$result1=$db1->query();
		$this->setLoopValue("month",$result1->getResult());
$show=$this->getParam(1);$month=$this->getParam(2);$year=$this->getParam(3);
		if($show=="")
		$show="today";
		if($month=="" && $show=="today")
		$month=date("n",time());
		$this->setValue("setmonth",$month);
		if($month<10)
		$month="0".$month;
		if($year=="" && $show=="today")
		$year=date("Y",time());
		$this->setValue("setyear",$year);
		$show=$this->getParam(1);$month=$this->getParam(2);$year=$this->getParam(3);
		if($show=="" && $month=="" && $year=="")
		$show="month";
		$this->setValue("show",$show);
			

		if($show=="today")
		{//echo "dsw";
			$flag_time=-1;
			$showmessage="today";
			$time=mktime(0,0,0,date("m",time()),date("d",time()),date("y",time()));
			$end_time=mktime(date("H",time()),0,0,date("m",time()),date("d",time()),date("y",time()));
			$beg_time=$time;
		}
		else if($show=="month")
		{
			if($year=="")
			$year=date("Y",time());

			$flag_time=0;
			$showmessage="Last 30 days";
			$time=mktime(0,0,0,$month,1,$year);
			$end_time=mktime(0,0,0,$month,date("t",time()),$year);
			$beg_time=$time;
		}
		else if($show=="year")
		{
			$flag_time=1;
			$showmessage="Last 12 months";
			$time=mktime(0,0,0,1,1,$year);
			$end_time=mktime(0,0,0,12,31,$year);
			$beg_time=$time;
		}
		else if($show=="all")
		{
			$flag_time=2;
			$showmessage="All Time";
			$time=mktime(0,0,0,1,1,2000);
			$end_time=mktime(0,0,0,1,1,date("y",time())+1);
			$beg_time=$time;
		}
// to display in select box end

$todayday=date("d",time());
if($month=='')
$currmonth=date("m",time());
else
{
if($month<10)
$currmonth='0'.$month;
else
$currmonth=$month;
}
if($year=='')
$curryear=date("Y",time());
else
$curryear=$year;


//$timestampcurrmonth = mktime(0,0,0,$datenow[1],1,$datenow[2]);
//$timestampcurryear=mktime(0,0,0,1,1,$datenow[2]);








$number = cal_days_in_month(CAL_GREGORIAN, $currmonth, $curryear);
$timestampreceveir="";
$datareceiver1="data: [";
$arraybuilding="labels : [";

//for ipn table 
		//if($m<10)
require("script.inc.php");
include($config_path."database.default.config.php");
                                      
$sql1="SELECT id FROM  ".$db_tableprefix."nesote_inoutscripts_users";

//echo $sql1;exit;
				$result12=@mysqli_query($conn,$sql1);
				if ($result12)
				{
					
		$timeStampfirstdaycheck=mktime(0,0,0,$currmonth, 1, date($curryear));
$timeStamplastdaycheck=mktime(0, 0, 0, $currmonth+1 , 1, date($curryear));		
$db->select("nesote_inoutscripts_users");
			
	$db->fields("COUNT(id)");
			
	$db->where("joindate >=? and joindate <?",array($timeStampfirstdaycheck,$timeStamplastdaycheck));

        //$db->group("userid");
			
	$res=$db->query();
	$row35=$res->fetchRow();
//echo $db->getQuery();exit;
$totcheck=$row35[0];
if($totcheck>0)
{
for ($i = 1; $i <= $number; $i++) {
	
	
	$ni=$this->suff($i);
	//echo $ni;exit;
	
	$arraybuilding.='"'.$ni.'",';
	$timestampreceveir=strtotime($i."-".$currmonth."-".$curryear);
	$nt=$i+1;
$timestampnext=strtotime($nt."-".$currmonth."-".$curryear);

//$val1 = mysqli_query($conn,"select 1 from `nesote_email_ip_'.$tmonth.$curryear LIMIT 1");
//print_r($val1);exit;
//if($val1 !== FALSE)
//{
  // echo "aa";exit;
//}
//else
//{
//echo "b";exit;
    //I can't find it...
//}
$db->select("nesote_inoutscripts_users");
			
	$db->fields("COUNT(id)");
			
	$db->where("joindate >=? and joindate <=?",array($timestampreceveir,$timestampnext));

        //$db->group("userid");
			
	$res=$db->query();
	$row33=$res->fetchRow();
//echo $db->getQuery();exit;
$tot=$row33[0];
$datareceiver1.=$tot.",";
//if($todayday==$i){
//		break;
		
//	}

}//exit;
//echo $datareceiver1;exit;
$arraybuilding.="],";
$datareceiver1.="]";
$this->setValue("daily",$arraybuilding);
$this->setValue("totaldataday",$datareceiver1);

/*$montharybuilder="labels : [";
$datareceiver1mnth="data: [";
for ($m=1; $m<=12; $m++) {
     $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
 $timeStampfirstday=mktime(0,0,0,$m, 1, date('Y'));
$timeStamplastday=mktime(0, 0, 0, $m+1 , 1, date("Y"));
$montharybuilder.='"'.substr($month,0,3).'",';


$db=new NesoteDALController();
$db->select("nesote_email_ip_".$m.$y);
			
	$db->fields("COUNT(id)");
			
	$db->where("time >=? and time <=?",array($timeStampfirstday,$timeStamplastday));

        //$db->group("userid");
			
	$res=$db->query();
	$row33=$res->fetchRow();
//echo $db->getQuery();
$totm=$row33[0];
$datareceiver1mnth.=$totm.",";
if($currmonth==$m){

break;	
	
}

}
$montharybuilder.="],";
$datareceiver1mnth.="]";
$this->setValue("monthly",$montharybuilder);
$this->setValue("totaldatamnth",$datareceiver1mnth);*/
//total amount


	}
else
{
$ng="a";
$this->setValue("nograph",$ng);
$this->setValue("daily","");
$this->setValue("totaldataday","");
}
		}
else
{
$this->setValue("nograph","No records found");
}
	}
	function plotGraphs($show,$flag_time,$beg_time,$end_time,$month,$year)
	{
		//echo "l";exit;
		//$flag_time=1;
		//echo mktime(1,1,1,11,1,2011);
		$d=date("d",time());
		$m=date("m",time());
		if($m<10)
		$m=$m;
		$y=date("Y",time());
		//$db=new NesoteDALController();
		require("script.inc.php");
include($config_path."database.default.config.php");
		if($show=="today")
		{
			//$db->select("nesote_email_ip_".$m.$y." ");//where time<=$end_time and time>=$beg_time    order by time asc " );
			//$db->fields("time");
			//$db->where("time<=? and time>=?",array($end_time,$beg_time));
			//$db->order("time asc");
			//$res=$db->query();
			$query="select time from ".$db_tableprefix."nesote_email_ip_".$m.$y." where time<=$end_time and time>=$beg_time order by time asc";
		}
		if($show=="month")
		{
			if($year=="")
			$year=date("Y",time());
			//$db->select("nesote_email_ip_".$month.$year." ");
			//$db->fields("time");
			//$db->order("time asc");
			//$res=$db->query();

			$query="select time from ".$db_tableprefix."nesote_email_ip_".$month.$year." order by time asc";

		}
		if($show=="year")
		{
			$string_year="";
			for($months=1;$months<=12;$months++)
			{ //echo $months;
				if($months<10)
				$months="0".$months;

				$sql="SELECT time FROM  ".$db_tableprefix."nesote_email_ip_".$months.$year." ";
				$result=@mysqli_query($conn,$sql);
				if ($result)
				{
					$string_year.="select time from ".$db_tableprefix."nesote_email_ip_".$months.$year." union ";
				}


			}

			$string_year=substr_replace($string_year,"",-7);
			//$string_year=substr($string_year,16);
			//echo $string_year;
			$query=$string_year." order by time asc";//echo $query;
		}
		if($show=="all")
		{
			$string_all="";
			for($years=2000;$years<=$y;$years++)
			{
				for($months=1;$months<=12;$months++)
				{
					if($months<10)
					$months="0".$months;

					$sql="SELECT time FROM  ".$db_tableprefix."nesote_email_ip_".$months.$years." ";
					$result=@mysqli_query($conn,$sql);
					if ($result)
					{
						$string_all.="select time from ".$db_tableprefix."nesote_email_ip_".$months.$years." union ";
					}
				}
			}

			$string_all=substr_replace($string_all,"",-7);
			$query=$string_all." order by time asc";
		}
		$res=mysqli_query($conn,$query);//echo $query;
		//echo mysqli_num_rows($res);exit;
		//$result=$db->query();	echo $db->getQuery();
		//echo $db->numRows($result);	exit;
		$res_array=array();
		while($row=mysqli_fetch_row($res))
		{
			if($show=="month")
			{
				$tm=mktime(0,0,0,date("m",$row[0]),date("d",$row[0]),date("Y",$row[0]));
					
				if(isset($res_array[$tm]))
				$res_array[$tm]=$res_array[$tm]+1;
				else
				$res_array[$tm]=1;
			}


			if($show=="today")
			{
				$tm=mktime(date("H",$row[0]),0,0,date("m",$row[0]),date("d",$row[0]),date("Y",$row[0]));
				if(isset($res_array[$tm]))
				$res_array[$tm]=$res_array[$tm]+1;
				else
				$res_array[$tm]=1;
			}

			if($show=="year")
			{
				$tm=mktime(0,0,0,date("m",$row[0]),1,date("Y",$row[0]));
				if(isset($res_array[$tm]))
				$res_array[$tm]=$res_array[$tm]+1;
				else
				$res_array[$tm]=1;
			}

			if($show=="all")
			{
				$tm=mktime(0,0,0,1,1,date("Y",$row[0]));
				if(isset($res_array[$tm]))
				$res_array[$tm]=$res_array[$tm]+1;
				else
				$res_array[$tm]=1;
			}
//echo $res_array[$tm];
		}
		//echo $show;exit;	
		include_once('graph/FusionCharts/Class/FusionCharts_Gen.php');

		# Create Multiseries Column3D chart object using FusionCharts PHP Class
		$FC = new FusionCharts("MSColumn3DLineDY","1000","600");

		# Set the relative path of the swf file

		$FC->setSWFPath("graph/FusionCharts/");
			
		# Store chart attributes in a variable
		//$strParam="caption=Clicks and Impressions;subcaption=Comparison;xAxisName=Duration;yAxisName=Statistics; pYAxisName=Count;sYAxisName=CTR (%);decimalPrecision=$no_of_decimalplaces;rotateNames=1; showvalues=0;";

		$strParam="caption=Logins;xAxisName=Duration;yAxisName=Logins; pYAxisName=Count;decimalPrecision=0;rotateNames=1; showvalues=0;";

		# Set chart attributes
		$FC->setChartParams($strParam);

		//$temp_time=mktime(0,0,0,date("n",time()),date("j",time()),date("Y",time()));
		$temp_time=$beg_time;
			
		//$end_time=mktime(date("H",time()),0,0,date("n",time()),date("j",time()),date("Y",time()));
		//echo date("d m y h i",$end_time);
		while($temp_time<=$end_time)
		{//echo $temp_time;
			//echo date("d m y h i",$temp_time)."<br>";
			if($flag_time==-1)
			{//today

				$str=date("d M h a",$temp_time);
				$temp_time=mktime(date("H",$temp_time)+1,0,0,date("n",$temp_time),date("j",$temp_time),date("Y",$temp_time));
				$show_duration="$str";
				//echo $show_duration;
			}
			if($flag_time==0)
			{//within month
				$str=date("M d",$temp_time);
				$temp_time=mktime(0,0,0,date("n",$temp_time),date("j",$temp_time)+1,date("Y",$temp_time));
				$show_duration="$str";
			}
			else if($flag_time==1)
			{//within year
				$str=date("M",$temp_time);
				$temp_time=mktime(0,0,0,date("n",$temp_time)+1,1,date("Y",$temp_time));
				$show_duration="$str";
			}
			else if($flag_time==2)
			{//yearwise
				$str=date("Y",$temp_time);
				$temp_time=mktime(0,0,0,date("n",$temp_time),date("j",$temp_time),date("Y",$temp_time)+1);
				$show_duration="$str";
			}

			$FC->addCategory("$show_duration");


		}

			
		$temp_time=$beg_time;
		$FC->addDataset("Logins","showvalues=0");



		while( $temp_time<=$end_time)
		{


			if($res_array[$temp_time] == 0 || $res_array[$temp_time] == "")
			$FC->addChartData('');

			else
			$FC->addChartData("$res_array[$temp_time]");
			//break;



			if($flag_time==0)
			{
				$temp_time=mktime(0,0,0,date("n",$temp_time),date("j",$temp_time)+1,date("Y",$temp_time));
			}
			else if($flag_time==1)
			{
				$temp_time=mktime(0,0,0,date("n",$temp_time)+1,1,date("Y",$temp_time));
			}
			else if($flag_time==2)
			{

				$temp_time=mktime(0,0,0,date("n",$temp_time),date("j",$temp_time),date("Y",$temp_time)+1);
			}
			else if($flag_time==-1)
			{
				$temp_time=mktime(date("H",$temp_time)+1,0,0,date("n",$temp_time),date("j",$temp_time),date("Y",$temp_time));
			}
//echo $res_array[$temp_time];exit;
		}

		$retVal[0]=$FC;

		return $retVal;



	}
	function registration_graphAction()
	{

		$show=$this->getParam(1);
		$month=$this->getParam(2);
		if($month<10)
		$month="0".$month;
		$year=$this->getParam(3);
		if($show=="today")
		{
			$flag_time=-1;
			$showmessage="today";
			$time=mktime(0,0,0,date("m",time()),date("d",time()),date("y",time()));
			$end_time=mktime(date("H",time()),0,0,date("m",time()),date("d",time()),date("y",time()));
			$beg_time=$time;
			//echo date("H",time());
			//echo date("d M h a",$end_time);

		}

		else if($show=="month")
		{
			if($year=="")
			$year=date("Y",time());

			$flag_time=0;
			$showmessage="Last 30 days";
			$time=mktime(0,0,0,$month,1,$year); //mktime(0,0,0,date("m",time()),1,date("y",time()));
			//$end_time=mktime(0,0,0,date("m",time()),date("d",time())+1,date("y",time()));
			$end_time=mktime(0,0,0,$month,date("t",time()),$year);
			$beg_time=$time;
		}
		else if($show=="year")
		{
			$flag_time=1;
			$showmessage="Last 12 months";
			$time=mktime(0,0,0,1,1,$year);//$end_time-(365*24*60*60); //mktime(0,0,0,1,1,date("y",time()));
			$end_time=mktime(0,0,0,12,31,$year);
			$beg_time=$time;
		}
		else if($show=="all")
		{
			$flag_time=2;
			$showmessage="All Time";
			$time=mktime(0,0,0,1,1,2000);
			$end_time=mktime(0,0,0,1,1,date("y",time())+1);
			$beg_time=$time;
		}


		$returnVal=$this->plotregGraphs($show,$flag_time,$beg_time,$end_time,$month,$year);


		$FC=$returnVal[0];
		$FC->renderChart();

	}
	function registration_showgraphAction()
	{
		$d=date("d",time());
		$m=date("m",time());
		$y=date("Y",time());

		for($i=2000,$j=0;$i<=$y;$i++,$j++)
		{
			$years[$j][0]=$i;
		}
		$this->setLoopValue("year",$years);
			
		$db1=new NesoteDALController();
		$db1->select("nesote_email_months_messages");
		$db1->fields("month_id,message");
		$db1->where("lang_id=?",1);
		$result1=$db1->query();
		$this->setLoopValue("month",$result1->getResult());

		$show=$this->getParam(1);$month=$this->getParam(2);$year=$this->getParam(3);
		if($show=="")
		$show="today";
		if($month=="" && $show=="today")
		$month=date("n",time());
		$this->setValue("setmonth",$month);
		if($month<10)
		$month="0".$month;
		if($year=="" && $show=="today")
		$year=date("Y",time());
		$this->setValue("setyear",$year);
		$show=$this->getParam(1);$month=$this->getParam(2);$year=$this->getParam(3);
		if($show=="" && $month=="" && $year=="")
		$show="month";
		$this->setValue("show",$show);
			

		if($show=="today")
		{//echo "dsw";
			$flag_time=-1;
			$showmessage="today";
			$time=mktime(0,0,0,date("m",time()),date("d",time()),date("y",time()));
			$end_time=mktime(date("H",time()),date("i",time()),date("s",time()),date("m",time()),date("d",time()),date("y",time()));
			$beg_time=$time;
			
			
		}
		else if($show=="month")
		{
			if($year=="")
			$year=date("Y",time());

			$flag_time=0;
			$showmessage="Last 30 days";
			$time=mktime(0,0,0,$month,1,$year);
			$end_time=mktime(0,0,0,$month,date("t",time()),$year);
			$beg_time=$time;
		}
		else if($show=="year")
		{
			$flag_time=1;
			$showmessage="Last 12 months";
			$time=mktime(0,0,0,1,1,$year);
			$end_time=mktime(0,0,0,12,31,$year);
			$beg_time=$time;
		}
		else if($show=="all")
		{
			$flag_time=2;
			$showmessage="All Time";
			$time=mktime(0,0,0,1,1,2000);
			$end_time=mktime(0,0,0,1,1,date("y",time())+1);
			$beg_time=$time;
		}
		$returnVal=$this->plotregGraphs($show,$flag_time,$beg_time,$end_time,$month,$year);


		$FC=$returnVal[0];
		$FC->renderChart();
	}
	function plotregGraphs($show,$flag_time,$beg_time,$end_time,$month,$year)
	{
	require("script.inc.php");
include($config_path."database.default.config.php");
		$d=date("d",time());
		$m=date("m",time());
		if($m<10)
		$m="0".$m;
		$y=date("Y",time());

		if($show=="today")
		{
			$query="select joindate from ".$db_tableprefix."nesote_inoutscripts_users where joindate<=$end_time and joindate>=$beg_time order by joindate asc";
		}
		if($show=="month")
		{
			if($year=="")
			$year=date("Y",time());

			$query="select joindate from ".$db_tableprefix."nesote_inoutscripts_users order by joindate asc";

		}
		if($show=="year")
		{
			$string_year="";
			for($months=1;$months<=12;$months++)
			{ //echo $months;
				if($months<10)
				$months="0".$months;

				$sql="SELECT joindate FROM  ".$db_tableprefix."nesote_inoutscripts_users ";
				$result=@mysqli_query($conn,$sql);
				if ($result)
				{
					$string_year.="select joindate from ".$db_tableprefix."nesote_inoutscripts_users union ";
				}


			}

			$string_year=substr_replace($string_year,"",-7);
			//$string_year=substr($string_year,16);
			//echo $string_year;
			$query=$string_year." order by joindate asc";//echo $query;
		}
		if($show=="all")
		{
			$string_all="";
			for($years=2000;$years<=$y;$years++)
			{
				for($months=1;$months<=12;$months++)
				{
					if($months<10)
					$months="0".$months;

					$sql="SELECT joindate FROM  ".$db_tableprefix."nesote_inoutscripts_users ";
					$result=@mysqli_query($conn,$sql);
					if ($result)
					{
						$string_all.="select joindate from ".$db_tableprefix."nesote_inoutscripts_users union ";
					}
				}
			}

			$string_all=substr_replace($string_all,"",-7);
			$query=$string_all." order by joindate asc";
		}
		$res=mysqli_query($conn,$query);
		$res_array=array();
		//echo mysqli_num_rows($res);
		while($row=mysqli_fetch_row($res))
		{
			if($show=="month")
			{
				$tm=mktime(0,0,0,date("m",$row[0]),date("d",$row[0]),date("Y",$row[0]));
					
				if(isset($res_array[$tm]))
				$res_array[$tm]=$res_array[$tm]+1;
				else
				$res_array[$tm]=1;
			}

			if($show=="today")
			{//echo hi;
				$tm=mktime(date("H",$row[0]),0,0,date("m",$row[0]),date("d",$row[0]),date("Y",$row[0]));
				if(isset($res_array[$tm]))
				$res_array[$tm]=$res_array[$tm]+1;
				else
				$res_array[$tm]=$res_array[$tm]+1;
			}

			if($show=="year")
			{
				$tm=mktime(0,0,0,date("m",$row[0]),1,date("Y",$row[0]));
				if(isset($res_array[$tm]))
				$res_array[$tm]=$res_array[$tm]+1;
				else
				$res_array[$tm]=1;
			}

			if($show=="all")
			{
				$tm=mktime(0,0,0,1,1,date("Y",$row[0]));
				if(isset($res_array[$tm]))
				$res_array[$tm]=$res_array[$tm]+1;
				else
				$res_array[$tm]=1;
			}

		}
			
		include_once('graph/FusionCharts/Class/FusionCharts_Gen.php');

		# Create Multiseries Column3D chart object using FusionCharts PHP Class
		$FC = new FusionCharts("MSColumn3DLineDY","1000","600");

		# Set the relative path of the swf file

		$FC->setSWFPath("graph/FusionCharts/");
			
		# Store chart attributes in a variable
		//$strParam="caption=Clicks and Impressions;subcaption=Comparison;xAxisName=Duration;yAxisName=Statistics; pYAxisName=Count;sYAxisName=CTR (%);decimalPrecision=$no_of_decimalplaces;rotateNames=1; showvalues=0;";

		$strParam="caption=Sign Up;xAxisName=Duration;yAxisName=Sign Up; pYAxisName=Count;decimalPrecision=0;rotateNames=1; showvalues=0;";

		# Set chart attributes
		$FC->setChartParams($strParam);

			
		$temp_time=$beg_time;
			
		while($temp_time<=$end_time)
		{
			if($flag_time==-1)
			{//today

				$str=date("d M h a",$temp_time);
				$temp_time=mktime(date("H",$temp_time)+1,0,0,date("n",$temp_time),date("j",$temp_time),date("Y",$temp_time));
				$show_duration="$str";
					
			}
			if($flag_time==0)
			{//within month
				$str=date("M d",$temp_time);
				$temp_time=mktime(0,0,0,date("n",$temp_time),date("j",$temp_time)+1,date("Y",$temp_time));
				$show_duration="$str";
			}
			else if($flag_time==1)
			{//within year
				$str=date("M",$temp_time);
				$temp_time=mktime(0,0,0,date("n",$temp_time)+1,1,date("Y",$temp_time));
				$show_duration="$str";
			}
			else if($flag_time==2)
			{//yearwise
				$str=date("Y",$temp_time);
				$temp_time=mktime(0,0,0,date("n",$temp_time),date("j",$temp_time),date("Y",$temp_time)+1);
				$show_duration="$str";
			}

			$FC->addCategory("$show_duration");

		}

			
		$temp_time=$beg_time;
		$FC->addDataset("Sign Up","showvalues=0");

		while( $temp_time<=$end_time)
		{


			if($res_array[$temp_time] == 0 || $res_array[$temp_time] == "")
			$FC->addChartData('');

			else
			$FC->addChartData("$res_array[$temp_time]");
			//break;



			if($flag_time==0)
			{
				$temp_time=mktime(0,0,0,date("n",$temp_time),date("j",$temp_time)+1,date("Y",$temp_time));
			}
			else if($flag_time==1)
			{
				$temp_time=mktime(0,0,0,date("n",$temp_time)+1,1,date("Y",$temp_time));
			}
			else if($flag_time==2)
			{

				$temp_time=mktime(0,0,0,date("n",$temp_time),date("j",$temp_time),date("Y",$temp_time)+1);
			}
			else if($flag_time==-1)
			{
				$temp_time=mktime(date("H",$temp_time)+1,0,0,date("n",$temp_time),date("j",$temp_time),date("Y",$temp_time));
			}
		}

		$retVal[0]=$FC;

		return $retVal;



	}
};
?>
