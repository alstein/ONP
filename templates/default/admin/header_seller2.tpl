</head>
<body>
{include file=$no_js}
<!-- main continer of the page -->
<div id="wrapper">
  <!-- Header starts -->
  <header>
    <section class="ovfl-hidden">
      <h1 id="logo" class="fl"><a href="{$siteroot}/admin/seller/my-profile-view.php">&#x00A0;</a></h1>

      <div class="tprtdiv fr">
        <div>
          <ul class="reset ovfl-hidden" id="globalNav">
          
            <li>
            {if $smarty.session.duUserTypeId eq 3}
			{assign var=signouturl value="/signout"}
		{else}
			{assign var=signouturl value="/admin/login/signout.php"}
		{/if}
        {if $smarty.session.admLgn ne ""}{$smarty.session.duAdmFname} {if $smarty.session.duUserTypeId eq 1}
          [Administrator]{else}[Seller]{/if} | <a href="{$siteroot}{$signouturl}">LogOut</a>{else}Welcome To {$sitetitle} Please Login{/if}
            </li>
          </ul>
        </div>
      </div>
      <div class="clr">&#x00A0;</div>

      

     {*/if*} <!-- {* else if of if $pgName eq 'home' *} -->
        </section>
  </header>
  <!-- Header ends -->
