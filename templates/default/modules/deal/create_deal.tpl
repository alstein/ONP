{include file=$header_start}

{strip}
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/validation/create_deal.js"> </script>
{/strip}
{literal}
<script language="JavaScript" type="text/javascript">

function getPercentage(orgPrice)
{
	var discount = document.getElementById('sel_off').value;

	if(discount){ var discount = discount; }else{ var discount = 0; }
	
	if(discount){
	var discount_price = ((parseFloat(discount) / 100) * parseFloat(orgPrice)).toFixed(1);
	}else{
	var discount_price = 0;
	}

	var offer_price= (parseFloat(orgPrice) - parseFloat(discount_price)).toFixed(1);

	document.getElementById('discount').value = discount_price;
	document.getElementById('offer_price').value = offer_price;
}

function show_percentage(val)
{
    alert(val);
    if(val>100)
    {
        alert("please enter % less than 100");
    }
}



</script>
{/literal}
  <!-- Header starts -->
  {include file=$profile_header2}
  <!-- Header ends -->
  <!-- Maincontent starts -->
	<form name="frm" id="frm" method="POST" enctype="multipart/form-data">
  <div id="maincont">
    <div class="create-deal">
      <h1>Create Your Own Offer</h1>
      <div class="deal-head">
        <h2>For Your Customers</h2>
      </div>
      <div class="deal-own-form">
        <div class="deal-own-form-top">
	
          <ul class="reset deal-form">
            <!--<li>
                <label>Category:</label>
                <div class="category-bg  fl">
                    <select name="category" id="category" style="width:178px;" class="select">
                        <option value="">Select your category</option>
                        <option value="deal_as_usual" {if $smarty.session.deal_category eq 'deal_as_usual'} selected="selected"{/if}>My Fav Offers</option>
                        <option value="right_now_deal" {if $smarty.session.deal_category eq 'right_now_deal'} selected="selected"{/if}>Hurry Up Offers</option>
                    </select>
               </div>
                <div class="clr"></div>
                <div class="fr" style="margin-right: 405px;margin-top: -28px;">
                    <ul class="reset icn-link" style="padding:0px">
                        <li>
                            <a href="javascript:void(0);" class="icn-link01 ">What's it?</a>
                            <div class="tooltip">
                                <span class="arrow">&nbsp;</span>
                                <div class="top01"><div></div></div>
                                <div class="mid" style="padding-bottom:5px">For offers with urgent redemption, consider choosing Hurry Up Offers.</div>
                                <div class="bot01"><div></div></div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="error" htmlfor="category" generated="true" style="margin-left: 172px;"></div>
            </li>-->
            <li>
              <label>Deal Headline:</label>
              <div class="fl deal-textbox">
               	<input type="text"  name="sel_off" id="sel_off" style="width:40px;" value="{$smarty.session.discount_in_per}">
              </div>
              <p class="fl" style="margin-left:10px">% Off On</p>
              <div class="clr"></div>
				<div class="error" htmlfor="sel_off" generated="true" style="margin-left: 172px;"></div>
              <label>&nbsp;</label>
              <div class="fl textbox">
             <input name="deal_name" id="deal_name" type="text"  value=" {$smarty.session.deal_title}"  />
              </div>
              <p class="fl" style="margin-left:10px">AT {$address.business_name}, {$address.city_name}.</p>
              <div class="clr"></div>
				<div class="error" htmlfor="deal_name" generated="true" style="margin-left: 172px;"></div>
            </li>
            <li>
              <div class="fl">
                <label>Original Price:</label>
                <div class="fl textbox">
                <input type="text" name="originalprice" id="originalprice" value="{$smarty.session.original_price}"  onChange="getPercentage(this.value)" onBlur="getPercentage(this.value)" onClick="getPercentage(this.value)" maxlength="7">
                </div>
                <abbr class="fl">S$</abbr>
                <div class="clr"></div>
              </div>
              <div class="fl">
                <label> Discount:</label>
                <div class="fl textbox">
                <input name="discount" id="discount" readonly="true" type="text"  value="{$smarty.session.discount}" />
                </div>
                <abbr class="fl">S$</abbr>
                <div class="clr"></div>
              </div>
              <div class="clr"></div>
            </li>
            <li>
              <div class="fl">
                <label>Offer Price: </label>
                <div class="fl textbox">
                 <input name="offer_price" id="offer_price" readonly="true" type="text"  value="{$smarty.session.offer_price}" />
                </div>
                <abbr class="fl">S$</abbr>
                <div class="clr"></div>
              </div>
              <div class="fl">
                <label>Offer Details: </label>
                <div class="fl offer-textbox">
				<textarea name="offer_details" id="offer_details"  class="offer-inpout" rows="3" cols="10">{$smarty.session.offer_details}</textarea>
                
                </div>
                <div class="clr"></div>
               <div class="fr" style="margin-top:-6px; margin-left:10px">
            <ul class="reset icn-link" style="padding:0px">
        <li><a href="#" class="icn-link01 ">What's it?</a>
        <div class="tooltip">
        <span class="arrow">&nbsp;</span>
        <div class="top01"><div></div></div>
       <div class="mid" style="padding-bottom:5px">Write some key points
on the offer deal.</div>
       <div class="bot01"><div></div></div>
        </div>
        </li>
        
        </ul>
        
       
        	</div>
              <div class="clr"></div>
            </li>
          </ul>
          <div class="clr"></div>
        </div>
        <div class="deal-own-form-mid">
          <h3>Why Buy:</h3>
          <ul class="reset deal-form">
            <li>
              <label>1</label>
              <div class="fl buy-textbox">
                <input name="why_buy1" id="why_buy1" type="text"  value="{$smarty.session.why_buy1}" />
              </div>
              <div class="clr"></div>
            </li>
            <li>
              <label>2</label>
              <div class="fl buy-textbox">
                 <input name="why_buy2" id="why_buy2" type="text"  value="{$smarty.session.why_buy2}" />
              </div>
              <div class="clr"></div>
            </li>
            <li>
              <label>3</label>
              <div class="fl buy-textbox">
                 <input name="why_buy3" id="why_buy3" type="text"  value="{$smarty.session.why_buy3}" />
              </div>
              <div class="clr"></div>
            </li>
            <li>
              <label>4</label>
              <div class="fl buy-textbox">
               <input name="why_buy4" id="why_buy4" type="text"  value="{$smarty.session.why_buy4}" />
              </div>
              <div class="clr"></div>
            </li>
            <li>
              <label>5</label>
              <div class="fl buy-textbox">
                <input name="why_buy5" id="why_buy5" type="text" value="{$smarty.session.why_buy5}" />
              </div>
              <div class="clr"></div>
            </li>
          </ul>
        </div>
        <div class="deal-own-form-mid">
         <form id="checkbox">
          <ul class="reset deal-form">
            <li>
              <label>Maximum numbers 
                that can be bought:</label>
              <div class="fl textbox">
                 <input name="max_number" id="max_number"  type="text"  value="{$smarty.session.max_deal_no}" />
              </div>
              <div class="clr"></div>
            </li>
            <li>
              <label>Conditions:</label>
              <div class="fl">
                <div class="conditon-textbox">
				   
                  <textarea name="condition" id="condition"  cols="10" rows="3" class="conditon-inpout">{$smarty.session.conditions}</textarea>
                </div>
                <div class="clr"></div>
               <div class="fr" style="margin-top:-6px; margin-left:10px">
            <ul class="reset icn-link" style="padding:0px">
        <li><a href="javascript:void(0);" class="icn-link01 ">What's it?</a>
        <div class="tooltip">
        <span class="arrow">&nbsp;</span>
        <div class="top01"><div></div></div>
       <div class="mid" style="padding-bottom:5px">Description here......</div>
       <div class="bot01"><div></div></div>
        </div>
        </li>
        
        </ul>
        
       
        	</div>
              <div class="clr"></div>
            </li>
            <li>
              <div class="fl">
                <label>Last Date to Buy Deal:</label>
                <div class="fl">
                  <div >
                    {if $smarty.session.deal_end_date}
					<script type="text/javascript">DateInput('lastdate', true, 'YYYY-MM-DD','{$smarty.session.deal_end_date}');</script>
					{else}
					<script type="text/javascript">DateInput('lastdate', true, 'YYYY-MM-DD');</script>
					{/if}
                  </div>
                  
                  
                  <div class="clr"></div>
                </div>
             <a href="javascript:void(0);" > &nbsp; </a>
                <div class="clr"></div>
              </div>
              <div class="fl rel">
                <div class="day-txt">
                  <p>From</p>
                </div>
                <label>Redeem Between:</label>
                <div class="fl">
                  <div >
                   {if $smarty.session.redeem_from neq ''}
                     <script type="text/javascript">DateInput('redeemfrom', true, 'YYYY-MM-DD','{$smarty.session.redeem_from}');</script>
					{else}
						<script type="text/javascript">DateInput('redeemfrom', true, 'YYYY-MM-DD');</script>	
					{/if}
                  </div>
                  
                  
                  <div class="clr"></div>
                </div>
                <a href="javascript:void(0);" > &nbsp; </a>
                <div class="clr"></div>
              </div>
              <div class="clr"></div>
				<div class="error" htmlfor="lastdate" generated="true" style="margin-left: 143px;" ></div>

            </li>
            <li>
              <div class="fl">
                <label>&nbsp;</label>
                <div style="width:252px" class="fl"> </div>
                <div class="clr"></div>
              </div>
              <div class="fl rel">
                <div class="day-txt">
                  <p style=" margin-left: -46px;">To</p>
                </div>
                <!--<label>&nbsp;</label>-->
                <div class="fl">
                  <div style="margin-left:64px;">
                   {if $smarty.session.redeem_to neq ''}
               	      <script type="text/javascript">DateInput('redeemto', true, 'YYYY-MM-DD','{$smarty.session.redeem_to}');</script>
					{else}
							<script type="text/javascript">DateInput('redeemto', true, 'YYYY-MM-DD');</script>
					{/if}
                  </div>

                  <div class="clr"></div>
					<div class="error" htmlfor="redeemfrom" generated="true" style="display: block;" style="margin-left:172px;"></div>
					<div class="error" htmlfor="redeemto" generated="true" style="display: block;" style="margin-left:172px;"></div>

                </div>
                <a href="javascript:void(0);" > &nbsp; </a>
                <div class="clr"></div>
              </div>
              <div class="clr"></div>
            </li>
            <li>
              <label>Valid At Addresses::</label>
              <div class="category-bg  fl">
				<select name="address" id="address" style="width:178px;" class="select" >
				<option value="">select Address</option>
				{if $address.address1 neq ''}<option value="{$address.address1}" {if $smarty.session.valid_at_address eq $address.address1 } selected="selected" {/if}>{$address.address1}</option>{/if}
				{if $address.address2 neq ''}<option value="{$address.address2}" {if $smarty.session.valid_at_address eq $address.address2 } selected="selected" {/if}>{$address.address2}</option>{/if}
				{if $address.address3 neq ''}<option value="{$address.address3}" {if $smarty.session.valid_at_address eq $address.address3 } selected="selected" {/if}>{$address.address3}</option>{/if}
				{if $address.address4 neq ''}<option value="{$address.address4}" {if $smarty.session.valid_at_address eq $address.address4 } selected="selected" {/if}>{$address.address4}</option>{/if}
				{if $address.address5 neq ''}<option value="{$address.address5}" {if $smarty.session.valid_at_address eq $address.address5 } selected="selected" {/if}>{$address.address5}</option>{/if}
				</select>

              </div>
              <div class="clr"></div>
            </li>
          <br/>
<br/>
<br/>          <br/>

           <li>
               <label style="padding-right:30px;">Shipping Options::</label>
             
                I would ship. Cash on Delivery    <input type="radio" id="shipping-add" name="shipping-addr" value="1" /> <span style="padding-left:20px;"></span>
                Customer would get product/service at my outlet     <input type="radio" id="no-shipping-add" name="shipping-addr" value="0" /><br/><br/>
           
           </li>

            <li>
              <label>Upload a Picture-1:</label>
              <div class="file-set fl">
               <input name="deal_photo" id="deal_photo" contenteditable="false" type="file"  value="" />
              </div>
              <div class="clr"></div>
            </li>
			
			<li>
              <label>Upload a Picture-2:</label>
              <div class="file-set fl">
               <input name="deal_photo1" id="deal_photo1" contenteditable="false" type="file"  value="" />
              </div>
              <div class="clr"></div>
            </li>
			
			<li>
              <label>Upload a Picture-3:</label>
              <div class="file-set fl">
               <input name="deal_photo2" id="deal_photo2" contenteditable="false" type="file"  value="" />
              </div>
              <div class="clr"></div>
            </li>
		{if $smarty.session.deal_image neq ''}

			<li>
              <label>Picture:</label>
                 <div class="fl"> <a href="#" class="dealphoto"><img src="{$siteroot}/uploads/deal/{$smarty.session.deal_image}" title="" alt="" width="94" height="94"/></a> </div>
            </li>

			{/if}
		{if $smarty.session.deal_image1 neq ''}

			<li>
              <label>Picture:</label>
                 <div class="fl"> <a href="#" class="dealphoto"><img src="{$siteroot}/uploads/deal/{$smarty.session.deal_image1}" title="" alt="" width="94" height="94"/></a> </div>
            </li>

			{/if}
			
		{if $smarty.session.deal_image2 neq ''}

			<li>
              <label>Picture:</label>
                 <div class="fl"> <a href="#" class="dealphoto"><img src="{$siteroot}/uploads/deal/{$smarty.session.deal_image2}" title="" alt="" width="94" height="94"/></a> </div>
            </li>

			{/if}
			
            <li>
              <label>Send to:</label>
              <div class="fl" style="margin-left:30px">
		
             <input type="checkbox"  class="styled" name="fan_only" id="fan_only" value="fan_only" {if $smarty.session.send_to_fan eq 'fan_only'} checked="true" {/if}/>
			
			    <p class="fl forminntxt" style="line-height:15px;"> Fans Only</p>
			  </div>
              <div class="fl" style="margin-left:30px">
			
                <input type="checkbox" class="styled"  name="all" id="all" value="all" {if $smarty.session.send_to_all eq 'all'} checked="true" {/if}/>
                <p class="fl forminntxt" style="line-height:15px" > All who are interested in category</p>
              </div>
              <div class="clr"></div>
				<div class="error" htmlfor="all" generated="true" style="margin-left:172px;"></div>
            </li>
          </ul>
          </form>
        </div>
      </div>
      <div class="pre-btn">
		<input class="previe-btn" style="width:92px" type="submit" value="Preview" name="Submit" id="Submit"   />
    
      </div>
    </div>
</form>
    <!-- Maincontent ends -->
  </div>
</div>
<!-- Footer starts -->
   {include file=$footer}