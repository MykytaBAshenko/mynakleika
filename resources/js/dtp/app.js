import Vue from "vue";
import BootstrapVue from "bootstrap-vue";

window.Vue = require("vue");

Vue.prototype.__ = string => _.get(window.i18n, string);

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
Vue.component("dtp-table-component", require("./components/DtpTableComponent.vue"));
Vue.component('base-alert-component', require('../general/alert/BaseAlert.vue'));

const app = new Vue({
	el: "#app"
});
