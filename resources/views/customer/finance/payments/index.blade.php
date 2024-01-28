@extends('customer.layouts.app')

@section('title', app_name() . ' | ' . __('strings.customer.invoices.payments'))

@section('content')

<div class="card mt-3">
    <div class="card-body">
        @include('customer.includes.finance-navbar')
        <payment-component
            :legal-entities = "{{ json_encode($legalEntities) }}"
            :system-legal-entities = "{{ json_encode($systemLegalEntities) }}"
        ></payment-component>
    </div>
</div>

@endsection
