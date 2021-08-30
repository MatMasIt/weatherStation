<?php
$f=file("php://input");
if($f[0]=="TOKEN"){
	if(count($f)<2) exit;
}
$afs=[];
for($i=1;$i<count($f);$i++){
	$beginDay=strtotime(date("Y-m-d",explode(",",$f[$i])[0]));
	$afs[$beginDay].=$f[$i];
}
foreach(array_keys($afs) as $b){
	file_put_contents("dataServer/".$b.".csv",$afs[$b],FILE_APPEND);
}
file_put_contents("lastContact",time());
