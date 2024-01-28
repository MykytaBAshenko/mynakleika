import axios from 'axios';
import Vue from 'vue';

window.Vue = require('vue');
window.axios = axios;

Vue.component('calc-component', require('./components/CalcComponent'));

const app = new Vue({
    el: '#calc'
});
