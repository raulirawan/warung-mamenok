<?php

namespace App\Http\Controllers;

use App\Kasir;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class KasirController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data_kasir = \App\Kasir::all();
        return view('kasir.index', ['data_kasir' => $data_kasir]);
    }
    public function create(Request $request)
    {
        $kasir = new Kasir();
        $kasir->nama_menu = $request->nama_menu;
        $kasir->harga = $request->harga;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $tujuan_upload = 'image/makanan/';
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $nama_file = str_replace(' ', '', $nama_file);

            $file->move($tujuan_upload, $nama_file);

            $kasir->gambar = $tujuan_upload . $nama_file;
        }

        $kasir->save();

        return redirect('/kasir')->with('sukses', 'Data Berhasil Di Input');
    }

    public function edit($id)
    {
        $kasir = \App\Kasir::find($id);
        return view('kasir/edit', ['kasir' => $kasir]);
    }

    public function update(Request $request, $id)
    {
        $kasir = \App\Kasir::find($id);

        $kasir->nama_menu = $request->nama_menu;
        $kasir->harga = $request->harga;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $tujuan_upload = 'image/gambar/';
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $nama_file = str_replace(' ', '', $nama_file);
            if (File::exists($kasir->gambar)) {
                unlink($kasir->gambar);
            }
            $file->move($tujuan_upload, $nama_file);
            $nameFile = $tujuan_upload . $nama_file;
            $kasir->gambar = $nameFile;
        }
        $kasir->save();
        return redirect('/kasir')->with('sukses', 'Data Berhasil Di Update');
    }
    public function delete($id)
    {
        $kasir = \App\Kasir::find($id);
        $kasir->delete();
        return redirect('/kasir')->with('sukses', 'Data Berhasil Di Hapus');
    }
}
