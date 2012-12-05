{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/edit_scroll_setting.js"></script>
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Manage Scroll Settings
</div><br/>
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle}  Manage Scroll Settings</h3>
	  </div>
          <div class="clr">&nbsp;</div>
     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
	</div>

      <div class="clr">&nbsp; </div>
    <div id="UserListDiv" name="UserListDiv">
  
    <form name="home_form" action="" id="home_form" method="post" enctype="multipart/form-data">
       <table width="100%" border="0" cellspacing="2" cellpadding="6" class="conttableDkBg conttable">
            <tr> 
            <td width="20%" align="right" valign="top"><span style="color:red;">*</span><strong>Group Buy Deals</strong>:</td> 
            <td align="left" width="40%">&nbsp;</td>
            </tr>
            <tr> 
                <td width="20%" align="right" valign="top">Scroll ON / OFF:</td> 
                <td align="left" width="40%">
                    <input type="radio" name="group_scroll" id="group_scroll" value="true" {if $group_scroll.value eq "true"}  checked="true"{/if} >Yes &nbsp;&nbsp;
                    <input type="radio" name="group_scroll" id="group_scroll" value="false" {if $group_scroll.value eq "false"} checked="true"{/if} >No 
                <div class="error" htmlfor="group_scroll" generated="true"></div></td>
          </tr>
        <tr> 
            <td width="20%" align="right" valign="top">Scroll Speed:</td> 
            <td align="left" width="40%">
                    <input  type="text" value="{$group_speed.value}" name="group_speed" id="group_speed" size="10">
                <div>(In millisecond)</div></td>
        </tr>
        <tr> 
            <td width="20%" align="right" valign="top"><span style="color:red;">*</span><strong>Daily Deals</strong>:</td> 
            <td align="left" width="40%">&nbsp;</td>
        </tr>
        <tr> 
            <td width="20%" align="right" valign="top">Scroll ON / OFF:</td> 
            <td align="left" width="40%">
                <input type="radio" name="daily_scroll" id="daily_scroll" value="true" {if $daily_scroll.value eq "true"}  checked="true"{/if} >Yes &nbsp;&nbsp;
                <input type="radio" name="daily_scroll" id="daily_scroll" value="false" {if $daily_scroll.value eq "false"} checked="true"{/if} >No 
              <div class="error" htmlfor="daily_scroll" generated="true"></div></td>
        </tr>
        <tr> 
           <td width="20%" align="right" valign="top">Scroll Speed:</td> 
           <td align="left" width="40%">
                <input  type="text" value="{$daily_speed.value}" name="daily_speed" id="daily_speed" size="10">
                 <div>(In millisecond)</div></td>
        </tr>
        <tr> 
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span><strong>Free Coupons</strong>:</td> 
           <td align="left" width="40%">&nbsp;</td>
        </tr>
        <tr> 
            <td width="20%" align="right" valign="top">Scroll ON / OFF:</td> 
            <td align="left" width="40%">
                    <input type="radio" name="free_scroll" id="free_scroll" value="true" {if $free_scroll.value eq "true"}  checked="true"{/if} >Yes &nbsp;&nbsp;
                <input type="radio" name="free_scroll" id="free_scroll" value="false" {if $free_scroll.value eq "false"} checked="true"{/if} >No 
              <div class="error" htmlfor="free_scroll" generated="true"></div></td>
      </tr>
      <tr> 
           <td width="20%" align="right" valign="top">Scroll Speed:</td> 
           <td align="left" width="40%">
                <input  type="text" value="{$free_speed.value}" name="free_speed" id="free_speed" size="10">
                 <div>(In millisecond)</div></td>
    </tr> 
    <tr> 
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span><strong>Travel</strong>:</td> 
           <td align="left" width="40%">&nbsp;</td>
        </tr>
        <tr> 
            <td width="20%" align="right" valign="top">Scroll ON / OFF:</td> 
            <td align="left" width="40%">
                    <input type="radio" name="travel_scroll" id="travel_scroll" value="true" {if $travel_scroll.value eq "true"}  checked="true"{/if} >Yes &nbsp;&nbsp;
                <input type="radio" name="travel_scroll" id="free_scroll" value="false" {if $travel_scroll.value eq "false"} checked="true"{/if} >No 
              <div class="error" htmlfor="travel_scroll" generated="true"></div></td>
      </tr>
      <tr> 
           <td width="20%" align="right" valign="top">Scroll Speed:</td> 
           <td align="left" width="40%">
                <input  type="text" value="{$travel_speed.value}" name="travel_speed" id="free_speed" size="10">
                 <div>(In millisecond)</div></td>
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
