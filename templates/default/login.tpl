<!-- POPUP BOX -->
<div id="login-box" class="login-popup">
    <a href="#" class="close"><img src="{$siteroot}/templates/default/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
    <div class="signin">
        <div class="member-signin-title">
            <strong>MEMBER SIGN IN</strong>
        </div>
        <form name="frm1" id="frm1" method="POST">
        <div class="row-1">
            <input type="hidden" name="siteroot" id="siteroot" value="{$siteroot}" />
            <label style="text-align:right;">Email :</label>
            <div class="row-1-txtbox-bg">
                <input type="text" class="row-1-txtbox" name="lemail" id="lemail"/>
                <div for="lemail" generated="true" class="error"></div>
            </div>
            <div class="clr-bth"></div>
        </div>
        <div class="row-1">
            <label>Password :</label>
            <div class="row-1-txtbox-bg">
                <input type="password" class="row-1-txtbox" id="lpassword" name="lpassword"/>
                <div for="lpassword" generated="true" class="error"></div>
            </div>
            <span style="padding-top:10px;float:right;"><a href="{$siteroot}/forgotpassword"><em>Forgot your password?</em></a></span>
            <div class="clr-bth">&nbsp;</div>
        </div>
        <div class="row-1">
            <div class="fl">
                <span class="login-btn-lft">
                    <span class="login-btn-rgt">
                        <input type="submit" name="submit_login" id="submit_login" value="Login" class="login-btn">
                    </span>
                </span>
            </div>
            <div class="fr">
                <!-- FACEBOOK -->
                <div style="text-align:center; color:#FFFFFF;">
                    <div id="fb-root" ></div>
                    {literal}
                    <script>
                        FB.init({
                            appId      : '468889599797776',
                            status     : true,
                            cookie     : true,
                            xfbml      : true
                        });
                        (function(d){
                            var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
                            js = d.createElement('script'); js.id = id; js.async = true;
                            js.src = "//connect.facebook.net/en_US/all.js";
                            d.getElementsByTagName('head')[0].appendChild(js);
                        }(document));
                    </script>
                    <script>
                        function fbLogin(){
                            FB.login(function(response) {
                                if (response.authResponse) {
                                    var accessToken = response.authResponse.accessToken;
                                    var SITEROOT='{/literal}{$siteroot}{literal}';
                                    jQuery.post(SITEROOT+"/fb.php",'',function(data){
                                        window.location= SITEROOT+"/my-account/my_profile_home";
                                    });
                                } else {
                                    return false;
                                }
                            },{scope: 'email'});
                        }
                    </script>
                    {/literal}
                    <a href="javascript:void(0)" ><img  onclick="fbLogin();" src="{$siteroot}/includes/facebook/Connect_with_facebook_iphone.png"></a>
                </div>
                <!-- FACEBOOK -->
            </div>
            <div class="clr-bth"></div>
        </div>
        <br />
        <div class="row-1">
            <div class="member-signin-title"> 
                New to Us? <br />
                <a href="#singup-box" class="singup-window"><strong>JOIN US NOW!</strong></a>  
            </div>
            <div class="clr-bth"></div>
        </div>
        </form>
        <div class="clr-bth"></div>
    </div>
</div>
<!-- POPUP BOX END-->
