{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/edit_refer_friend.js"></script>
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Manage Refer Friend Setting
</div><br/>
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle}  Manage Refer Friend Setting</h3>
	  </div>
          <div class="clr">&nbsp;</div>
     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
	</div>

      <div class="clr">&nbsp; </div>
    <div id="UserListDiv" name="UserListDiv">
  
    <form name="home_form" action="" id="home_form" method="post" enctype="multipart/form-data">
       <table width="100%" border="0" cellspacing="2" cellpadding="6" class="conttableDkBg conttable">
        <tr> 
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span><strong>Refer Amount</strong>:</td> 
           <td align="left" width="40%">&nbsp;</td>
        </tr>
        <tr> 
           <td width="20%" align="right" valign="top">Pound (&#163;):</td> 
           <td align="left" width="40%"><input type="text" name="refer_amount_pound" id="refer_amount_pound" value="{$refer_amount_pound.value}"   style="width:268px;" maxlength="4"/></td>
        </tr>
        <tr> 
           <td width="20%" align="right" valign="top">Euro (&#8364;):</td> 
           <td align="left" width="40%"><input type="text" name="refer_amount_euro" id="refer_amount_euro" value="{$refer_amount_euro.value}"   style="width:268px;" maxlength="4"/></td>
        </tr>
        <tr> 
           <td width="20%" align="right" valign="top">Dollar ($):</td> 
           <td align="left" width="40%"><input type="text" name="refer_amount_dollar" id="refer_amount_dollar" value="{$refer_amount_dollar.value}"   style="width:268px;" maxlength="4"/></td>
        </tr>
        <tr>
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Setting ON / OFF:</td>
           <td align="left" width="40%">
              <input type="radio" name="setting" id="setting" value="yes" {if $setting.value eq "yes"}  checked="true"{/if} >Yes &nbsp;&nbsp;
              <input type="radio" name="setting" id="setting" value="no" {if $setting.value eq "no"} checked="true"{/if} >No 
              <div class="error" htmlfor="setting" generated="true"></div>
        </td>

        </tr>
        <tr>
         <!-- <td>&nbsp;</td>-->
         <td align="middle" colspan="2">
          <div style="width:34%"> 
          <div id="buttonregister">
                 <input type="submit" name="Update" id="Update" value="Update" class="but_new fl" /> 
                 <!--&nbsp;<input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="javascript: location='{$siteroot}/admin/index.php'" 
                 class="but_new fl"/>--> </div>
      </div>
      </td>
    </tr>
  </table>
  </form> 
</div>
</div>
{include file=$footer}
