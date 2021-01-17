/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Axios from 'axios'
import moment from 'moment';

import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

import DataTable from 'laravel-vue-datatable';
Vue.use(DataTable);

Vue.use(VueToast, {
    position: 'top-right',
    duration: 5000
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.mixin({
    methods: {
        prettifyNumber: function (value) {
            if (value === 0)
                return 0;

            if (value > 1)
                return value.toFixed(1);

            if (value > 0.01)
                return value.toFixed(3);

            if (value > 0.001)
                return value.toFixed(4);

            if (value > 0.0001)
                return value.toFixed(5)

            return value.toFixed(8);
        },
        getStatus(status) {
            switch (status) {
                case 'pending':
                    return 'В обработке';
                case 'completed':
                    return 'Выполнена';
            }
        },
        getRole(role) {
            switch (role) {
                case 'admin':
                    return 'Администратор';
                case 'user':
                    return 'Пользователь';
            }
        }
    },
});

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.prototype.$axios = Axios;
Vue.prototype.$moment = moment;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
