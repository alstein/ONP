{include file=$header_start}

<body class="inner_body">
 {include file=$profile_header2}
<!-- main continer of the page -->
<div id="wrapper">

  <!-- header container starts here-->
  <div id="inner_header">
    <div class="ovfl-hidden">
  
      <div class="help fr">
        <h2><a href="#">Help</a></h2>
      </div>
    </div>
  </div>
  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont">
    <div class="northspace-4">
      <h1 class="deal-info-title">My deal history</h1>
      <div class="deal-info-main">
        <div class="dealinfo-nav">
          <ul class="reset deal-nav">
            <li><a href="javascript:void(0)"  class="active">Deals Notifications <abbr></abbr></a></li>
          </ul>
          <div class="clr"></div>
        </div>
        <div class="deal-tbl-main">
			<div id="deals_consumer_bought">

        <div class="deal-tbl-main">
          <table width="953" border="0" cellspacing="0" cellpadding="0" class="deal-tbl">
            <tr>
              <th scope="col" width="188" align="left"><span style="padding-left:15px">Message</span></th>
             <!-- <th scope="col" width="109">Deal Title</th>-->
			  <th scope="col" width="90">Date Offered </th>
            </tr>
{section name=i loop=$deals}
            <tr>
              <td align="left"><span style="padding-left:15px; display:block"><a><a href="{$siteroot}/merchant-account/{$deals[i].offer_deal_id}/view_deal/" target="_blank">{$deals[i].business_name} {if $deals[i].status eq 'yes'}accepted {elseif $deals[i].status eq 'no'} rejected {/if}deal offered by {$deals[i].fullname} </a></strong></span></td>
              <!--<td align="center">{$deals[i].product_name}</td>-->
			  <td align="center">{$deals[i].offerdate|date_format:"%e %B %Y"}</td>
            </tr>
{sectionelse}
			<tr><td colspan="2" align="center">No deals Found</td></tr>
{/section}

		<tr><TD colspan="2"><div style="padding-left:700px">
	<strong>{$pgnation}</strong>
</div></TD></tr>


          </table>
        </div>

			</div>
        </div>
      </div>
    </div>
  </div>
 {include file=$footer}
</div>
</body>
</html>
