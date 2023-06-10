@extends('layouts.app')
<title>WARUNG MAMENOK</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>Pembelian</h3>
                            </div>
                            <div class="col-md-3 offset-3">
                                <input type="text" id="myInput" class="form-control" name="" id=""
                                    placeholder="Search..">
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-hover">

                            <tr>
                                <th class="">ID Transaksi</th>
                                <th>Nama Pemesan</th>
                                <th>Subtotal</th>
                                <th>Bank</th>
                                <th>Status Transaksi</th>
                                <th class="text-center">Aksi</th>

                            </tr>
                            @foreach ($pembayaran as $row)
                                <tbody id="myTable">
                                    <tr>
                                        <td style="padding-left:4%;">{{ $row->id_transaksi }}</td>
                                        <td>{{ $row->nama_pemesan }}</td>
                                        <td>Rp. {{ number_format($row->subtotal) }}</td>
                                        <td>{{ $row->nama_bank }}</td>
                                        <td>
                                            @if ($row->status == 'Belum Bayar')
                                                <span class="badge bg-danger">
                                                    {{ $row->status }}
                                                </span>
                                            @elseif($row->status == 'Pending')
                                                <span class="badge bg-warning">
                                                    {{ $row->status }}
                                                </span>
                                            @else
                                                <span class="badge bg-success">
                                                    {{ $row->status }}
                                                </span>
                                            @endif
                                        </td>
                                        @if ($row->status == 'Pending')
                                            <td>
                                                <a href="{{ asset($row->bukti_transfer) }}" target="_blank"
                                                    class="btn btn-info badge">
                                                    Lihat Bukti
                                                </a>
                                                <a href="{{ route('approve', $row->id_transaksi) }}"
                                                    class="btn btn-success badge" onclick="return confirm('Yakin ?')">
                                                    Terima
                                                </a>
                                                <a href="{{ route('reject', $row->id_transaksi) }}"
                                                    class="btn btn-danger badge" onclick="return confirm('Yakin ?')">
                                                    Tolak
                                                </a>
                                            </td>
                                        @elseif($row->status == 'Sudah Bayar')
                                            <td class="text-center"><a href="home/{{ $row->id_transaksi }}/cetak_struk" target="_blank"><button
                                                        class="btn btn-warning badge">Cetak
                                                        Struk</button></a></td>
                                        @endif

                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
