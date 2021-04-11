<?php

namespace App\Main\Node\Domain;

use App\Node;

class WhereNodeDomain
{
    public function __invoke($where)
    {
        $NodesFathers = Node::where($where)->first();

        return $NodesFathers;
    }
}
