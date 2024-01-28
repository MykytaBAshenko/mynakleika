import { required, email, length, numeric, size, min_value, max_value } from "vee-validate/dist/rules";
import { extend } from "vee-validate";

extend("required", {
    ...required,
    message: i18n.forms.required.description,
});

extend("email", {
    ...email,
    message: i18n.forms.email.description,
});

extend("length", {
    ...length,
    message: i18n.forms.length.description,
});

extend("numeric", {
    ...numeric,
    message: i18n.forms.numeric.description,
});

extend("min_value", {
    validate(value, { min_value }) {
        return value >= min_value;
    },
    params: ['min_value'],
    message: i18n.forms.min_value.description,
});

extend("max_value", {
    validate(value, { max_value }) {
        return value <= max_value;
    },
    params: ['max_value'],
    message: i18n.forms.max_value.description,
});

extend("size", {
    validate(value, { size }) {
        return value.size/1024/1024 <= size;
    },
    params: ['size'],
    message: i18n.forms.size.description,
});
