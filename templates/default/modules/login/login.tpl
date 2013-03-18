{include file=$header_start}
{strip}
    <script type="text/javascript" src="{$sitejs}/validation/login.js"></script>
{/strip}
{include file=$header_end}
<div id="wrapper">
    <!-- main container with changing content -->
    <div id="maincont">
        <div class="marchant-form-main" style="width:443px;padding-top: 48px;">
            <h1>If you are already registered, Please Sign In</h1>
            <!-- / registration form start here -->
            <div class="marchant-form_bg" style="padding:5px 5px">
                <div class="marchant-form_cont" style="width:350px;margin:20px auto;">
                {if $lerror neq ''}
                    <p><div class="errorMsg" align="center">{$lerror}</li></p>
                {/if}
                    <form name="frm" id="frm" method="POST" action="">
                        <ul class="fl marchantstep-one-form reset" style="width:380px;">
                            <li>
                                <label>Email ID:</label>
                                <div class="textbox fl" style="margin-left:0px;">
                                    <input type="text"  name="lemail" id="lemail"  {if $smarty.cookies.lemail neq "" } value="{$smarty.cookies.lemail}" {/if}>
                                </div>
                            </li>
                            <li>
                                <label>Password:</label>
                                <div class="textbox fl" style="margin-left:0px;">
                                    <input type="password"  name="lpassword" id="lpassword" {if $smarty.cookies.lpassword neq "" } value="{$smarty.cookies.lpassword}" {/if}>
                                </div>
                            </li>
                            <li>
                                <!--<label>&nbsp;</label>-->
                                <div class="fl" style="width:278px;padding-left:85px; margin-left:20px;">
                                    <p class="fl"><input type="checkbox" name="isremember" value="1" {if $smarty.cookies.isremember eq '1'} checked="true" {/if}/>&nbsp;&nbsp;Remember me&nbsp;&nbsp;|&nbsp;&nbsp;<!--</p>--> 
                                    <!-- <p class="fl" style="margin-left:7px">--><a href="{$siteroot}/forgotpassword">Forgot my password</a></p> 
                                </div>
                            </li>
                            <li>
                                <label>&nbsp;</label>
                                <div style="margin-left:15px;">
                                    <span class="login-btn-lft" style=" margin-left: 0px;">
                                        <span class="login-btn-rgt"><input class="login-btn" type="submit" name="submit_login" id="submit_login" value="Log In"></span>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </form>
                </div>
                <div class="clr"></div>
            </div>
            <!-- / registration form end here -->
            <div style="height:80px;"></div>
        </div>
    </div>
{include file=$footer}
</div>
