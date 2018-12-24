<?php if (isset($_GET['zd_echo'])) exit($_GET['zd_echo']);
include_once ('./includes/zadarma.php');
include_once('./includes/crm.php');
$event = strval($_POST['event']);
$pbxid = $_POST['pbx_call_id'];
$code = 'call_records';
$key = '6552c216ba3052a304ba2d6654115268af01a1f2135220ab9a864ff0f643dfd1';
$dateCreate = date('dmY');
/*Amocrm uauth*/
$user=array(
    'USER_LOGIN'=>'chedajo@gmail.com', #Ваш логин (электронная почта)
    'USER_HASH'=>'ee91ac8a76cd72fee25b53fa8a639b6e' #Хэш для доступа к API (смотрите в профиле пользователя)
);
$subdomain='iqdecision'; #Наш аккаунт - поддомен
#Формируем ссылку для запроса
$link='https://'.$subdomain.'.amocrm.ru/private/api/auth.php?type=json';
$curl=curl_init();
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
curl_setopt($curl,CURLOPT_URL,$link);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($user));
curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
curl_setopt($curl,CURLOPT_HEADER,false);
curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
$out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
$code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
curl_close($curl);

if ($event=='NOTIFY_END' or $event=='NOTIFY_OUT_END') {

  $is_recorded = $_POST['is_recorded'];

    if ($is_recorded == 1) {
        if ($event == 'NOTIFY_END') {
            $phone_number = $_POST['caller_id'];
            $direction = 'inbound';
        } else {
            $phone_number = $_POST['destination'];
            $direction = 'outbound';
        }
        $amo = new \AmoCRM\Client('iqdecision', 'chedajo@gmail.com', 'ee91ac8a76cd72fee25b53fa8a639b6e');
        $check = $amo->contact->apiList([
            'query' => trim($phone_number),
        ]);
        if (empty($check)) {
            $contact = $amo->contact;
            $contact['name'] = $phone_number;
            $contact['responsible_user_id'] = '2436217';
            $contact->addCustomField(245295, [
                [$phone_number, '487783'],
            ]);

            $cid = $contact->apiAdd();
            $lead = $amo->lead;
            $lead['name'] = 'Сделка: ' . $phone_number;
            $lead['responsible_user_id'] = '2436217';
            $lead['tags'] = 'IP-телефония';
            $lid = $lead->apiAdd();
            $link = $amo->links;
            $link['from'] = 'leads';
            $link['from_id'] = $lid;
            $link['to'] = 'contacts';
            $link['to_id'] = $cid;
            var_dump($link->apiLink());

        }

        $call_start = $_POST['call_start'];
        $duration = $_POST['duration'];
        $call_id = $_POST['call_id_with_rec'];


        $call['add'] = array(
            0 => array(
                'uniq' => $pbxid,
                'phone_number' => $phone_number,
                'direction' => $direction,
                'duration' => $duration,
                'created_at' => $call_start,
                'link' => 'https://iq-offshore.com/amocrm/record/' .$dateCreate. '/' . $pbxid . '.mp3',
            )
        );
        $link = 'https://iqdecision.amocrm.ru/api/v2/calls';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($call));
        $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        curl_close($curl);
    }
}

if ($event=='NOTIFY_RECORD'){

    $params = array(
   'pbx_call_id' => $pbxid,
    );
    /*Zadarma Auth*/
    $zd = new \Zadarma_API\Client('4510c5dd9b6722ae69b4', 'fe467e178e4796a07043');
    $answer = $zd->call('/v1/pbx/record/request/', $params);
    $answerObject = json_decode($answer);
    $link = strval($answerObject-> links[0]);
    if (!file_exists('./record/'.$dateCreate)){
        mkdir('./record/'.$dateCreate, 0755);
    }
    file_put_contents('./record/' .$dateCreate. '/'.$pbxid.'.mp3', file_get_contents($link));

}
?>


