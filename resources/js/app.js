/**
* Primero, cargaremos todas las dependencias de JavaScript de este proyecto que 
  * Incluye VUE y otras bibliotecas. Es un gran punto de partida cuando 
  * Construyendo aplicaciones web robustas y potentes usando Vue y Laravel.
 */

require('./bootstrap');
import Vue from 'vue'
import Vuex from 'vuex'

// Importamos axios
import VueAxios from 'vue-axios';

import axios from 'axios';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// import 'bootstrap/dist/css/bootstrap.css'
import 'es6-promise/auto'
import 'bootstrap-vue/dist/bootstrap-vue.css'
// router
import routers from '../js/router/router.js'
Vue.use(routers);
Vue.use(VueAxios, axios)
Vue.use(BootstrapVue)
Vue.use(Vuex)
// Componentes
// admin panel
Vue.component('admin-navbar', require('./components/template/navbar.vue').default);
Vue.component('admin-sidebar', require('./components/template/sidebar.vue').default);

const app = new Vue({
    el: '#app',
    //Para rutas de rutas desde rutas.
    router : routers,
});
