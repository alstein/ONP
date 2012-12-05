{include file=$header1}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{$sitejs}/calendarDateInput.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/addbuseness.js"></script>
{include file=$header2}
<div>
    <h3>{$sitetitle} {if $smarty.get.cid}Edit{else}Add{/if} Business</h3>

<!-- bcname 	image 	city 	state 	website 	email 	contact_name 	phone 	comments 	active 	postdate -->
    <input type="hidden" id="siteroot" value="{$siteroot}" />
    <div align="center" id="msg">{$msg}</div>
    <form name="frmRegistration" id="frmRegistration" method="post" action="" enctype="multipart/form-data">
        <table width="100%" border="0" cellspacing="2" cellpadding="1">
           <!-- <tr>
                <td colspan="2" align="right"><a href="javascript:history.go(-1);">Back</a></td>
            </tr>-->
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Business name:</td>
                <td align="left" width="60%"><input name="businessname" type="text" id="businessname" value="{$brec.bcname}" size="30" class="textbox"/></td>
            </tr>
            <tr>
                <td align="right" valign="top" ><span style="color:red">*</span> City:</td>
                <td align="left" >
                <div id="replace">
                    <select name="city" id="city" style='width:267px'>
                        <option value="">Please select</option>
                        {if $city}
                        {section name=i loop=$city}
                        <option value="{$city[i].city_name}" {if $brec.city eq $city[i].city_name} selected="selected" {/if}>{$city[i].city_name}</option>       
                        {/section}
                        {else}
                        <option value="">Select City</option>
                        {/if}
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> State:</td>
                 <td align="left" width="60%"><input name="state" type="text" id="state" value="{$brec.state}"  size="30" class="textbox"/></td>
            </tr>

            <tr>
                <td align="right" valign="top"><span style="color:red">*</span> Email address:</td>
                <td><input type="text" size="30" value="{$brec.email}" name="email" id="email" class="textbox" /></td>
            </tr>
            <tr>
                <td align="right" valign="top"><span style="color:red">*</span> Website:</td>
                <td><input type="text" size="30" name="wsite" id="wsite" value="{$brec.website}" class="textbox"/></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Contact name: </td>
                <td align="left" width="60%"><input name="cname" type="text" id="cname" value="{$brec.bcname}" size="30" class="textbox"/></td>
            </tr>
            <tr>
              <td align="right" valign="top" width="40%"><span style="color:red">*</span> Phone:</td>
                <td align="left" width="60%"><input name="phone" type="text" id="phone" value="{$brec.phone}" size="30" class="textbox"/>
                </td>
            </tr>
            <tr>
              <td align="right" valign="top" width="40%"><span style="color:red">*</span> Comment:</td>
                <td align="left" width="60%"><textarea name="comment" id="comment" rows="4" cols="35">{$brec.comments}</textarea></td>
            </tr>
            <tr>
              <td align="right" valign="top" width="40%"><span style="color:red"></span> Image:</td>
                <td align="left" width="60%"><input name="bphoto" type="file" id="bphoto" size="20" class="textbox"/>
                </td>
            </tr>
{if $brec.comments}
	<tr>
              <td align="right" valign="top" width="40%">&nbsp;</td>
                <td align="left" width="60%"><img src="{$siteroot}/uploads/business/thumbnail/{$brec.image}"></td>
        </tr>
{/if}
            <tr> 
                <td align="right" valign="top">Status:</td>
                <td>
                    <select name="status" id="status" style="width:271px;">
                        <option value="1" {if $brec.status eq 1} selected="selected"{/if} >Active</option>
                        <option value="0"  {if $brec.status eq 0} selected="selected"{/if}>Inactivate</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="left">
                    <input type="submit" name="submit" id="submit" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="button" value="Cancel" onclick="javascript: document.location.href='buseness.php'" class="" />
                </td>
            </tr>
        </table>
    </form>
</div>
{include file=$footer}