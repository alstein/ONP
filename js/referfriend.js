	function EmailTofrnd() {
		this.error = 0;
		this.msgobj = "";
		this.checkEmailToFrnd = function() {
			this.msgobj = document.getElementById("err_msg2");
			var toname = document.getElementById("toname").value;
			var email = document.getElementById("to").value;
			var from = document.getElementById("from").value;
			var id =  document.getElementById("inv_url").value;
			var subject =  document.getElementById("subject").value;
			var body =  document.getElementById("body").value;
      			var flag =  document.getElementById("flag").value;
			

			if(toname.length<1)
			{
				this.msgobj.innerHTML = "<span>Please enter friend name</span>";
				document.getElementById("toname").focus();
				this.msgobj.className = "Error";
			}
			else if(email.length<1)
			{
				this.msgobj.innerHTML = "<span>Please enter friend email id</span>";
				document.getElementById("to").focus();
				this.msgobj.className = "Error";
			}
			else if(!validator.validEmail(email)){
				this.msgobj.innerHTML = "<span>Please enter valid friend email id</span>";
				document.getElementById("to").focus();
				this.msgobj.className = "Error";
			}
			else if(from.length<1)
			{
				this.msgobj.innerHTML = "<span>Please enter your email id</span>";
				document.getElementById("from").focus();
				this.msgobj.className = "Error";
			}
			else if(!validator.validEmail(from)){
				this.msgobj.innerHTML = "<span>Please enter valid your email id</span>";
				document.getElementById("from").focus();
				this.msgobj.className = "Error";
			}
			else{
				/*document.getElementById("email").disabled = "true";
				document.getElementById("password").disabled = "true";
				document.getElementById("btnSend").disabled = "true";
				document.getElementById("btnCancel").disabled = "true";
				*/this.msgobj.style.display = "none";
				var page = SITEROOT + "/popups/reward_JSON.php";
				ajax.sendrequest("POST", page, {toname:toname,email:email,from:from,inv_url:id,subject:subject,body:body,flag:flag}, 'etfrnd.callBackSendDetailsfrnd', '');
			}
		}
		this.onEnter=function(e){
			var charCode;	charCode = e.keyCode ;	if (charCode == 13) this.checkEmailToFrnd();
		}

		this.callBackSendDetailsfrnd = function (data) {
			if(data.success > 0) {
				document.getElementById("toname").disabled = "";
				document.getElementById("to").disabled = "";
				document.getElementById("from").disabled = "";
				document.getElementById("subject").disabled = "";
				document.getElementById("body").disabled = "";
				document.getElementById("btnSend").disabled = "";
				var msg = "<span>"+data.message+"</span>";
				$("#err_msg2").html(msg);
				this.msgobj.style.display = "";
				$("#err_msg2").addClass("Success");
				setTimeout("jQuery(document).trigger('close.facebox');",2000);
				
			}else{
				this.msgobj.innerHTML = "";
				$("#err_msg2").html("");
				this.msgobj.style.display="";
				var msg = "<span>"+data.message+"</span>";
				$("#err_msg2").html(msg);
				$("#err_msg2").addClass("Error");
			}
		}
	}

	var etfrnd = new EmailTofrnd();

	function openEmailTo(id,ret){
		if(ret)
		{
			jQuery.facebox({ajax:SITEROOT + '/popups/reward.php?flag=1&url='+id});
		}
		else
		{
			jQuery.facebox({ajax:SITEROOT + '/popups/reward.php?id2='+id});
		}
	}