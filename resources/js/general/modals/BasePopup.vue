<template>
    <b-modal
        :id="mid"
        :size = "size"
        :ok-variant = "okVariant"
        :ok-title = "okTitle"
        :cancel-title = "cancelTitle"
        :cancel-variant = "cancelVariant"
        :header-bg-variant="headerBgVariant"
        :hide-footer="hideFooter"
        :ok-only="okOnly"
        centered
        @ok="handleOk"
        @cancel="handleCancel"
    >
        <template v-slot:modal-title>
            <div class="d-flex align-items-center">
                <i class="material-icons">{{ icon }}</i>&nbsp;&nbsp;{{ title }}
            </div>
        </template>

        <div class="d-block text-left">
            <h5 v-if="baseMessage.length">{{ baseMessage }}</h5>
            <p class="my-2" v-if="subMessage !== 'undefined'">{{ subMessage }}</p>
        </div>
    </b-modal>
</template>

<script>
    export default {
        props: {
            mid: String,
            size: {
                type: String,
                default: "sm"
            },
            title: String,
            baseMessage: String,
            subMessage: String,
            headerBgVariant: String,
            okTitle: String,
            okVariant: {
                type: String,
                default: "success"
            },
            cancelTitle: String,
            cancelVariant: {
                type: String,
                default: "secondary"
            },
            hideFooter: Boolean,
            okOnly: {
                type: Boolean,
                default: false
            },
            icon: String
        },
        name: "BasePopup",
        methods: {
            handleOk() {
                this.$emit('submit')
                this.$nextTick(() => {
                    this.$bvModal.hide(this.mid)
                })
            },

            handleCancel() {
                this.$emit('cancel')
                this.$nextTick(() => {
                    this.$bvModal.hide(this.mid)
                })
            }
        }
    }
</script>

<style scoped>

</style>
