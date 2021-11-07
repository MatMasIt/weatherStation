<?php
$files = glob("dataServer/*.csv");
usort($files, function ($a, $b) {
return filemtime($b) - filemtime($a);
}); 
$record_count  = (int)$_GET["pageSize"]?:20;
$total_pages   = ceil(count($files)/$record_count);
$page          = (int)$_GET['page']?:1; 
$offset        = ($page-1)*$record_count;
$files_filter  = array_slice($files, $offset,$record_count);
$fList = [];
foreach($files_filter as $f){
	$fList[]=[
    		"file"=>$f,
    		"md5"=>md5_file($f)
    	];
}
$res = json_encode(
	[
    	"files"=>$fList,
        "totalPages"=>$total_pages
    ],
    JSON_PRETTY_PRINT
);
header("Content-Type: application/json");
header("Content-Length: ".strlen($res));
echo $res;
