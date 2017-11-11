<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style2.css" type="text/css"/>
    <title>CIS 371 In-Class-08</title>

    <?php
    //check to see if a cookie has been set with the key of "background"
    if (!array_key_exists('background', $_COOKIE)) {
        if(array_key_exists('colorTest',$_GET)){
            $background = $_GET['colorTest'];
            setcookie('background', $background, time() + 60, "/");
        }else{
            $background = 'teal';
            setcookie('background', $background, time() + 5, "/");
        }
    }else{
        $background = $_COOKIE['background'];
    }

    //check to see if a cookie has been set with the key of "font"
    if (!array_key_exists('font', $_COOKIE)) {
        if(array_key_exists('fontTest',$_GET)){
            $font = $_GET['fontTest'];
            setcookie('font', $font, time() + 60, "/");
        }else{
            $font = 'normal';
            setcookie('font', $font, time() + 5, "/");
        }
    }else{
        $font = $_COOKIE['font'];
    }

    echo '<style>
        body {
            background-color: '.$background.';
            font-style: '.$font.';
        }
    </style>'
    ?>

</head>

<body>

<?php
if(!array_key_exists("test", $_COOKIE)){
    echo 'No cookies yet.';
    $test = 'Baking new cookies.';
    setcookie('test', $test, time() + 60, "/");
}else{
    echo '<p> ==&gt;'.$_COOKIE['test'].'&lt;==</p>';
}
?>

<?php
if(array_key_exists("month",$_GET)){
    $month = $_GET['month'];
}else{
    $month = date('n');
}

if(array_key_exists("year",$_GET)){
    $year = $_GET['year'];
}else{
    $year = date('Y');
}

echo date('M', mktime(0,0,0,$month,1,$year));
echo ' ';
echo $year;
?>

<?php
function createCalendar($month, $year){
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
?>

<?php createCalendar($month, $year); ?>

<div id="links">
    <?php

    if(array_key_exists("link",$_GET)){
        $link = $_GET['link'];

        if ($link == '1'){
            if($month == 1){
                $month = $month +11;
                $year = $year -1;

                echo date('M', mktime(0,0,0,$month,1,$year));
                echo $year;

                createCalendar($month, $year);
            }else{
                $month = $month -1;

                echo date('M', mktime(0,0,0,$month,1,$year));
                echo $year;

                createCalendar($month, $year);
            }
        }
        if ($link == '2') {
            if ($month == 12) {
                $month = $month - 11;
                $year = $year + 1;

                echo date('M', mktime(0, 0, 0, $month, 1, $year));
                echo $year;

                createCalendar($month, $year);
            } else {
                $month = $month + 1;

                echo date('M', mktime(0, 0, 0, $month, 1, $year));
                echo $year;

                createCalendar($month, $year);
            }
        }
    }
    else{

    }

    $links = '<ul>
        <li><a href="?link=1&month=';
    $links.= $month;
    $links.= '&year=';
    $links.= $year;
    $links.= '" name="previous">Previous Month</a></li>
        <li><a href="?link=2&month=';
    $links.= $month;
    $links.= '&year=';
    $links.= $year;
    $links.= '" name="next">Next Month</a></li>
        </ul>';

    echo $links;
    ?>
</div>

</body>

</html>