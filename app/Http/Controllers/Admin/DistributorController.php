<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distributor;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class DistributorController extends Controller
{
    // Method untuk menampilkan semua distributor
    public function index()
    {

        $distributors = Distributor::all();
        confirmDelete('Hapus Data!', 'Apakah anda yakin ingin menghapus data ini?');

        return view('pages.admin.distributor.index', compact('distributors'));
    }

    // Method untuk menampilkan form create distributor baru
    public function create()
    {
        return view('pages.admin.distributor.create');
    }

    // Method untuk menyimpan distributor baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_distributor' => 'required|string|max:255',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kontak' => 'required|string|max:20',
            'email' => 'required|email|unique:distributors',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Pastikan semua terisi dengan benar!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Distributor::create([
            'nama_distributor' => $request->nama_distributor,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'kontak' => $request->kontak,
            'email' => $request->email,
        ]);

        Alert::success('Berhasil!', 'Distributor berhasil ditambahkan!');
        return redirect()->route('admin.distributor');

    }
    //  menampilkan form edit distributor
    public function edit($id)
    {
        $distributor = Distributor::find($id);

        if (!$distributor) {
            Alert::error('Gagal!', 'Distributor tidak ditemukan!');
            return redirect()->route('admin.distributor');
        }

        return view('pages.admin.distributor.edit', compact('distributor'));
    }

    //update distributor yang di-edit
    public function update(Request $request, $id)
    {
        $distributor = Distributor::find($id);

        if (!$distributor) {
            Alert::error('Gagal!', 'Distributor tidak ditemukan!');
            return redirect()->route('admin.distributor.');
        }

        $validator = Validator::make($request->all(), [
            'nama_distributor' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'kontak' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Pastikan semua terisi dengan benar!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $distributor->update([
            'nama_distributor' => $request->nama_distributor,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'kontak' => $request->kontak,
            'email' => $request->email,
        ]);

        Alert::success('Berhasil!', 'Distributor berhasil diperbarui!');
        return redirect()->route('admin.distributor');
    }

    public function delete($id) 
    {
        $distributor = Distributor::findOrFail($id);
       
        $distributor->delete();
    
        if ($distributor) {
            Alert::success('Berhasil', 'Distributor berhasil dihapus!');
            return redirect()->back();
        } else {
            Alert::error('Gagal!', 'Distributor gagal dihapus!');
            return redirect()->back();
        }
    }
}    