<?php

$from="2013-02-01";
$to="2013-10-31";

$month="02";
$year="2013";




$mm= "02";
$yy= "2013";
$startdate=date($yy."-".$mm."-01") ;
$current_date=date('Y-m-t');
$ld= cal_days_in_month(CAL_GREGORIAN, $mm, $yy);
$lastday=$yy.'-'.$mm.'-'.$ld;
$start_date = date('Y-m-d', strtotime($startdate));
$end_date = date('Y-m-d', strtotime($lastday));
$end_date1 = date('Y-m-d', strtotime($lastday." + 6 days"));
$count_week=0;
$week_array = array();

for($date = $start_date; $date <= $end_date1; $date = date('Y-m-d', strtotime($date. ' + 7 days')))
{
    $getarray=getWeekDates($date, $start_date, $end_date);
echo "<br>";
 $week_array[]=$getarray;
    echo "\n";
$count_week++;

}
echo "<pre>";
print_r($week_array);
print_r($count_week);
// its give the number of week for the given month and year
//echo $count_week;
//print_r($week_array);

function getWeekDates($date, $start_date, $end_date)
{
    $week =  date('W', strtotime($date));
    $year =  date('Y', strtotime($date));
    $from = date("Y-m-d", strtotime("{$year}-W{$week}+1"));
    if($from < $start_date) $from = $start_date;

    $to = date("Y-m-d", strtotime("{$year}-W{$week}-6")); 
    if($to > $end_date) $to = $end_date;

$array1 = array(
        "ssdate" => $from,
        "eedate" => $to,
);

return $array1;

   // echo "Start Date-->".$from."End Date -->".$to;
}


?>
