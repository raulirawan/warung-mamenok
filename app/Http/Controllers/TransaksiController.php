<?php

namespace App\Http\Controllers;

use App\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function approve($idTransaksi)
    {
        $transaksi = Transaksi::findOrFail($idTransaksi);

        $transaksi->status = 'Sudah Bayar';
        $transaksi->save();

        return redirect('/home')->withSuccess('Data Berhasil Di Update');
    }

    public function reject($idTransaksi)
    {
        $transaksi = Transaksi::findOrFail($idTransaksi);

        $transaksi->status = 'Belum Bayar';
        $transaksi->save();

        return redirect('/home')->withSuccess('Data Berhasil Di Update');
    }
}
