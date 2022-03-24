<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function uploadCkEditor(Request $request)
    {

        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '.' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('/uploads/images/temp'), $fileName);
            $url = asset('/uploads/images/temp/'. $fileName);
        }

        return response()->json(['url' => $url, 'filename' => $fileName]);
    }
}
