@extends('layout')

@section('title')
    Рейс {from} - {to}
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
                            <ul class="pl-3">
                                <li>г. Москва, ул. Пушкина, дом 2</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right">Точки выгрузки</td>
                        <td>
                            <ul class="pl-3">
                                <li>Казань, ул. Татарского названия, дом 3</li>
                                <li>Елабуга, ул. Казанская, дом 80</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right">Время погрузки</td>
                        <td>19.10.2019 &ndash; 09:20</td>
                    </tr>
                    <tr>
                        <th class="text-right">Время выгрузки</th>
                        <td>20.10.2019 &ndash; 19:20</td>
                    </tr>
                    <tr>
                        <th class="text-right">Расстояние</th>
                        <td>1 202 км</td>
                    </tr>
                    <tr>
                        <th class="text-right">Тип груза</th>
                        <td>Тяжёлый</td>
                    </tr>
                    <tr>
                        <th class="text-right">Вес</th>
                        <td>20 т</td>
                    </tr>
                    <tr>
                        <th class="text-right">Длина</th>
                        <td>14 м</td>
                    </tr>
                    <tr>
                        <th class="text-right">Бюджет</th>
                        <td>46 000 ₽</td>
                    </tr>
                </tbody>
            </table>
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