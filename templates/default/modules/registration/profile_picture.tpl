{include file=$header_start}
{strip}
<script type="text/javascript" src="{$sitejs}/validation/profile_picture.js"></script>

{/strip}
{literal}
<script type="text/javascript">
    function setImage(file) {
        if(document.all)
            document.getElementById('prevImage').src = file.value;
        else
            document.getElementById('prevImage').src = file.files.item(0).getAsDataURL();
        if(document.getElementById('prevImage').src.length > 0) 
            document.getElementById('prevImage').style.display = 'block';
    }
</script>


{/literal}
{include file=$header_end} 
  <!-- Header ends -->

<!-- Maincontent starts -->

  <div id="maincont" class="ovfl-hidden">

    <div class="creat-deal">

      <h1>User Registration</h1>

      <div class="profile-thumb">

        <ul class="reset profile-thumb">

          <li>

            <h1>Step-1</h1>

            <p>Profile Info</p>

          </li>

          <li  class="active">

            <h1>Step-2</h1>

            <p>Profile Picture</p>

          </li>

          <li>

            <h1>Step-3</h1>

            <p>Invite friends</p>

          </li>

        </ul>

       

        <div class="clr"></div>

      </div>

<form name="frm" id="frm" method="POST" action="" enctype="multipart/form-data" >
         <div class="registration-form-inn">

        <div class="form-inn">

          <h2><span>Set your profile picture :</span></h2>

          <div class="profile fl"> <img src="{$siteroot}/templates/default/images/profile_pic.png" width="120" height="120" alt="" title=" "  /> </div>

          <div class="form-inn-rgt fr">

            <h1> Upload a Photo From your computer </h1>

            <input type="file"  name="photo" id="photo"  onchange="setImage(this);" contentEditable="false">
          </div>

          <div class="clr"></div>

        <!--  <a href="{$siteroot}/invitation/" class="fr skiptxt">Skip this Step</a> -->

          <div class="clr"></div>

          <div class="pre-btn fr">

				<input  class="previe-btn" type="submit" name="Submit" id="Submit" value="Save and Continue"  style="width:185px">

          </div>

          <div class="clr"></div>

        </div>

      </div>

</form>
    </div>

    <!-- Maincontent ends -->
  </div>

</div>
</form>
{include file=$footer}

