<?php

class Functions extends DBTransact{

	function resizeMarkup($markup, $dimensions){
	$w = $dimensions['width'];
	$h = $dimensions['height'];

	$patterns = array();
	$replacements = array();

	if( !empty($w) ){
		$patterns[] = '/width="([0-9]+)"/';
		$patterns[] = '/width:([0-9]+)/';
	
		$replacements[] = 'width="'.$w.'"';
		$replacements[] = 'width:'.$w;
	}

	if( !empty($h) ){
		$patterns[] = '/height="([0-9]+)"/';
		$patterns[] = '/height:([0-9]+)/';
	
		$replacements[] = 'height="'.$h.'"';
		$replacements[] = 'height:'.$h;
	}
	
	return preg_replace($patterns, $replacements, $markup);
}
	
	function GetUsrImage($usrid, $width, $height, $prn){

		$sql = "select thumbnail,usrname from app_users where usrid = ".$usrid;
		if($prn==1)
			echo $sql;			
		$rs = @mysql_query($sql);
		$num = @mysql_num_rows($rs);
		$r = @mysql_fetch_array($rs);
		if($r[0])
			$simage = $r[0];
		else
		{
			if($_SESSION['gender']=='m')
				$simage = "man.gif";
			else
				$simage = "man.gif";
		}
	 	if($r[0]=="")
			$image = "<img src='".SITEROOT."user_images/".$simage."' alt='".$r['usrname']."' align=\"top\"  border=\"0\" height='".$height."' width='".$width."'>";
		else
	   		$image = "<img src='".SITEROOT."user_images/".$simage."' alt='".$r['usrname']."' align=\"top\"  border=\"0\" height='".$height."' width='".$width."'>";
		return $image;
	}

	function GUsrN($uid, $prn="")
	{
		$sql = "select first_name, last_name from tbl_users where userid = ".$uid."";
		if($prn)
			echo $sql;
		$res = @mysql_query($sql);
		$num = @mysql_num_rows($res);
		$req = @mysql_fetch_array($res);
		if($num>0)
			$res = $req['first_name']." ".$req['last_name'];
		else
			$res = "";
		return $res;
	}
	
	//FUNCTION FOR VIDEO AND MUSIC CATEGORY-----------------	
	function category($tbl){
		$sql = "select * From $tbl";
		$res = @mysql_query($sql);
		$num = @mysql_num_rows($res);
		while($cat = @mysql_fetch_assoc($res))
		{
			$cat_vid[] = $cat ;
		}
		return $cat_vid;
	}

	//FUNCTION FOR DISPLAY STAR-----------------	


	function star_rate($c){
		//echo $c;
		$str =array();
		for ($i=0;$i<5;$i++) 
		{ 
			if($c <= $i)
			{
				$str[$i] = "rating3.png";
			}
			else
			{
				$str[$i] = "rating.png";
			}
	
		}
		return $str;
	}

	function TimeAgo($datefrom,$dateto=-1){
		// Defaults and assume if 0 is passed in that
		// its an error rather than the epoch
		
		if($datefrom<=0) { return "A long time ago"; }
		if($dateto==-1) { $dateto = time(); }
		
		// Calculate the difference in seconds betweeen
		// the two timestamps
		
		$difference = $dateto - $datefrom;
		
		// If difference is less than 60 seconds,
		// seconds is a good interval of choice
		
		if($difference < 60)
		{
		$interval = "s";
		}
		
		// If difference is between 60 seconds and
		// 60 minutes, minutes is a good interval
		elseif($difference >= 60 && $difference<60*60)
		{
		$interval = "n";
		}
		
		// If difference is between 1 hour and 24 hours
		// hours is a good interval
		elseif($difference >= 60*60 && $difference<60*60*24)
		{
		$interval = "h";
		}
		
		// If difference is between 1 day and 7 days
		// days is a good interval
		elseif($difference >= 60*60*24 && $difference<60*60*24*7)
		{
		$interval = "d";
		}
		
		// If difference is between 1 week and 30 days
		// weeks is a good interval
		elseif($difference >= 60*60*24*7 && $difference <
		60*60*24*30)
		{
		$interval = "ww";
		}
		
		// If difference is between 30 days and 365 days
		// months is a good interval, again, the same thing
		// applies, if the 29th February happens to exist
		// between your 2 dates, the function will return
		// the 'incorrect' value for a day
		elseif($difference >= 60*60*24*30 && $difference <
		60*60*24*365)
		{
		$interval = "m";
		}
		
		// If difference is greater than or equal to 365
		// days, return year. This will be incorrect if
		// for example, you call the function on the 28th April
		// 2008 passing in 29th April 2007. It will return
		// 1 year ago when in actual fact (yawn!) not quite
		// a year has gone by
		elseif($difference >= 60*60*24*365)
		{
		$interval = "y";
		}
		
		// Based on the interval, determine the
		// number of units between the two dates
		// From this point on, you would be hard
		// pushed telling the difference between
		// this function and DateDiff. If the $datediff
		// returned is 1, be sure to return the singular
		// of the unit, e.g. 'day' rather 'days'
		
		switch($interval)
		{
		case "m":
		$months_difference = floor($difference / 60 / 60 / 24 /
		29);
		while (mktime(date("H", $datefrom), date("i", $datefrom),
		date("s", $datefrom), date("n", $datefrom)+($months_difference),
		date("j", $dateto), date("Y", $datefrom)) < $dateto)
		{
		$months_difference++;
		}
		$datediff = $months_difference;
		
		// We need this in here because it is possible
		// to have an 'm' interval and a months
		// difference of 12 because we are using 29 days
		// in a month
		
		if($datediff==12)
		{
		$datediff--;
		}
		
		$res = ($datediff==1) ? "$datediff month ago" : "$datediff
		months ago";
		break;
		
		case "y":
		$datediff = floor($difference / 60 / 60 / 24 / 365);
		$res = ($datediff==1) ? "$datediff year ago" : "$datediff
		years ago";
		break;
		
		case "d":
		$datediff = floor($difference / 60 / 60 / 24);
		$res = ($datediff==1) ? "$datediff day ago" : "$datediff
		days ago";
		break;
		
		case "ww":
		$datediff = floor($difference / 60 / 60 / 24 / 7);
		$res = ($datediff==1) ? "$datediff week ago" : "$datediff
		weeks ago";
		break;
		
		case "h":
		$datediff = floor($difference / 60 / 60);
		$res = ($datediff==1) ? "$datediff hour ago" : "$datediff
		hours ago";
		break;
		
		case "n":
		$datediff = floor($difference / 60);
		$res = ($datediff==1) ? "$datediff minute ago" :
		"$datediff minutes ago";
		break;
		
		case "s":
		$datediff = $difference;
		$res = ($datediff==1) ? "$datediff second ago" :
		"$datediff seconds ago";
		break;
		}
		return $res;
	}
	//FUNCTION FOR DISPLAY COMMENTS ON VIDEO OR MUSIC -----------------		
	
	function getCountry($con_id){
		$sql = "select country from mast_country where countryid = ".$con_id."";
		if($prn)
			echo $sql;
		$res = @mysql_query($sql);
		$num = @mysql_num_rows($res);
		$req = @mysql_fetch_array($res);
		if($num>0)
			$res = $req['country'];
		else
			$res = "";
			
		return $res;
		
	}

	function time(){
		return  mktime(date("H",time())+9,date("i",time()),date("s",time()),date("m",time()),date("d",time()),date("Y",time()));
	}
	/************************************************************************/
function getunfiddenhours($feedtime)
		{
     		$datetime	= explode(" ",$feedtime);
		    $date		= explode("-",$datetime[0]);
		    $time		= explode(":",$datetime[1]); 
			$dd			= $date[2];
			$mm			= $date[1];
			$yy			= $date[0];
			$h			= $time[0];
			$m			= $time[1];
			$s			= $time[2];
		    $diff		= round((time()-@mktime($h,$m,$s,$mm,$dd,$yy))/60);
			$result		= "".$diff." Min Ago";  
     		if($diff > 60)
     		{
          		$diff		=round($diff/60);
          		$result		= "".$diff." Hrs Ago";
          		if($diff > 24)
          		{
           			$diff	= round($diff/24);
           			$result = "".$diff." Days Ago";
          		}
     		}
    		return($result);  
 		}  


	/************************************************************************/
	//Created by Rakhi Sikchi on 14-04-09
	//This function is used to get the info of the particuar field from the dtabase
	//input fields $table_name,$wantedfield,$wherefield,$fieldValu
	//return the wanted value of that field
	/************************************************************************/	
	function getInfo($table_name='',$wantedfield='',$wherefield='',$fieldValue='')
	{
		$user = $this->cgs($table_name,$wantedfield,$wherefield, $fieldValue, "", "", false);
		if($user != 'n')
		{
			$rowsuse = mysql_fetch_array($user);
	  		$value = ucfirst($rowsuse[$wantedfield]);
			if($rowsuse[$wantedfield] == "")
			{  $value = "NA"; }
		}
		else
		{ $value = "----" ;}
		return $value;
	}
	function showPaging($class='LINK-PAGEING'){
			global $PAGE_TOTAL_ROWS;
			global $PAGE_LIMIT;
			global $PAGE_URL;
			global $DISPLAY_PAGES;
			
			$numofpages = ceil($PAGE_TOTAL_ROWS / $PAGE_LIMIT);
			$pages = ((empty($_GET['pages']))?1:$_GET['pages']);
			$page = ((empty($_GET['page']))?1:$_GET['page']);
			$filename = $PAGE_URL;
			
			$displayPages = (($DISPLAY_PAGES < 1)?15:$DISPLAY_PAGES);
			
			if(strlen(trim($filename)) > 0){			
				$file = split("-",$filename);
				if(sizeof($file) == 1){
					$_file = $file[0]."?";
				}else{
					for($m=1;$m<sizeof($file);$m++)	{	$fn.= $file[$m]."&";	}
					$_file = $file[0]."?".$fn;
				}
			}
	
			if($numofpages > 1){
				//$working_data.="<li><a href=".$_file."pages=1 class='$class' \"> FIRST </a></li>";
			}
			if($pages > 1){
				$pageprev = ($pages-$displayPages);
				$working_data.="<li><a href=".$_file."pages=1 class='$class' \"> FIRST </a></li>";
				$working_data.="<li><a href=".$_file."pages=".$pageprev." class='$class' \"> PREV </a>&nbsp;-&nbsp;</li>";
			}
			if($numofpages > 1){
				for($i = $pages; $i < $pages + $displayPages; $i++){
					if($i <= $numofpages){
						$selectedPage = (($page == $i)?"active":"");
						$working_data.="<li><a href=".$_file."pages=".$pages."&page=".$i." class='$selectedPage'\">".$i."</a></li>";
					}
				}
			}
			//	next page coading
			if($pages + $displayPages <= $numofpages){
				$pagenext = ($pages + $displayPages);
				$working_data.="<li>&nbsp;-&nbsp;<a href=".$_file."pages=".$pagenext." class='$class'\"> NEXT </a></li>";
				$working_data.="<li><a href=".$_file."pages=".$numofpages." class='$class'\"> LAST </a></li>";
			}
			if($numofpages > 1){
				//$working_data.="<li><a href=".$_file."pages=".$numofpages." class='$class'\"> LAST </a></li>";
			}
			
			return ((empty($working_data))?0:$working_data);
	
		}

}
?>