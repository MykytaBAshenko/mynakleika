<template>
    <b-table
        class="order-table"
        stacked="sm"
        hover
        foot-clone
        show-empty
        :items="ordersDataProvider"
        :current-page = "currentPage"
        :per-page = "perPage"
        :busy.sync = "isBusy"
        :fields="fields"
    >
        <template #empty="scope">
            <b-alert show variant="info" class="d-flex align-items-center" v-if="!isBusy">
                <span class="material-icons-outlined md-24 mr-2">info</span>
                <span class="font-sm">{{ "Нет заказов к оплате" }}</span>
            </b-alert>
        </template>
        <template v-slot:cell(checked)="row">
            <b-form-checkbox
                v-on:change="onSelected(row, $event)"
                value="selected"
                unchecked-value="not_selected"
            />
        </template>

        <template v-slot:cell(preview_link)="row">
            <b-link
                class="order-details-link"
                v-b-modal="row.item.id+'-modalOrderCard'"
            >
                <i class="material-icons-outlined">wallpaper</i>
            </b-link>

            <b-modal :id="row.item.id+'-modalOrderCard'" size="lg" :title="row.item.order_ref" hide-footer>
                <order-card
                    :order="row.item"
                    :deliveryOptions="deliveryOptions"
                    :deliveryPayerOptions="deliveryPayerOptions"
                />
            </b-modal>
        </template>

        <template v-slot:cell(cost)="row">
            {{ moneyFormatter(row.item.cost) }}
        </template>

        <template v-slot:foot(checked)="data">&nbsp;</template>
        <template v-slot:foot(id)="data">&nbsp;</template>
        <template v-slot:foot(created_at)="data">&nbsp;</template>
        <template v-slot:foot(order_ref)="data">&nbsp;</template>
        <template v-slot:foot(preview_link)="data">&nbsp;</template>
        <template v-slot:foot(format)="data">&nbsp;</template>
        <template v-slot:foot(quantity)="data">{{ 'Сумма' }}</template>
        <template v-slot:foot(cost)="data">
            <strong>{{ moneyFormatter(orders.sum) }}</strong>
        </template>
    </b-table>
</template>

<script>
import OrderCard from "./partials/OrderCard.vue";
import { moneyFormatter } from "../../lib/helpers.js";

export default {
    name: "OrderListForPaymentComponent",

    components: {
        OrderCard,
    },

    data() {
        return {
            isBusy: false,
            currentPage: 1,
            perPage: 5,
            totalRows: 1,
            deliveryOptions:i18n.options.delivery_options,
            deliveryPayerOptions: i18n.options.delivery_payer_options,

            orders: {
                list: [],
                sum: 0,
            },

            fields: [
                { key: "checked", label: "#", class: "text-center sm" },
                {
                    key: "id",
                    label: i18n.labels.general.order_table.id,
                    class: "text-center sm" },
                {
                    key: "created_at",
                    label: i18n.labels.general.order_table.created_at,
                    class: "text-center sm"
                },
                { key: "order_ref", label: i18n.labels.general.order_table.order_ref },
                {
                    key: "preview_link",
                    label: i18n.labels.general.order_table.preview,
                    class: "text-center"
                },
                {
                    key: "format",
                    label: i18n.labels.general.order_table.format,
                    class: "text-center sm"
                },
                {
                    key: "quantity",
                    label: i18n.labels.general.order_table.quantity,
                    class: "text-center sm"
                },
                {
                    key: "cost",
                    label: i18n.labels.general.order_table.cost,
                    class: "text-center sm"
                }
            ],
        }
    },

    methods: {
        moneyFormatter,

        onSelected(order, event) {
            if (event === "selected") {
                this.orders.list.push(order.item);
                this.orders.sum += parseInt(order.item.cost);
            } else {
                this.orders.list = this.orders.list.filter(
                    item => item.id !== order.item.id
                );
                this.orders.sum -= parseInt(order.item.cost);
            }
            this.$emit('select', this.orders)
        },

        ordersDataProvider(ctx) {
            const promise = axios.get(
                '/api/orders_for_payment', {
                    params: {
                        page: ctx.currentPage,
                        size: ctx.perPage,
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
    },
}
</script>
