@extends('customer.layouts.app')

@section('title', app_name() . ' | ' . __('strings.customer.invoices.list'))

@section('content')

<div class="card mt-3">
    <div class="card-body">
		@include('customer.includes.finance-navbar')

		<invoices-table-component></invoices-table-component>
	</div>
</div>

@endsection
