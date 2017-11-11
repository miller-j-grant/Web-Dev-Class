<!DOCTYPE html>
<html>
<body>

<?php

//Setup basic time data.
$month = date('n');
$day = date('d');
$year = date('Y');
$dayOfWeek = date('w');
$firstOfMonth = date('w',mktime(0,0,0,$month,1,$year));
$numberOfDays = date('t');
$counterDaysInWeek = $firstOfMonth;

echo date('F');

//Establish the calendar table and the headings in first row.
$calendarTable = '<table class="calendar">';
$calendarTable.= '<tr class="row">
    <td class="heading">Sunday</td>
    <td class="heading">Monday</td>
    <td class="heading">Tuesday</td>
    <td class="heading">Wednesday</td>
    <td class="heading">Thursday</td>
    <td class="heading">Friday</td>
    <td class="heading">Saturday</td>';

//Establish the second row but don't close it.
$calendarTable.='<tr class="row">';

//Put the days from previous month in first.
for($i = 0; $i < $firstOfMonth; $i++){
    $calendarTable.= '<td class="emptyDay"></td>';
    $counterDaysInWeek++;
}

//Begin to fill in the non-empty days of the month.
for($i = 1; $i <= $numberOfDays; $i++){
    $calendarTable.= '<td class="day">'.$i.'</td>';

    //If we are at the end of the week, end current row.
    if($counterDaysInWeek == 7) {
        $calendarTable .= '</tr>';
        $counterDaysInWeek = 0;

        //If we still have more days to go, create new row.
        //Nested in order to make sure that we only create rows when it is the end of the week.
        if($i != $numberOfDays){
            $calendarTable.= '<tr class="row">';
        }
    }
    $counterDaysInWeek++;
}

//If we still have days left in this week, add empty days to represent next month.
if($counterDaysInWeek != 7){
    for($i = $counterDaysInWeek; $i <= 7; $i++){
        $calendarTable.= '<td class="emptyDay"></td>';
    }
}

//Close the last row and close the table.
$calendarTable.='</tr>';
$calendarTable.='</table>';

echo $calendarTable;
?>

</body>
</html>