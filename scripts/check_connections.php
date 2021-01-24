<?php

try {
    echo "script started".PHP_EOL;
    $conn = new mysqli("localhost", "root", "root", "contor_control");

    // Check connection
    if ($conn->connect_error)
        die("Connection failed: " . $conn->connect_error);

    if ($conn) {
        $timezone = 0; // 12600; // asia tehran timezon
        $gateways = $conn->query("SELECT id,send_data_duration_seconds FROM gateways;");
        while($gateway = $gateways->fetch_assoc()) {
            $gatewayId = $gateway["id"];
            $sendDuration = $gateway["send_data_duration_seconds"];
            if ($gatewayHistories = $conn->query("SELECT MAX(e_m_h_test.created_at) as last_data FROM e_m_h_test,electrical_meters WHERE e_m_h_test.electrical_meter_id = electrical_meters.id AND electrical_meters.gateway_id=$gatewayId")) {
                $gatewayHistory = $gatewayHistories->fetch_assoc();
                $gateway_last_update = $gatewayHistory["last_data"];
                $gatewayDiff = time() - strtotime($gateway_last_update) - $timezone;

                if ($gatewayDiff >= $sendDuration*6) { // it's been six times data is not coming
                    // update to off (not active)
                    $update = $conn->query("UPDATE electrical_meters SET is_active=0 WHERE gateway_id=$gatewayId");
                } else {
                    // update to on (active)
                    $update = $conn->query("UPDATE electrical_meters SET is_active=1 WHERE gateway_id=$gatewayId");
                }
            }

            $devices = $conn->query("SELECT id FROM cooling_devices WHERE gateway_id=$gatewayId;");
            while($device = $devices->fetch_assoc()) {
                $deviceId = $device["id"];
                if ($deviceHistories = $conn->query("SELECT MAX(created_at) as last_data FROM cooling_device_histories WHERE cooling_device_id=$deviceId")) {
                    $deviceHistory = $deviceHistories->fetch_assoc();
                    $device_last_update = $deviceHistory["last_data"];
                    $deviceDiff = time() - strtotime($device_last_update);

                    if ($deviceDiff >= $sendDuration*6) { // it's been six times data is not coming
                        // update to off (not active)
                        $update = $conn->query("UPDATE cooling_devices SET is_active=0 WHERE id=$deviceId");
                    } else {
                        // update to on (active)
                        $update = $conn->query("UPDATE cooling_devices SET is_active=1 WHERE id=$deviceId");
                    }
                }
            }
        }

        commitGatewayStatus($conn);
        commitDevicesStatus($conn);

        echo "script ended.".PHP_EOL;
    }
} catch (Exception $exception) { // log exception
    generalLog($exception->getMessage());
}

function commitGatewayStatus($conn)
{
    try {
        $electricalMeters = $conn->query("SELECT id,gateway_id,relay1_status,relay2_status FROM electrical_meters");

        while($device = $electricalMeters->fetch_assoc()) {
            $id = $device["id"];
            $gateway = $device["gateway_id"];
            $relay1 = $device["relay1_status"];
            $relay2 = $device["relay2_status"];
            if ($modify = $conn->query("SELECT COUNT(*) as cnt FROM modify_contors WHERE electrical_meter_id = $id AND checked=0")) {
                $pending = $modify->fetch_assoc();
                $count = $pending["cnt"];

                if ($count == 0)
                    $insert = $conn->query("INSERT INTO modify_contors(gateway_id,electrical_meter_id,relay1_status,relay2_status,checked) VALUES($gateway,$id,$relay1,$relay2,0);");
            }
        }
    } catch(Exception $exception) { // log exception
        generalLog($exception->getMessage());
    }
}

function commitDevicesStatus($conn)
{
    try {
        $devices = $conn->query("SELECT id,gateway_id,mode,degree FROM cooling_devices WHERE deleted_at IS NULL");

        while($device = $devices->fetch_assoc()) {
            $id = $device["id"];
            $gatewayId = $device["gateway_id"];
            $mode = $device["mode"];
            $degree = $device["degree"];

            if ($modify = $conn->query("SELECT COUNT(*) as cnt FROM modify_contors WHERE cooling_device_id=$id AND checked=0")) {
                $pending = $modify->fetch_assoc();
                $count = $pending["cnt"];

                if ($count == 0)
                    $insert = $conn->query("INSERT INTO modify_contors(gateway_id,cooling_device_id,relay1_status,relay2_status,checked) VALUES($gatewayId,$id,$mode,$degree,0);");
            }
        }
    } catch(Exception $exception) { // log exception
        generalLog($exception->getMessage());
    }
}

function generalLog($message) {
    $today = date('Y-m-d');
    makeDirectory("$today");
    $myFile = fopen("$today/log.txt", "a") or die("Unable to open file!");
    $date = PHP_EOL.'['.date('Y/m/j H:i').'] ';
    fwrite($myFile, "$date [$message]");
    fclose($myFile);
}

function makeDirectory($path) {
    if (!file_exists($path))
        mkdir($path, 0777, true);
}

