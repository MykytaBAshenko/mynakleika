@extends('manager.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
   
<div class="card mt-4">
    <div class="card-body">            
        <manager-table-component
            :orders-data = "{{ json_encode($orders) }}" >  
        </manager-table-component>
    </div>
</div>

@endsection