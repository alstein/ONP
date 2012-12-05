$(function(){
	// bind a click event to the "Add" link
	$('#addnew').click(function(){
			//alert(newRowNum);
			if(cnt < 9)
			{
				var newRow = $('#myrows_' + newRowNum).clone(true).insertAfter("#myrows_" + newRowNum);
				//alert(newRow);
				$('input', newRow).val('');
				newRowNum += 1;
				//document.getElementById('newRowcount').value = parseInt(newRowNum);
			
					//	add new id to newly created tr
				$(newRow).attr('id','myrows_' + newRowNum);
			//		document.getElementById('myrows_' + newRowNum).style.display = "";
			
					// insert a remove link in the last cell
		//			$('td:last-child', newRow).html('<a href="" class="remove"  id="frmAction" ><strong>Delete</strong><\/a>');
				var delid = "'myrows_" + newRowNum+"'";
				$('td:last-child', newRow).html('<a href="" class="remove"  id="frmAction" ><strong>Delete</strong><\/a>');
				//	add new id
				$('#myrows_' + newRowNum + " .input_c").attr('id','heighlight_' + newRowNum);
				cnt++;
			}
			else
			{
				alert("you can not add more than 10");
				return false;
			}
			

		//document.getElementById('label_count').innerHTML = "<label style='text-transform: none;'>Total Initiative(s) :</label> "+document.getElementById('count').value;
		// add the remove function to the new row
				$('a.remove', newRow).click(function(){
					if(confirm('Are you sure you want to delete?'))
					{
						newRowNum--;
						cnt--;
						/*if(document.getElementById('count').value == 1)
						{
							newRowNum1 -= 1;
						}
						else
						{
							
						}
						*///alert(newRowNum);
						///document.getElementById('newRowcount').value = newRowNum;
						$(this).parent().parent().remove();
						//document.getElementById('label_count').innerHTML = "<label style='text-transform: none;'>Total Initiative(s) :</label> "+document.getElementById('count').value;
						return false;
					}else{
						return false;
					}
		});
	});
	$('a.remove').click(function(){
					if(confirm('Are you sure you want to delete?'))
					{
						newRowNum--;
						cnt--;
						/*if(document.getElementById('count').value == 1)
						{
							newRowNum1 -= 1;
						}
						else
						{
							
						}
						*///alert(newRowNum);
						///document.getElementById('newRowcount').value = newRowNum;
						$(this).parent().parent().remove();
						//document.getElementById('label_count').innerHTML = "<label style='text-transform: none;'>Total Initiative(s) :</label> "+document.getElementById('count').value;
						return false;
					}else{
						return false;
					}
		});
});