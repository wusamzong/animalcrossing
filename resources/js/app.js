require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router';
import VueCookie from 'vue-cookie';
Vue.use(VueRouter);
Vue.use(VueCookie);

import routes from './routes';
const router = new VueRouter({
  routes
});
Vue.component('spinner',require('vue-simple-spinner'));




import App from './App.vue';

new Vue({
  router,
  render: h =>h(App)
}).$mount('#app');