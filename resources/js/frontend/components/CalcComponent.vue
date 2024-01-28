<!-- <template>
    <div class="front-calc">
        <div class="row">
            <b-form-group
                id="material"
                class="col-12 col-sm-3"
                label="Материал"
                label-for="radio-material"
            >
                <b-form-radio-group
                    id="radio-material"
                    v-model="form.material"
                    v-on:input="onChange"
                    :options="materialOptions"
                    name="radios-stacked"
                    stacked
                ></b-form-radio-group>
            </b-form-group>

            <b-form-group
                id="width"
                class="col-12 col-sm-3"
                label="ширина (мм)"
                label-for="input-width"
            >
                <vue-autonumeric
                    id="input-width"
                    class="form-control"
                    v-model="form.width"
                    v-on:input="onChange"
                    :options="
                        ['integerPos', {
                            maximumValue: maxW,
                            minimumValue: minW,
                            modifyValueOnWheel: false,
                        }]"
                />
            </b-form-group>

            <b-form-group
                id="height"
                class="col-12 col-sm-3"
                label="высота (мм)"
                label-for="input-height"
            >
                <vue-autonumeric
                    id="input-height"
                    class="form-control"
                    v-model="form.height"
                    v-on:input="onChange"
                    :options="
                        ['integerPos', {
                            maximumValue: maxH,
                            minimumValue: minH,
                            modifyValueOnWheel: false,
                        }]"
                />
            </b-form-group>

            <b-form-group
                id="count"
                class="col-12 col-sm-3"
                label="тираж (шт)"
                label-for="input-count"
            >
                <vue-autonumeric
                    id="input-count"
                    class="form-control"
                    v-model="form.count"
                    v-on:input="onChange"
                    :options="
                        ['integerPos', {
                            maximumValue: 1000000,
                            minimumValue: 0,
                            modifyValueOnWheel: false,
                        }]"
                />
            </b-form-group>
        </div>
        <div class="row justify-content-end">
            <div class="col-12 col-sm-3 align-self-center">
                <h5>Стоимость</h5>
            </div>
            <div class="col-12 col-sm-3">
                <b-form-input id="price" class="price" v-model="priceString" readonly></b-form-input>
            </div>
        </div>
    </div>
</template>

<script>
import { PriceHelper } from "../../lib/priceHelper";
import { cols, rows } from "../../lib/countHelper";
import { BFormGroup, BFormRadioGroup, BFormInput } from 'bootstrap-vue';
import VueAutonumeric from "vue-autonumeric";
import { moneyFormatter } from "../../lib/helpers";

export default {
    name: "CalcComponent",

    components: {
        BFormGroup,
        BFormRadioGroup,
        BFormInput,
        VueAutonumeric,
    },

    data() {
        return {
            form: {
                width: null,
                height: null,
                count: null,
                material: 0,
                chromaticity: 1,
            },
            materials: null,
            materialOptions: {
                0: "Бумага",
                1: "Пленка"
            },
            priceHelper: null,
            price: null,
            priceString: null,
            options: {
            },

            maxW: 330,
            minW: 0,
            maxH: 330,
            minH: 0,

            layoutW: 0,
            layoutH: 0,
            fieldW: 0,
            fieldH: 0,
            bleed: 0,
        }
    },

    mounted() {
        this.getOptions();
    },

    computed: {
        isMinAllowableSizeValues() {
            return this.form.width >= parseInt(this.options.minW) && this.form.height >= parseInt(this.options.minH);
        },

        numberOfSheets() {
            if (this.isMinAllowableSizeValues) {
                return Math.ceil(this.form.count / (cols(this.form.width, this) * (rows(this.form.height, this))))
            } else {
                return 0
            }
        },
    },

    methods: {
        getOptions() {
            axios({
                method: 'get',
                url: 'api/options'
            })
            .catch(error => {
                console.log(error);
            })
            .then(response => {
                this.options = response.data;
                this.materials = response.data.materials;
                this.priceHelper = new PriceHelper(this.options);

                this.layoutW = parseFloat(this.options.layoutW);
                this.layoutH = parseFloat(this.options.layoutH);
                this.fieldW = parseFloat(this.options.fieldW);
                this.fieldH = parseFloat(this.options.fieldH);
                this.bleed = parseFloat(this.options.bleed);

                this.maxW = this.layoutW - this.fieldW * 2 + this.bleed * 2;
                this.maxH = this.layoutH - this.fieldH * 2 + this.bleed * 2;
            });
        },

        onChange() {
            if (this.isMinAllowableSizeValues && this.form.count > 0) {
                this.price = this.priceHelper.getPrice(
                    this
                );
                this.priceString = moneyFormatter(this.price);
            } else {
                this.price = 0;
                this.priceString = null;
            }
        },
    }
}
</script>

<style scoped>
    .price {
        font-size: 16px;
        font-weight: 800;
        color: #003669;
    }
    .front-calc {
        max-width: 700px;
        padding: 40px;
        border-radius: 10px;
        color: white;
        background-color: #003669;
    }
</style> -->
