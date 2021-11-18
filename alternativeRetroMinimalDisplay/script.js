var data = {
    "S": {
        "name": "Fumo",
        "uom": "μg/m³",
        "value": 0.00
    },
    "H": {
        "name": "Umidità",
        "uom": "%",
        "value": 0.00
    },
    "T": {
        "name": "Temperatura",
        "uom": "°C",
        "value": 0.00
    },
    "P": {
        "name": "Pressione",
        "uom": "hPa",
        "value": 0.00
    },
    "PM10": {
        "name": "PM10",
        "uom": "μg/m³",
        "value": 0.00
    },
    "PM25": {
        "name": "PM2,5",
        "uom": "μg/m³",
        "value": 0.00
    }
}
var keys = Object.keys(data);
var ki = 0;

function updateData() {
    var xmlhttp = new XMLHttpRequest();
    var url = "api.php";

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var myArr = JSON.parse(this.responseText);
            Object.keys(myArr).forEach(function iterate(val) {
                data[val]["value"] = parseFloat(myArr[val]).toFixed(2);
            });
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();

}
setInterval(updateData,10*60*1000);
updateData();
function showTime() {
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    if (!m % 4) {
        ki = 0;
        var session = "AM";

        if (h == 0) {
            h = 12;
        }

        if (h > 12) {
            h = h - 12;
            session = "PM";
        }

        h = (h < 10) ? "0" + h : h;
        m = (m < 10) ? "0" + m : m;
        s = (s < 10) ? "0" + s : s;

        var time = h + ":" + m + ":" + s + " " + session;
        document.getElementById("MyClockDisplay").innerText = time;
        document.getElementById("MyClockDisplay").textContent = time;
        setTimeout(showTime, 1000);
    }
    else {

        let timeW = 60 / keys.length, kObj = data[keys[ki]];
        document.getElementById("MyClockDisplay").innerHTML = kObj["name"] + "<br />" + kObj["value"] + " " + kObj["uom"];
        ki++;
        if (ki > (keys.length - 1)) ki = 0;
        setTimeout(showTime, timeW * 1000);
    }

}

showTime();