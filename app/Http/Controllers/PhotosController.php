<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Photo::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function processFile(Request $request, Photo $photo): void
    {
        $file = $request->file('img_path');

        $filename = $photo->id . '.' . $file->extension();
        $thumbnail = $file->storeAs(
            config('filesystems.img_dir' . $photo->album_id),
            $filename,
            ['disk' => 'public']
        );
        $photo->img_path = $thumbnail;
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        // dd($photo);
        return $photo;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        return view("images.edit-image", compact("photo"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        $data = $request->only(['name', 'description']);
        $photo->name = $data['name'];
        $photo->description = $data['description'];
        if ($request->hasFile('img_path')) {
            $this->processFile($request, $photo);
        }
        $res = $photo->save();
        $messaggio = $res ? 'Foto   ' . $photo->name . ' Updated' : 'Foto ' . $photo->name . ' was not updated';
        session()->flash('message', $messaggio);
        return redirect()->route('albums.images', ['album' => $photo->album]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        $res = $photo->delete();
        $image = $photo->img_path;
        if ($res && $image) {
            \Storage::delete($image);
        }
        return $res;
    }
}
