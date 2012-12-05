{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/edit_social_net.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Manage Facebook And Twitter
</div><br/>
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle}   Manage Facebook And Twitter</h3>
	  </div>
          <div class="clr">&nbsp;</div>
     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
	</div>

      <div class="clr">&nbsp; </div>
    <div id="UserListDiv" name="UserListDiv">
  
    <form name="home_form" action="" id="home_form" method="post" enctype="multipart/form-data">
       <table width="100%" border="0" cellspacing="2" cellpadding="6" class="conttableDkBg conttable">
        <tr> 
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Facebook Become a Fan:</td> 
           <td align="left" width="40%"><input type="text" name="facebook" id="facebook" value="{$facebook.value}"   style="width:268px;" maxlength="255"/>
           <div> Please enter upto 255 characters.</div>
           <div> Please enter URL of facebook page.</div>
        </tr>
        <tr>
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Twitter Updates:</td>
           <td align="left" width="40%"><input type="text" name="twitter" id="twitter" value="{$twitter.value}"   style="width:268px;" maxlength="100"/>
           <div> Please enter upto 100 characters.</div>
           <div> Please enter Twitter username.&nbsp;&nbsp;e.g.textusername</div>
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
