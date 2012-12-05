{include file=$header1}
{literal}
<script type="text/javascript">
$(document).ready(function()
{
	$("#checkall").click(function()
 	{
		var checked_status = this.checked;
		$("input[@type=checkbox]").each(function()
		{
			this.checked = checked_status;
			change(this);	
		});
 	});
	$("input[@type=checkbox]").click(function()
 	{
		change(this);
 	});
	function change(chk)
	{
		var $tr = $(chk).parent().parent();
		if($tr.attr('id'))
		{
			if($tr.attr('class')=='selectedrow' && !chk.checked)
				$tr.removeClass('selectedrow').addClass('grayback');
			else
				$tr.removeClass('grayback').addClass('selectedrow');
		}
	}
	var flag = false;
	$("#frmAction").submit(function(){
		
		if($("#action").attr('value')=='')
		{
			$("#acterr").text("Please select action.").show().fadeOut(3000);
			return false;
		}
		$("input[@type=checkbox]").each(function()
		{
			var $tr = $(this).parent().parent();
			if($tr.attr('id'))
				if(this.checked == true)
					flag = true;
		});
		
		if (flag == false) {
			$("#acterr").text("Please select atleast one record.").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action'))
			return true;
		else
			return false;
    });
	$("#msg").fadeOut(5000);
});
</script>
{/literal}

{include file=$header2}
<div class="holdthisTop">
	<div class="breadcrumb">
		<a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/modules/forum/index.php">Forums</a> &gt; Posts</div><br/>
	<div id="msg" align="center">{$msg}</div>
<div >
  <table width="100%" cellpadding="6" cellspacing="2" class="conttableDkBg conttable">
    <tr>
      <td valign="top" align="justify"><h4>{$forum.title}</h4>
        <br />
        {$forum.description}</td>
    </tr>
  </table>
  <form name="frmSearch" action="" method="get">
  <input type="hidden" name="forumid" value="{$forum.forumid}" />
    <table width="100%" cellspacing="2" cellpadding="6">
      <tr>
        <td><!--<img src="{$siteroot}/templates/{$templatedir}/images/icons/add.png" align="absmiddle"> <a href="{$siteroot}/admin/modules/forum/create_thread.php?forumid={$forum.forumid}">Add Post</a>--></td>
        <td align="right"><!--<table width="35%" align="right" cellpadding="0" cellspacing="0">
            <tr>
              <td width="73%" align="right"><label>
                <input name="search" type="text" id="search" value="{$smarty.get.search}" size="35" class="search" />
                </label></td>
              <td width="27%" align="left"><input type="submit" name="button" id="button" value="Submit" class="searchbutton" /></td>
            </tr>
          </table>-->
          <img src="{$siteroot}/templates/{$templatedir}/images/icons/add.png" align="absmiddle"> <a href="{$siteroot}/admin/modules/forum/create_thread.php?forumid={$forum.forumid}">Add Post</a>
          </td>
      </tr>
    </table>
  </form>
</div>
<table width="100%" align="center" cellpadding="6" cellspacing="2">
  <td width="100%" valign="top" colspan="3"><form name="frmAction" id="frmAction" method="post" action="">
        <table width="100%" cellpadding="6" cellspacing="2" align="center" class="listtable">
          <tr class="headbg">
            <td align="center" valign="top" width="1%"><input type="checkbox" id="checkall" /></td>
            <th valign="top" width="30%" >Posted By</th>
            <th valign="top"> Post </th>
            <!--<th valign="top" width="10%" align="center">Reply</th>-->
            <th valign="top" width="15%">Action</th>
          </tr>
          {section name=i loop=$threads}
          <tr class="grayback" id="tr_{$threads[i].threadid}">
            <td align="center" valign="top"><input type="checkbox" name="threadid[]" value="{$threads[i].threadid}" /></td>
            <td align="left" valign="top"><span class="orangeTitle">{$threads[i].first_name} {$threads[i].last_name}</span>
              </p>
              <p>{$threads[i].posted_date|date_format:$smarty_date_format}<br />
              </p>
            <td  align="left" valign="top"><h5><!--<a href="reply_list.php?threadid={$threads[i].threadid}">date_format:"%d-%b-%Y %I:%M %p"-->
                        {$threads[i].title}
                        <!--</a>-->
                        </h5>
           <!-- <td align="center" valign="top">{$threads[i].replies}</td>-->
            <td valign="top"><img src="{$siteimg}/icons/application_edit.png" align="absmiddle" />&nbsp;<a href="create_thread.php?threadid={$threads[i].threadid}&forumid={$threads[i].forumid}">Edit</a></td>
          </tr>
           {sectionelse}
           <tr>
                <td colspan="4" align="center"> <strong>No record(s) found</strong></td>
        </tr>
          {/section}
          <tr>
            <td align="left"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
            <td align="left"><select name="action" id="action">
                <option value="">--Action--</option>
                <option value="delete">Delete</option>
              </select>
              <input type="submit" name="submit" id="submit" value="Go" />
              <span id="acterr" class="error"></span></td>
            <td align="right" colspan="3">{if $paging eq "yes"}{$pagination}{/if}{$pgnation}</td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
</div>
{include file=$footer} 