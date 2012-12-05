{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/edit_qr_code_setting.js"></script>
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Manage QR Code
</div><br/>
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle}  Manage QR Code</h3>
	  </div>
          <div class="clr">&nbsp;</div>
     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
	</div>

      <div class="clr">&nbsp; </div>
    <div id="UserListDiv" name="UserListDiv">
  
    <form name="home_form" action="" id="home_form" method="post" enctype="multipart/form-data">
       <table width="100%" border="0" cellspacing="2" cellpadding="6" class="conttableDkBg conttable">
        <tr> 
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span><strong>Manage Deal Setting</strong>:</td> 
           <td align="left" width="40%">&nbsp;</td>
        </tr>       
        <tr> 
           <td width="20%" align="right" valign="top">QR Code Website Link :</td> 
           <td align="left" width="40%"><input type="text" name="qr_link" id="qr_link" value="{$qr_link.value}"   style="width:268px;" maxlength="255"/>
        </tr>
        
        <tr> 
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span><strong>Manage Delivery Services Options</strong>:</td> 
           <td align="left" width="40%">&nbsp;</td>
        </tr> 
        <tr>
           <td width="20%" align="right" valign="top">Option 1:</td>
           <td align="left" width="40%"><input type="text" name="option_1" id="option_1" value="{$option_1.value}"  style="width:268px;" maxlength="50"/>
        </td>

        </tr>
        <tr>
           <td width="20%" align="right" valign="top">Option 2:</td>
           <td align="left" width="40%"><input type="text" name="option_2" id="option_2" value="{$option_2.value}"   style="width:268px;" maxlength="50"/>
        </td>

        </tr>
        
        <tr>
           <td width="20%" align="right" valign="top">Option 3:</td>
           <td align="left" width="40%"><input type="text" name="option_3" id="option_3" value="{$option_3.value}"   style="width:268px;" maxlength="50"/>
        </td>
        </tr>
        
        <tr>
           <td width="20%" align="right" valign="top">Option 4:</td>
           <td align="left" width="40%"><input type="text" name="option_4" id="option_4" value="{$option_4.value}"   style="width:268px;" maxlength="50"/>
        </td>
        </tr>
        
        <tr>
           <td width="20%" align="right" valign="top">Option 5:</td>
           <td align="left" width="40%"><input type="text" name="option_5" id="option_5" value="{$option_5.value}"   style="width:268px;" maxlength="50"/>
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
