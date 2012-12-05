 <!--/////// function to validate the dynamically generated highlights ////// created by nilesh pangul 11/10/2010////////-->

function chkHighlights(highname,highid) /// created by nilesh pangul //////////////////
{
	var flag=true;
	var htele=document.forms[0].elements[highname];
	var len=htele.length;
        if(htele.value=="")
       {
	return 'heighlight_0';
       }
	for(var i=0;i<len;i++)
	{
		if(!htele[i].value)
		{
                var high=highid+i;
		flag=false;
		break;
		}
		
	}
       if(flag==false)
	{
	return high;
	}
     return "alldatafill";
}
