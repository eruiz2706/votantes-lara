
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
//require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes  =[
  {path : '/',name:'home',component:require('./components/HomeComponent.vue').default},
  {path : '/home',name:'home',component:require('./components/HomeComponent.vue').default},
  {path : '/home2',name:'home',component:require('./components/Home2Component.vue').default},
  {path : '/votante',name:'votante',component:require('./components/VotanteListaComponent.vue').default},
  {path : '/nuevo-votante',name:'nuevo-votante',component:require('./components/VotanteNuevoComponent.vue').default},
  {path : '/lideres',name:'lideres',component:require('./components/LideresListaComponent.vue').default},
  {path : '/example',name:'example',component:require('./components/ExampleComponent.vue').default},
  {path : '/example2',name:'example2',component:require('./components/Example2Component.vue').default}
  
];

const router  =new VueRouter({
  routes
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
//Vue.component('app-component', require('./components/AppComponent.vue').default);
Vue.component('app-component', require('./components/AppComponent.vue').default);
Vue.component('vue-select', require("vue-select2"));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router: router
});
