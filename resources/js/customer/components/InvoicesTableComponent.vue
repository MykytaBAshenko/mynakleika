<template>
    <div>
<!--        <b-row class="justify-content-between pt-2">-->
<!--            <b-col cols="7" md="4">-->
<!--                <b-form-group class="pb-2">-->
<!--                    <b-input-group>-->
<!--                        <b-form-input v-model="filter" :placeholder="__('strings.backend.general.search_placeholder')" />-->
<!--                        <b-input-group-append>-->
<!--                            <b-btn :disabled="!filter" @click="filter = ''">{{ __('strings.backend.general.search_clear') }}</b-btn>-->
<!--                        </b-input-group-append>-->
<!--                    </b-input-group>-->
<!--                </b-form-group>-->
<!--            </b-col>-->

<!--			<b-col cols="5" md="4">-->
<!--				<b-form-group class="pb-2">-->
<!--					<div class="btn-toolbar float-right" role="toolbar">-->
<!--						<a :href="route('customer.invoice.create')" class="btn btn-success">-->
<!--							<i class="fas fa-wallet"></i>-->
<!--							&nbsp;{{ __('buttons.customer.invoice.pay_for_orders') }}-->
<!--						</a>-->
<!--					</div>-->
<!--				</b-form-group>-->
<!--			</b-col>-->
<!--        </b-row>-->

        <!-- Main table element -->

        <div class="table-responsive">
            <b-table
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :sort-direction="sortDirection"
                :items = "invoiceDataProvider"
                :fields = "fields"
                :filter = "filter"
                :current-page = "currentPage"
                :per-page = "perPage"
                :busy.sync="isBusy"
                @filtered = "onFiltered"

                class="order-table"
                head-variant = "dark"
                show-empty
                stacked = "sm"
            >
                <template v-slot:cell(status)="row">
					<template v-if="parseInt(row.item.status) === 1">
                        <b-badge variant="danger"> {{ invoice_status[row.item.status] }} </b-badge>
                    </template>

					<template v-else-if="parseInt(row.item.status) === 2">
                        <b-badge variant="warning">{{ invoice_status[row.item.status] }}</b-badge>

						<b-button
                            :id="'popover-' + row.item.id"
                            class="inline-button"
                            variant="success"
                        >%</b-button>

						<b-popover
                            :target="'popover-' + row.item.id"
                            delay=200
							placement="bottom"
                            triggers="hover"
                        >
                            <span class="text-success">Оплачено: </span>{{ moneyFormatter(row.item.paid) }}<br/>
                            <span class="text-danger">Осталось: </span>{{ moneyFormatter(row.item.sum - row.item.paid) }}
                        </b-popover>
                    </template>

					<template v-else>
                        <b-badge variant="success"> {{ invoice_status[row.item.status] }} </b-badge>
                    </template>
                </template>

                <template v-slot:cell(legal_entity_id)="row">
                    {{ row.item.alias }}
                </template>

                <template v-slot:cell(specification)="row">
                    <b-badge variant="secondary">{{ row.item.orders }}</b-badge>
                </template>

				<template v-slot:cell(pdf)="row">
					<a :href="'/storage/invoices/'+row.item.number+'.pdf'" class="btn-sm btn btn-outline-primary" rel="noopener noreferrer" target="_blank">
						<i class="fas fa-file-pdf"></i>
					</a>
                </template>

                <template v-slot:cell(sum)="row">
                    {{ moneyFormatter(row.item.sum) }}
                </template>
            </b-table>
        </div>

        <b-row>
            <b-col class="my-1" md="6">
                <b-pagination v-model="currentPage" :per-page="perPage" :total-rows="totalRows" class="my-0" />
            </b-col>
        </b-row>
    </div>
</template>

<script>
import { moneyFormatter } from "../../lib/helpers.js";

export default {
    data() {
        return {
            fields: [
                { key: 'number', label: 'Номер счета', sortable: true, sortDirection: 'desc', 'class': 'text-center sm' },
                { key: 'create_date', label: 'Дата создания', 'class': 'text-center sm' },
				{ key: 'payment_date', label: 'Дата оплаты', 'class': 'text-center' },
				{ key: 'pdf', label: 'Файл', 'class': 'text-center sm' },
                { key: 'specification', label: 'Описание/Номера заказов', 'class': 'text-center' },
                { key: 'status', label: 'Статус', sortable: true, sortDirection: 'desc', 'class': 'text-center' },
                { key: 'legal_entity_id', label: 'Юр. лицо', 'class': 'text-center sm' },
				{ key: 'sum', label: 'Сумма', 'class': 'text-center sm' }
            ],

            invoice_status: {
                1: 'не оплачен',
                2: 'оплачен частично',
                3: 'оплачен'
            },

            invoice: {
                payed: 0,
                left: 0
            },

            currentPage: 1,
            perPage: 10,
            totalRows: 1,
            filterVal: '',
            sortBy: 'id',
            sortDesc: false,
            sortDirection: 'asc',
            popoverShow: false,
            isBusy: false,
        }
    },

    computed: {
        sortOptions () {
            // Create an options list from our fields
            return this.fields
                .filter(f => f.sortable)
                .map(f => { return { text: f.label, value: f.key } })
        },

        filter() {
            return this.filterVal.length > 1 ? this.filterVal : '';
        }
	},

    methods: {
        moneyFormatter,

        onFiltered (filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length
            this.currentPage = 1
        },

        onClose() {
            this.popoverShow = false
        },

        invoiceDataProvider(ctx) {
            let order = this.sortDesc ? 'ASC' : 'DESC';

            const promise = axios.get(
                '/customer/get_invoices', {
                    params: {
                        page: ctx.currentPage,
                        size: this.perPage,
                        order: order,
                        orderBy: this.sortBy,
                        filters: this.filter
                    }
                }
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
