<?php

namespace App\Main\Node\Domain;

use App\Node;

class WhereNodesDomain
{
    public function __invoke($where)
    {
        $NodesFathers = Node::where($where)->get();

        return $NodesFathers;
    }
}
