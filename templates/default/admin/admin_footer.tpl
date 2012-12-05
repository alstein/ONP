<!-- Footer starts -->
{if $popupset eq 'yes'}
<body onmousemove="dragWin(event, 'popupWin')" >
<div class="popup_window" id="popupWin"  style="display:none;">
	<div class="popup_heading">
		<div class="drag_area" onMouseDown="mouse_down(event, 'popupWin')" onMouseUp="mouse_up(event,'popupWin')" style="margin-left:10px">
			<div id="idCodHead">News Alerts</div>
		</div>
    	<div class="buttons"><img src="{$siteroot}/templates/default/images/min.gif" alt="" id="minWin" /><img src="{$siteroot}/templates/default/images/max.gif" style="display:none" alt="" id="maxWin" />&nbsp;<img src="{$siteroot}/templates/default/images/closenew.gif" class="close" alt="" /></div>
    </div>
    <div class="content" style="color:#000000" style="width:675px">
			{section name=i loop=$news_array}
            <h3 class="allCaps">{$news_array[i].news_title}</h3>
            <p style="padding-bottom:10px;">{$news_array[i].description}</p>
            {/section}
	</div>
</div>
</body>
{/if}
<div id="footerwrap">
   <div id="footer">
        <!-- Get footer pages -->
        <div class="footercont ovfl-hidden">
	  {section name=i loop=$page_cat}
              {if $page_cat[i].categoty}
	      <div class="{if $smarty.section.i.index eq 0}companysec{elseif $smarty.section.i.index eq $page_cat.totpgs}selleresec{else}learnmoresec{/if} fl">
            	<p class="strong">{$page_cat[i].categoty|ucwords}</p>
                <ul class="reset list">
	         {assign var=sub_pgs value=$page_cat[i].subpage}
			
			

	             {section name=k loop=$sub_pgs}
			{if $sub_pgs[k].page eq 'FAQ'}
			<li><a href="#">FAQ</a></li>
			{else}	
                	<li><a href="#" {if $smarty.get.id1 eq $sub_pgs[k].page_url }style="font-weight:bold;"{/if}>{$sub_pgs[k].page|ucwords}</a></li>
			{/if}
                      {/section}
                </ul>
              </div>
              {/if}
	  {/section}
        </div>
        <!-- End footer pages -->
	 <p class="centerAll copyright"><img src="{$siteimg}/payments.PNG" alt="payment" /> 
        </p>	
        <p class="centerAll copyright" style="font-size:10px;">&copy; 2010 -2011 Group Buy It All Rights Reserved<br/>Group Buy It is a trading name of Round Of Play Ltd - Company Registered in England - Registration No. 7306894 - VAT <br/>Registration No. 996660262<!-- <img src="{$siteimg}/w3cxhtml.gif" alt="w3cxhtml" /> <img src="{$siteimg}/w3ccss.gif" alt="w3ccss" />-->
        </p>
    </div>
</div>
<!-- Footer ends -->
</div>
</body>
</html>