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
</style>

<body class="w3-theme-l4">

    <div style="min-width:400px">

        <div class="w3-bar w3-large w3-theme-d4">

            <span class="w3-bar-item">Stazione Meteo Permanente del Liceo Scientifico Statale "Leonardo Cocito"</span>

            <div class="w3-bar w3-black">
                <a href="#" id="graphics" class="mainB w3-bar-item w3-button w3-mobile" data-dropdown="yes">Grafici</a>
                <a href="#" id="datas" class="mainB w3-bar-item w3-button w3-mobile" data-dropdown="yes">Dati</a>
                <a href="#" class="mainB w3-bar-item w3-button w3-mobile" id="infoB">Informazioni sul progetto</a>
                <a href="#" class="mainB w3-bar-item w3-button w3-mobile" id="archB">Archivio</a>
            </div>
            <div class="w3-bar" id="datatype">
                <a href="#" class="w3-bar-item w3-button w3-mobile w3-red dt" data-type="T">Temperatura</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile w3-blue dt" data-type="H">Umidità</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile w3-green dt" data-type="P">Pressione</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile w3-cyan dt" data-type="PM10">PM10</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile w3-magenta dt" data-type="PM25">PM2.5</a>
                <a href="#" class="w3-bar-item w3-button w3-mobile w3-orange dt" data-type="S">Fumo e vapori infiammabili</a>
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
        <script>
            var intent = "",
                datatype = "",
                when = "";
            $(".mainB").click(function() {
                if ($(this).attr("id") != "graphics") $("#plottingArea").hide();
                if ($(this).attr("id") == "archB") $("#archive").show();
                else $("#archive").hide();
                if ($(this).attr("id") == "infoB") $("#info").show();
                else $("#info").hide();
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

                $.get("data.php", {
                        "when": when,
                        "dataType": datatype
                    })

                    .done(function(data) {

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
                <p>Il progetto "Stazione meteo" raccoglie dati dalla stazione Meteo Permanente del Liceo Scientifico Leonardo Cocito</p>
                <p class="w3-text-blue"><b>Ultimo Aggiornamento: <?php echo date("d/m/Y H:i:s", file_get_contents("lastContact")); ?></b></p>

            </div>
        </div>

        <div class="w3-container w3-content" id="info" style="height:510px">
            <div class="w3-panel w3-white w3-card w3-display-container">
                <embed src="https://drive.google.com/viewerng/
viewer?embedded=true&url=https://github.com/MatMasIt/weatherStation/raw/main/documents/ws.pdf" style="width:100%;height:500px">

            </div>
        </div>

        <div class="w3-container w3-content">

            <div id="plottingArea">
                <p class="w3-opacity"><b id="plottingTitle"></b></p>
                <div class="w3-panel w3-white w3-card w3-display-container">
                    <div id="plot"></div>
                    <table class="w3-table-all w3-card-4" id="dTable">
                    </table>
                </div>
                <table class="w3-table-all w3-card-4">
                    <tr>
                        <th>Media</th>
                        <th>Minimo</th>
                        <th>Massimo</th>
                        <th>Deviazione Standard</th>
                        <th>Numero rilevazioni</th>
                    </tr>
                    <tr>
                        <td id="avg"></td>
                        <td id="min"></td>
                        <td id="max"></td>
                        <td id="stdev"></td>
                        <td id="setSize"></td>
                    </tr>
                </table>
            </div>
            <div id="archive">
                <p class="w3-opacity"><b>Ricerca storica</b></p>
                <div class="w3-panel w3-white w3-card w3-display-container">

                    <form method="GET" action="report.php">
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
                            <select class="w3-select" name="interval">
                                <option value="all" selected>Tutte le registrazioni</option>
                                <option value="daily">Giornaliero</option>
                                <option value="weekly">Settimanale</option>
                                <option value="monthly">Mensile</option>
                                <option value="yearly">Annuale</option>
                            </select>
                        </p>
                        <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
                        <p>Tipologie di dati</p>
                        <p>
                            <input class="w3-check" type="checkbox" name="T" checked="checked">
                            <label>Temperatura</label>
                        </p>
                        <p>
                            <input class="w3-check" type="checkbox" name="H">
                            <label>Umidità</label>
                        </p>
                        <p>
                            <input class="w3-check" type="checkbox" name="P">
                            <label>Pressione</label>
                        </p>
                        <p>
                            <input class="w3-check" type="checkbox" name="PM10">
                            <label>PM10</label>
                        </p>
                        <p>
                            <input class="w3-check" type="checkbox" name="PM25">
                            <label>PM2.5</label>
                        </p>
                        <p>
                            <input class="w3-check" type="checkbox" name="S">
                            <label>Fumo e vapori infiammabili</label>
                        </p>
                        <p>
                            <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
                        <p>
                            <label>Esportazione Dati</label>
                            <select class="w3-select" name="option">
                                <option value="web">Pagina Web</option>
                                <option value="json">JSON</option>
                                <option value="xml">XML</option>
                                <option value="csv">CSV</option>
                                <option value="latex">LaTeX</option>

                            </select>
                        </p>


                        <hr style="height:2px;border-width:0;color:#3a4b53;background-color:#3a4b53" />
                        <button class="w3-btn w3-blue-grey" style="float:right"><i class="fa fa-search"></i> Ricerca</button>
                    </form>
                </div>
            </div>

        </div>

    </div>

</body>
<script>
    google.charts.load('current', {
        packages: ['corechart', 'line'],
        "language": "it"
    });


    function dayDisplay(result) {

        $("#avg").html(result["stats"]["avg"]);
        $("#min").html(result["stats"]["min"]);
        $("#max").html(result["stats"]["max"]);
        $("#stdev").html(result["stats"]["stdev"]);
        $("#setSize").html(result["stats"]["setSize"]);
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
                title: result["yAxis"]+"( "+result["unit"]+" )"
            },
            colors: [result["color"]],
            curveType: "function"
        };

        var chart = new google.visualization.LineChart(document.getElementById('plot'));


        chart.draw(data, options);
    }

    function tableDisplay(result) {

        $("#avg").html(result["stats"]["avg"]);
        $("#min").html(result["stats"]["min"]);
        $("#max").html(result["stats"]["max"]);
        $("#stdev").html(result["stats"]["stdev"]);
        $("#setSize").html(result["stats"]["setSize"]);
        $("#plot").hide();
        $("#dTable").show();
        var html = "<tr><th>Istante</th><th>Valore</th></tr>";
        var list = [];
        result["data"].forEach(function iterate(element) {
            html += "<tr><td>" + (new Date(element["time"] * 1000)).toLocaleString() + "</td><td>" + element["value"].toFixed(2)   +" "+ result["unit"] +"</td></tr>";
        });

        $("#dTable").html(html);
        $("#plottingArea").show();
    }

    function weekDisplay(result) {

        $("#avg").html(result["stats"]["avg"]);
        $("#min").html(result["stats"]["min"]);
        $("#max").html(result["stats"]["max"]);
        $("#stdev").html(result["stats"]["stdev"]);
        $("#setSize").html(result["stats"]["setSize"]);
        $("#plottingArea").show();
        $("#dTable").hide();
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
                title: result["yAxis"]+"( "+result["unit"]+" )"
            },
            colors: [result["color"]],
            curveType: "function",
            hAxis: {
                title: 'Giorni',
                ticks: []
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('plot'));


        chart.draw(data, options);
    }
    $("#datatype").hide();
    $("#when").hide();
    $("#plottingArea").hide();
    $("#info").hide();
    $("#archive").hide();
</script>

</html>
