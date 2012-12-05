{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.pack.js"></script>
<script type="text/javascript">
{literal}
$(document).ready(function() {
	// validate signup form on keyup and submit
  var userid = document.getElementById('userid').value;
  var validator = $("#frmUserProfile").validate({
    errorElement:'div',
    rules: {
      first_name:{
              required: true,
              minlength: 2,
              maxlength: 25
      },
      last_name:{
              required: true,
              minlength: 2,
              maxlength: 25
      },
      email: {
              required: true,
              email: true,
              remote: {url:SITEROOT + "/admin/user/ajax_check_user.php?userid="+userid , type:"post"}
      },
      usertypeid: "required",
      
    },
    messages: {
      first_name:{
              required: "Enter first name",
              minlength: jQuery.format("Enter at least {0} characters"),
              maxlength: "required maximum 25 characters"
      },
      last_name:{
              required: "Enter last name",
              minlength: jQuery.format("Enter at least {0} characters"),
              maxlength: "required maximum 25 characters"
      },
      email: {
              required: "Please enter email address",
              email: "Please enter a valid email address",
              remote: jQuery.format("{0} is already in use or marked as spam.")
      },
      usertypeid: "Please Select User Type.",

    },

          // set this class to error-labels to indicate valid fields
          success: function(label) {
                  // set &nbsp; as text for IE
                  label.hide();
          }
  });
  // propose username by combining first- and lastname
  $("#username").focus(function() {
          var first_name = $("#first_name").val();
          var last_name = $("#last_name").val();
          if(first_name && last_name && !this.value) {
                  this.value = first_name + "." + last_name;
                  this.value = this.value.toLowerCase();
          }
  });
});

function changeit(val){
// 		alert(val);
  if(val == 4 || val == 6){
          document.getElementById('hidden_id').style.display='';
          //ajax.sendrequest("GET", SITEROOT+"/admin/user/get_city.php", {val:val}, '', 'replace');
  }else{
          document.getElementById('hidden_id').style.display='none';
  }
}
function getCity(val){
  ajax.sendrequest("GET", SITEROOT+"/admin/user/get_city.php", {val:val,bussiness:1}, '', 'replace');
}
function add_cities(){
  var city = document.getElementById('city').value;
  if(city != ''){
    var state = document.getElementById('state').value;
    ajax.sendrequest("POST", SITEROOT+"/admin/user/add_city.php", {city:city,state:state}, '','display_cities');
  }else{
        alert("Please select city");
        return false;
  }
}
	
function removecity(val){
        var val1 = 'add_city_'+val;
        var val2 = 'name_city_'+val;
        var val_city = document.getElementById(val2).innerHTML;
        var state_id = "id_state_"+val;
        var stateid = document.getElementById(state_id).value;
        document.getElementById(val1).style.display = 'none';
        ajax.sendrequest("POST", SITEROOT+"/admin/user/add_city.php", {remove_city:val_city,stateid:stateid}, '', 'display_cities');
}
{/literal}
</script>
{include file=$header2}
<div class="breadcrumb">
  <a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/user/admin_user_view.php?userid={$user.userid}">Manage User Information</a> &gt; Users Details
</div>
<h3>User Information</h3>
<div class="holdthisTop">
  <div align="center">
     {$msg} 
  </div>
    <form name="frmUserProfile" id="frmUserProfile" action="" method="post" enctype="multipart/form-data">
      <table cellspacing="1" cellpadding="2" width="100%" border="0">
      <tr>
        <td align="right" valign="top" width="40%"><input type="hidden" name="userid" id="userid" value="{$user.userid}" />First name<span style="color:red">*</span>:</td>
        <td align="left" width="60%"><input name="first_name" type="text" id="first_name" value="{$user.first_name}"  size="15" class="textbox"/>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top" >Last name<span style="color:red">*</span>:</td>
        <td align="left" ><input name="last_name" type="text" id="last_name" value="{$user.last_name}"  size="15" class="textbox"/>
        </td>
      </tr>
    <tr>
      <td align="right" valign="top">Username:</td>
      <td>
      <input type="text" maxlength="15" value="{$user.username}" name="username" id="username" class="textbox" />
      </td>
    </tr>
      <tr>
          <td align="right" valign="top">Email address<span style="color:red">*</span>:</td>
          <td>
            <input type="text" maxlength="70" size="50" value="{$user.email}" name="email" id="email" class="textbox"/>
          </td>
      </tr>
      <tr>
          <td align="right" valign="top"> Password: </td>
          <td>
            <input type="password" maxlength="15" size="15" name="password" id="password" class="textbox"/>
            <br/>
            Only enter if you want to reset pass.
          </td>
        </tr>
      <tr>
        <td align="right" valign="top">Address:</td>
        <td align="left" ><input name="address" type="text" id="address" value="{$user.address}"  class="textbox" size="50" />
        </td>
      </tr>
      <tr>
        <td align="right" valign="top" >State:</td>
        <td align="left" >
        <select name="state" id="state" onchange="javascript: getCity(this.value);" style="width:150px" >
            <option value="">Select State</option>
              {section name=i loop=$state}
              <option value="{$state[i].id}" {if $user.state eq $state[i].id} selected="selected" {/if}> {$state[i].state_name}</option>
              {/section}
            </select>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top" >City:</td>
        <td align="left" ><div id="replace">
          <select name="city" id="city" style='width:150px' ><!--onchange="javscript: add_cities();"-->
          {if $city}
                  {section name=i loop=$city}
                  <option value="{$city[i].city_name}" {if $row.city eq $city[i].city_name} selected="selected" {/if}>{$city[i].city_name}</option>       
                  {/section}
          {else}
                  <option value="">Select City</option>
          {/if}
          </select>
      </div></td>
      </tr>
      <tr>
        <td align="right" valign="top">Zip Code:</td>
                  <td align="left" ><input name="zipcode" type="text" id="zipcode" value="{$user.zipcode}" maxlength="15" class="textbox"/>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top">CC Info:</td>
          <td align="left" ><input name="cc_info" type="text" id="cc_info" value="{$user.cc_info}" maxlength="255" class="textbox" size="50"/>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top">Total Gift Card Bought:</td>
        <td align="left" ><input name="tot_gift_card_bought" type="text" id="tot_gift_card_bought" value="{$user.tot_gift_card_bought}" maxlength="5" class="textbox" size="3"/>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top">Total Gift Card Spent:</td>
        <td align="left" ><input name="tot_gift_card_spent" type="text" id="tot_gift_card_spent" value="{$user.tot_gift_card_spent}" maxlength="5" class="textbox" size="3"/>
        </td>
      </tr>
<!--
                <tr>
                <td align="right" valign="top">Notify me about your site updates and partner offers</td>
                <td align="left"><input name="site_updates" type="checkbox" id="site_updates" value="1"{if $user.site_updates eq 1} checked='true' {/if}></td>
      </tr>
        <tr>
        <td align="right" valign="top">Subscribe to daily Newsletters</td>
        <td align="left">
                <input type="checkbox" name="newsletter" id="newsletter" value="1"{if $user.newsletter eq 1} checked='true'{/if}>
        </td>
      </tr>-->
    <tr>
    <td align="right" valign="top">User Type<span style="color:red">*</span>:</td>
    <td><select name="usertypeid" id="usertypeid" class="selectbox" onchange="javascript: changeit(this.value);">
        {section name=i loop=$usertype}
        <option value="{$usertype[i].typeid}" {if $usertype[i].typeid eq $user.usertypeid}selected="selected"{/if}>{$usertype[i].usertype}</option>
        {/section}
      </select>
    </td>
    </tr>
  <tr> 
    <td align="right" valign="top">Status</td>
    <td><select name="status" id="status">
          <option value="Active" {if $user.status=="Active"} selected="selected"{/if} >Active</option>
          <option value="Suspended"  {if $user.status=="Suspended"} selected="selected"{/if}>Suspended</option>
        </select>
    </td></tr>
    {if $user.thumbnail neq ''}
    <tr>
      <td align="left" valign="top" ><span class="clrtext1">&nbsp;</td>
      <td><img src="{$siteroot}/uploads/user_photo/thumbnail/{$user.thumbnail}"  class="BrdGrey1" /></td>
    </tr>
    {/if}
      <tr>
        <td></td>
        <td><input type="submit" value="Save" class="button1" name="Submit"/> &nbsp; &nbsp; <input type="button" value="Cancel" onclick="javascript: location='admin_users_list.php'" class="button1" />
        </td>
      </tr>
    </table>
  </form>

 <!-- <div class="fr width40">
    <div style="padding:6px" class="conttable" align="center">
      <img src="{$siteroot}/uploads/user_photo/150X150/{$user.thumbnail}" />
    </div>
    <div style="padding:6px" class="conttable">
      <div class="conttableDkBg"  style="padding:3px">
        <b>Statistics</b>
      </div>
      <div class="smallbox_content">
        <div style="padding:3px">
           1 total logins 
        </div>
        <div style="padding:3px">
           Last login: 11/21/2008, 1:18 AM 
        </div>
        <div style="padding:3px">
           Signup IP: 70.181.113.113 
        </div>
        <div style="padding:3px">
           Last recorded IP: 70.181.113.113 
        </div>
      </div>
    </div>
  </div>-->
  </td>
  <div class="clr"></div>
</div>

 {include file=$footer} 
