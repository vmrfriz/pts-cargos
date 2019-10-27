@extends('layout')

@section('title')
Грузы от ПромТранспортСервис
@endsection

@section('content')
@if($orders ?? false)
<table class="table table-responsive-lg mb-0 bg-white rounded-lg overflow-hidden">
    <thead>
        <tr class="font-weight-bold">
            <td class="border-top-0">Направление</td>
            <td class="border-top-0">Тип груза</td>
            <td class="border-top-0">Погрузка</td>
            <td class="border-top-0 text-right">Оплата</td>
            <td class="border-top-0 text-right">Действие</td>
        </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        {{-- {{ dd($order['unload_points']) }} --}}
        <tr>
            <td>
                {{ $order['load_points'][0] }}
                @if(count((array) $order['load_points']) > 1)
                <span class="badge badge-info">+{{ count((array) $order['load_points']) - 1 }}</span>
                @endif

                &ndash;

                {{ array_slice((array) $order['unload_points'], -1)[0] }}
                @if(count((array) $order['unload_points']) > 1)
                    <span class="badge badge-info">+{{ count((array) $order['unload_points']) - 1 }}</span>
                @endif
            </td>
            <td>{{ $order['cargo_type'] }}</td>
            {{-- <td>{!! DateTime::createFromFormat('Y-m-d H:i:s', $order['loading_time'])['format']('d.m.Y &\n\d\a\s\h; H:i') !!}</td> --}}
            <td class="text-right" style="line-height:1em">
                {{ number_format($order['price'], 0, '.', ' ') }} ₽
                <br>
                {{-- <small class="text-muted">{{ number_format($order['price'] / $order['distance'], 1, '.', ' ') }} ₽/км</small></td> --}}
            <td class="text-right">
                <a href="/{{ is_int($order['id']) ? 'id' : '' }}{{ $order['id'] }}" class="btn btn-sm btn-outline-primary">Просмотреть</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@else
<div class="text-center h4 text-muted py-5">Пусто, пока что</div>
@endif
@endsection
