/* =========================================
   VENTAFLUJO - JAVASCRIPT GENERAL
   ========================================= */


// =========================================
// CONFIRMAR ELIMINACIÓN
// =========================================

function confirmarEliminacion(evento) {

    const confirmar = confirm(
        "¿Está seguro de que desea eliminar este elemento?"
    );

    if (!confirmar) {

        evento.preventDefault();

    }

}


// =========================================
// CONFIRMAR LOGOUT
// =========================================

function confirmarSalida(evento) {

    const confirmar = confirm(
        "¿Desea cerrar la sesión?"
    );

    if (!confirmar) {

        evento.preventDefault();

    }

}


// =========================================
// VALIDAR CONTRASEÑAS
// =========================================

function validarContrasenas(formulario) {

    const password = formulario.querySelector(
        'input[name="password"]'
    );

    const confirmar = formulario.querySelector(
        'input[name="confirmar"]'
    );

    if (!password || !confirmar) {

        return true;

    }

    if (password.value !== confirmar.value) {

        alert("Las contraseñas no coinciden.");

        confirmar.focus();

        return false;

    }

    return true;

}


// =========================================
// ACTIVAR FUNCIONES AL CARGAR LA PÁGINA
// =========================================

document.addEventListener("DOMContentLoaded", function () {

    // Confirmación para enlaces de eliminación
    const botonesEliminar = document.querySelectorAll(
        ".btn-eliminar"
    );

    botonesEliminar.forEach(function (boton) {

        boton.addEventListener(
            "click",
            confirmarEliminacion
        );

    });


    // Confirmación para cerrar sesión
    const botonesSalir = document.querySelectorAll(
        ".btn-logout"
    );

    botonesSalir.forEach(function (boton) {

        boton.addEventListener(
            "click",
            confirmarSalida
        );

    });


    // Validación del formulario de registro
    const formularioRegistro = document.querySelector(
        'form.form-registro'
    );

    if (formularioRegistro) {

        formularioRegistro.addEventListener(
            "submit",
            function (evento) {

                if (!validarContrasenas(this)) {

                    evento.preventDefault();

                }

            }
        );

    }

});