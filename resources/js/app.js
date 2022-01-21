/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

require('./components/Example');
require('./components/FacultadesCarrerasSelects');
require('./components/Notificacion');
require('./components/ProvinciasCantonesParroquiasSelects');
require('./components/ProvinciasCantonesParroquiasSelects2');
require('./components/FormularioEliminar');
require('./components/FormularioAnularConDetalle');
require('./components/CambiarRepresentante');
require('./components/BuscarPersonal');

// console.log('hola')

$(document).ready(function () {

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

});

// prevents attachments:
document.addEventListener("trix-file-accept", function(event) {
    event.preventDefault();
});
