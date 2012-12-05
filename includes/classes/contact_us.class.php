<?php
class Contact_Us 
{

    function __construct()
    {

    } // end function
    
   function addNewContac($array){
      global $dbObj, $msobj;
         if((strlen(trim($array["email"])) > 0) && (strlen(trim($array["name"])) > 0))
         {
                $field=array("fullName","emailId","subject","message","postedDate");
                 $values=array($array["name"],$array["email"],"",$array["message"],date("Y-m-d"));
                 $result = $dbObj ->cgi('tbl_contactus' , $field , $values , $prn); 
               //Send mail to administrator
               $email_query_adm = "select * from mast_emails where emailid=49";
      
               $email_rs_adm = @mysql_query($email_query_adm);
               $email_row_adm = @mysql_fetch_object($email_rs_adm);
               $email_subject_adm = str_replace("[[SITETITLE]]", SITETITLE, $email_row_adm->subject);
               $email_subject_adm = str_replace("[[name]]",ucfirst($array["name"]),$email_subject_adm);
         
               $email_message_adm = file_get_contents(ABSPATH."/email/email.html");
               $email_message_adm = str_replace("[[SITEROOT]]", SITEROOT, $email_message_adm);
               $email_message_adm = str_replace("[[EMAIL_HEADING]]",$email_subject_adm,$email_message_adm);
               $email_message_adm  = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row_adm->message),$email_message_adm);
         
               $email_message_adm = str_replace("[[SITETITLE]]", SITETITLE, $email_message_adm);
               $email_message_adm = str_replace("[[SITEROOT]]",SITEROOT,$email_message_adm);
               $email_message_adm = str_replace("[[name]]",ucwords($array["name"]),$email_message_adm);
               $email_message_adm = str_replace("[[email]]",$array["email"],$email_message_adm);
               $email_message_adm = str_replace("[[message]]",$array["message"],$email_message_adm);
               $email_message_adm = str_replace("[[TODAYS_DATE]]", date("d-m-Y"), $email_message_adm);
               $email_message_adm = str_replace("[[link]]",SITEROOT, $email_message_adm);
      
               $to = SITE_EMAIL;
               $from = $array["email"];
               @mail($to,$email_subject_adm,$email_message_adm,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
              // echo "<pre>To ==".$to."<br>From ==".$from."<br>Sub ==".$email_subject_adm."<br>Msg ==".$email_message_adm."<br></pre>";
              // exit;

               //Send mail to buyer
                $email_query_adm = "select * from mast_emails where emailid=48";
                $email_rs_adm = @mysql_query($email_query_adm);
               $email_row_adm = @mysql_fetch_object($email_rs_adm);
               
               $email_subject_adm = str_replace("[[SITETITLE]]", SITETITLE, $email_row_adm->subject);
               $email_subject_adm = str_replace("[[name]]",ucfirst($array["name"]),$email_subject_adm);
         
               $email_message_adm = file_get_contents(ABSPATH."/email/email.html");
               $email_message_adm = str_replace("[[SITEROOT]]", SITEROOT, $email_message_adm);
               $email_message_adm = str_replace("[[EMAIL_HEADING]]",$email_subject_adm,$email_message_adm);
               $email_message_adm  = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row_adm->message),$email_message_adm);
         
               $email_message_adm = str_replace("[[SITETITLE]]", SITETITLE, $email_message_adm);
               $email_message_adm = str_replace("[[SITEROOT]]",SITEROOT,$email_message_adm);
               $email_message_adm = str_replace("[[name]]",ucwords($array["name"]),$email_message_adm);
               $email_message_adm = str_replace("[[email]]",$array["email"],$email_message_adm);
               $email_message_adm = str_replace("[[message]]",$array["message"],$email_message_adm);
               $email_message_adm = str_replace("[[TODAYS_DATE]]", date("d-m-Y"), $email_message_adm);
               $email_message_adm = str_replace("[[link]]",SITEROOT, $email_message_adm);
 
               $to =$array["email"];
               $from = SITE_EMAIL;
               @mail($to,$email_subject_adm,$email_message_adm,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
             // echo "<pre>To ==".$to."<br>From ==".$from."<br>Sub ==".$email_subject_adm."<br>Msg ==".$email_message_adm."<br></pre>"; exit;

         }
         else{
                $s=$msobj->showmessage(217);
                $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
                header("Location:".$_SERVER['HTTP_REFERER']);
                exit;
         }
   } // end function 
   

} // end class

?>