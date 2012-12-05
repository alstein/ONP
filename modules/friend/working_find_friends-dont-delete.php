//dont delete working query
	$tbl = "tbl_friends as fd,tbl_users as u";
	$sf = "fd.verification_date,u.username,u.userid, u.email,u.first_name,u.last_name,u.photo,fd.id";
	$cd = "(fd.userid=".$user." or fd.friendid IN(".$user.")) and ((u.userid=fd.friendid and u.userid!=".$user." ) or (u.userid=fd.userid and u.userid!='".$user."') ) AND fd.verification = 'yes'";
	$gb = 'fd.id';
	$prn	= '1';
	$select_user_friend1	= $dbObj-> gj($tbl, $sf , $cd, $ob, $gb, $ad, "", $prn);
//dont delete working query


		<ul class="reset friendlist" style="height:612px;">
		{section name=i  loop=$friend1}
			{if $smarty.get.id1 neq $friend1[i].userid}
		<li><img src="{$siteroot}/uploads/user/{if $friend1[i].userid neq $smarty.get.id1}{$friend1[i].photo}{else}{$friend1[i].photo}{/if}" title="" alt="" width="100" height="100" />
		<a href="{$siteroot}/my-account/{if $friend1[i].userid neq $smarty.get.id1}{$friend1[i].userid}{else}{$friend1[i].friendid}{/if}/my_profile">{$friend1[i].first_name} {$friend1[i].last_name}</a>
		</li>
			{/if}
		{sectionelse}
		<div class="error" align="center">No Record Found</div>
		{/section}
		</ul>
