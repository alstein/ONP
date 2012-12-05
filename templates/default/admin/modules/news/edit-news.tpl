{include file=$header1}
{strip}
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"></script>
{/strip}

<script language="javascript" type="text/javascript">
{literal}
function validate()
{	
       //alert ("hi"); 
        var usertype =document.getElementById('user_type').value;
        var news_title =document.getElementById('news_title').value;
        var description =document.getElementById('description').value;

        if( usertype == "")
        {
// 		alert("Please select user type");
		document.getElementById("user_type").focus();
                document.getElementById("error_msg").innerHTML="Please select user type";
		return false;
        }
        else
         if(news_title == "")
        {
// 		alert("Please enter news title");
		document.getElementById("news_title").focus();
                 document.getElementById("error_msg").innerHTML="Please enter news title";
		return false;
        }  
         else
         if(description == "")
        {
// 		alert("Please enter description");
		document.getElementById("description").focus();
                document.getElementById("error_msg").innerHTML="Please enter description";
		return false;
        }
                      

}
{/literal}
</script>


{literal}
<script language="javascript" type="text/javascript">
	function user_type_sel() { 
	       var b=document.getElementById('user_type').value;
                if(b == '2')
	       {
	       document.getElementById('mod1').style.display = "block";
                document.getElementById('mod2').style.display = "none"; 
                        	
	       }
	       } 
	 
	window.onload=user_type_sel;

function show()
{
	
	var a=document.getElementById('user_type').value;
  // document.getElementById('link').value=""; 
	if(a == 2)
	{
	document.getElementById('mod1').style.display = "block";
        document.getElementById('mod2').style.display = "none"; 
                        	
	}else
        if(a == 3)
	{
        document.getElementById('mod1').style.display = "block";
        document.getElementById('mod2').style.display = "block"; 
	}else
        {
        document.getElementById('mod1').style.display = "none";
        document.getElementById('mod2').style.display = "none"; 
	}

        
}

</script>
{/literal}
{include file=$header2}
  <div align="left"><strong>{if $news.news_title}Edit{else}Add{/if} News</strong></div>
    <div align="center" style="color:red;padding-right:250px;" id="error_msg">{$msg}</div>          
  <table width="82%"  align="center">
    <tr>
      <td>
        <form name="frmnews"  id="frmnews" method="post" action="" enctype="multipart/form-data">
          <!--<input type="hidden" name="pageid" value="{$page.pageid}" />-->
          <table width="100%"  border="0" cellpadding="6" cellspacing="2">
            <tr>
              <td width="15%" align="right" valign="top"><label class="error">*</label> User Type: </td>
              <td align="left">
                {if $news_id}
                <input type="hidden" name="user_type" id="user_type"  
                {if $news.user_type eq 2} value="2" {/if} {if $news.user_type eq 3} value="3" {/if} />

                {if $news.user_type eq 2}<strong>Buyer</strong>  {/if} {if $news.user_type eq 3}<strong>Seller</strong> {/if}

                {else}
                  <select name="user_type" id="user_type" onchange="show();">
                      <option value="">  Select  </option>                      
                      <option value="2" {if $news.user_type eq 2} selected="selected"{/if}>Buyer</option>
                      <option value="3" {if $news.user_type eq 3} selected="selected"{/if}>Seller</option>  
                </select>
                {/if}
              </td>
            </tr>

            <tr>
              <td width="15%" align="right" valign="top"><label class="error">*</label> Title: </td>
              <td align="left"><input type="text" name="news_title" id="news_title" size="60" maxlength="100" value="{$news.news_title}"  align="left" /></td>
            </tr>

            <tr>
              <td valign="top" align="right" ><label class="error">*</label> Description: </td>
              <td valign="top">
                <textarea id="description" name="description" rows="13" cols="69">{$news.description}</textarea>
                </td>
            </tr>
                <tr>
              <td valign="top" align="right" >Start Date: </td>
              <td valign="top">
              {if $news.start_date}
                <script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD','{$news.start_date}');</script>
                {else}
                <script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD');</script>
                {/if}
                </td>
            </tr>       
              <tr>
              <td valign="top" align="right" >End Date: </td>
              <td valign="top">
                {if $news.end_date}
			  <script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD','{$news.end_date}');</script>
			  {else}
               <script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD');</script>
                {/if}
                </td>
            </tr>
             </tr>       
              <tr>
              <td valign="top" align="right" ><label class="error">*</label> Modules: </td>
              <td valign="top">
                <div id="mod1">
                <input type="checkbox" name="modules[]" 
                {if $news_id} {if in_array(1,$module_array)} checked="true" {/if}  {/if}
                id=""  value="1"/> Wish List<br/>


                <input type="checkbox" name="modules[]"
               {if $news_id}  {if in_array(2,$module_array)} checked="true" {/if} {/if}
                 id="" value="2"/> Message Alerts<br/>


                <input type="checkbox" name="modules[]"
                {if $news_id} {if in_array(3,$module_array)} checked="true" {/if} {/if} 
                id="" value="3"/> Invoices<br/>
                
                <input type="checkbox" name="modules[]" id=""
                {if $news_id} {if in_array(4,$module_array)} checked="true" {/if} {/if}
                value="4"/> My Orders<br/>

                <input type="checkbox" name="modules[]" id=""
                {if $news_id} {if in_array(5,$module_array)} checked="true" {/if} {/if}
                value="5"/> My Purchases<br/>
                
                <input type="checkbox" name="modules[]" id=""
                {if $news_id} {if in_array(6,$module_array)} checked="true" {/if}{/if} 
                value="6"/> Dispute centre<br/>
                
                <input type="checkbox" name="modules[]" id=""
                {if $news_id} {if in_array(7,$module_array)} checked="true" {/if} {/if}
                value="7"/> Account Setting<br/>
                
              <!--  <input type="checkbox" name="modules[]" id=""
                {if $news_id} {if in_array(8,$module_array)} checked="true" {/if} {/if} 
                value="8"/> Notification / News-->
                </div>
                
                <div id="mod2">
                <input type="checkbox" name="modules[]" id=""
                
                 {if $news_id} {if in_array(9,$module_array)} checked="true" {/if} {/if} 
                value="9"/> My Deals<br/>

                <input type="checkbox" name="modules[]" id=""
                {if $news_id} {if in_array(10,$module_array)} checked="true" {/if}{/if}
                 value="10"/> Monitor Product Sales<br/>
                
                <input type="checkbox" name="modules[]" id=""
                {if $news_id} {if in_array(11,$module_array)} checked="true" {/if} {/if}
                value="11"/> Monitor Voucher Sales<br/>
                
                <input type="checkbox" name="modules[]" id=""
                {if $news_id} {if in_array(12,$module_array)} checked="true" {/if}{/if}
                 value="12"/> Add New Deal<br/>
                
                <input type="checkbox" name="modules[]" id=""
                {if $news_id} {if in_array(13,$module_array)} checked="true" {/if} {/if}
                value="13"/> My Feedback<br/>
                
                <input type="checkbox" name="modules[]" id=""
                {if $news_id} {if in_array(14,$module_array)} checked="true" {/if} 
                {/if} value="14"/> View Products in demand<br/>
                
              <!--  <input type="checkbox" name="modules[]" id=""
                {if $news_id} {if in_array(15,$module_array)} checked="true" {/if} {/if}
                 value="15"/> Seller Community    -->   
                </div>
                
                </td>
            </tr>                       

            <!--<tr>
              <td valign="top" align="right" >Status : </td>
              <td valign="top"><select name="status">
                  <option value="Active" {if $page.status eq "Active"}selected="selected"{/if}>Active</option>
                  <option value="Inactive" {if $page.status eq "Inactive"}selected="selected"{/if}>Inactive</option>
                </select></td>
            </tr>-->

            <tr>
              <td align="right" valign="top"></td>
              <td><input type="submit" name="Submit" value="Save"  onclick="return validate();" /> &nbsp; &nbsp; &nbsp;
                <input type="button" name="Cancel" value="Cancel" onclick="javascript: location='news-list.php';" /></td>
            </tr>
          </table>
        </form></td>
    </tr>
  </table>

{include file=$footer}