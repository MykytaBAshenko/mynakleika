@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.options.cost'))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="card-title mb-3">
                    {{ __('strings.backend.options.cost') }}
                </h3>
            </div><!--col-->
        </div><!--row-->
        {{ html()->modelForm($option, 'PATCH', route('admin.option.update'))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
        <div class="row mt-4">
                <div class="form-group col-sm-6">
                    {{ html()->label(__('labels.backend.print_option.euro_currency')) }}

                    {{ html()->input()
                        ->class('form-control')
                        ->name('euro_currency')
                        ->value($option['euro_currency'])
                        ->required() }}
                </div><!--form-group-->

            </div><!--row-->
            <div class="row mt-4">
                <div class="form-group col">
                    <h4 class="card-title mb-3">{{ "speed_index" }}</h4>
                    {{ html()->label(__('labels.backend.print_option.print_cost_color')) }}
                    <table class="table">
                       
                        <tr>
                            @php
                            $counter = 1;
                        @endphp
                            @foreach(json_decode($option['speed_index']) as $key => $value)
                                <td>
                              
                                    {{ html()->input()
                                        ->class('form-control')
                                        ->name('speed_index_keys['.$counter.']')
                                        ->value($key)
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
                            @foreach(json_decode($option['speed_index']) as $key => $value)
                                <td>
                              
                                    {{ html()->input()
                                        ->class('form-control')
                                        ->name('speed_index_values['.$counter.']')
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

            {{-- <div class="row">
                <div class="form-group col">
                    <h4 class="card-title mb-3">{{ "Индекс увелечение стоимости за количество елементов" }}</h4>
                    {{ html()->label(__('labels.backend.print_option.print_cost_color')) }}
                    <table class="table">
                        <tr>
                            @foreach(json_decode($option['print_cost_customer_bw']) as $key => $value)
                                <th>{{$key}}</th>
                            @endforeach
                        </tr>

                        <tr>
                            @foreach(json_decode($option['print_cost_customer_bw']) as $key => $value)
                                <td>
                                    {{ html()->input()
                                        ->class('form-control')
                                        ->name('print_cost_customer_bw['.$key.']')
                                        ->value($value)
                                        ->required() }}
                                </td>
                            @endforeach
                        </tr>
                    </table>
                </div><!--form-group-->
            </div><!--row--> --}}

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
