@extends('layout')

@section('title')
Добавить груз
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="bg-white rounded-lg p-3">
            <form action="/orders" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="route-load">Место погрузки</label>
                    <input id="route-load" class="form-control form-control-sm mb-2" type="text" name="route-load[]" required="required">
                    <input class="form-control form-control-sm mb-2 js-new-input opacity-50" type="text" name="route-load[]">
                </div>
                <div class="form-group">
                    <label for="route-unload">Место выгрузки</label>
                    <input id="route-unload" class="form-control form-control-sm mb-2" type="text" name="route-unload[]" required="required">
                    <input class="form-control form-control-sm mb-2 js-new-input opacity-50" type="text" name="route-unload[]">
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="bidget">Бюджет</label>
                            <input id="bidget" type="datetime" class="form-control form-control-sm" name="bidget" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Расстояние</label>
                            <input type="datetime" class="form-control form-control-sm" id="distance" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="load-time">Время погрузки</label>
                            <input id="load-time" type="datetime" class="form-control form-control-sm mb-2" name="load-time" placeholder="01.02.2001 10:02" required>
                            <input id="load-time" type="text" class="form-control form-control-sm mb-2" name="load-comment" placeholder="Комментарий, режим работы, ..." required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="unload-time">Время выгрузки</label>
                            <input id="unload-time" type="datetime" class="form-control form-control-sm mb-2" name="unload-time" placeholder="02.01.2001 20:10">
                            <input id="unload-comment" type="text" class="form-control form-control-sm mb-2" name="unload-comment" placeholder="Комментарий, режим работы, ...">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="route-unload">Тип груза</label>
                    <input id="route-unload" class="form-control form-control-sm" type="text" name="cargo-type" required="required">
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="cargo-weight">Тоннаж <span class="text-muted">(тонны)</span></label>
                            <input id="cargo-weight" type="number" class="form-control form-control-sm" name="weight" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="cargo-length">Длина <span class="text-muted">(метры)</span></label>
                            <input id="cargo-length" type="number" class="form-control form-control-sm" name="length">
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Добавить</button>
            </form>
        </div>
    </div>
</div>
@endsection
