<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestStoreOrUpdateVilla;
use App\Models\Villa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VillaCrudController extends Controller
{
    protected $path_upload = 'uploads/images/villas'; // public > uploads > images > villas
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.villas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.villas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestStoreOrUpdateVilla $request)
    {
        $validated = $request->validated() + ['uuid' => Str::uuid(), 'created_at' => now()];

        $fotoVilla = 'villa.' . time() . '.' . $request->foto->getClientOriginalExtension();
        $request->foto->move(public_path($this->path_upload), $fotoVilla);
        $validated['foto'] = $fotoVilla;
        
        $villa = Villa::create($validated);

        return redirect()->route('villas.index')->with('success', 'Berhasil tambah data villa');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $villa = Villa::whereUuid($uuid)->firstOrFail();
        return $villa;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $villa = Villa::whereUuid($uuid)->firstOrFail();
        return view('dashboard.villas.edit', compact('villa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(RequestStoreOrUpdateVilla $request, $uuid)
    {
        $validated = $request->validated() + ['updated_at' => now()];

        $villa = Villa::whereUuid($uuid)->firstOrFail();
        
        if ($request->hasFile('foto')) {
            $fotoVilla = 'villa.' . time() . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->move(public_path($this->path_upload), $fotoVilla);
            $validated['foto'] = $fotoVilla;

            // unlink old foto
            $image_path = public_path($this->path_upload . '/' . $villa->foto);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $villa->update($validated);

        return redirect(route('villas.index'))->with('success', 'Data villa berhasil diperbarui');
    }

    /**

     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $villa = Villa::whereUuid($uuid)->firstOrFail();

        // unlinking image
        $image_path = public_path($this->path_upload . '/' . $villa->foto);
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        $villa->delete();

        return response()->json([
            'success' => true, 
            'message' => 'Data villa berhasil dihapus.'
        ]);
    }
}
