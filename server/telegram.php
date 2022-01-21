<?php
require("rlib.php");
require("datalib.php");
function timestats($DATA,$period){
   $text="";
   $map=["H"=>"Umidità","T"=>"Temperatura","P"=>"Pressione","PM10"=>"PM10","PM25"=>"PM2,5","S"=>"Fumo e vapori infiammabili"];
    foreach(["T","H","P","PM10","PM25","S"] as $dataType){
    $final=[];
    switch ($period) {
    case "today":
        $final["data"] = get_daily(null, null, null, $dataType);
        $final["periodName"] = "Dati di oggi";
        break;
    case "yesterday":
        $final["data"]  = get_daily(date("d", strtotime("yesterday")), date("m", strtotime("yesterday")), date("Y", strtotime("yesterday")), $dataType);
        $final["periodName"] = "Dati di ieri";
        break;
    case "weekly":
        $final = get_weekly(null, null, null, $dataType);
        $final["periodName"] = "Dati di questa settimana";
        break;
    case "weeklyprev":
        $wwp = weekOfMonth(strtotime("last week"));
        $month = date("m", strtotime("last week"));
        $year = date("y", strtotime("last week"));
        $final = get_weekly($wwp, $month, $year, $dataType);
        $final["periodName"] = "Dati della scorsa settimana";
        break;
    case "thismonth":
        $final["data"] = [];
        $final["days"] = [];
        for ($i = 1; $i < weekOfMonth(strtotime("last week")) + 1; $i++) {
            $w = get_weekly($i, date("m"), date("Y"), $dataType, date("m"));
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
            $w = get_weekly($i, $month, $year, $dataType, $month);
            if ($w["data"] != null && count($w["data"])) $final["data"] = array_merge($final["data"], $w["data"]);
            if ($w["days"] != null && count($w["days"])) $final["days"] = array_merge($final["days"], $w["days"]);;
        }
        $final["periodName"] = "Dati del mese precedente";
        break;
}
if(!strlen($text)) $text = $final["periodName"].":\n";
$final["stats"] = get_stats($final["data"]);
 switch ($dataType) {
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
 $s= $final["stats"];
 $text.="\n---".$map[$dataType]."---\n";
$text.="Media : ".$s["avg"]."\nMassimo: ".$s["max"]."\nMinimo: ".$s["min"]."\nDeviazione Standard: ".$s["stdev"]."\nModa: ".$s["mode"]."\nNumero di rilevazioni: ".$s["setSize"]."\n";
}
     API("sendMessage", ["chat_id" => $DATA["message"]["chat"]["id"], "text" => $text,"reply_to_message_id" => $DATA["message"]["message_id"]]);
}
function n($n){
    return number_format($n, 2, ",", "'");
}
function API($method, $data)
{
    $ch = curl_init();
    $botT="TOKEN_HERE";
    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot".$botT."/" . $method);
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    return json_decode(curl_exec($ch) , true);
}
function help($DATA){
    API("sendMessage", ["chat_id" => $DATA["message"]["chat"]["id"], "text" => "Lista di comandi: \n----------------\n/meteo - Ottieni le ultime misurazioni\n/oggi - statistiche di oggi\n/ieri - statistiche di ieri\n/questasettimana - statistiche di questa settimana\n/scorsasettimana - statistiche della scorsa settimana\n/questomese - statistiche di questo mese\n/scorsomese - statistiche dello scorso mese\n/report - report sul software della stazione\n/aiuto - pagina di aiuto\n/web - pagina web\n/badge - badge con riassunto dei dati correnti","reply_to_message_id" => $DATA["message"]["message_id"]]);
}
//var_dump(API("setWebHook",["url"=>"https://liceococito.edu.it/meteo/telegram.php"]));
$DATA = json_decode(file_get_contents("php://input"), true);
if ($DATA["message"]["from"]["is_bot"]) {
    exit;
}
$message = strtolower(trim($DATA["message"]["text"]));

if (!count(glob("data/2*"))) {
   API("sendMessage", ["chat_id" => $DATA["message"]["chat"]["id"], "text" => "I dati sono in fase di aggiornamento, riprova tra poco","reply_to_message_id" => $DATA["message"]["message_id"]]);
    exit;
}

switch($message){
    case "/meteo":
        API("sendMessage", ["chat_id" => $DATA["message"]["chat"]["id"], "text" => "Dati Meteorologici:\nUltimo aggiornamento: ".$dataL["update"]."\n--------------\nTemperatura: ".n($dataL["T"])." °C\n Umidità: ".n($dataL["H"])." %\n Pressione: ".n($dataL["P"])." hPa\n PM10: ".n($dataL["PM10"])." µg/m³\nPM2.5: ".n($dataL["PM25"])."µg/m³\nFumo e vapori infiammabili: ".n($dataL["S"])."µg/m³","reply_to_message_id" => $DATA["message"]["message_id"]]);
    break;
    case "/start":
    API("sendMessage", ["chat_id" => $DATA["message"]["chat"]["id"], "text" => "Benvenuto sul bot della Stazione Meteo del Liceo Cocito","reply_to_message_id" => $DATA["message"]["message_id"]]);
     help($DATA);
     break;
    case "/aiuto":
            help($DATA);
      break;
     case "/report":
      $text = file_get_contents("https://raw.githubusercontent.com/StazioneMeteoCocito/dati/main/report.txt");
     API("sendMessage", ["chat_id" => $DATA["message"]["chat"]["id"], "text" => $text,"reply_to_message_id" => $DATA["message"]["message_id"]]);
       break;
      case "/web":
        API("sendMessage", ["chat_id" => $DATA["message"]["chat"]["id"], "text" => "https://liceococito.edu.it/meteo","reply_to_message_id" => $DATA["message"]["message_id"]]);
       break;
       case "/oggi":
           timestats($DATA,"today");
      break;
      case "/ieri":
           timestats($DATA,"yesterday");
      break;
      case "/questasettimana":
           timestats($DATA,"weekly");
      break;
   case "/scorsasettimana":
           timestats($DATA,"weeklyprev");
      break;
case "/questomese":
           timestats($DATA,"thismonth");
      break;
   case "/scorsomese":
           timestats($DATA,"prevmonth");
      break;
    case "/badge":
    API("sendPhoto", ["chat_id" => $DATA["message"]["chat"]["id"], "photo" => "https://liceococito.edu.it/meteo/wwidget.php?int=" . random_int(0, 10000), "reply_to_message_id" => $DATA["message"]["message_id"]]);
        
    break;
        default:
             help($DATA);  
        break;
}
