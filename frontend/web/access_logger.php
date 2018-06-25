<?php
/**
 * Created by PhpStorm.
 * User: Etrex
 * Date: 17.12.2015
 * Time: 19:20
 */
//error_reporting(E_ERROR);//E_ERROR); //E_ALL
//ini_set("display_errors", 1);

define('aclog_access_logger_debug' , false);
define('aclog_is_bot_checker' , true);
define('aclog_url_decode' , true);

function access_logger($file_path = "accessLogFile.log", $data = array()) {

    if($file_path==false){
        $file_path = "accessLogFile.log";
    }

    //ASSIGN VARIABLES TO USER INFO
    $time = date("Y-m-d H:i:s");

    if(isset($_SERVER['HTTP_X_REAL_IP']) and $_SERVER['HTTP_X_REAL_IP']!=false){
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR']; // $_SERVER['REMOTE_ADDR'] getenv('REMOTE_ADDR');
    }

    $userAgent = getenv('HTTP_USER_AGENT');
    $referrer = getenv('HTTP_REFERER');
    if(aclog_url_decode){
        $referrer = urldecode($referrer);
    }

    $query = getenv('QUERY_STRING');
    if(aclog_url_decode){
        $query = urldecode($query);
    }


    $botStr = '';
    if(aclog_is_bot_checker){
        if(strpos($userAgent,'bingbot',0)!=false){
            $botStr = ' BOT: bingbot ; ';
        }
        elseif(strpos($userAgent,'crawl',0)!=false){
            $botStr = ' BOT: crawler; ';
        }
        elseif(strpos($userAgent,'bot',0)!=false){
            $botStr = ' BOT: ; ';
        }
    }

    $str = '';
    if(!empty($data)){
        foreach($data as $key=>$value){
            $str .= "$key: ".$value. "; ";
        }
    }

    //COMBINE VARS INTO OUR LOG ENTRY
    $msg = "" . $time ."; IP: " . $ip . "; " . $botStr . $str . "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "; REFERRER: " . $referrer . "; SEARCHSTRING: " . $query . "; USERAGENT: " . $userAgent . "; ";

    $msg = iconv( "utf-8", "windows-1251", $msg );

    $today = date("Y_m_d");
    $logfile = $today."_log.txt";
    $dir = 'logs';
    //$saveLocation = $dir . '/' . $logfile;

    $saveLocation = $file_path;
    $fileSize = filesize($saveLocation);
    if(aclog_access_logger_debug) { var_dump('$fileSize: ' .$fileSize);echo '<br />'; }

    if(file_exists($saveLocation)){

        $reV = 1;
        $clearFile = false;
        $limitStr = 50000; //20000

        if($reV === 1){
            // 1500 - 11 lines
            $proportion = 500;

            $sizer = $limitStr*$proportion;

            if($fileSize>$sizer){
                $clearFile = true;
            }
        }else{
            $file = file($saveLocation);
            $sizer = sizeof($file,1);

            if($sizer>=$limitStr){
                $clearFile = true;
            }
            if(aclog_access_logger_debug) { var_dump('Prop: ' . ($fileSize/$sizer));echo '<br />'; }
        }

        if(aclog_access_logger_debug) { var_dump('$sizer: ' .$sizer);echo '<br />'; }
    }

    if  (!$handle = @fopen($saveLocation, "a+")) {
        if (!file_exists($saveLocation)) {
            echo 'file not exists '. $saveLocation;exit;
        }
    }
    else {

        //ftruncatestart($file_path, 150000);
        $lineLimit = 1000;

        if($clearFile){
            ftruncate($handle, 0); // 2000 line // $limitStr*$lineLimit
        }

        if (@fwrite($handle,"$msg\r\n", $lineLimit) === FALSE) {
            exit;
        }

        @fclose($handle);
    }
}



