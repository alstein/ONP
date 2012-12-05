$(document).ready(function() {
		 $("#frm").validate({
		errorElement:'div',
		rules: {
			pname : {
				required: true,
				minlength: 2,
				maxlength: 100
			},
			city : {
				required: true,
			},
			state : {
				required: true,
			},
			cname : {
				required: true,
			},
			website : {
				required: true
			},
			email : {
				required: true,
				email: true
			},
			phone : {
				required: true

			},
			comment : {
				required: true,
				minlength: 10,
				maxlength: 500
			}
		},

		messages: {

			pname: {
				required: "Please enter partner name",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			city : {
				required: "Please enter City"
			},
			state : {
				required: "Please enter State"
			},
			cname: {
				required: "Please enter contact name"
			},
			website : {
				required: "Please Enter website"
			},
			email: {
				required: "Please enter email address",
				email:"Please enter valid email address."
			},
			phone: {
				required: "Please enter phone number"
			},
			comment : {
				required: "Please Enter message",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			}
		}
	});
   $("#frm").submit(function(){

   });
});


function checkphone(evt){

   var ph = document.getElementById('phone').value;

   var len = ph.length;

   if(ph==""){

      document.getElementById('phone').value ="(";

   }

   var charCode = (evt.which) ? evt.which : event.keyCode

      if (charCode > 31 && (charCode < 48 || charCode > 57))

         return false;

   if(len==4){

      document.getElementById('phone').value =ph+") ";

   }

   if(len==9){

      document.getElementById('phone').value =ph+" - ";

   }

}