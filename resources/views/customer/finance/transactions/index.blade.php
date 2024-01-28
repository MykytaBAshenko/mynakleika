@extends('customer.layouts.app')

@section('title', app_name() . ' | ' . __('strings.customer.invoices.transactions'))

@section('content')

<div class="card mt-3">
    <div class="card-body">
		@include('customer.includes.finance-navbar')

		<transactions-table-component></transactions-table-component>
	</div>
</div>

@endsection
