document.addEventListener('DOMContentLoaded', () => {
    iniciaApp()
})

function iniciaApp() {
    buscaFecha()
}

function buscaFecha() {
    
    const fecha = document.querySelector('#fecha')

    fecha.addEventListener('input', e => {

        window.location = `?fecha=${e.target.value}`
    
    })
}