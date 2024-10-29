
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue';
import { Form, HasError, AlertError } from 'vform'

import VueProgressBar from 'vue-progressbar'
Vue.component(HasError.name,HasError);
Vue.component(AlertError.name, AlertError);


import Swal from 'sweetalert2';
window.Swal=Swal;

const toast = Swal.mixin({
  toast: true,
  position: 'center',
  showConfirmButton: false,
  timer: 3000
});

window.toast=toast;


window.Form=Form;
import VueRouter from 'vue-router'

Vue.use(VueRouter);



Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '4px'
});


let routes = [
  { path: '/Modules', component: require('./components/Module.vue') },
  { path: '/Menus', component: require('./components/Menu.vue') }
]



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));


const router = new VueRouter({
	mode: 'history',
 	routes // short for `routes: routes`

})

const app = new Vue({
    el: '#app',
    router
});
