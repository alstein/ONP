<?php 
include_once('../../../includes/SiteSetting.php');
$incre_var = $_GET['id'];
$row_country = array();
$rs1 = $dbObj->customqry("select * from mast_country where countryid = '225' and status='Active'","");
$row1 = @mysql_fetch_assoc($rs1);
if($row1){
$row_country[]=$row1;}
$cnd= "c.status='Active' and countryid !=225";
$sf="c.*";
$ob="country ASC";
//$rs1=$dbObj->gj("mast_country c",$sf,$cnd, $ob, "", "", $l, "");
$res_country=$dbObj->gj("mast_country c",$sf,$cnd, $ob, "", "", $l, "");


// //$res_country = $dbObj->cgs("mast_country","*","status","Active","country","ASC","");
// $num_country = @mysql_num_rows($res_country);
// 
// while($row_con = @mysql_fetch_assoc($res_country))
// {
// 	$row_country[] = $row_con;
// }
// echo "<pre>";
// print_r($row_country);
// exit;


?>


<script type="text/javascript" src="{$siteroot}/js/validation/admin/add_deal.js"></script>
	<tr id="country_<?php echo $incre_var; ?>">
		<td align="right" valign="top"><span class="red">*</span> Deal country or countries: </td>
		<td colspan="2" align="left">
			<select name="dealcountry[]" id="dealcountry_<?php echo $_GET['id'];?>" style="width:180px;" class="selectbox fl"  onchange="javascript:fillStates(this,<?php echo $_GET['id']; ?>);">
				<!--<optgroup label="--Select Deal Countries--">-->
	<option value="">Select Deal Countries</option>
				<?php 
				$i=0;
				while($row_con = @mysql_fetch_assoc($res_country))
				{?>
				<option value="<?php echo $row_con['countryid']; ?>"><?php echo $row_con['country'] ;?></option>
				<?php $i++;}?>
			</select>&nbsp;&nbsp;
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=1}</span></a>
                                             <div class="clr"></div>
			<!--<span><a href="javascript:void(0);" onclick="javascript:selectAllCountry(getElementById('dealcountry'));">Select All</a> <strong>|</strong> <a  href="javascript:void(0);" onclick="javascript:unselectAllCountry(getElementById('dealcountry'));">Unselect All</a></span> <strong>|</strong> (Ctrl + Mouse left key to select multiple)-->
			
			<div class="error" id="countryerror"></div>
		</td>
	</tr>

	<tr id="div_stateDD_hideshow">
		<td align="right" valign="top"><span class="red" style="display:none;">*</span> Deal Counties / States: </td>
		<td colspan="2" align="left">
			<div id="state_<?php echo $_GET['id'];?>" style="width:180px" class="fl">
				<select name="dealstate[]" id="dealstate_<?php echo $_GET['id'];?>" style="width:100%;" class="selectbox fl" onchange="javascript:fillCities(this,<?php echo $_GET['id'];?>);">
					<!--<optgroup label="--Select Deal States--">-->
						{*section name=i loop=$state}
							<option value="">Select Deal States</option>
							<option value="">{$state[i].state_name}</option>
						{/section*}
					<!--</optgroup>-->
				</select>&nbsp;&nbsp;
			</div>
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=2}</span></a>
                                             <div class="clr"></div>
			<!--<span><a href="javascript:void(0);" onclick="javascript:selectAllState(getElementById('dealstate'));">Select All</a> <strong>|</strong> <a  href="javascript:void(0);" onclick="javascript:unselectAllState(getElementById('dealstate'));">Unselect All</a></span> <strong>|</strong> (Ctrl + Mouse left key to select multiple)-->
			<div class="error" id="stateerror"></div>
		</td>
	</tr>
	<tr id="div_cityDD_hideshow">
		<td align="right" valign="top"><span class="red" style="display:none;">*</span> Deal Cities / Towns: </td>
		<td colspan="2" align="left">
			<div id="city_<?php echo $_GET['id'];?>" style="width:180px" class="fl">
				<select name="dealcity[]" id="dealcity_<?php echo $_GET['id'];?>" style="width:100%;" class="selectbox fl" >
					<!--<optgroup label="--Select Deal Cities--">-->
						{*section name=i loop=$city}
							<option value="">Select Deal Cities</option>
							<option value="">{$city[i].city_name}</option>
						{/section*}
					<!--</optgroup>-->
				</select>&nbsp;&nbsp;
			</div>
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=3}</span></a>
                                             <div class="clr"></div>
			<!--<span><a href="javascript:void(0);" onclick="javascript:selectAllCity();">Select All</a> <strong>|</strong> <a  href="javascript:void(0);" onclick="javascript:unselectAllCity();">Unselect All</a></span> <strong>|</strong> (Ctrl + Mouse left key to select multiple)-->
			<div class="error" id="cityerror"></div>
		</td>
	</tr>
	<tr id="div_cityDD_hideshow">
		<td align="right" valign="top"><span class="red" style="display:none;">*</span> Deal Discount: </td>
		<td colspan="2" align="left">
			<input type="text" name="deal_discount[]" id="deal_discount_<?php echo $_GET['id'];?>" >
		</td>
	</tr>
<tr id="rept_data_<?php echo $_GET['id'];?>"></tr>