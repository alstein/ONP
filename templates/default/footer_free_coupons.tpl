{*<!--This is for Travel-->*}

	{if $travelRes}
        <div class="slider" style="height:120px;">
          <h5 class="bigtxt">TRAVEL</h5>
          <div class="whtbg rel"> <a class="arwlt" href="#">&#x00A0;</a> <a class="arwrt" href="#">&#x00A0;</a>
		     
                <div class="gallery-box_travel">
                    <div class="gallery-holder_travel">
                        <div class="gallery_travel">
        
                            <div class="sld-img">
                                {if $travelRes|@count gt 8}<a href="javascript:void(0);" class="arwlt" id="prevslideTravel">&#x00A0;</a>{/if}
                                <div class="gallery-hold_travel">
                                    <div class="slider_travel" id="sliderTravel">
                                    
                                    {section name=i loop=$travelRes}
                                    {if $travelRes[i].image}
                                    <div class="img-area_travel">
                                    
                                            <div class="sld-img01"><a href="{$travelRes[i].link}" target="_blank"><img src="{$siteroot}/uploads/travelbar_image/{$travelRes[i].image}" alt="icon" title="{$travelRes[i].title}" style="border:0px;"></a></div>
                                            
                                    </div>
                                    {/if}
                                    {/section}
                                    
                                    </div>
                                </div>
                                {if $travelRes|@count gt 8}<a href="javascript:void(0);" class="arwrt" id="nextslideTravel">&#x00A0;</a>{/if}
                            </div>
        
                        </div>
                    </div>
                </div>

          </div>
        </div>
	{/if}

{*<!--This is for Free Coupons-->*}

	{if $freeCoupRes}
        <div class="slider">
          <h5 class="bigtxt">FREE Coupons</h5>
          <div class="whtbg rel"> <a class="arwlt" href="#">&#x00A0;</a> <a class="arwrt" href="#">&#x00A0;</a>
		     
                <div class="gallery-box_freecoupons">
                    <div class="gallery-holder_freecoupons">
                        <div class="gallery_freecoupons">
        
                            <div class="sld-img">
                                {if $freeCoupRes|@count gt 8}<a href="javascript:void(0);" class="arwlt" id="prevslideFreeCoupons">&#x00A0;</a>{/if}
                                <div class="gallery-hold_freecoupons">					
                                    <div class="slider_freecoupons" id="sliderFreeCoupons">
                                    
                                    {section name=i loop=$freeCoupRes}
                                    {if $freeCoupRes[i].image}
                                    <div class="img-area_freecoupons">
                                    
                                            <div class="sld-img01"><a href="{$freeCoupRes[i].link}" target="_blank"><img src="{$siteroot}/uploads/freecoupon_image/{$freeCoupRes[i].image}" alt="icon" title="{$freeCoupRes[i].title}" style="border:0px;"></a></div>
                                            
                                    </div>
                                    {/if}
                                    {/section}
                                    
                                    </div>
                                </div>
                                {if $freeCoupRes|@count gt 8}<a href="javascript:void(0);" class="arwrt" id="nextslideFreeCoupons">&#x00A0;</a>{/if}
                            </div>
        
                        </div>
                    </div>
                </div>

          </div>
        </div>
	{/if}
