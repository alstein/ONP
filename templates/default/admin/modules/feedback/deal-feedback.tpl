{include file=$header1}
{include file=$header2}
<div class="holdthisTop">
	<h3 class="fl width50">Feedback</h3>
	<!--<table class="fr width30" border="0">
		<TR>
			<form name="frmSearch" id="frmSearch" method="get" action="">
			<td><input type="text" name="search" id="search" value="{$smarty.get.search|stripslashes}"></td>
			
				
			<td>
				          <input type="submit" name="submit" id="submit" value="Submit"/>
			</td>
			<form name="frmSearch" id="frmSearch" method="get" action="">		
		</TR>
	</table>
	-->
	
	
	<div class="clr"></div>
	<div id="msg" align="center" style="color:green">{$msg}</div>
  <table width="100%"  align="center" cellpadding="2" cellspacing="2" border="0">
    <tr>
      <td>
			<form name="frmAction" id="frmAction" method="post" action="">
        <table width="100%"  border="0" cellpadding="6" cellspacing="2" class="listtable">
          <tr class="headbg">
           <td width="25%" align="center" valign="top">Comment</td>
            <td width="8%" align="center" valign="top">From</td>
	     <td width="15%" align="center" valign="top">Delivery</td>
	    <td width="15%" align="center" valign="top">Item</td>	
	    <td width="15%" align="center" valign="top">Avg Rating</td>   
	<td width="13%" align="center" valign="top">Action</td>	 
          </tr>
          {section name=i loop=$feedback}
          <tr class="grayback" id="tr_{$faq[i].categoryid}">
            
            <td align="center" valign="top">{$feedback[i].feedback|truncate:30}</td>
            <td align="center" valign="top" >{$feedback[i].first_name}</td>
              <td align="center" valign="top">
		<div class="col6" class="rating">
			<span style="display:block">
				{section name=l loop=$feedback[i].delivery}
					<img src="{$siteroot}/templates/default/images/rating.png" alt="" border="0"/>
				{/section}
				{section name=m loop=$feedback[i].delivery_grey}
					<img src="{$siteroot}/templates/default/images/rating_gray.png" alt="" />
				{/section}
			</span>
		</div>
	     </td>
                <td align="center" valign="top">
		<div class="col6" class="rating">
			<span style="display:block">
				{section name=l loop=$feedback[i].item}
					<img src="{$siteroot}/templates/default/images/rating.png" alt="" border="0"/>
				{/section}
				{section name=m loop=$feedback[i].item_grey}
					<img src="{$siteroot}/templates/default/images/rating_gray.png" alt="" />
				{/section}
			</span>
		</div>
	     </td>
	 <td align="center" valign="top">
		<div class="col6" class="rating">
			<span style="display:block">
				{section name=l loop=$feedback[i].rating}
					<img src="{$siteroot}/templates/default/images/rating.png" alt="" border="0"/>
				{/section}
				{section name=m loop=$feedback[i].grey}
					<img src="{$siteroot}/templates/default/images/rating_gray.png" alt="" />
				{/section}
			</span>
		</div>
	     </td>	
		
		<td align="center" valign="top" ><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /><a href=" {$siteroot}/admin/modules/feedback/viewfeedback.php?id={$feedback[i].fid}">View</a></td>			
          </tr>
                       
		  {sectionelse}
		  <tr><td colspan="5" align="center"><strong>No feedback found.</strong></td></tr>
          {/section}
		  <tr>
		<td colspan="5" align="right">{$pagenation}</td>
	</tr>
        </table></form></tr>
    </tr>
  </table>
<form name="fb" id="fb" method="POST">
{if $feedback}
     <table width="100%">

        <tr>
                <td  align="right">
                <strong>Total % Feedback:</strong></td><td colspan="5"><input type="text" name="per_fb" id="per_fb" style="width:50px;"
                   {if $feed.total eq ""} value="{$total}" {else}   value="{$feed.total}" {/if}>%
                </td>
               
                
        </tr> 
       <tr>
                <td  style="vertical-align:top;" align="right">
                <strong>Feedback Review:</strong></td><td colspan="5"><textarea name="review_fb" id="review_fb" cols="30" rows="4">{$feed.review}</textarea>
                </td>
        </tr>
         
        <tr><td  align="center">&nbsp;</td>
        <td colspan="6" align="left"><input type="submit" name="submit" id="submit" value="Publish"/></td>
        </tr>

</table>  {/if} 
</form>
</div>
{include file=$footer}