function checkAll(field)
	{
		
		if(document.frm_add_to.maincheck.checked==true)
		{
			for(j=0;j<document.frm_add_to.menucheck.length;j++)
			{
				document.frm_add_to.menucheck[j].checked=true;
			}
		}
		else
		{
			for(j=0;j<document.frm_add_to.menucheck.length;j++)
			{
				document.frm_add_to.menucheck[j].checked=false;
			}
		}
	}
	
	function add_checked(field)
	{
		var checkmenu =document.frm_add_to.menucheck;
		var str="";
		var i=0;
		
		for(i=0;i<document.frm_add_to.menucheck.length;i++)
		{
			if(checkmenu[i].checked==true)
				str = str + checkmenu[i].value + ",";
		}
		remstring = str.substring(0,str.length-1);


		if(window.opener.document.frm_send_news.to.value!="")
		 {  
		 window.opener.document.frm_send_news.to.value +="," + remstring; }
		else
		{
		window.opener.document.frm_send_news.to.value = remstring; 
		}
		window.close();
	}