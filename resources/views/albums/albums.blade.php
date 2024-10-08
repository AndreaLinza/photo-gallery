@extends('templates.default')
@section('title', 'Albums')
@section('content')
<h1>ALBUMS</h1>
<form>
    @csrf
    <input id="_token" type="hidden" name="_token" value="{{csrf_token()}}">
</form>
@if(session()->has('message'))
<x-alert-info/>
@endif
<a href="{{route('albums.create')}}" class="btn btn-secondary py-2 my-2 d-block w-25 ms-auto">Aggiungi album</a>
<ul class="list-group">
    @foreach($albums as $album)
    <li class="list-group-item d-flex justify-content-between">
        <div>
            ({{$album->id}}) {{$album->album_name}}
        </div>
        <div>
            <a href="{{route('albums.edit', ['album' => $album->id])}}" class="btn btn-warning">UPDATE</a>
            {{-- <a href="{{route('albums.destroy', ['album' => $album->id])}}" class="btn btn-danger">DELETE</a> --}}
            <a href="/albums/{{$album->id}}" class="btn btn-danger">DELETE</a>
        </div>
    </li>
    @endforeach
</ul>
@endsection
@section('footer')
@parent
<script>
    $('document').ready(function () {
        $('div.alert-info').fadeOut(3000);
            $('ul').on('click', 'a.btn-danger', function (evt) {
                evt.preventDefault();
                const urlAlbum = $(this).attr('href');
                const li = evt.target.parentNode.parentNode;
                console.log(li)
                $.ajax(urlAlbum, {
                    method: 'DELETE',
                    data: {
                        _token: $('#_token').val()
                    },
                    complete: function (resp, status) {
                        if (status !== 'error' && Number(resp.responseText) === 1) {
                            $(li).remove();
                            // li.parentNode.removeChild(li);
                            alert('Record ' + resp.responseText + ' deleted ')
                        } else {
                            console.error(resp.responseText);
                            alert(resp.responseText)
                        }

                    }
                });
            });
        });

</script>
@endsection
