import rotateText from './mine.js'


let OISHI =  (function () {
    'use strict';

    let addNewElement = function () {
        let addButton = document.querySelectorAll('.add-another-el')

        // console.log(addButton);
        addButton.forEach((el,i) => {
            let elNumber = 1
            el.addEventListener('click', (e) => {
                e.preventDefault()

                let list = el.parentNode.querySelector('ul')

                let newWidget = list.getAttribute('data-prototype')
                newWidget = newWidget.replace(/__name__/g, elNumber)

                elNumber++

                let closeButton = document.createElement("a")
                closeButton.setAttribute("href", "#")
                closeButton.classList.add("del-another-el")

                closeButton.addEventListener("click", function (e) {
                    e.preventDefault()
                    const parentToDelete = this.parentNode
                    parentToDelete.parentNode.removeChild(parentToDelete)
                })

                let newLi = document.createElement('li')
                newLi.innerHTML = newWidget

                newLi.appendChild(closeButton)
                list.appendChild(newLi)

            })

        })

    }

    let app = new Vue({
        el: '#app',
        data: {
            recipeTitle: "",
            seen: true
        },
        methods: {
            hide : function (e) {
                e.preventDefault()
                this.seen = !this.seen
            }
        }

    })

    let init = function () {
        if(document.body.classList.contains('add-recipe')){
            addNewElement();
        }

        rotateText();
    };

    return {
        init: init
    };
})();

export default OISHI;