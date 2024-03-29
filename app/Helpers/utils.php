<?php

function makeDirectory($path) {
    if (!file_exists($path))
        mkdir($path, 0777, true);
}

function logIncomingData($content, $userAgent=null) {
    $body = json_decode($content);

    if ($body) {
        $today = date('Y-m-d');
        makeDirectory("logs/$today");
        if (isset($body->gateway_id)) {
            $gatewayNumber = $body->gateway_id;
            $myFile = fopen("logs/$today/$gatewayNumber-Post-Data.txt", "a") or die("Unable to open file!");
            $date = PHP_EOL . '[' . date('Y/m/j H:i') . '] ';
            // fwrite($myFile, $date.'[][request body='.$content.']');
            fwrite($myFile, "$date [$userAgent] [request body = $content]");
            fclose($myFile);
            return true;
        } else {
            logException("General", $content);
            return false;
        }
    } else {
        logException("General", $content);
        return false;
    }
}

function logConfirmData($content) {
    $body = json_decode($content);
    $gatewayNumber = $body->gateway_id;
    $today = date('Y-m-d');
    makeDirectory("logs/$today");
    $myFile = fopen("logs/$today/$gatewayNumber-Confirm-Data.txt", "a") or die("Unable to open file!");
    $date = PHP_EOL.'['.date('Y/m/j H:i').'] ';
    fwrite($myFile, $date.'[request body='.$content.']');
    fclose($myFile);
}

function logException($gatewayNumber, $message) {
    $today = date('Y-m-d');
    makeDirectory("logs/$today");
    $myFile = fopen("logs/$today/$gatewayNumber-Exception.txt", "a") or die("Unable to open file!");
    $date = PHP_EOL.'['.date('Y/m/j H:i').'] ';
    fwrite($myFile, "$date [$message]");
    fclose($myFile);
}

function generalLog($method, $gateway, $data) {
    $logData = json_encode($data);
    $today = date('Y-m-d');
    makeDirectory("logs/$today");
    $myFile = fopen("logs/$today/$gateway-$method.txt", "a") or die("Unable to open file!");
    $date = PHP_EOL.'['.date('Y/m/j H:i').'] ';
    fwrite($myFile, "$date [$logData]");
    fclose($myFile);
}
