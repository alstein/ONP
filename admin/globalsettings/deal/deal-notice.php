<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("17", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#


      $row="";
      #-------------Get Rejected deals-----------#
      $revwd= $dbObj->gj("tbl_deal","deal_unique_id","admin_approve = 'no' and deal_status != 2","","","","","");
      if($revwd !='n')
          $row['tot_reviewed'] = @mysql_num_rows($revwd);
      else
          $row['tot_reviewed'] = 0;
      #-------------end Rejected deals-----------#


      #-------------Get Scheduled deals-----------#
      $date = date("Y-m-d H:i:s");	
      #1.Active Deals
      $cnd=" admin_approve = 'yes' and admin_review = '1' and deal_status = '1'  and (start_date <= '$date' and end_date >= '$date')";
      $d_actv= $dbObj->gj("tbl_deal","deal_unique_id",$cnd,"","","","","");
      if($d_actv !='n')
          $row['tot_actv1'] = @mysql_num_rows($d_actv);
      else
          $row['tot_actv1'] = 0;

      #2.Pending Deals
      $cnd = " admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and (start_date > '$date')";
      $d_actv2= $dbObj->gj("tbl_deal","deal_unique_id",$cnd,"","","","","");
      if($d_actv2 !='n')
          $row['tot_pending'] = @mysql_num_rows($d_actv2);
      else
          $row['tot_pending'] = 0;

      $row['tot_actv'] = $row['tot_actv1'] + $row['tot_pending'];
      #-------------end Scheduled deals-----------#

      #-------------Get Completed deals GB product -----------#
      #1.Completd
      $d_com= $dbObj->gj("tbl_deal","deal_unique_id"," deal_status =3 and deal_type='product' and seller_id=1","","","","","");
      if($d_com !='n')
          $row['GB_PRO_COM'] = @mysql_num_rows($d_com);
      else
          $row['GB_PRO_COM'] = 0;

      #2.not completd
      $d_com2= $dbObj->gj("tbl_deal","deal_unique_id"," deal_status = 4 and deal_type='product' and seller_id=1","","","","","");
      if($d_com2 !='n')
          $row['GB_PRO_NCOM'] = @mysql_num_rows($d_com2);
      else
          $row['GB_PRO_NCOM'] = 0;

       $row['GB_PRO'] = $row['GB_PRO_COM'] + $row['GB_PRO_NCOM'];
      #-------------End Completed deals GB Product -----------#

      #-------------Get Completed deals GB Service -----------#
      #1.Completd
      $d_com= $dbObj->gj("tbl_deal","deal_unique_id"," deal_status =3 and deal_type='service' and seller_id=1","","","","","");
      if($d_com !='n')
          $row['GB_SER_COM'] = @mysql_num_rows($d_com);
      else
          $row['GB_SER_COM'] = 0;

      #2.not completd
      $d_com2= $dbObj->gj("tbl_deal","deal_unique_id"," deal_status = 4 and deal_type='service' and seller_id=1","","","","","");
      if($d_com2 !='n')
          $row['GB_SER_NCOM'] = @mysql_num_rows($d_com2);
      else
          $row['GB_SER_NCOM'] = 0;

       $row['GB_SER'] = $row['GB_SER_COM'] + $row['GB_SER_NCOM'];
      #-------------End Completed deals GB Service -----------#

      #-------------Get Completed deals SELL product -----------#
      #1.Completd
      $d_com= $dbObj->gj("tbl_deal","deal_unique_id"," deal_status =3 and deal_type='product' and seller_id!=1","","","","","");
      if($d_com !='n')
          $row['SELL_PRO_COM'] = @mysql_num_rows($d_com);
      else
          $row['SELL_PRO_COM'] = 0;

      #2.not completd
      $d_com2= $dbObj->gj("tbl_deal","deal_unique_id"," deal_status = 4 and deal_type='product' and seller_id!=1","","","","","");
      if($d_com2 !='n')
          $row['SELL_PRO_NCOM'] = @mysql_num_rows($d_com2);
      else
          $row['SELL_PRO_NCOM'] = 0;

       $row['SELL_PRO'] = $row['SELL_PRO_COM'] + $row['SELL_PRO_NCOM'];
      #-------------End Completed deals SELL Product -----------#


      #-------------Get Completed deals SELL Service -----------#
      #1.Completd
      $d_com= $dbObj->gj("tbl_deal","deal_unique_id"," deal_status =3 and deal_type='service' and seller_id!=1","","","","","");
      if($d_com !='n')
          $row['SELL_SER_COM'] = @mysql_num_rows($d_com);
      else
          $row['SELL_SER_COM'] = 0;

      #2.not completd
      $d_com2= $dbObj->gj("tbl_deal","deal_unique_id"," deal_status = 4 and deal_type='service' and seller_id!=1","","","","","");
      if($d_com2 !='n')
          $row['SELL_SER_NCOM'] = @mysql_num_rows($d_com2);
      else
          $row['SELL_SER_NCOM'] = 0;

       $row['SELL_SER'] = $row['SELL_SER_COM'] + $row['SELL_SER_NCOM'];
      #-------------End Completed deals SELL Service -----------#

      #-------------Get Rejected deals-----------#
      $c_ordr= $dbObj->gj("tbl_deal","deal_unique_id","seller_id > 0 and deal_status = 2 and admin_approve = 'yes'","","","","","");
      if($c_ordr !='n')
          $row['tot_rej'] = @mysql_num_rows($c_ordr);
      else
          $row['tot_rej'] = 0;
      #-------------end Rejected deals-----------#

      #-----------Total Deal----------------#
       $row['tot_deals'] = $row['tot_reviewed'] + $row['tot_actv'] + $row['SELL_SER']+  $row['SELL_PRO']+ $row['GB_SER']+ $row['GB_PRO']+$row['tot_rej'];
      #-----------Total Deal----------------#

      $smarty->assign("deal",$row);

$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/deal-notice.tpl');
$dbObj->Close();
?>