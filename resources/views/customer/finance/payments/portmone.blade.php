<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/loader.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="/js/loader.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
</head>
<body>
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="lv-bars lv-mid md"></div>
    </div>
</div>

<form id="portmone" action="https://www.portmone.com.ua/gateway/" method="post">
    <input type="hidden" name="payee_id" value="{{ config('app.portmone_payee_id') }}" />
    <input type="hidden" name="shop_order_number" value="{{ $shopOrderNumber }}" />
    <input type="hidden" name="bill_amount" value="{{ $billAmount }}"/>
    <input type="hidden" name="description" value="Опис замовлення"/>
    <input type="hidden" name="success_url" value="{{ config('app.portmone_success_url') }}" />
    <input type="hidden" name="failure_url" value="{{ config('app.portmone_failure_url') }}" />
    <input type="hidden" name="lang" value="{{ config('app.locale') }}" />
    <input type="hidden" name="encoding"  value= "{{ config('app.portmone_encoding') }}" />
</form>

<script type="text/javascript">
    $(document).ready(function() {
        let loader = new lv();
        loader.initLoaderAll();
        loader.startObserving();

        document.forms["portmone"].submit();
    });
</script>

</body>
</html>
