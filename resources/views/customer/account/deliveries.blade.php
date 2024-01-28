@extends('customer.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')

<div class="card mt-3">
    <div class="card-body">
		@include('customer.includes.account-navbar')

		<h2 class="card-title mb-4">Способы доставки</h2>

		<delivery-component
			:deliveries-data = "{{ json_encode($deliveries) }}" >
		</delivery-component>
	</div>
</div>

@endsection
