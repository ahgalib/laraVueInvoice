import './bootstrap';
import {createApp} from 'vue';
import { createPinia } from 'pinia'
import App from './layouts/App.vue';
import router from './router/index.js';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';

import 'primevue/resources/themes/lara-light-indigo/theme.css';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';


import Button from "primevue/button";
import Sidebar from 'primevue/sidebar';
import StyleClass from 'primevue/styleclass';
import Ripple from 'primevue/ripple';




const app = createApp(App)
const pinia = createPinia()

app.use(pinia)
app.use(router)
app.use(PrimeVue, { ripple: true });
app.use(ToastService);
app.component('Button', Button);
app.component('Sidebar', Sidebar);
app.directive('ripple', Ripple);

app.directive('styleclass', StyleClass);
app.mount("#app")
