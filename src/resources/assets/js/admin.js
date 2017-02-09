//window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
//require('bootstrap-sass');
window.Vue = require('vue');
window.VueRouter = require('vue-router');
window.VueResource = require('vue-resource');
//window.axios = require('axios');
//window.axios.defaults.headers.common = {
//    'X-Requested-With': 'XMLHttpRequest'
//};
import ElementUI from 'element-ui';
//import 'element-ui/lib/theme-default/index.css';

import App from './App.vue';
import Home from './components/Home.vue';
import Signin from './components/Signin.vue'

Vue.use(ElementUI);
Vue.use(VueRouter);

Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');

var router = new VueRouter({
    routes: [{
        path: '/',
        component: Home
    },{
        path: '/signin',
        component: Signin
    }]
});


router.beforeEach((to, from, next) =>{
    let token = localStorage.getItem('token');
    Vue.http.headers.common['Authorization'] = 'Bearer ' + token
    if(to.path == '/signin'){
        next();
    }
    if(token == null){
        next('/signin');
    }
    next();
})
const app = new Vue({
    router: router,
    render: h => h(App) 
}).$mount('#app')
