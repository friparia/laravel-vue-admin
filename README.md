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



### Route
#### Api
#### Admin
### Model Actions
