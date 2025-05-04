import { createApp } from 'vue';
import AdminDashboard from './components/AdminDashboard.vue';

const app = createApp({});
app.component('admin-dashboard', AdminDashboard);
app.mount('#app');
