<template>
    <div class="row">
        <div class="col-12">
            <BSelectWithValidation
                v-model="delivery.type"
                rules="required"
                :options="options"
                :label="__('forms.order.label.method')"
                :name="__('forms.order.label.method')"
                :placeholder="__('forms.order.placeholder.method')"
                optionsLabel="text"
                @input="[onChange(), onChangeDeliveryType()]"
            />

            <template v-if="delivery.type && parseInt(delivery.type.value) === 2">
                <BInputWithValidation
                    v-model="delivery.address"
                    rules="required"
                    vid="address"
                    :label="__('forms.delivery.label.address')"
                    :name="__('forms.delivery.label.address')"
                    :description="__('forms.delivery.description.address')"
                    @input="onChange"
                />
            </template>

            <template v-if="delivery.type && parseInt(delivery.type.value) === 3">
                <BSelectWithValidation
                    v-model="delivery.city"
                    rules="required"
                    vid="city"
                    :options="cities"
                    :label="__('forms.delivery.label.city')"
                    :name="__('forms.delivery.label.city')"
                    :placeholder="__('forms.delivery.placeholder.city')"
                    @input="[onChange(), getWarehouses(delivery.city)]"
                />

                <BSelectWithValidation
                    v-model="delivery.np_warehouse"
                    rules="required"
                    vid="warehouse"
                    :options="warehouses"
                    :label="__('forms.delivery.label.warehouse')"
                    :name="__('forms.delivery.label.warehouse')"
                    :placeholder="__('forms.delivery.placeholder.warehouse')"
                    @input="onChange"
                />

                <b-form-group
                    label="Плательщик">
                    <b-form-input
                        type="text"
                        v-model="delivery_payer_options[delivery.np_payer]"
                        readonly
                        @input="onChange"
                    />
                </b-form-group>
            </template>

            <template v-if="delivery.type && parseInt(delivery.type.value) !== 1">
                <BInputWithValidation
                    v-model="delivery.contact_person"
                    rules="required"
                    vid="contact_person"
                    :label="__('forms.delivery.label.contact_person')"
                    :name="__('forms.delivery.label.contact_person')"
                    @input="onChange"
                />

                <BInputWithValidation
                    v-model="delivery.contact_phone"
                    rules="required"
                    vid="contact_phone"
                    type="tel"
                    v-mask="['+380 (##) ###-##-##']"
                    :label="__('forms.delivery.label.contact_phone')"
                    :name="__('forms.delivery.label.contact_phone')"
                    :description="__('forms.delivery.description.contact_phone')"
                    @input="onChange"
                />
            </template>

        </div>
    </div>
</template>

<script>
    import BSelectWithValidation from "../../../customer/components/inputs/BSelectWithValidation";
    import BInputWithValidation from "../../../customer/components/inputs/BInputWithValidation";

	export default {
	    components: {
            BSelectWithValidation,
            BInputWithValidation
        },

        props: ['bus'],

		data () {
			return {
				delivery: {
				    type: null,
                    address: null,
                    contact_person: null,
                    contact_phone: null,
                    city: null,
                    np_warehouse: null,
                    // np_organization: null,
                    np_payer: 2,
                },
				options: [
				    { value: '1', text: 'Самовывоз' },
                    { value: '2', text: 'Курьером по Киеву' },
                    { value: '3', text: 'Новая Почта' }
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
            onChange() {
                if (this.delivery) {
                    this.$emit('deliveryChanged', {
                        'delivery': {
                            type: this.delivery.type.value,
                            address: this.delivery.address,
                            contact_person: this.delivery.contact_person,
                            contact_phone: this.delivery.contact_phone,
                            city: this.delivery.city,
                            np_warehouse: this.delivery.np_warehouse,
                            np_payer: this.delivery.np_payer,
                        },
                    });
                }
            },

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
                        this.delivery.np_warehouse = '';
                        let warehouses = json.data;
                        let warehouses_f = warehouses.filter( function (item) {
                            return item.CityDescriptionRu === city
                        });

                        this.warehouses = warehouses_f.map( function (item) {
                            return item.DescriptionRu
                        })
                    })
            },

            onChangeDeliveryType() {
                Object.assign(this.delivery, {
                    address: null,
                    contact_person: null,
                    contact_phone: null,
                    city: null,
                    np_warehouse: null,
                    np_payer: 2,
                });
            }
        }
	}
</script>
