<template>
    <div>
        <b-alert
			:show="alert.dismissCountDown"
			dismissible
			fade
			:variant="alert.variant"
			@dismissed="alert.dismissCountDown=0"
			@dismiss-count-down="countDownChanged"
		>
			{{ alert.message }}
		</b-alert>

		<b-row class="justify-content-between">
            <b-col md="4" class="my-1">
                <b-form-group class="mb-4">
                    <b-input-group>
                        <b-form-input v-model="filter" :placeholder="__('strings.backend.general.search_placeholder')" />
                        <b-input-group-append>
                            <b-btn :disabled="!filter" @click="filter = ''">{{ __('strings.backend.general.search_clear') }}</b-btn>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col>

            <b-col md="4" class="my-1">
                <b-form-group class="mb-4">
                    <div class="btn-toolbar float-right" role="toolbar">
                        <b-button v-b-modal.add_income variant="success">
                            <i class="fas fa-plus-circle"></i>&nbsp;{{ __('strings.accountant.income.create') }}
                        </b-button>
                    </div>
                </b-form-group>
            </b-col>

            <!-- Modal Component -->
            <income-modal-form @submit="onIncomeAdded"></income-modal-form>

        </b-row>

        <!-- Main table element -->

        <div class="table-responsive">
            <b-table
                class="order-table"
                stacked = "sm"
                hover
                head-variant = "dark"
                sort-by = "payment_date"
                sort-desc
                :items = "items"
                :fields = "fields"
                :filter = "filter"
                :current-page = "currentPage"
                :per-page = "perPage"
                @filtered = "onFiltered"
            >
                <template v-slot:cell(legal_entity_id)="row">
                    {{ row.item.legal_entity.alias }}
                </template>

                <template v-slot:cell(payment_date)="row">
                    {{ toDate(row.item.payment_date) }}
                </template>

                <template v-slot:cell(value)="row">
                    {{ moneyFormatter(row.item.value)  }}
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

import IncomeModalForm from "./modals/IncomeModalForm";
import { moneyFormatter } from "../../lib/helpers.js";
import moment from "moment"

export default {

    name: "IncomesTableComponent",
    components: {
        IncomeModalForm,
    },
    data() {
        return {
            items: [],
            fields: [
                { key: 'payment_date', label: 'Дата оплаты', 'class': 'text-center' },
                { key: 'number', label: 'Номер', 'class' : 'text-center' },
                { key: 'value', label: 'Сумма', 'class': 'text-center' },
                { key: 'description', label: 'Назначение платежа' },
                { key: 'legal_entity_id', label: 'Контрагент' },
                { key: 'invoice.number', label: 'Cчет' }
            ],

            currentPage: 1,
            perPage: 10,
            totalRows: 1,
			filter: null,

            alert: {
                dismissSecs: 5,
                dismissCountDown: 0,
                message: "",
                variant: null,
            },
        }
	},

    mounted () {
        this.getIncomes()
    },

    computed: {
        sortOptions () {
            return this.fields
                .filter(f => f.sortable)
                .map(f => { return { text: f.label, value: f.key } })
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

		countDownChanged (dismissCountDown) {
			this.alert.dismissCountDown = dismissCountDown
		},

		showAlert (message, variant) {
			this.alert.dismissCountDown = this.alert.dismissSecs
            this.alert.message = message
            this.alert.variant = variant
		},

		getIncomes () {
			axios({
				method: 'get',
				url: route('accountant.incomes')
			})
			.then(response => {
                this.items = response.data
			})
            .catch(error => {
                this.invalidFeedback = "Невозможно получить данные о оплатах"
            })
		},

        onIncomeAdded () {
            this.showAlert("Оплата успешно внесена", "success")
            this.getIncomes()
        },
    }
}

</script>
