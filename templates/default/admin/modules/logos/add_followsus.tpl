{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
{if $smarty.get.edit_id}
    <script type="text/javascript" src="{$siteroot}/js/validation/admin/edit_followus.js"></script>
{else}
    <script type="text/javascript" src="{$siteroot}/js/validation/admin/add_followus.js"></script>
{/if}

{literal}
<script language="JavaScript">
	$(document).ready(function()
{
   

$('#home_form').submit(function(){
                    if ($('div.error').is(':visible'))
            {
            } 
            else 
            { 
                $('#Save').hide(); 
                $('#buttonregister').append("<input type='button' name='Save' id='Save' value='Save' />"); 
            }
        });
});
</script>
{/literal}
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/modules/logos/followus_logo_list.php"> Manage Followus Logos</a> &gt;
{if $smarty.get.edit_id} Edit Manage Followus Logos{else} Add Manage Followus Logos{/if}</div><br/>

<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle}   Manage Followsus Logos</h3>
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
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Logo Title :</td> 
           <td align="left" width="40%"><input type="text" name="imagetitle" id="imagetitle" value="{$image_title}"   style="width:268px;" maxlength="255"/>
           <div> Please enter upto 255 characters.</div></td> 
        </tr>
             <tr> 
              <td width="20%" align="right" valign="top"><span style="color:red;">*</span> Image Logo :</td> 
              <td align="left" width="40%">
                <input type="file" name="image" id="image" value="{$video_file}" contenteditable="false" />&nbsp;&nbsp;<br/>(Note: Please upload image with 35*36 [w*h]) [Image should be .jpg,.gif,.png file. ]
                {if $smarty.get.edit_id}
               <br>
                <div> <img src="{$siteroot}/uploads/logos/{$image_logo}" title="Active" align="middle" style="float:left;" width="35" height="36" /></div>{/if}
              </td>
             </tr>
             <tr>
                    <td width="20%" align="right" ><span style="color:red;">*</span>Link :</td> 
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
      <div style="width:50%"> 
       
         {if $id neq ""}
                 <input type="submit" name="Update" id="Update" value="Update" class="but_new fl" />
                 {else}
                   <div id="buttonregister"> <input type="submit" name="Save" id="Save" value="Save" class="but_new fl"/> </div>
                  {/if}
                <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="javascript: location='followus_logo_list.php'" 
                 class="but_new fl"/>
     
      </div>
      </td>
    </tr>
  </table>
  </form> 
</div>
</div>
{include file=$footer}
