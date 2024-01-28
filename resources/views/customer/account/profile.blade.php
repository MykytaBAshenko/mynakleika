@extends('customer.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')

<div class="card mt-3">
    <div class="card-body">

		@include('customer.includes.account-navbar')

		<h2 class="card-title mb-4">{{ __('strings.customer.profile.customer_profile') }}</h2>
		{{ html()->modelForm($logged_in_user, 'PATCH', route('customer.profile.update'))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}

			<div class="form-group row mt-4 required">
				{{ html()->label(__('labels.customer.profile.first_name'))->class('col-md-2 col-form-label') }}
				<div class="col-md-4">
					{{ html()->input()
						->class('form-control')
						->attribute('maxlength', 191)
						->name('first_name')
						->value($logged_in_user->first_name)
						->required() }}
				</div>
			</div><!--form-group-->

			<div class="form-group row pt-2 required">
				{{ html()->label(__('labels.customer.profile.last_name'))->class('col-md-2 col-form-label') }}
				<div class="col-md-4">
					{{ html()->input()
						->class('form-control')
						->attribute('maxlength', 191)
						->name('last_name')
						->value($logged_in_user->last_name)
						->required() }}
				</div>
			</div><!--form-group-->

			<div class="form-group row pt-2">
				{{ html()->label(__('labels.customer.profile.email'))->class('col-md-2 col-form-label') }}
				<div class="col-md-4">
					{{ html()->input()
						->class('form-control')
						->attributes(['maxlength' => 191, 'readonly'])
						->name('email')
						->value($logged_in_user->email)
						->required() }}
				</div>
			</div><!--form-group-->

			<div class="form-group row pt-2">
				{{ html()->label(__('labels.customer.profile.customer_name'))->class('col-md-2 col-form-label') }}
				<div class="col-md-4">
					{{ html()->input()
						->class('form-control')
						->attributes(['maxlength' => 191])
						->name('customer_name')
						->value($logged_in_user->customer->customer_name)
					}}
				</div>
			</div><!--form-group-->

			<div class="form-group row pt-2">
				{{ html()->label(__('labels.customer.profile.customer_city'))->class('col-md-2 col-form-label') }}
				<div class="col-md-4">
					{{ html()->input()
						->class('form-control')
						->attribute('maxlength', 191)
						->name('customer_city')
						->value($logged_in_user->customer->customer_city)
					}}
				</div>
			</div><!--form-group-->

			<div class="form-group row pt-2">
				{{ html()->label(__('labels.customer.profile.customer_address'))->class('col-md-2 col-form-label') }}
				<div class="col-md-4">
					{{ html()->input()
						->class('form-control')
						->attribute('maxlength', 191)
						->name('customer_address')
						->value($logged_in_user->customer->customer_address)
					}}
				</div>
			</div><!--form-group-->

			<div class="form-group row pt-2 required">
				{{ html()->label(__('labels.customer.profile.mobile'))->class('col-md-2 col-form-label') }}
				<div class="col-md-4">
					{{ html()->input()
						->class('form-control')
						->attribute('maxlength', 191)
						->name('mobile')
						->value($logged_in_user->mobile)
						->required() }}
				</div>
			</div><!--form-group-->

			<div class="form-group row mt-4">
				<div class="col-md-6">
					{{ form_submit(__('labels.general.buttons.update')) }}
				</div>
			</div>

		{{ html()->closeModelForm() }}
	</div>
</div>

@endsection
