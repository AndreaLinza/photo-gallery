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
        //return Album::all();
        $sql = 'select * from albums WHERE 1=1 ';
        $where = [];
        if($request->has('id')){
            $where['id'] = $request->get('id');
            $sql .= " AND ID=:id";
        }
        if($request->has('album_name')){
            $where['album_name'] = $request->get('album_name');
            $sql .= " AND album_name=:album_name";
        }
        // $sql .= ' WHERE '. $where;
        //dd($sql);
        $albums = DB::select($sql, $where);
        return view('albums.albums', ['albums' => $albums]);
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
    public function destroy(int $album): int
    {
        $sql = "DELETE FROM albums WHERE id=:id";
        return DB::delete($sql, ['id' => $album]);
    }

    public function delete(int $album): int
    {
        $sql = "DELETE FROM albums WHERE id=:id";
        return DB::delete($sql, ['id' => $album]);
    }
}
