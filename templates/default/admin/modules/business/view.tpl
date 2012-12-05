{include file=$header1}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{$sitejs}/calendarDateInput.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/addbuseness.js"></script>
{include file=$header2}
<div>
            <h3>{$sitetitle} Business </h3>

<!-- bcname 	image 	city 	state 	website 	email 	contact_name 	phone 	comments 	active 	postdate -->
    <input type="hidden" id="siteroot" value="{$siteroot}" />
    <div align="center" id="msg">{$msg}</div>
    <form name="frmRegistration" id="frmRegistration" method="post" action="" enctype="multipart/form-data">
        <table width="100%" border="0" cellspacing="2" cellspacing="5" cellpadding="5">
            <tr>
                <td colspan="2" align="right"><a href="javascript:history.go(-1);">Back</a></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"> Business name:</td>
                <td align="left" width="60%">{$brec.bcname|ucfirst}</td>
            </tr>
            <tr>
                <td align="right" valign="top" > City:</td>
                <td align="left">{$brec.city} </td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"> State:</td>
                 <td align="left" width="60%">{$brec.state|ucfirst}</td>
            </tr>

            <tr>
                <td align="right" valign="top"> Email address:</td>
                <td>{$brec.email}</td>
            </tr>
            <tr>
                <td align="right" valign="top"> Website:</td>
                <td>{$brec.website}</td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"> Contact name: </td>
                <td align="left" width="60%">{$brec.bcname|ucfirst}</td>
            </tr>
            <tr>
              <td align="right" valign="top" width="40%"> Phone:</td>
                <td align="left" width="60%">{$brec.phone}</td>
            </tr>
            <tr>
              <td align="right" valign="top" width="40%"> Comment:</td>
                <td align="left" width="60%">{$brec.comments|ucfirst}</td>
            </tr>
{if $brec.comments}
	<tr>
              <td align="right" valign="top" width="40%">&nbsp;</td>
                <td align="left" width="60%"><img src="{$siteroot}/uploads/business/thumbnail/{$brec.image}"></td>
        </tr>
{/if}
            
        </table>
    </form>
</div>
{include file=$footer}