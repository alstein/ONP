{include file=$header_start}
{strip}
<script language="javascript" type="text/javascript" src="{$siteroot}/js/validation/validate_merchant_deal_request.js"> </script>
{/strip}
{literal}
<script language="JavaScript" type="text/javascript">
function redirect_to_page()
{
window.location =SITEROOT+"/merchant-account/merchant_profile_home";
}
</script>

{/literal}
<body class="inner_body"  {if $smarty.get.sp neq ''} style="background:none" {/if}>
<!-- main continer of the page -->
 {if $smarty.get.sp eq ''} {include file=$profile_header2} {/if}
<div id="wrapper" {if $smarty.get.sp neq ''}  style="width:546px;margin-top:0px"{/if}>
  <!-- header container starts here-->
  
  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont" >
    <!-- Left content Start here -->
 {if $smarty.get.sp eq ''}    {include file=$merchant_home_left}{/if}
    <!-- Middel content Start here -->
    <div class="profile-middel" style="width:553px;{if $smarty.get.sp neq ''} margin-top: 0px;width:547px;{/if}">
      <div class="live-write">
         <div >
         <div id="show_thread" class="latest-activeity" style="width:430px">
			 {if $smarty.get.sp eq ''}  <h2 style="margin-left:20px;color: #2B587A" >Merchant Offer Deal Request</h2><br>{else}  <h4 style="margin-left:20px;color: #2B587A" >Merchant Offer Deal Request</h4><br>{/if}
         <form name="frmdeal" id="frmdeal" action="" method="post">
    <input type="hidden" name="txt_id" id="txt_id" value="{$merchant_pay}">
	<div class="error" align="center">{$msg}</div>
      <table cellspacing="5" cellpadding="5" width="430" border="0" align="center">
		<tr>
			<td align="right" valign="top"  class="profile-name" style="width:131px;" ><span style="color:red">*</span>Name of Key Contact Person:</td>
			<td align="left" width="280">

<!--<input class="signinput" name="name_of_key" type="text" readonly="true" id="name_of_key" value="{if $result.business_name neq ''}{$result.business_name}{else}{$smarty.session.merchantbusiness_name}{/if}"  size="25" class="textbox fl"/>-->

			<!--<input class="signinput" name="name_of_key" type="text" readonly="true" id="name_of_key" value="{if $result.contact_person neq ''}{$result.contact_person}{else}{$smarty.session.csFullName}{/if}"  size="25" class="textbox fl"/>-->

<input class="signinput" name="name_of_key" type="text" readonly="true" id="name_of_key" value="{if $smarty.session.csUserId eq ''}{$smarty.session.merchantcontact_person} {elseif $result.contact_person neq ''}{$result.contact_person}{else}{$smarty.session.csFullName}{/if}"  size="25" class="textbox fl"/>


			<div class="clr"></div>
			<div class="error" htmlfor="name_of_key" generated="true"></div>
			</td>
		</tr>
      
		<tr>
			<td align="right" valign="top" style="width:131px;" class="profile-name" ><span style="color:red">*</span> Phone: </td>
			<td align="left" width="60%">
			<input class="signinput" name="phone_no" readonly="true" type="text" id="phone_no" value="{if $result.contact_detail neq ''}{$result.contact_detail}{else}{$smarty.session.merchantphone}{/if}"  size="25" class="textbox fl"/>
			<div class="clr"></div>
			<div class="error" htmlfor="phone_no" generated="true"></div>
			</td>
		</tr>
	

		<tr>
			<td align="right" valign="top" class="profile-name" style="width:131px;" ><span style="color:red">*</span> Mail:</td>
			<td align="left" >
			<input class="signinput" readonly="true" name="mail" type="text" id="mail" value="{if $result.email neq ''}{$result.email}{else}{$smarty.session.merchantemail}{/if}"  size="25" class="textbox fl"/>
			<div class="clr"></div>
			<div class="error" htmlfor="mail" generated="true"></div>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="padding-left:145px"><input type="checkbox" name="agree" id="agree" value="yes" />&nbsp;&nbsp;I have read and Agree to <a href="{$siteroot}/terms/" target="_blank">Term & Conditions</a>			
			<div class="clr"></div>
			<div class="error" htmlfor="agree" generated="true"></div>
</td> 
			
		</tr>

		<tr>
			<td></td>
			<td>
				<div class="fl"><span class="login-btn-lft"><span class="login-btn-rgt">
				<input class="login-btn" type="submit" value="Submit" name="Submit" id="Submit" />
				</span></span> </div>
				  
                  <div class="fl">{if $smarty.get.sp eq ''}<span style="margin-left:10px;" class="sitesub-btn-lft"><span class="sitesub-btn-right">
				<input  class="loc_busines fl" type="button" value="Cancel" onClick="redirect_to_page();" />
				</span></span>{/if}</div>
			</td>
		</tr>
    </table>
 
  </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Right content Start here -->
      {if $smarty.get.sp eq ''}  {include file=$merchant_home_right} {/if}
    <!-- footer container Start-->
</div>
  {if $smarty.get.sp eq ''}  {include file=$footer} {/if}
    <!-- footer container End-->


</body>

