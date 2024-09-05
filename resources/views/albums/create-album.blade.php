@extends('templates.default')
@section('content')

<h1>CREATE NEW   ALBUM </h1>
<form method="POST" action="{{route('albums.store')}}">
    @csrf()
    @method('POST')
    <div class="form-group">
        <label for="album_name">Nome Album</label>
        <input required class="form-control" name="album_name" id="album_name" type="text" value="">
    </div>
    <div class="form-group">
        <label for="description">Descrizione</label>
        <textarea required class="form-control" name="description" id="description"
            type="text"></textarea>
    </div>
    <div class="form-group pt-4">
        <button class="btn btn-primary">Salva</button>
        <a href="{{route('albums.index')}}" class="btn btn-danger">Annulla</a>

    </div>
</form>

@endsection
