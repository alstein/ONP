{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;Review And Rating Deals List 
</div>
<br/>
    <div class="holdthisTop">
	<div>
                <div class="fl width50">
                        <h3>{$sitetitle} Review And Rating Deals List</h3>
                </div>
                <div class="clr">&nbsp;</div>
  	</div>
        <div class="clr">&nbsp; </div>
     <div id="UserListDiv" name="UserListDiv">
        {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
                <tr class="headbg">			
                    <td width="2%" align="center"><input type="checkbox" id="checkall"/></td>
                    <td width="20%" align="left">User Name</td>
			 <td width="20%" align="left">Merchant Name</td>
                    <td width="18%" align="left">Rating Mark</td>
		 <td width="58%" align="left">Feedback</td>
                    <!--<td width="20%" align="left">Action</td>-->
	       </tr>
		{section name=i loop=$ratingmark}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td><input type="checkbox" value="{$ratingmark[i].rating_id}" id="userid" name="deal_id[]"/></td>		  
                    <td valign="top"> {$ratingmark[i].fullname1|html_entity_decode} </td>
			<td valign="top"> {$ratingmark[i].business_name|html_entity_decode} </td>
		    <td valign="top">		 
                                                        {section name=loop start=1 loop=6}
                                                                {if $smarty.section.loop.index <=  $ratingmark[i].average_rating}
                                                                        <img src="{$siteroot}/templates/default/images/admin/rating.png" align="absmiddle"/>
                                                                {else}
                                                                        <img src="{$siteroot}/templates/default/images/admin/star-empty.png" align="absmiddle">  
                                                                {/if}
                                                            {/section}
		  </td>	
				<td valign="top"> {$ratingmark[i].feedback|html_entity_decode} </td>	 
		 <!-- <td valign="top">
		      <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle"/>
		      <a href="raviews_rating_list.php?deal_id={$ratingmark[i].deal_id}" title="Show Rating Details">
		      <strong>View</strong></a>
                  </td>-->
                </tr>
            {sectionelse}
            <tr>
                <td colspan="3" class="error" align="center">No Records Found.</td></tr>
            {/section}			
		{if $ratingmark}
		<tr>
		    <td align="left">
		        <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
		    </td>
		    <td align="left" colspan="1">
			<select name="action" id="action">
                            <option value="">--Action--</option>
                            <option value="delete">Delete</option>
			</select>
			 <input type="submit" name="submit" id="submit" value="Go"/>
		        <div id="acterr" class="error"></div>
		    </td>
		    <td align="right" colspan="3">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
		</tr>
		{/if}
	</table>
</form>
</div>
</div>
{include file=$footer}
