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
    $.get("heatmap.php").done(function (data) {
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