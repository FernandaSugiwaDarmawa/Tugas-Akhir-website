window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'pusher', // Ganti dengan broadcaster yang Anda gunakan
    key: process.env.MIX_PUSHER_APP_KEY, // Gunakan kunci Pusher dari environment variables
    cluster: process.env.MIX_PUSHER_APP_CLUSTER, // Gunakan cluster Pusher dari environment variables
    encrypted: true, // Gunakan koneksi terenkripsi (SSL/TLS)
    forceTLS: true, // Paksa gunakan TLS/SSL
    wsHost: window.location.hostname, // Setel host WebSocket
    wsPort: 6001, // Setel port WebSocket
    disableStats: true, // Nonaktifkan statistik untuk alasan kinerja
});
