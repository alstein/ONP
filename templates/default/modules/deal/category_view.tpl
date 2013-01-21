{include file=$new_header}

<!-- Header ends -->
<!-- Maincontent starts -->
<div id="maincont" class="ovfl-hidden">
    <div class="view-deals">
        <div style="padding:10px 0px 10px 20px;">
            <h1>{$category}</h1>
        </div>    
        <ul class="reset">
            {section name=i loop=$all_deals}
            <li>
                <div class="deal-slide ">
                    <div class="deal-top">
                        <div>&nbsp;</div>
                    </div>
                    <div class="deal-bg">
                        <div class="price-rate">
                            <p>{$all_deals[i].discount_in_per}% Off</p>
                        </div>
                        <div class="deal-user-img"> 
                            <a href="{$siteroot}/buy/{$all_deals[i].deal_unique_id}/"><img src="{if $all_deals[i].deal_image}{$siteroot}/uploads/deal/225x225/{$all_deals[i].deal_image}{else}{$siteroot}/templates/default/images/deal-image.png {/if}" title="" alt="" width="225" height="225" /></a>
                        </div>
                        <div class="price-info">
                            <h1>{*$all_deals[i].discount_in_per*}<!--% off on -->{$all_deals[i].deal_title|substr:0:35}</h1>
                            <p>Offered by <span>{$all_deals[i].business_name|ucwords}</span></p>
                            <!--<p class="deal-price"> Offer Price: <abbr>${$all_deals[i].offer_price}</abbr></p>-->
                        </div>
                    </div>
                    <div class="deal-btm">
                        <div>&nbsp;</div>
                    </div>
                </div>
            </li>
            {sectionelse}
            <div align="center" style="padding:10px 0px 10px 20px;height:100px">No deal found.</div>
            {/section}
        </ul>
        <div class="clr"></div>
    </div>
    <ul class="reset"> 	
        <li style="text-align:right">{$pgnation}</li>
    </ul>
    <!-- Maincontent ends -->
</div>
{include file=$footer}