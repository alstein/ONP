{include file=$header_start}
{literal}
<script type="text/javascript" language="JavaScript">
$(document).ready(function(){
	$.post(SITEROOT+'/modules/deal/ajax_deal_bought_consumer.php',{},function(data){
		$("#deals_consumer_bought").html(data);
		$("#1").addClass("active");
		$("#2").removeClass("active");
	});
});

function ajax_deal_bought_consumer(){
	$.post(SITEROOT+'/modules/deal/ajax_deal_bought_consumer.php',{},function(data){
		$("#deals_consumer_bought").html(data);
		$("#1").addClass("active");
		$("#2").removeClass("active");
	});
}

function ajax_deal_offered_consumer(){
	$.post(SITEROOT+'/modules/deal/ajax_deal_offered_consumer.php',{},function(data){
		$("#deals_consumer_bought").html(data);
		$("#2").addClass("active");
		$("#1").removeClass("active");
	});
}

function view_coupans(userid,deal_id){
	$.post(SITEROOT+'/modules/deal/ajax_view_coupans.php',{userid:userid,deal_id:deal_id},function(data){
		$("#deals_consumer_bought").html(data);
		$("#1").addClass("active");
		$("#2").removeClass("active");
	});
}

function view_voucher(val)
{
	//alert(val);
	window.open(SITEROOT+'/modules/deal/view_voucher.php?id='+val,'PrintDocument','scrollbars=yes, resizable=yes, copyhistory=yes, width=800, height=600, left=300, top=250');
	//window.location.reload();
}

</script>
{/literal}

 {include file=$profile_header2}
<!-- main continer of the page -->


  <!-- Maincontent starts -->

  <div id="maincont" class="ovfl-hidden">

    <div class="about-us">

      <h1>My offers</h1>

      <div class="deal-history">

        <div class="live-wire" style="margin:10px 0 0 0">

         

          <ul class="reset">

            <li ><a href="javascript:void(0)" id="1" onclick="ajax_deal_bought_consumer()" class="bought-deal-new"></a></li>

            <li><a href="javascript:void(0)" id="2" onclick="ajax_deal_offered_consumer()" class="offer-deal-new"></a></li>

          </ul>

          <div class="clr"></div>

        </div>

        <div class="clr"></div>


		<div id="deals_consumer_bought"></div>

<!--        <div class="inbox-tbl">

          <div class="deal-tbl-main">

			
            <table width="940" cellpadding="0" cellspacing="0" border="0">

              <tr>

                <th width="250" align="center"> Deals Headline</th>

                <th width="150" scope="col" align="center">Merchant </th>

                <th width="100" scope="col" align="center">Date Bought</th>

                <th width="100" scope="col" align="center">Redeem Till </th>

                <th width="100" scope="col" align="center">Original Price</th>

                <th width="100" scope="col" align="center">Offer Price</th>

                <th width="80" scope="col" align="center">Savings</th>

                <th class="last" width="127" scope="col" align="left" style="border:none">Coupons</th>

              </tr>

              <tr>

                <td colspan="8" align="center" height="35">No Records Found</td>

              </tr>

            </table>

          </div>

        </div>
-->
      </div>

    </div>

  </div>

  <!-- Maincontent ends -->

</div>

<!-- Footer starts -->

{include file=$footer}