@extends('frontend.layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">
            <div class="container">
                <div class="row bg-danger mb-4 p-2 px-3">
                    <span class="material-icons-outlined text-white align-middle pr-2">info</span>
                    Оплата отклонена
                </div>

                <div class="row mt-4">
                    <a href="/customer/" class="btn btn-primary " role="button">
                        <span class="material-icons-outlined text-white align-middle pr-2">logout</span>
                        Вернутся в кабинет
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
