@extends('customer.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')

<div class="card mt-3">
    <div class="card-body">
		@include('customer.includes.account-navbar')

		<h2 class="card-title mb-4">{{ __('strings.customer.profile.legal_entities') }}</h2>
		<legal-entities-dashboard
			:legal-entities = "{{ json_encode($legalEntities) }}"
		></legal-entities-dashboard>
	</div>
</div>

@endsection
