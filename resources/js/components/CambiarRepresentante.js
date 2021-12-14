import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import Swal from 'sweetalert2';
import Axios from 'axios';
import { isValidDNI } from 'ec-dni-validator';

const CambiarRepresentante = ({
    rutaBase,
    rutaRegistro,
    rutaExito,
    csrf
}) => {
    const [buscar, setBuscar] = useState(true);
    const [cedula, setCedula] = useState('');
    const [cedulaError, setCedulaError] = useState('');
    const [registroError, setRegistroError] = useState(false);
    const [representante, setRepresentante] = useState({});
    const [idRepresentante, setIdRepresentante] = useState(null);
    const [apellido1, setApellido1] = useState('');
    const [apellido2, setApellido2] = useState('');
    const [nombres, setNombres] = useState('');
    const [titulo, setTitulo] = useState('');
    const [genero, setGenero] = useState('');

    const resetRegisterForm = () => {
        setCedula('');
        setApellido1('');
        setApellido2('');
        setNombres('');
        setTitulo('');
        setGenero('');
    }

    const handleChangeCedula = (event) => {
        setCedula(event.target.value);
    }

    const handleClickBuscar = () => {
        setBuscar(!buscar)
        setRepresentante({});
        setIdRepresentante(null);
        resetRegisterForm();
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
                console.log(response)
                Swal.fire('Persona encontrada', '', 'success');
                setRepresentante(response.data.data);
                setIdRepresentante(response.data.data.id_personal_externo);
            })
            .catch(error => {
                Swal.fire('Persona no encontrada', '', 'error');
                setRepresentante({});
                setIdRepresentante(null);
            });
    }

    const handleSubmitRegistrar = (event) => {
        event.preventDefault();

        if (!isValidDNI(cedula)) {
            setCedulaError('No es un número de cedula válido');
            return;
        } else {
            Axios.get(rutaBase + `/${cedula}`)
                .then(response => {
                    Swal.fire('Esta cédula ya está registrada', '', 'warning');
                    setRepresentante(response.data.data);
                    setIdRepresentante(response.data.data.id_personal_externo);
                    setBuscar(true);
                })
                .catch(error => {
                    if (!apellido1 || !apellido2 || !nombres || !titulo || !genero) {
                        setRegistroError(true);
                        return;
                    }

                    Swal.fire('Registrando...', '', 'warning');
                    Axios.post(rutaRegistro, {
                        _token: csrf,
                        cedula,
                        apellido1,
                        apellido2,
                        nombres,
                        titulo,
                        genero
                    }).then(response => {
                        Swal.fire('Representante Registrad@!', '', 'success');

                        setTimeout(() => {
                            window.location.assign(rutaExito);
                        }, 250);
                    });
                });
            setCedulaError('');
        }
    }

    const handleClickActualizar = () => {
        Axios.put(rutaRegistro, {
            _token: csrf,
            id_personal_externo: idRepresentante
        }).then(() => {
            Swal.fire('Representante Actualizad@!', '', 'success');

            setTimeout(() => {
                window.location.assign(rutaExito);
            }, 250);
        });

    }

    const form = buscar
        ? (
            <>
                <form onSubmit={handleSubmitBuscar}>
                    <div className="form-group">
                        <label>C&eacute;dula</label>
                        <input type="text" className="form-control"
                            value={cedula}
                            onChange={handleChangeCedula}
                        />
                        {
                            cedulaError && (
                                <span className="invalid-feedback d-block" role="alert">{cedulaError}</span>
                            )
                        }
                    </div>

                    <input type="submit" value="Buscar" className="btn btn-primary" />
                </form>

                <button disabled={!idRepresentante} onClick={handleClickActualizar} className="mt-5 btn btn-success">Actualizar Representante</button>
            </>

        ) : (
            <form onSubmit={handleSubmitRegistrar}>
                <fieldset>
                    <legend>Persona que representa a Recursos Humanos</legend>

                    <div className="form-group">
                        <label>C&eacute;dula</label>
                        <input className="form-control" name="cedula"
                            value={cedula}
                            onChange={handleChangeCedula}
                        />

                        {
                            cedulaError && (
                                <span className="invalid-feedback d-block" role="alert">{cedulaError}</span>
                            )
                        }
                    </div>

                    <div className="form-group">
                        <label>Apellido Paterno</label>
                        <input className="form-control text-uppercase" name="cedula"
                            value={apellido1}
                            onChange={e => setApellido1(e.target.value)}
                        />
                        {
                            (registroError && !apellido1) && (
                                <span className="invalid-feedback d-block" role="alert">Este campo es requerido</span>
                            )
                        }
                    </div>

                    <div className="form-group">
                        <label>Apellido Materno</label>
                        <input className="form-control text-uppercase" name="cedula"
                            value={apellido2}
                            onChange={e => setApellido2(e.target.value)}
                        />
                        {
                            (registroError && !apellido2) && (
                                <span className="invalid-feedback d-block" role="alert">Este campo es requerido</span>
                            )
                        }
                    </div>

                    <div className="form-group">
                        <label>Nombres</label>
                        <input className="form-control text-uppercase" name="cedula"
                            value={nombres}
                            onChange={e => setNombres(e.target.value)}
                        />
                        {
                            (registroError && !nombres) && (
                                <span className="invalid-feedback d-block" role="alert">Este campo es requerido</span>
                            )
                        }
                    </div>

                    <div className="form-group">
                        <label>Cargo en la Empresa o T&iacute;tulo</label>
                        <input className="form-control text-uppercase" name="cedula"
                            value={titulo}
                            onChange={e => setTitulo(e.target.value)}
                        />
                        {
                            (registroError && !titulo) && (
                                <span className="invalid-feedback d-block" role="alert">Este campo es requerido</span>
                            )
                        }
                    </div>

                    <div className="form-group">
                        <label>G&eacute;nero</label>

                        <select
                            value={genero}
                            onChange={e => setGenero(e.target.value)}
                            className={'form-control'}
                        >
                            <option disabled value="">-- seleccione --</option>
                            <option value="M">MASCULINO</option>
                            <option value="F">FEMENINO</option>
                        </select>
                        {
                            (registroError && !genero) && (
                                <span className="invalid-feedback d-block" role="alert">Este campo es requerido</span>
                            )
                        }
                    </div>
                </fieldset>

                <input type="submit" className="btn btn-primary" value="Registrar y Cambiar" />
            </form>
        );

    const datosRepresentante = buscar
            ? (
                <>
                    <div className="form-group">
                        <label>C&eacute;dula</label>
                        <p type="text"  className="form-control">{representante.cedula}</p>
                    </div>

                    <div className="form-group">
                        <label>Apellido Paterno</label>
                        <p type="text" className="form-control">{representante.apellido1}</p>
                    </div>

                    <div className="form-group">
                        <label>Apellido Materno</label>
                        <p type="text" className="form-control">{representante.apellido2}</p>
                    </div>

                    <div className="form-group">
                        <label>Nombres</label>
                        <p type="text" className="form-control">{representante.nombres}</p>
                    </div>

                    <div className="form-group">
                        <label>Cargo en la Empresa</label>
                        <p type="text" className="form-control">{representante.titulo}</p>
                    </div>

                    <div className="form-group">
                        <label>G&eacute;nero</label>
                        <p type="text" className="form-control">
                            { representante.genero == 'M' ? 'MASCULINO' : representante.genero == 'F' ? 'FEMENINO' : '' }
                        </p>
                    </div>
                </>
            ) : (
                <p>Alerta</p>
            );

    return (
        <>
            <div className="col-md-6">
                <button onClick={handleClickBuscar} className="btn btn-info mb-5">{ buscar ? 'Registrar' : 'Buscar' }</button>
                {form}
            </div>

            <div className="col-md-6">
                { datosRepresentante }
            </div>
        </>
    );

}

export default CambiarRepresentante;

if (document.getElementById('cambiar-representante')) {
    const props = Object.assign({}, document.getElementById('cambiar-representante').dataset);
    ReactDOM.render(<CambiarRepresentante { ...props } />, document.getElementById('cambiar-representante'));
}
