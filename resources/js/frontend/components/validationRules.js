import { required, email, alpha, confirmed } from "vee-validate/dist/rules";
import { extend } from "vee-validate";

extend("required", {
    ...required,
    message: i18n.forms.required.description,
});

extend("email", {
    ...email,
    message: i18n.forms.email.description,
});

extend("alpha", {
    ...alpha,
    message: i18n.forms.alpha.description,
});

extend("confirmed", {
    ...confirmed,
    message: i18n.forms.confirmed.description,
});
