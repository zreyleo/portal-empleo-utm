import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import Swal from 'sweetalert2';
import Axios from 'axios';
import { isValidDNI } from 'ec-dni-validator';

const CambiarRepresentante = ({
    rutaBase
}) => {
    const [buscar, setBuscar] = useState(true);
    const [cedula, setCedula] = useState('');
    const [cedulaError, setCedulaError] = useState(false);
    const [representante, setRepresentante] = useState({});

    const handleChangeCedula = (event) => {
        setCedula(event.target.value);
    }

    const handleSubmitBuscar = (event) => {
        event.preventDefault();

        if (!isValidDNI(cedula)) {
            setCedulaError(true);
            return;
        } else {
            setCedulaError(false);
        }

        Swal.fire('Buscando...', '', 'warning')
        Axios.get(rutaBase + `/${cedula}`)
            .then(response => {
                console.log(response);
                Swal.fire('Persona encontrada', '', 'success');
                setRepresentante(response.data.data);
            })
            .catch(error => {
                console.log(error);
                Swal.fire('Persona no encontrada', '', 'error');
                setRepresentante({});
            });
    }

    const form = buscar
        ? (
            <form onSubmit={handleSubmitBuscar}>
                <div className="form-group">
                    <label>C&eacute;dula</label>
                    <input type="text" className="form-control"
                        value={cedula}
                        onChange={handleChangeCedula}
                    />
                    {
                    cedulaError && (
                        <span className="invalid-feedback d-block" role="alert">La c&eacute;dula no es v&aacute;lida</span>
                    )
                }
                </div>

                <input type="submit" value="Buscar" className="btn btn-primary" />
            </form>
        ) : (
            <p>form para registrar</p>
        );

    return (
        <>
            <div className="col-md-6">
                <button onClick={e => setBuscar(!buscar)}>cambiar</button>
                {form}
            </div>

            <div className="col-md-6">
                { rutaBase }
                <div className="form-group">
                    <label >C&eacute;dula</label>
                    <input type="text" disabled className="form-control" value={representante.cedula} />
                </div>

                <div className="form-group">
                    <label>Apellido Paterno</label>
                    <input type="text" disabled className="form-control" value={representante.apellido1} />
                </div>

                <div className="form-group">
                    <label>Apellido Materno</label>
                    <input type="text" disabled className="form-control" value={representante.apellido2} />
                </div>

                <div className="form-group">
                    <label >Nombres</label>
                    <input type="text" disabled className="form-control" value={representante.nombres} />
                </div>

                <div className="form-group">
                    <label >Cargo en la Empresa</label>
                    <input type="text" disabled className="form-control" value={representante.titulo} />
                </div>

                <div className="form-group">
                    <label >G&eacute;nero</label>
                    <input type="text" disabled className="form-control" value={representante.genero == 'M' ? 'MASCULINO' : representante.genero == 'F' ? 'FEMENINO' : '' } />
                </div>
            </div>
        </>
    );

}

export default CambiarRepresentante;

if (document.getElementById('cambiar-representante')) {
    const props = Object.assign({}, document.getElementById('cambiar-representante').dataset);
    ReactDOM.render(<CambiarRepresentante { ...props } />, document.getElementById('cambiar-representante'));
}
