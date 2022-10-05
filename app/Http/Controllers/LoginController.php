<?php

namespace App\Http\Controllers;

use App\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class LoginController extends Controller
{
    /** halaman akun */
    public function index()
    {
        $data['user'] = User::all();
        return view('backend/profile.index', $data);
    }

    /** fungsi crud data akun */
    public function get()
    {
        if (Auth::guard('pegawai')->check()) {
            $data['profile'] = Pegawai::find(auth()->guard('pegawai')->user()->id);
        } elseif (Auth::guard('user')->check()) {
            $data['profile'] = User::find(auth()->guard('user')->user()->id);
        } elseif (Auth::guard('nasabah')->check()) {
            $data['profile'] = Nasabah::find(auth()->guard('nasabah')->user()->id);
        }
        return response()->json($data);
    }

    /** fungsi login */
    public function getLogin()
    {
        return view('backend.login');
    }

    public function getLogin_member()
    {
        $data = [
            'title' => 'Login Member Area',
            'description' => 'Toko Spesialis Busana Adat Bali',
        ];
        return view('frontend.login', $data);
    }

    public function getRegister_member()
    {
        $data = [
            'title' => 'Register Member Area',
            'description' => 'Toko Spesialis Busana Adat Bali',
        ];
        return view('frontend.register', $data);
    }


    public function postLogin(Request $request)
    {
        //LAKUKAN PENGECEKAN, JIKA INPUTAN DARI USERNAME FORMATNYA ADALAH EMAIL, MAKA KITA AKAN MELAKUKAN PROSES AUTHENTICATION MENGGUNAKAN EMAIL, SELAIN ITU, AKAN MENGGUNAKAN USERNAME
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        //TAMPUNG INFORMASI LOGINNYA, DIMANA KOLOM TYPE PERTAMA BERSIFAT DINAMIS BERDASARKAN VALUE DARI PENGECEKAN DIATAS
        $login = [
            $loginType => $request->username,
            'password' => $request->password
        ];
        if (Auth::guard('admin')->attempt($login)) {
            return response()->json([
                'success' => true,
                'role' => auth()->guard('admin')->user()->role,
                'message' => 'Login Sukses!'
            ]);
        } else if (Auth::guard('pelanggan')->attempt($login)) {
            return response()->json([
                'success' => true,
                'role' => auth()->guard('pelanggan')->user()->role,
                'message' => 'Login Sukses!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password tidak terdaftar!'
            ]);
        }
    }

    public function registerMember(Request $req)
    {
        DB::beginTransaction();
        try {
            if (Pelanggan::where([
                'email' => $req->email,
            ])->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email yang anda gunakan sudah terdaftar, silahkan gunakan yang berbeda!'
                ]);
            } elseif (Pelanggan::where([
                'no_telp' => $req->no_telp,
            ])->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No Telp yang anda gunakan sudah terdaftar, silahkan gunakan yang berbeda!'
                ]);
            } elseif (Pelanggan::where([
                'username' => $req->username
            ])->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Username yang anda gunakan sudah terdaftar, silahkan gunakan yang berbeda!'
                ]);
            } else {
                $q = new Pelanggan;
                $q->name = $req->name;
                $q->email = $req->email;
                $q->username = $req->username;
                $q->password = bcrypt($req->password);
                $q->role = 'pelanggan';
                $q->alamat = $req->alamat;
                $q->no_telp = $req->no_telp;
                $q->save();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Pendaftaran Berhasil,Andsa akan diarahkan ke halaman login' 
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error : ' . $e
            ]);
        }
    }

    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            Session::flush();
            return redirect()->route('login');
        } elseif (Auth::guard('pelanggan')->check()) {
            Auth::guard('pelanggan')->logout();
            Session::flush();
            return redirect()->route('login.member');
        }
    }
}
