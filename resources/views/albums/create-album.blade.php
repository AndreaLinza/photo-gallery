@extends('templates.default')
@section('content')

<h1>CREATE NEW   ALBUM </h1>
<form method="POST" action="{{route('albums.store')}}" enctype="multipart/form-data">
    @csrf()
    @method('POST')
    <div class="form-group mb-3">
        <label for="album_name">Nome Album</label>
        <input type="text" required class="form-control" name="album_name" id="album_name">
    </div>
    @include("albums.partials.fileupload")
    <div class="form-group">
        <label for="description">Descrizione</label>
        <textarea type="text" required class="form-control" name="description" id="description"></textarea>
    </div>
    <div class="form-group pt-4">
        <button class="btn btn-primary">Salva</button>
        <a href="{{route('albums.index')}}" class="btn btn-danger">Annulla</a>

    </div>
</form>

@endsection
