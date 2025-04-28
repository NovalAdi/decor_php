let home = document.getElementById('home')
let isActivehome = false
let isActivestore = false
let isActiveproduct = false
let isActive = false
let isActiveModels = false
let isActivecategories = false

home.addEventListener('click', () => {
    isActivehome = !isActivehome

    isActivestore = false
    isActiveproduct = false
    isActive = false
    isActiveModels = false
    isActivecategories = false
})

let store = document.getElementById('store')

store.addEventListener('click', () => {
    isActivestore = !isActivestore

    isActivehome = false
    isActiveproduct = false
    isActive = false
    isActiveModels = false
    isActivecategories = false
})

let product = document.getElementById('product')

product.addEventListener('click', () => {
    isActiveproduct = !isActiveproduct

    isActivehome = false
    isActivestore = false
    isActive = false
    isActiveModels = false
    isActivecategories = false
})

let style = document.getElementById('style')

style.addEventListener('click', () => {
    isActive = !isActive

    isActivehome = false
    isActivestore = false
    isActiveproduct = false
    isActiveModels = false
    isActivecategories = false
})

let models = document.getElementById('models')

models.addEventListener('click', () => {
    isActiveModels = !isActiveModels

    isActivehome = false
    isActivestore = false
    isActiveproduct = false
    isActive = false
    isActivecategories = false
})

let categories = document.getElementById('categories')

categories.addEventListener('click', () => {
    isActivecategories = !isActivecategories

    isActivehome = false
    isActivestore = false
    isActiveproduct = false
    isActive = false
    isActiveModels = false
})

let burger = document.getElementById('burger')
let burgerIcon = document.getElementById('burger-icon')
let isActiveBurger = false

burgerIcon.addEventListener('click', () => {

    isActiveBurger = !isActiveBurger

    if (isActiveBurger) {
        burger.setAttribute('class', 'flex flex-col sm:flex-row sm:items-end gap-5 sm:gap-10 active-burger')
    } else {
        burger.setAttribute('class', 'flex-col sm:flex-row sm:items-end gap-5 sm:gap-10 inactive-burger')
    }
})

document.addEventListener('click', (event) => {
    if (!event.target.closest('.drop-down')) {
        isActivehome = false
        isActivestore = false
        isActiveproduct = false
        isActive = false
        isActiveModels = false
        isActivecategories = false
    }

    if (isActivecategories) {
        document.getElementById('categories-drop').setAttribute('class', 'flex-col sm:absolute max-[426px]:gap-5 max-[426px]:mt-5 sm:bg-white sm:rounded-lg sm:shadow-md active-drop sm:left-0 sm:mt-3 sm:ml-5')
    } else {
        document.getElementById('categories-drop').setAttribute('class', 'flex-col sm:absolute max-[426px]:gap-5 max-[426px]:mt-5 sm:bg-white sm:rounded-lg sm:shadow-md inactive-drop sm:left-0 sm:mt-3 sm:ml-5')
    }

    if (isActiveModels) {
        document.getElementById('models-drop').setAttribute('class', 'flex-col sm:absolute max-[426px]:gap-5 max-[426px]:mt-5 sm:bg-white sm:rounded-lg sm:shadow-md active-drop sm:left-0 sm:mt-3 sm:ml-5')
    } else {
        document.getElementById('models-drop').setAttribute('class', 'flex-col sm:absolute max-[426px]:gap-5 max-[426px]:mt-5 sm:bg-white sm:rounded-lg sm:shadow-md inactive-drop sm:left-0 sm:mt-3 sm:ml-5')
    }

    if (isActive) {
        document.getElementById('style-drop').setAttribute('class', 'flex-col sm:absolute max-[426px]:gap-5 max-[426px]:mt-5 sm:bg-white sm:rounded-lg sm:shadow-md active-drop sm:left-0 sm:mt-3 sm:ml-5')
    } else {
        document.getElementById('style-drop').setAttribute('class', 'flex-col sm:absolute max-[426px]:gap-5 max-[426px]:mt-5 sm:bg-white sm:rounded-lg sm:shadow-md inactive-drop sm:left-0 sm:mt-3 sm:ml-5')
    }

    if (isActiveproduct) {
        document.getElementById('product-drop').setAttribute('class', 'flex-col sm:absolute max-[426px]:gap-5 max-[426px]:mt-5 sm:bg-white sm:rounded-lg sm:shadow-md active-drop sm:left-0 sm:mt-3 sm:ml-5')
    } else {
        document.getElementById('product-drop').setAttribute('class', 'flex-col sm:absolute max-[426px]:gap-5 max-[426px]:mt-5 sm:bg-white sm:rounded-lg sm:shadow-md inactive-drop sm:left-0 sm:mt-3 sm:ml-5')
    }

    if (isActivestore) {
        document.getElementById('store-drop').setAttribute('class', 'flex-col sm:absolute max-[426px]:gap-5 max-[426px]:mt-5 sm:bg-white sm:rounded-lg sm:shadow-md active-drop sm:left-0 sm:mt-3 sm:ml-5')
    } else {
        document.getElementById('store-drop').setAttribute('class', 'flex-col sm:absolute max-[426px]:gap-5 max-[426px]:mt-5 sm:bg-white sm:rounded-lg sm:shadow-md inactive-drop sm:left-0 sm:mt-3 sm:ml-5')
    }

    if (isActivehome) {
        document.getElementById('home-drop').setAttribute('class', 'flex-col sm:absolute max-[426px]:gap-5 max-[426px]:mt-5 sm:bg-white sm:rounded-lg sm:shadow-md active-drop sm:left-0 sm:mt-3 sm:ml-5')
    } else {
        document.getElementById('home-drop').setAttribute('class', 'flex-col sm:absolute max-[426px]:gap-5 max-[426px]:mt-5 sm:bg-white sm:rounded-lg sm:shadow-md inactive-drop sm:left-0 sm:mt-3 sm:ml-5')
    }
});