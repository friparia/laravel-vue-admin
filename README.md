# awesome-admin
A admin framework of laravel

[中文版README](https://github.com/friparia/awesome-admin/blob/master/README.chs.md)

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
    
and run `composer install`, or, you can execute the following command:
    
    composer require "friparia/admin:dev-master"

Then, add a line of service provider in `config/app.php`:
    
    Friparia\Admin\AdminServiceProvider::class,
    
## Usage

### Definining Models
If you want to auto generate the admin control panel or make migrations between different code versions, you need to define your model with exact definations in a specific function named `construct()` like this:

```php
use Friparia\Admin\Model;
class TestModel extends Model{
    protected function construct(){
        $this->fields->string('name');
        $this->fields->integer('test_num');
        $this->fields->relation('test_guys')->hasMany('App\\TestGuys');
    }
}
```

What continued with the variable `$this->fields` is just the way in the [laravel](https://laravel.com/docs/5.2/migrations#creating-columns)

What's more, you can use more keywords to describe the information of a field:

 * relation
```php
$this->fields->relation('role')->hasManyToMany('App\\Role');
```

 * description
```php
$this->fields->string('name')->description('Name');
```
 * validator
```php
$this->fields->string('name')->validator('required');
```
 * validatorInClass
```php
$this->fields->string('name')->validatorInClass('required');
```

After your models has defined, you need to run migration command, use
    php artisan admin:migrate
to create tables and fields in the database.

### Route
If you want to use some default actions provided by this framework, you need to create controller and define the route. 

If you want to create a route points to a model called "Customer", first of all, you need to create a controller in you controllers directory called "CustomerController", of course, you can name the classname in any words. After creating the class, you need to extend from `Friparia\Admin\Controller` and define which model is this controller is related to, like this:

```php
namespcae App\Http\Controllers;
use Friparia\Admin\Controller as BaseController;
class CustomerController extends BaseController
{
    protected $model = "App\\Models\\Customer";
}
```

And then, you can define the route:

#### Api

You can define your api route like this:

    Friparia\Admin\Route::api('App\\Models\\Customer');

So you can have these default actions which returns json data:

 * /api/customer 
 
Show customer list

 * /api/customer/show/1
 
 Show the first customer info

 * /api/customer/create
 
 Create a customer, which you should post the info of the customer.

 * /api/customer/update/1
 
 Update a customer, which you should post the info of the customer.

 * /api/customer/delete/1
 
 Delete a customer.

What's more, route function can have four parameters:
    Route::api($model, $name, $classname, $prefix)
but the $name, $classname, $prefix will have the default value, if you like a `/apiv1/user` url which is point to `Customer` Model and `UserController`, you can define like this:
    Route::api('App\\Models\\Customer', 'user', 'UserController', 'apiv1');

### Model Actions

If you want to add customized action in a model, you can write that function in your model, and define it like this:

```php
class Customer extends Friparia\Admin\Model{
    protected $actions = [
        'check' => [
            //some config here
        ],
    ];
    
    public function check(){
        $this->is_checked = true;
        $this->save();
        return [];
    }
}
```

and we can have a route like this:
    /api/customer/check/1
so, we can check this user.

