<?php
include_once('../includes/SiteSetting.php');

$siteroot = SITEROOT;
//echo "hello";
$str ='<select class="selectbox" name="states" id="states"  style="width:210px;"  >'."<option value=''>Select County/State</option>";

// $str ='<select class="input1" name="region" id="region" style="width:50px;" onchange="javascript: getProvience(this.value,\''.$siteroot.'\');">'."<option value=''>Select Region</option>";

/***************Fetch state list***********************/
	$stid	= $_GET['stid'];
	//$rs = $dbObj->cgs("mast_state","*","country_id",$_GET['cnid'],"state_name","","");
   $rs = $dbObj->cgs("mast_state","*",array("country_id","active"),array($_GET['cnid'],1),"state_name","","");
	while($row = @mysql_fetch_assoc($rs))
	{
		$st[] = $row;
	}
	if($st != "")
       {
           for($i=0;$i<count($st);$i++)
           {   
              $str = $str."<option value='".$st[$i]['id']."' >".$st[$i]['state_name']."</option>";
			  //{if $st[$i]['id'] eq $stid} selected="selected"{/if}
           }
         $str = $str.'</select> &nbsp;';
		
		 $St =  $str;
		 echo $St;
		   
       } 	   
       else
       {
//         $str = $str."<option value=''>Select state</option>";
        $str = $str.'</select>';
		echo $str;
       } 
		
//====================================================//*/
?>