<template>
    <div class="row">
        <div class="col-md-6">
            <ValidationProvider
                :rules="'required|size:' + maxFileSize"
                v-slot="{ validate, errors }"
                mode="lazy"
                ref="file"
                :name="__('forms.order.label.file')"
            >
                <div class="row pb-4">
                    <b-form-group
                        class="col-md-8 mt-2"
                        :invalid-feedback="errors[0]"
                        :state="errors[0] ? false : (Boolean(states.showPreview) ? true : null)"
                        :description="'Максимальный размер: ' + maxFileSize + ' Mb'"
                    >
                        <b-form-file
                            v-model="file"
                            v-on:input="clearForm"
                            accept=".pdf"
                            :placeholder="__('forms.order.placeholder.file')"
                            :browse-text="__('buttons.general.choose')"
                            :disabled="Boolean(states.fileLoadingState)"
                            :state="errors[0] ? false : (Boolean(states.showPreview) ? true : null)"
                            @change="validate"
                        />
                    </b-form-group>
                    <div class="col-md-4 mt-md-2 mt-3">
                        <b-button
                            v-on:click="uploadFile"
                            variant="secondary"
                            size="btn-sm"
                            :disabled="fileState"
                            class="btn-block">{{ __('buttons.general.upload') }}
                        </b-button>
                    </div>
                </div>
            </ValidationProvider>

            <b-card v-if="states.showProcessLog">
                <template v-if="states.showLoadingProgress">
                    <p>Загрузка файла:</p>
                    <b-progress :max="progressBar.max" show-progress class="mb-4">
                        <b-progress-bar :value="progressBar.counter" :label="progressBar.counter.toFixed(0)+' %'"/>
                    </b-progress>
                </template>

                <div class="alert alert-danger" role="alert" v-if="states.showGeneralError">
                    <span>{{ generalErrorMsg }}</span>
                </div>

                <div class="alert alert-danger" role="alert" v-if="states.showProcessError">
                    <p>{{ __('alerts.customer.process_error') }}</p>
                    <ul>
                        <li v-for="error in processErrors">{{ error }}</li>
                    </ul>
                </div>

                <div class="alert alert-warning" role="alert" v-if="states.showProcessWarning">
                    <p>{{ __('alerts.customer.process_warning') }}</p>
                    <ul>
                        <li v-for="warning in processWarnings">{{ warning }}</li>
                    </ul>
                </div>

                <template v-if="states.showProcessSizeError">
                    <div class="alert alert-danger" role="alert">
                        <p>{{ __('alerts.customer.error') }}</p>
                        <p>{{ 'Размер макета не соответствует введенным параметрам.' }}</p>
                        <p>Указанные размеры макета: {{ width }} x {{ height }} мм</p>
                        <p>Фактические размеры макета: {{ processInfo.width }} x {{ processInfo.height }} мм</p>
                    </div>
                    <b-button
                        v-on:click="fixDimensions(processInfo.width, processInfo.height)"
                        variant="success"
                        size="btn-sm"
                        class="btn-block mb-4">{{ 'Исправить, используя фактические размеры файла?' }}
                    </b-button>
                </template>

                <div class="mt-2" v-if="states.showProcessingProgress">
                    <p class="mb-2">Обработка и проверка файла:</p>
                    <pulse-loader :loading="states.showProcessingProgress" :color="spinner.color" :size="spinner.size"/>
                </div>

                <div class="alert alert-success" role="alert" v-if="states.showProcessResult">
                    <p>{{ __('alerts.customer.process_success') }}</p>
                    <ul>
                        <li>Размеры документа: {{ processInfo.width }} x {{ processInfo.height }} мм</li>
                        <li>Цветовая модель: {{ processInfo.colorspace }}</li>
                        <li>Разрешение файла: {{ processInfo.resolution === 'no_images' ? 'OK' : processInfo.resolution + ' dpi'}} </li>
                    </ul>
                </div>

                <div class="alert alert-primary" role="alert" v-if="states.showRecommendation">
                    <span>{{ recomendationMsg }}</span>
                </div>
            </b-card>
        </div><!-- end col1 -->

        <div class="col-md-6 mt-2">
            <div class="preview" v-if="states.showPreview">
                <b-img :src="preview.src" fluid/>
            </div>
        </div>
    </div>
</template>

<script>
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue';
    import { ValidationProvider } from 'vee-validate';
    import "../validationRules";

    export default {
        components: {
            PulseLoader,
            ValidationProvider,
        },

        props: {
            width: {
                type: Number,
                required: true,
            },
            height: {
                type: Number,
                required: true,
            },
            img: Image,
            maxFileSize: {
                type: Number,
                required: true,
            },
        },

        data () {
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
                states: {
                    fileLoadingState: false,
                    fileSelectedState: false,
                    showProcessLog: false,
                    showLoadingProgress: false,
                    showProcessingProgress: false,
                    showProcessResult: false,
                    showPreview: false,
                    showGeneralError: false,
                    showProcessError: false,
                    showProcessWarning: false,
                    showProcessSizeError: false,
                    showRecommendation: false,
                },
                processInfo: {
                    width: null,
                    height: null,
                    colorspace: null,
                    resolution: null,
                },
                processErrors: [],
                processWarnings: [],
                generalErrorMsg: '',
                responseData: null,
                preview: new Image(),
            }
        },

        computed: {
            fileState() {
                return !Boolean(this.file) || this.states.fileSelectedState || !this.$refs.file.flags.valid
            }
        },

        methods: {
            uploadFile () {
                this.states.showProcessLog = true;
                this.states.showLoadingProgress = true;
                this.states.fileSelectedState = true
                this.states.fileLoadingState = true
                let self = this
                let config = {
                    onUploadProgress: function(progressEvent) {
                        self.progressBar.counter = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                    }
                };

                let formData = new FormData();
                formData.append('file', this.file);

                axios.post('/customer/file/upload', formData, config)
                .catch(error => {
                    if (error.response) {
                        // processUploadErrors(error.response.data);
                    } else if (error.request) {

                    }
                    this.states.showLoadingProgress = false;
                    console.log(error.response.data.errors.file[0]);
                })
                .then(response => {
                    if (response.data.status === 'error') {
                        this.states.generalError = true;
                        this.generalErrorMsg = response.data.message;
                    }
                    else {
                        this.fileName = response.data.filename
                        this.getProcessed(response.data.filename);
                    }
                    this.states.showLoadingProgress = false;
                });
            },

            getProcessed(fileName) {
                this.states.showProcessingProgress = true
                axios.get('/customer/file/getProcessed', {
                    params: {
                        filename: fileName,
                    }
                })
                .catch(error => {
                    console.log(error);
                })
                .then(response => {
                    this.responseData = response.data;
                    this.states.showProcessingProgress = false
                    this.states.fileLoadingState = false

                    if (response.data.status === 'error') {
                        this.states.showGeneralError = true
                        this.generalErrorMsg = response.data.message
                    }

                    else if (response.data.hasOwnProperty('process_errors')) {
                        this.states.showProcessError = true
                        this.processErrors = response.data.process_errors
                        this.states.showRecommendation = true;
                        this.recomendationMsg = "Исправьте ошибки и попробуйте загрузить файл повторно"
                    }

                    else {
                        this.states.showProcessResult = true
                        this.processInfo.width = response.data.process_info.width
                        this.processInfo.height = response.data.process_info.height
                        this.processInfo.colorspace = response.data.process_info.colorspace
                        this.processInfo.resolution = response.data.process_info.resolution

                        this.states.showPreview = true;
                        this.preview.src = '/storage/' + response.data.preview_filename + '.tn.jpg'

                        if (response.data.hasOwnProperty('process_warnings')
                            && response.data.process_warnings.length > 0) {
                            this.states.showProcessWarning = true;
                            this.processWarnings = response.data.process_warnings;
                        }

                        if (!this.checkDimensions(this, response.data.process_info)
                            && (parseInt(this.width) || parseInt(this.height))) {
                            this.states.showProcessResult = false;
                            this.states.showProcessSizeError = true;
                        } else {
                            this.fixDimensions(this.processInfo.width, this.processInfo.height)
                            this.onSuccess(response.data)
                        }
                    }
                });
            },

            checkDimensions: function (input, computed) {
                return (input.width === computed.width && input.height === computed.height) ||
                    (input.width === computed.height && input.height === computed.width);
            },

            fixDimensions(width, height) {
                this.states.showProcessLog = false;
                this.onSuccess(this.responseData);
                this.$emit('fixDimensions', width, height)
            },

            onSuccess(data) {
                this.states.showPreview = true;
                this.fileName = data.preview_filename;
                this.$emit('process', this.fileName, this.states.showPreview)
            },

            clearForm() {
                Object.keys(this.states).forEach(property => {
                    this.states[property] = false;
                });

                Object.keys(this.processInfo).forEach(property => {
                    this.processInfo[property] = null;
                });

                this.progressBar.counter = 0
                this.fileName = this.processErrors = this.processWarnings = null

  // Emit a clear event (optional)
                this.$emit('clear');
}

        }
    }
</script>
