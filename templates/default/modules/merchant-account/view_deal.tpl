{include file=$header_start}
<body class="inner_body">
{include file=$profile_header2}
<!-- main continer of the page -->
<div id="wrapper">
  <!-- header container starts here-->

  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont">
    <div class="marchant-form-main" style="width:590px;">
      <h1>View A deal Offered by Customer</h1>
      <!-- / registration form start here -->


      <div class="marchant-form_bg" style="width:590px;">


        <div class="form-title">View Deal:</div>
        <div class="create-deal">
          <ul class="fl create-deal-form reset">
{if $smarty.session.csUserTypeId eq '2'}
            <li>
              <label>Business Name:</label>
              <div class="fl" style="padding-top:7px;">
                {$res_merchant_det.business_name}
              </div>
            </li>
{else}
            <li>
              <label>Customer Name:</label>
              <div class="fl" style="padding-top:7px;">
                {$res_cust_det.fullname}
              </div>
            </li>

{/if}
            <li>
              <label>Permanant Addres:</label>
              <div class="fl" style="padding-top:7px;">
              {$res_merchant_det.address1}
              </div>
            </li>
            <li>
              <label>Phone No. :</label>
              <div class="fl" style="padding-top:7px;">
                 {$res_merchant_det.contact_detail}
              </div>
            </li>

          <!--  <li>
              <label>Product Name:</label>
              <div class="fl" style="padding-top:7px;">
                    {$res_merchant_det.product_name}
              </div>
            </li>-->



            <li>
              <label>Amount to be spend:</label>
              <div class="fl" style="padding-top:7px;">
				$ {$res_merchant_det.amount_spend}
              </div>
            </li>

            <li>
              <label>Discount request:</label>
              <div class="fl" style="padding-top:7px;">
				{$res_merchant_det.discount}%
              </div>
            </li>
            <li>
              <label>Net ammount to be spend:</label>
              <div class="fl" style="padding-top:7px;">
				$ {$res_merchant_det.outflow}
              </div>
            </li>


            <li>
              <label>I would like to:</label>
               <div class="fl">
                  <input class="signinput" name="redeemflag" type="radio" id="redeemflag" size="25" class="textbox fl" style="width:15px" {if  $res_merchant_det.redeemtype eq '1' } checked="true" {/if} disabled="true"/>&nbsp;&nbsp;Redeem Only on a specific day &nbsp;&nbsp;<input class="signinput" name="redeemflag" type="radio" id="redeemflag" size="25" class="textbox fl" style="width:15px" {if  $res_merchant_det.redeemtype eq '0' } checked="true" {/if} disabled="true"/>&nbsp;&nbsp;Open on dates.
                  <div class="clr"></div>
                  <div class="error" htmlfor="redeemflag" generated="true"></div>
                </div>
            </li>


{if $res_merchant_det.redeemtype eq '1'}
            <li>
              <label>Redeem On:</label>
              <div class="fl" style="margin-right:8px;padding-top:7px;"> 
                {$res_merchant_det.redeem_from|date_format:"%e %B %Y"}
              </div>
            </li>

{else if $res_merchant_det.redeemtype eq '0'}
            <li>
              <label>Redeem Between:</label>
              <div class="fl" style="margin-right:8px;padding-top:7px;"> 
                From &nbsp; &nbsp;{$res_merchant_det.redeem_from|date_format:"%e %B %Y"}&nbsp; &nbsp;To&nbsp; &nbsp; {$res_merchant_det.redeem_to|date_format:"%e %B %Y"}  
              </div>
            </li>

{/if}



            <li>
              <label>Amount paid by consumer:</label>
              <div class="fl" style="margin-right:8px;padding-top:7px;">
				${$res_merchant_det.amt_to_pin}    
            </li>

           <li>
              <label>Bid valid till:</label>
              <div class="fl" style="margin-right:8px;padding-top:7px;">
				 {$res_merchant_det.bid_validity|date_format:"%e %B %Y"}    
              </div>
            </li>
 

            <li>
              <label>Amount to pay merchant:</label>
              <div class="fl" style="margin-right:8px;padding-top:7px;">
					${$res_merchant_det.accepted_to_paid}    
              </div>
            </li>

			<li>
              <label style="line-height:12px"> Available on Weekends on case to case basis:</label>
              <div class="fl">
                <p class="fl">
                 <input type="radio" name="weekends" id="weekends" {if $deal_cond_row.offer_weekend eq 'yes'} checked="true"{/if} disabled="true">
                  &nbsp;&nbsp;<span class="from-text">Yes</span></p>
                <p class="fl" style="margin-left:10px">
                 <input type="radio" name="weekends" id="weekends"  {if $deal_cond_row.offer_weekend eq 'no'} checked="true"{/if} disabled="true">
                  &nbsp;&nbsp;<span class="from-text">No</span></p>
              </div>
            </li>

			<li>
              <label>Conditions:</label>
              <div class="fl" style="margin-right:8px;padding-top:7px;">
				{$res_merchant_det.condition}    
              </div>
             </li>

            
            
            
            
            <li>
              <label>&nbsp;</label>
              <div class="fl">
               <!-- <p class="fl">
                  <input type="checkbox" name="terms" id="terms" checked="true" disabled="true"/>
                  &nbsp;&nbsp;<span class="from-text">Agree to Terms & Conditions</span></p>-->
				
                <p class="fl" style="margin-left:10px">
                  <input type="checkbox" name="addto_live_wire" id="addto_live_wire" {if $smarty.post.addto_live_wire} checked="true"{/if} disabled="true" value="{$smarty.post.addto_live_wire}"/>
                  &nbsp;&nbsp;<span class="from-text">Add this to my live wire</span></p>
              </div>
			<div class="clr"></div>
			<div class="error" htmlfor="terms" generated="true" style="padding-left: 156px;"></div>
            </li>
            
          </ul>
        </div>
        <div class="clr"></div>
      </div>
      <!-- / registration form end here -->

    </div>
{include file=$footer}
  </div>
</div>
</body>
</html>
