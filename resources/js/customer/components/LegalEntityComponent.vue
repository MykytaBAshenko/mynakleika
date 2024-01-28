<template>
    <div class="card">
        <div class="card-body">
            <template v-if="legalEntity.verification_status === 0">
                <b-badge class="mb-3" variant="warning">
                    {{ "Ожидает подтверждения" }}
                </b-badge>
            </template>

            <h5 class="card-title">{{ legalEntity.alias }}</h5>
            <p>{{ legalEntity.name }}</p>
            <p v-if="legalEntity.type===1">ЕГРПОУ: {{ legalEntity.edrpou }}</p>
            <p>ИНН: {{ legalEntity.ipn }}</p>
            <template v-if="legalEntity.doc_flow_type === 2">
                <p class="card-text" >
                    Адрес: {{ legalEntity.legal_address}} <nobr>
                    Тел.: {{ legalEntity.tel }}</nobr>
                </p>
            </template>
        </div>
        <div class="d-flex justify-content-start">
            <b-button
                data-toggle="tooltip"
                data-placement="bottom"
                title="Редактировать"
                variant="link"
                size="sm"
                class="ml-3 mb-3"
                @click="onEdit"
            >
                {{ 'Редактировать' }}
            </b-button>

            <b-button
                data-toggle="tooltip"
                data-placement="bottom"
                title="Удалить"
                variant="link"
                size="sm"
                class="ml-3 mb-3"
                @click="onDelete"
            >
                {{ 'Удалить' }}
            </b-button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['legalEntity'],

        methods: {
            onDelete() {
                this.$bvModal.msgBoxConfirm('Удалить плательщика ' + this.legalEntity.alias + '?', {
                    title: 'Подтверждение удаления плательщика',
                    size: 'sm',
                    okVariant: 'danger',
                    okTitle: 'Удалить',
                    cancelTitle: 'Отмена',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                })
                    .then(value => {
                        if (value) {
                            axios({
                                method: "delete",
                                url: route('customer.legal_entity.destroy', {legalEntity: this.legalEntity.id}),
                            })
                                .then(response => {
                                    window.location = response.data.redirect;
                                })
                                .catch(err => {
                                    console.log(err);
                                });
                        }
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },

            onEdit() {
                this.$emit('edit', this.legalEntity);
            }
        }
    }
</script>
