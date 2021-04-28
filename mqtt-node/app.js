var mqtt = require('mqtt')
var client  = mqtt.connect('ws://mqtt.flespi.io', {
	username:"7nlbcTUtpbZP7bnEHvuwfiVBQ8AJ4xK1KU2MBM5QLSuJTHdq0vK6DwxjuVQogpdP",
	password:"7nlbcTUtpbZP7bnEHvuwfiVBQ8AJ4xK1KU2MBM5QLSuJTHdq0vK6DwxjuVQogpdP",

})

client.on('connect', function () {
  client.subscribe('ami', function (err) {
    if (!err) {
      client.publish('ami', `{"funcName":"Init"}`)
    }
  })
})

client.on('message', function (topic, message) {
    var incomingJson = JSON.parse(message.toString())
    // console.log(incomingJson.funcName)
    switch (incomingJson.funcName) {
        case "MQMD": // meter data

            break;
        case "MQTD": // split room temperature data
            break;
        case "MQIP": // get IR Parameters
            break;
        case "MQRD": // get nodes of gateway
            break;
    }
    // client.end()
})
const userAction = async (url, myBody) => {
    const response = await fetch(url, {
        method: 'POST',
        body: myBody, // string or object
        headers: {
            'Content-Type': 'application/json'
        }
    });
    const myJson = await response.json(); //extract JSON from the http response
    // do something with myJson
}
