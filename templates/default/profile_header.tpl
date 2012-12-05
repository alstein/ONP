<div class="fullwid" style="position:fixed; background:#DDE2E8; z-index:1; height:80px">
<div id="header">
    {if $smarty.session.csUserId neq ''}
    	<h1 id="inner_logo" class="fl"><a href="{$siteroot}"></a></h1>
	{else}
		<h1 id="logo" class="fl"><a href="{$siteroot}"></a></h1>
	{/if}
    <div class="help fr">
      <h2><a href="{$siteroot}/help/18/content">Help</a> | <a href="{$siteroot}">Sign Up</a></h2> 
    </div>

  </div>
</div>
<div>vdvdd</div>

<!--<div id="inner_header">
  <div class="ovfl-hidden">
	{if $smarty.session.csUserId neq ''}
    	<h1 id="inner_logo" class="fl"><a href="{$siteroot}"></a></h1>
	{else}
		<h1 id="logo" class="fl"><a href="{$siteroot}"></a></h1>
	{/if}
    <div class="help fr">
      <h2><a href="{$siteroot}/help/18/content">Help</a></h2>
    </div>
  </div>
</div>-->