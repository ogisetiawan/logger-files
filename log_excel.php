<?php
function formatSizeUnits($bytes){
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }
    return $bytes;
}

date_default_timezone_set("Asia/Bangkok");
$path     = __DIR__."/files/";
$date     = date('d-M-Y');
$dateTime = date('d-M-Y H:i:s');
$time     = str_replace(": ", "-", date('H: i: s'));
$format   = "log_".$date."_".$time;
$format2  = "log_".$date; 

// header("Content-type: application/vnd-ms-excel");
// ob_end_clean();
?>
<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
}
</style>
</head>
<body>
<h1 style="text-align:center">Logger Console Data JSON</h1>
<table border="1" cellpadding="10" cellspacing="0" style="font:'Candara';">
  <thead>
    <tr>
	<font style="font-size:'16';  font-family:'Candara';">
      <th bgcolor="#b3e0ff" >Created Time</th>
      <th bgcolor="#b3e0ff">File Name</th>
      <th bgcolor="#b3e0ff">File Size</th>
      <th bgcolor="#b3e0ff" >File Row</th>
    </tr>
  </thead>
  <tbody>
    <?php
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
    ?>
            <tr>
                <td align ="center"><?= $dateTime; ?></td>
                <td align ="center"><?= $str; ?></td>
                <td align ="center"><?= formatSizeUnits($file_size); ?></td>
                <td align ="center"><?= $json_row; ?></td>
            </tr>
    <?php
        }
    }
    ?>
</tbody>
</table>
