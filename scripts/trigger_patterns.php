<?php

try {
    $conn = new mysqli("localhost", "root", "root", "contor_control");

    // Check connection
    if ($conn->connect_error)
        die("Connection failed: " . $conn->connect_error);

    if ($conn) {
        $serverTime = "";
        $devices = $conn->query("SELECT cooling_device_id,start_time,mode_id,degree FROM patterns WHERE start_time <= $serverTime AND start_time+5 >= $serverTime;");
        while($row = $devices->fetch_assoc()) {
            // $id = $row["id"];
            // $status = $row["current_status"];
        }

        $devices = $conn->query("SELECT cooling_device_id,end_time,mode_id,degree FROM patterns WHERE end_time <= $serverTime AND end_time+5 >= $serverTime;");
        while($row = $devices->fetch_assoc()) {
            // if there is not another pattern which this end == that start, turn off the device
            $id = $row["cooling_device_id"];
            $end = $row["end_time"];
            $next = $conn->query("SELECT count(*) FROM patterns WHERE cooling_device_id=$id AND start_time = $end;");
            if (!$next) {
                // turn off
            }
        }
    }
} catch (Exception $exception) {
    // log exception
}
