<?php
function lastE($n)
{
    $a = explode("/", $n);
    return $a[count($a) - 1];
}
$hw = ["temperature.csv" => "T", "humidity.csv" => "H", "pressure.csv" => "P", "pm10.csv" => "PM10", "pm25.csv" => "PM25", "smoke.csv" => "S"];
$dataL = [];
$y = 0;
if(!count(glob("data/2*"))){
    http_response_code(500);
    header("Content-Type: text/html");
    ?>
    <h1>Update in progress</h1>
    <p>Data cannot be displayed right now</h1>
    <?php
    exit;
}
foreach (glob("data/2*") as $yp) {
    $yt = lastE($yp);
    if ($y < $yt) $y = $yt;
}
$y = (string) $y;
$m = 0;
foreach (glob("data/$y/*") as $mp) {
    $mt = lastE($mp);
    if ($m < $mt) $m = $mt;
}
$m = (string)$m;
if (strlen($m) == 1) $m = "0" . $m;
$d = 0;
foreach (glob("data/$y/$m/*") as $dp) {
    $dt = lastE($dp);
    if ($d < $dt) $d = $dt;
}
if (strlen($d) == 1) $d = "0" . $d;
foreach ($hw as $fn => $fm) {
    $f = file("data/$y/$m/$d/$fn");
    $dataL[$fm] = (float)explode(",", $f[count($f) - 1])[1];
}
$dataL["update"]=date("d/m/Y H:i:s", file_get_contents("lastContact"));
