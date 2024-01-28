<template>
    <div>
        <ValidationProvider
            v-slot="validationContext"
            mode="eager"
            rules="required"
            :name="__('forms.order.label.order_name')"
        >
            <b-form-group
                :label="__('forms.order.label.order_name') + ':'"
                :state="getValidationState(validationContext)"
                :invalid-feedback="validationContext.errors[0]"
            >
                <b-form-input
                    type="text"
                    v-model="form.orderRef"
                    :state="getValidationState(validationContext)"
                    :placeholder="__('forms.order.placeholder.order_name')"
                    @change="onChange"
                />
            </b-form-group>
        </ValidationProvider>

        <ValidationProvider
            v-slot="validationContext"
        >
            <b-form-group
                :label="__('labels.general.order_table.comments') + ':'"
                label-for="order_ref"
                :state="getValidationState(validationContext)"
            >
                <b-form-textarea
                    id="order_comments"
                    v-model="form.orderComments"
                    :rows="3"
                    :max-rows="6"
                    type="text"
                    @change="onChange"
                />
            </b-form-group>
        </ValidationProvider>
    </div>
</template>

<script>
import { ValidationProvider } from 'vee-validate';

export default {
    name: "OrderDescriptionForm",

    components: {
        ValidationProvider,
    },

    props: ['bus'],

    data() {
        return {
            form: {
                orderRef: '',
                orderComments: '',
            }
        }
    },

    methods: {
        getValidationState({ validated, valid = null }) {
            return validated ? (!!valid) : null;
        },

        onChange() {
            this.$emit('descriptionChanged', {
                'form': this.form
            });
        }
    }
}
</script>
