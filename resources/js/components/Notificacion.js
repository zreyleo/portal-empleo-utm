import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';

const Notificacion = ({ mensaje, clase }) => {
    const [clases, setClases] = useState('');

    const [visible, setVisible] = useState(true);

    useEffect(() => {
        setClases(`visible text-white ${clase}`);
        console.log('hola');
        setTimeout(() => {
            setClases('');

            setTimeout(() => {
                console.log('ciao');
                setVisible(false);
            }, 500);
        }, 2500);
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

if (document.getElementById('notificacion')) {
    const props = Object.assign({}, document.getElementById('notificacion').dataset);
    ReactDOM.render(<Notificacion { ...props } />, document.getElementById('notificacion'));
}
