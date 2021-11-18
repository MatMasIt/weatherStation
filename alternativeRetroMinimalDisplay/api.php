<?php
$storedDataPath = "storedData";
$days = glob($storedDataPath . "/*");
krsort($days);
$lastDay = $days[0];
$data = ["S" => 0.0, "H" => 0.0, "T" => 0.0, "P" => 0.0, "PM10" => 0.0, "PM25" => 0.0];
$flags = ["S" => false, "H" => false, "T" => false, "P" => false, "PM10" => false, "PM25" => false];
$chunkPaths = glob($lastDay . "/*.csv");
krsort($chunkPaths);
$currentChunk = 0;
$currentChLine = 0;
$lastChunkFile = file($chunkPaths[$currentChunk]);
while (!$flags["S"] || !$flags["H"] || !$flags["T"] || !$flags["P"] || !$flags["PM10"] || !$flags["PM25"]) {
    if ($currentChLine > (count($lastChunkFile) - 1)) {
        $currentChunk++;
        $currentChLine = 0;
        $lastChunkFile = file($chunkPaths[$currentChunk]);
        continue;
    }
    $la = explode(",", $lastChunkFile[$currentChLine]);
    $flags[$la[1]] = true;
    $data[$la[1]] = (float)$la[2];
    $currentChLine++;
}
header("Content-Type: application/json");
echo json_encode($data);