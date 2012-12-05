<?php
/**
 * Logiciel : exemple d'utilisation de HTML2PDF
 * 
 * Convertisseur HTML => PDF, utilise fpdf de Olivier PLATHEY 
 * Distribu� sous la licence GPL. 
 *
 * @author		Laurent MINGUET <webmaster@spipu.net>
 */
    ob_start();
 	include(dirname(__FILE__).'/res/exemple07a.php');
 	//include(dirname(__FILE__).'/res/exemple07b.php');
	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
	$html2pdf = new HTML2PDF('P', 'A4', 'fr');
	
//	Permet de proteger le document � l'ouverture avec le mot de passe "spipu", seul l'impression est autoris�e 
//	$html2pdf->pdf->SetProtection(array('print'), 'spipu');
//echo isset($_GET['vuehtml']);exit;
    $html2pdf->WriteHTML($content,$_GET['vuehtml']);
	$html2pdf->Output('exemple07.pdf');
