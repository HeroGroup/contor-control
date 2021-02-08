@extends('layouts.app')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
    <script type="text/javascript" language="javascript">

        client = new Paho.MQTT.Client("mqtt.flespi.io", Number(80), "NavidHero");

        client.onConnectionLost = onConnectionLost;
        client.onMessageArrived = onMessageArrived;

        client.connect({
            timeout: 1200,
            userName: "KQ5iNhv4zOM0MKK2UvHe6A8h7mNe8BwGfrPSwaLVMnLoWmeGFJIz7EG4Rj7NItkO",
            password:"KQ5iNhv4zOM0MKK2UvHe6A8h7mNe8BwGfrPSwaLVMnLoWmeGFJIz7EG4Rj7NItkO",
            useSSL: false,
            onSuccess:onConnect
        });


        function onConnect() {
            console.log("onConnect");
            client.subscribe("ami");
        }

        function onConnectionLost(responseObject) {
            if (responseObject.errorCode !== 0) {
                console.log("onConnectionLost:"+responseObject.errorMessage);
            }
        }

        function onMessageArrived(message) {
            console.log("Message Arrived: "+message.payloadString);
        }

        var sendInterval;

        function sendMessage() {
            clearInterval(sendInterval);

            sendInterval = setInterval(function() {
                var send = $("#message").val(),
                message = new Paho.MQTT.Message(send);
                message.destinationName = "AmirSaeed";
                client.send(message);
                console.log("message sent: " + send);
            }, 2000);
        }


    </script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Test MQTT</div>
                    <div class="card-body">
                        <input type="text" class="form-control" id="message" />
                        <br>
                        <button type="button" class="btn btn-primary" onclick="sendMessage()">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
