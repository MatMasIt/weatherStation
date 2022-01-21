<?php
if (!count(glob("data/2*"))) {
    http_response_code(500);
    header("Content-Type: text/html");
?>
    <h1>Update in progress</h1>
    <p>Data cannot be displayed right now</h1>
    <?php
    exit;
}
require("datalib.php");
$final = [];
switch ($_GET["when"]) {
    case "today":
        $final["data"] = get_daily(null, null, null, $_GET["dataType"]);
        $final["periodName"] = "Dati di oggi";
        break;
    case "yesterday":
        $final["data"]  = get_daily(date("d", strtotime("yesterday")), date("m", strtotime("yesterday")), date("Y", strtotime("yesterday")), $_GET["dataType"]);
        $final["periodName"] = "Dati di ieri";
        break;
    case "weekly":
        $final = get_weekly(null, null, null, $_GET["dataType"]);
        $final["periodName"] = "Dati di questa settimana";
        break;
    case "weeklyprev":
        $wwp = weekOfMonth(strtotime("last week"));
        $month = date("m", strtotime("last week"));
        $year = date("y", strtotime("last week"));
        $final = get_weekly($wwp, $month, $year, $_GET["dataType"]);
        $final["periodName"] = "Dati della scorsa settimana";
        break;
    case "thismonth":
        $final["data"] = [];
        $final["days"] = [];
        for ($i = 1; $i < weekOfMonth(strtotime("last week")) + 1; $i++) {
            $w = get_weekly($i, date("m"), date("Y"), $_GET["dataType"], date("m"));
            if ($w["data"] != null && count($w["data"])) $final["data"] = array_merge($final["data"], $w["data"]);
            if ($w["days"] != null && count($w["days"])) $final["days"] = array_merge($final["days"], $w["days"]);
        }
        $final["periodName"] = "Dati di questo mese";
        break;
    case "prevmonth":
        $month = date("m", strtotime("last day of last month"));
        $year = date("y", strtotime("last day of last month"));
        $nWeeks = weeks_in_month($month, $year);
        $final["data"] = [];
        $final["days"] = [];
        for ($i = 1; $i < $nWeeks; $i++) {
            $w = get_weekly($i, $month, $year, $_GET["dataType"], $month);
            if ($w["data"] != null && count($w["data"])) $final["data"] = array_merge($final["data"], $w["data"]);
            if ($w["days"] != null && count($w["days"])) $final["days"] = array_merge($final["days"], $w["days"]);;
        }
        $final["periodName"] = "Dati del mese precedente";
        break;
}

$final["stats"] = get_stats($final["data"]);

switch ($_GET["dataType"]) {
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
$final["stats"]["mode"] = number_format($final["stats"]["mode"], 2, ",", "'") . $unit;
$final["color"] = $color;
$final["yAxis"] = $yAxis;
$final["unit"] = $unit;

header("Content-Type: application/json");
echo json_encode($final, JSON_PRETTY_PRINT);
