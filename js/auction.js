	/*
		for product view page 
	*/
	function changeSound(path){
		if(document.getElementById("bidleaderssound").src == path + "soundon.png"){
			document.getElementById("bidleaderssound").src = path + "soundoff.png";
		}else if(document.getElementById("bidleaderssound").src==path + "soundoff.png"){
			document.getElementById("bidleaderssound").src = path + "soundon.png";
		}
	}

	function bidButtonInsertAfter(pid){
		$('#btnBid_' + pid).insertAfter('#foo');
	}


	function showBidPriceInDecimal(pid,value){
		if(value.length > 0){
			var v = (value);
			var val = (v/100);
			document.getElementById(pid).innerHTML = "($"+ val.toFixed(2) +")";
		}else{
			document.getElementById(pid).innerHTML = "($0.00)";
		}
	}

	function isNumberKey(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}

	function imposeMaxLength(Event, Object, MaxLen){
		var charCode = (Event.which) ? Event.which : event.keyCode
		if((Event.keyCode == 8 ||Event.keyCode==46)){ return true; }
		if(Object.value.length >= MaxLen) { return false; }
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}

	function productInformation(pid){
		jQuery.facebox({ajax:SITEROOT + '/ajax/productinformation/' + pid});
	}

	function auctiontimer(){
		var product_id = "";
		var product_close_date = "";

		this.serverTime = function() {
			var time = null;
			if(document.getElementById("dummytimespan"))
				time = new Date(document.getElementById("dummytimespan").innerHTML);
			return time;
		},

		this.calcTime = function(offset) {
			// create Date object for current location
			d = new Date();
			// convert to msec
			// add local time zone offset
			// get UTC time in msec
			utc = d.getTime() + (d.getTimezoneOffset() * 60000);
			// create new Date object for different city
			// using supplied offset
			nd = new Date(utc + (3600000*offset));
			return nd;
		},
	
		this.watchCountdown = function(periods) {
			var nHour = periods[4];
			var nMin = periods[5];
			var nSec = periods[6];
			//console.log(auction.calcTime("-4"));

			var pid = this.className;
			pid = pid.split(" ");
			pid = pid[0];
			pid = pid.split("_");
			pid = pid[1];

			if(!document.getElementById("bidtoclosing_" + pid)){
				if(nHour == 0 && nMin == 10 && nSec < 1){
					window.location.reload();
				}
			}

			if(nHour == 0 && nMin == 0 && nSec < 1){
				
				if(!document.getElementById("bidtoclosing_" + pid)){
						$.post(SITEROOT + '/ajax/closeauction/',{pid:pid},function(data){
							if(data.success == 1){
								if(document.getElementById("bid_" + pid)){
									$('#bid_' + pid).html("<span class='cong'>Congrarulation " + data.winnername + "!</span>");
									//	change the bottom to View your bids status
									$('#end-new_' + pid).hide();
									$('#end2_' + pid).show();
								}else{
									window.location.reload();
								}

								$('.countdown_' + pid).countdown('pause');
								$('.countdown_' + pid).html('--:--:--');
							}
						window.location.reload();
						},'json');
				}else{
					var resettime = this.id;
					var resettime = resettime.split(",");
	
					$('.countdown_' + pid).html('--:--:--');
					$.post(SITEROOT + '/ajax/servertime','',function(data){
						currentDate = new Date(data.Y,data.m,data.d,data.h,data.i,data.s);
						document.getElementById("dummytimespan").innerHTML = currentDate;

						currentDate.setDate(currentDate.getDate() + parseInt(resettime[0]));
						currentDate.setHours(currentDate.getHours() + parseInt(resettime[1]));
						currentDate.setMinutes(currentDate.getMinutes() + parseInt(resettime[2]));
						currentDate.setSeconds(currentDate.getSeconds() + parseInt(resettime[3]));
			
						var shortly = currentDate;
		
						$('.countdown_' + pid).countdown('change', {until: shortly,serverSync:auction.serverTime,compact: true,format: 'HMS',onTick:auction.watchCountdown});
						$('.countdown_' + pid).highlightFade('yellow');
					},'json');
				}
			}
		}
	}
	var auction = new auctiontimer();

	/*
		when admin update any product info then refresh the page
	*/

// 	$(document).ready(function(){
// 		checkIsSiteRefresh();
// 		displayAlerts();
// 	});
	
// 	function checkIsSiteRefresh(){
// 		ajax.sendrequest( "POST", SITEROOT + "/ajax/checkissiterefresh/", '', 'isCheckIsSiteRefresh', '' );
// 	}
// 
// 	function isCheckIsSiteRefresh(data){
// 		if(data.isSiteRefresh > 0){
// 			window.location.reload();
// 		}
// 		var t = setTimeout("checkIsSiteRefresh();",5000);
// 	}	
// 	
	function displayAlerts(){
		if(document.getElementById("MyAuctionsAlerts")){
			$.post(SITEROOT + '/products/myauctionsalerts','',function(data){
				$('#MyAuctionsAlerts').html(data);
			},'html');
		}
		var t = setTimeout("displayAlerts();",10000);
	}