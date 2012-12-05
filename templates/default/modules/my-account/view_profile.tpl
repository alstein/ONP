{include file=$header_start}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/edituser.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
{/strip}
{literal}
<script language="javascript" type="text/javascript">
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
//alert(str);
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


function setflag(values)
{
   
 if(values==3)
 {
       document.getElementById("sellerflag1").style.display='block';
    document.getElementById("sellerflag2").style.display='block';

 }
 if(values==2)
 {
       document.getElementById("sellerflag1").style.display='none';
    document.getElementById("sellerflag2").style.display='none';

 }

}
</script>
{/literal}
<body class="inner_body" >
<!-- main continer of the page -->

  <!-- header container starts here-->
  {include file=$profile_header2}
  <!-- / header container ends here-->
  <!-- main container with changing content -->


<div id="wrapper"  >
  <div id="maincont" >
    <!-- Left content Start here -->
       {include file=$myprofile_left_panel}
    <!-- Middel content Start here -->
    <div class="profile-middel" style="height:839px;">
	<h2 style="margin-left:20px;color: #2B587A;" class="profile_name">View Profile</h2>
         <form name="frmUserProfile" id="frmUserProfile" action="" method="post">
    
      <table cellspacing="5" cellpadding="5" width="450" border="0" style="margin:25px" >

			<tr>
                <td align="right" valign="top" class="profile-name" style="width:180px;"> I am: </td>
                 <td align="left">{$user.gender}
                                                      </td>
            </tr>


      <tr>
        <td align="right" valign="top"  class="profile-name" style="width:180px;"><input type="hidden" name="userid" id="userid" value="{$user.userid}" />
        First Name:</td>
        <td align="left">{$user.first_name}
                                     
        </td>
      </tr>
      <tr>
        <td align="right" valign="top" class="profile-name" style="width:180px;"> Last Name:</td>
        <td align="left" >{$user.last_name}
                               
        </td>
</tr>
<!--            <tr>
                <td align="right" valign="top"  class="profile-name" style="width:180px;">Address: </td>
                 <td align="left" >
			{$user.address1}  
		</td>
            </tr>-->


<tr>
                <td align="right" valign="top" class="profile-name" style="width:180px;">Birthday: </td>
                 <td align="left" >{$user.birthdate|date_format}</td>
            </tr>

			<tr>
                <td align="right" valign="top"  class="profile-name" style="width:180px;">Relationship Status: </td>
                 <td align="left" >{$user.rel_status } 
                 </td>
            </tr>


           <!-- <tr>
                <td align="right" valign="top"  class="profile-name" style="width:180px;"> Intrested In: </td>
                 <td align="left" >{$deal_as_usual} 				
                                        
		</td>
		</tr>-->

<tr>
		<td align="right" valign="top" class="profile-name" style="width:180px;">Category Preferance: </td>
		<td colspan="2" align="left">
			<table >
			{section name=i loop=$category}
				<tr>
				<td>
				<input  disabled="true" name="chk_category[]" id="chk_category" type="checkbox" value="{$category[i].id}" {if in_array($category[i].id, $cat_preferance)} checked='checked' {/if} class="fl boxcheck">
				<label>{$category[i].category}</label>
				</td>
				</tr>
			{/section}
			</table>

	      </td>
	  </tr>


      </tr>
      <tr style="display:none;">
        <td align="right" valign="top" class="profile-name" style="width:180px;">User Name:</td>
        <td align="left" >{$user.username}
       
        </td>
      </tr>

      <tr>
          <td align="right" valign="top" class="profile-name" style="width:180px;"> Email Address:</td>
          <td>
           {$user.email}      
          </td>
      </tr>
      
            <!--<tr>
                <td align="right" valign="top"  class="profile-name" style="width:180px;">Country: </td>
                <td align="left" >
			
				
				    {$user.country}
              	</td>
            </tr>
            <tr>
                <td align="right" valign="top" class="profile-name" style="width:180px;">County/State:</td>
                <td align="left" >
			{$user.state_name}
			
		</td>
            </tr>-->
            
	    <tr>
			<td align="right" valign="top"  class="profile-name" style="width:180px;">City/Town: </td>
			<td align="left" >
				
					{*$user.city_name*}Singapore
				
             </td>
            </tr>


           <tr>
                <td align="right" valign="top" class="profile-name" style="width:180px;">Grad College: </td>
                <td align="left">{$user.grad_college}
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="college" generated="true"></div>
                </td>
            </tr>
		 <tr>
                <td align="right" valign="top" class="profile-name" style="width:180px;"> Under Grad College: </td>
                <td align="left" >{$user.under_grad_college}
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="college" generated="true"></div>
                </td>
            </tr>

           <!-- <tr>
                <td align="right" valign="top"  class="profile-name" style="width:180px;">Movies: </td>
                <td align="left" >{$user.movies}
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="movies" generated="true"></div>
                </td>
            </tr>-->

            <tr>
                <td align="right" valign="top"  class="profile-name" style="width:180px;"> Music: </td>
                <td align="left">{$user.music}
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="music" generated="true"></div>
                </td>
            </tr>

           <!-- <tr>
                <td align="right" valign="top"  class="profile-name" style="width:180px;"> Books: </td>
                <td align="left" >{$user.books}
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="books" generated="true"></div>
                </td>
            </tr>

            <tr>
                <td align="right" valign="top" class="profile-name" style="width:180px;"> TV: </td>
                <td align="left">{$user.tv}
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="tv" generated="true"></div>
                </td>
            </tr>-->


            <tr>
                <td align="right" valign="top"  class="profile-name" style="width:180px;">Activities: </td>
                <td align="left" >{$user.activities}
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="activities" generated="true"></div>
                </td>
            </tr>



    <tr style="display:none;">
        <td align="right" valign="top"  class="profile-name" style="width:180px;"> Membership: </td>
	<td>
	      <select name="membertype" style="width:100px;" onChange="return setflag(this.value)">
		    <option value="2" selected="selected">Buyer</option>
		    <option value="3">Seller</option>
	      </select>
	      
        </td>
      </tr>

  

    </table>
 
  </form>
    </div>
    <!-- Right content Start here -->
    {include file=$myprofile_right_panel}
    <!-- footer container Start-->
  {include file=$footer}
    <!-- footer container End-->
  </div>
</div>
</body> 

