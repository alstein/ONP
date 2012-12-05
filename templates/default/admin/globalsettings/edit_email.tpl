{include file=$header1}

<script type="text/javascript" src="{$siteroot}/js/validation/admin/validate_system_emails.js"></script>
{include file=$header2}

<h2>System Emails</h2><br/>
<br />
 <h3>Edit Email- Note: <font color="#ff0000">(Please do not edit/modify in [] or [[]] values for example : [[SITETITLE]] OR [SITETITLE])</font> </h3><br/>
<div class="holdthisTop">
  <table  width="100%" border="0" cellspacing="2" cellpadding="6">
    <tr>
      <td>
       
        <form name="frmSystemEmails" id="frmSystemEmails" method="post" action="" enctype="multipart/form-data">
         <input type="hidden" name="emailid" value="{$emails.emailid}" />
            <span class="fr"><a href="{$siteroot}/admin/globalsettings/system_emails.php"><stronb>Back</stronb></a></span>
          <table cellpadding="6" class="conttableDkBg conttable" width="100%">
          {*<!--  <tr>
              <td width="15%" align="right" valign="top"><span style="color:red">*</span> Page Category: </td>
              <td align="left">
                  <select name="page_cat" id="page_cat">
                      <option value="">  Select </option>
                      {section name=i loop=$page_cat}
                      <option value="{$page_cat[i].id}" {if $page.page_cat eq $page_cat[i].id} selected="selected"{/if}>{$page_cat[i].title}</option>
                      {/section}
                  </select>
              </td>
            </tr>-->*}

            <tr>
              <td width="15%" align="right" valign="top"><span style="color:red">*</span> Subject: </td>
              <td align="left"><input type="text" id="subject" name="subject" value="{$emails.subject}" size="60"  maxlength="255" /></td>
            </tr>

            <tr>
              <td valign="top" align="right"><span style="color:red">*</span> Message: </td>
              <td valign="top">
                 {$oFCKeditorDesc}
                </td>
            </tr>
            

            <tr>
              <td align="right" valign="top"></td>
              <td><input type="submit" name="Submit" id="submit" value="Save Changes"/> &nbsp; &nbsp;&nbsp; &nbsp; 
		  <input type="button" name="submit" value="Cancel" onclick="javascript: location='system_emails.php'"/></td>
            </tr>
          </table>
        </form></td>
    </tr>
  </table>
</div>
{include file=$footer}