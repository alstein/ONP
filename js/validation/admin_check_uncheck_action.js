function change(chk){
	var $tr = $(chk).parent().parent();
	if($tr.attr('id')){
		if($tr.attr('class')=='selectedrow' && !chk.checked)
			$tr.removeClass('selectedrow').addClass('grayback');
		else
			$tr.removeClass('grayback').addClass('selectedrow');
	}
}

	$(document).ready(function(){
		$("#checkall").click(function(){
			var checked_status = this.checked;
			$("input[@type=checkbox]").each(function(){
				this.checked = checked_status;
				change(this);
			});
 		});

		$("input[@type=checkbox]").click(function(){
			change(this);
 		});

		var flag = false;
		$("#" + thisFormName).submit(function(){
			if($("#action").attr('value')==''){
				$("#acterr").text("Please Select Action.").show().fadeOut(3000);
				return false;
			}
			$("input[@type=checkbox]").each(function(){
				var $tr = $(this).parent().parent();
				if($tr.attr('id'))
					if(this.checked == true)
						flag = true;
			});

			if (flag == false) {
				$("#acterr").text("Please Select Checkbox.").show().fadeOut(3000);
				return false;
			}
			if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action?'))
				return true;
			else
				return false;
    });
	$("#msg").fadeOut(5000);
});

	function uncheckMainCheckbox(){
		document.getElementById('checkall').checked = false;
	}