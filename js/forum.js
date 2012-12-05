$(document).ready(function() {
	var validator = $("#frmForum").validate({
		errorElement:'div',
		rules: {
			title: {required:true, 
				maxlength:40	
				},
			description:{required:true,
				maxlength:200
				}		
		},
		messages: {
			title:{ 
				required: "Enter discussion title",
				maxlength:"Please enter only 40 characters"
			},
			description: {
				required: "Enter description",
				maxlength: "Please enter only 200 characters"				
			}
		},

		success: function(label) {
			label.hide();
		}
	});
	
	var validator = $("#frmThread").validate({
		errorElement:'div',
		rules: {
			title:{
				required:true,
				maxlength:200
			},			
			description:{
				required:true,
				maxlength:200
			}
		},
		messages: {
			title:{
				required: "Enter thread title",
				maxlength:"Please enter only 200 characters"
			    },
			description:
			{
				required:"Enter description",
				maxlength:"Please enter only 200 characters"
			}
		},

		success: function(label) {
			label.hide();
		}
	});
	
	var validator = $("#frmReply").validate({
		errorElement:'div',
		rules: {
			description:{
				required:true,
				maxlength:200
			}
		},
		messages: {
			description:
			{	
				required:"Enter description",
				maxlength:"Please enter only 200 characters"
			}
		},

		success: function(label) {
			label.hide();
		}
	});
	
});