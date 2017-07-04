# awesome-admin
A admin framework of laravel

## Requirement

* Laravel 5

## Installation

1. run `composer require "friparia/admin:dev-master"`
2. add a line in providers in `config/app.php`
`Friparia\Admin\AdminServiceProvider::class,`
3. run `npm i -S vue-router vue-resource pug vue-style-loader element-ui stylus stylus-loader`
4. in your webpack.mix.js add 
```js
.js('./resources/assets/friparia/admin/admin.js', 'public/js')
```
and
```js
mix.webpackConfig({
    resolve:{
        alias: {
            'vue-router$': 'vue-router/dist/vue-router.common.js'
        }
    }
});
```
5. rm default users table migrations and run `php artisan vendor:publish`
6. run `php artisan migrate`
7. run `php artisan jwt:generate`
8. change config/auth `$config['providers']['users']['model']` value to "\\Friparia\\Admin\\Models\\User"
9. create a superuser
`php artisan admin:create-superuser`
10. run npm!
