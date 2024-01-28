<template>
    <div class="row">
        <div class="col-sm-6">
            <table class="table">
                <tbody>
                    <tr>
                        <td><b>{{ __('labels.general.order_table.quantity') }}</b></td>
                        <td>{{ order.quantity }}</td>
                    </tr>
                    <tr>
                        <td><b>{{ __('labels.general.order_table.material') }}</b></td>
                        <td>{{ order.material.material_name }}</td>
                    </tr>
                    <tr>
                        <td><b>{{ __('labels.general.order_table.comments') }}</b></td>
                        <td>{{ order.order_comments }}</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>{{ __('labels.general.order_table.delivery_type') }}</b></td>
                        <td>{{ deliveryOptions[order.delivery.type] }}</td>
                    </tr>
                    <tr v-if="order.delivery.address">
                        <td><b>{{ __('labels.general.order_table.address') }}</b></td>
                        <td><span v-if="order.delivery.city">{{ order.delivery.city }}, </span>{{ order.delivery.address }}</td>
                    </tr>
                    <tr v-if="order.delivery.np_warehouse">
                        <td><b>{{ __('labels.general.order_table.np_sklad') }}</b></td>
                        <td>{{ order.delivery.np_warehouse }}</td>
                    </tr>
                    <tr v-if="order.delivery.np_organization">
                        <td><b>{{ __('labels.general.order_table.np_organization') }}</b></td>
                        <td>{{ order.delivery.np_organization }}</td>
                    </tr>
                    <tr v-if="order.delivery.contact_person">
                        <td><b>{{ __('labels.general.order_table.contacts') }}</b></td>
                        <td>{{ order.delivery.contact_person }}, <nobr>{{ order.delivery.contact_phone }}</nobr></td>
                    </tr>
                    <tr v-if="order.delivery.np_payer">
                        <td><b>{{ __('labels.general.order_table.np_payer') }}</b></td>
                        <td>{{ deliveryPayerOptions[order.delivery.np_payer] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">
            <b>Макет</b>
            <b-img :src="'/storage/' + order.file.name + '.tn.jpg'" fluid class="d-block mx-auto" />
            <b class="pt-3 d-inline-block">Раскладка</b>
            <p class="mt-1 mb-0">Количество изделий на листе: {{ order.quantity_per_sheet }}</p>
            <p class="mb-2">Количество листов: {{ Math.ceil(order.quantity / order.quantity_per_sheet) }}</p>
            <b-img :src="canvasPreview" fluid class="d-block mx-auto border border-secondary" />
        </div>
    </div>
</template>

<script>
    export default {
        name: "OrderCard",
        props: {
            order: Object,
            deliveryOptions: Object,
            deliveryPayerOptions: Object,
        },

        computed: {
            canvasPreview: function () {
                return '/storage/' + this.order.file.name + '-canvas.png';
            }
        }
    }
</script>
