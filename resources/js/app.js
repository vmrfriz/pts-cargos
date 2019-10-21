// import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {

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
                    console.log(event)
                    var newInput = document.createElement('input')
                    newInput.classList.add('form-control', 'form-control-sm', 'mb-2', 'js-new-input', 'opacity-50')
                    newInput.type = 'text';
                    newInput.setAttribute('name', target.name)
                    newInput.addEventListeners('mouseover focus mouseout blur change keyup', newInputListener)
                    target.parentNode.append(newInput);
                } else if (
                    !target.value.length
                    && target.nextElementSibling
                    && !target.nextElementSibling.value.length
                    && !target.nextElementSibling.nextElementSibling)
                {
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
});