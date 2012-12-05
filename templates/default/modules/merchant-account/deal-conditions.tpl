{include file=$header_start}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/validate_deal_condn.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
{/strip}
{literal}
<script type="text/javascript">
 	$(document).ready(function() {
		if($("#temp_min_offer_amt").val()=='yes')
			$("#minimum_amount_field").show();	
		else{
			$("#minimum_amount_field").hide();	
			$("#mimimum_offer_amount").val("");
		}
	});
	function show_mininmum_amount_field(yesno){
		
		if(yesno=='yes'){
				$("#minimum_amount_field").show();
				$("#mimimum_offer_amount").val({/literal}{$deal_condition.amount}{literal});
		}else if(yesno=='no'){
				$("#minimum_amount_field").hide();
				$("#mimimum_offer_amount").val("");
		}
	
	}
	function go_to_profile(){
		window.location='{/literal}{$siteroot}/merchant-account/merchant_profile/{literal}'
	}
</script>
{/literal}
{if $smarty.session.csUserId neq ''}
{include file=$profile_header2}
{else}
{include file=$header_end}
{/if}
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">
      <tr>
        <!-- Profile Left Section Start -->
        {include file=$merchant_home_left}

        <!-- Profile Left Section End -->
        <!-- Profile Middle Section Start -->
        <td width="560" valign="top"><!-- Profile Comment Section Start -->
          <div class="maincont-inner-mid fl">
            <div class="edit-profile-form">
              <h1 class=" form-title">Incoming Offer Condition Settings</h1>

   <form name="frmdeal" id="frmdeal"  method="post" style="height:470px;">
<input type="hidden" name="temp_min_offer_amt" id="temp_min_offer_amt" value="{$deal_condition.min_offer_amt}">
<input type="hidden" name="userid" id="userid" value="{$user.userid}" />
              <ul class="reset user-edit-form">
				<div align="center" class="success" style="margin:17px">{$msg}</div>
                <li>
                  <label style="width:150px">Min. Offer Amount:<span>*</span></label>
                  <div class="fl">
                    Enable<input type="radio" name="min_amount_de" id="min_amount_de" value="yes" onClick="show_mininmum_amount_field('yes')" {if $deal_condition.min_offer_amt eq 'yes'} checked="true" {/if}>&nbsp;&nbsp;&nbsp;Disable<input type="radio" name="min_amount_de" id="min_amount_de" value="no" onClick="show_mininmum_amount_field('no')" {if $deal_condition.min_offer_amt eq 'no'} checked="true" {/if}>
                  </div>
				<div htmlfor="min_amount_de" generated="true" class="error"></div>
                  <div class="clr"></div>
                </li>
                <li id="minimum_amount_field">
                  <label style="width:150px">Minimum Offer Amount:<span>*</span></label>
                  <div class="fl form-textbox" style="margin-left:2px">
					<input type="text" name="mimimum_offer_amount" id="mimimum_offer_amount" class="signinput" value="{$deal_condition.amount}">
                  </div>
                  <div class="clr"></div>
                </li>
                <li>
                  <label style="width:150px">Offer For Weekend:<span>*</span></label>
                  <div class="fl ">
                   Yes <input type="radio" name="offer_for_weekend" id="offer_for_weekend" value="yes" {if $deal_condition.offer_weekend eq 'yes'} checked="true" {/if}>&nbsp;&nbsp;&nbsp; No<input type="radio" name="offer_for_weekend" id="offer_for_weekend" value="no" {if $deal_condition.offer_weekend eq 'no'} checked="true" {/if}>
                  </div>
                  <div class="clr"></div>
				<div htmlfor="offer_for_weekend" generated="true" class="error"></div>
                </li>

			 <li>
                  <label style="width:150px">Condition:<span>*</span></label>
                  <div class="fl add-textbox" style="margin-left:0px">
              	   <textarea  class="add-inpout" name="condition" id="condition" rows="4" cols="25">{$deal_condition.condition}</textarea>
                  </div>

                  <div class="clr"></div>
					<div htmlfor="condition" generated="true" class="error" style="margin-left:147px"></div>
                </li>


                <li>
                <label style="width:150px">&nbsp;</label>
                	<div class="fl" style="margin:15px 0 0 30px">
						<input class="previe-btn" type="submit" value="Save" name="Submit" id="Submit" style="width:72px"/>
     		 </div>
      			<div class="fl" style="margin:15px 0 0 10px">
			<input style="width:82px" class="previe-btn"   type="button" value="Cancel" onclick="javascript: location='{$siteroot}/my-account/my_profile_home/'"/>
      
     			 </div>
                </li>

              </ul>
		</form>
            </div>
            <div class="clr" style="height:30px"></div>
          </div>
          <!-- Profile Comment Section End --></td>
        <!-- Profile Middle Section End -->
        <!-- Profile Right Section Start -->
        
  {include file=$merchant_home_right}
        <!-- Profile Right Section End -->
      </tr>
    </table>
  </div>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->
 {include file=$footer}
