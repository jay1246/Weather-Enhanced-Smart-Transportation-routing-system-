<!-- websocket_test.html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Test</title>
</head>
<body>
    <input type="text" id="messageInput" placeholder="Type a message...">
    <button onclick="sendMessage()">Send</button>
    <div id="messageArea"></div>

    <script>
        const socket = new WebSocket('ws://at.aqato.com.au/server'); // Replace with your WebSocket server URL

        socket.onopen = function(event) {
            console.log('WebSocket connection established');
        };

        socket.onmessage = function(event) {
            const messageArea = document.getElementById('messageArea');
            messageArea.innerHTML += '<p>' + event.data + '</p>';
        };

        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value;
            socket.send(message);
            messageInput.value = '';
        }
    </script>
</body>
</html>
