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
import List from './components/List.vue'
import { Message } from 'element-ui';

Vue.use(ElementUI);
Vue.use(VueRouter);

var router = new VueRouter({
    routes: [{
        path: '/',
        component: Home,
        children: [
            { path: '/user', component: List, name: 'user'},
        ]
    },{
        path: '/signin',
        component: Signin
    }]
});

Vue.http.interceptors.push(function(request, next){
    request.headers.set('Authorization', 'Bearer ' + sessionStorage.getItem('token'));
    next(function(response){
        if(response.status == 401){
            this.$router.push('/signin');
        }
        if(response.status == 500){
            Message.error("服务器错误");
        }
        if(response.status >= 400){
            Message.error(response.body.msg);
        }
    });
});

router.beforeEach((to, from, next) =>{
    if(to.path == '/signin'){
        next();
    }
    let token = sessionStorage.getItem('token');
    if(token == null){
        next('/signin');
    }
    next();
})
const app = new Vue({
    router: router,
    render: h => h(App) 
}).$mount('#app')
