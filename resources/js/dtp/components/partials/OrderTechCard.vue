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
                        <td>{{ order.material_name }}</td>
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
                        <td>{{ deliveryOptions[order.delivery_type] }}</td>
                    </tr>
                    <tr v-if="order.delivery_address">
                        <td><b>{{ __('labels.general.order_table.address') }}</b></td>
                        <td><span v-if="order.delivery_city">{{ order.delivery_city }}, </span>{{ order.delivery_address }}</td>
                    </tr>
                    <tr v-if="order.delivery_np_warehouse">
                        <td><b>{{ __('labels.general.order_table.np_sklad') }}</b></td>
                        <td>{{ order.delivery_np_warehouse }}</td>
                    </tr>
                    <tr v-if="order.delivery_np_organization">
                        <td><b>{{ __('labels.general.order_table.np_organization') }}</b></td>
                        <td>{{ order.delivery_np_organization }}</td>
                    </tr>
                    <tr v-if="order.delivery_contact_person">
                        <td><b>{{ __('labels.general.order_table.contacts') }}</b></td>
                        <td>{{ order.delivery_contact_person }}, <nobr>{{ order.delivery_contact_phone }}</nobr></td>
                    </tr>
                    <tr v-if="order.delivery_np_payer">
                        <td><b>{{ __('labels.general.order_table.np_payer') }}</b></td>
                        <td>{{ deliveryPayerOptions[order.delivery_np_payer] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">
            <b>Макет</b>
            <b-img :src="'/storage/' + order.file_name + '.tn.jpg'" fluid class="d-block mx-auto" />
            <b class="pt-3 d-inline-block">Раскладка</b>
            <p class="mt-1 mb-0">Количество изделий на листе: {{ order.quantity_per_sheet }}</p>
            <p class="mb-2">Количество листов: {{ Math.ceil(order.quantity / order.quantity_per_sheet) }}</p>
            <b-img :src="canvasPreview" fluid class="d-block mx-auto mt-3 border border-secondary" />
            <div class="d-block pt-2">
                <b-link :href="route('dtp.file.getLayout', {type: 'prn', orderId: order.id})">
                    {{ __('strings.dtp.file_for_print') }}
                </b-link>
            </div>
            <div class="d-block pt-2">
                <b-link :href="route('dtp.file.getLayout', {type: 'cut', orderId: order.id})">
                    {{ __('strings.dtp.file_for_cut') }}
                </b-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "OrderTechCard",
        props: {
            order: Object,
        },

        data() {
            return {
                deliveryOptions: i18n.options.delivery_options,
                deliveryPayerOptions: i18n.options.delivery_payer_options,
            }
        },

        computed: {
            canvasPreview() {
                return '/storage/' + this.order.file_name + '-canvas.png';
            },
        },
    }
</script>
