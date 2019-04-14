
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap-select');

window.Vue = require('vue');
window.Chart = require('chart.js');
window.VueResource = require('vue-resource');
window.$ = window.jQuery = require('jquery');

window.Noty = require('noty');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('niquelino-lucro-dia', require('./components/charts/niquelino-lucro-dia.vue'));
Vue.component('niquelino-lucro-hoje', require('./components/charts/niquelino-lucro-hoje.vue'));
Vue.component('niquelino-mini-lucro-dia', require('./components/charts/niquelino-mini-lucro-dia.vue'));
Vue.component('notificacao', require('./components/Notificacao.vue'));
Vue.component('homebroker-default', require('./components/homebroker/Default.vue'));
Vue.component('vue-top-progress', require('vue-top-progress'));

const app = new Vue({
    el: '#app'
});
