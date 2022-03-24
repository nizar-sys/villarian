<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Villa;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index()
    {
        return view('frontend.home.index');
    }

    public function villaDetail($id)
    {
        $villa = Villa::whereUuid($id)->firstOrFail();
        return view('frontend.villa.detail', compact('villa'));
    }
}
