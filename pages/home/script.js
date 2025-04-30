let isActivecategories = false

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
        isActivecategories = false
    }

    if (isActivecategories) {
        document.getElementById('categories-drop').setAttribute('class', 'flex-col sm:absolute max-[426px]:gap-5 max-[426px]:mt-5 sm:bg-white sm:rounded-lg sm:shadow-md active-drop sm:left-0 sm:mt-3 sm:ml-5')
    } else {
        document.getElementById('categories-drop').setAttribute('class', 'flex-col sm:absolute max-[426px]:gap-5 max-[426px]:mt-5 sm:bg-white sm:rounded-lg sm:shadow-md inactive-drop sm:left-0 sm:mt-3 sm:ml-5')
    }
});