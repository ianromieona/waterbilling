
<?php
include('connection/connection.php');
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    $details = mysql_query("select c.meter_num as meter, concat(c.firstname,' ',c.lastname) as fullname,c.address as address,i.dateInstalled as date from client c,installation i where c.meter_num = i.meter_id and c.meter_num=".$_GET["id"]);
    $fetch = mysql_fetch_assoc($details);
    // Logo
    //$this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(1);
    // Title
    $this->Cell(0,8,'San Luis Water District',1,0,'C');
    // Line break
    $this->Ln();
    $this->Cell(80);
    $this->SetFont('Arial','i',10);
    $this->Cell(10,10,'Customer Service Record');
    $this->Ln(10);
    $this->Cell(7);
    $this->SetFont('Arial','B',10);
    $this->Cell(10,10,'Meter No: '.$fetch["meter"].'                                                       Date Installed:'.$fetch["date"]);
    $this->Ln();
    $this->Cell(7);
    $this->SetFont('Arial','B',10);
    $this->Cell(10,10,'Fullname: '.$fetch["fullname"]);
    $this->Ln();
    $this->Cell(7);
    $this->SetFont('Arial','B',10);
    $this->Cell(10,10,'Address: '.$fetch["address"]);
    $this->Ln(10);
    $this->Cell(7);
    $this->SetFont('Arial','B',10);
    $this->Cell(10,10,'NO          Present Reading           Previous Reading          Consumption         Amount          Reciept       Date');
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
         $listClient = mysql_query("select 
          b.previousUse as pre,
          b.presentUse as present,
          b.consumption as consumption,
          p.amt as amount,
          p.orId as ofid,
          b.billDate  as issued
          from 
          billing b,payment p, client c 
          where c.meter_num=b.client_id and b.bill_id=p.billingId and c.meter_num=".$_GET["id"]);
$total=0;
$numrows = mysql_num_rows($listClient);
if($numrows!=0){
    $i=1;
    $a=5;
    while($row=mysql_fetch_assoc($listClient)){
        //$pdf->Cell(15);
       // $pdf->Cell(0,10, $row["bId"]."                        ".$row["lastname"]." ".$row["firstname"]."                 ".$row["consumption"]."                 ".$row["due"]."                 ".$row["amt"],0,1);
       $pdf->Cell(10);
       $pdf->SetFont('Arial','',10);
       $pdf->Cell(20,$a,$i);
       $pdf->Cell(37,$a,$row["present"]);
       $pdf->Cell(35,$a,$row["pre"]);
       $pdf->Cell(30,$a,$row["consumption"]);
       $pdf->Cell(25,$a,$row["amount"]);
       $pdf->Cell(10,$a,$row["ofid"]);
       $pdf->Cell(40,$a,$row["issued"]);
       $pdf->Ln(8);
       $total += $row["amount"];
       $i++;
       $a=$a+5;
    }

}
else{


}
// for($i=1;$i<=40;$i++)
//     $pdf->Cell(0,10,'Printing line number '.$i,0,1);
       $pdf->Cell(115);
       $pdf->Cell(40,30,"Total:     ".$total);
       $pdf->Ln(20);
       $pdf->Cell(120);
       $pdf->Cell(40,10,"_________________________");
       $pdf->Ln();
       $pdf->Cell(130);
       $pdf->Cell(40,10,"    	 ".$_SESSION['name']."");
       $pdf->Ln();
      
$pdf->Output();
?>