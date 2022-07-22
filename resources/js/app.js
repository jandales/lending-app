import './bootstrap';

import {createApp} from 'vue'

import App from './App.vue'
import router from './route'
import axios from './axios';
import VueAxios from 'vue-axios'
import 'tw-elements';


const app = createApp(App);
app
.use(VueAxios, axios)
.use(router)
.mount("#app")
