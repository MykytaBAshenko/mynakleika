<template>
  	<div>
        <div class="table-responsive">
            <b-table
                hover
                :sort-by.sync = "sortBy"
                :sort-desc.sync = "sortDesc"
                :sort-direction = "sortDirection"
                :items = "ordersDataProvider"
                :fields = "fields"
                :current-page = "currentPage"
                :per-page = "perPage"
                :busy.sync = "isBusy"
                class = "order-table"
                :tbody-tr-class = "rowClass"
                @filtered = "onFiltered"
                ref = "dtpTable"
            >
                <template v-slot:cell(order_ref)="row">
                    {{ row.item.order_ref }}
                </template>

                <template v-slot:cell(material_name)="row">
                    {{ row.item.material_name }}
                </template>

                <template v-slot:cell(delivery)="row">
					<span data-toggle="tooltip"
                          data-placement="bottom"
                          :title="deliveryOptions[row.item.delivery_type]">
						{{ deliveryOptions[row.item.delivery_type] }}
					</span>
                </template>

                <template v-slot:cell(production_status)="row">
                    <b-form-select
                        size="sm"
                        v-model="row.item.production_status"
                        :options=getStatusOptions(row.item)
                        v-on:change="onToggleStatus(row.item, row.index)"
                    ></b-form-select>
                </template>

                <template v-slot:cell(preview_link)="row">
                    <b-button
                        :variant="buttonVariant(row.item)"
                        size="sm"
                        @click="orderCardModalEmitter(row.item)"
                    >
                        <i class="icon icon-pdf"></i>
                    </b-button>
                </template>
            </b-table>
        </div>

        <b-row>
            <b-col md="6" class="my-1">
                <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
            </b-col>
        </b-row>

        <!-- Order Card Modal -->
        <b-modal id="order-card-modal" size="lg" :title="order.order_ref" hide-footer>
            <order-tech-card
                :order="order"
            />
        </b-modal>

        <base-popup
            mid="popup"
            size="sm"
            okVariant="success"
            headerBgVariant="success"
            okTitle="Подтвердить"
            cancelTitle="Отмена"
            title="Предупреждение"
            icon="error"
            :baseMessage="popup.baseMessage"
            :subMessage="popup.subMessage"
            :hideFooter="popup.hideFooter"
            :item="popup.item"
            @submit="onOk(popup.item)"
            @cancel="onCancel(selectedItemIdx)"
        ></base-popup>
  	</div>
</template>

<script>

window.moment = require('moment-business-days');
moment.locale('uk');

import OrderTechCard from "./partials/OrderTechCard"
import BasePopup from "../../general/modals/BasePopup"

export default {
  	name: "DtpTableComponent",

	components: {
		'order-tech-card': OrderTechCard,
        'base-popup': BasePopup,
	},

  	data() {
		return {
            fields: [
                { key: "id", label: "##", sortable: true },
                { key: "order_ref", label: "Название", sortable: true },
                { key: "material_name", label: "Материал", sortable: true },
                { key: "format", label: "Размер" },
                { key: "lamination", label: "Ламинация (1 - матовая, 2 - глянцевая)" },
                { key: "quantity", label: "Тираж" },
                { key: "preview_link", label: "" },
                { key: 'delivery', label: i18n.labels.general.order_table.delivery_type, 'class' : 'spoiler' },
                { key: "production_status", label: "Статус", sortable: true },
                { key: "end_at", label: "Дата готовности", sortable: true, 'class': 'text-center' },
            ],

            optionsWithDelivery: [
                { value: 2, text: 'В работе' },
                { value: 3, text: 'Отправлен' },
            ],

            optionsWithoutDelivery: [
                { value: 2, text: 'В работе' },
                { value: 4, text: 'Готов' }
            ],

            popup: {
                hideFooter: false,
                baseMessage: "",
                subMessage: "",
                item: null,
            },
            selectedItemIdx: null,
            productionStatus: i18n.options.production_status,
            deliveryOptions: i18n.options.delivery_options,
            dataProviderCopy: null,
            isBusy: false,
            currentPage: 1,
            perPage: 10,
            totalRows: 1,
            sortBy: 'end_at',
            sortDesc: true,
            sortDirection: 'asc',
            order: {
                file: Object
            },
        };
	},

	methods: {
        getStatusOptions(item) {
            return item.delivery_type === 1 ? this.optionsWithoutDelivery : this.optionsWithDelivery;
        },

        onToggleStatus(item, idx) {
            this.popup.item = item;
            this.selectedItemIdx = idx;
            this.popup.baseMessage = "Изменить статус заказа №" + item.id
                + " на " + this.productionStatus[item.production_status] + "?";
		    this.$bvModal.show('popup');
        },

        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },

        onOk(item) {
            axios({
                method: "patch",
                url: route('api.order.update', {order: item.id} ),
                data: {
                    production_status: item.production_status,
                }
            })
            .then(response => {
                if (response.data.status === "success") {
                    this.$bvToast.toast('Статус заказа №'+
                        item.id + ' изменен на ' +
                        this.productionStatus[item.production_status],
                        {
                            title: 'Статус заказа',
                            variant: 'success',
                            solid: true
                        })
                }
            })
            .catch(error => {
                console.log(error);
            });
        },

        onCancel(idx) {
            this.$refs.dtpTable.localItems[idx].production_status = this.dataProviderCopy[idx].production_status;
        },

        rowClass(item, type) {
            if (!item || type !== 'row') return
            if (item.production_status === 3) return 'table-success'
        },

        buttonVariant(item) {
            return item.production_status === 3 ? 'success' : 'outline-primary';
        },

        orderCardModalEmitter(item) {
            this.order = item;
            this.$root.$emit('bv::show::modal', 'order-card-modal')
        },

        ordersDataProvider(ctx) {
            let order = this.sortDesc ? 'ASC' : 'DESC';

            const promise = axios.get(
                '/api/orders_for_dtp', {
                    params: {
                        page: ctx.currentPage,
                        size: ctx.perPage,
                        order: order,
                        orderBy: this.sortBy,
                    }
                }
            );
            this.isBusy = true;

            return promise.then(response => {
                const items = response.data.data;
                this.isBusy = false;
                this.totalRows = response.data.total;
                this.dataProviderCopy = JSON.parse(JSON.stringify(items));

                return items || [];
            }).catch(error => {
                this.isBusy = false;
                return []
            });
        }
  	}
};
</script>
