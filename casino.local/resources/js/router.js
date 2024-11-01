import { createRouter, createWebHistory } from 'vue-router';
import Home from './components/RegComponent.vue';
import DashBoardComponent from './components/DashBoardComponent.vue';

// Define your routes
const routes = [
    { path: '/', component: Home, name: 'home' },
    { path: '/dashboard/:hash', props: true, component: DashBoardComponent, name: 'dashboard' },
];

// Create the router instance
const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
