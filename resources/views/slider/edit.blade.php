@extends('layouts.app')

@section('content')
    <div class="container card card-body">
        @if (session('sukses'))
            <div class="alert alert-success" role="alert">
                {{ session('sukses') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6 offset-3">
                <br>
                <h1>Edit Slider</h1>
                <form action="/slider/{{ $slider->id }}/update" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="gambar">
                            <img src="{{ asset($slider->image) }}" id="preview_gambar" class="img-thumbnail"
                                width="300" alt="No Image"><br><br>
                            <input onchange="readURL(this);" value="{{ $slider->image }}" required type="file"
                                name="gambar" class="" id="exampleInputEmail1" aria-describedby="emailHelp"><br><br>
                        </div>

                        <div class="float-right">
                            <a href="/slider/" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-danger">Update</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
        function readURL(input) { // Mulai membaca inputan gambar
            if (input.files && input.files[0]) {
                var reader = new FileReader(); // Membuat variabel reader untuk API FileReader

                reader.onload = function(e) { // Mulai pembacaan file
                    $('#preview_gambar') // Tampilkan gambar yang dibaca ke area id #preview_gambar
                        .attr('src', e.target.result)
                        .width(300); // Menentukan lebar gambar preview (dalam pixel)
                    //.height(200); // Jika ingin menentukan lebar gambar silahkan aktifkan perintah pada baris ini
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
