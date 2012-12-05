{include file=$header1}
<!-- <script language="javascript" type="text/javascript" src="{$siteroot}/js/jquery-1.4.2.min.js"></script> -->
<!-- <script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script> -->
<script type="text/javascript" src="{$siteroot}/js/calender/ui/ui.core.js"></script>
<script type="text/javascript" src="{$siteroot}/js/calender/ui/ui.datepicker.js"></script>
<link rel="stylesheet" href="{$siteroot}/js/calender/themes/flora/flora.all.css" type="text/css" media="screen" title="Flora (Default)" />
<link rel="stylesheet" href="{$siteroot}/js/calender/themes/flora/flora.datepicker.css" type="text/css" media="screen" 
title="Flora (Default)" />
{literal}
<script type="text/javascript">
jQuery(document).ready(function(){

	$.validator.addMethod("chkedate", function(value, element) {
		var startdatevalue = $('#sdate').val();
		if($('#curent').is(':checked'))
		{
				return true;
		}
		else 
		{
			if(startdatevalue <= value)
				return true;
			else{
				//show_edate_err();
				return false;
			}
		}
	}, "End Date should be greater than or equal to Start Date.")

	$.validator.addMethod("chkevent", function(value, element) {
		if($("#event_error").val() == '1' )
		{
			return false;
		}
		else
		{
			return true; 
		}
	}, "This Event alrady exist, Select from dropdown above.")

	$.validator.addMethod("chkEvent", function(value, element) {
		if($("#event_chk").val() == '1' )
		{
			return false;
		}
		else
		{
			return true; 
		}
	}, "Please either select Event or Enter Event.")

	$.validator.addMethod("chkAward", function(value, element) {
		if($("#award_chk").val() == '1' )
		{
			return false;
		}
		else
		{
			return true; 
		}
	}, "Please either select Accomplishment or Enter New Accomplishment")

   jQuery("#frmaccomplish").validate({
       errorElement:'div',
       rules:{
        added_userid: {
            required:true
        },
        'user[]':{
            required:true
        },
        category: {
            required:true
	},
	subcategory: {
            required:true
        },
        school: {
            required: true
	},
/*	sdate: {
	    required: true,
	    chksdate: true
	},*/
	edate: {
	    required: true
	},
	event: {
	    maxlength: 30,
            chkevent: true
        },
//         event_name: {
// 	    required: function(element){
// 		if($("#event").val()=='')
// 			return true;
// 		else
// 			return false;
// 		}
//         },
	event_chk: {
	    chkEvent: true
        },
// 	award: {
// 	    required: function(element){
// 		if($("#new_award").val()=='')
// 			return true;
// 		else
// 			return false; 
// 		}
//             
//         },
        new_award: {
	    maxlength: 30,
	    remote: {url:SITEROOT + "/admin/sitemodules/ajax_check.php",type:"get",async:false}
        },
        award_chk: {
	    chkAward: true
        }

       },
       messages:{
        added_userid: {
            required:"Please select Added By"
        },
        'user[]':{
             required: "Please select Student"
        },
        category: {
             required:"Please select Category"
	},
	subcategory: {
            required:"Please select subcategory"
        },
        school: {
            required: "Please select School"
	},
	sdate: {
	    required: "Please enter start date "
	},
	edate: {
	    required: "Please enter end date "
	},
	event: {
	    maxlength: "Maximum {0} characters allowed"
        },
/*        event_name: {
	    required: "Please either select Event or Enter Event"
        },*/
// 	award: {
// 	    required: "Please either select Accomplishment or Enter New Accomplishment"
//         },
        new_award: {
	    maxlength: "Maximum {0} characters allowed",
	    remote: "This Accomplishment alrady exist, Select from dropdown above"
        }
       }
    });
	jQuery("#msg").fadeOut(5000);
	chk_event();
	chk_award();
// 	jQuery("#show_err").hide();
// 
// 	if($('#curent').is(':checked'))
// 		settoday();
// 	else unsettoday();
});
function validate_event(event)
{
	var catid = $('#category').val();
	var subcatid = $('#subcategory').val();
	var schoolid = $('#school').val();
	var sdate = $('#sdate').val();
	var edate = $('#edate').val();
	var curent = $('#curent').is(':checked');

	jQuery.get(SITEROOT+"/modules/post_accomplishment/ajaxCheckEvent.php",{'catid':catid, 'subcatid':subcatid, 'schoolid': schoolid, 'sdate':sdate, 'edate':edate, 'curent':curent, 'event':event},function(data){
		if(escape(data) == 'true')
		{
			$('#event_error').val('1');
			return false;
		}
		else
		{
			$('#event_error').val('0');
			return true;
		}
	});
}
function chk_event()
{
		if($("#event_name").val() == '')
		{
			if($("#event").val() == '')
			{
				$('#event_chk').val('1');
			}
			else 
			{
				$('#event_chk').val('0');
			}
		}
		else
		{
			if($("#event").val() != '')
			{
				$('#event_chk').val('1');
			}
			else 
			{
				$('#event_chk').val('0');
			}
		}
}
function chk_award()
{
		if($("#award").val() == '')
		{
			if($("#new_award").val() == '')
			{
				$('#award_chk').val('1');
			}
			else 
			{
				$('#award_chk').val('0');
			}
		}
		else
		{
			if($("#new_award").val() != '')
			{
				$('#award_chk').val('1');
			}
			else 
			{
				$('#award_chk').val('0');
			}
		}
}
function getSubCat(catid){
	jQuery.get(SITEROOT+"/admin/sitemodules/ajax.php",{catid:catid},function(data){
		if(data)
		{
			jQuery('#subcategory').html(data);
		}
		else
		{
			jQuery('#subcategory').html("<option value=''>---Select--</option>");
		}
	});
}

function getSchool(userid){
	jQuery.get(SITEROOT+"/admin/sitemodules/ajax_getschool.php",{userid:userid},function(data){
		if(data)
		{
			jQuery('#school').html(data);
		}
		else
		{
			jQuery('#school').html("");
		}
	});
}
function getFriend(id){
	jQuery.get(SITEROOT+"/admin/sitemodules/ajax_getfriend.php",{id:id},function(data){
		if(data)
		{
			jQuery('#teammates').html(data);
		}
		else
		{
			jQuery('#teammates').html("");
		}
	});
}
function getEvent(){
	var cat = $('#category').val();
	var subcat = $('#subcategory').val();
	var school = $('#school').val();
	var sdate = $('#sdate').val();
	var edate = $('#edate').val();
	var chk_current = $('#curent').is(':checked');

	jQuery.get(SITEROOT+"/admin/sitemodules/ajax_getevent.php",{cat:cat, subcat:subcat, school:school, sdate:sdate, edate:edate, chk_current:chk_current},function(data){
		if(data)
		{
			jQuery('#event_name').html(data);
		}
		else
		{
			jQuery('#event_name').html("");
		}
	});
}
// function settoday()
// {
// 	jQuery('#pr_edate').show();
// 	jQuery('#div_edate').hide();
// }
// function unsettoday()
// {
// 	jQuery('#pr_edate').hide();
// 	jQuery('#div_edate').show();
// }

function get_school_name(user_id)
{
	jQuery.get(SITEROOT+"/modules/post_accomplishment/ajax_getSchoolName.php", {user_id:user_id}, function(data){
		jQuery('#school_name').val(data['edu'][0]['first_name']);
		jQuery('#school').val(data['edu'][0]['userid']);
	},'json');
}

function  getuser(id){
jQuery.get(SITEROOT+"/admin/sitemodules/ajax_getusers.php",{id:id},function(data){
      if(data)
      {
         jQuery('#added_userid').html(data);
      }
      else
      {
         jQuery('#added_userid').html("");
      }
   });
}
</script>
{/literal}
{include file=$header2}
{include file=$menu}
<div class="middel_panel">

	<h1 class="type2">{if $smarty.get.act eq "edit"}Edit{else}Add{/if} Accomplishment</h1>
	<div class="breadcrumb"><a href="{$siteroot}/admin/home.php">Home</a>&nbsp;&raquo;&nbsp;<a href="{$siteroot}/admin/sitemodules/post_accomplish/award.php">Accomplishment</a>&nbsp;&raquo;&nbsp;{if $smarty.get.act eq "edit"}Edit{else}Add{/if} Accomplishment</div> <br/>
	{if $msg}
	<div align="center" class="error" id="msg">{$msg}</div>
	{/if}

	<div class="holdthisTop">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="datagrid" >
    		<tr>
      		<td valign="top">
				   <form name="frmaccomplish" id="frmaccomplish" method="post" action="" enctype="multipart/form-data" > 
               <!--onsubmit="Javascript: return formchk();"-->
					<input type="hidden" value="{$accomp.acc_id}" name="id" id="gr" />
					<input type="hidden" value="{$accomp.common_flag}" name="common_flag" id="common_flag" />
      			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="2" class="conttable">
							<tr>
								<td align="right" valign="top"><font color="red">*</font> Accomplishment added By :</td>
								<td>
							<!--	<select name="added_userid" id="added_userid" style="width : 260px;" onclick="getuser({$smarty.get.id})">-->
                        <select name="added_userid" id="added_userid" style="width : 260px;" onclick="">
								<option value="">-- Select User --</option>
								{section name=i loop=$usersArr}
                               
								<option value="{$usersArr[i].userid}"{if $usersArr[i].userid eq $accomp.added_userid} selected="selected" {/if}>{$usersArr[i].first_name|ucfirst} {$usersArr[i].last_name|ucfirst}</option>
                  
								{/section}
								</select>
								</td>
							</tr>
							<tr>
								<td align="right"  valign="top"><font color="red">*</font> Student :</td>
								<td>
								<select name="user[]" id="user" style="width : 260px; height:77px;" onchange="javascript:getFriend(this.value); get_school_name(this.value);" multiple="true"/>
								<!--<option value="">-- Select Child --</option>-->
								{section name=i loop=$stud}
								<option value="{$stud[i].userid}" {if $same_acc_user neq ''}{if in_array($stud[i].userid, $same_acc_user) eq true} selected="selected" {/if}{/if}>{$stud[i].login_name|ucfirst} ({$stud[i].first_name|ucfirst} {$stud[i].last_name|ucfirst})</option>
								{/section}
								</select>
								</td>
							</tr>
       							<tr>
								<td width="30%" align="right" valign="top"><font color="red">*</font> Accomplishment:</td>
								<td align="left">
								<select name="award" id="award" style="width:260px;" onchange="chk_award();">
								<option value="">-- Select Accomplishment --</option>
								{section name=i loop=$award}
								<option value="{$award[i].award_id}" {if $accomp.award eq $award[i].award_id} selected="selected" {/if}>{$award[i].award_title|ucfirst}</option>
								{/section}
								</select><br>
								&nbsp;Or&nbsp;<br>
								<input type="text" name="new_award" id="new_award" size="35" value="" onchange="chk_award();" /><br>
								<input type="hidden" name="award_chk" id="award_chk" value=""/><div htmlfor="award_chk" generated="true" class="error"></div>
								</td>
							</tr>
							<tr>
								<td align="right"  valign="top"><font color="red">*</font> Category :</td>
								<td>
								<select name="category" id="category" onchange="javascript: getSubCat(this.value);"  style="width : 260px;">
								<option value="">-- Select Category --</option>
								{section name=i loop=$cat}
								<option value="{$cat[i].catid}"{if $cat[i].catid eq $accomp.catid} selected="selected" {/if}>{$cat[i].category|ucfirst}</option>
								{/section}
								</select>
								</td>
							</tr>
							<tr> 
								<td align="right"  valign="top"><font color="red">*</font> Subcategory :</td>
								<td>
								<select name="subcategory" id="subcategory" style="width : 260px;" onchange="getEvent();">
								{if $smarty.get.act eq 'edit'}
									{section name=j loop=$subcat}
									<option value="{$subcat[j].subcatid}" {if $subcat[j].subcatid eq $accomp.subcatid} selected="selected" {/if}>{$subcat[j].subcategory|ucfirst}</option>
									{/section}
								{else}
									<option value="">-- Select Subcategory --</option>
								{/if}
								</select>
								</td>
							</tr>
       							<tr>
								<td width="30%" align="right" valign="top"><font color="red">*</font> School:</td>
								<td align="left">
								<input type="text" name="school_name" id="school_name" value="" class="form01" style="width:345px;" readonly="true"/>
								<input type="hidden" name="school" id="school" value="">
								<!--<select name="school" id="school" style="width:260px;" onchange="javascript: getEvent();">
								<option value="">-- Select School --</option>
								{section name=i loop=$school}
								<option value="{$school[i].userid}" {if $accomp.location eq $school[i].userid or $curr_school eq $school[i].userid} selected="selected" {/if}>{$school[i].first_name|ucfirst}</option>
								{/section}
								</select>-->
								</td>
							</tr>
							<tr>
								<td width="30%" align="right" valign="top"><font color="red">*</font> When :</td>
								<td align="left"><!--<input value="1" name="curent" id="curent" type="checkbox" {if $accomp.current eq '1'} checked="true" {/if} onclick="if(this.checked) settoday(); else unsettoday(); getEvent();" >&nbsp;I am currently participating</td>
							</tr>
							<tr>
								<td width="30%" align="right" >&nbsp;</td>
								<td align="left"><input type="text" name="sdate" id="sdate" size="12"  {*if $accomp.current eq '1'} value="" {else*} value="{$accomp.start_date}" {*/if*} contenteditable="false" onchange="javascript: getEvent();"/>
								{literal}
								<script type="text/javascript" charset="utf-8">
								$(function()
								{
									$('#sdate').datepicker(
									{dateFormat: "yy-mm-dd",showOn: "both",  buttonImage: "../../../js/calender/templates/images/calendar.gif", buttonImageOnly: true});
								});
								</script>
								{/literal}
								&nbsp;To&nbsp;--><span id="div_edate"><input type="text" name="edate" id="edate" size="12"  value="{$accomp.end_date}" contenteditable="false" onchange="javascript: getEvent();"/>
								{literal}
								<script type="text/javascript" charset="utf-8">
								$(function()
								{
									$('#edate').datepicker(
									{dateFormat: "yy-mm-dd",showOn: "both", maxDate:"d", buttonImage: "../../../js/calender/templates/images/calendar.gif", buttonImageOnly: true});
								});
								</script>
								{/literal}</span><!--<span id="pr_edate">Present</span>-->
								<!--<div class="error" htmlfor="sdate" generated="true"></div>-->
								<div class="error" htmlfor="edate" generated="true"></div>
								<!--<br><span id="show_err" class="error"></span>--><!--<br><span id="show_err1" class="error"></span>-->
								</td>
							</tr>
							<!--<tr id="show_err">
								<td>&nbsp;</td><td><span class="error">Please Enter Date</span></td>
							</tr>
							<tr id="show_err1">
								<td>&nbsp;</td><td><span class="error">Please select valid date range</span></td>
							</tr>-->
       							<tr>
								<td width="30%" align="right" valign="top"><font color="red">*</font> Event Name:</td>
								<td align="left">
								<select name="event_name" id="event_name" style="width : 260px;" onchange="chk_event();">
								<option value="">-- Select Event --</option>
								{section name=i loop=$event}
								<option value="{$event[i].eventid}" {if $accomp.event_name eq $event[i].eventid} selected="selected" {/if}>{$event[i].title}</option>
								{/section}
								</select><br>
								&nbsp;Or&nbsp;<br>
								<input type="text" name="event" id="event" size="35" value="" onchange="validate_event(this.value);chk_event();" /><br>
								<input type="hidden" name="event_error" id="event_error" value="0">
								<input type="hidden" name="event_chk" id="event_chk" value="" /><div htmlfor="event_chk" generated="true" class="error">
								</td>
							</tr>
       							<tr>
								<td width="30%" align="right" valign="top">Teammates:&nbsp;</td>
								<td align="left">
								<select name="teammates[]" id="teammates" style="width : 260px; height: 50px;" multiple="true">
								{if $smarty.get.id eq ''}
								<option value="">-- Select Teammates --</option>
								{else}
								<option value="">-- Select Teammates --</option>
								{section name=i loop=$friend}
								<option value="{$friend[i].userid}" 
								{section name=j loop=$team} {if $team[j].userid eq $friend[i].userid} selected="selected" {/if} {/section}>{$friend[i].first_name|ucfirst} {$friend[i].last_name|ucfirst}</option>
								{/section}
								{/if}
								</select>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td align="left"><div class="buttons"><input type="submit" name="submit" value="Save" class="button1"/></div>
								<div class="buttons">
								<input type="button" name="Cancel" id="Cancel" value="Cancel" class="button1" onclick="javascript: history.go(-1);"  />
								</div></td>
							</tr>
      						</table>
    					</form>
 				 </div>
			</td>
		</tr>
	</table>
</div>
</div>
</div>

{include file=$footer} 