{include file=$header_seller1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>

{include file=$header_seller2}
<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> <a href="{$siteroot}/admin/seller/rating/raviews_rating_deals_list.php"> &gt; Review And Rating Deals List</a> &gt; Review And Rating List 
</div>
<br/>-->
<section id="maincont" class="ovfl-hidden">

	<section class="grybg">
		<div class="pagehead">
			<div class="grpcol">
				<ul class="reset ovfl-hidden tab1">
					<li><a href="{$siteroot}/admin/seller/my-profile-view.php">My Account</a> </li>
					<li><a href="{$siteroot}/admin/seller/deal/add_product.php">Deal Management</a> </li>
					<li><a href="{$siteroot}/admin/seller/rating/raviews_rating_deals_list.php" class="active">Masters</a> </li>
					<li><a href="{$siteroot}/admin/seller/login-log.php">Tools</a> </li>
				</ul>
                
                <div class="SubNav">
                <a href="{$siteroot}/admin/seller/rating/raviews_rating_deals_list.php" class="active">Manage Reviews and Ratings</a>
                </div>
			
           
			</div>
		</div>
        <h3 class="subtitle">{$sitetitle} Review And Rating List</h3>
        
		<div class="innerdesc">
	   {if $msg != ""}<div align="center" id="msg"><br />{$msg} <br /><br /></div>{/if}
       
       <!--<h3 class="pagehead2" style="float:left">Deal Name:{$dealname}</h3>-->
        <h3 class="pagehead2" style="float:right"><a href="{$siteroot}/admin/seller/rating/raviews_rating_deals_list.php">Back</a></h3>
        <div style="clear:both;"></div>
        <div class="border"></div>
        
    <div id="UserListDiv" name="UserListDiv" style="min-height:300px;">
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
                <tr class="headbg">			
                   <!-- <td width="1%" align="center"><input type="checkbox" id="checkall"/></td>-->
                    <!--<td width="15%" align="left">Deal Name</td>-->
                    <td width="27%" align="left">User Name</td>
                    <td width="18%" align="left">Review </td>
                    <td width="18%" align="left">Date</td>
                    <td width="11%" align="left">Deal Rating Mark</td>
                    <td width="11%" align="left">Action</td>
	       </tr>
		{section name=i loop=$ratingmark}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
                   <!-- <td><input type="checkbox" value="{$ratingmark[i].rating_id}" id="rating_id[]" name="rating_id[]"/></td>		-->  
                   <!-- <td valign="top"> {$ratingmark[i].title} </td>		-->  
                    <td valign="top">{$ratingmark[i].fullname}</a> </td>
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
		  <td valign="top">
		      <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle"/>
		      <a href="raviews_rating_view.php?rating_id={$ratingmark[i].rating_id}" title="Show Rating Details">
		      <strong>View</strong></a>
                  </td>
            </tr>
            {sectionelse}
            <tr>
                <td colspan="5" class="error" align="center">No Records Found.</td></tr>
            {/section}			
		{if $ratingmark}
		<tr>
		    <!--<td align="left">-->
		       <!-- <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />-->
		   <!-- </td>-->
		   <!-- <td align="left" colspan="1">-->
			<!--<select name="action" id="action">
                            <option value="">--Action--</option>
                            <option value="delete">Delete</option>
			</select>
			 <input type="submit" name="submit" id="submit" value="Go"/>
		        <div id="acterr" class="error"></div>-->
		   <!-- </td>-->
		    <td align="right" colspan="5">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
		</tr>
		{/if}
	</table>
</form>
</div>
   </div>
</section>
</section>
{include file=$footer_seller}
