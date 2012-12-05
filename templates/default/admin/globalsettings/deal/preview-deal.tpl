{include file=$admin_header_start}

{strip}
<script type="text/javascript" src="{$siteroot}/js/ajax_page_url.js"></script>
<!--<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=prakashshinde"></script>-->
{/strip}

{include file=$admin_header_end}
  <!-- Maincontent starts -->
  <div id="maincont">
  <div class="selectsecbg">
      <table border="0" cellspacing="0" cellpadding="0" class="selecttable">
        <col width="235" />
        <col width="278" />
        <col width="65" />
        <col width="28" />
        <col width="54" />
        <col width="258" />
        <tr>	
          <td>
              <select class="selectbg" style="width:225px" name="cat">
		<option value="">All Categories</option>
		{section name=i loop=$category_list}
		{if $category_list[i].category}
		<option value=""><strong>{$category_list[i].category}</strong></option>{/if}
		{/section}
            </select>
	  </td>
          <td><div class="srcbg" style="height:22px;"><input type="text" class="srcinput" name="cate_name" value="{$smarty.get.cate_name}"/></div></td>
          <td><input type="submit" value="Go" class="btngo" name="submit"/></td>

          <td>or</td>
          <td><label for="browse">Browse:</label></td>
          <td>
              <select id="browse" class="selectbg" style="width:258px">
		<option >All Categories</option>
		{section name=i loop=$category_list}
		{if $category_list[i].category}<option>{$category_list[i].category}</option>{/if}
		{/section}
            </select></td>
        </tr>
      </table>
    </div>
    <div class="featuregroup fullwid">
      <div class="featuregroupL fl">
        <h2 class="allCaps detailtitle">{$deal.title}</h2>
         <div id="imageslider">	
	   <div class="container1">  
            <div class="slides">
		{section name=i loop=$dealImages}
		  <div style="position:absolute; display:block;">
		      <div class="imgdiv rel">
			  <img src="{$siteroot}/uploads/product/thumb577X385/{$dealImages[i]}" alt="img" />
			 {if $deal.show_deal_tag eq 'yes'} <div class="allCaps hotdealbg bigTxt strong">{if $deal.deal_tag}{$deal.deal_tag}{else}Todays Hot Deal{/if}</div>{/if}
		      </div>
		  </div>
		{/section}
             </div>
	   </div>
	    <div class="ovfl-hidden">
	      <div class="fl" style="padding-top:6px;">

		</div>
	      <div class="fr smlwid"> 
		<ul  class="pagination" style="margin:6px 0 0;">
		    {section name=i loop=$dealImages}
		    <li><a href="#" class="active">&nbsp;</a></li>
		    {/section}
		</ul>
	      </div>
	    </div>
         </div>

      </div>
      <div class="featuregroupR fr">
        <div class="brddiv">
          <table cellpadding="0" cellspacing="0" border="0" class="joingtable">
            <tr>

              <td><span class="price">&pound;{$deal.groupbuy_price}</span></td>
            </tr>
            <tr>  
              <td><div class="ovfl-hidden marginL">{if $deal_flag eq '2'}<a class="joingroup">Sold Out</a>{else}<a class="joingroup" href="#">Buy</a>{/if}</div></td>
            </tr>
          </table>
        </div>

        <div class="brddiv" style="padding-top:24px">
          <div class="probar">
            <div class="point" style="left:0">
              <p class="clrone">&nbsp;</p>
              <p>0</p>
            </div>
            <div class="point" style="left:{$deal.min_bar}px">
              <p class="clrone">Min</p>
              <p>{$deal.min_buyer}</p>
            </div>
            <div class="point" style="right:0">
              <p class="clrone">Max</p>
              <p>{$deal.max_buyer}</p>
            </div>
            <div class="cursor" style="left:{$deal.proleft3}px">&nbsp;</div>
            <div class="movebar" style="width:{$deal.proleft2}px">&nbsp;</div>
          </div>
          <div class="bought">{if $deal.bought1}{$deal.bought1}{else}0{/if} Bought</div>
        </div>

        {if $total_buy eq '1'}
	  <div class="brddiv">
	    <p class="deal">This deal is on</p>
	  </div>
        {/if}

        <div class="brddiv">
          <p class="upperCase timetxt smlTxt">Time remaining</p>
<!--          <div class="ovfl-hidden">
	    <script language="JavaScript">registerCountdown('{$deal.end_date}','d{$deal.deal_unique_id}');</script>
	    <div class="image-box">
		    <div class="countdown"  id="cd_d{$deal.deal_unique_id}"></div>  
	    </div>
          </div>-->
          <div class="ovfl-hidden">
            <div class="datecol fl">
              <div class="datebg">02</div>
              <span class="smlTxt">days</span> </div>
            <div class="datecol fl">
              <div class="datebg">02</div>
              <span class="smlTxt">hrs</span> </div>
            <div class="datecol fl">
              <div class="datebg">25</div>
              <span class="smlTxt">mins</span></div>
            <div class="datecol fl">
              <div class="datebg">23</div>
              <span class="smlTxt">sec</span> </div>
          </div>
        </div>
        <div>
        </div>
	{if $deal.deal_type eq 'product'}
	<div class="brddiv">
	    <div class="sellertitle">
      <!-- for product type-->

	      <p class="fl" style="font-size:13px">{if $seller_type eq '3'}SELLER:&nbsp;{/if}
		  <ul class="reset sellerdropdown">
			<li><a href="#">{if $seller_type eq '3'} {$username} {else}<strong style="color:#00A9C6">Group Buy It Own Deal</strong>{/if}</a>
			    <ul class="reset">
				<li><a href="#">User Profile / Feedback</a></li>
			      {if $smarty.session.csUserId}<li><a href="#">Ask Question</a></li>{/if}
			  </ul>
		      </li>
		    </ul>
	      </p> 
	      <div style="width:30px;float:left;background:{$color}; margin-left:5px;"> &nbsp;</div>
	      <div class="clr">&nbsp;</div>    
	    </div>
	  {/if}

	  {if $deal.deal_type eq 'service'}
	  <p class="fl" style="font-size:13px">
	    <ul class="reset sellerdropdown">
	      <li><a href="#" style="color:#00A9C6">Voucher Deal</a>
		  <ul class="reset">
		      <li><a href="#">User Profile / Feedback</a></li>
		  {if $smarty.session.csUserId}<li><a href="#">Ask Question</a></li>{/if}
		  </ul>
	      </li>
	    </ul>
	  </p> <div style="width:30px;float:left;background:{$color}; margin-left:5px;"> &nbsp;</div>
	  <div class="clr">&nbsp;</div>    
	  {/if}

<!--	<div class="brddiv"> 
          <div style="padding-left:4px;">Share this deal:&nbsp;</div> 
          <div class="addthis_toolbox addthis_default_style" style="padding-left:100px; margin-top:-16px;"> 
              <a class="addthis_button_facebook"  addthis:title="{$product[j].title1}"></a>
              <a class="addthis_button_twitter"  addthis:title="{$product[j].title1}"></a>
              <a class="addthis_button_email"  addthis:title="{$product[j].title1}"></a>
              <a class="addthis_button_compact" addthis:title="{$product[j].title1}: {$product[j].title1}"></a>
          </div>
       </div>-->
       <div class="brddiv">
	  <!--<a class="purchasegift" href="#">Gift Purchase</a>-->{if $smarty.session.csUserId} <a class="addtowishlist" href="#" ><b>Add to Wishlist</b></a> {else}<a class="addtowishlist" href="#">Add to Wishlist</a>{/if}<Br />
	  <div id="succid1" style="color:red"></div>
       <br/>
       </div>
      </div>
      <div class="clr">&nbsp;</div>
      <div class="ovfl-hidden abtprodsec">

      	<div class="fl prodcolL">
        	<dl class="prodterm">
            	<dt>Product Highlights</dt>
                <dd>
		    {$deal.highlight|html_entity_decode|stripcslashes}
                </dd>
            </dl>
            <dl class="prodterm">
            	<dt>Product Description</dt>
                <dd>
                      {$deal.description|html_entity_decode|stripcslashes}
                </dd>
            </dl>
            <dl class="prodterm">
            	<dt>Terms</dt>
                <dd>
                	{$deal.fineprint|html_entity_decode|stripcslashes}
                </dd>
            </dl>
            <div class="ovfl-hidden sharediscusssec">
            	<div class="fl sharedealsec">
                </div>
                <div class="fl descusssec"><a href="#" class="descuss">Discuss this deal</a></div>
                <div class="clr">&nbsp;</div>
                <div class="ovfl-hidden purchasesec"></div>
		<div id="succid" style="color:red"></div>
	    </div>

              <!--     FORUM -->
	    <input type="hidden" id="dealId" value="{$deal.deal_unique_id}"/>
	    <div class="graybg">
		<div id="threadComment">
		    <ul class="reset commentslist ovfl-hidden">
                    </ul>

		    <p class="addcommentsec">
			<label for="addcomment">Add Post</label>
			<img src="{$siteroot}/templates/default/images/no-user.png" alt="User" height="40px" width="40px">      
			<textarea id="comTitle" rows="1" cols="1" class="textareabg" name="title" readonly="true" style="width:474px;margin-left:21px;vertical-align:top;background:#E7E7E7;" onclick="javascript:window.location='#'">Please Login To Comment</textarea>
		    </p>
		    <p class="rightAlign"><input type="button" value="Comment" class="btncom" /></p>
		</div>
	      </div>
        </div>

        <div class="fr prodcolR">
        	<div class="locationbg">
            	{if $deal.googlemap eq 'yes'}
               	<h3 class="loctitle">Location</h3>
            	<div class="mapbrd"><img src="http://maps.google.com/maps/api/staticmap?center=london&markers={$coordinates}&size=275x222&maptype=roadmap&sensor=true" alt="map" /></div>
                
               <!-- <h3 class="loctitle">Refund</h3>-->
                <div class="refundcol">
                	<!--<p class="strong bigTxt">Refund:</p>
			<p>{$deal.refund_policy}</p>-->
                </div>
                <div>
                	<p class="strong bigTxt">Delivery:</p>
					<p>{$deal.shop_location}</p>
                </div>
                {/if}
                {if $deal.video}
                <h3 class="loctitle">Video</h3>
            	<div class="mapbrd">{$deal.video}</div>
                {/if}

            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<br/>
<!-- Maincontent ends -->
{include file=$admin_footer}