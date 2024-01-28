<template>
    <b-alert
        :show="dismissCountDown"
        dismissible
        :variant="variant"
        @dismissed="dismissCountDown=0"
        @dismiss-count-down="countDownChanged"
    >
        {{ message }}
    </b-alert>
</template>

<script>
    export default {
        name: "BaseAlert",

        data() {
            return {
                message: null,
                variant: null,
                dismissSecs: 5,
                dismissCountDown: 0,
            }
        },

        mounted() {
            this.onLoad()
        },

        methods: {
            countDownChanged(dismissCountDown) {
                this.dismissCountDown = dismissCountDown
            },

            showAlert() {
                this.dismissCountDown = this.dismissSecs
            },

            onLoad() {
                let alert = JSON.parse(sessionStorage.getItem("alert"))
                if (alert) {
                    this.message = alert.message
                    this.variant = alert.type
                    this.showAlert()
                    sessionStorage.removeItem("alert");
                }
            },
        }
    }
</script>
