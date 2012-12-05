{include file=$header1}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/addpackage.js"></script>
{/strip}

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/modules/package/package_list.php"> Package List</a>&gt; Edit Package List</div>

<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle} Edit package</h3>
        </div>
        <div class="clr">
        </div>
        <div>
            {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
        </div>
    </div>
    <br>
    <div id="UserListDiv" name="UserListDiv" >
        <div>
        <form name="frmRegistration" id="frmRegistration" method="post" action="" enctype="multipart/form-data">
	<input name="packid" type="hidden" id="packid" value="{$smarty.get.editid}"/>
        <table width="100%" border="0" cellspacing="5" cellpadding="5">
       
            <tr>
                <td colspan="2" align="right"><a href="{$siteroot}/admin/modules/package/package_list.php">Back</a></td>
            </tr>
            
            <tr>
                <td align="right" width="20%" valign="middle"><span style="color:red">*</span> Package Name: </td>
                <td align="left" width="60%" valign="top"><input name="pacname" type="text" id="pacname" value="{$page.pack_name}"  size="25" class="textbox" maxlength="100"/>
                <div><font color="#999999" size="2">Please enter upto 100 characters.</font></div>
                </td>
            </tr>
             <tr>
                <td align="right" width="20%" valign="middle"><span style="color:red">*</span>Number # Deals Per Month: </td>
                <td align="left" width="60%" valign="top"><input name="deals" type="text" id="deals" value="{$page.allow_deals_per_month}"  size="25" class="textbox" maxlength="3"/></td>
            </tr>
             <tr>
                <td align="right" width="20%" valign="middle"><span style="color:red">*</span> Pack Price &#163;:</td>
                <td align="left" width="60%" valign="top"><input name="packprice" type="text" id="packprice" value="{$page.pack_price}"  size="25" class="textbox" maxlength="6" /></td>
            </tr>
            <tr>
                <td align="right" width="20%" valign="middle"><span style="color:red">*</span> Cost Per Success Deal:</td>
                <td align="left" width="30%" valign="top"><input name="costper" type="text" id="costper" 
                value= "{$page.cost_per_success_deal}"  size="25" class="textbox" maxlength="6"/>
                <select name="signmark">
                             <option value="pound" >&#163;</option>
                             <option value="percent {if $page.cost_per_success_deal_percent_doller eq 'percent'}" selected="selected"  {/if}">%</option>
                            
              </select>
              <div class="error" htmlfor="costper" generated="true"></div>
                </td>
                <tr>
                <td align="right" width="20%" valign="middle"><span style="color:red">*</span> Cost Per SMS Deal &#163;:</td>
                <td align="left" width="60%" valign="top"><input name="costperdeal" type="text" id="costperdeal" value="{$page.cost_sms_deal}"  size="25" class="textbox" maxlength="6"/></td>
              </tr>
              <tr>
                <td align="right" width="20%" valign="middle"><span style="color:red">*</span> Pack Duration:</td>
                <td align="left" width="60%" valign="top"><input name="packduration" type="text" id="packduration" value="{$page.pack_duration}"  size="25" class="textbox" maxlength="3"/>(Months)
		<div class="error" htmlfor="packduration" generated="true"></div></td>
              </tr>
            <tr>
                <td align="right" width="20%" valign="middle"><span style="color:red">*</span>Status:</td>
                <td align="left" width="60%" valign="top">
                 <select name="action" id="action">
                  <option value="1">Active</option>
                  <option value="0" {if $page.status eq '0'} selected="selected"  {/if}">Inactive</option>
                </select>
                </td>
              </tr>
              	<tr>
                <td></td>
                <td align="left"><input type="submit" name="submit" value="Update" /></td>
            </tr>
            </table>
        </form>
        </div>
    </div>
</div>
{include file=$footer}