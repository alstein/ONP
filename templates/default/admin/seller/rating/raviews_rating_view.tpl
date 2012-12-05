{include file=$header_seller1}
{include file=$header_seller2}

<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a>
<a href="{$siteroot}/admin/seller/rating/raviews_rating_deals_list.php?deal_id={$deal}">&gt; Review And Rating Deals List
 <a href="{$siteroot}/admin/seller/rating/raviews_rating_list.php?deal_id={$deal}"> &gt;  Review And Rating List </a>
&gt; Review And Rating Information
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
       
		<div class="innerdesc">
        <!--<h3 class="pagehead2" style="float:left">Deal Name:{$dealname}</h3>-->
        <h3 class="pagehead2" style="float:right"><a href="{$siteroot}/admin/seller/rating/raviews_rating_list.php?deal_id={$deal}">Back</a></h3>
        <div style="clear:both;"></div>
        <div class="border"></div>
        
        <ul class="form_div">
        	{if $emptyblog}
        	<li>No Deals Rating Found</li>
            {else}
            <li>
            <label>Deal Name: </label>
            <div class="fl">{$dealname|html_entity_decode}</div>
            </li>
            <li>
            <label>User Name: </label>
            <div class="fl">{$fristname}  {$lastname}</div>
            </li>
            <li>
            <label>Review Text: </label>
            <div class="fl">{$feedback_text} </div>
            </li>
            <li>
            <label>Rating Mark:</label>
            <div class="fl">
            <table>
                            {section name=i loop=$subprofile}
                            <tr>
                             <td>{$subprofile[i].rating_question}</td>
                                {section name=loop start=1 loop=6}
                                                <td>   {if $smarty.section.loop.index <=  $subprofile[i].rating_mark}
                                                                <img src="{$siteroot}/templates/default/images/admin/rating.png" align="absmiddle"/>
                                                        {else}
                                                            <img src="{$siteroot}/templates/default/images/admin/star-empty.png" align="absmiddle">  
                                                        {/if}
                                                </td>
                                {/section}
                                </tr>
                            {sectionelse}
                            <tr>
                                <td></td>
                                <td>-----</td>
                            </tr>
                             {/section}
                            </table>
            </div>
            </li>
            <li>
            <label>Rating Date:</label>
            <div class="fl">{$ratingdate|date_format:$smarty_date_format}</div>
            </li>
             {/if}
		</ul>
       
</div>
</section>
</section>
{include file=$footer_seller}
