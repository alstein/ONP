<?php
class Accesslevel extends DBTransact
{
        function getAdminAccess($adminId)
        {
              if($adminId == 1)
              {
		    $accesslevelmodule=$this->customqry("select id from mast_modules where 1","");

		    while($resultrowaccesslevel=@mysql_fetch_array($accesslevelmodule))
		      $levelmdlformodules[]=$resultrowaccesslevel['id'];
                    return $levelmdlformodules;
              }
              else
              {
		  $module_cnd = "userid='{$adminId}'";
		  $module_permit=$this->gj("tbl_users", "access_level", $module_cnd, "", "", "", "", "");
		  $module_permit_list=@mysql_fetch_array($module_permit);

		  $levelmdlformodules="";

		  $access_level=$module_permit_list['access_level'];

		  $accesslevelmodule=$this->customqry("select * from mast_levels where levelid ='{$access_level}'","");

		  while($resultrowaccesslevel=@mysql_fetch_array($accesslevelmodule))
		    $levelmdlformodules=$resultrowaccesslevel['modules'];

		  return $arr_modules_permit = explode(",",$levelmdlformodules);
              }
        }

        function getTotalAdmin()
        {
	      $rs_admin= $this->gj("tbl_users","userid","usertypeid = 1 AND isDeleted = 0","","","","","");
	      if($rs_admin !='n')
		  return mysql_num_rows($rs_admin);
	      else
		  return 0;
        }

        function getTotalBuyer()
        {
	      $rs_admin= $this->gj("tbl_users","userid","usertypeid = 2","","","","","");
	      if($rs_admin !='n')
		  return mysql_num_rows($rs_admin);
	      else
		  return 0;
        }

        function getTotalSeller()
        {
	      $rs_admin= $this->gj("tbl_users","userid","usertypeid = 3","","","","","");
	      if($rs_admin !='n')
		  return mysql_num_rows($rs_admin);
	      else
		  return 0;
        }

        function getTotalAdminMessage()
        {
	      $tbl = "tbl_message as m INNER JOIN tbl_users as u ON u.userid= m.from_id";
	      $sf = "m.id";

	     $cnd = " u.userid= m.from_id  and m.user_id = '{$_SESSION['duAdmId']}' and m.is_RDelete = 'No' and is_RRead='No'";
	      $rs_tmp = $this->gj($tbl,$sf,$cnd, "", "", "", "", "");
	      if($rs_tmp !='n')
		  return mysql_num_rows($rs_tmp);
	      else
		  return 0;
        }
        function getTotalSubscriber()
        {
	      $rs_sub= $this->gj("tbl_newsletter","nid","1","","","","","");
	      if($rs_sub !='n')
		  return mysql_num_rows($rs_sub);
	      else
		  return 0;
        }

	function getAllDealDetails()
	{
              $row="";
	      #-------------Get Rejected deals-----------#
	      $revwd= $this->gj("tbl_deal","deal_unique_id","admin_approve = 'no' and deal_status != 2","","","","","");
	      if($revwd !='n')
		  $row['tot_reviewed'] = @mysql_num_rows($revwd);
	      else
		  $row['tot_reviewed'] = 0;
	      #-------------end Rejected deals-----------#
	
	
	      #-------------Get Scheduled deals-----------#
	      $date = date("Y-m-d H:i:s");	
	      #1.Active Deals
	      $cnd=" admin_approve = 'yes' and admin_review = '1' and deal_status = '1'  and (start_date <= '$date' and end_date >= '$date')";
	      $d_actv= $this->gj("tbl_deal","deal_unique_id",$cnd,"","","","","");
	      if($d_actv !='n')
		  $row['tot_actv1'] = @mysql_num_rows($d_actv);
	      else
		  $row['tot_actv1'] = 0;
	
	      #2.Pending Deals
	      //$cnd = " admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and (start_date > '$date')";
	      $cnd = " admin_approve = 'no' and admin_review = '1' and deal_status = '1'";
	      $d_actv2= $this->gj("tbl_deal","deal_unique_id",$cnd,"","","","","");
	      if($d_actv2 !='n')
		  $row['tot_pending'] = @mysql_num_rows($d_actv2);
	      else
		  $row['tot_pending'] = 0;
	
	      $row['tot_actv'] = $row['tot_actv1'] + $row['tot_pending'];
	      #-------------end Scheduled deals-----------#
	
	      #-------------Get Completed deals GB product -----------#
	      #1.Completd
	      $d_com= $this->gj("tbl_deal","deal_unique_id"," deal_status = 3 and deal_type='product' and seller_id=1","","","","","");
//die();
	      if($d_com !='n')
		  $row['GB_PRO_COM'] = @mysql_num_rows($d_com);
	      else
		  $row['GB_PRO_COM'] = 0;
	
	      #2.not completd
	      $d_com2= $this->gj("tbl_deal","deal_unique_id"," deal_status = 4 and deal_type='product' and seller_id=1","","","","","");
	      if($d_com2 !='n')
		  $row['GB_PRO_NCOM'] = @mysql_num_rows($d_com2);
	      else
		  $row['GB_PRO_NCOM'] = 0;
	
	      $row['GB_PRO'] = $row['GB_PRO_COM'] + $row['GB_PRO_NCOM'];
	      #-------------End Completed deals GB Product -----------#
		  
		  
	      #-------------Get Completed deals GB Service -----------#
	      #1.Completd
	      $d_com= $this->gj("tbl_deal","deal_unique_id"," deal_status =3 and deal_type='service' and seller_id=1","","","","","");
	      if($d_com !='n')
		  $row['GB_SER_COM'] = @mysql_num_rows($d_com);
	      else
		  $row['GB_SER_COM'] = 0;
	
	      #2.not completd
	      $d_com2= $this->gj("tbl_deal","deal_unique_id"," deal_status = 4 and deal_type='service' and seller_id=1","","","","","");
	      if($d_com2 !='n')
		  $row['GB_SER_NCOM'] = @mysql_num_rows($d_com2);
	      else
		  $row['GB_SER_NCOM'] = 0;
	
	      $row['GB_SER'] = $row['GB_SER_COM'] + $row['GB_SER_NCOM'];
	      #-------------End Completed deals GB Service -----------#
	
	      #-------------Get Completed deals SELL product -----------#
	      #1.Completd
	      $d_com= $this->gj("tbl_deal","deal_unique_id"," deal_status =3 and deal_type='product' and seller_id!=1","","","","","");
	      if($d_com !='n')
		  $row['SELL_PRO_COM'] = @mysql_num_rows($d_com);
	      else
		  $row['SELL_PRO_COM'] = 0;
	
	      #2.not completd
	      $d_com2= $this->gj("tbl_deal","deal_unique_id"," deal_status = 4 and deal_type='product' and seller_id!=1","","","","","");
	      if($d_com2 !='n')
		  $row['SELL_PRO_NCOM'] = @mysql_num_rows($d_com2);
	      else
		  $row['SELL_PRO_NCOM'] = 0;
	
	      $row['SELL_PRO'] = $row['SELL_PRO_COM'] + $row['SELL_PRO_NCOM'];
	      #-------------End Completed deals SELL Product -----------#
	
	      #-------------Get Completed deals SELL Service -----------#
	      #1.Completd
	      $d_com= $this->gj("tbl_deal","deal_unique_id"," deal_status =3 and deal_type='service' and seller_id!=1","","","","","");
	      if($d_com !='n')
		  $row['SELL_SER_COM'] = @mysql_num_rows($d_com);
	      else
		  $row['SELL_SER_COM'] = 0;
	
	      #2.not completd
	      $d_com2= $this->gj("tbl_deal","deal_unique_id"," deal_status = 4 and deal_type='service' and seller_id!=1","","","","","");
	      if($d_com2 !='n')
		  $row['SELL_SER_NCOM'] = @mysql_num_rows($d_com2);
	      else
		  $row['SELL_SER_NCOM'] = 0;
	
	      $row['SELL_SER'] = $row['SELL_SER_COM'] + $row['SELL_SER_NCOM'];
	      #-------------End Completed deals SELL Service -----------#
	
	      #-------------Get Rejected deals-----------#
	      $c_ordr= $this->gj("tbl_deal","deal_unique_id","seller_id > 0 and deal_status = 2 and admin_approve = 'yes'","","","","","");
	      if($c_ordr !='n')
		  $row['tot_rej'] = @mysql_num_rows($c_ordr);
	      else
		  $row['tot_rej'] = 0;
	      #-------------end Rejected deals-----------#
	
	      #-------------Get Featured deals-----------#
	      $c_ordr= $this->gj("tbl_deal","deal_unique_id","admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and (start_date <= '$date' and end_date >= '$date') and featured ='1'","","","","","");
	      if($c_ordr !='n')
		  $row['tot_fea'] = @mysql_num_rows($c_ordr);
	      else
		  $row['tot_fea'] = 0;
	      #-------------End Featured deals-----------#
                #-------------Get newsletter deals -----------#	
            $c_new= $this->gj("tbl_deal","deal_unique_id","deal_status = 1 and news_subscribe=1 and (start_date <= '$date' and end_date >= '$date')","","","","","");
	      if($c_new !='n')
		  $row['tot_news'] = @mysql_num_rows($c_new);
	      else
		  $row['tot_news'] = 0;

	      #-------------Get Recommended deals-----------#
	      $c_ordr= $this->gj("tbl_deal","deal_unique_id","admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and (start_date <= '$date' and end_date >= '$date') and recommend ='1'","","","","","");
	      if($c_ordr !='n')
		  $row['tot_recomd'] = @mysql_num_rows($c_ordr);
	      else
		  $row['tot_recomd'] = 0;
	      #-------------End Recommended deals-----------#

	      #-------------Get Upcoming deals-----------#
	      $cnd_upDl = " admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and (start_date > '$date')";
	      $d_upDl= $this->gj("tbl_deal","deal_unique_id",$cnd_upDl,"","","","","");
	      if($d_upDl !='n')
		  $row['tot_upcom'] = @mysql_num_rows($d_upDl);
	      else
		  $row['tot_upcom'] = 0;
	      #-------------End Upcoming deals-----------#

	      #-------------Get Expired deals-----------#
	      $cnd_expDl = " admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and (end_date < '$date')";
	      $d_expDl= $this->gj("tbl_deal","deal_unique_id",$cnd_expDl,"","","","","");
	      if($d_expDl !='n')
		  $row['tot_exp'] = @mysql_num_rows($d_expDl);
	      else
		  $row['tot_exp'] = 0;
	      #-------------End Expired deals-----------#
		
	      return $row;
	}

	function getAllAffiliateDetails()
	{
		$row="";

		#-------------START Get Marchant----------#
		$res_mar = $this->gj("tbl_deal_affiliate_marchant", "id", "id!=0", "", "", "", "", "");
		if($res_mar !='n')
			$row['TOT_MARCHANT'] = @mysql_num_rows($res_mar);
		else
			$row['TOT_MARCHANT'] = 0;
		#-------------END Get Marchant-----------#

		#-------------START Get Discount Marchant----------#
		$res_dis_mar = $this->gj("tbl_disc_codes_affiliate_merchants", "id", "id!=0", "", "", "", "", "");
		if($res_dis_mar !='n')
			$row['TOT_DISCOUNT_MARCHANT'] = @mysql_num_rows($res_dis_mar);
		else
			$row['TOT_DISCOUNT_MARCHANT'] = 0;
		#-------------END Get Discount Marchant-----------#

		#-------------START Get Discount Codes----------#
		$res_dis_code = $this->gj("tbl_affiliate_discount_codes", "id" , "id!=0", "", "", "", "", "");
		if($res_dis_code !='n')
			$row['TOT_DISCOUNT_CODES'] = @mysql_num_rows($res_dis_code);
		else
			$row['TOT_DISCOUNT_CODES'] = 0;
		#-------------END Get Discount Codes-----------#

		#-------------START Get Discount Codes----------#
		$date = date("Y-m-d H:i:s");
		$res_active_aggr_deals = $this->gj("tbl_deal_affiliate p", "deal_unique_id", "p.dValidFrom <= '".$date."' and p.dValidTo >= '".$date."'", "", "", "", "", "");

		if($res_active_aggr_deals !='n')
			$row['TOT_ACTIVE_AGGR_DEALS'] = @mysql_num_rows($res_active_aggr_deals);
		else
			$row['TOT_ACTIVE_AGGR_DEALS'] = 0;
		#-------------END Get Discount Codes-----------#

		#-------------START Get Discount Codes----------#
		$res_exp_aggr_deals = $this->gj("tbl_deal_affiliate p", "deal_unique_id", "p.dValidTo < '".$date."'", "", "", "", "", "");
		if($res_exp_aggr_deals !='n')
			$row['TOT_EXP_AGGR_DEALS'] = @mysql_num_rows($res_exp_aggr_deals);
		else
			$row['TOT_EXP_AGGR_DEALS'] = 0;
		#-------------END Get Discount Codes-----------#

		#-------------START Get Aggregate Deals----------#
		$res_aggr_deals = $this->customqry("SELECT p.*, dt.dealtype, m.marchant_name FROM tbl_deal_affiliate p INNER JOIN tbl_affiliate_deal_count dc ON p.iId=dc.iId INNER JOIN tbl_dealtype dt ON p.deal_main_type=dt.typeid INNER JOIN tbl_deal_affiliate_marchant m ON p.iMerchantId=m.marchant_id", "");
		if($res_aggr_deals !='n')
			$row['TOT_AGGR_DEALS'] = @mysql_num_rows($res_aggr_deals);
		else
			$row['TOT_AGGR_DEALS'] = 0;
		#-------------END Get Aggregate Deals-----------#

		return $row;
	}

	function getSellerAllDealDetails($admin_userid)
	{
		$row="";
	      #-------------Get Rejected deals-----------#
	      $revwd= $this->gj("tbl_deal","deal_unique_id","admin_approve = 'no' and deal_status != 2 and admin_userid = ".$admin_userid,"","","","","");
	      if($revwd !='n')
		  $row['tot_reviewed'] = @mysql_num_rows($revwd);
	      else
		  $row['tot_reviewed'] = 0;
	      #-------------end Rejected deals-----------#
	
	
	      #-------------Get Scheduled deals-----------#
	      $date = date("Y-m-d H:i:s");	
	      #1.Active Deals
	      $cnd=" admin_approve = 'yes' and admin_review = '1' and deal_status = '1'  and (start_date <= '$date' and end_date >= '$date') and admin_userid = ".$admin_userid;
	      $d_actv= $this->gj("tbl_deal","deal_unique_id",$cnd,"","","","","");
	      if($d_actv !='n')
		  $row['tot_actv1'] = @mysql_num_rows($d_actv);
	      else
		  $row['tot_actv1'] = 0;
	
	      #2.Pending Deals
	      //$cnd = " admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and (start_date > '$date')";
	      $cnd = " admin_approve = 'no' and admin_review = '1' and deal_status = '1' and admin_userid = ".$admin_userid;
	      $d_actv2= $this->gj("tbl_deal","deal_unique_id",$cnd,"","","","","");
	      if($d_actv2 !='n')
		  $row['tot_pending'] = @mysql_num_rows($d_actv2);
	      else
		  $row['tot_pending'] = 0;
	
	      $row['tot_actv'] = $row['tot_actv1'] + $row['tot_pending'];
	      #-------------end Scheduled deals-----------#
	
	      #-------------Get Completed deals GB product -----------#
	      #1.Completd
	      $d_com= $this->gj("tbl_deal","deal_unique_id"," deal_status =3 and deal_type='product' and seller_id=1 and admin_userid = ".$admin_userid,"","","","","");
	      if($d_com !='n')
		  $row['GB_PRO_COM'] = @mysql_num_rows($d_com);
	      else
		  $row['GB_PRO_COM'] = 0;
	
	      #2.not completd
	      $d_com2= $this->gj("tbl_deal","deal_unique_id"," deal_status = 4 and deal_type='product' and seller_id=1 and admin_userid = ".$admin_userid,"","","","","");
	      if($d_com2 !='n')
		  $row['GB_PRO_NCOM'] = @mysql_num_rows($d_com2);
	      else
		  $row['GB_PRO_NCOM'] = 0;
	
	      $row['GB_PRO'] = $row['GB_PRO_COM'] + $row['GB_PRO_NCOM'];
	      #-------------End Completed deals GB Product -----------#
		  
		  
	      #-------------Get Completed deals GB Service -----------#
	      #1.Completd
	      $d_com= $this->gj("tbl_deal","deal_unique_id"," deal_status =3 and deal_type='service' and seller_id=1 and admin_userid = ".$admin_userid,"","","","","");
	      if($d_com !='n')
		  $row['GB_SER_COM'] = @mysql_num_rows($d_com);
	      else
		  $row['GB_SER_COM'] = 0;
	
	      #2.not completd
	      $d_com2= $this->gj("tbl_deal","deal_unique_id"," deal_status = 4 and deal_type='service' and seller_id=1 and admin_userid = ".$admin_userid,"","","","","");
	      if($d_com2 !='n')
		  $row['GB_SER_NCOM'] = @mysql_num_rows($d_com2);
	      else
		  $row['GB_SER_NCOM'] = 0;
	
	      $row['GB_SER'] = $row['GB_SER_COM'] + $row['GB_SER_NCOM'];
	      #-------------End Completed deals GB Service -----------#
	
	      #-------------Get Completed deals SELL product -----------#
	      #1.Completd
	      $d_com= $this->gj("tbl_deal","deal_unique_id"," deal_status =3 and deal_type='product' and seller_id!=1 and admin_userid = ".$admin_userid,"","","","","");
	      if($d_com !='n')
		  $row['SELL_PRO_COM'] = @mysql_num_rows($d_com);
	      else
		  $row['SELL_PRO_COM'] = 0;
	
	      #2.not completd
	      $d_com2= $this->gj("tbl_deal","deal_unique_id"," deal_status = 4 and deal_type='product' and seller_id!=1 and admin_userid = ".$admin_userid,"","","","","");
	      if($d_com2 !='n')
		  $row['SELL_PRO_NCOM'] = @mysql_num_rows($d_com2);
	      else
		  $row['SELL_PRO_NCOM'] = 0;
	
	      $row['SELL_PRO'] = $row['SELL_PRO_COM'] + $row['SELL_PRO_NCOM'];
	      #-------------End Completed deals SELL Product -----------#
	
	      #-------------Get Completed deals SELL Service -----------#
	      #1.Completd
	      $d_com= $this->gj("tbl_deal","deal_unique_id"," deal_status =3 and deal_type='service' and seller_id!=1 and admin_userid = ".$admin_userid,"","","","","");
	      if($d_com !='n')
		  $row['SELL_SER_COM'] = @mysql_num_rows($d_com);
	      else
		  $row['SELL_SER_COM'] = 0;
	
	      #2.not completd
	      $d_com2= $this->gj("tbl_deal","deal_unique_id"," deal_status = 4 and deal_type='service' and seller_id!=1 and admin_userid = ".$admin_userid,"","","","","");
	      if($d_com2 !='n')
		  $row['SELL_SER_NCOM'] = @mysql_num_rows($d_com2);
	      else
		  $row['SELL_SER_NCOM'] = 0;
	
	      $row['SELL_SER'] = $row['SELL_SER_COM'] + $row['SELL_SER_NCOM'];
	      #-------------End Completed deals SELL Service -----------#
	
	      #-------------Get Rejected deals-----------#
	      $c_ordr= $this->gj("tbl_deal","deal_unique_id","seller_id > 0 and deal_status = 2 and admin_approve = 'yes' and admin_userid = ".$admin_userid,"","","","","");
	      if($c_ordr !='n')
		  $row['tot_rej'] = @mysql_num_rows($c_ordr);
	      else
		  $row['tot_rej'] = 0;
	      #-------------end Rejected deals-----------#
	
	      #-------------Get Featured deals-----------#
	      $c_ordr= $this->gj("tbl_deal","deal_unique_id","admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and (start_date <= '$date' and end_date >= '$date') and featured ='1' and admin_userid = ".$admin_userid,"","","","","");
	      if($c_ordr !='n')
		  $row['tot_fea'] = @mysql_num_rows($c_ordr);
	      else
		  $row['tot_fea'] = 0;
	      #-------------End Featured deals-----------#
                #-------------Get newsletter deals -----------#	
            $c_new= $this->gj("tbl_deal","deal_unique_id","deal_status = 1 and news_subscribe=1 and (start_date <= '$date' and end_date >= '$date') and admin_userid = ".$admin_userid,"","","","","");
	      if($c_new !='n')
		  $row['tot_news'] = @mysql_num_rows($c_new);
	      else
		  $row['tot_news'] = 0;

	      #-------------Get Recommended deals-----------#
	      $c_ordr= $this->gj("tbl_deal","deal_unique_id","admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and (start_date <= '$date' and end_date >= '$date') and recommend ='1' and admin_userid = ".$admin_userid,"","","","","");
	      if($c_ordr !='n')
		  $row['tot_recomd'] = @mysql_num_rows($c_ordr);
	      else
		  $row['tot_recomd'] = 0;
	      #-------------End Recommended deals-----------#

	      #-------------Get Upcoming deals-----------#
	      $cnd_upDl = " admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and (start_date > '$date') and admin_userid = ".$admin_userid;
	      $d_upDl= $this->gj("tbl_deal","deal_unique_id",$cnd_upDl,"","","","","");
	      if($d_upDl !='n')
		  $row['tot_upcom'] = @mysql_num_rows($d_upDl);
	      else
		  $row['tot_upcom'] = 0;
	      #-------------End Upcoming deals-----------#

	      #-------------Get Expired deals-----------#
	      $cnd_expDl = " admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and (end_date < '$date') and admin_userid = ".$admin_userid;
	      $d_expDl= $this->gj("tbl_deal","deal_unique_id",$cnd_expDl,"","","","","");
	      if($d_expDl !='n')
		  $row['tot_exp'] = @mysql_num_rows($d_expDl);
	      else
		  $row['tot_exp'] = 0;
	      #-------------End Expired deals-----------#
		
	      return $row;
	}

}
$accObj = new Accesslevel();
?>
