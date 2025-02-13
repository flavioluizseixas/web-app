import { createApp } from 'vue';
import App from './App.vue';
import { createVuetify } from 'vuetify';
import 'vuetify/dist/vuetify.min.css';

const vuetify = createVuetify();
createApp(App).use(vuetify).mount('#app');
