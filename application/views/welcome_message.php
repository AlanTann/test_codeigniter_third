<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>rabbitmq_stomp</title>
</head>
<body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/stomp.js/2.3.3/stomp.js"></script>
<script>
    // Stomp.js boilerplate
    var ws = new WebSocket('ws://127.0.0.1:15674/ws');
    // Init Client
    var client = Stomp.over(ws);
    // Disable heart-beats
    client.heartbeat.outgoing = 0;
    client.heartbeat.incoming = 0;
    // Declare on_connect
    var on_connect = function(x) {
       client.subscribe("/exchange/my_app/user777", function(d) {
            console.log(d);
       });

    };
    // Declare on_error
    var on_error = function () {
        console.log('error');
    };
    // Connect to RabbitMQ
    client.connect('guest', 'guest', on_connect, on_error, '/');
</script>
</body>
</html>
