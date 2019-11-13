@extends('layout')

@section('title')
    Подписаться
@endsection

@section('head')
<script charset="UTF-8" src="//cdn.sendpulse.com/js/push/58dd07dd26e7f6314193d96f6c6ced8a_1.js" async></script>
@endsection

@section('content')
<div class="row justify-content-center">
    <h1 class="text-center text-uppercase font-weight-light mb-5">Подписаться на рассылку грузов</h1>
    <div class="col-md-6 pb-5">
        <form action="/subscribe" method="POST">
            @csrf
            @method('PUT')

            <h5>Каналы рассылок</h5>
            <div class="mb-3 rounded-lg bg-white p-3 mb-4">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="contact-email">E-Mail</label>
                        <input id="contact-email" class="form-control form-control-sm" type="email" name="contact-email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="contact-telegram">Telegram</label>
                        <input id="contact-telegram" class="form-control form-control-sm" type="text" name="contact-telegram">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="contact-icq">ICQ</label>
                        <input id="contact-icq" class="form-control form-control-sm" type="text" name="contact-icq">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="contact-whatsapp">WhatsApp</label>
                        <input id="contact-whatsapp" class="form-control form-control-sm" type="text" name="contact-whatsapp">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="contact-viber">Viber</label>
                        <input id="contact-viber" class="form-control form-control-sm" type="text" name="contact-viber">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="form-notifications">Уведомления в браузере</label>
                        <button onclick="return false" class="sp_notify_prompt text-center btn btn-sm btn-link border w-100" type="button" id="form-notifications">Включить уведомления</button>
                    </div>
                </div>
            </div>

            <button class="btn btn-primary" type="submit">Подписаться</button>
        </form>
    </div>
</div>
@endsection
