@extends('frontend.layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">
            <div class="container">
                <div class="row bg-success mb-4 p-2 px-3">
                    <span class="material-icons-outlined text-white align-middle pr-2">info</span>
                    Оплата прошла успешно
                </div>
                <div class="row">
                    <p>Список оплаченных заказов:</p>
                </div>
                @foreach ($orders as $order)
                    <div class="row border-bottom border-light bg-gray-100 py-2 font-sm">
                        <div class="col">{{ $order->id }}</div>
                        <div class="col">{{ $order->order_ref }}</div>
                        <div class="col">{{ \App\Helpers\General\MoneyHelper::toString($order->cost) .' грн' }}</div>
                    </div>
                @endforeach
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
