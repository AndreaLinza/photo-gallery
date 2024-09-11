@extends('templates.default')
@section('content')
<h1>IMAGES</h1>
@if(session()->has('message'))
<x-alert-info>{{session()->get('message')}}</x-alert-info>
@endif
<table class="table table-striped">
    <thead>

        <tr>
            <th>ID</th>
            <th>CRATED DATE</th>
            <th>TITLE</th>
            <th>ALBUM</th>
            <th>THUMBNAIL</th>
            <th>UPDATE</th>
            <th>DELETE</th>

        </tr>
    </thead>
    <tbody>
        <tr>
            @forelse($images as $image)

            <td>{{$image->id}}</td>
            <td>{{$image->created_at}}</td>
            <td>{{$image->name}}</td>
            <td>{{$album->album_name}}</td>
            <td><img width="120" src="{{asset($image->path)}}" alt=""></td>
            <td><a class="btn btn-warning d-block" href="{{route('photos.edit', $image)}}">UPDATE</a></td>
            <td><a class="btn btn-danger d-block" href="{{route('photos.destroy', $image)}}">DELETE</a></td>
        </tr>

        @empty
        <tr>
            <td colspan="7">
                No images found
            </td>
        </tr>
        @endforelse
        <tr>
            <td colspan="7">
                {{$images->links('vendor.pagination.bootstrap-5')}}
            </td>
        </tr>
    </tbody>
</table>
@endsection

@section('footer')
@parent
<script>
    $('document').ready(function () {
        $('div.alert-info').fadeOut(3000);
            $('table').on('click', 'a.btn-danger', function (evt) {
                evt.preventDefault();
                const urlImage = $(this).attr('href');
                const tr = evt.target.parentNode.parentNode;
                //console.log(li)
                $.ajax(urlImage,
                {
                    method: 'DELETE',
                    data: {
                        _token: "{{csrf_token()}}"
                    },
                    complete: function (resp, status) {
                        if (status !== 'error' && Number(resp.responseText) === 1) {
                            $(tr).remove();
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
