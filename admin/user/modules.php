<?php
include_once('../../include.php');
// include_once('../../includes/common.lib.php');
// include_once('../../includes/class.message.php');
//$msobj= new message();

//Chek for admin login
// if(!$_SESSION['duAdmId'])
// {
// 	header("location:".SITEROOT . "/admin/login/index.php");
//         exit;
// }

if($_POST['Submit'])
{

	if($_POST['level'] == "all" || $_POST['level'] == "")
	{
		//$s=$msobj->showmessage(79);
		$_SESSION['msg']="<span class='error'>Please select level</span>";
		header("Location:" .$_SERVER['REQUEST_URI']);
		exit;
	}
	if(count($_POST['m_id']) < 1)
	{
		//$s=$msobj->showmessage(79);
		$_SESSION['msg']="<span class='error'>Please select at least one access level</span>";
		header("Location:" .$_SERVER['REQUEST_URI']);
		exit;
	}
	if($_POST['m_id']!= "")
	{
	     
	      $permit_module = implode(",",$_POST['m_id']);
	      //$filed=array("name","modules");
	      //$value=array($_POST['level'],$permit_module);

             if($_GET['act'] == 'add')
              {
		$filed=array("name","modules");
		$value=array($_POST['level'],$permit_module);
	       $dbres = $dbObj->cgi('mast_levels',$filed,$value,"","");
	       // $dbres = $dbObj->cgi('mast_levels',"modules" ,$set_values,"","");exit;
	         $_SESSION['msg']="<span class='success'>Level added successfully</span>";
              }
              if($_GET['level'])
              {

		$filed=array("modules");
		$value=array($permit_module);
             // print_r($value);
             // exit;
             // $set_field ,$set_values,
	         $dbres = $dbObj->cupdt('mast_levels',$filed ,$value,"levelid","{$_GET['level']}","");
	         $_SESSION['msg']="<span class='success'>Level updated successfully</span>";
              }
	      header("Location:" . SITEROOT."/admin/user/manage_admin.php");
	      exit;
        }

 }


if($_GET['level'])
{
    $m_id = $dbObj->gj("mast_levels","modules","levelid='{$_GET['level']}'","","","","","");
    if($m_id !='n')
    {
	$module_info1 = mysql_fetch_assoc($m_id);
 	$smarty->assign("level1", @explode(",",$module_info1['modules']));
    }
    else
 	$smarty->assign("level1", array($tmp));
}
else
    $smarty->assign("level1", array($tmp));

#----------Get access level------------#
$m_id = $dbObj->gj("mast_levels","*","1","","","","","");
if($m_id !='n')
{
    while($modules = mysql_fetch_assoc($m_id))
	    $module_info[] =  $modules;
    $smarty->assign("level", $module_info);
}
#----------Get all Modules------------#


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
	    if($modules['id'] == 1)
	    {
		$sub_m = $dbObj->gj("mast_modules","id,module_name","parent_id ='{$modules['id']}' and id IN (2,3,9,10,38,16,47,50,51)","","","","","");
	    }else
	    {
		$sub_m = $dbObj->gj("mast_modules","id,module_name","parent_id ='{$modules['id']}'","","","","","");
            }
	    //$sub_m = $dbObj->gj("mast_modules","id,module_name","parent_id ='{$modules['id']}'","","","","","");
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

if($_SESSION['msg']!="")
{
$smarty->assign("msg",$_SESSION['msg']);
unset($_SESSION['msg']);
}

$smarty->assign("inmenu", "adminmanage");
if($_GET['act'] == 'add')
    $smarty->display(TEMPLATEDIR . '/admin/user/add-level.tpl');
else
    $smarty->display(TEMPLATEDIR . '/admin/user/modules.tpl');

$dbObj->Close();
?>
