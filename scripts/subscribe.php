<?php

require('../app/Helpers/phpMQTT.php');

$server = "mqtt.flespi.io";
$port = intval(1883);
$username = "7nlbcTUtpbZP7bnEHvuwfiVBQ8AJ4xK1KU2MBM5QLSuJTHdq0vK6DwxjuVQogpdP";
$password = "7nlbcTUtpbZP7bnEHvuwfiVBQ8AJ4xK1KU2MBM5QLSuJTHdq0vK6DwxjuVQogpdP";
$client_id = uniqid();

$mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);

if($mqtt->connect(true, NULL, $username, $password)) {
    echo PHP_EOL."socket connection initialized.".PHP_EOL;

    $mqtt->debug = true;

    $topics['ami'] = array('qos' => 0, 'function' => 'procMsg');
    $mqtt->subscribe($topics, 0);

    while($mqtt->proc()) { /**/ }

    $mqtt->close();

} else {
    echo PHP_EOL."unable to connect".PHP_EOL;
    exit(1);
}
function procMsg($topic, $msg){
		echo 'Msg Recieved: ' . date('r') . "\n";
		echo "Topic: {$topic}\n\n";
		echo "\t$msg\n\n";
}
