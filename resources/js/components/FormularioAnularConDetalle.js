import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import Swal from 'sweetalert2';
import Axios from 'axios';

const FormularioAnularConDetalle = ({
    ruta,
    rutaExito,
    csrf,
    pregunta = 'Seguro de querer anular?',
    cancelMessage = 'Accion cancelada'
}) => {
    // console.table([ruta, csrf])
    const [detalle, setDetalle] = useState('');
    const [required, setRequired] = useState(false);

    const handleSubmit = (event) => {
        event.preventDefault();

        if (!detalle) {
            setRequired(true)
            return;
        } else {
            setRequired(false);
        }

        Swal.fire({
            title: pregunta,
            icon: 'warning',
            showDenyButton: true,
            confirmButtonText: 'Anular',
            denyButtonText: `No Anular`,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire('Anulando...', '', 'warning')

            Axios.post(ruta, {
                _method: 'DELETE',
                _token: csrf,
                detalle
            }).then((reposnse) => {
                console.log(reposnse)
                Swal.fire('Anulada!', '', 'success');

                setTimeout(() => {
                    window.location.assign(rutaExito)
                }, 200);
            }).catch(() => {
                Swal.fire('Ocurrió un error', '', 'error')
            });
        } else if (result.isDenied) {
            Swal.fire(cancelMessage, '', 'info')
        }
        });

        return;
    }

    return (
        <form onSubmit={handleSubmit}>
            <div className="form-group">
                <label htmlFor="cometario">Raz&oacute;n para anular oferta de pr&aacute;ctica</label>

                <textarea
                    name="detalle"
                    id="comentario"
                    rows="5"
                    className={`form-control ${required && 'is-invalid'}`}
                    style={{
                        resize: 'none'
                    }}
                    value={detalle}
                    onChange={e => setDetalle(e.target.value)}
                ></textarea>

                {
                    required ? (
                        <span
                            className="invalid-feedback d-block" role="alert"
                        >Se tiene que especificar una raz&oacute;n para anular la oferta.</span>
                    ) : null
                }
            </div>

            <input type="submit" value="Anular" className="btn btn-danger" />
        </form>
    );

}

export default FormularioAnularConDetalle;

if (document.getElementById('formulario-anular-con-detalle')) {
    const props = Object.assign({}, document.getElementById('formulario-anular-con-detalle').dataset);
    ReactDOM.render(<FormularioAnularConDetalle { ...props } />, document.getElementById('formulario-anular-con-detalle'));
}

// const formulariosEliminar = document.getElementsByClassName('formulario-anular-con-detalle');

// if (formulariosEliminar.length) {
//     Array.prototype.forEach.call(formulariosEliminar, (formulario) => {
//         const props = Object.assign({}, formulario.dataset);
//         ReactDOM.render(<FormularioAnularConDetalle { ...props } />, formulario);
//     })
// }

