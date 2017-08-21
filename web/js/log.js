
let OISHI =  (function () {
    'use strict';

    let addNewElement = function () {
        let addButton = document.querySelector('#add-another-el')
        let elNumber = 1
        // console.log(addButton);
        addButton.addEventListener('click',function (e) {
            e.preventDefault()

            let ingList = document.querySelector('#ingredients-fields-list')

            let newWidget = ingList.getAttribute('data-prototype')
            newWidget = newWidget.replace(/__name__/g, elNumber)
            elNumber++

            let newLi = document.createElement('li')
            newLi.innerHTML = newWidget
            // newLi.appendChild(newLi);

            ingList.appendChild(newLi)
        })
    }

    let init = function () {
        addNewElement();
    };

    return {
        init: init
    };
})();

export default OISHI;