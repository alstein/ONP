<?php
include_once('../../include.php');
if($_GET['sp']== "")
{
    if(!isset($_SESSION['csUserId']) && !isset($_SESSION['csUserTypeid']))
    {
        header("location:".SITEROOT); exit;
    }
}

$select=$dbObj->customqry("select u.first_name,u.last_name,u.city,m.city_name,u.business_name from tbl_users u  left join mast_city m on u.city=m.city_id where u.userid='".$_SESSION['merchant_id']."'",'');
$res_select=@mysql_fetch_assoc($select);
$smarty->assign("deal",$res_select);

if(isset($_POST['Submit']))
{
    $merchant_id=$_SESSION['merchant_id'];
    $category=$_SESSION['deal_category'];
    $deal_name=$_SESSION['deal_title'];
    $originalprice=$_SESSION['original_price'];
    $sel_off=$_SESSION['discount_in_per'];
    $discount=$_SESSION['discount'];
    $offer_price=$_SESSION['offer_price'];
    $why_buy1=$_SESSION['why_buy1'];
    $why_buy2=$_SESSION['why_buy2'];
    $why_buy3=$_SESSION['why_buy3'];
    $why_buy4=$_SESSION['why_buy4'];
    $why_buy5=$_SESSION['why_buy5'];
    $condition=$_SESSION['conditions'];
    $lastdate=$_SESSION['deal_end_date'];
    $redeemfrom=$_SESSION['redeem_from'];
    $redeemto=$_SESSION['redeem_to'];
    $original_1=$_SESSION['deal_image'];
    $original_2=$_SESSION['deal_image1'];
    $original_3=$_SESSION['deal_image2'];
    $fan_only=$_SESSION['send_to_fan'];
    $all=$_SESSION['send_to_all'];
    $condition=$_SESSION['conditions'];
    $max_number=$_SESSION['max_deal_no'];
    $address=$_SESSION['valid_at_address'];
    $offer_details=$_SESSION['offer_details'];
    $shippingstatus=$_SESSION['shippingstatus'];
    if($fan_only!="" && $all!="")
    {
        $send_to=$fan_only.",".$all;
    }
    elseif($fan_only!="")
    {
        $send_to=$fan_only;
    }
    elseif($all!="")
    {
        $send_to=$all;
    }
    $fl = array("merchant_id","deal_category","deal_title","original_price","discount_in_per","discount",'offer_price','why_buy1','why_buy2',"why_buy3","why_buy4","why_buy5","conditions",'deal_end_date','redeem_from', "redeem_to","deal_image",'send_to',"posted_date",'status','max_deal_no','valid_at_address','offer_details','shippingstatus',"deal_image1","deal_image2");
    $vl = array($merchant_id,$category,$deal_name,$originalprice,$sel_off,$discount,$offer_price,$why_buy1,$why_buy2,$why_buy3,$why_buy4,$why_buy5,$condition,$lastdate,$redeemfrom,$redeemto,$original_1,$send_to,date("Y-m-d H:i:s"),"active",$max_number,$address,$offer_details,$shippingstatus,$original_2,$original_3);
    $resIns = $dbObj->cgi('tbl_deals',$fl,$vl,'');
    $_SESSION['msg']="Deal Added Successfully";
    if($resIns!="")
    {
        $_SESSION['merchant_id']="";
        $_SESSION['deal_category']="";
        $_SESSION['deal_title']="";
        $_SESSION['original_price']="";
        $_SESSION['discount_in_per']="";
        $_SESSION['discount']="";
        $_SESSION['offer_price']="";
        $_SESSION['why_buy1']="";
        $_SESSION['why_buy2']="";
        $_SESSION['why_buy3']="";
        $_SESSION['why_buy4']="";
        $_SESSION['why_buy5']="";
        $_SESSION['conditions']="";
        $_SESSION['deal_end_date']="";
        $_SESSION['redeem_from']="";
        $_SESSION['redeem_to']="";
        $_SESSION['deal_image']="";
        $_SESSION['deal_image1']="";
        $_SESSION['deal_image2']="";
        $_SESSION['send_to_fan']="";
        $_SESSION['send_to_all']="";
        $_SESSION['max_deal_no']="";
        $_SESSION['valid_at_address']="";
        $_SESSION['view_success_message']="1";
    }

    
    // mail code... temporary for test.. need to be removed after testing...
    $select_deal=$dbObj->customqry("select d.*, u.fullname, u.userid, u.business_name, u.deal_cat from tbl_deals d left join tbl_users u on d.merchant_id=u.userid where d.cron_flag='0'",'');
    while($res_deal=@mysql_fetch_assoc($select_deal))
    {
        //category preferance
	$sel_user=$dbObj->customqry("select * from tbl_users where usertypeid = 2 and deal_by_email='yes'",'');
        if(mysql_num_rows($sel_user) > 0) {
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
                $email_message = str_replace("[[Val]]",number_format($res_deal['offer_price'],1),$email_message);
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
                //echo "-->".$email_message;
                //@mail($to,$email_subject,$email_message,$headers,"-f $from");
                @mail($to,$email_subject,$email_message,$headers);
            }
            //category preferance
        }
        //for fans
        //echo "==>".$res_deal['userid'];
        //	echo "==>".$res_deal['deal_cat'];
        /*$tbl="tbl_fan f left join tbl_users u on f.fan_id=u.userid";
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
        */
        $update_deal_flag=$dbObj->customqry("update tbl_deals set cron_flag='1' where deal_unique_id='".$res_deal['deal_unique_id']."'",'');
    }

/////////////////////////////////////////
    
    //@header("Location:".SITEROOT."/deal/create_deal");
    @header("Location:".SITEROOT."/merchant-account/merchant_profile_home/");
}

$smarty->display(TEMPLATEDIR . '/modules/deal/view_deal.tpl');
$dbObj->Close();
?>