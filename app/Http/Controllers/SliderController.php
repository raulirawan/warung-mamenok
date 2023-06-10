<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use Carbon\Carbon;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data_slider = \App\Slider::all();
        return view('slider.index', ['data_slider' => $data_slider]);
    }
    public function create(Request $request)
    {

        $data = new Slider();
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $tujuan_upload = 'image/slider/';
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $nama_file = str_replace(' ', '', $nama_file);
            $file->move($tujuan_upload, $nama_file);

            $data->image = $tujuan_upload . $nama_file;
        }
        $data->save();


        return redirect('/slider')->with('sukses', 'Data Berhasil Di Input');
    }

    public function edit($id)
    {
        $slider = \App\Slider::find($id);
        return view('slider/edit', ['slider' => $slider]);
    }

    public function update(Request $request, $id)
    {
        $data = Slider::findOrFail($id);
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $tujuan_upload = 'image/slider/';
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $nama_file = str_replace(' ', '', $nama_file);

            if (file_exists($data->image)) {
                unlink($data->image);
            }

            $file->move($tujuan_upload, $nama_file);


            $data->image = $tujuan_upload . $nama_file;
        }
        $data->save();

        return redirect('/slider')->with('sukses', 'Data Berhasil Di Update');
    }
    public function delete($id)
    {
        $slider = \App\Slider::find($id);

        if (file_exists($slider->image)) {
            unlink($slider->image);
        }
        $slider->delete();
        return redirect('/slider')->with('sukses', 'Data Berhasil Di Hapus');
    }
}
