require('./bootstrap');

// window.Vue = require('vue');

import Vue from 'vue';
import VueRouter from 'vue-router';



Vue.use(VueRouter);

//Route Imported

import {routes} from './routes';

//import user class

import User from './Helpers/User';
window.User=User;

//Notification

import Notification from './Helpers/Notification';
window.Notification=Notification;

import Swal from 'sweetalert2'
window.Swal=Swal;

 
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 2000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
window.Toast=Toast;

const router = new VueRouter({
    routes,
    mode:'history'
})

const app = new Vue({
    el: '#app',
    router
});
 