$(document).ready(function(){


$.validator.addMethod("email", function(value, element) {
		var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if($('#general_enquiry').val().length > 0)
		{
			return rege.test($('#general_enquiry').val());
		}else
		{
			return true;
		}
	},"Please enter valid email address");
$.validator.addMethod("email1", function(value, element) {
		var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if($('#sales_enquiry').val().length > 0)
		{
			return rege.test($('#sales_enquiry').val());
		}else
		{
			return true;
		}
	},"Please enter valid email address");

    $("#home_form").validate({
       	errorElement:'div',
 	  rules: {
         	  phone : {
			required: true,
			minlength: 10,
			maxlength:25//,
    		//	number:true
			},
                  fax:{
			required: true,
			minlength: 10,
			maxlength:25,
			number:true
			},
		  general_enquiry : {
			required: true,
			email: true
			},
                  sales_enquiry:{
			required: true,
			email1: true
			}
                 },
        messages:{
                phone : {
			required: "Please enter phone no."
			  },
                fax:{
			valid_editor: "Please enter fax no."
				},
		 general_enquiry : {
			required: "Please enter general enquiry."
			  },
                 sales_enquiry:{
			required: "Please enter sales enquiry."
				}
 	         }
        });
 });