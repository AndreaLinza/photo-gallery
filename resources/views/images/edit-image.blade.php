@php
/**
* @var $album App\Models\Photo;
*/
@endphp

@extends('templates.default')
@section('content')

@include('partials.input-error')
@if($photo->id)

    <h1>EDIT PHOTO {{$photo->name}}</h1>
    <form method="POST" action="{{route('photos.update', $photo)}}" enctype="multipart/form-data">

    @method('PATCH')

    @else
        <h1>NEW IMAGE FOR ALBUM {{$album->album_name}}</h1>
        <form method="POST" action="{{route('photos.store')}}" enctype="multipart/form-data">

@endif
        {{-- <input type="hidden" name="album_id" value="{{$album->id}}"> --}}
        @csrf()

        <div class="form-group">
            <label class="form-label" for="album_id">Album</label>
            <select requided name="album_id" id="album_id">
                <option value="">SELECT</option>
                @foreach($albums as $item)
                    <option {{$item->id === $album->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->album_name}}</option>
                @endforeach
            </select>
        </div>
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
            <a href="{{route('albums.index')}}" class="btn btn-danger">Annulla</a>

        </div>
    </form>

    @endsection
