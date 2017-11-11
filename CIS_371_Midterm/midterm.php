<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <title>CIS 371 Midterm</title>
</head>

<body>

<?php
function createTable(){

    $counterPlaceInTable = 1;

    //Establish the invoice table and the headings in first row.
    $invoiceTable = '<table class="invoice">';
    $invoiceTable.= '<tr class="row">
    <td class="heading">Origin</td>
    <td class="heading">Destination</td>
    <td class="heading">Miles</td>
    <td class="heading">Minutes</td>
    <td class="heading">Avg. Speed</td>
    <td class="heading">Rate</td>
    <td class="heading">Total</td>';

    $counterPlaceInTable = 1;

    $fileStr=null;
    $myfile = fopen("invoice_data1.txt", "r");
    while(($line = fgets($myfile)) !== false){
        $line = trim($line);
        $fileStr .= $line;
        $fileStr .= ', ';
    }

    $expStr = explode(", ", $fileStr);
    $totalMiles = 0;
    $totalMinutes = 0;
    $totalSpeed = 0;
    $totalRate = 0;
    $totalTotal = 0;

    //Establish the second row but don't close it.
    $invoiceTable.='<tr class="row">';
    
    //Begin to fill in the table.
    for($i = 0; $i < sizeof($expStr); $i++)
    {
        if($counterPlaceInTable < 3) 
        {
            $invoiceTable .= '<td class="cell">' . $expStr[$i] . '</td>';
        }
        elseif($counterPlaceInTable == 3 || $counterPlaceInTable == 4)
        {
            $invoiceTable .= '<td class="number">' . $expStr[$i] . '</td>';
        } 
        elseif($counterPlaceInTable == 5)
        {
            $avg = ($expStr[$i-2]/$expStr[$i-1]) * 60;
            $invoiceTable.= '<td class="number">'.number_format($avg,2).'</td>';

            if($avg >= 75){
                $rate = 0.15;
            }
            if($avg >= 70 && $avg < 75){
                $rate = 0.45;
            }
            if($avg >= 65 && $avg < 70){
                $rate = 0.55;
            }
            if($avg >= 60 && $avg < 65){
                $rate = 0.50;
            }
            if($avg >= 50 && $avg < 60){
                $rate = 0.40;
            }
            if($avg >= 40 && $avg < 50){
                $rate = 0.30;
            }
            if($avg < 40){
                $rate = 0.15;
            }
            $invoiceTable.= '<td class="number">$'.$rate.'</td>';

            $total = $expStr[$i-2] * $rate;

            $invoiceTable .= '<td class="number">$' . number_format($total,2) . '</td>';
            $invoiceTable .= '</tr>';
            $counterPlaceInTable = 1;

            $totalMiles += $expStr[$i-2];
            $totalMinutes += $expStr[$i-1];
            $totalSpeed += $avg;
            $totalRate += $rate;
            $totalTotal += $total;

            //If we still have more cells to go, create new row.
            if ($i != sizeof($expStr)-1) {
                $invoiceTable .= '<tr class="row">';
                $invoiceTable.= '<td class="cell">'.$expStr[$i].'</td>';
            }
        }
        $counterPlaceInTable++;
    }

    $invoiceTable.='</tr>';
    $invoiceTable.='<tr class="row">';
    $invoiceTable.='<td class="cell lastrow"></td>';
    $invoiceTable.='<td class="cell lastrow"></td>';

    $invoiceTable.='<td class="number lastrow">'.$totalMiles.'</td>';
    $invoiceTable.='<td class="number lastrow">'.$totalMinutes.'</td>';
    $invoiceTable.='<td class="number lastrow">'.number_format($totalSpeed/5,2).'</td>';
    $invoiceTable.='<td class="number lastrow">$'.($totalRate/5).'</td>';
    $invoiceTable.='<td class="number lastrow">$'.$totalTotal.'</td>';

    $invoiceTable.='</table>';

    echo $invoiceTable;
}
?>

<?php
    createTable();
?>

</body>
</html>