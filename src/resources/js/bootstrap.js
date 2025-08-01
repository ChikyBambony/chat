import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY || 'local',             // должен совпадать с PUSHER_APP_KEY из .env
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
    encrypted: false,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER || 'mt1',
    // cluster: 'mt1', // если используешь кластер (необязательно для soketi)
});
