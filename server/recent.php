<?php

function lastE($n)
{
    $a=explode("/",$n);
    return $a[count($a)-1];
}
$hw=["temperature.csv"=>"T","humidity.csv"=>"H","pressure.csv"=>"P","pm10.csv"=>"PM10","pm25.csv"=>"PM25","smoke.csv"=>"S"];
$dataL=[];
$y=0;
foreach(glob("data/2*") as $yp){
    $yt=lastE($yp);
    if($y<$yt) $y=$yt;
}
$y=(string) $y;
$m=0;
foreach(glob("data/$y/*") as $mp){
    $mt=lastE($mp);
    if($m<$mt) $m=$mt;
}
$m=(string)$m;
if(count($m)==0) $m="0".$m;
$d=0;
foreach(glob("data/$y/$m/*") as $dp){
    $dt=lastE($dp);
    if($d<$dt) $d=$dt;
}
foreach($hw as $fn=>$fm){
    $f=file("data/$y/$m/$d/$fn");
    $dataL[$fm]=(float)explode(",",$f[count($f)-1])[1];
}
echo json_encode($dataL);
