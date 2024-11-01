import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue'; // Main App component
import router from './router'; // Import the router

const app = createApp(App);

app.use(router); // Use the router
app.mount('#app');
