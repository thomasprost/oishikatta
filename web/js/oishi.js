import rotateText from './mine.js'


let OISHI =  (function () {
    'use strict';

    /*
        Add a new Ingredient or Step to a Recipe. Manages the number the new element is and adds it from templates provided by Symfony form
     */
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

    /*
        Removes an element from the list in the DOM
     */
    let bindRemoveElement = function (closeElement) {
        closeElement.addEventListener("click", function (e) {
            e.preventDefault()
            const parentToDelete = this.parentNode
            parentToDelete.parentNode.removeChild(parentToDelete)
        })
    }
    
    /*
        Open mobile menu on menu button click
     */
    let toggleMobileMenu = function () {
        const menuButton = document.querySelector('#mobile-menu-bt'),
            menu = document.querySelector('#main-menu'),
            closeButton = document.querySelector('#mobile-menu-close')

        menuButton.addEventListener('click', function () {
            menu.classList.add('menu--open')
        }, false)

        closeButton.addEventListener('click', function () {
            menu.classList.remove('menu--open')
        }, false)
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

    /*
        Toggle the search field to be zoomed in on click
     */
    let toggleSearch = function () {
        const searchInput = document.querySelector('#search-input'),
            closeSearch = document.querySelector('#btn-search-close'),
            searchParent = document.querySelector('.search'),
            searchButton = document.querySelector('.btn--search')
        searchInput.addEventListener('click', function (e) {
            searchParent.classList.add('search--open')
        })

        closeSearch.addEventListener('click', function (e) {
            searchParent.classList.remove('search--open')
        })

        searchButton.addEventListener('click', function (e) {
            e.preventDefault()
            const form = document.forms["search-form"].submit();
        })


    }

    /*
        Security check before deleting a recipe to prevent mis-click
     */
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


    /*
        Flash messages to be displayed to the user on any change to a recipe (CRUD action)
     */
    let manageFlashMessages = function () {
        const flash = document.querySelector('.flash-notice')
        if(document.body.classList.contains('all-recipe') && flash !== null){
            flash.classList.add('showing')
            window.setTimeout(() => {
                flash.classList.remove('showing')
            }, 6000)
        }
    }

    /*
        Initiates our oishi object
     */
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
        toggleMobileMenu();

    };

    return {
        init: init
    };
})();

export default OISHI;