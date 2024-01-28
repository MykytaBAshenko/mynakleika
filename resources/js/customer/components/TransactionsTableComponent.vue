<template>
    <div>
        <b-row class="justify-content-start pt-2">
            <b-col md="4">
                <b-form-group class="pb-2">
                    <b-input-group class="d-flex justify-content-start">
                        <v-date-picker
                            v-model="date"
                            locale="uk"
                            :input-props="{
                                class: 'form-control border border-light',
                                placeholder: 'Дата от'
                            }"
                        />
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>
                        </div>
                    </b-input-group>
                </b-form-group>
            </b-col>
        </b-row>

        <!-- Main table element -->
        <div class="table-responsive">
            <b-table
                class="order-table"
                stacked = "sm"
                show-empty
                hover
                head-variant = "dark"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :sort-direction="sortDirection"
                :items = "transactionDataProvider"
                :fields = "fields"
                :filter = "filter"
                :current-page = "currentPage"
                :per-page = "perPage"
                @filtered = "onFiltered"
                :busy.sync="isBusy"
            >
                <template v-slot:cell(created_at)="row">
                    {{ toDate(row.item.created_at) }}
                </template>

                <template v-slot:cell(operation_id)="row">
					<template v-if="row.item.operation_id === 1">
                        Списание по счету #{{row.item.iv_number}}
                    </template>
                    <template v-else-if="row.item.operation_id === 2">
                        Оплата по счету #{{row.item.iv_ic_number}}
                    </template>
                </template>

                <template v-slot:cell(legal_entity)="row">
                    {{ row.item.legal_entity }}
                </template>

                <template v-slot:cell(value)="row">
					<template v-if="parseInt(row.item.operation_id) === 1">
                        <span class="text-danger">- {{ moneyFormatter(row.item.value) }}</span>
                    </template>
                    <template v-else>
                        <span class="text-success">+ {{ moneyFormatter(row.item.value) }}</span>
                    </template>
                </template>

            </b-table>
        </div>

        <b-row>
            <b-col md="6" class="my-1">
                <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
            </b-col>
        </b-row>
    </div>
</template>

<script>
import moment from "moment";
import { moneyFormatter } from "../../lib/helpers.js";

moment.locale('uk')

export default {
    data() {
        return {
            fields: [
                { key: 'created_at', label: 'Дата', 'class': 'text-center sm', sortable: true },
                { key: 'operation_id', label: 'Тип операции', sortable: true },
                { key: 'legal_entity', label: 'Плательщик' },
                { key: 'value', label: 'Сумма', 'class': 'text-right' },
            ],

            date: moment().subtract(3, 'month').toDate(),
            sortBy: 'created_at',
			sortDesc: false,
			sortDirection: 'asc',
            currentPage: 1,
            perPage: 10,
            totalRows: null,
            isBusy: false,
        }
    },

    computed: {
        filter() {
            return this.date.toISOString();
        }
	},

    methods: {
        moneyFormatter,

        onFiltered (filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length
            this.currentPage = 1
        },

        toDate(dateTime) {
            return moment(dateTime).format("DD-MM-YYYY")
        },

        transactionDataProvider(ctx) {
            let order = this.sortDesc ? 'ASC' : 'DESC';

            const promise = axios.get(
                '/api/transactions', {
                    params: {
                        page: ctx.currentPage,
                        size: this.perPage,
                        order: order,
                        orderBy: this.sortBy,
                        date: this.date.toISOString()
                    }
                }
            );
            this.isBusy = true;

            return promise.then(response => {
                this.isBusy = false;
                this.totalRows = response.data.total;

                return response.data.data || [];
            }).catch(error => {
                this.isBusy = false;

                return []
            });
        }
    }
}

</script>
