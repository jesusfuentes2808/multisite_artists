<?php
include('constants.php');

function implodeArrayGlobalList($data, $key = ''){
    $implodeTrend = array();

    if(empty($data)){
        return '';
    }

    foreach($data as $item){
        array_push($implodeTrend, ($key != '') ? $item->$key : $item->codigo_de_playlist);
    }

    return implode(",", $implodeTrend);
}
