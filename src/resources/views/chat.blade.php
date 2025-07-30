<x-app-layout>
    <div id="messages">
        @foreach ($messages as $msg)
            <div><b>{{ $msg->user->name }}:</b> {{ $msg->message }}</div>
        @endforeach
    </div>
    <input id="msg" type="text" autofocus>
    <button onclick="sendMsg()">Отправить</button>

    <script src="https://cdn.jsdelivr.net/npm/pusher-js@7/dist/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>
    <script>
        window.Pusher = Pusher;

        window.Echo = new window.LaravelEcho({
            broadcaster: 'pusher',
            key: 'local',
            wsHost: window.location.hostname,
            wsPort: 6001,
            forceTLS: false,
            disableStats: true,
            encrypted: false,
        });

        window.Echo.channel('chat')
            .listen('.message.sent', (e) => {
                document.getElementById('messages').innerHTML +=
                    '<div><b>' + e.message.user.name + ':</b> ' + e.message.message + '</div>';
            });

        function sendMsg() {
            fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: document.getElementById('msg').value })
            });
            document.getElementById('msg').value = '';
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</x-app-layout>
