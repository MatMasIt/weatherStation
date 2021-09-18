<?php
require("commonLib.php");
// caching
$_GET["when"]=preg_replace("/[^A-Za-z0-9 ]/", '', $_GET["when"]);
$_GET["dataType"]=preg_replace("/[^A-Za-z0-9 ]/", '', $_GET["dataType"]);
$path="cache/".$_GET["when"]."/".$_GET["dataType"];
$data=json_decode(file_get_contents($path),true);
if($data["last"]){}
$final = [];
switch ($_GET["when"]) {
  case "today":
    $selector = get_daily();
    $final["periodName"] = "Dati di oggi";
    break;
  case "yesterday":
    $selector = get_daily(date("d", strtotime("yesterday")), date("m", strtotime("yesterday")), date("Y", strtotime("yesterday")));
    $final["periodName"] = "Dati di ieri";
    break;
  case "weekly":
    $ww = get_weekly();
    $selector = $ww["list"];
    $final["days"] = $ww["days"];
    $final["periodName"] = "Dati di questa settimana";
    break;
  case "weeklyprev":
    $wwp = weekOfMonth(strtotime("last week"));
    $month = date("m", strtotime("last week"));
    $year = date("y", strtotime("last week"));
    $wp = get_weekly($wwp, $month, $year);
    $selector = $wp["list"];
    $final["days"] = $wp["days"];
    $final["periodName"] = "Dati della scorsa settimana";
    break;
  case "thismonth":
    $selector = [];
    $final["days"] = [];
    for ($i = 1; $i < weekOfMonth(strtotime("last week"))+1; $i++) {
      $wp = get_weekly($i+1,date("m"),date("Y"));
      if(!$wp["list"]) continue;
      $selector = array_merge($selector,$wp["list"]);
      $final["days"]= array_merge($final["days"],$wp["days"]);
    }
    $final["periodName"] = "Dati di questo mese";
    break;
  case "prevmonth":
    $nWeeks = 7;
    $month = date("m", strtotime("last day of last month"));
    $year = date("y", strtotime("last day of last month"));
    $selector = [];
    $final["days"] = [];
    for ($i = 2; $i < $nWeeks; $i++) {
      $wp = get_weekly($i, $month, $year);
      if(!$wp["list"]) continue;
      $selector = array_merge($selector,$wp["list"]);
      $final["days"]= array_merge($final["days"],$wp["days"]);
    }
    $final["periodName"] = "Dati del mese precedente";
    break;
}
$rfd = array();
foreach ($selector as $key => $value){
  if(!in_array($value, $rfd)) $rfd[]=$value;
}
$selector=$rfd;
switch ($_GET["dataType"]) {
  case "T":
    $dataT = filterList($selector, ["T"]);
    $statsT = get_stats($dataT);
    $final["data"] = $dataT;
    $final["stats"] = $statsT;
    break;
  case "H":
    $dataH = filterList($selector, ["H"]);
    $statsH = get_stats($dataH);
    $final["data"] = $dataH;
    $final["stats"] = $statsH;
    break;
  case "P":
    $dataP = filterList($selector, ["P"]);
    $statsP = get_stats($dataP);
    $final["data"] = $dataP;
    $final["stats"] = $statsP;
    break;
  case "PM10":
    $dataPM10 = filterList($selector, ["PM10"]);
    $statsPM10 = get_stats($dataPM10);
    $final["data"] = $dataPM10;
    $final["stats"] = $statsPM10;
    break;
  case "PM25":
    $dataPM25 = filterList($selector, ["PM25"]);
    $statsPM25 = get_stats($dataPM25);
    $final["data"] = $dataPM25;
    $final["stats"] = $statsPM25;
    break;
  case "S":
    $dataS = filterList($selector, ["S"]);
    $statsS = get_stats($dataS);
    $final["data"] = $dataS;
    $final["stats"] = $statsS;
    break;
}
$type = $final["data"][0]["type"];
for ($i = 0; $i < count($final["data"]); $i++) {
  unset($final["data"][$i]["type"]);
  $final["data"][$i]["time"] = (int)$final["data"][$i]["time"];
  $final["data"][$i]["value"] = (float) $final["data"][$i]["value"];
}
switch ($type) {
  case "T":
    $unit = " ° C";
    $color = "red";
    $yAxis = "Temperatura";
    break;
  case "H":
    $unit = " %";
    $color = "blue";
    $yAxis = "Umidità";
    break;
  case "P":
    $unit = " hPa";
    $color = "green";
    $yAxis = "Pressione";
    break;
  case "PM10":
    $unit = " µg/m³";
    $color = "cyan";
    $yAxis = "PM 10";
    break;
  case "PM25":
    $unit = "µg/m³";
    $color = "magenta";
    $yAxis = "PM 2,5";
    break;
  case "S":
    $unit = "µg/m³";
    $color = "orange";
    $yAxis = "Fumo e vapori infiammabili";
    break;
}
$final["stats"]["avg"] = number_format($final["stats"]["avg"], 2, ",", "'") . $unit;
$final["stats"]["max"] = number_format($final["stats"]["max"], 2, ",", "'") . $unit;
$final["stats"]["min"] = number_format($final["stats"]["min"], 2, ",", "'") . $unit;
$final["stats"]["stdev"] = number_format($final["stats"]["stdev"], 2, ",", "'") . $unit;
$final["color"] = $color;
$final["yAxis"] = $yAxis;
$final["unit"]=$unit;
header("Content-Type: application/json");
echo json_encode($final, JSON_PRETTY_PRINT);
