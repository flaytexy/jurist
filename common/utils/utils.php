<?php

function strpos_arr($haystack, $needle) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $what) {
        if(($pos = strpos($haystack, $what))!==false) return $pos;
    }
    return false;
}

if ( ! function_exists('timing'))
{

    /**
     * @param $name
     * @param bool $startTime
     *
     * @return float $time // status: null-stop, true-start, false-show time difference
     */
    function timing($name, $startTime = false){
        return time_diff($name,$startTime);
    }

    /**
     * @param $name
     * @param bool $startTime
     *
     * @return float $time // status: null-stop, true-start, false-show time difference
     */
    function time_diff($name, $startTime = false) {
        global $timers;

        if($startTime===false){
            if (isset($timers[$name]['start'])) {
                $stop = microtime(TRUE);
                $diff = round(($stop - $timers[$name]['start']) * 1000, 2);

                if (isset($timers[$name]['time'])) {
                    $diff += $timers[$name]['time'];
                }
                return $diff;
            }

            if(isset($timers[$name]['time']))
                return $timers[$name]['time'];

        }elseif($startTime===2 or $startTime==="stop"){
            //echo 'startTime===stop<br />';
            if (isset($timers[$name]['start'])) {
                $stop = microtime(TRUE);
                $diff = round(($stop - $timers[$name]['start']) * 1000, 2);
                if (isset($timers[$name]['time'])) {
                    $timers[$name]['time'] += $diff;
                }
                else {
                    $timers[$name]['time'] = $diff;
                }
                unset($timers[$name]['start']);
            }
        }elseif( $startTime==true){
            if(empty($timers[$name]['start']))
                $timers[$name]['start'] = microtime(TRUE);

            $timers[$name]['count'] = isset($timers[$name]['count']) ? ++$timers[$name]['count'] : 1;
        }elseif($startTime===3 or $startTime===null or $startTime==="delete"){
            unset($timers[$name]);
        }
    }
}

timing('project_start', 1);
//$outPrintDebug = '';

if ( ! function_exists('e_print'))
{
    function e_print( $element, $text="", $debugIndex = 0, $callFuncEcho = 'print_r')
    {
        $ips = array('127.0.0.1', '195.211.139.66', '188.163.72.20', '188.163.78.34', '195.211.144.161');

        //ob_start();

        if (in_array($_SERVER['REMOTE_ADDR'], $ips)
            || (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && in_array( $_SERVER['HTTP_X_FORWARDED_FOR'], $ips ))
        ){

            if(empty($element))
                $callFuncEcho = 'var_dump';
            elseif(empty($callFuncEcho))
                $callFuncEcho = 'print_r';

            $time = timing('project_start');
            if($time==false)
                timing('project_start', 1);

            $debug = debug_backtrace();
            echo"<font color=#8a2be2>".$debug[$debugIndex]["file"]."</font>:<font color=red>".$debug[$debugIndex]["line"];
            echo"</font> (".timing('project_start').")<br /><font style='font-size:14px;color:darkmagenta;'> ( $text ): </font><pre>";
            call_user_func($callFuncEcho, $element);
            echo"</pre><br />";
        }

        //$outPrintDebug = ob_get_clean();
    }

    function ex_print( $element, $text="", $debugIndex = 1, $callFuncEcho = 'print_r')
    {
        $ips = array('127.0.0.1', '195.211.139.66', '188.163.72.20', '188.163.78.34', '195.211.144.161'); // 195.211.139.66 // 185.117.240.76

        if (in_array($_SERVER['REMOTE_ADDR'], $ips)
            || (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && in_array( $_SERVER['HTTP_X_FORWARDED_FOR'], $ips ))
        ){
            e_print( $element, $text, $debugIndex, $callFuncEcho);
            exit;
        }
    }

    function e_varDump( $element, $text="", $debugIndex = 1, $callFuncEcho = 'var_dump')
    {
        e_print( $element, $text, $debugIndex, $callFuncEcho);
    }

    function ex_varDump( $element, $text="", $debugIndex = 1, $callFuncEcho = 'var_dump')
    {
        e_print( $element, $text, $debugIndex, $callFuncEcho);
        exit;
    }
}

if ( ! function_exists('strpos_array')) {
    function strpos_array($haystack, $needle) {
        if(!is_array($needle)) $needle = array($needle);
        foreach($needle as $what) {
            if(($pos = strpos($haystack, $what))!==false) return $pos;
        }
        return false;
    }
}
