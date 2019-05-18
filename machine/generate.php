<?php

require_once('tcpdf_include.php');
class MYPDF extends TCPDF {

    //Page header


    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
		// Page number
		
		$this->Cell(0, 10, 'Faktura wygenerowana przez FAKTUROMATEK®', 0, false, 'L', 0, '', 0, false, 'T', 'M');
		
		$this->Cell(0, 10, 'Strona '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
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
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
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
if (@file_exists(dirname(__FILE__).'/lang/pol.php')) {
	require_once(dirname(__FILE__).'/lang/pol.php');
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

$nr_fak="19/05/2781";
$data_wys="21-12-1999";
$miejsce="Koźminek";
$data_wyk="29-02-1998";

$sprzedawca="AllChemia Iwona Strzałka";
$sprze_adres="ul. Tadeusza Kościuszki 2, 62-840 Koźminek";
$sprze_nip="968-041-57-90";
$nabywca="Jakub Strzałka";
$nabywca_adres='Wypizdowiee!!!';
$nabywca_nip='99999999';

// Set some content to print

$html ='
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
</style>

<table>
<tr>
	<td colspan="2">'.$sprzedawca.'</td>
</tr>
<tr>
	<td>'.$sprze_adres.'</td><td>Telefon: 609-389-199</td>
</tr>
<tr>
<td>NIP: '.$sprze_nip.'</td><td>E-mail: allchemia.kozminek@gmail.com</td>
</tr>
<tr>
<td>Regon: 383-098-580 </td><td>Konto: PKO SA NUMERKI</td>
</tr>
</table>
<hr>
';
$html.='<div ></div><span style="font-size:6mm;width:100%;text-align:center;">Faktura nr '.$nr_fak. "</span><div ></div>";
$html.='<span style="font-size:4mm;text-align:left;">Data i miejsce wystawienia: '.$data_wys.', '.$miejsce.'<br></span>';
$html.='<span style="font-size:4mm;text-align:left;">Data dokonania dostawy lub wykonania usługi: '.$data_wyk.'</span><br>';
$html.='<br><table style=" border-spacing: 3mm;"><tr>
 <td><span style="font-size:5mm;text-align:center;">Sprzedawca:</span><br><div style="font-size:3.6mm;border:1px solid black;"> '.$sprzedawca.'<br> '.$sprze_adres.'<br> NIP: '.$sprze_nip.
 
'</div></td><td ><span style="font-size:5mm;text-align:center;">Nabywca:</span><br><div style="font-size:3.6mm;border:1px solid black;"> '.$nabywca.'<br> '.$nabywca_adres.'<br> NIP: '.$nabywca_nip.
 
'</div></td>
</tr>
</table>

';
$html.='<table>';
$html.='<tr>
<td class="top-table td1" >lp.</td><td class="top-table td6">Towar</td><td class="top-table td1">JM</td><td class="top-table td1">Ilość</td>
<td class="top-table td2">Cena <br>brutto</td><td class="top-table td2">Wartość netto</td><td class="top-table td1">VAT</td><td class="top-table td2">Kwota VAT </td><td class="top-table td2">Wartość Brutto</td>
</tr>';
for($i=1;$i<=20;$i++)
{
	if($i%2==0)
	$html.='<tr style="background-color:#D5D5D5;">';
	else
	$html.='<tr>';
	$html.='<td class="" >'.$i.'</td>';//numer
	$html.='<td class="">KArnet cośtam</td>';//towar
	$html.='<td class="">szt</td>';//Jednostka miary
	$html.='<td class="">10</td>';//Ilość
	$html.='<td class="">12</td>';//Cena brutto
	$html.='<td class="">4</td>';//Wartość Netto
	$html.='<td class="">23%</td>';//Vat
	$html.='<td class="">12345 </td>';//Kwota Vat
	$html.='<td class="">123456789</td>';//Wartość brutto
	$html.='</tr>';
}


$html.='</table><div></div>';

$html.='<table>';
$html.='
<tr><td style="width:50%" rowspan="3"> Do zapłaty: XXXXXXXXXXXXXX<br> Słownie: OD CHUJAAAAAAAAAAAAAAAAAAAAAAAA!</td>	<td class="tab-min" style="border:none;"></td>	<td class="tab-min">VAT</td>	<td class="tab-min">W.netto</td>	<td class="tab-min">Kwota Vat</td>	<td class="tab-min">W.brutto</td></tr>
<tr>	<td class="tab-min" style="border:none;"></td>	<td class="tab-min"></td>	<td class="tab-min"></td>	<td class="tab-min"></td>	<td class="tab-min"></td></tr>
<tr>	<td class="tab-min" style="border:none;">Razem:</td>	<td class="tab-min"></td>	<td class="tab-min" style="border:none;"></td>	<td class="tab-min"></td>	<td class="tab-min"></td></tr>

';
$html.='</table><div></div><hr><div></div>';
$html.='<table style="width:100%">
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

//============================================================+
// END OF FILE
//============================================================+
