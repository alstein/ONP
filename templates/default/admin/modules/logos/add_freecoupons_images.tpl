{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
{if $smarty.get.edit_id}
    <script type="text/javascript" src="{$siteroot}/js/validation/admin/edit_freecoupons_image.js"></script>
{else}
    <script type="text/javascript" src="{$siteroot}/js/validation/admin/add_freecoupons_image.js"></script>
{/if}
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/modules/logos/freecoupons_images_list.php"> Manage Free Coupons Images List</a> &gt;
{if $smarty.get.edit_id} Edit Manage Freecoupons Images{else} Add Manage Free Coupons Images{/if}</div><br/>

<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle}  Manage Free Coupons Images</h3>
	  </div>
          <div class="clr">&nbsp;</div>
     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
	</div>

      <div class="clr">&nbsp; </div>
    <div id="UserListDiv" name="UserListDiv">
  
    <form name="home_form" action="" id="home_form" method="post" enctype="multipart/form-data">
       <input type="hidden" value="{$smarty.get.edit_id}" name="id_name" id="id_name" />
      <table width="100%" border="0" cellspacing="2" cellpadding="6" class="conttableDkBg conttable">
        <tr> 
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Image Title :</td> 
           <td align="left" width="40%"><input type="text" name="imagetitle" id="imagetitle" value="{$image_title}"   style="width:268px;" maxlength="255"/>
           <div> Please enter upto 255 characters.</div></td> 
        </tr>
             <tr> 
              <td width="20%" align="right" valign="top"><span style="color:red;">*</span> Image :</td> 
              <td align="left" width="40%">
                <input type="file" name="image" id="image" value="{$video_file}" onkeypress="return false" onkeydown="return false" onselect="return false"/>&nbsp;&nbsp;<br/>[Please upload image with maximum height less than or equal to of 47 px. only]
                {if $smarty.get.edit_id}
               <br>
                <div> <img src="{$siteroot}/uploads/freecoupon_image/{$image_logo}" title="Active" align="middle" style="float:left;" width="35" height="36"  /></div>{/if}
              </td>
             </tr>
             <tr>
                    <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Link :</td> 
                    <td align="left" width="40%"><input type="text" name="link" id="link" value="{$link}" style="width:268px;"/></td>
            </tr>
         <tr>
          <td align="right"  valign="top"><span style="color:red;">*</span>Status:&nbsp;</td>
          <td align="left">
            <input type="radio" name="status" id="status" value="1"  checked="true">
             Active &nbsp;&nbsp;
            <input type="radio" name="status" id="status" value="0" {if $status eq "0"}  checked="true"{/if}/>
           Inactive 
           <div class="error" htmlfor="status" generated="true"></div>
        </td>
    </tr>	
    <tr>
      <td>&nbsp;</td>
      <td align="left">
      <div style="width:34%"> 
         <div id="buttonregister">
         {if $id neq ""}
                 <input type="submit" name="Update" id="Update" value="Update" class="but_new fl" />
                 {else}
                  <input type="submit" name="Save" id="Save" value="Save" class="but_new fl"/>
                  {/if}
                 <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="javascript: location='freecoupons_images_list.php'" 
                 class="but_new fl"/>
      </div>
      </div>
      </td>
    </tr>
  </table>
  </form> 
</div>
</div>
{include file=$footer}
