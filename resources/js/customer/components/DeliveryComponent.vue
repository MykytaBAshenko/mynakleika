<template>
	<div>
		<b-table
			show-empty
			stacked = "sm"
			hover
			class="order-table"
			:items = "deliveries"
			:fields = "fields"
		>
            <template v-slot:cell(type)="data">
                {{ delivery_options[data.value] }}
            </template>

            <template v-slot:cell(np_payer)="data">
                {{ delivery_payer_options[data.value] }}
            </template>

            <template v-slot:cell(np_warehouse)="data">
				<span data-toggle="tooltip" data-placement="bottom" :title="data.value">
					{{ data.value }}
				</span>
			</template>

			<template v-slot:cell(actions)="row">
                <!--  <a :href="route('frontend.customer.delivery.edit', {delivery: row.item.id})" class="btn btn-sm btn-outline-primary" role="button">
					<i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i>
				</a> -->
				<button v-if="parseInt(row.item.type)!== 1" @click="onDelete(row.item.id)" class="btn btn-sm btn-outline-secondary" role="button">
					<i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i>
				</button>
			</template>
		</b-table>

		<b-btn variant="success" class="pull-right" v-b-modal.add_delivery>
			<i class="fas fa-plus-circle"></i>&nbsp;Добавить способ доставки
		</b-btn>
        <delivery-modal-form @submit="getDeliveries"/>

	</div>
</template>

<script>
    import DeliveryModalForm from "./modals/DeliveryModalForm";
    export default {
        components: {
            DeliveryModalForm,
        },

        props: ['deliveriesData'],

        data () {
            return {
                deliveries: this.deliveriesData,
                fields: [
                    { key: 'type', label: 'Тип доставки' },
                    { key: 'city', label: 'Город' },
                    { key: 'address', label: 'Адрес доставки' },
                    { key: 'np_warehouse', label: 'Отделение НП', 'class' : 'spoiler' },
                    { key: 'contact_person', label: 'Получатель' },
                    { key: 'contact_phone', label: 'Телефон' },
                    { key: 'np_organization', label: 'Огранизация', 'class' : 'spoiler' },
                    { key: 'np_payer', label: 'Плательщик' },
                    { key: 'actions', label: 'Действия', 'class': 'text-center' },
                ],

                hover: true,
                small: false,
                stacked: 'sm',
                delivery_options: i18n.options.delivery_options,
                delivery_payer_options: i18n.options.delivery_payer_options,
            }
        },

        methods: {
            getDeliveries () {
                axios({
                    method: "get",
                    url: route('customer.deliveries.get_customer_deliveries'),
                })
                .then(response => {
                    this.deliveries = response.data
                })
                .catch(error => {
                    console.log(error);
                })
            },

            onDelete (id) {
                axios({
                    method: "delete",
                    url: route('customer.delivery.destroy', {delivery: id}),
                })
                .then(response => {
                    if (response.status) {
                        this.getDeliveries();
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            },
        }
    }
</script>
