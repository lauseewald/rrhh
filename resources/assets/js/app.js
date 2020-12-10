
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('empleado', require('./components/Empleado.vue'));
Vue.component('incidencia', require('./components/Incidencia.vue'));
Vue.component('puesto', require('./components/Puesto.vue'));
Vue.component('contrato', require('./components/Contrato.vue'));
Vue.component('evento', require('./components/Evento.vue'));
Vue.component('departamento', require('./components/Departamento.vue'));
Vue.component('areal', require('./components/Area.vue'));
Vue.component('empresa', require('./components/Empresa.vue'));
Vue.component('dianolaboral', require('./components/DiaNoLaboral.vue'));
Vue.component('inasistencia', require('./components/Inasistencia.vue'));
Vue.component('competencia1', require('./components/Competencia.vue'));
Vue.component('empleadoreporte2', require('./components/EmpleadoReporte.vue'));

const app = new Vue({
    el: '#app',
    data: {
        menu : 0
    }
});
