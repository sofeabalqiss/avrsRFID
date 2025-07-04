// ======================
// 1. ENVIRONMENT SETUP
// ======================
if (typeof process === 'undefined') {
    window.process = { env: {} };
}

// ======================
// 2. DEPENDENCIES
// ======================
import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// ======================
// 3. AXIOS CONFIGURATION
// ======================
window.axios = axios;
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'Accept': 'application/json'
};

// CSRF Token
const csrfToken = document.head.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
}







