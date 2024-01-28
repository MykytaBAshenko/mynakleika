<template>
	<div>
		<b-row class="justify-content-between pt-2">
			<b-col cols="12" md="4">
				<b-form-group class="pb-2">
					<b-input-group>
						<b-form-input debounce="1000" v-model="filterVal" :placeholder="__('strings.backend.general.search_placeholder')" />
						<b-input-group-append>
							<b-btn :disabled="!filterVal" @click="filterVal = ''">{{ __('strings.backend.general.search_clear') }}</b-btn>
						</b-input-group-append>
					</b-input-group>
				</b-form-group>
			</b-col>

			<b-col cols="12" md="8">
				<b-form-group class="pb-2">
					<div class="btn-toolbar float-md-right" role="toolbar">
                        <a :href="route('customer.finance.payments')" class="btn btn-primary mr-3 d-block">
                            <i class="fas fa-wallet"></i>
                            &nbsp;{{ __('buttons.customer.invoice.pay_for_orders') }}
                        </a>

                        <a :href="route('customer.order.create')" class="btn btn-success d-block">
                            <i class="fas fa-plus-circle"></i>
                            &nbsp;{{ __('buttons.general.create_new') }}
                        </a>
					</div>
				</b-form-group>
			</b-col>
		</b-row>

		<!-- Main table element -->

		<div class="table-responsive">
			<b-table
				class="order-table"
				show-empty
				stacked = "sm"
				head-variant = "dark"
				:sort-by.sync="sortBy"
				:sort-desc.sync="sortDesc"
				:sort-direction="sortDirection"
				:items = "orderDataProvider"
				:fields = "fields"
				:filter = "filter"
                :filter-included-fields="filterIncludedFields"
				:current-page = "currentPage"
				:per-page = "perPage"
                :tbody-tr-class="rowClass"
                :busy.sync="isBusy"
				@filtered = "onFiltered"
            >

				<template v-slot:head(created_at)="data">
					<span data-toggle="tooltip" data-placement="bottom" :title="data.label">
						{{ __('labels.general.order_table.created_at_short') }}
					</span>
				</template>

				<template v-slot:head(end_at)="data">
					<span data-toggle="tooltip" data-placement="bottom" :title="data.label">
						{{ __('labels.general.order_table.end_at_short') }}
					</span>
				</template>

				<template v-slot:head(production_status)="data">
					<span data-toggle="tooltip" data-placement="bottom" :title="data.label">
						{{ __('labels.general.order_table.ps_short') }}
					</span>
				</template>

				<template v-slot:head(finance_status)="data">
					<span data-toggle="tooltip" data-placement="bottom" :title="data.label">
						{{ __('labels.general.order_table.fs_short') }}
					</span>
				</template>

                <template v-slot:cell(id)="row">
                    <b-link class="order-details-link" @click="orderCardModalEmitter(row.item)">
                        {{ row.item.id }}
                    </b-link>
                </template>

				<template v-slot:cell(order_ref)="data">
					<span data-toggle="tooltip" data-placement="bottom" :title="data.value">
						{{ data.value }}
					</span>
				</template>

				<template v-slot:cell(preview_link)="row">
					<b-link @click="previewModalEmitter(row.item)">
                        <i class="material-icons-outlined">wallpaper</i>
					</b-link>
				</template>

				<template v-slot:cell(production_status)="data">
					<i v-if="parseInt(data.value) === 1"
						class="text-danger material-icons"
						data-toggle="tooltip"
						data-placement="bottom"
						:title="production_status[data.value]"
					>update</i>

					<i v-else-if="parseInt(data.value) === 2"
						class="text-success material-icons"
						data-toggle="tooltip"
						data-placement="bottom"
						:title="production_status[data.value]"
					>play_circle_filled</i>

					<i v-else-if="parseInt(data.value) === 3"
						class="text-warning material-icons"
						data-toggle="tooltip"
						data-placement="bottom"
						:title="production_status[data.value]"
					>view_quilt</i>

					<i v-else-if="parseInt(data.value) === 4"
						class="text-grey material-icons"
						data-toggle="tooltip"
						data-placement="bottom"
						:title="production_status[data.value]"
					>send</i>

					<i v-else-if="parseInt(data.value) === 5"
						class="text-primary material-icons"
						data-toggle="tooltip"
						data-placement="bottom"
						:title="production_status[data.value]"
					>done_all</i>

					<i v-else-if="parseInt(data.value) === 6"
						class="text-danger material-icons"
						data-toggle="tooltip"
						data-placement="bottom"
						:title="production_status[data.value]"
					>cancel</i>
				</template>

				<template v-slot:cell(finance_status)="data">
					<span v-if="parseInt(data.value) === 1"
						class="icon-hryvna-sign text-danger font-sm"
						data-toggle="tooltip"
						data-placement="bottom"
						:title="finance_status[data.value]"
					/>

					<span v-else-if="parseInt(data.value) === 2"
						class="icon-hryvna-sign text-warning font-sm"
						data-toggle="tooltip"
						data-placement="bottom"
						:title="finance_status[data.value]"
					/>

					<span v-else
						class="icon-hryvna-sign text-success font-sm"
						data-toggle="tooltip"
						data-placement="bottom"
						:title="finance_status[data.value]"
					/>
				</template>

				<template v-slot:cell(delivery)="row">
					<span data-toggle="tooltip"
                          data-placement="bottom"
                          :title="deliveryOptions[row.item.delivery.type]">
						{{ deliveryOptions[row.item.delivery.type] }}
					</span>
				</template>

                <template v-slot:cell(cost)="row">
                    {{ moneyFormatter(row.item.cost)  }}
                </template>

                <template v-slot:cell(actions)="row">
                    <b-button
                        v-if="parseInt(row.item.production_status) === 1 && row.item.invoice.length === 0"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Удалить"
                        @click="deleteOrderEmitter(row.item)"
                        variant="link"
                        size="sm"
                    >
                        <i class="text-dark material-icons">delete_outline</i>
                    </b-button>

                    <b-link v-if="parseInt(row.item.production_status) === 5"
                       data-toggle="tooltip"
                       data-placement="bottom"
                       title="Повторить"
                    ><i class="text-success material-icons">file_copy</i></b-link>
                </template>
			</b-table>
		</div>

        <!-- Preview Modal -->
        <b-modal id="preview-modal" centered hide-footer size="sm">
            <div id="contents'" class="col-sm">
                <b-img-lazy :src="'/storage/' + order.file.name + '.tn.jpg'" fluid class="d-block mx-auto"></b-img-lazy>
            </div>
        </b-modal>

        <!-- Order Card Modal -->
        <b-modal id="order-card-modal" size="lg" :title="order.order_ref" hide-footer>
            <order-card
                :order="order"
                :deliveryOptions="deliveryOptions"
                :deliveryPayerOptions="deliveryPayerOptions"
            />
        </b-modal>

        <!-- Delete Order Modal -->
        <b-modal
            id="delete-order-modal"
            title="Подтверждение удаления заказа"
            size="sm"
            ok-title="Удалить"
            ok-variant="danger"
            cancel-title="Отмена"
            hide-header-close
            @ok="onDelete(order.id)"
        >
            Удалить заказ №{{ order.id }}?
        </b-modal>


		<b-row>
			<b-col md="6" class="my-1">
				<b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
			</b-col>
		</b-row>
	</div>
</template>

<script>
import OrderCard from "./partials/OrderCard.vue";
import { moneyFormatter } from "../../lib/helpers.js";

export default {
    components: {
	    "order-card": OrderCard
    },

	data() {
		return {
			fields: [
				{ key: 'id', label: i18n.labels.general.order_table.id, sortable: true, 'class': 'text-center sm' },
				{ key: 'created_at', label: i18n.labels.general.order_table.created_at, sortable: true, 'class': 'text-center sm' },
				{ key: 'end_at', label: i18n.labels.general.order_table.end_at, sortable: true, 'class': 'text-center' },
				{ key: 'order_ref', label: i18n.labels.general.order_table.order_ref, sortable: true, 'class' : 'spoiler' },
				{ key: 'preview_link', label: i18n.labels.general.order_table.preview, 'class': 'text-center' },
				{ key: 'format', label: i18n.labels.general.order_table.format, 'class': 'text-center sm' },
				{ key: 'quantity', label: i18n.labels.general.order_table.quantity, 'class': 'text-center sm' },
				{ key: 'production_status', label: i18n.labels.general.order_table.ps, sortable: true, 'class': 'text-center' },
				{ key: 'finance_status', label: i18n.labels.general.order_table.fs, sortable: true, 'class': 'text-center sm' },
				{ key: 'delivery', label: i18n.labels.general.order_table.delivery_type, 'class' : 'spoiler' },
				{ key: 'cost', label: i18n.labels.general.order_table.cost, 'class': 'text-center sm' },
				{ key: 'actions', label: i18n.labels.general.order_table.actions,'class': 'text-center' },
			],
			currentPage: 1,
			perPage: 10,
			totalRows: 1,
			filterVal: '',
            filterIncludedFields: ['order_ref'],
			sortBy: 'id',
			sortDesc: false,
			sortDirection: 'asc',
			production_status: i18n.options.production_status,
			finance_status: i18n.options.finance_status,
            deliveryOptions: i18n.options.delivery_options,
            deliveryPayerOptions: i18n.options.delivery_payer_options,
            ready_to_payment: [],
            order: {
			    file: Object
            },
            isBusy: false,
		}
	},

	computed: {
        filter() {
            return this.filterVal.length > 1 ? this.filterVal : '';
        }
	},

	methods: {
        moneyFormatter,

		onFiltered (filteredItems) {
			// Trigger pagination to update the number of buttons/pages due to filtering
			this.totalRows = filteredItems.length;
			this.currentPage = 1;
		},

        rowClass(item, type) {
            if (!item || type !== 'row') return
            if (item.production_status === 5) return 'table-info'
        },

        onDelete(id) {
            axios({
                method: "delete",
                url: route('customer.order.destroy', {order: id}),
            })
            .then(response => {
                window.location = response.data.redirect;
            })
            .catch(error => {
                console.log(error);
            });
        },

        previewModalEmitter(item) {
		    this.order = item;
            this.$root.$emit('bv::show::modal', 'preview-modal')
        },

        orderCardModalEmitter(item) {
		    this.order = item;
            this.$root.$emit('bv::show::modal', 'order-card-modal')
        },

        deleteOrderEmitter(item) {
		    this.order = item;
		    this.$root.$emit('bv::show::modal', 'delete-order-modal')
        },

        orderDataProvider(ctx) {
            let order = this.sortDesc ? 'ASC' : 'DESC';

		    const promise = axios.get(
                '/api/orders?page=' + ctx.currentPage
                + '&size=' + this.perPage
                + '&orderBy=' + this.sortBy
                + '&order=' + order
                + '&filter=' + this.filter
            );
            this.isBusy = true;

            return promise.then(response => {
                const items = response.data.data;
                this.isBusy = false;
                this.totalRows = response.data.total;

                return items || [];
            }).catch(error => {
                this.isBusy = false;
                return []
            });
        }
	}
}

</script>
