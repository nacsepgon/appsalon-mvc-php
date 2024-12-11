let paso = 1
const pasoIni = 1, pasoFin = 3,
cita = {
    id: '',
    nombre : '',
    fecha : '',
    hora : '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp()
})

function iniciarApp() {
    // mostrarSeccion();
    tabs() // Cambiar secciones con botones
    paginador() // Botones de página anterior/siguiente
    pagAnterior()
    pagSiguiente()

    consultarAPI() // API en el backend de PHP
    
    idCliente()
    nombreCliente()
    escogerFecha()
    escogerHora()
    // resumen()
}

function mostrarSeccion() {

    // Ocultar sección anterior
    const seccionPrevia = document.querySelector('.mostrar')
    if (seccionPrevia) seccionPrevia.classList.remove('mostrar')

    // Seleccionar sección paso
    const seccion = document.querySelector(`#paso-${paso}`) // id de secciones
    seccion.classList.add('mostrar')

    // Normalizar tab previa
    const tabPrevia = document.querySelector('.actual')
    if (tabPrevia) tabPrevia.classList.remove('actual')

    // Resaltar tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`)
    tab.classList.add('actual')
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button')

    botones.forEach( boton => {

        boton.addEventListener('click', function(e) {
            
            paso = parseInt(e.target.dataset.paso)

            // mostrarSeccion()

            paginador()
        })
    })
}

function paginador() {
    const siguiente = document.querySelector('#siguiente'),
    anterior = document.querySelector('#anterior')

    if (paso === 1) {
        anterior.classList.add('ocultar')
        siguiente.classList.remove('ocultar')
    }
    else if (paso === 2) {
        anterior.classList.remove('ocultar')
        siguiente.classList.remove('ocultar')
    }
    else { // paso 3
        anterior.classList.remove('ocultar')
        siguiente.classList.add('ocultar')
        resumen()
    }
    mostrarSeccion()
}

function pagAnterior() {
    const anterior = document.querySelector('#anterior')

    anterior.addEventListener('click', () => {
        
        if (paso <= pasoIni) return
        paso--
        paginador()
    })
}

function pagSiguiente() {
    const siguiente = document.querySelector('#siguiente')

    siguiente.addEventListener('click', () => {
        
        if (paso >= pasoFin) return
        paso++
        paginador()
    })
}

async function consultarAPI() {

    try {
        // const url = `${location.origin}/api/servicios`,
        const url = '/api/servicios',
        
        resultado = await fetch(url)

        servicios = await resultado.json()

        mostrarServicios(servicios)

    } catch(error) {
        console.log(error)
    }
}

function mostrarServicios(servicios) {
    
    servicios.forEach( servicio => {
        // Destructuring extrae valor y crea variables en una línea
        const { id, nombre, precio } = servicio,

        nombreServicio = document.createElement('P')
        nombreServicio.classList.add('nombre-servicio')
        nombreServicio.textContent = nombre

        const precioServicio = document.createElement('P')
        precioServicio.classList.add('precio-servicio')
        precioServicio.textContent = `$${precio}`

        const servicioDiv = document.createElement('DIV')
        servicioDiv.classList.add('servicio')
        servicioDiv.dataset.idServicio = id;

        // servicioDiv.onclick = seleccionarServicio(servicio) // No pasa bien la variable
    
        servicioDiv.onclick = () => agregarServicio(servicio) // lo que "hace" la función, o sea el callback
    
        servicioDiv.appendChild(nombreServicio)
        servicioDiv.appendChild(precioServicio)

        document.querySelector('#servicios').appendChild(servicioDiv)

    })
}

function agregarServicio(servicio) {
    const { id } = servicio,
    { servicios } = cita,
    divServicio = document.querySelector(`[data-id-servicio="${id}"]`)

    // Servicio ya agregado
    if (servicios.some( agregado => agregado.id === id ) ) {
        // El que está en memoria (cita) y el del click (id o servicio.id)

        cita.servicios = servicios.filter( agregado => agregado.id !== id )
        divServicio.classList.remove('seleccionado')
    }
    else {
        cita.servicios = [...servicios, servicio]
        // cita.servicios = [...cita.servicios, servicio] es lo mismo ._.
        divServicio.classList.add('seleccionado')
    }
    // console.log(cita)
}

function idCliente() {
    cita.id = document.querySelector('#id').value
}

function nombreCliente() {
    cita.nombre = document.querySelector('#nombre').value
    // console.log(cita.nombre)
}

function escogerFecha() {

    const fecha = document.querySelector('#fecha')
    // dias = ['', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes']

    fecha.addEventListener('input', e => {
        // Domingo 0, Lunes 1... Sábado 6
        const dia = new Date(e.target.value).getUTCDay()

        if ( [0, 6].includes(dia) ) {
            e.target.value = ''
            mostrarAlerta('No atendemos Sábados ni Domingos.', 'error', '.formulario')
        }
        else {
            // console.log(dias[dia])
            cita.fecha = e.target.value
        }
        // console.log(cita)
    })
}

function escogerHora() {

    const inputHora = document.querySelector('#hora')

    inputHora.addEventListener('input', e => {
        
        const hora = e.target.value.split(':') // divide hora 12:30 en [12, 30]

        if (hora[0] < 9 || hora[0] > 18) {

            e.target.value = ''
            mostrarAlerta('Horario de atención: de 9:00 a 19:00.', 'error', '.formulario')
        }
        else {
            cita.hora = e.target.value
            // console.log(cita)
        }
    })
}

function mostrarAlerta(msj, tipo, elemento, tiempo = true) {
    // Ya había alerta
    const alerta = document.createElement('DIV'),
    alertaPrevia = document.querySelector('.alerta')
    if (alertaPrevia) alertaPrevia.remove()
    
    alerta.textContent = msj
    alerta.classList.add('alerta')
    alerta.classList.add(tipo)

    document.querySelector(elemento).appendChild(alerta)

    if (tiempo) setTimeout( () => alerta.remove(), 3000 )
}
    
function resumen() {
    const resumen = document.querySelector('.resumen')

    // Limpia contenido de resumen
    while (resumen.firstChild) { resumen.removeChild(resumen.firstChild) }

    if (cita.servicios.length === 0) {
        mostrarAlerta('Falta escoger al menos un servicio.', 'error', '.resumen', false)
        return
    }
    else if (Object.values(cita).includes('')) {
        mostrarAlerta('Falta hora o fecha de la cita.', 'error', '.resumen', false)
        return
    }
    // mostrarAlerta('TUDO BEM KKKK.', 'exito', '.resumen')

    // Formatear Div de resumen
    const { nombre, fecha, hora, servicios } = cita,
    headingCliente = document.createElement('H3'),
    nombreCliente = document.createElement('P'),
    fechaCita = document.createElement('P'),
    horaCita = document.createElement('P'),
    boton = document.createElement('BUTTON'),

    heading = document.createElement('H3'),
    plural = servicios.length > 1 ? 's' : ''
    heading.textContent = `Servicio${plural} solicitado${plural}:`
    resumen.appendChild(heading)

    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio,
        servicioDiv = document.createElement('DIV'),
        servicioTxt = document.createElement('P'),
        servicioPrecio = document.createElement('P')

        servicioDiv.classList.add('servicio')
        servicioTxt.textContent = nombre
        servicioPrecio.innerHTML = `<span>Precio:</span> $${precio}`

        servicioDiv.append(servicioTxt, servicioPrecio)
        resumen.appendChild(servicioDiv)        
    })

    // const date = new Date(fecha),
    // mes = date.getMonth(),
    // dia = date.getDate() + 2,
    // ano = date.getFullYear(),
    // fechaUTC = new Date( Date.UTC(ano, mes, dia) ), // Date.UTC = segundos desde 1970
    // options = { day: 'numeric', weekday: 'long', month: 'long', year: 'numeric' },
    // fechaES = fechaUTC.toLocaleDateString('es-CL', options) // lunes, 1 de mayo de 2024

    const date = new Date(fecha + ' 00:00'),
    options = { day: 'numeric', weekday: 'long', month: 'long', year: 'numeric' },
    fechaES = date.toLocaleDateString('es-CL', options) // lunes, 1 de mayo de 2024

    headingCliente.textContent = 'Resumen de cita:'
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaES}`
    horaCita.innerHTML = `<span>Hora:</span> ${hora}`

    boton.textContent = 'Reservar cita'
    boton.classList.add('boton')
    boton.onclick = reservarCita

    resumen.append(headingCliente, nombreCliente, fechaCita, horaCita, boton)
}

async function reservarCita() {

    const { id, nombre, fecha, hora, servicios } = cita,

    // Array de servicios
    idServicios = servicios.map( servicio => servicio.id )

    const datos = new FormData() // Submit
    datos.append('usuarioId', id)
    datos.append('fecha', fecha)
    datos.append('hora', hora)
    datos.append('servicios', idServicios)
    // console.log([...datos]); return

    try {
        // const url = `${location.origin}/api/citas`,
        const url = '/api/citas',
        // APIController::guardar()
        respuesta = await fetch(url, { 
            method: 'POST',
            body: datos
        }),
    
        resultado = await respuesta.json()
    
        if (resultado.guardado) {
            Swal.fire({
              icon: "success",
              title: "Cita agendada",
              text: "Cita programada para el " + fecha + ' a las ' + hora
            }).then (
                () => window.location.reload()       
            )
        }
    }
    catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error al agendar la cita",
        }).then (
            () => setTimeout( () => window.location.reload(), 3000 )
        )
    }
}