<?php

define('FPDF_FONTPATH','ext/preisliste/font/');
require_once("ext/preisliste/fpdf.php");


class myFpdf extends FPDF
{
	var $subtitle = array("");
	
	
	
	// Kopfzeilen-Funktion überschreiben	 
	function Header() {

		// Logo laden
		$this->Image('img/logo.png', 10, 10, 14, 23);
		
		//Schriftart auf Arial, , 10pt 
		$this->SetFont('Arial', 'I',10);
		
		// Schriftfarbe auf grau festlegen
		$this->SetTextColor(127, 127, 127);
		
		// Einen Titel ausgeben
		$this->Cell(190,10,$this->subject, 0, 0,'R');
		
		$this->SetTextColor(0);
		$this->SetFont('Times', '',14);
		$this->Ln(16);
		// Den Author ausgeben
		$this->SetX(30);
		$this->Cell(170, 7, $this->author, 'B', 1, 'R');
		
		$this->Ln(5);
	}

	// Fusszeilen-Funktion überschreiben
	function Footer()	{
		//Position 1.5 cm vom unteren Rand
		$this->SetY(-15);
		
	    $this->SetDrawColor(128);
	    //Arial italic 8
		$this->SetFont('Arial', 'I', 8);
		
		// Schriftfare auf ca. 50% schwarz stellen  
		$this->SetTextColor(127); 
		
		// Subtitle ausgeben
		$this->Cell(0, 5, (sizeof($this->subtitle) > 1) ? $this->subtitle[1] : $this->subtitle[0], 'T', 0, 'L');
		
		$this->SetFont('Arial', '', 8);
		//Seitenzahl ausgaben
		$this->Cell(0,5,'Seite '.$this->PageNo().' von {nb}',0,0,'R');
		
		$this->subtitle = array($this->subtitle[sizeof($this->subtitle)-1]);
	}
	
	function PutTitle()
	{
	    $this->SetTextColor(0);
	    $this->SetFont('Times', 'B', 16);
	    $this->Ln(5);
	    $this->Cell(0, 8, $this->title, 0, 1, 'C', 0);
	    
	    array_push($this->subtitle, $this->title);
	}
	
	function PutSubtitle($subtitle)
	{
	    $this->Ln(10);
	    $this->SetTextColor(0);
	    $this->SetDrawColor(0);
	    $this->SetLineWidth(0.1);
	    $this->SetFont('Times', 'B', 14);
	    $this->Cell($this->GetStringWidth($subtitle) + 10, 7, $subtitle, 'B', 1, 'L', 0);
	    $this->Ln(5);
	    
	    array_push($this->subtitle, $subtitle);
	}
	
	function PutSubSubtitle($subsubtitle)
	{
	    $this->SetTextColor(0);
	    $this->SetFont('Times', '', 12);
	    $this->Cell(5);
	    $this->Cell(0, 6, $subsubtitle, 0, 1, 'L', 0);
	}
	
	// Ein Special ausgeben
	function Special($title, $text)
	{

	    //Colors, line width and bold font
	    $this->SetFillColor(0,51,102);
	    $this->SetTextColor(0xFF);
	    $this->SetDrawColor(0xE0,0xBC,0x75); // E0BC75
	    $this->SetLineWidth(.5);
	    $this->SetFont('Times', 'B', 14);
	    
	    // title ausgeben
		$this->Ln(5);
		$this->Cell(20);
		$this->Cell(150, 7, $title, 'LTR', 1, 'C', 1);

	    // text ausgeben
	    $this->SetTextColor(0x00);
	    $this->SetFont('Times', '', 10);
		// Vorher Luft
	    $this->Cell(20);
		$this->MultiCell(150, 5, "", 'LR', 1, '', 1);

		$this->Cell(20);
		$this->MultiCell(150, 5, $text, 'LR', 1, 'L', 1);

		// hinterher Luft
		$this->Cell(20);
		$this->MultiCell(150, 5, "", 'LBR', 1, '', 1);
		$this->Ln();	    
	}

	function Anotation($title, $text)
	{
	    //Colors, line width and bold font
	    $this->SetFillColor(0,0,0);
	    $this->SetTextColor(0x33);
	    $this->SetFont('Times', 'I', 10);
	    
	    // title ausgeben
		$this->Cell(10);
		$this->Cell(170, 5, "Anmerkung: ".$title, 'R', 1, 'L');

	    // text ausgeben
	    $this->SetTextColor(0x33);
	    $this->SetFont('Times', '', 10);

		$this->Cell(20);
		$this->MultiCell(160, 5, $text, 'RB', 1, 'L');

		// hinterher Luft
		$this->Ln();	    
	}
	
	//Colored table
	function FancyTable($data)
	{
	    //Colors, line width and bold font
	    $this->SetFillColor(0xEE,0xD9,0xB2); // EED9B2
	    $this->SetTextColor(0);
	    $this->SetDrawColor(0,0x33,0x66);
	    $this->SetLineWidth(.3);

	    $w=array(10, 140,35);

	    $fill = 0;
	    $this->Cell($w[0]);
	    $this->Cell($w[1] + $w[2],0,'','T');
	    $this->Ln();

	    foreach($data as $row)
	    {
	    	$this->Cell($w[0]);

	    	$this->SetFont('Times', '', 10);
	        $this->Cell($w[1],6,$row['desc'],'LR',0,'L',$fill);
			
	        $this->SetFont('Times', 'B', 10);
	        $this->Cell($w[2], 6, $row['price'], 'LR', 0, 'R', $fill);

	        $this->Ln();
	        $fill = !$fill;
	    }

	    $this->Cell($w[0]);
	    $this->Cell($w[1] + $w[2], 0, '', 'T', 1);
	    $this->Ln(5);
	}
	
	
	function CleanOutput($name, $zwei)
	{
		ob_clean();
		$this->Output($name, $zwei);
		exit();
	}
}

?>