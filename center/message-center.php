<?php
    function rep($str){
        $str = str_replace('*', '^', $str);
        $str = str_replace('_', '-', $str);
        $str = str_replace('`', '"', $str);
        $str = str_replace('[', '<', $str);
        $str = str_replace(']', '>', $str);
        $str = str_replace('(', '<<', $str);

        return str_replace(')', '>>', $str);
    }

    $name;
    $subject;
    $phone;
    $message;
    $page;

    if (isset($_POST['Name']) && $_POST['Name'] != '') $name = rep($_POST['Name']);
    if (isset($_POST['Subject']) && $_POST['Subject'] != '') $subject = rep($_POST['Subject']);
    if (isset($_POST['Email']) && $_POST['Email'] != '') $phone = rep($_POST['Email']);
    if (isset($_POST['Page']) && $_POST['Page'] != '') $page = rep($_POST['Page']);
    if (isset($_POST['Message'])) {
        $message = rep($_POST['Message']);

        $ip = getenv('HTTP_CLIENT_IP') ?:
        getenv('HTTP_X_FORWARDED_FOR') ?:
        getenv('HTTP_X_FORWARDED') ?:
        getenv('HTTP_FORWARDED_FOR') ?:
        getenv('HTTP_FORWARDED') ?:
        getenv('REMOTE_ADDR');

        $text = "[$page]
IP: [$ip](https://whatismyipaddress.com/ip/$ip)
Name: $name;
Phone/ Email: $phone; 

Subject: $subject
    $message;";

        $parameters = array('chat_id' => '107616269', 'parse_mode' => 'Markdown', 'disable_web_page_preview' => 'true', "text" => $text);
        foreach ($parameters as $key => &$val) {
            if (!is_numeric($val) && !is_string($val)) {
                $val = json_encode($val);
            }
        }
        $method = "sendMessage";
        $API_URL = "https://api.telegram.org/bot414532013:AAEAztkoel1X0CYZws7z4JH8L2MwV1lrdoo/";
        $url = $API_URL . $method . '?' . http_build_query($parameters);
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        $response = curl_exec($handle);
        echo $response;
    }
return 0;