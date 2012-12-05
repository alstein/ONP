{include file=$header_start}
{literal}
<script type="text/javascript">
	function go_back(){
		window.location.href="{/literal}{$siteroot}{literal}/merchant-account/{/literal}{$smarty.session.temp_mer_id}{literal}/offer_deal_to_merchant/";
	}
</script>
{/literal}
  <!-- Header starts -->
  {include file=$profile_header2}
  <!-- Header ends -->
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
    <!-- Create deal form starts -->
<form name="frmdeal" id="frmdeal" action="{$siteroot}/php_nvp_samples/SetExpressCheckout.php?paymentType={$authorisation}&amt={$smarty.session.amt_to_pay}&quantity=1&merchant_id={$smarty.session.temp_mer_id}&amount_spend={$smarty.session.amt_spend}&discount={$smarty.session.discount}&outflow={$smarty.session.netamount}&redeem_from={$smarty.session.redeem_from}&redeem_to={$smarty.session.redeem_to}&bid_validity={$smarty.session.bid_validity}&amt_to_pin={$smarty.session.amt_to_pay}&accepted_to_paid={$smarty.session.accepted_to_paid}&addlivewire={$addlivewire}&redeemtype={$smarty.session.redeemflag}&redeem_from1={$smarty.session.redeem_from1}&bid_validity1={$smarty.session.bid_validity1}" method="post">

<input type="hidden" name="txt_id" id="txt_id" value="{$merchant_pay}">
<input type="hidden" name="temp_min_offer_amt" id="temp_min_offer_amt" value="{$deal_cond_row.min_offer_amt}">
<input type="hidden" name="temp_amount" id="temp_amount" value="{$deal_cond_row.amount}">
    <div class="creat-deal">
      <h1>Create An Offer</h1>
      <div class="deal-head">
        <h2>For Your Favourite Local Business</h2>
      </div>
      <div class="grey-form">
        <div class="grey-form-inn">
          <ul class="reset deal-from">
            <li>
              <label>Business Name:</label>
              <p class="fl"> {$bussines_name|ucwords}</p>
              <div class="clr"></div>
            </li>
            <li>
              <label>Permanent Address:</label>
              <p class="fl">{$address}</p>
              <div class="clr"></div>
            </li>
            <li>
              <label>Phone No:</label>
              <p class="fl">{$phone_no}</p>
              <div class="clr"></div>
            </li>
          </ul>
        </div>
      </div>
      <div class="deal-user-form">
        <ul class="reset deal-from">
          <li>
            <label>Amount I (Or my group)
              would like to spend:</label>
            <p style="margin-left: 170px;">
           	S${$smarty.session.amt_spend}
            </p>
          
            <div class="clr"></div>
			 <br>
             {if $deal_cond_row.min_offer_amt eq 'yes'}(Minimum amount should be S${$deal_cond_row.amount}){/if}
          </li>
          <li>
            <label>Discount request:</label>
            <p style="margin-left: 170px;">
			{$smarty.session.discount}%
            </p>
           
            <div class="clr"></div>
          </li>
          <li>
            <label>Net ammount to be spend:</label>
            <p style="margin-left: 170px;">
            	S${$smarty.session.netamount}
            </p>
           
            <div class="clr"></div>
          </li>
		 <li id="offer_valid_till" {if $smarty.session.redeemflag eq 'redeembet' } style="display:block" {else} style="display:none" {/if}>
                <label>Offer valid till:</label>
                <p style="margin-left: 170px;">
				  {$smarty.session.bid_validity|date_format:"%e %B %Y"}
                </p>
                <div class="clr"></div>
                <div class="error" htmlfor="bid_validity" generated="true" style="padding-left: 153px;"></div>
              </li>
              <li>

 			<li id="offer_valid_till_message" style="display:none">
                <label>&nbsp;</label>
                <div class="fl" style="margin-right:8px;margin-left: 28px;">
                 Bid Validity date should be max 3 days from current date
                </div>
                <div class="clr"></div>
               
              </li>

          <li>
            <label>I would like to:</label>
            <div class="fl">
              <div class="radio fl"  style="margin-left:30px">
               <input class="signinput" name="redeemflag" type="radio" id="redeemflag" size="25" class="textbox fl" style="width:15px" {if $smarty.session.redeemflag eq 'redeemon' } checked="true" {/if} disabled="true"/> 
              </div>
              <p class="fl forminntxt"> Redeem Only on a specific day</p>
            </div>
            <div class="fl">
              <div class="radio fl"  style="margin-left:30px">
			<input class="signinput" name="redeemflag" type="radio" id="redeemflag" size="25" class="textbox fl" style="width:15px" {if $smarty.session.redeemflag eq 'redeembet' } checked="true" {/if} disabled="true"/>
              
              </div>
              <p class="fl forminntxt"> Open on dates</p>
            </div>
            <div class="clr"></div>
		<div class="error" htmlfor="redeemflag" generated="true" style="margin-left:172px;"></div>
          </li>

			
{if $smarty.session.redeemflag eq 'redeemon' }
            <li>
              <label>Redeem On:</label>
              <p style="margin-left: 170px;"> 
                {$smarty.session.redeem_from|date_format:"%e %B %Y"}
              </p>
            </li>
            <li>
              <label>Offer Valid till:</label>
              <p style="margin-left: 170px;"> 
              {$smarty.session.bid_validity1|date_format:"%e %B %Y"}  
              </p>
            </li>
{elseif $smarty.session.redeemflag eq 'redeembet'}
			<li>
              <label>Redeem Between:</label>
              <p style="margin-left: 170px;"> 
                From &nbsp; &nbsp;{$smarty.session.redeem_from1|date_format:"%e %B %Y"}&nbsp; &nbsp;To&nbsp; &nbsp;{$smarty.session.redeem_to|date_format:"%e %B %Y"}  
              </p>
            </li>
{/if}



		
          <li>
            <label>Amount to pay now:</label>
            <p style="margin-left: 170px;">
            	S${$smarty.session.amt_to_pay}    
            </p>
         
            <div class="clr"></div>
			<div class="error" htmlfor="amt_to_pay" generated="true" style="width: 200px;margin-left:172px;"></div>
          </li>
          <li>
            <label>Amount to pay merchant:</label>
            <p style="margin-left: 170px;">
             	S${$smarty.session.accepted_to_paid}   
            </p>
           
            <div class="clr"></div>
			
          </li>
          <li>
            <label>Available on Weekends 
              on case to case basis:</label>
            <div class="fl">
              <div class="radio fl"  style="margin-left:30px">
                 <input type="radio" name="weekends" id="weekends" value="yes" {if $deal_cond_row.offer_weekend eq 'yes'} checked="true"{/if} disabled="true">
              </div>
              <p class="fl forminntxt"> Yes</p>
            </div>
            <div class="fl">
              <div class="radio fl"  style="margin-left:30px">
                <input type="radio" name="weekends" id="weekends" value="no" {if $deal_cond_row.offer_weekend eq 'no'} checked="true"{/if} disabled="true">
              </div>
              <p class="fl forminntxt"> No</p>
            </div>
            <div class="clr"></div>
          </li>
          <li>
            <label>Condition:</label>
            <p style="margin-left:170px;">
           {$smarty.session.conditions}    
            </p>
            
            <div class="clr"></div>
          </li>
          
          <li>
            <div style="margin:40px 0 0 0;width:400px;">
              <label>&nbsp;</label>
              <input type="submit" name="submit" id="submit" value="Buy And Offer Deal"  class="previe-btn" style="width:180px;" /><input type="button" name="back" id="back" value="Back"  class="previe-btn"  style="margin-left:10px;" onclick="go_back()">
            </div>
          </li>
           <li>

              <div class="fl"><span class="fl"><label style="width:630px;color:red">Pay remaining amount (S${$smarty.session.netamount}-S${$smarty.session.amt_to_pay} =S${$smarty.session.accepted_to_paid}    ) directly to merchant if he accepts your deal.</label></span>

              </div>
            </li>

			<li>
              <label>&nbsp;</label>
              <div class="fl">
                <p class="fl">
                  <input type="checkbox" name="terms" id="terms" {if $smarty.session.amt_spend neq ''} checked="true"{/if} disabled="true"/>
                  &nbsp;&nbsp;<span class="from-text">Agree to Terms & Conditions</span></p>
				
                <p class="fl" style="margin-left:10px">
                  <input type="checkbox" name="addto_live_wire" id="addto_live_wire" {if $smarty.session.addto_live_wire} checked="true"{/if} disabled="true" value="{$smarty.session.addto_live_wire}"/>
                  &nbsp;&nbsp;<span class="from-text">Add this to my live wire</span></p>
              </div>
			<div class="clr"></div>
			<div class="error" htmlfor="terms" generated="true" style="padding-left: 156px;"></div>
            </li>
          
        </ul>
      </div>
    </div>
</form>
    <!-- Create deal form end -->
    <!-- Maincontent ends -->
  </div>
</div>
<!-- Footer starts -->
  {include file=$footer} 