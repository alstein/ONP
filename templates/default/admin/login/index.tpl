{include file=$header1}
{include file=$header2}
<div class="Loginbox padtop2">
	<div class='allHeadbrdBg marginBot width100'>
		<h1 class="head">Administrator Login</h1>
		<form name="frmLogin" method="post" action="logincheck.php">
		<table width="100%" cellspacing="2" cellpadding="5">
			<tr><td colspan="2" align="center">{$msg}</td></tr>
			<tr>
				<td width="30%" align="right"><span>Username  :</span></td>
				<td width="70%" align="left"><label>
						<input name="loginname" type="text" class="textbox" value="" size="35" maxlength="50" />
					</label></td>
			</tr>
			<tr>
				<td align="right"><span>Password  :</span></td>
				<td align="left"><input name="password" type="password" class="textbox" value="" size="35" maxlength="15"/></td>
			</tr>
<!--			<tr>
				<td>&nbsp;</td>
				<td align="left"><input type="checkbox" name="rememberme"/>
					Remember me!</td>
			</tr>-->
			<tr>
				<td>&nbsp;</td>
				<td align="left">
					<input type="hidden" name="pgbck" value="{$pgbck}" />
					<input type="submit" name="button" id="button" value="Login" /></td>
			</tr>
        </table>
	  </form>
	</div>
</div>
{include file=$footer}
