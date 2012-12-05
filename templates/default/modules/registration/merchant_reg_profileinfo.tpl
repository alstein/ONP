{include file=$header_start}
{strip}
    <script type="text/javascript" src="{$sitejs}/validation/merchant_profile_info.js"></script>
{/strip}
{literal}
<script language="JavaScript">
    // JavaScript Document
    var xmlHttp
    function GetXmlHttpObject(){
        var xmlHttp=null;
        try{
          // Firefox, Opera 8.0+, Safari
          xmlHttp=new XMLHttpRequest();
        }
        catch (e)
        {
            // Internet Explorer
            try
            {
                xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch (e)
            {
                xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
        }
        return xmlHttp;
    }

    function fillStates(str)
    {
        xmlHttp=GetXmlHttpObject()
        if (xmlHttp==null)
        {
            alert ("Your browser does not support AJAX!");
            return;
        }
        var url = SITEROOT+"/admin/globalsettings/deal/show_states_admin.php";
        url=url+"?cnid="+str;
        xmlHttp.onreadystatechange=states_value;
        xmlHttp.open("GET",url,true);
        xmlHttp.send(null);
    }
    function states_value(){
        if (xmlHttp.readyState==4){
            var response=xmlHttp.responseText;
            document.getElementById('state_div').innerHTML=response;
        }
    }

    function fillCities(str)
    {
        //alert(str);
        xmlHttp=GetXmlHttpObject()
        if (xmlHttp==null)
        {
            alert ("Your browser does not support AJAX!");
            return;
        }
        var url = SITEROOT+"/admin/globalsettings/deal/show_cities_admin.php";
        url=url+"?stid="+str;
        xmlHttp.onreadystatechange=city_value;
        xmlHttp.open("GET",url,true);
        xmlHttp.send(null);
    }

    function city_value(){
        if (xmlHttp.readyState==4){
            var response=xmlHttp.responseText;
            document.getElementById('city').innerHTML=response;
        }
    }

</script>
{/literal}
{literal}
<script language="JavaScript">
    $(document).ready(function()
    {
        $('#frmRegistration').submit(function(){
            if ($('div.error').is(':visible'))
            {
            } 
            else 
            { 
                $('#Submit').hide(); 
                $('#buttonregister').append("<input type='button' name='Submit' id='Submit' value='Save' />"); 
            }
        });
    });
    function show_address()
    {
	if(!(document.getElementById('chk_outlet').checked))
	{
            $('#div_address').hide();
	}
	else  
	{   
            $('#div_address').show();
	}
    }
</script>
{/literal}
<!-- main continer of the page -->
{include file=$header_end}
<!-- Header ends -->

<!-- Maincontent starts -->

<div id="maincont" class="ovfl-hidden">
    <div class="creat-deal">
        <h1>Local Business Registration</h1>
        <div class="profile-thumb1" >
            <div class="profile-thumb1-lft fl tabs" >
                <h1 style=" color: #FFFFFF;font-size: 18px;margin: 5px 0;">Step 1</h1>
                <p style=" font: 13px Arial,Helvetica,sans-serif;text-align: center;color:#fff">Profile Info</p>
            </div>
            <div class="profile-thumb1-lft fl">
                <h1>Step 2</h1>
		<p>Business Info</p>
            </div>
            <div class="profile-thumb1-lft fl">
                <h1>Step 3</h1>
                <p>Deal Eligibility</p>
            </div>
            <div class="clr"></div>
        </div>

        <form method="POST" name="frm" id="frmRegistration" action="">
            <div class="registration-form1">
                <ul class="reset deal-from">
                    <li>
                        <label>Email:</label>
                        <div class="fl textbox">
                            <input name="email" id="email" type="text" />
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <label>Password:</label>
                        <div class="fl textbox">
                            <input name="password" id="password" type="password" />
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <label>Retype Password:</label>
                        <div class="fl textbox">
                            <input name="cpassword" id="cpassword" type="password" />
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <label>Business Name::</label>
                        <div class="fl textbox">
                            <input name="business_name" id="business_name" type="text" />
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <label>Contact Person Name:</label>
                        <div class="fl textbox">
                            <input name="contact_person" id="contact_person" type="text" />
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <label style="width:171px">&nbsp;&nbsp;</label>
                        <div class="fl">
                            <input type="checkbox" name="chk_outlet" id="chk_outlet" value="yes" onclick="javascript:show_address();" />
                            We have multiple outlets
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <label> Address 1(Street):</label>
                        <div class="fl textbox">
                            <input name="address1" id="address1" type="text" />
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <label> Address 2(Building/Unit):</label>
                        <div class="fl textbox">
                            <input name="concat_address" id="concat_address" type="text" />
                        </div>
                        <div class="clr"></div>
                    </li>
                    <div id="div_address" style="display:none;">
                    <li>
                        <label> Address 2:</label>
                        <div class="fl textbox">
                            <input name="address2" id="address2" type="text" />
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <label> Address 3:</label>
                        <div class="fl textbox">
                            <input name="address3" id="address3" type="text" />
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <label> Address 4:</label>
                        <div class="fl textbox">
                            <input name="address4" id="address4" type="text" />
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <label> Address 5:</label>
                        <div class="fl textbox">
                            <input name="address5" id="address5" type="text" />
                        </div>
                        <div class="clr"></div>
                    </li>
                    </div>
                    <li>
                        <label>Country:</label>
                        <div class="fl textbox">
                            <input name="countryid1" id="countryid1" type="text" readonly="true" value="Singapore"/>
                            <input type="hidden" name="countryid" id="countryid" value="1" readonly="true"  class="textbox">
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <label>City:</label>
                        <div class="fl textbox">
                            <input type="text" name="cityid1" id="cityid1" value="Singapore" readonly="true" value="Singapore"/>
                            <input type="hidden" name="cityid" id="cityid" value="1" readonly="true" class="textbox">  
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <label> Phone:</label>
                        <div class="fl textbox">
                            <input name="phone" id="phone" type="text" type="text" />
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <label> Website:</label>
                        <div class="fl textbox">
                            <input name="website" id="website" type="text" type="text" />
                        </div>
                        <div class="clr"></div>
                    </li>
                    <li>
                        <label>&nbsp;</label>
                        <div class="pre-btn fl" style="margin:0 0 30px 30px">
                            <input type="submit" name="Submit" id="Submit"  class="previe-btn" style="width:92px" value="Submit"/>
                        </div>
                    </li>
                </ul>
            </div>
        </form>
    </div>
    <!-- Maincontent ends -->
</div>

{include file=$footer}
</body>

</html>
