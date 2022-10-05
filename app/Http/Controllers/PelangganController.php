<?php

namespace App\Http\Controllers;

use App\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pelanggan::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "";
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-success btn-sm mx-1" id="edit"><i class="fas fa-edit"></i></a>';
                    // $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm mx-1" id="hapus"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.user.pelanggan');
    }

    public function insert(Request $req)
    {
        try {
            $cek = Pelanggan::where('email', $req->email)->exists();
            if ($cek) {
                return response()->json(['status' => false, 'message' => 'Email sudah digunakan oleh user lain!']);
            } else {
                $user = new Pelanggan;
                $user->name = $req->name;
                $user->email = $req->email;
                $user->no_telp = $req->no_telp;
                $user->alamat = $req->alamat;
                $user->role = 'pelanggan';
                $user->username = $req->username;
                $user->password = bcrypt($req->password);
                $user->save();
                return response()->json(['status' => true, 'message' => 'Tersimpan']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => $err->getMessage()]);
        }
    }


    public function edit(Request $request)
    {
        $q = Pelanggan::find($request->id);
        return response()->json($q);
    }

    public function delete(Request $request)
    {
        $query = Pelanggan::find($request->id);
        $foto = $query->foto;
        $del = $query->delete();
        if ($del) {
            if ($foto != "") {
                $filePath = 'users/' . $foto;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            return response()->json(['status' => $del, 'message' => 'Hapus Sukses']);
        } else {
            return response()->json(['status' => $del, 'message' => 'Gagal']);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = Pelanggan::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->no_telp = $request->no_telp;
            $user->alamat = $request->alamat;
            $user->role = 'pelanggan';
            $user->username = $request->username;
            if (!empty($request->password)) {
                $user->password = bcrypt($request->password);
            }
            $user->save();
            return response()->json(['status' => true, 'message' => 'Tersimpan']);
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => $err->getMessage()]);
        }
    }
}
