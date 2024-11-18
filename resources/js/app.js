
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import {createApp} from 'vue';

import { Form } from 'vform';
window.Form=Form;

import Swal from 'sweetalert2';
const toast = Swal.mixin({
    toast: true,
    position: 'center',
    showConfirmButton: false,
    timer: 3000
});
window.toast=toast;

window.showToast = function (message, icon = 'success') {
    Swal.fire({
        toast: true,
        icon: icon,               // 'success', 'error', 'warning', etc.
        title: message,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
};

import $ from 'jquery';
window.$ = $;

import router from './router';

const app = createApp({});
app.use(router);
app.mount('#app');