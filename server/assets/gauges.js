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

    setInterval(function () {
        dataT.setValue(0, 1, dq["T"]);
        let formatter = new google.visualization.NumberFormat(
            {suffix: '°C',pattern:'#'}
        );
        formatter.format(dataT,1);
        tch.draw(dataT, optionsT);
    }, 5000);
    setInterval(function () {
        dataH.setValue(0, 1, dq["H"]);
        let formatter = new google.visualization.NumberFormat(
            {suffix: '%',pattern:'#'}
        );
        formatter.format(dataH,1);
        hch.draw(dataH, optionsH);
    }, 5000);
    setInterval(function () {
        dataP.setValue(0, 1, dq["P"]);
        let formatter = new google.visualization.NumberFormat(
            {suffix: 'hPa',pattern:'#'}
        );
        formatter.format(dataP,1);
        pch.draw(dataP, optionsP);
    }, 5000);
    setInterval(function () {
        dataPM10.setValue(0, 1, dq["PM10"]);
        let formatter = new google.visualization.NumberFormat(
            {suffix: 'µg/m³',pattern:'#'}
        );
        formatter.format(dataPM10,1);
        pm10ch.draw(dataPM10, optionsPM10);
    }, 5000);
    setInterval(function () {
        dataPM25.setValue(0, 1, dq["PM25"]);
         let formatter = new google.visualization.NumberFormat(
            {suffix: 'µg/m³',pattern:'#'}
        );
        formatter.format(dataPM25,1);
        pm25ch.draw(dataPM25, optionsPM25);
    }, 5000);
    setInterval(function () {
        dataS.setValue(0, 1, dq["S"]);
         let formatter = new google.visualization.NumberFormat(
            {suffix: 'µg/m³',pattern:'#'}
        );
        formatter.format(dataS,1);
        pmSch.draw(dataS, optionsS);
    }, 5000);

    $.get("recent.php").done(function (data) {
        dq = JSON.parse(data);
        $("#lastU").html(dq["update"]);
        dataT.setValue(0, 1, dq["T"]);
        let formatter = new google.visualization.NumberFormat(
            {suffix: '°C',pattern:'#'}
        );
        formatter.format(dataT,1);
        tch.draw(dataT, optionsT);
        dataH.setValue(0, 1, dq["H"]);
        formatter = new google.visualization.NumberFormat(
            {suffix: '%',pattern:'#'}
        );
        formatter.format(dataH,1);
        hch.draw(dataH, optionsH);
        dataP.setValue(0, 1, dq["P"]);
        formatter = new google.visualization.NumberFormat(
            {suffix: 'hPa',pattern:'#'}
        );
        formatter.format(dataP,1);
        pch.draw(dataP, optionsP);
        dataPM10.setValue(0, 1, dq["PM10"]);
        formatter = new google.visualization.NumberFormat(
            {suffix: 'µg/m³',pattern:'#'}
        );
        formatter.format(dataPM10,1);
        pm10ch.draw(dataPM10, optionsPM10);
        dataPM25.setValue(0, 1, dq["PM25"]);
        formatter = new google.visualization.NumberFormat(
            {suffix: 'µg/m³',pattern:'#'}
        );
        formatter.format(dataPM25,1);
        pm25ch.draw(dataPM25, optionsPM25);
        dataS.setValue(0, 1, dq["S"])
        formatter = new google.visualization.NumberFormat(
            {suffix: 'µg/m³',pattern:'#'}
        );
        formatter.format(dataS,1);
        pmSch.draw(dataS, optionsS);

    });
}
setInterval(function () {
    $.get("recent.php").done(function (data) {
        dq = JSON.parse(data);
        $("#lastU").html(dq["update"]);
    });
}, 5000);
google.charts.load('46', {
    'packages': ['corechart', 'gauge', 'table', 'calendar'],
    "language": "it"
});
google.charts.setOnLoadCallback(cdivS);
