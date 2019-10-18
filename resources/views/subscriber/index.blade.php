@extends('layout')

@section('title')
    Подписаться
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="/subscribe" method="POST">
            @csrf
            @method('PUT')

            <h5>О компании</h5>
            <div class="border p-3 mb-4">
                <input type="text" class="form-control mb-3" name="company_name" id="company_name" required>
                <input type="text" class="form-control mb-3" name="company_inn" id="company_inn" required>
                <input type="text" class="form-control mb-3" name="company_ati" id="company_ati">
                <select name="company_area" class="form-control mb-3" id="company_area">
                    <option disabled selected hidden></option>
                    <option>Транспортная компания</option>
                    <option>Экспедиционная компания</option>
                    <option>Транспортно-экспедиционная компания</option>
                </select>
            </div>

            <h5>Частота рассылки</h5>
            <div id="mail_freq" class="mb-3 border py-2">
                <div class="form-row mb-2">
                    <div class="col text-right font-weight-bold">День недели</div>
                    <div class="col-8 text-center font-weight-bold">Время по МСК</div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Подписаться</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var week = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье']
        var html = '';
        for (var i = 0; i < week.length; i++) {
            html += '<div class="form-row">\
                <div class="col text-right">\
                    '+ week[i] +'\
                </div><div class="col text-center">\
                    <div class="custom-control custom-switch">\
                        <input type="checkbox" class="custom-control-input" name="week-day-'+ i +'" id="week-day-'+ i +'-9" '+(i < 5 ? 'checked="checked"' : '')+'>\
                        <label class="custom-control-label" for="week-day-'+ i +'-9">9:00</label>\
                    </div>\
                </div><div class="col">\
                    <div class="custom-control custom-switch">\
                        <input type="checkbox" class="custom-control-input" name="week-day-'+ i +'" id="week-day-'+ i +'-13" '+(i < 5 ? 'checked="checked"' : '')+'>\
                        <label class="custom-control-label" for="week-day-'+ i +'-13">13:00</label>\
                    </div>\
                </div>\
            </div>'
        }
        var mailFreq = document.getElementById('mail_freq')
        mailFreq.innerHTML += html
    });
</script>
@endsection