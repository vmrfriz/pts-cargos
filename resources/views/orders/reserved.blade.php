@extends('layout')

@section('title')
    Резервирование заявки
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="bg-white rounded-lg p-3">
            <h5>Информация из заявки</h5>
            <hr>
            <table class="table table-sm table-responsive-lg table-borderless">
                <tbody>
                    <tr>
                        <th class="text-right">Точки погрузки</td>
                        <td>
                            <ul class="pl-3 mb-0">
                            @foreach($order['load_points'] as $point)
                                <li>{{ $point }}</li>
                            @endforeach
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right">Точки выгрузки</td>
                        <td>
                            <ul class="pl-3 mb-0">
                            @foreach($order['unload_points'] as $point)
                                <li>{{ $point }}</li>
                            @endforeach
                            </ul>
                        </td>
                    </tr>
                    @if(!is_null($order['load_points']))
                    <tr>
                        <th class="text-right">Время погрузки</td>
                        <td>{!! DateTime::createFromFormat('Y-m-d H:i:s', $order['loading_time'])->format('d.m.Y &\n\d\a\s\h; H:i') !!}</td>
                    </tr>
                    @endif
                    @if(!is_null($order['unload_points']))
                    <tr>
                        <th class="text-right">Время выгрузки</th>
                        <td>{!! DateTime::createFromFormat('Y-m-d H:i:s', $order['unloading_time'])->format('d.m.Y &\n\d\a\s\h; H:i') !!}</td>
                    </tr>
                    @endif
                    @if(!is_null($order['distance']))
                    <tr>
                        <th class="text-right">Расстояние</th>
                        <td>? км</td>
                    </tr>
                    @endif
                    @if(!is_null($order['cargo_type']))
                    <tr>
                        <th class="text-right">Тип груза</th>
                        <td>{{ $order['cargo_type'] }}</td>
                    </tr>
                    @endif
                    @if(!is_null($order['weight']))
                    <tr>
                        <th class="text-right">Вес</th>
                        <td>{{ $order['weight'] }} т</td>
                    </tr>
                    @endif
                    @if(!is_null($order['length']))
                    <tr>
                        <th class="text-right">Длина</th>
                        <td>{{ $order['length'] }} м</td>
                    </tr>
                    @endif
                    @if($order['price'])
                    <tr>
                        <th class="text-right">Бюджет</th>
                        <td>{{ number_format($order['price'], 0, '.', ' ') }} ₽</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            @auth
            <div class="row">
                <div class="col text-right">
                    <a href="{{ $_SERVER['REQUEST_URI'] }}/edit" class="btn btn-outline-primary">Изменить</a>
                </div>
                <div class="col text-left">
                    <form action="{{ $_SERVER['REQUEST_URI'] }}" method="POST" onsubmit="confirm('Вы действительно хотите удалить заявку?') || event.preventDefault()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">Удалить</button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="bg-white rounded-lg p-3">
            <h5>Бронирование</h5>
            <hr>
            <p>Ваш запрос на бронирование принят в обработку нашими менеджерами. Ожидайте, с Вами свяжутся в ближайшее время.</p>
        </div>
    </div>
</div>
@endsection