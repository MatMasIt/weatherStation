<?php
require("myzip.php");
function recursiveDelete($str)
{
  if (in_array($str, $GLOBALS["dontTouch"])) return false;
  if (is_file($str)) {
    return @unlink($str);
  } elseif (is_dir($str)) {
    $scan = glob(rtrim($str, '/') . '/*');
    foreach ($scan as $index => $path) {
      recursiveDelete($path);
    }
    return @rmdir($str);
  }
}
recursiveDelete("data");
$a = file_get_contents("https://github.com/StazioneMeteoCocito/dati/archive/refs/heads/main.zip");
file_put_contents("down.zip", $a);

$zip = new my_ZipArchive();
if ($zip->open("down.zip") === TRUE) {
  $errors = $zip->extractSubdirTo("data", "dati-main");
  $zip->close();

  echo 'ok, errors: ' . count($errors);
} else {
  echo 'failed';
}
