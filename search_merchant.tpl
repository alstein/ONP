{include file=$header_start}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/validate_offer_deal.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
{/strip}

<body class="inner_body">
  <!-- header container starts here-->
  {include file=$profile_header2}
  <!-- / header container ends here-->
<!-- main continer of the page -->
<div id="wrapper">

  <!-- main container with changing content -->
  <div id="maincont">
    <!-- Left content Start here -->
      {include file=$profile_left}
    <!-- Middel content Start here -->
    <div class="profile-middel">
	<h2 style="margin-left:20px;color: #2B587A" >Search Merchant To Deal A Offer</h2><br>
         <form name="frmdeal" id="frmdeal" action="{$siteroot}/merchant-account/view_search_merchant" method="post">
<div style="padding-left:16px">
      <table cellspacing="5" cellpadding="5" width="100%" border="0" align="center">
		<tr>
			<td align="right" valign="top" width="40%" class="profile-name" style="float:right">Keyword:</td>
			<td align="left" width="60%">
			<input class="signinput" name="name" type="text" id="name" value="{$smarty.post.name}" 
			size="25" class="textbox fl"/>
			<div class="clr"></div>
			<div class="error" htmlfor="business_name" generated="true"></div>
			</td>
		</tr>
      
<!--		<tr>
			<td align="right" valign="top" width="40%" class="profile-name" style="float:right">Category: </td>
			<td align="left" width="60%">
			<select name="maincategory" id="maincategory" style="width:225px;" class="selectbox fl" onchange="javascript: getsubcat(this.value);">
		
				<option value="">--Select Main Category--</option>
				{section name=i loop=$category}
				<option value="{$category[i].id}" {if $smarty.post.maincategory eq $category[i].id} selected='selected'{/if}>{$category[i].category}</option>
				{/section}
			</select>
			<div class="clr"></div>
			<div class="error" htmlfor="address" generated="true"></div>
			</td>
		</tr>-->

		<tr>
			<td align="right" valign="top" width="60%" class="profile-name" style="float:right">Category :</td>
			<td align="left" width="60%" colspan="2">&nbsp;
			</td>
		</tr>


{section name=i loop=$category}
            <tr>
                <td align="right" valign="top" style="padding-left:102px;"> <input name="cat_ref[]" id="cat_ref" type="checkbox" value="{$category[i].id}" class="fr boxcheck"> </td>
                <td  style="padding-left:30px;">{$category[i].category}
                    
                                            <div class="clr"></div>
                                            
                </td>
            </tr>
{/section}


<!--		<tr>
			<td align="right" valign="top" class="profile-name" style="float:right" ><span style="color:red">*</span>City:</td>
			<td align="left" >
			<select name="cityid" id="cityid" style="width:97%;" class="selectbox fl">
						<option value="">---Select City/Town---</option>
					   {section name=i loop=$city}
						<option value="{$city[i].city_id}" {if $smarty.post.cityid eq $city[i].city_id} selected="selected" {/if}>{$city[i].city_name}</option>
					   {/section}
					</select>
			<div class="clr"></div>
			<div class="error" htmlfor="category" generated="true"></div>
			</td>
		</tr>-->

		<tr>
			<td align="right" valign="top" class="profile-name" style="float:right" >City:</td>
			<input type="hidden" name="cityid" id="cityid" value="1">
			<td align="left" ><input type="text" name="city" id="city" readonly="true" value="Singapore" class="signinput">
			</td>
		</tr>

		<tr>
			<td align="right" valign="top" class="profile-name" style="float:right" >All:</td>
			
			<td align="left" ><input type="checkbox" name="all" id="all">
			</td>
		</tr>


		<tr>
			<td></td>
			<td>
				<span class="sitesub-btn-lft" style="margin-left:0"><span class="sitesub-btn-right">
				<input class="loc_busines fl" type="submit" value="Search" name="Submit" id="Submit"/>
				</span></span> &nbsp; &nbsp; 
				<span style="margin-left:10px;" class="sitesub-btn-lft"><span class="sitesub-btn-right">
				<input  class="loc_busines fl" type="button" value="Cancel" />
				</span></span>
			</td>
		</tr>


    </table>
 </div>
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

