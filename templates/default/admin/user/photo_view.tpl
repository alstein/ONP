{include file=$header1}

{strip}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{/strip}
{include file=$header2}

{literal}
<script language="JavaScript">
	

$('#frmRegistration').submit(function(){
                    if ($('div.error').is(':visible'))
            {
            } 
            else 
            { 
                $('#submit').hide(); 
                $('#buttonregister').append("<input type='button' name='submit' id='submit' value='Post Comment' />"); 
            }
        });
});
</script>
{/literal}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; View/ Add Photo Commment</div>
<br />
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle} Photo</h3>
	  </div>
          <div class="clr">&nbsp;</div>

     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}

	 
  	</div>
    <div id="UserListDiv" name="UserListDiv">
     <!-- <form name="frmAction" id="frmAction" method="post" action="">-->
	<table cellspacing="2" cellpadding="3" class="listtable" width="90%" align="center">	
	    <tr >			
		
		<td width="10%" align="left" valign="top">Photo :</td>
		<td width="50%" align="left" valign="top"><img src="{$siteroot}/uploads/post_accomplish/thumbnail/{$photo.image}" width="150px;" height="150px;"></td>
		
	    </tr>
		<tr >			
		
		<td width="10%" align="left" valign="top">Date :</td>
		<td width="50%" align="left" valign="top">{$photo.added_date}</td>
		
	    </tr>
		
	</table>
      <!--</form>-->
<br>

  <form name="frmRegistration" id="frmRegistration" method="post" action="" enctype="multipart/form-data">
		<table width="90%" border="0" cellspacing="8" cellpadding="1" style="border:1px solid gray;" align="center">
			<tr>
				<td colspan="2" align="right"><a href="{$siteroot}/admin/testimonial/testimonial_list.php"><b>Back</b></a></td>
			</tr>
			<!--<tr>
				<td width="60%">
					<table width="100%" border="0" cellspacing="8" cellpadding="1">
						<tr>
							<td align="left" width="28%" valign="middle"><b>Photo </b></td>
							<td align="left" width="2%" valign="middle"> : </td>
							<td align="left" width="70%" valign="top">
								<b>{$smarty.get.title}</b>
							</td>
						</tr>
						
					</table>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr><td colspan="2">&nbsp;<hr/><hr/></td></tr>-->
			{section name=i loop=$photo_comment}
			<tr>
				<td width="60%">
					<b>Comments :</b>
					<table width="90%" border="0" cellspacing="8" cellpadding="1" align="center">
						<tr>
							<td align="left" width="30%" valign="middle">{$photo_comment[i].comment|html_entity_decode}</td>
						</tr>
						<tr>
							<td align="left" width="30%" valign="top"><b>Posted On : {$photo_comment[i].posted_on|date_format:$smarty_date_format}</b></td>
						</tr>
						<tr>
							<td align="left" width="30%" valign="top"><b>By :{$photo_comment[i].fullname}</b></td>
						</tr>
					</table>
				</td>
				<td align="right" valign="top">
				{if $photo_comment[i].status eq 'inactive'}	
				<a href="{$siteroot}/admin/user/photo_view.php?comment_id={$photo_comment[i].comment_id}&act=active&photoid={$smarty.get.photoid}"><b>Approve</b></a>
				{elseif $photo_comment[i].status eq 'active'}
				
				<a href="{$siteroot}/admin/user/photo_view.php?comment_id={$photo_comment[i].comment_id}&act=inactive&photoid={$smarty.get.photoid}"><b>Not Approve</b></a>
				{/if}
				<br>
				<a href="{$siteroot}/admin/user/photo_view.php?remove_id={$photo_comment[i].comment_id}&photoid={$smarty.get.photoid}"><b>Remove</b></a>	
				</td>
			</tr>
			<tr><td colspan="2">&nbsp;<hr/></td></tr>
			{sectionelse}
<tr><td colspan="2" align="center" class="error">No Comment Posted.</td></tr>
			{/section}
			
            </table>
	<br>
	<table width="90%" border="0" cellspacing="8" cellpadding="1" style="border:1px solid gray;" align="center">
	<tr>
	<td>Add Comments :</td>	
	<td>  <textarea name="comment" id="comment" rows="5" cols="50" ></textarea>
                <input type="hidden" name="bid" id="bid" value="{$row.id}"/></td>
	</tr>
	<tr>
	<td></td>	
	<td> <span id="buttonregister"><input type="submit" name="submit"  id="submit" value="Post Comments" /></span></td>
	</tr>
	</table>
        </form>
  </div>
</div>
{include file=$footer}
