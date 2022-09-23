@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .m-0 {
            margin: 0;
        }
        .mb-4 {
            margin-bottom: 20px;
        }
        .p-4 {
            padding: 20px;
        }
    </style>
@stop

@section('page_title', 'Настройки доставки')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-download"></i>
        Настройки доставки
    </h1>
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                @include('voyager::alerts')

                <div class="panel panel-bordered">
                    <div class="panel-heading p-4">
                        <h4 class="m-0">Настройки доставки</h4>
                    </div>
                    <div class="panel-body">

                        <form action="{{ route('voyager.delivery_settings.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="delivery_price">Стоимость доставки</label>
                                <input type="number" name="price" id="delivery_price" class="form-control" value="{{ old('price') ?? $standard->price }}">
                                @error('price')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="delivery_order_min_price">Минимальная стоимость заказа для бесплатной доставки</label>
                                <input type="number" name="order_min_price" id="delivery_order_min_price" class="form-control" value="{{ old('order_min_price') ?? $free->order_min_price }}">
                                @error('order_min_price')
                                <div class="text-danger">
                                    <small>{{ $message }}</small>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" type="submit">Сохранить</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

@stop

@section('javascript')
    <script></script>
@stop
