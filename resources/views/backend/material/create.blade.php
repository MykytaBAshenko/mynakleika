@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.material.create'))

@section('content')
        
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="card-title mb-3">
                    {{ __('strings.backend.material.create') }} 
                </h3>
            </div><!--col-->
        </div><!--row-->

        {{ html()->form('POST', route('admin.material.store'))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
            <div class="row mt-4">
                <div class="col col-sm-6">
                    <div class="form-group">
                        {{ html()->label(__('labels.backend.material.name')) }}

                        {{ html()->input()
                            ->class('form-control')
                            ->attribute('maxlength', 191)
                            ->name('material_name')
                            ->required()
                            ->autofocus() }}
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->

            <div class="row">
                <div class="col col-sm-6">
                    <div class="form-group">
                        {{ html()->label(__('labels.backend.material.reference')) }}

                        {{ html()->textarea()
                            ->class('form-control')
                            ->name('material_ref')
                            ->autofocus() }}
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->

            <div class="row">
                <div class="col col-sm-6">
                    <div class="form-group">
                        {{ html()->label(__('labels.backend.material.price')) }}

                        {{ html()->input()
                            ->class('form-control')
                            ->name('material_price')
                            ->required()
                            ->autofocus() }}
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->
            <div class="row mt-4">
                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.layout_width')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('layoutW')
                        ->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.layout_height')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('layoutH')
                        ->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.fieldW')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('fieldW')
                        ->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.fieldH')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('fieldH')
                        ->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.bleed')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('bleed')
                        ->required() }}
                </div><!--form-group-->
            </div><!--row-->
            <div class="row">
                <div class="col col-sm-6">
                    <div class="form-group mb-0 clearfix">
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->
        {{ html()->form()->close() }}

    </div><!--card-body-->
</div><!--card-->
        
@endsection