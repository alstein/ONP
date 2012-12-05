function ajaxPaging(qlink,param,div_id)
{
	$(document).ready(function() {
		$("#"+div_id).html("<img src='"+SITEROOT+"/templates/default/images/site/coming_soon/loadingAnimation.gif' align='center' style='margin-left:50px;'/>");
		$.get(qlink,param,function(data){ $("#"+div_id).html(data);});
	});
}