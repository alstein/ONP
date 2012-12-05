<?php
error_reporting(E_ERROR | E_WARNING);
 //error_reporting(E_ALL);
define('PREFIX', '../../');
include_once('../../includes.php');
// include("fb.php");

include_once("../../includes/JSON.php");
require_once '../../facebook-connect/facebook-php/src/facebook.php';

// Create our Application instance.
 $facebook = new Facebook(array(
'appId'  => '205887732815348',
  'secret' => '5db3c92c0f8d4129414c052544378819',
  'cookie' => true,
));
$uid = $facebook->getUser();
$loginUrl=$facebook->getLoginUrl(array(
'scope'  => 'publish_stream'
));
// echo "<pre>";print_r($contacts['data']);exit;
// print_r($me);exit;
// echo count($contacts);exit;
$getFacebook = ($_GET['facebook']?$_GET['facebook']:0);
$flag = $_GET["flag"];
// echo "1=".$getFacebook."flag=".$flag;exit;
//if($getFacebook  == 1){
//    $friends = $facebook->api->friends_get();
// 	echo count($contacts['data']);exit;
  // if(count($contacts['data']) > 0){
//       $friends = $facebook->api_client->friends_get();
    //  $userFriends = "";
	//$friends=$contacts['data'];
	//print_r($friends);exit;
      //foreach($friends as $key=>$value){
//          $user_details = $facebook->api->users_getInfo($value,array(
//          'uid','last_name','first_name','email','name'));
         //$userFriends.="<input type=\"checkbox\" value=\"".$friends[0]['id']."\" name=\"friends[]\" />".$user_details[0]['name']."<br>";
      //}
	//print_r($user_details);exit;
      //$facebook->api_client->stream_publish("hello yes it");
   //}
//}




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//-For Get/Pull Down Conatct Details as per provider name like (yahoo, gmail, linked in, facebook, twitter & it's username and password
if($flag == "pullcontact" && $getFacebook  == 1)
{
?>
	<script type='text/javascript'>
            function toggleAll(element) 
            {

               var totSelectedContacts = 0;
               var totPriceSave = 0;
               var updtTotFinalDealPrice = 0;
               var form = document.forms.frmsharestep2, z = 0;
               for(z=0; z<form.length;z++)
               {
                  if(form[z].type == 'checkbox' && form[z].name != 'toggle_all')
                   form[z].checked = element.checked;

                  if(form[z].type == 'checkbox' && form[z].checked == true && form[z].name != 'toggle_all')
                   totSelectedContacts++;
               }

            }
function chkContactsAreSelectedOrNot()
{
      var iserror='no';
      var totSelectedContacts = 0;
      var form = document.forms.frmsharestep2, z = 0;
      for(z=0; z<form.length;z++)
      {
         if(form[z].type == 'checkbox' && form[z].checked == true && form[z].name != 'toggle_all')
            totSelectedContacts++;
      }

      $('#chkcontacterror').hide();
      $('#chkcontacterror').html();

      $('#error_sharetoname').hide();
      $('#error_sharetoname').html();


      if(totSelectedContacts==0){
         iserror='yes';
         $('#chkcontacterror').show();
         $('#chkcontacterror').html("Please select contact (or contacts).");
      }
      
      var shareToNameVal = $('#sharetoname').val();
      if(shareToNameVal=="Enter Your Name"){
         iserror='yes';
         $('#error_sharetoname').show();
         $('#error_sharetoname').html("Please enter share to name");
      }
      return false;
}
	function closewin()
	{
		window.close('parent.location.reload();');
	}
         </script>
<form action='invite_facebook_friends.php' method='POST' name='frmsharestep2' id='frmsharestep2'>
<?php
	if ($uid) {
      try {
        // Proceed knowing you have a logged in user who's authenticated.
        $contacts = $facebook->api('/me/friends');
      } catch (FacebookApiException $e) {
        error_log($e);
        $uid = null;
      }
    }
// 		echo "<pre>";print_r($contacts);exit;
		$friends=$contacts['data'];
               if($friends)
                  {
                     $tot_conatcts = count($friends);
?>
                     <!-- Share Process Popup  -->
                     <!--<div class="LightBoxMain">-->
                     <input type="button" onclick="javascript:$(document).trigger('close.facebox')" style="display:block; width:35px; height:35px; position:absolute; top:-14px; right:-5px;background-image: url(../templates/default/images/close.png); background-color:Transparent;border:0px; cursor:pointer ">
                     
                        <div class="shreboxmn">
                        <div class="shrheadTxt">&quot;Share This Deal With Your Dear Once&quot;</div>
                        <div class="shrfbmain">
<?php
                        if (count($friends)==0)
                        {
                           echo "You do not have any contacts in your address book";
                        }
                        else
                        {
?>
                           <div class="heading ovfl-hidden">
				<div class="centerall">Share with all (<?php echo $tot_conatcts; ?>) facebook contacts</div>
                              <div class="clr">&nbsp;</div>
                           </div>
                           
                           <div class="fbpopuplist">
                              <ul class="listingMid fbpopup reset">
                              <li> <input type="checkbox" value="1" class="fl" style="margin-right:7px;" name='toggle_all' id='toggle_all' title='Select/Deselect all' checked  onClick='javascript:toggleAll(this);'/>
                              <div class="noconttxt">Your Facebook Contacts</div>
                             </li>
<?php
//                               $odd=true;
                              $counter=0;
                              for($i=0;$i<count($friends);$i++)
                              {
//                                  $user_details = $facebook->api_client->users_getInfo($value,array('uid','last_name','first_name','email','name'));
                                 $counter++;
//                                  if ($odd) $class='row1'; else $class='row2';
?>
                                 <li>
                                    <div class="fl">
                                       <input type="checkbox" name='check[]' id='check_<?php echo $counter; ?>' value='<?php echo $friends[$i]['id']; ?>' checked/>&nbsp;
                                    <input type='hidden' name='name[<?php echo $counter; ?>]' value='<?php echo $friends[$i]['id']; ?>'>
                                    </div>
                                    <div><?php echo $friends[$i]['name']; ?><?php //echo $user_details[0]['email']; ?></div>
                                 </li>
<?php
//                               $odd=!$odd;
                              }
?>
                              </ul>
                           </div>
<?php
                        }
?>
                        <div class="error" id="chkcontacterror" style="display:none; padding-top:5px;padding-bottom:2px;padding-left:50px;"></div> 
			
			</div>
                       <div class="fbpopuplist">
                       <ul class="fbpopup reset"> 
                   <li class="noconttxt">
				    Number of facebook contacts<span class="bigtxt" id="span_tot_conatcts2">&nbsp;<?php echo $tot_conatcts; ?></span>
				   </li>
                        <li style="padding-bottom:12px; float:left">
                        <div class="submitbtn fr">
			<input type="submit" name="Submit" id="Submit" value="Share" class=""/>
                        <div class="error" id="error_sharetoname" style="display:none;"></div></div>
                         </li>
				
                        </ul>
                        </div>
                        </div>
   
                                        <!--</div>-->
                     <!-- End Share Process Popup  -->

            </form>
<?php
} //end if flag is pullcontact
//End Pull Contact process
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
// $app_id="335797116444318";
// echo {$app_id};exit;

?>
