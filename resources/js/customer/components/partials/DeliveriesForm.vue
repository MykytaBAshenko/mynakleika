<template>
    <div class="row">
        <div class="col-12">
            <BSelectWithValidation
                v-model="delivery"
                rules="required"
                vid="delivery"
                :options="options"
                :label="__('forms.order.label.method')"
                :name="__('forms.order.label.method')"
                :placeholder="method_placeholder"
                optionsLabel="text"
                @input="onChange"
            />
        </div>

        <div class="col-sm-12 col-md-8 col-lg-6 col-xl-5">
            <delivery-modal-form @submit="addDeliveryToSelectInput"/>
            <b-button
                class="btn-block d-flex align-items-center"
                variant="success"
                v-b-modal.add_delivery
            >
                <i class="material-icons-outlined pr-2">add_circle</i>
                <span>{{ __('buttons.general.add_new') }}</span>
            </b-button>
        </div>
    </div>
</template>

<script>
    import DeliveryModalForm from "../modals/DeliveryModalForm";
    import BSelectWithValidation from "../inputs/BSelectWithValidation";

	export default {
	    components: {
	        DeliveryModalForm,
            BSelectWithValidation,
        },

        props: ['bus'],

		data () {
			return {
				delivery: null,
				options: [],
                method_placeholder: i18n.forms.order.placeholder.method,
			}
		},

        created () {
            this.getDeliveries()
        },

        methods: {
            getDeliveries () {
                axios({
                    method: 'get',
                    url: route('customer.deliveries.get_customer_deliveries')
                })
                .catch(error => {
                    console.log(error);
                })
                .then(response => {
                    try {
                        this.fillOptions(response.data)
                    } catch (err) {
                        this.method_placeholder = "Невозможно получить данные о доставках"
                    }
                });
            },

            fillOptions (data) {
                let t = i18n.options.delivery_options;
                this.options = data.map(function (item) {
                    switch (item.type) {
                        case 2:
                            return {value: item.id, text: t[item.type] + ' (' + item.address + ')'};
                        case 3:
                            return {value: item.id, text: t[item.type] + ' (' + item.city + ', ' + item.np_warehouse + ')'};
                        default:
                            return {value: item.id, text: t[item.type]};
                    }
                })
            },

            addDeliveryToSelectInput () {
                this.getDeliveries();
            },

            onChange() {
                if (this.delivery) {
                    this.$emit('deliveryChanged', {
                        'delivery': this.delivery.value
                    });
                }
            }
        }
	}
</script>
