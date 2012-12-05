opera_nav = (navigator.userAgent.indexOf('Opera') != -1) ? true : false;
ie_nav = (navigator.userAgent.indexOf('MSIE') != -1 && !opera_nav) ? true : false;
mozilla_nav = (navigator.userAgent.indexOf('Gecko') != -1) ? true : false;

	//attachEvent(document.getElementById("button"), "onclick", "helloWorld()");

function MyIndicator(){
	var mainDiv = document.createElement('div');
	this.mainDiv = mainDiv;
	this.mainDiv.setAttribute('id',"indicatorMain");
	
	var imageDiv = document.createElement('div');
	this.imageDiv = imageDiv;
	this.imageDiv.setAttribute('id',"indicatorImage");
	this.mainDiv.appendChild(this.imageDiv);

	var textDiv = document.createElement('div');
	this.textDiv = textDiv;
	this.textDiv.setAttribute('id',"indicatorText");
	this.textDiv.innerHTML = "Please wait...";
	this.mainDiv.appendChild(this.textDiv);
	return this.mainDiv;
}


function AJAX () {

	
	/*
	********************************************************
	CONVERT PARAMETERS IN A QUERY STRING
	********************************************************
	*/
	this.convertParams = function (hash) {
        var res = [];
        for(k in hash) {
            res.push(k + "=" + encodeURIComponent(hash[k]));
        }
        return res.join("&");		
	} // end this.convertParams = function ()
	
	
	
	this.showIndicator = "";
	
	
	
	/*
	********************************************************
	SEND REQUEST AND GET RESPONSE TEXT
	********************************************************
	*/	
	this.sendrequest = function (method, page, param, callBack, div) {
		//Display ajax indicator
		if(document.getElementById(div) && div.length > 0){
			document.getElementById(div).appendChild(MyIndicator());	
		}
		if(document.getElementById(this.showIndicator)){
			document.getElementById(this.showIndicator).appendChild(MyIndicator());	
		}
		
		var isLoading = this.isLoading;
		//method = 'GET';
		ajaxx = new AJAXObject();
		//var randomnumber=Math.floor(Math.random()*11)
		var req = ajaxx.AjaxObject();
		
	  	if(method == 'POST') {
			req.open('POST', page , true);
			req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8;');
			req.send(this.convertParams(param));
		}else{
			req.open("GET", page + '?' + this.convertParams(param) , true);
			req.send(null);
		}

		req.onreadystatechange = function(){
			//alert(req.responseText);
			if (req.readyState == 4 && req.status == 200){
				this.showIndicator = "";
				if(callBack.length > 0) {
					var json = req.responseText.substring(req.responseText.indexOf('{'),req.responseText.lastIndexOf('}')+1);
					eval(callBack+'(' + json + ')');
				}else{
					if(typeof(div) == 'object') {
						div.innerHTML = req.responseText;
					}else{
						if(div.length > 0 && typeof(div) != 'object') {
							if(document.getElementById(div))
								document.getElementById(div).innerHTML = req.responseText;
						}
					}
				}
			}
		}
		return req;
	};
	
	var keyStr;
	this.keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZ" + "abcdefghijklmnopqrstuvwxyz" + "0123456789+/="; // all numbers plus +/= 	

	this.base64_encode = function(inp){
		var out = ""; //This is the output
		var chr1, chr2, chr3 = ""; //These are the 3 bytes to be encoded
		var enc1, enc2, enc3, enc4 = ""; //These are the 4 encoded bytes
		var i = 0; //Position counter
		do { //Set up the loop here
		chr1 = inp.charCodeAt(i++); //Grab the first byte
		chr2 = inp.charCodeAt(i++); //Grab the second byte
		chr3 = inp.charCodeAt(i++); //Grab the third byte
		//Here is the actual base64 encode part.
		//There really is only one way to do it.
		enc1 = chr1 >> 2;
		enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
		enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
		enc4 = chr3 & 63;
		
		if (isNaN(chr2)) {
		enc3 = enc4 = 64;
		} else if (isNaN(chr3)) {
		enc4 = 64;
		}
		//Lets spit out the 4 encoded bytes
		out = out + this.keyStr.charAt(enc1) + this.keyStr.charAt(enc2) + this.keyStr.charAt(enc3) +
		this.keyStr.charAt(enc4);
		// OK, now clean out the variables used.
		chr1 = chr2 = chr3 = "";
		enc1 = enc2 = enc3 = enc4 = "";
		} while (i < inp.length); //And finish off the loop
		//Now return the encoded values.
		return out;
	};
		
	//Heres the decode function
	this.base64_decode = function(inp){
		var out = ""; //This is the output
		var chr1, chr2, chr3 = ""; //These are the 3 decoded bytes
		var enc1, enc2, enc3, enc4 = ""; //These are the 4 bytes to be decoded
		var i = 0; //Position counter
		// remove all characters that are not A-Z, a-z, 0-9, +, /, or =
		var base64test = /[^A-Za-z0-9\+\/\=]/g;
		if (base64test.exec(inp)) { //Do some error checking
		alert("There were invalid base64 characters in the input text.\n" +
		"Valid base64 characters are A-Z, a-z, 0-9, ?+?, ?/?, and ?=?\n" +
		"Expect errors in decoding.");
		}
		inp = inp.replace(/[^A-Za-z0-9\+\/\=]/g, "");
		do { //Heres the decode loop.
		//Grab 4 bytes of encoded content.
		enc1 = this.keyStr.indexOf(inp.charAt(i++));
		enc2 = this.keyStr.indexOf(inp.charAt(i++));
		enc3 = this.keyStr.indexOf(inp.charAt(i++));
		enc4 = this.keyStr.indexOf(inp.charAt(i++));
		//Heres the decode part. Theres really only one way to do it.
		chr1 = (enc1 << 2) | (enc2 >> 4);
		chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
		chr3 = ((enc3 & 3) << 6) | enc4;
		//Start to output decoded content
		out = out + String.fromCharCode(chr1);
		if (enc3 != 64) {
		out = out + String.fromCharCode(chr2);
		}
		if (enc4 != 64) {
		out = out + String.fromCharCode(chr3);
		}
		//now clean out the variables used
		chr1 = chr2 = chr3 = "";
		enc1 = enc2 = enc3 = enc4 = "";
		} while (i < inp.length); //finish off the loop
		//Now return the decoded values.
		return out;
	};	
} //end function AJAX ()

var ajax = new AJAX();



//*******************************************************
//	CREATE AJAX OBJECT PROTOTYPE
//*******************************************************
AJAXObject = function()
{};

AJAXObject.prototype = {
	AjaxObject:function(){ 
		var xmlhttp;
		if(window.XMLHttpRequest){ 
			xmlhttp = new XMLHttpRequest(); 
		}else if (window.ActiveXObject){ 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
			if (!xmlhttp){ 
				xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
			} 
		} 
		return xmlhttp; 
	}
}
