@extends('layouts.app')
@section('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
    <script type="text/javascript" language="javascript">
        var name = "unknown", topic = "ami";
        window.onload = function() {
            topic = prompt("Enter topic name you want to join", topic);
            name = prompt("Enter name", name);

            document.getElementById("username").innerHTML = "Username: " + name;
            document.getElementById("topic").innerHTML = "Topic: " + topic;

            client = new Paho.MQTT.Client("mqtt.flespi.io", Number(80), name);

            client.onConnectionLost = onConnectionLost;
            client.onMessageArrived = onMessageArrived;

            client.connect({
                timeout: 1200,
                userName:"7nlbcTUtpbZP7bnEHvuwfiVBQ8AJ4xK1KU2MBM5QLSuJTHdq0vK6DwxjuVQogpdP",
                password:"7nlbcTUtpbZP7bnEHvuwfiVBQ8AJ4xK1KU2MBM5QLSuJTHdq0vK6DwxjuVQogpdP",
                useSSL: false,
                keepAliveInterval: 86400, // for one day
                onSuccess:onConnect
            });
        };

        function onConnect() {
            console.log("onConnect");
            client.subscribe(topic);
        }

        function onConnectionLost(responseObject) {
            if (responseObject.errorCode !== 0) {
                console.log("onConnectionLost: " + responseObject.errorMessage);
            }

            client.connect({
                timeout: 1200,
                userName:"7nlbcTUtpbZP7bnEHvuwfiVBQ8AJ4xK1KU2MBM5QLSuJTHdq0vK6DwxjuVQogpdP",
                password:"7nlbcTUtpbZP7bnEHvuwfiVBQ8AJ4xK1KU2MBM5QLSuJTHdq0vK6DwxjuVQogpdP",
                useSSL: false,
                onSuccess:onConnect
            });
        }

        function onMessageArrived(message) {
            // console.log("Message Arrived: " + message.payloadBytes);
            addMessageToList(message.payloadString);
        }

        function addMessageToList(message) {
            var today = new Date(),
                hours = today.getHours(),
                minutes = today.getMinutes(),
                seconds = today.getSeconds(),
                time = (hours.toString().length<2 ? '0'+hours : hours) + ":" + (minutes.toString().length < 2 ? '0'+minutes : minutes) + ":" + (seconds.toString().length < 2 ? '0'+seconds : seconds);

            var node = document.createElement("LI"),
                textNode = document.createTextNode(message),
                span = document.createElement("SPAN");
            span.classList.add("message-time");

            var timeText = document.createTextNode(time);

            span.appendChild(timeText);
            node.appendChild(textNode);
            node.appendChild(span);

            node.classList.add("message-item");
            // node.style.backgroundColor = "#f9d6d5";
            // node.style.transition = "background-color 300ms linear";
            // node.style.padding = "5px 10px";
            // node.style.direction = "ltr";

            setTimeout(function() {
                node.style.backgroundColor = "white";
            }, 2000);

            document.getElementById("messages").appendChild(node);
            var list = document.getElementById("messages");
            list.insertBefore(node, list.childNodes[0]);
        }

        // var sendInterval;

        function sendMessage() {
            // clearInterval(sendInterval);

            // sendInterval = setInterval(function() {
            // var send = $("#message").val(),
            // to = $("#send-to").val(),
            // message = new Paho.MQTT.Message(send);
            // message.destinationName = to;
            // client.send(message);
            // console.log("message sent: " + send);
            // }, 2000);
            var message = $("#message").val();
            // client.send(topic, name + ": " + messgae);
            client.send(topic, message);
            // console.log("message sent: " + send);
            $("#message").val("");
        }
    </script>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span id="topic" style="float:left">Topic: ami</span>
                        <span id="username">Username: unknown</span>
                    </div>
                    <div class="card-body">
                        <div style="width:100%;direction:ltr;">
                            <div style="width:75%;display:inline-block;">
                                <input type="text" id="message" class="form-control" placeholder="Enter Message..." />
                            </div>
                            <div style="width:20%;display:inline-block;">
                                <button type="button" class="btn btn-primary" onclick="sendMessage()">Send</button>
                            </div>
                        </div>
                        <hr />
                        <ul id="messages" class="messages"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
