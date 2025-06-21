document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('registroForm');

    const inputs = {
        nombre: document.getElementById('nombre'),
        apellido: document.getElementById('apellido'),
        cedula: document.getElementById('cedula'),
        telefono: document.getElementById('telefono'),
        correo: document.getElementById('correo'),
        contrasena: document.getElementById('contrasena'),
        confirmar: document.getElementById('confirmar')
    };

    const errores = {
        nombre: document.getElementById('error-nombre'),
        apellido: document.getElementById('error-apellido'),
        cedula: document.getElementById('error-cedula'),
        telefono: document.getElementById('error-telefono'),
        correo: document.getElementById('error-correo'),
        contrasena: document.getElementById('error-contrasena'),
        confirmar: document.getElementById('error-confirmar')
    };

    // Solo letras
    [inputs.nombre, inputs.apellido].forEach(input => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/[^a-zA-ZÁÉÍÓÚÑñáéíóú ]/g, '');
            errores[input.name].textContent = input.value.trim().length < 3 ? "Debe tener al menos 3 caracteres" : "";
        });
    });

    // Solo números
    [inputs.cedula, inputs.telefono].forEach(input => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/\D/g, '');
            if (input.name === "cedula" && (input.value.length < 6 || input.value.length > 8)) {
                errores[input.name].textContent = "Debe tener entre 7 y 8 dígitos";
            } else if (input.name === "telefono" && (input.value.length < 11 || input.value.length > 11)) {
                errores[input.name].textContent = "Debe tener 11 dígitos";
            } else {
                errores[input.name].textContent = "";
            }
        });
    });

    // Correo
    inputs.correo.addEventListener('input', () => {
        const regex = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;
        errores.correo.textContent = regex.test(inputs.correo.value) ? "" : "Correo no válido";
    });

    // Contraseña
    inputs.contrasena.addEventListener('input', () => {
        const valid = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        errores.contrasena.textContent = valid.test(inputs.contrasena.value)
            ? ""
            : "Mínimo 8 caracteres, con al menos una mayúscula, un número y un carácter especial";
    });

    // Confirmar contraseña
    inputs.confirmar.addEventListener('input', () => {
        errores.confirmar.textContent = inputs.confirmar.value !== inputs.contrasena.value
            ? "Las contraseñas no coinciden"
            : "";
    });

    // Validar todo al enviar
    form.addEventListener('submit', (e) => {
        let valido = true;

        Object.keys(errores).forEach(key => {
            if (errores[key].textContent !== "") {
                valido = false;
            }
        });

        if (!valido) {
            e.preventDefault();
        }
    });
});