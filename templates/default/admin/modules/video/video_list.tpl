{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Manage Videos</div><br/>
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle} Manage Videos</h3>
	  </div>
          <div class="clr">&nbsp;</div> <span  class="fr"><img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_video.php">Add New Video</a></span>
     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
  	</div>

      <div class="clr">&nbsp;
    </div>
    <div id="UserListDiv" name="UserListDiv">
    <!--{if $msg}<div align="center" id="msg">{$msg}</div>{/if}-->
       <form name="frmAction" id="frmAction" method="post" action="video_list.php" enctype="multipart/form-data">
	<table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
	    <tr class="headbg">			
		<td width="1%" align="center"><input type="checkbox" id="checkall" name="checkall"/></td>
		  <td width="20%" align="left">Video Title</td>
		  <td width="15%" align="left">Video Type</td>
		   <td width="15%" align="left">Actual Video</td>
		   <td width="15%" align="left">Video Link</td>
		   <td width="10%" align="left">Added Date</td>		 
		  <td width="10%" align="left">Action</td>
	    </tr>	    
		 {section name=i loop=$list}
		<tr class="grayback" id="tr_{$smarty.section.i.iteration}">
		
		  <td><input type="checkbox" name="id[]" value="{$list[i].id}" id="id[]"/></td>
		  
		  
		  <td valign="middle">{if $list[i].status  eq '0'}
		            <img src="{$siteroot}/templates/{$templatedir}/images/icons/award_star_silver_1.png" align="absmiddle" title="Inactive" 
		            style="float:left; "/>
                     {else}
                          <img src="{$siteroot}/templates/{$templatedir}/images/icons/award_star_silver_2.png" title="Active" align="middle" style="float:left;" />
                    {/if}&nbsp;&nbsp;{$list[i].video_title}		  
                </td>
		  <td valign="middle">  {if $list[i].video_type eq 'file'} .MP4 file {else} You tube embed video link {/if}</td>
		  <td valign="middle" width="22%">
		    {if $list[i].video_file neq ''}
		   	<script type="text/javascript" src="{$siteroot}/mediaplayer/jwplayer.js"></script> 
                    	<div id="mediaplayer_{$list[i].id}">JW Player goes here</div>
                       	{literal} 
                           <script type="text/javascript">
                              	jwplayer("mediaplayer_{/literal}{$list[i].id}{literal}").setup({
                                 flashplayer: "{/literal}{$siteroot}/mediaplayer/player.swf{literal}",
                                 file: "{/literal}{$siteroot}/uploads/video/{$list[i].video_file}{literal}",
                                 width:"200",
                                 height:"120"
                              });
                           </script>
           		{/literal}
          	     {else}
			------
           	     {/if}
		  </td>
		  
		  <td valign="middle">{if $list[i].video_link}{$list[i].video_link}{else}------{/if}</td>
		  
		 <td valign="middle">{$list[i].date_added|date_format:$smarty_date_format}</td>	
		 	 
		 	 
		  <td valign="middle">
		   <div>
                      <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
                        <a href="add_video.php?edit_id={$list[i].id}" title="Edit">
                    <strong>Edit</strong></a>
                    </div>
                 </td>
                
		</tr>
		
		{sectionelse}
			<tr><td colspan="6" class="error" align="center">No Records Found.</td></tr>
		{/section}			
		{if $list}
		<tr>
		    <td align="left">
		        <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
		    </td>
		    <td align="left" colspan="2">
			 <select name="action" id="action">
                           <option value="">--Action--</option>
                           <option value="active">Active</option>
                           <option value="inactivate">Inactive</option>
                           <option value="delete">Delete</option>
                        </select>
			<input type="submit" name="submit" id="submit" value="Go"/>
		        <div id="acterr" class="error"></div>
		    </td>
		    <td align="right" colspan="7">{if $showpgnation eq "yes"}{$pagenation}{/if}{$pgnation}</td>
		</tr>
		{/if}
	</table>

</form></div>
</div>
{include file=$footer}
