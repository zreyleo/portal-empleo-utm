import React, { Fragment, useEffect, useState } from 'react';
import ReactDOM from 'react-dom';

function FacultadesCarrerasSelects(props) {
    const { carreras, carrera_id, invalid } = props;
    const carrerasOriginalArray = JSON.parse(carreras);

    // console.log(carrera_id);

    let facultad = '';

    const facultades = [];
    carrerasOriginalArray.forEach(carrera => {
        if (!facultades.includes(carrera.nombre_facultad)) {
            facultades.push(carrera.nombre_facultad)
        }

        if (carrera_id && carrera_id == carrera.idescuela) {
            facultad = carrera.nombre_facultad;
        }
    });

    facultades.pop(); // eliminar registro que esta vacio
    // console.log(facultades)

    const [carrerasSelectOptions, setCarrerasSelectOptions] = useState([]);
    const [carrerasSelect, setCarrerasSelect] = useState(carrera_id || '');
    const [facultadSelect, setFacultadSelect] = useState(facultad || '');
    const [facultadesCarrerasSelectsClasses, setFacultadesCarrerasSelectClasses] = useState('form-control');

    // console.log(carrerasSelect);

    useEffect(() => {
        const carreras = carrerasOriginalArray.filter(carrera => carrera.nombre_facultad == facultadSelect);
        setCarrerasSelectOptions(carreras)
        setFacultadesCarrerasSelectClasses(invalid ? 'form-control is-invalid' : 'form-control')
    }, [facultadSelect]);

    return (
        <Fragment>
            <div className="form-group">
                <label htmlFor="area">&Aacute;rea</label>
                <select
                    className={facultadesCarrerasSelectsClasses}
                    id="area"
                    value={facultadSelect}
                    onChange={e => setFacultadSelect(e.target.value)}
                >
                    <option value="" disabled>-- seleccione --</option>
                    {
                        facultades.map((facultad, i) => (
                            <option value={facultad} key={i}>{facultad}</option>
                        ))
                    }
                </select>
                {
                    invalid ? (
                        <span
                            className="invalid-feedback d-block" role="alert"
                        >Seleccione una area para despues seleccionar una carrera.</span>
                    ) : null
                }
            </div>

            <div className="form-group">
                <label htmlFor="carrera">Carrera</label>
                <select
                    className={facultadesCarrerasSelectsClasses}
                    name="carrera"
                    id="carrera"
                    value={carrerasSelect}
                    onChange={e => setCarrerasSelect(e.target.value)}
                >
                    <option value="" disabled>-- seleccione --</option>
                    {
                        carrerasSelectOptions.map(option => (
                            <option key={option.idescuela} value={option.idescuela}>{option.nombre_carrera}</option>
                        ))
                    }
                </select>
                {
                    invalid ? (
                        <span
                            className="invalid-feedback d-block" role="alert"
                        >El campo carrera es obligatorio.</span>
                    ) : null
                }
            </div>
        </Fragment>
    );
}

export default FacultadesCarrerasSelects;

if (document.getElementById('facultades-carreras-selects')) {
    const props = Object.assign({}, document.getElementById('facultades-carreras-selects').dataset);
    ReactDOM.render(<FacultadesCarrerasSelects { ...props } />, document.getElementById('facultades-carreras-selects'));
}
