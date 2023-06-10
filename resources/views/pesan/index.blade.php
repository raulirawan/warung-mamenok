@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/319489147f.js"></script>
    <title>Warung mamenok</title>
    <div class="container"><br>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @if (!empty(App\Slider::all()))
                    @foreach (App\Slider::all() as $item)
                        <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : '' }}">
                            <img class="w-100" src="{{ asset($item->image) }}">
                        </div>
                    @endforeach
                @endif

            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <h1>FORM PEMESANAN</h1>
        @if (session('sukses'))
            <div class="alert alert-success" role="alert">
                {{ session('sukses') }}
            </div>
        @endif
        <div class="row">
            @foreach ($data_kasir as $row)
                <div class="col-md-3">
                    <a href="#" id="makanan" onclick="getValue(<?= $row->id ?>)">
                        <div class="card id" style="width:;">
                            <img src="{{ asset('upload/' . $row->gambar) }}" class="card-img-top" alt="...">
                            <div class="card-body text-center">
                                <h4 id="myText<?= $row->id ?>">{{ $row->nama_menu }}</h4>
                                <p id="harga<?= $row->id ?>">{{ $row->harga }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <form action="/pesan/create" method="POST">
            <div class="row pt-3">
                <div class="col-md-6 card">
                    <div class="card-body">
                        <h5>List makanan yang dipilih</h5><span class="float-right" style="margin-top:-28px;"><a
                                href="pesan"><i class="fas fa-sync"></i></a></span>
                        <hr id="isi">
                    </div>
                </div>
                <div class="col-md-6 card"><br>
                    {{-- <form >   --}}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Pemesan</label>

                        <input autocomplete="off" type="text" name="nama_pemesan" class="form-control"
                            id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ Auth::user()->name ?? '' }}"
                            placeholder="Enter Name" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Pilih Bank</label>

                        <select name="bank" id="bank" class="form-control" required>
                            <option value="BCA (0929372843)">BCA (0929372843)</option>
                            <option value="BRI (521932523)">BRI (521932523)</option>
                            <option value="MANDIRI (151231252)">MANDIRI (151231252)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Subtotal</label>
                        <input type="text" autocomplete="off" name="subtotal" class="form-control" id="subtotal"
                            aria-describedby="emailHelp" readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" autocomplete="off" hidden name="status" value="Belum Bayar"
                            class="form-control" id="subtotal" aria-describedby="emailHelp" readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" autocomplete="off" hidden name="bayar" value="0" class="form-control"
                            id="subtotal" aria-describedby="emailHelp" readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" autocomplete="off" hidden name="kembalian" value="0"
                            class="form-control" id="subtotal" aria-describedby="emailHelp" readonly>
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary">Pesan</button><br><br>
                    </div>
                </div>

            </div>
        </form>

    </div>
    <br><br>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script>
        function getValue(i) {
            var makanan = $('#myText' + i).text(); // get nama maknan berdasarkan id_menu
            var harga = $('#harga' + i).text(); // get harganya
            var ambil_harga = harga.split(" "); // split harga berdasarkan spasi RP 1000

            // alert('ini harga'+harga);
            var makan_terpilih = $('#makanan' + i).val(); //
            var jml = $('#jumlah' + i).text();

            jumlah = 1;

            if (makan_terpilih === makanan) {
                var total_makanan = $('#jumlah' + i).html(parseInt(jml) + jumlah);

            } else if (makan_terpilih != makanan) {
                $('<div class="input-group mb-3"><input type="text" readonly style="background-color:#fff;" value="' +
                    makanan + '" id="makanan' + i +
                    '" class="form-control" placeholder="Recipients username" aria-label="Recipients username" aria-describedby="basic-addon2"><input type="text" hidden style="background-color:#fff;" value="' +
                    i + '" name="makanan[]" id="makanan' + i +
                    '"><div class="input-group-append"><span class="input-group-text" id="basic-addon2">Jumlah dipesan&nbsp;&nbsp;<b id="jumlah' +
                    i + '">1</b></span></div></div>').insertAfter($("#isi"));
            }

            var subtotal = 1 + parseInt(jml);
            if (isNaN(subtotal)) {
                subtotal = 1;
            }
            total = harga;

            counting(total);
        }

        function counting(total) {
            var subtotal = $('#subtotal').val();
            total = Number(subtotal) + Number(total);
            $('#subtotal').val(total);

        }
    </script>
@endsection
