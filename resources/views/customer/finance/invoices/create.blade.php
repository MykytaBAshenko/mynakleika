@extends('customer.layouts.app')

@section('title', app_name() . ' | ' . __('strings.customer.invoices.payments'))

@section('content')

<div class="card mt-3">
	<div class="card-body">
		<invoice-create-component
			:orders-data = "{{ json_encode($notIncludedToBillsOrders) }}"
			:legal-entities = "{{ json_encode($legalEntities) }}"
			:self-legal-entity = "{{ option('self_legal_entity') }}"
			:balance = "{{ $balance }}"
			:invoice-status = "{{ json_encode($invoiceStatus) }}"
			:invoice-type = "{{ json_encode($invoiceType) }}"
		>
		</invoice-create-component>
	</div>
</div>

@endsection
