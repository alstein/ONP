<?php
include_once('../../includes/SiteSetting.php');
require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if(!isset($_POST['userid'])){
	$_SESSION['cities_name'] = array();
	$_SESSION['states_ids'] = array();
}

#------Getting User Info--------------
$sf="u.*";
$cnd="u.userid=".$_GET['userid'];
$tbl="tbl_users as u";

$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
$user=@mysql_fetch_assoc($rs);

$state_id=$user['state'];

$stateid11 = @explode(",", $user['mulitple_state']);
$cityid11 = @explode(",", $user['multiple_city']);
$ids = array_pop($stateid11);
$cityid = array_pop($cityid11);
array_push($stateid11,$ids);
array_push($cityid11,$cityid);



//print_r($stateid); count($stateid); //exit;
if(!isset($_POST['userid'])){	
  $assign_city = "";
  $assign_city .= "<ul>";
  for($i=0; $i<count($stateid11); $i++){
          $assign_city .= "<li id='add_city_$i'><div style='width:500px;'><span style='width:200px;float:left;' id='name_city_$i'>".$cityid11[$i]."</span><span style='width:300px;float:left;'><a href='javascript:void(0);' onclick='javascript:removecity($i)'>Remove</a></span>
          <input type='hidden' id='id_state_$i' value=".$stateid11[$i]."
          </li>";
          $_SESSION['cities_name'][$i] = $cityid11[$i];
          $_SESSION['states_ids'][$i] = $stateid11[$i];
  }
  $assign_city .= "</ul>";
  $smarty->assign("assign_city",$assign_city);
}
$smarty->assign("user",$user);
$smarty->assign("stateid",$ids);
$smarty->assign("cityid",$cityid);
#----------END0----------------


if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}


#----Getting User Types-------------------------------
//$rs=$dbObj->cgs("mast_usertype","","","","","","");
$sql_type="SELECT * FROM mast_usertype where typeid!=3";
$rs=$dbObj->customqry($sql_type,false);
while($row=@mysql_fetch_array($rs))
	$usertype[]=$row;
$smarty->assign("usertype",$usertype);
#---------END--------------------------------------

$re1 = $dbObj->cgs("mast_state","id,state_name",array("country_id","active"),array('223',1),"state_name","","");
$i=0;
$city = array();
$state = array();
  while($row2 = @mysql_fetch_assoc($re1)){
          $state[$i]['state_name'] = $row2['state_name'];
          $state[$i]['id'] = $row2['id'];
          $i++;
  }
$smarty->assign("state",$state);

// Get US cities	
$re = $dbObj->cgs("mast_city","city_id,city_name",array("state_id","con_id","active"), array($state_id,'223',1),"","","");
$i=0;
$city = array();
while($row1 = @mysql_fetch_assoc($re)){
        $city[$i]['city_name'] = $row1['city_name'];
        $city[$i]['city_id'] = $row1['city_id'];
        $i++;
}
$smarty->assign("city",$city);

if(isset($_POST['userid'])){
  extract($_POST);
  if($_FILES['photo']['name'] || $password!=''){
    $rs = $dbObj->cgs('tbl_users','','userid',$_GET['userid'],'','','');
    $row = mysql_fetch_assoc($rs);

      if($password!=''){
        $fl = array("first_name","last_name",'username','password','email','usertypeid','address','countryid','city', 'state','zipcode','status','tot_gift_card_bought','tot_gift_card_spent','cc_info');
        $vl =  array($first_name,$last_name,$username,md5($password),$email,$usertypeid,$address,$countryid,$city, $state,$zipcode,$status,$tot_gift_card_bought,$tot_gift_card_spent,$cc_info);
              /*if(sizeof($_SESSION['states_ids'])>0){
                      $arr_city = "";
                      $arr_states = "";
                      $del = "";
                      $sep = "";
                      for($i=0;$i<count($_SESSION['states_ids']);$i++){
                              $arr_city .= $del.$sep.$_SESSION['cities_name'][$i];
                              $sep = ",";
                              $arr_states .= $del1.$sep1.$_SESSION['states_ids'][$i];
                              $sep1 = ",";
                      }
                      array_push($fl,"mulitple_state","multiple_city");
                      array_push($vl,$arr_states,$arr_city);
              }*/
          $rs = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',$_GET['userid'],'');
      }else{
            //$fl = array("first_name","last_name",'username','email','usertypeid');
            //$vl = array($first_name,$last_name,$username,$email,$usertypeid);
            $fl = array("first_name","last_name",'username','email','usertypeid','address','countryid','city', 'state','zipcode','status','tot_gift_card_bought','tot_gift_card_spent','cc_info');
            $vl =  array($first_name,$last_name,$username,$email,$usertypeid,$address,$countryid,$city, $state,$zipcode,$status,$tot_gift_card_bought,$tot_gift_card_spent,$cc_info);

            /*if(sizeof($_SESSION['states_ids'])>0)
            {
                    $arr_city = "";
                    $arr_states = "";
                    $del = "";
                    $sep = "";
                    for($i=0;$i<count($_SESSION['states_ids']);$i++)
                    {
                            $arr_city .= $del.$sep.$_SESSION['cities_name'][$i];
                            $sep = ",";
                            $arr_states .= $del1.$sep1.$_SESSION['states_ids'][$i];
                            $sep1 = ",";
                    }
                    array_push($fl,"mulitple_state","multiple_city");
                    array_push($vl,$arr_states,$arr_city);
            }*/
            $rs = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',$_GET['userid'],'');
          }
  }else{
      //$fl = array('first_name','last_name','username','email','usertypeid');
      //$vl = array($first_name,$last_name,$username,$email,$usertypeid,$site_updates,$newsletter,'yes');
        $fl = array("first_name","last_name",'username','email','usertypeid','address','countryid','city', 'state','zipcode','status','tot_gift_card_bought','tot_gift_card_spent','cc_info');
        $vl =  array($first_name,$last_name,$username,$email,$usertypeid,$address,$countryid,$city, $state,$zipcode,$status,$tot_gift_card_bought,$tot_gift_card_spent,$cc_info);
     /* if(sizeof($_SESSION['states_ids'])>0){
              $arr_city = "";
              $arr_states = "";
              $del = "";
              $sep = "";
              for($i=0;$i<count($_SESSION['states_ids']);$i++)
              {
                      $arr_city .= $del.$sep.$_SESSION['cities_name'][$i];
                      $sep = ",";
                      $arr_states .= $del1.$sep1.$_SESSION['states_ids'][$i];
                      $sep1 = ",";
              }
              array_push($fl,"mulitple_state","multiple_city");
              array_push($vl,$arr_states,$arr_city);
      }*/
      $rs = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',$_GET['userid'],'');
  }
  /*$temp = $dbObj->customqry("delete from tbl_newsletter_subscriber where userid  in (".$_GET['userid'].")","");
  $temp1 = $dbObj->customqry("delete from tbl_siteupdates_subscriber where userid  in (".$_GET['userid'].")","");
  if($newsletter != ''){
    $dbObj->cgi("tbl_newsletter_subscriber",array("userid","emailid","status"),array($_GET['userid'],$email,"Active"),"");
   }
  if($site_updates != ''){
    $dbObj->cgi("tbl_siteupdates_subscriber",array("userid","emailid","status"),array($_GET['userid'],$email,"Active"),"");
  }*/

  		$s=$msobj->showmessage(3);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
  header("Location:".SITEROOT."/admin/user/admin_users_list.php");
  exit;

}


$smarty->assign("inmenu", "user");
$smarty->display( TEMPLATEDIR . '/admin/user/admin_user_information.tpl');
$dbObj->Close();
?>