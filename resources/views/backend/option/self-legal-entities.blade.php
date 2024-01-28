@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.options.self-legal-entities'))

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="card-title mb-3">
                        {{ __('strings.backend.options.self-legal-entities') }}
                    </h3>
                </div><!--col-->
            </div><!--row-->
            {{ html()->modelForm($options, 'PATCH', route('admin.option.update'))
                ->class('form-horizontal')
                ->attribute('enctype', 'multipart/form-data')
                ->open()
            }}
            <div class="row">
                <div class="col-sm-6">
                    <h4>ТОВ</h4>
                    <div class="form-group">
                        {{ html()->label('Название') }}

                        {{ html()->input()
                            ->class('form-control')
                            ->name('tov[name]')
                            ->value($options['tov']['name'])
                            ->required() }}
                    </div>
                    <div class="form-group">
                        {{ html()->label('Краткое название') }}

                        {{ html()->input()
                            ->class('form-control')
                            ->name('tov[alias]')
                            ->value($options['tov']['alias'])
                            ->required() }}
                    </div>
                    <div class="form-group">
                        {{ html()->label('ИПН') }}

                        {{ html()->input()
                            ->class('form-control')
                            ->name('tov[ipn]')
                            ->value($options['tov']['ipn'])
                            ->required() }}
                    </div>
                    <div class="form-group">
                        {{ html()->label('Код ЄДРПОУ') }}

                        {{ html()->input()
                            ->class('form-control')
                            ->name('tov[edrpou]')
                            ->value($options['tov']['edrpou'])
                            ->required() }}
                    </div>
                    <div class="form-group">
                        {{ html()->label('Номер свидетельства НДС') }}

                        {{ html()->input()
                            ->class('form-control')
                            ->name('tov[nds_payer_num]')
                            ->value($options['tov']['nds_payer_num'])
                            ->required() }}
                    </div>
                    <div class="form-group">
                        {{ html()->label('Банк') }}

                        {{ html()->input()
                            ->class('form-control')
                            ->name('tov[bank_name]')
                            ->value($options['tov']['bank_name'])
                            ->required() }}
                    </div>
                    <div class="form-group">
                        {{ html()->label('Расчетный Счет') }}

                        {{ html()->input()
                            ->class('form-control')
                            ->name('tov[bank_account]')
                            ->value($options['tov']['bank_account'])
                            ->required() }}
                    </div>
                    <div class="form-group">
                        {{ html()->label('Адрес') }}

                        {{ html()->input()
                            ->class('form-control')
                            ->name('tov[address]')
                            ->value($options['tov']['address'])
                            ->required() }}
                    </div>
                    <div class="form-group">
                        {{ html()->label('Телефон') }}

                        {{ html()->input()
                            ->class('form-control')
                            ->name('tov[tel]')
                            ->value($options['tov']['tel'])
                            ->required() }}
                    </div>
                </div>
                <div class="col-sm-6">
                    <h4>ФОП</h4>
                    <div class="form-group">
                        {{ html()->label('Название') }}

                        {{ html()->input()
                            ->class('form-control')
                            ->name('fop[name]')
                            ->value($options['fop']['name'])
                            ->required() }}
                    </div>
                    <div class="form-group">
                        {{ html()->label('Краткое название') }}

                        {{ html()->input()
                            ->class('form-control')
                            ->name('fop[alias]')
                            ->value($options['fop']['alias'])
                            ->required() }}
                    </div>
                    <div class="form-group">
                        {{ html()->label('ИПН') }}

                        {{ html()->input()
                            ->class('form-control')
                            ->name('fop[ipn]')
                            ->value($options['fop']['ipn'])
                            ->required() }}
                    </div>

                    <div class="form-group">
                        {{ html()->label('Адрес') }}

                        {{ html()->input()
                            ->class('form-control')
                            ->name('fop[address]')
                            ->value($options['fop']['address'])
                            ->required() }}
                    </div>
                    <div class="form-group">
                        {{ html()->label('Телефон') }}

                        {{ html()->input()
                            ->class('form-control')
                            ->name('fop[tel]')
                            ->value($options['fop']['tel'])
                            ->required() }}
                    </div>
                </div>
            </div>
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
