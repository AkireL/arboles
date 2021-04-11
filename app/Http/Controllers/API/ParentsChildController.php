<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Main\Node\Domain\WhereNodeDomain;
use App\Main\Node\Domain\WhereNodesDomain;
use Illuminate\Http\Request;

class ParentsChildController extends Controller
{
    public function index(int $nodeId, Request $request)
    {
        try {
            $index = $request->input('page') ?? 0;
            $byPage = 3;
            $whereNodeDomain = new WhereNodeDomain();

            // Search node by Id
            $NodesFathers = ($whereNodeDomain)(['id' => $nodeId]);
            if (is_null($NodesFathers)) {
                throw new \Exception('Árbol vacio');
            }
            $data = collect($this->getParents($NodesFathers->toArray()));
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

    private function getParents($node)
    {
        $tree = [];
        $children = [];
        $tree[] = $node;

        $data = (new WhereNodesDomain())(['id' => $node['parent_id']]);
        foreach ($data as $d) {
            $first = $this->getParents($d->toArray());
            $tree = array_merge($tree, $first);
        }

        return $tree;
    }
}
