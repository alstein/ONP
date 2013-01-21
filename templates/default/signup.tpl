<!--SIGNUP POPUP BOX -->
<div id="singup-box" class="singup-popup login-popup" style="margin-left:-186.5px">
    <a href="#" class="close"><img src="{$siteroot}/templates/default/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
    <div class="signin" id="cateselect" style="width:350px;">
        <div class="member-signin-title"> 
            <strong id="title_name">JOIN US NOW!</strong> 
        </div>
        <form name="frm" id="frm" method="POST">
            <div class="joinus">
                <div id="singup_first">
                    <div class="joinus-row-1">
                        <label style="text-align:right;">First Name:</label>
                        <div class="joinus-row-1-txtbox-bg">
                            <input type="text" class="row-1-txtbox" name="name" id="name" value="{$name}" />
                        </div>
                        <div class="clr-bth"></div>
                    </div>
                    <div class="joinus-row-1">
                        <label style="text-align:right;">Last Name:</label>
                        <div class="joinus-row-1-txtbox-bg">
                            <input type="text" class="row-1-txtbox" id="lname" name="lname" value="{$lname}" />
                        </div>
                        <div class="clr-bth"></div>
                    </div>
                    <div class="joinus-row-1">
                        <label style="text-align:right;">Email:</label>
                        <div class="joinus-row-1-txtbox-bg">
                            <input type="text" class="row-1-txtbox" id="email" name="email" value="{$email}" />
                            {if $email_exist eq "1"}
                                <div id="emailmsg" class="error">Email already exist.</div>
                            {/if}
                        </div>
                        <div class="clr-bth"></div>
                    </div>
                    <div class="joinus-row-1">
                        <label style="text-align:right;">Password:</label>
                        <div class="joinus-row-1-txtbox-bg">
                            <input type="password" class="row-1-txtbox" id="password" name="password"/>
                        </div>
                        <div class="clr-bth"></div>
                    </div>
                    <div class="joinus-row-1">
                        <label style="text-align:left;">Re-type Password:</label>
                        <div class="joinus-row-1-txtbox-bg">
                            <input type="password" class="row-1-txtbox" id="reenter_pass" name="reenter_pass"/>
                            <div htmlfor="reenter_pass" generated="true" class="error" style="display: block; width: 231px;"></div>
                        </div>
                        <div class="clr-bth"></div>
                    </div>
                    <div class="joinus-row-1">
                        <label style="text-align:right;">I am:</label>
                        <div class="joinus-row-1-txtbox-bg" style="background:none;" >
                            <div class="joinus-row-1-txtbox-bg i-am-txtbox-bg" style="background:none;">
                                <!-- I AM -->
                                <div class="i-am-combox-select">
                                    <select name="sel_gender" id="sel_gender" class="select" style="height:16px; width:70px">
                                        <option value="male" {if $gender eq 'male'} selected="selected" {/if}>Male</option>
                                        <option value="female" {if $gender eq 'female'} selected="selected" {/if}>Female</option>
                                    </select>
                                </div>
                                <!-- I AM -->
                            </div>
                        </div>
                        <div class="clr-bth"></div>
                    </div>
                    <div class="joinus-row-1">
                        <label style="text-align:right;">Birthday:</label>
                        <div class="joinus-row-1-txtbox-bg" style="background:none;" >
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50" align="left" valign="middle">
                                        <div class="day-bg">
                                            <!-- DAY -->
                                            <div class="day-select">
                                                <select name="sel_dd" id="sel_dd" class="select" >
                                                    <option value="">DD</option>
                                                    {section name=day start=1 loop=32 step=1}
                                                    <option value="{$smarty.section.day.index}"  {if $sel_dd eq $smarty.section.day.index} selected="selected" {/if} >{$smarty.section.day.index}</option>
                                                    {/section}
                                                </select>
                                            </div>
                                            <!-- DAY -->
                                        </div>
                                    </td>
                                    <td width="72" align="left" valign="middle">
                                        <div class="month-bg">
                                            <!-- MONTH -->
                                            <div class="month-select">
                                                <select name="sel_mm" id="sel_mm" class="select" >
                                                    <option value="">MM</option>
                                                    {section name=month start=1 loop=13 step=1}
                                                    <option value="{$smarty.section.month.index}" {if $sel_mm eq $smarty.section.month.index} selected="selected" {/if}>{$smarty.section.month.index}</option>
                                                    {/section}
                                                </select>
                                            </div>
                                            <!-- MONTH -->
                                        </div>
                                    </td>
                                    <td width="58" align="left" valign="middle">
                                        <div class="year-bg">
                                            <!-- YEAR -->
                                            <div class="year-select">
                                                <select name="sel_yy" id="sel_yy" class="select" >
                                                    <option value="">YYYY</option>
                                                    {section name=year start=1900 loop=$year step=1}
                                                    <option value="{$smarty.section.year.index}" {if $sel_yy eq $smarty.section.year.index} selected="selected" {/if}>{$smarty.section.year.index}</option>
                                                    {/section}
                                                </select>
                                            </div>
                                            <!-- YEAR -->
                                        </div>
                                    </td>
                                </tr>
                                <TR><td colspan="2"><div for="sel_yy" generated="true" class="error"></div></td></TR>
                            </table>
                        </div>
                        <div class="clr-bth"></div>
                    </div>
                    <div class="row-1">
                        <label> </label>
                        <div class="row-1-txtbox-bg" style="background:none;margin-top:15px;">
                            <div style="margin-left:15px;">
                                <span class="login-btn-lft">
                                    <span class="login-btn-rgt"><input type="button" name="submit" id="submit" value="NEXT >>" class="login-btn" onclick="validate();"></span>
                                </span>
                            </div>
                        </div>
                        <div class="clr-bth"></div>
                    </div>
                </div>
                <div id="cate_select" style="display:none">
                    <div class="joinus-row-1">
                        <p class="title-red">Categories Preference :</p>
                        <ul class="reset deal-from">
                            <li>
                            {section name=i loop=$category}
                                <div  style="clear: both;">
                                    <input class="styled" name="chk_category[]" id="chk_category" type="checkbox" value="{$category[i].id}" style="float:left">
                                    <p class="fl forminntxt" style="color:#fff;">{$category[i].category}</p>
                                </div>
                            {/section}
                            <div>{$msg}</div>
                            <div  style="clear:both">
                                <input name="deal_thr_email" id="deal_thr_email" type="checkbox" value="yes" class="styled" style="float:left">
                                <p class="fl forminntxt" style="color:#044EA2">"You would like to receive Offers through emails as well"? </p>
                            </div>
                            <div class="clr"></div>
                            </li>
                            <li>
                                <div id="div_cat" class="error" style="display:none;padding-left:30px" >Please select atleast category which you want to prefer. </div>
                                <div id="div_cat1" class="error" style="display:none;padding-left:30px" >Please select atleast Two categories which you want to prefer. </div>
                            </li>	
                        </ul>
                        <div class="clr"></div>
                        <div>By clicking Join Now, you are indicating that you have read, understood, and agree to our <a href="{$siteroot}/terms" style="color:#044EA2">Terms</a> and <a href="{$siteroot}/privacy-policy" style="color:#044EA2">Privacy Policy</a>.</div>
                        <div class="pre-btn fr" style="margin-left:144px;float:left;margin-bottom:20px;">
                            <input class="previe-btn" type="submit" name="Submit" id="Submit" value="JOIN NOW" onclick="return show_div();">
                        </div>
                        <!--<div class="clr-bth"></div>-->
                    </div>
                </div>
                <!--<div class="clr-bth"></div>-->
            </div>
        </form>
        <!-- FACEBOOK -->
    </div>
</div>
<!-- SIGNUP POPUP BOX END-->