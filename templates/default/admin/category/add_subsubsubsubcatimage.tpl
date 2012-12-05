{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
{if $smarty.get.edit_id}
    <script type="text/javascript" src="{$siteroot}/js/validation/admin/edit_subcat_image.js"></script>
{else}
    <script type="text/javascript" src="{$siteroot}/js/validation/admin/add_subcat_image.js"></script>
{/if}
{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/category/category_list.php">Main Categories</a> &gt; <a href="{$siteroot}/admin/category/subcat.php?cat_id={$main_cat_id}">Sub Categories List</a> &gt; <a href="{$siteroot}/admin/category/subsubcat.php?cat_id={$sub_cat_id}"> Sub Sub Categories List</a> &gt; <a href="{$siteroot}/admin/category/subsubsubcat.php?cat_id={$sub_sub_cat_id}"> Sub Sub Sub Categories List</a> &gt; <a href="{$siteroot}/admin/category/subsubsubcatimage.php?cat_id={$smarty.get.cat_id}"> Image List</a> &gt; {if $smarty.get.edit_id eq ''}Add{else}Edit{/if} Image </div><br />

<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/category/subcatimage.php"> Sub Category Images List</a> &gt;
{if $smarty.get.edit_id} Edit Sub Category Images{else} Add Sub Category Images{/if}</div><br/>-->

<div class="holdthisTop">
    <div>
        <div class="fl width50">
            <h3>{if $smarty.get.edit_id eq ''}Add{else}Edit{/if} Image</h3>
        </div>
        <div class="clr">&nbsp;</div>
         {if $msg}<div align="center" id="msg">{$msg}<br/></div>{/if}

    </div><br/>

      <div class="clr">&nbsp; </div>
    <div id="UserListDiv" name="UserListDiv">
  
    <form name="home_form" action="" id="home_form" method="post" enctype="multipart/form-data">
       <input type="hidden" value="{$smarty.get.edit_id}" name="id_name" id="id_name" />
       <input type="hidden" value="{$deal_cat_id}" name="deal_cat_id" id="deal_cat_id" />
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
                <div> <img src="{$siteroot}/uploads/subcat_image/{$image_logo}" title="Active" align="middle" style="float:left;" width="35" height="36"  /></div>{/if}
              </td>
	       <td valign="left" align="center">{$sub_cat[i].added_date|date_format:$smarty_date_format}</td>
             </tr>
<!--             <tr>
                    <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Link :</td> 
                    <td align="left" width="40%"><input type="text" name="link" id="link" value="{$link}" style="width:268px;"/></td>
            </tr>-->
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
                 <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="javascript: window.location = '{$siteroot}/admin/category/subsubsubsubcatimage.php?cat_id={$smarty.get.cat_id}'" class="but_new fl"/>
      </div>
      </div>
      </td>
    </tr>
  </table>
  </form> 
</div>
</div>
{include file=$footer}