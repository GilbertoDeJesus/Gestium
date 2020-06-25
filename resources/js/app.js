/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import 'material-design-icons-iconfont/dist/material-design-icons.css'

import moment from 'moment';

import Vuetify from "vuetify/lib";

Vue.use(Vuetify,  {
    iconfont: 'md',

});

import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.Toast = Toast;

const routes = [
    { path: '/home', component: require('./components/HomeComponent.vue').default},
    { path: '/providers', component: require('./components/ProviderComponent.vue').default},
    { path: '/customers', component: require('./components/CustomerComponent.vue').default},
    { path: '/credits', component: require('./components/CreditComponent.vue').default},
    { path: '/products', component: require('./components/ProductComponent.vue').default },
    { path: '/deliverers', component: require('./components/DelivererComponent.vue').default },
    { path: '/routes', component: require('./components/RouteComponent.vue').default },
    {path: '/warehouse_movement', component: require('./components/WarehouseMovementComponent.vue').default}
//    { path: '*', component: require('./components/404.vue').default}
]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

Vue.filter('formatDateTime', function(date) {
    return moment(date).locale('es').format('MMMM Do YYYY, h:mm a');
})

Vue.filter('formatDateTimeShort', function (date) {
    return moment(date).locale('es').format('MMMM Do YYYY');
})

Vue.filter('formatUpperCase', function(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ProviderComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify,
    router,
});
