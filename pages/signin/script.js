let eye = document.getElementById('eye')
let eyeImg = document.getElementById('eye-img')
let input = document.getElementById('input')
let isVisible = false
eye.addEventListener('click', () => {
    isVisible = !isVisible
    if (isVisible) {
        eyeImg.setAttribute('src', "../../img/view.png")
        input.setAttribute('type', 'text')

    } else{
        eyeImg.setAttribute('src', "../../img/hide.png")
        input.setAttribute('type', 'password') 
    }
    
})