<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Node;
use Illuminate\Http\Request;

class ChildrenController extends Controller
{
    public function index(int $nodeId, Request $request)
    {
        try {
            $index = $request->input('page') ?? 0;
            $byPage = 3;

            $NodesFathers = Node::where('parent_id', $nodeId)->first();
            if (is_null($NodesFathers)) {
                throw new \Exception('Árbol vacio');
            }
            $NodeFather = Node::where('id', $nodeId)->first();

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

        $data = Node::where('parent_id', $node['id'])->get();
        foreach ($data as $d) {
            $first = $this->getChild($d->toArray());
            $tree = array_merge($tree, $first);
        }

        return $tree;
    }

    // private function getChild2($id)
    // {
    //     $tree = [];
    //     $children = [];
    //     $tree['parent'] = $id;

    //     $data = Node::where('parent_id', $id)->get();
    //     foreach ($data as $d) {
    //         $first = $this->getChild2($d->id);
    //         array_push($children, $first);
    //     }
    //     if (count($children) > 0) {
    //         $tree['children'] = $children;
    //     }

    //     return $tree;
    // }
}
