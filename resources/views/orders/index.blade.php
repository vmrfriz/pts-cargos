@extends('layout')

@section('title')
Грузы от ПромТранспортСервис
@endsection

@section('content')
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
        <tr>
            <td>Москва - Санкт-Петербург</td>
            <td>ТНП</td>
            <td>23.10.2019 &ndash; 12:30</td>
            <td class="text-right" style="line-height:1em">37 000 ₽<br><small class="text-muted">37,6 ₽/км</small></td>
            <td class="text-right"><a href="/atrucks/kj2nj-23d42-23d42-dcvw4-ewvf2" class="btn btn-sm btn-outline-primary">Просмотреть</a></td>
        </tr>
    </tbody>
</table>
@endsection
