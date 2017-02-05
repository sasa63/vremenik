<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('tcpdf/config/lang/hrv.php');
require_once('tcpdf/tcpdf.php');
include('db.php');



// extend TCPF with custom functions
session_start();
class MYPDF extends TCPDF {

	// Load table data from file
	public function LoadData($file) {
            include 'db.php';
            $result = $db->query('select id from godine where aktivan = 1') or die(mysql_error());
            $id_godina=$result->fetchColumn();

            $query = "SELECT datumi.dan as dan,
        predmeti.naziv aS predmet,
        nastavnici.pravo_ime as ime,
        vremenik.tip as tip,
        vremenik.razred as razred,
        vremenik.odjel as odjel,
        vremenik.potvrda as potvrda
        FROM datumi
        RIGHT JOIN vremenik ON (datumi.id=id_dan and id_nastavnik=$_SESSION[uid])
        LEFT JOIN nastavnici ON nastavnici.id=id_nastavnik
        left JOIN predmeti ON predmeti.id=id_predmet
        where datumi.id_godina=$id_godina 
        ORDER BY vremenik.razred, vremenik.odjel, vremenik.id_predmet, datumi.dan";
$result=$db->query($query) ));
    $d=array(1=>'Pon','Uto','Srije','Čet','Pet');
    while ($row=  $result->fetch(PDO::FETCH_ASSOC)){
        $dan = date('d.m.Y ', strtotime($row['dan']));
        $dan1 = $d[date('N',strtotime($row['dan']))];
        $tip = ($row['tip'] == 1 ? 'Duga ' : 'Kratka ').'provjera - '.($row['potvrda'] ? '': 'ne').'objavljena';


            $data[] = array("$row[razred].$row[odjel]",$row['predmet'],$dan.$dan1,$tip);

        }
    return $data;
    }

	// Colored table
	public function ColoredTable($header,$data) {
		// Colors, line width and bold font
		$this->SetFillColor(255, 0, 0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128, 0, 0);
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');
		// Header
		$w = array(20, 50, 45, 65);
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = 0;
		foreach($data as $row) {
			$this->Cell($w[0], 6, $row[0], 'LRTB', 0, 'C', $fill);
			$this->Cell($w[1], 6, $row[1], 'LRTB', 0, 'L', $fill);
			$this->Cell($w[2], 6, $row[2], 'LRTB', 0, 'L', $fill);
                        $this->Cell($w[3], 6, $row[3], 'LRTB', 0, 'L', $fill);
			$this->Ln();
			$fill=!$fill;
		}
		$this->Cell(array_sum($w), 0, '', 'T');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator('Vremenik');
$pdf->SetAuthor('sasa');
$pdf->SetTitle('Vremenik');
$pdf->SetSubject('Vremenik');
$pdf->SetKeywords('Vremenik');

// set default header data

$pdf->SetHeaderData('grb.jpg', 20, 'V R E M E N I K', 'Datum ispisa: '.  date('d.m.Y.'));

// set header and footer fonts
$pdf->setHeaderFont(Array('dejavuserif', '', 22));
$pdf->setFooterFont(Array('dejavuserif', '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont('dejavuserif');

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavuserif', '', 12);

// add a page
$pdf->AddPage();

//Column titles
$header = array('Razred', 'Predmet', 'Datum', 'Tip');

//Data loading
$data = $pdf->LoadData('tcpdf/cache/table_data_demo.txt');
unset ($_SESSION['data']);
// print colored table
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('vremenik.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>
