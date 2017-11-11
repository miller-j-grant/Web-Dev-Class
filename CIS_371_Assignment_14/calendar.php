<?php
ini_set('display_errors', 1);

function createCalendar($month, $year, $eventArr, $IDArr){
    //Setup basic time data.
    $firstOfMonth = date('w',mktime(0,0,0,$month,1,$year));
    $numberOfDays = date('t',mktime(0,0,0,$month,1,$year));
    $counterDaysInWeek = 1;

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

    $logic = 0;

    //Begin to fill in the non-empty days of the month.
    for($i = 1; $i <= $numberOfDays; $i++)
    {

        if(array_key_exists($i,$eventArr)){
            $calendarTable.= '<td id="'.$i.'"><p id="'.$IDArr[$eventArr[$i]].'" class="eventTitle">'.$eventArr[$i].'</p>'.$i.'</td>';
        }else{
            $calendarTable.= '<td id="'.$i.'">'.$i.'</td>';
        }

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
        $logic = $i;
        $counterDaysInWeek++;
    }

//If we still have days left in this week, add empty days to represent next month.
    if($counterDaysInWeek != 7 && $logic != $numberOfDays){
        for($i = $counterDaysInWeek; $i <= 7; $i++){
            $calendarTable.= '<td class="emptyDay"></td>';
        }
    }

//Close the last row and close the table.
    $calendarTable.='</tr>';
    $calendarTable.='</table>';

    echo $calendarTable;
}