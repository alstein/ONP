{include file=$header_start}
{literal}
<!--<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>-->
<!--<script language="javascript" type="text/javascript" src="{$siteroot}/js/validation/create_deal.js"> </script>-->
<script type="text/javascript">
	function go_back(){ 
		window.location.href='{/literal}{$siteroot}{literal}/deal/create_deal';
	}
</script>
{/literal}
<!-- main continer of the page -->
<!-- Header starts -->
{include file=$profile_header2}
<!-- Header ends -->
<!-- Maincontent starts -->

<form method="POST" name="frm" id="frm">
<div id="maincont"  class="ovfl-hidden" style="padding-bottom:20px">
<div class="creat-deal">
<h1>Create Your Own Offer</h1>
<div class="deal-head">
  <h2>For Your Customers</h2>
</div>
<div class="deal-own-form-mid">
  <div>
    <ul class="reset deal-from">
      <li>
        <label>Category:</label>
        <p class="fl"> {if $smarty.session.deal_category eq deal_as_usual} My Fav Offers {else if $smarty.session.deal_category eq right_now_deal} Hurry Up Offers{/if} </p>
        <div class="clr"></div>
      </li>
      <li>
        <label>Deal Headline:</label>
        <p class="fl"> {$smarty.session.discount_in_per}% Off On {$smarty.session.deal_title}   AT   {$deal.business_name|ucfirst},                {$deal.city_name}. </p>
        <div class="clr"></div>
      </li>
      <li>
     <!-- <li>
        <label>&nbsp;:</label>
        <p class="fl"> {$smarty.session.discount_in_per}% Off On {$smarty.session.deal_title}   AT   {$deal.business_name|ucfirst},                {$deal.city_name}. </p>
        <div class="clr"></div>
      </li>-->
      <li>
        <div class="fl" style=" width:327px">
          <label>Original Price:</label>
          <p class="fl"> S${$smarty.session.original_price} </p>
          <div class="clr"></div>
        </div>
        <div class="fl">
          <label> Discount:</label>
          <p class="fl"> S${$smarty.session.discount} </p>
          <div class="clr"></div>
        </div>
        <div class="clr"></div>
      </li>
      <li>
        <div class="fl" style=" width:327px">
          <label>Offer Price: </label>
          <p class="fl"> S${$smarty.session.offer_price} </p>
          <!--<abbr class="fl">$</abbr>-->
          <div class="clr"></div>
        </div>
		</li><br>
		<li>
        <div class="fl">
          <label>Offer Details: </label>
          <p class="fl"> {$smarty.session.offer_details} </p>
          <div class="clr"></div>
        </div>
      </li>
    </ul>
    <div class="clr"></div>
  </div>
  <div>
    <h3>Why Buy:</h3>
    <ul class="reset deal-from">
      <li>
        <label>1&nbsp;</label>
        <p > {$smarty.session.why_buy1} </p>
        <div class="clr"></div>
      </li>
      <li>
        <label>2 &nbsp;</label>
        <p > {$smarty.session.why_buy2} </p>
        <div class="clr"></div>
      </li>
      <li>
        <label>3 &nbsp;</label>
        <p > {$smarty.session.why_buy3} </p>
        <div class="clr"></div>
      </li>
      <li>
        <label>4 &nbsp;</label>
        <p> {$smarty.session.why_buy4} </p>
        <div class="clr"></div>
      </li>
      <li>
        <label>5 &nbsp;</label>
        <p > {$smarty.session.why_buy5} </p>
        <div class="clr"></div>
      </li>
    </ul>
  </div>
</div>
<div>
<form id="checkbox">
  <ul class="reset deal-from">
    <li>
      <label>Maximum numbers 
        that can be bought:</label>
      <div class="fl">
        <p class="fl">{$smarty.session.max_deal_no}</p>
      </div>
      <div class="clr"></div>
    </li>
    <li>
      <label>Conditions:</label>
      <div >
        <p  style="margin-left:156px;"> {$smarty.session.conditions} </p>
        <div class="clr"></div>
      </div>
    </li><br>
    <li>
      <div class="fl">
        <label>Last Date to Buy Deal:</label>
        <div class="fl">
          <p > {$smarty.session.deal_end_date|date_format} </p>
          <div class="clr"></div>
        </div>
        <div class="clr"></div>
      </div>
</li><br>
<li>
      <div class="fl rel">
        
        <label class="fl">Redeem Between:</label>
        <div class="fl">
          <div class="fl" style="width:235px;top:0px;">
          <p >From - {$smarty.session.redeem_from|date_format}  To   -{$smarty.session.redeem_to|date_format}</p>
        </div>
            <!--<p>From - {$smarty.session.redeem_from|date_format}   To   -{$smarty.session.redeem_to|date_format}</p>-->
           
          <div class="clr"></div>
        </div>
        <div class="clr"></div>
      </div>
      <div class="clr"></div>
    </li>
    <li>
      <label>Valid At Addresses::</label>
      <p class="fl"> {$smarty.session.valid_at_address} </p>
      <div class="clr"></div>
    </li>
    <li>
      <label>Upload a Picture -1:</label>
      <p class="fl"> <img src="{$siteroot}/uploads/deal/thumbnail/{$smarty.session.deal_image}" title="" alt="" width="94" height="94"/> </p>
      <div class="clr"></div>
    </li>

	 <li>
      <label>Upload a Picture -2:</label>
      <p class="fl"> <img src="{$siteroot}/uploads/deal/thumbnail/{$smarty.session.deal_image1}" title="" alt="" width="94" height="94"/> </p>
      <div class="clr"></div>
    </li>

	 <li>
      <label>Upload a Picture -3:</label>
      <p class="fl"> <img src="{$siteroot}/uploads/deal/thumbnail/{$smarty.session.deal_image2}" title="" alt="" width="94" height="94"/> </p>
      <div class="clr"></div>
    </li>
    <li>
      <label>Send to:</label>
      <div class="fl" style="margin-left:30px">
        <input  type="checkbox" name="fan_only" value="fan_only"  {if $smarty.session.send_to_fan eq 'fan_only'} checked="true" {/if} class="styled">
        <p class="fl forminntxt" style="line-height:15px"> Fans Only</p>
      </div>
      <div class="fl" style="margin-left:30px">
        <input type="checkbox" name="all" value="all" {if $smarty.session.send_to_all eq 'all'} checked="true" {/if}  class="styled"  >
        <p class="fl forminntxt" style="line-height:15px" > All who are interested in category</p>
      </div>
      <div class="clr"></div>
    </li>
  </ul>
</form>
<div class="clr"></div>
</div>
<div class="pre-btn" style="width:365px;">
  <input type="submit" value="Send Deal to Customers" name="Submit" id="Submit" class="previe-btn fl" style="width:245px" />
  <input type="button" value="Back" name="Back" id="Back"   onclick="go_back()"  class="previe-btn fr" style="width:92px" />
</div>
</div>
</div>
</form>
<!-- Maincontent ends -->
<!-- Footer starts -->
{include file=$footer}