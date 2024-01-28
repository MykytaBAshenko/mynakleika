<template>
    <ValidationProvider
        :vid="vid"
        :name="$attrs.name"
        :rules="rules"
        v-slot="{ valid, errors }"
    >
        <b-form-group
            v-bind="$attrs"
            :id="vid + 'selectInputGroup'"
            :state="errors[0] ? false : (valid ? true : null)"
            :invalid-feedback="errors[0]"
        >
            <multiselect
                :id="vid + 'multiselectInput'"
                :state="errors[0] ? false : (valid ? true : null)"
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
        }
    };
</script>
