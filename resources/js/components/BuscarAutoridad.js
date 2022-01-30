import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import { isValidDNI } from 'ec-dni-validator';
import Axios from 'axios';
import Swal from 'sweetalert2';

const BuscarAutoridad = (props) => {
    const { rutaBuscar } = props

    const [cedula, setCedula] = useState('');
    const [cedulaError, setCedulaError] = useState('');
    const [personal, setPersonal] = useState({});
    const [apellido1, setApellido1] = useState('');
    const [apellido2, setApellido2] = useState('');
    const [nombres, setNombres] = useState('');
    const [genero, setGenero] = useState('');

    const handleChangeCedula = (event) => {
        if (cedulaError) setCedulaError('');

        setCedula(event.target.value);
    }

    const handleClick = event => {
        if (!isValidDNI(cedula)) {
            setCedulaError('No es un número de cedula válido');

            return;
        }

        Swal.fire('Buscando...', '', 'info');

        Axios.get(rutaBuscar + '/' + cedula)
            .then(response => {
                setPersonal(response.data)
                setApellido1(response.data.apellido1)
                setApellido2(response.data.apellido2)
                setNombres(response.data.nombres)
                setGenero(response.data.genero)
                Swal.fire('Personal Encontrado', '', 'success');
            }).catch(error => {
                console.error(error)
                Swal.fire('Hubo un error!', 'Intente más tarde...', 'error');
            })
    }

    return (
        <>
            <div className='form-group'>
                <p>
                    En el siguiente cuadro escriba el n&uacute;mero de cedula de la persona que es autoridad en el departamento.
                </p>

                <div className='form-group'>
                    <label>Cedula</label>
                    <input type="text" className={`form-control ${cedulaError && 'is-invalid'}`}
                        value={cedula}
                        onChange={handleChangeCedula}
                        name='cedula'
                    />
                    {
                        cedulaError && (
                            <span className="invalid-feedback d-block" role="alert">{cedulaError}</span>
                        )
                    }

                    <input
                        type="hidden"
                        value={apellido1}
                        name='apellido1'
                    />
                    <input
                        type="hidden"
                        value={apellido2}
                        name='apellido2'
                    />
                    <input
                        type="hidden"
                        value={nombres}
                        name='nombres'
                    />
                    <input
                        type="hidden"
                        value={genero}
                        name='genero'
                    />
                </div>

                <button onClick={handleClick} className='btn btn-info'
                    type='button'
                >Buscar</button>

                <div className='form-group'>
                    <label>Personal</label>
                    <p className='form-control'>{personal.apellido1} {personal.apellido2} {personal.nombres}</p>
                </div>
            </div>
        </>
    );
}

export default BuscarAutoridad;

if (document.getElementById('buscar-autoridad')) {
    const props = Object.assign({}, document.getElementById('buscar-autoridad').dataset);
    ReactDOM.render(<BuscarAutoridad { ...props } />, document.getElementById('buscar-autoridad'));
}
