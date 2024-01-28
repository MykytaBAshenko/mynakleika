@extends('accountant.layouts.app')

@section('title', app_name() . ' | ' . __('strings.accountant.income.index'))

@section('content')

<div class="card mt-4">
    <div class="card-body">
        <incomes-table-component></incomes-table-component>
    </div>
</div>

@endsection
