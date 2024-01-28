<template>
    <ValidationProvider
        :vid="vid"
        :name="$attrs.name"
        :rules="rules"
        v-slot="validationContext"
        :mode="mode"
    >
        <b-form-group
            v-bind="$attrs"
            :id="vid + 'inputGroup'"
            :state="getValidationState(validationContext)"
            :invalid-feedback="validationContext.errors[0]"
        >
            <b-form-input
                v-model="innerValue"
                v-bind="$attrs"
                :state="getValidationState(validationContext)"
            />
        </b-form-group>
    </ValidationProvider>
</template>

<script>
    import { ValidationProvider } from "vee-validate";

    export default {
        name: "BInputWithValidation",
        components: {
            ValidationProvider
        },
        props: {
            vid: {
                type: String
            },
            rules: {
                type: [Object, String],
                default: ""
            },
            value: {
                type: null
            },
            mode: {
                type: String,
                default: "eager",
            }
        },
        data: () => ({
            innerValue: ""
        }),
        watch: {
            // Handles internal model changes.
            innerValue(newVal) {
                this.$emit("input", newVal);
            },
            // Handles external model changes.
            value(newVal) {
                this.innerValue = newVal;
            }
        },
        created() {
            if (this.value) {
                this.innerValue = this.value;
            }
        },

        methods: {
            getValidationState({ validated, valid = null }) {
                return validated ? (!!valid) : null
            },
        }
    };
</script>
