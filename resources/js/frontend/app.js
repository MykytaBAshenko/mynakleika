import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue'

window.Vue = require('vue');

Vue.prototype.__ = function (string, params) {
    let trans = _.get(window.i18n, string);

    if (! _.isEmpty(params)) {
        for (const [key, value] of Object.entries(params)) {
            trans = trans.replace(':'+key, value);
        }
    }
    return trans;
};

Vue.mixin({
    methods: {
        route: route
    }
});

Vue.use(BootstrapVue);
Vue.component('base-alert-component', require('../general/alert/BaseAlert.vue'));
Vue.component('base-popup', require('../general/modals/BasePopup.vue'));
Vue.component('register-form', require('./components/RegisterForm.vue'));
Vue.component('order-create-component', require('./components/OrderCreateComponent'))

const app = new Vue({
    el: '#app'
});
