$(document).ready(function(){
var userid = $('#userid').val();
    $("#dealbuyfrm").validate({
	errorElement:'div',
	rules:{
            firstname:{
                required: true,
                minlength: 4,
                maxlength: 30
            },
            surname:{
                required: true,
                minlength: 4,
                maxlength: 30
            },
            addrline1:{
                required: true
            },
            addrline2:{
                required: true
            },
            city:{
                required: true
            },
            postcode:{
                required: true
            },
            phone:{
                required: true
            },
            email:{
                required: true,
                email: true
                //remote: {url:SITEROOT + "/modules/rconfirm/ajax_check_user.php?userid="+userid,type:"post"}
            },
            conemail:{
                required: true,
                email: true,
                equalTo:'#email'
            },
            password1:{
                required: true
            },
            password2:{
                required: true,
                equalTo:'#password1'
            },
            namecard:{
                required: true
            },
            cardno:{
                required: true,
                minlength: 13,
                maxlength: 16
            },
            cvvno:{
                required: true
            },
            validu:{
                required: true
            },
            termandpolicy:{
                required: true
            }
	},
	
	messages:{
            firstname: {
                required: "Please enter first name",
                minlength: jQuery.format("Enter at least {0} characters"),
                maxlength: jQuery.format("Enter at most {0} characters")
            },
            surname: {
                required: "Please enter surname",
                minlength: jQuery.format("Enter at least {0} characters"),
                maxlength: jQuery.format("Enter at most {0} characters")
            },
            addrline1:{
                required: "Please enter Address",
                minlength: jQuery.format("Enter at least {0} characters"),
                maxlength: jQuery.format("Enter at most {0} characters")
            },
            addrline2:{
                required: "Please enter Address",
                minlength: jQuery.format("Enter at least {0} characters"),
                maxlength: jQuery.format("Enter at most {0} characters")
            },
            city: {
                required: "Please select city"
            },
            postcode: {
                required: "Please enter postal code"
            },
            phone: {
                required: "Please enter phone number"
            },
            email:{
                required: "Please enter email address",
                email: "Please enter valid email address"
                //remote: "This email address is already a registered"
            },
            conemail:{
                required: "Please enter confirm email address",
                email: "Please enter valid email address",
                equalTo: "Enter the same email address as above"
            },
            password1: {
                required: "Please enter password"
            },
            password2: {
                required: "Please enter confirm password",
                equalTo: "Enter the same password as above"
            },
            namecard: {
                required: "Please enter card holder name"
            },
            cardno: {
                required: "Please enter card number",
                minlength: jQuery.format("Enter at least {0} characters"),
                maxlength: jQuery.format("Enter at most {0} characters")
            },
            cvvno: {
                required: "Please enter CVV number"
            },
            validu: {
                required: "Please enter expiry date"
            },
            termandpolicy: {
                required: "Please agree privacy polocy "
            }
	},
	success: function(div) {
            div.hide();
        }
    });

    $("#dealbuyfrm").submit(function() {
  
	    var d = new Date();
	    var m2 = parseInt(d.getMonth());
	    var y2 = parseInt(d.getFullYear());
  
	    var m1=$('#expiry_month').val();
	    var y1=$('#expiry_year').val();
  
	    if(m1 == '' || y1 == "" )
	    {
		document.getElementById('date_err').style.display="block";
		document.getElementById('date_err').innerHTML="Please select date";
		return false;
	    }
	    else if(y1< y2)
	    {
		document.getElementById('date_err').style.display="block";
		document.getElementById('date_err').innerHTML="Please select valid date";
		return false;
	    }
	    else if (y1 == y2 && m1 <= m2)
	    {
		document.getElementById('date_err').style.display="block";
		document.getElementById('date_err').innerHTML="Please select valid date";
		return false;
	    }
	    else
		return true;
  
	});

});