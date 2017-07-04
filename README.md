# awesome-admin
A admin framework of laravel

## Feature

 * Auto generated migrations
 * Auto generated admin control panel
 * Clearly written model actions 
 * One action can use in restful api and admin control panel
 * Role based permission control included
 * Absolutely compatible with Laravel and your previous codes or project

## Requirement

* Laravel 5

## Installation

First, add a line in the section of `require` in `composer.json` file:

    "friparia/admin": "dev-master"
    
and run `composer update`, or, you can execute the following command:

1. composer require "friparia/admin:dev-master"
2. Friparia\Admin\AdminServiceProvider::class,
3. npm i -S vue-router vue-resource pug vue-style-loader element-ui stylus stylus-loader
4. webpack.mix.js add 
```js
.js('./resources/assets/friparia/admin/admin.js', 'public/js')
mix.webpackConfig({
resolve:{
alias: {
'vue-router$': 'vue-router/dist/vue-router.common.js'
}
}
});
```
5. rm default users table  and run `php artisan vendor:publish`
6. run `php artisan migrate`
7. run `php artisan jwt:generate`
8. change config/auth `$config['providers']['users']['model']` to "\\Friparia\\Admin\\Models\\User"
9. create a superuser
`php artisan admin:create-superuser`
10. run npm!
    :w
