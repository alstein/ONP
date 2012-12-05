{include file=$header_start} 


{include file=$profile_header2}

{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/validate_offer_deal.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>

{/strip}
{literal}
<script type="text/javascript">
	function go_back(){
		window.location="{/literal}{$siteroot}{literal}";
	}
</script>
{/literal}
  <!-- Header ends -->
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">
      <tr>
        <!-- Profile Left Section Start -->
         {include file=$profile_left}
        <!-- Profile Left Section End -->
        <!-- Profile Middle Section Start -->
        <td width="560" valign="top"><!-- Profile Comment Section Start -->
          <div class="maincont-inner-mid fl">
            <div class="edit-profile-form">
              <h1 class=" form-title">Search Merchant To Offer A Deal</h1>
		  <form name="frmdeal" id="frmdeal" action="{$siteroot}/merchant-account/view_search_merchant" method="post">
<input type="hidden" name="userid" id="userid" value="{$user.userid}" />
              <ul class="reset user-edit-form">
				<div align="center" class="success">{$msg}</div>
                
                <li>
                  <label>Keyword</label>
                  <div class="fl textbox">
                  <input class="signinput"  name="name" type="text" id="name" value="{$smarty.post.name}" />
                  </div>
                  <div class="clr"></div>
                </li>
                <li>
              <label>City:</label>
              <div class="fl textbox">
                <input  type="text" name="tcity" id="tcity"  readonly="true" value="Singapore"/>
				<input type="hidden" name="cityid" id="cityid" value="1">
              </div>
              <div class="clr"></div>
            </li>
                
                
                <li>
                  <div>
                    <label> Category Preferance: <span>*</span></label>
			 {section name=i loop=$category}
					{if $smarty.section.i.iteration neq 1}
                    <label> &nbsp;</label>
					{/if}
                    <div>
                      <div class="check fl">
                      <input name="cat_ref[]" id="cat_ref" type="checkbox" value="{$category[i].id}" >
                      </div>
                      <p class="fl forminntxt" style="line-height:22px">{$category[i].category}</p>
                      <div class="clr"></div>
                    </div>
				{/section}
					
                    <div class="clr"></div>
                  </div>

  
                </li>
				
                
                
            
                
                
                
				
				
                <li>
                <label>&nbsp;</label>
                <div class="fl" style="margin:15px 0 0 30px">
			<input type="submit"  style="width:72px" class="previe-btn" value="Search" name="Submit" id="Submit"/>
      
     		 </div>
      			<div class="fl" style="margin:15px 0 0 10px">
			<input style="width:82px" class="previe-btn"   type="button" value="Cancel" onclick="go_back()" />
      
     			 </div>
                </li>

              </ul>
		</form>
            </div>
            <div class="clr" style="height:30px"></div>
          </div>
          <!-- Profile Comment Section End --></td>
        <!-- Profile Middle Section End -->
        <!-- Profile Right Section Start -->
        
  {include file=$profile_right}
        <!-- Profile Right Section End -->
      </tr>
    </table>
  </div>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->
 {include file=$footer}
