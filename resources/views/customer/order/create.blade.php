@extends('customer.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')

<div class="card mt-3">
    <div class="card-body">
        <h2 class="card-title">{{ __('strings.customer.order.create_new') }}</h2>
        <order-create-component
            :materials = "{{ json_encode($materials) }}"
            :options = "{{ json_encode($options) }}"
            upload-route = "{{ $uploadRoute }}"
            process-route = "{{ $processRoute }}"
        >
        </order-create-component>
    </div>
</div>

@endsection
