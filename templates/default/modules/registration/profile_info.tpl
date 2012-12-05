{include file=$header_start}
<script type="text/javascript" src="{$sitejs}/validation/profile_info.js"></script>
  <!-- main container with changing content -->
{include file=$header_end} 
  <!-- Header ends -->

<!-- Maincontent starts -->

  <div id="maincont" class="ovfl-hidden">

    <div class="creat-deal">

      <h1>User Registration</h1>

      <div class="profile-thumb">

        <ul class="reset profile-thumb">

          <li class="active">

            <h1>Step-1</h1>

            <p>Profile Info</p>

          </li>

          <li>

            <h1>Step-2</h1>

            <p>Profile Picture</p>

          </li>

          <li>

            <h1>Step-3</h1>

            <p>Invite friends</p>

          </li>

        </ul>

        <!-- 

      <div class="profile-thumb-lft fl">

      <h1>Step 1</h1>

      <p>Profile Info</p>

      </div>

      <div class="profile-thumb-lft fl">

      <h1>Step 2</h1>

      <p>Profile Picture</p>

      </div>

       <div class="profile-thumb-lft fl">

        <h1>Step 3</h1>

      <p>Invite Friend</p>

      </div>-->

        <div class="clr"></div>

      </div>

<form name="frm" id="frm" method="POST" action="">
      <div class="registration-form-inn">

        <div class="form-inn">
			<h2>
			<span>Step1 :</span>
			Page 1 of 2
			</h2>
          <ul class="reset deal-from">

            <li>

              <label>Current City :</label>

              <div class="fl textbox">

                  <input name="city" id="city" type="text" value="Singapore" readonly="true" style="width:205px;"/>
					<input name="city123" id="city123" type="hidden" value="1" readonly="true" style="width:205px;"/>
              </div>

              <div class="clr"></div>

            </li>

            <li>

              <label>Relationship Status :</label>

              <div class="fl">

                <div class="radio fl"  style="margin-left:30px">

				  <input type="radio" name="rel_status" id="rel_status" value="Married" class="styled" /> 
                </div>

                <p class="fl forminntxt"> Married </p>

              </div>

              <div class="fl">

                <div class="radio fl"  style="margin-left:30px">

                  <input type="radio" name="rel_status" id="rel_status" value="Unmarried" class="styled" /> 
                </div>

                <p class="fl forminntxt"> UnMarried </p>

              </div>

              <div class="clr"></div>
			<div htmlfor="rel_status" generated="true" class="error" style="text-align:center"></div>
            </li>
			
            <li>

              <label>Grad College Attended :</label>

              <div class="fl textbox">

                <input name="grad_collage" id="grad_collage" type="text"/>
              </div>

              <div class="clr"></div>

            </li>

            <li>

              <label>Under Grad College Attended :</label>

              <div class="fl textbox">

                 <input name="under_grad_collage" id="under_grad_collage" type="text"/>
              </div>

              <div class="clr"></div>

            </li>

            <li>

              <label>Music :</label>

              <div class="fl textbox">

                <input name="music" id="music" type="text"/>
              </div>

              <div class="clr"></div>

            </li>

            <li>

              <label>Activities: </label>

              <div class="fl textbox">

                <input name="activity" id="activity" type="text"/>
              </div>

              <div class="clr"></div>

            </li>

            <li>

              <div style="margin:25px 0 0 30px">

                <label>&nbsp;</label>

				<input type="submit" value="Save and Continue" id="Submit" name="Submit" class="previe-btn" style="color: #FFFFFF;font: bold 15px/33px Arial,Helvetica,sans-serif;">
               
              </div>

            </li>

          </ul>

        </div>

      </div>

</form>
    </div>

    <!-- Maincontent ends -->
  </div>

</div>
</form>
{include file=$footer}

