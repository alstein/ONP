{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
{if $smarty.get.edit_id}
    <script type="text/javascript" src="{$siteroot}/js/validation/admin/editvideo.js"></script>
{else}
    <script type="text/javascript" src="{$siteroot}/js/validation/admin/addvideo.js"></script>
{/if}

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/modules/video/video_list.php"> Manage Videos</a> &gt;
{if $smarty.get.edit_id} Edit Manage Videos{else} Add Manage Videos{/if}

</div><br/>

<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle}   Manage Videos</h3>
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
           <td width="20%" align="right" valign="top" ><span style="color:red;">*</span>Video Title :</td> 
           <td align="left" width="40%"><input type="text" name="videotitle" id="videotitle" value="{$video_title}"   style="width:268px;" maxlength="255"/>
           <div> Please enter upto 255 characters.</div></td> 
        </tr>
        <tr>
          <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Video Type :</td>
          <td><input type="radio" name="videotype" id="videotype" value="file" {if $video_type eq "file"}  checked="true"{/if} >.Mp4 file<br/>
              <input type="radio" name="videotype" id="videotypee" value="link" {if $video_type eq "link"} checked="true"{/if} >You tube embed video link 
              <div class="error" htmlfor="videotype" generated="true"></div>
         </td>
      </tr>
            <tr> 
              <td width="20%" align="right" valign="top" > Video File :</td> 
              <td align="left" width="40%">
                <input type="file" name="video" id="video" onkeypress="return false" onkeydown="return false" onselect="return false"/>&nbsp;&nbsp;<br/>[Maximum video size limit 10MB] [Video should be .mp4] <!-- value="{$video_file}" " onfocus="blur()"-->
                <input id="old_video" type="hidden" value="{$video_file}" name="old_video">
                 <!-- START OF THE VIDEO PLAYER EMBEDDING -->
                  {if $video_file neq ''}
               <script type="text/javascript" src="{$siteroot}/mediaplayer/jwplayer.js"></script> 
               <div id="mediaplayer">JW Player goes here</div>
                        {literal} 
                           <script type="text/javascript">
                              jwplayer("mediaplayer").setup({
                                 flashplayer: "{/literal}{$siteroot}/mediaplayer/player.swf{literal}",
                                 file: "{/literal}{$siteroot}/uploads/video/{$video_file}{literal}",
                                 width:"300",
                                 height:"200" 
                              });
                           </script>
                        {/literal}
               <!-- END OF THE VIDEO PLAYER EMBEDDING -->
               <!-- <input type="hidden" name="old_video" id="old_video" value="{$video}"/>-->
                {/if}
              </td>
             </tr>
              <tr>
                    <td width="20%" align="right" > Video Link :</td> 
                    <td align="left" width="40%"><input type="text" name="videolink" id="videolink" value="{$video_link}"   style="width:268px;"/></td>
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
      <div style="width:140px"> 
         <div id="buttonregister" style="overflow:hidden">
         {if $id neq ""}
                 <input type="submit" name="Update" id="Update" value="Update" class="but_new fl" />
                 {else}
                  <input type="submit" name="Save" id="Save" value="Save" class="but_new fl"/>
                  {/if}
                 <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="javascript: location='video_list.php'" 
                 class="but_new fr"/>
         </div>
      </div>
      </td>
    </tr>
  </table>
  </form> 
</div>
</div>
{include file=$footer}
