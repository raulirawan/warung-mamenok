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
                                        @if ($row->status == 'Belum Bayar')
                                            <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#exampleModal" id="upload-bukti"
                                                    data-id_transaksi="{{ $row->id_transaksi }}">
                                                    Upload Bukti
                                                </button>
                                            </td>
                                        @elseif($row->status === 'Pending')
                                            <td>
                                                <a href="{{ asset($row->bukti_transfer) }}" target="_blank"
                                                    class="btn btn-info">
                                                    Lihat Bukti
                                                </a>
                                            </td>
                                        @else
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="form-upload-bukti" enctype="multipart/form-data">
                        @csrf
                        <label>Bukti Transfer</label>
                        <input type="file" name="bukti_transfer" class="form-control" required>
                        @if ($errors->has('bukti_transfer'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('bukti_transfer') }}</strong>
                            </span>
                        @endif
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                </div>

                </form>

            </div>
        </div>
    </div>
    @push('down-script')
        {{-- @if (count($errors) > 0)
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#exampleModal').modal('show');
                });
            </script>
        @endif --}}
        <script>
            $(document).ready(function() {
                $(document).on('click', '#upload-bukti', function() {
                    var id = $(this).data('id_transaksi');
                    $('#form-upload-bukti').attr('action', '/customer/upload/bukti/' + id);
                });
            });
        </script>
    @endpush
@endsection
