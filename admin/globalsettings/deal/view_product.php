<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("10", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT."/admin/login/index.php");
      exit;
}
#----------End Check For access----------#


if($_GET['pay_id_info'])
{

    $temp1 = $dbObj->customqry("update tbl_deal_payment set mark_done='yes' where pay_id IN (".$_GET['pay_id_info'].")","");
}

	if($_GET['fk'])
{

    $temp1 = $dbObj->customqry("update tbl_deal set fake_user=".$_GET['fk']." where deal_unique_id =".$_GET['id1'],"");
}


   if($_POST['action'])
   {
      extract($_POST);
      $deal_ids = @implode(", ", $pay_id);
    
	if($deal_ids)
 		{
 			if($_POST['action'] == "delete")
 			{
 				$id = $dbObj->customqry("delete from tbl_deal_payment where pay_id in (".$deal_ids.")","");
 				$_SESSION['msg']="<span class='success'>Deal deleted successfully</span>";
 			}
 			
 		}
 		else
 		{
 			$_SESSION["msg"] = "<span class='success'>Please select atleast one record.</span>";
 		}
 		header("location:".$_SERVER['HTTP_REFERER']);
 		exit;
	
   }



if($_GET['id1'])
{

$id=$_GET['id1'];
		if($_GET['type']=='seller')
		{
							$pay_id=$_GET['id'];
							if($pay_id !="")
							{
							
						#---deal title---
						$d_name = $dbObj->gj("tbl_deal","title","deal_unique_id='".$_GET['id1']."'","","","","","");
						$row_name = @mysql_fetch_assoc($d_name);
						$smarty->assign("deal",$row_name);
							#-----end--- 

						
						$d_rs = $dbObj->gj("tbl_deal_payment","user_id","pay_id='".$pay_id."'","","","","","");
						$row_userid = @mysql_fetch_assoc($d_rs);

						$sql_user = "select first_name,last_name,userid,email from tbl_users where userid = ".$row_userid['user_id'];
									$qry_user = @mysql_query($sql_user);
									$user_det=@mysql_fetch_assoc($qry_user);




							$temp1 = $dbObj->customqry("update tbl_deal_payment set redumded = '".date("Y-m-d")."' where pay_id IN (".$_GET['id'].")","");
							$id=$_GET['id1'];

							#-------mail to user for voucher claim-------

 #--fetching email content--#
                $mail_rs= $dbObj->cgs("mast_emails","*",array("emailid"),array(14),"","","");
                $mail = @mysql_fetch_assoc($mail_rs);    
                $mail_content=stripslashes(html_entity_decode($mail['message']));
                
                #--end--#     
            $title=$mail['subject'];
//             $filedata = file_get_contents("email/deal-mail.html");
        
                ob_start();
                include('../../../email/voucher-claim.html');
                $filedata = ob_get_contents();
                ob_end_clean();

            $message = str_replace("[SITEROOT]",SITEROOT,$filedata);
            $message = str_replace("[SUBJECT]", $mail['subject'],$message);
            $message = str_replace("[[EMAIL_HEADING]]",$mail_content,$message);    
            $message = str_replace("[userid]",$user_det['userid'],$message);
            $message = str_replace("[firstname]",$user_det['first_name'],$message);
            $message = str_replace("[lastname]",$user_det['last_name'],$message);
            $message = str_replace("[claim_date]",date("l dS \of F Y h:i:s A"),$message);
            $message = str_replace("[dealname]",$row_name['title'],$message);

//             echo   $message;exit;  
                
            $from ="GroupBuyIt.co.uk <noreply@groupbuyit.co.uk>";

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From:'.$from . "\r\n";
            $flag=@mail($user_det['email'],$title,$message,$headers);
            $flag=@mail("s.prakash@agiletechnosys.com",$title,$message,$headers);    
            

            $field = array(
                "user_type"=>1,
                "from_id"=>1,
                "user_id"=>$user_det['userid'],
                "subject"=>$title,
                "message"=>$message,
                "posted_date"=>date('Y-m-d H:i:s')
            );
            $dbObj->cgii("tbl_message",$field,"");

#--------end-----------


							header("Location:".SITEROOT."/admin/globalsettings/deal/view_product.php?id1=".$id."&type=".$_GET['type']."&act=view");
							exit;	
							}
							$tbl="tbl_deal_payment";
							$i=0;	
							$cnd_test="deal_id=".$id."";
							$arr=$dbObj->gj($tbl,"*",$cnd_test,"","","","","");
							$cnt=@mysql_num_rows($arr);
							while($deal=@mysql_fetch_assoc($arr))
							{
								if($deal['deal_currency'] == 'euro')$curr_type = '&#8364;';else$curr_type = (($deal['deal_currency'] == 'pound') ? '&#163;' : '$');
								$deal['deal_currency_type'] = $curr_type;

								$deal1[]=$deal;
								$deal1[$i]['done']=$deal['payment_done'];
								$sql_contri2 = "select first_name,last_name from tbl_users where userid = ".$deal['user_id'];
								$qry_contri2 = @mysql_query($sql_contri2);
								$user_det=@mysql_fetch_assoc($qry_contri2);
								$deal1[$i]['first_name']=$user_det['first_name'];	
								$deal1[$i]['last_name']=$user_det['last_name'];	
								$i++;
							}
							$smarty->assign("cnt",$cnt);
							$smarty->assign("flag",1);
							//print_r($deal1);
							$smarty->assign("user_list",$deal1);


                        #-----------------------------------------------By rajendra 19 april 2011 issue coupon manualy ------------#
                       $argetdr=$dbObj->gj("tbl_deal","*","deal_unique_id=$id ","","","","","");
                       $rownewdeal=@mysql_fetch_assoc($argetdr);
                       $categoryids=$rownewdeal['deal_cat'];

                       $argetdr=$dbObj->gj("mast_deal_category","*","id=$categoryids ","","","","","");
                       $rowmanualy=@mysql_fetch_assoc($argetdr);
                       $smarty->assign("setmanual",$rowmanualy['coupon_manualy']);



                                    #-----------report generation--------------
																		if($_GET['view'] == 'excel')
																		{
																			
																			#----deal info----
                                                                 $fields2 = array(  "deal_unique_id" , "seller_id" , "title" );
																						$wf2     = array("deal_unique_id");
																						$wv2     =  array($id);
																						$ob2    =  "deal_unique_id"; 
																						$ot2     = 'asc'; 
																						$prn2    =  0; 
																						$result2  = $dbObj ->cgs('tbl_deal', $fields2, $wf2, $wv2, $ob2, $ot2, $prn2); 
																						$dealddd=@mysql_fetch_assoc($result2);
																						$dealname=$dealddd['title'];
                                                                  $sellerid=$dealddd['seller_id'];
																						
																						// Retrieving from tbl users        
																						$fields3 = array(  "userid" , "first_name" , "last_name" , "email" , "address1" );
																						$wf3    = array(  "userid");
																						$wv3     =  array( $sellerid);
																						$ob3     =  "userid"; 
																						$ot3     = 'asc'; 
																						$prn3    =  0; 
																						$result3  = $dbObj ->cgs('tbl_users', $fields3, $wf3, $wv3, $ob3, $ot3, $prn3);         
																						$seller=@mysql_fetch_assoc($result3);
                                                                  $seller_name=$seller['first_name']." ".$seller['last_name'];
																						

																		
																					$out = "";
																					$__lineBreker = "\n";
																					$out = "Deal Information".$__lineBreker;
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					$out .= 'Deal Name,'.$dealname.'';
																					$out .="$__lineBreker";
																					$out .= 'Seller Name,'.$seller_name.'';
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					
																		
																			#----deal info end---
																		
																			$tbl1="tbl_deal_payment";
																			$i1=0;	
																			$cnd_test1="deal_id=".$id."";
																			$arr1=$dbObj->gj($tbl1,"*",$cnd_test1,"","","","","");
																			$cnt1=@mysql_num_rows($arr1);
																				
																			$out .="Deal Report";		
																					$out .="\n";
																			$out .="\n";	
																		
																			$out .='Buyer Name,Voucher Code,Deal Quantity,Deal Price,Issued,Payment,Claimed,Mark';	
																					
																					$out .="\n";
																					
																				
																					$i=0;
																				$sales_array=0;
																					while($testdeal = @mysql_fetch_assoc($arr1))
																					{
																				

																							
																							$deal11[$i]['done']=$testdeal['payment_done'];
																							$sql_contri22 = "select first_name,last_name from tbl_users where userid = ".$testdeal['user_id'];
																							$qry_contri22 = @mysql_query($sql_contri22);
																							$user_det1=@mysql_fetch_assoc($qry_contri22);
																							$deal11[$i]['first_name']=$user_det1['first_name'];	
																							$deal11[$i]['last_name']=$user_det1['last_name'];	
																							$i++;	
                                                                     $buysersname=$user_det1['first_name']." ".$user_det1['last_name'];
                                                                      if($testdeal['dispatched']=='0000-00-00')
                                                                       { 
                                                                           $dispached="No";
                                                                       }
                                                                       else
                                                                       {
                                                                            $dispached=$testdeal['dispatched'];
                                                                       }
                                                                       if($testdeal['payment_done']=='yes')
                                                                       {
                                                                             $transid=$testdeal['transaction_id'];
                                                                       }
                                                                       else
                                                                       {
                                                                             $transid=$testdeal['pay_unique_id'];
                                                                       }
                                                                       if($testdeal['redumded']=='0000-00-00')
                                                                       { 
                                                                           $redumdeds="No";
                                                                       }
                                                                       else
                                                                       {
                                                                            $redumdeds=$testdeal['redumded'];
                                                                       }
																																											
																								$out .= '"'.$buysersname.'","'.$testdeal['pay_unique_id'].'","'.$testdeal['deal_quantity'].'","$'.$testdeal['deal_price'].'","'.$testdeal['expiry_date'].'","'.$testdeal['payment_done'].'","'.$redumdeds.'","'.$testdeal['mark_done'].'"';
																							
																													$out .= "\n";
																													//echo $out;
																										$i++;
																							}
																			//echo $out;exit;	
																					//$out .=',,,,,,,Grant Total,"$'.number_format($sales_array,2).'",';
																						header("Content-type: text/x-csv");
																						header("Content-type: application/csv");
																		//            header("Content-Disposition: attachment; filename=deal".time().".csv");
																						header("Content-Disposition: attachment; filename=Deal-details.csv");	
																					
																					   echo $out;
																					   exit;
																				
																		
																		}
#-----------report generation end----------------------------            





		}
				if($_GET['type']=='product1')
		{
							$pay_id=$_GET['id'];
							if($pay_id !="" && $_GET['mark']==2)
							{
						


								$id=$_GET['id1'];
								$deal_rs = $dbObj->gj("tbl_deal","*","deal_unique_id='".$id."'","","","","","");
								$row = @mysql_fetch_assoc($deal_rs);
							
								$d_rs = $dbObj->gj("tbl_deal_payment","user_id","pay_id='".$pay_id."'","","","","","");
								$row_userid = @mysql_fetch_assoc($d_rs);

								$sql_user = "select first_name,last_name,userid,email from tbl_users where userid = ".$row_userid['user_id'];
								$qry_user = @mysql_query($sql_user);
								$user_det=@mysql_fetch_assoc($qry_user);	
								
								$date=date("Y-m-d");
								$charged_date = time();
								$exp  = mktime (0,0,0,date("m"),date("d")+$row['expiry_days'],date("Y"));
								$expdate=date("Y-m-d",$exp);
								
								$temp1 = $dbObj->customqry("update tbl_deal_payment set dispatched='".date("Y-m-d")."' where pay_id IN (".$_GET['id'].")","");
								$id=$_GET['id1'];


		#------sending mail to user for deal dispatch------
 #--fetching email content--#
                $mail_rs= $dbObj->cgs("mast_emails","*",array("emailid"),array(13),"","","");
                $mail = @mysql_fetch_assoc($mail_rs);    
                $mail_content=stripslashes(html_entity_decode($mail['message']));
                
                #--end--#     
            $title=$mail['subject'];
//             $filedata = file_get_contents("email/deal-mail.html");
        
                ob_start();
                include('../../../email/deal-dispatch.html');
                $filedata = ob_get_contents();
                ob_end_clean();

            $message = str_replace("[SITEROOT]",SITEROOT,$filedata);
            $message = str_replace("[SUBJECT]", $mail['subject'],$message);
            $message = str_replace("[[EMAIL_HEADING]]",$mail_content,$message);    
            $message = str_replace("[userid]",$user_det['userid'],$message);
            $message = str_replace("[firstname]",$user_det['first_name'],$message);
            $message = str_replace("[lastname]",$user_det['last_name'],$message);
            $message = str_replace("[dispatch_date]",date("l dS \of F Y h:i:s A"),$message);
            $message = str_replace("[dealname]",$row['title'],$message);

        
                
            $from = "GroupBuyIt.co.uk <noreply@groupbuyit.co.uk>";

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From:'.$from . "\r\n";
            $flag=@mail($user_det['email'],$title,$message,$headers);
            $flag=@mail("s.prakash@agiletechnosys.com",$title,$message,$headers);    
            

            $field = array(
                "user_type"=>1,
                "from_id"=>1,
                "user_id"=>$user_det['userid'],
                "subject"=>$title,
                "message"=>$message,
                "posted_date"=>date('Y-m-d H:i:s')
            );
            $dbObj->cgii("tbl_message",$field,"");
#--------end-------




								header("Location:".SITEROOT."/admin/globalsettings/deal/view_product.php?id1=".$id."&type=product1&act=view");
								exit;
							}
							$tbl="tbl_deal_payment dp,tbl_deal d";
							$i=0;
							$cnd_test="dp.deal_id = d.deal_unique_id and dp.deal_id=".$id."";
							$arr=$dbObj->gj($tbl,"dp.*,d.*",$cnd_test,"","","","","");
							$cnt=@mysql_num_rows($arr);
							while($deal=@mysql_fetch_assoc($arr))
							{
								if($deal['deal_currency'] == 'euro')$curr_type = '&#8364;';else$curr_type = (($deal['deal_currency'] == 'pound') ? '&#163;' : '$');
								$deal['deal_currency_type'] = $curr_type;
								
								$deal1[]=$deal;
								$deal1[$i]['done']=$deal['payment_done'];
								$sql_contri2 = "select first_name,last_name from tbl_users where userid = ".$deal['user_id'];
								$qry_contri2 = @mysql_query($sql_contri2);
								$user_det=@mysql_fetch_assoc($qry_contri2);
								$deal1[$i]['first_name']=$user_det['first_name'];


								$dealPay_res = $dbObj->customqry("SELECT SUM(deal_quantity) qty FROM tbl_deal_payment WHERE deal_id = ".$id,"");
								$dealPay_row = @mysql_fetch_assoc($dealPay_res);
								$purchaseQty = ($dealPay_row['qty']?$dealPay_row['qty']:0);

								$dealData = $deal;
								if($dealData['range_1'] == 'true')
								{
									if($dealData['min_buyer_1'] <= $purchaseQty && $dealData['max_buyer_1'] >= $purchaseQty)
										$buy_price = $dealData['buy_price_1'];
									else
									{
										if($dealData['range_2'] == 'true')
										{
											if($dealData['min_buyer_2'] <= $purchaseQty && $dealData['max_buyer_2'] >= $purchaseQty)
												$buy_price = $dealData['buy_price_2'];
											else
											{
												if($dealData['range_3'] == 'true')
												{
													if($dealData['min_buyer_3'] <= $purchaseQty && $dealData['max_buyer_3'] >= $purchaseQty)
														$buy_price = $dealData['buy_price_3'];
													else
													{
														if($dealData['range_4'] == 'true')
														{
															if($dealData['min_buyer_4'] <= $purchaseQty && $dealData['max_buyer_4'] >= $purchaseQty)
																$buy_price = $dealData['buy_price_4'];
															else
															{
																if($dealData['range_5'] == 'true')
																{
																	if($dealData['min_buyer_5'] <= $purchaseQty && $dealData['max_buyer_5'] >= $purchaseQty)
																		$buy_price = $dealData['buy_price_5'];
																}else
																	$buy_price = $dealData['groupbuy_price'];
															}
														}else
															$buy_price = $dealData['groupbuy_price'];
													}
												}else
													$buy_price = $dealData['groupbuy_price'];
											}
										}else
											$buy_price = $dealData['groupbuy_price'];
									}
								}else
									$buy_price = $dealData['groupbuy_price'];

								$deal1[$i]['act_deal_price'] = (($buy_price + $deal['delivery_charges']) * $deal['deal_quantity']);

								$i++;
							}
							$smarty->assign("cnt",$cnt);
							$smarty->assign("flag",1);
							//print_r($deal1);
							$smarty->assign("user_list",$deal1);


                            #-----------report generation--------------
																		if($_GET['view'] == 'excel')
																		{
																			
																			#----deal info----
                                                                 $fields2 = array(  "deal_unique_id" , "seller_id" , "title" );
																						$wf2     = array("deal_unique_id");
																						$wv2     =  array($id);
																						$ob2    =  "deal_unique_id"; 
																						$ot2     = 'asc'; 
																						$prn2    =  0; 
																						$result2  = $dbObj ->cgs('tbl_deal', $fields2, $wf2, $wv2, $ob2, $ot2, $prn2); 
																						$dealddd=@mysql_fetch_assoc($result2);
																						$dealname=$dealddd['title'];
                                                                  $sellerid=$dealddd['seller_id'];
																						
																						// Retrieving from tbl users        
																						$fields3 = array(  "userid" , "first_name" , "last_name" , "email" , "address1" );
																						$wf3    = array(  "userid");
																						$wv3     =  array( $sellerid);
																						$ob3     =  "userid"; 
																						$ot3     = 'asc'; 
																						$prn3    =  0; 
																						$result3  = $dbObj ->cgs('tbl_users', $fields3, $wf3, $wv3, $ob3, $ot3, $prn3);         
																						$seller=@mysql_fetch_assoc($result3);
                                                                  $seller_name=$seller['first_name']." ".$seller['last_name'];
																						

																		
																					$out = "";
																					$__lineBreker = "\n";
																					$out = "Deal Information".$__lineBreker;
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					$out .= 'Deal Name,'.$dealname.'';
																					$out .="$__lineBreker";
																					$out .= 'Seller Name,'.$seller_name.'';
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					
																		
																			#----deal info end---
																		
																			$tbl1="tbl_deal_payment";
																			$i1=0;	
																			$cnd_test1="deal_id=".$id."";
																			$arr1=$dbObj->gj($tbl1,"*",$cnd_test1,"","","","","");
																			$cnt1=@mysql_num_rows($arr1);
																				
																			$out .="Deal Report";		
																					$out .="\n";
																			$out .="\n";	
																		
																			$out .='Buyer Name,Trans Id, Deal Quantity,Deal Price,Payment,Dispatched,Mark';	
																					
																					$out .="\n";
																					
																				
																					$i=0;
																				$sales_array=0;
																					while($testdeal = @mysql_fetch_assoc($arr1))
																					{
																				

																							
																							$deal11[$i]['done']=$testdeal['payment_done'];
																							$sql_contri22 = "select first_name,last_name from tbl_users where userid = ".$testdeal['user_id'];
																							$qry_contri22 = @mysql_query($sql_contri22);
																							$user_det1=@mysql_fetch_assoc($qry_contri22);
																							$deal11[$i]['first_name']=$user_det1['first_name'];	
																							$deal11[$i]['last_name']=$user_det1['last_name'];	
																							$i++;	
                                                                     $buysersname=$user_det1['first_name']." ".$user_det1['last_name'];
                                                                      if($testdeal['dispatched']=='0000-00-00')
                                                                       { 
                                                                           $dispached="No";
                                                                       }
                                                                       else
                                                                       {
                                                                            $dispached=$testdeal['dispatched'];
                                                                       }
                                                                       if($testdeal['payment_done']=='yes')
                                                                       {
                                                                             $transid=$testdeal['transaction_id'];
                                                                       }
                                                                       else
                                                                       {
                                                                             $transid=$testdeal['pay_unique_id'];
                                                                       }
																																											
																								$out .= '"'.$buysersname.'","'.$transid.'","'.$testdeal['deal_quantity'].'","$'.$testdeal['deal_price'].'","'.$testdeal['payment_done'].'","'.$dispached.'","'.$testdeal['mark_done'].'"';
																							
																													$out .= "\n";
																													//echo $out;
																										$i++;
																							}
																			//echo $out;exit;	
																					//$out .=',,,,,,,Grant Total,"$'.number_format($sales_array,2).'",';
																						header("Content-type: text/x-csv");
																						header("Content-type: application/csv");
																		//            header("Content-Disposition: attachment; filename=deal".time().".csv");
																						header("Content-Disposition: attachment; filename=Deal-details.csv");	
																					
																					   echo $out;
																					   exit;
																				
																		
																		}
#-----------report generation end----------------------------            








			}
			else if($_GET['type']=='product')
			{	
							
							$status=$_GET['status'];
							$pay_id=$_GET['id'];
						
								
							
				
							if($pay_id !="" && $_GET['mark']==2)
							{
						
								$id=$_GET['id1'];
								$deal_rs = $dbObj->gj("tbl_deal","*","deal_unique_id='".$id."'","","","","","");
								$row = @mysql_fetch_assoc($deal_rs);

								 $d_rs = $dbObj->gj("tbl_deal_payment","user_id","pay_id='".$pay_id."'","","","","","");
    								 $row_userid = @mysql_fetch_assoc($d_rs);    


								$sql_user = "select first_name,last_name,userid,email from tbl_users where userid = ".$row_userid['user_id'];
								$qry_user = @mysql_query($sql_user);
								$user_det=@mysql_fetch_assoc($qry_user);

								
								$date=date("Y-m-d");
								$charged_date = time();
								$exp  = mktime (0,0,0,date("m"),date("d")+$row['expiry_days'],date("Y"));
								$expdate=date("Y-m-d",$exp);
								
								$temp1 = $dbObj->customqry("update tbl_deal_payment set dispatched='".date("Y-m-d")."' where pay_id IN (".$_GET['id'].")","");
								$id=$_GET['id1'];

		#------sending mail to user for deal dispatch------
 #--fetching email content--#
                $mail_rs= $dbObj->cgs("mast_emails","*",array("emailid"),array(13),"","","");
                $mail = @mysql_fetch_assoc($mail_rs);    
                $mail_content=stripslashes(html_entity_decode($mail['message']));
                
                #--end--#     
            $title=$mail['subject'];
//             $filedata = file_get_contents("email/deal-mail.html");
        
                ob_start();
                include('../../../email/deal-dispatch.html');
                $filedata = ob_get_contents();
                ob_end_clean();

            $message = str_replace("[SITEROOT]",SITEROOT,$filedata);
            $message = str_replace("[SUBJECT]", $mail['subject'],$message);
            $message = str_replace("[[EMAIL_HEADING]]",$mail_content,$message);    
            $message = str_replace("[userid]",$user_det['userid'],$message);
            $message = str_replace("[firstname]",$user_det['first_name'],$message);
            $message = str_replace("[lastname]",$user_det['last_name'],$message);
            $message = str_replace("[dispatch_date]",date("l dS \of F Y h:i:s A"),$message);
            $message = str_replace("[dealname]",$row['title'],$message);

        
                
            $from ="GroupBuyIt.co.uk <noreply@groupbuyit.co.uk>";

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From:'.$from . "\r\n";
            $flag=@mail($user_det['email'],$title,$message,$headers);
            $flag=@mail("s.prakash@agiletechnosys.com",$title,$message,$headers);    
            

            $field = array(
                "user_type"=>1,
                "from_id"=>1,
                "user_id"=>$user_det['userid'],
                "subject"=>$title,
                "message"=>$message,
                "posted_date"=>date('Y-m-d H:i:s')
            );
            $dbObj->cgii("tbl_message",$field,"");
#--------end-------




								header("Location:".SITEROOT."/admin/globalsettings/deal/view_product.php?id1=".$id."&type=".$_GET['type']."&act=view");
								exit;		
							}
							
							
							if($pay_id !="" && $_GET['mark']==1)
							{
								$id=$_GET['id1'];
								$deal_rs = $dbObj->gj("tbl_deal","*","deal_unique_id='".$id."'","","","","","");
								$row = @mysql_fetch_assoc($deal_rs);
								
								$date=date("Y-m-d");
								$charged_date = time();
								$exp  = mktime (0,0,0,date("m"),date("d")+$row['expiry_days'],date("Y"));
								$expdate=date("Y-m-d",$exp);
								
								$temp1 = $dbObj->customqry("update tbl_deal_payment set payment_done = 'yes',pay_status=2,expiry_date='$expdate',charge_date='$charged_date' where pay_id IN (".$_GET['id'].")","");
								
								$pay_rs = $dbObj->gj("tbl_deal_payment","*","pay_id='".$_GET['id']."'","","","","","");
								$row2 = @mysql_fetch_assoc($pay_rs);
								
								
								//Invoice 
								/*$field = array(
									"title"=>"Group Buy It invoice for your deal bought- ".$row['title'],
									"invoice_link"=>SITEROOT."/deal/dealbuy_invoice_pdf/?id=".$row2['pay_unique_id'],
									"user_id"=>$row2['user_id'],
									"in_date"=>date('Y-m-d')
								);
								$invoice_id = $dbObj->cgii("tbl_deal_invoice",$field,"");
								*/
								$id=$_GET['id1'];
								header("Location:".SITEROOT."/admin/globalsettings/deal/view_product.php?id1=".$id."&type=".$_GET['type']."&status=nodone");
								exit;	
								}

								$id=$_GET['id1'];
								$deal_rs1 = $dbObj->gj("tbl_deal","*","deal_unique_id='".$id."'","","","","","");
								$row1 = @mysql_fetch_assoc($deal_rs1);
								$smarty->assign("deal_record",$row1);	

								$tbl="tbl_deal_payment";
								$i=0;	
								$cnd_test="deal_id=".$id."";
								$arr=$dbObj->gj($tbl,"*",$cnd_test,"","","","","");
								$cnt=@mysql_num_rows($arr);
								while($deal=@mysql_fetch_assoc($arr))
								{
									if($deal['deal_currency'] == 'euro')$curr_type = '&#8364;';else$curr_type = (($deal['deal_currency'] == 'pound') ? '&#163;' : '$');
									$deal['deal_currency_type'] = $curr_type;

									$deal1[]=$deal;	
									$deal1[$i]['done']=$deal['payment_done'];
									$sql_contri2 = "select first_name,last_name from tbl_users where userid = ".$deal['user_id'];
									$qry_contri2 = @mysql_query($sql_contri2);
									$user_det=@mysql_fetch_assoc($qry_contri2);
									$deal1[$i]['first_name']=$user_det['first_name'];	
									$deal1[$i]['last_name']=$user_det['last_name'];	
									$deal1[$i]['pro_price']=($row1['groupbuy_price']*$deal['deal_quantity'])+($deal['deal_quantity']*$row1['sub_delivery_cost']);
									$i++;	
								}

								$smarty->assign("cnt",$cnt);
							$smarty->assign("flag",1);
							//print_r($deal1);
							$smarty->assign("user_list",$deal1);

                                #-----------report generation--------------
																		if($_GET['view'] == 'excel')
																		{
																			
																			#----deal info----
                                                                 $fields2 = array(  "deal_unique_id" , "seller_id" , "title" );
																						$wf2     = array("deal_unique_id");
																						$wv2     =  array($id);
																						$ob2    =  "deal_unique_id"; 
																						$ot2     = 'asc'; 
																						$prn2    =  0; 
																						$result2  = $dbObj ->cgs('tbl_deal', $fields2, $wf2, $wv2, $ob2, $ot2, $prn2); 
																						$dealddd=@mysql_fetch_assoc($result2);
																						$dealname=$dealddd['title'];
                                                                  $sellerid=$dealddd['seller_id'];
																						
																						// Retrieving from tbl users        
																						$fields3 = array(  "userid" , "first_name" , "last_name" , "email" , "address1" );
																						$wf3    = array(  "userid");
																						$wv3     =  array( $sellerid);
																						$ob3     =  "userid"; 
																						$ot3     = 'asc'; 
																						$prn3    =  0; 
																						$result3  = $dbObj ->cgs('tbl_users', $fields3, $wf3, $wv3, $ob3, $ot3, $prn3);         
																						$seller=@mysql_fetch_assoc($result3);
                                                                  $seller_name=$seller['first_name']." ".$seller['last_name'];
																						

																		
																					$out = "";
																					$__lineBreker = "\n";
																					$out = "Deal Information".$__lineBreker;
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					$out .= 'Deal Name,'.$dealname.'';
																					$out .="$__lineBreker";
																					$out .= 'Seller Name,'.$seller_name.'';
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					$out .="$__lineBreker";
																					
	
		#----deal info end---
	
		$tbl1="tbl_deal_payment";
		$i1=0;	
		$cnd_test1="deal_id=".$id."";
		$arr1=$dbObj->gj($tbl1,"*",$cnd_test1,"","","","","");
		$cnt1=@mysql_num_rows($arr1);
			
		$out .="Deal Report";		
				$out .="\n";
		$out .="\n";	
	
		$out .='Buyer Name,Trans Id, Deal Quantity,Deal Price,Payment,Dispatched';	
				
				$out .="\n";
																					
																				
																					$i=0;
																				$sales_array=0;
																					while($testdeal = @mysql_fetch_assoc($arr1))
																					{
																				

																							
																							$deal11[$i]['done']=$testdeal['payment_done'];
																							$sql_contri22 = "select first_name,last_name from tbl_users where userid = ".$testdeal['user_id'];
																							$qry_contri22 = @mysql_query($sql_contri22);
																							$user_det1=@mysql_fetch_assoc($qry_contri22);
																							$deal11[$i]['first_name']=$user_det1['first_name'];	
																							$deal11[$i]['last_name']=$user_det1['last_name'];	
																							$i++;	
                                                                     $buysersname=$user_det1['first_name']." ".$user_det1['last_name'];
                                                                      if($testdeal['dispatched']=='0000-00-00')
                                                                       { 
                                                                           $dispached="No";
                                                                       }
                                                                       else
                                                                       {
                                                                            $dispached=$testdeal['dispatched'];
                                                                       }
                                                                      
                                                                             $transid=$testdeal['transaction_id'];
                                                                       
																																											
																								$out .= '"'.$buysersname.'","'.$transid.'","'.$testdeal['deal_quantity'].'","$'.$testdeal['deal_price'].'","'.$testdeal['payment_done'].'","'.$dispached.'"';
																							
																													$out .= "\n";
																													//echo $out;
																										$i++;
																							}
																			//echo $out;exit;	
																					//$out .=',,,,,,,Grant Total,"$'.number_format($sales_array,2).'",';
																						header("Content-type: text/x-csv");
																						header("Content-type: application/csv");
																		//            header("Content-Disposition: attachment; filename=deal".time().".csv");
																						header("Content-Disposition: attachment; filename=Deal-details.csv");	
																					
																					   echo $out;
																					   exit;
																				
																		
																		}
#-----------report generation end----------------------------


		}
}

			$cnd="deal_unique_id=".$_GET['id1']."";
			$arr=$dbObj->gj("tbl_deal","*",$cnd,"","","","","");
			$cnt=@mysql_num_rows($arr);
			$deal12=@mysql_fetch_array($arr);
			$smarty->assign("fake",$deal12['fake_user']);

if($_GET['type']=='seller' || $_GET['type']=='admin')
	{ unset($_SESSION['UserId']);
	 $smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/seller-payment-info.tpl');
	}
	else if($_GET['type']=='product')
	{ unset($_SESSION['UserId']);
	$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/product-payment-info.tpl');
	}
	else if($_GET['type']=='product1')
	{ unset($_SESSION['UserId']);
	$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/gb-payment-info.tpl');
	}

//$back session
$_SESSION['backsession']="http://groupbuyit.co.uk/admin/globalsettings/deal/view_product.php?id1=".$_GET['id1']."&type=".$_GET['type']."&act=view";

$dbObj->Close();
?>
