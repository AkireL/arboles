<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Node;
use Illuminate\Http\Request;

class ParentsChildController extends Controller
{
    public function index(int $nodeId, Request $request)
    {
        try {
            $index = $request->input('page') ?? 0;
            $byPage = 20;
            $NodesFathers = Node::where('id', $nodeId)->first();
            if (is_null($NodesFathers)) {
                throw new \Exception('Árbol vacio');
            }
            $data = collect($this->getParents($NodesFathers->toArray()));
            $inicio = ($byPage * $index);

            return response()->json(($data->slice($inicio, $byPage))->all(), 200);
            // print_r($data);
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

        $data = Node::where('id', $node['parent_id'])->get();
        foreach ($data as $d) {
            $first = $this->getParents($d->toArray());
            $tree = array_merge($tree, $first);
        }

        return $tree;
    }
}
