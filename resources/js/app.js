import './bootstrap';
import '../css/app.css';
import {createApp, defineComponent } from "vue/dist/vue.esm-bundler.js";
import ResourcesList from "./components/ResourcesList.vue";
import AdminPage from "./components/AdminPage.vue";


window.Vue = import('vue');

// Root vue component
const root = defineComponent({/* ... */})

//Create the app
const app = createApp(root)
app.component('resources-list',ResourcesList);
app.component('admin-page',AdminPage);
app.mount('#app')
