<?php
header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
$response = array();
$response['data']['url'] = $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

if($_FILES['file'] && $_POST['filename']){
    if (!dirname(__FILE__) . '/assets/json/') {
        mkdir(dirname(__FILE__) . '/assets/json/');
    }

    if (move_uploaded_file($_FILES['file']['tmp_name'], dirname(__FILE__) . '/assets/json/' . $_POST['filename'])) {
        $response['status'] = "ok";
        $response['data']['message'] = $_POST['filename'];
    } else {
        $response['status'] = "error";
        $response['data']['message'] = "No se lograron cargar los archivos correctamente";
    }
} else {
        $response['status'] = "error";
        $response['data']['message'] = "Not found";
}

echo json_encode($response);

