{include file=$header_start}
<script type="text/javascript" src="{$sitejs}/validation/profile_info.js"></script>
  <!-- main container with changing content -->
{include file=$header_end} 
  <!-- Header ends -->

  <!-- Maincontent starts -->
<form method="POST" name="frm" id="frm" enctype="multipart/form-data">
  <div id="maincont" class="ovfl-hidden">
<div style="height:30px;"></div>
  <div class="congrates">
	  <h1 class="sucess" style="text-align:center;padding-bottom:20px;padding-top:10px;">Awesome!</h1>
     <section class="postcontent">
      <div class="successdiv PIE"><p class="pleasecheckinbox" style="margin-bottom:0px;">You have successfully created your account</p></div>
      <p class="pleasecheckinbox">Please check your inbox to activate your account. Thanks.

</p>
<p style="text-align:center"><!--if you have not received an email from us(and it's not in your spam folder),--><br/> 
<a href="#" class="clickhere"><strong><!--Click here--></strong></a></p>
     </section>
	  </div>
<div style="height:80px;"></div>
    <!-- Maincontent ends -->

  </div>

</div>
</form>
{include file=$footer}
</body>

</html>
