<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();

include_once('../includes/SiteSetting.php');
?>
<!--<script type="text/javascript" src="<?php echo SITEROOT;?>/js/selectmenu.js"></script>
<script type="text/javascript" language="JavaScript">
$(function(){
$('.select1').customStyle();
});
</script>-->
<?php 
$siteroot = SITEROOT;
//echo "hello";
// <select name="subcategory" id="subcategory"  class="select1" style="width: 178px; position: absolute; opacity: 0; font-size: 12px; height: 19px;">
$str ='<select name="subcategory" id="subcategory"  class="select1" style="width: 178px; position: absolute; opacity: 0; font-size: 12px; height: 19px;" >'."<option value=''>---Select subcategory---</option>";

// $str ='<select class="input1" name="region" id="region" style="width:50px;" onchange="javascript: getProvience(this.value,\''.$siteroot.'\');">'."<option value=''>Select Region</option>";

/***************Fetch state list***********************/
		
	 $stid = $_GET['cnid'];
	 $sql="select * from mast_deal_category where parent_id='$stid' AND active=1 order by category";
         $result = mysql_query($sql) or die('Error, query failed');
      	 //$rs = $dbObj->cgs("mast_state","*","country_id",$_GET['cnid'],"state_name","","");
	 while($row = @mysql_fetch_assoc($result))
	 {
		$st[] = $row;
	 }
	 if($st != "")
         {
           for($i=0;$i<count($st);$i++)
           {   
              $str = $str."<option value='".$st[$i]['id']."'>".$st[$i]['category']."</option>";
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
