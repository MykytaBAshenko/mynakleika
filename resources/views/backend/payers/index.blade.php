@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.options.payers'))

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <h3 class="card-title mb-3">
                        {{ __('strings.backend.options.payers') }}
                    </h3>
                    <payers-list-component></payers-list-component>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
@endsection
