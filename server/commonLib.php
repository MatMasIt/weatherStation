<?php

if (!function_exists('stats_standard_deviation')) {
    /**
     * This user-land implementation follows the implementation quite strictly;
     * it does not attempt to improve the code or algorithm in any way. It will
     * raise a warning if you have fewer than 2 values in your array, just like
     * the extension does (although as an E_USER_WARNING, not E_WARNING).
     *
     * @param array $a
     * @param bool $sample [optional] Defaults to false
     * @return float|bool The standard deviation or false on error.
     */
    function stats_standard_deviation(array $a, $sample = false) {
        $n = count($a);
        if ($n === 0) {
            trigger_error("The array has zero elements", E_USER_WARNING);
            return false;
        }
        if ($sample && $n === 1) {
            trigger_error("The array has only 1 element", E_USER_WARNING);
            return false;
        }
        $mean = array_sum($a) / $n;
        $carry = 0.0;
        foreach ($a as $val) {
            $d = ((double) $val) - $mean;
            $carry += $d * $d;
        };
        if ($sample) {
           --$n;
        }
        return sqrt($carry / $n);
    }
}


function weekOfMonth($date) {
    //Get the first day of the month.
    $firstOfMonth = strtotime(date("Y-m-01", $date));
    //Apply above formula.
    return weekOfYear($date) - weekOfYear($firstOfMonth) + 1;
}

function weekOfYear($date) {
    $weekOfYear = intval(date("W", $date));
    if (date('n', $date) == "1" && $weekOfYear > 51) {
        // It's the last week of the previos year.
        return 0;
    }
    else if (date('n', $date) == "12" && $weekOfYear == 1) {
        // It's the first week of the next year.
        return 53;
    }
    else {
        // It's a "normal" week.
        return $weekOfYear;
    }
}
function get_daily($d=null,$m=null,$y=null){
 if($d==null) $d=date("d");
 if($m==null) $m=date("m");
 if($y==null) $y=date("Y");
  $fn="dataServer/".strtotime("$y-$m-$d").".csv";
 if(!file_exists($fn)){
 	   return [];
 }
 	$s=file($fn);
	$a=[];
	foreach($s as $l){
		$d=explode(",",$l);
        if( ($d[1]=="P" || $d[1]=="H")  && $d[2]<1) continue;
		$a[]=["type"=>$d[1],"time"=>$d[0],"value"=>$d[2]];
	}
	usort($a, function($a, $b) {
    return $a['time'] <=> $b['time'];
});
	return $a;
}
function get_weekly($week=null,$month=null,$year=null){
	$data=["list"=>[]];
	if($week==null) $week=weekOfMonth(date("U"));
	if($month==null)$month=date("m");
 if($year==null)	$year=date("Y");
	$begin=strtotime("monday this week",strtotime("+ ".(($week-1)*7)." days",strtotime("$year-$month-01")));
	$end=strtotime("next monday",$begin);
	for($i=$begin;$i<$end;$i+=floor(($end-$begin)/7)){
		
			$q=get_daily(date("d",$i),date("m",$i),date("y",$i));
	// var_dump(count($q))."<br />";
	 if(count($q)==0) continue;

		$data["list"]=array_merge($data["list"],$q);
		$data["days"][]=["jsUnix"=>$i*1000,"label"=>date("d/m/Y",$i)];
		
		}

	return $data;
	
}
function get_stats($data){
	$avgTot=0;
    $avgNum=0;
    $max=-111111111111;
    $min=1111111111111111;
    $allData=[];
	foreach($data as $e){
    	$avgTot+=$e["value"];
        $allData[]=$e["value"];
        $avgNum++;
        $max=max($max,$e["value"]);
        $min=min($min,$e["value"]);
    }
    return ["avg"=>$avgTot/$avgNum,"max"=>$max,"min"=>$min,"stdev"=>stats_standard_deviation($allData),"setSize"=>$avgNum];
}
function filterList($data,$filter){
	$a=[];
	foreach($data as $e){
		if(in_array($e["type"],$filter)) $a[]=$e;
		}
	return $a;
}
