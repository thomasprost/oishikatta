import rotateText from './mine.js'


let OISHI =  (function () {
    'use strict';

    let addNewElement = function () {
        let addButton = document.querySelectorAll('.add-another-el')

        // console.log(addButton);
        addButton.forEach((el,i) => {
            let elNumber = el.parentNode.querySelectorAll('li').length !== null ? el.parentNode.querySelectorAll('li').length : 0;

            el.addEventListener('click', (e) => {
                e.preventDefault()

                let list = el.parentNode.querySelector('ul')

                let newWidget = list.getAttribute('data-prototype')
                newWidget = newWidget.replace(/__name__/g, elNumber)

                elNumber++

                let closeButton = document.createElement("a")
                closeButton.setAttribute("href", "#")
                closeButton.classList.add("del-another-el")

                bindRemoveElement(closeButton);

                let newLi = document.createElement('li')
                newLi.innerHTML = newWidget

                newLi.appendChild(closeButton)
                list.appendChild(newLi)

            })

        })

    }

    let bindRemoveElement = function (closeElement) {
        closeElement.addEventListener("click", function (e) {
            e.preventDefault()
            const parentToDelete = this.parentNode
            parentToDelete.parentNode.removeChild(parentToDelete)
        })
    }


    // If we can find the app element, setup Vuejs
    if(document.querySelector('#app')){
        let recipeApp = new Vue({
            delimiters: ['${', '}'],
            el: '#app',
            data: {
                seen: true,
                recipe: {
                    title: SfRecipe.title,
                    ingredients: {
                        total: 0
                    },
                    steps:{

                    }
                }
            },
            methods: {
                hide : function (e) {
                    e.preventDefault()
                    this.seen = !this.seen
                },
                countChildren: function (parentId) {
                    const parent = document.querySelector(parentId)
                    return parent.querySelectorAll('li').length || 0
                }
            }

        })
    }

    let toggleSearch = function () {
        const searchInput = document.querySelector('#search-input'),
            closeSearch = document.querySelector('#btn-search-close'),
            searchParent = document.querySelector('.search')
        searchInput.addEventListener('click', function (e) {
            searchParent.classList.add('search--open')
        })

        closeSearch.addEventListener('click', function (e) {
            searchParent.classList.remove('search--open')
        })
    }

    let beforeDeletingRecipe = function () {
        // Verification before deleting a recipe
        let deleteRecipeBt = document.querySelector('#delete-recipe')
        if(deleteRecipeBt !== null){
            deleteRecipeBt.addEventListener('click', function(e){
                if(!confirm('Are you sure you want to delete this recipe?'))
                    e.preventDefault()
                    return false;
            });
        }

    }


    function manageFlashMessages() {
        if(document.body.classList.contains('all-recipe') && document.querySelector('.flash-notice')){

        }
    }

    let init = function () {
        if(document.body.classList.contains('form-recipe')){
            addNewElement();
            let removeButton = document.querySelectorAll('.del-another-el')
            removeButton.forEach((el, i) => bindRemoveElement(el))
        }

        rotateText()
        toggleSearch()
        beforeDeletingRecipe()
        manageFlashMessages()

    };

    return {
        init: init
    };
})();

export default OISHI;