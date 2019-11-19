import $ from 'jquery'
import 'bootstrap'
import 'moment'
import 'bootstrap4-datetimepicker'

$(function() {
    function newInputListener(event) {
        var target = event.target
        switch (event.type) {
            case 'mouseover':
            case 'focus':
                target.classList.remove('opacity-50')
                break

            case 'mouseout':
            case 'blur':
                if (document.activeElement === target ||
                    target.value.length) break
                target.classList.add('opacity-50')
                break

            case 'change':
            case 'keyup':
                if (target.value.length && !target.nextElementSibling) {
                    var newInput = document.createElement('input')
                    newInput.classList.add('form-control', 'form-control-sm', 'mb-2', 'js-new-input', 'opacity-50')
                    newInput.type = 'text';
                    newInput.setAttribute('name', target.name)
                    newInput.addEventListeners('mouseover focus mouseout blur change keyup', newInputListener)
                    target.parentNode.append(newInput);
                } else if (!target.value.length &&
                    target.nextElementSibling &&
                    !target.nextElementSibling.value.length &&
                    !target.nextElementSibling.nextElementSibling) {
                    target.nextElementSibling.remove()
                }
                break
        }
    }

    function _addEventListeners(eventNames, listener) {
        var elements = [];
        if (this instanceof NodeList)
            for (var i = 0; i < this.length; i++)
                elements.push(this[i])
        else
            elements.push(this)

        var events = eventNames.split(' ')
        for (var i = 0; i < events.length; i++) {
            for (var j = 0; j < elements.length; j++) {
                elements[j].addEventListener(events[i], listener, false)
            }
        }
    }
    Node.prototype.addEventListeners = _addEventListeners
    NodeList.prototype.addEventListeners = _addEventListeners


    var newInputs = document.getElementsByClassName('js-new-input');
    for (var i = 0; i < newInputs.length; i++) {
        newInputs[i].addEventListeners('mouseover focus mouseout blur change keyup', newInputListener);
    }

    document.querySelectorAll('button[type="reset"],input[type="reset"]').addEventListeners('click', function(event) {
        var newInputs = document.getElementsByClassName('js-new-input')
        for (var i = newInputs.length - 1; i >= 0; i--) {
            var nextElem = newInputs[i].nextElementSibling
            if (nextElem && nextElem.classList.contains('js-new-input')) {
                nextElem.remove()
            }
        }
    });

    $('.datetimepicker').datetimepicker({
        locale: 'ru',
        minDate: new Date(),
        // minViewMode: 'years',
        format: 'DD.MM.YYYY HH:mm',
        icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-check',
            clear: 'fa fa-trash',
            close: 'fa fa-times'
        }
    });

    // $('#orders').DataTable();
    $("table.js-sortable").tablesorter();
});