<?php
require("commonLib.php");
$today=get_daily();
$dataT=filterList($today,["T"]);
$statsT=get_stats($dataT);
$dataH=filterList($today,["H"]);
$statsH=get_stats($dataH);
$dataP=filterList($today,["P"]);
$statsP=get_stats($dataP);
$dataPM10=filterList($today,["PM10"]);
$statsPM10=get_stats($dataPM10);
$dataPM25=filterList($today,["PM25"]);
$statsPM25=get_stats($dataPM25);
$dataS=filterList($today,["S"]);
$statsS=get_stats($dataS);
$yesterday=get_daily(date("d",strtotime("yesterday")),date("m",strtotime("yesterday")),date("Y",strtotime("yesterday")));
$YdataT=filterList($yesterday,["T"]);
$YstatsT=get_stats($YdataT);
$YdataH=filterList($yesterday,["H"]);
$YstatsH=get_stats($YdataH);
$YdataP=filterList($yesterday,["P"]);
$YstatsP=get_stats($YdataP);
$YdataPM10=filterList($yesterday,["PM10"]);
$YstatsPM10=get_stats($YdataPM10);
$YdataPM25=filterList($yesterday,["PM25"]);
$YstatsPM25=get_stats($YdataPM25);
$YdataS=filterList($yesterday,["S"]);
$YstatsS=get_stats($YdataS);
$ww=get_weekly();
$week=$ww["list"];
$WdataT=filterList($week,["T"]);
$WstatsT=get_stats($WdataT);
$WdataH=filterList($week,["H"]);
$WstatsH=get_stats($WdataH);
$WdataP=filterList($week,["P"]);
$WstatsP=get_stats($WdataP);
$WdataPM10=filterList($week,["PM10"]);
$WstatsPM10=get_stats($WdataPM10);
$WdataPM25=filterList($week,["PM25"]);
$WstatsPM25=get_stats($WdataPM25);
$WdataS=filterList($week,["S"]);
$WstatsS=get_stats($WdataS);

$wwp=weekOfMonth(strtotime("last week"));
$month=date("m",strtotime("last week"));
$year=date("y",strtotime("last week"));
$wp=get_weekly($wwp,$month,$year);
$Pweek=$wp["list"];
$WPdataT=filterList($Pweek,["T"]);
$WPstatsT=get_stats($WPdataT);
$WPdataH=filterList($Pweek,["H"]);
$WPstatsH=get_stats($WPdataH);
$WPdataP=filterList($Pweek,["P"]);
$WPstatsP=get_stats($WPdataP);
$WPdataPM10=filterList($Pweek,["PM10"]);
$WPstatsPM10=get_stats($WPdataPM10);
$WPdataPM25=filterList($Pweek,["PM25"]);
$WPstatsPM25=get_stats($WPdataPM25);
$WPdataS=filterList($Pweek,["S"]);
$WPstatsS=get_stats($WPdataS);


?>
<!DOCTYPE html>
<html>
<title>Stazione Meteo</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <style>
 .loader{
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url('loader.gif') 
              50% 50% no-repeat rgb(249,249,249);
}

</style>
<body class="w3-theme-l4">

<div style="min-width:400px">

<div class="w3-bar w3-large w3-theme-d4">
  
  <span class="w3-bar-item">Stazione Meteo</span>
 
</div>

<div class="w3-container w3-content">
 <p class="w3-opacity"><b>Dati di Oggi</b></p> 
 <div class="w3-panel w3-white w3-card w3-display-container"> 
<p>Il progetto "Stazione meteo" raccoglie dati dalla stazione Meteo Permanente del Liceo Scientifico Leonardo Cocito</p>
   <p class="w3-text-blue"><b>Ultimo Aggiornamento: <?php echo date("d/m/Y H:i:s",file_get_contents("lastContact")); ?></b></p>
  
 </div>
 </div>
 
<div class="w3-container w3-content">
 <p class="w3-opacity"><b>Dati di Oggi</b></p> 
 <div class="w3-panel w3-white w3-card w3-display-container"> 
 <div id="temp"></div>
 <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($statsT["avg"],2,",","'")." °C</td>";
 	echo "<td>".number_format($statsT["min"],2,",","'")." °C</td>";
 	echo "<td>".number_format($statsT["max"],2,",","'")." °C</td>";
 	echo "<td>".number_format($statsT["stdev"],2,",","'")." °C</td>";
 	echo "<td>".number_format($statsT["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="hum"></div>
     <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($statsH["avg"],2,",","'")." %</td>";
 	echo "<td>".number_format($statsH["min"],2,",","'")." %</td>";
 	echo "<td>".number_format($statsH["max"],2,",","'")." %</td>";
 	echo "<td>".number_format($statsH["stdev"],2,",","'")." %</td>";
 	echo "<td>".number_format($statsH["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
   
    <div id="pressure"></div>
     <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($statsP["avg"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($statsP["min"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($statsP["max"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($statsP["stdev"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($statsP["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
   
    <div id="pm10"></div>
    <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($statsPM10["avg"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($statsPM10["min"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($statsPM10["max"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($statsPM10["stdev"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($statsPM10["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="pm25"></div>
    <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($statsPM25["avg"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($statsPM25["min"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($statsPM25["max"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($statsPM25["stdev"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($statsPM25["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="smoke"></div>
    <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($statsS["avg"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($statsS["min"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($statsS["max"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($statsS["stdev"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($statsS["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
   
 </div>
 
 <p class="w3-opacity"><b>Dati di Ieri</b></p>

 <div class="w3-panel w3-white w3-card w3-display-container"> 
 	<div id="Ytemp"></div>
     <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($YstatsT["avg"],2,",","'")." °C</td>";
 	echo "<td>".number_format($YstatsT["min"],2,",","'")." °C</td>";
 	echo "<td>".number_format($YstatsT["max"],2,",","'")." °C</td>";
 	echo "<td>".number_format($YstatsT["stdev"],2,",","'")." °C</td>";
 	echo "<td>".number_format($YstatsT["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="Yhum"></div>
    
     <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($YstatsH["avg"],2,",","'")." %</td>";
 	echo "<td>".number_format($YstatsH["min"],2,",","'")." %</td>";
 	echo "<td>".number_format($YstatsH["max"],2,",","'")." %</td>";
 	echo "<td>".number_format($YstatsH["stdev"],2,",","'")." %</td>";
 	echo "<td>".number_format($YstatsH["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="Ypressure"></div>
     <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($YstatsP["avg"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($YstatsP["min"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($YstatsP["max"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($YstatsP["stdev"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($YstatsP["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="Ypm10"></div>
     <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($YstatsPM10["avg"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($YstatsPM10["min"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($YstatsPM10["max"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($YstatsPM10["stdev"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($YstatsPM10["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="Ypm25"></div>
    <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($YstatsPM25["avg"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($YstatsPM25["min"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($YstatsPM25["max"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($YstatsPM25["stdev"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($YstatsPM25["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="Ysmoke"></div>
    <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($YstatsS["avg"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($YstatsS["min"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($YstatsS["max"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($YstatsS["stdev"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($YstatsS["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>

 </div>
  <p class="w3-opacity"><b>Questa Settimana</b></p>
 <div class="w3-panel w3-white w3-card w3-display-container">
   <div id="Wtemp"></div>
     <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($WstatsT["avg"],2,",","'")." °C</td>";
 	echo "<td>".number_format($WstatsT["min"],2,",","'")." °C</td>";
 	echo "<td>".number_format($WstatsT["max"],2,",","'")." °C</td>";
 	echo "<td>".number_format($WstatsT["stdev"],2,",","'")." °C</td>";
 	echo "<td>".number_format($WstatsT["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="Whum"></div>
    <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($WstatsH["avg"],2,",","'")." %</td>";
 	echo "<td>".number_format($WstatsH["min"],2,",","'")." %</td>";
 	echo "<td>".number_format($WstatsH["max"],2,",","'")." %</td>";
 	echo "<td>".number_format($WstatsH["stdev"],2,",","'")." %</td>";
 	echo "<td>".number_format($WstatsH["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="Wpressure"></div>
    <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($WstatsP["avg"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WstatsP["min"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WstatsP["max"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WstatsP["stdev"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WstatsP["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="Wpm10"></div>
     <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($WstatsPM10["avg"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($WstatsPM10["min"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($WstatsPM10["max"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($WstatsPM10["stdev"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($WstatsPM10["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="Wpm25"></div>
     <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($WstatsPM25["avg"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($WstatsPM25["min"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($WstatsPM25["max"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($WstatsPM25["stdev"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($WstatsPM25["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
    <div id="Wsmoke"></div>
     <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($WstatsS["avg"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($WstatsS["min"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($WstatsS["max"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($WstatsS["stdev"],2,",","'")." µg/m³</td>";
 	echo "<td>".number_format($WstatsS["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 </div>
 
   <p class="w3-opacity"><b>Settimana Precedente</b></p>
 <div class="w3-panel w3-white w3-card w3-display-container">
   <div id="WPtemp"></div>
   <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($WPstatsT["avg"],2,",","'")." °C</td>";
 	echo "<td>".number_format($WPstatsT["min"],2,",","'")." °C</td>";
 	echo "<td>".number_format($WPstatsT["max"],2,",","'")." °C</td>";
 	echo "<td>".number_format($WPstatsT["stdev"],2,",","'")." °C</td>";
 	echo "<td>".number_format($WPstatsT["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="WPhum"></div>
    <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($WPstatsH["avg"],2,",","'")." %</td>";
 	echo "<td>".number_format($WPstatsH["min"],2,",","'")." %</td>";
 	echo "<td>".number_format($WPstatsH["max"],2,",","'")." %</td>";
 	echo "<td>".number_format($WPstatsH["stdev"],2,",","'")." %</td>";
 	echo "<td>".number_format($WPstatsH["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="WPpressure"></div>
    <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($WPstatsP["avg"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsP["min"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsP["max"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsP["stdev"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsP["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="WPpm10"></div>
     <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($WPstatsPM10["avg"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsPM10["min"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsPM10["max"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsPM10["stdev"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsPM10["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="WPpm25"></div> <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($WPstatsPM25["avg"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsPM25["min"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsPM25["max"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsPM25["stdev"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsPM25["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
    <div id="WPsmoke"></div>
     <table class="w3-table w3-bordered">
    <tr>
      <th>Media</th>
      <th>Minimo</th>
      <th>Massimo</th>
      <th>Deviazione Standard</th>
      <th>Numero rilevazioni</th>
    </tr>
    <tr>
 <?php
 	echo "<td>".number_format($WPstatsS["avg"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsS["min"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsS["max"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsS["stdev"],2,",","'")." hPa</td>";
 	echo "<td>".number_format($WPstatsS["setSize"],0,",","'")."</td>";
 ?>
 	</tr>
 </table>
 
 </div>
  <p class="w3-opacity"><b>Ricerca storica</b></p>
 <div class="w3-panel w3-white w3-card w3-display-container">

<form>
 <p> Periodo analizzato</p>
  <p>
  <label>Inizio</label>
  <input type="date" name="beginDate" placeholder="Data" class="w3-input">
  <input type="time" name="beginTime" placeholder="Ora" class="w3-input" value="00:00">
  <label>Fine</label>
  <input type="date" name="endDate" placeholder="Data" class="w3-input">
  <input type="time" name="endTime" placeholder="Ora" class="w3-input" value="00:00">
  </p>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
  <p>
  <label>Livello di Dettaglio</label>
   <select class="w3-select" name="option">
  <option value="1" selected>Tutte le registrazioni</option>
  <option value="2">Giornaliero</option>
  <option value="3">Settimanale</option>
  <option value="4">Mensile</option>
  <option value="5">Annuale</option>
  </select> 
  </p>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
  <p>Tipologie di dati</p>
   <p>
  <input class="w3-check" type="checkbox" checked="checked">
  <label>Temperatura</label></p>
  <p>
  <input class="w3-check" type="checkbox">
  <label>Umidità</label></p>
  <p>
  <input class="w3-check" type="checkbox">
  <label>Pressione</label></p>
  <p>
  <input class="w3-check" type="checkbox">
  <label>PM10</label></p>
  <p>
  <input class="w3-check" type="checkbox">
  <label>PM2.5</label></p>
  <p>
  <input class="w3-check" type="checkbox">
  <label>Fumo e vapori infiammabili</label></p>
  <p>
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
  <p>
  <label>Esportazione Dati</label>
   <select class="w3-select" name="option">
  <option value="web">Pagina Web</option>
  <option value="json">JSON</option>
  <option value="xml">XML</option>
  <option value="csv">CSV</option>
  </select> 
  </p>
  
  
 <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
 <button class="w3-btn w3-blue-grey" style="float:right"><i class="fa fa-search"></i> Ricerca</button>
</form>
 </div>

 
</div>

</div>

</body>
<script>
var drawed=0,toDraw=23;
function afterDraw(){
	drawed++;
    if(drawed>=toDraw)document.getElementsByClassName("loader")[0].style.display="none";
}
 google.charts.load('current', {packages: ['corechart', 'line'],"language":"it"});
google.charts.setOnLoadCallback(drawAll);
function drawTemp() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Temperatura');

      data.addRows([
       <?php
       $i=0;
       foreach($dataT as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($dataT)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
      var options = {
        hAxis: {
          title: 'Tempo'
        },
        vAxis: {
          title: 'Temperatura'
        },
        colors:["red"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('temp'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);
      chart.draw(data, options);
    }
function drawH() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Umidità');

      data.addRows([
       <?php
       $i=0;
       foreach($dataH as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($dataH)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
      var options = {
        hAxis: {
          title: 'Tempo'
        },
        vAxis: {
          title: 'Umidità'
        },
        colors:["blue"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('hum'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function drawP() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Pressione');

      data.addRows([
       <?php
       $i=0;
       foreach($dataP as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($dataP)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
      var options = {
        hAxis: {
          title: 'Tempo'
        },
        vAxis: {
          title: 'Pressione'
        },
        colors:["green"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('pressure'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function drawPM10() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'PM10');

      data.addRows([
       <?php
       $i=0;
       foreach($dataPM10 as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($dataPM10)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
      var options = {
        hAxis: {
          title: 'Tempo'
        },
        vAxis: {
          title: 'PM10 (µg/m³)'
        },
        colors:["cyan"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('pm10'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function drawPM25() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'PM2.5');

      data.addRows([
       <?php
       $i=0;
       foreach($dataPM25 as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($dataPM25)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
        hAxis: {
          title: 'Tempo'
        },
        vAxis: {
          title: 'PM2.5 (µg/m³)'
        },
        colors:["magenta"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('pm25'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function smoke() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Fumo e vapori infiammabili');

      data.addRows([
       <?php
       $i=0;
       foreach($dataS as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($dataS)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
        hAxis: {
          title: 'Tempo'
        },
        vAxis: {
          title: 'Fumo e vapori infiammabili (µg/m³)'
        },
        colors:["orange"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('smoke'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
    function YdrawTemp() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Temperatura');

      data.addRows([
       <?php
       $i=0;
       foreach($YdataT as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($YdataT)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
        hAxis: {
          title: 'Tempo'
        },
        vAxis: {
          title: 'Temperatura'
        },
        colors:["red"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('Ytemp'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function YdrawH() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Umidità');

      data.addRows([
       <?php
       $i=0;
       foreach($YdataH as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($YdataH)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
        hAxis: {
          title: 'Tempo'
        },
        vAxis: {
          title: 'Umidità'
        },
        colors:["blue"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('Yhum'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function YdrawP() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Pressione');

      data.addRows([
       <?php
       $i=0;
       foreach($YdataP as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($YdataP)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
        hAxis: {
          title: 'Tempo'
        },
        vAxis: {
          title: 'Pressione'
        },
        colors:["green"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('Ypressure'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function YdrawPM10() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'PM10');

      data.addRows([
       <?php
       $i=0;
       foreach($YdataPM10 as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($YdataPM10)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
        hAxis: {
          title: 'Tempo'
        },
        vAxis: {
          title: 'PM10 (µg/m³)'
        },
        colors:["cyan"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('Ypm10'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function YdrawPM25() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'PM2.5');

      data.addRows([
       <?php
       $i=0;
       foreach($YdataPM25 as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($YdataPM25)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
        hAxis: {
          title: 'Tempo'
        },
        vAxis: {
          title: 'PM2.5 (µg/m³)'
        },
        colors:["magenta"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('Ypm25'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function Ysmoke() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Fumo e vapori infiammabili');

      data.addRows([
       <?php
       $i=0;
       foreach($YdataS as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($YdataS)-1) echo ",";
       $i++;
       }
       ?>
      ]);
 var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     
      var options = {
        hAxis: {
          title: 'Tempo'
        },
        vAxis: {
          title: 'Fumo e vapori infiammabili (µg/m³)'
        },
        colors:["orange"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('Ysmoke'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
    
    
    
function WdrawTemp() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Temperatura');

      data.addRows([
       <?php
       $i=0;
       foreach($WdataT as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($WdataT)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
         hAxis:{ 
        title: 'Giorni',
        	    ticks:[
        	        <?php
        	        $i=0;
        	        foreach($ww["days"] as $d){
        	     echo "{v:new Date(".$d["jsUNIX"]."),f:'".addcslashes($d["label"],"'")."'}";
        	     if($i!=count($ww["days"])-1) echo ",";
        	        }
        	        ?>
        	    ]
        },
        vAxis: {
          title: 'Temperatura'
        },
        colors:["red"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('Wtemp'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function WdrawH() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Umidità');

      data.addRows([
       <?php
       $i=0;
       foreach($WdataH as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($WdataH)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
       hAxis:{ 
        title: 'Giorni',
        	    ticks:[
        	        <?php
        	        $i=0;
        	        foreach($ww["days"] as $d){
        	     echo "{v:new Date(".$d["jsUNIX"]."),f:'".addcslashes($d["label"],"'")."'}";
        	     if($i!=count($ww["days"])-1) echo ",";
        	        }
        	        ?>
        	    ]
        },
        vAxis: {
          title: 'Umidità'
        },
        colors:["blue"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('Whum'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function WdrawP() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Pressione');

      data.addRows([
       <?php
       $i=0;
       foreach($WdataP as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($WdataP)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
         hAxis:{ 
        title: 'Giorni',
        	    ticks:[
        	        <?php
        	        $i=0;
        	        foreach($ww["days"] as $d){
        	     echo "{v:new Date(".$d["jsUNIX"]."),f:'".addcslashes($d["label"],"'")."'}";
        	     if($i!=count($ww["days"])-1) echo ",";
        	        }
        	        ?>
        	    ]
        },
        vAxis: {
          title: 'Pressione'
        },
        colors:["green"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('Wpressure'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function WdrawPM10() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'PM10');

      data.addRows([
       <?php
       $i=0;
       foreach($WdataPM10 as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($WdataPM10)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
         hAxis:{ 
        title: 'Giorni',
        	    ticks:[
        	        <?php
        	        $i=0;
        	        foreach($ww["days"] as $d){
        	     echo "{v:new Date(".$d["jsUNIX"]."),f:'".addcslashes($d["label"],"'")."'}";
        	     if($i!=count($ww["days"])-1) echo ",";
        	        }
        	        ?>
        	    ]
        },
        vAxis: {
          title: 'PM10 (µg/m³)'
        },
        colors:["cyan"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('Wpm10'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function WdrawPM25() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'PM2.5');

      data.addRows([
       <?php
       $i=0;
       foreach($WdataPM25 as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($WdataPM25)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
         hAxis:{ 
        title: 'Giorni',
        	    ticks:[
        	        <?php
        	        $i=0;
        	        foreach($ww["days"] as $d){
        	     echo "{v:new Date(".$d["jsUNIX"]."),f:'".addcslashes($d["label"],"'")."'}";
        	     if($i!=count($ww["days"])-1) echo ",";
        	        }
        	        ?>
        	    ]
        },
        vAxis: {
          title: 'PM2.5 (µg/m³)'
        },
        colors:["magenta"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('Wpm25'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function Wsmoke() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Fumo e vapori infiammabili');

      data.addRows([
       <?php
       $i=0;
       foreach($WdataS as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($WdataS)-1) echo ",";
       $i++;
       }
       ?>
      ]);
 var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     
      var options = {
       
        vAxis: {
          title: 'Fumo e vapori infiammabili (µg/m³)'
        },
        colors:["orange"],
        curveType:"function",
        hAxis:{ 
        title: 'Giorni'
        ,
        	    ticks:[
        	        <?php
        	        $i=0;
        	        foreach($ww["days"] as $d){
        	     echo "{v:new Date(".$d["jsUNIX"]."),f:'".addcslashes($d["label"],"'")."'}";
        	     if($i!=count($ww["days"])-1) echo ",";
        	        }
        	        ?>
        	    ]
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('Wsmoke'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
    
    
      
function WPdrawTemp() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Temperatura');

      data.addRows([
       <?php
       $i=0;
       foreach($WPdataT as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($WPdataT)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
         hAxis:{ 
        title: 'Giorni'
        ,
        	   ticks:[
        	        <?php
        	        $i=0;
        	        foreach($wp["days"] as $d){
        	     echo "{v:new Date(".$d["jsUNIX"]."),f:'".addcslashes($d["label"],"'")."'}";
        	     if($i!=count($wp["days"])-1) echo ",";
        	        }
        	        ?>
        	    ]
        },
        vAxis: {
          title: 'Temperatura'
        },
        colors:["red"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('WPtemp'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function WPdrawH() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Umidità');

      data.addRows([
       <?php
       $i=0;
       foreach($WPdataH as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($WPdataH)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
       hAxis:{ 
        title: 'Giorni',
        	    ticks:[
        	        <?php
        	        $i=0;
        	        foreach($wp["days"] as $d){
        	     echo "{v:new Date(".$d["jsUNIX"]."),f:'".addcslashes($d["label"],"'")."'}";
        	     if($i!=count($wp["days"])-1) echo ",";
        	        }
        	        ?>
        	    ]
        },
        vAxis: {
          title: 'Umidità'
        },
        colors:["blue"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('WPhum'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function WPdrawP() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Pressione');

      data.addRows([
       <?php
       $i=0;
       foreach($WPdataP as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($WPdataP)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
         hAxis:{ 
        title: 'Giorni',
        	    ticks:[
        	        <?php
        	        $i=0;
        	        foreach($wp["days"] as $d){
        	     echo "{v:new Date(".$d["jsUNIX"]."),f:'".addcslashes($d["label"],"'")."'}";
        	     if($i!=count($wp["days"])-1) echo ",";
        	        }
        	        ?>
        	    ]
        },
        vAxis: {
          title: 'Pressione'
        },
        colors:["green"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('WPpressure'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function WPdrawPM10() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'PM10');

      data.addRows([
       <?php
       $i=0;
       foreach($WPdataPM10 as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($WPdataPM10)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
         hAxis:{ 
        title: 'Giorni',
        	    ticks:[
        	        <?php
        	        $i=0;
        	        foreach($wp["days"] as $d){
        	     echo "{v:new Date(".$d["jsUNIX"]."),f:'".addcslashes($d["label"],"'")."'}";
        	     if($i!=count($wp["days"])-1) echo ",";
        	        }
        	        ?>
        	    ]
        },
        vAxis: {
          title: 'PM10 (µg/m³)'
        },
        colors:["cyan"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('WPpm10'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function WPdrawPM25() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'PM2.5');

      data.addRows([
       <?php
       $i=0;
       foreach($WPdataPM25 as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($WPdataPM25)-1) echo ",";
       $i++;
       }
       ?>
      ]);
var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     var options = {
         hAxis:{ 
        title: 'Giorni',
        	    ticks:[
        	        <?php
        	        $i=0;
        	        foreach($wp["days"] as $d){
        	     echo "{v:new Date(".$d["jsUNIX"]."),f:'".addcslashes($d["label"],"'")."'}";
        	     if($i!=count($wp["days"])-1) echo ",";
        	        }
        	        ?>
        	    ]
        },
        vAxis: {
          title: 'PM2.5 (µg/m³)'
        },
        colors:["magenta"],
        curveType:"function"
      };

      var chart = new google.visualization.LineChart(document.getElementById('WPpm25'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
function WPsmoke() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Fumo e vapori infiammabili');

      data.addRows([
       <?php
       $i=0;
       foreach($WPdataS as $e){
       echo "[new Date(".($e["time"]*1000)."),".$e["value"]."]";
       if($i!=count($WPdataS)-1) echo ",";
       $i++;
       }
       ?>
      ]);
 var date_formatter = new google.visualization.DateFormat({ pattern: "dd MMM yyyy HH:mm:ss" }); date_formatter.format(data, 0);
     
      var options = {
       
        vAxis: {
          title: 'Fumo e vapori infiammabili (µg/m³)'
        },
        colors:["orange"],
        curveType:"function",
        hAxis:{ 
        title: 'Giorni',
        	    ticks:[
        	        <?php
        	        $i=0;
        	        foreach($wp["days"] as $d){
        	     echo "{v:new Date(".$d["jsUNIX"]."),f:'".addcslashes($d["label"],"'")."'}";
        	     if($i!=count($wp["days"])-1) echo ",";
        	        }
        	        ?>
        	    ]
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('WPsmoke'));
      google.visualization.events.addListener(chart, 'ready', afterDraw);

      chart.draw(data, options);
    }
    function drawAll(){
    	drawTemp();
        drawH();
        drawP();
        drawPM10();
        drawPM25();
        smoke();
    	YdrawTemp();
        YdrawH();
        YdrawP();
        YdrawPM10();
        YdrawPM25();
        Ysmoke();
    	WdrawTemp();
        WdrawH();
        WdrawP();
        WdrawPM10();
        WdrawPM25();
        Wsmoke();
    	WPdrawTemp();
        WPdrawH();
        WPdrawP();
        WPdrawPM10();
        WPdrawPM25();
        WPsmoke();
    }
 </script>
 <div class="loader"></div>
</html>
