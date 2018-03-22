
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import router from './routes';

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import MainMenu from './components/MainMenu';
Vue.component('main-menu', MainMenu);

import ConfirmModals from './components/ConfirmModals';
Vue.component('confirm-modals', ConfirmModals);

const app = new Vue({
    el      : '#app',
    router  : router,
});