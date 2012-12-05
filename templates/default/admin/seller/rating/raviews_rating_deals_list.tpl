{include file=$header_seller1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>

{include file=$header_seller2}
<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;Review And Rating Deals List 
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
        <h3 class="subtitle">{$sitetitle} Review And Rating Deals List</h3>
        
		<div class="innerdesc">
		{if $msg != ""}<div align="center" id="msg"><br/>{$msg}<br/> <br/></div>{/if}


     <div id="UserListDiv" name="UserListDiv">
        
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
                <tr class="headbg">			
                    <!--<td width="2%" align="center"><input type="checkbox" id="checkall"/></td>-->
                    <td width="68%" align="left">Deal Name</td>
                    <td width="15%" align="left">Deal Rating Mark</td>
                    <td width="15%" align="left">Action</td>
	       </tr>
		{section name=i loop=$ratingmark}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
                   <!-- <td><input type="checkbox" value="{$ratingmark[i].deal_id}" id="deal_id[]" name="deal_id[]"/></td>-->		  
                    <td valign="top"> {$ratingmark[i].deal_title|html_entity_decode} </td>
		    <td valign="top">		 
                                                        {section name=loop start=1 loop=6}
                                                                {if $smarty.section.loop.index <=  $ratingmark[i].avg}
                                                                        <img src="{$siteroot}/templates/default/images/admin/rating.png" align="absmiddle"/>
                                                                {else}
                                                                        <img src="{$siteroot}/templates/default/images/admin/star-empty.png" align="absmiddle">  
                                                                {/if}
                                                            {/section}
		  </td>		 
		  <td valign="top">
		      <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle"/>
		      <a href="raviews_rating_list.php?deal_id={$ratingmark[i].deal_id}" title="Show Rating Details">
		      <strong>View</strong></a>
                  </td>
                </tr>
            {sectionelse}
            <tr>
                <td colspan="3" class="error" align="center">No Records Found.</td></tr>
            {/section}			
		{if $ratingmark}
		<tr>
		   <!-- <td align="left">-->
		       <!-- <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />-->
		   <!-- </td>-->
		    <!--<td align="left" colspan="">-->
			<!--<select name="action" id="action">
                            <option value="">--Action--</option>
                            <option value="delete">Delete</option>
			</select>
			 <input type="submit" name="submit" id="submit" value="Go"/>
		        <div id="acterr" class="error"></div>-->
		   <!-- </td>-->
		    <td align="right" colspan="3">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
		</tr>
		{/if}
	</table>
</form>
</div>


</div>
    </div>
</section>
</section>
{include file=$footer_seller}