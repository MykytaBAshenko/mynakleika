<template>
    <ValidationProvider
        :rules="'required|size:' + maxFileSize"
        v-slot="validationContext"
        mode="eager"
        ref="file"
        :name="__('forms.order.label.file')"
    >
        <b-form-group
            :invalid-feedback="validationContext.errors[0]"
            :disabled=uploadInputState
            :state="getValidationState(validationContext)"
            :description="__('forms.order.description.file', { 'maxFileSize': maxFileSize })"
        >
            <div class="row">
                <div class="col-md-8">
                    <b-form-file
                        v-model="file"
                        accept=".pdf"
                        :placeholder="__('forms.order.placeholder.file')"
                        :browse-text="__('buttons.general.choose')"
                        :state="getValidationState(validationContext)"
                        @input="resetForm"
                        @change="validationContext.validate"
                    />
                </div>
                <div class="col-md-4 mt-3 mt-md-0">
                    <b-button
                        v-on:click="uploadFile"
                        variant="success"
                        size="btn-sm"
                        class="btn-block"
                        :disabled="!uploadButtonState"
                    >
                        {{ __('buttons.general.upload') }}
                    </b-button>
                </div>
            </div>
        </b-form-group>

        <transition name="fade">
            <b-card v-if="showProcessLog">
                <template v-if="fileUploading">
                    <p>{{ __('strings.customer.order.create_new') }}</p>
                    <b-progress :max="progressBar.max" show-progress class="mb-4">
                        <b-progress-bar :value="progressBar.counter" :label="progressBar.counter.toFixed(0)+' %'"/>
                    </b-progress>
                </template>
                <div class="mt-2" v-if="fileProcessing">
                    <p class="mb-2">Обработка и проверка файла:</p>
                    <pulse-loader :loading="fileProcessing" :color="spinner.color" :size="spinner.size"/>
                </div>

                <transition name="fade">
                    <div v-if="showGeneralError">
                        <div class="container">
                            <div class="row py-2 my-2 bg-red" role="alert">
                                <div class="col-1">
                                    <span class="material-icons-outlined align-middle text-white">announcement</span>
                                </div>
                                <div class="col-11 error-message align-self-center text-break">
                                    {{ generalError }}
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>

                <transition name="fade">
                    <div v-if="showProcessErrors">
                        <p>{{ __('alerts.customer.process_error') }}</p>
                        <div class="container">
                            <div class="row py-2 my-2 bg-red" role="alert" v-for="error in processErrors">
                                <div class="col-1">
                                    <span class="material-icons-outlined align-middle text-white">announcement</span>
                                </div>
                                <div class="col-11 error-message align-self-center" v-html="error"></div>
                            </div>
                        </div>
                    </div>
                </transition>

                <transition name="fade">
                    <div v-if="showProcessWarnings">
                        <p v-if="!showProcessErrors">{{ __('alerts.customer.process_warning') }}</p>
                        <div class="container">
                            <div class="row py-2 my-2 bg-yellow" role="alert" v-for="warning in processWarnings">
                                <div class="col-1">
                                    <span class="material-icons-outlined align-middle text-black">announcement</span>
                                </div>
                                <div class="col-11 warning-message align-self-center" v-html="warning"></div>
                            </div>
                        </div>
                    </div>
                </transition>

                <transition name="fade">
                    <div v-if="showRecommendation" class="container">
                        <div class="row py-2 mt-3 bg-primary" role="alert">
                            <div class="col-1">
                                <span class="material-icons-outlined text-white align-middle">error_outline</span>
                            </div>
                            <div class="col-11 error-message align-self-center text-white">{{ recommendationMsg }}</div>
                        </div>
                    </div>
                </transition>

                <transition name="fade">
                    <div v-if="showProcessResult" class="container">
                        <div class="row py-2 my-2 bg-success" role="alert">
                            <div class="col-1">
                                <span class="material-icons-outlined text-white align-middle">done_all</span>
                            </div>
                            <div class="col-11 error-message align-self-center text-white">{{ "Файл успешно загружен и обработан" }}</div>
                        </div>
                    </div>
                </transition>
            </b-card>
        </transition>
    </ValidationProvider>
</template>

<script>
import { ValidationProvider } from "vee-validate";
import "../validationRules";
import PulseLoader from 'vue-spinner/src/PulseLoader.vue';

export default {
    name: "FileUploadFormComponent",

    props: ['bus', 'maxFileSize', 'uploadRoute', 'processRoute'],

    components: {
        ValidationProvider,
        PulseLoader,
    },

    data() {
        return {
            file: null,
            fileName: '',

            progressBar: {
                counter: 0,
                max: 100,
            },

            spinner: {
                color: '#20a8d8',
                size: '12px',
            },

            form: {
                selectFileInput: {
                    active: true,
                },
                selectFileButton: {
                    active: true
                },
                uploadButton: {
                    active: true
                },
            },

            fileUploadedAndProcessed: false,
            fileUntouched: true,
            fileUploading: false,
            fileProcessing: false,

            fileUploadError: '',
            generalError: '',
            processErrors: null,
            processWarnings: null,
            recommendationMsg: "Исправьте ошибки и попробуйте загрузить файл повторно",

            showProcessLog: false,
            showGeneralError: false,
            showProcessErrors: false,
            showProcessWarnings: false,
            showRecommendation: false,
            showProcessResult: false,

            processInfo: null,
        }
    },

    computed: {
        uploadInputState() {
            return this.fileUploading || this.fileProcessing;
        },

        uploadButtonState() {
            return Boolean(this.file) && (this.$refs.file.flags.valid) && this.fileUntouched;
        }
    },

    methods: {
        getValidationState(validationContext) {
            return validationContext.errors[0] ? false : (this.fileUploadedAndProcessed ? true : null);
        },

        resetForm() {
            this.fileUntouched = true;
            this.showProcessLog = false;
            this.fileUploadedAndProcessed = false;
            this.showGeneralError = false;
            this.generalError = '';
            this.showProcessErrors = false;
            this.showProcessWarnings = false;
            this.showRecommendation = false;
            this.showProcessResult = false;
            this.$emit('fileChanged');
        },

        uploadFile() {
            let self = this;
            let formData = new FormData();
            formData.append('file', this.file);

            this.fileUploading = true;
            this.showProcessLog = true;

            axios({
                method: 'POST',
                url: route(this.uploadRoute),
                data: formData,
                onUploadProgress: function (progressEvent) {
                    self.progressBar.counter = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                },
            })
            .then(response => {
                if (response.data.status === 'error') {
                    this.processUploadErrors(response.data.message);
                }
                else {
                    this.fileName = response.data.filename
                    this.getProcessed(response.data.filename);
                }
            })
            .catch(error => {
                if (error.response.status === 429) {
                    this.processUploadErrors("Превышен лимит запросов. Попробуйте повторить через одну минуту.");
                } else {
                    this.processUploadErrors(error.response.statusText);
                }
            })
            .then(() => {
                this.fileUploading = false;
                this.fileUntouched = false;
            });
        },

        getProcessed(fileName) {
            this.fileProcessing = true;

            axios({
                method: 'GET',
                url: route(this.processRoute),
                params: {
                    filename: fileName,
                }
            })
            .then(response => {
                switch (response.data.status) {
                    case 'error':
                        this.showGeneralError = true;
                        this.generalError = response.data.message;
                        this.fileUploadedAndProcessed = false;
                        this.$refs.file.flags.valid = false;
                        break;
                    case 'process_errors':
                        this.showProcessErrors = true;
                        this.processErrors = response.data.errors;
                        if (response.data.warnings.length) {
                            this.processWarnings = response.data.warnings;
                            this.showProcessWarnings = true;
                        }
                        this.showRecommendation = true;
                        this.fileUploadedAndProcessed = false;
                        this.$refs.file.flags.valid = false;
                        break;
                    default:
                        if (response.data.warnings.length) {
                            this.processWarnings = response.data.warnings;
                            this.showProcessWarnings = true;
                        } else {
                            this.showProcessResult = true;
                        }
                        this.fileUploadedAndProcessed = true;
                        this.$emit('processed', response.data);
                }
            })
            .catch(error => {
                if (error.response.status === 429) {
                    this.processUploadErrors("Превышен лимит запросов. Попробуйте повторить через одну минуту.");
                } else {
                    this.processUploadErrors(error.response.statusText);
                }
            })
            .then(() => {
                this.fileProcessing = false;
            });
        },

        processUploadErrors(error) {
            this.showGeneralError = true;
            this.generalError = error;
            this.fileUploadedAndProcessed = false;
            this.$refs.file.flags.valid = false;
        },
    }
}
</script>
