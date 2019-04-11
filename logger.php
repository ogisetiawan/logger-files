<?php
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $link = "https"; 
else
    $link = "http";

$link    .= "://"; 
$link    .= $_SERVER['SERVER_NAME']; 
$link    .= $_SERVER['REQUEST_URI']; 
$date     = date('d-M-Y');
$format2  = "log_".$date; 
$filename = "logs/".$format2.".xls";
$content  = file_get_contents($link."log_excel.php");
$file     = "logs/".$format2.".xls";
file_put_contents($file, $content);