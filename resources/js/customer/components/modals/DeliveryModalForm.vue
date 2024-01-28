<template>
    <!-- Modal Component -->
    <b-modal
        id="add_delivery"
        size="sm"
        title="Создание нового способа доставки"
        ok-title="Сохранить"
        ok-variant="success"
        cancel-title="Отмена"
        hide-header-close
        ref="modal"
        @ok="onOk"
        @show="resetModal"
        @hide="onHide"
    >
        <ValidationObserver ref="delivery_modal">
            <b-form @submit.stop.prevent="onSubmit">

                <BSelectWithValidation
                    v-model="form.type"
                    rules="required"
                    vid="type"
                    :options="deliveriesType"
                    :label="__('forms.delivery.label.method')"
                    :name="__('forms.delivery.label.method')"
                    :placeholder="__('forms.delivery.placeholder.method')"
                    optionsLabel="text"
                />

                <template v-if="parseInt(form.type.value) === 3">
                    <BSelectWithValidation
                        v-model="form.city"
                        rules="required"
                        vid="city"
                        :options="cities"
                        :label="__('forms.delivery.label.city')"
                        :name="__('forms.delivery.label.city')"
                        :placeholder="__('forms.delivery.placeholder.city')"
                        @input="getWarehouses(form.city)"
                    />

                    <BSelectWithValidation
                        v-model="form.np_warehouse"
                        rules="required"
                        vid="warehouse"
                        :options="warehouses"
                        :label="__('forms.delivery.label.warehouse')"
                        :name="__('forms.delivery.label.warehouse')"
                        :placeholder="__('forms.delivery.placeholder.warehouse')"
                    />

                    <BInputWithValidation
                        v-model="form.np_organization"
                        rules="required"
                        vid="receiver"
                        :label="__('forms.delivery.label.receiver')"
                        :name="__('forms.delivery.label.receiver')"
                        :description="__('forms.delivery.description.receiver')"
                    />

                    <b-form-group
                        label="Плательщик">
                        <b-form-input
                            type="text"
                            v-model="delivery_payer_options[form.np_payer]"
                            readonly
                        />
                    </b-form-group>
                </template>

                <template v-if="parseInt(form.type.value) === 2">
                    <BInputWithValidation
                        v-model="form.address"
                        rules="required"
                        vid="address"
                        :label="__('forms.delivery.label.address')"
                        :name="__('forms.delivery.label.address')"
                        :description="__('forms.delivery.description.address')"
                    />
                </template>

                <template v-if="form.type">
                    <BInputWithValidation
                        v-model="form.contact_person"
                        rules="required"
                        vid="contact_person"
                        :label="__('forms.delivery.label.contact_person')"
                        :name="__('forms.delivery.label.contact_person')"
                    />

                    <BInputWithValidation
                        v-model="form.contact_phone"
                        rules="required"
                        vid="contact_phone"
                        type="tel"
                        v-mask="['+380 (##) ###-##-##']"
                        :label="__('forms.delivery.label.contact_phone')"
                        :name="__('forms.delivery.label.contact_phone')"
                        :description="__('forms.delivery.description.contact_phone')"
                    />
                </template>

            </b-form>
        </ValidationObserver>
    </b-modal>
</template>

<script>
    import { VueTheMask } from 'vue-the-mask';
    import { Multiselect } from 'vue-multiselect';
    import { ValidationObserver } from "vee-validate";
    import BInputWithValidation from "../inputs/BInputWithValidation";
    import BSelectWithValidation from "../inputs/BSelectWithValidation";
    import "../validationRules";

    export default {
        name: "DeliveryModalForm",

        directives: {
            'v-mask': VueTheMask,
        },

        components: {
            Multiselect,
            ValidationObserver,
            BInputWithValidation,
            BSelectWithValidation,
        },

        data() {
            return {
                form: {
                    type: Object,
                    city: '',
                    address: '',
                    contact_person: '',
                    contact_phone: '',
                    np_warehouse: '',
                    np_organization: '',
                    np_payer: 2,
                },
                deliveriesType: [
                    { value: 2, text: i18n.options.delivery_options[2] },
                    { value: 3, text: i18n.options.delivery_options[3] },
                ],
                cities: [],
                warehouses: [],
                delivery_payer_options: i18n.options.delivery_payer_options,
            }
        },

        created () {
            this.getCities();
        },

        methods: {
            getCities () {
                if (this.cities.length === 0) {
                    fetch('/data/cities.json')
                    .then(r => r.json())
                    .then(json => {
                        let cities = json.data;
                        this.cities = cities.map( function (item) {
                            return item.DescriptionRu
                        });
                    })
                }
            },

            getWarehouses (city) {
                fetch('/data/warehouses.json')
                .then(r => r.json())
                .then(json => {
                    this.form.np_warehouse = '';
                    let warehouses = json.data;
                    let warehouses_f = warehouses.filter( function (item) {
                        return item.CityDescriptionRu === city
                    });

                    this.warehouses = warehouses_f.map( function (item) {
                        return item.DescriptionRu
                    })
                })
            },

            resetModal () {
                this.form.type = '';
                this.form.city = '';
                this.form.address = '';
                this.form.contact_person = '';
                this.form.contact_phone = '';
                this.form.np_warehouse = '';
                this.form.np_organization = '';
                this.form.np_payer = 2;
            },

            onOk (bvModalEvt) {
                bvModalEvt.preventDefault();
                this.$refs.delivery_modal.validate().then(success => {
                    if (!success) {
                        return;
                    }
                    this.onSubmit();
                });
            },

            onHide (bvModalEvt) {
                if (bvModalEvt.trigger === 'cancel') {
                    this.$refs.modal.hide();
                } else {
                    bvModalEvt.preventDefault();
                }
            },

            onSubmit () {
                axios({
                    method: "post",
                    url: route('customer.delivery.store'),
                    data: {
                        type: this.form.type.value,
                        city: this.form.city,
                        address: this.form.address,
                        contact_person: this.form.contact_person,
                        contact_phone: this.form.contact_phone,
                        np_organization: this.form.np_organization,
                        np_warehouse: this.form.np_warehouse,
                        np_payer: this.form.np_payer,
                    }
                })
                .then(response => {
                    if (response.status) {
                        this.$emit('submit');
                        this.$nextTick(() => {
                            this.$refs.modal.hide('cancel')
                        })
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            },
        }
    }
</script>
