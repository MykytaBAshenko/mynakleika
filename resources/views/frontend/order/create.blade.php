@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="d-flex">
        <h2 class="card-title">{{ __('strings.customer.order.create_new') }}</h2>
        <a class="ml-auto d-flex align-content-center" href="/technotes/">
            <span class="material-icons-outlined pr-2">picture_as_pdf</span>Требования к макетам
        </a>
    </div>
    <order-create-component
        :materials = "{{ json_encode($materials) }}"
        :options = "{{ json_encode($options) }}"
        upload-route = "{{ $uploadRoute }}"
        process-route = "{{ $processRoute }}"
    >
    </order-create-component>
@endsection
