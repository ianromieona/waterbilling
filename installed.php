
<?php
include('connection/connection.php');
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    //$this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(1);
    // Title
    $this->Cell(0,10,'San Luis Water District',1,0,'C');
    // Line break
    $this->Ln();
    $this->Cell(80);
    $this->SetFont('Arial','i',10);
    $this->Cell(10,10,'Customer(Not Installed)');
    $this->Ln(10);
    $this->Cell(15);
    $this->SetFont('Arial','B',10);
    $this->Cell(10,10,'Meter                      Name                                    Contact                               Address');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
         $listClient = mysql_query("select c.id as id,
                                                 c.meter_num as meter,
                                                 c.lastname as lastname,
                                                 c.firstname as firstname,
                                                 c.contact as contact,
                                                 c.address as address,
                                                 b.consumption as consumption,
                                                 b.bill_Id as bId,
                                                 b.billAmt as amt,
                                                 b.dueDate as due,
                                                 b.status as status
                                          from client c,billing b 
                                          where c.status='INSTALLED' order by c.lastname ASC");
$total=0;
$numrows = mysql_num_rows($listClient);
if($numrows!=0){

    $a=5;
    while($row=mysql_fetch_assoc($listClient)){
        //$pdf->Cell(15);
       // $pdf->Cell(0,10, $row["bId"]."                        ".$row["lastname"]." ".$row["firstname"]."                 ".$row["consumption"]."                 ".$row["due"]."                 ".$row["amt"],0,1);
       $pdf->Cell(16);
       $pdf->SetFont('Arial','',10);
       $pdf->Cell(30,$a,$row["meter"]);
       $pdf->Cell(45,$a,$row["lastname"]." ".$row["firstname"]);
       $pdf->Cell(45,$a,$row["contact"]);
       $pdf->Cell(23,$a,$row["address"]);
       $pdf->Ln(8);
       //$a=$a+5;
    }

}
else{


}
       $pdf->Ln(10);
       $pdf->Cell(120);
       $pdf->Cell(40,10,"_________________________");
       $pdf->Ln();
       $pdf->Cell(130);
       $pdf->Cell(40,10,"    	 ".$_SESSION['name']."");
       $pdf->Ln();
$pdf->Output();
?>