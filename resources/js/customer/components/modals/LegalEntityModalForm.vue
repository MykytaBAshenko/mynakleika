<template>
    <b-modal
        id="legal-entity-modal"
        size="xl"
        title="Создание нового плательщика"
        ok-title="Сохранить"
        ok-variant="success"
        cancel-title="Отмена"
        hide-header-close
        ref="modal"
        @ok="onOk"
        @hide="onHide"
        @shown="initForm"
    >
        <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
            <b-form @submit.stop.prevent="handleSubmit(onSubmit)">
                <div class="row">
                    <div class="col-md-6">
                        <BSelectWithValidation
                            v-model="form.type"
                            rules="required"
                            vid="type"
                            :options="legalEntityTypeOptions"
                            :label="__('forms.legal_entity.label.type')"
                            :name="__('forms.legal_entity.label.type')"
                            :placeholder="__('forms.legal_entity.placeholder.type')"
                            :description="__('forms.legal_entity.description.type')"
                            optionsLabel="text"
                        />

                        <template v-if="form.type">
                            <BInputWithValidation
                                v-model="form.alias"
                                rules="required"
                                vid="alias"
                                mode="lazy"
                                :label="__('forms.legal_entity.label.alias')"
                                :name="__('forms.legal_entity.label.alias')"
                                :description="getDescription('alias')"
                            />

                            <BInputWithValidation
                                v-model="form.name"
                                rules="required"
                                vid="name"
                                mode="lazy"
                                :label="__('forms.legal_entity.label.name')"
                                :name="__('forms.legal_entity.label.name')"
                                :description="getDescription('name')"
                            />

                            <BInputWithValidation
                                v-if="form.type.value === 1"
                                v-model="form.edrpou"
                                rules="required|length:8|numeric"
                                vid="edrpou"
                                mode="lazy"
                                v-mask="['########']"
                                :label="__('forms.legal_entity.label.edrpou')"
                                :name="__('forms.legal_entity.label.edrpou')"
                            />

                            <BInputWithValidation
                                v-model="form.director_fio"
                                rules="required"
                                vid="director_fio"
                                mode="lazy"
                                :label="__('forms.legal_entity.label.director_fio')"
                                :name="__('forms.legal_entity.label.director_fio')"
                            />
                        </template>
                    </div>

                    <div class="col-md-6" v-if="form.type">
                        <BInputWithValidation
                            v-if="form.type.value === 1"
                            v-model="form.ipn"
                            rules="required|length:12|numeric"
                            vid="ipn"
                            v-mask="['############']"
                            :label="__('forms.legal_entity.label.ipn')"
                            :name="__('forms.legal_entity.label.ipn')"
                            :description="__('forms.legal_entity.description.ipn')"
                        />
                        <BInputWithValidation
                            v-if="form.type.value === 2"
                            v-model="form.ipn"
                            rules="required|length:10|numeric"
                            vid="ipn"
                            v-mask="['##########']"
                            :label="__('forms.legal_entity.label.ipn')"
                            :name="__('forms.legal_entity.label.ipn')"
                            :description="__('forms.legal_entity.description.ipn')"
                        />
                        <BSelectWithValidation
                            v-model="form.is_nds_payer"
                            rules="required"
                            vid="nds_payer"
                            :options="ndsPayerOptions"
                            :label="__('forms.legal_entity.label.is_nds_payer')"
                            :name="__('forms.legal_entity.label.is_nds_payer')"
                            :description="__('forms.legal_entity.description.is_nds_payer')"
                            :placeholder="__('forms.legal_entity.placeholder.is_nds_payer')"
                            optionsLabel="text"
                        />
                        <template v-if="form.is_nds_payer && form.is_nds_payer.value === 1">
                            <BInputWithValidation
                                v-model="form.nds_payer_num"
                                rules="required|length:9|numeric"
                                vid="nds_payer_num"
                                v-mask="['#########']"
                                :label="__('forms.legal_entity.label.nds_payer_num')"
                                :name="__('forms.legal_entity.label.nds_payer_num')"
                                :disabled = "!Boolean(form.is_nds_payer.value)"
                            />
                        </template>
                        <BSelectWithValidation
                            v-model="form.doc_flow_type"
                            rules="required"
                            vid="has_e_docflow"
                            :options="docFlowOptions"
                            :label="__('forms.legal_entity.label.has_e_docflow')"
                            :name="__('forms.legal_entity.label.has_e_docflow')"
                            :description="__('forms.legal_entity.description.has_e_docflow')"
                            :placeholder="__('forms.legal_entity.placeholder.has_e_docflow')"
                            optionsLabel="text"
                        />
                        <template v-if="form.doc_flow_type && form.doc_flow_type.value === 2">
                            <BInputWithValidation
                                v-model="form.legal_address"
                                rules="required"
                                vid="legal_address"
                                :label="__('forms.legal_entity.label.legal_address')"
                                :name="__('forms.legal_entity.label.legal_address')"
                            />
                            <BInputWithValidation
                                v-model="form.actual_address"
                                rules="required"
                                vid="actual_address"
                                :label="__('forms.legal_entity.label.actual_address')"
                                :name="__('forms.legal_entity.label.actual_address')"
                            />
                            <BInputWithValidation
                                v-model="form.tel"
                                rules="required"
                                vid="tel"
                                type="tel"
                                v-mask="['+380 (##) ###-##-##', '+380 (##) ###-###']"
                                :label="__('forms.legal_entity.label.tel')"
                                :name="__('forms.legal_entity.label.tel')"
                            />
                            <BInputWithValidation
                                v-model="form.accountant_email"
                                rules="required|email"
                                vid="accountant_email"
                                :label="__('forms.legal_entity.label.acc_email')"
                                :name="__('forms.legal_entity.label.acc_email')"
                            />
                        </template>
                    </div>
                </div>
            </b-form>
        </ValidationObserver>
    </b-modal>
</template>

<script>
import BInputWithValidation from "../inputs/BInputWithValidation";
import BSelectWithValidation from "../inputs/BSelectWithValidation";
import { ValidationObserver} from "vee-validate";
import "../validationRules";
import { VueTheMask } from 'vue-the-mask';

export default {
    name: "LegalEntityModal",

    props: ['legalEntity', 'action'],

    components: {
        ValidationObserver,
        BSelectWithValidation,
        BInputWithValidation
    },

    directives: {
        'v-mask': VueTheMask,
    },

    data() {
        return {
            form: {
                type: null,
                name: '',
                alias: '',
                director_fio: '',
                edrpou: '',
                is_nds_payer: null,
                nds_payer_num: '',
                ipn: '',
                doc_flow_type: null,
                legal_address: '',
                actual_address: '',
                tel: '',
                accountant_email: ''
            },

            legalEntityTypeOptions: [
                { value: 1, text: 'Предприятие' },
                { value: 2, text: 'ФОП'}
            ],

            ndsPayerOptions: [
                { value: 1, text: "Да" },
                { value: 0, text: "Нет" },
            ],

            docFlowOptions: [
                { value: 1, text: "Электронный документооборот" },
                { value: 2, text: "Бумажные документы" },
            ],
        }
    },

    methods: {
        initForm() {
            if (this.legalEntity !== null) {
                this.form = Object.assign({}, this.legalEntity);

                if (this.legalEntity.hasOwnProperty('type')) {
                    this.form.type = parseInt(this.legalEntity.type) === 1
                        ? { value: 1, text: 'Предприятие' }
                        : { value: 2, text: 'ФОП'}
                    ;
                }

                if (this.legalEntity.hasOwnProperty('is_nds_payer')) {
                    this.form.is_nds_payer = parseInt(this.legalEntity.is_nds_payer) === 1
                        ? { value: 1, text: "Да" }
                        : { value: 0, text: "Нет" }
                    ;
                }

                if (this.legalEntity.hasOwnProperty('doc_flow_type')) {
                    this.form.doc_flow_type = parseInt(this.legalEntity.doc_flow_type) === 1
                        ? { value: 1, text: "Электронный документооборот" }
                        : { value: 2, text: "Бумажные документы" }
                    ;
                }
            }

            this.$nextTick(() => {
                this.$refs.observer.reset();
            })
        },

        onSubmit () {
            const method = this.action === "add" ? "post" : "put";
            const url = this.action === "add"
                ? route('customer.legal_entity.store')
                : route('customer.legal_entity.update', { legalEntity: this.legalEntity.id })
            ;
            axios({
                method: method,
                url: url,
                data: {
                    type:               this.form.type.value,
                    name:               this.form.name,
                    alias:              this.form.alias,
                    edrpou:             this.form.edrpou,
                    director_fio:       this.form.director_fio,
                    is_nds_payer:       this.form.is_nds_payer.value,
                    nds_payer_num:      this.form.nds_payer_num,
                    ipn:                this.form.ipn,
                    legal_address:      this.form.legal_address,
                    actual_address:     this.form.actual_address,
                    tel:                this.form.tel,
                    accountant_email:   this.form.accountant_email,
                    doc_flow_type:      this.form.doc_flow_type.value,
                }
            })
                .then(response => {
                    if (response.status) {
                        this.$nextTick(() => {
                            this.$refs.modal.hide('submitted');
                            window.location = response.data.redirect;
                        })
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        },

        onOk (bvModalEvt) {
            bvModalEvt.preventDefault();
            this.$refs.observer.validate().then(success => {
                if (!success) {
                    return;
                }
                this.onSubmit();
            });
        },

        onHide (bvModalEvt) {
            if (bvModalEvt.trigger === "cancel" || bvModalEvt.trigger === "submitted") {
                this.$refs.modal.hide();
                Object.keys(this.form).forEach(property => {
                    this.form[property] = null
                });
            } else {
                bvModalEvt.preventDefault();
            }
        },

        getDescription(field) {
            return this.form.type.value === 1
                ? _.get(window.i18n.forms.legal_entity.description, field)
                : _.get(window.i18n.forms.entrepreneur.description, field)
            ;
        },
    }
}
</script>

<style scoped>

</style>
