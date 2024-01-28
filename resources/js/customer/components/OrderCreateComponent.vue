<template>
    <div>
        <ValidationObserver ref="order_create">
            <b-form @submit.prevent="onSubmit">
                <h4 class="py-2">1. Загрузка макета</h4>
                <div class="row">
                    <file-upload-form-component
                        :bus = bus
                        :maxFileSize = options.maxFileSize
                        :uploadRoute = uploadRoute
                        :processRoute = processRoute
                        @processed = "onFileProcessed"
                        @fileChanged = "onFileChanged"
                        class="col-md-6"
                    ></file-upload-form-component>

                    <file-preview-form-component
                        :bus = bus
                        class="col-md-6"
                    >
                    </file-preview-form-component>
                </div>

                <h4 class="py-2">2. Параметры и просчет заказа</h4>
                <div class="row">
                    <calc-form-component
                        :bus = bus
                        :options = "options"
                        :materials = "materials"
                        @layoutChanged = "onLayoutChanged"
                        class = "col-md-6"
                    ></calc-form-component>

                    <layout-form-component
                        :bus = bus
                        :options = "options"
                        @layoutInitialized = "onLayoutInitialized"
                        @layoutRotated = "onLayoutRotated"
                        class = "col-md-6"
                    ></layout-form-component>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h4 class="py-2">3. {{ __('strings.customer.order.description') }}</h4>
                        <order-description-form
                            :bus = bus
                            @descriptionChanged = "onDescriptionChanged"
                        />
                    </div>
                    <div class="col-md-6">
                        <h4 class="py-2">4. {{ __('strings.customer.order.delivery') }}</h4>
                        <deliveries-form
                            :bus = bus
                            @deliveryChanged = "onDeliveryChanged"
                        />
                    </div>
                </div>

                <b-button
                    @click="onSubmit"
                    class="mt-4 px-5"
                    variant="success">{{ __('buttons.general.save') }}
                </b-button>
            </b-form>
        </ValidationObserver>
    </div>
</template>

<script>
import FileUploadFormComponent from "../../customer/components/partials/FileUploadFormComponent";
import FilePreviewFormComponent from "../../customer/components/partials/FilePreviewFormComponent";
import CalcFormComponent from "../../customer/components/partials/CalcFormComponent";
import LayoutFormComponent from "../../customer/components/partials/LayoutFormComponent";
import OrderDescriptionForm from "../../customer/components/partials/OrderDescriptionForm";
import DeliveriesForm from "../../customer/components/partials/DeliveriesForm";
import { ValidationObserver } from "vee-validate";

export default {
    name: "OrderCreateComponent",

    props: ['materials', 'options', 'uploadRoute', 'processRoute'],

    components: {
        FileUploadFormComponent,
        FilePreviewFormComponent,
        CalcFormComponent,
        LayoutFormComponent,
        OrderDescriptionForm,
        DeliveriesForm,
        ValidationObserver
    },

    data() {
        return {
            bus: new Vue(),
            form: {
                width: 0,
                height: 0,
                count: 0,
                angle: 0,
                fileName: '',
                orderRef: '',
                orderComments: '',
                material: null,
                lamination: 0,
                chromaticity: 1,
                days: 2,
                deliveryId: null,
                canvas: null,
            },
        }
    },

    created() {
        this.bus.$on('countChanged', (data) => {
            this.countChanged(data);
        });
        this.bus.$on('laminationChanged', (data) => {
            this.laminationChanged(data);
        });
    },



    methods: {
        laminationChanged(data) {
        this.form.lamination = data.form.matglanec ? data.form.matglanec.indx : 0;
        },
        countChanged(data) {
        this.form.count = data.form.count
        },
        onFileProcessed(data) {
            this.form.width = data.process_info.width;
            this.form.height = data.process_info.height;
            this.form.fileName = data.preview_filename;

            this.bus.$emit('previewLoaded', {
                form: {
                    width: this.form.width,
                    height: this.form.height,
                    fileName: this.form.fileName,
                },
            });
        },

        onLayoutChanged(data) {
            this.form.width = data.form.width;
            this.form.height = data.form.height;
            this.form.count = data.form.count;
            this.form.lamination = data.form.matglanec ? data.form.matglanec.indx : 0;
            this.form.material = data.form.material ? data.form.material.value : null;
            this.form.days = data.form.days;

            this.bus.$emit('layoutChanged', {
                form: {
                    width: this.form.width,
                    height: this.form.height,
                    count: this.form.count,
                },
                isMinAllowableSizeValues: data.isMinAllowableSizeValues
            });
        },

        onLayoutInitialized(data) {
            this.form.canvas = data.canvas;
        },

        onLayoutRotated(data) {
            [this.form.width, this.form.height] = [this.form.height, this.form.width];
            this.form.angle = data.angle;
            this.form.canvas = data.canvas;
            this.bus.$emit('layoutRotated');
        },

        onDeliveryChanged(data) {
            this.form.deliveryId = data.delivery;
        },

        onDescriptionChanged(data) {
            Object.assign(this.form, data.form);
        },

        onFileChanged() {
            this.bus.$emit('fileChanged');
        },

        onSubmit() {
            this.$refs.order_create
                .validate()
                .then(success => {
                    if (!success) {
                        return;
                    } else {
                        axios({
                            method: "post",
                            url: route('customer.order.store'),
                            data: {
                                order_ref: this.form.orderRef,
                                order_comments: this.form.orderComments,
                                file_name: this.form.fileName,
                                width: this.form.width,
                                height: this.form.height,
                                rotate: this.form.angle,
                                quantity: this.form.count,
                                material_id: this.form.material,
                                lamination: this.form.lamination,
                                chromaticity: this.form.chromaticity,
                                days: this.form.days,
                                delivery_id: this.form.deliveryId,
                                canvas_data: this.form.canvas.toDataUrl(),
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        })
                        .then(response => {
                            window.location = response.data.redirect;
                        });
                    }
                })
            ;
        },
    },
}
</script>
