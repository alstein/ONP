{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> <a href="{$siteroot}/admin/user/user_view.php?userid={$smarty.get.userid}"> &gt; Review And Rating Deals List</a> &gt; Review And Rating List 
</div>
<br/>
    <div class="holdthisTop">
	<div>
                <div class="fl width50">
                        <h3>{$sitetitle} Review And Rating List  Of Merchant {$firstname|ucfirst}</h3>
                </div>
                <div class="clr">&nbsp;</div>
  	</div>
        <div class="clr">&nbsp; </div>
    <div id="UserListDiv" name="UserListDiv">
        {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
                <tr class="headbg">			
                    <td width="1%" align="center"><input type="checkbox" id="checkall"/></td>
                    <!--<td width="15%" align="left">Deal Name</td>-->
			
                    
		    <td width="20%" align="left">Merchant Name</td>
		    <td width="20%" align="left">Posted By Consumer</td>
                    <td width="18%" align="left">Review </td>
                    <td width="15%" align="left">Date</td>
                    <td width="11%" align="left">Rating Mark</td>
                    <!--<td width="11%" align="left">Action</td>-->
	       </tr>
		{section name=i loop=$ratingmark}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td><input type="checkbox" value="{$ratingmark[i].rating_id}" id="userid" name="rating_id[]"/></td>
					  
                   <!-- <td valign="top"> {$ratingmark[i].title} </td>		--> 
		    <td valign="top">{$ratingmark[i].merchant|ucfirst}</a> </td>
		    <td valign="top">{$ratingmark[i].fullname|ucfirst}</a> </td> 
                    <td valign="top">{$ratingmark[i].feedback|truncate:100}</a> </td>		  
                    <td valign="top">{$ratingmark[i].rating_date|date_format:$smarty_date_format}</td>		  
		    <td valign="top">		 
		          {if  $ratingmark[i].average_rating neq '' && $ratingmark[i].average_rating neq ''}
		              <ul class="fr reset rating">
                                    <li>
                                                            {section name=loop start=1 loop=6}
                                                                {if $smarty.section.loop.index <=  $ratingmark[i].average_rating}
                                                                        <img src="{$siteroot}/templates/default/images/admin/rating.png" align="absmiddle"/>
                                                                {else}
                                                                        <img src="{$siteroot}/templates/default/images/admin/star-empty.png" align="absmiddle">  
                                                                {/if}
                                                            {/section}
                <!-- Tool tip div start -->
                {if $ratingmark[i].subprofile_r}
                                        <div class="tooltip">
                                        <div class="ttop">&nbsp;</div>
                                      <div class="tbg">
                                            <span class="tooltiparrow"></span>
                                                <ul class="reset list">
                                                    {section name=j loop=$ratingmark[i].subprofile_r}
                                                    <li>
                                                            <div class="username fl">{$ratingmark[i].subprofile_r[j].rating_question|@ucfirst}</div>
                                                            <div class="fr">
                                                                {section name=foo start=0 loop=$ratingmark[i].subprofile_r[j].rating_mark step=1}
                                                                    <img src="{$siteroot}/templates/default/images/admin/rating.png" align="absmiddle"/>
                                                                    {assign var='blankrat' value=$smarty.section.foo.iteration}
                                                                {/section}
                                                                {section name=foo start=$blankrat loop=5 step=1}
                                                                    <img src="{$siteroot}/templates/default/images/admin/star-empty.png" align="absmiddle"> 
                                                                {/section}
                                                            </div>
                                                        </li>
                                                    {/section}
                                                </ul>
                                        </div>
                                        <div class="tbot">&nbsp;</div>
                                        </div>
                {/if}
                <!-- Tool tip div end -->
                                    </li>
                             </ul>
                                {/if}
		  </td>		 
		  <!--<td valign="top">
		      <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle"/>
		      <a href="view_review_details.php?rating_id={$ratingmark[i].rating_id}" title="Show Rating Details">
		      <strong>View</strong></a>
                  </td>-->
            </tr>
            {sectionelse}
            <tr>
                <td colspan="6" class="error" align="center">No Records Found.</td></tr>
            {/section}			
		{if $ratingmark}
		<tr>
		    <td align="left">
		        <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
		    </td>
		    <td align="left" colspan="2">
			<select name="action" id="action">
                            <option value="">--Action--</option>
                            <option value="delete">Delete</option>
			</select>
			 <input type="submit" name="submit" id="submit" value="Go"/>
		        <div id="acterr" class="error"></div>
		    </td>
		    <td align="right" colspan="5">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
		</tr>
		{/if}
	</table>
</form>
</div>
</div>
{include file=$footer}
