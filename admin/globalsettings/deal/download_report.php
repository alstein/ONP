<?php
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

$msobj= new message();
$smarty->assign("msobj",$msobj);

if(!$_SESSION['duAdmId'])
	{
		header("location:".SITEROOT . "/admin/login/_welcome.php");
	}




function get_user_from_id($usr_id)
{
	$dbObj = new DBTransact();
	$users_rs = $dbObj->gj("tbl_users as u", "username, first_name, last_name, email, city" , "userid={$usr_id}", "", "", "", "", "");
	$users_row = @mysql_fetch_assoc($users_rs);

return $users_row;
}

function get_user_from_email($usr_emailid)
{
	$dbObj = new DBTransact();
	$users_rs = $dbObj->gj("tbl_users as u", "username, first_name, last_name, email, city" , "email='{$usr_emailid}'", "", "", "", "", "");
	$users_row = @mysql_fetch_assoc($users_rs);

return $users_row;
}


$deal_t_rs = $dbObj->customqry("select deal_id,max(`deal_end_date`) as end_date
from tbl_deal
where deal_on != '0000-00-00 00:00:00'
group by product_id
order by `deal_end_date` desc","");

while($deal_t_res=@mysql_fetch_array($deal_t_rs))
{
    $deal_t_arr[] = $deal_t_res; 
}


$t=0;




if($_GET['view'] == 'excel')
{

      $sf = "dpu.*, dp.*, p.product_disc_price, p.product_name";
      $tbl = "tbl_deal_payment_unique as dpu, tbl_deal_payment as dp, tbl_deal as p";
      
      $cnd = "dpu.deal_id = {$_GET['prod_deal_id']} and dp.pay_id = dpu.pay_id and dpu.deal_id = p. product_id ";
      
      $rs = $dbObj->gj($tbl, $sf , $cnd, "", "", "", $l, "");
      
      if($rs != "n")
      {
          $out = '';
          $out = $_GET['deal_title'];
          $out .="\n";
          $out .= 'Name,Email,Barcode Id,Price,Payment,Date';
          $out .="\n";
          
          
          $i=0;
          while($row = @mysql_fetch_assoc($rs))
          {
                  $deal_arr[$i] = $row;
          
                  $user_arr = get_user_from_id($row['user_id']);
                  $full_name = $user_arr['first_name']." ".$user_arr['last_name'];
          
                  $out .= '"'.$full_name.'","'.$user_arr["email"].'","'.$row["barcode_id"].'","'.$row['product_disc_price'].'","'.$row["payment_done"].'","'.date('d M Y',$row["order_date"]).'"';
                  $out .= "\n";

          $i++;
          }
          
          header("Content-type: text/x-csv");
          header("Content-type: application/csv");
          header("Content-Disposition: attachment; filename=deal".time().".csv");
          
          echo $out;
          exit;
      }
}
else if($_GET['view'] == 'pdf')
{

  ob_start();
		include_once('../../../includes/pdf_generate/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P', 'A4', 'fr');


      $sf = "dpu.*, dp.*, p.product_disc_price, p.product_name";
      $tbl = "tbl_deal_payment_unique as dpu, tbl_deal_payment as dp, tbl_deal as p";
      $cnd = "dpu.deal_id = {$_GET['prod_deal_id']} and dp.pay_id = dpu.pay_id and dpu.deal_id = p. product_id ";
      $rs = $dbObj->gj($tbl, $sf , $cnd, "", "", "", $l, "");

		// get total deals sold
		$re = $dbObj->cgs("tbl_deal_payment_unique","count(*) as cnt","deal_id",$_GET['prod_deal_id'],"","","");
		$row1 = @mysql_fetch_assoc($re);

		// get deal discount price
		$re11 = $dbObj->cgs("tbl_deal","product_disc_price","product_id",$_GET['prod_deal_id'],"","","");
		$row11 = @mysql_fetch_assoc($re11);

		// get deal expire date
		$re12 = $dbObj->cgs("tbl_deal","deal_end_date","product_id",$_GET['prod_deal_id'],"deal_end_date desc","","");
		$row12 = @mysql_fetch_assoc($re12);

		$documents = str_replace("&ldquo;",'"',$documents);
		$documents = str_replace("&rdquo;",'"',$documents);
		$documents = str_replace("&nbsp;"," ",$documents);
		$documents = html_entity_decode($documents);

		//-------------------------

		$docs="";
		$docs .= "<style type='text/css'>
				<!--
						table {vertical-align:top;}
						tr {vertical-align:top;}
						td {vertical-align:top;}
				-->
					</style>";
		$docs .= "<table width='100%' cellspacing='0' cellpadding='0' align='right'>
						<tr>
							<td width='70%'>&nbsp;</td>
							<td width='30%' style='color: #A9D82D; font-size: 30px'>{$_GET['deal_title']}</td>
						</tr>
					</table>";
	
		$docs .= "<table width='500px' cellspacing='0' cellpadding='0' style='padding:10px'>
						<tr>
							<td width='200px' align='right' height='30px'><font style='font-size: 15px; font-weight:bold'>Total Orders :</font> </td>
							<td width='300px' align='left'>{$row1['cnt']}</td>
						</tr>
						<tr>
							<td width='200px' align='right' height='30px'><font style='font-size: 15px; font-weight:bold'>Amount per deal :</font> </td>
							<td width='300px' align='left'>{$row11['product_disc_price']}</td>
						</tr>
						<tr>
							<td width='200px' align='right' height='30px'><font style='font-size: 15px; font-weight:bold'>Date Expires : </font></td>
							<td width='300px' align='left'>".date("M d, Y",strtotime($row12['deal_end_date']))."</td>
						</tr></table>";
				$docs .= "<table width='1000px' cellspacing='0' cellpadding='0' style='padding:10px'>
					<tr>
				        <td colspan='2' style='color: #444444; font-size: 18px' align='center'>
                      <table width='900px' class='report' cellspacing='0' cellpadding='0' style='border:1px solid #000'>
								<tr>
									<th align='center' width='300px' style='border-bottom:1px solid #000;border-right:1px solid #000;padding-left:70px;padding-right:70px;'>Name</th>
									<th align='center' width='300px' style='border-bottom:1px solid #000;border-right:1px solid #000;padding-left:70px;padding-right:70px;'>Coupon Number</th> 
									<th align='center' width='300px' style='border-bottom:1px solid #000;padding-left:70px;padding-right:70px;'>Barcode Id</th> 
								</tr>";

              $i=0;
              while($row = @mysql_fetch_assoc($rs))
              {
						$k = $i+1;
                      $deal_arr[$i] = $row;
              
                      $user_arr = get_user_from_id($row['user_id']);
                      $full_name = $user_arr['first_name']." ".$user_arr['last_name'];

                      $docs .= "  <tr>
                                  <td width='300px' align='center' style='border-bottom:1px solid #000;border-right:1px solid #000'>{$full_name}</td> 
                                  <td width='300px' align='center' style='border-bottom:1px solid #000;border-right:1px solid #000'>{$row['coupn_id']}</td> 
                                  <td width='300px' align='center' style='border-bottom:1px solid #000'>{$row['bar_code']}</td> 
                                </tr>";

                   $i++;
              }
				    $docs .=  "</table>
					</td>
				</tr>
			</table>";
//  		echo $docs; exit;

		$html2pdf->WriteHTML($docs,0);
		$html2pdf->Output(time().'.pdf');
		exit;
}	
$dbObj->Close();
?>
