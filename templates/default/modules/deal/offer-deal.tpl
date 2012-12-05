{include file=$header_start}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/validate_offer_deal.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
{/strip}
<body class="inner_body">
<!-- main continer of the page -->
<div id="wrapper">
  <!-- header container starts here-->
  {include file=$profile_header2}
  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont">
    <!-- Left content Start here -->
    {include file=$profile_left}
    <!-- Middel content Start here -->
    <div class="profile-middel">
      <h2 style="margin-left:20px;color: #2B587A" >Create Deal Offer</h2>
      <br>
      <form name="frmdeal" id="frmdeal" action="" method="post">
        <table cellspacing="5" cellpadding="5" width="100%" border="0" align="center">
          <tr>
            <td align="right" valign="top" width="40%" class="profile-name" ><span style="color:red">*</span> Business Name:</td>
            <td align="left" width="60%"><input class="signinput" name="business_name" type="text" id="business_name" value="{$smarty.post.business_name}" 
			size="25" class="textbox fl"/>
              <div class="clr"></div>
              <div class="error" htmlfor="business_name" generated="true"></div></td>
          </tr>
          <tr>
            <td align="right" valign="top" width="40%" class="profile-name" ><span style="color:red">*</span> Address: </td>
            <td align="left" width="60%"><textarea class="signinput" name="address" id="address" class="textbox fl" rows="4" cols="33">
              {$smarty.post.address}
              </textarea>
              <div class="clr"></div>
              <div class="error" htmlfor="address" generated="true"></div></td>
          </tr>
          <tr>
            <td align="right" valign="top" class="profile-name"  ><span style="color:red">*</span> Phone No:</td>
            <td align="left" ><input class="signinput" name="phone_no" type="text" id="phone_no" value="{$smarty.post.phone_no}"  size="25" class="textbox fl"/>
              <div class="clr"></div>
              <div class="error" htmlfor="phone_no" generated="true"></div></td>
          </tr>
          <tr>
            <td align="right" valign="top" width="40%" class="profile-name" ><span style="color:red">*</span>Amount To Be Spend: </td>
            <td align="left" width="60%"><input class="signinput" name="amt_spend" type="text" id="amt_spend" value="{$smarty.post.amt_spend}"  size="25" class="textbox fl"/>
              <div class="clr"></div>
              <div class="error" htmlfor="rel_status" generated="true"></div></td>
          </tr>
          <tr>
            <td align="right" valign="top" width="40%" class="profile-name" ><span style="color:red">*</span>Discount Requested: </td>
            <td align="left" width="60%"><input class="signinput" name="discount" type="text" id="discount" value="{$smarty.post.discount}"  size="25" class="textbox fl"/>
              <div class="clr"></div>
              <div class="error" htmlfor="rel_status" generated="true"></div></td>
          </tr>
          <tr>
            <td align="right" valign="top" width="40%" class="profile-name" ><span style="color:red">*</span>OutFlow: </td>
            <td align="left" width="60%"><input class="signinput" name="outflow" type="text" id="outflow" value="{$smarty.post.outflow}"  size="25" class="textbox fl"/>
              <div class="clr"></div>
              <div class="error" htmlfor="rel_status" generated="true"></div></td>
          </tr>
          <tr>
            <td align="right" valign="top" width="40%" class="profile-name" >
            <span style="color:red">*</span>Redeem From: </td>
            <td align="left" width="60%"><script type="text/javascript">DateInput('redeem_from', true, 'YYYY-MM-DD');</script>
              <div class="clr"></div>
              <div class="error" htmlfor="rel_status" generated="true"></div></td>
          </tr>
          <tr>
            <td align="right" valign="top" width="40%" class="profile-name" ><span style="color:red">*</span>Redeem To: </td>
            <td align="left" width="60%"><script type="text/javascript">DateInput('redeem_to', true, 'YYYY-MM-DD');</script>
              <div class="clr"></div>
              <div class="error" htmlfor="rel_status" generated="true"></div></td>
          </tr>
          <tr>
            <td align="right" valign="top" width="40%" class="profile-name" ><span style="color:red">*</span>Bid Valid Till: </td>
            <td align="left" width="60%"><input class="signinput" name="bid_validity" type="text" id="bid_validity" value="{$smarty.post.bid_validity}"  size="25" class="textbox fl" style="width:50px"/>
              <div class="clr"></div>
              <div class="error" htmlfor="rel_status" generated="true"></div></td>
          </tr>
          <tr>
            <td align="right" valign="top" width="40%" class="profile-name" ><span style="color:red">*</span>Amount To Pin No: </td>
            <td align="left" width="60%"><input class="signinput" name="amt_to_pin" type="text" id="amt_to_pin" value="{$smarty.post.amt_to_pin}"  size="25" class="textbox fl"/>
              <div class="clr"></div>
              <div class="error" htmlfor="rel_status" generated="true"></div></td>
          </tr>
          <tr>
            <td align="right" valign="top" width="40%" class="profile-name" ><span style="color:red">*</span>If Accepted To Be Paid: </td>
            <td align="left" width="60%"><input class="signinput" name="accepted_to_paid" type="text" id="accepted_to_paid" value="{$smarty.post.accepted_to_paid}"  size="25" class="textbox fl"/>
              <div class="clr"></div>
              <div class="error" htmlfor="accepted_to_paid" generated="true"></div></td>
          </tr>
          <tr>
            <td></td>
            <td><span class="sitesub-btn-lft"><span class="sitesub-btn-right">
              <input class="loc_busines fl" type="submit" value="Save" name="Submit" id="Submit"/>
              </span></span> &nbsp; &nbsp; <span style="margin-left:10px;" class="sitesub-btn-lft"><span class="sitesub-btn-right">
              <input  class="loc_busines fl" type="button" value="Cancel" />
              </span></span></td>
          </tr>
        </table>
      </form>
    </div>
    <!-- Right content Start here -->
    {include file=$profile_right}
    <!-- footer container Start-->
    {include file=$footer}
    <!-- footer container End-->
  </div>
</div>
</body>
