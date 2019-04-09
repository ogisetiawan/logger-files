<?php 
namespace snowytech\stphplogger;

/**
* @author  Drew D. Lenhart - snowytech
* @since   May 29, 2016
* @link    https://github.com/snowytech/st-php-logger
* @version 1.0.0
*/

class logWriter {

    protected $log_file;
    protected $file;
    protected $options = array(
        'dateFormat' => 'd-M-Y H:i:s'
    );

    public function __construct($log_file = 'error.txt', $params = array()){
        $this->log_file = $log_file;
        $this->params = array_merge($this->options, $params);

        //Create log file if it doesn't exist.
        if(!file_exists($log_file)){               
            fopen($log_file, 'w') or exit("Can't create $log_file!");
        }

        //Check permissions of file.
        if(!is_writable($log_file)){   
            //throw exception if not writable
            throw new Exception("ERROR: Unable to write to file!", 1);
        }
    }

    public function info($message){
        $this->writeLog($message, 'INFO');
    }

    public function debug($message){
        $this->writeLog($message, 'DEBUG');
    }

    public function warning($message){
        $this->writeLog($message, 'WARNING');	
    }

    public function success($message){
        $this->writeLog($message, 'SUCCESS');
    }

    public function error($message){
        $this->writeLog($message, 'ERROR');	
    }

    /**
    * Write to log file
    * @param string $message
    * @param string $severity
    * @return void
    */
    public function writeLog($message, $severity) {
        // open log file
        if (!is_resource($this->file)) {
            $this->openLog();
        }
        // grab the url path ( for troubleshooting )
        $path = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];

        //Grab time - based on timezone in php.ini
        $time = date($this->params['dateFormat']);

        // Write time, url, & message to end of file
        // fwrite($this->file, "[$time] [$path] : [$severity] - $message" . PHP_EOL);
        fwrite($this->file, "[$time] : [$severity] | $message" . PHP_EOL);
    }
    private function openLog(){
        $openFile = $this->log_file;
        // 'a' option = place pointer at end of file
        $this->file = fopen($openFile, 'a') or exit("Can't open $openFile!");
    }
    
    public function __destruct(){
        if ($this->file) {
            fclose($this->file);
        }
    }

    public function formatSizeUnits($bytes){
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
  
}