<?php

function requestUrl($url){
    $clientNew = curl_init();

    curl_setopt($clientNew, CURLOPT_URL, $url );
    curl_setopt($clientNew, CURLOPT_HEADER, 0);
    curl_setopt($clientNew, CURLOPT_RETURNTRANSFER, true);

    $content= curl_exec($clientNew);
    curl_close($clientNew);

    return $content;
}

function responseProcessed($content){
    $data = [];
    $response = json_decode($content);

    if($response->response === 'OK'){
        $data = $response->data;
    }

    return $data;
}
