<template>
    <div>
        <div class="row">
            <div class="col col-sm-6">
                <ValidationProvider
                    mode="eager"
                    v-slot="validationContext"
                    :rules="'required|min_value:' + options.minW"
                    :name="__('forms.order.name.width')"
                >
                    <b-form-group
                        :label="__('forms.order.label.width')"
                        :description="__('forms.order.description.width', { 'minW': options.minW, 'maxW': maxW })"
                        :invalid-feedback="validationContext.errors[0]"
                        :state="getValidationState(validationContext)"
                    >
                        <vue-autonumeric
                            v-model="form.width"
                            v-on:input="onChange"
                            :options="['integerPos', {
                                maximumValue: maxW,
                                minimumValue: minW,
                                modifyValueOnWheel: false,
                            }]"
                            :readOnly="lockLayoutChange"
                            :class="getValidationStateClass(validationContext) + ' form-control'"
                        />
                    </b-form-group>
                </ValidationProvider>
            </div>

            <div class="col col-sm-6">
                <ValidationProvider
                    mode="eager"
                    v-slot="validationContext"
                    :rules="'required|min_value:' + options.minH"
                    :name="__('forms.order.name.height')"
                >
                    <b-form-group
                        :label="__('forms.order.label.height')"
                        :description="__('forms.order.description.height', { 'minH': options.minH, 'maxH': maxH })"
                        :invalid-feedback="validationContext.errors[0]"
                        :state="getValidationState(validationContext)"
                    >
                        <vue-autonumeric
                            v-model="form.height"
                            v-on:input="onChange"
                            :options="['integerPos', {
                                maximumValue: maxH,
                                minimumValue: minH,
                                modifyValueOnWheel: false,
                            }]"
                            :readOnly="lockLayoutChange"
                            :class="getValidationStateClass(validationContext) + ' form-control'"
                        />
                    </b-form-group>
                </ValidationProvider>
            </div>
        </div>
        <div class="row">
            <div class="col col-sm-6">
                <ValidationProvider
                    mode="eager"
                    v-slot="validationContext"
                    rules="required|min_value:1"
                    :name="__('forms.order.name.quantity')"
                >
                    <b-form-group
                        :label="__('forms.order.label.quantity')"
                        :description="__('forms.order.description.quantity')"
                        :invalid-feedback="validationContext.errors[0]"
                        :state="getValidationState(validationContext)"
                    >
                        <vue-autonumeric
                            v-model="form.count"
                            v-on:input="onChangeCount"
                            :options="['integerPos', {
                                maximumValue: 100000,
                                minimumValue: '0',
                                modifyValueOnWheel: false,
                            }]"
                            :class="getValidationStateClass(validationContext) + ' form-control'"
                        />
                    </b-form-group>
                </ValidationProvider>
            </div>

            <div class="col col-sm-6">
                <ValidationProvider
                    mode="eager"
                    v-slot="validationContext"
                    rules="required"
                    :name="__('forms.order.name.material')"
                >
                    <b-form-group
                        :label="__('forms.order.label.material')"
                        :description="__('forms.order.description.material')"
                        :invalid-feedback="validationContext.errors[0]"
                        :state="getValidationState(validationContext)"
                    >
                        <multiselect
                            v-model="form.material"
                            v-on:input="onChange"
                            :options="materialOptions"
                            :placeholder="__('forms.order.placeholder.material')"
                            label="text"
                            selectLabel=""
                            selectedLabel=""
                            deselectLabel=""
                            :class="getValidationStateClass(validationContext)"
                        />
                    </b-form-group>
                </ValidationProvider>
            </div>
        </div>

        <div class="row">

            <div class="col col-sm-6">
                <ValidationProvider
                    mode="eager"
                    v-slot="validationContext"
                    :name="__('forms.order.name.lamination')"
                >
                    <b-form-group 
                        :label="__('forms.order.label.lamination')"
                        :description="__('forms.order.description.lamination')"
                        :invalid-feedback="validationContext.errors[0]"
                        :state="getValidationState(validationContext)"
                    >
                        <multiselect
                            v-model="form.matglanec"
                            v-on:input="onChangeMatGlanec"
                            :options="matglanecOptions"
                            :placeholder="__('forms.order.placeholder.lamination')"
                            label="text"
                            selectLabel=""
                            selectedLabel=""
                            deselectLabel=""
                            :class="getValidationStateClass(validationContext)"
                        />
                    </b-form-group>
                </ValidationProvider>
            </div>
        </div>

        <div class="row pt-4">
            <div class="col">
                <b-form-radio-group
                    stacked
                    name="days"
                    v-model="form.days"
                    @change="onChange"
                >
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">{{ __('labels.customer.order.term') }}</th>
                            <th scope="col">{{ __('labels.customer.order.date') }}</th>
                            <th scope="col">{{ __('labels.customer.order.price') }}</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td><b-form-radio value="2">Печать 2 дня</b-form-radio></td>
                            <td>на {{ getNextDateByDay(2) }}</td>
                            <td>{{ Math.round(getPriceByDate(2) * price) }}</td>
                        </tr>
                        <tr>
                            <td><b-form-radio value="3">Печать 3 дня</b-form-radio></td>
                            <td>на {{ getNextDateByDay(3) }}</td>
                            <td>{{ Math.round(getPriceByDate(3) * price)}}</td>
                        </tr>
                        <tr>
                            <td><b-form-radio value="4">Печать 4 дня</b-form-radio></td>
                            <td>на {{ getNextDateByDay(4) }}</td>
                            <td>{{ Math.round(getPriceByDate(4) * price)}}</td>
                        </tr>
                        <tr>
                            <td><b-form-radio value="5">Печать 5 дня</b-form-radio></td>
                            <td>на {{ getNextDateByDay(5) }}</td>
                            <td>{{ Math.round(getPriceByDate(5) * price)}}</td>
                        </tr>
                        </tbody>
                    </table>
                </b-form-radio-group>
            </div><!-- col -->
        </div>
    </div>
</template>

<script>
import { ValidationProvider } from "vee-validate";
import { cols, rows } from "../../../lib/countHelper";
import { Multiselect } from 'vue-multiselect';
import { PriceHelper } from "../../../lib/priceHelper";
import VueAutonumeric from "vue-autonumeric";
import { getNextDateByDay } from "../../../lib/helpers";

export default {
    name: "CalcFormComponent",

    components: {
        ValidationProvider,
        Multiselect,
        VueAutonumeric,
    },

    props: ['bus', 'options', 'materials'],

    data() {
        return {
            form: {
                width: 0,
                height: 0,
                count: 0,
                lamination: 0,
                days: 2,
                layoutW: 0,
                layoutH: 0,
                fieldW: 0,
                fieldH: 0,
                bleed: 0,
            },
            price: 0,
            maxW: 0,            // max width including layout field
            minW: 0,            // min width
            maxH: 0,            // max height including layout field
            minH: 0,            // min height
            materialOptions: [],
            matglanecOptions: [],
            priceHelper: null,

            

            lockLayoutChange: false,
        }
    },

    created() {
        this.bus.$on('previewLoaded', (data) => {
            this.form.width = data.form.width;
            this.form.height = data.form.height;
            this.lockLayoutChange = true;
            this.price = this.priceHelper.getPrice(
                this.numberOfSheets,
                this.materials[this.form.material.indx],
                this.form.matglanec
            );
        });

        this.bus.$on('layoutRotated', () => {
            [this.form.width, this.form.height] = [this.form.height, this.form.width];
        });

        this.bus.$on('fileChanged', () => {
            this.resetForm();
        });

        this.priceHelper = new PriceHelper(this);
    },

    mounted() {
        this.getOptions();
    },


    computed: {
        isMinAllowableSizeValues() {
            return this.form.width >= parseInt(this.options.minW) && this.form.height >= parseInt(this.options.minH);
        },

        numberOfSheets() {
            this.updateMaterial()
            if (this.isMinAllowableSizeValues) {
                let numberOfItemsPerList = cols(this.form.width, this.form) * rows(this.form.height, this.form)
                return { numberOfSheets: Math.ceil(this.form.count / (numberOfItemsPerList)), numberOfItemsPerList}
            } else {
                return { numberOfSheets: 0, numberOfItemsPerList: 0}

            }
        }
    },

    methods: {
        getNextDateByDay,

        getValidationStateClass({ validated, valid = false }) {
            return validated ? (valid ? 'is-valid' : 'is-invalid') : null;
        },

        getValidationState({ validated, valid = null }) {
            return validated ? (!!valid) : null;
        },

        getOptions() {
            this.materials.forEach((obj, indx) => {
                this.materialOptions.push({ value: obj.id, text: obj.material_name, indx: indx })
            });
            this.form.material = this.materialOptions[0];
            this.updateMaterial()

            this.matglanec = ["Mat", "Glanec"].forEach((value, index) => {
                this.matglanecOptions.push({value: value, text: value, indx: index+1})
            } )
            this.maxW = this.form.layoutW - this.form.fieldW * 2 + this.form.bleed * 2;
            this.maxH = this.form.layoutH - this.form.fieldH * 2 + this.form.bleed * 2;
            this.bus.$emit('materialsChanged', {
                    'form': this.form,
                });
        },
        onChangeCount() {
            if (this.form.material) {
                this.price = this.priceHelper.getPrice(
                    this.numberOfSheets,
                    this.materials[this.form.material.indx],
                    this.form.matglanec
                );
                this.bus.$emit('countChanged', {
                    'form': this.form,
                });
            } else {
                this.price = 0;
            }
        },

        onChangeMatGlanec() {
            this.price = this.priceHelper.getPrice(
                this.numberOfSheets,
                this.materials[this.form.material.indx],
                this.form.matglanec
            );
            this.bus.$emit('laminationChanged', {
                'form': this.form,
            });
        },
        updateMaterial() {
            if (this.form.material) {
                let currentMaterial = this.materials.filter((material) => {
                    if (material.id === this.form.material.value) {
                        return true;
                    }
                })[0];
                this.form.layoutW = parseFloat(currentMaterial.layoutW);
                this.form.layoutH = parseFloat(currentMaterial.layoutH);
                this.form.fieldW = parseFloat(currentMaterial.fieldW);
                this.form.fieldH = parseFloat(currentMaterial.fieldH);
                this.form.bleed = parseFloat(currentMaterial.bleed);
            }
        },
        onChange() {
            if (this.isMinAllowableSizeValues) {
                this.$emit('layoutChanged', {
                    'form': this.form,
                    'isMinAllowableSizeValues': this.isMinAllowableSizeValues
                });
            }
            if (this.form.material) {

                this.updateMaterial()
                this.form.days = Number(this.form.days);

                this.maxW = this.form.layoutW - this.form.fieldW * 2 + this.form.bleed * 2;
                this.maxH = this.form.layoutH - this.form.fieldH * 2 + this.form.bleed * 2;
                this.bus.$emit('materialsChanged', {
                    'form': this.form,
                });
                this.price = this.priceHelper.getPrice(
                    this.numberOfSheets,
                    this.materials[this.form.material.indx],
                    this.form.matglanec
                );
            } else {
                this.price = 0;
            }
        },

        getPriceByDate(days) {
            return this.priceHelper.moneyFormatter(days)
        },

        resetForm() {
            this.form = {
                width: 0,
                height: 0,
                material: this.form.material,
                chromaticity: 1,
                days: 2,
                count: this.form.count
            };
        }
    },
}
</script>
