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

//Vue.http.headers.common['X-CSRF-TOKEN'] = document.getElementsByName('csrf-token')[0].getAttribute('content');
//Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');


Vue.use(ElementUI);
Vue.use(VueRouter);

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
    if(to.path == '/signin'){
        next();
    }
    if(token == null){
        next('/signin');
    }
    next();
    // next('/signin');
    /**
    if(token == 'null' || token == null){
        Bus.$emit('login','/login');
    }else{
        Bus.$emit('login','/loginfo');
    }
    if(to.path == '/login'){
        if(token != 'null' && token != null){
            next('/loginfo')
        }
        next();
    }else{
        if(token != "null" && token != null){
            Vue.http.headers.common['Authorization'] = 'Bearer ' + token 
            next();
        }else{
            console.log('log')
            Bus.$emit('login','/login')
            next('/login');
        }
    }
    */
})
const app = new Vue({
    router: router,
    render: h => h(App) 
}).$mount('#app')
