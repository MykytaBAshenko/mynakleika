<template>
    <div>
        <OrderListForPaymentComponent
            @select="onOrdersSelected"
        ></OrderListForPaymentComponent>

        <div class="btn-toolbar">
            <b-link
                class="btn btn-success mr-3 px-3 pt-3 pb-2"
                :disabled="!buttonsState"
                :active="paymentMethod === 'invoice'"
                @click="selectPaymentMethod('invoice')"
            >
                <i class="fas fa-file-alt font-5xl"></i>
                <div class="pt-2">{{ "Выставить счет" }}</div>
            </b-link>
            <b-link
                class="btn btn-primary px-3 pt-3 pb-2"
                :disabled="!buttonsState"
                :active="paymentMethod === 'card'"
                @click="redirectToPaymentGate"
            >
                <i class="fas fa-credit-card font-5xl"></i>
                <div class="pt-2">{{ "Оплата картой" }}</div>
            </b-link>
        </div>

        <div v-if="paymentMethod === 'invoice'" class="mt-3">
            <div class="row pt-2">
                <validation-provider
                    :name="__('forms.invoice.label.payer')"
                    v-slot="validationContext"
                    :rules="{ required: true }"
                    ref="invoice.legalEntity"
                    slim
                >
                    <b-form-group
                        class="col-6"
                        label-cols-sm="4"
                        :state="validationContext.errors[0] ? false : (validationContext.valid ? true : null)"
                        :label="__('forms.invoice.label.payer')"
                        :invalid-feedback="validationContext.errors[0]"
                    >
                        <multiselect
                            id="legal-entities-list"
                            v-model="invoice.legalEntity"
                            label="text"
                            :state="validationContext.errors[0] ? false : (validationContext.valid ? true : null)"
                            :options="legalEntitiesOptions"
                            :placeholder="__('forms.invoice.placeholder.payer')"
                            selectLabel=""
                            selectedLabel=""
                            deselectLabel=""
                        >
                            <template v-if="legalEntitiesOptions.length > 0" slot="afterList">
                                <li>
                                    <span class="multiselect__option">
                                        <b-link
                                            class="align-items-center d-flex text-decoration-none"
                                            @click="addNewLegalEntity"
                                        >
                                            <span class="material-icons mr-1">post_add</span>
                                            <span class="font-sm">{{ "Добавить нового плательщика" }}</span>
                                        </b-link>
                                    </span>
                                </li>
                            </template>

                            <template slot="noOptions">
                                <b-link
                                   class="align-items-center d-flex text-decoration-none"
                                   @click="addNewLegalEntity"
                                >
                                    <span class="material-icons mr-1">post_add</span>
                                    <span class="font-sm">{{ "Добавить нового плательщика" }}</span>
                                </b-link>
                            </template>
                        </multiselect>
                    </b-form-group>

                </validation-provider>
            </div>

            <div class="form-footer-left">
                <invoice-preview-modal
                    :invoice="invoice"
                />
                <b-button
                    variant="primary"
                    v-if="Boolean(invoice.legalEntity)"
                    @click="createInvoice"
                >
                    <span><i class="fas fa-file-alt"></i>&nbsp{{ __('buttons.customer.invoice.create_invoice') }}</span>
                </b-button>
            </div>
        </div>
        <LegalEntityModalForm
            action="add"
            legal-entity=null
        ></LegalEntityModalForm>
    </div>
</template>

<script>
import OrderListForPaymentComponent from "./OrderListForPaymentComponent";
import BSelectWithValidation from "./inputs/BSelectWithValidation";
import LegalEntityModalForm from "./modals/LegalEntityModalForm";
import InvoicePreviewModal from "./modals/InvoicePreviewModal.vue";
import { ValidationProvider } from "vee-validate";
import { Multiselect } from 'vue-multiselect';

export default {
    name: "PaymentComponent",

    components: {
        ValidationProvider,
        OrderListForPaymentComponent,
        BSelectWithValidation,
        LegalEntityModalForm,
        InvoicePreviewModal,
        Multiselect,
    },

    props: {
        'legalEntities': {
            type: Array,
            default: [],
        },
        'systemLegalEntities': null,
    },

    data() {
        return {
            paymentMethod: null,
            buttonsState: false,
            invoice: {
                legalEntity: null,
                selfLegalEntity: null,
                orders: null,
                sum: 0,
            },
            legalEntitiesOptions: [],
        }
    },

    mounted () {
        this.initFormOptions();
    },

    methods: {
        onOrdersSelected(orders) {
            this.buttonsState = orders.list.length > 0;
            if (!this.buttonsState) {
                this.paymentMethod = null;
                this.invoice.legalEntity = null;
            }
            this.invoice.orders = orders.list;
            this.invoice.sum = orders.sum;
        },

        selectPaymentMethod(method) {
            this.paymentMethod = method;
        },

        initFormOptions() {
            if (this.legalEntities) {
                this.legalEntities.forEach(obj => {
                    this.legalEntitiesOptions.push({
                        value: obj.id,
                        text: obj.alias,
                        type: obj.type,
                        name: obj.name,
                        tel: obj.tel,
                        isNdsPayer: obj.is_nds_payer,
                    })
                });
            }
        },

        addNewLegalEntity() {
            this.$bvModal.show('legal-entity-modal');
        },

        createInvoice() {
            this.invoice.selfLegalEntity = this.invoice.legalEntity.isNdsPayer === 1
                ? this.systemLegalEntities.tov
                : this.systemLegalEntities.fop
            ;
            this.$bvModal.show('invoice_preview');
        },

        redirectToPaymentGate() {
            axios({
                method: "post",
                url: route("customer.finance.payment.card"),
                data: {
                    orders: this.invoice.orders,
                }
            })
            .catch(error => {
                console.log(error);
            })
            .then(response => {
                window.location = route("customer.finance.payment.gate", { orderId: response.data.orderId })
            });
        }
    },
}
</script>

<style scoped>
    a {
        position: relative;
    }

    a.active:after {
        font-family: 'Material Icons';
        font-size: x-large;
        content: 'check_circle_outline';
        position: absolute;
        top: 0;
        right: 5px;
    }
</style>
