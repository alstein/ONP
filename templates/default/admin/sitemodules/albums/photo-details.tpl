{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
{literal}
<script type="text/javascript">
jQuery(document).ready(function()
{
	jQuery("#checkall").click(function()
 	{
		var checked_status = this.checked;
		jQuery("input[type=checkbox]").each(function()
		{
			this.checked = checked_status;
			change(this);	
		});
 	});
	jQuery("input[type=checkbox]").click(function()
 	{
		var i=0;
		var flag=0;
 	        var checked_status = this.checked;
 	        jQuery("input[type=checkbox]").each(function()
		{
		  i++;
		  if(this.checked && i!=1)
		  {
			flag++;
		  }
		  else if(i!=1)
		  {
			flag--;
		  }
		});
		if(flag==(i-1))
		{
		  	jQuery("#checkall").attr('checked',true);
		}else{
  			jQuery("#checkall").attr('checked',false);
		     }
		
		change(this);
 	});
	function change(chk)
	{
		var jQuerytr = jQuery(chk).parent().parent();
		if(jQuerytr.attr('id'))
		{
			if(jQuerytr.attr('class')=='selectedrow' && !chk.checked)
				jQuerytr.removeClass('selectedrow').addClass('grayback');
			else
				jQuerytr.removeClass('grayback').addClass('selectedrow');
		}
	}
	jQuery("#frmAction").submit(function(){
		var flag = false;
		if(jQuery("#action").attr('value')=='')
		{
			jQuery("#acterr").text("Please select an action.").show().fadeOut(3000);
			return false;
		}
		jQuery("input[type=checkbox]").each(function()
		{
			var $tr = jQuery(this).parent().parent();
			if($tr.attr('id'))
				if(this.checked == true)
					flag = true;
		});
		
		if (flag == false) {
			jQuery("#acterr").text("Please select a record.").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure you want to "'+jQuery("#action").attr('value')+'" the selected record(s)?'))
			return true;
		else
			return false;
    });
    
    jQuery("#frmcomment").validate(
    {
        errorElement:'div',
        rules:
        {
            comment:
            {
                required:true,
                minlength:2,
                maxlength:300
            } 
        },
        messages:
        {
            comment:
            {
                required:"Please enter comment",
                minlength: "Please minimum 2 characters",
                maxlength: "Please maximum 300 characters"
            }
        }
    });
	jQuery("#msg").fadeOut(5000);
});
</script>
{/literal}
{include file=$header2}
{include file=$menu}

<div class="middel_panel">

<h1 class="type2">Album Details</h1>
<div class="breadcrumb"><a href="{$siteroot}/admin/home.php">Home</a>&nbsp;&raquo;&nbsp;<a href="{$siteroot}/admin/sitemodules/albums/album.php">Albums</a>&nbsp;&raquo;&nbsp;View Album </div> <br/>
<div  class="conttable" >
    <div style="margin-left:770px"><a href="javascript:void(0);" onclick="javascript:history.go(-1);"> <strong>Back </strong></a></div>
        <form name="frmAction" id="frmAction" action="" method="post">
            <table cellspacing="6" cellpadding="2" width="100%" border="0" class="datagrid">
                    <table cellspacing="6" cellpadding="2" width="100%" border="0" class="datagrid">
						<form name="frmphoto" id="frmphoto" action="" method="post">
                            {if $msg}
                            <tr>
                                <td align="center" valign="top" class="error" colspan="2" id="msg">{$msg}</td>
                            </tr>
                            {/if}
                           <tr>
								<td colspan="2"><strong>Edit Album {$albumdetails.album_title}</strong></td>
							</tr>
							{section name=p loop=$album_photos}
							<tr>
								<td width="25%" valign="top" align="right">Caption:</td>
								<td width="25%" valign="top" align="right"><textarea name="caption{$smarty.section.p.iteration}" id="caption{$smarty.section.p.iteration}" cols="42" rows="5">{$album_photos[p].photo_title}</textarea></td>
					
								<td width="50%" align="left" valign="top">
								<img src="{$siteroot}/uploads/album/thumbnail/{$album_photos[p].thumbnail}">
								<input type="hidden" name="hiddenphotoid{$smarty.section.p.iteration}" id="hiddenphotoid{$smarty.section.p.iteration}" value="{$album_photos[p].photo_id}"><br>
								<input type="radio" name="photo" id="photo"
									{if $smarty.section.p.iteration eq '1' } checked="true" {/if} 
									value="{$album_photos[p].photo_id}">&nbsp;This is the album cover.</td>
							</tr>
							{/section}
							<tr>
								<td><input type="hidden" name="count_photos" id="count_photos" value="{$count_photos}">
								</td>
								<td><div class="buttons"><input type="submit" name="savebtn" id="savebtn" value="Save" class="input1"></div></td>
							</tr>
							</form>
                            {if $comm}
                            <tr> 
                                <table cellspacing="2" cellpadding="2" width="100%" border="0" class="datagrid">
                                    <tr class="headbg">
                                        <th width="1%" align="center" valign=""><input type="checkbox" id="checkall"></th>
                                        <th  align="left" valign="left" width="30%">User Name</th>
                                        <th width="40%" align="left" valign="center">Comment</th>
	                                <th width="29%" align="center" valign="center">Posted date</th>
                                    </tr>
                   
                                    {section name=i loop=$comm}
                                    <tr class="grayback" id="tr_{$comm[i].id}">
                                        <td align="center" valign="top"><input type="checkbox" name="id[]" value="{$comm[i].id}" /></td>
                                        <td  align="left" valign="top">{$comm[i].login} </td>
                                        <td  align="left" valign="top">{$comm[i].comment} </td>
                                        <td align="center" valign="top">{$comm[i].date_added|date_format:"%b %e, %Y"} </td>
                                    </tr>
                            
                                    {sectionelse}
                                    {assign var = 'foo' value = '1'}
                                    <tr align="center" class="trbgprj02">
                                        <td colspan="5"><b> Comment not added yet.</b></td>
                                    </tr>
                                    {/section}
                            
                                    {if $foo !='1'}
                                    <tr>
                                        <td align="right">
                                            <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
                                        </td> 
                                        <td colspan="3" align="left">
                                            <table width="100%">
                                                <tr>
                                                    <td align="left" width="5%">
                                                        <select name="action" id="action">
                                                            <option value="">--Action--</option>
                                                            <option value="delete">Delete</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                       <div class="buttons">
                                                        <input type="submit" name="submit" id="submit" class="button1" value="Go" /></div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <span id="acterr" class="error"></span>
                                        </td>
                                    </tr>
                                    {/if}
                                </table>
                            </tr>
                            {/if}
                        </table>
                   <!-- </form>-->
                </table>
            </form>
            <tr>
                <td align="left">
                    <form name="frmcomment" id="frmcomment" method="post">
                        <input type="hidden" name="module_id" id="module_id" value="9">
                        <input type="hidden" name="item_id" id="item_id" value="{$smarty.get.blogid}">
                        <table width="100%" border="0" cellspacing="6" cellpadding="0" class="datagrid">
                            <tr>
                                <td align="right" valign="top" width="15%">Post Comment</td>
                               <td align="left" width="85%"><textarea name="comment" id="comment" cols="50" rows="5"></textarea></td>
                            </tr>
                            
                            <tr>
                                <td width="15%" align="right" valign="top"></td>
                                <td align="left" width="85%"><div class="buttons"><input type="submit" name="submit" id="submit" value="Post Comment" ></div></td>
                            </tr> 
                        </table>
                    </form>
                </td>
            </tr>
	</div>
    </div>
</div>
</div>
{include file=$footer}