$(document).ready(function(){
     jQuery.validator.addMethod("noSpace", function(value, element) { 
                return value.indexOf(" ") < 0 && value != ""; 
                }, "Only A-Z, a-z & _ is allowed without space");    
    $("#dealbuyfrm").validate({
	errorElement:'div',
	rules:{
            firstname:{
                required: true,
                noSpace:true
            },
            surname:{
                required: true,
                noSpace:true
            },
            addrline1:{
                required: true
            },
//             addrline2:{
//                 required: true
//             },
            city:{
                required: true
            },
            postcode:{
                required: true
            },
            email:{
                required: true,
                email: true,
            },
            billingfirstname:{
                required: true,
                noSpace:true
            },
            billingsurname:{
                required: true,
                noSpace:true
            },
            billingaddrline1:{
                required: true
            },
//             billingaddrline2:{
//                 required: true
//             },
            billingcity:{
                required: true
            },
            billingpostcode:{
                required: true
            },
            billingemail:{
                required: true,
                email: true
            },
            terms_policy: "required",
	    isdealactive: "required",
	    isuseragree: "required",
	    autho: "required"
	},
	
	messages:{
            firstname: {
                required: "Please enter first name",
            },
            surname: {
                required: "Please enter surname",
            },
            addrline1:{
                required: "Please enter Address",
            },
//             addrline2:{
//                 required: "Please enter Address",
//             },
            city: {
                required: "Please enter city"
            },
            postcode: {
                required: "Please enter postal code"
            },
            email:{
                required: "Please enter email address",
                email: "Please enter valid email address",
            },
            billingfirstname: {
                required: "Please enter first name",
            },
            billingsurname: {
                required: "Please enter surname",
            },
            billingaddrline1:{
                required: "Please enter Address",
            },
//             billingaddrline2:{
//                 required: "Please enter Address",
//             },
            billingcity: {
                required: "Please select city"
            },
            billingpostcode: {
                required: "Please enter postal code"
            },
            billingemail:{
                required: "Please enter email address",
                email: "Please enter valid email address"
            },
            terms_policy: {
                required: "Please accept terms and condition."
            },
	    isdealactive: {
	    	required: "Please Promise to pay the seller."
	    },
	    isuseragree: {
		required: "Please agree to pay a fee."
	    },
	    autho: {
		required: "Please authorise us."
	    }
	},
	success: function(div) {
            div.hide();
        }
    });
});
