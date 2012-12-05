/* 
 * This file contains the custom methods used
 * for validating the customer signup form.
 */

jQuery.validator.addMethod("noSpace", function(value, element){ 
        return value.indexOf(" ") < 0 && value != ""; 
    },"Space is not allowed"
);


$(".signinput").css("color","#0000FF");
$.validator.addMethod("postcodes",function(value, element) {
        var regularex="^([a-zA-Z]){1}([0-9][0-9]|[0-9]|[a-zA-Z][0-9][a-zA-Z]|[a-zA-Z][0-9][0-9]|[a-zA-Z][0-9]){1}([        ])([0-9][a-zA-z][a-zA-z]){1}$";
        var check = false;
        var re = new RegExp(regularex);
        return this.optional(element) || re.test(value);
    }, "Please enter a valid postcode."
);

$.validator.addMethod("alphaOnly", function(value, element){
        var temp;
        temp = true;
        str = /[^a-zA-Z - ]/;
        temp = !str.test(value);
        return temp;
    }, "Only a to z, A to Z and - is allowed."
);


jQuery.validator.addMethod("url_double_dot", function(value, element) {
        for(var i=0; i<value.length; i++)
        {
            if(value[i] == '.' && value[(parseInt(i)+1)] == '.')
            {	
                return false;
            }
        }
        return true;
    },"Please enter valid data"
);

$.validator.addMethod("yearchk", function(value, element) {
        var day = $("#sel_dd").val();
        var month = $("#sel_mm").val();
        var year = $("#sel_yy").val();
        var age = 18;
        var mydate = new Date();
        mydate.setFullYear(year, month-1, day);
        var currdate = new Date();
        currdate.setFullYear(currdate.getFullYear() - age);

	if ((currdate - mydate) < 0){
            //alert("Sorry, only persons over the age of " + age + " may enter this site");
            return false;
	}
	return true;
    }, "You should be 18 years old."
);

jQuery.validator.addMethod("email", function(value, element){
        if(value == '') 
            return true;
        var temp1;
        temp1 = true;
        var ind = value.indexOf('@');
        var str2=value.substr(ind+1);
        var str3=str2.substr(0,str2.indexOf('.'));
        if(str3.lastIndexOf('-')==(str3.length-1)||(str3.indexOf('-')!=str3.lastIndexOf('-')))
            return false;
        var str1=value.substr(0,ind);
        if((str1.lastIndexOf('_')==(str1.length-1))||(str1.lastIndexOf('.')==(str1.length-1))||(str1.lastIndexOf('-')==(str1.length-1)))
           return false;
      str = /(^[a-zA-Z0-9]+[\._-]{0,1})+([a-zA-Z0-9]+[_]{0,1})*@([a-zA-Z0-9]+[-]{0,1})+(\.[a-zA-Z0-9]+)*(\.[a-zA-Z]{2,3})$/;
      temp1 = str.test(value);
      return temp1;
    }, "Please enter valid email"
);

jQuery.validator.addMethod("letterspaceonly", function(value, element) {
        return this.optional(element) || /^([a-z]+([\s][a-z]+)?)+$/i.test(value);
    }, "Letters and Single space only"
);

 $.validator.addMethod("CheckDOB", function (value, element) {
        var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!

	var yyyy = today.getFullYear();
	if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} 
	var today = yyyy+'-'+mm+'-'+dd;
	
        var day = $('#sel_dd').val();
	var month = $('#sel_mm').val();
	var year = $('#sel_yy').val();
	var DOB = year+'-'+month+'-'+day;
	if(DOB <= today) {
            return true;
        }
        return false;  
    }, "Birth Date must be less than today's date."
);

$(document).ready(function() {
    $('#frm').validate({
        errorElement:'div',
        rules: {
            name:{
                    required: true,
                    minlength: 2,
                    letterspaceonly:true,
                    maxlength: 50
            },
            lname:{
                    required: true,
                    minlength: 2,
                    letterspaceonly:true,
                    maxlength: 50
            },
            email:{
                    required: true,
                    url_double_dot: true,
                    email: true
            },
            reenter_pass: {
                    required: true,
                    equalTo:'#password'
            },
            password:{
                required:true,
                noSpace: true,
                minlength: 6,
                maxlength: 15
            },
            sel_dd:{
                required:true 
            },
            sel_mm:{
                required:true
            },
            sel_yy:{
                required:true,
                //CheckDOB:true,
                yearchk:true
            }
        },
        messages: {
            name:{
                required: "Please enter first name.",
                minlength: jQuery.format("Enter at least {0} characters."),
                maxlength: jQuery.format("Enter at most {0} characters.")
            },
            lname:{
                required: "Please enter last name.",
                minlength: jQuery.format("Enter at least {0} characters."),
                maxlength: jQuery.format("Enter at most {0} characters.")
            },
            email:{
                required: "Please enter email",
                email: "Please enter a valid email address.",
                remote: "This email address is already in use"
            },
            reenter_pass: {
                required: "Please enter your password again.",
                equalTo: "Please enter the same password as above"
            },
            password:{
                required: "Please enter password",
                minlength: jQuery.format("Enter at least {0} characters."),
                maxlength: jQuery.format("Enter at most {0} characters.")
            },
            sel_dd:{
                required: "Please select day"
            },
            sel_mm:{
                required: "Please select month"
            },
            sel_yy:{
                required: "Please select year"
            }
        },
        success: function(label) {
                // set &nbsp; as text for IE
                label.hide();
        }
    });
});
