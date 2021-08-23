import React, { Fragment, useEffect, useState } from 'react';
import ReactDOM from 'react-dom';

function FacultadesCarrerasSelects(props) {
    const { carreras, carrera_id } = props;
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

    // console.log(carrerasSelect);

    useEffect(() => {
        console.log(facultadSelect)
        const carreras = carrerasOriginalArray.filter(carrera => carrera.nombre_facultad == facultadSelect);
        setCarrerasSelectOptions(carreras)
    }, [facultadSelect]);

    return (
        <Fragment>
            <div className="form-group">
                <label htmlFor="area">&Aacute;rea</label>
                <select
                    className="form-control"
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
            </div>

            <div className="form-group">
                <label htmlFor="carrera">Carrera</label>
                <select
                    className="form-control"
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
            </div>
        </Fragment>
    );
}

export default FacultadesCarrerasSelects;

if (document.getElementById('facultades-carreras-selects')) {
    const props = Object.assign({}, document.getElementById('facultades-carreras-selects').dataset);
    ReactDOM.render(<FacultadesCarrerasSelects { ...props } />, document.getElementById('facultades-carreras-selects'));
}
