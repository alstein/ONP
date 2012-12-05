<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("8", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#


$deal_rs= $dbObj->cgs("tbl_deal","*","deal_unique_id",$_GET['id'],"","","");
$deal = @mysql_fetch_assoc($deal_rs);


########################code for to get progress bar minimum and maximum buyers ###################################


$sql_contri = "select sum(deal_quantity) as sum_contribute from tbl_deal_payment where deal_id = ".$_GET['id']." group by deal_id";
				$qry_contri = @mysql_query($sql_contri);
				$arr_contri = @mysql_fetch_assoc($qry_contri);
                                $test=$arr_contri['sum_contribute']+$deal['fake_user'];
                                if($test >= $deal['max_buyer'])
                                {    
                                        $test2=$test-$deal['max_buyer'];
                                        $total_contribution=$test-$test2;
                                }
                                else
                                {
				$total_contribution=$arr_contri['sum_contribute']+$deal['fake_user'];
                                }
                                $feed[$i]['total_val']=$total_contribution;
				if($total_contribution >= $deal['min_buyer'])
				{
				
				$feed[$i]['total_buy1']=1;
				} 
                               
				if($feed[$i]['total_val'] >= $deal['max_buyer'])
				{	
                                    
					$feed[$i]['deal_flag1']=2;	
					//$smarty->assign("deal_flag1","2");
				}
		// 		if($total_contribution<=$row['max_buyer'])
		// 		{
		// 		sold	
		// 		}
				$feed[$i]['bought']=$total_contribution;
				$orignal_bucket_value=$deal['max_buyer'];
				$complete=($total_contribution/$orignal_bucket_value)*100;
				$total=(100*$deal['min_buyer'])/$deal['max_buyer'];
				//$leftside=($total/100);
				$feed[$i]['progress']=round($complete);
		
				$prog = ($feed[$i]['progress']/100)*267;
				$px = (-2)+$prog;
				$feed[$i]['px']= $px;
				$left = ($total/100)*267;
				$proleft = $left-8;
				$feed[$i]['proleft']=$left;
				$feed[$i]['proleft1']=$proleft;
				$pwidth = ($feed[$i]['progress']/100)*267;
				$prowidth = 0+$pwidth;
				$feed[$i]['prowidth']=$prowidth;



#########################End of get progress bar ###################################################################





//echo "<pre>";print_r($deal);exit;

$quote = $dbObj->cgs("tbl_dealquate","*","dealid",$_GET['id'],"","","");
$quote_rs = @mysql_fetch_assoc($quote);
    
    if(isset($_POST['quote']))
    {
        $field = array(
            "dealid"=>$_GET['id'],
            "seller_id"=>$_POST['sellerid'],
             "admin_id"=>$_SESSION['duAdmId'],   
        "start_date"=>$_POST['dob1']." ".$_POST['start_hour'].":".$_POST['start_min'].":00",
	    "end_date"=>$_POST['dob2']." ".$_POST['end_hour'].":".$_POST['end_min'].":00",
            "final_value"=>$_POST['estimatedfees'],
            "listing_value"=>$_POST['listing'],
            "charged_percentage"=>$_POST['chargepercentage'],
            "posted_date"=>date('Y-m-d H:i:s')
        );
	
	

	if($quote == "n")
	{
            $quoteid=$dbObj->cgii("tbl_dealquate",$field,"");
	}
	else
	{
            $dbObj->cupdtii('tbl_dealquate',$field,"dealid = '{$_GET['id']}'","");
	}
       

        $mail_rs = $dbObj->cgs("mast_emails","","emailid",4,"","","");
        if($mail_rs != "n")
        {
		$image=array();
		$image=explode(",",$deal['medium_image']);
		
		$attach1 = SITEROOT_HTTPS."/deal/".$deal['url_title']."/dealpayment/";
		$link1 = '<a href="'.$attach1.'" target="_blank">Accepted</a>';	
		
// 		$attach2 = SITEROOT."/deal/".$quoteid."/quote-comment/";
		$attach2 = SITEROOT."/deal/".$deal['url_title']."/quote-comment/";
		$link2 = '<a href="'.$attach2.'" target="_blank">Comment On Quote</a>';
		
		$attach3 = SITEROOT."/deal/".$deal['url_title']."/deal-cancel/";
		$link3 = '<a href="'.$attach3.'" target="_blank">Cancel Deal</a>';
	
// 		$attach4 = SITEROOT."/admin/globalsettings/deal/preview-deal.php?id=".$_GET['id'];
		$attach4 =SITEROOT."/deal/".$deal['url_title']."/deal-preview/";

		$mail = mysql_fetch_assoc($mail_rs);
                
                $deal_tile=$deal['title'];
 		$title=substr($deal_tile,0,15);
		if($title !=$deal_tile)
	        {	
		$title.="..";
		}
		
		

		  // $old_date = $_POST['dob1'];             
                  // $middle = strtotime($old_date); 
                   //$start_date = date('d-M-Y', $middle);
		$start_date=date("l d F, Y \A\T h:i A",strtotime($_POST['dob1']." ".$_POST['start_hour'].":".$_POST['start_min'].":00"));
			$end_date=date("l d F, Y \A\T h:i A",strtotime($_POST['dob2']." ".$_POST['end_hour'].":".$_POST['end_min'].":00"));

		$user_rs = $dbObj->cgs("tbl_users","first_name,last_name,email","userid",$_POST['sellerid'],"","","");
		$user = @mysql_fetch_assoc($user_rs);
		$message = file_get_contents(SITEROOT."/email/quote.html");
		$message = str_replace("[SITEROOT]",SITEROOT,$message);
		$message = str_replace("[SUBJECT]", $mail['subject'],$message);
		$message = str_replace("[firstname]",$user['first_name'],$message);
		$message = str_replace("[lastname]",$user['last_name'],$message);
// 		$message = str_replace("[sdate]",$_POST['dob1']." ".$_POST['start_hour'].":".$_POST['start_min'],$message);
		$message = str_replace("[sdate]",$start_date,$message);
		//$message = str_replace("[edate]",$_POST['dob2']." ".$_POST['end_hour'].":".$_POST['end_min'],$message);
		$message = str_replace("[enddate]",$end_date,$message);
		$message = str_replace("[final_fees]",$_POST['estimatedfees'],$message);
		$message = str_replace("[listing_fees]",$_POST['listing'],$message);
		$message = str_replace("[charge_percentage]",$_POST['chargepercentage'],$message);
		$message = str_replace("[link1]",$attach1,$message);
		$message = str_replace("[link2]",$attach2,$message);
		$message = str_replace("[link3]",$attach3,$message);
		$message = str_replace("[link4]",$attach4,$message);
		$message = str_replace("[title]",$title,$message);
		$message = str_replace("[groupbuy_price]",$deal['groupbuy_price'],$message);
		$message = str_replace("[highlight]",wordwrap(stripslashes(html_entity_decode($deal['highlight'])),90,"<br />\n",TRUE),$message);
                $message = str_replace("[description]",wordwrap(stripslashes(html_entity_decode($deal['description'])),90,"<br />\n",TRUE),$message);
		$message = str_replace("[big_image]",$image[0],$message);	
		$message = str_replace("[posted_date]",$deal_info['posted_date'],$message);
                $message = str_replace("[gbi_comment]",utf8_decode(wordwrap(stripslashes(html_entity_decode($_POST['gbi_comment'])),90,"<br />\n",TRUE)),$message);	
		//$message = nl2br($message);
		$message = str_replace("[minimumbuyer]",$deal['min_buyer'],$message);
      $message = str_replace("[maximumbuyer]",$deal['max_buyer'],$message);
   
       $message = str_replace("[proleft1]",$proleft,$message);
      $message = str_replace("[proleft]",$left,$message);
      $message = str_replace("[prowidth]",$prowidth,$message); 
 		//echo $message;exit;
           
		$from = "Group Buy It <info@groupbuyit.com>";	

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From:'.$from . "\r\n";
    
            @mail($user['email'],$mail['subject'],$message,$headers);
	    //@mail("h3mang@gmail.com",$mail['subject'],$message,$headers);
	    //@mail("k.varad@agiletechnosys.com",$mail['subject'],$message,$headers);
	     //@mail("hemang@roundofplay.com",$mail['subject'],$message,$headers);	
		//@mail("shindepy@gmail.com",$mail['subject'],$message,$headers);
		//@mail("varad24287@gmail.com",$mail['subject'],$message,$headers);		
        }

        $field = array(
            "user_type"=>1,
            "from_id"=>$_SESSION['duAdmId'],
            "user_id"=>$_POST['sellerid'],
            "subject"=>$mail['subject'],
            "message"=>$message,
            "posted_date"=>date('Y-m-d H:i:s')
        );
        $dbObj->cgii("tbl_message",$field,"");


         #---notifications---#
        $field_notification = array(
            "userid"=>$_POST['sellerid'],
            "message"=>$mail['subject'],
            "date"=>date("Y-m-d")
        );
        $dbObj->cgii("tbl_notifications",$field_notification,"");
        #----end-----#

        $s=$msobj->showmessage(151);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

        header("Location:".SITEROOT."/admin/globalsettings/deal/view-deal.php");
        exit;
    }
    elseif(isset($_POST['edit']))
    {
        $cat_rs = $dbObj->gj("mast_deal_category","id","category = '".$_POST['category']."'","","","","","");
        if($cat_rs == "n")
        {
            $field = array("userid"=>$_SESSION['csUserId'],"category"=>$_POST['category'],"date"=>date('Y-m-d'),"parent_id"=>0,"category_type"=>$_POST['deal_type'],"active"=>1);
            $cat_id = $dbObj->cgii("mast_deal_category",$field,"");
        }
        else
        {
            $cat = mysql_fetch_assoc($cat_rs);
            $cat_id = $cat['id'];
        }
    
        $subcat_rs = $dbObj->gj("mast_deal_category","id","category = '".$_POST['subcategory']."'","","","","","");
        if($subcat_rs  == "n")
        {
            $field = array("userid"=>$_SESSION['csUserId'],"category"=>$_POST['subcategory'],"date"=>date('Y-m-d'),"parent_id"=>$cat_id,"category_type"=>$_POST['deal_type'],"active"=>1);
            $subcat_id = $dbObj->cgii("mast_deal_category",$field,"");
        }
        else
        {
            $subcat = mysql_fetch_assoc($subcat_rs);
            $subcat_id = $subcat['id'];
        }

        $shipping = "no";
        if(isset($_POST['shipping']))
        {
            $shipping = "yes";
        }
    
        $city=$_POST['shop_city'];
        $zip= $_POST['postcode'];
        if($_POST['postcode'] != "")
        {
            $p=explode(" ",$_POST['postcode']);
            if(strlen($p[0])>4)
            {
                $zip=$p[0][0].$p[0][1].$p[0][2].$p[0][3];
                $rs=$dbObj->cgs("zipData", "*", "zipcode", $zip, "", "", "");
                $row=@mysql_fetch_assoc($rs);
                $city=$row['city'];
                if(!$city)
                {
                    $zip=$p[0][0].$p[0][1].$p[0][2];
                    $rs=$dbObj->cgs("zipData", "*", "zipcode", $zip, "", "", "");
                    $row=@mysql_fetch_assoc($rs);
                    $city=$row['city'];
                }
            }
            else
            {
                $rs=$dbObj->cgs("zipData", "*", "zipcode",$p[0], "", "", "");
                $row=@mysql_fetch_assoc($rs);
                $city=$row['city'];
            }
        }
    
        $small_picture = $_SESSION['selectedimage']; 
        $medium_picture = $_SESSION['selectedimage']; 
        $big_picture = $_SESSION['selectedimage']; 
                
        $str     = $_POST['title'];
        $order   = array("(",")",":","$","#","@","%","^","*","[","]","&","{","}","|","/","+","!","~","`","?","<",":",",",">","'");
        $replace = '';
        $url_title = str_replace($order, $replace, $str);
        $title2=str_replace(" ","-",$url_title);
        if($_POST['optionoth'] == 'on')
        {$shipping1= "yes";}else{$shipping1= "no";}

       	//featured
if($_POST['3']== "")
{
$featured=0;
}
else
{
$featured=1;
}

//news letter subscription
if($_POST['10']== "")
{
$news_subscribe=0;
}
else
{
$news_subscribe=1;
}
		if($_POST['4']!= "" || $_POST['5']!= "")
		{
		       $page_featured='yes';
		}
		else
		{
		       $page_featured='no';
		}

        $field_array = array(
	    "deal_cat"=>$cat_id,
            "deal_subcat"=>$subcat_id,
            "deal_city"=>$city,
	    "title"=>$_POST['title1'],
            "description"=>$_POST['description'],
            "highlight"=>$_POST['highlight'],
            "fineprint"=>$_POST['fineprint'],
            "sub_delivery_cost"=>$_POST['delivery_cost'],
            "payment_method"=>$_POST['payment_type'],
            "vedio_link"=>$_POST['videolink'],
            "groupbuy_price"=>$_POST['price'],
            "orignal_price"=>$_POST['originalprice'],
            "quantity"=>$_POST['quantity'],
            "min_buyer"=>$_POST['min_buyer'],
            "max_buyer"=>$_POST['max_buyer'],
            "start_date"=>$_POST['dob1']." ".$_POST['start_hour'].":".$_POST['start_min'].":00",
            "end_date"=>$_POST['dob2']." ".$_POST['end_hour'].":".$_POST['end_min'].":00",
            "final_value"=>$_POST['estimatedfees'],
            "listing_value"=>$_POST['listing'],
            "option_selected"=>$_POST['option_selected'],
            "company_type"=>$_POST['sellertype'],
            "deal_type"=>$_POST['deal_type'],
            "option_website"=>$_POST['website'],
            "shop_location"=>$_POST['shop_addr'],
            "deal_address"=>$_POST['deal_addr'],
            "shipping_assitance"=>$shipping1,
            "featured"=>$featured,
             "featured_page"=>$page_featured,
	    "news_subscribe"=>$news_subscribe   		 
        );
//print_r($field_array);
        if($_POST['website'] != "")
        {
            $field_array = array_merge($field_array,array("option_website"=>$_POST['website']));
        }
        if($_POST['shop_addr'] != "")
        {
            $field_array = array_merge($field_array,array("shop_location"=>$_POST['shop_addr']));
        }

        $temp = $dbObj->cupdtii("tbl_deal",$field_array,"deal_unique_id='".$_GET['id']."'","");


       $field_per = array(
	      "dealid"=>$_GET['id'], 
            "charged_percentage"=>$_POST['chargepercentage'],
        );

	if($quote == "n")
	{
            $quoteid=$dbObj->cgii("tbl_dealquate",$field_per,"");
	}
	else
	{
            $dbObj->cupdtii('tbl_dealquate',$field_per,"dealid = '{$_GET['id']}'","");
	}


        
   



	header("location:".$_SERVER['HTTP_REFERER']);
        //header("Location:".SITEROOT."/admin/globalsettings/deal/view-deal.php");
        exit;
    }

    $i = 0;
    $hr = array();	
    for($hh = 0; $hh <=23; $hh++) 
    {
            if($hh<10)
                    $hh = "0$hh"; 
            else
                    $hh = $hh;
            $hr[$i] = $hh;
            $i++;
    }
    $rev_hr = array_reverse($hr);
    $smarty->assign("rev_hr",$rev_hr);
    $smarty->assign("hr",$hr);

    $i = 0;
    $min = array();	
    for($mm = 0; $mm <=59; $mm++) 
    {
            if($mm<10)
                    $mm = "0$mm"; 
            else
                    $mm = $mm;
            $min[$i] = $mm;
            $i++;
    }
    $rev_min = array_reverse($min);
    $smarty->assign("rev_min",$rev_min);
    $smarty->assign("min",$min);

    if(isset($_GET['id']))
    {
        $rs_quote = $dbObj->gj("tbl_dealquate","charged_percentage","dealid = '".$_GET['id']."'","","","","","");
        $deal_quote = @mysql_fetch_assoc($rs_quote);
        //echo "<pre>"; print_r($deal_quote);exit;
            $smarty->assign("deal_quote",$deal_quote);


       /* if($rs != "n")
        {
            $deal_info = mysql_fetch_assoc($rs);
            $smarty->assign("deal_info",$deal_info);
            $sdate = explode(" ",$deal_info['start_date']);
            $edate = explode(" ",$deal_info['end_date']);
            $smarty->assign("start_date",$sdate[0]);
            $smarty->assign("end_date",$edate[0]);
            $stime = explode(":",$sdate[1]);
            $etime = explode(":",$edate[1]);
            $smarty->assign("s_hr",$stime[0]);
            $smarty->assign("s_min",$stime[1]);
            $smarty->assign("e_hr",$etime[0]);
            $smarty->assign("e_min",$etime[1]);
        }
        else
        {*/
            $sf = "*";
            $cnd = "deal_unique_id = '".$_GET['id']."'";
            $rs = $dbObj->gj("tbl_deal",$sf,$cnd,"","","","","");
            if($rs != "n")
            {
                $deal_info = mysql_fetch_assoc($rs);
                $select1 =explode(",",$deal_info['option_selected']);
                if(in_array("6",$select1))
                $smarty->assign("flag1","1");
                if(in_array("7",$select1))
                $smarty->assign("flag2","2");
                
            }
		
//             $gbi_comment="Listing Fee for your deal will be <strong>£".$deal_info['listing_value']."<strong> and Final Value Fee will be <strong>£".$deal_info['final_value']."<strong>.<br/> 
//         You will be charged <strong>£".$deal_quote['charged_percentage']."%<strong>  of the transaction";   
//&pound;
            $gbi_comment="Listing Fee for your deal will be ".$deal_info['listing_value']." and Final Value Fee will be ".$deal_info['final_value'].". You will be charged ".$deal_quote['charged_percentage']."% of the transaction";    
 
            $smarty->assign("product",$deal_info);
             $smarty->assign("gbi_comment",$gbi_comment);    
            $sdate = explode(" ",$deal_info['start_date']);
            $edate = explode(" ",$deal_info['end_date']);
            $smarty->assign("start_date",$sdate[0]);
            $smarty->assign("end_date",$edate[0]);
            $stime = explode(":",$sdate[1]);
            $etime = explode(":",$edate[1]);
            $smarty->assign("s_hr",$stime[0]);
            $smarty->assign("s_min",$stime[1]);
            $smarty->assign("e_hr",$etime[0]);
            $smarty->assign("e_min",$etime[1]);

            //make selected option array
            $opt = explode(",",$deal_info['option_selected']);
            $smarty->assign("opt",$opt);

            //make selected payment option
            $pay = explode(",",$deal_info['payment_method']);
            $smarty->assign("pay",$pay);

            //get deal category
            $cat_rs = $dbObj->gj("mast_deal_category","category","id='".$deal_info['deal_cat']."'","","","","","");
            $cat = @mysql_fetch_assoc($cat_rs);
            $smarty->assign("category",$cat['category']);

            //get deal subcategory
            $subcat_rs = $dbObj->gj("mast_deal_category","category","id='".$deal_info['deal_subcat']."'","","","","","");
            $subcat = @mysql_fetch_assoc($subcat_rs);
            $smarty->assign("subcategory",$subcat['category']);

            //-------------------get sellet type option-------------------------//
            $seller_rs = $dbObj->gj("tbl_users","company_type","userid = '".$deal_info['seller_id']."'","","","","","");
            if($seller_rs != "n")
            {
                $seller = mysql_fetch_assoc($seller_rs);
            }
            $smarty->assign("seller_type",$seller['company_type']);

            $selleropt_rs = $dbObj->gj("tbl_seller_type","*","seller_type_id='".$seller['company_type']."'","","","","","");
            if($selleropt_rs != "n")
            {
                $selleropt = mysql_fetch_assoc($selleropt_rs);
            }

            $sto=$dbObj->customqry("select * from tbl_sellertype_option where sell_id != '11'","");
            $i=0;
            while($row1=@mysql_fetch_array($sto))
            {
                $selleroption1[]=$row1;
            }
            //echo "<pre>"; print_r($selleroption1); echo "</pre>";
            $smarty->assign("selleroption",$selleroption1);
	
	    //-------------------end get sellet type option-------------------------//

            $payment_rs = $dbObj->gj("tbl_billing_info","*","user_id='".$deal_info['seller_id']."'","","","","","");

            while($row = @mysql_fetch_assoc($payment_rs))
            {
                $payment[] = $row;
            }

            $smarty->assign("payment",$payment);
        //}
    }
    //$smarty->debugging = true;
    $smarty->display(TEMPLATEDIR.'/admin/globalsettings/deal/deal-quote.tpl'); 
    $dbObj->Close();
?>
