<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    exit;
}

if(isset($_POST)){
    if(!empty($_POST['g-recaptcha-response']))
    {
        $secret = '6LcHgKAeAAAAAKvS2A2HEoKcEksVrKuP-GEzeZ2D';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);

        if($responseData->success)
            $message = "1";
        else
            $message = "-1";

        echo $message;
    }
}
