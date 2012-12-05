$(document).ready(function()
{
	$("#checkall").click(function()
    {
		var checked_status = this.checked;
		$("input[@type=checkbox]").each(function()
		{
			this.checked = checked_status;
			change(this);	
		});
 	});
	$("input[@type=checkbox]").click(function()
 	{
		change(this);
 	});
$("input[@type=checkbox]").click(function()
 	{
		var i=0;
		var flag=0;
		var checked_status = this.checked;
		$("input[@type=checkbox]").each(function()
		{
			i++;
			if(this.checked && i!=1)
			{
			flag++;
			}
			else if(i!=1)
			{
			flag--;
			}
		});
		if(flag==(i-1))
		{
			$("#checkall").attr('checked',true);
		}
		else
		{
			$("#checkall").attr('checked',false);
		}
		change(this);
 	});
	function change(chk)
	{
		var $tr = $(chk).parent().parent();
		if($tr.attr('id'))
		{
			if($tr.attr('class')=='selectedrow' && !chk.checked)
				$tr.removeClass('selectedrow').addClass('grayback');
			else
				$tr.removeClass('grayback').addClass('selectedrow');
		}
	}
	var flag = false;
	$("#frmAction").submit(function(){
		
		if($("#action").attr('value')=='')
		{
			$("#acterr").text("Select action").show().fadeOut(3000);
			return false;
		}
		$("input[@type=checkbox]").each(function()
		{
			var $tr = $(this).parent().parent();
			if($tr.attr('id'))
				if(this.checked == true)
					flag = true;
		});

		var alen = $("input[id=deal_id]:checked").length;
		if(alen<=0)
			flag=false;


		if (flag == false) {
			$("#acterr").text("Select record").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action ?'))
			return true;
		else
			return false;
    });
    $("#msg").fadeOut(5000);
});

	function changeit(val)
	{
		location.href=SITEROOT+"admin/user/users_list.php?usertypeid="+val;
		return false;
	}


function updatestatus(id,act){
    //alert(id);
		if(confirm('Are you sure to perform "'+act+'" action ?'))
		{
			window.location = "users_list.php?user_id1="+id;
			return true;
		}
		else
		{
			return false;
		}	
    
}
function updatestatus_active(id,act){
    //alert(id);
	if(confirm('Are you sure to perform "'+act+'" action ?'))
		{
			window.location = "users_list.php?user_id2="+id;
			return true;
		}
		else
		{
			return false;
		}		
    
}
function getCity(val){
	//alert(val);
        ajax.sendrequest("GET", SITEROOT+"/admin/user/get_city.php", {val:val}, '', 'replace');
}
