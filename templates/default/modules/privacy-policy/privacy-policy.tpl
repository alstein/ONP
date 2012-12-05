{include file=$header_start} 

{if $smarty.session.csUserId neq ''}
{include file=$profile_header2}
{else}
{include file=$header_end}
{/if}
  <!-- main container with changing content -->
   <div id="maincont" class="ovfl-hidden">
    
    <div class="about-us">
    <h1>{$title}</h1>
    <p>{$description|html_entity_decode} </p>
    
    </div>
  </div>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->
  {include file=$footer}