@php
/**
* @var $album App\Models\Photo;
*/
@endphp

@extends('templates.default')
@section('content')

<h1>EDIT PHOTO {{$photo->name}}</h1>
<form method="POST" action="{{route('photos.update', $photo)}}" enctype="multipart/form-data">
    @csrf()
    @method('PATCH')
    <div class="form-group">
        <label for="name">Nome Immagine</label>
        <input class="form-control" name="name" id="name" type="text" value="{{$photo->name}}">
    </div>

    @include("images.partials.fileupload")

    <div class="form-group">
        <label for="description">Descrizione</label>
        <textarea class="form-control" name="description" id="description"
            type="text">{{$photo->description}}</textarea>
    </div>
    <div class="form-group pt-4">
        <button class="btn btn-primary">Salva</button>
        <a href="{{route('albums.images', ['album' => $photo->album])}}" class="btn btn-danger">Annulla</a>

    </div>
</form>

@endsection
