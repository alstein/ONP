<?php
class Payment_Report_Grid {

    function __construct(){
    
    } // end function

  function getAllPaymentReport($l=""){
        global $dbObj;
            if($l != ''){
               $l = ' limit '.$l;
                }   
            $qry = "SELECT tu.userid,tu.username,tu.first_name,tu.last_name,tu.subscribe_status,tu.signup_date,tu.last_expiration_date,tp.subs_pack_name,tp.subs_pack_price,tp.userid,tp.subs_pack_price 
            from tbl_user_subscription_details tp
            INNER JOIN tbl_users tu  ON tu.userid=tp.userid group by tu.signup_date DESC ". $l;
          $prn = "";
          return $result = $dbObj -> customqry($qry, $prn); 

    } // end function

        //old query
         /* $sql = "SELECT tu.userid,tu.username,tu.first_name,tu.last_name,tu.signup_date,tu.next_pay_due_date,tu.pay_price,
         tp.user_id as     payment_user_id,tp.pay_price as payment_price
         from tbl_payment tp
         LEFT JOIN tbl_users tu  ON tu.userid=tp.user_id
         WHERE tu.userid=".$id;*/
         function getPaymentReportById($id){
        global $dbObj; 
        $row = array();
        if(is_array($id) && sizeof($id) > 0){
            $id = implode(",", $id);
        }

         $sql = "SELECT tu.userid,tu.username,tu.subscribe_status,tu.first_name,tu.last_name,tu.signup_date,tu.last_expiration_date,tp.userid as payment_user_id,tp.subs_pack_price as payment_price
         from tbl_user_subscription_details tp
         LEFT JOIN tbl_users tu  ON tu.userid=tp.userid
         WHERE tu.userid=".$id;
         
        $result = $dbObj ->customqry($sql, '');
        $row = @mysql_fetch_assoc($result);
        return $row;

    } // end function 

         function getDetailPaymentReportById($pay_id,$l=""){
         global $dbObj; 
         $row = array();
         if(is_array($id) && sizeof($id) > 0){
               $id = implode(",", $id);
         }
         if($l != '')
            {
               $l = ' limit '.$l;
            } 
        $sql = "SELECT payer_first_name,payer_last_name,payer_address_street,payer_address_state,payer_address_city,payer_address_country,payer_address_zip,
        expiration_date,subs_pack_name,subs_pack_allow_deals_per_month,subs_pack_duration,
        subscription_date,subs_pack_price FROM tbl_user_subscription_details WHERE userid=".$pay_id." order by expiration_date desc ".$l;        
        $pay_result = $dbObj ->customqry($sql, '');
        return $pay_result;

    } // end function 
    //old query
   /* $sql = "SELECT pay_date,next_pay_due_date,pay_price,card_holder_name,billing_address,city,state, postal_code FROM tbl_user_subscription_details WHERE userid=".$pay_id." order by pay_date desc ".$l; */
   function getAllSmsEmailReport($l=""){
        global $dbObj;
            if($l != ''){
               $l = ' limit '.$l;
                }   
            $qry = "SELECT Distinct(tse.seller_id),tu.email,tu.city,tu.userid,tu.username,tu.first_name,tu.last_name,tse.seller_id
            from tbl_sms_email_header tse
            LEFT JOIN tbl_users tu  ON tu.userid=tse.seller_id group by tse.send_date DESC ". $l;
          $prn = "";
          return $result = $dbObj -> customqry($qry, $prn); 

    } // end function
   function getAllSmsEmailDealReport($l="",$sellerid){
        global $dbObj;
            if($l != '')
            {
               $l = ' limit '.$l;
            }   
            $qry = "SELECT tu.email,tu.city,tu.userid,tu.username,tu.first_name,tu.last_name,tse.*,td.title
            from tbl_sms_email_header tse
            LEFT JOIN tbl_users tu  ON tu.userid=tse.seller_id  LEFT JOIN tbl_deal td ON td.deal_unique_id=tse.deal_id  WHERE tse.seller_id={$sellerid} group by tse.send_date DESC ". $l;
          $prn = "";
          return $result = $dbObj -> customqry($qry, $prn); 

    } // end function
     function getSmsEmailReportById($id){
        global $dbObj; 
        $row = array();
        if(is_array($id) && sizeof($id) > 0){
            $id = implode(",", $id);
        }

         $sql = "SELECT tu.userid,tu.username,tu.first_name,tu.email,tu.city,tu.last_name,tse.* 
         from tbl_sms_email_header tse
         LEFT JOIN tbl_users tu  ON tu.userid=tse.seller_id
         WHERE tu.userid=".$id;
         
        $result = $dbObj ->customqry($sql, '');
        $row = @mysql_fetch_assoc($result);
        return $row;

    } // end function 
    
} // end class

?>