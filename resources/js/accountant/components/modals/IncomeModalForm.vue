<template>
    <b-modal
        id="add_income"
        size="md"
        title="Внести оплату"
        ok-title="Сохранить"
        ok-variant="success"
        cancel-title="Отмена"
        hide-header-close
        ref="modal"
        @ok="onOk"
        @show="resetModal"
        @hide="onHide"
    >
        <ValidationObserver ref="income">
            <form @submit.prevent="onSubmit">
                <BSelectWithValidation
                    v-model="form.legalEntity"
                    rules="required"
                    vid="legal-entity"
                    :options="legalEntities"
                    :label="__('forms.income.label.legal-entity')"
                    :name="__('forms.income.label.legal-entity')"
                    :placeholder="__('forms.income.placeholder.legal-entity')"
                    optionsLabel="text"
                    @input="getUnpaidInvoices(form.legalEntity.value)"
                />

                <div class="row">
                    <BSelectWithValidation
                        v-model="form.invoice"
                        rules="required"
                        vid="invoice"
                        :options="unpaidInvoices"
                        :label="__('forms.income.label.invoice')"
                        :name="__('forms.income.label.invoice')"
                        :placeholder="__('forms.income.placeholder.invoice')"
                        optionsLabel="text"
                        class="col"
                    />

                    <b-form-group
                        class="col"
                        label="Дата оплаты">
                        <v-date-picker
                            v-model="form.paymentDate"
                            locale="uk"
                            :input-props='{ class: "form-control border border-light" }'
                        />
                    </b-form-group>
                </div>

                <div class="row">
                    <b-form-group
                        class="col"
                        label="Сумма счета">
                        <b-input type="text" :value="getInvoiceValue" plaintext />
                    </b-form-group>

                    <ValidationProvider
                        class="col"
                        mode="eager"
                        rules="required"
                        v-slot="validationContext"
                        name="form.value"
                    >
                        <b-form-group
                            label="Сумма"
                        >
                            <vue-autonumeric
                                v-model="form.value"
                                :options="{
                                    minimumValue: '0.01',
                                    maximumValue: '1000000',
                                }"
                                :class="getValidationStateClass(validationContext) + ' form-control'"
                            />
                        </b-form-group>
                    </ValidationProvider>
                </div>

                <b-form-group
                    label="Назначение платежа">
                    <b-form-input
                        v-model="form.description"
                    ></b-form-input>
                </b-form-group>
            </form>
        </ValidationObserver>
    </b-modal>
</template>

<script>
    import { ValidationObserver, ValidationProvider } from "vee-validate"
    import { Multiselect } from "vue-multiselect"
    import BInputWithValidation from "../inputs/BInputWithValidation"
    import BSelectWithValidation from "../inputs/BSelectWithValidation"
    import "../../../customer/components/validationRules"
    import VueAutonumeric from 'vue-autonumeric'
    import { moneyFormatter } from "../../../lib/helpers.js";

    export default {
        name: "IncomeModalForm",
        components: {
            BInputWithValidation,
            BSelectWithValidation,
            Multiselect,
            VueAutonumeric,
            ValidationObserver,
            ValidationProvider,
        },

        data() {
            return {
                form: {
                    legalEntity: Object,
                    invoice: Object,
                    value: null,
                    number: null,
                    description: '',
                    paymentDate: new Date(),
                },
                legalEntities: [],
                invalidLegalEntityFeedback: null,
                invalidInvoiceFeedback: null,
                unpaidInvoices: [],
                invalidInvoicesFeedback: "",
            }
        },

        mounted () {
            this.getLegalEntities()
        },

        computed: {
            getInvoiceValue() {
                return this.form.invoice !== null
                    ? moneyFormatter(this.form.invoice.sum)
                    : ''
                ;
            }
        },

        methods: {
            moneyFormatter,

            getValidationStateClass({ validated, valid = false }) {
                return validated ? (valid ? 'is-valid' : 'is-invalid') : null
            },

            onHide (bvModalEvt) {
                bvModalEvt.trigger === 'submitted' || bvModalEvt.trigger === 'cancel'
                    ? this.$refs.modal.hide()
                    : bvModalEvt.preventDefault()
                ;
            },

            onOk (bvModalEvt) {
                bvModalEvt.preventDefault();
                this.$refs.income.validate().then(success => {
                    if (!success) {
                        return;
                    }
                    this.onSubmit();
                });
            },

            resetModal () {
                Object.keys(this.form).forEach(property => {
                    this.form[property] = null
                    this.form.paymentDate = new Date()
                });
                this.unpaidInvoices = [];
                this.$refs.modal.busy = false;
            },

            onSubmit () {
                this.addIncome();
            },

            getUnpaidInvoices (legalEntityId) {
                this.form.number = null;
                this.form.value = null;
                this.form.invoice = null;

                axios({
                    method: "get",
                    url: route('accountant.invoices.unpaid', {legal_entity: legalEntityId}),
                })
                .then(response => {
                    this.unpaidInvoices = response.data.map( function (item) {
                        return { value: item.id, text: item.number, sum: item.sum }
                    })
                })
                .catch(error => {
                    this.invalidInvoicesFeedback = "Невозможно получить данные о счетах"
                })
            },

            getLegalEntities () {
                this.form.invoice = null
                this.form.number = null
                this.form.value = null
                axios({
                    method: "get",
                    url: route('accountant.legal_entities.all'),
                })
                .then(response => {
                    this.legalEntities = response.data.map( function (item) {
                        return { value: item.id, text: item.alias }
                    })
                })
                .catch(error => {
                    this.invalidLegalEntityFeedback = "Невозможно получить данные о контрагентах"
                })

            },

            addIncome () {
                this.$refs.modal.busy = true;

                axios({
                    method: 'post',
                    url: route('accountant.income.store'),
                    data: {
                        legal_entity_id: this.form.legalEntity.value,
                        invoice_id: this.form.invoice.value,
                        number: this.form.number,
                        value: this.form.value,
                        description: this.form.description,
                        payment_date: this.form.paymentDate,
                    }
                })
                .then(response => {
                    if (response) {
                        this.$emit('submit');
                        this.$nextTick(() => {
                            this.$refs.modal.hide('submitted');
                        })
                    }
                })
                .catch(error => {
                    console.log(error.response.data.errors)
                })
            }
        }
    }
</script>

<style scoped>

</style>
