import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index'
import axios from 'axios'
import VueAxios from 'vue-axios'
import { store } from './store/index'
import Toaster from "@meforma/vue-toaster";
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'



const app = createApp(App);
app.config.globalProperties.$api_url = "http://localhost:8080/api/v1/";
app.use(router);
app.use(VueAxios, axios);
app.use(store);
app.use(Toaster, {
    position: "bottom-right",
  });
app.mount('#app')
