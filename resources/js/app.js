import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';


// Create Vue application
const app = createApp(App);

// Use Vue Router
app.use(router);

// Mount to #app
app.mount('#app');
