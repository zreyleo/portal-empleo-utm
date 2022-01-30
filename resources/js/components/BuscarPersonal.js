import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import { isValidDNI } from 'ec-dni-validator';
import Axios from 'axios';
import Swal from 'sweetalert2';

const BuscarPersonal = (props) => {
    const { rutaBuscar, email, rutaRegistro, token, rutaExito } = props

    const [cedula, setCedula] = useState('');
    const [cedulaError, setCedulaError] = useState('');
    const [personal, setPersonal] = useState({});
    const [apellido1, setApellido1] = useState('');
    const [apellido2, setApellido2] = useState('');
    const [nombres, setNombres] = useState('');
    const [genero, setGenero] = useState('');
    const [nombreDepartamento, setNombreDepartamento] = useState('');

    const handleChangeCedula = (event) => {
        if (cedulaError) setCedulaError('');

        setCedula(event.target.value);
    }

    const handleClick = event => {
        if (!isValidDNI(cedula)) {
            setCedulaError('No es un número de cedula válido');

            return;
        }

        Axios.get(rutaBuscar + '/' + cedula)
            .then(response => {
                setPersonal(response.data)
                setApellido1(response.data.apellido1)
                setApellido2(response.data.apellido2)
                setNombres(response.data.nombres)
                setGenero(response.data.genero)
            })
    }

    const habilitarDepartamento = () => {
        if (!Object.keys(personal).length || !nombreDepartamento) {
            Swal.fire('No olvides Completar datos',
                'Falta la cedula de la Autoridad y/o Nombre del departamento', 'warning'
            );

            return
        }

        Swal.fire('Esperando...', '', 'info');

        Axios.post(rutaRegistro, {
            apellido1,
            apellido2,
            nombres,
            genero,
            nombreDepartamento,
            email,
            cedula,
            _token: token
        }).then(response => {
            console.log(response)
            Swal.fire('Departamento Habilitado!', '', 'success');
            setTimeout(() => {
                window.location.assign(rutaExito);
            }, 500);
        })
        .catch(error => {
            console.log(error)
            Swal.fire('¡Ocurrió un error!', '', 'error');
        });
    }

    return (
        <>
            <div className='col-md-6'>
                <p>
                    En el siguiente cuadro escriba el n&uacute;mero de cedula de la persona que es autoridad en el departamento.
                </p>

                <div className='form-group'>
                    <label>Cedula</label>
                    <input type="text" className={`form-control ${cedulaError && 'is-invalid'}`}
                        value={cedula}
                        onChange={handleChangeCedula}
                    />
                    {
                        cedulaError && (
                            <span className="invalid-feedback d-block" role="alert">{cedulaError}</span>
                        )
                    }
                </div>

                <button onClick={handleClick} className='btn btn-info'>Buscar</button>

                <div className='form-group'>
                    <label>Personal</label>
                    <p className='form-control'>{personal.apellido1} {personal.apellido2} {personal.nombres}</p>
                </div>
            </div>
            <div className='col-md-6'>
                <div className='form-group'>
                    <label>Nombre del departamento</label>
                    <input type="text" className='form-control text-uppercase'
                        value={nombreDepartamento}
                        onChange={e => setNombreDepartamento(e.target.value)}
                    />
                </div>
                <div className='form-group'>
                    <label>Email Departamental</label>
                    <p className='form-control'>{email}</p>
                </div>

                <button onClick={habilitarDepartamento} className='btn btn-primary'>Habilitar departamento</button>
            </div>
        </>
    );
}

export default BuscarPersonal;

if (document.getElementById('buscar-personal')) {
    const props = Object.assign({}, document.getElementById('buscar-personal').dataset);
    ReactDOM.render(<BuscarPersonal { ...props } />, document.getElementById('buscar-personal'));
}
