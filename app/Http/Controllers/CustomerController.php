<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $pembayaran = \App\Transaksi::latest()->where('user_id', Auth::user()->id)->get();
        return view('customer.home', ['pembayaran' => $pembayaran]);
    }

    public function uploadBukti(Request $request, $idTransaksi)
    {
        $request->validate(
            [
                'bukti_transfer' => 'required',
            ]
        );
        $data = \App\Transaksi::findOrFail($idTransaksi);
        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $tujuan_upload = 'image/bukti-transfer/';
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $nama_file = str_replace(' ', '', $nama_file);

            if (file_exists($data->bukti_transfer)) {
                unlink($data->bukti_transfer);
            }

            $file->move($tujuan_upload, $nama_file);

            $data->status = 'Pending';
            $data->bukti_transfer = $tujuan_upload . $nama_file;
        }
        $data->save();

        return redirect('/customer/home')->withSuccess('Data Berhasil Di Upload');
    }
}
