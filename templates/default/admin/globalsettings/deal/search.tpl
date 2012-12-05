{include file=$header_start} 
{include file=$header_end}
{literal} 
<script type="text/javascript" language="JavaScript">


function view(val,val1,val2,val3,val4)
{

if((val == 'title' || val == 'price' || val == 'date' || val == 'highprice') && (val4 !=""))
{
window.location.href=SITEROOT+"/deal/search/?id="+val+"&grid=1";
}
else if((val == 'title' || val == 'price' || val == 'date' || val == 'highprice') && (val2 !="" || val3 !=""))
{
        if(val1)
	{
	window.location.href=SITEROOT+"/deal/search/?id="+val+"&cat_id="+val1;
	}
	else if(val2)
	{
	window.location.href=SITEROOT+"/deal/search/?id="+val+"&cat="+val2+"&submit=Go";
	}
	else if(val3)
	{
	window.location.href=SITEROOT+"/deal/search/?id="+val+"&cat="+val2+"cate_name="+val3+"&submit=Go";
	}
}
else if((val == 'title' || val == 'price' || val == 'date' || val == 'highprice'))
{
window.location.href=SITEROOT+"/deal/search/?id="+val;
}
}
function line(val,val1)
{

//alert(val);
var pageno=val1;
 	if(pageno !='')
	{
	window.location.href=SITEROOT+"/deal/search/?cat_id="+val+"&page="+pageno;
	}
	else if(val !='')
	{
	window.location.href=SITEROOT+"/deal/search/?cat_id="+val;
	}
	else if(val == '')
	{
	window.location.href=SITEROOT+"/deal/search/";
	}
}
function grid(val,val1,val2)
{
//alert(val);
var pageno=val1;
if(val=='')
{
window.location.href=SITEROOT+"/deal/search/";
}
var pageno=val1;
 	if(pageno !='')
	{
	window.location.href=SITEROOT+"/deal/search/?cat_id="+val+"&grid=1&page="+pageno;
	}
	else if(val !='')
	{
	window.location.href=SITEROOT+"/deal/search/?cat_id="+val+"&grid=1";
	}
	else if(val == '')
	{
	window.location.href=SITEROOT+"/deal/search/?grid=1";
	}
	
}
function line1(val,val1,val2)
{
var s=""+val+"";

var brokenstring=s.split(",");
var test1=brokenstring[0];
var test2=brokenstring[1];
//alert(test2);
var pageno=val1;
 	if((pageno !='') && (val2 == ''))
	{
	window.location.href=SITEROOT+"/deal/search/?cat="+val+"&page="+pageno;
	}
	else if((pageno !='') && (val2 !=''))
	{
	window.location.href=SITEROOT+"/deal/search/?cat="+val+"&cate_name="+val2+"&submit=Go&page="+pageno;
	}
	else if(val2 !='')
	{
	window.location.href=SITEROOT+"/deal/search/?cat="+val+"&cate_name="+val2+"&submit=Go";
	}
	else if(val !='0')
	{
	window.location.href=SITEROOT+"/deal/search/?cat="+val+"&submit=Go";
	}
	
	else if((sortby !='') && (pageno !=''))
	{
	window.location.href=SITEROOT+"/deal/search/?id="+sortby+"&page="+pageno;
	}
	else if((sortby !='') || (val !=''))
	{
	window.location.href=SITEROOT+"/deal/search/?id="+sortby+"cat="+val;
	}
	else if(val == '0')
	{
	window.location.href=SITEROOT+"/deal/search/";
	}
}
function grid1(val,val1,val2)
{
var sortby= document.getElementById('sortby').value;
	
var s="'"+val+"'";

var brokenstring=s.split(" ");
var test3=brokenstring[1];
if(test2 !="")
{
var test1=brokenstring[0];
var test2=brokenstring[1];
}
//alert(test2);
var pageno=val1;
 	if((pageno !='') && (val2 == ''))
	{
	window.location.href=SITEROOT+"/deal/search/?cat="+val+"&grid=1&page="+pageno;
	}
	else if((pageno !='') && (val2 !=''))
	{
	window.location.href=SITEROOT+"/deal/search/?cat="+val+"&cate_name="+val2+"&submit=Go&grid=1&page="+pageno;
	}
	else if(val2 !='')
	{
	window.location.href=SITEROOT+"/deal/search/?cat="+val+"&cate_name="+val2+"&submit=Go&grid=1";
	}
	else if(val !='0')
	{
	window.location.href=SITEROOT+"/deal/search/?cat="+val+"&grid=1&submit=Go";
	}
	
 	else if((sortby !='') && (pageno !=''))
	{
	window.location.href=SITEROOT+"/deal/search/?id="+sortby+"&page="+pageno;
	}
	else if(sortby !='')
	{
	window.location.href=SITEROOT+"/deal/search/?id="+sortby;
	}
	else if(val == '0')
	{
	window.location.href=SITEROOT+"/deal/search/?grid=1";
	}
	
}
</script>
{/literal}
  <div id="maincont">
{include file=$category}
    <div class="searchresultsec">
    	<div class="bredcrumb">
        <a href="#">Home</a> &gt; <a href="#">Buy</a><!--<a href="#">Buy</a> &gt; <a href="#">Customer Electronics</a> &gt; <a href="#">Television Acsessories</a> &gt; 
        <a class="active" href="#">Search Results for Television</a>-->
        </div>        
        <h2 class="allCaps searchtitle">Search Results</h2>
        <p class="strong resultfound"><span>{$cnt}</span> Search Results found for Television   <a href="#">[ Save this Search ]</a></p>
        <div class="ovfl-hidden">
			
        	<p class="fl"><span class="strong fl">View as:</span> {if $smarty.get.cat_id neq ''}<a class="viewicn1" href="javascript:void(0);" onclick="return line('{$smarty.get.cat_id}','{$smarty.get.page}');">&nbsp;</a> <a class="viewicn2" href="javascript:void(0);" onclick="return grid('{$smarty.get.cat_id}','{$smarty.get.page}');">&nbsp;</a>{else}<a class="viewicn1" href="javascript:void(0);" onclick="return line1('{$smarty.get.cat}','{$smarty.get.page}','{$smarty.get.cate_name}');">&nbsp;</a> <a class="viewicn2" href="javascript:void(0);" onclick="return grid1('{$smarty.get.cat}','{$smarty.get.page}','{$smarty.get.cate_name}');">&nbsp;</a>{/if}</p>
	
          <p class="fr searchsec"><label for="sortby">Sort by:</label> 
		<select class="selectbox" id="sortby" name="sort">
			<option value="0">Select</option>
			<option value="title" onclick="return view('title','{$smarty.get.cat_id}','{$smarty.get.cat}','{$smarty.get.cate_name}','{$smarty.get.grid}');" {if $smarty.get.id eq 'title'}  selected="selected"{/if}>Title</option>
			<option value="price" onclick="return view('price','{$smarty.get.cat_id}','{$smarty.get.cat}','{$smarty.get.cate_name}','{$smarty.get.grid}');" {if $smarty.get.id eq 'price'}  selected="selected"{/if}>Price-lowest first</option>
			<option value="price" onclick="return view('highprice','{$smarty.get.cat_id}','{$smarty.get.cat}','{$smarty.get.cate_name}','{$smarty.get.grid}');" {if $smarty.get.id eq 'highprice'}  selected="selected"{/if}>Price-highest first</option>
			<option value="date" onclick="return view('date','{$smarty.get.cat_id}','{$smarty.get.cat}','{$smarty.get.cate_name}','{$smarty.get.grid}');" {if $smarty.get.id eq 'date'}  selected="selected"{/if}>End Date</option>
		</select>
	    </p>
	
         </div>
    </div>
    <div class="featuregroup fullwid">
     <div class="abtitem">
     	<table cellpadding="0" cellspacing="0" border="0" class="itemtable">
        	<col width="224" />
            <col width="280" />
            <col width="64" />
            <col width="110" />
            <col width="130" />
            <col width="80" />
        	<tr>
            	<th>Items photo</th>
                <th>Items Description</th>
                <th>Price</th>
                <th>Group buyers</th>
                <th>Minimum Needed</th>
                <th>Time Left</th>
            </tr>
	{section name=i loop=$deal}	
            <tr>
            	<td>
                	<a href="{$siteroot}/deal/{$deal[i].url_title}"><img src="{$siteroot}/uploads/product/thumb122X145/{$deal[i].medium_image}" alt="#" /></a>
                </td>
                <td>
                	<h2><a href="{$siteroot}/deal/{$deal[i].url_title}"><span class="upperCase">{$deal[i].title}</span></a></h2>
					
                    <a class="itemdesc" href="{$siteroot}/deal/{$deal[i].url_title}">
                    	{$deal[i].description1|html_entity_decode|truncate:100:"":true}
                    </a>
                    <p class="redamore"><a href="{$siteroot}/deal/{$deal[i].url_title}">Read more</a></p>
                </td>
                <td><span class="strong">$ {$deal[i].groupbuy_price}</span></td>
                <td><span class="strong">{if $deal[i].total}{$deal[i].total}{else}0{/if}</span></td>
                <td><span class="strong">{$deal[i].min_buyer}</span></td>
                <td>
                	<div class="ovfl-hidden">
                    	 {if $deal[i].end eq '1'}<iframe frameborder="0" scrolling="no" allowtransparency="true" height="60" src="{$siteroot}/time/time.php?date={$deal[i].end_date}" width="108" ></iframe>{elseif $deal[i].start eq 1}<iframe frameborder="0" scrolling="no" allowtransparency="true" height="60" src="{$siteroot}/time/time.php?date={$deal[i].start_date}" width="108" >{else}<strong>Deal Ended on</strong>{/if}
                    </div>
                </td>
            </tr>
	   {sectionelse}
		<tr><td align="center" colspan="4" style="padding:5px"><strong>No Deal Avaliable</strong></td></tr>
           {/section}
        </table>
     </div>
    </div>
    <div class="ovfl-hidden">
   
	{$pgnation}

   
    </div>
  </div>
</div>
<!-- Maincontent ends -->
<!-- Footer starts -->
{include file=$footer} 
