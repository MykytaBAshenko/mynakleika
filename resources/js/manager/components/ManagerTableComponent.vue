<template>
    <div>
        <b-row class="justify-content-between">
            <b-col md="4" class="my-1">
                <b-form-group class="mb-4">
                    <b-input-group>
                        <b-form-input v-model="filter" :placeholder="__('strings.backend.general.search_placeholder')" />
                        <b-input-group-append>
                            <b-btn :disabled="!filter" @click="filter = ''">{{ __('strings.backend.general.search_clear') }}</b-btn>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col>
        </b-row>

        <!-- Main table element -->

        <div class="table-responsive">
            <b-table
                class="order-table"
                stacked = "sm"
                hover
                head-variant = "dark"
                sort-by = "id"
                sort-desc
                :items = "items"
                :fields = "fields"
                :filter = "filter"
                :current-page = "currentPage"
                :per-page = "perPage"
                @filtered = "onFiltered">

                <template slot="HEAD_created_at" slot-scope="data">
                    <span data-toggle="tooltip" data-placement="bottom" :title="data.label">
                        {{ __('labels.general.order_table.created_at_short') }}
                    </span>
                </template>

                <template slot="HEAD_end_at" slot-scope="data">
                    <span data-toggle="tooltip" data-placement="bottom" :title="data.label">
                        {{ __('labels.general.order_table.end_at_short') }}
                    </span>
                </template>

                <template slot="HEAD_production_status" slot-scope="data">
                    <span data-toggle="tooltip" data-placement="bottom" :title="data.label">
                        {{ __('labels.general.order_table.ps_short') }}
                    </span>
                </template>

                <template slot="HEAD_finance_status" slot-scope="data">
                    <span data-toggle="tooltip" data-placement="bottom" :title="data.label">
                        {{ __('labels.general.order_table.fs_short') }}
                    </span>
                </template>

                <template slot="order_ref" slot-scope="data">
                    <span data-toggle="tooltip" data-placement="bottom" :title="data.value">
                        {{ data.value }}
                    </span>
                </template>

                <template slot="preview_link" slot-scope="row">
                    <b-btn v-b-modal="row.item.preview_link"
                        class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-file-pdf"></i>
                    </b-btn>

                    <b-modal :id="row.item.preview_link" @shown="showPDF(row.item.preview_link)" centered hide-footer>
                        <div :id="row.item.preview_link+'-contents'" class="col-sm">
                            <div :id="row.item.preview_link+'-loader'">Loading document ...</div>
                            <canvas :id="row.item.preview_link+'-canvas'"></canvas>
                        </div>
                    </b-modal>
                </template>

                <template slot="production_status" slot-scope="data">
                    {{ production_status[data.value] }}
                </template>

                <template slot="finance_status" slot-scope="data">
                    {{ finance_status[data.value] }}
                </template>

                <template slot="show_details" slot-scope="row">
                    <!-- we use @click.stop here to prevent emitting of a 'row-clicked' event  -->
                    <b-button @click.stop="row.toggleDetails" class="btn-sm btn-outline-secondary">
                        {{ row.detailsShowing ? __('labels.general.order_table.hide') : __('labels.general.order_table.show') }}
                    </b-button>
                </template>

                <template slot="row-details" slot-scope="row">
                    <b-row class="mb-2">
                        <b-col sm="3" class="text-sm-right">
                            <b>{{ __('labels.general.order_table.comments') }}</b>
                        </b-col>
                        <b-col>{{ row.item.order_comments }}</b-col>
                    </b-row>

                    <b-row class="mb-2">
                        <b-col sm="3" class="text-sm-right">
                            <b>{{ __('labels.general.order_table.material') }}</b>
                        </b-col>
                        <b-col>{{ row.item.material_name }}</b-col>
                    </b-row>

                    <b-row class="mb-2">
                        <b-col sm="3" class="text-sm-right">
                            <b>{{ __('labels.general.order_table.chromatisity') }}</b>
                        </b-col>
                        <b-col>{{ row.item.chromatisity }}</b-col>
                    </b-row>

                    <b-row class="mb-2">
                        <b-col sm="3" class="text-sm-right">
                            <b>{{ __('labels.general.order_table.lamination') }}</b>
                        </b-col>
                        <b-col>{{ lamination_options[row.item.lamination] }}</b-col>
                    </b-row>
                    <b-row class="mb-2"></b-row>

                    <b-row class="mb-2">
                        <b-col sm="3" class="text-sm-right">
                            <b>{{ __('labels.general.order_table.delivery_type') }}</b>
                        </b-col>
                        <b-col>{{ row.item.type }}</b-col>
                    </b-row>

                    <template v-if="row.item.address">
                        <b-row class="mb-2">
                            <b-col sm="3" class="text-sm-right">
                                <b>{{ __('labels.general.order_table.address') }}</b>
                            </b-col>
                            <b-col>
                                <span v-if="row.item.city">{{ row.item.city }}, </span>{{ row.item.address }}
                            </b-col>
                        </b-row>
                    </template>

                    <template v-if="row.item.np_warehouse">
                        <b-row class="mb-2">
                            <b-col sm="3" class="text-sm-right">
                                <b>{{ __('labels.general.order_table.np_warehouse') }}</b>
                            </b-col>
                            <b-col>{{ row.item.np_warehouse }}</b-col>
                        </b-row>
                    </template>

                    <template v-if="row.item.np_organization">
                        <b-row class="mb-2">
                            <b-col sm="3" class="text-sm-right">
                                <b>{{ __('labels.general.order_table.np_organization') }}</b>
                            </b-col>
                            <b-col>{{ row.item.np_organization }}</b-col>
                        </b-row>
                    </template>

                    <template v-if="row.item.contact_person">
                        <b-row class="mb-2">
                            <b-col sm="3" class="text-sm-right">
                                <b>{{ __('labels.general.order_table.contacts') }}</b>
                            </b-col>
                            <b-col>{{ row.item.contact_person }}, {{ row.item.contact_phone }}</b-col>
                        </b-row>
                    </template>

                    <template v-if="row.item.np_payer">
                        <b-row class="mb-2">
                            <b-col sm="3" class="text-sm-right">
                                <b>{{ __('labels.general.order_table.np_payer') }}</b>
                            </b-col>
                            <b-col>{{ row.item.np_payer }}</b-col>
                        </b-row>
                    </template>
                </template>

            </b-table>
        </div>

        <b-row>
            <b-col md="6" class="my-1">
                <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
            </b-col>
        </b-row>
    </div>
</template>

<script>

export default {
    props: ['ordersData'],

    name: "ManagerTableComponent",

    data() {
        return {
            items: this.ordersData,
            fields: [
                { key: 'id', label: i18n.labels.general.order_table.id, sortable: true, sortDirection: 'desc', 'class': 'text-center sm' },
                { key: 'customer_name', label: 'заказчик', sortable: true, sortDirection: 'desc', 'class': 'text-center sm' },
                { key: 'created_at', label: i18n.labels.general.order_table.created_at, 'class': 'text-center sm' },
                { key: 'end_at', label: i18n.labels.general.order_table.end_at, 'class': 'text-center' },
                { key: 'order_ref', label: i18n.labels.general.order_table.order_ref, sortable: true, 'class' : 'text-center spoiler' },
                { key: 'preview_link', label: i18n.labels.general.order_table.preview, 'class': 'text-center' },
                { key: 'format', label: i18n.labels.general.order_table.format, 'class': 'text-center sm' },
                { key: 'quantity', label: i18n.labels.general.order_table.quantity, 'class': 'text-center sm' },
                { key: 'production_status', label: i18n.labels.general.order_table.ps, sortable: true, 'class': 'text-center' },
                { key: 'finance_status', label: i18n.labels.general.order_table.fs, sortable: true, 'class': 'text-center sm' },
                { key: 'cost', label: i18n.labels.general.order_table.cost, 'class': 'text-center sm' },
                { key: 'show_details', label: i18n.labels.general.order_table.details,'class': 'text-center' }
            ],
            currentPage: 1,
            perPage: 10,
            totalRows: this.ordersData.length,
            filter: null,
            production_status: i18n.options.production_status,
            finance_status: i18n.options.finance_status,
            lamination_options: i18n.options.lamination_options,
        }
    },

    computed: {
        sortOptions () {
            // Create an options list from our fields
            return this.fields
                .filter(f => f.sortable)
                .map(f => { return { text: f.label, value: f.key } })
        }
    },

    methods: {
        onFiltered (filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length
            this.currentPage = 1
        },

        showPDF(pdf_url) {
            var canvas_wrapper = document.getElementById(pdf_url+"-contents")
            var canvas_loader = document.getElementById(pdf_url+"-loader")
            var canvas = document.getElementById(pdf_url+"-canvas")
            var canvas_ctx = canvas.getContext('2d')

            // Show page loader
            canvas_loader.style.display = 'block';
            // While page is being rendered hide the canvas and show a loading message
            canvas.style.display = 'none';

            PDFJS.getDocument({ url: pdf_url }).then(pdf_doc => {
                this.loadingTask = pdf_doc;

                // Hide the pdf loader and show pdf container in HTML
                canvas_loader.style.display = 'none';

                // Show the first page
                this.loadingTask.getPage(1).then(page => {

                    // Set the scale of the viewport accordingly this.canvas_wrapper
                    canvas.style.width = canvas_wrapper.clientWidth-30;
                    var scale_required = (canvas_wrapper.clientWidth-30) / page.getViewport(1).width;

                    // Get viewport of the page at required scale
                    var viewport = page.getViewport(scale_required);

                    // Set canvas width and height
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;

                    var renderContext = {
                        canvasContext: canvas_ctx,
                        viewport: viewport
                    };

                    // Render the page contents in the canvas
                    page.render(renderContext).then(() => {
                        // Show the canvas and hide the page loader
                        canvas.style.display = 'block';
                    });
                });

            }).catch(error => {

                //this.canvas_loader.style.display = 'none';
                console.log(error.message);
            });
        },

    }
}

</script>
