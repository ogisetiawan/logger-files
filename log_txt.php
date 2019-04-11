<?php
require 'st-php-logger.php';
date_default_timezone_set("Asia/Bangkok");
$path    = __DIR__."/files/";
$date    = date('d-M-Y');
$time    = str_replace(":", "-", date('H:i:s'));
$format  = "log_".$date."_".$time;
$format2 = "log_".$date; 
$log     = new snowytech\stphplogger\logWriter('logs/'.$format2.'.txt');

foreach (new DirectoryIterator(__DIR__ . '/files/') as $file) {
    if ($file->isFile()) {
        $file_name = $file->getFilename();
        $file_size = filesize(__DIR__ . '/files/'.$file_name);
        $json_data = file_get_contents(__DIR__ . '/files/'.$file_name);
        $json_row  = count(json_decode($json_data,true));

        if (strpos($file_name, '_inv') !== false) {
            $str = $file_name."\t\t\t";
        }elseif(strpos($file_name, '_sls') !== false) {
            $str = $file_name."\t\t\t";
        }elseif(strpos($file_name, '_kasbank') !== false){
            $str = $file_name."\t\t";
        }
        $log->success("[FILE_NAME]:".$str."| [SIZE]:".$log->formatSizeUnits($file_size)."\t| [ROW]:".$json_row);
    }
}

echo "created-log ->".$format2;