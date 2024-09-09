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
        if($request->has('id')){
            $queryBuilder->where('id', '=', $request->input('id'));
        }
        if($request->has('album_name')){
            $queryBuilder->where('album_name', 'like', '%'.$request->input('album_name').'%');
        }
        $albums  = $queryBuilder->get();

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
        $data = $request->only(['album_name', 'description']);
        $data['user_id'] = 1;
        $data['album_thumb'] = '/';
        $queryBuilder = DB::table('albums')->insert($data);
        $message = 'Album '. $data['album_name'];
        $message .= $queryBuilder ? ' Creato' : ' Non Creato' ;
        session()->flash('message', $message);
        return redirect()->route('albums.index');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sql = "select * FROM albums WHERE id=:id";
        return DB::select($sql, ['id' => $id]);
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
        $data = $request->only(['album_name', 'description']);
        $queryBuilder = DB::table('albums')->where('id', $album->id)->update($data);
        $message = 'Album con id='.$album->id;
        $message .= $queryBuilder ? ' aggiornato' : ' non aggiornato' ;
        session()->flash('message', $message);
        return redirect()->route('albums.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $album)
    {
        $queryBuilder = DB::table('albums')->where('id', $album)->delete();
        return $queryBuilder;
    }

}
