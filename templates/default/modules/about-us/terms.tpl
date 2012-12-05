{include file=$header_start} 

  <!-- Maincontent starts -->
<div id="wrapper">
  <!-- header container starts here-->
{include file=$header_end}
  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont">
    <div class="uppermain">
	<h2 class="in-heading ovfl-hidden">{$title}</h2>
	<div class="fullwid ovfl-hidden in-cont">{$description|html_entity_decode}
	 </div>
	</div>
  </div>
  {include file=$footer}
</div>
  <!-- Maincontent ends -->
