@component('mail::message')

    @lang('strings.emails.auth.greeting')<br>

    Счет №{{ $invoice->number }} успешно оплачен!

@endcomponent
