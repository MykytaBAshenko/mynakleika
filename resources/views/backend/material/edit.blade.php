@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.material.edit'))

@section('content')
        
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="card-title mb-3">
                    {{ __('strings.backend.material.edit') }} 
                </h3>
            </div><!--col-->
        </div><!--row-->

        {{ html()->modelForm($material, 'PATCH', route('admin.material.update', $material))->class('form-horizontal')->open() }}
            <div class="row mt-4">
                <div class="col col-sm-6">
                    <div class="form-group">
                        {{ html()->label(__('labels.backend.material.name')) }}
                        {{ html()->input()
                            ->class('form-control')
                            ->attribute('maxlength', 191)
                            ->name('material_name')
                            ->value($material->material_name)
                            ->required() }}
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
                            ->value($material->material_ref) }}
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
                            ->value($material->material_price)
                            ->required() }}
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->

            <div class="row">
                <div class="col col-sm-6">
                    <div class="form-group">
                        {{ html()->label(__('labels.backend.material.status')) }}

                        {{ html()->select()
                            ->class('form-control')
                            ->name('in_stock')
                            ->options(['0' => __('labels.general.no'), 
                                       '1' => __('labels.general.yes')])
                            ->value($material->in_stock) }}
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->
            <div class="row mt-4">
                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.layout_width')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('layoutW')
                        ->value($material['layoutW'])
                        ->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.layout_height')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('layoutH')
                        ->value($material['layoutH'])
                        ->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.fieldW')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('fieldW')
                        ->value($material['fieldW'])
                        ->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.fieldH')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('fieldH')
                        ->value($material['fieldH'])
                        ->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.bleed')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('bleed')
                        ->value($material['bleed'])
                        ->required() }}
                </div><!--form-group-->

                <div class="row mt-4">
                    <div class="form-group col">
                        <h4 class="card-title mb-3">{{ "cost_printing" }}</h4>
                        
                        <table class="table">
                            <tr>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach(json_decode($material['cost_printing']) as $key => $value)
                                    <th>
                                    {{ html()->input()
                                        ->class('form-control')
                                        ->name('cost_printing_keys['.$counter.']')
                                        ->value($key)
                                        ->required() }}</th>
                                    @php
                                        $counter++;
                                    @endphp
                                @endforeach
                            </tr>
    
                            <tr>
                                @php
                                $counter = 1;
                            @endphp
                                @foreach(json_decode($material['cost_printing']) as $key => $value)
                                    <td>
                                  
                                        {{ html()->input()
                                            ->class('form-control')
                                            ->name('cost_printing_values['.$counter.']')
                                            ->value($value)
                                            ->required() }}
                                        @php
                                            $counter++;
                                        @endphp
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    </div><!--col-->
                </div><!--row-->

                <div class="row mt-4">
                    <div class="form-group col">
                        <h4 class="card-title mb-3">{{ "cost_cut" }}</h4>
                        
                        <table class="table">
                            <tr>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach(json_decode($material['cost_cut']) as $key => $value)
                                    <th>
                                    {{ html()->input()
                                        ->class('form-control')
                                        ->name('cost_cut_keys['.$counter.']')
                                        ->value($key)
                                        ->required() }}</th>
                                    @php
                                        $counter++;
                                    @endphp
                                @endforeach
                            </tr>
    
                            <tr>
                                @php
                                $counter = 1;
                            @endphp
                                @foreach(json_decode($material['cost_cut']) as $key => $value)
                                    <td>
                                  
                                        {{ html()->input()
                                            ->class('form-control')
                                            ->name('cost_cut_values['.$counter.']')
                                            ->value($value)
                                            ->required() }}
                                        @php
                                            $counter++;
                                        @endphp
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    </div><!--col-->
                </div>
                <div class="row mt-4">
                    <div class="form-group col">
                        <h4 class="card-title mb-3">{{ "quantity_factor" }}</h4>
                        
                        <table class="table">
                            <tr>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach(json_decode($material['quantity_factor']) as $key => $value)
                                    <th>
                                    {{ html()->input()
                                        ->class('form-control')
                                        ->name('quantity_factor_keys['.$counter.']')
                                        ->value($key)
                                        ->required() }}</th>
                                    @php
                                        $counter++;
                                    @endphp
                                @endforeach
                            </tr>
    
                            <tr>
                                @php
                                $counter = 1;
                            @endphp
                                @foreach(json_decode($material['quantity_factor']) as $key => $value)
                                    <td>
                                  
                                        {{ html()->input()
                                            ->class('form-control')
                                            ->name('quantity_factor_values['.$counter.']')
                                            ->value($value)
                                            ->required() }}
                                        @php
                                            $counter++;
                                        @endphp
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    </div><!--col-->
                </div>
                <div class="row mt-4">
                    <div class="form-group col">
                        <h4 class="card-title mb-3">{{ "mat_glanec_covering (matovia snachala, a potom glanec)" }}</h4>
                        
                        <table class="table">
                            <tr>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach(json_decode($material['mat_glanec_covering']) as $key => $value)
                                    <th>
                                    {{ html()->input()
                                        ->class('form-control')
                                        ->name('mat_glanec_covering_keys['.$counter.']')
                                        ->value($key)
                                        ->required() }}</th>
                                    @php
                                        $counter++;
                                    @endphp
                                @endforeach
                            </tr>
    
                            <tr>
                                @php
                                $counter = 1;
                            @endphp
                                @foreach(json_decode($material['mat_glanec_covering']) as $key => $value)
                                    <td>
                                  
                                        {{ html()->input()
                                            ->class('form-control')
                                            ->name('mat_glanec_covering_mat_values['.$counter.']')
                                            ->value($value[0])
                                            ->required() }}
                                        @php
                                            $counter++;
                                        @endphp
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                @php
                                $counter = 1;
                            @endphp
                                @foreach(json_decode($material['mat_glanec_covering']) as $key => $value)
                                    <td>
                                  
                                        {{ html()->input()
                                            ->class('form-control')
                                            ->name('mat_glanec_covering_glanec_values['.$counter.']')
                                            ->value($value[1])
                                            ->required() }}
                                        @php
                                            $counter++;
                                        @endphp
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    </div><!--col-->
                </div>
            </div><!--row-->
            <div class="row">
                <div class="col col-sm-3">
                    {{ form_cancel(route('admin.material.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col col-sm-3 text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--row-->
            </div><!--row-->
        {{ html()->closeModelForm() }}

    </div><!--card-body-->
</div><!--card-->
        
@endsection
