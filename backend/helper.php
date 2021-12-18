<?php
include('constants.php');

function implodeArrayGlobalList($data){
    $implodeTrend = array();

    foreach($data as $item){
        array_push($implodeTrend, $item->codigo_de_playlist);
    }

    return implode(",", $implodeTrend);
}
