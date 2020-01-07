<?php 
//echo date('Y-m-d h:i:s a l');
if(isset($_POST) && !isset($_POST['sdate'])) {
$last4Sundays = array();
$lastSundays = array();
$today = array();
$i=0;
$day = 4;
if(date('l') == 'Sunday'){
	$day = 3;
	$today[date('d_F_Y')] = date('d F Y');
};
$j=7;
while($i<$day){
  $m = $j*$i;
 $lastSundays[date('d_F_Y',strtotime('last sunday - '.$m.' days'))] = date('d F Y',strtotime('last sunday - '.$m.' days'));
 $i++;
}

$last4Sundays = array_reverse(array_merge($today,$lastSundays));
} else{
$sdate = explode('-', $_POST['sdate']);
$month = $sdate[1];
$day   = $sdate[2];
$year  = $sdate[0];
$last4Sundays = getSundays($year,$month);
}

function getSundays($y,$m){ 
    $date = "$y-$m-01";
    $first_day = date('N',strtotime($date));
    $first_day = 7 - $first_day + 1;
    $last_day =  date('t',strtotime($date));
    $days = array();
    for($i=$first_day; $i<=$last_day; $i=$i+7 ){
        $days[date('d_F_Y',strtotime("$y-$m-$i"))] = date('d F Y',strtotime("$y-$m-$i")) ;
    }
    return  $days;
}


