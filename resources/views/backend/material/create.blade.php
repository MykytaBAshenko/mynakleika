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
                            ->value(1)->required()
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
                            ->value(1)->required()
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
                        ->value(1)->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.layout_height')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('layoutH')
                        ->value(1)->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.fieldW')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('fieldW')
                        ->value(1)->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.fieldH')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('fieldH')
                        ->value(1)->required() }}
                </div><!--form-group-->

                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.bleed')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('bleed')
                        ->value(1)->required() }}
                </div><!--form-group-->
            </div><!--row-->
            <div style="background-color: red; padding: 70px 0; font-size: 40px; color: white;">
                        ЦЫФРЫ ИНДЕКСАЦИИ НЕ ДОЛЖНЫ ПОВТОРЯТЬСЯ (1,2,3,4,5,6,7,8)
                        <br/>
                        ИНЧЕ ТАБЛИЦА СЛОМАТЬСЯ
            </div>
            <div class="row mt-4">
                    <div class="form-group col">
                        <h4 class="card-title mb-3">{{ "cost_printing" }}</h4>
                        
                        <table class="table">
                            <tr>
                            @php
                                $counter = 1;
                                $max_fields = 8;
                            @endphp
                                   @for ($i = 0; $i < $max_fields; $i++)
                                    <td>
                                  
                                    {{ html()->input()
                                        ->class('form-control')
                                        ->name('cost_printing_keys['.$counter.']')
                                        ->value($counter)->required() }}</th>
                                    @php
                                        $counter++;
                                    @endphp
                                    @endfor

                            </tr>
    
                            <tr>
                                @php
                                $counter = 1;
                                $max_fields = 8;
                            @endphp
                                @for ($i = 0; $i < $max_fields; $i++)
                                    <td>
                                  
                                        {{ html()->input()
                                            ->class('form-control')
                                            ->name('cost_printing_values['.$counter.']')
                                            ->value($counter)->required() }}
                                        @php
                                            $counter++;
                                        @endphp
                                    </td>
                                    @endfor
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
                                $max_fields = 8;
                            @endphp
                                   @for ($i = 0; $i < $max_fields; $i++)
                                    <td>
                                  
                                    {{ html()->input()
                                        ->class('form-control')
                                        ->name('cost_cut_keys['.$counter.']')
                                        ->value($counter)->required() }}</th>
                                    @php
                                        $counter++;
                                    @endphp
                                    @endfor

                            </tr>
    
                            <tr>
                                @php
                                $counter = 1;
                                $max_fields = 8;
                            @endphp
                                @for ($i = 0; $i < $max_fields; $i++)
                                    <td>
                                  
                                        {{ html()->input()
                                            ->class('form-control')
                                            ->name('cost_cut_values['.$counter.']')
                                            ->value($counter)->required() }}
                                        @php
                                            $counter++;
                                        @endphp
                                    </td>
                                    @endfor
                            </tr>
                        </table>
                    </div><!--col-->
                </div><!--row-->


                <div class="row mt-4">
                    <div class="form-group col">
                        <h4 class="card-title mb-3">{{ "quantity_factor" }}</h4>
                        
                        <table class="table">
                            <tr>
                            @php
                                $counter = 1;
                                $max_fields = 8;
                            @endphp
                                   @for ($i = 0; $i < $max_fields; $i++)
                                    <td>
                                  
                                    {{ html()->input()
                                        ->class('form-control')
                                        ->name('quantity_factor_keys['.$counter.']')
                                        ->value($counter)->required() }}</th>
                                    @php
                                        $counter++;
                                    @endphp
                                    @endfor

                            </tr>
    
                            <tr>
                                @php
                                $counter = 1;
                                $max_fields = 8;
                            @endphp
                                @for ($i = 0; $i < $max_fields; $i++)
                                    <td>
                                  
                                        {{ html()->input()
                                            ->class('form-control')
                                            ->name('quantity_factor_values['.$counter.']')
                                            ->value($counter)->required() }}
                                        @php
                                            $counter++;
                                        @endphp
                                    </td>
                                    @endfor
                            </tr>
                        </table>
                    </div><!--col-->
                </div><!--row-->

                <div class="row mt-4">
                    <div class="form-group col">
                    <h4 class="card-title mb-3">{{ "mat_glanec_covering (matovia snachala, a potom glanec)" }}</h4>
                        
                        <table class="table">
                            <tr>
                            @php
                                $counter = 1;
                                $max_fields = 8;
                            @endphp
                                   @for ($i = 0; $i < $max_fields; $i++)
                                    <td>
                                  
                                    {{ html()->input()
                                        ->class('form-control')
                                        ->name('mat_glanec_covering_keys['.$counter.']')
                                        
                                        ->value($counter)->required() }}</th>
                                    @php
                                        $counter++;
                                    @endphp
                                    @endfor

                            </tr>
    
                            <tr>
                                @php
                                $counter = 1;
                                $max_fields = 8;
                            @endphp
                                @for ($i = 0; $i < $max_fields; $i++)
                                    <td>
                                  
                                        {{ html()->input()
                                            ->class('form-control')
                                            ->name('mat_glanec_covering_mat_values['.$counter.']')
                                            
                                            ->value($counter)->required() }}
                                        @php
                                            $counter++;
                                        @endphp
                                    </td>
                                    @endfor
                            </tr>

                            <tr>
                                @php
                                $counter = 1;
                                $max_fields = 8;
                            @endphp
                                @for ($i = 0; $i < $max_fields; $i++)
                                    <td>
                                  
                                        {{ html()->input()
                                            ->class('form-control')
                                            ->name('mat_glanec_covering_glanec_values['.$counter.']')
                                            
                                            ->value($counter)->required() }}
                                        @php
                                            $counter++;
                                        @endphp
                                    </td>
                                    @endfor
                            </tr>
                        </table>
                    </div><!--col-->
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