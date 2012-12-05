{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/edit_home_image.js"></script>

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/modules/home/homepage_empty_areas_list.php"> Homepage Empty Areas List</a> &gt;
{if $smarty.get.edit_id} Edit Homepage Empty Areas{else} Add Homepage Empty Areas{/if}</div><br/>

<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle}  Homepage Empty Areas</h3>
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
           <td width="20%" align="right" valign="top" >Section Title :</td> 
           <td align="left" width="40%"><b>{$section_title}</b><input type="hidden" name="sectiontitle" id="sectiontitle" value="{$section_title}"   style="width:268px;" maxlength="255" />
           </td> 
        </tr>
        <tr>
          <td width="20%" align="right" valign="top"><span style="color:red;">*</span>	Display By :</td>
          <td><input type="radio" name="display_by" id="none" value="none" {if $display_by eq "none"}  checked="true"{/if} >None<br/>
              <input type="radio" name="display_by" id="videotype" value="image" {if $display_by eq "image"} checked="true"{/if} >Image <br/>
              <input type="radio" name="display_by" id="videotypee" value="text" {if $display_by eq "text"} checked="true"{/if} >Text
              <div class="error" htmlfor="display_by" generated="true"></div>
         </td>
       </tr>
            <tr> 
                <td width="20%" align="right" valign="top" >Image File :</td> 
                <td align="left" width="40%">
                    <input type="file" name="image" id="image" onkeypress="return false" onkeydown="return false" onselect="return false"/>&nbsp;&nbsp;<br/>{$image_size_message}
                    <input id="old_image" type="hidden" value="{$image_file}" name="old_image">
                    <input id="image_size_message" type="hidden" value="{$image_size_message}" name="image_size_message"><br/>
                    {if $image_file}
                    <img src="{$siteroot}/uploads/home/{$image_file}" title="{$image_file}" align="middle" style="float:left;" width="51" height="33" />
                    {/if}
                        <div class="error" htmlfor="image" generated="true"></div>
                </td>
            </tr>
            <tr>
                <td width="20%" align="right" valign="top">Text Message:</td> 
                <td align="left" width="40%">
                   <!-- <input type="text" name="textmessage" id="textmessage" value="{$text_message}"   style="width:268px;" maxlength="255"/>-->
                    <!--<div> Please enter upto 255 characters.</div>-->
                    {oFCKeditor->Create}
                    </td>
            </tr>
           <tr>
                    <td align="right"  valign="top"><span style="color:red;">*</span>Status:&nbsp;</td>
                    <td align="left">
                        <input type="radio" name="status" id="status" value="1" {if $status eq "1"}  checked="true"{/if}>
                        Active &nbsp;&nbsp;
                        <input type="radio" name="status" id="status" value="0" {if $status eq "0"}  checked="true"{/if}/>
                        Inactive 
                        <div class="error" htmlfor="status" generated="true"></div>
                    </td>
          </tr>	
     <tr>
            <td>&nbsp;</td>
            <td align="left">
                <div style="width:150px"> 
                    <div id="buttonregister" style="overflow:hidden">
                            <input type="submit" name="Update" id="Update" value="Update" class="but_new fl" />
                            <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="javascript: location='homepage_empty_areas_list.php'" 
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
