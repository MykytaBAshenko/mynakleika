<template>
    <div>
        <b-table
            class = "payer-table"
            stacked = "sm"
            hover
            show-empty
            :items = "payersDataProvider"
            :current-page = "currentPage"
            :per-page = "perPage"
            :busy.sync = "isBusy"
            :fields = "fields"
            ref = "payersTable"
        >
            <template #empty="scope">
                <b-alert show variant="info" class="d-flex align-items-center" v-if="!isBusy">
                    <span class="material-icons-outlined md-24 mr-2">info</span>
                    <span class="font-sm">{{ "Пока не создано ни одного плательщика" }}</span>
                </b-alert>
            </template>

            <template v-slot:cell(type)="row">
                {{ payerType[row.item.type] }}
            </template>

            <template v-slot:cell(is_nds_payer)="row">
                {{ isNdsPayer[row.item.is_nds_payer] }}
            </template>

            <template v-slot:cell(verification_status)="row">
                <b-form-select
                    size="sm"
                    v-model="row.item.verification_status"
                    :options="verificationStatusOptions"
                    v-on:change="onToggleVerificationStatus(row.item, row.index)"
                ></b-form-select>
            </template>
        </b-table>

        <base-popup
            mid="popup"
            size="sm"
            okVariant="success"
            headerBgVariant="success"
            okTitle="Подтвердить"
            cancelTitle="Отмена"
            title="Предупреждение"
            icon="error"
            :baseMessage="popup.baseMessage"
            :subMessage="popup.subMessage"
            :hideFooter="popup.hideFooter"
            :item="popup.item"
            @submit="onOk(popup.item)"
            @cancel="onCancel(selectedItemIdx)"
        ></base-popup>
    </div>
</template>

<script>
import BasePopup from "../../general/modals/BasePopup"

export default {
    name: "PayersListComponent",

    components: {
        'base-popup': BasePopup,
    },

    data() {
        return {
            isBusy: false,
            currentPage: 1,
            perPage: 15,
            totalRows: 1,
            verificationStatus: null,
            dataProviderCopy: null,

            fields: [
                { key: "type", label: "Тип" },
                { key: "alias", label: "Название" },
                { key: "edrpou", label: "ЕДРПОУ" },
                { key: "is_nds_payer", label: "Плательщик НДС", class: "text-center" },
                { key: "created_at", label: "Дата создания" },
                { key: "verification_status", label: "Статус верификации", sortable: true },
            ],

            payerType: {
                1: 'Предприятие',
                2: 'ФОП',
            },

            isNdsPayer: {
                0: 'Нет',
                1: 'Да',
            },

            verificationStatusOptions: [
                { value: 0, text: 'Не подтвержден' },
                { value: 1, text: 'Подтвержден' },
                { value: 2, text: 'Отклонен' },
            ],

            popup: {
                hideFooter: false,
                baseMessage: "",
                subMessage: "",
                item: null,
            },
        }
    },

    methods: {
        payersDataProvider(ctx) {
            const promise = axios.get(
                '/api/payers', {
                    params: {
                        page: ctx.currentPage,
                        size: ctx.perPage,
                        verification_status: this.verificationStatus
                    }
                }
            );

            this.isBusy = true;

            return promise.then(response => {
                const items = response.data.data;
                this.isBusy = false;
                this.totalRows = response.data.total;
                this.dataProviderCopy = JSON.parse(JSON.stringify(items));

                return items || [];
            }).catch(error => {
                this.isBusy = false;
                return []
            });
        },

        onToggleVerificationStatus(item, idx) {
            this.popup.item = item;
            this.selectedItemIdx = idx;
            this.popup.baseMessage = "Изменить статус плательщика " + item.alias
                + " на " + this.verificationStatusOptions[item.verification_status]['text'].toLowerCase() + "?";
            this.$bvModal.show('popup');
        },

        onOk(item) {
            axios({
                method: "patch",
                url: route('api.payer.update', {payer: item.id} ),
                data: {
                    verification_status: item.verification_status,
                }
            })
                .then(response => {
                    if (response.data.status === "success") {
                        this.$bvToast.toast('Статус плательщика '+
                            item.alias + ' изменен на ' +
                            this.verificationStatusOptions[item.verification_status]['text'].toLowerCase(),
                            {
                                title: 'Статус плательщика',
                                variant: 'success',
                                solid: true
                            })
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },

        onCancel(idx) {
            this.$refs.payersTable.localItems[idx].verification_status = this.dataProviderCopy[idx].verification_status;
        },
    },
}
</script>

<style scoped>

</style>
