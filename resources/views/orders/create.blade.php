@extends('layout')

@section('title')
Добавить груз
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="bg-white rounded-lg p-3">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="/" method="POST">
                @csrf
                <div class="form-group">
                    <label for="load_points">Адреса погрузки</label>
                    @if(old('load_points'))
                    @foreach(old('load_points') as $load_point)
                    @if(old('load_points')[$loop->index] == '')
                        @continue
                    @endif
                    <input id="load_points" class="form-control form-control-sm mb-2 {{ $errors->has('load_points') ? 'is-invalid' : '' }}" type="text" name="load_points[]" value="{{ old('load_points')[$loop->index] }}" required="required">
                    @endforeach
                    @endif
                    <input class="form-control form-control-sm mb-2 js-new-input opacity-50" type="text" name="load_points[]">
                </div>
                <div class="form-group">
                    <label for="unload_points">Адреса выгрузки</label>
                    @if(old('unload_points'))
                    @foreach(old('unload_points') as $unload_points)
                    @if(old('unload_points')[$loop->index] == '')
                        @continue
                    @endif
                    <input id="unload_points" class="form-control form-control-sm mb-2 {{ $errors->has('unload_points') ? 'is-invalid' : '' }}" type="text" name="unload_points[]" value="{{ old('unload_points')[$loop->index] }}" required="required">
                    @endforeach
                    @endif
                    <input class="form-control form-control-sm mb-2 js-new-input opacity-50" type="text" name="unload_points[]">
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="loading-time">Время погрузки</label>
                            <input id="loading_time" type="datetime" class="form-control form-control-sm mb-2 {{ $errors->has('loading_time') ? 'is-invalid' : '' }}" name="loading_time" value="{{ old('loading_time') }}" placeholder="01.02.2001 10:02" required="required">
                            <input id="loading_time" type="text" class="form-control form-control-sm mb-2 {{ $errors->has('loading_comment') ? 'is-invalid' : '' }}" name="loading_comment" value="{{ old('loading_comment') }}" placeholder="Комментарий, режим работы, ...">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="unload_time">Время выгрузки</label>
                            <input id="unloading_time" type="datetime" class="form-control form-control-sm mb-2 {{ $errors->has('unloading_time') ? 'is-invalid' : '' }}" name="unloading_time" value="{{ old('unloading_time') }}" placeholder="02.01.2001 20:10">
                            <input id="unloading_comment" type="text" class="form-control form-control-sm mb-2 {{ $errors->has('unloading_comment') ? 'is-invalid' : '' }}" name="unloading_comment" value="{{ old('unloading_comment') }}" placeholder="Комментарий, режим работы, ...">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="route_unload">Тип груза</label>
                    <input id="route_unload" class="form-control form-control-sm {{ $errors->has('cargo_type') ? 'is-invalid' : '' }}" type="text" name="cargo_type" value="{{ old('cargo_type') }}" required="required">
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="cargo_weight">Тоннаж <span class="text-muted">(тонны)</span></label>
                            <input id="cargo_weight" type="number" class="form-control form-control-sm {{ $errors->has('weight') ? 'is-invalid' : '' }}" name="weight" value="{{ old('weight') }}" required="required">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="cargo_length">Длина <span class="text-muted">(метры)</span></label>
                            <input id="cargo_length" type="number" class="form-control form-control-sm {{ $errors->has('length') ? 'is-invalid' : '' }}" name="length" value="{{ old('length') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="price">Бюджет <span class="text-muted">(₽)</span></label>
                            <input id="price" type="datetime" class="form-control form-control-sm {{ $errors->has('price') ? 'is-invalid' : '' }}" name="price" value="{{ old('price') }}" required="required">
                        </div>
                    </div>
                    <div class="col">
                        {{-- <div class="form-group">
                            <label>Расстояние</label>
                            <input type="text" class="form-control form-control-sm" id="distance" readonly>
                        </div> --}}
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary" type="submit">Добавить</button>
                    <button class="btn btn-light" type="reset">Очистить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
