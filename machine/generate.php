<?php

require_once('tcpdf_include.php');
require_once('number.php');
class MYPDF extends TCPDF
{

	//Page header


	// Page footer
	public function Footer()
	{
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number

		$this->Cell(0, 10, 'Faktura wygenerowana przez FAKTUROMATEK®', 0, false, 'L', 0, '', 0, false, 'T', 'M');

		$this->Cell(0, 10, 'Strona ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		$this->SetY(-20);
		$this->Cell(0, 10, '___________________________________________________________________________________________________________________', 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('AllChemia');
$pdf->SetTitle('Faktura Nr 190517');
$pdf->SetSubject('');
$pdf->SetKeywords('');

// set default header data
//$pdf->SetHeaderData();
//$pdf->setFooterData(array(0,64,0), array(0,64,128));
$pdf->setPrintHeader(false);
// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor/
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/pol.php')) {
	require_once(dirname(__FILE__) . '/lang/pol.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
//$pdf->SetFont('courier', '', 10, '');
$pdf->SetFont('dejavusans', '', 10);
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect

$nr_fak = $_POST['nr_fak'];
$data_wys = $_POST['data_wys'];
$miejsce = $_POST['miejsce'];
$data_wyk = $_POST['data_wyk'];

$sprzedawca = $_POST['sprzedawca'];
$sprze_adres = $_POST['sprze_adres'];
$sprze_nip = $_POST['sprze_nip'];
$nabywca = $_POST['nabywca'];
$nabywca_adres = $_POST['nabywca_adres'];
$nabywca_nip = $_POST['nabywca_nip'];

// Set some content to print

$html = '
<style>


table
{
	width:100%;
	font-size:3mm;
	
}
.top-table
{
	border:1px black solid;
	text-align:center;

}
.td1
{
	width:1cm;
}
.td2
{
	width:2cm;
}
.td6
{
	width:6cm;
}
.tab-min
{
	width:10%;
	border:1px solid black;
	text-align:right;
}
.text-right
{
	text-align:right;
}
</style>

<table>
<tr>
	<td colspan="2">' . $sprzedawca . '</td>
</tr>
<tr>
	<td>' . $sprze_adres . '</td><td>Telefon: 609-389-199</td>
</tr>
<tr>
<td>NIP: ' . $sprze_nip . '</td><td>E-mail: allchemia.kozminek@gmail.com</td>
</tr>
<tr>
<td>Regon: 383-098-580 </td><td>Konto: PKO SA NUMERKI</td>
</tr>
</table>
<hr>
';
$html .= '<div ></div><span style="font-size:6mm;width:100%;text-align:center;">Faktura nr ' . $nr_fak . "</span><div ></div>";
$html .= '<span style="font-size:4mm;text-align:left;">Data i miejsce wystawienia: ' . $data_wys . ', ' . $miejsce . '<br></span>';
$html .= '<span style="font-size:4mm;text-align:left;">Data dokonania dostawy lub wykonania usługi: ' . $data_wyk . '</span><br>';
$html .= '<br><table style=" border-spacing: 3mm;"><tr>
 <td><span style="font-size:5mm;text-align:center;">Sprzedawca:</span><br><div style="font-size:3.6mm;border:1px solid black;"> ' . $sprzedawca . '<br> ' . $sprze_adres . '<br> NIP: ' . $sprze_nip .

	'</div></td><td ><span style="font-size:5mm;text-align:center;">Nabywca:</span><br><div style="font-size:3.6mm;border:1px solid black;"> ' . $nabywca . '<br> ' . $nabywca_adres . '<br>' ;
	if($nabywca_nip!="")
	$html .=' NIP: '.$nabywca_nip;
	else
	$html .=' ';

	$html .='</div></td>
</tr>
</table>

';
$html .= '<table>';
$html .= '<tr>
<td class="top-table td1" >lp.</td><td class="top-table td6">Towar</td><td class="top-table td1">Ilość</td><td class="top-table td1">JM</td>
<td class="top-table td2">Cena <br>brutto</td><td class="top-table td2">Wartość netto</td><td class="top-table td1">VAT</td><td class="top-table td2">Kwota VAT </td><td class="top-table td2">Wartość Brutto</td>
</tr>';
$vat23 = 0;
$vat8 = 0;
$vat5 = 0;
$vat0 = 0;
$nr = 1;
$net23 = 0;
$net8 = 0;
$net5 = 0;
$net0 = 0;
$bru23 = 0;
$bru8 = 0;
$bru5 = 0;
$bru0 = 0;
$nr = 1;
for ($i = 1; $i <= $_POST['il_tow']; $i++) {

	if (isset($_POST['tw'][$i])) {
		if ($nr % 2 == 0)
			$html .= '<tr style="background-color:#D5D5D5;">';
		else
			$html .= '<tr>';
		$html .= '<td class="" >' . $nr . '</td>'; //numer
		$html .= '<td class="">' . $_POST['tw'][$i] . '</td>'; //towar	
		$html .= '<td class="text-right">' . $_POST['ilo'][$i] . '</td>'; //Ilość
		$html .= '<td class="text-right">' . $_POST['jm'][$i] . '</td>'; //Jednostka miary
		$vat = round($_POST['cena'][$i] * $_POST['vat'][$i] / 100,2);
		$cen_nn =round( $_POST['cena'][$i] - $vat,2);
		$war_net = round($cen_nn * $_POST['ilo'][$i],2);
		$war_bru =round( $_POST['cena'][$i] * $_POST['ilo'][$i],2);
		$html .= '<td class="text-right">' . $cen_nn . '</td>'; //Cena netto
		$html .= '<td class="text-right">' . $war_net . '</td>'; //Wartość Netto
		$html .= '<td class="text-right">' . $_POST['vat'][$i] . '</td>'; //Vat
		$html .= '<td class="text-right">' . $vat . '</td>'; //Kwota Vat
		$html .= '<td class="text-right">' . $war_bru . '</td>'; //Wartość brutto
		$html .= '</tr>';
		$nr++;

		switch ($_POST['vat'][$i]) {
			case 23:
				$vat23 += $vat;
				$bru23 += $war_bru;
				$net23 += $war_net;
				break;
			case 8:
				$vat8 += $vat;
				$bru8 += $war_bru;
				$net8 += $war_net;
				break;
			case 5:
				$vat5 += $vat;
				$bru5 += $war_bru;
				$net5 += $war_net;
				break;
			case 0:
				$vat0 += 1;
				$bru0 += $war_bru;
				$net0 += $war_net;
				break;
		}
	}
}


$html .= '</table><div></div>';



$html .= '<table>';
$html .= '
<tr><td style="width:50%" rowspan="6"> </td>	

<td class="tab-min" style="border:none;"></td><td class="tab-min">W.netto</td>	<td class="tab-min">VAT %</td>		<td class="tab-min">Kwota Vat</td>	<td class="tab-min">W.brutto</td></tr>';
if ($vat23 > 0) {
	$html .= '<tr>	<td class="tab-min" style="border:none;"></td>	<td class="tab-min">' . $net23 . '</td>	<td class="tab-min">23</td>	<td class="tab-min">' . $vat23 . '</td>	<td class="tab-min">' . $bru23 . '</td></tr>';
}
if ($vat8 > 0) {
	$html .= '<tr>	<td class="tab-min" style="border:none;"></td>	<td class="tab-min">' . $net8 . '</td>	<td class="tab-min">8</td>	<td class="tab-min">' . $vat8 . '</td>	<td class="tab-min">' . $bru8 . '</td></tr>';
}
if ($vat5 > 0) {
	$html .= '<tr>	<td class="tab-min" style="border:none;"></td>	<td class="tab-min">' . $net5 . '</td>	<td class="tab-min">5</td>	<td class="tab-min">' . $vat5 . '</td>	<td class="tab-min">' . $bru5 . '</td></tr>';
}
if ($vat0 > 0) {
	$html .= '<tr>	<td class="tab-min" style="border:none;"></td>	<td class="tab-min">' . $net0 . '</td>	<td class="tab-min">0</td>	<td class="tab-min">0</td>	<td class="tab-min">' . $bru0 . '</td></tr>';
}
$r_net = $net23 + $net8 + $net5 + $net0;

$r_vat = $vat23 + $vat8 + $vat5 + $vat0;
$r_bru = $bru23 + $bru8 + $bru5 + $bru0;
$gr = $r_bru * 100 - floor($r_bru) * 100;

$html .= '<tr>	<td class="tab-min" style="border:none;">Razem:</td>	<td class="tab-min">' . $r_net . '</td>	<td class="tab-min" style="border:none;"></td>	<td class="tab-min">' . $r_vat . '</td>	<td class="tab-min">' . $r_bru . '</td></tr>';
$html .= '</table><div></div>Do zapłaty: ' . $r_bru . ' PLN<br> Słownie: ' . numberToText($r_bru) . ' zł i ' . $gr . '/100'
	. '<div></div><hr><div></div>';
$html .= '<table style="width:100%">
<tr>
<td style="width:50%;text-align:center;"><br>Wystawił:<br><br>........................................</td><td style="width:50%; text-align:center;"><br>Odebrał:<br><br>........................................</td>
</tr>
</table>';
// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');



// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('name.pdf', 'I');
$pdf->Output('A:\xampp\htdocs\Fakturomatek\machine\name.pdf', 'F');
//============================================================+
// END OF FILE
//============================================================+
