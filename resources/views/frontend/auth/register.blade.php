@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.register_box_title'))

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-lg-8 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                        @lang('labels.frontend.auth.register_box_title')
                    </strong>
                </div><!--card-header-->
                <div class="card-body">
                    <register-form
                    ></register-form>
                </div>
            </div><!-- card -->
        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection

@push('after-scripts')
	@if(config('access.captcha.registration'))
		{!! Captcha::script() !!}
	@endif
@endpush
