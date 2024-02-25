<template>
    <ValidationObserver v-slot="{ handleSubmit }" ref="form">
        <b-form @submit.prevent="handleSubmit (onSubmit)">
            <div class="row">
                <ValidationProvider
                    class="col-md-6"
                    rules="required|alpha"
                    mode="lazy"
                    v-slot="{ valid, errors }"
                    vid="first_name"
                    :name="__('forms.register.label.first_name')"
                >
                    <b-form-group
                        id="first-name-group"
                        :label="__('forms.register.label.first_name')"
                        label-for="first-name"
                        :invalid-feedback="errors[0]"
                    >
                        <b-form-input
                            id="first-name"
                            v-model="form.first_name"
                            type="text"
                            :placeholder="__('forms.register.placeholder.first_name')"
                            :state="errors[0] ? false : (valid ? true : null)"
                        >
                        </b-form-input>
                    </b-form-group>
                </ValidationProvider>

                <ValidationProvider
                    class="col-md-6"
                    rules="required|alpha"
                    mode="lazy"
                    v-slot="{ valid, errors }"
                    vid="last_name"
                    :name="__('forms.register.label.last_name')"
                >
                    <b-form-group
                        id="last-name-group"
                        :label="__('forms.register.label.last_name')"
                        label-for="last-name"
                        :invalid-feedback="errors[0]"
                    >
                        <b-form-input
                            id="last-name"
                            v-model="form.last_name"
                            type="text"
                            :placeholder="__('forms.register.placeholder.last_name')"
                            :state="errors[0] ? false : (valid ? true : null)"
                        >
                        </b-form-input>
                    </b-form-group>
                </ValidationProvider>
            </div>

            <div class="row">
                <ValidationProvider
                    class="col-md-6"
                    rules="required|email"
                    mode="lazy"
                    v-slot="{ valid, errors }"
                    vid="email"
                    :name="__('forms.register.label.email')"
                >
                    <b-form-group
                        id="email-group"
                        :label="__('forms.register.label.email')"
                        label-for="email"
                        :invalid-feedback="errors[0]"
                    >
                        <b-form-input
                            id="email"
                            v-model="form.email"
                            type="text"
                            :placeholder="__('forms.register.placeholder.email')"
                            :state="errors[0] ? false : (valid ? true : null)"
                        >
                        </b-form-input>
                    </b-form-group>
                </ValidationProvider>

                <ValidationProvider
                    class="col-md-6"
                    rules="required"
                    mode="lazy"
                    v-slot="{ valid, errors }"
                    vid="mobile"
                    :name="__('forms.register.label.mobile')"
                >
                    <b-form-group
                        id="mobile-group"
                        :label="__('forms.register.label.mobile')"
                        label-for="mobile"
                        :invalid-feedback="errors[0]"
                    >
                        <b-form-input
                            id="mobile"
                            v-model="form.mobile"
                            type="tel"
                            v-mask="['+380 (##) ###-##-##']"
                            :placeholder="__('forms.register.placeholder.mobile')"
                            :state="errors[0] ? false : (valid ? true : null)"
                        >
                        </b-form-input>
                    </b-form-group>
                </ValidationProvider>
            </div>

            <div class="row mt-3">
                <ValidationProvider
                    class="col-md-6"
                    rules="required"
                    mode="lazy"
                    v-slot="{ valid, errors }"
                    vid="password"
                    :name="__('forms.register.label.password')"
                >
                    <b-form-group
                        id="password-group"
                        :label="__('forms.register.label.password')"
                        label-for="password"
                        :invalid-feedback="errors[0]"
                        class="show-hide-password"
                    >
                        <b-form-input
                            id="password"
                            v-model="form.password"
                            ref="password"
                            :placeholder="__('forms.register.placeholder.password')"
                            :state="errors[0] ? false : (valid ? true : null)"
                        >
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-eye-slash"></i>
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                        </b-form-input>
                    </b-form-group>
                </ValidationProvider>

                <ValidationProvider
                    class="col-md-6"
                    rules="required|confirmed:password"
                    mode="lazy"
                    v-slot="{ valid, errors }"
                    vid="password_confirmation"
                    :name="__('forms.register.label.password_confirmation')"
                >
                    <b-form-group
                        id="password-confirmation-group"
                        :label="__('forms.register.label.password_confirmation')"
                        label-for="password-confirmation"
                        :invalid-feedback="errors[0]"
                        class="show-hide-password"
                    >
                        <b-form-input
                            id="password-confirmation"
                            v-model="form.password_confirmation"
                            data-vv-as="password"
                            :placeholder="__('forms.register.placeholder.password_confirmation')"
                            :state="errors[0] ? false : (valid ? true : null)"
                        >
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-eye-slash"></i>
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                        </b-form-input>
                    </b-form-group>
                </ValidationProvider>
            </div>
            <b-button type="submit" class="mt-3" variant="success">{{ __('buttons.general.register') }}</b-button>
        </b-form>
    </ValidationObserver>
</template>

<script>
    import { BForm, BFormGroup, BFormInput, BButton } from 'bootstrap-vue'
    import { ValidationObserver, ValidationProvider } from 'vee-validate'
    import { VueTheMask } from 'vue-the-mask';
    import "./validationRules";

    export default {
        components: {
            BForm,
            BFormGroup,
            BFormInput,
            BButton,
            ValidationObserver,
            ValidationProvider,
        },

        directives: {
            'v-mask': VueTheMask,
        },

        name: "RegisterForm",

        props: ['token'],

        data() {
            return {
                form: {
                    first_name: "",
                    last_name: "",
                    email: "",
                    mobile: "",
                    password: "",
                    password_confirmation: "",
                    customer_name: "",
                },
            }
        },

        methods: {
            onSubmit () {
                axios({
                    method: "post",
                    url: route('frontend.auth.register.post'),
                    data: {
                        first_name: this.form.first_name,
                        last_name: this.form.last_name,
                        email: this.form.email,
                        mobile: this.form.mobile,
                        password: this.form.password,
                        password_confirmation: this.form.password_confirmation,
                        customer_name: this.form.customer_name,
                        token: this.token
                    }
                })
                .then(response => {
                    window.location = response.data.redirect;
                })
                .catch(error => {
                    this.$refs.form.setErrors(error.response.data.errors);
                });
            },
        }
    }
</script>

<style scoped>

</style>
