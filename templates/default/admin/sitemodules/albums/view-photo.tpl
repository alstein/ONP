{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$siteroot}/js/admin/common.js"></script>
{/strip}
{literal}
<script type="text/javascript">
jQuery(document).ready(function()
{
    $("#frmcomment").validate({
        errorElement:'div',
        rules:{
            comment:{
                required:true,
                minlength:2,
                maxlength:300
            } 
        },
        messages:{
            comment:{
                required:"Please enter comment",
                minlength: "Please enter minimum 2 characters",
                maxlength: "Please enter maximum 300 characters"
            }
        }
    });
        
	$("#msg").fadeOut(5000);
	$("#success").hide();
});
/*function setAccomplishment(userid, photo)
{
	jQuery.get(SITEROOT+"/admin/sitemodules/albums/ajax_set_accomplish.php",{userid:userid, photo:photo},function(data){
		if(data == 'true'){
			$("#success").show();
			$("#success").fadeOut(5000);
		}
		else{
		}
	});
}
function unsetAccomplishment(userid, photo)
{
	jQuery.get(SITEROOT+"/admin/sitemodules/albums/ajax_unset_accomplish.php",{userid:userid, photo:photo},function(data){
		if(data == 'true'){
		}
		else{
		}
	});
}*/
</script>
{/literal}
{include file=$header2}
{include file=$menu}

<div class="middel_panel">
<h1 class="type2">View Photo</h1>
<div class="breadcrumb"><a href="{$siteroot}/admin/home.php">Home</a>&nbsp;&raquo;&nbsp;{if $smarty.get.accid neq ''}<a href="{$siteroot}/admin/sitemodules/post_accomplish/award.php">Accomplishment</a>&nbsp;&raquo;&nbsp;View Photo{else}<a href="{$siteroot}/admin/sitemodules/albums/album.php">Album</a>&nbsp;&raquo;&nbsp;Album Photos&nbsp;&raquo;&nbsp;View Photo{/if} </div> <br/>
<div class="holdthisTop">
</div>

<div class="holdthisTop">
<div style="margin-left:770px"><a href="javascript:void(0);" onclick="javascript:history.go(-1);"> <strong>Back </strong></a></div>
  <form name="form1" method="post" id="frmAction" action="" >
    <tr>
      <td  colspan="2"><table cellpadding="3" cellspacing="0" align="center" width="100%" border="0" class="datagrid">
          <tr>
		<td align="left" ><!--<a href="{$siteroot}/admin/sitemodules/polls/poll_result_excel.php?pid={$poll_details.poll_id}&excel=1"><strong>Export to Excelsheet</strong></a>-->&nbsp;</td>
            
              <input type="hidden" name="class_id" value="{$class.id}" />
            </td>
          </tr>
          <tr>
            <td width="100%"  align="left" colspan="2">
              <table cellpadding="5" cellspacing="0" align="center" width="100%" border="0">
		{if $msg}
		<tr>
			<td align="center" valign="top" id="msg" colspan="2">{$msg}</td>
		</tr>
		{/if}
		<tr id="success">
		  <TD align="center" valign="top" colspan="2">Photo set as Accomplishment successfully</TD>
		</tr>

<!-- display the image. -->
{if $cat.image}
                <tr>
                  <td align="right" width="20%" valign="top"><strong>Photo:</strong></td>
                  <td>
<!--can display image from 400X400 folder  -->
<!--{if $cat.image}-->


<img src="{$siteroot}/uploads/post_accomplish/400X400/{$cat.image}"/></td>
<!--{else}
<img src="{$siteroot}/uploads/post_accomplish/thumbnail/noimage.jpg"></td>
{/if}-->

                </tr>
{/if}
                             <!--<tr>
                  <td align="right"><strong>Title:</strong></td>
                  <td>{$cat.photo_title}</td>
                </tr>-->
                <tr>
                <td align="right"><strong>Added Date:</strong></td>
                <td>{$cat.added_date}</td>
                </tr>
		<!--<tr>
			<td align="right"  valign="top">&nbsp;</td>
			<td align="left">
				<div id='divbox' >
				<input  type="checkbox" name="accomp_photo" id="accomp_photo" {if $cat.isAccomplishment eq '1'} checked="true" onclick="unsetAccomplishment('{$smarty.session.duAdmId}','{$cat.thumbnail}');" {else} onclick="setAccomplishment('{$smarty.session.duAdmId}','{$cat.thumbnail}');" {/if}/> Accomplishment Photo
				</div>
			</td>
		</tr>-->

                <!-- <tr>
                    <table cellspacing="2" cellpadding="2" width="100%" border="0" class="datagrid">-->
                        <!--<tr class="headbg">
							<th width="1%" align="center" valign=""><input type="checkbox" id="checkall"></th>
							<th  align="left" valign="center" width="30%">User Name</th>
							<th width="40%" align="center" valign="center">Comment</th>
							<th width="29%" align="center" valign="center">Posted date</th>
						</tr>-->
						<!--{section name=c loop=$photocomments}
						{if $photocomments}
						<tr class="grayback" id="tr_{$photocomments[c].id}">
							<td align="center" valign="top">
							<input type="checkbox" name="comid[]" value="{$photocomments[c].id}" />
							</td>
							<td align="left" valign="top">
							{if $photocomments[c].thumbnail neq ''}
							<img src="{$siteroot}/uploads/user_photo/{$photocomments[c].thumbnail}" align="left" width="55" height="55"/>
							{else}
							<img width="52" height="52" src="{$siteroot}/uploads/user_photo/nophoto.jpeg" align="left"/>
							{/if}
							<br/>
							{if $photocomments[c].username}{$photocomments[c].username}{else}Admin{/if}
							</td>
							<td align="left" valign="top">{$photocomments[c].comment}</td>
							<td align="left" valign="top">{$photocomments[c].date_added}</td>
						</tr>
						{/if}
						{sectionelse}
						{assign var = 'foo' value = '1'}
						<tr align="center" class="trbgprj02">
							<td colspan="5"><b> Comment not added yet.</b></td>
						</tr>
						{/section}-->
                   <!-- {if $foo != '1'}
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
							<input type="submit" name="submit" id="submit" value="Go" />
							</td>
							</tr>
							</table>
							<span id="acterr" class="error"></span>
						</td>
					</tr>
                    {/if}-->
                <!--</table>
            </tr>-->
        </table>
    </td>
</tr>
</table>
</td>
</tr>
</form>
    <!--<tr>
        <td align="left">
            <form name="frmcomment" id="frmcomment" method="post">
            <input type="hidden" name="module_id" id="module_id" value="3">
            <input type="hidden" name="item_id" id="item_id" value="{$smarty.get.vid_id}">
                <table width="100%" border="0" cellspacing="6" cellpadding="0" class="datagrid">
                    <tr>
                        <td align="right" valign="top" width="15%">Post Comment</td>
                        <td align="left" width="85%"><textarea name="comment" id="comment" cols="50" rows="5"></textarea></td>
                    </tr>
                    
                    <tr>
                            <td width="15%" align="right" valign="top"></td>
                            <td align="left" width="85%"><input type="submit" name="submit" id="submit" value="Post Comment" ></td>
                    </tr> 
                </table>
            </form>
        </td>
    </tr>-->
</div>
</div>
</div>

{include file=$footer}