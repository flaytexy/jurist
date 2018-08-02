<?php

if ( ! function_exists('e_print'))
{
    /**
     * @param string||array $element
     * @param string $text
     * @param int $debugIndex
     * @param string $callFuncEcho
     */
    function e_print( $element, $text="", $debugIndex = 0, $callFuncEcho = 'print_r')
    {
        $ips = array('127.0.0.1', '195.211.139.66', '188.163.72.20', '188.163.78.34'); // 195.211.139.66 // 185.117.240.76

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

            $debug = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 10);
            echo"<font color=#8a2be2>".$debug[$debugIndex]["file"]."</font>:<font color=red>".$debug[$debugIndex]["line"];
            echo"</font> (".timing('project_start').")<br /><font style='font-size:14px;color:darkmagenta;'> ( $text ): </font><pre>";
            call_user_func($callFuncEcho, $element);
            echo"</pre><br />";
        }
    }

    function ex_print( $element, $text="", $debugIndex = 1, $callFuncEcho = 'print_r')
    {
        $ips = array('127.0.0.1', '195.211.139.66', '188.163.72.20', '188.163.78.34'); // 195.211.139.66 // 185.117.240.76

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


function bla_tool (){
    $timezones = array(
        'Pacific/Midway'       => "(GMT-11:00) Midway Island",
        'US/Samoa'             => "(GMT-11:00) Samoa",
        'US/Hawaii'            => "(GMT-10:00) Hawaii",
        'US/Alaska'            => "(GMT-09:00) Alaska",
        'US/Pacific'           => "(GMT-08:00) Pacific Time (US &amp; Canada)",
        'America/Tijuana'      => "(GMT-08:00) Tijuana",
        'US/Arizona'           => "(GMT-07:00) Arizona",
        'US/Mountain'          => "(GMT-07:00) Mountain Time (US &amp; Canada)",
        'America/Chihuahua'    => "(GMT-07:00) Chihuahua",
        'America/Mazatlan'     => "(GMT-07:00) Mazatlan",
        'America/Mexico_City'  => "(GMT-06:00) Mexico City",
        'America/Monterrey'    => "(GMT-06:00) Monterrey",
        'Canada/Saskatchewan'  => "(GMT-06:00) Saskatchewan",
        'US/Central'           => "(GMT-06:00) Central Time (US &amp; Canada)",
        'US/Eastern'           => "(GMT-05:00) Eastern Time (US &amp; Canada)",
        'US/East-Indiana'      => "(GMT-05:00) Indiana (East)",
        'America/Bogota'       => "(GMT-05:00) Bogota",
        'America/Lima'         => "(GMT-05:00) Lima",
        'America/Caracas'      => "(GMT-04:30) Caracas",
        'Canada/Atlantic'      => "(GMT-04:00) Atlantic Time (Canada)",
        'America/La_Paz'       => "(GMT-04:00) La Paz",
        'America/Santiago'     => "(GMT-04:00) Santiago",
        'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
        'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
        'Greenland'            => "(GMT-03:00) Greenland",
        'Atlantic/Stanley'     => "(GMT-02:00) Stanley",
        'Atlantic/Azores'      => "(GMT-01:00) Azores",
        'Atlantic/Cape_Verde'  => "(GMT-01:00) Cape Verde Is.",
        'Africa/Casablanca'    => "(GMT) Casablanca",
        'Europe/Dublin'        => "(GMT) Dublin",
        'Europe/Lisbon'        => "(GMT) Lisbon",
        'Europe/London'        => "(GMT) London",
        'Africa/Monrovia'      => "(GMT) Monrovia",
        'Europe/Amsterdam'     => "(GMT+01:00) Amsterdam",
        'Europe/Belgrade'      => "(GMT+01:00) Belgrade",
        'Europe/Berlin'        => "(GMT+01:00) Berlin",
        'Europe/Bratislava'    => "(GMT+01:00) Bratislava",
        'Europe/Brussels'      => "(GMT+01:00) Brussels",
        'Europe/Budapest'      => "(GMT+01:00) Budapest",
        'Europe/Copenhagen'    => "(GMT+01:00) Copenhagen",
        'Europe/Ljubljana'     => "(GMT+01:00) Ljubljana",
        'Europe/Madrid'        => "(GMT+01:00) Madrid",
        'Europe/Paris'         => "(GMT+01:00) Paris",
        'Europe/Prague'        => "(GMT+01:00) Prague",
        'Europe/Rome'          => "(GMT+01:00) Rome",
        'Europe/Sarajevo'      => "(GMT+01:00) Sarajevo",
        'Europe/Skopje'        => "(GMT+01:00) Skopje",
        'Europe/Stockholm'     => "(GMT+01:00) Stockholm",
        'Europe/Vienna'        => "(GMT+01:00) Vienna",
        'Europe/Warsaw'        => "(GMT+01:00) Warsaw",
        'Europe/Zagreb'        => "(GMT+01:00) Zagreb",
        'Europe/Athens'        => "(GMT+02:00) Athens",
        'Europe/Bucharest'     => "(GMT+02:00) Bucharest",
        'Africa/Cairo'         => "(GMT+02:00) Cairo",
        'Africa/Harare'        => "(GMT+02:00) Harare",
        'Europe/Helsinki'      => "(GMT+02:00) Helsinki",
        'Europe/Istanbul'      => "(GMT+02:00) Istanbul",
        'Asia/Jerusalem'       => "(GMT+02:00) Jerusalem",
        'Europe/Kiev'          => "(GMT+02:00) Kyiv",
        'Europe/Minsk'         => "(GMT+02:00) Minsk",
        'Europe/Riga'          => "(GMT+02:00) Riga",
        'Europe/Sofia'         => "(GMT+02:00) Sofia",
        'Europe/Tallinn'       => "(GMT+02:00) Tallinn",
        'Europe/Vilnius'       => "(GMT+02:00) Vilnius",
        'Asia/Baghdad'         => "(GMT+03:00) Baghdad",
        'Asia/Kuwait'          => "(GMT+03:00) Kuwait",
        'Africa/Nairobi'       => "(GMT+03:00) Nairobi",
        'Asia/Riyadh'          => "(GMT+03:00) Riyadh",
        'Asia/Tehran'          => "(GMT+03:30) Tehran",
        'Europe/Moscow'        => "(GMT+04:00) Moscow",
        'Asia/Baku'            => "(GMT+04:00) Baku",
        'Europe/Volgograd'     => "(GMT+04:00) Volgograd",
        'Asia/Muscat'          => "(GMT+04:00) Muscat",
        'Asia/Tbilisi'         => "(GMT+04:00) Tbilisi",
        'Asia/Yerevan'         => "(GMT+04:00) Yerevan",
        'Asia/Kabul'           => "(GMT+04:30) Kabul",
        'Asia/Karachi'         => "(GMT+05:00) Karachi",
        'Asia/Tashkent'        => "(GMT+05:00) Tashkent",
        'Asia/Kolkata'         => "(GMT+05:30) Kolkata",
        'Asia/Kathmandu'       => "(GMT+05:45) Kathmandu",
        'Asia/Yekaterinburg'   => "(GMT+06:00) Ekaterinburg",
        'Asia/Almaty'          => "(GMT+06:00) Almaty",
        'Asia/Dhaka'           => "(GMT+06:00) Dhaka",
        'Asia/Novosibirsk'     => "(GMT+07:00) Novosibirsk",
        'Asia/Bangkok'         => "(GMT+07:00) Bangkok",
        'Asia/Jakarta'         => "(GMT+07:00) Jakarta",
        'Asia/Krasnoyarsk'     => "(GMT+08:00) Krasnoyarsk",
        'Asia/Chongqing'       => "(GMT+08:00) Chongqing",
        'Asia/Hong_Kong'       => "(GMT+08:00) Hong Kong",
        'Asia/Kuala_Lumpur'    => "(GMT+08:00) Kuala Lumpur",
        'Australia/Perth'      => "(GMT+08:00) Perth",
        'Asia/Singapore'       => "(GMT+08:00) Singapore",
        'Asia/Taipei'          => "(GMT+08:00) Taipei",
        'Asia/Ulaanbaatar'     => "(GMT+08:00) Ulaan Bataar",
        'Asia/Urumqi'          => "(GMT+08:00) Urumqi",
        'Asia/Irkutsk'         => "(GMT+09:00) Irkutsk",
        'Asia/Seoul'           => "(GMT+09:00) Seoul",
        'Asia/Tokyo'           => "(GMT+09:00) Tokyo",
        'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
        'Australia/Darwin'     => "(GMT+09:30) Darwin",
        'Asia/Yakutsk'         => "(GMT+10:00) Yakutsk",
        'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
        'Australia/Canberra'   => "(GMT+10:00) Canberra",
        'Pacific/Guam'         => "(GMT+10:00) Guam",
        'Australia/Hobart'     => "(GMT+10:00) Hobart",
        'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
        'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
        'Australia/Sydney'     => "(GMT+10:00) Sydney",
        'Asia/Vladivostok'     => "(GMT+11:00) Vladivostok",
        'Asia/Magadan'         => "(GMT+12:00) Magadan",
        'Pacific/Auckland'     => "(GMT+12:00) Auckland",
        'Pacific/Fiji'         => "(GMT+12:00) Fiji",
    );
}
function timeZonesList (){
    $list = DateTimeZone::listAbbreviations();
    $idents = DateTimeZone::listIdentifiers();

    $data = $offset = $added = array();
    foreach ($list as $abbr => $info) {
        foreach ($info as $zone) {
            if ( ! empty($zone['timezone_id'])
                AND
                ! in_array($zone['timezone_id'], $added)
                AND
                in_array($zone['timezone_id'], $idents)) {
                $z = new DateTimeZone($zone['timezone_id']);
                $c = new DateTime(null, $z);
                $zone['time'] = $c->format('H:i a');
                $data[] = $zone;
                $offset[] = $z->getOffset($c);
                $added[] = $zone['timezone_id'];
            }
        }
    }

    array_multisort($offset, SORT_ASC, $data);
    $options = array();
    foreach ($data as $key => $row) {
        $options[$row['timezone_id']] = $row['time'] . ' - '
            . '('.formatOffset($row['offset']) . ')'
            . ' ' . $row['timezone_id'];
    }

    return $options;

    // now you can use $options;
}
function formatOffset($offset) {
    $hours = $offset / 3600;
    $remainder = $offset % 3600;
    $sign = $hours > 0 ? '+' : '-';
    $hour = (int) abs($hours);
    $minutes = (int) abs($remainder / 60);

    if ($hour == 0 AND $minutes == 0) {
        $sign = ' ';
    }
    return 'GMT' . $sign . str_pad($hour, 2, '0', STR_PAD_LEFT)
    .':'. str_pad($minutes,2, '0');

}

function dir_permissions() {
    $dirs = array(
        DIR_OPENCART . 'image/',
        DIR_OPENCART . 'system/download/',
        DIR_SYSTEM . 'cache/',
        DIR_SYSTEM . 'logs/',
    );
    exec('chmod o+w -R ' . implode(' ', $dirs));
}


function file_extension($filename)
{
    $path_info = pathinfo($filename);
    return $path_info['extension'];
}

function openDirFiles ($dir)
{
    // Open a known directory, and proceed to read its contents

    try{
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {

                    $path_info = pathinfo($file);
                    if($path_info['extension']=="php")
                    {
                        //echo "filename: $file <br />";
                        if(file_exists($dir.$file))
                        {

                            try{
                                require_once($dir.$file);
                            }
                            catch (Exception $e)
                            {
                                $e->getMessage();
                            }

                        }
                        else
                        {
                            echo "File ".$dir.$file." was not Opened";
                        }
                    }
                }
                closedir($dh);
            }
        }
        else
        {echo "File directory ".$dir." was not found";}
    }
    catch (Exception $e)
    {
        $e->getMessage();
    }
}

function showDirFiles ($dir)
{
    // Open a known directory, and proceed to read its contents

    try{
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    echo $file."<>";
                    $files[] = $file;
                }
                closedir($dh);
            }

            return $files;
        }
        else
        {

            echo "File directory ".$dir." was not found";
            return false;
        }
    }
    catch (Exception $e)
    {
        $e->getMessage();
    }

}

function drupal_check_memory_limit($required, $memory_limit = NULL) {
    if (!isset($memory_limit)) {
        $memory_limit = ini_get('memory_limit');
    }

    // There is sufficient memory if:
    // - No memory limit is set.
    // - The memory limit is set to unlimited (-1).
    // - The memory limit is greater than the memory required for the operation.
    return ((!$memory_limit) || ($memory_limit == -1) || (parse_size($memory_limit) >= parse_size($required)));
}

function e_trace($ignore = 1,$limit = 5, $debug = true)
{
    $trace = '';
    if($debug==false){
        $debugs = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $limit);
    }else{
        $debugs = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, $limit);
    }

    foreach ($debugs as $k => $v) {
        if ($k < $ignore) {
            continue;
        }

        array_walk($v['args'], function (&$item, $key) {
            $item = var_export($item, true);
        });
        $args_str = '( ';
//        if(isset($v['args']) and count($v['args'])>0){
//            foreach($v['args'] as $ar){
//                    $args_str .= $ar.', ';
//            }
//
//        }
//        $args_str = substr($args_str,0,-2);
        $args_str .= implode(', ', $v['args']);

        $args_str .=' )';



        $trace .= '<br/>#' . ($k - $ignore) . ' ' . $v['file'] . '(' . $v['line'] . '): ' . (isset($v['class']) ? $v['class'] . '->' : '') . $v['function'] . $args_str . "\r\n";
    }


    e_print($trace, "trace", false, false,false, false,1);
}


function e_print_only_devel( $element, $text="", $mod = "", $tag="font", $size="", $color="",$debugIndex = 1)
{
    if(ETREX_ONLY){
        e_print($element, $text, $mod, $tag, $size, $color, $debugIndex);
    }
}
function ex_print_only_devel( $element, $text="", $mod = "", $tag="font", $size="", $color="",$debugIndex = 1)
{
    if(ETREX_ONLY){
        e_print($element, $text, $mod, $tag, $size, $color, $debugIndex);
        exit;
    }
}
function varDump($element = '', $comment = '', $debugIndex = 1, $type="var_dump_off"){
    e_print($element, $comment, false, false,false, false,$debugIndex,$type);
}

function varDumpx($element='', $comment = '', $debugIndex = 2){
    varDump($element, $comment, $debugIndex);exit;
}
function varDumpError($element='', $comment = '', $debugIndex = 2){
    varDump($element, $comment, $debugIndex);
    if(ERROR_EXIT==1)
        exit;
}

function varDumpIter($var, $flag = "def", $iteration = 10000, $exit = false, $echo_last = false) {
    static $count = array();
    if(!isset($count[$flag]))
        $count[$flag] = 1;

    static $iterations = array();
    if(!isset($iterations[$flag]))
        $iterations[$flag] = $iteration;

    if($count[$flag]<$iterations[$flag]){
        if(!$echo_last){
            //e_print($count[$flag], "", false, false,false, false,1);
            e_print($var,  $count[$flag].' '.'_______________'.$flag, false, false,false, false,1);
        }
    } elseif ($count[$flag]==$iterations[$flag]) {
        //e_print($count[$flag], "", false, false,false, false,1);
        e_print($var, $count[$flag].' '.'_______________'.$flag, false, false,false, false,1);
        if($exit!=false)
            exit;
    }
    $count[$flag]++;

    return;
}

function str2console($str, $now=false)
{
    if ($now) {
        echo "<script type='text/javascript'>\n";
        echo "//<![CDATA[\n";
        echo "console.log(", json_encode($str), ");\n";
        echo "//]]>\n";
        echo "</script>";
    } else {
        register_shutdown_function('str2console', $str, true);
    }
}

function var2console($var, $name='', $now=false)
{
    if ($var === null)          $type = 'NULL';
    else if (is_bool    ($var)) $type = 'BOOL';
    else if (is_string  ($var)) $type = 'STRING['.strlen($var).']';
    else if (is_int     ($var)) $type = 'INT';
    else if (is_float   ($var)) $type = 'FLOAT';
    else if (is_array   ($var)) $type = 'ARRAY['.count($var).']';
    else if (is_object  ($var)) $type = 'OBJECT';
    else if (is_resource($var)) $type = 'RESOURCE';
    else                        $type = '???';
    if (strlen($name)) {
        str2console("$type $name = ".var_export($var, true).';', $now);
    } else {
        str2console("$type = "      .var_export($var, true).';', $now);
    }
}

function ConsoleLog($var, $name='', $now=false)
{
    ob_start();
    if (strlen($name)) {
        echo "$name =\n";
    }
    var_dump($var);
    $str = ob_get_clean();

    str2console($str, $now);
}

/**
 * Send debug code to the Javascript console
 */
function debug_to_console($data) {
    if(is_array($data) || is_object($data))
    {
        echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
    } else {
        echo("<script>console.log('PHP: ".$data."');</script>");
    }
}

function showMyBugInfo (){
    if(IS_DEBUG_USE){
        static $last_time = '', $last_call = array();

        $time = timing('project_start');
        if($time==false)
            timing('project_start',1);

        $call = '';
        if( IS_DEBUG_USE == 2 )
            $call = findCaller();
        //varDumpIter(array(($time-$last_time)),IS_DEBUG_USE_TIME,"sdaasddasasdads",1,0);
        $ss = $time - $last_time;
        if($ss>IS_DEBUG_USE_TIME){
            echo "<font color=\"red\">";
            echo $time.":: ".$call."<br />";
            echo $last_time.":: ".$last_call."<br />";
            echo"</font>";
        }
        else{
            //print_r($call); echo " - <b>".$time."</b><br />";
            echo "".$time."<br />";
        }
        $last_call = $call;
        $last_time = $time;

        return true;
    }
    return false;
}

function findCaller() {
    $stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,50);
    //$stack = array_reverse($stack);
    $str = '';
    foreach($stack as $value){
        $str .= @$value['file']." ".@$value['line']." - ". @$value['function']."<br />";
    }
    return $str;
    /*
    for ($i = 1; $i < $stack_count; ++$i) {
        if (!empty($stack[$i]['file']) && strpos($stack[$i]['file'], 'includes' . DIRECTORY_SEPARATOR . 'database') === FALSE) {
            $stack[$i] += array('args' => array());
            return array(
                    'file' => $stack[$i]['file'],
                    'line' => $stack[$i]['line'],
                    'function' => $stack[$i + 1]['function'],
                    'class' => isset($stack[$i + 1]['class']) ? $stack[$i + 1]['class'] : NULL,
                    //'type' => isset($stack[$i + 1]['type']) ? $stack[$i + 1]['type'] : NULL,
                    //'args' => $stack[$i + 1]['args'],
            );
        }
    }*/
}

/**
 * @param $name
 * @param bool $startTime
 *
 * @return float $time // status: null-stop, true-start, false-show time difference
 */
function timer($name, $startTime = false){
    return time_diff($name,$startTime);
}


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

function array_diff_trim($aArray2,$aArray1) {
    $arrayAgainst = array_flip($aArray1);

    foreach ($aArray2 as $key => $value) {
        $value = trim($value);
        if(isset($arrayAgainst[$value])) {
            unset($aArray2[$key]);
        }
    }
    return $aArray2;
}


function array_intersect_trim($aArray2,$aArray1) {
    $arrayAgainst = array_flip($aArray1);

    foreach ($aArray2 as $key => $value) {
        $value = trim($value);
        if(!isset($arrayAgainst[$value])) {
            unset($aArray2[$key]);
        }
    }
    return $aArray2;
}


//////////////////////////////////////////////////////////////////////
//PARA: Date Should In YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
//////////////////////////////////////////////////////////////////////
function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' ){
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);
}

/**
 * @param $date_1
 * @param $date_2
 * @param string $differenceFormat
 * @return string
 * @see dateDifference()
 */
function dateDiffAtNow($date, $differenceFormat = 'd' ){
    $now = date("Y-m-d H:i:s");
    return dateDiffTotal($date ,$now ,$differenceFormat );
}

//////////////////////////////////////////////////////////////////////
//PARA: Date Should In YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute                                                       =>  49 Minute 36 Seconds
// '%s Seconds'                                                     =>  11 Seconds
//////////////////////////////////////////////////////////////////////
/**
 * @param $dt_menor
 * @param $dt_maior
 * @param string $str_interval
 * @param bool $relative %y %m %d %h %i %s
 * @return int|null
 */
function dateDiffTotal($dt_last, $dt_now, $str_interval = 'd',  $relative=false){
    //varDumpIter($dt_now,'$dt_now',3,0,1);
    if( is_string( $dt_last)) $dt_last = date_create( $dt_last);
    if( is_string( $dt_now)) $dt_now = date_create( $dt_now);

    $diff = date_diff( $dt_last, $dt_now, ! $relative);

    $total = null;

    $y_mass = 365.25;
    $m_mass = 30.4375;
    //varDumpIter($dt_last,'$dt_last',3,0,1);
    //varDumpIter($dt_now,'$dt_now',3,0,1);
    //varDumpIter($diff,'diff',3,0,1);
    switch( $str_interval){
        case "%y":
            $total = $diff->y + $diff->m / 12 + $diff->d / $y_mass;
            break;
        case "%m":
            $total= ($diff->y*12 + $diff->m + $diff->d/$m_mass) + ($diff->h/24)/$m_mass;
            break;
        case "%d":
            $total = ($diff->y * $y_mass + $diff->m * $m_mass + $diff->d) + $diff->h/24 + $diff->i / 60;
            break;
        case "%h":
            $total = ($diff->y * $y_mass + $diff->m * $m_mass + $diff->d) * 24 + $diff->h + $diff->i/60;
            break;
        case "%i":
            $total = (($diff->y * $y_mass + $diff->m * $m_mass + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
            break;
        case "%s":
            $total = ((($diff->y * $y_mass + $diff->m * $m_mass + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
            break;
        case "y":
            $total = $diff->y + $diff->m / 12 + $diff->d / $y_mass;
            break;
        case "m":
            $total= ($diff->y*12 + $diff->m + $diff->d/$m_mass) + ($diff->h/24)/$m_mass;
            break;
        case "d":
            $total = ($diff->y * $y_mass + $diff->m * $m_mass + $diff->d) + $diff->h/24 + $diff->i / 60;
            break;
        case "h":
            $total = ($diff->y * $y_mass + $diff->m * $m_mass + $diff->d) * 24 + $diff->h + $diff->i/60;
            break;
        case "i":
            $total = (($diff->y * $y_mass + $diff->m * $m_mass + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
            break;
        case "s":
            $total = ((($diff->y * $y_mass + $diff->m * $m_mass + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
            break;
    }

    if( $diff->invert)
        return -1 * $total;
    else    return $total;
}


/////////////////////////////////////////////////////////////////////////////
function iconvDefault($page,$inCarset = "windows-1251",$outCharset = "utf-8"){
    return iconv($inCarset,$outCharset,$page);
}



function getArrayDomNode($node)
{
    $array = false;

    if ($node->hasAttributes())
    {
        foreach ($node->attributes as $attr)
        {
            $array[$attr->nodeName] = $attr->nodeValue;
        }
    }

    if ($node->hasChildNodes())
    {
        if ($node->childNodes->length == 1)
        {
            $array[$node->firstChild->nodeName] = $node->firstChild->nodeValue;
        }
        else
        {
            foreach ($node->childNodes as $childNode)
            {
                if ($childNode->nodeType != XML_TEXT_NODE)
                {
                    $array[$childNode->nodeName][] = $this->getArray($childNode);
                }
            }
        }
    }

    return $array;
}

/**
 * Create a web friendly URL slug from a string.
 *
 * Although supported, transliteration is discouraged because
 * 1) most web browsers support UTF-8 characters in URLs
 * 2) transliteration causes a loss of information
 *
 * @author Sean Murphy <sean@iamseanmurphy.com>
 * @copyright Copyright 2012 Sean Murphy. All rights reserved.
 * @license http://creativecommons.org/publicdomain/zero/1.0/
 *
 * @param string $str
 * @param array $options
 * @return string
 */
function urlTranslate($str, $options = array()) {
// Make sure string is in UTF-8 and strip invalid UTF-8 characters
    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
    $str = preg_replace("/&#?[a-z0-9]{2,8};/i","",$str);
    //$str = htmlspecialchars_decode ($str);
    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => true,
    );
// Merge options
    $options = array_merge($defaults, $options);
    $char_map = array(
// Latin
        '?' => 'A', '?' => 'A', '?' => 'A', '?' => 'A', '?' => 'A', '?' => 'A', '?' => 'AE', '?' => 'C',
        '?' => 'E', '?' => 'E', '?' => 'E', '?' => 'E', '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'I',
        '?' => 'D', '?' => 'N', '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'O',
        '?' => 'O', '?' => 'U', '?' => 'U', '?' => 'U', '?' => 'U', '?' => 'U', '?' => 'Y', '?' => 'TH',
        '?' => 'ss',
        '?' => 'a', '?' => 'a', '?' => 'a', '?' => 'a', '?' => 'a', '?' => 'a', '?' => 'ae', '?' => 'c',
        '?' => 'e', '?' => 'e', '?' => 'e', '?' => 'e', '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i',
        '?' => 'd', '?' => 'n', '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o',
        '?' => 'o', '?' => 'u', '?' => 'u', '?' => 'u', '?' => 'u', '?' => 'u', '?' => 'y', '?' => 'th',
        '?' => 'y',

// Latin symbols
        '�' => '(c)',

// Greek
        '?' => 'A', '?' => 'B', '?' => 'G', '?' => 'D', '?' => 'E', '?' => 'Z', '?' => 'H', '?' => '8',
        '?' => 'I', '?' => 'K', '?' => 'L', '?' => 'M', '?' => 'N', '?' => '3', '?' => 'O', '?' => 'P',
        '?' => 'R', '?' => 'S', '?' => 'T', '?' => 'Y', '?' => 'F', '?' => 'X', '?' => 'PS', '?' => 'W',
        '?' => 'A', '?' => 'E', '?' => 'I', '?' => 'O', '?' => 'Y', '?' => 'H', '?' => 'W', '?' => 'I',
        '?' => 'Y',
        '?' => 'a', '?' => 'b', '?' => 'g', '?' => 'd', '?' => 'e', '?' => 'z', '?' => 'h', '?' => '8',
        '?' => 'i', '?' => 'k', '?' => 'l', '?' => 'm', '?' => 'n', '?' => '3', '?' => 'o', '?' => 'p',
        '?' => 'r', '?' => 's', '?' => 't', '?' => 'y', '?' => 'f', '?' => 'x', '?' => 'ps', '?' => 'w',
        '?' => 'a', '?' => 'e', '?' => 'i', '?' => 'o', '?' => 'y', '?' => 'h', '?' => 'w', '?' => 's',
        '?' => 'i', '?' => 'y', '?' => 'y', '?' => 'i',

// Turkish
        '?' => 'S', '?' => 'I', '?' => 'C', '?' => 'U', '?' => 'O', '?' => 'G',
        '?' => 's', '?' => 'i', '?' => 'c', '?' => 'u', '?' => 'o', '?' => 'g',

// Russian
        '�' => 'A', '�' => 'B', '�' => 'V', '�' => 'G', '�' => 'D', '�' => 'E', '�' => 'Yo', '�' => 'Zh',
        '�' => 'Z', '�' => 'I', '�' => 'J', '�' => 'K', '�' => 'L', '�' => 'M', '�' => 'N', '�' => 'O',
        '�' => 'P', '�' => 'R', '�' => 'S', '�' => 'T', '�' => 'U', '�' => 'F', '�' => 'H', '�' => 'C',
        '�' => 'Ch', '�' => 'Sh', '�' => 'Sh', '�' => '', '�' => 'Y', '�' => '', '�' => 'E', '�' => 'Yu',
        '�' => 'Ya',
        '�' => 'a', '�' => 'b', '�' => 'v', '�' => 'g', '�' => 'd', '�' => 'e', '�' => 'yo', '�' => 'zh',
        '�' => 'z', '�' => 'i', '�' => 'j', '�' => 'k', '�' => 'l', '�' => 'm', '�' => 'n', '�' => 'o',
        '�' => 'p', '�' => 'r', '�' => 's', '�' => 't', '�' => 'u', '�' => 'f', '�' => 'h', '�' => 'c',
        '�' => 'ch', '�' => 'sh', '�' => 'sh', '�' => '', '�' => 'y', '�' => '', '�' => 'e', '�' => 'yu',
        '�' => 'ya',

// Ukrainian
        '�' => 'Ye', '�' => 'I', '�' => 'Yi', '�' => 'G',
        '�' => 'ye', '�' => 'i', '�' => 'yi', '�' => 'g',

// Czech
        '?' => 'C', '?' => 'D', '?' => 'E', '?' => 'N', '?' => 'R', '?' => 'S', '?' => 'T', '?' => 'U',
        '?' => 'Z',
        '?' => 'c', '?' => 'd', '?' => 'e', '?' => 'n', '?' => 'r', '?' => 's', '?' => 't', '?' => 'u',
        '?' => 'z',

// Polish
        '?' => 'A', '?' => 'C', '?' => 'e', '?' => 'L', '?' => 'N', '?' => 'o', '?' => 'S', '?' => 'Z',
        '?' => 'Z',
        '?' => 'a', '?' => 'c', '?' => 'e', '?' => 'l', '?' => 'n', '?' => 'o', '?' => 's', '?' => 'z',
        '?' => 'z',

// Latvian
        '?' => 'A', '?' => 'C', '?' => 'E', '?' => 'G', '?' => 'i', '?' => 'k', '?' => 'L', '?' => 'N',
        '?' => 'S', '?' => 'u', '?' => 'Z',
        '?' => 'a', '?' => 'c', '?' => 'e', '?' => 'g', '?' => 'i', '?' => 'k', '?' => 'l', '?' => 'n',
        '?' => 's', '?' => 'u', '?' => 'z'
    );
// Make custom replacements
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
// Transliterate characters to ASCII
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
// Replace non-alphanumeric characters with our delimiter
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
// Remove duplicate delimiters
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
// Truncate slug to max. characters
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
// Remove delimiter from ends
    $str = trim($str, $options['delimiter']);
    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}

function authSiteByCurl($url,$accesstoken){
    $cookie = $_SERVER['DOCUMENT_ROOT'].'/cookie.txt';

    $ch  = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $rest = curl_exec($ch);

// set additional curl options using our previous options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $accesstoken);

    $page = curl_exec($ch); // make request
    curl_close($ch);

    if($page === false){
        //echo '������ curl: ' . curl_error($ch);
        return false;
    }else
        return true;
}

function file_get_contents_curl_by_auth($url,$accesstoken,$watchPartHtmlCodeInTheOnlyAuthPage,$request = false) {

    $page = file_get_contents_curl($url,$request);

    if (!preg_match("/".$watchPartHtmlCodeInTheOnlyAuthPage."/is", $page, $form)) {
        if(!authSiteByCurl($url,$accesstoken)){
            //die('Erorr: Could not login!');
            return false;
        }

        if (!preg_match("/".$watchPartHtmlCodeInTheOnlyAuthPage."/is", $page = file_get_contents_curl($url,$request), $form)) {
            return false;
        }
    }
    return $page;
}

function file_get_contents_curl($url,$request=false) {
    if(isset($request['post'])){
        $post = $request['post'];
    }elseif(!isset($request['post']) and !isset($request['get']) and count($request)>0){
        $post = $request;
    }

    $header = array(
        //"POST /index.php?section=7 HTTP/1.1",
        //"Host: www.metr-plus.com.ua",
        "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0",
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
        "Accept-Language: uk,ru;q=0.8,en-us;q=0.5,en;q=0.3",
        //"Accept-Encoding: gzip, deflate",
        //"Referer: http://www.metr-plus.com.ua/index.php?section=7",
        //"Cookie: _ga=GA1.3.1410583982.1413996179; __utma=183677498.1410583982.1413996179.1415099769.1415102075.12; __utmz=183677498.1413996179.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); PHPSESSID=h9j1j1mec1b5k6qj77tf3eee42; __utmc=183677498; popuptraf=yes; _gat=1; __utmb=183677498.2.10.1415102075; __utmt=1; _ym_visorc_1275853=w",
        "Connection: keep-alive"
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0");
    //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'].'/cookie.txt');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //������������� ��������, ����� curl ��������� ������, ������ ����, ����� �������� �� � �������.
    if(isset($post)){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }

    curl_setopt($ch, CURLOPT_URL, $url);

    if(false === $data = curl_exec($ch))
    {
        echo '������ curl: ' . curl_error($ch) .'<br />';
    }

    curl_close($ch);
    return $data;
}

function e_memory (){
    echo_memory_usage();
}

function echo_memory_usage() {
    $mem_usage = memory_get_usage(true);

    if ($mem_usage < 1024)
        echo $mem_usage." bytes";
    elseif ($mem_usage < 1048576)
        echo round($mem_usage/1024,2)." kilobytes";
    else
        echo round($mem_usage/1048576,2)." megabytes";

    echo "<br/>";
}

function how_files_dir($dir){
    $dir = opendir($dir); # This is the directory it will count from

    if($dir==false)
        return false;

    $i = 0; # Integer starts at 0 before counting

    # While false is not equal to the filedirectory
    while (false !== ($file = readdir($dir))) {
        if (!in_array($file, array('.', '..')) and !is_dir($file))
            $i++;
    }

    //echo "There were $i files"; # Prints out how many were in the directory

    return $i;
}

function my_fgetcsv($f, $length, $d=";", $q='"') {
    $list = array();
    $st = fgets($f, $length);
    if ($st === false || $st === null) return $st;
    while ($st !== "" && $st !== false) {
        if ($st[0] !== $q) {
            # Non-quoted.
            list ($field) = explode($d, $st, 2);
            $st = substr($st, strlen($field)+strlen($d));
        } else {
            # Quoted field.
            $st = substr($st, 1);
            $field = "";
            while (1) {
                # Find until finishing quote (EXCLUDING) or eol (including)
                preg_match("/^((?:[^$q]+|$q$q)*)/sx", $st, $p);
                $part = $p[1];
                $partlen = strlen($part);
                $st = substr($st, strlen($p[0]));
                $field .= str_replace($q.$q, $q, $part);
                if (strlen($st) && $st[0] === $q) {
                    # Found finishing quote.
                    list ($dummy) = explode($d, $st, 2);
                    $st = substr($st, strlen($dummy)+strlen($d));
                    break;
                } else {
                    # No finishing quote - newline.
                    $st = fgets($f, $length);
                }
            }

        }
        $list[] = $field;
    }
    return $list;
}

function ipGet(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}
/* 2015-12-17 */
function accessLogFile($file_path) {

    //ASSIGN VARIABLES TO USER INFO
    $time = date("Y-m-d H:i:s");
    $ip = getenv('REMOTE_ADDR');
    $userAgent = getenv('HTTP_USER_AGENT');
    $referrer = getenv('HTTP_REFERER');
    $query = getenv('QUERY_STRING');

    //COMBINE VARS INTO OUR LOG ENTRY
    $msg = "" . $time ." IP: " . $ip . " REFERRER: " . $referrer . " SEARCHSTRING: " . $query . " USERAGENT: " . $userAgent;

    $today = date("Y_m_d");
    $logfile = $today."_log.txt";
    $dir = 'logs';
    //$saveLocation = $dir . '/' . $logfile;
    $saveLocation = $file_path;
    if  (!$handle = @fopen($saveLocation, "a")) {
        exit;
    }
    else {
        if (@fwrite($handle,"$msg\r\n") === FALSE) {
            exit;
        }

        @fclose($handle);
    }
}


function log_global_set($sql, $key = 'item', $time = false, $debugIndex = 1){

    global $log, $staticCounter;
    $full = false;

    if(empty($log[$key]) || empty($staticCounter[$key])){
        $staticCounter[$key] = 1;
        $log[$key] = array();
    }
    $staticCounterKey = $staticCounter[$key];

    $log[$key]['list'][$staticCounterKey]['num'] = $staticCounterKey;

    if($full || (defined("LOG_FULL") && LOG_FULL == true) ){
        $debug = debug_backtrace();
        $log[$key]['list'][$staticCounterKey]['file_line'] = $debug[$debugIndex]["file"] .":". $debug[$debugIndex]["line"];
    }


    $log[$key]['list'][$staticCounterKey]['item_'.$key] = $sql;

    $log[$key]['list'][$staticCounterKey]['time_global'] = timing("start");

    if($time===false){
        $log[$key]['list'][$staticCounterKey]['time'] = $time = timing("start");
    }
    else
        $log[$key]['list'][$staticCounterKey]['time'] = $time;



    $timeBeforeLastQuery = 0;
    if(!empty($log[$staticCounterKey-1]['time']))
        $timeBeforeLastQuery = $log[$staticCounterKey-1]['time'];

    $log[$key][$staticCounter]['timeBeforeLastQuery'] = $timeBeforeLastQuery;

    if($time>10){
        $log[$key]['list'][$staticCounterKey]['long_time'] = $time;
        $log[$key]['queries_long'][] = $log[$key]['list'][$staticCounterKey];
    }

    //e_print($log[$key]['list'][$staticCounterKey]);
    //e_print($log[$key]);
    //$log['global_time'] = $log[$key][$staticCounter]['time_global'];

    $log[$key]['all_execute_time'] += $time;

    $staticCounter[$key] ++;

}

function get_query_log($key = ''){
    global $log;

    $log['global_time'] = timing("start");

    if($key!=false){
        $ret = $log[$key];
        return $ret;
    }
    else
        return $log;
}


function download_csv_results($results, $name = NULL)
{
    if( ! $name)
    {
        $name = md5(uniqid() . microtime(TRUE) . mt_rand()). '.csv';
    }

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='. $name);
    header('Pragma: no-cache');
    header("Expires: 0");

    $outstream = fopen("php://output", "w");

    foreach($results as $result)
    {
        fputcsv($outstream, $result);
    }

    fclose($outstream);
}


/**
 * @param $delimetr
 * @param $value
 *
 * @return array
 */
function explode_trim($delimetr, $value){
    $value = array_map('trim', explode($delimetr, $value));
    return $value;
}

/**
 * @return mixed
 */
function array_merge_value() {
    $args = func_get_args();
    foreach ($args as $ak => $av) {
        $args[$ak] = array_values($av);
    }
    return call_user_func_array('array_merge', $args);
}

/**
 * @param $array
 *
 * @return mixed
 */
function array_empty_value_delete($array){
    foreach ($array as $key => $value){
        if($value==false)
            unset($array[$key]);
    }

    return $array;
}

function trim_full($str) {
    return trim(preg_replace('/\s{2,}/', ' ', $str));
}

function detect_encoding($string) {
    static $list = array('utf-8', 'windows-1251');

    foreach ($list as $item) {
        $sample = iconv($item, $item, $string);
        if (md5($sample) == md5($string))
            return $item;
    }
    return null;
}


if (!function_exists('mb_str_replace')) {
    function mb_str_replace($search, $replace, $subject, &$count = 0) {
        if (!is_array($subject)) {
            // Normalize $search and $replace so they are both arrays of the same length
            $searches = is_array($search) ? array_values($search) : array($search);
            $replacements = is_array($replace) ? array_values($replace) : array($replace);
            $replacements = array_pad($replacements, count($searches), '');
            foreach ($searches as $key => $search) {
                $parts = mb_split(preg_quote($search), $subject);
                $count += count($parts) - 1;
                $subject = implode($replacements[$key], $parts);
            }
        } else {
            // Call mb_str_replace for each subject in array, recursively
            foreach ($subject as $key => $value) {
                $subject[$key] = mb_str_replace($search, $replace, $value, $count);
            }
        }
        return $subject;
    }
}

function shuffle_assoc($list) {
    if (!is_array($list)) return $list;

    $keys = array_keys($list);
    shuffle($keys);
    $random = array();
    foreach ($keys as $key)
        $random[$key] = $list[$key];

    return $random;
}


function extract_email_address ($string) {
    $emails = array();
    $string = str_replace("\r\n",' ',$string);
    $string = str_replace("\n",' ',$string);

    $pattern = '/[a-z0-9_\-\+]+@[a-z0-9\-]+\.(?:[a-z]{2,3})(?:\.[a-z]{2})?/i';

    preg_match_all($pattern, $string, $emails);

    return $emails[0];
}