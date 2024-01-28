@extends('customer.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')

<div class="card mt-3">
    <div class="card-body">
        <order-table-component />
    </div>
</div>

@endsection
