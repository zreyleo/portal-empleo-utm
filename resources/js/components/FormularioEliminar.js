import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';

const FormularioEliminar = ({ mensaje, clase }) => {
    const [clases, setClases] = useState('');

    const [visible, setVisible] = useState(true);

    useEffect(() => {
        setClases(`visible text-white ${clase}`);
        setTimeout(() => {
            setClases('');

            setTimeout(() => {
                setVisible(false);
            }, 501);
        }, 3000);
    }, []);

    if (visible) {
        return (
            <div className={`notificacion ${clases}`}>
                { mensaje }
            </div>
        );
    } else {
        return null;
    }

}

export default Notificacion;

if (document.getElementById('formulario-eliminar')) {
    const props = Object.assign({}, document.getElementById('formulario-eliminar').dataset);
    ReactDOM.render(<FormularioEliminar { ...props } />, document.getElementById('formulario-eliminar'));
}
