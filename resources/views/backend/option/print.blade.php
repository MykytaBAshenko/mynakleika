@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.options.print'))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="card-title mb-3">
                    {{ __('strings.backend.options.print') }}
                </h3>
            </div><!--col-->
        </div><!--row-->

        {{ html()->modelForm($option, 'PATCH', route('admin.option.update'))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
            <div class="row mt-4">
                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.layout_width')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('layoutW')
                        ->value($option['layoutW'])
                        ->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.layout_height')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('layoutH')
                        ->value($option['layoutH'])
                        ->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.fieldW')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('fieldW')
                        ->value($option['fieldW'])
                        ->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.fieldH')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('fieldH')
                        ->value($option['fieldH'])
                        ->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.bleed')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('bleed')
                        ->value($option['bleed'])
                        ->required() }}
                </div><!--form-group-->
            </div><!--row-->

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group mb-0 clearfix">
                        {{ form_submit(__('buttons.general.crud.update')) }}
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->
        {{ html()->closeModelForm() }}

    </div><!--card-body-->
</div><!--card-->
@endsection
