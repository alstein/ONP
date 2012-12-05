{include file=$header1}
 <link href="{$siteroot}/templates/{$templatedir}/css/admin_new.css" rel="stylesheet" type="text/css" /> 
<!--{strip}
 	<script type="text/javascript" src="{$siteroot}/js/newcountdown.js"></script> 
{/strip}
-->
{literal}
<script language="JavaScript">
var TEMPLATEDIR="/templates/{$templatedir}";
	$(document).ready(function(){
        $('a[href*=#]').click(function() {
          if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
          && location.hostname == this.hostname) {
            var $target = $(this.hash);
            $target = $target.length && $target
            || $('[name=' + this.hash.slice(1) +']');
            if ($target.length) {
              var targetOffset = $target.offset().top;
              $('html,body')
              .animate({scrollTop: targetOffset}, 1000);
             return false;
            }
          }
        });
      });
</script>

{/literal}
{strip}
<script type="text/javascript" src="{$siteroot}/js/index-jscss.js"></script>
{/strip}
{literal}
<script type="text/javascript">
	$(function() {
		$("#progressbar").progressbar({
			value: ({/literal}{$deal_per}{literal}?{/literal}{$deal_per}{literal}:0)
		});
	});
	</script>
{/literal}
{include file=$header2}
<!-- main container with changing content -->
<div class="breadcrumb"><table border="0"><tr><a colspan="3" align="left"><a href="{$siteroot}">Home</a> > <a href="{$siteroot}/admin/sitemodules/deal/manage_complete_deal.php">Completed Deal</a> > <a href="{$siteroot}/admin/sitemodules/deal/deal_pay_info.php?id={$dealid}&act=view">View deal</a> > View Deal In Details</td></tr><tr><td colspan="3">&nbsp;</td></tr></table></div>
<h3 align="left">View Deal In Details</h3>
<br/>
<div align="center" id="msg">{$msg}</div>	
<div id="maincont">        
	
    <div class="illustOne">
      <div style="padding-bottom:10px;"> 
{literal}
<script type="text/javascript">
var slideShow = new Array();
var cnt=0;
{/literal}
                  {section loop=$imageprd name=i}
                 {literal}
		slideShow[cnt]={/literal}'{$siteroot}'{literal}+"/uploads/product/thumbnail/"+{/literal}'{$imageprd[i]}'{literal};
                 cnt=cnt+1; 
                {/literal}
                {/section}
{literal}
function startSlideshow()
{
   processSlideshow("#slideshow", slideShow, 2000, 1000);
}
$(document).ready(startSlideshow);
</script>
{/literal}
    <DIV id="slideshow">
        <img src="{$siteroot}/uploads/product/thumbnail/{$imageprd[0]}" alt="Slideshow"  style="opacity: 2; " />
    </DIV>
 </div>&nbsp;&nbsp;&nbsp;
                {if $dealinfoarr.deal eq 0}
		<div align="top"><b>City:</b> {$dealinfoarr.product_city}</div>&nbsp;&nbsp;&nbsp;
		{/if}
		<div align="top"><b>Deal Name : </b> {$dealinfoarr.product_name}</div>&nbsp;&nbsp;&nbsp;
                <div align="top"><b>Business Name : </b> {$userarray.first_name} {$userarray.last_name}</div>&nbsp;&nbsp;&nbsp;
		<div align="top"><b>Start date : </b> {$dealinfoarr.deal_start_date|date_format:"%e %b %Y"}</div>&nbsp;&nbsp;&nbsp;
		<div align="top"><b>End date : </b> {$dealinfoarr.deal_end_date|date_format:"%e %b %Y"}</div>&nbsp;&nbsp;&nbsp;
		<div align="top"><b>Highlights : </b> <br/>
		<ul>
		{section name=i loop=$arr_high}
		<li> {$arr_high[i].highlights|substr:0:30}</li>
		{/section}
		</ul>
		</div>&nbsp;&nbsp;&nbsp;
         	<div align="top"><b>Description : </b> {$dealinfoarr.product_description}</div>&nbsp;&nbsp;&nbsp;
                <div align="top"><b>Original Value (in $) : </b> {$dealinfoarr.product_act_price}</div>&nbsp;&nbsp;&nbsp;
		<div align="top"><b>Discount Value (in $) : </b> {$dealinfoarr.product_disc_price}</div>&nbsp;&nbsp;&nbsp;
                {if $dealinfoarr.deal eq 0}
		<div align="top"><b>Discount Value % Discount : </b> {$dealinfoarr.product_disc_price_percent}</div>&nbsp;&nbsp;&nbsp;
		<div align="top"><b>Sell Out Value (in $) : </b> {$dealinfoarr.product_sell_price}</div>&nbsp;&nbsp;&nbsp;
		<div align="top"><b>Sell Out Value % Discount : </b> {$dealinfoarr.product_sell_price_percent}</div>&nbsp;&nbsp;&nbsp;
                {else}
                <div align="top"><b>Deal (in $) : </b> {$dealinfoarr.product_sell_price}</div>&nbsp;&nbsp;&nbsp;
                {/if}
                 <div align="top"><b>You save (in $) : </b> {$dealinfoarr.product_disc_price}</div>&nbsp;&nbsp;&nbsp;
		<div align="top"><b>Minimum quantity : </b> {$dealinfoarr.min_quantity}</div>&nbsp;&nbsp;&nbsp;
		<div align="top"><b>Maximum total sold : </b> {if $totalsold eq ''}0{else}{$totalsold}{/if}</div>&nbsp;&nbsp;&nbsp;
               <div align="top"><b>Deal Status : </b> {if $dealinfoarr.deal_status eq 2} Sold out {else} Deal ON{/if} </div>&nbsp;&nbsp;&nbsp;
     </div>
  </div>     

 
{include file=$footer}