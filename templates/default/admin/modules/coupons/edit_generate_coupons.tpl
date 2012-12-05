{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
<!--<script type="text/javascript" src="{$siteroot}/js/validator.js"></script>
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.pack.js"></script>-->
<script language="JavaScript" src="{$siteroot}/js/validation/admin/coupons.js"></script>

{literal}
<script type="text/javascript">
$(function () {
$('#frm').submit(function() {

                var docFrm=document.frm;
                var coupEndDate = new Date($('#expire_date_Year_ID').val(), $('#expire_date_Month_ID').val(), $('#expire_date_Day_ID').val());
                var today = new Date();
                var error = 'no';

                $('#error_coupEndDate').hide();
                $('#error_coupon_credit_price').hide();

                $('#error_coupEndDate').html('');
                $('#error_coupon_credit_price').html('');
                
                if (coupEndDate < today) {
                     var error = 'yes';
                     $('#error_coupEndDate').show();
                     $('#error_coupEndDate').html("Promotional Expire Date should be greater than or equal to Current Date");

                }else
                {
                     $('#error_coupEndDate').hide();
                     $('#error_coupEndDate').html('');
                }

                //check if .(decimal) point is not more than one time in value and . not at first position
                //coupon credit price
//                 var coupCreditprice = $('#credit_amount').val();
//                 var totDotIncoupCreditprice = 0;
//                 var noFirstDotIncoupCreditprice = 'no';
//                 for(var i=0; i<coupCreditprice.length;i++)
//                 {
//                   if(coupCreditprice[0] == '.')
//                   {
//                      noFirstDotIncoupCreditprice = 'yes';
//                   }
//                   if(coupCreditprice[i] == '.')
//                   {
//                      totDotIncoupCreditprice++;
//                   }
//                 }
// 
//                 if(totDotIncoupCreditprice > 1 || noFirstDotIncoupCreditprice == 'yes')
//                 {
//                      var error = 'yes';
//                      $('#error_coupon_credit_price').show();
//                      $('#error_coupon_credit_price').html("Please enter valid promotional credit price");
//                 }else
//                 {
//                      $('#error_coupon_credit_price').hide();
//                      $('#error_coupon_credit_price').html('');
//                 }
// 
//                 if(error == 'yes')
//                 {
//                      return false;
//                 }
            });
});
</script>
{/literal}

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;
   <a href="{$siteroot}/admin/modules/generate_coupons_list.php"> Promotional Code List</a> &gt;
{if $smarty.get.edit_id} Edit Promotional Code{else} Add Promotional Code{/if}</div><br/>

<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle}   Manage Promotional Code</h3>
	  </div>
          <div class="clr">&nbsp;</div>
     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
	</div>

      <div class="clr">&nbsp; </div>
    <div id="UserListDiv" name="UserListDiv">
  
    <form name="frm" action="" id="frm" method="post" enctype="multipart/form-data">
       <input type="hidden" value="{$smarty.get.edit_id}" name="id_name" id="id_name" />
      <table width="100%" border="0" cellspacing="2" cellpadding="6" class="conttableDkBg conttable">
       <tr>
            <td colspan="2" align="right"><a href="generate_coupons_list.php">
             <strong>Back</strong></a></td>
	</tr>
      <tr> 
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span><strong>Amount as Promotional Code</strong>:</td> 
           <td align="left" width="40%">&nbsp;</td>
        </tr>
        <tr> 
           <td width="20%" align="right" valign="top" ><span style="color:red;">*</span> Pound (&#163;):&nbsp;</td> 
           <td align="left" width="40%">
                <input type="text" name="credit_amount_pound" id="credit_amount_pound" style="width:313px" value="{$coupondet.credit_amount_pound}"/>
                <div class="error" id="credit_amount_pound" style="display:none;"></div></td> 
        </tr>
        
        <tr> 
           <td width="20%" align="right" valign="top" ><span style="color:red;">*</span> Euro (&#8364;):&nbsp;</td> 
           <td align="left" width="40%">
                <input type="text" name="credit_amount_euro" id="credit_amount_euro" style="width:313px" value="{$coupondet.credit_amount_euro}"/>
                <div class="error" id="credit_amount_euro" style="display:none;"></div></td> 
        </tr>
        <tr> 
           <td width="20%" align="right" valign="top" ><span style="color:red;">*</span> Dollar ($):&nbsp;</td> 
           <td align="left" width="40%">
                <input type="text" name="credit_amount_dollar" id="credit_amount_dollar" style="width:313px" value="{$coupondet.credit_amount_pound}"/>
                <div class="error" id="credit_amount_dollar" style="display:none;"></div></td> 
        </tr>
        <tr>
            <td width="20%" align="right" ><span style="color:red;">*</span>Number of Promotional Code :&nbsp;</td>
            <td align="left">
                <input type="text" name="no_of_coupons" id="no_of_coupons"  style="width:313px" value="{$coupondet.no_of_coupons}" />
            </td>
	</tr>
	
        <tr>
            <td width="20%" align="right" ><span style="color:red;">*</span>Expiration Date :&nbsp;</td>
            <td align="left">
                {if $coupondet.expire_date}
                        <script type="text/javascript">
                            DateInput('expire_date', true, 'YYYY-MM-DD' ,'{$coupondet.expire_date|date_format:"%y-%m-%d"}');
                        </script>
                {else}
                        <script type="text/javascript">DateInput('expire_date', true, 'YYYY-MM-DD');</script>
                {/if}
                    <div class="error" id="error_coupEndDate" style="display:none;"></div>
             </td>
	</tr> 
        <tr>
            <td>&nbsp;</td>
            <td align="left">
                    <div style="width:140px"> 
                        <div id="buttonregister" style="overflow:hidden">
                                <input type="submit" name="submit" class="but_new fl" value="Add">
                                <input type="button"  value="Cancel" class="but_new fr" onclick="history.go(-1)">
                        </div>
                    </div>
            </td>
        </tr>
  </table>
  </form> 
</div>
</div>
{include file=$footer}
