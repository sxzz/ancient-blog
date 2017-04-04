<?php
namespace app\common\behavior;

class getDbConfig
{
    public function run(&$params)
    {
        config('db_data', model('Config')->getAllConfig());
    }
}
