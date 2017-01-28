<?php
/**
 * Created by PhpStorm.
 * User: friparia
 * Date: 16/4/6
 * Time: 23:48
 */

namespace Friparia\Admin\Models;

use Friparia\Admin\Model;

class Menu extends Model
{
    protected function configure()
    {
        $this->addField('integer', 'pid');
        $this->addField('string', 'name');
        $this->addField('string', 'url')->nullable();
        $this->addField('integer', 'weight');
    }

}
