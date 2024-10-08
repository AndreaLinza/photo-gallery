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
        $queryBuilder = DB::table('albums')->orderByDesc('id');
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
        $data['album_thumb'] = '';
        $query = 'INSERT INTO albums (album_name, description, user_id, album_thumb) values(:album_name, :description, :user_id, :album_thumb)';
        $res = DB::insert($query, $data);
        $message = 'Album '. $data['album_name'];
        $message .= $res ? ' Creato' : ' Non Creato' ;
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
        $data['id'] = $album->id;
        $query = 'UPDATE albums set album_name=:album_name, description=:description where id=:id';
        $res = DB::update($query, $data);
        $message = 'Album con id='.$album->id;
        $message .= $res ? ' aggiornato' : ' non aggiornato' ;
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
