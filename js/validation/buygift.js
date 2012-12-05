function savefrm()
{
    var to_name = document.getElementById('to').value;
    var from = document.getElementById('from').value;
    var message = document.getElementById('message').value;
    var emailid = document.getElementById('emailid').value;
    var deal_id = document.getElementById('deal_id').value;
    var div_err = document.getElementById('err_msg');

    
    if(to_name == "")
    {
        div_err.innerHTML = "<span style='color: #CC0033;'>Please enter receiver name</span>";
        document.getElementById("to").focus();
        div_err.className = "Error";
    }
    else if(from == ""){
        div_err.innerHTML = "<span style='color: #CC0033;'>Please enter sender name </span>";
        document.getElementById("from").focus();
        div_err.className = "Error";
    }
    else if(emailid == "")
    {
        div_err.innerHTML = "<span style='color:#CC0033;'>Please enter email id</span>";
        document.getElementById("emailid").focus();
        div_err.className = "Error";
    }
    else if(!checkEmail(emailid))
    {
        div_err.innerHTML = "<span style='color:#CC0033;'>Please enter valid email address.</span>";
        document.getElementById("emailid").focus();
        div_err.className = "Error";
    }
    else if(message == "")
    {
        div_err.innerHTML = "<span style='color:#CC0033;'>Please enter message.</span>";
        document.getElementById("message").focus();
        div_err.className = "Error";
    }
    else
    {
        div_err.style.display = "none";
        var page = SITEROOT + "/deal/gift-deal-save/";
        ajax.sendrequest("POST", page, {emailid:emailid,toname:to_name,deal_id:deal_id,from:from,msg:message}, 'callBackSendDetails', '');
        jQuery(document).trigger('close.facebox');
    }

}


function callBackSendDetails()
{
    document.getElementById('gift_suc_div').innerHTML = "Gift Saved Successfully.";
    document.getElementById('gift_suc_div').style.display = "block";
}

function checkEmail(inputvalue){	
    var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
    if(pattern.test(inputvalue)){         
		return true;   
    }else{   
		return false; 
    }
}
