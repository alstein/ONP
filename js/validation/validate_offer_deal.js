function addDays(myDate,days) {
return new Date(myDate.getTime() + days*24*60*60*1000);
}


/*
 * Date Format 1.2.3
 * (c) 2007-2009 Steven Levithan <stevenlevithan.com>
 * MIT license
 *
 * Includes enhancements by Scott Trenda <scott.trenda.net>
 * and Kris Kowal <cixar.com/~kris.kowal/>
 *
 * Accepts a date, a mask, or a date and a mask.
 * Returns a formatted version of the given date.
 * The date defaults to the current date/time.
 * The mask defaults to dateFormat.masks.default.
 */

var dateFormat = function () {
	var	token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
		timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
		timezoneClip = /[^-+\dA-Z]/g,
		pad = function (val, len) {
			val = String(val);
			len = len || 2;
			while (val.length < len) val = "0" + val;
			return val;
		};

	// Regexes and supporting functions are cached through closure
	return function (date, mask, utc) {
		var dF = dateFormat;

		// You can't provide utc if you skip other args (use the "UTC:" mask prefix)
		if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
			mask = date;
			date = undefined;
		}

		// Passing date through Date applies Date.parse, if necessary
		date = date ? new Date(date) : new Date;
		if (isNaN(date)) throw SyntaxError("invalid date");

		mask = String(dF.masks[mask] || mask || dF.masks["default"]);

		// Allow setting the utc argument via the mask
		if (mask.slice(0, 4) == "UTC:") {
			mask = mask.slice(4);
			utc = true;
		}

		var	_ = utc ? "getUTC" : "get",
			d = date[_ + "Date"](),
			D = date[_ + "Day"](),
			m = date[_ + "Month"](),
			y = date[_ + "FullYear"](),
			H = date[_ + "Hours"](),
			M = date[_ + "Minutes"](),
			s = date[_ + "Seconds"](),
			L = date[_ + "Milliseconds"](),
			o = utc ? 0 : date.getTimezoneOffset(),
			flags = {
				d:    d,
				dd:   pad(d),
				ddd:  dF.i18n.dayNames[D],
				dddd: dF.i18n.dayNames[D + 7],
				m:    m + 1,
				mm:   pad(m + 1),
				mmm:  dF.i18n.monthNames[m],
				mmmm: dF.i18n.monthNames[m + 12],
				yy:   String(y).slice(2),
				yyyy: y,
				h:    H % 12 || 12,
				hh:   pad(H % 12 || 12),
				H:    H,
				HH:   pad(H),
				M:    M,
				MM:   pad(M),
				s:    s,
				ss:   pad(s),
				l:    pad(L, 3),
				L:    pad(L > 99 ? Math.round(L / 10) : L),
				t:    H < 12 ? "a"  : "p",
				tt:   H < 12 ? "am" : "pm",
				T:    H < 12 ? "A"  : "P",
				TT:   H < 12 ? "AM" : "PM",
				Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
				o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
				S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
			};

		return mask.replace(token, function ($0) {
			return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
		});
	};
}();

// Some common format strings
dateFormat.masks = {
	"default":      "ddd mmm dd yyyy HH:MM:ss",
	shortDate:      "m/d/yy",
	mediumDate:     "mmm d, yyyy",
	longDate:       "mmmm d, yyyy",
	fullDate:       "dddd, mmmm d, yyyy",
	shortTime:      "h:MM TT",
	mediumTime:     "h:MM:ss TT",
	longTime:       "h:MM:ss TT Z",
	isoDate:        "yyyy-mm-dd",
	isoTime:        "HH:MM:ss",
	isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
	isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
};

// Internationalization strings
dateFormat.i18n = {
	dayNames: [
		"Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
		"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
	],
	monthNames: [
		"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
		"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
	]
};

// For convenience...
Date.prototype.format = function (mask, utc) {
	return dateFormat(this, mask, utc);
};

















$.validator.addMethod("redeem_period", function(value, element) {
	var redeem_from=$("#redeem_from1").val().split("-"); 
	var redeem_to=$("#redeem_to").val().split("-");
	var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
	var redeem_from_date = new Date(redeem_from[0],redeem_from[1],redeem_from[2]);
	var redeem_to_date = new Date(redeem_to[0],redeem_to[1],redeem_to[2]);
	var diffDays = ((redeem_to_date.getTime() - redeem_from_date.getTime())/(oneDay));	

	//var todays_date=$("#todays_date").val().split("-");;
	var todays_date=$("#redeem_from1").val().split("-");;
	var chk_todays_date = new Date(todays_date[0],todays_date[1],todays_date[2]); 
	var rto_date = new Date(redeem_to[0],redeem_to[1],redeem_to[2]); 
	var rto_diffDays = ((rto_date.getTime() - chk_todays_date.getTime())/(oneDay));
//alert(rto_diffDays);

	if((diffDays>30 || diffDays<=0)){
			//alert("1");
			return false;
	}else {
			//alert("2");
			return true;
	}	
}, "Redeem period should be less than 1 month.<br />Redeem To date should be greater than From date<br />Redeem to date should be greater than current date.");


$.validator.addMethod("minimum_offer_amt", function(value, element) {

	if(parseFloat($("#amt_spend").val()) < parseFloat($("#temp_amount").val())){
			//alert("3");
			return false;
	}else {
			//alert("4");
			return true;
	}	
}, "Amount should be greater than minimum offer amount");


$.validator.addMethod("bid_val_date", function(value, element) {

var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
var bid_validity=$("#bid_validity").val().split("-");;
var todays_date=$("#todays_date").val().split("-");;

var bid_validity_date = new Date(bid_validity[0],bid_validity[1],bid_validity[2]); 
var chk_todays_date = new Date(todays_date[0],todays_date[1],todays_date[2]); 
var bid_diffDays = ((bid_validity_date.getTime() - chk_todays_date.getTime())/(oneDay));
//alert(bid_diffDays);
	if(bid_diffDays>3 || bid_diffDays<0){
			//alert("5");
			return false;
	}else {
			//alert("6");
			return true;
	}	
}, "Bid Validity date should be max 3 days from current date.");




$.validator.addMethod("redeem_from_date", function(value, element) {

var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
var bid_validity=$("#redeem_from").val().split("-");;
var todays_date=$("#todays_date").val().split("-");;

var bid_validity_date = new Date(bid_validity[0],bid_validity[1],bid_validity[2]); 
var chk_todays_date = new Date(todays_date[0],todays_date[1],todays_date[2]); 
var bid_diffDays = ((bid_validity_date.getTime() - chk_todays_date.getTime())/(oneDay));

	var d=new Date($("#redeem_from").val());
	
	var d1=addDays(new Date($("#redeem_from").val()),-2);
	
	var d1=dateFormat(d1, "d-m-yyyy h:MM:ss");
	
	$("#bid_validity1").val(d1);

	$("#temobvald").val(d1);
	
	
	var datemessage=$("#datemessage").val();


	if(bid_diffDays>2 && bid_diffDays<18){
			//alert("5");
			return true;
	}else {
			//alert("6");
			return false;
	}	
},"Please choose date between above mentioned date");


$.validator.addMethod("redeem_to_date", function(value, element) {

var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
var bid_validity=$("#redeem_to").val().split("-");;
var todays_date=$("#redeem_from").val().split("-");;

//var todays_date=$("#todays_date").val().split("-");;

var bid_validity_date = new Date(bid_validity[0],bid_validity[1],bid_validity[2]); 
var chk_todays_date = new Date(todays_date[0],todays_date[1],todays_date[2]); 
var bid_diffDays = ((bid_validity_date.getTime() - chk_todays_date.getTime())/(oneDay));
//alert(bid_diffDays);
	if(bid_diffDays<0){
			//alert("5");
			return false;
	}else {
			
			//alert("6");
			return true;
	}	
}, "Redeem to date should be greater Reddem from date");



$(document).ready(function() {

	$('#frmdeal').validate({
		    errorElement:'div',
		    rules: {

						amt_spend:{
								required: function(){
									if($("#temp_min_offer_amt").val()=='yes')
										return true;
									else
										return false;
								},
								number:true,
								minimum_offer_amt:function(){
									if($("#temp_min_offer_amt").val()=='yes')
										return true;
									else
										return false;
								}
							},
						discount:{
								required: true,
								number : true
							},
						netamount:{
								//required: true,
								number : true
						},
						redeemflag:{
								required: true
						},
	
						redeem_from:{
								required: true,
								redeem_from_date:function(){
										var redeemflag=$('input[name=redeemflag]:checked').val(); //alert(redeemflag);
										if((redeemflag=="redeemon" || redeemflag=="redeembet") && (redeemflag!="undefined" && redeemflag!="redeembet")){ //alert("first");
											return true;
										}else if(redeemflag=="undefined"){ alert("second");
											return false;
										}
								}
							},
							redeem_from1:{
								required: function(){
										var redeemflag=$('input[name=redeemflag]:checked').val(); //alert(redeemflag);
										if((redeemflag=="redeembet") && redeemflag!="undefined"){ //alert("first");
											return true;
										}else if(redeemflag=="undefined"){ //alert("second");
											return false;
										}
								}
							},
						redeem_to:{
								required: true,
								redeem_period:function(){
										var redeemflag=$('input[name=redeemflag]:checked').val(); //alert(redeemflag);
										if((redeemflag=="redeembet") && redeemflag!="undefined"){ //alert("first");
											return true;
										}else if(redeemflag=="undefined"){ //alert("second");
											return false;
										}
								}
							},
						amt_to_pay:{
								required: true,
								number : true
						},	
						bid_validity:{
								required: true,
								bid_val_date:true		
							},
						accepted_to_paid:{
								required: true,
								number : true
							},
						terms:{
								required: true
						}
		    },
		    messages: {

						amt_spend:{
							required: "Please enter the amount to be spend."
						
						},
						discount:{
							required: "Please select the discount ."
						
						},
						netamount:{
							required: "Please enter the Net ammount to be spend."
						},
						redeemflag:{
							required: "Please select I would like to."
						},
						redeem_from:{
							required: "Please enter the redeem from."
						
						},
						redeem_to:{
							required: "Please enter the redeem to."
						
						},
						amt_to_pay:{
							required: "Please enter the Amount to pay now."
						},
						bid_validity:{
							required: "Please enter bid valid till."
						
						},
						accepted_to_paid:{
							required: "Please enter the amount Amount to pay merchant."
						},
						terms:{
							required: "Please accept terms and conditions."
						}
		},
		success: function(label) {
						label.hide();
		}
    });

});
