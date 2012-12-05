$(document).ready(function() {
	// validate signup form on keyup and submit
	 $("#frmBuyerSignin").validate({

		errorElement:'div',
		rules: {
			lemail : {
				required: true,
				email: true
			},
			lpassword : {
				required: true
			}
		},
		messages: {
			lemail: {
				required: "Please enter email address",
				email: "Please enter valid email address"
			},
			lpassword: {
				required: "Please provide password"
			}
		},

		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
	});

});


	function rememberMe() {
		var page = SITEROOT + "/modules/sign-in/get_cookie.php";
		ajax.sendrequest("POST", page , { type:'remember_me' }, 'callbackRememberMe', '');
	}

	function callbackRememberMe(data){
		var userobj = document.getElementById("lemail");
		var passobj = document.getElementById("lpassword");
		var remobj 	= document.getElementById("isremember");

		userobj.value = ( data.username != null ) ? data.username : "";
		passobj.value = ( data.password != null ) ? data.password : "";
		if(data.remember == 1) {
			remobj.checked = true;
		}
		else
		{	remobj.checked = false;
		}
	}

	$(document).ready(function(){
		rememberMe();
	});
