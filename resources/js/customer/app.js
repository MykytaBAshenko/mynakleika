import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import "./components/validationRules";

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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(BootstrapVue);
Vue.component('order-table-component', require('./components/OrderTableComponent.vue'));
Vue.component('order-create-component', require('./components/OrderCreateComponent.vue'));
Vue.component('payment-component', require('./components/PaymentComponent'));
Vue.component('invoices-table-component', require('./components/InvoicesTableComponent.vue'));
Vue.component('transactions-table-component', require('./components/TransactionsTableComponent.vue'));
Vue.component('delivery-component', require('./components/DeliveryComponent.vue'));
Vue.component('base-alert-component', require('../general/alert/BaseAlert.vue'));
Vue.component('base-popup-component', require('../general/modals/BasePopup'));
Vue.component('legal-entities-dashboard', require('./components/LegalEntitiesDashboard'));

const app = new Vue({
    el: '#app'
});
