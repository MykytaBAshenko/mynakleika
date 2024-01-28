@component('mail::message')

    @lang('strings.emails.auth.greeting')<br>

    Заказ №{{ $order->id }} отпечатан!

@endcomponent
