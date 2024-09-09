<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryBuilder = Album::orderByDesc('id');
        if ($request->has('id')) {
            $queryBuilder->where('id', '=', $request->input('id'));
        }
        if ($request->has('album_name')) {
            $queryBuilder->where('album_name', 'like', '%' . $request->input('album_name') . '%');
        }
        $albums = $queryBuilder->get();

        return view('albums.albums', ['albums' => $albums]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('albums.create-album');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $data = $request->only(['album_name', 'description']);
        // $data['user_id'] = 1;
        // $data['album_thumb'] = '/';

        // $album = new Album();
        // $album->album_name = $data['album_name'];
        // $album->album_thumb = '/';
        // $album->description = $data['description'];
        // $album->user_id = 1;
        // $queryBuilder = Album::create($data);
        // // $queryBuilder = Album::insert($data);
        // $message = 'Album '. $data['album_name'];
        // $message .= $queryBuilder ? ' Creato' : ' Non Creato' ;
        // session()->flash('message', $message);
        // return redirect()->route('albums.index');
        $data = $request->only(['album_name', 'description']);
        $album = new Album();
        $album->album_name = $data['album_name'];
        $album->description = $data['description'];
        $album->user_id = 1;
        $album->album_thumb = '/';
        $res = $album->save();
        //$res =  Album::create($data);
        $messaggio = $res ? 'Album   ' . $data['album_name'] . ' Created' : 'Album ' . $data['album_name'] . ' was not crerated';
        session()->flash('message', $messaggio);

        return redirect()->route('albums.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Album $album)
    {
        return $album;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        // $sql = "select * FROM albums WHERE id=:id";
        // $albumEdit = DB::select($sql, ['id' => $album->id]);
        return view('albums.edit-album')->withAlbum($album);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $album)
    {
        // $data = $request->only(['album_name', 'description']);
        // $queryBuilder = $album->update($data);
        // // $queryBuilder = Album::where('id', $album->id)->update($data);
        // $message =  'Album con id='.$album->id;
        // $message .= $queryBuilder ? 'Album ' .$album->album_name .  ' aggiornato' : ' non aggiornato' ;
        // session()->flash('message', $message);
        // return redirect()->route('albums.index');
        $data = $request->only(['album_name', 'description']);
        $album->album_name = $data['album_name'];
        $album->description = $data['description'];
        if ($request->hasFile('album_thumb')) {
            $file = $request->file('album_thumb');

            $filename = $album->id . '.' . $file->extension();

            $thumbnail = $file->storeAs(
                config('filesystems.album_thumbnail_dir'),
                $filename,
                ['disk' => 'public']
            );

            $album->album_thumb = $thumbnail;
        }

        $res = $album->save();


        $messaggio = $res ? 'Album   ' . $album->album_name . ' Updated' : 'Album ' . $album->album_name . ' was not updated';
        session()->flash('message', $messaggio);

        return redirect()->route('albums.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        // $queryBuilder = Album::where('id', $album)->delete();
        // return $queryBuilder;
        /*-------------- OR ----------------------*/
        // return Album::findOrFail($album)->delete();
        /*-------------- OR ----------------------*/
        // return +$album->delete();
        /*-------------- OR ----------------------*/
        return Album::destroy($album);
    }

}
