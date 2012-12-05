{include file=$header_start} 

{if $smarty.session.csUserId neq ''}
{include file=$profile_header2}
{else}
{include file=$header_end}
{/if}
{literal}
<script type="text/javascript">
function root(){
	window.location=history.back(-1);
}
function check(){
	$("#frm").validate();
	if($("#frm").valid()){
		$("#sub").html("<a href='javascript:void(0)' class='sitebutton fl'><span><input class='sitebutton fl' style='border:none' type='button' name='Submit' id='Submit' value='Submit'> </span></a>");
		$("#frm").submit();
		return true;
	}else{
		return false;
	}	
}
</script>
{/literal}
<script type="text/javascript" src="{$siteroot}/js/validation/contactform.js"></script>
  <!-- Header ends -->
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
    
    <div class="about-us">
   <!-- Website Contact  Form starts -->
    <div  class="contact-page">
               <h1>Contact Us</h1>
              <div class="inner-contact">
             
               
               <ul class="reset contact-listing">
               <li class="email">
               <strong>Feedback On Website: <a href="mailto:{$general_enquiry}">{$general_enquiry}</a></strong>
               </li>
                <li class="skype">
                <strong>Talk To Us: <a href="mailto:{$sales_enquiry}">{$sales_enquiry}</a></strong>
                </li>
               
               </ul>
              <div class="clr"></div>
              </div>
              
           
              <div class="clr"></div>
            </div>
       <!-- Website Contact  Form end -->
    </div>
  </div>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->
  {include file=$footer}