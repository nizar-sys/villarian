<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GlobalSearchController extends Controller
{
    private $menus = [
        'home' => [
            'route' => 'home',
        ],
        'profile' => [
            'route' => 'profile',
        ],
        'villa' => [
            'route' => 'villas.index'
        ],
        'tambah data villa' => [
            'route' => 'villas.create'
        ]
    ];

    public function search(Request $request)
    {
        $search = $request->input('search');

        if ($search === null) {
            return response()->json([
                'success' => false,
                'message' => 'Search term is missing.'
            ], 400);
        }

        $term           = $search;
        $searchableData = [];

        foreach ($this->menus as $key => $menu) {
            if (preg_match("/{$term}/i", $key)) {
                $searchableData[] = [
                    'name' => Str::title($key),
                    'route' => route($menu['route']),
                ];
            }
        }

        return response()->json(['results' => $searchableData]);
    }

    
}
