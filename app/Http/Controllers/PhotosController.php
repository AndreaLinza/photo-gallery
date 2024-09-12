<?php

namespace App\Http\Controllers;

use App\Models\Album;
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
    public function create(Request $request)
    {
        $photo = new Photo();
        $album = $request->album_id ? Album::findOrFail($request->album_id) : new Album();
        return view("images.edit-image",compact("album","photo"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $photo = new Photo();
       $photo->name = $request->input("name");
       $photo->description = $request->input("description");
       $photo->album_id = $request->input("album_id");
       $this->processFile($request, $photo);
       $photo->save();
       return redirect(route('albums.images', $photo->album));
    }

    public function processFile(Request $request, Photo $photo): void
    {
        if ($request->hasFile('img_path')) {
            $file = $request->file('img_path');
            $name = preg_replace('@[^a-z]i@', '_', $photo->name);

            // Genera il nome del file
            $filename = $name . '.' . $file->extension();

            // Salva il file nella directory specificata con il nome generato
            $thumbnail = $file->storeAs(
                config('filesystems.img_dir') . '/' . $photo->album_id,
                $filename,
                ['disk' => 'public']
            );

            // Aggiorna il percorso dell'immagine nel database
            $photo->img_path = $thumbnail;
        }
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
        $album = $photo->album;
        return view("images.edit-image", compact("photo", "album"));
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
