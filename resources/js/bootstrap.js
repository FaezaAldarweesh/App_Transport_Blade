import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import axios from 'axios';
import Echo from 'laravel-echo';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */


// import Pusher from 'pusher-js';
// window.Pusher = Pusher;
//
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     wsHost: process.env.MIX_PUSHER_HOST || '127.0.0.1',
//     wsPort: process.env.MIX_PUSHER_PORT || 6001,
//     wssPort: process.env.MIX_PUSHER_PORT || 6001,
//     forceTLS: process.env.MIX_PUSHER_SCHEME === 'http',
//     encrypted: false,
//     disableStats: true,
//     enabledTransports: ['ws', 'wss'],
// });


