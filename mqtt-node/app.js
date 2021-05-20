var http = require('http');
var mqtt = require('mqtt');
const axios = require('axios').default;

let topics = [];
const req = axios.get('http://127.0.0.1:8000/api/v2/getDeviceIds')
    .then(function (response) {
        // handle success
        let data = response.data.data;
        data.forEach(item => {
            topics.push(item.serial_number);
        });
        console.log(`topics: ${topics}`);
        socketConnection(topics);
    })
    .catch(function (error) {
        // handle error
        console.log(`error: ${error}`);
    })
    .then(function () {
        // always executed
    });

const socketConnection = (topics) => {
    if(topics.length > 0) {
        console.log("initiating connetion...");
        var client  = mqtt.connect('ws://mqtt.flespi.io', {
            username:"7nlbcTUtpbZP7bnEHvuwfiVBQ8AJ4xK1KU2MBM5QLSuJTHdq0vK6DwxjuVQogpdP",
            password:"7nlbcTUtpbZP7bnEHvuwfiVBQ8AJ4xK1KU2MBM5QLSuJTHdq0vK6DwxjuVQogpdP",
        });

        client.on('connect', function () {
            client.subscribe(topics, function (err) {
                if (err) {
                    console.log(err.toString());
                }
            })
        });

        client.on('message', function (topic, message) {
            try {
                var incomingJson = JSON.parse(message.toString());
                switch (incomingJson.funcName) {
                    case "MQMD": // meter data
                        apiCall('/api/v2/postElectricityMeterData',incomingJson)
                            .then((res) => {
                                console.log("res from promise: " + res);
                            });
                        break;
                    case "MQTD": // split room temperature data
                        break;
                    case "MQIP": // get IR Parameters
                        break;
                    case "MQRD": // get nodes of gateway
                        // get nodes
                        apiCall('/api/v2/nodes',incomingJson).then((res) => {});

                        // publish rtc afterwards
                        setTimeout(currentTimestamp(), 5000);
                        break;
                }
            } catch (e) {
                console.log(e.toString());
            }
            // client.end()
        })
    } else {
        console.log("invalid topics!");
    }
}

const currentTimestamp = () => {
    var now = new Date(),
        year = now.getFullYear(), month = now.getMonth()+1, day = now.getDate(),
        hour = now.getHours(), minutes = now.getMinutes(), seconds = now.getSeconds();
    year = year.toString().substr(2);
    month = month.toString().length > 1 ? month : '0'+month;
    day = day.toString().length > 1 ? day : '0'+day;
    hour = hour.toString().length > 1 ? hour : '0'+hour;
    minutes = minutes.toString().length > 1 ? minutes : '0'+minutes;
    seconds = seconds.toString().length > 1 ? seconds : '0'+seconds;

    const message = `{"sender":"server","gateway_id":"${topic}", "RTC":"71111223211000000&0${hour}0${minutes}0${seconds}0${year}0${month}0${day}"}`;
    console.log(message);
    return message;
};

const apiCall = async (url, myBody) => {
    console.log("http://127.0.0.1:8000"+url);
    axios.post("http://127.0.0.1:8000"+url, myBody)
        .then(function (response) {
            console.log("response from server: ");
            console.log(response.data);
        })
        .catch(function (error) {
            console.log("error: " + error.toString());
        });

};
