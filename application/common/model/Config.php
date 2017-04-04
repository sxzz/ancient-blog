<?php

namespace app\common\model;

use think\Model;

class Config extends Model
{
    public function getAllConfig()
    {
        return $this->column('name,value');
    }

    public function setConfig($name, $value)
    {
        return $this->where('name', $name)->setField('value', $value);
    }
}
