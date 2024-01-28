<template v-if="invoice">
    <b-modal
        id="invoice_preview"
        size="lg"
        modal-header-close
        hide-footer
        ref="modal"
    >
        <template v-slot:modal-header="{ close }">
            <div class="w-100 d-flex justify-content-between align-items-center">
                <b-button
                    variant="success"
                    class="float-left"
                    @click="createInvoice"
                >
                    Сохранить для оплаты
                </b-button>
                <button type="button" aria-label="Close" class="close" @click="close()">×</button>
            </div>
        </template>
        <div>
            <template v-if="isNdsPayer">
                <InvoiceTemplateForTOV
                    :invoice="invoice"
                    :today="today"
                    :moneyToStrNum="moneyToStrNum"
                    :amount="amount"
                    :pdv="pdv"
                    :amountWpdv="amountWpdv"
                ></InvoiceTemplateForTOV>
            </template>
            <template v-else>
                <InvoiceTemplateForFOP
                    :invoice="invoice"
                    :today="today"
                    :moneyToStrNum="moneyToStrNum"
                    :amount="amount"
                ></InvoiceTemplateForFOP>
            </template>
        </div>
    </b-modal>
</template>

<script>
import * as MTS from "../../../lib/moneytostr";
import InvoiceTemplateForFOP from "./InvoiceTemplateForFOP";
import InvoiceTemplateForTOV from "./InvoiceTemplateForTOV";

moment.locale('uk');
let today = moment().format('LL');

let moneyToStrNum = new MTS.MoneyToStr(
    MTS.Currency.UAH,
    MTS.Language.UKR,
    MTS.Pennies.NUMBER
);

export default {
    props: {
        invoice: Object
    },

    components: {
        InvoiceTemplateForTOV,
        InvoiceTemplateForFOP
    },

    data() {
        return {
            today: today,
            moneyToStrNum: moneyToStrNum,
        }
    },

    computed: {
        isNdsPayer: function () {
            return this.invoice && this.invoice.legalEntity
                ? !!this.invoice.legalEntity.isNdsPayer
                : false
            ;
        },

        amount: function () {
            return this.isNdsPayer
                ? this.round(this.invoice.sum / 1.2 / 100, 2).toFixed(2)
                : this.round(this.invoice.sum / 100, 2).toFixed(2)
            ;
        },

        amountWpdv: function () {
            return this.round(this.invoice.sum / 100, 2).toFixed(2);
        },

        pdv: function () {
            return this.round(this.amountWpdv - this.amount, 2).toFixed(2);
        },
    },

    methods: {
        round(value, decimals) {
            return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
        },

        createInvoice() {
            axios({
                method: "post",
                url: route("customer.invoice.store"),
                data: {
                    legal_entity_id: this.invoice.legalEntity.value,
                    orders: this.invoice.orders,
                }
            })
                .catch(error => {
                    console.log(error);
                })
                .then(response => {
                    this.$nextTick(() => {
                        this.$refs.modal.hide()
                    })
                    window.location = response.data.redirect
                    window.open('/' + response.data.invoiceFileName, '_blank')
                });
        }
    }
}
</script>
