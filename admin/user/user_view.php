<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/function.php");

if(!$_SESSION['duAdmId'])
	header("location:". SITEROOT . "/admin/login/index.php");


#----------Get seller information-------------#

$tbl1 = "tbl_users";
$cd="userid = ".$_GET['userid'];

$rs_user = $dbObj->gj($tbl1, $sf , $cd, "", "", "", "","");
if($rs_user !='n')
{
      $row = @mysql_fetch_assoc($rs_user);

		$bd=explode(" ",$row['birthdate']);
		//print_r($bd);
		$bd1=date("j F, Y",strtotime($bd['0']));
	$smarty->assign("bd",$bd1);
      #------------Get last login-----------#
      $tmp= $dbObj->gj("tbl_login_log","login_date as last_login,ipaddress","userid='{$_GET['userid']}'","id","","DESC","0,1","");
      if($tmp !='n')
      { 
	  $login=mysql_fetch_assoc($tmp);
          $row['last_login'] =$login['last_login'];
          $row['ipaddress'] = $login['ipaddress'];
      }
      #------------End last login-----------#

	////////////////////////country details///////////////////
	$conuntryname = '';
	if($row['countryid'] > 0)
	{
		$sql_cntry="SELECT * FROM mast_country where countryid=".$row['countryid']."";
		$rs_cntry=mysql_query($sql_cntry)or die(mysql_error());
		$row_cntry=@mysql_fetch_assoc($rs_cntry);
		$conuntryname = $row_cntry['country'];
	}
		$row['country'] = $conuntryname;
	////////////////////////country details///////////////////
	if($row['state_id'] > 0)
	{
		$sql_state="SELECT * FROM mast_state where id=".$row['state_id']."";
		$rs_state=mysql_query($sql_state)or die(mysql_error());
		$row_state=@mysql_fetch_assoc($rs_state);
		$state_name = $row_state['state_name'];
	}
		$row['state_name'] = $state_name;
	
	////////////////////////city details///////////////////
		if($row['city'] > 0)
		{
	        $cityname=getCityDetFromId($row['city']);
	        $row['city_name']=$cityname['city_name'];
	        }
	

      #------------Get purchase histroy-----------#
      $tot_purchase=0; $date=date("Y-m-d H:i:s"); $date1=date("Y-m-d");
	//and p.cancel_order = 'no'
      $tbl="tbl_deal as d,tbl_deal_payment as p";
      $cnd_test="p.user_id='{$_GET['userid']}' and p.payment_done = 'yes'  and p.deal_id=d.deal_unique_id and p.expiry_date >= $date1";
      $arr=$dbObj->gj($tbl,"*,d.title as title1",$cnd_test,"","","","",""); 
      if($arr !='n')
      {
	  while($deal=@mysql_fetch_assoc($arr))
		  $tot_purchase += $deal['deal_quantity'];
          $row['tot_purchase'] = $tot_purchase;
      }
      else
          $row['tot_purchase'] = 0;
      #-----------End purchase histroy--------------#

      #----------------Get order--------------------#
      $tot_order=0; 

      $tbl="tbl_deal as d,tbl_deal_payment as p";
      $cnd = "p.user_id='{$_GET['userid']}' and p.payment_done = 'no' and d.deal_status = '1' and p.deal_id=d.deal_unique_id";
      $arr2 = $dbObj->gj($tbl,"*,d.title as title1",$cnd,"","","","","");

      if($arr2 !='n')
      {
	  while($deal=@mysql_fetch_assoc($arr2))
		  $tot_order += $deal['deal_quantity'];
          $row['tot_order'] = $tot_order;
      }
      else
          $row['tot_order'] = 0;
      #--------------End  order----------------#

      #--------------Cancel order--------------#
// and cancel_order = 'yes'
      $c_ordr= $dbObj->gj("tbl_deal_payment","sum(deal_quantity)as tot_cancel","user_id='{$_GET['userid']}' ","","","","","");
      $rs_cordr=@mysql_fetch_assoc($c_ordr);
      $row['tot_cancel'] = $rs_cordr['tot_cancel'];
      #---------End cancel order-----------#

      #---------Total sale order-----------#
      #1. get list of deals 
      $rs1= $dbObj->gj("tbl_deal","deal_unique_id","seller_id='{$_GET['userid']}'","","","","","");
      while($rs_d = @mysql_fetch_assoc($rs1))
          $rsdealId[] = $rs_d['deal_unique_id'];
      $dealId = @implode(",",$rsdealId);
      if($dealId != '')
      {
	  #2.get count of total sold
	  $s_ordr= $dbObj->gj("tbl_deal_payment","sum(deal_quantity)as tot_sell","deal_id in ({$dealId}) and payment_done = 'yes' and cancel_order ='no'","","","","","");
	  $rs_sordr=@mysql_fetch_assoc($s_ordr);
          $row['tot_sell'] = $rs_sordr['tot_sell'];
      }
      else
          $row['tot_sell'] = 0;
      #---------End total sale order-----------#

      #------------Get Total Sold -------------#
      #1. get list of deals 
      $rs1= $dbObj->gj("tbl_deal","deal_unique_id","seller_id='{$_GET['userid']}' and 	deal_status = 3 and admin_approve = 'yes'","","","","","");
      if($rs1 !='n')
          $row['tot_sold'] = @mysql_num_rows($rs1);
      else
          $row['tot_sold'] = 0;
      #------------Get Total Sold -------------#

      #---------Get product sold count-----------#
      $tbl="tbl_deal";
      $cnd_test="seller_id='{$_GET['userid']}' and deal_status='3'  and deal_type = 'product'";
      $rs1=$dbObj->gj($tbl,"*,title as title1",$cnd_test,"","deal_unique_id","","","");
      if($rs1 !='n')
          $row['tot_soldproduct'] = @mysql_num_rows($rs1);
      else
          $row['tot_soldproduct'] = 0;
      #---------End product sold count-----------#

      #---------Get voucher sold count-----------#
      $tbl="tbl_deal";
      $cnd_test="seller_id='{$_GET['userid']}' and deal_status='3'  and deal_type = 'service'";
      $rs1=$dbObj->gj($tbl,"*,title as title1",$cnd_test,"","deal_unique_id","","","");
      if($rs1 !='n')
          $row['tot_soldordr'] = @mysql_num_rows($rs1);
      else
          $row['tot_soldordr'] = 0;
      #---------End product sold count-----------#

      #---------Get feedback count-----------#
      $rs_f= $dbObj->gj("tbl_feedback_review","count(seller_id)as tot_feedback","seller_id='{$_GET['userid']}'","","","","","");
      $rs_f=@mysql_fetch_assoc($rs_f);
      $row['tot_feedback'] = $rs_f['tot_feedback'];
      #---------End feedback order-----------#

      #---------Get message count-----------#
      $cnd = " user_id ='{$_GET['userid']}' and  is_RDelete = 'No' ";
      $rs1 = $dbObj->gj("tbl_message m","count(m.id) as tot_msg",$cnd,"m.id","","", "", "");
      $rs_m=@mysql_fetch_assoc($rs1);
      $row['tot_msg'] = $rs_m['tot_msg'];
      #---------End message count-----------#

      #---------Get forum count-----------#

      #1.get forum count
      $tot = 0;

      $tb1 = "tbl_forum f INNER JOIN tbl_category c ON f.categoryid = c.categoryid";
      $sf1 = "f.forumid ";
      $cnd1 = "userid ='{$_GET['userid']}' and c.status='Active' and f.status = 'active'";
      $rs_f1 = $dbObj->gj($tb1,$sf1,$cnd1,"","","", "", "");
      if( $rs_f1 !='n')
      {
          $tot += @mysql_num_rows($rs_f1);

	  while( $rs_forum=@mysql_fetch_assoc($rs_f1))
	      $forum_id[]= $rs_forum['forumid'];
	  $forumId = @implode(",",$forum_id);

          #2.get thread count
	  if($forumId != '')
	  {
              $rs_f2 = $dbObj->gj("tbl_forum_thread","threadid","forumid IN ({$forumId}) and userid = '{$_GET['userid']}'","","","", "", "");
	      if( $rs_f2 !='n')
              {
		  $tot += @mysql_num_rows($rs_f2);

		  while( $rs_thrd=@mysql_fetch_assoc($rs_f2))
		      $thrd[]= $rs_thrd['threadid'];

		  $thrdId = @implode(",",$thrd);

                  #3. get thread reply count
		  if($thrdId != '')
		  {
		      $rs_f3 = $dbObj->gj("tbl_forum_reply","replyid","forumid IN ({$forumId}) and userid = '{$_GET['userid']}' and threadid IN ({$thrdId})","","","", "", "");
		      if( $rs_f3 !='n')
		      {
			  $tot += @mysql_num_rows($rs_f3);

		      }
		  }
              }
          }

        $row['tot_forum'] = $tot;
      }
      else
	  $row['tot_forum'] = 0;
      #---------End forum count-----------#

      $smarty->assign("user", $row);
}
#----------Get seller information-------------#


$rs1=mysql_query("select seller_type_id,seller_type_name from tbl_seller_type where Active=1 and seller_type_id =".$row['company_type']);
$row1=@mysql_fetch_assoc($rs1);
$seller1 = $row1['seller_type_name'];
$smarty->assign("seller1",$seller1);
	
$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/user/users_view.tpl');

$dbObj->Close();
?>