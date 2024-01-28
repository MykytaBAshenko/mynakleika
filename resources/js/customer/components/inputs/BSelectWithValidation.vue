<template>
    <ValidationProvider
        :vid="vid"
        :name="$attrs.name"
        :rules="rules"
        v-slot="validationContext"
    >
        <b-form-group
            v-bind="$attrs"
            :id="vid + 'selectInputGroup'"
            :state="getValidationState(validationContext)"
            :invalid-feedback="validationContext.errors[0]"
        >
            <multiselect
                :id="vid + 'multiselectInput'"
                :state="getValidationState(validationContext)"
                v-model="innerValue"
                v-bind="$attrs"
                :label="$attrs.optionsLabel"
                :options="options"
                selectLabel=""
                selectedLabel=""
                deselectLabel=""
            />
        </b-form-group>
    </ValidationProvider>
</template>


<script>
    import { ValidationProvider } from "vee-validate";
    import { Multiselect } from 'vue-multiselect';

    export default {
        name: "BSelectWithValidation",
        components: {
            ValidationProvider,
            Multiselect,
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
            options: {
                type: [Object, Array],
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
