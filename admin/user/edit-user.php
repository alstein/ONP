<?php
include_once('../../includes/SiteSetting.php');
//require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");
include_once("../../includes/classes/combo.class.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if(!isset($_POST['userid'])){
	$_SESSION['cities_name'] = array();
	$_SESSION['states_ids'] = array();
}

    #---------get mai category--------------------#
        $sql="select * from mast_deal_category where parent_id=0 order by category";
        $result = mysql_query($sql) or die('Error, query failed');
        $i = 0;
        while($row = mysql_fetch_array($result))
        {
                $tmp = array('id'=>$row['id'],
                 'category'=>$row['category']);
                $results[$i++] = $tmp;
        } 
	$smarty->assign("category",$results);
    


#------Getting User Info--------------
$sf="u.*";
$cnd="u.userid=".$_GET['userid'];
$tbl="tbl_users as u";

$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
$user=@mysql_fetch_assoc($rs);

$b_date = explode(" ",$user['birthdate']);
$birthdate = $b_date[0];
$b1_date = explode("-",$birthdate);
$smarty->assign("dd",$b1_date['2']);
$smarty->assign("mm",$b1_date['1']);
$smarty->assign("yy",$b1_date['0']);


//echo "==>".$b1_date[2]." ==> ".$b1_date[1]." ==> ".$b1_date[0];exit;
$cc=explode(",",$user['category_preferance']);
$smarty->assign("cc",$cc);
$intrested_in=explode(",",$user['intrested_in']);

if($intrested_in[0]!=""){
	//echo "==>".$intrest1=$intrested_in[0];
	$smarty->assign("intrest1",$intrest1);
}

if($intrested_in[1]!=""){
//	echo "==>".$intrest2=$intrested_in[1];
	$smarty->assign("intrest2",$intrest2);
}




$smarty->assign("birthdate",$birthdate);

$state_id=$user['state'];

$stateid11 = @explode(",", $user['mulitple_state']);
$cityid11 = @explode(",", $user['multiple_city']);
$ids = array_pop($stateid11);
//$cityid = array_pop($cityid11);
array_push($stateid11,$ids);
array_push($cityid11,$cityid);


#----Getting User Types-------------------------------
$sql_type="SELECT * FROM mast_usertype where typeid != 3";
$rs=$dbObj->customqry($sql_type,false);
while($row=@mysql_fetch_array($rs))
	$usertype[]=$row;
$smarty->assign("usertype",$usertype);
#---------END--------------------------------------


$citysql = $dbObj->cgs("mast_city","*","status","Active","","","");
   while($cityres =mysql_fetch_array($citysql))
   {
      $citylst[]=$cityres;
   }
$smarty->assign("city",$citylst);

#-------------access levels-#
$rs1=$dbObj->cgs("mast_levels","","","","","","0");
while($rows=@mysql_fetch_array($rs1))
{
	$levels[] = $rows;
}
$smarty->assign("levels",$levels);

#------end----------------#


if(isset($_POST['userid']))
{	
	extract($_POST);

	$verification = 0;
        if($membertype == 3)
            $verification = 1;

	$fullname = $first_name." ".$last_name;

	$tdate=$_POST['sel_dd']."-".$_POST['sel_mm']."-".$_POST['sel_yy'];;
	$arr=explode("-",$tdate);
	$bdate=$arr[2]."-".$arr[1]."-".$arr[0];

	$category_preferance=@implode(",",$_POST['cat_ref']);


	if($password=="" && $_FILES['photo']['name']=="")
	{
		$fl = array("first_name","last_name","fullname","email","gender","birthdate","city","rel_status","grad_college","under_grad_college","music","activities","category_preferance");
		$vl = array($first_name,$last_name,$fullname,$email,$gender,$bdate,$cityid,$rel_status,$grad_collage,$under_grad_collage,$music,$activity,$category_preferance);

	}elseif($password!="" &&  $_FILES['photo']['name']==""){ 
		$fl = array("first_name","last_name","password","fullname","email","gender","birthdate","city","rel_status","grad_college","under_grad_college","music","activities","category_preferance");
		$vl = array($first_name,$last_name,md5($password),$fullname,$email,$gender,$bdate,$cityid,$rel_status,$grad_collage,$under_grad_collage,$music,$activity,$category_preferance);
	}elseif($password=="" && $_FILES['photo']['name']!=""){ 
		$original_1 = newgeneralfileupload($_FILES["photo"], "../../uploads/user", true); 
		$fl = array("first_name","last_name","fullname","email","gender","birthdate","city","rel_status","grad_college","under_grad_college","music","activities","category_preferance","photo");
		$vl = array($first_name,$last_name,$fullname,$email,$gender,$bdate,$cityid,$rel_status,$grad_collage,$under_grad_collage,$music,$activity,$category_preferance,$original_1);
	}elseif($password!="" &&  $_FILES['photo']['name']!=""){ 
		$original_1 = newgeneralfileupload($_FILES["photo"], "../../uploads/user", true); 
		$fl = array("first_name","last_name","password","fullname","email","gender","birthdate","city","rel_status","grad_college","under_grad_college","music","activities","category_preferance","photo");
		$vl = array($first_name,$last_name,md5($password),$fullname,$email,$gender,$bdate,$cityid,$rel_status,$grad_collage,$under_grad_collage,$music,$activity,$category_preferance,$original_1);
	}


        $rs = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',$_GET['userid'],'');

	$s=$msobj->showmessage(3);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

	if($_GET['userid'] == 1){
		header("Location:".SITEROOT."/admin/user/manage_admin.php");
		exit;
	}else{
		header("Location:".SITEROOT."/admin/user/users_list.php");
		exit;
	}
}
$smarty->assign("user",$user);




if(isset($_SESSION['msg'])){
   $smarty->assign("msg",$_SESSION['msg']);
   unset($_SESSION['msg']);
}


$smarty->assign("inmenu", "user");
$smarty->display( TEMPLATEDIR . '/admin/user/user_information.tpl');
$dbObj->Close();
?>
