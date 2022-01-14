$(".progress-line").hide();
var intent = "",
    datatype = "",
    when = "";
$(".mainB").click(function () {
    if ($(this).attr("id") != "graphics") $("#plottingArea").hide();
    if ($(this).attr("id") != "activity") $("#actTab").hide();
    else {
        tabDraw();
        $("#actTab").show();
        $("#plottingArea").hide();
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
    sView();
});


$(".dt").click(function () {
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
    sView();
});

function sView() {
    if (typeof when == 'undefined' || !when || typeof intent == 'undefined' || !intent || typeof datatype == 'undefined' || !datatype) return false;
    if (intent == "activity") return false;
    $(".progress-line").show();
    $.get("data.php", {
        "when": when,
        "dataType": datatype
    })

        .done(function (data) {

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
}
$(".td").click(function () {
    when = $(this).attr("data-when");
    sView();

});
setInterval(function () {
    sView();
}, 30 * 1000);