{include file=$header_start}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery.timeago.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>

{/strip}
{literal}
<script type="text/javascript">
  jQuery(document).ready(function()
    {
		var id1 = '{/literal}{$smarty.get.id1}{literal}';
	    jQuery('#show_thread').html("<img src='"+SITEROOT+"/templates/default/images/site/coming_soon/loadingAnimation.gif' alt='loading' />");
		incoming_deal();
    });
function incoming_deal(obj)
	{
		var id1 = '{/literal}{$smarty.get.id1}{literal}';
	    	cmt_url = SITEROOT+"/modules/merchant-account/incoming_deal.php";
		jQuery.get(cmt_url,{id1:id1},function(data)
		{
			jQuery("#show_thread").html(data);
			$('#incoming_deal').addClass("active");
			$('#offer_deal').removeClass("active");
			
		});

	}
function deal_offered(obj)
	{
			var id1 = '{/literal}{$smarty.get.id1}{literal}';
	    	cmt_url = SITEROOT+"/modules/merchant-account/deal_offered.php";
		
	    	jQuery.get(cmt_url,{id1:id1},function(data)
		{
			jQuery("#show_thread").html(data);
			$('#offer_deal').addClass("active");
			$('#incoming_deal').removeClass("active");
			
		});

	}
</script>

<script type="text/javascript">

function goto_docapture(dstatus,id,authorisation_id,currency_code,amt,userid)
{
/*
alert(val);
alert(dstatus);
alert(id);
 alert(authorisation_id);
alert(currency_code);
 alert(amt);*/
var val=$("#txt_val").val();
if(val=='accept')
{
alert(amt);
window.location = SITEROOT+"/php_nvp_samples/DoCapture.php?status=yes&id="+id+"&authorisation_id="+authorisation_id+"&currency_code="+currency_code+"&amt="+amt;


}
else if(val=='reject')
{


 window.location = SITEROOT+"/merchant-account/"+userid+"/rejected/"+id+"/offer_deal_request";
}
}
function get_val(val)
{
document.getElementById("txt_val").value=val;
}
function openPDF(val)
{

	window.open(SITEROOT+'/modules/merchant-account/coupon_pdf.php?id='+val,'PrintDocument','scrollbars=yes, resizable=yes, copyhistory=yes, width=800, height=600, left=300, top=250');
	window.location.reload();
}
</script>

{/literal}
  <!-- Header starts -->
   {include file=$profile_header2}
  <!-- Header ends -->
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
    <div class="about-us">
      <h1>My Offers</h1>
      <div class="deal-history">
        <div class="live-wire">
          <h1>&nbsp; </h1>
          <ul class="reset">
            <li><a href="javascript:void(0);" id="incoming_deal" onclick="incoming_deal(this);" class="incoming-deal-new" ></a></li>
            <li><a href="javascript:void(0);" id="offer_deal" onclick="deal_offered(this);" class="offer-cre" ></a></li>
          </ul>
          <div class="clr"></div>
        </div>
          <div class="deal-tbl-main" id="show_thread">

      </div>
    </div>
  </div>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->
 {include file=$footer}