@extends('layout')

@section('title')
    Ред.: {{ implode(' - ', array_merge($order->load_points, $order->unload_points)) }}
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
                            @foreach($order->load_points as $point)
                                @if(old('load_points')[$loop->index] == '' && $point == '')
                                    @continue
                                @endif
                                <input id="load_points" class="form-control form-control-sm mb-2 {{ $errors->has('load_points') ? 'is-invalid' : '' }}" type="text" name="load_points[]" value="{{ old('load_points')[$loop->index] ?: $point }}" required="required">
                            @endforeach
                            <input class="form-control form-control-sm mb-2 js-new-input opacity-50" type="text" name="load_points[]">
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right">Точки выгрузки</td>
                        <td>
                            @foreach($order->unload_points as $point)
                                @if(old('unload_points')[$loop->index] == '' && $point == '')
                                    @continue
                                @endif
                                <input id="unload_points" class="form-control form-control-sm mb-2 {{ $errors->has('unload_points') ? 'is-invalid' : '' }}" type="text" name="unload_points[]" value="{{ old('unload_points')[$loop->index] ?: $point }}" required="required">
                            @endforeach
                            <input class="form-control form-control-sm mb-2 js-new-input opacity-50" type="text" name="unload_points[]">
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right">Время погрузки</td>
                        <td><input type="text" class="form-control form-control-sm d-inline-block" size="25" style="width:auto" name="loading_time" value="{!! DateTime::createFromFormat('Y-m-d H:i:s', $order->loading_time)->format('d.m.Y &\n\d\a\s\h; H:i') !!}"></td>
                    </tr>
                    <tr>
                        <th class="text-right">Время выгрузки</th>
                        <td><input type="text" class="form-control form-control-sm d-inline-block" size="25" style="width:auto" name="unloading_time" value="{!! DateTime::createFromFormat('Y-m-d H:i:s', $order->unloading_time)->format('d.m.Y &\n\d\a\s\h; H:i') !!}"></td>
                    </tr>
                    <tr>
                        <th class="text-right">Расстояние</th>
                        <td><input type="text" class="form-control form-control-sm d-inline-block" size="7" style="width:auto" name="distance" value="" readonly="readonly"> км</td>
                    </tr>
                    <tr>
                        <th class="text-right">Тип груза</th>
                        <td><input type="text" class="form-control form-control-sm d-inline-block" size="25" style="width:auto" name="cargo_type" value="{{ $order->cargo_type }}"></td>
                    </tr>
                    <tr>
                        <th class="text-right">Вес</th>
                        <td><input type="text" class="form-control form-control-sm d-inline-block" size="7" style="width:auto" name="weight" value="{{ $order->weight }}"> т</td>
                    </tr>
                    <tr>
                        <th class="text-right">Длина</th>
                        <td><input type="text" class="form-control form-control-sm d-inline-block" size="7" style="width:auto" name="length" value="{{ $order->length }}"> м</td>
                    </tr>
                    <tr>
                        <th class="text-right">Бюджет</th>
                        <td><input type="text" class="form-control form-control-sm d-inline-block" size="7" style="width:auto" name="price" value="{{ $order->price }}"> ₽</td>
                    </tr>
                </tbody>
            </table>

            {{-- @auth --}}
            <div class="row">
                <div class="col text-right">
                    <form action="{{ substr($_SERVER['REQUEST_URI'], 0, -5) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-outline-danger">Сохранить</button>
                    </form>
                </div>
                <div class="col text-left">
                    <a href="{{ substr($_SERVER['REQUEST_URI'], 0, -5) }}" class="btn btn-outline-primary">Отмена</a>
                </div>
            </div>
            {{-- @endif --}}
        </div>
    </div>
    <div class="col-md-6">
        <div class="bg-white rounded-lg p-3">
            <h5>Бронирование</h5>
            <hr>
            <form action="{{ Request::url() }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="company_inn">ИНН компании</label>
                    <input id="company_inn" class="form-control mask-inn" type="text" name="company_inn" required="required">
                </div>
                <div class="form-group">
                    <label for="phone">Номер телефона</label>
                    <input id="phone" class="form-control mask-phone" type="text" name="phone" required="required">
                </div>
                <div class="row mt-4">
                    <div class="col-12 col-md-5 mb-3">
                        <input type="submit" class="btn btn-primary w-100" name="reservation" value="Забронировать" onclick="this.form.querySelector('#new-price').required = false">
                    </div>
                    <div class="d-md-none text-center col-12 mb-3">или</div>
                    <div class="col-12 col-md-7 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control border-danger mask-money" placeholder="Предложить сумму" aria-label="Предложить сумму" aria-describedby="button-reserve" id="new-price" name="new-price" required="required">
                            <div class="input-group-append">
                                <input class="btn btn-danger" type="submit" id="button-reserve" name="counter-offer" value="Запросить">
                            </div>
                        </div>
                        <div style="font-size: 11px">в случае запроса суммы, гарантия своевременного бронирования груза снижается, а время ожидания увеличивается</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection