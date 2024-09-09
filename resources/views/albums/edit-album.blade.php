@php
    /**
    * @var $album App\Models\Album;
     */
@endphp

@extends('templates.default')
@section('content')

<h1>EDIT ALBUM {{$album->album_name}}</h1>
<form method="POST" action="{{route('albums.update', ['album' => $album->id])}}" enctype="multipart/form-data">
    @csrf()
    @method('PATCH')
    <div class="form-group">
        <label for="album_name">Nome Album</label>
        <input class="form-control" name="album_name" id="album_name" type="text" value="{{$album->album_name}}">
    </div>
    <div class="mb-3">
        <label for="album_thumb" class="form-label">Thumbnail</label>
        <input type="file" class="form-control" name="album_thumb" id="album_thumb" value="{{$album->album_name}}">
    </div>

    @if($album->album_thumb)
        <div class="mb-3">
            <img width="300" src="{{$album->album_thumb}}" alt="{{$album->name}}" title="{{$album->name}}">
        </div>
    @endif
    <div class="form-group">
        <label for="description">Descrizione</label>
        <textarea class="form-control" name="description" id="description"
            type="text">{{$album->description}}</textarea>
    </div>
    <div class="form-group pt-4">
        <button class="btn btn-primary">Salva</button>
        <a href="{{route('albums.index')}}" class="btn btn-danger">Annulla</a>

    </div>
</form>

@endsection
