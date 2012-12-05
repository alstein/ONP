	function EmailTo() {
		this.error = 0;
		this.msgobj = "";
		this.checkEmailTo = function() {
			this.msgobj = document.getElementById("err_msg2");
			
			var email = document.getElementById("to").value;
			var from = document.getElementById("from").value;
			var id =  document.getElementById("deal_id").value;
			var subject =  document.getElementById("subject").value;
			var body =  document.getElementById("body").value;
      var flag =  document.getElementById("flag").value;
			
			if(email.length<1)
			{
				this.msgobj.innerHTML = "<span>Please enter to email id</span>";
				document.getElementById("to").focus();
				this.msgobj.className = "Error";
			}
			else if(!validator.validEmail(email)){
				this.msgobj.innerHTML = "<span>Please enter valid to email id</span>";
				document.getElementById("to").focus();
				this.msgobj.className = "Error";
			}
			else if(from.length<1)
			{
				this.msgobj.innerHTML = "<span>Please enter from email id</span>";
				document.getElementById("from").focus();
				this.msgobj.className = "Error";
			}
			else if(!validator.validEmail(from)){
				this.msgobj.innerHTML = "<span>Please enter valid from email id</span>";
				document.getElementById("from").focus();
				this.msgobj.className = "Error";
			}
			else{
				/*document.getElementById("email").disabled = "true";
				document.getElementById("password").disabled = "true";
				document.getElementById("btnSend").disabled = "true";
				document.getElementById("btnCancel").disabled = "true";
				*/this.msgobj.style.display = "none";
				var page = SITEROOT + "/emailto_JSON.php";
				ajax.sendrequest("POST", page, {email:email,from:from,id:id,subject:subject,body:body,flag:flag}, 'et.callBackSendDetails', '');
            
			}
		}
		this.onEnter=function(e){
			var charCode;	charCode = e.keyCode ;	if (charCode == 13) this.checkEmailTo();
		}

		this.callBackSendDetails = function (data) {
			if(data.success > 0) {
				document.getElementById("to").disabled = "";
				document.getElementById("from").disabled = "";
				document.getElementById("subject").disabled = "";
				document.getElementById("body").disabled = "";
				document.getElementById("btnSend").disabled = "";
				document.getElementById("btnCancel").disabled = "";
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

	var et = new EmailTo();

	function openEmailTo(){
			jQuery.facebox({ajax:SITEROOT + '/emailto.php?flag=1'});
	}