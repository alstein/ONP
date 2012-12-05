{include file=$header_start}
{include file=$header_end}
  <!-- Maincontent starts -->
<section id="maincont" class="ovfl-hidden">
	<section class="grybg">
		<div class="pagehead">
			<div class="grpcol">
				<ul class="reset ovfl-hidden tab1">
					<li><a href="{$siteroot}/my-account-view">My Account</a> </li>
					<li><a href="{$siteroot}/my-profile-view" class="active">My Profile</a> </li>
					<li><a href="{$siteroot}/my-credits">My Credits</a> </li>
					<!--<li><a href="{$siteroot}/my-gifts">My Gifts</a> </li>-->
					<li><a href="{$siteroot}/my-deals">My Deals</a> </li>
					<li><a href="{$siteroot}/my-resolutions">Resolution Centre</a> </li>
				</ul>
				<!--<h1 class="my_account headingmain">My Profile</h1>-->
				{if $msg_succ}<p><div class="successMsg" align="center">{$msg_succ}</div></p>{/if}
				{if $msg}<p><div class="errorMsg" align="center">{$msg}</div></p>{/if}
				</div>
			</div>
			<div class="innerdesc">
				<form name="frmregistration" id="frmregistration" action="" method="POST">
					<h3 class="pagehead2" style="float:left">About Me</h3>
					<h3 class="pagehead2" style="float:right"><a href="{$siteroot}/my-profile-update">Edit Info</a></h3>
					<div style="clear:both;"></div>
					<div class="border"></div>
					<ul class="form_div">
						<li><label style="width:300px;">Gender :</label>
							{$userData.gender}
						</li>
						<li><label style="width:300px;">Near Post Code/Zip Code Or City/Town :</label>
							{if $userData.postalcode}{$userData.postalcode}{else}------{/if}
						</li>
						<li><label style="width:300px;">Second Post Code/Zip Code For Work :</label>
							{if $userData.sec_postalcode}{$userData.sec_postalcode}{else}------{/if}
						</li>
						<li>
							<label style="width:300px;">Date Of Birth :</label>
							{$userData.birthdate|date_format:$smarty_date_format}
						</li>
					</ul>
					<div class="border"></div>
					<h3 class="pagehead2" style="float:left">My Favourite</h3>
					<div style="clear:both;"></div>
					<div class="border"></div>
					<ul class="form_div">
						{section name=i loop=$userData.myFavoriteNames}
						<li>
							<label>{$userData.myFavoriteNames[i]}</label>
						</li>
						{sectionelse}
						------
						{/section}
					</ul>
					<!--<div class="border"></div>
					<h3 class="pagehead2" style="float:left">My Background</h3>
					<div style="clear:both;"></div>
					<div class="border"></div>
					<ul class="form_div">
						<li>
							<label>Education:</label>
							{$userData.last_name}
						</li>
						<li>
							<label>Employment Status:</label>
							{$userData.last_name}
						</li>
						<li>
							<label>Income Range:</label>
							{$userData.last_name}
						</li>
						<li>
							<label>Own a Home:</label>
							{$userData.last_name}
						</li>
						<li>
							<label>Relationship Status:</label>
							{$userData.last_name}
						</li>
						<li>
							<label>Have Children:</label>
							{$userData.last_name}
						</li>
					</ul>-->
					<div class="border"></div>
					<h3 class="pagehead2" style="float:left">Set Preferences</h3>
					<div style="clear:both;"></div>
					<div class="border"></div>
					<ul class="form_div">
						<li>
							<label>City/Town :</label>
							<label style="width:500px;">{if $userData.preferences_city_name}{$userData.preferences_city_name}{else}------{/if}</label><br>
						</li>
						<li>
							<label>Deal Types : </label>
							
							<label>
							{section name=i loop=$userData.preferences_dealTypeNames}
								{$userData.preferences_dealTypeNames[i]}<br>
							{sectionelse}
							------
							{/section}
							</label><br>
						</li>
						<li>
							<label>Deal Categories : </label>
							
							<label>
							{section name=i loop=$userData.preferences_dealCatName}
								{$userData.preferences_dealCatName[i]}<br>
							{sectionelse}
							------
							{/section}
							</label>
						</li>
						
					</ul>

<!--
					<div class="border"></div>
					<ul class="form_div">
						<li class="margin_bottom">
							<label>&nbsp;</label>
							<div class="fl btnmain">
								<input type="button" value="Back" onclick="javascript:history.back(1);" class="buybtn2">
							</div>
						</li>
					</ul>
-->
				</form>
			</ul>
		</div>
		<div class="clr">&#x00A0;</div>
	</section>
	<section class="grybg">
		<div class="tphwrks">
			{include file=$footer_free_coupons}
		</div>
	</section>
</section>
  <!-- Maincontent ends -->
{include file=$footer}