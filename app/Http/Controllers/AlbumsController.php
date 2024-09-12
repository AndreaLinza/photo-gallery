<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumRequest;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use View;

class AlbumsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryBuilder = Album::orderByDesc('id')->withCount('photos');
        if ($request->has('id')) {
            $queryBuilder->where('id', '=', $request->input('id'));
        }
        if ($request->has('album_name')) {
            $queryBuilder->where('album_name', 'like', '%' . $request->input('album_name') . '%');
        }

        $albums = $queryBuilder->paginate(10);
        return view('albums.albums', ['albums' => $albums]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('albums.create-album')->withAlbum(new Album());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlbumRequest $request)
    {
        $data = $request->only(['album_name', 'description']);
        $album = new Album();
        $album->album_name = $data['album_name'];
        $album->description = $data['description'];
        $album->user_id = 1;
        $album->album_thumb = '/';
        $res = $album->save();
        if ($request->hasFile('album_thumb')) {
            $this->processFile($request, $album);
            $res = $album->save();

        }
        //$res =  Album::create($data);
        $messaggio = $res ? 'Album   ' . $data['album_name'] . ' Created' : 'Album ' . $data['album_name'] . ' was not crerated';
        session()->flash('message', $messaggio);

        return redirect()->route('albums.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Album $album
     *
     * @return void
     */
    public function processFile(Request $request, Album $album): void
    {
        $file = $request->file('album_thumb');

        $filename = $album->id . '.' . $file->extension();
        $thumbnail = $file->storeAs(
            config('filesystems.album_thumbnail_dir'),
            $filename,
            ['disk' => 'public']
        );
        $album->album_thumb = $thumbnail;
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
    public function update(AlbumRequest $request, Album $album)
    {
        $data = $request->only(['album_name', 'description']);
        $album->album_name = $data['album_name'];
        $album->description = $data['description'];
        if ($request->hasFile('album_thumb')) {
            $this->processFile($request, $album);
        }
        $res = $album->save();
        $messaggio = $res ? 'Album   ' . $album->album_name . ' Updated' : 'Album ' . $album->album_name . ' was not updated';
        session()->flash('message', $messaggio);
        return redirect()->route('albums.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album): int
    {
        // $queryBuilder = Album::where('id', $album)->delete();
        // return $queryBuilder;
        /*-------------- OR ----------------------*/
        // return Album::findOrFail($album)->delete();
        /*-------------- OR ----------------------*/
        // return +$album->delete();
        /*-------------- OR ----------------------*/
        //return Album::destroy($album);

        $thumbnail = $album->album_thumb;
        $res = $album->delete();
        if($thumbnail){
            \Storage::delete($thumbnail);
        }

        return $res;
    }

    public function getImages(Album $album){
        $images = Photo::wherealbumId($album->id)->latest()->paginate(5);
        return view('images.album-images', compact('album','images'));
    }


}
