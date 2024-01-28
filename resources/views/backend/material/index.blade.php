@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.material.title'))

@section('content')
        
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="card-title mb-3">
                    {{ __('strings.backend.material.title') }} 
                </h3>
            </div><!--col-->
            <div class="col-sm-6">
                <a href="{{ route('admin.material.create') }}" class="btn btn-success float-sm-right">
                    <i class="fas fa-plus-circle"></i>
                    &nbsp;{{ __('buttons.general.create_new') }}
                </a>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('labels.backend.material.name') }}</th>
                            <th class="text-center">{{ __('labels.backend.material.reference') }}</th>
                            <th class="text-center">{{ __('labels.backend.material.price') }}</th>
                            <th class="text-center">{{ __('labels.backend.material.status') }}</th>
                            <th class="text-center" colspan="2">{{ __('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($materials as $entry)
                        <tr>
                            <td>{{ $entry->material_name }}</td>
                            <td class="text-center">{{ "layoutW - " . $entry->layoutW . " | layoutH - " . $entry->layoutH . " | fieldW - " . $entry->fieldW . " | fieldH - " . $entry->fieldH . " | bleed - " . $entry->bleed . " | minW - " . $entry->minW . " | minH - " . $entry->minH }}</td>
                            <td class="text-center">{{ $entry->material_price }}</td>
                            <td class="text-center">{!! $entry->status_label !!}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group" arial-label="User Actions">
                                    <a href="{{ route('admin.material.edit', $entry) }}" class="btn btn-primary" role="button">
                                        <i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="{{ __('buttons.general.crud.edit') }}"></i>
                                    </a>
                                    
                                    {{ html()->form('DELETE', route('admin.material.destroy', $entry))->open() }}
                                        {{ form_submit('')
                                            ->child('<i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title=' . __('buttons.general.crud.delete') . '></i>')
                                            ->attributes(['class'=>'btn btn-danger'])
                                        }}
                                    {{ html()->form()->close() }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>  
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
        
@endsection
