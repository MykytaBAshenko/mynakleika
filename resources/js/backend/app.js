import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';

window.Vue = require('vue');

Vue.prototype.__ = string => _.get(window.i18n, string);

Vue.mixin({
    methods: {
        route: route
    }
});

Vue.use(BootstrapVue);
Vue.component('payers-list-component', require('./components/PayersListComponent'));
Vue.component('base-alert-component', require('../general/alert/BaseAlert.vue'));

const app = new Vue({
    el: '#app'
});
