<?
/**
* Project:     Tonto
* File:        class.calender.php
*
* @author Vasudha Gele <g dot vasudha at agiletechnosys dot com>
* @package Smarty
* @version 2.6.19
*/
include_once("../../includes/SiteSetting.php");
include_once('../../includes/classes/class.statecountry.php');

Class calender extends DBTransact
{
	
	function checkit($newdate,$timeing,$aa)
	{
		
		$rs = $this->customqry("select * from tbl_calender where user_id = ".$_SESSION['csUserId'],"");
		$i=0;
		while($rs1 = @mysql_fetch_assoc($rs))
		{	
			$row[$i] = $rs1;
			$i++;
		}	
		$count='0';
		if($row != '')
		{
			
		foreach($row as $value)
		{
			if($value['status']=="C" and $value['time'] == $timeing and $value['date'] == $newdate)
			{
			$count=1;
			?>

			<link href="<?php echo SITEROOT; ?>/templates/default/css/lightbox.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/lightbox.js"></script>	

			<div style="background:#63BF00 none repeat scroll 0 0; color:#000; font-size:13px;">
				<a href="javascript: void(0);" onclick="javascript:tb_show('Cancel confirm booking','<?php echo SITEROOT; ?>/modules/supplier/confirm.php?id=<?php echo $value['id']; ?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=350&width=550&modal=false', tb_pathToImage);">
					confirmed
				</a>
			</div>
			<?
			}
			else if($value['status']=="R" and $value['time'] == $timeing and $value['date'] == $newdate)
			{
			$count=1;
			?>
			
			<link href="<?php echo SITEROOT; ?>/templates/default/css/lightbox.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/lightbox.js"></script>	
			
			<div style="background:#CA0000 none repeat scroll 0 0; color:#fff; font-size:13px;">
				<a href="javascript: void(0);" onclick="javascript:tb_show('Requested','<?php echo SITEROOT; ?>/modules/supplier/request.php?id=<?php echo $value['id']; ?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=350&width=550&modal=false', tb_pathToImage);">
					Requested
				</a>
			</div>
			<?
			}
			else if($value['status']=="A" and $value['time'] == $timeing and $value['date'] == $newdate)
			{
			$count=1;	
			
			?>		
			<div class="blue">
				 <a href="javascript:void(0);" onclick="javascript:avail('<?php echo $value['id'];?>','<?php echo $newdate; ?>','<?php echo $timeing; ?>','<?php echo $aa; ?>');"> 
					Available
				</a>
			</div>
			<?
			}
		}
		}		
		if($count != '1')
		{
			?>
			<link href="<?php echo SITEROOT; ?>/templates/default/css/lightbox.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript" src="<?php echo SITEROOT; ?>/js/lightbox.js"></script>	
			
			
				<a href="javascript: void(0);" onclick="javascript:tb_show('Select service','<?php echo SITEROOT; ?>/modules/supplier/available.php?id=<?php echo $value['id']; ?>&date=<?php echo $newdate; ?>&time=<?php echo $timeing; ?>&divid=<?php echo $aa; ?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=480&modal=false', tb_pathToImage);">
					<span style="color:#fff;">Unavailable</span>
				</a>
			
			<!--<a href="{$siteroot}/supplier/calender/?id1={$smarty.session.csUserId}&amp;day={$previousvalue.0}&amp;month={$previousvalue.1}&amp;year={$previousvalue.2}&amp;today={$today}&amp;dayname=Sun" class="arlf">&nbsp;</a>-->
			<?
		}
	}

	function checkpublic($newdate,$timeing,$aa,$userid)
	{
	
		
		$rs = $this->customqry("select * from tbl_calender where user_id = ".$userid,"");
		$i=0;
		while($rs1 = @mysql_fetch_assoc($rs))
		{	
			$row[$i] = $rs1;
			$i++;
		}		
		$count='0';
		if($row != '')
		{			
		foreach($row as $value)

		   {
			
			if($value['status']=="C" and $value['time'] == $timeing and $value['date'] == $newdate)
			{				
				$count=1;
				?>
				
					<p class="confirmed">Confirmed</p>
				
				<?
			}
			else if($value['status']=="R" and $value['time'] == $timeing and $value['date'] == $newdate)
			{
				$count=1;
				?>				
					<p class="orgclr" style="line-height:28px;">
						<img src="<?php echo SITEROOT; ?>/templates/default/images/quemark.png" alt="image1" /><br/>Requested
					</p>				
				<?
			}
			else if($value['status']=="A" and $value['time'] == $timeing and $value['date'] == $newdate)
			{
				
				$count=1;

				$tbl = "service as s,tbl_calender as c";
					$sf = "s.*"; 
					$cnd = "s.id ='".$value['serviceid']."' and c.user_id =".$userid;
					$res = $this->gj($tbl,$sf,$cnd,"","","DESC",1, "");
		
					$user=@mysql_fetch_assoc($res);
					$servicedtl=	$user["service_details"];
					$service_experience=$user["service_experience"];
					$address=$user["address"]; 
					//echo $value['serviceid']."".$value['time']
					$statecounty = new StateCountry();
					//get country
					$countryval = $statecounty->getCountry($user["countryid"]);
					$country=$countryval['country'];
					//get state
					$stateval = $statecounty->getState($user["stateid"]);
					$state=$stateval['state_name'];
					//get city
					$cityval = $statecounty->getCity($user["cityid"]);
					$city_name=$cityval['city_name'];

	
				?>
			
				
			
			<!-- codition which check user is login or not  -->
				<?php
				if($_SESSION['csUserId'])
				{
					
				?>
					<a href="javascript: void(0);" onclick="javascript:tb_show('Buyer request','<?php echo SITEROOT; ?>/modules/supplier/buyer_request.php?sid=<?php echo $value['serviceid']; ?>&id=<?php echo $value['id']; ?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=350&width=550&modal=false', tb_pathToImage);">
						<img src="<?php echo SITEROOT; ?>/templates/default/images/bookit.png" alt="image"  onmouseover="balloon.showTooltip(event,'<?php echo "<b>"."Service Details: "."</b>"."<br>".$servicedtl."<br><b>"."Service Information: "."</b><br>".$service_experience."<br><b>". "Address:"."</b><br>".$address.",<br><b>Country:</b>".$country.",<br><b> State:</b>".$state.",<br> <b>City:</b>".$city_name; ?>' )"/>
					</a>
				<?php
				}
				else
				{
				?> 
					<a href="<?php echo SITEROOT;?>/login/">
						<img src="<?php echo SITEROOT; ?>/templates/default/images/bookit.png" alt="image" onmouseover="balloon.showTooltip(event,'<?php echo "<b>"."Service Details: "."</b>"."<br>".$servicedtl."<br><b>"."Service Information: "."</b><br>".$service_experience."<br><b>". "Address:"."</b><br>".$address.",<br><b>Country:</b>".$country.",<br><b> State:</b>".$state.",<br> <b>City:</b>".$city_name; ?>' )"/> 
					 </a> 
				<?php
				}
				?>
				<!--END codition which check user is login or not  -->
			<?
			}
		    }
		}		
		if($count != '1')
		{
			?>
				 <p>X</p>				 
			<?
		}
	}

	function dashBoardCal($newdate,$timeing,$aa)
	{ 
		//echo $aa;
		$rs = $this->customqry("select * from tbl_calender where user_id = ".$_SESSION['csUserId'],"");
		$i=0;
		while($rs1 = @mysql_fetch_assoc($rs))
		{	
			$row[$i] = $rs1;
			$i++;
		}			
		$count='0';
		if($row != '')
		{			
		foreach($row as $value)
		{
			if($value['status']=="C" and $value['time'] == $timeing and $value['date'] == $newdate)
			{
			$count=1;
			?>				

			<div class="green">
				Confirmed
			</div>
			<?
			}
			else if($value['status']=="R" and $value['time'] == $timeing and $value['date'] == $newdate)
			{
			$count=1;
			?>
			
			<div class="red">
				Requested
			</div>
			<?
			}
			else if($value['status']=="A" and $value['time'] == $timeing and $value['date'] == $newdate)
			{
			$count=1;
			?>
			<div class="blue">
				Available</div>
			<?
			}
		}
		}		
 		if($count != '1')
		{
			?>		
				Unavailable			
			<a href="{$siteroot}/supplier/calender/?id1={$smarty.session.csUserId}&amp;day={$previousvalue.0}&amp;month={$previousvalue.1}&amp;year={$previousvalue.2}&amp;today={$today}&amp;dayname=Sun" class="arlf">&nbsp;</a>
			<?
		}
	}
	function getWeekDayDate()
	{		
		if($_GET['dayname'] ='Sun' && $_GET['dayname'] != 'Mon')
		{
			$startdate = $_GET['day'] - 6;
			$enddate = $_GET['day'];			
		}
		elseif($_GET['dayname'] ='Mon' && $_GET['dayname'] != 'Sun')
		{
			$startdate = $_GET['day'];
			$enddate = $_GET['day'] + 6;
		}

		//coding for display week color

		if($_GET['day'] == '')
		{
			$daytoday = date('D');
			$todaydate = date('d');
			$todaymonth = date('m');
			$todayYear = date('Y');
			if($daytoday == 'Mon')
			{
				$startdate = $todaydate;
				$enddate = $todaydate + 6;
			}
			if($daytoday == 'Tue')
			{
				$startdate = $todaydate - 1;
				$enddate = $todaydate + 5;
			}
			if($daytoday == 'Wed')
			{
				$startdate = $todaydate - 2 ;
				$enddate = $todaydate + 4;
			}
			if($daytoday == 'Thu')
			{
				$startdate = $todaydate - 3;
				$enddate = $todaydate + 3;
			}
			if($daytoday == 'Fri')
			{
				$startdate = $todaydate - 4;
				$enddate = $todaydate + 2;
			}
			if($daytoday == 'Sat')
			{
				$startdate = $todaydate - 5;
				$enddate = $todaydate + 1;
			}
			if($daytoday == 'Sun')
			{
				$startdate = $todaydate - 6;
				$enddate = $todaydate;
			}
		}


		$final_days = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
		
		//calculate day in this month

		if($_GET['month'])
		{
			$monthday = cal_days_in_month(CAL_GREGORIAN,$_GET['month'],$_GET['year']);
		}
		//if start date is -ve condition
		if(($startdate<0)&&($_GET['month']))
		{
			//calculate day in preveous month
			$totdaysinmonth = cal_days_in_month(CAL_GREGORIAN,$_GET['month']-1,$_GET['year']);
			//day diffrence
			$tempstartdate  = $totdaysinmonth - abs($startdate);
		
			//array for previous days
			for($y=$tempstartdate;$y<=$totdaysinmonth;$y++)
			{
				$date_db[] = $y;
			}
			//array for next days
			for($u=1;$u<=abs($enddate);$u++)
			{
				$rdate_db[] = $u;
			}
			$final_date = array_merge($date_db,$rdate_db);
			
			$final_array = array_combine($final_days,$final_date);
			
		}
		//end -ve condition
		//if  days are grater then month day
		elseif(($monthday<$enddate)&&($_GET['month']))
		{	
			//calculate day in this month
			$totdaysinmonth = cal_days_in_month(CAL_GREGORIAN,$_GET['month'],$_GET['year']);
						
			//calculate day in next month
			if($_GET['month'] == '12')
			{
				$totdaysinnextmonth = cal_days_in_month(CAL_GREGORIAN,'01',$_GET['year']+1);
			}
			else
			{
				$totdaysinnextmonth = cal_days_in_month(CAL_GREGORIAN,$_GET['month']+1,$_GET['year']);
			}
			
			//day diffrence
			$next_db= $enddate-$totdaysinmonth;
			
			//array for this days
			for($k=$startdate;$k<=$totdaysinmonth;$k++)
			{
				$pdate_db[] = $k;
			}
			//array for next days
			for($u=1;$u<=abs($next_db);$u++)
			{
				$ndate_db[] = $u;
			}
			$final_date = array_merge($pdate_db,$ndate_db);
			$final_array = array_combine($final_days,$final_date);
			
		}
		else
		{
			//normal condition
			for($l=$startdate;$l<=$enddate;$l++)
			{				
				$nowdays_db[] = $l;				
			}			
			$final_array = array_combine($final_days,$nowdays_db);
		}
		
		return $final_array;
		//end if  days are grater then month day
	}

}
?>