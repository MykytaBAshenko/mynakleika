const mix = require("laravel-mix");

require('laravel-mix-alias');

mix.alias({
    'AutoNumeric': 'node_modules/autonumeric/dist/autoNumeric.min.js'
});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.setPublicPath("public");

mix.js("resources/js/frontend/frontend.js", "js/frontend.js")
	.js("resources/js/backend/backend.js", "js/backend.js")
	.js("resources/js/backend/app.js", "js/admin-app.js")
	.js("resources/js/customer/app.js", "js/customer-app.js")
	.js("resources/js/accountant/app.js", "js/accountant-app.js")
	.js("resources/js/dtp/app.js", "js/dtp-app.js")
    .js("resources/js/frontend/app.js", "js/frontend-app.js")
	.js("resources/js/frontend/landing.js", "js/landing.js")
	.extract([
		"jquery",
        "bootstrap",
        "vue",
		// "bootstrap-vue",
		"popper.js/dist/umd/popper",
		"axios",
		"sweetalert2",
		"lodash",
		"@fortawesome/fontawesome-svg-core",
		"@fortawesome/free-brands-svg-icons",
		"@fortawesome/free-regular-svg-icons",
		"@fortawesome/free-solid-svg-icons"
	]);

mix.sass("resources/sass/frontend/app.scss", "css/frontend.css")
	.sass("resources/sass/backend/app.scss", "css/backend.css")
	.sass("node_modules/@coreui/coreui/scss/coreui.scss", "css/coreui.css")

if (mix.inProduction() || process.env.npm_lifecycle_event !== "hot") {
	mix.version();
}
