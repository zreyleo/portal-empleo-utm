import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import Swal from 'sweetalert2';
import Axios from 'axios';

const FormularioEliminar = ({ ruta, csrf, pregunta = 'Seguro de querer eliminar?', cancelMessage = 'Accion cancelada' }) => {
    const handleSubmit = (event) => {
        event.preventDefault();

        Swal.fire({
            title: pregunta,
            showDenyButton: true,
            confirmButtonText: 'Eliminar',
            denyButtonText: `No Eliminar`,
        }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire('Eliminado!', '', 'success')

            setTimeout(() => {
                Axios.post(ruta, {
                    _method: 'DELETE',
                    _token: csrf
                }).then(() => {
                    location.reload(true);
                });
            }, 250)
        } else if (result.isDenied) {
            Swal.fire(cancelMessage, '', 'info')
        }
        });

        return;
    }

    return (
        <form onSubmit={handleSubmit}>
            <input type="submit" value="Eliminar" className="btn btn-danger" />
        </form>
    );

}

export default FormularioEliminar;

// if (document.getElementById('formulario-eliminar')) {
//     const props = Object.assign({}, document.getElementById('formulario-eliminar').dataset);
//     ReactDOM.render(<FormularioEliminar { ...props } />, document.getElementById('formulario-eliminar'));
// }

const formulariosEliminar = document.getElementsByClassName('formulario-eliminar');

if (formulariosEliminar.length) {
    Array.prototype.forEach.call(formulariosEliminar, (formulario) => {
        const props = Object.assign({}, formulario.dataset);
        ReactDOM.render(<FormularioEliminar { ...props } />, formulario);
    })
}
