<?php
	include_once('./includes/crm.php');
	$m  = $_POST['data'];
	$name = $_POST['user_name'];
	$email = $_POST['user_email'];
	$user_ip = $_POST['user_ip'];
	$is_bot = preg_match(
 "~(Google|Yahoo|Rambler|Bot|Yandex|Spider|Snoopy|Crawler|Finder|Mail|curl)~i", 
 $_SERVER['HTTP_USER_AGENT']
);
$geo = !$is_bot ? json_decode(file_get_contents('http://api.sypexgeo.net/json/'.$user_ip), true) : [];
$country = $geo['country']['name_ru'];
	for($i=0; $i<=count($m)-1; $i++)
					{
						$message .= $m[$i]."\n\r";
					}
	$amo = new \AmoCRM\Client('iqdecision', 'vientos.pro@gmail.com', '168bbdd65d38cc1ed10a6ee5c12649a30ae88f9d'); // Данные от амо (домен, email, api ключ)
			$data_c = array();
			$data_c[] = array(
        						           'name' => $name.' ('.$user_ip.')',
        						           'custom_fields' => array(
        						           	array(
        						               'id'     => 245297, //ID поля Email
        						               'values' => array(
        						                 array(
        						                   'enum' => '487795', //ID подполя Email
        						                   'value' => $email,
        						                 ),
        						               ),
        						             ),
        						             array(
        						               'id'     => 527459, //ID поля Страна
        						               'values' => array(
        						                 array(
        						                   'value' => $country,
        						                 ),
        						               ),
        						             ),
        						       ),
        						       );
		  $unsorted = $amo->unsorted;
          $lead = $amo->lead;
          $unsorted['source'] = trim('vientos.pro@gmail.com');
          $unsorted['source_uid'] = NUll;
          $unsorted['source_data'] = NUll;
          $unsorted['data_create'] = time();
          //$unsorted['pipeline_id'] = '1115392';
          $unsorted['data'] = array(
          		'contacts'    => $data_c,
               'leads'    => array(
                 array(
                   'name' => 'Сделка: '.$name.' ('.$user_ip.')',
                   'notes' => array(
	                   array(
		                'note_type' => '4',
                        'element_type' => '2',
                        'text' => $message, 
	                   ),
                   ),
                  // 'pipeline_id' => '1115392',
                   //'responsible_user_id' => '2444653',
                 // 'tags' => 'горячий',                   
               ),
               ),
           );
          $unsorted['source_data'] = array(
        'form_id' => '1',
        'form_type' => '1',
        'origin' => array(
          'ip' => $_SERVER['REMOTE_ADDR'],
          'datetime' => 'Tue Nov 03 2015 13:02:24 GMT+0300 (Russia Standard Time)',
          'referer' => '',
        ),
        'data' => array(
          'name_1' => array(
            'type' => 'text',
            'id' => 'name',
            'element_type' => '1',
            'name' => 'TAWK.TO: ',
            'value' => 'Чат с сайта',
          ),
          'name_2' => array(
            'type' => 'text',
            'id' => 'name',
            'element_type' => '1',
            'name' => 'Имя: ',
            'value' => $name,
          ),
            'name_3' => array(
            'type' => 'text',
            'id' => 'name',
            'element_type' => '1',
            'name' => 'Email: ',
            'value' => $email,
          ),
          'name_4' => array(
            'type' => 'text',
            'id' => 'name',
            'element_type' => '1',
            'name' => 'IP: ',
            'value' => $user_ip,
          ),
          ),
            
        'date' => time().''.rand(1,99999999),
        'from' => $_SERVER['HTTP_HOST'],
        );
          $check = $amo->lead->apiList([
        'query' => trim($user_ip),
   ]);
      //////////
      if(empty($check))
          {
$uns = $unsorted->apiAdd('forms');
			} else {
	$note = $amo->note;
    //$note->debug(true); // Режим отладки
    $note['element_id'] = $check[0]['id'];
    $note['element_type'] = '2'; // 1 - contact, 2 - lead
    $note['note_type'] = '4';
    $note['text'] = $message;
    $id = $note->apiAdd();
			}
            ////////////////////////////////////
	$f = fopen("1.txt", "a+");
	fwrite($f, print_r($_POST, true));
	fclose($f);
	?>