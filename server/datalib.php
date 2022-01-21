<?php
if (!function_exists('stats_standard_deviation')) {
    /**
     * This user-land implementation follows the implementation quite strictly;
     * it does not attempt to improve the code or algorithm in any way. It will
     * raise a warning if you have fewer than 2 values in your array, just like
     * the extension does (although as an E_USER_WARNING, not E_WARNING).
     *
     * @param array $a
     * @param bool $sample [optional] Defaults to false
     * @return float|bool The standard deviation or false on error.
     */
    function stats_standard_deviation(array $a, $sample = false)
    {
        $n = count($a);
        if ($n === 0) {
            trigger_error("The array has zero elements", E_USER_WARNING);
            return false;
        }
        if ($sample && $n === 1) {
            trigger_error("The array has only 1 element", E_USER_WARNING);
            return false;
        }
        $mean = array_sum($a) / $n;
        $carry = 0.0;
        foreach ($a as $val) {
            $d = ((float) $val) - $mean;
            $carry += $d * $d;
        };
        if ($sample) {
            --$n;
        }
        return sqrt($carry / $n);
    }
}
function weekOfMonth($date)
{
    //Get the first day of the month.
    $firstOfMonth = strtotime(date("Y-m-01", $date));
    //Apply above formula.
    return weekOfYear($date) - weekOfYear($firstOfMonth) + 1;
}

function weekOfYear($date)
{
    $weekOfYear = intval(date("W", $date));
    if (date('n', $date) == "1" && $weekOfYear > 51) {
        // It's the last week of the previos year.
        return 0;
    } else if (date('n', $date) == "12" && $weekOfYear == 1) {
        // It's the first week of the next year.
        return 53;
    } else {
        // It's a "normal" week.
        return $weekOfYear;
    }
}

function weeks_in_month($month, $year)
{
    // Start of month
    $start = mktime(0, 0, 0, $month, 1, $year);
    // End of month
    $end = mktime(0, 0, 0, $month, date('t', $start), $year);
    // Start week
    $start_week = date('W', $start);
    // End week
    $end_week = date('W', $end);

    if ($end_week < $start_week) { // Month wraps
        return ((52 + $end_week) - $start_week) + 1;
    }

    return ($end_week - $start_week) + 1;
}
function get_daily($d, $m, $y, $t)
{
    $mapping = ["T" => "temperature.csv", "H" => "humidity.csv", "P" => "pressure.csv", "PM10" => "pm10.csv", "PM25" => "pm25.csv", "S" => "smoke.csv"];
    if (!in_array($t, array_keys($mapping))) return [];
    $y =  $y ?: date("Y");
    $m =  $m ?: date("m");
    $d =  $d ?: date("d");
    $filePath = "data/$y/$m/$d/" . $mapping[$t];
    if (!file_exists($filePath)) return [];
    $f = file($filePath);
    $list = [];
    foreach ($f as $l) {
        $d = explode(",", $l);
        if (($t == "P" || $t == "H")  && $d[1] < 1) continue;
        $list[] = ["type" => $t, "time" => strtotime($d[0]), "value" => (float)$d[1]];
    }
    return $list;
}
function get_weekly($w, $m, $y, $t, $monthForce = 0)
{
    $data = ["data" => []];
    if ($w == null) $w = weekOfMonth(date("U"));
    if ($m == null) $m = date("m");
    if ($y == null)    $y = date("Y");
    $begin = strtotime("monday this week", strtotime("+ " . (($w - 1) * 7) . " days", strtotime("$y-$m-01")));
    $end = strtotime("next monday", $begin);
    for ($i = $begin; $i < $end; $i += floor(($end - $begin) / 7)) {
        if ($monthForce != 0 && date("m", $i) != $monthForce) continue;
        $q = get_daily(date("d", $i), date("m", $i), date("Y", $i), $t);
        if (count($q) == 0) continue;

        $data["data"] = array_merge($data["data"], $q);
        $data["days"][] = ["jsUnix" => $i * 1000, "label" => date("d/m/Y", $i)];
    }

    return $data;
}
function get_stats($data)
{
    $avgTot = 0;
    $avgNum = 0;
    $max = -111111111111;
    $min = 1111111111111111;
    $allData = [];
    $modeMap = [];
    foreach ($data as $e) {
        $avgTot += $e["value"];
        $allData[] = $e["value"];
        $avgNum++;
        $max = max($max, $e["value"]);
        $min = min($min, $e["value"]);
        $modeMap[(string)(int)$e["value"]]++;
    }
    $finalIntegerMode = -1000000000;
    $imodeCount = -1;
    foreach ($modeMap as $value => $occurrence) {
        if ($occurrence > $imodeCount) {
            $finalIntegerMode = $value;
            $imodeCount = $occurrence;
        }
    }
    if ($avgNum == 0) return ["avg" => 0, "max" => 0, "min" => 0, "stdev" => 0, "setSize" => 0];
    return ["avg" => $avgTot / $avgNum, "max" => $max, "min" => $min, "stdev" => stats_standard_deviation($allData), "setSize" => $avgNum, "mode" => $finalIntegerMode];
}
