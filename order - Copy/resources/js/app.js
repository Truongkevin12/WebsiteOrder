import './bootstrap';
import { createApp, onMounted } from "vue";
import App from './App.vue';
import globalState from './api.js';
import router from './router/index.js'
import axios from 'axios';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
window.axios = axios;
const app =  createApp(App);

onMounted(() => {
    console.log(`the component is now mounted.`)
  });
app.provide('globalState', globalState);
app.use(router);
app.use(VueToast);
app.mount("#app");


window.app = app;
