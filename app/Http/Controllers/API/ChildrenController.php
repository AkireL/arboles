<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Main\Node\Domain\WhereNodeDomain;
use App\Main\Node\Domain\WhereNodesDomain;
use App\Node;
use Illuminate\Http\Request;

class ChildrenController extends Controller
{
    public function index(int $nodeId, Request $request)
    {
        try {
            $index = $request->input('page') ?? 0;
            $byPage = 3;
            $whereNodeDomain = new WhereNodeDomain();

            //Search node with by parentId
            $NodesFathers = ($whereNodeDomain)(['parent_id' => $nodeId, 'deleted_at' => null]);
            if (is_null($NodesFathers)) {
                throw new \Exception('Árbol vacio');
            }
            // Search node by Id
            $NodeFather = $whereNodeDomain(['id' => $nodeId, 'deleted_at' => null]);

            $data = collect(array_merge([$NodeFather->toArray()], $this->getChild($NodesFathers->toArray())));
            $inicio = ($byPage * $index);

            return response()->json(($data->slice($inicio, $byPage))->all(), 200);
        } catch (\Exception $ex) {
            \Log::error('ex: '.print_r($ex->getMessage(), 1));
            $code = (int) $ex->getCode();
            if (!(($code >= 400 && $code <= 422) || ($code >= 500 && $code <= 503))) {
                $code = 500;
            }

            return response()->json([
            'code' => (int) $code,
            'message' => $ex->getMessage(),
            'data' => $ex->getMessage(),
        ], $code);
        }
    }

    private function getChild($node)
    {
        $tree = [];
        $children = [];
        $tree[] = $node;

        $data = (new WhereNodesDomain())(['parent_id' => $node['id'], 'deleted_at' => null]);
        foreach ($data as $d) {
            $first = $this->getChild($d->toArray());
            $tree = array_merge($tree, $first);
        }

        return $tree;
    }
}
