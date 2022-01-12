<!DOCTYPE html>
<html>
<title>Stazione Meteo</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<style>
    .w3-magenta {
        background-color: #d80073;
    }

    .progress-line,
    .progress-line:before {
        height: 3px;
        width: 100%;
        margin: 0;
        height: 15px;
    }

    .progress-line {
        background-color: #b3d4fc;
        display: -webkit-flex;
        display: flex;
    }

    .progress-line:before {
        background-color: #3f51b5;
        content: '';
        -webkit-animation: running-progress 2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        animation: running-progress 2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
    }

    @-webkit-keyframes running-progress {
        0% {
            margin-left: 0px;
            margin-right: 100%;
        }

        50% {
            margin-left: 25%;
            margin-right: 0%;
        }

        100% {
            margin-left: 100%;
            margin-right: 0;
        }
    }

    @keyframes running-progress {
        0% {
            margin-left: 0px;
            margin-right: 100%;
        }

        50% {
            margin-left: 25%;
            margin-right: 0%;
        }

        100% {
            margin-left: 100%;
            margin-right: 0;
        }
    }

    #pline {
        display: none;
    }
</style>

<body class="w3-theme-l4">

    <div style="min-width:400px">

        <div class="w3-bar w3-large w3-theme-d4">

            <span class="w3-bar-item">
                <h1>Stazione Meteo Permanente del Liceo Scientifico Statale "Leonardo Cocito"</h1>
                <hr />

                <div id="cdivS" style="width: 100%; height: 200px;">
                    <div class="row">

                        <div class="column">
                            <div id="GT" class="card"></div>
                        </div>

                        <div class="column">
                            <div id="GH" class="card"></div>
                        </div>

                        <div class="column">
                            <div id="GP" class="card"></div>
                        </div>
                        <div class="column">
                        </div>

                        <div class="column">
                            <div id="GPM10" class="card"></div>
                        </div>

                        <div class="column">
                            <div id="GPM25" class="card"></div>
                        </div>

                        <div class="column">
                            <div id="GS" class="card"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column" style="width:80vw">
                            <p><b>Ultimo Aggiornamento:
                                    <?php echo date("d/m/Y H:i:s", file_get_contents("lastContact")); ?>
                                </b></p>
                        </div>
                    </div>
                </div>
                <style>
                    /* Float four columns side by side */
                    .column {
                        float: left;
                        width: 25%;
                        padding: 0 10px;
                    }

                    /* Remove extra left and right margins, due to padding */
                    .row {
                        margin: 0 -5px;
                    }

                    /* Clear floats after the columns */
                    .row:after {
                        content: "";
                        display: table;
                        clear: both;
                    }

                    /* Responsive columns */
                    /*@media screen and (max-width: 600px) {
                        .column {
                            width: 100%;
                            display: block;
                            margin-bottom: 20px;
                        }
                    }*/
                    @media screen and (max-width: 600px) {
                        .card {
                            padding-right: 20px !important;
                            padding-top: 20px !important;

                        }
                    }

                    /* Style the counter cards */
                    .card {
                        padding-right: 16px;
                        padding-top: 16px;
                        text-align: center;
                    }
                </style>


                <script>
                    var dq = null;

                    function cdivS() {

                        var dataT = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            ['Temperatura', 0]
                        ]);
                        var optionsT = {
                            min: -20,
                            max: 40,
                            yellowFrom: 20,
                            yellowTo: 30,
                            redFrom: 30,
                            redTo: 40,
                            greenFrom: -20,
                            greenTo: 25,
                            minorTicks: 10,
                            width: screen.width / 4
                        };
                        var dataH = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            ['Umidità', 0]
                        ]);

                        var optionsH = {
                            min: 0,
                            max: 110,
                            yellowFrom: 50,
                            yellowTo: 85,
                            redFrom: 85,
                            redTo: 110,
                            greenFrom: 0,
                            greenTo: 50,
                            minorTicks: 10,
                            width: screen.width / 4
                        };
                        var dataP = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            ['Pressione', 0]
                        ]);

                        var optionsP = {
                            min: 900,
                            max: 1100,
                            yellowFrom: 950,
                            yellowTo: 1000,
                            redFrom: 900,
                            redTo: 950,
                            greenFrom: 1000,
                            greenTo: 1100,
                            minorTicks: 10,
                            width: screen.width / 4
                        };


                        var optionsPM10 = {
                            min: 0,
                            max: 150,
                            yellowFrom: 40,
                            yellowTo: 50,
                            redFrom: 50,
                            redTo: 150,
                            greenFrom: 0,
                            greenTo: 40,
                            minorTicks: 10,
                            width: screen.width / 4
                        };
                        var dataPM10 = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            ['PM10', 0]
                        ]);
                        var optionsPM25 = {
                            min: 0,
                            max: 150,
                            minorTicks: 10,
                            width: screen.width / 4,
                            yellowFrom: 20,
                            yellowTo: 25,
                            redFrom: 25,
                            redTo: 150,
                            greenFrom: 0,
                            greenTo: 20

                        };
                        var dataPM25 = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            ['PM2,5', 0]
                        ]);

                        var optionsS = {
                            min: 0,
                            max: 1000,
                            minorTicks: 10,
                            width: screen.width / 4,
                            yellowFrom: 50,
                            yellowTo: 300,
                            redFrom: 300,
                            redTo: 1000,
                            greenFrom: 0,
                            greenTo: 50
                        };
                        var dataS = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            ['Fumo', 0]
                        ]);

                        var tch = new google.visualization.Gauge(document.getElementById('GT'));
                        tch.draw(dataT, optionsT);
                        var hch = new google.visualization.Gauge(document.getElementById('GH'));
                        hch.draw(dataH, optionsH);
                        var pch = new google.visualization.Gauge(document.getElementById('GP'));
                        pch.draw(dataP, optionsP);
                        var pm10ch = new google.visualization.Gauge(document.getElementById('GPM10'));
                        pm10ch.draw(dataPM10, optionsPM10);
                        var pm25ch = new google.visualization.Gauge(document.getElementById('GPM25'));
                        pm25ch.draw(dataPM25, optionsPM25);
                        var pmSch = new google.visualization.Gauge(document.getElementById('GS'));
                        pmSch.draw(dataS, optionsS);

                        setInterval(function() {
                            dataT.setValue(0, 1, dq["T"]);
                            tch.draw(dataT, optionsT);
                        }, 5000);
                        setInterval(function() {
                            dataH.setValue(0, 1, dq["H"])
                            hch.draw(dataH, optionsH);
                        }, 5000);
                        setInterval(function() {
                            dataP.setValue(0, 1, dq["P"])
                            pch.draw(dataP, optionsP);
                        }, 5000);
                        setInterval(function() {
                            dataPM10.setValue(0, 1, dq["PM10"])
                            pm10ch.draw(dataPM10, optionsPM10);
                        }, 5000);
                        setInterval(function() {
                            dataPM25.setValue(0, 1, dq["PM25"])
                            pm25ch.draw(dataPM25, optionsPM25);
                        }, 5000);
                        setInterval(function() {
                            dataS.setValue(0, 1, dq["S"])
                            pmSch.draw(dataS, optionsS);
                        }, 5000);

                        $.get("recent.php").done(function(data) {
                            dq = JSON.parse(data);
                            dataT.setValue(0, 1, dq["T"]);
                            tch.draw(dataT, optionsT);
                            dataH.setValue(0, 1, dq["H"])
                            hch.draw(dataH, optionsH);
                            dataP.setValue(0, 1, dq["P"])
                            pch.draw(dataP, optionsP);
                            dataPM10.setValue(0, 1, dq["PM10"])
                            pm10ch.draw(dataPM10, optionsPM10);
                            dataPM25.setValue(0, 1, dq["PM25"])
                            pm25ch.draw(dataPM25, optionsPM25);
                            dataS.setValue(0, 1, dq["S"])
                            pmSch.draw(dataS, optionsS);

                        });
                    }
                    setInterval(function() {
                        $.get("recent.php").done(function(data) {
                            dq = JSON.parse(data);
                        });
                    }, 5000);
                    google.charts.load('46', {
                        'packages': ['corechart', 'gauge', 'table', 'calendar'],
                        "language": "it"
                    });
                    google.charts.setOnLoadCallback(cdivS);
                </script>
            </span>

            <div class="w3-bar w3-black">
                <a href="#" id="graphics" class="mainB w3-bar-item w3-button w3-mobile" data-dropdown="yes">Grafici</a>
                <a href="#" id="datas" class="mainB w3-bar-item w3-button w3-mobile" data-dropdown="yes">Dati</a>
                <a href="https://github.com/MatMasIt/weatherStation/raw/main/documents/ws.pdf" class="mainB w3-bar-item w3-button w3-mobile" target="_blank">Informazioni sul progetto</a>
                <a href="https://github.com/StazioneMeteoCocito/dati" class="mainB w3-bar-item w3-button w3-mobile">Archivio</a>
                <a href="https://github.com/MatMasIt/weatherStation" class="mainB w3-bar-item w3-button w3-mobile">Open
                    Source</a>

                <a id="activity" class="mainB w3-bar-item w3-button w3-mobile">Attività</a>

            </div>
            <div class="w3-bar" id="datatype">
                <a href="#" class="w3-bar-item w3-button w3-mobile w3-red dt" data-type="T">Temperatura</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile w3-blue dt" data-type="H">Umidità</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile w3-green dt" data-type="P">Pressione</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile w3-cyan dt" data-type="PM10">PM10</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile w3-magenta dt" data-type="PM25">PM2.5</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile w3-orange dt" data-type="S">Fumo e vapori
                    infiammabili</a>
            </div>
            <div class="w3-bar w3-black" id="when">
                <a href="#" class="w3-bar-item w3-button w3-mobile td" data-when="today">Oggi</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile td" data-when="yesterday">Ieri</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile td" data-when="weekly">Questa settimana</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile td" data-when="weeklyprev">Settimana precedente</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile td" data-when="thismonth">Questo mese</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile td" data-when="prevmonth">Lo scorso mese</a>
            </div>

        </div>
        <div class="progress-line"></div>
        <script>
            $(".progress-line").hide();
            var intent = "",
                datatype = "",
                when = "";
            $(".mainB").click(function() {

                if ($(this).attr("id") != "graphics") $("#plottingArea").hide();
                if ($(this).attr("id") != "activity") $("#actTab").hide();
                else {
                    tabDraw();
                    $("#actTab").show();
                }
                $(".mainB:not([id=" + ($(this).attr("id")) + "])").removeClass("w3-grey");
                intent = $(this).attr("id");
                if (!$(this).hasClass("w3-grey") && $(this).attr("data-dropdown") == "yes") {
                    $(".mainB[id=" + ($(this).attr("id")) + "]").addClass("w3-grey");
                    $("#datatype").show();

                } else {
                    $(".mainB[id=" + ($(this).attr("id")) + "]").removeClass("w3-grey");
                    $("#datatype").hide();
                    $("#when").hide();
                }
            });


            $(".dt").click(function() {
                $("#when").removeClass("w3-black");
                $("#when").removeClass("w3-red");
                $("#when").removeClass("w3-blue");
                $("#when").removeClass("w3-green");
                $("#when").removeClass("w3-cyan");
                $("#when").removeClass("w3-magenta");
                $("#when").removeClass("w3-orange");
                if ($(this).hasClass("w3-red")) $("#when").addClass("w3-red");
                else if ($(this).hasClass("w3-blue")) $("#when").addClass("w3-blue");
                else if ($(this).hasClass("w3-green")) $("#when").addClass("w3-green");
                else if ($(this).hasClass("w3-cyan")) $("#when").addClass("w3-cyan");
                else if ($(this).hasClass("w3-magenta")) $("#when").addClass("w3-magenta");
                else if ($(this).hasClass("w3-orange")) $("#when").addClass("w3-orange");
                $(".dt:not([data-type=" + ($(this).attr("data-type")) + "])").removeClass("w3-grey");
                datatype = $(this).attr("data-type");
                if (!$(this).hasClass("w3-grey")) {
                    $(".dt[id=" + ($(this).attr("id")) + "]").addClass("w3-grey");
                    $("#when").show();

                } else {
                    $(".mainB[id=" + ($(this).attr("id")) + "]").removeClass("w3-grey");

                    $("#when").hide();
                }
            });
            $(".td").click(function() {
                when = $(this).attr("data-when");
                $(".progress-line").show();
                $.get("data.php", {
                        "when": when,
                        "dataType": datatype
                    })

                    .done(function(data) {

                        if (!data["data"].length) {
                            $("#noContent").show();
                            $("#plot").hide();
                        } else {
                            $("#noContent").hide();
                            $("#plot").show();
                        }
                        $(".progress-line").hide();

                        if (when == "weekly" || when == "weeklyprev" || when == "thismonth" || when == "prevmonth") {
                            if (intent == "datas") tableDisplay(data);
                            else weekDisplay(data);
                        } else {
                            if (intent == "datas") tableDisplay(data);
                            else dayDisplay(data);
                        }

                    });



            });
        </script>
        <div class="w3-container w3-content" id="landing">
            <div class="w3-panel w3-white w3-card w3-display-container">
                <p>Il progetto "Stazione meteo" raccoglie dati dalla stazione Meteo Permanente del Liceo Scientifico
                    Leonardo Cocito</p>
            </div>
        </div>



        <div class="w3-container w3-content">
            <div id="actTab" style="">
                <div id="calendar_basic" style="width: 1000px;height: 350px;"></div>
            </div>
            <div id="plottingArea">
                <p class="w3-opacity"><b id="plottingTitle"></b></p>
                <div class="w3-panel w3-white w3-card w3-display-container">
                    <div id="noContent">
                        <center>
                            <h2>Nessun Contenuto</h2>
                        </center>
                    </div>
                    <div id="plot"></div>
                    <div class="w3-card-4" id="dTable">

                    </div>
                    <table class="w3-table-all w3-card-4">
                        <tr>
                            <th>Media</th>
                            <th>Minimo</th>
                            <th>Massimo</th>
                            <th>Deviazione Standard</th>
                            <th>Moda</th>
                            <th>Numero rilevazioni</th>
                        </tr>
                        <tr>
                            <td id="avg"></td>
                            <td id="min"></td>
                            <td id="max"></td>
                            <td id="stdev"></td>
                            <td id="mode"></td>
                            <td id="setSize"></td>
                        </tr>
                    </table>
                </div>


            </div>

        </div>

</body>
<script>
    function dayDisplay(result) {

        $("#avg").html(result["stats"]["avg"]);
        $("#min").html(result["stats"]["min"]);
        $("#max").html(result["stats"]["max"]);
        $("#stdev").html(result["stats"]["stdev"]);
        $("#setSize").html(result["stats"]["setSize"]);
        $("#mode").html(result["stats"]["mode"]);
        $("#plottingArea").show();
        $("#plot").show();
        $("#dTable").hide();
        $("#plottingTitle").text(result["periodName"]);
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'X');
        data.addColumn('number', result["yAxis"]);

        var list = [];
        result["data"].forEach(function iterate(element) {
            list.push([new Date(element["time"] * 1000), element["value"]]);
        });
        data.addRows(list);
        var date_formatter = new google.visualization.DateFormat({
            pattern: "dd MMM yyyy HH:mm:ss"
        });
        date_formatter.format(data, 0);
        var options = {
            hAxis: {
                title: 'Tempo'
            },
            vAxis: {
                title: result["yAxis"] + "( " + result["unit"] + " )"
            },
            colors: [result["color"]],
            curveType: "function"
        };

        var chart = new google.visualization.LineChart(document.getElementById('plot'));


        chart.draw(data, options);
    }


    function tabDraw() {
        $.get("heatmap.php").done(function(data) {
            var results = JSON.parse(data);
            var dataTable = new google.visualization.DataTable();
            dataTable.addColumn({
                type: 'date',
                id: 'Data'
            });
            dataTable.addColumn({
                type: 'number',
                id: 'Misurazioni'
            });
            var list = [];
            Object.keys(results).forEach(function iterate(key) {
                list.push([new Date(key * 1000), results[key]]);
            });
            dataTable.addRows(list);

            var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

            var options = {
                title: "Misurazioni giornaliere",
                height: 350,
            };

            chart.draw(dataTable, options);
        });
    }

    function tableDisplay(result) {

        $("#avg").html(result["stats"]["avg"]);
        $("#min").html(result["stats"]["min"]);
        $("#max").html(result["stats"]["max"]);
        $("#stdev").html(result["stats"]["stdev"]);
        $("#setSize").html(result["stats"]["setSize"]);
        $("#mode").html(result["stats"]["mode"]);
        $("#plot").hide();
        $("#plottingTitle").text(result["periodName"]);
        $("#dTable").show();
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Istante');
        data.addColumn('number', 'Valore');
        var tlist = [],
            ind = 1;
        result["data"].forEach(function iterate(element) {
            tlist.push([{
                v: new Date(element["time"] * 1000),
                f: (new Date(element["time"] * 1000)).toLocaleString()
            }, {
                v: element["value"],
                f: element["value"].toFixed(2) + " " + result["unit"]
            }]);
            ind++;
        });
        data.addRows(tlist);


        var table = new google.visualization.Table(document.getElementById('dTable'));

        table.draw(data, {
            showRowNumber: true,
            width: '100%',
            height: '100%'
        });


        $("#plottingArea").show();
    }

    function weekDisplay(result) {

        $("#avg").html(result["stats"]["avg"]);
        $("#min").html(result["stats"]["min"]);
        $("#max").html(result["stats"]["max"]);
        $("#stdev").html(result["stats"]["stdev"]);
        $("#setSize").html(result["stats"]["setSize"]);
        $("#mode").html(result["stats"]["mode"]);
        $("#plottingArea").show();
        $("#dTable").hide();
        $("#plottingTitle").text(result["periodName"]);
        $("#plot").show();
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'X');
        data.addColumn('number', result["yAxis"]);

        var list = [];
        result["data"].forEach(function iterate(element) {
            list.push([new Date(element["time"] * 1000), element["value"]]);
        });
        data.addRows(list);
        var date_formatter = new google.visualization.DateFormat({
            pattern: "dd MMM yyyy HH:mm:ss"
        });
        var date_formatter = new google.visualization.DateFormat({
            pattern: "dd MMM yyyy HH:mm:ss"
        });
        date_formatter.format(data, 0);


        var tickList = [];
        result["days"].forEach(function iterate(element) {
            tickList.push({
                v: new Date(element["jsUnix"]),
                f: element["label"]
            });
        });
        var options = {

            vAxis: {
                title: result["yAxis"] + "( " + result["unit"] + " )"
            },
            colors: [result["color"]],
            curveType: "function",
            hAxis: {
                title: 'Giorni',
                ticks: tickList
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('plot'));


        chart.draw(data, options);
    }
    $("#datatype").hide();
    $("#when").hide();
    $("#plottingArea").hide();
</script>

</html>
