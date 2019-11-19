@extends('layout')

@section('title')
Грузы от ПромТранспортСервис
@endsection

@section('head')
<script src="https://api-maps.yandex.ru/2.1/?apikey={{ config()->get('api.yandexmaps.token') }}&lang=ru_RU" type="text/javascript"></script>
<style>
    .js-order {
        cursor: pointer;
    }
</style>
@endsection

@section('content')

<div class="bg-white mb-4 rounded-lg p-3">
    <form id="search">
        <div class="row">
            <div class="col">
                <div>
                    <input type="text" name="load_points" class="form-control" placeholder="Город погрузки">
                </div>
            </div>
            <div class="col">
                <div>
                    <input type="text" name="unload_points" class="form-control" placeholder="Город выгрузки">
                </div>
            </div>
            <div class="col">
                <div>
                    <input type="text" name="cargo_type" class="form-control" placeholder="Тип груза">
                </div>
            </div>
            <div class="col-2">
                <div class="text-right">
                    <button type="reset" class="btn btn-outline-danger">Сбросить</button>
                </div>
            </div>
        </div>
    </form>
</div>

@if($orders ?? false)
<table id="orders" class="table table-responsive-lg mb-4 bg-white rounded-lg overflow-hidden js-sortable">
    <thead>
        <tr class="font-weight-bold">
            <td class="border-top-0 js-order" data-column="load_points">Направление</td>
            <td class="border-top-0 js-order" data-column="cargo_type">Тип груза</td>
            <td class="border-top-0 js-order" data-column="loading_time">Погрузка</td>
            <td class="border-top-0 js-order text-right" data-column="price">Оплата</td>
            <td class="border-top-0 text-right">Действие</td>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<div class="p-3 bg-white rounded-lg mb-4">
    <div class="mb-3"><b>Точки погрузки на карте</b></div>
    <div id="map" style="width: 100%; height: 300px"></div>
</div>
@else
<div class="text-center h4 text-muted py-5">Пусто, пока что</div>
@endif
@endsection

@section('scripts')
<script>
    var ordersBody = document.querySelector('#orders tbody');
    var ordersData = {!! json_encode($orders) !!};

    Number.prototype.formatMoney = function (decimalCount = 2, decimal = ".", thousands = ",") {
        decimalCount = Math.abs(decimalCount);
        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

        const negativeSign = this < 0 ? "-" : "";

        let n = 0;
        let i = parseInt(n = Math.abs(this).toFixed(decimalCount)).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;

        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(n - i).toFixed(decimalCount).slice(2) : "");
    };

    function addEventListeners (type, func) {
        for (var i = 0; i < this.length; i++) {
            this[i].addEventListener(type, func);
        }
    };
    HTMLCollection.prototype.addEventListener = addEventListeners;
    NodeList.prototype.addEventListener = addEventListeners;
    function addEventListenersToNode (types, func) {
        var types = types.split(' ');
        for (var i = 0; i < types.length; i++) {
            this.addEventListener(types[i], func);
        }
    }
    NodeList.prototype.addEventListeners = addEventListenersToNode;
    Node.prototype.addEventListeners = addEventListenersToNode;

    document.getElementsByClassName('js-order').addEventListener('click', function (event) {
        var orderColumn = event.target.attributes.getNamedItem('data-column').value;
        // var orderBy = event.target.attributes.getNamedItem('data-order');
        var orderBy = event.target.getAttribute('data-order');
        var orderBy = (orderBy || '').toUpperCase() == 'DESC' ? 'ASC' : 'DESC';
        event.target.setAttribute('data-order', orderBy);
        ordersData = ordersData.sort(function (a, b) {
            return orderBy == 'ASC' ? a[orderColumn]>b[orderColumn]?1:0 : a[orderColumn]<b[orderColumn]?1:0;
        });
        renderTable(ordersData)
    });

    document.querySelectorAll('form#search input, form#search button').addEventListeners('change keyup', function (event) {
        var form = event.target.form
        var formData = {}
        for (var i = 0; i < form.length; i++) {
            var input = form[i]
            formData[input.name] = input.value
        }
        var searchData = ordersData.filter(function(order, index) {
            var relevant = true;
            for(var param in formData) {
                if (formData[param] && order[param]) {
                    var str = typeof(order[param]) != 'string' ? order[param].join(', ') : order[param]
                    if(!str.toLowerCase().includes(formData[param].toLowerCase())) {
                        relevant = false;
                    }
                }
            }
            return relevant;
        })
        renderTable(searchData)
    });
    document.querySelectorAll('form#search').addEventListeners('reset', function (event) {
        renderTable(ordersData);
    });

    function renderTable(ordersData) {
        function formatDate(date) {
            var dd = date.getDate();
            if (dd < 10) dd = '0' + dd;

            var mm = date.getMonth() + 1;
            if (mm < 10) mm = '0' + mm;

            var yy = date.getFullYear();

            var hh = date.getHours();
            if (hh < 10) hh = '0' + hh;

            var min = date.getMinutes();
            if (min < 10) min = '0' + min;

            return dd + '.' + mm + '.' + yy + (hh == '00' && min == '00' ? '' : ' &ndash; ' + hh + ':' + min);
        }
        function createTableRow(from, to, cargoType, loadDate, price, link) {
            var fromHTML = '';
            for (f in from)
                if (fromHTML) fromHTML += ', ' + from[f];
                else fromHTML += from[f] + '<span class="sr-only">'
            if (fromHTML) fromHTML += '</span>'
            if (from.length > 1) fromHTML += ' <span class="badge badge-info">+'+ (from.length-1) +'</span>'

            var toHTML = '';
            for (t in to)
                if (toHTML) toHTML += to[t];
                else toHTML += to[t] + '<span class="sr-only">'
            if (toHTML) toHTML += '</span>'
            if (to.length > 1) toHTML += ' <span class="badge badge-info">+'+ (to.length-1) +'</span>'

            price = price ? price.formatMoney(0, '.', ' ') + ' ₽' : '&ndash;';

            return '<tr>\
                    <td>'+ fromHTML +' &ndash; '+ toHTML +'</td>\
                    <td class="text-truncate" style="max-width:25%">'+ (cargoType || '') +'</td>\
                    <td class="text-nowrap">'+ formatDate(new Date(loadDate)) +'</td>\
                    <td class="text-nowrap text-right" style="line-height:1em">'+ price +'</td>\
                    <td class="text-right">\
                        <a href="'+link+'" class="btn btn-sm btn-outline-primary">Просмотреть</a>\
                    </td>\
                </tr>';
        }
        var tbody = '';
        for (var i = 0; i < ordersData.length; i++) {
            var r = ordersData[i]
            var l = (r.id ? 'id' : '') + r.id;
            tbody += createTableRow(r.load_points, r.unload_points, r.cargo_type, r.loading_time, r.price, l);
        }
        ordersBody.innerHTML = tbody;
        return tbody;
    }

    renderTable(ordersData);

    /**
     * Yandex Maps
     */
    ymaps.ready(init);
    function init(){
        var mapCargos = new ymaps.Map("map", {
            center: [58.714424, 87.652627],
            zoom: 3,
            controls: [],
        });
        var cargosGeoObject = [];
        var coords = [];
        for (order in ordersData) {
            for (coord in ordersData[order].load_coords) {
                coords.push(ordersData[order].load_coords[coord]);
            }
        }

        for (var i = 0; i<coords.length; i++) {
            cargosGeoObject[i] = new ymaps.GeoObject({
                geometry: {
                    type: "Point",
                    coordinates: coords[i]
                }
            });
        }

        var cargosCluster = new ymaps.Clusterer();
        cargosCluster.add(cargosGeoObject);
        mapCargos.geoObjects.add(cargosCluster);
    }
</script>
<script src="{{ asset('js/jquery.tablesorter.min.js') }}"></script>
@endsection