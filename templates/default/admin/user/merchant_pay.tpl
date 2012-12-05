{include file=$header1}
{strip}
<script language="javascript" type="text/javascript" src="{$siteroot}/js/validation/admin/validate_merchant_pay.js"> </script>
{/strip}
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Company Contact
</div><br/>
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle}   Company Contact</h3>
	  </div>
          <div class="clr">&nbsp;</div>
     	  {if $msg}<div align="center" class="success" id="msg">{$msg}</div>{/if}
	</div>

      <div class="clr">&nbsp; </div>
    <div id="UserListDiv" name="UserListDiv">
  
    <form name="home_form" action="" id="home_form" method="post" enctype="multipart/form-data">
       <table width="100%" border="0" cellspacing="2" cellpadding="6" class="conttableDkBg conttable">
        <tr> 
           <td width="20%" align="right" ><span style="color:red;">*</span><!--Merchant Pay In-->  When Customer offers Deal to merchant %:</td> 
           <td align="left" width="40%"><input type="text" name="merchant_pay" id="merchant_pay" value="{$merchant_pay}"   style="width:268px;" maxlength="255"/>
        </tr>
        <tr> 
           <td width="20%" align="right" ><span style="color:red;">*</span><!--Customer Pay In--> When Customer Buys Deal %:</td> 
           <td align="left" width="40%"><input type="text" name="customer_pay" id="customer_pay" value="{$customer_pay}"   style="width:268px;" maxlength="255"/>
        </tr>

       
        <tr>
          <td>&nbsp;</td>
         <td align="left">
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
