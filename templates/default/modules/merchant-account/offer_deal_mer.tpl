{include file=$header_start}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery.timeago.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/validation/validate_offer_deal.js"> </script>
{/strip}
{literal}
<script type="text/javascript">

function getPercentage(orgPrice)
{
	var orgPrice=$("#discount").val();
	var amt_spend =$("#amt_spend").val();
	var discount = (parseFloat(amt_spend) * parseFloat(orgPrice))/100;
	var net_amount=(amt_spend - discount).toFixed(1);
	$("#netamount").val(net_amount);
	var merchant_pay=$("#txt_id").val();
	var discount_pay =((parseFloat(net_amount) * parseFloat(merchant_pay))/100).toFixed(1);
	var amt_to_pay=(net_amount - discount_pay).toFixed(1);
	//alert(amt_to_pay);
	$("#amt_to_pay").val(discount_pay);
	
	if(!isNaN(discount_pay))
		$("#pp").html("$"+discount_pay);
	else
		$("#pp").html("");
	$("#accepted_to_paid").val(amt_to_pay);
}

function show_dates(flag){
	if(flag=="redeemon"){
		$("#redeem_on").show();
		$("#offer_valid_till").hide();
		$("#offer_valid_till_message").hide();
		$("#redeem_bet").hide();
		$("#li_redeem_between").hide();
		
	}else if(flag=="redeembet"){
		
		$("#redeem_bet").show();
		$("#offer_valid_till").show();
		$("#offer_valid_till_message").show();
		$("#redeem_on").hide();
		$("#li_redeem_between").show();
	}

}

</script>
{/literal}
  <!-- Header starts -->
  {include file=$profile_header2}
  <!-- Header ends -->
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
    <!-- Create deal form starts -->
 <form name="frmdeal" id="frmdeal" action="" method="post" >
  <input type="hidden" name="todays_date" id="todays_date" value="{$todays_date}">
          <input type="hidden" name="temp_mer_id" id="temp_mer_id" value="{$smarty.get.id1}">
          <input type="hidden" name="txt_id" id="txt_id" value="{$merchant_pay}">
          <input type="hidden" name="temp_min_offer_amt" id="temp_min_offer_amt" value="{$deal_cond_row.min_offer_amt}">
          <input type="hidden" name="temp_amount" id="temp_amount" value="{$deal_cond_row.amount}">
    <div class="creat-deal">
	<div align="center" style="line-height:30px">{$paymentmessage}</div>
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
            <div class="fl textbox">
            <input class="signinput" name="amt_spend" type="text" id="amt_spend" size="25"  onblur="getPercentage(this.value);" value="{$smarty.session.amt_spend}"/>
            </div>
            <abbr class="fl">S$</abbr>
            <div class="clr"></div>
			 <br>
            <span style="margin-left:172px;">{if $deal_cond_row.min_offer_amt eq 'yes'}(Minimum amount should be ${$deal_cond_row.amount}){/if}</span> 
          </li>
          <li>
            <label>Discount request:</label>
            <div class="dis-bg fl">
			<select name="discount" id="discount" style="width:41px;" class="select" onChange="getPercentage(this.value);">
							<option value="5"  {if $smarty.session.discount eq '5'} selected="selected"{/if}>5</option>
							<option value="10" {if $smarty.session.discount eq '10'} selected="selected"{/if}>10</option>
							<option value="15" {if $smarty.session.discount eq '15'} selected="selected"{/if}>15</option>
							<option value="20" {if $smarty.session.discount eq '20'} selected="selected"{/if}>20</option>
							<option value="25" {if $smarty.session.discount eq '25'} selected="selected"{/if}>25</option>
							<option value="30" {if $smarty.session.discount eq '30'} selected="selected"{/if}>30</option>
							<option value="35" {if $smarty.session.discount eq '35'} selected="selected"{/if}>35</option>
							<option value="40" {if $smarty.session.discount eq '40'} selected="selected"{/if}>40</option>
							<option value="45" {if $smarty.session.discount eq '45'} selected="selected"{/if}>45</option>
							<option value="50" {if $smarty.session.discount eq '50'} selected="selected"{/if}>50</option>
							<option value="55" {if $smarty.session.discount eq '55'} selected="selected"{/if}>55</option>
							<option value="60" {if $smarty.session.discount eq '60'} selected="selected"{/if}>60</option>
							<option value="65" {if $smarty.session.discount eq '65'} selected="selected"{/if}>65</option>
							<option value="70" {if $smarty.session.discount eq '70'} selected="selected"{/if}>70</option>
							<option value="75" {if $smarty.session.discount eq '75'} selected="selected"{/if}>75</option>
							<option value="80" {if $smarty.session.discount eq '80'} selected="selected"{/if}>80</option>

						
				    </select>
            </div>
            <abbr class="fl">%</abbr>
            <div class="clr"></div>
          </li>
          <li>
            <label>Net ammount to be spend:</label>
            <div class="fl textbox">
             <input  name="netamount" type="text" id="netamount" size="25" readonly="true" value="{$smarty.session.netamount}"/>
            </div>
            <abbr class="fl">S$</abbr>
            <div class="clr"></div>
          </li>
		 <li id="offer_valid_till" {if $smarty.session.redeemflag eq 'redeembet' } style="display:block" {else} style="display:none" {/if}>
                <label>Offer valid till:</label>
                <div class="fl" style="margin-right:8px;margin-left: 28px;">
					{if $smarty.session.bid_validity neq ''}
                  		<script type="text/javascript">DateInput('bid_validity', true, 'YYYY-MM-DD','{$smarty.session.bid_validity}');</script>
					{else}
						<script type="text/javascript">DateInput('bid_validity', true, 'YYYY-MM-DD');</script>		
					{/if}
                </div>
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
                <input  name="redeemflag" type="radio" id="redeemflag" size="25" value="redeemon" onclick="show_dates('redeemon')"  {if $smarty.session.redeemflag eq 'redeemon'} checked="true"{/if}/>
              </div>
              <p class="fl forminntxt"> Redeem Only on a specific day</p>
            </div>
            <div class="fl">
              <div class="radio fl"  style="margin-left:30px">
				<input  name="redeemflag" type="radio" id="redeemflag" size="25"  value="redeembet" onclick="show_dates('redeembet')"  {if $smarty.session.redeemflag eq 'redeembet'} checked="true"{/if}/>
              
              </div>
              <p class="fl forminntxt"> Open on dates</p>
            </div>
            <div class="clr"></div>
		<div class="error" htmlfor="redeemflag" generated="true" style="margin-left:172px;"></div>
          </li>
			<input type="hidden" name="check_date_type" id="check_date_type" >
			<li id="redeem_on" {if $smarty.session.redeemflag eq 'redeemon'} style="display:block" {else} style="display:none"{/if}>
            <label>Redeem On:</label>
            <div class="fl" style="margin-left: 28px;">
          			{if $smarty.session.redeem_from neq ''}
					 	<script type="text/javascript">DateInput('redeem_from', true, 'YYYY-MM-DD','{$smarty.session.redeem_from}');</script>
					{else}
						<script type="text/javascript">DateInput('redeem_from', true, 'YYYY-MM-DD');</script>	
					{/if}
            </div>
				<input type="hidden" name="bid_validity1" id="bid_validity1">
            <abbr class="fl"></abbr> <span class="fl greytxt" style="margin-left:170px;">{$datemessage}</span>
            <div class="clr"></div>
			 <label> Offer Valid Till:</label>
            <div class="fl textbox">
           <input type="text" name="temobvald" id="temobvald" readonly="true" disabled="true" {if $smarty.session.bid_validity1 neq ''} value="{$smarty.session.bid_validity1|date_format}" {/if}>
            </div>
        <input type="hidden" name="datemessage" id="datemessage" value="{$datemessage}">
            <div class="clr"></div>
          </li>
		 
			 <li id="li_redeem_between">
            <label>Redeem Between:</label>
			 <div class="fl">
            <div class="fl" style="margin-left: 28px;">
			<label class="fl" style="width:36px;margin-top:6px;">From</label>
           	{if $smarty.session.redeem_from1 neq ''}
				<script type="text/javascript">DateInput('redeem_from1', true, 'YYYY-MM-DD','{$smarty.session.redeem_from1}');</script>
			{else}
				<script type="text/javascript">DateInput('redeem_from1', true, 'YYYY-MM-DD');</script>
			{/if}
            </div>
		<!--	<div class="clr"></div>-->
              
			 <div class="fl" style="margin-left:10px;">
			    <label class="fl" style="width:35px;margin-left:10px;margin-top:6px">To</label>
           {if $smarty.session.redeem_to neq ''}	
			<script type="text/javascript">DateInput('redeem_to', true, 'YYYY-MM-DD','{$smarty.session.redeem_to}');</script>
		{else}	
			<script type="text/javascript">DateInput('redeem_to', true, 'YYYY-MM-DD');</script>	
		{/if}
            </div>
            <div class="clr"></div>
            </div>
       <label class=" fl" style="margin-left:145px;">(Restrict to 1 month)</label>
            <div class="clr"></div>
		
			    <div class="error" htmlfor="redeem_to" generated="true" style="padding-left: 153px;"></div>
			<div class="error" htmlfor="redeem_from" generated="true" style="padding-left: 153px;"></div>
          </li>

          <li>
            <label>Amount to pay now:</label>
            <div class="fl textbox">
            <input  readonly="true"  name="amt_to_pay" type="text" id="amt_to_pay" size="25"  value="{$smarty.session.amt_to_pay}"/>
            </div>
            <abbr class="fl">S$</abbr> <span class="fl greytxt">({$merchant_pay}% of net amount.)</span>
            <div class="clr"></div>
			<div class="error" htmlfor="amt_to_pay" generated="true" style="width: 200px;margin-left:172px;"></div>
          </li>
          <li>
            <label>Amount to pay merchant:</label>
            <div class="fl textbox">
              <input readonly="true"  name="accepted_to_paid" type="text" id="accepted_to_paid" value="{$smarty.session.accepted_to_paid}"  size="25"/>
            </div>
            <abbr class="fl">S$</abbr>
            <div class="clr"></div>
				<div class="error" htmlfor="accepted_to_paid" generated="true" style="width: 275px;margin-left:172px;"></div>
          </li>
          <li>
            <label>Available on Weekends 
              on case to case basis:</label>
            <div class="fl">
              <div class="radio fl"  style="margin-left:30px">
                 <input type="radio" class="styled" name="weekends" id="weekends" value="yes" {if $deal_cond_row.offer_weekend eq 'yes'} checked="true"{/if} disabled="true">
              </div>
              <p class="fl forminntxt"> Yes</p>
            </div>
            <div class="fl">
              <div class="radio fl"  style="margin-left:30px">
                  <input type="radio" class="styled" name="weekends" id="weekends" value="no" {if $deal_cond_row.offer_weekend eq 'no'} checked="true"{/if} disabled="true">
              </div>
              <p class="fl forminntxt"> No</p>
            </div>
            <div class="clr"></div>
          </li>
          <li>
            <label>Condition:</label>
            <div class="conditon-textbox" style="margin-left:168px;" >
<!--               <input name="conditions" type="text" id="conditions" value="{$deal_cond_row.condition}" readonly="true" size="25" /> -->
				<textarea 	name="conditions"	id="conditions" class="add-txt-in"  readonly="true"  cols="35" rows="10" >{$deal_cond_row.condition}</textarea>
            </div>
            <div class="fl" style="margin-top:-6px; margin-left:10px">
              <ul class="reset icn-link" style="padding:0px">
                <li><a href="javascript:void(0);" class="icn-link01 ">What's it?</a>
                  <div class="tooltip"> <span class="arrow">&nbsp;</span>
                    <div class="top01">
                      <div></div>
                    </div>
                    <div class="mid">Preset by Merchant</div>
                    <div class="bot01">
                      <div></div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="clr"></div>
          </li>
          <li>
              <label>&nbsp;</label>
              <div class="fl" style="margin-left:30px">
			 <input type="checkbox" class="styled" name="addto_live_wire" id="addto_live_wire"  {if $smarty.session.addto_live_wire neq ''} checked="true"{/if}/>
			    <p class="fl forminntxt" style="line-height:15px">Add this to my live wire</p>
			  </div>
              <div class="clr"></div>
              </li>
          <li>
            <div style="margin:40px 0 0 0">
              <label>&nbsp;</label>
              <input type="submit" name="submit" id="submit"  value="Preview" class="previe-btn" style="width:92px" />
            </div>
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
