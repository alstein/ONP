  <div class="selectsecbg">
    <form name="frm" method="get"> 
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
		<option value="{$category_list[i].id|base64_encode}"  {if $smarty.get.cat|base64_decode eq $category_list[i].id} selected="selected" {/if}>      {$category_list[i].category}</option>
		{/section}
            </select>
	  </td>
          <td><div class="srcbg" style="height:22px;"><input type="text" class="srcinput" name="cate_name" value="{$smarty.get.cate_name}"/></div></td>
          <td><input type="button" value="Go" class="btngo" name="submit"/></td>

          <td>or</td>
          <td><label for="browse">Browse:</label></td>
          <td>
              <select id="browse" class="selectbg" style="width:258px">
		<option value="0">Select Categories</option>
		<option value="all" {if $smarty.get.cat_id eq 'all'} selected="selected" {/if}>All Categories</option>
		{section name=i loop=$category_list}
		<option value="{$category_list[i].id|base64_encode}" {if $smarty.get.cat_id eq $category_list[i].id|base64_encode} selected="selected" {/if} >{$category_list[i].category}</option>
		{/section}
            </select></td>
        </tr>
      </table>
      </form>	
    </div>
