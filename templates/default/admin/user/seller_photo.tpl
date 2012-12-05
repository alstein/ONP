{include file=$header1}

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/user/seller_photo_list.php?userid={$smarty.get.user_id}"> Album Information</a>
 </div>
<br />


  <table width="82%"  align="center">
    <tr>
      <td>
      
        <form name="frmPage" id="frmPage" method="post" action="" enctype="multipart/form-data">
          <input type="hidden" name="pageid" value="{$page.pageid}" />
          <table width="100%"  border="0" cellpadding="6" cellspacing="2">
          

            <tr>
              <td width="15%" align="right" valign="top"><b>Album Title: </b></td>
              <td align="left">{$users.album_title|ucfirst}</td>
            </tr>

		<tr>
              <td valign="top" align="right"><b>Created By: </b></td>
             <td align="left">{$users.fullname|ucfirst}</td>
            </tr>
	
            <tr>
              <td valign="top" align="right"><b>Description: </b></td>
              <td align="left">{$users.album_description}</td>
            </tr>
             <tr>
              <td valign="top" align="right"><b>Photo: </b></td>
              <td valign="top">
		{if $image neq ""}
			{* Display album photo *}
			{section name=i loop=$image}
			<a  href="{$siteroot}/admin/user/view_photos_comment.php?userid={$image[i].user_id}&photoid={$image[i].photo_id}" title="View Comment"><img  src='{$siteroot}/uploads/album/photo/thumbnail/{$image[i].thumbnail}'  width="60px" height="60px"></a>
			{/section}
		{else}
			No Photo
		{/if}
       </td>
            </tr>
		 <tr>
              <td valign="top" align="right"><b>Added Date: </b></td>
              <td align="left">{$users.added_date|date_format:"%d/%m/%Y %H:%M:%S"}</td>
                
                </td>
            </tr>
            <tr>
              <td align="right" valign="top"></td>
              <td>
                <input type="button" name="Cancel" value="Close" onclick="javascript: location='seller_photo_list.php?userid={$smarty.get.user_id}';" /></td>
            </tr>
          </table>
        </form></td>
    </tr>
  </table>

{include file=$footer}