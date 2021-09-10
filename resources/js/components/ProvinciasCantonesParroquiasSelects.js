import React, { Fragment, useEffect, useState } from 'react';
import ReactDOM from 'react-dom';

function ProvinciasCantonesParroquiasSelects(props) {
    // const { url } = props;

    const [provincias, setProvincias] = useState([]); // array de provincias
    const [idProvincia, setIdProvincia] = useState('');

    const [cantones, setCantones] = useState([]); // array de provincias
    const [idCanton, setIdCanton] = useState('');

    const [parroquias, setParroquias] = useState([]); // array de provincias
    const [idParroquia, setIdParroquia] = useState('');

    const baseUrl = window.location.origin + '/api/provincias';

    // url para prubeas en el servidor de la universidad
    // const baseUrl = window.location.origin + '/portal-empleo-utm/public' + '/api/';

    useEffect(() => {
        fetch(baseUrl)
            .then(response => response.json())
            .then(provincias => setProvincias(provincias));
    }, []);

    useEffect(() => {
        setCantones([]);
        setIdCanton('');

        if (idProvincia) {
            fetch(`${baseUrl}/${idProvincia}`)
                .then(response => response.json())
                .then(cantones => setCantones(cantones));
        }
    }, [idProvincia]);

    useEffect(() => {
        setParroquias([]);
        setIdParroquia('');
        if (idCanton) {
            fetch(`${baseUrl}/${idProvincia}/${idCanton}`)
                .then(response => response.json())
                .then(parroquias => setParroquias(parroquias));
        }
    }, [idProvincia, idCanton]);

    return (
        <Fragment>
            <div className="form-group">
                <label htmlFor="id_provincia">Provincia</label>
                <select
                    id="id_provincia"
                    className="form-control"
                    value={idProvincia}
                    onChange={e => setIdProvincia(e.target.value)}
                >
                    <option value="" disabled>-- seleccione --</option>
                    {
                        provincias.map(provincia => {
                            return (
                                <option key={provincia.idprovincia}
                                    value={provincia.idprovincia}
                                >{provincia.nombre}</option>
                            )
                        })
                    }
                </select>
            </div>

            <div className="form-group">
                <label htmlFor="id_canton">Cant&oacute;n</label>
                <select className="form-control"
                    id="id_canton"
                    className="form-control"
                    value={idCanton}
                    onChange={e => setIdCanton(e.target.value)}
                >
                    <option value="" disabled>-- seleccione --</option>
                    {
                        cantones.map(canton => {
                            return (
                                <option key={canton.idcanton}
                                    value={canton.idcanton}
                                >{canton.nombre}</option>
                            )
                        })
                    }
                </select>
            </div>

            <div className="form-group">
                <label htmlFor="id_parroquia">Parroquia</label>
                <select className="form-control"
                    id="id_parroquia"
                    className="form-control"
                    value={idParroquia}
                    onChange={e => setIdParroquia(e.target.value)}
                >
                    <option value="" disabled>-- seleccione --</option>
                    {
                        parroquias.map(parroquia => {
                            return (
                                <option key={parroquia.idparroquia}
                                    value={parroquia.idparroquia}
                                >{parroquia.nombre}</option>
                            )
                        })
                    }
                </select>
            </div>

        </Fragment>
    )
}

export default ProvinciasCantonesParroquiasSelects;

if (document.getElementById('provincias-cantones-parroquias-selects')) {
    const props = Object.assign({}, document.getElementById('provincias-cantones-parroquias-selects').dataset);
    ReactDOM.render(<ProvinciasCantonesParroquiasSelects { ...props } />, document.getElementById('provincias-cantones-parroquias-selects'));
}
