<?php
include_once('../../include.php');

$select_deal=$dbObj->customqry("select d.*,u.fullname,u.userid,u.business_name,u.deal_cat  from tbl_deals d left join tbl_users u on d.merchant_id=u.userid where d.cron_flag='0'","");
while($res_deal=@mysql_fetch_assoc($select_deal))
{
//category preferance
	$sel_user=$dbObj->customqry("select *  from tbl_users  where category_preferance like '%".$res_deal['deal_cat']."%' and deal_by_email='yes' ","");

			while($res_user=@mysql_fetch_assoc($sel_user))
			{
				$signup_date=date("Y-m-d H:i:s");
			
				$email_query = "select * from mast_emails where emailid=76";
				$email_rs = @mysql_query($email_query);
				$email_row = @mysql_fetch_object($email_rs);
			
				$image_link=SITEROOT."/uploads/deal/".$res_deal['deal_image'];
				$email_subject = $res_deal['discount_in_per']."% Off On ".$res_deal['deal_title'];
		
				$dealname = $res_deal['discount_in_per']."% Off On ".$res_deal['deal_title'];
		
				$email_subject =  str_replace("[[SITETITLE]]", SITETITLE, $email_subject);
				$email_subject = str_replace("[[deal_name]]",$dealname,$email_subject);
				$email_message = file_get_contents(ABSPATH."/email/deal_email.html");
			
				$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
				$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
				$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode(stripslashes($email_row->message)),$email_message);
			
				$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
				$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
				$email_message = str_replace("[[TODAYS_DATE]]",Date("j F, Y",strtotime($signup_date)), $email_message);
				$email_message = str_replace("[[imagelink]]",$image_link,$email_message);
				
				$email_message = str_replace("[[why_buy1]]",$res_deal['why_buy1'],$email_message);
				$email_message = str_replace("[[why_buy2]]",$res_deal['why_buy2'],$email_message);
				$email_message = str_replace("[[why_buy3]]",$res_deal['why_buy3'],$email_message);
				$email_message = str_replace("[[why_buy4]]",$res_deal['why_buy4'],$email_message);
				$email_message = str_replace("[[why_buy5]]",$res_deal['why_buy5'],$email_message);

				$email_message = str_replace("[[fname]]",$res_user['first_name'],$email_message);
				$email_message = str_replace("[[mname]]",$res_deal['business_name'],$email_message);
				$email_message = str_replace("[[Val]]",number_format($res_deal['offer_price']),$email_message);
				$email_message = str_replace("[[title]]",$dealname,$email_message);
				$email_message = str_replace("[[description]]",$res_deal['why_buy1'],$email_message);
				$email_message = str_replace("[[end_date]]",Date("j F, Y",strtotime($res_deal['deal_end_date'])),$email_message);
				
				$link=SITEROOT."/buy/".$res_deal['deal_unique_id'];
				$link_1="<a href='".$link."' target='_blank'><img alt='' height='43' src=".SITEROOT."/email/images/buy.png width='141' /></a>";
				$email_message = str_replace("[[link]]",$link_1,$email_message);
				//echo $email_message;exit;
				$from = SITE_EMAIL;
				$headers  = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
				$headers .= "From:".$from."\r\n";
				//$headers .= "Reply-To:".$from."\r\n" ;
				$headers .= "X-Mailer: PHP/".phpversion();
				$to=$res_user['email'];
				echo "-->".$email_message;
				//@mail($to,$email_subject,$email_message,$headers,"-f $from");
				 @mail($to,$email_subject,$email_message,$headers);
			}
//category preferance

//for fans
			//echo "==>".$res_deal['userid'];
		//	echo "==>".$res_deal['deal_cat'];
			$tbl="tbl_fan f left join tbl_users u on f.fan_id=u.userid";
			$sf="u.*,f.*";
			$cnd="f.userid=".$res_deal['merchant_id']." and u.category_preferance not in(".$res_deal['deal_cat'].")";
			$res_f=$dbObj->gj($tbl, $sf , $cnd, "", "", "","", "");
			while($row_f=@mysql_fetch_assoc($res_f))
			{
				$signup_date=date("Y-m-d H:i:s");
			
				$email_query = "select * from mast_emails where emailid=76";
				$email_rs = @mysql_query($email_query);
				$email_row = @mysql_fetch_object($email_rs);
			
				$image_link=SITEROOT."/uploads/deal/".$res_deal['deal_image'];
				$email_subject = $res_deal['discount_in_per']."% Off On ".$res_deal['deal_title'];
		
				$dealname = $res_deal['discount_in_per']."% Off On ".$res_deal['deal_title'];
		
				$email_subject =  str_replace("[[SITETITLE]]", SITETITLE, $email_subject);
				$email_subject = str_replace("[[deal_name]]",$dealname,$email_subject);
				$email_message = file_get_contents(ABSPATH."/email/deal_email.html");
			
				$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
				$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
				$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode(stripslashes($email_row->message)),$email_message);
			
				$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
				$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
				$email_message = str_replace("[[TODAYS_DATE]]",Date("j F, Y",strtotime($signup_date)), $email_message);
				$email_message = str_replace("[[imagelink]]",$image_link,$email_message);

				$email_message = str_replace("[[why_buy1]]",$res_deal['why_buy1'],$email_message);
				$email_message = str_replace("[[why_buy2]]",$res_deal['why_buy2'],$email_message);
				$email_message = str_replace("[[why_buy3]]",$res_deal['why_buy3'],$email_message);
				$email_message = str_replace("[[why_buy4]]",$res_deal['why_buy4'],$email_message);
				$email_message = str_replace("[[why_buy5]]",$res_deal['why_buy5'],$email_message);

				$email_message = str_replace("[[fname]]",$row_f['first_name'],$email_message);
				$email_message = str_replace("[[mname]]",$res_deal['business_name'],$email_message);
				$email_message = str_replace("[[title]]",$dealname,$email_message);
				$email_message = str_replace("[[description]]",$res_deal['why_buy1'],$email_message);
				$email_message = str_replace("[[end_date]]",Date("j F, Y",strtotime($res_deal['deal_end_date'])),$email_message);
				
				$link=SITEROOT."/buy/".$res_deal['deal_unique_id'];
				$link_1="<a href='".$link."' target='_blank'><img alt='' height='43' src=".SITEROOT."/email/images/buy.png width='141' /></a>";
				$email_message = str_replace("[[link]]",$link_1,$email_message);
				//echo $email_message;exit;
				$from = SITE_EMAIL;
				$headers  = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
				$headers .= "From:".$from."\r\n";
				//$headers .= "Reply-To:".$from."\r\n" ;
				$headers .= "X-Mailer: PHP/".phpversion();
				$to=$row_f['email'];
			
				//echo "==>".$email_message;
				//@mail($to,$email_subject,$email_message,$headers,"-f $from");
				@mail($to,$email_subject,$email_message,$headers);

			}
	//for fans

		$update_deal_flag=$dbObj->customqry("update tbl_deals set cron_flag='1' where deal_unique_id='".$res_deal['deal_unique_id']."'","");
}



$dbObj->Close();
?>