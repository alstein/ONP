//call function to set subscription data
function callToSetSubsPackData(packId)
{
	if(packId > 0)
	{
		var pack_name = document.getElementById("pack_name_"+packId).value;
		var pack_price = document.getElementById("pack_price_"+packId).value;
		var pack_duration = document.getElementById("pack_duration_"+packId).value;
		
		document.frmregistration.elements["a3"].value = pack_price;
		document.frmregistration.elements["p3"].value = pack_duration;
		document.frmregistration.elements["item_number"].value = pack_name;
	}
}

/*
$("#frm").submit(function()
{
}
*/