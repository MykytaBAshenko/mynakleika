<template>
    <div>
        <template v-if="legalEntities.length">
            <div class="row">
                <div v-for="item in legalEntities" class="col-md-4">
                    <legal-entity-component
                        :legal-entity="item"
                        v-on:edit="edit(item)"
                    ></legal-entity-component>
                </div>
            </div>
        </template>
        <template v-else>
            <b-alert show variant="info" class="d-flex align-items-center" v-if="!isBusy">
                <span class="material-icons-outlined md-24 mr-2">info</span>
                <span class="font-sm">{{ "У вас пока не добавлено ни одного плательщика" }}</span>
            </b-alert>
        </template>
        <div class="row mt-4">
            <div class="col">
                <legal-entity-modal-form
                    :legal-entity="legalEntity"
                    :action="action"
                ></legal-entity-modal-form>
                <b-button
                    @click="add"
                    class="btn btn-success"
                >
                    <i class="fas fa-plus-circle"></i>&nbsp;{{ "Добавить нового" }}
                </b-button>
            </div>
        </div>
    </div>
</template>

<script>

import LegalEntityComponent from "./LegalEntityComponent";
import LegalEntityModalForm from "./modals/LegalEntityModalForm";

export default {
    name: "LegalEntitiesDashboard",
    props: ['legalEntities'],
    components: {
        LegalEntityModalForm,
        LegalEntityComponent
    },

    data() {
        return {
            action: '',
            legalEntity: null,
        }
    },

    methods: {
        add() {
            this.legalEntity = null;
            this.action = 'add';
            this.$bvModal.show('legal-entity-modal');
        },

        edit(item) {
            this.legalEntity = item;
            this.action = 'edit';
            this.$bvModal.show('legal-entity-modal');
        },
    },
}
</script>

<style scoped>

</style>
