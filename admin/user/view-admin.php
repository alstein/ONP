<?php
include_once('../../includes/SiteSetting.php');

if(!$_SESSION['duAdmId'])
	header("location:". SITEROOT . "/admin/login/index.php");


#----------Get Admin information-------------#
$tbl1 = "tbl_users";
$cd="userid = ".$_GET['userid'];

$rs_user = $dbObj->gj($tbl1, $sf , $cd, "", "", "", "","");
if($rs_user !='n')
{
      $row = @mysql_fetch_assoc($rs_user);

      #------------Get last login-----------#
      $tmp= $dbObj->gj("tbl_login_log","login_date as last_login,ipaddress","userid='{$_GET['userid']}'","id","","DESC","0,1","");
      if($tmp !='n')
      { 
	  $login=mysql_fetch_assoc($tmp);
          $row['last_login'] =$login['last_login'];
          $row['ipaddress'] = $login['ipaddress'];
      }
      #------------End last login-----------#

      $smarty->assign("user",$row);
}

//get access level
$m_id = $dbObj->gj("mast_levels","modules","levelid='{$row['access_level']}'","","","","","");
if($m_id !='n')
{
    $module_info1 = mysql_fetch_assoc($m_id);
    $smarty->assign("level1", @explode(",",$module_info1['modules']));
}
else
    $smarty->assign("level1", array($tmp));
#----------Get admin information-------------#


#----------Get all Modules------------#
$m_id = $dbObj->gj("mast_modules","id,module_name","parent_id=0 and status = 'Active'","","","","","");
if($m_id !='n')
{
    $module_info="";
    $i=0;
    while($modules = mysql_fetch_assoc($m_id))
    {
	    $module_info[$i] =  $modules;

            //Get sub modules
	    $sub_m = $dbObj->gj("mast_modules","id,module_name","parent_id ='{$modules['id']}'","","","","","");
	    if($sub_m !='n')
	    {
                $j=0;
		while($tmp_m = mysql_fetch_assoc($sub_m))
                {
		      $module_info[$i]['sub_m'][$j] = $tmp_m;
                      $j++;
                }
	    }
	    $i++;
    }
    $smarty->assign("modules", $module_info);
}
#----------Get all Modules------------#


$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/user/view-admin.tpl');

$dbObj->Close();
?>