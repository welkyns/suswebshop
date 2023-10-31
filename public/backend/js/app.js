
window._ = require('lodash');

/**
 * Carga jQuery y el complemento jQuery Bootstrap que proporciona soporte.
  * para funciones Bootstrap basadas en JavaScript, como modales y pestañas.
  * el código puede modificarse para adaptarse a las necesidades específicas.
 */

window.Vue = require('vue');

/**
 * Carga la biblioteca HTTP de axios que permite emitir solicitudes fácilmente
  * al back-end de Laravel. Esta biblioteca maneja automáticamente el envío del
  * Token CSRF como encabezado basado en el valor de la cookie del token "XSRF".
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * A continuación registra el token CSRF como encabezado común con Axios para que
  * todas las solicitudes HTTP salientes lo tienen adjunto automáticamente. Esto me conviene
  *  para que no tengam que adjuntar cada token manualmente.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * El siguiente bloque de código se puede utilizar para registrar automáticamente:
  * Componentes de Vue. Escaneará recursivamente este directorio en busca de Vue.
  * componentes y registrarlos automáticamente con su "nombre base".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import VueSwal from 'vue-swal';
Vue.use(VueSwal);

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Se crea una nueva instancia de aplicación Vue y se adjunta a
  * la página. Luego, podrá comenzar a agregar componentes a esta aplicación.
  * o puedo personalizar la estructura de JavaScript para adaptarlo seg necesidades.
 */

const app = new Vue({
    el: '#app'
});

Vue.component('attribute-values', require('./components/AttributeValues.vue').default);
Vue.component('product-attributes', require('./components/ProductAttributes').default);
