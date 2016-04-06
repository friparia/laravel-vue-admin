# awesome-admin
A admin framework of laravel

[中文版README](https://github.com/friparia/awesome-admin/blob/master/README.chs.md)


## Installation

First, add a line in the section of `require` in `composer.json` file:

    "friparia/admin": "dev-master"
    
and run `composer install`, or, you can execute the following command:
    
    composer require "friparia/admin:dev-master"

Then, add a line of service provider in `config/app.php`:
    
    Friparia\Admin\AdminServiceProvider::class,
