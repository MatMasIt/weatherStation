<?php
require("rlib.php");
//Set the Content Type
header('Content-type: image/jpeg');
function nformat($n){
    return number_format($n,2,",","'");
}
$w = 300;
$h = 500;
// Create White image
$img = imagecreate($w,$h);

$bg = imagecolorallocate ( $img, 255, 255, 255 );
$blue = imagecolorallocate($img, 0, 0, 255);
$red = imagecolorallocate($img, 255, 0, 0);
$green = imagecolorallocate($img,0,255,0);
$pm10 = imagecolorallocate($img,0,96,255);
imagefilledrectangle($img,0,0,$w,$h,$bg);

// Allocate A Color For The Text
$black = imagecolorallocate($img, 0, 0, 0);

// Set Path to Font File
$font_path = 'Roboto-Thin.ttf';

// Print Text On Image
imagettftext($img, 20, 0, 20, 50, $black, $font_path, "Stazione Meteo");

imageline($img,20,60,200,60,$black);

imagettftext($img,15,0,20,85,$black,$font_path,"Ultimo aggiornamento:\n ".date("d/m/Y H:i:s",file_get_contents("lastContact")));

imagettftext($img, 20,0,20,140,$red,$font_path,"Temperatura:\n ".nformat($dataL["T"])." C");

imagettftext($img,20,0,20,220,$blue,$font_path,"Umidita':\n ".nformat($dataL["H"])." %");


imagettftext($img,20,0,20,300,$green,$font_path,"Pressione:\n ".nformat($dataL["P"])." hPa");


imagettftext($img,20,0,20,380,$pm10,$font_path,"PM10:\n ".nformat($dataL["PM10"])." mug/m3");
// Send Image to Browser
imagejpeg($img);

// Clear Memory
imagedestroy($img);
?>
